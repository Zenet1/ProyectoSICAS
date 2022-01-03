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
    case "EnviarQRExterno";
        EnviarQRExterno(array($_SESSION["Correo"] => $_SESSION["Nombre"]), $DB_CONEXION);
        break;
    case "rechazado":
        Rechazo(array($_SESSION["Correo"] => $_SESSION["Nombre"]), "Problemas de seguridad");
        break;
    case "alertar":
        Alertar((array)$datos->usuarios, "No se");
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

function EnviarQRExterno(array $datosDestinatario, PDO $Conexion)
{
    $correo = new CorreoManejador();
    $correo->setArchivo(true);
    
    $sql_recuperarOficinas = "SELECT OFC.NombreOficina, OFC.Departamento, EDF.NombreEdificio FROM oficinas AS OFC 
    INNER JOIN reservacionesexternos AS RSEX 
    ON RSEX.IDOficina=OFC.IDOficina 
    INNER JOIN edificios AS EDF
    ON EDF.IDEdificio=OFC.IDEdificio
    WHERE RSEX.IDExterno=? AND RSEX.FechaReservaExterno=?";

    $obj_recuperar = $Conexion->prepare($sql_recuperarOficinas);
    $obj_recuperar->execute(array($_SESSION["IDExterno"], $_SESSION["FechaReservada"]));

    $NombreOficinas = $obj_recuperar->fetchAll(PDO::FETCH_ASSOC);
    $cuerpo = "";

    foreach ($NombreOficinas as $Oficina) {
        $cuerpo .= "<li>" . $Oficina["NombreOficina"] . "</li>";
    }
    $mensaje_inicio = "<p>Has podido realizar reservaciones con éxito a las siguientes oficinas:</p><br>
        <ul>";
    $mensaje_pie = "</ul><br><p>Con el siguiente código QR podrás acceder a la facultad</p>";
    $correo->EnviarCorreo($datosDestinatario, "Registro Exitoso", $mensaje_inicio . $cuerpo . $mensaje_pie, "img/" . $_SESSION["IDExterno"] . ".png");
    unlink("img/" . $_SESSION["IDExterno"] . ".png");
}

function Rechazo(array $datosDestinatario, string $msg)
{
    $correo = new CorreoManejador();
    $correo->EnviarCorreo($datosDestinatario, "Rechazado", $msg);
}

function Alertar(array $datosDestinatarios, string $msg)
{
    $correo = new CorreoManejador();
    print_r($datosDestinatarios);
}
