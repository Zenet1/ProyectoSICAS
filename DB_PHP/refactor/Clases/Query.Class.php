<?php

class Query
{
    public function SELECT(array $Formato, array $incognitas): array
    {
        $query = $this->SELECTMaker($Formato);
        echo $query;
        return array();
    }

    public function INSERT()
    {
    }

    public function UPDATE()
    {
    }

    public function DELETE()
    {
    }

    private function SELECTMaker(array $estructuraQuery): string
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

        $queryCompleta = "SELECT " . $datosQuery . "FROM " . $tablaPrinc . " " . $UnionesQuery . " WHERE " . $CondQuery;
        return $queryCompleta;
    }

    private function DatosPorRecuperar(string $ALIAS, array $datos): string
    {
        $datosPorObtener = "";
        $contDatos = 0;

        foreach ($datos as $DATOINDIVIDUAL) {
            $datosPorObtener .= $ALIAS . "." . $DATOINDIVIDUAL . (++$contDatos < sizeof($datos) ? "," : "");
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
        return $union;
    }

    private function Condiciones(array $tablaCompleta): string
    {
        $cond = "";
        $contCond = 0;

        foreach ($tablaCompleta["COND"] as $CONDINDIVIDUAl) {
            $cond .= $tablaCompleta["CARAC"]["ALIAS"] . "." . $CONDINDIVIDUAl . "?";
            $cond .= (++$contCond < sizeof($tablaCompleta["COND"]) ? " AND " : "");
        }

        return $cond;
    }
}
