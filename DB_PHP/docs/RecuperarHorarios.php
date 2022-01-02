<?php

function RecuperarHorarios(PDO $Conexion)
{
    $archivo = file("docs/HorariosSesionesGrupo_Licenciatura.txt");
    $saltado = false;

    //Querys
    $sqlInsert = "INSERT INTO horarios (IDGrupo, Dia, HoraInicioHorario, HoraFinHorario, IDSalon) VALUES (?, ?, ?, ?, ?);";
    $sqlrecuperarIDProfesor = "SELECT IDProfesor FROM academicos WHERE ClaveProfesor=?";

    $sqlrecuperarIDPlanAsig = "SELECT IDPlanEstudio FROM planesdeestudio WHERE ClavePlan=? AND VersionPlan=?";
    $sqlrecuperarIDAsignatura = "SELECT IDAsignatura FROM asignaturas WHERE ClaveAsignatura=? AND IDPlanEstudio=?";

    $sqlrecuperarIDGrupo = "SELECT IDGrupo FROM grupos WHERE ClaveGrupo=? AND IDProfesor=? AND IDAsignatura=?";

    $sqlrecuperarEdificio = "SELECT IDEdificio FROM edificios WHERE NombreEdificio=?";
    $sqlrecuperarSalon = "SELECT IDSalon FROM salones WHERE NombreSalon=? AND IDEdificio=?";

    //Objetos de recuperación
    $obj_recuperarIDProfesor = $Conexion->prepare($sqlrecuperarIDProfesor);

    $obj_recuperarIDPlanAsig = $Conexion->prepare($sqlrecuperarIDPlanAsig);
    $obj_recuperarIDAsignatura = $Conexion->prepare($sqlrecuperarIDAsignatura);

    $obj_recuperarIDGrupo = $Conexion->prepare($sqlrecuperarIDGrupo);

    $obj_recuperarEdificio = $Conexion->prepare($sqlrecuperarEdificio);
    $obj_recuperarSalon = $Conexion->prepare($sqlrecuperarSalon);

    $obj_insert = $Conexion->prepare($sqlInsert);

    $horarios = array();

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }

        $data = explode("|", utf8_encode($linea));

        $obj_recuperarEdificio->execute(array($data[9]));
        $IDEdificio = $obj_recuperarEdificio->fetch(PDO::FETCH_ASSOC);

        if (isset($IDEdificio["IDEdificio"])) {
            $obj_recuperarIDProfesor->execute(array($data[3]));
            $IDProfesor = $obj_recuperarIDProfesor->fetch(PDO::FETCH_ASSOC);

            $obj_recuperarIDPlanAsig->execute(array($data[0], $data[1]));
            $IDPlanAsignatura = $obj_recuperarIDPlanAsig->fetch(PDO::FETCH_ASSOC);
            $obj_recuperarIDAsignatura->execute(array($data[2], $IDPlanAsignatura["IDPlanEstudio"]));

            $IDAsignatura = $obj_recuperarIDAsignatura->fetch(PDO::FETCH_ASSOC);
            $obj_recuperarIDGrupo->execute(array($data[4], $IDProfesor["IDProfesor"], $IDAsignatura["IDAsignatura"]));

            $obj_recuperarSalon->execute(array($data[10], $IDEdificio["IDEdificio"]));
            $IDGrupo = $obj_recuperarIDGrupo->fetch(PDO::FETCH_ASSOC);
            $IDSalon = $obj_recuperarSalon->fetch(PDO::FETCH_ASSOC);

            if (isset($IDSalon["IDSalon"]) && isset($IDGrupo["IDGrupo"])) {
                $obj_insert->execute(array($IDGrupo["IDGrupo"], $data[6], $data[7], $data[8], $IDSalon["IDSalon"]));
            }
        }
    }
}
