<?php
header("content-type : image/png");

include("resources/phpqrcode/qrlib.php");


function genQR( $vars ){

	$size = (isset($vars["s"])) ? $vars["s"] : 10;
	$qr =  str_replace(array("http:/","www."),"http://",$vars["qr"]);	

	if(filter_var($qr,FILTER_VALIDATE_INT))
		$qr = trim("tel:{$qr}");

	if(filter_var($qr,FILTER_VALIDATE_MAIL))
		$qr = "mailto:{$qr}";
   
    if(preg_match("/".$qr."/i","vcard"))
    	die("vcard");

    echo $qr;
    die;

    QRcode::png($qr,false,QR_ECLEVEL_H, $size, 1);


}


if(isset($_GET["qr"]))
       genQR($_GET);