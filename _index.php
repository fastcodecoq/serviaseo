<!DOCTYPE html>
<html lang="es-CO">
   
      <head>
   	  <meta  charset="utf-8">
      <title>Fasalud Cisnes</title>  
      <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
                            


      <link rel="stylesheet/less" type="text/css" href="less/default.less">

   	  <script type="text/javascript" src="js/less.js"></script>


   </head>
   
   <body>
    
    <div id="container" >

   	 <header>
   	      
   	      <? include("pages/header.php"); ?>
   	      
   	 </header>

   	 <section id="info-wraper">

   	 	   <? include("pages/slider.html"); ?>

   	 		<br />
   	 		<br />
   	 		<br />
   	 		<br />

   	 		<section id="info">
   	 		
   	 			<? include("pages/resume.php"); ?>


   	 		</section>

   	 		<br />
   	 		<br />
   	 		<br />
   	 		<br />
   	 		<span class="divider" style="width:88%"></span>
   	 		<br />
   	 		<br />
   	 		<br />


          <section id="contacto">

           <? include("pages/contacto.php"); ?>

          </section>

   

   	 </section>

   	 <footer>
   	 	  <? include("pages/foot.php"); ?>
   	 </footer>


   	</div>

   	<script type="text/javascript" src="js/jquery.js"></script>
   	<script type="text/javascript" src="js/carousel.js"></script>
   	<script type="text/javascript" src="js/index.js"></script>   	 	   	 
   	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=es"></script>
   	<script type="text/javascript" src="js/gmap3.js"></script>
  

   	<script type="text/javascript">

   		  ini_controllers();
   		 
   		  function map(){  
   		  	$("#map").gmap3({ map : { 
   		    	options : { 
   		  		zoom : 18 ,
   		  		center:[22.49156846196823, 89.75802349999992],
   		  		mapTypeId: google.maps.MapTypeId.HYBRID,
   		  		navigationControl: true,
     		    scrollwheel: false,     		    
                streetViewControl: true,
                mapTypeControlOptions: {
     	        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                    }
   		        } 
   		     }

   		  });

   		  	     $("#slider").cycle({ 
    fx:     'scrollLeft', 
    speed:  'fast', 
    timeout: 5000, 
    next:   '#next', 
    prev:   '#prev',
    pause: 1,
    continuous : 0
});

   		 }
   		  
   		  $(map);

   	</script>

   </body>

</html>
