<?php
include_once("../../Clases/Query.Class.php");
include_once("../../Clases/Conexion.Class.php");

Conexion::ReconfigurarConexcion("CAMPUS");
$QueryControl = new Query();

$sql_recFacs = "SELECT * FROM facultades";
$resultado = $QueryControl->ejecutarConsulta($sql_recFacs, array());

echo json_encode($resultado);
