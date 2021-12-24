<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    include "../DB_PHP/BD_Conexion_migrations.php";

    $archivo = file("bd_src/Licenciatura/AsignaturasALasQueSeInscribieronAlumnos.txt");
    $saltado = false;
    $insertar = "INSERT INTO sicas_test.asignaturas (ClaveAsignatura, NombreAsignatura, IDPlanEstudio) VALUES (?,?,?)";
    $recuperar = "SELECT IDPlanEstudio FROM planesdeestudio WHERE ClavePlan=? AND VersionPlan=?";
    $insertar_obj = $DB_CONEXION->prepare($insertar);
    $recuperar_obj = $DB_CONEXION->prepare($recuperar); 

    foreach($archivo as $linea){
        if(!$saltado){
            $saltado = true;
            continue;
        }

        $datos = explode("|", wordwrap(utf8_encode($linea)));
        $recuperar_obj->execute(array($datos[0], $datos[1]));
        $IDFeature = $recuperar_obj->fetch(PDO::FETCH_ASSOC);
        $verificacion = $insertar_obj->execute(array($datos[2], $datos[3], $IDFeature["IDPlanEstudio"]));
        if(!esValido($verificacion)){
            echo "ERROR";
            break;
        }

    }
    function esValido($datos) : bool{
        return $datos != null && $datos != false;
    }
?>