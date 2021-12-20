<?php
    session_start();
        if(isset($_SESSION['nombreExterno']) && isset($_SESSION['apellidosExterno']) && isset($_SESSION['empresa']) && isset($_SESSION['correoExterno'])){
            $idExterno = (int) random_int(0, 99);
            $nombreExterno = $_SESSION['Nombre'];
            $apellidosExterno = $_SESSION['Apellidos'];
            $empresa = $_SESSION['Empresa'];
            $correoExterno = $_SESSION['Correo'];
            
            $sql_registrar_externo = "INSERT INTO 'externos' ('IDExterno', 'NombreExterno', 'ApellidosExterno', 'Empresa', 'CorreoExterno') VALUES ($idExterno, '$nombreExterno', '$apellidosExterno', '$empresa', '$correoExterno')";
            $sql_reservacion_externo = "";

            $estado_obj = $DB_CONEXION->prepare($sql_registrar_externo);
            $estado_obj->execute(array("$idExterno", "$nombreExterno", "$apellidosExterno", "$empresa", "$correoExterno"));
            $datos = $estado_obj->fetch(PDO::FETCH_ASSOC);
            
        }else{
            /*
            Hay que revisar qué acción hay que realizar en caso de no existir una sesión de externo previa (¿Devolver a vista RegistroExterno?)
            */
        }
?>