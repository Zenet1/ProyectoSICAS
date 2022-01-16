<?php

class Pregunta
{
    private Conexion $conexion;
    
    public function __construct()
    {
        include_once('../Clases/Conexion.Class.php');
        $this->conexion = Conexion::ConexionInstacia();
    }

    public function recuperarPreguntas()
    {
        $sql_recuperarPreguntas = "SELECT * FROM preguntas";
        $obj_recuperarPreguntas = $this->conexion->getConexion()->prepare($sql_recuperarPreguntas);
        $obj_recuperarPreguntas->execute();
        $preguntasRecuperadas = $obj_recuperarPreguntas->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($preguntasRecuperadas);
    }

    public function eliminarPregunta(string $contenidoPregunta)
    {
        $sql_eliminarPregunta = "DELETE FROM preguntas WHERE IDPregunta = ?";
        $obj_eliminarPregunta = $this->conexion->getConexion()->prepare($sql_eliminarPregunta);
        $obj_eliminarPregunta->execute(array($contenidoPregunta));
    }

    public function insertarPregunta(string $contenidoPregunta){
        if($this->validarPreguntaRegistrada($contenidoPregunta, true)){
            $sql_registrarPregunta = "INSERT INTO preguntas (Pregunta) SELECT ? FROM DUAL
            WHERE NOT EXISTS (SELECT Pregunta FROM preguntas WHERE Pregunta = ?) LIMIT 1";
            $obj_registrarPregunta = $this->conexion->getConexion()->prepare($sql_registrarPregunta);
            $obj_registrarPregunta->execute(array($contenidoPregunta, $contenidoPregunta));
            
            $this->validarPreguntaRegistrada($contenidoPregunta, false);
        }
    }
    
    private function validarPreguntaRegistrada(string $contenidoPregunta, bool $validarDuplicacion) : bool
    {
        $sql_validarPregunta = "SELECT * FROM preguntas WHERE Pregunta = ?";
        $obj_validarPregunta = $this->conexion->getConexion()->prepare($sql_validarPregunta);
        $obj_validarPregunta->execute(array($contenidoPregunta));
        $preguntaDevuelta = $obj_validarPregunta->fetchAll(PDO::FETCH_ASSOC);
        
        return $this->validarCasos($preguntaDevuelta, $validarDuplicacion);
    }

    private function validarCasos(array $preguntaDevuelta, bool $validarDuplicacion) : bool
    {
        if($validarDuplicacion){
            if(!validarVariable($preguntaDevuelta)){
                echo "ERROR: Pregunta duplicada";
                return false;
            }
        }else{
            if(validarVariable($preguntaDevuelta)){
                echo "ERROR: La pregunta no se ha podido registrar con éxito";
                return false;
            }
        }
        return true;
    }
    
    private function validarVariable($variable)
    {
        return ($variable === false || sizeof($variable) === 0);
    }
}

    
?>