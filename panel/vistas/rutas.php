<div class="span12 formulario" style="width:97% !important; margin-left:2em">	
	<br>
     <form class="formulite" data-route-form>
     	 <label>
     	 	 <span>Sede</span>
     	 	 <select name="sede">
     	 	 	 <option value="0">Corozal</option>
     	 	 	 <option value="1">Chinu</option>
     	 	 	 <option value="2">El Carmen</option>
     	 	 	 <option value="3">Magangue</option>
     	 	 	 <option value="4">Sampues</option>
     	 	 	 <option value="5">San Onofre</option>     	 	 	 
     	 	 </select>
     	 </label>
     	 <label>
     	 	 <span>Día</span>
     	 	 <select name="day" data-days></select>
     	 </label>
     	 <label>
     	 	 <span>Hora de Inicio de recogida</span>
     	 	 <select name="start" data-hours></select>
     	 </label>
     	 <label>
     	 	 <span>Hora de finalización de recogida</span>
     	 	 <select name="end" data-hours></select>
     	 </label>
     	 <label>
     	 	 <span>Barrios</span>
     	 	 <textarea placeholder="Escribe aquí los barrios separados por comas" name="zone"></textarea>
     	 </label>
     	 <br>
     	 <a href="#" class="optt" data-trace-route>Trazar Ruta</a>
     	 <input type="submit" value="Guardar" >
     	 <input type="hidden" name="polygone">
     </form>
		
     

</div>

 <div id="map-wrap">
      	 <div style="position:absolute; left:0; bottom:20px; width:100%; z-index:2000">
      	 	<br>
      	 	<div class="controlator toCenter">
      	 	<a href="#" class="top-optt" data-cancel-route>Cancelar</a>       	 		
      	 	<a href="#" class="top-optt" data-restart-route>Reiniciar</a> 
          <a href="#" class="top-optt" data-add-other>Agregar Zona</a>         
      	 	<a href="#" class="top-optt" data-asig-route>Asignar</a> 
      	   </div>
      	 </div>
      	 <div id="map">
      	 </div>
      </div>

      <script src="//maps.googleapis.com/maps/api/js?sensor=true&callback=inimap"></script>          
      <script src="//google-maps-utility-library-v3.googlecode.com/svn/trunk/geolocationmarker/src/geolocationmarker-compiled.js"></script>
      <script src="/panel/js/map.controller.js"></script>



      <script type="text/javascript">

      $.fn.hours = function(){

      	  for( i = 1 ; i < 24 ; i ++)
      	  {	
      	  	 var ampm = (i < 12 ) ? "am" : "pm";
      	  	 var hour = (i < 12) ? i : i - 12;
      	  	 $(this).append("<option value='{{hour}}'>{{hour}}</option>".replace(/\{\{hour\}\}/g, hour + ":00 " + ampm));
      	  	 $(this).append("<option value='{{hour}}'>{{hour}}</option>".replace(/\{\{hour\}\}/g, hour + ":30 " + ampm));
      	  }

      	  	 $(this).append("<option value='{{hour}}'>{{hour}}</option>".replace(/\{\{hour\}\}/g, "12:00 am" ));
      }

      $.fn.days = function(){

      	  var days = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Domingo"];

      	  for( x in days)      	
      	     if(days[x])        	  	 
      	   	  $(this).append("<option value='"+x+"'>{{day}}</option>".replace(/\{\{day\}\}/g, days[x]));      	  
      	  	 
      }

      function route_controller(){
      	
         $(this).removeClass("trace-ok");
      	 $("#map-wrap").addClass("visy");    
      	 create_zone_in_map();
         toCenter();                
         

      }

      function asig_controller(){

      	points = save_created_zone();
      	if(points.length === 0){
      		 dialog.show("No hay ruta para asignar");
      		 return false;
      	}
      	$("#map-wrap").removeClass("visy");      	
      	points = JSON.stringify(points);

      	$("input[name='polygone']").val(points);
      	$("[data-trace-route]").addClass("trace-ok");

      }

      function save(e){
      	e.preventDefault();

      	var data = {
      		 sede : parseInt($("select[name='sede']").val()),
      		 day : parseInt($("select[name='day']").val()),
      		 start : $("select[name='start']").val(),      		 
      		 end : $("select[name='end']").val(),      		       		
      		 zone : $("textarea[name='zone']").val(),
      		 polygone : $("input[name='polygone']").val()      		       		
       	};

       	if(empty(data.polygone))
       		{	
       			dialog.show("Debes definir una ruta para poder guardar");
       			return false;
       		}


          if(empty(data.zone))
          { 
            dialog.show("Debes especificar los barrios de la ruta");
            return false;
          }


       	$.ajax({
       		url : "/panel/core/php/route.php?save",
       		data : data,
       		type : "POST",  
          dataType : "JSON",    		
       		success : saved,
       		error : fail      
       	});

       	function saved(rs){
          
          if(rs.success === 0)
          {
             dialog.show(rs.message);
             return false;
          }

          dialog.show("Se ha salvado la ruta");
          $("[data-route-form]").reset();
          window.zones = [];
          $("[data-trace-route]").removeClass("trace-ok");
          inimap();
          console.log(rs);

          }

       	function fail(err){ console.log(err);}


      	return false;
      }

      function empty(str)
      {
      	 return !/\w+/g.test(str);
      }

      function cancel_trace(){
      	inimap;
      	$("#map-wrap").removeClass("visy");

      }

      function restart_route(){
         inimap();
         create_zone_in_map();         
      }

      function inicia(){
      	 
      	  $("[data-hours]").hours(); 
      	  $("select[name='sede']").change(inimap);     	
      	  $("[data-days]").days();      	
		  $("[data-trace-route]").live("click", route_controller);
		  $("[data-asig-route]").live("click", asig_controller);
		  $("[data-restart-route]").live("click", restart_route);
		  $("[data-cancel-route]").live("click", cancel_trace);
      $("[data-route-form]").live("submit", save);
		  $("[data-add-other]").live("click", add);

      }

      $(inicia);
      </script>