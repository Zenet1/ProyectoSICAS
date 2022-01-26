<?php
session_start();
include_once("Autenticacion.Query.php");

class Autenticar
{
    private Query $objQuery;
    private AutentcacionQuery $objAunQ;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
        $this->objAunQ = new AutentcacionQuery();
    }

    public function ValidarCuenta(array $contenido)
    {
        $incognitas = array("ctn" => $contenido["usuario"], "pss" => $contenido["contrasena"]);
        $resultado = $this->objQuery->ejecutarConsulta($this->objAunQ->VerificarLocal(), $incognitas);

        if (sizeof($resultado) !== 0) {
            $this->ObtenerDatosPorRol($resultado[0]);
            $_SESSION["Conexion"] = $contenido["facultad"];
            $CuentaUsuario = array("Cuenta" => $resultado[0]["Cuenta"], "Rol" => $resultado[0]["Rol"]);
            echo json_encode($CuentaUsuario);
            exit();
        }
        exit("Sin cuenta valida");
    }

    private function ObtenerDatosPorRol(array $datos)
    {
        switch ($datos["Rol"]) {
            case "Alumno":
                $this->AlumnosDatos($datos);
                break;
            case "Personal":
                $this->PersonalDatos($this->objAunQ->DatosPersonal(), $datos);
                break;
            case "Profesor":
                $this->PersonalDatos($this->objAunQ->DatosProfesor(), $datos);
                break;
        }
    }

    private function AlumnosDatos(array $datosCuenta)
    {
        $incognitas = array("idu" => $datosCuenta["IDUsuario"]);
        $resultado = $this->objQuery->ejecutarConsulta($this->objAunQ->DatosAlumno(), $incognitas);

        $nombreCompleto = $resultado[0]["NombreAlumno"] . " ";
        $nombreCompleto .= $resultado[0]["ApellidoPaternoAlumno"] . " ";
        $nombreCompleto .= $resultado[0]["ApellidoMaternoAlumno"];

        $_SESSION["Nombre"] = $nombreCompleto;
        $_SESSION["IDAlumno"] = $resultado[0]["IDAlumno"];
        $_SESSION["Matricula"] = $resultado[0]["Matricula"];
        $_SESSION["Correo"] = $resultado[0]["CorreoAlumno"];
    }

    private function PersonalDatos(string $sql, array $datosCuenta)
    {
        $incognitas = array("idu" => $datosCuenta["IDUsuario"]);
        $resultado = $this->objQuery->ejecutarConsulta($sql, $incognitas);

        $nombreCompleto = $resultado[0]["NOMBRE"] . " " . $resultado[0]["APP"];
        $_SESSION["Correo"] = $resultado[0]["CORREO"];
        $_SESSION["NombrePersonal"] = $nombreCompleto;
        $_SESSION["ID"] = $resultado[0]["ID"];
    }
}
