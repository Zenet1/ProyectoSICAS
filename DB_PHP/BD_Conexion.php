<?php
    require 'Utileria.php';

    try{
        $DSN = $_ENV['DSN'];
        $USUARIO = $_ENV['USERNAME'];
        $CONTRASENIA = $_ENV['PASSWORD'];
        $DB_CONEXION = new PDO("mysql:dbname=sicasbs;host=localhost:3306", "root", "");
    }catch(Exception $e){
        echo "ERROR AL CARGAR LA BASE DE DATOS";
    }
?>