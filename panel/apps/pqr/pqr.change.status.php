<?
header("Content-type: application/json; charset=utf-8");
require_once("../../core/php/config.inc.php");


class pqr{
	
	protected $col;

	public function __construct(){

		$con = new MongoClient();
		$db = $con->selectDB(dbname);
		$this->col = $db->pqrs;
		
		$this->run();

	}

	protected function run(){

		 if(!isset($_POST["status"]) || !isset($_POST["id"]))
		 	throw new Exception("bad request:19");
		 
		 extract($_POST);

		 $status = (int) strip_tags($status);
		 $id = strip_tags($id);
		 $col = $this->col;
		 $query = array("_id" => new MongoId($id));
		 $set = ['$set' => ["status" => $status]];
		 $upsert = ['upsert' => true];

		 $rs = $col->update($query, $set, $upsert);

		 if(!$rs)
		 	throw new Exception("erorr:no se cambio el estado:31");
		 else
	       echo json_encode([]);				 

	}

}

try{

 new pqr;
	
}catch(Exception $e){
	echo json_encode(["error" => $e->getMessage()]);
}