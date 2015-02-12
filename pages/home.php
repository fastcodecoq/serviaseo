    
    <div id="container" >

   	 <header>
   	      
   	      <? include("pages/header.php"); ?>
   	      
   	 </header>

   	 <section id="info-wraper">

   	 	   %print_slider%

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
   	<script type="text/javascript" src="js/index.js"></script>
   	 	<script type="text/javascript" src="js/gmap3.js"></script>

   	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=es">

   	 	<script type="text/javascript" src="js/gmap3.js"></script>
  

   	<script type="text/javascript">

   		  ini_controllers();
   		  function map(){  $("#map").gmap3({ map : { 
   		  	options : { 
   		  		zoom : 18 ,
   		  		center:[22.49156846196823, 89.75802349999992],
   		  		mapTypeId: google.maps.MapTypeId.HYBRID
   		     } 
   		   }

   		  });

   		 }
   		  $(map);
   	</script>

