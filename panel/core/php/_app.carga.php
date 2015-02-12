<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include("util.php");
include("app.image.php");


function carga(){

$files = array();


foreach ($_FILES as $f) {


  $dir = $_SERVER["DOCUMENT_ROOT"] . "/medios";
  $ext = $f["name"];
  $ext = explode(".",$ext);
  $ext = strtolower(end($ext));
  
  $exts = array("jpg","pdf","gif","png","jpeg","zip","rar","mp3");

   if( !in_array($ext, $exts)  )
   	     die(json(0,array( "msg" => "Archivo no permitido")));

      $nombre = md5(time()) . "." . $ext;
      $nombre_ = "/" . md5(time()) . "." . $ext;

      if(!is_dir($dir)) 	   	 
 	   	  if(mkdir($dir,0775,true))

 	  if(!is_dir($dir . "/tmp")) 	   	 
 	   	  if(mkdir($dir . "/tmp",0775,true))
 	   	   	  	   
 	   	   	  	 	   	    

 	  if( isset($f) and !empty($f["tmp_name"]) )
 	      	if(preg_match("/image/i",$f["type"])){ 	  	 
 	          
 	        if(saveFile($f, $dir, $nombre, $nombre_)){

 	      	 array_push( $files, array( 
   							
   							"nombre" => $nombre,
   							"tipo" => $f["type"]

   							));	 

 	      	     unlink($dir . $nombre_);


 	           }


 	        }else{	
 	         if(saveFile($f, $dir, $nombre, $nombre)){

 	      	 array_push( $files, array( 
   							
   							"nombre" => $nombre,
   							"tipo" => $f["type"]

   							));	 


 	           }

 	        }   	
 	      	  

 }  




  success($files);

}



function saveFile($f , $dir, $nombre, $file){

	try{
		

		$vars_mini = array( "i" => $dir . $file , "n" => $nombre ,"c" => 30, "w" => 60 , "dir" => $dir . "/thumbs/60/", "make" => "save");
		$vars_thumb = array( "i" => $dir . $file , "n" => $nombre ,"c" => 30, "w" => 150, "dir" => $dir . "/thumbs/150/", "make" => "save");
		$vars_ = array( "i" => $dir . $file , "n" => $nombre ,"c" => 30, "w" => 250, "dir" => $dir . "/thumbs/250/", "make" => "save");
		$vars__ = array( "i" => $dir . $file , "n" => $nombre , "w" => 950, "dir" => $dir . "/" , "c" => 25, "make" => "save");


   if(move_uploaded_file($f["tmp_name"], $dir ."/". $file) or die(json(0,array())))
   	if(preg_match("/image/i",$f["type"])){
      
	    if( makeThumb($vars__) )	 	 
	 	   if(makeThumb( $vars_mini ))
	 	      if(makeThumb( $vars_thumb ))	 	  	 	   
	 	         if(makeThumb( $vars_ ))	 	  	 	   
	                      return true;	
              else
                return false;
            else
              return false;
          else
            return false;
        else 
           return false;

	         }else
	            return true;
	     else
	       return true;    	      	

	  } catch(Exception $e){

	     return false;

	}


}



function saveNombre($files, $nombre, $f){


	return  array_push( $files, array( 
   							
   							"nombre" => $nombre,
   							"tipo" => $f["type"]

   							));	 

    
     }



function makeThumb(  $vars ){

        
 	   	  if(optImg($vars))
 	   	  	   return true;
 	   	  else
 	   	       return false;

}


function success($files){
  

     mongo($files);

     json(1,$files);

}





function mongo($data){


	$con = new Mongo();

	foreach ($data as $doc) 
			$con->scholes->medios->insert($doc);
	



}



function main(){

	if($_FILES)
		carga();

}


main();