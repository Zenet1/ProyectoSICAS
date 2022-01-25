<?php
include_once("./docs/RecuperarAlumnos.php");
include_once("./docs/RecuperarAsignaturas.php");
include_once("./docs/RecuperarCargasAcademicas.php");
include_once("./docs/RecuperarEdificiosLicenciatura.php");
include_once("./docs/RecuperarGrupos.php");
include_once("./docs/EstablecerPorcentaje.php");
include_once("./docs/RecuperarPersonal.php");
include_once("./docs/RecuperarHorarios.php");
include_once("./docs/RecuperarPlanEstudio.php");
include_once("./docs/RecuperarProfesores.php");
include_once("./docs/RecuperarSalones.php");
include_once("./docs/RecuperarUsuariosAlumnos.php");

class SICEIControl
{
    private PDO $conexion;
    private ArchivoControl $archivos;
    private array $archivosPrinc;
    private bool $personal;

    public function __construct(PDO $conexion, ArchivoControl $archivos)
    {
        $this->personal = false;
        $this->conexion = $conexion;
        $this->archivos = $archivos;
        $this->archivosPrinc = array("AlumnosCargaDeAsignaturas.txt", "AlumnosInscripcionEnPeriodoCurso.txt", "AsignaturasALasQueSeInscribieronAlumnos.txt", "HorariosSesionesGrupo.txt", "PlanesDeEstudios.txt", "ProfesoresConAlumnosInscritos.txt");
    }

    private function VerificarDatosRespaldo()
    {
        if (sizeof($this->archivosPrinc) > intval($_POST["numArchivos"])) {
            exit("Cantidad de archivos incorrectos");
        }

        $archivosSubidos = scandir("./" . $this->archivos::$carpetaUnica . "/");

        foreach ($this->archivosPrinc as $archivo) {
            if (!in_array($archivo, $archivosSubidos)) {
                exit("Algun archivo principal falta o el nombre no es posible reconocerlo");
            }

            if (in_array("administrativos.txt", $archivosSubidos)) {
                $this->personal = true;
            }
        }
    }

    public function RestaurarSICEI()
    {

        $this->archivos->MoverArchivos(intval($_POST["numArchivos"]));
        $this->VerificarDatosRespaldo();

        //RecuperarUsuariosAlumnos($this->conexion);
        //RecuperarEdificiosLicenciatura($this->conexion);
        //RecuperarSalones($this->conexion);
        //RecuperarPlanEstudio($this->conexion);
        //RecuperarAsignaturas($this->conexion);
        //RecuperarProfesores($this->conexion);
        //RecuperarAlumnos($this->conexion);
        //RecuperarGrupos($this->conexion);
        //RecuperarCargasAcademicas($this->conexion);
        //RecuperarHorarios($this->conexion);
        //InsertarPorcentaje($this->conexion);

        if ($this->personal) {
            RecuperarPersonal($this->conexion);
        }

        foreach (scandir($this->archivos::$carpetaUnica) as $archivo) {
            if (is_file($this->archivos::$carpetaUnica . "/" . $archivo) && strpos($archivo, ".txt") !== false) {
                unlink($this->archivos::$carpetaUnica . "/" . $archivo);
            }
        }
        rmdir($this->archivos::$carpetaUnica);
    }
}
