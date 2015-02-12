<?php

require_once(dirname(__FILE__) . "/util.php");
require_once(dirname(__FILE__) . "/config.inc.php");


class products{

    private $erros;

    function __construct(){

        $erros = array();

    }



    function get( $sort ){

$con = new Mongo();
$bd = $con->selectDB(dbname);
$col = $bd->productos;

$rs = $col->find();

switch($sort)
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

foreach ($rs as $doc)
  array_push($rss, $doc);



return array_reverse($rss);

}





}



