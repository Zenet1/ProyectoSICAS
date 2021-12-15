<?php
    require 'vendor/autoload.php';

    try{
        $dotenv = Dotenv\Dotenv::createImmutable("../");
        $dotenv->safeLoad();

        $DSN = $_ENV['DSN'];
        $USUARIO = $_ENV['USERNAME'];
        $CONTRASENIA = $_ENV['PASSWORD'];

        $DB_CONEXION = new PDO($DSN, $USUARIO, $CONTRASENIA);
    }catch(Exception $e){
        echo "ERROR AL CARGAR LA BASE DE DATOS";
    }
?>