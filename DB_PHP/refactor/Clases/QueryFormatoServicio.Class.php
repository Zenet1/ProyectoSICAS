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

        foreach ($estructuraQuery as $DATOSPORTABLA) {

            if (isset($DATOSPORTABLA["DATOS"])) {
                $datosQuery .= ($primerosDatos === false ? "," : "");
                $primerosDatos = false;
                $datosQuery .= $this->DatosPorRecuperar($DATOSPORTABLA["CARAC"]["ALIAS"], $DATOSPORTABLA["DATOS"]);
            }

            if (isset($DATOSPORTABLA["UNIR"])) {
                $UnionesQuery .= $this->Uniones($DATOSPORTABLA, $estructuraQuery);
            }

            if (isset($DATOSPORTABLA["COND"])) {
                $CondQuery .= $this->Condiciones($DATOSPORTABLA);
            }

            if (isset($DATOSPORTABLA["CARAC"]["DESDE"])) {
                $tablaPrinc .= $DATOSPORTABLA["CARAC"]["TABLA"] . " AS " . $DATOSPORTABLA["CARAC"]["ALIAS"];
            }
        }

        $condQuery = ($CondQuery !== "" ? "WHERE " . $CondQuery : "");
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
                $condQuery = " WHERE " . $this->Condiciones($TABLAINDIVIDUAL, false);
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
                $condQuery = " WHERE " . $this->Condiciones($TABLAINDIVIDUAL, false);
            }
        }
        $queryCompleta = "DELETE FROM " . $tabla . $condQuery;
        return $queryCompleta;
    }

    private function VariablesPorActualizar(array $datos): string
    {
        $actualizar = "";
        $contDatos = 0;

        foreach ($datos as $DATO) {
            $actualizar .= $DATO . "=?" . (++$contDatos < sizeof($datos) ? "," : "");
        }
        return $actualizar;
    }

    private function IncognitasPorRecuperar(int $cantidadElementos): string
    {
        $incog = str_repeat("?,", $cantidadElementos - 1);
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

    private function Uniones(array $tablaEmisora, array $estructuraQuery): string
    {
        $tablaAUnir = $tablaEmisora["UNIR"]["UNIR"];
        $tablaEmisor = $tablaEmisora["CARAC"]["TABLA"];
        $atributoComun = $tablaEmisora["UNIR"]["CON"];
        $aliasEmisor =  $tablaEmisora["CARAC"]["ALIAS"];
        $aliasAUnir = $estructuraQuery[$tablaAUnir]["CARAC"]["ALIAS"];


        $union = "INNER JOIN " . $tablaEmisor . " AS " . $aliasEmisor;
        $union .= " ON " . $aliasAUnir . "." . $atributoComun . "=" . $aliasEmisor . "." . $atributoComun;
        return $union . " ";
    }

    private function Condiciones(array $tablaCompleta, bool $alias = true): string
    {
        $cond = "";
        $contCond = 0;

        foreach ($tablaCompleta["COND"] as $CONDINDIVIDUAl) {
            $cond .= ($alias === true ? $tablaCompleta["CARAC"]["ALIAS"] . "." : "") . $CONDINDIVIDUAl . "?";
            $cond .= (++$contCond < sizeof($tablaCompleta["COND"]) ? " AND " : " ");
        }
        return $cond;
    }
}
