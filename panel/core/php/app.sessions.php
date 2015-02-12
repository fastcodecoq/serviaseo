<?php
  if(!isset($_SESSION))
  session_start();
 // include(dirname(__FILE__) . "/config.inc.php");

class sessions_{

 
    private $_uid;

	private $_db_server = DB_SERVER;
	private $_db_user = DB_USER;
	private $_db_pass = DB_PASS;
	private $_db_bdata = DB_BASEDATA;
	private $_tb_sessions = TB_SESSIONS;
	private $token ;

	private $_mysqli;
	private $_error = 'Error no identificado';

	public function __construct($init = "yes") {
		 

		 if($this->connect_DB())
		 	if($init == "yes")
		 	 {
		 	 	if($this->init_())
		 	 	    return true;
		 	 }else
		 	   return true;
		 else
		 	return false;
	


	}


	private function connect_DB(){

		$mysqli = new mysqli($this->_db_server, $this->_db_user, $this->_db_pass, $this->_db_bdata);
		if ( mysqli_connect_errno () ) {
			$this->_error = 'No se pudo conectar a la base de datos';
			return false;
		}else{
			$this->_mysqli = $mysqli;			
			return true;
		}	

	}


	private function init_(){


		if(!isset($_COOKIE["activity"])){
			


			if(isset($_SESSION["token"]) && !isset($_COOKIE["token"])){				

				$this->token = md5($_SESSION["token"] . "==");	

			setcookie("activity", $this->token, time() + 120,"/");
			$data = array(

				"uid" => $_COOKIE["uid"],
				"token" => $this->token,
				"session_inf" => $_SESSION["token"],
				"keep" => "nop",
				"active" => "yes",
				"last_activity" => time()

				);

		    	$this->register_session($data);

		     }
		    else if(isset($_COOKIE["token"])) {	

				$this->token = md5($_COOKIE["token"] . "==" . time());	

		    
			setcookie("activity", $this->token, time() + ( 24*3600*365 ),"/");		

			$data = array(

				"uid" => $_COOKIE["uid"],
				"token" => $this->token,
				"session_inf" => $_COOKIE["token"],
				"keep" => "yes",
				"active" => "yes",
				"last_activity" => time()

				);


			  $this->register_session($data);				    


		    }

		}		

	

	}


public function gTok(){

	return $this->token;

}



  public function register_session($data){

 		$data["keep"] = (empty($data["keep"])) ? "nop" : $data["keep"]; 		

        $query = "INSERT INTO `{$this->_tb_sessions}` (`uid`, `token`, `sessionInf`, `keep`, `active`, `last_activity`) VALUES (?, ?, ?, ?, ?, ?)";                

		$conn = $this->_mysqli;
		$ins = $conn->prepare($query);	
		
		$time = time();		

		$ins->bind_param('ssssss', $data["uid"], $data["token"], $data["session_inf"], $data["keep"], $data["active"], $time);
		$insert = $ins->execute();

		if ( !$insert ) {
			$this->_error = "No se pudo registrar la session";
			return false;
		} else {			
			return true;
		}

	}

	public function consult_ ($what, $who, $this_) {

		$who = (empty($who) OR $who == NULL) ? "token" : $who;	

		if(is_array($what)){

			foreach ($what as $key => $value){
			  
			   $what[$key] = str_replace("`", "", $what[$key]);
			   $what[$key] = "`{$value}`";

			  }

			$what_ = join(" ,",$what);

		}else{
		 
		  $what = str_replace("`", "", $what);
		  $what_ = "`{$what}`";

		 } 


		$query = "SELECT {$what_} FROM `{$this->_tb_sessions}` WHERE `{$who}` = '$this_'";	

		$conn = $this->_mysqli;
		$get_data = $conn->query($query);
		$result = $get_data->fetch_assoc();

		if($result != NULL)
		 return $result;
		else{
		 
		 $this->_error = $this->_mysqli->error;
		 echo $this->error();
		 return false;

		  }
		

	}


