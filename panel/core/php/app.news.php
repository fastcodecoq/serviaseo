<?php

include("util.php");
include("app.mailer.php");

if($_POST){
	
	
	$mail = $_POST["email"];
	$errors = array();

	if(!filter_var($mail, FILTER_VALIDATE_EMAIL) || strlen($mail) < 3) $errors[] = "El eMail no es correcto";

	if(count($errors) > 0)
	{

		json(0,$errors);
		exit();

	}



	$con = new Mongo;
	$bd = $con->selectDB($dbname);
	$col = $bd->news;





	try{


		$rs = $col->findOne(array("email" => $mail));

		if(is_array($rs))
			{
				json(0,$rs);
				exit();
			}
     
		if($col->insert(array("email" => $mail)))
			json(1,"");		

	}catch(Exception $e){

		json(0,"");

	}




}