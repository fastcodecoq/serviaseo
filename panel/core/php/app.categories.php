<?

require_once(dirname(__FILE__) . "/util.php");
require_once(dirname(__FILE__) . "/config.inc.php");
require_once(dirname(__FILE__) . "/app.mongoController.php");

class categoryException extends Exception{}

class categories extends mongoController{
		
		private $errors;
	

	   public function __construct(){}


	   public function ini(){

	   	  	 $this->errors = array();

			  parent::__construct("categories");	

	   }



		public function save($name, $parent = "none", $child = "none", $slug = "none"){
		 	  
		 	  	 try{

		 	  	  $data = array(
		 	  	  		 "name" => $name,
		 	  	  	);


		 	  	 if(count($this->get($data)) > 0)
		 	  	 	throw new categoryException("Error saving category: Categoy already exists");

		 	  	 $data["parent"] = $parent;
		 	  	 $data["child"] = $child;
		 	  	 $data["slug"] = $slug;
		 	  	 $data["id"] = (int) ($this->getMaxID() + 1);

		 	  	 return $this->insert($data);

		 	  	   }catch ( mongoControllerException $e ){

		 	  	   	   throw new categoryException("Error saving category: " . $e->getMessage() );

		 	  	   }


		 }


		public function removeAll(){ return $this->drop(); }


		public function length(){ return $this->count(); }

		public function getMaxID(){ 
			
			if( $this->length() === 0 )
				return 0;

			$rs = $this->find();
			$rs->sort(array("id" => 1));
			$id = iterator_to_array($rs);
			$id = end($id);
			$id = $id["id"]; 

			return $id; 

		}


		public function get( $query = NULL ){ 
		 	
		 	try{
		 	
		 	 if($query === NULL) $rs = $this->find(); else $rs = $this->find($query); 

		 	 return iterator_to_array($rs);

		 	 }
		 	 catch(mongoControllerException $e){

		 	  	   	   throw new categoryException("Error getting category: " . $e->getMessage() );


		 	 }

		 }



		 public function remove($id){

		 	  try{

		 	  	 $query = array("_id" => new MongoId($id));
		 	  	 return $this->del($query);

		 	  }
		 	  catch(mongoControllerException $e){ 
		 	  	throw new categoryException("Error Deleting category: " . $e->getMessage());
		 	   }

		 }


		  public function edit($id = NULL, $data = NULL){


		 	  try{

		 	  	  if($id === NULL)
		 	  	  	 throw new categoryException("Error editing category, id object is required.");


		 	  	  if($data === NULL)
		 	  	   throw new categoryException("Error editing category, array $data is required.");

		 	  	  if(!isset($data["name"]) && !isset($data["parent"]) && !isset($data["child"]) && !isset($data["slug"]))
		 	  	  	 throw new categoryException("Error editing category, bad array structure.");

		 	  	  	 

		 	  	 $query = array("_id" => new MongoId($id));
		 	  	 return $this->update($query, $data);

		 	  }
		 	  catch(mongoControllerException $e){ 
		 	  	throw new categoryException("Error Deleting category: " . $e->getMessage());
		 	   }

		 }

		 //526f694023100f4b16465070



		 function error(){ return end($this->errors); }


		 function all_errors(){ return $this->errors; }

}


try{


$cat = new categories;
$cat->ini();
//$edit = array( "name" => "Callese careverga!" );

//if($cat->edit($_GET["id"], $edit))

$ctgy = $cat->get();
$ctgy = end($ctgy);

echo $ctgy["name"];



}
catch (categoryException $e){

	 echo $e->getMessage();

}
catch (Exception $e){

	echo "Error desconocido";

}