<?php
    require 'Utileria.php';

    try{
        $DB_CONEXION = new PDO("mysql:dbname=sicas_test;host=localhost:3308", "root", "");
    }catch(Exception $e){
        echo "ERROR AL CARGAR LA BASE DE DATOS";
    }
?>