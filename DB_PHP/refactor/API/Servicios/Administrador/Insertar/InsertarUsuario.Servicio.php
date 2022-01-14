<?php
include_once("InsertarUsuarioQuery.Query.php");
class InsertarUsuario
{
    private Query $objQuery;
    private InsertarUsuarioQuery $objQueries;

    public function __construct(Query $objQuery)
    {
        $this->objQueries = new InsertarUsuarioQuery();
        $this->objQuery = $objQuery;
    }

    public function InsertarNuevoTrabajador(array $datos)
    {
        $datosInsertar = array();
    }
}

$incognitas = array("ctn" => $datos["usuario"], $datos["contrasena"], $datos["rol"]);
$obj_insertarUsuario->execute($incognitas);


function Insertar(PDO $Conexion, array $datosAdmin, string $query)
{
    $obj_recuperarID = $Conexion->prepare("SELECT IDUsuario FROM usuarios WHERE Cuenta=?");
    $obj_recuperarID->execute(array($datosAdmin["usuario"]));

    $IDCuenta = $obj_recuperarID->fetch(PDO::FETCH_ASSOC);

    $obj_registro = $Conexion->prepare($query);

    $obj_registro->execute(array($IDCuenta["IDUsuario"], $datosAdmin["nombre"], $datosAdmin["apellidoPaterno"], $datosAdmin["apellidoMaterno"], $IDCuenta["IDUsuario"]));
}
