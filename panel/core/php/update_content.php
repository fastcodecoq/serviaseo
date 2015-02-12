<?php
session_start();

 include( "../../../config.inc.php");

if(isset($_SESSION["editable"]))
	 die;


include("util.php");

$file = (!isset($_POST["path"])) ? $_SERVER["DOCUMENT_ROOT"] . path . "/themes" . theme_dir . "/pages/" . $_POST["vista"] : 
                                   $_SERVER["DOCUMENT_ROOT"] . $_POST["path"] . "/themes" . theme_dir . "/pages/" . $_POST["vista"]  ;

$fc = $_POST["html"];


$fc = htmlentities(clean_($fc));
$fc = str_replace('data-role="editable"',"%editable%", $fc);
$fc = str_replace('contenteditable=""',"", $fc);
$fc = str_replace('<br />','\n',$fc);
$fc = preg_replace('/<a href="#edit".+a>/', "", $fc);

$f = file_put_contents($file, html_entity_decode($fc));


if($f)
 json(1,array("rs" => $fc));
else
 json(0,array());