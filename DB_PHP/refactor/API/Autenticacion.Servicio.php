<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once("../Clases/Query.Class.php");

$objQuery = new Query();

$json = file_get_contents('php://input');
$datos = json_decode($json);

$sql_verificar = "SELECT us.IDUsuario,us.IDRol,us.Cuenta,ro.IDRol,ro.Rol FROM usuarios AS us 
INNER JOIN roles AS ro ON ro.IDRol=us.IDRol 
WHERE us.Cuenta=? AND us.Contraseña=?";

$datos = $objQuery->ejecutarConsulta($sql_verificar, array($datos->usuario, $datos->contrasena));
$datosUsuario = $datos[0];

if (esValido($datosUsuario)) {
    session_start();
    ($datosUsuario["Rol"] === "Alumno" ? Estudiantes($datosUsuario["IDUsuario"]) : "");
    $CuentaUsuario = array("Cuenta" => $datosUsuario["Cuenta"], "Rol" => $datosUsuario["Rol"]);
    echo json_encode($CuentaUsuario);
}

function Estudiantes($IDusuario)
{
    $objQuery = new Query();
    $sql_estudiante = "SELECT IDAlumno,NombreAlumno,ApellidoPaternoAlumno, ApellidoMaternoAlumno, Matricula,CorreoAlumno FROM alumnos WHERE IDUsuario = ?";
    $datos = $objQuery->ejecutarConsulta($sql_estudiante, array($IDusuario));
    $datosAlumno = $datos[0];

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
