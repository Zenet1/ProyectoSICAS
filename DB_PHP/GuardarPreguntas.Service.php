<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";

    $json = file_get_contents('php://input');
    $datos_pregunta = (array)json_decode($json);

    registrarPregunta($datos_pregunta["pregunta"], $DB_CONEXION);

    function registrarPregunta(string $contenidoPregunta, PDO $Conexion){

        if(validarPreguntaRegistrada($contenidoPregunta, true, $Conexion)){

            $sql_registrarPregunta = "INSERT INTO preguntas (Pregunta) SELECT ? FROM DUAL
            WHERE NOT EXISTS (SELECT Pregunta FROM preguntas WHERE Pregunta = ?) LIMIT 1";

            $obj_registrarPregunta = $Conexion->prepare($sql_registrarPregunta);
            
            $obj_registrarPregunta->execute(array($contenidoPregunta, $contenidoPregunta));

            validarPreguntaRegistrada($contenidoPregunta, false, $Conexion);
        }
    }

    function validarPreguntaRegistrada(string $contenidoPregunta, bool $validarDuplicacion, PDO $Conexion) : bool{
        
        $sql_validarPregunta = "SELECT * FROM preguntas WHERE Pregunta = ?";

        $obj_validarPregunta = $Conexion->prepare($sql_validarPregunta);

        $obj_validarPregunta->execute(array($contenidoPregunta));
        
        $preguntaDevuelta = $obj_validarPregunta->fetchAll(PDO::FETCH_ASSOC);

        return validarCasos($preguntaDevuelta, $validarDuplicacion);
    }

    function validarCasos(array $preguntaDevuelta, bool $validarDuplicacion) : bool{

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

    function validarVariable(array $variable) : bool{
        return ($variable === false || sizeof($variable) === 0);
    }
?>