 public function is_active( $token = "me"){


		
     if($token == "me")		
     	  if(isset($_COOKIE["activity"]))
			$token = $_COOKIE["activity"];
		else
			return false;


			$rs = $this->consult_(array('last_activity','active','keep'),NULL, $token);			           

			if($rs){
			
				if($rs["keep"] == "yes")
					   
					   {					

					   $this->_error = "";  

					 	
					   	  if($rs["active"] == "yes"){					   	  	
					   	
					   		$this->extend_cookie_plus($token);
					        return true;
					      
					          }else{

					      	$this->_error = "Token inválido";
					      	return false;

					      }

					 }else{


					$last_activity = $rs["last_activity"];
			        $active = $rs["active"];		 	
			        $now = time();


			        if( ( ($now - $last_activity) > 10000 ) OR $active != "yes" )
				      {
					  
					  $this->die_session();
					  $this->_error = "El Token ha expirado";
					  return false;					

				      }
			            else {
				   								  
				    $this->extend_cookie($token);
					return true;					
 
				       }


					 }

			
			 } 
			   else {

			 	$this->_error = "Token inválido";
			 	return false;

			 }

			
	}

	public function die_session($token = "me"){

			if($token == "me")
				$token = $_COOKIE["activity"];
			

			if($this->update_("active", $token, "nop"))
				{

					return true;					
				}
			else{

				$this->_error = "No se pudo dar de baja la session";
				return false;

			 }


	}

	private function extend_cookie($token){
		 
		
		 if(isset($_SESSION))
		   setcookie("activity", $token, time() + 120, "/");
		 else
		   setcookie("activity", $token, time() + 120, "/");
		
		$now = time();

		$this->update_("last_activity", $token, $now);


	}



	private function extend_cookie_plus($token){
		 

		 $plus = 24*3600*365;
		

	   setcookie("activity", (string) $token, time() + $plus, "/");
         
		
		$now = time();
		

		$this->update_("last_activity", $token, $now);


	}




	private function update_ ($this_, $what, $newVal) {

		$conexion = $this->_mysqli;
		$up_query = "UPDATE `{$this->_tb_sessions}` SET `{$this_}` = ? WHERE `token` = ?";



		$up = $conexion->prepare($up_query);

		$up->bind_param ('ss', $newVal, $what);
		$upd = $up->execute();

		if ( !$upd ) {
			$this->_error = "No se pudo actualizar éste dato";
			return false;
		}else{
			return true;
		}

	}




	public function error(){

		 return $this->_error;

	}

}


if(1 > 2){

	switch ($_GET["make"]) {

		case 'register_session':
			

			  $data = array( 

			  	   "uid" => "uid_test",
			  	   "token" => md5("token_test" .  time()),
			  	   "keep" => ""			  	  

			  	);


			   $ses_api = new sessions_();

			   if($ses_api)
			    $ses_api->register_session($data);
			   else
			   	echo $ses_api->error();


			break;

		case 'exist':

			   $ses_api = new sessions_();							   

			   $vars = array("active","last_activity","token");

			   $rs = $ses_api->consult_('token','active',"y");

			   if($rs)
			   var_dump($rs);
			   else
			   	echo "no se hallaron resultados";

		break;


		case 'update':

			$ses_api = new sessions_();
			$token = "5fe3c13dd45ea90c611614cac40b7e36";

			$upd = $ses_api->update_('active',$token,'yes');

			if($upd){
								
				$rs = $ses_api->consult_('active','',$token);

				echo "{$token} : {$rs["active"]}";

			  }
			else
				echo "No se pudo actualizar";


		break;


		case 'init':

			$ses_api = new sessions_();

			if($ses_api->is_active("me"))
		      echo "si";
		    else
		      echo "no";

		break;

		
		default:
			# code...
			break;

	}

}