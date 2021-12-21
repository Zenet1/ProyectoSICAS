<?php
    session_start();
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include 'BD_Conexion.php';

    


    function ReservaAlumno(){
        $IDAlumno = $_SESSION["IDAlumno"];
        $sql_obtenerMateriasAlumno = "SELECT * ";
    }

    function ReservaExterno(){
        
    }
?>