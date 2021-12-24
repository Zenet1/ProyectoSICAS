<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    include "../DB_PHP/BD_Conexion_migrations.php";

    $archivo = file("bd_src/Licenciatura/HorariosSesionesGrupo_Licenciatura.txt");
    $saltado = false;

    $sqlInsert = "INSERT INTO sicas_test.horarios (IDGrupo, Dia, HoraInicioHorario, HoraFinHorario, IDSalon) VALUES (?, ?, ?, ?, ?, ?);";
    $sqlrecuperarIDGrupo = "SELECT IDGrupo FROM grupos WHERE ClaveGrupo=?";
    $sqlrecuperarEdificio = "SELECT IDEdificio FROM edificios WHERE NombreEdificio=?";
    $sqlrecuperarSalon = "SELECT IDSalon FROM salones WHERE NombreSalon=? AND IDEdificio=?";

    $obj_recuperarIDGrupo = $DB_CONEXION->prepare($sqlrecuperarIDGrupo);
    $obj_recuperarEdificio = $DB_CONEXION->prepare($sqlrecuperarEdificio);
    $obj_recuperarSalon = $DB_CONEXION->prepare($sqlrecuperarSalon);
    $obj_insert = $DB_CONEXION->prepare($sqlInsert);

    $horarios = array();

    foreach($archivo as $linea){
        if(!$saltado){
            $saltado = true;
            continue;
        }

        $data = explode("|", utf8_encode($linea));

        $obj_recuperarIDGrupo->execute(array($data[4]));
        $obj_recuperarEdificio->execute(array($data[9]));
        $IDEdificio = $obj_recuperarEdificio->fetch(PDO::FETCH_ASSOC);
        
        if(isset($IDEdificio["IDEdificio"])){
            $obj_recuperarSalon->execute(array($data[10], $IDEdificio["IDEdificio"]));
            $IDGrupo = $obj_recuperarIDGrupo->fetch(PDO::FETCH_ASSOC);
            $IDSalon = $obj_recuperarSalon->fetch(PDO::FETCH_ASSOC);
            if(isset($IDSalon["IDSalon"])){
                $obj_insert->execute(array($IDGrupo["IDGrupo"], $data[6], $data[7], $data[8], $IDSalon["IDSalon"]));
            }
        }else{
            continue;
        }
    }
?>