<?
	 require_once(dirname(__FILE__) . "/config.inc.php" );

    class mongoControllerException extends Exception{}

	class mongoController{

			private $col;			

			function __construct( $collection = "productos"){

				  $con = new MongoClient();
				  $db = $con->selectDB(dbname);


				  $this->col = $db->selectCollection($collection);

			 }


		 protected function insert($data = NULL){

		 	  if($data === NULL)
		 	  	  throw new mongoControllerException("Nothing to insert");
		 	  	  		 	  

		 	  $col = $this->col;

		 	  $q = $col->insert($data);
		 	 
		 	  
		 	 if(is_array($q))
		 		return true;
		 	else 		 	
		 	   return false;

		 }


		 protected function find($query = false){

		 	 if(is_array($query))
		 	 	 return $this->col->find($query);
		 	 else if($query)
		 	 	return $this->col->find($query);
		 	 else if(!$query)
		 	 	return $this->col->find();
		 	 else
		 	 	throw new categoryException("Invalid param for make a search");

		  }


		 protected function del($query, $opts = NULL){

		 	if( $query === NULL )
		 	throw new mongoControllerException("Nothing passed for delete");

		     if($opts === NULL)
		     	$opts = array("justOne" => true);


		 	$col = $this->col;
		 	$q = $col->remove($query, $opts);

		 	if(is_array($q))
		 		return true;
		 	else 		 	
		 	   return false;	

		 }


		 protected function count(){ return $this->col->count(); }

		 protected function drop(){ return $this->col->drop(); }

		 protected function update($query = NULL, $set = NULL, $opts = NULL){

		 $col = $this->col;	

		  if( $query === NULL )
		 	throw new mongoControllerException("Nothing passed for update");	 

		 if( $set === NULL || !is_array($set))
		 	throw new mongoControllerException("Set data is required");

		 if($opts === NULL)
		 	$opts = array("upsert" => false);

           $q = $col->update($query , array('$set' => $set), $opts);		 	

            if(is_array($q))
            	return true;
            else
            	return false;

		 }


		}