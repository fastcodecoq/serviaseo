<?php 

include("util.php");
include("app.mailer.php");

//orders



class order{

	private $con;
	private $cursor;
	private $lang;


	function __construct($lang = "es-CO"){


		 $this->con = new Mongo();
		 $this->con = $this->con->selectDB($dbname);

		 $this->cursor = $this->con->orders;

		 $this->lang = $lang;


	}




	public function send_order($data, $products, $mail_cont ){

	    	$data =  json_decode($data, true);
	    	$products=  json_decode($products, true);
	    	$order_id = "SCH-" . substr(md5(date("w j-m-Y g:i:s:a")),0,5);


	    	$query = $this->validate($data);
	    	unset($query["remember"]);
	    	
	    	if(!$query)
	    		json(0,array("msg" => "Datos invalidos"));
	    	else{

	    	$query["order_id"] = $order_id;
	    	$query["accepted"] = 0;
	    	$query["tracking"] = "";
	    	$query["weight"] = "";	  
	    	$query["send_date"] = date("Y/m/d");
	    	$query["send_hour"] = date("g:i:s a");   	
	    	$query["status"] = "preparing";	    	   

	    	$prods = array();
	    	$prods["order_id"] = $order_id;
	    	$prods["products"] = array();
	    	$total = 0;

	    	foreach ($products as $p) {
	    			
	    			$pr = array();
	    			$pr["id"] = $p["id"];
	    			$pr["quantity"] = $p["quantity"];
	    			$pr["image"] = $p["image"];	    			
	    			$pr["price"] = $p["price"];	    			
	    			$pr["name"] = $p["name"];	    

	    			$total += (int) $p["price"];			

	    			array_push($prods["products"], $pr);

	    	}

	    	$query["total"] = $total;

	    	if($this->save($query, $prods)){
	    	
	    	  $mail = new mail_;

	    	  if($this->lang == "es-CO") { 

	    	  $details = "<br /> <br />";
	    	  $details .= "Apreciado(a) <b>" . $query["name-sender"] . "</b>,";
	    	  $details .= "<br /> <br />";	    	  
	    	  $details .= "Estamos muy felices de que nos hallas permitido hacer negocios contigo. A continuación los detalles de tu orden: <br /><br />";
	    	  $details .= "N° Orden: <b>" . $query["order_id"] . "</b> <br />";
	    	  $details .= "Recibe: <b>" . $query["name-delivery"] . "</b> <br />";
	    	  $details .= "Tel: " . $query["tel-delivery"] . " <br />";
	    	  $details .= "Dirección: " . $query["address-delivery"] . "</b> <br />";
	    	  $details .= "Ciudad: " . $query["city-delivery"] . " <br />";
	    	  $details .= "<br /> <br />";	 
	    	  $details .= "<br /> ";	 


	    	  $details_ = "<br /> <br />";
	    	  $details_ .= "Hola tenemos una nueva orden,";
	    	  $details_ .= "<br /> <br />";	    	  
	    	  $details_ .= "El cliente <b>" . $query["name-sender"] . "</b> ha realizado una orden en Scholes-store.com. A continuación los detalles la orden: <br /><br />";
	    	  $details_ .= "N° Orden: <b>" . $query["order_id"] . "</b> <br />";
	    	  $details_ .= "Envía: " . $query["name-sender"] . " <br />";
	    	  $details_ .= "Ciudad: " . $query["city-sender"] . " <br />";
	    	  $details_ .= "Tel: " . $query["tel-sender"] . " <br />";
	    	  $details_ .= "email: " . $query["email-sender"] . " <br />";
	    	  $details_ .= "<br /> <br />";	    	  	    	  
	    	  $details_ .= "Recibe: " . $query["name-delivery"] . " <br />";
	    	  $details_ .= "Tel: " . $query["tel-delivery"] . "<br />";
	    	  $details_ .= "Dirección: " . $query["address-delivery"] . " <br />";
	    	  $details_ .= "Ciudad: " . $query["city-delivery"] . " <br />";
	    	  $details_ .= "email: " . $query["email-delivery"] . " <br />";
	    	  $details_ .= "<br /> <br />";	 
	    	  $details_ .= "Mensaje personalizado: " . $query["custom-msg"];	 	    	    	  	    	 
	    	  $details_ .= "<br /> <br /><br />";	   	  	   

	    	  }else if($this->lang == "en-US"){


	    	  	$details = "<br /> <br />";
	    	  $details .= "Dear <b>" . $query["name-sender"] . "</b>,";
	    	  $details .= "<br /> <br />";	    	  
	    	  $details .= "We are very happy that we find yourself allowed to do business with you. Here are the details of your order: <br /><br />";
	    	  $details .= "Order N°: <b>" . $query["order_id"] . "</b> <br />";
	    	  $details .= "Recieve: <b>" . $query["name-delivery"] . "</b> <br />";
	    	  $details .= "Tel: " . $query["tel-delivery"] . " <br />";
	    	  $details .= "Address: " . $query["address-delivery"] . "</b> <br />";
	    	  $details .= "City: " . $query["city-delivery"] . " <br />";
	    	  $details .= "<br /> <br />";	 
	    	  $details .= "<br /> ";	


	    	  }  	  


	    	  $content = $details . $mail_cont . "<br /> <br /><a href=\"http://scholes-store.com/formas-de-pago\" > Formas de págo </a>";
	    	  $content_ = $details_ . $mail_cont . "<br /> <br />";

	    	  if($mail->send($content , $query["email-sender"], $query["name-sender"])){

	    	  	 $mail->clean_header();

	    	  	  if($mail->send($content_))
	    	    	json(1,$query);
	    	      else
	    	      	json(0,"");

	    	     }


	    	   }
	    	else
	    	    json(0,array("msg" => "Problemas almacenando orden"));	

	      }

	}



	private function save($data, $products){
	  	
	  	$cursor_p = $this->con->products_selled;

	try {

		if($this->validate($data))
		 if($this->cursor->insert($data)  && $cursor_p->insert($products) )
		   return true; 
		  else
		   return false; 	
	  else
	  	return false;
    	
     
     } catch(MongoCursorException $e) { 

     	return false;

      }

	  
	   

	}



	private function validate($data){
		    		
		    $return = array();

			foreach ($data as $val) {


				if(isset($val["require"]))
					if($val["require"] == "require"  &&  empty($val["value"]))						
							return false;													
                   
                  if(isset($val["name"])){

					if(preg_match("/mail/", $val["name"]))
						if(!filter_var($val["value"], FILTER_VALIDATE_EMAIL))							 
							 	return false;		

			 	 $return[$val["name"]] = htmlentities($val["value"], ENT_QUOTES, 'UTF-8');

			 	   }

			 }



			 return $return; 

	}


	



}



if($_POST)
{

  if(isset($_POST["products"]) && isset($_POST["fact_delivery"]))
   {
	
	$app = new order;
	$prods = $_POST["products"];
	$fact = $_POST["fact_delivery"];
	$mail_cont = $_POST["mail"];

    $lang = isset($_POST["lang"]) ? $_POST["lang"] : "es-CO";

	$app->send_order($fact, $prods, $mail_cont, $lang);

   }

}

