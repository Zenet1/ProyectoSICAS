<?php
include 'BD_Conexion.php';

$json = file_get_contents('php://input');
$datos = (array)json_decode($json);

try {
    $datosFiltrados = array();
    $datosSQL = obtenerDatos($datos, $DB_CONEXION);
    Recursivo($datosSQL, $datosFiltrados);
} catch (Exception $e) {
    echo json_encode(array());
}

function obtenerDatos(array $datos, PDO $Conexion)
{
    $tabla = $datos["tipo"];
    $query = "SELECT PLE.NombrePlan, PLE.SiglasPlan,PLE.ClavePlan,ALM.Genero FROM $tabla AS GEN INNER JOIN alumnos AS ALM ON ALM.IDAlumno=GEN.IDAlumno INNER JOIN planesdeestudio AS PLE ON PLE.IDPlanEstudio=ALM.IDPlanEstudio WHERE GEN.FechaAl >= ? AND GEN.FechaAl <= ?";

    $condGenero = $condPlan = "";

    if ($datos["genero"] !== "todos") {
        $genero = $datos["genero"];
        $condGenero = " AND ALM.Genero = '$genero' ";
    }

    if ($datos["NombrePlan"] !== "todos") {
        $nombreplan = $datos["NombrePlan"];
        $claveplan =  $datos["ClavePlan"];
        $condPlan = " AND PLE.NombrePlan = '$nombreplan' AND PLE.ClavePlan = $claveplan ";
    }

    $query .= $condGenero . $condPlan;
    $objRecuperar = $Conexion->prepare($query);
    $objRecuperar->execute(array($datos["fechaInicio"], $datos["fechaFin"]));
    $arrayDatos = $objRecuperar->fetchAll(PDO::FETCH_ASSOC);

    if ($arrayDatos === false || sizeof($arrayDatos) === 0) {
        throw new Exception();
    }
    return $arrayDatos;
}

function Recursivo($datosCrudos, $datosFiltrados)
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

    $datosFiltrados[$Siglas . "_" . $Clave][] = array("Siglas" => $Siglas, "Clave" => $Clave, $Genero => $contGen);

    if (sizeof($datosModificados) === 0) {
        echo json_encode($datosFiltrados);
    } else {
        Recursivo($datosModificados, $datosFiltrados);
    }
}
