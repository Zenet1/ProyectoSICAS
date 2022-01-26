<?php

function RecuperarPersonal(string $carpeta, PDO $Conexion)
{
    $archivo = file("$carpeta/administrativos.txt");
    $saltado = false;

    $sql_insertarUsuario = "INSERT INTO usuarios (Cuenta,IDRol) SELECT :cnt,:idr FROM DUAL WHERE NOT EXISTS (SELECT Cuenta FROM usuarios WHERE Cuenta=:cnt) LIMIT 1";

    $sql_insertarPersonal = "INSERT INTO personal (IDUsuario,Nombres,Apellidos,CorreoPersonal,ClavePersonal) SELECT :idu,:nom,:ape,:cor,:clp FROM DUAL WHERE NOT EXISTS (SELECT ClavePersonal FROM personal WHERE ClavePersonal=:clp) LIMIT 1";

    $sql_recuperarIDUsu = "SELECT IDUsuario FROM usuarios WHERE Cuenta=:cnt";

    $objInsertusu = $Conexion->prepare($sql_insertarUsuario);
    $objInsertper = $Conexion->prepare($sql_insertarPersonal);
    $objRecuperar = $Conexion->prepare($sql_recuperarIDUsu);

    foreach ($archivo as $linea) {
        $data = explode("|", $linea);

        if (!$saltado) {
            $saltado = true;
            continue;
        }

        if ($data[2] === "" || $data[3] === "" || $data[4] === "") {
            continue;
        }

        $incognitasUsuario = array("cnt" => trim($data[4]), "idr" => 4);
        $objInsertusu->execute($incognitasUsuario);
        $objRecuperar->execute(array("cnt" => trim($data[4])));
        $idusuario = $objRecuperar->fetch(PDO::FETCH_ASSOC);

        $incognitasPer = array("idu" => $idusuario["IDUsuario"], "nom" => $data[0], "ape" => $data[1], "cor" => $data[2], "clp" => $data[3]);
        $objInsertper->execute($incognitasPer);
    }
}
