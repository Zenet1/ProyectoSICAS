<?php

class Conexion
{
    private PDO $conexion;
    private static $ObjConexion;

    public static function ConexionInstacia()
    {
        if (!self::$ObjConexion instanceof self) {
            self::$ObjConexion = new self();
        }
        return self::$ObjConexion;
    }

    private function __construct()
    {
        include_once 'Env.Utileria.php';
        $this->IniciarConexion();
    }

    private function IniciarConexion()
    {
        try {
            $DSN = $_ENV['DSN'];
            $USUARIO = $_ENV['USERNAME'];
            $CONTRASENIA = $_ENV['PASSWORD'];
            $this->conexion = new PDO($DSN, $USUARIO, $CONTRASENIA);
        } catch (Exception $e) {
            error_log("Error al iniciar la conexion");
        }
    }

    public function getConexion(): PDO
    {
        return $this->conexion;
    }
}
