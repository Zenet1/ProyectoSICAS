<?php
include 'BD_Conexion.php';
include 'Email.Class.php';
date_default_timezone_set("America/Mexico_City");

$obj_datosProfesores = $DB_CONEXION->prepare("SELECT ASIG.NombreAsignatura,GPS.IDGrupo, ACAD.NombreProfesor, ACAD.ApellidoPaternoProfesor, ACAD.ApellidoMaternoProfesor, ACAD.CorreoProfesor FROM academicos AS ACAD INNER JOIN grupos AS GPS ON GPS.IDProfesor=ACAD.IDProfesor INNER JOIN asignaturas AS ASIG ON ASIG.IDAsignatura=GPS.IDAsignatura");

$obj_datosAlumnos = $DB_CONEXION->prepare("SELECT ALM.NombreAlumno, ALM.ApellidoPaternoAlumno, ALM.ApellidoMaternoAlumno FROM alumnos AS ALM INNER JOIN cargaacademica AS CGAC ON CGAC.IDAlumno=ALM.IDAlumno INNER JOIN reservacionesalumnos AS RSAL ON RSAL.IDCarga=CGAC.IDCarga WHERE CGAC.IDGrupo=? AND RSAL.FechaReservaAl=?");

$obj_datosProfesores->execute();
$profesoresCrudos = $obj_datosProfesores->fetchAll(PDO::FETCH_ASSOC);
$correo = new CorreoManejador();

foreach ($profesoresCrudos as $profesor) {
    $obj_datosAlumnos->execute(array($profesor["IDGrupo"], date('Y-m-d')));
    $alumnosCrudos = $obj_datosAlumnos->fetchAll(PDO::FETCH_ASSOC);
    $listaAlumnos = "";
    foreach ($alumnosCrudos as $alumno) {
        $listaAlumnos .= "<li>" . $alumno["NombreAlumno"];
        $listaAlumnos .= " " . $alumno["ApellidoPaternoAlumno"];
        $listaAlumnos .= " " .  $alumno["ApellidoMaternoAlumno"] . "</li>";
    }
    $nombreProfesor .= $profesor["NombreProfesor"];
    $nombreProfesor .= " " . $profesor["ApellidoPaternoProfesor"];
    $nombreProfesor .= " " . $profesor["ApellidoMaternoProfesor"];

    $asunto = "Lista de alumnos. Asignatura: " . $profesor["NombreAsignatura"];

    $correo->EnviarCorreo(array($profesor["CorreoProfesor"] => $nombreProfesor), $asunto, " ");
}
