<?php 

include(dirname(__FILE__) . "/users_api.php");




function ajax_check(){

	$user_api = new User();
    $ses_api = new sessions_();

 if($user_api->login("me"))
 {

 	if($ses_api->is_active("me"))
 		json(1,array( "msg" => $ses_api->error() ));
 	else{
 		
 		$user_api->logout("me");
 		json(0,array("msg" => $ses_api->error() . " is_active"));

 	  } 

 }else{
 		 	
 	json(0,array("msg",$user_api->error() . " chkLogin"));

 }

}


ajax_check();