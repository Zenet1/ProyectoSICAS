<?php
    
function RecuperarPlanEstudio(PDO $DB_CONEXION){
    
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    //include "EsValido.php";
    include "BD_Conexion.php";

    $archivo = file("docs/PlanesDeEstudios.txt");
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
    }
}
    
?>