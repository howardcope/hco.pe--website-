<?php
// Set the content-type
//header("Content-type: image/png");
header("Content-type: text/html");
// header("Content-type: text/html");

// Create the image
// get font metrics and make the image the right size
$text = stripslashes($_GET['t']);
$color_parts = explode("|",$_GET['bg']);
$font_color_parts = explode("|",$_GET['fc']);


$font_size = 14;

// use imagemagick to get font metrics
$draw = "nix"; //new Gmagick();
$font = 'fnt/Underwood_Etendu_1913.TTF';

$bbox = imagettfbbox($font_size, -45, $font, $text);

//echo "****" . $font . "****";

//var_dump($bbox);

//Secho "<br /><br />";

$dLowerLeftx = $bbox[0];
$dLowerRightx = $bbox[2];

$dTextWIdth = $dLowerRightx - $dLowerLeftx;

//echo "dLowerLeftx: " . $dLowerLeftx . "<br />";
//echo "dLowerRightx: " . $dLowerRightx . "<br />";
//echo "dTextWIdth: " . $dTextWIdth . "<br />";

//exit;

// header styles pixel sizes
$header_widths = array('1' => '13.335','2' => '18','3' => '16','4' => '10');
$header_heights = array('1' => '24','2' => '18','3' => '16','4' => '10');

$em = $header_widths[$_GET['h']]; //$header_heights[$_GET['h']];

$w = strlen($text) * $em;
$h = $dTextWIdth;

$im = imagecreatetruecolor($dTextWIdth, $h);



$bg_color = imagecolorallocate($im, hexdec("0x{$color_parts[0]}"), hexdec("0x{$color_parts[1]}"), hexdec("0x{$color_parts[2]}"));
$font_color = imagecolorallocate($im, hexdec("0x{$font_color_parts[0]}"), hexdec("0x{$font_color_parts[1]}"), hexdec("0x{$font_color_parts[2]}"));
imagefilledrectangle($im, 0, 0, $dTextWIdth, $h-1, $bg_color);

//$font = 'fnt/Underwood_Etendu_1913.TTF';

// Add some shadow to the text
//imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);

// Add the text
imagettftext($im, $font_size, 0, 1, $font_size+1, $font_color, $font, $text); //  . " " . $dTextWIdth

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);

?>
