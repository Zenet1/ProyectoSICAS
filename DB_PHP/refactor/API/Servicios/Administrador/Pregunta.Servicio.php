<?php

class Pregunta
{
    private Query $objQuery;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
    }

    function recuperarPreguntas()
    {
        $sql_recuperarPreguntas = "SELECT * FROM preguntas";
        $preguntas = $this->objQuery->ejecutarConsula($sql_recuperarPreguntas, array());
        echo json_encode($preguntas);
    }

    function eliminarPregunta(int $idPregunta)
    {
        $sql_eliminarPregunta = "DELETE FROM preguntas WHERE IDPregunta=:pgr";
        $this->objQuery->ejecutarConsula($sql_eliminarPregunta, array("pgr" => $idPregunta));
    }

    public function insertarPregunta(string $pregunta)
    {
        $sql_registrarPregunta = "INSERT INTO preguntas (IDpregunta, Pregunta) SELECT :idp,:pgr FROM DUAL WHERE NOT EXISTS (SELECT Pregunta FROM preguntas WHERE Pregunta=:pgr) LIMIT 1";
        $this->objQuery->ejecutarConsula($sql_registrarPregunta, array("idp" => 0, "pgr" => $pregunta));
    }

    private function validarPreguntaRegistrada(string $contenidoPregunta, bool $validarDuplicacion): bool
    {
        $sql_validarPregunta = "SELECT * FROM preguntas WHERE Pregunta = ?";
        $obj_validarPregunta = $this->conexion->getConexion()->prepare($sql_validarPregunta);
        $obj_validarPregunta->execute(array($contenidoPregunta));
        $preguntaDevuelta = $obj_validarPregunta->fetchAll(PDO::FETCH_ASSOC);

        return $this->validarCasos($preguntaDevuelta, $validarDuplicacion);
    }

    private function validarCasos(array $preguntaDevuelta, bool $validarDuplicacion): bool
    {
        if ($validarDuplicacion) {
            if (!validarVariable($preguntaDevuelta)) {
                echo "ERROR: Pregunta duplicada";
                return false;
            }
        } else {
            if (validarVariable($preguntaDevuelta)) {
                echo "ERROR: La pregunta no se ha podido registrar con éxito";
                return false;
            }
        }
        return true;
    }

    private function validarVariable(array $variable): bool
    {
        return ($variable === false || sizeof($variable) === 0);
    }
}
