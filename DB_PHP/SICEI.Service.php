<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$numArchivos = intval($_POST["numArchivos"]);

for ($i = 0; $i < $numArchivos; $i++) {
    move_uploaded_file($_FILES["archivo" . $i]["tmp_name"], "docs/" . $_FILES["archivo" . $i]["name"]);
}
