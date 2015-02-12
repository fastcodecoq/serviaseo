<?php

include("util.php");
require_once("config.inc.php");


$con = new Mongo();
$bd = $con->selectDB(dbname);

$col = $bd->giftcards;


if(!preg_match("/[\w]+/i", $_POST["nombre"]))
  json(0,array("msg" => "No has indicado un nombre"));


if(!preg_match("/[\w]+/i", $_POST["name"]))
  json(0,array("msg" => "No has indicado un nombre en ingles"));

if(!preg_match("/[0-9]+/i", $_POST["minval"]))
  json(0,array("msg" => "No has indicado el valor minimo"));


if(!preg_match("/[0-9]+/i", $_POST["maxval"]))
  json(0,array("msg" => "No has indicado el valor maximo"));


if(!preg_match("/[\w]+/i", $_POST["descripcion"]))
  json(0,array("msg" => "No has indicado una descripcion"));


if(!preg_match("/[\w]+/i", $_POST["description"]))
  json(0,array("msg" => "No has indicado una descripcion en ingles"));


if(!preg_match("/[\w]+/i", $_POST["fotos"]))
  json(0,array("msg" => "No hay fotos"));

$descripcion = str_replace("\n", "<br />", $_POST["descripcion"]);
$descripcion = str_replace("\t", "  ", $descripcion);

$description = str_replace("\n", "<br />", $_POST["description"]);
$description = str_replace("\t", "  ", $description);

$_POST["nombre"] = clean($_POST["nombre"]);
$_POST["name"] = clean($_POST["name"]);
$_POST["descripcion"] = $descripcion;
$_POST["fotos"] = clean($_POST["fotos"]);
$_POST["vendidos"] = 0;
$_POST["minval"] = (int) str_replace(array("$",".",","), "", $_POST["minval"]);
$_POST["maxval"] = (int) str_replace(array("$",".",","), "", $_POST["maxval"]);


$p_en = $_POST;

$p_en["nombre"] = $_POST["name"];
$p_en["descripcion"] = $description;
$p_en["lang"] = "en";

$_POST["lang"] = "esp";


if($col->insert( $_POST ) && $col->insert( $p_en ))
	json(1,array());