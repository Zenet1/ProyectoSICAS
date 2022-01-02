<?php

function RecuperarEdificiosLicenciatura(PDO $Conexion)
{
    $archivo = file("docs/HorariosSesionesGrupo_Licenciatura.txt");
    $saltado = false;

    $sqlInsert = "INSERT INTO edificios (NombreEdificio) VALUES (?)";
    $obj_insert = $Conexion->prepare($sqlInsert);

    $edificios = array();

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }
        $data = explode("|", utf8_encode($linea));

        if (!isset($edificios[$data[9]]) && $data[9] != "" && false !== strpos($data[9], "Edificio")) {
            $edificios[$data[9]] = $data[9];
            $obj_insert->execute(array($data[9]));
        }
    }
}
