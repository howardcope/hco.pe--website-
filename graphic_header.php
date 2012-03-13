<?php
	
function calculateTextBox($text,$fontFile,$fontSize,$fontAngle) 
{ 
	/************ 
	simple function that calculates the *exact* bounding box (single pixel precision). 
	The function returns an associative array with these keys: 
	left, top:  coordinates you will pass to imagettftext 
	width, height: dimension of the image you have to create 
	*************/ 
	$rect = imagettfbbox($fontSize,$fontAngle,$fontFile,$text); 
	$minX = min(array($rect[0],$rect[2],$rect[4],$rect[6])); 
	$maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6])); 
	$minY = min(array($rect[1],$rect[3],$rect[5],$rect[7])); 
	$maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7])); 
	
	return array( 
	 "left"   => abs($minX) - 1, 
	 "top"    => abs($minY) - 1, 
	 "width"  => $maxX - $minX, 
	 "height" => $maxY - $minY, 
	 "box"    => $rect 
	); 
}

$text_string    = stripslashes($_GET['t']); 
$font_ttf        = 'fnt/Underwood_Etendu_1913.TTF'; 
$font_size        = 16; 
$text_angle        = 0; 
$text_padding    = 0; // Img padding - around text 

$color_parts = explode("|",$_GET['bg']);
$font_color_parts = explode("|",$_GET['fc']);

$the_box        = calculateTextBox($text_string, $font_ttf, $font_size, $text_angle); 

$imgWidth    = $the_box["width"] + $text_padding; 
$imgHeight    = $the_box["height"] + $text_padding; 

$image = imagecreate($imgWidth,$imgHeight); 
imagefill($image, 0, 0, imagecolorallocate($image, hexdec("0x{$color_parts[0]}"), hexdec("0x{$color_parts[1]}"), hexdec("0x{$color_parts[2]}"))); 

$color = imagecolorallocate($image, hexdec("0x{$font_color_parts[0]}"), hexdec("0x{$font_color_parts[1]}"), hexdec("0x{$font_color_parts[2]}")); 
imagettftext($image, 
	$font_size, 
	$text_angle, 
	$the_box["left"] + ($imgWidth / 2) - ($the_box["width"] / 2), 
	$the_box["top"] + ($imgHeight / 2) - ($the_box["height"] / 2), 
	$color, 
	$font_ttf, 
	$text_string);

//$text = stripslashes($_GET['t']);
//$color_parts = explode("|",$_GET['bg']);
//$font_color_parts = explode("|",$_GET['fc']);

//$font_size = 14;

//$font = 'fnt/Underwood_Etendu_1913.TTF';

//$bbox = imagettfbbox($font_size, 45, $font, $text);

//echo "****" . $font . "****";

//var_dump($bbox);

//Secho "<br /><br />";

//$dLowerLeftx = $bbox[0];
//$dLowerRightx = $bbox[2];

//$dTextWIdth = $dLowerRightx - $dLowerLeftx;

//echo "dLowerLeftx: " . $dLowerLeftx . "<br />";
//echo "dLowerRightx: " . $dLowerRightx . "<br />";
//echo "dTextWIdth: " . $dTextWIdth . "<br />";

//exit;

// header styles pixel sizes
//$header_widths = array('1' => '13.335','2' => '18','3' => '16','4' => '10');
//$header_heights = array('1' => '24','2' => '18','3' => '16','4' => '10');

//$em = $header_widths[$_GET['h']]; //$header_heights[$_GET['h']];

//$w = strlen($text) * $em;
//$h = $dTextWIdth;

//$im = imagecreatetruecolor($dTextWIdth, $h);



//$bg_color = imagecolorallocate($im, hexdec("0x{$color_parts[0]}"), hexdec("0x{$color_parts[1]}"), hexdec("0x{$color_parts[2]}"));
//$font_color = imagecolorallocate($im, hexdec("0x{$font_color_parts[0]}"), hexdec("0x{$font_color_parts[1]}"), hexdec("0x{$font_color_parts[2]}"));
//imagefilledrectangle($im, 0, 0, $dTextWIdth, $h-1, $bg_color);

//$font = 'fnt/Underwood_Etendu_1913.TTF';

// Add some shadow to the text
//imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);

// Add the text
//imagettftext($im, $font_size, 0, 1, $font_size+1, $font_color, $font, $text); //  . " " . $dTextWIdth

//header("Content-type: image/png");

header("Content-type: text/html");
imagepng($image);
imagedestroy($image);

?>
