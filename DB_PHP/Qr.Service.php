<?php
include 'phpqrcode/qrlib.php';
require "Email.Service.php";
$text = "Pichulita coquetona";

$path = 'img/';
$file = $path.uniqid().".png";
  
// $ecc stores error correction capability('L')
$ecc = 'M';
$pixel_Size = 10;
$frame_Size = 10;
  
// Generates QR Code and Stores it in directory given
QRcode::png($text, $file, $ecc, $pixel_Size, $frame_Size);

$corre = new CorreoManejador();
$corre->setArchivo(true);
$corre->EnviarCorreo("eduardzenet@outlook.com","doxeo con png","pichulin pichulon", $file);

// Displaying the stored QR code from directory
echo "<center><img src='".$file."'></center>";
?>
