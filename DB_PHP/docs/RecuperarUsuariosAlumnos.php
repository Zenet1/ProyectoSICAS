<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: text/html; charset=UTF-8');
header('Content-Type: text/html; charset=UTF-8');

function RecuperarUsuariosAlumnos($Conexion)
{
    $archivo = file("docs/AlumnosInscripcionEnPeriodoCurso.txt");

    $saltado = false;
    $sql_introducir_cuenta = "INSERT INTO usuarios (Cuenta, IDRol) SELECT :cue,:idr FROM DUAL WHERE NOT EXISTS(SELECT Cuenta FROM usuarios WHERE Cuenta=:cue) LIMIT 1";

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }

        $datos = explode("|", utf8_encode($linea));
        $estado_obj = $Conexion->prepare($sql_introducir_cuenta);
        $estado_obj->execute(array("cue" => "a" . $datos[0], "idr" => 1));
    }
}
