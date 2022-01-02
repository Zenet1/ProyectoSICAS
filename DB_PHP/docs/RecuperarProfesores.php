<?php

function RecuperarProfesores(PDO $Conexion)
{
    $archivo = file("docs/ProfesoresConAlumnosInscritos.txt");
    $saltado = false;

    $sqlInsert = "INSERT INTO academicos (ClaveProfesor, NombreProfesor, ApellidoPaternoProfesor, ApellidoMaternoProfesor, GradoAcademico, CorreoProfesor) VALUES (?,?,?,?,?,?)";

    $obj_insert = $Conexion->prepare($sqlInsert);

    foreach ($archivo as $linea) {
        if (!$saltado) {
            $saltado = true;
            continue;
        }
        $data = explode("|", utf8_encode($linea));
        $verificacion = $obj_insert->execute(array($data[0], $data[1], $data[2], $data[3], $data[4], $data[5]));
        
    }
}


