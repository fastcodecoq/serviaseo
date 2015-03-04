<?php

		if($_SERVER["SERVER_NAME"] != "localhost"){
	    define("burl","http://" . $_SERVER["SERVER_NAME"]);
	    define("dpath","");
	     }
	    else{
	    
	    define("burl","http://" . $_SERVER["SERVER_NAME"] );
	    define("dpath","/cms2lite");

	     }


		define("server_root", $_SERVER["DOCUMENT_ROOT"]);
		define("path", "/panel");
		define("theme","serviaseo");

		define("theme_dir","/serviaseo");
