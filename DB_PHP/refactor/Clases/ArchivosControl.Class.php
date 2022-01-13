<?php

class ArchivoControl
{
    public static string $carpetaUnica;

    public function __construct(Fechas $fechaObj)
    {
        $carpetaRaiz = "backups/";
        self::$carpetaUnica = $carpetaRaiz . $fechaObj->FechaAct() . "_" . $fechaObj->HrAct();
        mkdir(self::$carpetaUnica);
    }

    public function MoverArchivos(string $PATH, int $CANTARCHIVOS)
    {
        for ($i = 0; $i < $CANTARCHIVOS; $i++) {
            $direccion = $PATH . $_FILES["archivo" . $i]["name"];
            move_uploaded_file($_FILES["archivo" . $i]["tmp_name"], $direccion);
        }
    }

    public function EliminarArchivos(string $PATH, string $extension)
    {
        foreach (scandir($PATH) as $archivo) {
            $direccion = $PATH . "/" . $archivo;
            if (is_file($direccion) && strpos($direccion, $extension)) {
                unlink($direccion);
            }
        }
    }

    public function TablaArchivo(String $NombreArchivo, string $extension, string $separador,  array $contenido)
    {
        
    }

    public function descargarArchivos(String $NombreArchivo, string $PATH, string $extension)
    {
        $direccionZip = $PATH . $NombreArchivo;
        $archivoZip = new ZipArchive();
        if ($archivoZip->open($direccionZip, ZipArchive::CREATE) === true) {
            foreach (scandir($PATH) as $archivo) {
                $direccion = $PATH . $archivo;
                if (is_file($PATH) && strpos($archivo, $extension) !== false) {
                    $archivoZip->addFile($direccion);
                }
            }
        }
        $archivoZip->close();
        $this->Descargar($direccionZip);
    }

    private function descargar(string $nombreArchivo)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/text');
        header('Content-Disposition: attachment; filename="' . basename($nombreArchivo . ".zip") . '"');
        header('Content-Length: ' . filesize($nombreArchivo));
        readfile($nombreArchivo);
    }

    function __destruct()
    {
        rmdir(self::$carpetaUnica . "/");
    }
}