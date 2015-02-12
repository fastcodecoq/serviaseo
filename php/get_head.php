<?php 


function get_head(){
	
	if($_GET)
	$vista = get_vista($_GET["v"]);
    else
    $vista = "home.php";

 $vars = array();
	
 if(preg_match("/^.+[.].+\?/i", $vista)) 
   {

      $temp = explode("?",$vista);
      $vista = $temp[0];

      $temp = explode("=", $temp[1]);

      $vars["id"] = $temp[1];

   } 

   $dev_resc = "";

   $theme_dir = theme_dir;
   $dirname = dirname;
   $theme_path = "themes" . theme_dir;


   if(isset($_COOKIE["dev"])) 
        $dev_resc = '<link rel="stylesheet/less"  href="panel/less/estilo.less" />
                <link rel="stylesheet/less"  href="panel/less/medios.less" />
                <link rel="stylesheet/less"  href="panel/less/clear-medios.less" />
                <link rel="stylesheet/less"  href="less/estilo.less" />                         
                <link rel="stylesheet/less"  href="panel/less/picker.less" />                         
                <link rel="stylesheet/less"  href="fontAwesome/css/font-awesome.css" />                         
                <link rel="stylesheet/less"  href="css/bootstrap.css" />                         
                         <script src="js/jquery.js" ></script>                         
                         <script src="js/less.js" ></script>                         
                        <script src="js/phpjs.js" ></script>                              
                         <script src="panel/js/consoleIE.js" ></script>
                         <script src="js/dialogs.js" ></script>
                         <script src="js/controll_medios.js" ></script>'; 





    switch($vista){


       case "producto.php":

        $id = $vars["id"];

        $con = new Mongo();
        $bd = $con->scholes;
        $_id = new MongoId($id);

        $col = $bd->productos;

        $p = $col->findOne(array( "_id" => $_id));

        $f = explode(";",$p["fotos"]);
        $f = $f[0];

        return str_replace("%theme_path%", $theme_path, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>%title%</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
      <link rel="stylesheet/less"  href="fontAwesome/css/font-awesome.css" />                         


      <link rel="stylesheet/less" type="text/css" href="%theme_path%/less/default.less">
      
      <script type="text/javascript" src="%theme_path%/js/jquery.js"></script>




');

       break;


       default:

			return str_replace("%theme_path%", $theme_path, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
   <meta name="apple-mobile-web-app-capable" content="yes" />

        
<title>%title%</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
      <link rel="stylesheet"  href="fontAwesome/css/font-awesome.css" />                         
      <link rel="stylesheet" type="text/css" href="%theme_path%/icons/style.css">

      <link rel="stylesheet/less" type="text/css" href="%theme_path%/less/default.less">
      <link rel="stylesheet/less" type="text/css" href="js/datepicker/css/datepicker.css">
    <script type="text/javascript" src="%theme_path%/js/jquery.js"></script>
      


'.$dev_resc);

       break;

    }



}