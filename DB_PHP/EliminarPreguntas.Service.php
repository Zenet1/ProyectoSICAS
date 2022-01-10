<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";

    $json = file_get_contents('php://input');
    $datos_pregunta = (array)json_decode($json);

    eliminarPregunta($datos_pregunta[0], $DB_CONEXION);

    function eliminarPregunta(string $contenidoPregunta, PDO $Conexion){

        $sql_eliminarPregunta = "DELETE FROM preguntas WHERE IDPregunta = ?";
        
        $obj_eliminarPregunta = $Conexion->prepare($sql_eliminarPregunta);
        
        $obj_eliminarPregunta->execute(array($contenidoPregunta));
        
        validarPreguntaEliminada($contenidoPregunta, $Conexion);
    }

    function validarPreguntaEliminada(string $contenidoPregunta, PDO $Conexion) : bool{
        
        $sql_validarPregunta = "SELECT * FROM preguntas WHERE IDPregunta = ?";

        $obj_validarPregunta = $Conexion->prepare($sql_validarPregunta);

        $obj_validarPregunta->execute(array($contenidoPregunta));
        
        $preguntaDevuelta = $obj_validarPregunta->fetchAll(PDO::FETCH_ASSOC);

        if(!validarVariable($preguntaDevuelta)){
            echo "ERROR: La pregunta no se ha podido eliminar";
            return false;
        }else{
            return true;
        }
    }

    function validarVariable(array $variable) : bool{
        return ($variable === false || sizeof($variable) === 0);
    }
?>