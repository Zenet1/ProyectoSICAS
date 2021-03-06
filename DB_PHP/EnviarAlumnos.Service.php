<?php
include 'BD_Conexion.php';
include 'Email.Class.php';
date_default_timezone_set("America/Mexico_City");

$obj_datosProfesores = $DB_CONEXION->prepare("SELECT ASIG.NombreAsignatura,PLE.NombrePlan,GPS.IDGrupo,ACAD.GradoAcademico, ACAD.NombreProfesor,ACAD.ApellidoPaternoProfesor, ACAD.ApellidoMaternoProfesor, ACAD.CorreoProfesor FROM academicos AS ACAD  INNER JOIN grupos AS GPS ON GPS.IDProfesor=ACAD.IDProfesor INNER JOIN asignaturas AS ASIG ON ASIG.IDAsignatura=GPS.IDAsignatura INNER JOIN planesdeestudio AS PLE ON PLE.IDPlanEstudio=ASIG.IDPlanEstudio");

$obj_datosAlumnos = $DB_CONEXION->prepare("SELECT ALM.NombreAlumno, ALM.ApellidoPaternoAlumno, ALM.ApellidoMaternoAlumno FROM alumnos AS ALM INNER JOIN cargaacademica AS CGAC ON CGAC.IDAlumno=ALM.IDAlumno INNER JOIN reservacionesalumnos AS RSAL ON RSAL.IDCarga=CGAC.IDCarga WHERE CGAC.IDGrupo=? AND RSAL.FechaReservaAl=? ORDER BY ALM.ApellidoPaternoAlumno,ALM.ApellidoMaternoAlumno");

$obj_datosProfesores->execute();
$profesoresCrudos = $obj_datosProfesores->fetchAll(PDO::FETCH_ASSOC);
$correo = new CorreoManejador();
$fechahoy = date('Y-m-d');

foreach ($profesoresCrudos as $profesor) {
    $obj_datosAlumnos->execute(array($profesor["IDGrupo"], $fechahoy));
    $alumnosCrudos = $obj_datosAlumnos->fetchAll(PDO::FETCH_ASSOC);
    $listaAlumnos = "";
    foreach ($alumnosCrudos as $alumno) {
        $listaAlumnos .= "<li>" . $alumno["ApellidoPaternoAlumno"];
        $listaAlumnos .= " " . $alumno["ApellidoMaternoAlumno"];
        $listaAlumnos .= " " .  $alumno["NombreAlumno"] . "</li>";
    }
    $nombreCompleto = "";
    $nombreCompleto .= $profesor["NombreProfesor"];
    $nombreCompleto .= " " . $profesor["ApellidoPaternoProfesor"];
    $nombreCompleto .= " " . $profesor["ApellidoMaternoProfesor"];

    $asunto = "Lista de alumnos. Asignatura: " . $profesor["NombreAsignatura"];
    $mensaje = "Estimado " . $profesor["GradoAcademico"] . " " . $nombreCompleto . ", a continuacion se le compartir√° una lista de los estudiantes que han hecho una reservacion para la fecha " . $fechahoy . " en la asignatura " . $profesor["NombreAsignatura"] . "Plan de estudio: " . $profesor["NombrePlan"] . ".\n<ol>" . $listaAlumnos . "</ol>";
    echo $mensaje;
    //$correo->EnviarCorreo(array($profesor["CorreoProfesor"] => $nombreProfesor), $asunto, $mensaje);
}
