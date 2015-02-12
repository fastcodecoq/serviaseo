<?php

require_once("util.php");
require_once("config.inc.php");


function find(){
	
 $min = (isset($_GET["min"])) ? (int) $_GET["min"]  : 0;
 $max = (isset($_GET["max"])) ? (int) $_GET["max"] + 1: 10001;
 $make = (isset($_GET["make"])) ? $_GET["make"] : "json";
 $n_f = (isset($_GET["n_f"])) ? true : false;
 $filtro = (isset($_GET["f"])) ? true : false;
 $lang = (isset($_GET["lang"])) ? true : false;



 $con = new Mongo();
 $bd = $con->selectDB(dbname);

 $col = $bd->productos;

if($max < 130000)
 $query = array( 'precio' => array('$gt' => $min , '$lt' => $max) );
else
 $query = array( 'precio' => array('$gt' => 120000) );

 $query["lang"] = "esp";


if($filtro)
  $query["categoria"] = $_GET["f"];

if($lang)
	$query["lang"] = $_GET["lang"];
   



 $rs = $col->find($query);


if(isset($_GET["sort"]))
switch($_GET["sort"])
{

  case "p>":

     $rs->sort( array("precio" => -1) );

  break;

  case "<p":

     $rs->sort( array("precio" => 1) );

  break;

  case "name>":

     $rs->sort( array("name" => -1) );

  break;

  case "<name":

     $rs->sort( array("name" => 1) );

  break;



}


$rs = iterator_to_array($rs);
$rss = array();


foreach ($rs as $doc){
    
    if($n_f)
    	$doc["precio"] = number_format($doc["precio"], 0, '', '.');

	array_push($rss, $doc);

}


 switch ($make) {
 	
 	case 'json':
 	
 	 json(1,$rss);

    break;
 	
 }


}



if($_GET)
 find();



