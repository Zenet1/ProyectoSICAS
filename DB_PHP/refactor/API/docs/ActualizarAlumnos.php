<?php

function ActualizarAlumnos(string $carpeta, PDO $conexion)
{
    $archivo = file("$carpeta/AlumnosInscripcionEnPeriodoCurso.txt");
    $saltado = false;

    $sqlBuscar = "";
}
