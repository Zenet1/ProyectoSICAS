<?php
    include 'BD_Conexion.php';
    include 'Email.Service.php';

    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";

    $json = file_get_contents('php://input');
    $datos = json_decode($json);
?>