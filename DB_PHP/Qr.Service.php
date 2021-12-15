<?php
    use chillerlan\QRCode\QRCode;
    use chillerlan\QRCode\QROptions;
    
    require 'vendor/autoload.php';
    
    $options = new QROptions(
      [
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        'version' => 5,
      ]
    );
    
    $qrcode = (new QRCode($options))->render('pichula coqueta');
?>