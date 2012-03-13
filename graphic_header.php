<?php
	
function calculateTextBox($text,$fontFile,$fontSize,$fontAngle) 
{ 
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

header("Content-type: text/html");
imagepng($image);
imagedestroy($image);

?>
