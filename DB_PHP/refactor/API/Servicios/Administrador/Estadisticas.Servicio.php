<?php
include_once("Estadisticas.Query.php");

class EstadisticaControl
{
    private Query $objQuery;
    private EstadisticaQuery $objEstic;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
        $this->objEstic = new EstadisticaQuery();
    }

    public function EstadisticasAlumno(array $contenido)
    {
        print_r($contenido);
        /*
        try {
            $datosSQL = obtenerDatos($datos, $DB_CONEXION);
            Recursivo($datosSQL, array());
        } catch (Exception $e) {
            echo json_encode(array());
        }
        */
    }

    private function FiltradoRecursivo(array $datosCrudos, array $datosFiltrados)
    {
        $datosModificados = array();
        $Genero = $datosCrudos[0]["Genero"];
        $Plan = $datosCrudos[0]["NombrePlan"];
        $Clave = $datosCrudos[0]["ClavePlan"];
        $Siglas = trim($datosCrudos[0]["SiglasPlan"]);
        $contGen = 0;

        foreach ($datosCrudos as $dato) {
            if ($Genero === $dato["Genero"] && $Plan === $dato["NombrePlan"] && $Clave === $dato["ClavePlan"]) {
                $contGen++;
            } else {
                $datosModificados[] = $dato;
            }
        }

        $datosFiltrados[$Siglas . "_" . $Clave][] = array("name" => $Genero, "value" => $contGen);
        if (sizeof($datosModificados) === 0) {
            print_r(json_encode($this->FormatoGrafica($datosFiltrados)));
        } else {
            Recursivo($datosModificados, $datosFiltrados);
        }
    }

    private function FormatoGrafica(array $datos): array
    {
        $array_adaptada = array();
        foreach ($datos as $clave => $valor) {
            $array_adaptada[] = array("name" => $clave, "series" => $valor);
        }
        return $array_adaptada;
    }

    public function EstadisticasPersonal(array $contenido)
    {
    }
}
