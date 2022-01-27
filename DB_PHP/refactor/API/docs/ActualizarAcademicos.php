<?php

function ActualizarAcademicos(string $carpeta, PDO $conexion)
{
    $archivo = file("$carpeta/ProfesoresConAlumnosInscritos.txt");
    $saltado = false;

    $sqlBuscar = "SELECT IDUsuario WHERE ClaveProfesro=?";

    $sqlActualizarDatos = "UPDATE academicos SET NombreProfesor=?,ApellidoPaternoProfesor=?,ApellidoMaternoProfesor=?,CorreoProfesor=? WHERE";
    $sqlInsertarCuenta = "";
}
