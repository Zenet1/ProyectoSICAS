<?php
class Edificio{
    private Query $objQuery;

    public function __construct(Query $objQuery)
    {
        include_once('../Clases/Conexion.Class.php');
        $this->conexion = Conexion::ConexionInstacia();
    }

    public function recuperarEdificios(){
        $sql_obtenerEdificios = "SELECT NombreEdificio FROM edificios ORDER BY NombreEdificio";
        $edificiosRecuperados = $this->objQuery->ejecutarConsula($sql_obtenerEdificios, array());
        echo json_encode($edificiosRecuperados);
    }
}
