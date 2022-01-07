<?php

function RecuperarPlanEstudio(PDO $Conexion)
{
    $archivo = file("docs/PlanesDeEstudios.txt");
    $saltado = false;
    $insertar = "INSERT INTO planesdeestudio (NombrePlan, SiglasPlan, ClavePlan, VersionPlan) SELECT :nom,:sig,clv,:ver FROM DUAL WHERE NOT EXISTS (SELECT ClavePlan,VersionPlan FROM planesdeestudio WHERE ClavePlan = :clv AND VersionPlan = :ver) LIMIT 1";
    $estado_obj = $Conexion->prepare($insertar);

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }

        $datos = explode("|", utf8_encode($linea));
        $incognitas = array("nom" => $datos[2], "sig" => $datos[3], "clv" => $datos[0], "ver" => $datos[1]);
        $estado_obj->execute($incognitas);
    }
}
