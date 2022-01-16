<?php
class Edificio{

    private Conexion $conexion;

    public function __construct()
    {
        include_once('../Clases/Conexion.Class.php');
        $this->conexion = Conexion::ConexionInstacia();
    }

    public function recuperarEdificios(){
        $sql_obtenerEdificios = "SELECT NombreEdificio FROM edificios ORDER BY NombreEdificio";
        $obj_obtenerEdificios = $this->conexion->getConexion()->prepare($sql_obtenerEdificios);
        $obj_obtenerEdificios->execute();
        $edificiosRecuperados = $obj_obtenerEdificios->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($edificiosRecuperados);
    }
}

?>