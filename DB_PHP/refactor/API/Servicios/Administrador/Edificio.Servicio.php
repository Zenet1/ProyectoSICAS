<?php
class Edificio{

    private Conexion $conexion;

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *'); 
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        include_once('Conexion.Class.php');
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