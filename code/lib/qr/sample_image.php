<?php
require_once("qrcode.php");
$NewName_src = "qr_test.png";
$toPath = "".$NewName_src;
//unlink($toPath);
$qr = QRCode::getMinimumQRCode("Test ".time(), QR_ERROR_CORRECT_LEVEL_H);
$im = $qr->createImage(25, 10);
header("Content-type: image/png");
imagepng($im, $toPath);
imagedestroy($im);
//file_put_contents($toPath, $img_temp);
?>