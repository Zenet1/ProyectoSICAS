<?php

date_default_timezone_set("America/Mexico_City");
include "BD_Conexion.php";

$json = file_get_contents('php://input');
$datos_entrada = (array)json_decode($json);

alertarAfectados($datos_entrada, $DB_CONEXION);

function alertarAfectados(array $datos_entrada, PDO $Conexion)
{

    $arraygruposID = array();
    $arrayClaveGrupo = array();
    $alumnos = array();
    $Profesores = array();
    $usuariosImplicados = array();
    $datos_enviar = array();
    $IDAlumnoAfectado = "";
    $arrayFechasAsistidas = obtenerFechasAsistencia($datos_entrada["fechaInicio"], $datos_entrada["fechaFin"], $datos_entrada["matricula"], $Conexion);

    $sql_obtenerGruposAsistidos = "SELECT CGAC.IDGrupo, GPS.ClaveGrupo, GPS.Grupo FROM reservacionesalumnos AS RSAL 
    INNER JOIN cargaacademica AS CGAC ON CGAC.IDCarga = RSAL.IDCarga 
    INNER JOIN grupos AS GPS ON GPS.IDGrupo = CGAC.IDGrupo 
    WHERE RSAL.FechaReservaAl = ? AND CGAC.IDAlumno = ?";

    $obj_obtenerGruposAsistidos = $Conexion->prepare($sql_obtenerGruposAsistidos);

    $sql_obtenerAlumnosAfectados = "SELECT ALM.NombreAlumno, ALM.ApellidoPaternoAlumno, ALM.ApellidoMaternoAlumno, ALM.CorreoAlumno FROM alumnos AS ALM 
    INNER JOIN cargaacademica AS CGAC ON ALM.IDAlumno = CGAC.IDAlumno 
    WHERE CGAC.IDGrupo = ? AND ALM.Matricula != ?";

    $obj_obtenerAlumnosAfectados = $Conexion->prepare($sql_obtenerAlumnosAfectados);

    $sql_obtenerProfesores = "SELECT ACAD.CorreoProfesor, ACAD.NombreProfesor, ACAD.ApellidoPaternoProfesor, ACAD.ApellidoMaternoProfesor FROM academicos AS ACAD 
    INNER JOIN grupos AS GPS ON GPS.IDProfesor = ACAD.IDProfesor 
    WHERE GPS.IDGrupo = ?";

    $obj_obtenerProfesores = $Conexion->prepare($sql_obtenerProfesores);

    foreach ($arrayFechasAsistidas as $fechaAsistida) {
        $IDAlumnoAfectado = $fechaAsistida["IDAlumno"];

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

        $obj_obtenerAlumnosAfectados->execute(array($valor, $datos_entrada["matricula"]));
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

    registrarIncidente($IDAlumnoAfectado, $datos_entrada["fechaSuspension"], $Conexion);

    $datos_enviar["usuarios"] = $usuariosImplicados;
    $datos_enviar["grupos"] = $arrayClaveGrupo;

    echo json_encode($datos_enviar);
    flush();
}

function obtenerFechasAsistencia(string $fechaInicio, string $fechaFin, string $matricula, PDO $Conexion): array
{

    $sql_obtenerFechasAsistencia = "SELECT ASIS.FechaAl, ALM.IDAlumno FROM asistenciasalumnos AS ASIS 
    INNER JOIN alumnos AS ALM ON ALM.IDAlumno = ASIS.IDAlumno 
    WHERE ASIS.FechaAl >= ? AND ASIS.FechaAl <= ? AND ALM.Matricula = ?";

    $obj_obtenerFechasAsistencia = $Conexion->prepare($sql_obtenerFechasAsistencia);

    $obj_obtenerFechasAsistencia->execute(array($fechaInicio, $fechaFin, $matricula));

    $arrayFechasAsistidas = $obj_obtenerFechasAsistencia->fetchAll(PDO::FETCH_ASSOC);

    return $arrayFechasAsistidas;
}

function registrarIncidente(string $IDAlumno, string $fechaLimiteSuspension, PDO $Conexion)
{

    $fechaAlerta = date('Y-m-d');
    if (validarIncidenteRegistrado($IDAlumno, $fechaAlerta, $fechaLimiteSuspension, true, $Conexion)) {
        $sql_registrarIncidente = "INSERT INTO incidentes (IDAlumno, FechaAl, FechaLimiteSuspension) SELECT ?, ?, ? FROM DUAL 
        WHERE NOT EXISTS (SELECT IDIncidente FROM incidentes WHERE IDAlumno = ? AND FechaAl = ? AND FechaLimiteSuspension = ?) LIMIT 1";

        $obj_registrarIncidente = $Conexion->prepare($sql_registrarIncidente);

        $obj_registrarIncidente->execute(array($IDAlumno, $fechaAlerta, $fechaLimiteSuspension, $IDAlumno, $fechaAlerta, $fechaLimiteSuspension));

        validarIncidenteRegistrado($IDAlumno, $fechaAlerta, $fechaLimiteSuspension, false, $Conexion);
    }
}

function validarIncidenteRegistrado(string $IDAlumno, string $fechaAlerta, string $fechaLimiteSuspension, bool $validarDuplicacion, PDO $Conexion): bool
{

    $sql_validarIncidente = "SELECT * FROM incidentes WHERE IDAlumno = ? AND FechaAl = ? AND FechaLimiteSuspension = ?";

    $obj_validarIncidente = $Conexion->prepare($sql_validarIncidente);

    $obj_validarIncidente->execute(array($IDAlumno, $fechaAlerta, $fechaLimiteSuspension));

    $incidenteDevuelto = $obj_validarIncidente->fetchAll(PDO::FETCH_ASSOC);

    return validarCasos($incidenteDevuelto, $validarDuplicacion);
}

function validarCasos(array $incidenteDevuelto, bool $validarDuplicacion): bool
{

    if ($validarDuplicacion) {
        if (!validarVariable($incidenteDevuelto)) {
            echo "ERROR: El incidente ingresado ya ha sido registrado con anterioridad";
            return false;
        }
    } else {
        if (validarVariable($incidenteDevuelto)) {
            echo "ERROR: El incidente no se ha podido registrar con éxito";
            return false;
        }
    }
    return true;
}

function validarVariable(array $variable): bool
{
    return ($variable === false || sizeof($variable) === 0);
}
