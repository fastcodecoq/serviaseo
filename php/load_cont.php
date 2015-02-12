<?php
session_start();

$path = dirname(__DIR__);

require_once(  $path . "/config.inc.php");



function load_cont($vista){

  $path = dirname(__DIR__);




$b_view = file_get_contents( $path . "/themes" . theme_dir . "/index.html" , true); 
$cont = file_get_contents( server_name .  path . "/themes" . theme_dir . "/pages/". $vista , true); 
$sview = file_get_contents( server_name .  path . "/themes" . theme_dir ."/pages/sliders.html" , true);
$vars = array();
$msg_seo = "Regalos en cartagena Sorprende a esa persona que tanto quieres enviándole un regalo a la puerta de su casa u oficina. Con SCHOLES STORE puedes darle un detalle a ese ser querido en cualquier fecha especial a cualquier hora del día, solo comunícate con nosotros para decirnos que quieres regalar y a donde debemos llevarlo. ";
$logo = "http://gomosoft.com/cdn/img/logos/logo-grande.png";

//Google Analytics

$title = $vista;
$pga = false;
$dname = dname;
$ua = "UA-23677861-1";
$ganalytics = "<script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '{$ua}']);
  _gaq.push(['_setDomainName', '{$dname}']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";





 
 if(preg_match("/^.+[.].+\?/i", $vista)) 
   {

      $temp = explode("?",$vista);
      $vista = $temp[0];

      $temp = explode("=",$temp[1]);

      $vars["id"] = $temp[1];      

   } 

      if(preg_match("/%print_sliders:.*%|%print_sliders%/i", $sview, $flag)){        

        
        $surl = server_name . path . "/panel/core/php/app.getSliders.php";         


        $sliders = json_decode(file_get_contents($surl));
        $sliders = $sliders;



        $flag_is_cmd = (count(explode(":",$flag[0])) > 1) ? 1 : -1; 
        
        if(is_array($flag_is_cmd)){
        
        $tagName = explode(":",$flag[0]);
        $tagName = $tagName[1];

        }
        else
          $tagName = "";

        if(is_object($sliders))
        $sliders = $sliders->rs;


        $si = "";
        $sf = "";
        $ss = "";
        
        
     switch ($tagName) {
       
       case 'ul':
         
         $si = "<ul>";
         $sf = "</ul>";
         $imgf = "<li>%img%</li>";

         break;

      case 'div':

        $si = "<div>";
        $sf = "</div>";
        $imgf = "%img%";


      break;

      case 'a':

        $si = "<a href='%href%'>";
        $sf = "</a>";
        $imgf = "%img%";


      break;
       
       default:
           $si = "";
           $sf = "";
           $imgf = "%img%";

         break;
     }        

      if(is_array($sliders))
        foreach ($sliders as $s) {

           $img = $s->slider;                                  
           $ss .=  str_replace("%img%", "<img src='f/". $img ."' alt=''  />", $imgf);

        }
        
        $slds = $si . $ss . $sf;  

        
        $sview = preg_replace("/%print_sliders:.*%|%print_sliders%/i", $slds, $sview);   
        //$sview = str_replace("%print_sliders%", $slds, $sview);
        

      }

      if(preg_match("/%print_info_cont%/i", $cont)){

        $promos = file_get_contents(server_root . path . "/themes" . theme_dir . "/pages/promos.html");

        $cont = str_replace("%print_info_cont%", $promos, $cont); 

      }

      if(preg_match("/%print_pops%/i", $cont)){      

        $pops = file_get_contents(server_root . path . "/themes" . theme_dir . "/pages/pops.html");


        if(!preg_match("/%noprint_cart%/i", $cont))
        $pops .= file_get_contents("js/cart/layout/cart-widget.html");

        $cont = str_replace("%print_pops%", $pops, $cont);   

      }

      if(preg_match("/%print_side_bar%/i", $cont)){


        $side_bar = file_get_contents(server_root . path . "/themes" . theme_dir . "/pages/lateral.php");

        $cont = str_replace("%print_side_bar%", $side_bar, $cont); 

       }  


       if(preg_match("/%print_slider%/i", $cont)){
        

        $cont = str_replace("%print_slider%", $sview, $cont); 

       }  






       if(preg_match("/%print_plugins%/i", $cont)){


        $plugins = "<script src='js/LSutil.js'></script>" .
                   "<script src='js/cart/index.js'></script>";


        $cont = str_replace("%print_plugins%", $plugins, $cont); 

       }  
        



       switch($vista)
       {

        case "home.php":

   

        break;


        case "producto.php":

        $id = $vars["id"];

        $con = new Mongo();
        $bd = $con->scholes;
        $_id = new MongoId($id);

        $col = $bd->productos;

        $p = $col->findOne(array( "_id" => $_id));
        $fotos = explode(";",$p["fotos"]);
        $portada = '<img id="prev-thumb" src="/t/250/' . $fotos[0] . '" alt="' . $p["nombre"] . '" data-zoom-image="/f/' . $fotos[0] . '" class="zoom" />';
        $thumbs = "";
        $t_molde = '<div class="span12 p_thumb" style="margin-left:0;max-height: 75px; overflow: hidden;"><a href="#prev_thumb" class="elevatezoom-gallery" data-zoom-image="/f/%src%" data-image="/t/250/%src%" ><img src="/t/150/%src%" alt="%nombre%"  /></a></div> ';
        $descripcion = str_replace("\n", "<br />", $p["descripcion"]);
        $descripcion = str_replace("\t", "  ", $descripcion);
        
        foreach ($fotos as $thumb) {
              
              $tt = $t_molde;
              $tt = str_replace("%src%", $thumb, $tt);
              $tt = str_replace("%nombre%", $p["nombre"], $tt);
              $thumbs .=   $tt; 

        }

        $cont = str_replace("%print_nombre%", $p["nombre"], $cont);
        $cont = str_replace("%print_precio%", "$" . number_format($p["precio"],0,"","."), $cont);
        $cont = str_replace("%print_portada%", $portada, $cont);
        $cont = str_replace("%print_portada_src%", $fotos[0], $cont);
        $cont = str_replace("%print_desc%", $descripcion, $cont);
        $cont = str_replace("%print_thumbs%", $thumbs, $cont);
        $cont = str_replace("%print_id%", $id, $cont);

        break;

        

       }





              



        if(preg_match("/%print_msg_seo%/i", $b_view)){

        $b_view = str_replace("%print_msg_seo%", $msg_seo, $b_view); 

       }  
 

        if(preg_match("/%print_logo%/i", $b_view)){

        $b_view = str_replace("%print_logo%", $msg_seo, $b_view); 

       } 


         if(preg_match("/%print_header%/i", $b_view)){

          $html = file_get_contents($path . "/themes" . theme_dir . "/pages/header.php");
          $b_view = str_replace("%print_header%", $html, $b_view);

         }  


      

         if(preg_match("/%print_foot%/i", $b_view)){

          $html = file_get_contents($path . "/themes" . theme_dir  . "/pages/foot.php");
          $b_view = str_replace("%print_foot%", $html, $b_view);

         }  

        if(preg_match("/%print_content%/i", $b_view)){

          
          $b_view =  str_replace("%print_content%", $cont, $b_view);

         }  


         if(preg_match("/%theme_path%/i", $b_view)){

          
          $b_view =  str_replace("%theme_path%", "themes" . theme_dir  , $b_view);

         }  

          if(preg_match("/{{theme_path}}/i", $b_view)){

          
          $b_view =  str_replace("{{theme_path}}", "themes" . theme_dir   , $b_view);

         }  

      

     if(!isset($_COOKIE["dev"]))
       $b_view = preg_replace("/%.+%/", "", $b_view);
     else{

        $b_view = str_replace("%editable%", "data-role='editable' title='editar' contenteditable", $b_view);
        preg_match_all("/%vista:.+%/", $b_view, $rs);

        $rs = $rs[0];
    
     foreach ($rs as $r) {

        $r = explode(":",$r);
        $r = $r[1];
        $r = str_replace("%", "", $r);
    

        $b_view = preg_replace("/%vista:[a-zA-Z0-9._-]*%/i", "data-role='vista' data-view='$r'", $b_view, 1);


      }


    }

 //cargamos los JS globales antes del body


       if(preg_match("/%print_global_js%/i", $b_view)){

         $plugins = '
         
       <script src="js/mouseTrap.js"></script>  
       <script src="js/controlador.js"></script> 
       <script src="/js/sidebar-controller.js"></script> 

      <script>

       function showLogo(){

        console.log("mostrando");

          $("#gomosoft").fadeIn( function(){


              var interval = setInterval( function(){


                    hideLogo();
                    clearInterval(interval);   


               }, 1200);

          });

       }


       function hideLogo(){

        console.log("ocultando");

         $("#gomosoft").fadeOut( function(){

             window.open("http://gomosoft.com");

         });

       }

        function iniAnimation(){

             showLogo();

        }

        Mousetrap.bind("g o m o s o f t",function(){

                iniAnimation();      

        });

      </script>';
      
         if($pga)
          $plugins.= $ganalytics;

        $b_view = str_replace("%print_global_js%", $plugins, $b_view); 

       } 


         echo $b_view;


     }


    