<?php

function RecuperarGrupos(PDO $Conexion)
{
    $archivo = file("docs/AlumnosCargaDeAsignaturas.txt");
    $saltado = false;

    //Querys
    $sqlInsert = "INSERT INTO grupos (IDAsignatura, IDProfesor, ClaveGrupo, Grupo) SELECT ?,:idP,:clG,:gP FROM DUAL WHERE NOT EXISTS (SELECT IDProfesor, ClaveGrupo, Grupo FROM grupos WHERE IDProfesor = :idP AND ClaveGrupo = :clG AND Grupo = :gP)LIMIT 1";

    $sqlrecuperarIDPlanAsig = "SELECT IDPlanEstudio FROM planesdeestudio WHERE ClavePlan=? AND VersionPlan=?";
    $sqlrecuperarCasig = "SELECT IDAsignatura FROM asignaturas WHERE ClaveAsignatura=? AND IDPlanEstudio = ?";

    $sqlrecuperarIprof = "SELECT IDProfesor FROM academicos WHERE ClaveProfesor=?";

    //Objetos de recuperación
    $obj_recuperarIDPlanAsig = $Conexion->prepare($sqlrecuperarIDPlanAsig);
    $obj_recuperarAsig = $Conexion->prepare($sqlrecuperarCasig);

    $obj_recuperarIprof = $Conexion->prepare($sqlrecuperarIprof);
    $obj_insert = $Conexion->prepare($sqlInsert);

    $grupos = array();

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }

        $data = explode("|", $linea);

        $obj_recuperarIDPlanAsig->execute(array($data[1], $data[2]));
        $IDPlan = $obj_recuperarIDPlanAsig->fetch(PDO::FETCH_ASSOC);
        $obj_recuperarAsig->execute(array($data[3], $IDPlan["IDPlanEstudio"]));

        $obj_recuperarIprof->execute(array($data[4]));

        $IDasig = $obj_recuperarAsig->fetch(PDO::FETCH_ASSOC);
        $IDprof = $obj_recuperarIprof->fetch(PDO::FETCH_ASSOC);

        if (!isset($grupos[$data[1] . $data[2] . $data[3] . $data[4] . $data[5]])) {
            $incognitas = array($IDasig["IDAsignatura"], "idP" => $IDprof["IDProfesor"], "clG" => $data[5], "gP" => $data[6]);
            $obj_insert->execute($incognitas);
            $grupos[$data[1] . $data[2] . $data[3] . $data[4] . $data[5]] = $data[1] . $data[2] . $data[3] . $data[4] . $data[5];
        }
    }
}
