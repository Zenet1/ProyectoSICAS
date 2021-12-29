<?php
include "BD_Conexion.php";

$json = file_get_contents('php://input');
$datos = (array)json_decode($json);


