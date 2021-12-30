<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    include "../DB_PHP/BD_Conexion_migrations.php";

    $archivo = file("bd_src/Licenciatura/PlanesDeEstudios.txt");
    $saltado = false;
    $insertar = "INSERT INTO planesdeestudio (NombrePlan, SiglasPlan, ClavePlan, VersionPlan) VALUES (?,?,?,?);";
    $estado_obj = $DB_CONEXION->prepare($insertar);

    foreach($archivo as $linea){
        if(!$saltado){
            $saltado = true;
            continue;
        }

        $datos = explode("|", utf8_encode($linea));
        $verificacion = $estado_obj->execute(array($datos[2],$datos[3],$datos[0],$datos[1]));
        if(!esValido($verificacion)){
            echo "ERROR";
            break;
        }
        print_r($datos);
    }
    function esValido($datos) : bool{
        return $datos != null && $datos != false;
    }
?>