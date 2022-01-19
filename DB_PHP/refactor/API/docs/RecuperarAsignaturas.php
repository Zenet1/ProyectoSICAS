<?php
function RecuperarAsignaturas(PDO $Conexion)
{
    $archivo = file("docs/AsignaturasALasQueSeInscribieronAlumnos.txt");
    $saltado = false;
    $insertar = "INSERT INTO asignaturas (ClaveAsignatura, NombreAsignatura, IDPlanEstudio) SELECT :clv,:nom,:idp FROM DUAL WHERE NOT EXISTS (SELECT ClaveAsignatura, NombreAsignatura, IDPlanEstudio FROM asignaturas WHERE ClaveAsignatura=:clv AND NombreAsignatura=:nom AND IDPlanEstudio=:idp) LIMIT 1";
    $recuperar = "SELECT IDPlanEstudio FROM planesdeestudio WHERE ClavePlan=? AND VersionPlan=?";
    $insertar_obj = $Conexion->prepare($insertar);
    $recuperar_obj = $Conexion->prepare($recuperar);

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }

        $datos = explode("|", $linea);
        $recuperar_obj->execute(array($datos[0], $datos[1]));
        $IDEstudio = $recuperar_obj->fetch(PDO::FETCH_ASSOC);
        $incognitas = array("clv" => $datos[2], "nom" => trim($datos[3]), "idp" => $IDEstudio["IDPlanEstudio"]);
        $insertar_obj->execute($incognitas);
    }
}
