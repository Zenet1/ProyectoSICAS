<?php
function RecuperarCargasAcademicas(PDO $Conexion)
{
    $archivo = file("docs/AlumnosCargaDeAsignaturas.txt");
    $saltado = false;

    $getIDalu = "SELECT IDAlumno FROM alumnos WHERE Matricula=?";
    $getIDgru = "SELECT IDGrupo FROM grupos AS GPS INNER JOIN asignaturas AS ASIG ON ASIG.IDAsignatura=GPS.IDIDAsignatura INNER JOIN planesdeestudio AS PLE ON PLE.IDPlanEstudio=ASIG.IDPlanEstudio WHERE GPS.ClaveGrupo=? AND GPS.IDProfesor=? AND ASIG.ClaveAsignatura=? AND PLE.ClavePlan=? AND PLE.VersionPlan=?";
    $getIDprof = "SELECT IDProfesor FROM academicos WHERE ClaveProfesor=?";

    $setcargas = "INSERT INTO cargaacademica (IDAlumno, IDGrupo) VALUES(:idA,:idG)";

    $getProf = $Conexion->prepare($getIDprof);
    $getalu = $Conexion->prepare($getIDalu);
    $getsgrup = $Conexion->prepare($getIDgru);
    $sethora = $Conexion->prepare($setcargas);

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }

        $data = explode("|",  utf8_encode($linea));
        
        $getalu->execute(array($data[0]));
        $getProf->execute(array($data[4]));

        $idprof = $getProf->fetch(PDO::FETCH_ASSOC);
        $idal = $getalu->fetch(PDO::FETCH_ASSOC);
        $getsgrup->execute(array($data[5], $idprof["IDProfesor"], $data[3], $data[5], $data[6]));
        $idgr = $getsgrup->fetch(PDO::FETCH_ASSOC);
        print_r(array($data[5], $idprof["IDProfesor"], $data[3], $data[5], $data[6]));
        //$incognitas = array("idA" => $idal["IDAlumno"], "idG" => $idgr["IDGrupo"]);
        //$sethora->execute($incognitas);
    }
}
