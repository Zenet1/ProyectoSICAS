<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include "BD_Conexion.php";

$json = file_get_contents('php://input');
$datos = json_decode($json);

$sql_verificar = "SELECT us.IDUsuario,us.IDRol,us.Cuenta,ro.IDRol,ro.Rol FROM usuarios AS us INNER JOIN roles AS ro ON ro.IDRol=us.IDRol WHERE us.Cuenta=? AND us.Contraseña=?";

$estado_obj = $DB_CONEXION->prepare($sql_verificar);
$estado_obj->execute(array("$datos->usuario", "$datos->contrasena"));
$datosUsario = $estado_obj->fetch(PDO::FETCH_ASSOC);

if (esValido($datosUsario)) {
    session_start();
    ($datosUsario["Rol"] === "Alumno" ? Estudiantes($DB_CONEXION, $datosUsario["IDUsuario"]) : "");
    $CuentaUsuario = array("Cuenta" => $datosUsario["Cuenta"], "Rol" => $datosUsario["Rol"]);
    echo json_encode($CuentaUsuario);
}

function Estudiantes($Conexion, $IDusuario)
{
    $sql_estudiante = "SELECT IDAlumno,NombreAlumno,ApellidoPaternoAlumno, ApellidoMaternoAlumno, Matricula,CorreoAlumno FROM alumnos WHERE IDUsuario = ?";
    $estado_obj = $Conexion->prepare($sql_estudiante);
    $estado_obj->execute(array($IDusuario));
    $datosAlumno = $estado_obj->fetch(PDO::FETCH_ASSOC);

    if (esValido($datosAlumno)) {
        $nombreCompleto = $datosAlumno["NombreAlumno"] . " "  . $datosAlumno["ApellidoPaternoAlumno"] . " " . $datosAlumno["ApellidoMaternoAlumno"];
        $_SESSION["Nombre"] = $nombreCompleto;
        $_SESSION["IDAlumno"] = $datosAlumno["IDAlumno"];
        $_SESSION["Matricula"] = $datosAlumno["Matricula"];
        $_SESSION["Correo"] = $datosAlumno["CorreoAlumno"];
    }
}

function esValido($datos): bool
{
    return $datos != null && $datos != false;
}
