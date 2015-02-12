<?php

include("util.php");
require_once("config.inc.php");

$con = new Mongo();
$bd = $con->selectDB(dbname);

$col = $bd->sliders;


if(!preg_match("/[\w]+/i", $_GET["sliders"]))
  json(0,array("msg" => "No hay fotos"));


$sliders= clean($_GET["sliders"]);
$lang = clean($_GET["lang"]);

$sliders = explode(";",$sliders);


try{

foreach ($sliders as $s) {

	$col->insert(array("slider" => $s , "lang" => $lang));
	
}

json(1,array());

}catch(Exception $e){

  json(0,array("msg" => "No se pudo guardar los sliders"));    
	

 }
