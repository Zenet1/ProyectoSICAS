<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    include "../DB_PHP/BD_Conexion.php";

    $archivo = file("bd_src/Licenciatura/AlumnosInscripcionEnPeriodoCurso.txt");
    $saltado = false;
    $insertar = "INSERT INTO alumnos (Matricula, NombreAlumno, ApellidoPaternoAlumno, ApellidoMaternoAlumno, IDPlanEstudio, CorreoAlumno, Genero, IDUsuario, IDModelo, NivelEducativo) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $recuperar_plan = "SELECT IDPlanEstudio FROM planesdeestudio WHERE ClavePlan=? AND VersionPlan=?";
    $recuperar_id = "SELECT IDUsuario FROM usuarios WHERE Cuenta=?";

    $insertar_obj = $DB_CONEXION->prepare($insertar);
    $recuperarPlan_obj = $DB_CONEXION->prepare($recuperar_plan); 
    $recuperarID_obj = $DB_CONEXION->prepare($recuperar_id);

    foreach($archivo as $linea){
        if(!$saltado){
            $saltado = true;
            continue;
        }
        $datos_archivo = explode("|", utf8_encode($linea));
        $recuperarID_obj->execute(array("a".$datos_archivo[0]));
        $IDUsuario = $recuperarID_obj->fetch(PDO::FETCH_ASSOC);
        $recuperarPlan_obj->execute(array($datos_archivo[6], $datos_archivo[7]));
        $IDPlan = $recuperarPlan_obj->fetch(PDO::FETCH_ASSOC);
        
        $verificacion = $insertar_obj->execute(array($datos_archivo[0], $datos_archivo[1], $datos_archivo[2], $datos_archivo[3],$IDPlan["IDPlanEstudio"], $datos_archivo[8], $datos_archivo[4], $IDUsuario["IDUsuario"], 1, "Licenciatura"));

        if(!esValido($verificacion)){
            echo "ERROR";
            break;
        }
    }
    function esValido($datos) : bool{
        return $datos != null && $datos != false;
    }
?>