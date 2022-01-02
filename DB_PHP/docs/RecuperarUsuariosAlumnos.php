<?php
function RecuperarUsuariosAlumnos(PDO $Conexion)
{
    $archivo = file("docs/AlumnosInscripcionEnPeriodoCurso.txt");
    $saltado = false;
    $sql_introducir_cuenta = "INSERT INTO usuarios (Cuenta, Contraseña, IDRol) VALUES (?,?,?)";

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }

        $datos = explode("|", utf8_encode($linea));
        $estado_obj = $Conexion->prepare($sql_introducir_cuenta);
        $verificacion = $estado_obj->execute(array("a" . $datos[0], 123, 1)); //Cambiar la contraseña
    }
}

