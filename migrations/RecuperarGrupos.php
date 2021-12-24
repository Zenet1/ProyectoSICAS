<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    include "../DB_PHP/BD_Conexion.php";

    $archivo = file("bd_src/Licenciatura/AlumnosCargaDeAsignaturas.txt");
    $saltado = false;

    $sqlInsert = "INSERT INTO sicas_test.grupos (IDAsignatura, IDProfesor, ClaveGrupo, Grupo) VALUES (?,?,?,?)";
    $sqlrecuperarCasig = "SELECT IDAsignatura FROM asignaturas WHERE ClaveAsignatura=?";
    $sqlrecuperarIprof = "SELECT IDProfesor FROM academicos WHERE ClaveProfesor=?"; 

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

        $obj_recuperarAsig->execute(array($data[3]));
        $obj_recuperarIprof->execute(array($data[4]));

        $IDasig = $obj_recuperarAsig->fetch(PDO::FETCH_ASSOC);
        $IDprof = $obj_recuperarIprof->fetch(PDO::FETCH_ASSOC);

        if(!isset($grupos[$data[3] . $data[4] . $data[5]])){
            $obj_insert->execute(array($IDasig["IDAsignatura"], $IDprof["IDProfesor"], $data[5], $data[6]));
            $grupos[$data[3] . $data[4] . $data[5]] = $data[3] . $data[4] . $data[5];
        }
    }
    print_r($grupos);
    function esValido($datos) : bool{
        return $datos != null && $datos != false;
    }
?>