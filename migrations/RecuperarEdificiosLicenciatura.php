<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    include "../BD_Conexion.php";

    $archivo = file("HorariosSesionesGrupo_Licenciatura.txt");
    $saltado = false;

    $sqlInsert = "INSERT INTO sicasbd.edificios (NombreEdificio) VALUES (?)";
    $obj_insert = $DB_CONEXION->prepare($sqlInsert);

    $edificios = array();

    foreach($archivo as $linea){
        if(!$saltado){
            $saltado = true;
            continue;
        }
        $data = explode("|", utf8_encode($linea));

        if(!isset($edificios[$data[9]]) && $data[9] != "" && false !== strpos($data[9], "Edificio")){
            $edificios[$data[9]] = $data[9];
            $obj_insert->execute(array($data[9]));
        }
    }
    print_r($edificios);
    function esValido($datos) : bool{
        return $datos != null && $datos != false;
    }
?>