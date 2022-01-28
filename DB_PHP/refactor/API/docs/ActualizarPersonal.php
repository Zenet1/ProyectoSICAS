<?php

function ActualizarPersonal(string $carpeta, PDO $conexion)
{
    $archivo = file("$carpeta/administrativos.txt");
    $saltado = false;

    $sqlBuscarIDBuscar = "SELECT IDUsuario FROM personal WHERE ClavePersonal=?";
    $sqlBuscarIDcuenta = "SELECT IDUsuario FROM usuarios WHERE Cuenta=?";
}
