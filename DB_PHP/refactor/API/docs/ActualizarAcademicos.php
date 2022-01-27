<?php

function ActualizarAcademicos(string $carpeta, PDO $conexion)
{
    $archivo = file("$carpeta/ProfesoresConAlumnosInscritos.txt");
    $saltado = false;

    $sqlBuscar = "SELECT IDUsuario FROM academicos WHERE ClaveProfesro=?";

    $sqlBuscarID = "SELECT IDUsuario FROM usuarios WHERE Cuenta=?";

    $sqlActualizarDatos = "UPDATE academicos SET NombreProfesor=?,ApellidoPaternoProfesor=?,ApellidoMaternoProfesor=?,CorreoProfesor=? WHERE ClaveProfesro=?";

    $sqlInsertarCuenta = "INSERT INTO usuarios (Cuenta,Rol) SELECT :cnt,:rol FROM DUAL WHERE NOT EXISTS (SELECT Cuenta FROM usuarios WHERE Cuenta=:cnt) LIMIT 1";

    $objBuscar = $conexion->prepare($sqlBuscar);
    $objInsertar = $conexion->prepare($sqlInsertarCuenta);

    foreach ($archivo as $linea) {

        if ($saltado) {
            continue;
            $saltado = true;
        }

        $datos = explode("|", trim($linea));

        $objBuscar->execute(array($datos[0]));
        $ID = $objBuscar->fetch(PDO::FETCH_ASSOC);

        if ($ID["IDUsuario"] === 0 && $datos[6] !== "null") {
            $objInsertar->execute(array("cnt" => $datos[6], "rol" => 5));
        }

        

    }
}
