<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
include 'BD_Conexion.php';
include 'docs/RecuperarAlumnos.php';
include 'docs/RecuperarAsignaturas.php';
include 'docs/RecuperarCargasAcademicas.php';
include 'docs/RecuperarEdificiosLicenciatura.php';
include 'docs/RecuperarGrupos.php';
include 'docs/RecuperarHorarios.php';
include 'docs/RecuperarPlanEstudio.php';
include 'docs/RecuperarProfesores.php';
include 'docs/RecuperarSalones.php';
include 'docs/RecuperarUsuariosAlumnos.php';



$numArchivos = intval($_POST["numArchivos"]);

for ($i = 0; $i < $numArchivos; $i++) {
    move_uploaded_file($_FILES["archivo" . $i]["tmp_name"], "docs/" . $_FILES["archivo" . $i]["name"]);
}

RecuperarUsuariosAlumnos($DB_CONEXION);
RecuperarEdificiosLicenciatura($DB_CONEXION);
RecuperarSalones($DB_CONEXION);
RecuperarPlanEstudio($DB_CONEXION);
RecuperarAsignaturas($DB_CONEXION);
RecuperarProfesores($DB_CONEXION);
RecuperarAlumnos($DB_CONEXION);
RecuperarGrupos($DB_CONEXION);
RecuperarCargasAcademicas($DB_CONEXION);
RecuperarHorarios($DB_CONEXION);

foreach (scandir('docs/') as $archivo) {
    if (is_file('docs/' . $archivo) && strpos($archivo, ".txt") !== false) {
        unlink("docs/" . $archivo);
    }
}
