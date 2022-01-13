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
            $this->conexion = new PDO($_ENV['DSN'], $_ENV['USERNAME'],  $_ENV['PASSWORD']);
        } catch (Exception $e) {
            error_log("Error al iniciar la conexion");
        }
    }

    public function getConexion(): PDO
    {
        return $this->conexion;
    }
}
