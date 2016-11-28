<?php
  include('php-barcode.php');

  // -------------------------------------------------- //
  //                  PROPERTIES
  // -------------------------------------------------- //
  
  // download a ttf font here for example : http://www.dafont.com/fr/nottke.font
  //$font     = './NOTTB___.TTF';
  // - -
  
  $fontSize = 10;   // GD1 in px ; GD2 in point
  $marge    = 10;   // between barcode and hri in pixel
  $x        = 450;  // barcode center
  $y        = 450;  // barcode center
  $height   = 200;   // barcode height in 1D ; module size in 2D
  $width    = 8;    // barcode height in 1D ; not use in 2D
  $angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
  
  $code     = (isset($_GET["ean"])?$_GET["ean"]:"0"); // barcode, of course ;)
  $type     = 'ean13';
  

  // -------------------------------------------------- //
  //            ALLOCATE GD RESSOURCE
  // -------------------------------------------------- //
  $im     = imagecreatetruecolor(900, 900);
  $black  = ImageColorAllocate($im,0x00,0x00,0x00);
  $white  = ImageColorAllocate($im,0xff,0xff,0xff);
  $red    = ImageColorAllocate($im,0xff,0x00,0x00);
  $blue   = ImageColorAllocate($im,0x00,0x00,0xff);
  imagefilledrectangle($im, 0, 0, 900, 900, $white);
  
  // -------------------------------------------------- //
  //                      BARCODE
  // -------------------------------------------------- //
  $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
  
  // -------------------------------------------------- //
  //                        HRI
  // -------------------------------------------------- //
  if ( isset($font) ){
    $box = imagettfbbox($fontSize, 0, $font, $data['hri']);
    $len = $box[2] - $box[0];
    Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
    imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $blue, $font, $data['hri']);
  }
  // -------------------------------------------------- //
  //                    GENERATE
  // -------------------------------------------------- //
  header('Content-type: image/gif');
  imagegif($im);
  imagedestroy($im);
var_dump($_GET);
var_dump($code);
?>