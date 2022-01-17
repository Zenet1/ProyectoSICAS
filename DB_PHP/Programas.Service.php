<?php

include 'BD_Conexion.php';

$programas = $DB_CONEXION->prepare("SELECT NombrePlan,ClavePlan FROM planesdeestudio");
$programas->execute();

echo json_encode($programas->fetchAll(PDO::FETCH_ASSOC));
