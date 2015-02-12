
<div class="span11" style="margin-left:1em">

	<h3 style="margin-left:2em;
display: inline-block">Nuevo Producto</h3> 
<a href='#!/giftcard' class='pull-right'target="_blank" style="margin-right: 5em;">Agregar giftcard <i class="icon-plus"></i></a>
<a href='#!/productos' class='pull-right'target="_blank" style="margin-right: 1em;">Ver Productos <i class="icon-eye"></i></a>
<br>
<br>

	<div class="span12 formulario" style="width:97% !important">

		    <form class="span12" id='producto'>
		    	    <div class="span12" id="prevs" style='margin-left:1em;margin-top:1.5em;'></div>
		     <div class="fotos span4" style="background:#ccc; height:250px">

		    	 <div class="span12">	
		    	 	
		    	 	<a href="#abrir" rel="#medios" class="span12 medio agregar" data-target="#fotos_" data-role="multiple" data-select="ok" data-filter="images">+</a>
		    	 	<small class="span12">Agregar Medios</small>

		    	 </div>

		    	 
		    	 	<input type="text" name="fotos" class="hidden medio_target" id="fotos_" rel='#prevs' data-role='' value="medios"/>

		     </div>

		     <div class="span7">
		    	<div class="android-ui span12"> <input class="span12" type="text" name="nombre" placeholder="*Nombre del producto" pattern="[a-zA-Z]+" /> </div>
		    	<div class="android-ui span12" style="margin-left:0"> <input class="span12" type="text" name="name" placeholder="*Nombre en ingles" pattern="[a-zA-Z]+" /> </div>
		
		    	<ul class="span12 navbar clearfix" style="margin:0; margin-top:2em">
		    		
		    		<li class="nav span8"><div class="android-ui span12 lft"> <input class="span12" type="text" name="precio" placeholder="*Precio $30.000" pattern="[0-9]+"/> </div></li>
		    		<li class="nav span3 pull-right"><div class="android-ui span12 lft"> <input class="span12" type="text" name="cantidad" placeholder="*Cantidad" pattern="[0-9&]+"/> </div></li>		    		
		    		


		        </ul>
  

	

		       	<div class="android-ui span12" style="margin-left:0"> 

		    		<select name="cat" style=' border:0; float-left'>
		    			
		    			<option value="sincat">Sin Categoría</option>		    			
		    			<? echo "<option>Hola</option>"; ?>
		    			
		    		</select>  


		    		<input type="text" class="pull-right" name='slug' placeholder="nombre amigable" />

		    	
		    	</div>

		

		    	
		    	
		    	<div class="android-ui textarea span12" style="margin-left:0"> <textarea class="span12" name="descripcion" placeholder="Descripción" cols="10" rows="8" pattern="[\w]+"></textarea> </div>
		    	<div class="android-ui textarea span12" style="margin-left:0"> <textarea class="span12" name="description" placeholder="Descripción en ingles" cols="10" rows="8" pattern="[\w]+"></textarea> </div>
		    </div>
		    	 


		    </form>


		


	</div>

	  <a href="#guardar" rel="#producto" class='btn btn-block btn-large btn-success' style="margin-top: 1em; margin-left: 1em; width: 89%;" >Guardar</a>
	  
	  <br />
	  <br />
</div>