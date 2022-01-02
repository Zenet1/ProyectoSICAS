<?php
function RecuperarCargasAcademicas(PDO $Conexion)
{
    $archivo = file("docs/AlumnosCargaDeAsignaturas.txt");
    $saltado = false;

    $getIDalu = "SELECT IDAlumno FROM alumnos WHERE Matricula=?";
    $getIDgru = "SELECT IDGrupo FROM grupos WHERE ClaveGrupo=? AND IDProfesor=?";
    $getIDprof = "SELECT IDProfesor FROM academicos WHERE ClaveProfesor=?";

    $setcargas = "INSERT INTO cargaacademica (IDAlumno, IDGrupo) VALUES (?,?)";

    $getProf = $Conexion->prepare($getIDprof);
    $getalu = $Conexion->prepare($getIDalu);
    $getsgrup = $Conexion->prepare($getIDgru);
    $sethora = $Conexion->prepare($setcargas);

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }
        $data = explode("|", $linea);

        $getalu->execute(array($data[0]));
        $getProf->execute(array($data[4]));

        $idprof = $getProf->fetch(PDO::FETCH_ASSOC);
        $idal = $getalu->fetch(PDO::FETCH_ASSOC);

        if (isset($idprof["IDProfesor"])) {
            $getsgrup->execute(array($data[5], $idprof["IDProfesor"]));
            $idgr = $getsgrup->fetch(PDO::FETCH_ASSOC);
            $sethora->execute(array($idal["IDAlumno"], $idgr["IDGrupo"]));
        }
    }
}
