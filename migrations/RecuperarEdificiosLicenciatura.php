<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    include "../DB_PHP/BD_Conexion_migrations.php";

    $archivo = file("bd_src/Licenciatura/HorariosSesionesGrupo_Licenciatura.txt");
    $saltado = false;

    $sqlInsert = "INSERT INTO sicas_test.edificios (NombreEdificio) VALUES (?)";
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