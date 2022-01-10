<?php
include 'BD_Conexion.php';

$json = file_get_contents('php://input');
$datos = (array)json_decode($json);

$obj_insertarUsuario = $DB_CONEXION->prepare("INSERT INTO usuarios (Cuenta,Contraseña,IDRol) SELECT :ctn,?,? FROM DUAL WHERE NOT EXISTS (SELECT Cuenta FROM usuarios WHERE Cuenta = :ctn) LIMIT 1");
$incognitas = array("ctn" => $datos["usuario"], $datos["contrasena"], $datos["rol"]);
$obj_insertarUsuario->execute($incognitas);

switch ($datos["rol"]) {
    case "2":
        $query = "INSERT INTO capturadores (IDUsuario,NombreCapt,ApellidoPaternoCapt, ApellidoMaternoCapt) SELECT ?,?,?,? FROM DUAL WHERE NOT EXISTS (SELECT IDUsuario FROM administrativos WHERE IDUsuario=?) LIMIT 1";
        Insertar($DB_CONEXION, $datos, $query);
        break;
    case "3":
        $query = "INSERT INTO administradores (IDUsuario,NombreAdmin, ApellidoPaternoAdmin, ApellidoMaternoAdmin) SELECT ?,?,?,? FROM DUAL WHERE NOT EXISTS (SELECT IDUsuario FROM administradores WHERE IDUsuario=?) LIMIT 1";
        Insertar($DB_CONEXION, $datos, $query);
        break;
}


function Insertar(PDO $Conexion, array $datosAdmin, string $query)
{
    $obj_recuperarID = $Conexion->prepare("SELECT IDUsuario FROM usuarios WHERE Cuenta=?");
    $obj_recuperarID->execute(array($datosAdmin["usuario"]));

    $IDCuenta = $obj_recuperarID->fetch(PDO::FETCH_ASSOC);

    $obj_registro = $Conexion->prepare($query);

    $obj_registro->execute(array($IDCuenta["IDUsuario"], $datosAdmin["nombre"], $datosAdmin["apellidoPaterno"], $datosAdmin["apellidoMaterno"], $IDCuenta["IDUsuario"]));
}
