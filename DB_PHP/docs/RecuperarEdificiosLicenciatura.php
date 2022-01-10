<?php

function RecuperarEdificiosLicenciatura(PDO $Conexion)
{
    $archivo = file("docs/HorariosSesionesGrupo.txt");
    $saltado = false;

    $sqlInsert = "INSERT INTO edificios (NombreEdificio) SELECT :nome FROM DUAL WHERE NOT EXISTS (SELECT NombreEdificio FROM edificios WHERE NombreEdificio = :nome) LIMIT 1";
    $obj_insert = $Conexion->prepare($sqlInsert);

    $edificios = array();

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }
        $data = explode("|", utf8_encode($linea));

        if (!isset($edificios[$data[9]]) && $data[9] != "" && strpos($data[9], "Edificio") !== false) {
            $edificios[$data[9]] = "si";
            $obj_insert->execute(array("nome" => $data[9]));
        }
    }
}
