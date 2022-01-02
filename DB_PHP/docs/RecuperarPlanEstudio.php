<?php

function RecuperarPlanEstudio(PDO $Conexion)
{
    $archivo = file("docs/PlanesDeEstudios.txt");
    $saltado = false;
    $insertar = "INSERT INTO planesdeestudio (NombrePlan, SiglasPlan, ClavePlan, VersionPlan) VALUES (?,?,?,?);";
    $estado_obj = $Conexion->prepare($insertar);

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }

        $datos = explode("|", utf8_encode($linea));
        $verificacion = $estado_obj->execute(array($datos[2], $datos[3], $datos[0], $datos[1]));
        
    }
}

