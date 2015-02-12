<?php

require_once("config.inc.php");
require_once("util.php");


$con = new Mongo();
$bd = $con->selectDB(dbname);
$col = $bd->sliders;


if(isset($_GET["all"]))
$rs = iterator_to_array($col->find());
else{
	
$query = array();
$query["lang"] = ($_GET) ? $_GET["lang"] : "esp";

$rs = iterator_to_array($col->find($query));

}

$rss = array();


foreach ($rs as $doc)
	array_push($rss, $doc);



json(1,array_reverse($rss));