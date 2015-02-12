<?php

include("util.php");

$con = new Mongo();
$bd = $con->selectDB($dbname);

$col = $bd->productos;

$_id = $_GET["_id"];

$_id = new MongoId($_id);



$docs = $col->findOne( array( "_id" => $_id) );


if( $col->remove( array("_id" => $_id)) )
 json(1,array());
else
 json(0,array());
