<?php
include 'BD_Conexion.php';
$obj_roles = $DB_CONEXION->prepare("SELECT IDRol,Rol FROM roles WHERE IDRol > 1");
$obj_roles->execute();

$roles = $obj_roles->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($roles);
