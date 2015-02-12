<?php

include("util.php");
require_once("config.inc.php");

$con = new Mongo();
$bd = $con->selectDB(dbname);

$col = $bd->sliders;

$_id = $_GET["_id"];

$_id = new MongoId($_id);



$docs = $col->findOne( array( "_id" => $_id) );


if( $col->remove( array("_id" => $_id)) )
 json(1,array());
else
 json(0,array());
