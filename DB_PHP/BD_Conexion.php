<?php
    require 'Utileria.php';

    class Db_conexion{
        private $DB_CONEXION;

        public function __construct(){
            try{
                $DSN = $_ENV['DSN'];
                $USUARIO = $_ENV['USERNAME'];
                $CONTRASENIA = $_ENV['PASSWORD'];
                $this->DB_CONEXION = new PDO($DSN, $USUARIO, $CONTRASENIA);
            }catch(Exception $e){
                echo "ERROR AL CARGAR LA BASE DE DATOS";
            }
        }

        public function Insertar(String $QUERY) : bool{
            return true;
        }

        public function Editar(String $QUERY): bool{
            return true;
        }

        public function Eliminar(String $QUERY) : bool{
            return true;
        }

        public function Recuperar(String $QUERY){
            
        }
    }
?>