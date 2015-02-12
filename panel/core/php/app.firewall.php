<?

require_once(dirname(__FILE__) . "/users_api.php");

$user_api = new User();

var_dump($user_api);
 
 try{
 if(chkLogin($user_api,'','return'))   
   	throw new Exception("Acceso denegado:7", 1);   	   
}catch(Exception $e){
      echo json_encode(["error" => $e->getMessage()]);
      die;
}