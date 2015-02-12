<?php

include_once(dirname(__FILE__) . "/config.inc.php");
header("HTTP/1.1 301 Moved Permanently");  

$con = new Mongo();
$short = $_GET["short"];

$col = $con->selectDB(dbname)->shorter;

$rs = $col->findOne( array( "short" => $short ) );




 if( count($rs) > 0)
  header("Location: ".$rs["url"].""); 
 else
   die("Short invalido");


      
      