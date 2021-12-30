<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    include "../DB_PHP/BD_Conexion_migrations.php";

    $archivo = file("bd_src/Licenciatura/ProfesoresConAlumnosInscritos.txt");
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
    function esValido($datos) : bool{
        return $datos != null && $datos != false;
    }
?>