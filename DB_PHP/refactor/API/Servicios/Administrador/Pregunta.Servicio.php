<?php

class Pregunta
{
    private Query $objQuery;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
    }

    public function recuperarPreguntas()
    {
        $sql_recuperarPreguntas = "SELECT * FROM preguntas";
        $preguntas = $this->objQuery->ejecutarConsulta($sql_recuperarPreguntas, array());
        echo json_encode($preguntas);
    }

    function eliminarPregunta(array $contenido)
    {
        $sql_eliminarPregunta = "DELETE FROM preguntas WHERE IDPregunta=:pgr or Enlace=:pgr";
        $this->objQuery->ejecutarConsulta($sql_eliminarPregunta, array("pgr" => $contenido[0]));
    }

    public function insertarPregunta(array $contenido)
    {
        $sql_registrarPregunta = "INSERT INTO preguntas (Pregunta,Respuesta,Enlace) SELECT :pgr,:rpt,:enl FROM DUAL WHERE NOT EXISTS (SELECT Pregunta FROM preguntas WHERE Pregunta=:pgr) LIMIT 1";
        $incognitas = array("pgr" => $contenido["pregunta"], "rpt" => $contenido["respuesta"], "enl" => $contenido["preguntaEnlace"]);
        $this->objQuery->ejecutarConsulta($sql_registrarPregunta, $incognitas);
    }
}
