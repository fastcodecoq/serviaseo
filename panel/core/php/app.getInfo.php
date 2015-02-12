<?php


 include("util.php");
 require_once("config.inc.php");

function query( $vars = array("filtro"=>"none") ){

 
  $con = new Mongo();
  $filtro = (isset($vars["filtro"])) ? $vars["filtro"] : "none";
  $query = 0;

  switch ($filtro) {
  	
  	case 'imagenes':
  			
  		 $query = array("nombre" => new MongoRegex("/(^.+[.]jpg$)+|(^.+[.]gif$)+|(^.+[.]png$)+|(^.+[.]jpeg$)+/i"));

  	break;

    case 'docs':

       $query = array("nombre" => new MongoRegex("/(^.+[.]pdf$)+/i"));


    break;  

    case 'files':

       $query = array("nombre" => new MongoRegex("/(^.+[.]zip$)+|(^.+[.]rar$)+/i"));


    break;  

    case 'audio':

       $query = array("nombre" => new MongoRegex("/(^.+[.]mp3$)+/i"));    

    break;

    case 'videos':

       $query = array("tipo" =>"url/video");       


    break;
  	
  	  default:
  	
  		break;

  }


  if($query != 0){

  $rs = $con->selectDB(dbname)->medios->find($query);

  }
  else
  $rs = $con->selectDB(dbname)->medios->find();

  $rs_ = array();


  foreach ($rs as $doc) {

 	array_push($rs_, $doc);
 	
   }

  $rs_ = array_reverse($rs_);


  $make = (isset($vars["make"])) ? $_GET["make"] : "json";


  switch ($make) {
  	
  	case 'json':
  		
  		json(1,$rs_);

  		break;

   default:

    echo $filtro;

   break;
  	

  }



}



 if($_GET)
  query($_GET);
 else
  query();
 


