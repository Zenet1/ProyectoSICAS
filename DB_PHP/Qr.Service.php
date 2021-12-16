<?php
require 'Email.Service.php';
include "phpqrcode/qrlib.php";

try {
  //data to be stored in qr
  $contenido = "pichula coqueta 123 xd";
  $dir =  "images/";
  

  if(!file_exists($dir)){
    mkdir("images");
    echo "ERROR";
  } else {
    echo "EXISTE";
  }

  $filename = $dir."Test.png";

  $level = 'H';
  $tamaño = 10;
  $frame_size = 5;

  // Generates QR Code and Save as PNG
  QRcode::png($contenido, $filename, $level, $tamaño, $frame_size);

  // Displaying the stored QR code if you want
  echo "<img src='".$filename."' />";
  
} catch (Exception $e) {
  echo $e->getMessage();
}
//other parameters
