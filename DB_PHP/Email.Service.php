<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include 'BD_Conexion.php';
include 'Email.Class.php';

$json = file_get_contents('php://input');
$datos = json_decode($json);

switch ($datos->accion) {
    case "EnviarQRAlumno":
        EnviarQRAlumno(array($_SESSION["Correo"] => $_SESSION["Nombre"]), $DB_CONEXION);
        break;
    case "rechazado":
        Rechazo(array($_SESSION["Correo"] => $_SESSION["Nombre"]), "Problemas de seguridad");
        break;
    case "alertar":

        break;
}

function EnviarQRAlumno(array $datosDestinatario, PDO $Conexion)
{
    $correo = new CorreoManejador();
    $correo->setArchivo(true);
    $sql_recuperarCargas = "SELECT ASIG.NombreAsignatura FROM cargaacademica AS CGAC 
        INNER JOIN reservacionesalumnos AS RSAL 
        ON RSAL.IDCarga=CGAC.IDCarga 
        INNER JOIN grupos AS GPS
        ON GPS.IDGrupo=CGAC.IDGrupo
        INNER JOIN asignaturas AS ASIG
        ON ASIG.IDAsignatura=GPS.IDAsignatura
        WHERE CGAC.IDAlumno=? AND RSAL.FechaReservaAl=?";

    $obj_recuperar = $Conexion->prepare($sql_recuperarCargas);
    $obj_recuperar->execute(array($_SESSION["IDAlumno"], $_SESSION["FechaSig"]));

    $NombreMaterias = $obj_recuperar->fetchAll(PDO::FETCH_ASSOC);
    $cuerpo = "";

    foreach ($NombreMaterias as $Materia) {
        $cuerpo .= "<li>" . $Materia["NombreAsignatura"] . "</li>";
    }
    $mensaje_inicio = "<p>Te has podido registrar con exito a las siguientes materias:</p><br>
        <ul>";
    $mensaje_pie = "</ul><br><p>Con el siguiente codigo QR podras acceder a la facultad</p>";
    $correo->EnviarCorreo($datosDestinatario, "Registro Exitoso", $mensaje_inicio . $cuerpo . $mensaje_pie, "img/" . $_SESSION["IDAlumno"] . ".png");
    unlink("img/" . $_SESSION["IDAlumno"] . ".png");
}

function Rechazo(array $datosDestinatario, string $msg)
{
    $correo = new CorreoManejador();
    $correo->EnviarCorreo($datosDestinatario, "Rechazado", $msg);
}

function Alertar(array $datosDestinatarios, string $msg){
    $correo = new CorreoManejador();
    //$correo->EnviarCorreo($datosDestinatarios, "Posible contagio", $msg);
}