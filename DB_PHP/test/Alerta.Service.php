<?php
include "BD_Conexion.php";

$json = file_get_contents('php://input');
$datos = (array)json_decode($json);

$arraygruposID = array();
$arrayClaveGrupo = array();
$alumnos = array();
$Profesores = array();
$usuariosImplicados = array();
$datos_enviar = array();

$obj_obtenerFechasAsistencia = $DB_CONEXION->prepare("SELECT ASIS.FechaAl,ALM.IDAlumno FROM asistenciasalumnos AS ASIS INNER JOIN alumnos AS ALM ON ALM.IDAlumno=ASIS.IDAlumno WHERE ASIS.FechaAl >= ? AND ASIS.FechaAl <= ? AND ALM.Matricula = ?");
$obj_obtenerFechasAsistencia->execute(array($datos["fechaInicio"], $datos["fechaFin"], $datos["matricula"]));

$arrayFechasAsistidas = $obj_obtenerFechasAsistencia->fetchAll(PDO::FETCH_ASSOC);

$obj_obtenerGruposAsistidos = $DB_CONEXION->prepare("SELECT CGAC.IDGrupo,GPS.ClaveGrupo,GPS.Grupo FROM reservacionesalumnos AS RSAL INNER JOIN cargaacademica AS CGAC ON CGAC.IDCarga=RSAL.IDCarga INNER JOIN grupos AS GPS ON GPS.IDGrupo=CGAC.IDGrupo WHERE RSAL.FechaReservaAl = ? AND CGAC.IDAlumno = ?");

$obj_obtenerAlumnosAfectados = $DB_CONEXION->prepare("SELECT ALM.NombreAlumno,ALM.ApellidoPaternoAlumno,ALM.ApellidoMaternoAlumno,ALM.CorreoAlumno FROM alumnos AS ALM INNER JOIN cargaacademica AS CGAC ON ALM.IDAlumno = CGAC.IDAlumno WHERE CGAC.IDGrupo = ? AND ALM.Matricula != ?");

$obj_obtenerProfesores = $DB_CONEXION->prepare("SELECT ACAD.CorreoProfesor,ACAD.NombreProfesor,ACAD.ApellidoPaternoProfesor, ACAD.ApellidoMaternoProfesor FROM academicos AS ACAD INNER JOIN grupos AS GPS ON GPS.IDProfesor=ACAD.IDProfesor WHERE GPS.IDGrupo=?");

foreach ($arrayFechasAsistidas as $fechaAsistida) {
    $obj_obtenerGruposAsistidos->execute(array($fechaAsistida["FechaAl"], $fechaAsistida["IDAlumno"]));
    $grupos = $obj_obtenerGruposAsistidos->fetchAll(PDO::FETCH_ASSOC);
    foreach ($grupos as $grupo) {
        if (!isset($arraygruposID[$grupo["IDGrupo"]])) {
            $arraygruposID[$grupo["IDGrupo"]] = $grupo["IDGrupo"];
            $arrayClaveGrupo[] = array("ClaveGrupo" => $grupo["ClaveGrupo"], "Grupo" => trim($grupo["Grupo"]));
        }
    }
}

foreach ($arraygruposID as $clave => $valor) {
    $obj_obtenerAlumnosAfectados->execute(array($valor, $datos["matricula"]));
    $obj_obtenerProfesores->execute(array($valor));
    $datosProfesor = $obj_obtenerProfesores->fetch(PDO::FETCH_ASSOC);
    $datosAlumnos = $obj_obtenerAlumnosAfectados->fetchAll(PDO::FETCH_ASSOC);

    if (!isset($Profesores[trim($datosProfesor["CorreoProfesor"])])) {
        $Profesores[trim($datosProfesor["CorreoProfesor"])] = "";
        $usuariosImplicados[] = array(trim($datosProfesor["CorreoProfesor"]) => $datosProfesor["NombreProfesor"] . " " . $datosProfesor["ApellidoPaternoProfesor"] . " " . $datosProfesor["ApellidoMaternoProfesor"]);
    }

    foreach ($datosAlumnos as $alumno) {
        if (!isset($alumnos[trim($alumno["CorreoAlumno"])])) {
            $alumnos[trim($alumno["CorreoAlumno"])] = "";
            $usuariosImplicados[] = array(trim($alumno["CorreoAlumno"]) => $alumno["NombreAlumno"] . " " . $alumno["ApellidoPaternoAlumno"] . " " . $alumno["ApellidoMaternoAlumno"]);
        }
    }
}

$datos_enviar["usuarios"] = $usuariosImplicados;
$datos_enviar["grupos"] = $arrayClaveGrupo;

echo json_encode($datos_enviar);