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
        $incognitas = array("ctn" => $datos["usuario"], "pss" => $datos["contrasena"], "idr" => $datos["rol"]);
        $this->objQuery->ejecutarConsula($this->objQueries->INSERTusuarioQuery(), $incognitas);
        $IDUsuario = $this->objQuery->ejecutarConsula($this->objQueries->SELECTIDusuarioQuery(), array("ctn" => $datos["usuario"]));
        $datosTrabajador = array("idu" => $IDUsuario[0]["IDUsuario"], "nm" => $datos["nombre"], "app" => $datos["apellidoPaterno"], "apm" => $datos["apellidoMaterno"]);
        $this->objQuery->ejecutarConsula($this->objQueries->INSERTTRABQuery($datos["rol"]), $datosTrabajador);
    }
}
