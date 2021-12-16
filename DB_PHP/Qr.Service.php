<?php
    use chillerlan\QRCode\QRCode;
    use chillerlan\QRCode\QROptions;
    require 'vendor/autoload.php';
    require('Email.Service.php');

    $options = new QROptions(
      [
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        'version' => 5,
      ]
    );
    
    $qrcode = (new QRCode($options))->render('pichula coqueta');
    
    $correo = new CorreoManejador();
    $correo->EnviarCorreo("eduardzenet@outlook.com", "doexeo", "<img src='<?= $qrcode ?>' alt='QR Code' width='800' height='800'>" , $qrcode);
?>