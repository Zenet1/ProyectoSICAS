<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    include "../DB_PHP/BD_Conexion.php";

    $archivo = file("bd_src/Licenciatura/HorariosSesionesGrupo_Licenciatura.txt");
    $saltado = false;

    $sqlInsert = "INSERT INTO salones (IDEdificio, NombreSalon, Capacidad) VALUES (?,?,?)";
    $sqlrecuperar = "SELECT IDEdificio FROM edificios WHERE NombreEdificio=?";
    $obj_recuperar = $DB_CONEXION->prepare($sqlrecuperar);
    $obj_insert = $DB_CONEXION->prepare($sqlInsert);
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
    print_r($salones);
?>