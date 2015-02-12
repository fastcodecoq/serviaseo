
<ul class="cssmenu">
	<li><a href="inicio">Inicio</a></li>
    <li><a href="#" rel="nofollow" onclick="menunuevo(1)">Venta</a></li>
    <li><a href="#" rel="nofollow" onclick="menunuevo(2)">Arriendo</a></li>
    <li><a href="busqueda-mapa">Mapa</a></li>
    <li><a href="inmobiliarias">Inmobiliaria</a></li>
    <li><a href="#" onclick="tipoproy(1)">Proyectos Nuevos</a></li>
   <!-- <li><a href="#">Encontrar Inmueble</a>
      <ul>
        <li><a href="buscarInmobiliaria.php">Por </a></li>
        <li><a href="buscarConstructora.php">Por Constructora</a></li>
        
        </ul>
    </li>-->
    <li><a href="publicar" style="">Publicar Inmueble</a>
    	<!--<ul>
            <li><a href="planes">Planes</a></li>
            <?php 
			if($_SESSION["idusuario"] == "")
			{
			?>
            	<li><a href="registrar-inmueble">Registrar Inmueble</a></li>
            <?php
			}
			else
			{
			?>
            	<li><a href="registrar-inmueble">Registrar Inmueble</a></li>
            <?php
			}
			?>
        </ul>-->
    </li> 
    <!--<li><a href="#">Temas de Inter&eacute;s</a>
    	<ul>
            <li><a href="noticias">Noticias</a></li>
            <li><a href="decoracion">Decoraci&oacute;n</a></li>
        </ul>
    </li>-->
   <!-- <li><a href="#">Turismo</a>
    	<ul>
            <li><a href="alquileres">Alquileres</a></li>
            <li><a href="guia-turismo">Gu&iacute;a Turismo</a></li>
            <li><a href="hoteles">Hoteles</a></li>
        </ul>
    </li>-->
    <li><a href="#">Ayuda</a>
    	<ul>
            <li><a href="faq">Preguntas frecuentes</a></li>
            <li><a href="terminos-y-condiciones" target="_blank">T&eacute;rminos legales</a></li>
            <li><a href="manual" target="_blank">Manual de publicaci&oacute;n</a></li>
        </ul>
    </li>
</ul>
