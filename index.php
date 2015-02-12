<?php
  header("Content-type: text/html; charset: UTF-8");
  header("Cache-Control: must-revalidate");
  $offset = 60 * 60 * 24 * 8;
  $ExpStr = "Expires: " .
  gmdate("D, d M Y H:i:s",
  time() + $offset) . " GMT";
  header($ExpStr);

   require_once( dirname(__FILE__) . "/config.inc.php");
   require_once( dirname . "/php/get_vista.php");
   require_once( dirname . "/php/load_cont.php");
   require_once( dirname . "/php/get_head.php");
   require_once( dirname . "/panel/core/php/app.og.php");



   if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();


   
   if(isset($_GET["go"]))
     die($_GET["go"]);


   $vista = get_vista();





  // if( ((dev_mode == "on" OR !web_finished)  && !isset($_SESSION["dev"])) ) 
    //       echo "<script> window.location = '/dev' </script>";


  if(isset($_COOKIE["dev"])){     


      include(dirname . "/panel/core/php/users_api.php");      
      $user_api = new User();

      if(! ( chkLogin($user_api,'','return') && ($_COOKIE["activity"] == $_COOKIE["dev"])) AND  base64_decode($_COOKIE["dev"]) != $_COOKIE["activity"]  ) 
          echo "<script>window.location = 'dev_off' </script>";    
          
        if(!isset($_COOKIE["dev"]))
          setcookie("dev", base64_encode($_COOKIE["dev"]), time() + 3500, "/");   
        else
          setcookie("dev", $_COOKIE["dev"], time() + 3500, "/");   



  }



?>

<!DOCTYPE html>
<html lang='es-CO'
      xmlns:og="http://ogp.me/ns#">

   <head>

   	<meta charset="utf-8" />

      <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">


     <?php 
     


     $page = explode("/", $_SERVER["REQUEST_URI"]);
     $page = end($page);
     $page = (strlen($page) === 0) ?  "Inicio | " . site_name . " " . substr(site_short_description, 0, 250) : ucfirst($page) . " | " . site_name . " " . substr(site_short_description, 0, 250);
    
    echo graph($page, site_name, substr(site_seo_description, 0, 250) . "...", path . "/themes" . theme_dir . "/img/og.png");
     echo str_replace("%title%", $page, get_head()); 

     ?>
     <link rel="icon" href="favicon.ico" type="image/x-icon" />

     <script type="text/javascript" src="js/less.js"></script>
     <script type="text/javascript" src="js/jquery.js"></script>

       <!--[if lt IE 9]>
      <script src='http://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
    <![endif]-->
    
    <script type="text/javascript">

      var page = <? echo "'{$page}'" ?>;
          page = page.split("|")[0].replace(/ /g,"").toLowerCase();  
          page = (page === "contacto") ? "servicio-al-cliente" : page;                
          


    </script>
    
  </head>

   <body id="main" style="padding:0; margin:0">


         <h1 style="display:none"><? echo substr(site_seo_description, 0, 250) . "..."; ?></h1>


           <?php 

              if(isset($_COOKIE["dev"]) ) { 
                
                echo file_get_contents(server_root . path . "/panel/vistas/editor_avanzado.html");

              }

              ?>

 

     <?php 

       load_cont($vista);


     ?>

  

    <?php if(isset($_COOKIE["dev"]) ):?>
       <script src='js/editable_controller.js'></script>
    <?php endif; ?>

     

           <?php 

              if(isset($_COOKIE["dev"]) ) { 
                
                echo file_get_contents("http://scholes-store.com/panel/vistas/medios.php?ext=true");
                echo '<script type="text/javascript" src="panel/js/parser.js"></script>';
                echo '<script type="text/javascript" src="panel/js/editorhtml5.js"></script>';
                echo '<script type="text/javascript" src="panel/js/sidebar.js"></script>';
                echo '<script type="text/javascript">
                    var editor = new wysihtml5.Editor("textarea", {
                                      toolbar:      "toolbar",
                                      parserRules:  wysihtml5ParserRules,
                                      html : true,
                                      color : true,
                                      locale: "es-ES",
                                      stylesheets : ["panel/css/editor.css"],
                                      spellcheck : true
                                  });
                      
             

                </script>';                


                 }

           ?>

       
    <script>
        
          $("a[href=\"" + page + "\"]").addClass("active");

    </script>

   </body>

</html>