<?php

class QueryFormatoServicio
{
    public function FormatoSELECT(array $estructuraQuery): string
    {
        $tablaPrinc = "";
        $datosQuery = "";
        $UnionesQuery = "";
        $CondQuery = "";
        $primerosDatos = true;
        $primerasCond = true;

        foreach ($estructuraQuery as $TABLAINDIVIAUL) {

            if (isset($TABLAINDIVIAUL["DATOS"])) {
                $datosQuery .= ($primerosDatos === false ? "," : "");
                $primerosDatos = false;
                $datosQuery .= $this->DatosPorRecuperar($TABLAINDIVIAUL["CARAC"]["ALIAS"], $TABLAINDIVIAUL["DATOS"]);
            }

            if (isset($TABLAINDIVIAUL["UNIR"])) {
                $UnionesQuery .= $this->ObtenerUniones($TABLAINDIVIAUL, $estructuraQuery);
            }

            if (isset($TABLAINDIVIAUL["COND"])) {
                $CondQuery .= ($primerasCond === false ? " AND " : "");
                $primerasCond = false;
                $CondQuery .= $this->ObtenerCondiciones($TABLAINDIVIAUL);
            }

            if (isset($TABLAINDIVIAUL["CARAC"]["DESDE"])) {
                $tablaPrinc .= $TABLAINDIVIAUL["CARAC"]["TABLA"] . " AS " . $TABLAINDIVIAUL["CARAC"]["ALIAS"];
            }
        }

        $CondQuery = ($CondQuery !== "" ? "WHERE " . $CondQuery : "");
        $queryCompleta = "SELECT " . $datosQuery . " FROM " . $tablaPrinc . " " . $UnionesQuery . $CondQuery;

        return $queryCompleta;
    }

    public function FormatoINSERT(array $estructuraQuery)
    {
        $queryDatos = "";
        $incognitasQuery = "";
        $tabla = "";

        foreach ($estructuraQuery as $TABLAAINSERTAR) {
            $tabla = $TABLAAINSERTAR["CARAC"]["TABLA"];
            $queryDatos = $this->DatosPorRecuperar("", $TABLAAINSERTAR["DATOS"]);
            $incognitasQuery = $this->IncognitasPorRecuperar(sizeof($TABLAAINSERTAR["DATOS"]));
        }

        $queryCompleta = "INSERT INTO " . $tabla . "(" . $queryDatos . ") " . "VALUES " . $incognitasQuery;
        return $queryCompleta;
    }

    public function FormatoUPDATE(array $estructuraQuery): string
    {
        $condQuery = "";
        $datoQuery = "";
        $tabla = "";

        foreach ($estructuraQuery as $TABLAINDIVIDUAL) {
            $datoQuery = $this->VariablesPorActualizar($TABLAINDIVIDUAL["DATOS"]);
            $tabla = $TABLAINDIVIDUAL["CARAC"]["TABLA"];
            if (isset($TABLAINDIVIDUAL["COND"])) {
                $condQuery = " WHERE " . $this->ObtenerCondiciones($TABLAINDIVIDUAL, false);
            }
        }
        $queryCompleta = "UPDATE " . $tabla . " SET " . $datoQuery . $condQuery;
        return $queryCompleta;
    }

    public function FormatoDELETE(array $estructuraQuery): string
    {
        $condQuery = "";
        $tabla = "";
        foreach ($estructuraQuery as $TABLAINDIVIDUAL) {
            $tabla = $TABLAINDIVIDUAL["CARAC"]["TABLA"];

            if (isset($TABLAINDIVIDUAL["COND"])) {
                $condQuery = " WHERE " . $this->ObtenerCondiciones($TABLAINDIVIDUAL, false);
            }
        }
        $queryCompleta = "DELETE FROM " . $tabla . $condQuery;
        return $queryCompleta;
    }

    private function VariablesPorActualizar(array $DATOS): string
    {
        $actualizar = "";
        $contDatos = 0;

        foreach ($DATOS as $DATO) {
            $actualizar .= $DATO . "=?" . (++$contDatos < sizeof($DATOS) ? "," : "");
        }
        return $actualizar;
    }

    private function IncognitasPorRecuperar(int $cantidadElementos): string
    {
        return str_repeat("?,", $cantidadElementos - 1) . "?";
    }

    private function DatosPorRecuperar(string $ALIAS, array $datos): string
    {
        $datosPorObtener = "";
        $contDatos = 0;

        foreach ($datos as $DATOINDIVIDUAL) {
            $datosPorObtener .= ($ALIAS !== "" ? $ALIAS . "." : "") . $DATOINDIVIDUAL . (++$contDatos < sizeof($datos) ? "," : "");
        }
        return $datosPorObtener;
    }

    private function ObtenerCondiciones(array $TABLAINDIVIAUL, bool $ALIAS = true): string
    {
        $contadorCond = 0;
        $cadenaCond = "";

        foreach ($TABLAINDIVIAUL["COND"] as $CONDIND) {
            $cadenaCond .= ($ALIAS === true ? $TABLAINDIVIAUL["CARAC"]["ALIAS"] . "." : "") . $CONDIND . " ";
            // EVITA FORMAR CADENAS: "<ULTIMA CONDICION> AND <CADENA VACIA>"
            $cadenaCond .= (++$contadorCond < sizeof($TABLAINDIVIAUL["COND"]) ? " AND " : "");
        }
        return $cadenaCond;
    }

    private function ObtenerUniones(array $tablaEmisora, array $estructuraQuery): string
    {
        $TABLAUNIR = $tablaEmisora["UNIR"]["UNIR"];
        $ALIASUNIR = $estructuraQuery[$TABLAUNIR]["CARAC"]["ALIAS"];
        $TABLAEMISOR = $tablaEmisora["CARAC"]["TABLA"];
        $DATOCOEMISOR = $tablaEmisora["UNIR"]["EMIDATO"];
        $DATORECEPTOR = $tablaEmisora["UNIR"]["RECDATO"];
        $ALIASEMISOR =  $tablaEmisora["CARAC"]["ALIAS"];

        $Cadenaunion = "INNER JOIN " . $TABLAEMISOR . " AS " . $ALIASEMISOR;
        $Cadenaunion .= " ON " . $ALIASUNIR . "." . $DATORECEPTOR . "=" . $ALIASEMISOR . "." . $DATOCOEMISOR;
        return $Cadenaunion . " ";
    }
}
