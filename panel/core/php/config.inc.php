<?php

//Rutas
	define('SUBDIR', '/panel');
	define('DOMAIN', $_SERVER['SERVER_NAME'] . '/' . SUBDIR);
	define('DURL', 'http://' . DOMAIN);
	define("PATH", dirname(__FILE__) );

	if($_SERVER["SERVER_NAME"] != "localhost"){
	    define("burl","http://" . $_SERVER["SERVER_NAME"]);
	    define("dpath","");
	     }
	    else{
	    
	    define("burl","http://" . $_SERVER["SERVER_NAME"] . "/itversion6");
	    define("dpath","/fasalud");

	     }

	define('INPHP', PATH . 'includes/php/');
	define('INCLASS', PATH . 'includes/class/');
	define('INAPPS', PATH . 'includes/apps/');

	define('INLANGS', DURL . 'includes/langs/');
	define('TOAPPS', DURL . 'includes/apps/');
	define('TOGUIAPPS', DURL . 'includes/guiapps/');
	define('TOPHP', DURL . 'includes/php/');
	define('TOJS', DURL . 'includes/js/');
	define('TOLESS', DURL . 'includes/less/');
	define('TOIMG', DURL . 'includes/img/');

	// Configuración regional

	date_default_timezone_set("America/Bogota");
	define('LANG', 'es_CO');

	//Conexión MySQL
	define('DB_SERVER', 'localhost');
	define('DB_USER', 'gomosoft');
	define('DB_PASS', 'p455w');
	define('DB_BASEDATA', 'gomoCMS');

	//Prefijo
	define('PREFIX', 'serviaseo_');
	define('dbname', "serviaseo");

	//Tablas
	define('TB_USERS', PREFIX . 'users');
	define('TB_SESSIONS', PREFIX . 'sessions');
	