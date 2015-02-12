<?php

   function optImg($vars){

   try{

   if(preg_match("/:\/[\w]+?/i", $vars["i"]))
   $i = preg_replace("/:\//i", "://", $vars["i"]);   
   else
   $i =  $vars["i"];   

   $cal = ( isset($vars["c"]) ) ? 100 - $vars["c"] : 30;  
   $make = ( isset($vars["make"]) ) ? $vars["make"] : "show";  
   $height = ( isset($vars["h"]) ) ? $vars["h"] : 700;


   $img_type = explode(".",$vars["n"]);
   $img_type = strtolower(end($img_type));


   if(preg_match("/^jp/i", $img_type))
   	  $img_type = "jpeg";

   

   $img = new Imagick(); 
   $img->readImage($i); 
   $img->setImageFormat($img_type);

   $width = ( isset($vars["w"]) ) ? $vars["w"] : $img->getImageWidth();


   $img->scaleImage($width, 0);


   $img->setImageCompressionQuality($cal);       
   
   switch($vars["make"]){

   	case "show":

      header("Content-type:image/{$img_type}");

   	echo $img;

   	break;


   	case "blob":

   	$a = $img->getImageBlob();

   	echo $a;

   	break;

   	case "json":

		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');

   	$a = $img->getImageBlob();	

	 $json = array(

	 	 "success" => 1,
	 	 "img"=> base64_encode($a),
	 	 "size" => substr(strlen($a) / 1000000,0,5) . "MB",
	 	 "type" => $img_type

	 	);


	 echo json_encode($json);

   	break;


   	case "base64":

   	$a = $img->getImageBlob();	
   	$a = base64_encode($a);

   	echo "<img src='data:image/{$img_type};base64,{$a}' alt='' />";


   	break;

      case "save":

      $dir = $vars["dir"];
      $rs = $img->writeImage($dir . $vars["n"]) ;
 
      
      if($rs)
        return true;
      else
        return false;

      break;

   }

}catch(Exception $e){

      
        return false;

     }
   

   }



  // if($_GET)
    // optImg($_GET); 