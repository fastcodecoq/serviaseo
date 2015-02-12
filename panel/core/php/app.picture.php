<?php

function resizeImg ( $vars ){

	try{

	$img = $vars["img"];
	$width = $vars["w"];
	$nombre = $vars["n"];
	$cal = ( isset($var["cal"]) ) ? $var["cal"] : 75;

	$dir = (isset($vars["dir"])) ? $vars["dir"] : $_SERVER["DOCUMENT_ROOT"] . "/medios/thumbs/";



	$image_type = explode(".", $img);
	$image_type = end($image_type);


	if(!is_dir($dir))
		if(mkdir($dir,0777,true))


	if ( preg_match('/jp/i', $image_type) ) { $image_type = "jpeg"; }

	header("Content-Type: image/" . $image_type);

	list($width_o, $height_o) = getimagesize( $img );
	
	$height = $height_o;

   
	$ratio_o = $width_o / $height_o;

	if ( $width / $height > $ratio_o ) {
	   $width = $height * $ratio_o;
	} else {
	   $height = $width /$ratio_o;
	}


    

	$image_p = imagecreatetruecolor( $width, $height );

	switch ( $image_type ){
		case "jpeg": $image = imagecreatefromjpeg( $img ); break;
		case "png": $image = imagecreatefrompng( $img ); break;
		case "gif": $image = imagecreatefromgif( $img ); break;
		case "jpg": $image = imagecreatefromjpeg( $img ); break;
	}

	imagealphablending($image_p, false); 
	imagesavealpha($image_p, true);
	imagecopyresampled( $image_p, $image, 0, 0, 0, 0, $width, $height, $width_o, $height_o );

	switch ( $image_type ){
		case "jpeg": 
		   imagejpeg($image_p, $dir.$nombre, $cal); 

		   break;

		case "png": 
		   imagepng($image_p, $dir.$nombre, $cal); 
		   break;

		case "gif": 
		    imagegif($image_p, $dir.$nombre , $cal); 
		break;

		case "jpg": 
		    imagegif($image_p, $dir.$nombre , $cal); 
		break;
	}
	
	imagedestroy($image);
	imagedestroy($image_p);

	return true;

	} catch(Exception $e){

		return false;

	}
	
}

function main_re(){


 $p =  $_GET["p"] ;
 $w =  $_GET["w"];
 $cal = $_GET["c"];

   resizeImg($_GET);



}

if($_GET)
 main_re();

