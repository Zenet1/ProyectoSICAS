<?php

class Conexion
{
    private PDO $conexion;
    private static $ObjConexion;

    public static function ConexionInstacia(string $cabecera = "DSN")
    {
        if (!self::$ObjConexion instanceof self) {
            self::$ObjConexion = new self($cabecera);
        }
        return self::$ObjConexion;
    }

    private function __construct(string $cabecera)
    {
        include_once 'Env.Utileria.php';
        try {
            $this->conexion = new PDO($_ENV[$cabecera], $_ENV['USERNAME'],  $_ENV['PASSWORD']);
        } catch (Exception $e) {
            error_log("Error al iniciar la conexion");
        }
    }

    public static function ReconfigurarConexion(string $cabecera = "DSN")
    {
        if (!self::$ObjConexion instanceof self) {
            self::$ObjConexion = new self($cabecera);
        }
    }

    public function getConexion(): PDO
    {
        return $this->conexion;
    }
}
