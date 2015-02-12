<?
header("Content-type: application/json; charset=utf-8");
require_once("../../core/php/config.inc.php");
//require_once("../../core/php/app.firewall.php");



class pqr_stats{
	
	protected $col;

	public function __construct(){

		$con = new MongoClient();
		$db = $con->selectDB(dbname);
		$this->col = $db->pqrs;
		
		$this->run();

	}

	protected function run(){

	  $col = $this->col;

	  $rs = iterator_to_array($col->find());
	  $stats = [0 , 0, 0, 0, 0];	  

	  foreach ($rs as $pqr)
	  	$stats[$pqr["status"]]++;

	  $stats[4]  =  count($rs);

	  echo json_encode($stats);

	}

 }



try{

 new pqr_stats;
	
}catch(Exception $e){
	echo json_encode(["error" => $e->getMessage()]);
}