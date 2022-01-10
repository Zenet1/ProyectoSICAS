<?php

function RecuperarProfesores(PDO $DB_CONEXION){
    
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    //include "EsValido.php";
    include "BD_Conexion.php";

    $archivo = file("docs/ProfesoresConAlumnosInscritos.txt");
    $saltado = false;

    $sqlInsert = "INSERT INTO academicos (ClaveProfesor, NombreProfesor, ApellidoPaternoProfesor, ApellidoMaternoProfesor, GradoAcademico, CorreoProfesor) VALUES (?,?,?,?,?,?)";


    $obj_insert = $DB_CONEXION->prepare($sqlInsert);

    foreach($archivo as $linea){
        if(!$saltado){
            $saltado = true;
            continue;
        }
        $data = explode("|", utf8_encode($linea));
        $verificacion = $obj_insert->execute(array($data[0],$data[1],$data[2],$data[3],$data[4],$data[5]));
        if(!esValido($verificacion)){
            echo "ERROR";
            break;
        }
    }
}
    
?>