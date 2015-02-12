<?php 

session_start();

require_once(dirname(__DIR__)  . "/php/util.php");
require_once(dirname(__DIR__)  . "/php/config.inc.php");

$con = new Mongo();
$bd = $con->selectDB($dbname);

$col = $bd->dev_mode;

$switch = (isset($_GET["switch"])) ? $_GET["switch"] : "off";

switch ($switch) {
	
	case 'on':
	  		
	  	$set = array("status" => "on");
	  	$col->update(array("status" => "off"), $set);
	  	setcookie("dev", $_COOKIE["activity"], time() + 3600,"/");

		break;
	
	case 'off':
		
		$set = array("status" => "off");
	  	$col->update(array("status" => "on"), $set);

		setcookie("dev", "", time()-3600, "/");	

		break;
}


$make = (isset($_GET["make"])) ? $_GET["make"] : "http";


switch ($make) {
	case 'http':	
		
		if($switch == "on")
		echo "<script>window.location='/'</script>";
	    else{

	    	$location = $_SERVER["HTTP_REFERER"];

	    	$location = explode("/",$location);
	    	$location = end($location);

	    	if(preg_match("/off/i", $location))
	    		$location = dpath;


	    	if(empty($location))
	    		$location = "/";

	    	 echo "<script>document.location = '$location';</script>";
	    }
		

	    die;

		break;
	
	case 'json':
	
	  json(1,array());

    break;
}

