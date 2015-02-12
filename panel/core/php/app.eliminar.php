<?php

include("util.php");
require_once("config.inc.php");


function eliminar( $_id ){

$con = new Mongo();
$col = $con->selectDB(dbname)->medios;

$_id = new MongoId($_id);



$docs = $col->findOne( array( "_id" => $_id) );



if( $col->remove( array("_id" => $_id)) )	
	 if( delFiles($docs["nombre"]) )
	 	      json(1,array());



}


function delFiles( $file ) {

  $dir = $_SERVER["DOCUMENT_ROOT"] . dpath . "/medios/";

  $ext = explode(".",$file);
  $ext = end($ext);

  try{

   if(unlink($dir . $file))
   	if( $ext == "jpg" || $ext == "jpeg" || $ext == "gif" || $ext == "png"){
     
     if(unlink($dir . "thumbs/150/" . $file))
       if(unlink($dir . "thumbs/60/" . $file))
   		   if(unlink($dir . "thumbs/250/" . $file))
   		   				return true;
   	 }else{

   	 	return true;

   	 }

    } catch(Exception $e){

    	 return false;

    }


}


function main_el(){

	if($_GET)
	  eliminar($_GET["_id"]); 

}


main_el();