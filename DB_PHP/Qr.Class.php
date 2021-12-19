<?php
include 'phpqrcode/qrlib.php';
require "Email.Service.php";
$text = "Pichulita coquetona";

$path = 'img/';
$file = $path.uniqid().".png";

// Generates QR Code and Stores it in directory given
    QRcode::png($text, $file, $ecc, $pixel_Size, $frame_Size);

    class GeneradorQr{
        private $ecc;
        private $pixel_Size;
        private $frame_Size;
        private $path;
        private $file;

        public function __construct() {
            $this->ecc = 'Q';
            $this->pixel_Size = 10;
            $this->frame_Size = 3;
            $this->path = 'img/';
        }


        public function Generar($contenido) : void{
            QRcode::png($contenido,  $this->file, $this->ecc, $this->pixel_Size, $this->frame_Size);
        }

        public function setNombrePng($nombre){
            $this->file = $this->path . $nombre . ".png";
        }
    }

?>
