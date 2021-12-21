<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";

    $json = file_get_contents('php://input');
    $datos = json_decode($json);
    $sql_verificar = "SELECT us.IDUsuario,us.IDRol,us.Cuenta,ro.IDRol,ro.Rol FROM usuarios AS us INNER JOIN roles AS ro ON ro.IDRol=us.IDRol WHERE us.Cuenta=? AND us.Contraseña=?";

    $estado_obj = $DB_CONEXION->prepare($sql_verificar);
    $estado_obj->execute(array("$datos->usuario", "$datos->contrasena"));
    $datos = $estado_obj->fetch(PDO::FETCH_ASSOC);

    if(esValido($datos)){
        session_start();

        switch($datos["Rol"]){
            case "Alumno":
                Estudiantes($DB_CONEXION, $datos["IDUsuario"]);
                break;
            case "Administrador":
                Administrador($DB_CONEXION, $datos["IDUsuario"]);
                break;
            default:
                
                break;
        }

        $datos_alumnos = array("Cuenta"=>$datos["Cuenta"] , "Rol"=>$datos["Rol"]);
        echo json_encode($datos_alumnos);
        //echo json_encode("hola");
    }

    function Estudiantes($Conexion, $IDusuario){
        $sql_estudiante = "SELECT NombreAlumno,IDAlumno,Matricula,CorreoAlumno FROM alumnos WHERE IDUsuario = ?";
        $estado_obj = $Conexion->prepare($sql_estudiante);
        $estado_obj->execute(array("$IDusuario"));

        $datos = $estado_obj->fetch(PDO::FETCH_ASSOC);
        if(esValido($datos)){
            $_SESSION["Nombre"] = $datos["NombreAlumno"];
            $_SESSION["IDAlumno"] = $datos["IDAlumno"];
            $_SESSION["Matricula"] = $datos["Matricula"];
            $_SESSION["Correo"] = $datos["CorreoAlumno"];
        }
    }

    function Administrador($Conexion, $IDusuario){

    }   
    
    function esValido($datos) : bool{
        return $datos != null && $datos != false;
    }


?>