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
                $datosQuery .= $this->DatosPorRecuperar($DATOSPORTABLA["CARAC"]["ALIAS"], $DATOSPORTABLA["DATOS"]);
                $datosQuery .= ($primerosDatos === false ? "," : $primerosDatos = false);
            }

            if ($primerosDatos > 0) {
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

        $queryCompleta = "SELECT " . $datosQuery . " FROM " . $tablaPrinc . " " . $UnionesQuery . "WHERE " . $CondQuery;
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

    public function FormatoUPDATE(array $estructuraQuery)
    {
        //UPDATE `sicasbd`.`alumnos` SET `IDPlanEstudio` = '3' WHERE (`IDAlumno` = '8');
    }

    public function FormatoDELETE(array $estructuraQuery)
    {
    }

    private function VariablesPorActualizar()
    {
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

    private function Condiciones(array $tablaCompleta): string
    {
        $cond = "";
        $contCond = 0;

        foreach ($tablaCompleta["COND"] as $CONDINDIVIDUAl) {
            $cond .= $tablaCompleta["CARAC"]["ALIAS"] . "." . $CONDINDIVIDUAl . "?";
            $cond .= (++$contCond < sizeof($tablaCompleta["COND"]) ? " AND " : " ");
        }
        return $cond;
    }
}
