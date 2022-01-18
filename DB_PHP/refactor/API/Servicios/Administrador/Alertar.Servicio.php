<?php
include_once("Alertar.Query.php");

class Alertar
{
    private Query $objQuery;
    private AlertaQuery $objAleQ;
    private CorreoManejador $correo;

    public function __construct(Query $objQuery, CorreoManejador $correo)
    {
        $this->objQuery = $objQuery;
        $this->objAleQ = new AlertaQuery();
        $this->correo = $correo;
    }

    public function Alertar(array $contenido)
    {
        //print_r($contenido);
    }

    public function obtenerAfectados(array $contenido)
    {
        $fechas = $this->ObtenerFechas($contenido);
        if (sizeof($fechas) === 0) {
            echo "no valido";
            exit();
        }
        $gruposFiltrados = array();
        $alumnosFiltrados = array();
        $profesoresFiltrados = array();

        foreach ($fechas as $FECHA) {
            $incognitas = array("mat" => $contenido["matricula"], "fch" => $FECHA["FechaAl"]);
            $gruposFiltrados = $this->ObtenerDatosUnicos($this->objAleQ->CargasAcademicas(), $gruposFiltrados, $incognitas);
        }

        foreach ($gruposFiltrados as $GRUPO) {
            $incognitaAl = array("mat" => $contenido["matricula"], "fch" => $GRUPO["FechaReservaAl"], "idg" => $GRUPO["IDGrupo"]);
            $incognitaProf = array("idg" => $GRUPO["IDGrupo"]);

            $profesoresFiltrados = $this->ObtenerDatosUnicos($this->objAleQ->ObtenerProf(), $profesoresFiltrados, $incognitaProf);

            $alumnosFiltrados = $this->ObtenerDatosUnicos($this->objAleQ->ObtenerInvol(), $alumnosFiltrados, $incognitaAl);
        }

        $this->EnviarCorreo($profesoresFiltrados, $gruposFiltrados);
        $this->EnviarCorreo($alumnosFiltrados, $gruposFiltrados);
    }

    private function ObtenerDatosUnicos(string $sql, array $datosFiltrados, array $datos): array
    {
        $resultado = $this->objQuery->ejecutarConsulta($sql, $datos);
        return $this->Filtrar($resultado, $datosFiltrados);
    }


    private function Filtrar(array $datoCrudo, array $datosFiltrados)
    {
        foreach ($datoCrudo as $DATO) {
            if (!in_array($DATO, $datosFiltrados)) {
                $datosFiltrados[] = array_shift($datoCrudo);
            } else {
                array_shift($datoCrudo);
            }
        }
        return $datosFiltrados;
    }

    private function EnviarCorreo(array $datosUnicos, array $grupos)
    {
        $FormatoDestinatario = array();

        $asunto = "Posible contagio";
        $mensaje = "Buen dia, el objetivo de este correo es informarle que se a notificado un caso de COVID 19";
        $mensaje .= ", y debido que se ha detectado que has estado presente en uno de los siguientes asignaturas <ul>";
        $gruposAfectados = "";

        foreach ($grupos as $GRUPO) {
            $gruposAfectados .= "<li>" . $GRUPO["NombreAsignatura"] . "</li><br>";
        }

        $mensaje .= $gruposAfectados . "</ul>";
        $mensaje .= "Por lo que se recomienda monitorear tu salud por un posible contagio.";
        
        echo $mensaje;

        foreach ($datosUnicos as $DATO) {
            $NombreCompleto = $DATO["NOMBRE"] . " ";
            $NombreCompleto .= $DATO["APELLIDOP"] . " ";
            $NombreCompleto .= $DATO["APELLIDOM"];
            $FormatoDestinatario[trim($DATO["CORREO"])] = trim($NombreCompleto);
        }

        //$this->correo->EnviarCorreo($FormatoDestinatario, $asunto, $mensaje);
    }

    private function ObtenerFechas(array $contenido)
    {
        $incognitas = array("mat" => $contenido["matricula"], "fchIn" => $contenido["fechaInicio"], "fchFn" => $contenido["fechaFin"]);
        return $this->objQuery->ejecutarConsulta($this->objAleQ->ObtenerAsistencias(), $incognitas);
    }
}
