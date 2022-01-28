<?php
include_once("Alertar.Query.php");

class Alertar
{
    private Query $objQuery;
    private AlertaQuery $objAleQ;
    private CorreoManejador $correo;
    private Fechas $fecha;

    public function __construct(Query $objQuery, CorreoManejador $correo, Fechas $fecha)
    {
        $this->objQuery = $objQuery;
        $this->objAleQ = new AlertaQuery();
        $this->correo = $correo;
        $this->fecha = $fecha;
    }

    public function alertar(array $contenido)
    {
        //print_r($contenido);
    }

    public function obtenerAfectados(array $contenido)
    {
        $listaFechas = $this->obtenerFechas($contenido);

        if (sizeof($listaFechas) === 0) {
            exit();
        }
        $gruposFiltrados = array();
        $alumnosFiltrados = array();
        $profesoresFiltrados = array();

        foreach ($listaFechas as $fecha) {
            $incognitas = array("mat" => $contenido["matricula"], "fch" => $fecha["FechaAl"]);
            $gruposFiltrados = $this->obtenerDatosUnicos($this->objAleQ->CargasAcademicas(), $gruposFiltrados, $incognitas);
        }

        foreach ($gruposFiltrados as $grupo) {
            $incognitaAlumno = array("mat" => $contenido["matricula"], "fch" => $grupo["FechaReservaAl"], "idg" => $grupo["IDGrupo"]);
            $incognitaProfesor = array("idg" => $grupo["IDGrupo"]);

            $alumnosFiltrados = $this->obtenerDatosUnicos($this->objAleQ->ObtenerInvol(), $alumnosFiltrados, $incognitaAlumno);
            $profesoresFiltrados = $this->obtenerDatosUnicos($this->objAleQ->ObtenerProf(), $profesoresFiltrados, $incognitaProfesor);
        }

        //$this->EnviarCorreo($profesoresFiltrados, $gruposFiltrados);
        //$this->EnviarCorreo($alumnosFiltrados, $gruposFiltrados);

        $this->insertarIncidentados($contenido["matricula"], $alumnosFiltrados, $contenido["fechaSuspension"], $contenido["fechaSospechosos"]);

        $datosEnviar["usuarios"] = sizeof($profesoresFiltrados) + sizeof($alumnosFiltrados);
        $datosEnviar["grupos"] = $gruposFiltrados;

        echo json_encode($datosEnviar);
    }

    private function obtenerFechas(array $contenido)
    {
        $incognitas = array("mat" => $contenido["matricula"], "fchIn" => $contenido["fechaInicio"], "fchFn" => $contenido["fechaFin"]);
        return $this->objQuery->ejecutarConsulta($this->objAleQ->ObtenerAsistencias(), $incognitas);
    }

    private function obtenerDatosUnicos(string $sql, array $datosFiltrados, array $datos) : array
    {
        $resultado = $this->objQuery->ejecutarConsulta($sql, $datos);
        return $this->filtrar($resultado, $datosFiltrados);
    }

    private function filtrar(array $datoCrudo, array $datosFiltrados)
    {
        foreach ($datoCrudo as $dato) {
            if (!in_array($dato, $datosFiltrados)) {
                $datosFiltrados[] = array_shift($datoCrudo);
            } else {
                array_shift($datoCrudo);
            }
        }
        return $datosFiltrados;
    }

    private function enviarCorreo(array $datosUnicos, array $grupos)
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

        foreach ($datosUnicos as $DATO) {
            $NombreCompleto = $DATO["NOMBRE"] . " ";
            $NombreCompleto .= $DATO["APELLIDOP"] . " ";
            $NombreCompleto .= $DATO["APELLIDOM"];
            $FormatoDestinatario[trim($DATO["CORREO"])] = trim($NombreCompleto);
        }

        //$this->correo->EnviarCorreo($FormatoDestinatario, $asunto, $mensaje);
    }

    private function insertarIncidentados(string $matriculaAlumnoPortador, array $listaAlumnos, string $fechaSuspension, string $fechaSospechosos){
        $this->insertarAlumnoIncidentado($matriculaAlumnoPortador, $fechaSuspension);

        foreach($listaAlumnos as $alumnoSospechoso){
            $this->insertarAlumnoIncidentado($alumnoSospechoso["Matricula"], $fechaSospechosos);
        }
    }

    private function insertarAlumnoIncidentado(string $matricula, string $fechaSuspension) : void
    {
        $IDAlumno = $this->recuperarAlumno($matricula);
        $incognitas = array("ida" => $IDAlumno, "fchA" => $this->fecha->FechaAct(), "fchL" => $fechaSuspension);
        
        $this->objQuery->ejecutarConsulta($this->objAleQ->AgregarIncidente(), $incognitas);
    }

    private function recuperarAlumno(string $matricula) : string
    {
        $sql_recuperarIDAlumno = "SELECT IDAlumno FROM alumnos WHERE Matricula = ?";
        $IDAlumno = $this->objQuery->ejecutarConsulta($sql_recuperarIDAlumno, array($matricula));

        return $IDAlumno[0]["IDAlumno"];
    }
}