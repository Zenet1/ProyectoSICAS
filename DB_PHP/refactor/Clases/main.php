<?php
include 'Query.Class.php';

$sql_verificarReservaAlumno = "SELECT ALM.NombreAlumno,ALM.ApellidoPaternoAlumno,ALM.ApellidoMaternoAlumno FROM reservacionesalumnos AS RSAL
        INNER JOIN cargaacademica AS CGAC
        ON CGAC.IDCarga=RSAL.IDCarga
        INNER JOIN alumnos AS ALM
        ON CGAC.IDAlumno=ALM.IDAlumno
        WHERE CGAC.IDAlumno=? AND RSAL.IDReservaAlumno=? AND RSAL.FechaReservaAl=?";

$a = "SELECT ALM.NombreAlumno,ALM.ApellidoPaternoAlumno,ALM.ApellidoMaternoAlumno FROM reservacionesalumnos AS RSAL INNER JOIN alumnos AS ALM ON CGAC.IDAlumno=ALM.IDAlumno INNER JOIN cargaacademica AS CGAC ON RSAL.IDCarga=CGAC.IDCarga WHERE CGAC.IDAlumno=?RSAL.IDReservaAlumno=? AND RSAL.FechaReservaAl=?";

$queryhandler = new Query();

$condRes  = array("IDReservaAlumno=", "FechaReservaAl=");
$caracRes = array("ALIAS" => "RSAL", "TABLA" => "reservacionesalumnos", "DESDE" => "si");

$inCarg = array("UNIR" => "reservacionesalumnos", "CON" => "IDCarga");
$condCarg = array("IDAlumno=");
$caracCarg = array("ALIAS" => "CGAC", "TABLA" => "cargaacademica");

$datosAlm = array("NombreAlumno", "ApellidoPaternoAlumno", "ApellidoMaternoAlumno");
$inAlm = array("UNIR" => "cargaacademica", "CON" => "IDAlumno");
$caracAlum = array("ALIAS" => "ALM", "TABLA" => "alumnos");

$Formato["alumnos"] = array("CARAC" => $caracAlum, "DATOS" => $datosAlm, "UNIR" => $inAlm);
//$Formato["cargaacademica"] = array("CARAC" => $caracCarg, "COND" => $condCarg, "UNIR" => $inCarg);
//$Formato["reservacionesalumnos"] = array("CARAC" => $caracRes, "COND" => $condRes);

$resultado = $queryhandler->INSERT($Formato, array(870, 1, "2022-01-10"));