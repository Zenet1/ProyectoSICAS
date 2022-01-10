<?php

function RecuperarGrupos(PDO $DB_CONEXION){
    
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    //include "EsValido.php";
    include "BD_Conexion.php";

    $archivo = file("docs/AlumnosCargaDeAsignaturas.txt");
    $saltado = false;

    //Querys
    $sqlInsert = "INSERT INTO grupos (IDAsignatura, IDProfesor, ClaveGrupo, Grupo) VALUES (?,?,?,?)";

    $sqlrecuperarIDPlanAsig = "SELECT IDPlanEstudio FROM planesdeestudio WHERE ClavePlan=? AND VersionPlan=?";
    $sqlrecuperarCasig = "SELECT IDAsignatura FROM asignaturas WHERE ClaveAsignatura=? AND IDPlanEstudio = ?";
    
    $sqlrecuperarIprof = "SELECT IDProfesor FROM academicos WHERE ClaveProfesor=?"; 

    //Objetos de recuperación
    $obj_recuperarIDPlanAsig = $DB_CONEXION->prepare($sqlrecuperarIDPlanAsig);
    $obj_recuperarAsig = $DB_CONEXION->prepare($sqlrecuperarCasig);

    $obj_recuperarIprof = $DB_CONEXION->prepare($sqlrecuperarIprof);
    $obj_insert = $DB_CONEXION->prepare($sqlInsert);

    $grupos = array();

    foreach($archivo as $linea){
        if(!$saltado){
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

        if(!isset($grupos[$data[1] . $data[2] . $data[3] . $data[4] . $data[5]])){
            $obj_insert->execute(array($IDasig["IDAsignatura"], $IDprof["IDProfesor"], $data[5], $data[6]));
            $grupos[$data[1] . $data[2] . $data[3] . $data[4] . $data[5]] = $data[1] . $data[2] . $data[3] . $data[4] . $data[5];
        }
    }
}
    
?>