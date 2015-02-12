<?php

include("util.php");
include("config.inc.php");

$con = new Mongo();
$bd = $con->selectDB(dbname);

$col = $bd->productos;


if(!preg_match("/[\w]+/i", $_POST["nombre"]))
  json(0,array("msg" => "No has indicado un nombre"));

if(!preg_match("/[0-9]+/i", $_POST["precio"]))
  json(0,array("msg" => "No has indicado el precio"));

if(!preg_match("/[0-9&]+/i", $_POST["cantidad"]))
  json(0,array("msg" => "No has indicado la cantidad"));


if(!preg_match("/[\w]+/i", $_POST["descripcion"]))
  json(0,array("msg" => "No has indicado una descripcion"));


if(!preg_match("/[\w]+/i", $_POST["fotos"]))
  json(0,array("msg" => "No hay fotos"));

$descripcion = str_replace("\n", "<br />", $_POST["descripcion"]);
$descripcion = str_replace("\t", "  ", $descripcion);

$description = str_replace("\n", "<br />", $_POST["description"]);
$description = str_replace("\t", "  ", $description);

$_POST["nombre"] = clean($_POST["nombre"]);
$_POST["name"] = clean($_POST["name"]);
$_POST["precio"] = clean($_POST["precio"]);
$_POST["cantidad"] = (int) clean($_POST["cantidad"]);
$_POST["descripcion"] = $descripcion;
$_POST["fotos"] = clean($_POST["fotos"]);
$_POST["categoria"] = clean($_POST["categoria"]);
$_POST["slug"] = clean($_POST["slug"]);
$_POST["vendidos"] = 0;

$_POST["precio"] = (int) str_replace(array("$",".",","), "", $_POST["precio"]);

$p_en = $_POST;

$p_en["nombre"] = $_POST["name"];
$p_en["descripcion"] = $description;
$p_en["lang"] = "en";

$_POST["lang"] = "esp";


if($col->insert( $_POST ) && $col->insert( $p_en ))
	json(1,array());


