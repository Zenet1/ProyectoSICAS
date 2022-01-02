<?php


function RecuperarSalones(PDO $Conexion){
    $archivo = file("docs/HorariosSesionesGrupo_Licenciatura.txt");
    $saltado = false;

    $sqlInsert = "INSERT INTO salones (IDEdificio, NombreSalon, Capacidad) VALUES (?,?,?)";
    $sqlrecuperar = "SELECT IDEdificio FROM edificios WHERE NombreEdificio=?";
    $obj_recuperar = $Conexion->prepare($sqlrecuperar);
    $obj_insert = $Conexion->prepare($sqlInsert);
    $salones = array();

    foreach($archivo as $linea){
        if(!$saltado){
            $saltado = true;
            continue;
        }

        $data = explode("|", $linea);
        $obj_recuperar->execute(array($data[9]));
        $ID = $obj_recuperar->fetch(PDO::FETCH_ASSOC);

        if(isset($ID["IDEdificio"]) && !isset($salones[$data[9] . $data[10]])){
            $obj_insert->execute(array($ID["IDEdificio"], $data[10], 30));
            $salones[$data[9] . $data[10]] = $data[9] . $data[10];
        }
    }
}
