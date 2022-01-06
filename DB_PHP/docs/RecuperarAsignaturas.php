<?php
function RecuperarAsignaturas(PDO $Conexion)
{
    $archivo = file("docs/AsignaturasALasQueSeInscribieronAlumnos.txt");
    $saltado = false;
    $insertar = "INSERT INTO asignaturas (ClaveAsignatura, NombreAsignatura, IDPlanEstudio) SELECT :clv,?,? FROM DUAL WHERE NOT EXISTS (SELECT ClaveAsignatura FROM asistencia WHERE ClaveAsignatura=:clv) LIMIT 1";
    $recuperar = "SELECT IDPlanEstudio FROM planesdeestudio WHERE ClavePlan=? AND VersionPlan=?";
    $insertar_obj = $Conexion->prepare($insertar);
    $recuperar_obj = $Conexion->prepare($recuperar);

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }

        $datos = explode("|", wordwrap(utf8_encode($linea)));
        $recuperar_obj->execute(array($datos[0], $datos[1]));
        $IDFeature = $recuperar_obj->fetch(PDO::FETCH_ASSOC);
        $incognitas = array("clv" => $datos[2], $datos[3], $IDFeature["IDPlanEstudio"]);
        $insertar_obj->execute($incognitas);
    }
}
