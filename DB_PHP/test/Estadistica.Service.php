<?php
include 'BD_Conexion.php';

$DatosFiltrados = array();

switch ($_POST["accion"]) {
    case "genero":
        PorGenero($DB_CONEXION);
        break;
    case "carrera":
        PorCarrera($DB_CONEXION);
        break;
}

function PorGenero(PDO $Conexion)
{
    $obj_recuperar = $Conexion->prepare("SELECT ALM.Genero AS GEND FROM alumnos AS ALM INNER JOIN asistenciasalumnos AS ASISALM ON ASISALM.IDAlumno=ALM.IDAlumno");
    $obj_recuperar->execute();
    $datosBD = $obj_recuperar->fetchAll(PDO::FETCH_ASSOC);
    Recursivo($datosBD);
}

function PorCarrera(PDO $Conexion)
{
    $obj_recuperar = $Conexion->prepare("SELECT PLE.SiglasPlan AS GEND FROM planesdeestudio AS PLE INNER JOIN alumnos AS ALM ON PLE.IDPlanEstudio=ALM.IDPlanEstudio INNER JOIN asistenciasalumnos AS ASISALM ON  ASISALM.IDAlumno=ALM.IDAlumno");
    $obj_recuperar->execute();
    $datosBD = $obj_recuperar->fetchAll(PDO::FETCH_ASSOC);
    Recursivo($datosBD);
}

function Recursivo(array $datosCrudos)
{
    $datoReferencia = "";
    foreach ($datosCrudos as $datoGen) {
        $datoReferencia = $datoGen["GEND"];
        break;
    }

    $contadorDatoGenerico = 0;
    $indice = 0;
    foreach ($datosCrudos as $dato) {
        if ($dato["GEND"] === $datoReferencia) {
            $contadorDatoGenerico++;
            unset($datosCrudos[$indice]);
        }
        $indice++;
    }

    $GLOBALS["DatosFiltrados"][] = array($datoReferencia => $contadorDatoGenerico);

    if (sizeof($datosCrudos) !== 0) {
        foreach ($datosCrudos as $dato) {
            $arrayReacondicion[] = array("GEND" => $dato["GEND"]);
        }
        Recursivo($arrayReacondicion);
    } else {
        return;
    }
}
