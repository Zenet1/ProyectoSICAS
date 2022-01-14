<?php
include_once("ControlBD.Queries.php");

class ControlBD
{
    private Query $objQuery;
    private ControlBDQueries $queries;

    public function __construct(Query $objQuery)
    {
        $this->queries = new ControlBDQueries();
        $this->objQuery = $objQuery;
    }

    public function EliminarBD(Fechas $fecha)
    {
        foreach ($this->queries->ObtenerQueriesEliminar() as $QUERYELIMINAR) {
            $this->objQuery->ejecutarConsula($QUERYELIMINAR, array("fch" => $fecha->FechaAct()));
        }
    }

    function Respaldar(ArchivoControl $archivoControl, Fechas $fecha)
    {
        $tablas = array("externos", "reservacionesalumnos", "reservacionesexternos", "asistenciasalumnos", "asistenciasexternos", "incidentes");
        foreach ($tablas as $tabla) {
            $this->RespaldarTablas($tabla, $this->queries->ObtenerQueryRespaldar($tabla), array($fecha->FechaAct()));
        }
        $archivoControl->descargarArchivos("zipRespaldo", ArchivoControl::$carpetaUnica . "/", ".txt");
        $archivoControl->EliminarArchivos(ArchivoControl::$carpetaUnica ."/", ".txt");
        $archivoControl->EliminarArchivos(ArchivoControl::$carpetaUnica ."/", ".zip");
    }

    private function RespaldarTablas(string $tabla, string $Query, array $variables = null)
    {
        $archivo = fopen(ArchivoControl::$carpetaUnica . "/" . $tabla . ".txt", "w");
        $nombreColumnas = $this->objQuery->ejecutarConsula($this->queries->RecupColumQuery($tabla), array());
        $datosTabla = $this->objQuery->ejecutarConsula($Query, $variables);

        $indice_final = 0;

        foreach ($nombreColumnas as $columna) {
            fwrite($archivo, $columna["COLUMN_NAME"] . (++$indice_final < sizeof($nombreColumnas) ? "|" : ""));
        }
        fwrite($archivo, "\n");

        foreach ($datosTabla as $dato) {
            $indice_final = 0;
            foreach ($nombreColumnas as $columna) {
                fwrite($archivo, $dato[$columna["COLUMN_NAME"]] . (++$indice_final < sizeof($dato) ? "|" : ""));
            }
            fwrite($archivo, "\n");
        }
        fclose($archivo);
    }

    public function Restaurar(ArchivoControl $archivoControl)
    {
        $rutaArchivo = $archivoControl->MoverArchivo(ArchivoControl::$carpetaUnica . "/");
        $nombreSinExtension = basename($rutaArchivo, ".txt");
        $archivo = file($rutaArchivo);

        foreach ($archivo as $LINEA) {
            $lnExp = explode("|", $LINEA);
            $datos = $this->FormatearLinea($lnExp, $nombreSinExtension);
            $query = $this->queries->ObtenerQueryRestaurar($nombreSinExtension);
            $this->objQuery->ejecutarConsula($query, $datos);
        }
        $archivoControl->EliminarArchivos(ArchivoControl::$carpetaUnica ."/", ".txt");
    }

    private function FormatearLinea(array $lnExp, string $nombreSinExtension): array
    {
        $datosRestaurar = array();
        switch ($nombreSinExtension) {
            case "externos":
                $datosRestaurar = array("ide" => $lnExp[0], "nme" => $lnExp[1], "ape" => $lnExp[2], "ame" => $lnExp[3], "emp" => $lnExp[4]);
                break;
            case "reservacionesalumnos":
                $datosRestaurar = array("idc" => $lnExp[1], "fcRA" => $lnExp[2], "hri" => $lnExp[3], "hrf" =>  $lnExp[4], "fca" => $lnExp[5], "hra" => $lnExp[6]);
                break;
            case "reservacionesexternos":
                $datosRestaurar = array("ide" => $lnExp[1], "ido" => $lnExp[2], "fcRE" => $lnExp[3], "fce" => $lnExp[4], "hre" => $lnExp[5]);
                break;
            case "asistenciasalumnos":
                $datosRestaurar = array("ida" => $lnExp[1], "fca" =>  $lnExp[2], "hri" => $lnExp[3]);
                break;
            case "asistenciasexternos":
                $datosRestaurar = array("ide" => $lnExp[1], "fce" => $lnExp[2], "hrIE" => $lnExp[3], "hrSE" => $lnExp[4], "lgenE" =>  $lnExp[5]);
                break;
            case "incidentes":
                $datosRestaurar = array("ida" => $lnExp[1], "fca" => $lnExp[2], "fcLS" => $lnExp[3]);
                break;
        }
        return $datosRestaurar;
    }
}