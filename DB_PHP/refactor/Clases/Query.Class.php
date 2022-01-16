<?php

class Query
{
    private Conexion $conexion;

    public function __construct()
    {
        include_once('Conexion.Class.php');
        $this->conexion = Conexion::ConexionInstacia();
    }

    public function ejecutarConsulta(string $query, array $variables)
    {
        $objSelect = $this->conexion->getConexion()->prepare($query);
        $objSelect->execute($variables);
        return $objSelect->fetchAll(PDO::FETCH_ASSOC);
    }
}
