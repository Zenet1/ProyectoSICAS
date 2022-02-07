<?php
require("phpqrcode/qrlib.php");

class GeneradorQr
{
    private $ecc;
    private $pixel_Size;
    private $frame_Size;
    private $path;
    private $file;

    public function __construct() {
        $this->ecc = 'Q';
        $this->pixel_Size = 10;
        $this->frame_Size = 5;
        $this->path = '../img/';
        $this->file;
    }

    public function GenerarImagen(string $contenido): void {
        QRcode::png($contenido,  $this->file, $this->ecc, $this->pixel_Size, $this->frame_Size);
    }

    public function setNombrePng(string $nombre) : void
    {
        $this->file = $this->path . $nombre . ".png";
    }
}
