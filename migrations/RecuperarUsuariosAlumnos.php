<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Content-Type: text/html; charset=UTF-8');
    header('Content-Type: text/html; charset=UTF-8');
    include "../DB_PHP/BD_Conexion_migrations.php";

    $archivo = file("bd_src/Licenciatura/AlumnosInscripcionEnPeriodoCurso.txt");
    $saltado = false;
    $sql_introducir_cuenta = "INSERT INTO usuarios (Cuenta, Contraseña, IDRol) VALUES (?,?,?)";

    foreach($archivo as $linea){
        if(!$saltado){
            $saltado = true;
            continue;
        }

        $datos = explode("|", utf8_encode($linea));
        $estado_obj = $DB_CONEXION->prepare($sql_introducir_cuenta);
        $verificacion = $estado_obj->execute(array("a".$datos[0],123,1));

        if(!esValido($verificacion)){
            echo "ERROR";
            break;
        }
    }
    function esValido($datos) : bool{
        return $datos != null && $datos != false;
    }
?>