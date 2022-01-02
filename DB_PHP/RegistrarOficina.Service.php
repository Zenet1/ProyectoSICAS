<?php
    session_start();
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";
    $json = file_get_contents('php://input');
    $datos = json_decode($json);
    
    insertarOficina((array)$datos, $DB_CONEXION);

    function insertarOficina(array $oficina, PDO $Conexion) : void{
        $sql_insertarOficina = "INSERT INTO oficinas (NombreOficina, Departamento, IDEdificio) VALUES (?, ?, ?)";

        $sql_recuperarIDEdificio = "SELECT IDEdificio FROM edificios WHERE NombreEdificio = ?";

        $obj_recuperarIDEdificio = $Conexion->prepare($sql_recuperarIDEdificio);
        $obj_insertarOficina = $Conexion->prepare($sql_insertarOficina);

        $obj_recuperarIDEdificio->execute(array($oficina["edificio"]));
        $IDEdificio = $obj_recuperarIDEdificio->fetch(PDO::FETCH_ASSOC);
        if(!validarOficinas($oficina, $IDEdificio, $Conexion)){
            if(isset($IDEdificio[0]["IDEdificio"])){
                $obj_insertarOficina->execute(array($oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"]));
            }
        }else{
            echo "error";
        }
    }

    function validarOficinas(array $oficina, array $IDEdificio, PDO $Conexion): bool
    {
        $existe = false;
        
        $sql_validarOficinasDuplicadas = "SELECT NombreOficina, Departamento, IDEdificio WHERE NombreOficina=? AND Departamento=? AND IDEdificio=?";

        $obj_validarOficinasDuplicadas = $Conexion->prepare($sql_validarOficinasDuplicadas);

        $obj_validarOficinasDuplicadas->execute(array($oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"]));

        $oficinaDuplicada = $obj_validarOficinasDuplicadas->fetch(PDO::FETCH_ASSOC);

        if(isset($oficinaDuplicada)){
            $existe = true;
        }else{
            $existe = false;
        }
        return $existe;
    }
?>