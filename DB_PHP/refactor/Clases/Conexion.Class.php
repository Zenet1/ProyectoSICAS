<?php

class Conexion
{
    private PDO $Conexion;
    private self $ObjConexion;

    public function ConexionInstacia(){
        if($this->ObjConexion === null){
            $this->ObjConexion = new Conexion();
        }
        return $this->ObjConexion;
    }

    private function __construct()
    {
        include 'Env.Utileria.php';
        $this->IniciarConexion();
    }

    private function IniciarConexion()
    {
        try {
            $DSN = $_ENV['DSN'];
            $USUARIO = $_ENV['USERNAME'];
            $CONTRASENIA = $_ENV['PASSWORD'];
            $this->Conexion = new PDO($DSN, $USUARIO, $CONTRASENIA);
        } catch (Exception $e) {
            error_log("Error al iniciar la conexion");
        }
    }

    public function getConexion(): PDO
    {
        return $this->Conexion;
    }
}
