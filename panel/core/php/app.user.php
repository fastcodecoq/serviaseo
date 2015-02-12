<?php
if(!isset($_SESSION))
session_start();

 ini_set("session.gc_maxlifetime", (24*3600*30) );	
  
 require_once(dirname(__FILE__) . "/functions.php");
 require_once(dirname(__FILE__) . "/config.inc.php");
 
 
  if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
    { 
        function undo_magic_quotes_gpc(&$array) 
        { 
            foreach($array as &$value) 
            { 
                if(is_array($value)) 
                { 
                    undo_magic_quotes_gpc($value); 
                } 
                else 
                { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
     
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    } 



class User
{
	private $_uid;

	private $_db_server = DB_SERVER;
	private $_db_user = DB_USER;
	private $_db_pass = DB_PASS;
	private $_db_bdata = DB_BASEDATA;
	private $_tb_users = TB_USERS;

	private $_mysqli;
	private $_error = 'Error no identificado';

	public function __construct () {
		$mysqli = new mysqli($this->_db_server, $this->_db_user, $this->_db_pass, $this->_db_bdata);
		if ( mysqli_connect_errno () ) {
			$this->_error = 'No se pudo conectar a la base de datos';
			return false;
		}else{
			$this->_mysqli = $mysqli;
			return true;
		}
	}

	public function error () {
		return $this->_error;
	}

	public function register ($data) {

		$uid = genKeyUid('uid');

		$username = $data['username'];
		$username = delespecialchars($username);			

		$name = $data['name'];
		$email = $data['email'];

		$date = date("w j-m-Y g:i:s:a");
		$rol = 'admin';
		$status = 'active';
		$login = 'yep';


		$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
		$password = $this->doHash($data["password"],$salt);


		$hash_login = md5($username) .  $password;
		$hash_login_mail = md5($email) .  $password;

		$token = genToken("{$uid}|{$username}|{$password}");



		$query = "INSERT INTO `{$this->_tb_users}` (`uid`, `username`, `password`, `name`, `email`, `date`, `rol`, `status`, `login`, `token`, `hash_login` , `hash_login_mail`, `salt`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$conn = $this->_mysqli;
		$ins = $conn->prepare($query);
		$ins->bind_param( 'sssssssssssss', $uid, $username, $password, $name, $email, $date, $rol, $status, $login, $token, $hash_login, $hash_login_mail, $salt);
		$insert = $ins->execute();

		if ( !$insert ) {
			$this->_error = "No se pudo registrar el usuario {$username}";
			return false;
		} else {
			return true;
		}

	}

	function consult ($what, $who, $that = "username") {



		$query = "SELECT `{$what}` FROM `{$this->_tb_users}` WHERE `{$that}` = '{$who}'";
		$conn = $this->_mysqli;

	
		$get_data = $conn->query($query);
		$result = $get_data->fetch_assoc();
		return $result[$what];

	}

	private function update ($who, $what, $newVal) {

		$conexion = $this->_mysqli;
		$up_query = "UPDATE `{$this->_tb_users}` SET `{$what}` = ? WHERE `username` = '{$who}'";
		$up = $conexion->prepare($up_query);

		$up->bind_param ('s', $newVal);
		$upd = $up->execute();

		if ( !$upd ) {
			$this->_error = "No se pudo actualizar éste dato";
			return false;
		}else{
			return true;
		}

	}

	public function getInfo ($user) {

		$conn = $this->_mysqli;
		$query = "SELECT * FROM `{$this->_tb_users}` WHERE `username` = '{$user}'";
		$get_data = $conn->query($query);
		$result = $get_data->fetch_assoc();
		$res = Array(
			'index' => $result['id'],
			'uid' => $result['uid'],
			'username' => $result['username'],
			'name' => $result['name'],
			'email' => $result['email'],
			'rol' => $result['rol'],
			'bio' => $result['bio'],
			'date' => $result['date'],
			'avatar' => $result['avatar']
		);

		return $res;

	}

	public function exist ($who, $type = NULL) {


		$conn = $this->_mysqli;

		if($type == NULL)
		$sql = "SELECT * FROM `{$this->_tb_users}` WHERE `username` = '{$who}'";
	    else{
	    
	    if(filter_var($who, FILTER_VALIDATE_EMAIL))
	    $sql = "SELECT * FROM `{$this->_tb_users}` WHERE `email` = '{$who}'";
	    else
	    return false;

	     }
	     
	    	
		$conn->query($sql);
		$n = $conn->affected_rows;
		if ($n > 0) {
			return true;	
		} else {
			return false;			
		}

	}

	private function auth ($who, $type = NULL) {
		
		$conn = $this->_mysqli;

		if($type == NULL)
		$sql = "SELECT * FROM `{$this->_tb_users}` WHERE `hash_login` = '{$who}'";
	    else 
		$sql = "SELECT * FROM `{$this->_tb_users}` WHERE `hash_login_mail` = '{$who}'";


		$conn->query($sql);
		$n = $conn->affected_rows;

		if ($n > 0) {
			return true;			
		} else {
			return false;			
		}

	}


	public function logout ($user) {

		$user = ($user == "me") ? $_COOKIE["user"] : $user;


		$uid = $this->consult('uid', $user);
		$token = genToken("{$uid}|{$user}|logout");
		$this->update($user, 'login', 'nope');
		$this->update($user, 'token', $token);

		setcookie('uid', '', time() - 3600, '/');
		setcookie('user', '', time() - 3600, '/');
		setcookie('activity', '', time() - 3600, '/');
		setcookie('dev', '', time() - 3600, '/');


		if (isset($_COOKIE['token'])) {
			setcookie('token', '', time() - 3600, '/');
		} else {			
			unset($_SESSION['token']);			
		}

		session_destroy();


		return true;

	}


	private function logout_duplicate ($user) {
			

		setcookie('uid', '', time() - 3600, '/');
		setcookie('user', '', time() - 3600, '/');

		if (isset($_COOKIE['token'])) {
			setcookie('token', '', time() - 3600, '/');
		} else {			
			unset($_SESSION['token']);
			session_destroy();
		}
		return true;

	}

	private function compare_tokens($tk,$ntk,$uid,$user){

		$tk = base64_decode($tk);
        $ntk = base64_decode($ntk);
		$tk = explode('|', $tk);					
		$ntk = explode('|', $ntk);


		if(                 
		     ($tk[0] == $ntk[0]) && //uid
			 ($tk[1] == $ntk[1]) && //user
			 ($tk[2] == $ntk[2]) && //pass
						//	($tk[3] == $ntk[3]) && //date
			 ($tk[4] == $ntk[4]) && //ip
			 ($tk[5] == $ntk[5]) && //type
			 ($tk[6] == $ntk[6]) && //os
			 ($tk[7] == $ntk[7]) && //nav

			 ($tk[0] == $uid) && // UID actual
			 ($tk[1] == $user) // usuario actual
			)
		  return true;
		else
		 return false;


	}


   public function isLoged($user){   		

   		$rs = $this->login($user);
   		return $rs;


   }


  private function doHash( $pass , $salt){

  	        $pass = hash('sha256', $pass . $salt); 
            
            for($round = 0; $round < 65536; $round++) 
            { 
                $pass = hash('sha256', $pass . $salt); 
            } 


            return $pass;

  }


	public function login ($user) {


		if (is_array($user)) {
			
			$keep = $user['keep'];
			$pass = $user['password'];
				
			$user = htmlentities($user['username'], ENT_QUOTES, 'UTF-8'); 

			

		if ($this->exist($user) OR $this->exist($user, "mail")) {



			if(filter_var($user,FILTER_VALIDATE_EMAIL))
			  $salt = $this->consult("salt", $user, "email");			 
			else
			  $salt = $this->consult("salt", $user);
			


			$pass = $this->doHash($pass,$salt);

			

			$hash_login = md5(delespecialchars($user)) . $pass;
			$hash_login_mail = md5($user) . $pass;

		
			
				
				if ($this->auth($hash_login) OR $this->auth($hash_login_mail, "mail")) {

				

					if(filter_var($user,FILTER_VALIDATE_EMAIL))
					$user = $this->consult('username', $user, 'email');

					$uid = $this->consult('uid', $user);
					$token = genToken("{$uid}|{$user}|{$pass}");

					$this->update($user, 'login', 'yep');
					$this->update($user, 'token', $token);

				

					if ($keep == 'keep') {
						
						setcookie('uid', $uid, time() + 31536000, '/');
					    setcookie('user', $user, time() + 31536000, '/');
						setcookie('token', $token, time() + 31536000, '/');

					} else {



						setcookie('uid', $uid, time() + 3600, '/');
					    setcookie('user', $user, time() + 3600, '/');					    	
						
						$_SESSION['token'] = $token;					    
						
						
					}
					
						                 

					return true;

				
				} else {

					$this->_error = 'Datos de acceso incorrectos';
					return false;

				}

			} else {
				
				$this->_error = "Datos de acceso incorrectos";
				return false;

			}

		} else {


		  if($user == "me"){
			
			if(isset($_COOKIE["user"]))
			  $user = $_COOKIE["user"];
			else
			  $user = "anonymous";	

		    }
	

			if ($this->exist($user) OR $this->exist($user, "mail")) {

				$token = $this->consult('token', $user);

				$uid = $this->consult('uid', $user);
				$pass = $this->consult('password', $user);
				$newToken = genToken("{$uid}|{$user}|{$pass}");

				if (isset($_COOKIE['token'])) {

					if ($_COOKIE['token'] == $token) {



						if ( $this->compare_tokens($token,$newToken,$uid,$user) ) {

							$this->update($user, 'token', $newToken);
							setcookie('token', $newToken, time() + 31536000, '/');
							return true;

						} else {
							$this->logout($user);
							$this->_error = 'invalid token';
							return false;
						}


					} else {
						$this->logout($user);
						$this->_error = 'invalid token';
						return false;
					}

				} else {		

					if (isset($_SESSION['token'])){
					
					if ($_SESSION['token'] == $token) {
						$this->update($user, 'token', $newToken);
						$_SESSION['token'] = $newToken;
						return true;
					 }else{

					 	$this->logout_duplicate($user);
						$this->_error = 'invalid token';
						return false;

					 }

					} else {

						$this->logout($user);
						$this->_error = 'invalid token';
						return false;

					}

				}

			} else {
				$this->_error = "Datos de acceso incorrectos";
				return false;
			}
		}
	}

}


if(1 > 2){

 $user = new User();
 $data = (isset($_POST["data"])) ? json_decode($_POST["data"]) : array();

    switch ($_GET["cmd"]) {

    	case 'register':

    	       $data = array(

    	       		"username" => "serviaseo",
    	       		"email" => "admin@serviaseo.com.co",
    	       		"password" => "#serviaseo.2014.sa",
    	       		"name" => "Serviaseo S.A. E.S.P."

    	       	);
    			    						
    			if($user->register($data))
    				json(1,array());
    			else
    	   	        json(0,array("msg" => $user->_error));

    		break;


    	case 'login':  

    		$data = array(

    			"username" => "info@gomosoft.com",
    			"password" => "p455w0rd",
    			"keep" => ""

    			);    	


    	   if($user->login($data))
    	   	 json(1,array());
    	   else
    	     json(0,array("msg" => $user->error()));

    	
    	break;


    	case 'logout':

    	$user_ = $_COOKIE["user"];


    	if($user->logout($user_))
    		 json(1,array());
    	 else
    	   	  json(0,array("msg" => $user->error()));

    	break;


    	case 'isloged':

    	   $user_ = $_COOKIE["user"];    	   

    	   if($user->login($user_))
    	   	  json(1,array());
    	   else
    	   	  json(0,array("msg" => $user->error()));


    	break;


    	case 'exist':
    

    	if($user->exist("info@gomosoft.com", "mail"))
    		echo "si";
    	else
    		echo "no";

    	break;
    	    

    }


}