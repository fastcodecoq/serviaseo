<?php

class routeException extends Exception{}

class route{

private $col;

function __construct(){

	$con = new MongoClient();
	$db = $con->selectDB("serviaseo");
	$this->col = $db->routes;

}

function save(){

   $col = $this->col;
   $this->cleanPost();
   
   if(empty($_POST["zone"]))
   	 throw new routeException("Debes especificar los barrios de la ruta");

   $_POST["day"] = (int) $_POST["day"];
   $_POST["sede"] = (int) $_POST["sede"];
   $query = $this->getQuery();

   $exist = ( is_array($col->findOne($query)) ) ? true : false;


   if($exist)
  	$rs = $col->update($query, $_POST );
   else
    $rs = $col->save($_POST);
   


  if($rs)
   echo json_encode(array("success" => 1));
  else
   throw new routeException("");


  }

  function find(){

 		$col = $this->col;
 		$_POST["day"] = (int) $_POST["day"];
        $_POST["sede"] = (int) $_POST["sede"];
 		$query = $this->getQuery();

 		$rs = $col->findOne($query);

 		

 		if(is_array($rs))
 			 echo json_encode(array("success" => 1, "data" => $rs));
 	    else
             throw new routeException("");
 	    	

  }

  private function cleanPost(){
  	  foreach ($_POST as $key => $value)
  	  	 if($key != "polygone")
  	  	  $_POST[$key] = trim(htmlentities(strip_tags($value), ENT_QUOTES, 'UTF-8'));  	  
  }

  private function getQuery(){
   
   $day =  $_POST["day"];
   $sede =  $_POST["sede"];
   $query = array("sede" => $sede , "day" => $day);
   return $query;

  } 


}


$app = new route;	

try{
if(isset($_GET["save"]))
	$app->save();

if(isset($_GET["find"]))
	$app->find();
 }
 catch(Exception $e){
 	 echo json_encode(array("success" => 0, "message" => $e->getMessage()));
 	 die;
 }





