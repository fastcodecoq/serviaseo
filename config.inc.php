<?php

 

		if($_SERVER["SERVER_NAME"] === "gomosoft.com")
		{
			
			define("path", "/cms2lite");

		}
	    else if( $_SERVER["SERVER_NAME"] === "localhost" )
		{
			
			define("path", "/serviaseo");
			
		}else if( $_SERVER["SERVER_NAME"] === "serviaseo.com.co"){

			define("path", "");

		}


		define("server_root", $_SERVER["DOCUMENT_ROOT"]);
		define("server_root_abs", dirname(__DIR__));		
		define("theme","serviaseo");
		define("theme_dir","/serviaseo");
		define("dirname", dirname(__FILE__));
		define("dname", $_SERVER["HTTP_HOST"]);
		define("server_name","http://" . $_SERVER["SERVER_NAME"]);

		
		define("site_name", "Serviaseo S.A. E.S.P.");
		define("site_short_description", "Serviaseo empresa ...");
		define("site_seo_description", "Serviaseo empresa...");


		
		define("web_finished",true);

		$con = new MongoClient();
		$bd = $con->fasalud;

		$col = $bd->dev_mode;

		$rs = $col->findOne();		

		define("dev_mode",$rs["status"]);
  

