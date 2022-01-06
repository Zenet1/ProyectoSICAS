<?php

session_start();
date_default_timezone_set("America/Mexico_City");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include "BD_Conexion.php";
include "Qr.Class.php";

$json = file_get_contents('php://input');
$entrada = json_decode($json);
$datos_entrada = (array)$entrada;
$IDExterno = array();
$ContenidoQR = "";

$externoRegistrado = insertarExterno($DB_CONEXION);
if($externoRegistrado){    
    $IDExterno = recuperarIDExterno($DB_CONEXION);
    $ContenidoQR = insertarReservacion($datos_entrada["seleccionadas"], $IDExterno["IDExterno"], $datos_entrada["fechaAsistencia"], $DB_CONEXION);
    generarQRExterno($IDExterno["IDExterno"], $ContenidoQR);
}

function generarQRExterno(string $IDExterno, string $ContenidoQR){
    $NombreQRExterno = "e" . $IDExterno;
    $ContenidoQRExterno = "e," . $ContenidoQR;
    $QR = new GeneradorQr();
    $QR->setNombrePng($NombreQRExterno);
    $QR->Generar($ContenidoQRExterno);
}

function insertarExterno(PDO $Conexion): bool{
    $operacionRealizada = true;

    $sql_insertarExterno = "INSERT INTO externos (NombreExterno, ApellidosExterno, Empresa, CorreoExterno) SELECT ?,?,?,? FROM DUAL
    WHERE NOT EXISTS (SELECT IDExterno FROM externos WHERE NombreExterno = ? AND ApellidosExterno = ? AND Empresa = ? AND CorreoExterno = ?) LIMIT 1";

    $obj_insertarExterno = $Conexion->prepare($sql_insertarExterno);

    if(isset($_SESSION['Nombre']) && isset($_SESSION['apellidosExterno']) && isset($_SESSION['empresa']) && isset($_SESSION['Correo'])){
        $obj_insertarExterno->execute(array($_SESSION['Nombre'], $_SESSION['apellidosExterno'], $_SESSION['empresa'], $_SESSION['Correo'], $_SESSION['Nombre'], $_SESSION['apellidosExterno'], $_SESSION['empresa'], $_SESSION['Correo']));
    }else{
        $operacionRealizada = false;
    }
    return $operacionRealizada;
}

function recuperarIDExterno(PDO $Conexion) : array{
    $sql_recuperarIDExterno = "SELECT IDExterno FROM externos WHERE NombreExterno = ? AND ApellidosExterno = ? AND Empresa = ? AND CorreoExterno = ?";

    $obj_recuperarIDExterno = $Conexion->prepare($sql_recuperarIDExterno);

    $obj_recuperarIDExterno->execute(array($_SESSION['Nombre'], $_SESSION['apellidosExterno'], $_SESSION['empresa'], $_SESSION['Correo']));

    $IDExternoRecuperado = $obj_recuperarIDExterno->fetch(PDO::FETCH_ASSOC);

    return $IDExternoRecuperado;
}

function insertarReservacion(array $oficinas, string $IDExterno, string $fechaAsistencia, PDO $Conexion): string {
    $fechaActual = date('Y-m-d');
    $horaActual = date("H:i:s");
    
    $sql_insertarReservacion = "INSERT INTO reservacionesexternos (IDExterno, IDOficina, FechaReservaExterno, FechaExterno, HoraExterno) VALUES (?, ?, ?, ?, ?)";
    $sql_recuperarIDReserva = "SELECT IDReservaExterno FROM reservacionesexternos WHERE IDExterno = ? AND IDOficina = ? AND FechaReservaExterno = ?";
    
    $obj_insertarReservacion = $Conexion->prepare($sql_insertarReservacion);
    $obj_recuperarIDReserva = $Conexion->prepare($sql_recuperarIDReserva);

    $QRContenido = $IDExterno;

    foreach($oficinas as $oficina){
        $oficinaArray = (array)$oficina;
        
        $obj_insertarReservacion->execute(array($IDExterno, $oficinaArray["IDOficina"], $fechaAsistencia, $fechaActual, $horaActual));
        $obj_recuperarIDReserva->execute(array($IDExterno, $oficinaArray["IDOficina"], $fechaAsistencia));
        $IDReserva = $obj_recuperarIDReserva->fetch(PDO::FETCH_ASSOC);

        $QRContenido .= "," . $IDReserva["IDReservaExterno"];
    }
    
    inicializacionVariablesSesion($IDExterno, $fechaAsistencia);
    return $QRContenido;
}

function inicializacionVariablesSesion(string $IDExterno, string $fechaAsistencia) : void{
    $_SESSION["IDExterno"] = $IDExterno;
    $_SESSION["FechaReservada"] = $fechaAsistencia;
}

?>