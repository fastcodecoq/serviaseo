<?php
include(dirname(__FILE__) . "/app.genQR.php");
include(dirname(__FILE__) . "/util.php");
require_once(dirname(__FILE__) . "/config.inc.php");


function short( $vars ){
		

		$url = $vars["u"];	
		$ip = $_SERVER["REMOTE_ADDR"];

	   //echo "ping -c 1 {$url} > /dev/null 2>&1";
	   //$rs = exec("echo apache | ping -c 1 {$url} > /dev/null 2>&1");
	   //echo $rs;
	   //die;

		if(!filter_var($ip,FILTER_VALIDATE_IP))	
			die;

	    if(!preg_match("/^[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+$/i", $url))
	    	die(json(0,array("msg" => "URL invalida")));
	   


	    //if( == "error")
	    	//die(json(0,array("msg" => "URL no existe")));

	     $short = nAle(5); 

	     $con = new Mongo();
	     $short_col = $con->selectDB(dbname)->shorter;
	     $block_col = $con->block->urls;
 
	     $rs = $short_col->findOne( array("url" => $url) );
	     $rs_ = $block_col->findOne( array("url" => $url) );
	     
	     if( count($rs_) > 0 )
	     	die(json(0,array("msg" => "URL bloqeada")));



	     if( count($rs) > 0){
	      
	      $short = $rs["short"];
	  	  $url = $rs["url"];
	  	  $qr = $rs["qr"];

	  	  }else{
	  	  	
	  	  	$qr = $url;
	  	  	$doc = array("url" => $url , "short" => $short, "qr" => $qr);
	  	  	$short_col->insert($doc);


	  	  }


	  	switch($vars["make"]){

	  		case "json":

					header('Cache-Control: no-cache, must-revalidate');
					header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
					header('Content-type: application/json');


	  		echo json_encode(array("short"=>$short,"url" => $url,"qr" =>$qr));

	  		break;

	  		case "return":

	  		return array("short"=>$short,"url"=>$url,"qr"=>$qr);

	  		break;

	  	}  


}






function main_short(){
		
		
		   short($_GET);

}

if(isset($_GET["u"]))
  main_short();


