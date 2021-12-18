<?php
    require 'Utileria.php';
    try{
        $DSN = $_ENV['DSN'];
        $USUARIO = $_ENV['USERNAME'];
        $CONTRASENIA = $_ENV['PASSWORD'];
        $this->DB_CONEXION = new PDO($DSN, $USUARIO, $CONTRASENIA);
    }catch(Exception $e){
        echo "ERROR AL CARGAR LA BASE DE DATOS";
    }
?>