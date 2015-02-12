<?php


include(dirname(__FILE__) . "/core/php/users_api.php");

$date = date("Y") ."-". date("m") ."-" . (date("d")-1);

$last_conn = format_date($date,"Último acceso el {day_name} {day} de {month_name} de {year}");

$update = false;

$user_api = new User();
$dirname = dpath;


if(chkLogin($user_api,"nop"))
  {    
        
    echo "<script>window.location = '{$dirname}/panel'</script>";   

  }
else if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["keep"]))
{

  $rs = login($user_api,$_POST);

  if($rs and !is_array($rs)){
    
    echo "<script>window.location = '{$dirname}/panel'</script>";   


  }  
  

}


?>

<!DOCTYPE html>

<html lang="es-CO">
  
  <head>

  	  <meta charset="UTF-8" />

  	  <title>gomosoftCMS - Panel de administración</title>

  	  <link rel="stylesheet" href="../css/bootstrap.css" />
  	  <link rel="stylesheet" href="../css/bootstrap-responsive.css" />
  	  <link rel="stylesheet" href="../fontAwesome/css/font-awesome.min.css" />
      <link rel="stylesheet/less" href="less/estilo.less" />
  	  <link rel="stylesheet/less" href="less/login.less" />


  	  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  	  <script type="text/javascript" src="../js/less.js"></script>
      <script src="js/consoleIE.js"></script>  
      
      <link rel="icon" href="favicon.ico" type="image/x-icon" />
      

  </head>

  <body>

  	  <div id="container"class="row-fluid">

  	  	  <header class="span12 clearfix">

  	  	  	<div class="span6">

  	  	  	 <figure><img src="http://gomosoft.pro/img/gomoB.png" alt="" width="40"/></figure>
  	  	  	 <h3 class="logo"><font style="text-transform:lowercase">gomosoft</font><em><b>CMS</b></em></h3>

  	  	  	</div>



  	  	  	<div class="span6 pull-right">

               <div class="span12">      

                       
                   
                   <form action="login.php" method="post" name="login">
                    
                    <div class="span12" style="position:relative">

                       <div class="box pull-left">
                        <label >Usuario</label>
                        <input type="text" name="username" class="pull-left" />
                      </div>
                      <div class="box pull-left">
                        <label >Contraseña</label>
                        <input type="password" name="password" class="pull-left"/>   
                        <input type="hidden" name="keep" />                                                              
                      </div>
                        <button type="submit" class="btn btn-small pull-left">Iniciar Sesión</button>
                        
                      <?php if(isset($rs)): ?>
                        <div class="pop-error span5"> 
                           <?php echo $rs["error"]; ?>
                        </div>
                      <?php endif; ?>

                    </div>

                    <div class="box-check span12">

                     <input type="checkbox" id="keep" class="pull-left" />  
                     <label class="pull-left">Recordarme</label>   

                     </div>

                   </form>                                  
               </div>
                                
  	  	  		
  	  	  	</div>

           
  	  	  </header>

         
         

  	  	   <div id="panel" class="span12">  



  	  	   	 
         


          <div class="span8" id="content-wrap">
    

  	  	   	 <div class="span12 " id="content">


                 <div class="img-promo">

                    <h4>Novedades en Gomosöft:</h4>

                      <?php echo get_ads_img(); ?>

                 </div>

    <ul id="promo" class="hidden"> 

  <li>
  	<b class='title'>Tienda Online</b>
  	<div class="span12" style="margin-top: .5em;">
    	<div class="span5"><img src="" alt=""></div>
   	 <div class="span4"> 
   		<p>
   Con <em>gomosoftCMS</em> podrás tener una tienda online, donde podrás administrar todos tus productos de forma rápida y sencilla. 
   <br> <br>
Además cuentas con un resumen de estadisticas financieras de todas tus ventas, como productos más vendidos, entre otros
       </p>
     </div>
   </div>
 </li>

  <li>
  	<b class='title'>Fácil administración del contenido web</b>
  	<div class="span12" style="margin-top: .5em;">
    	<div class="span5"><img src="" alt=""></div>
   	 <div class="span4"> 
   		<p>
   Administra el contenido de tu sitio web directamente en lás páginas, como si editaras una plantilla de Power Point.
   <br> <br>
Gracias a la tecnología implementada en </em>gomosoftCMS</em> podrás editar e ir viendo los resultados al mismo tiempo.
       </p>
     </div>
   </div>
 </li>

</ul> 	  	   	 	

  	  	   	 </div>

          </div>          

  	  	   </div>

  	  </div>

  <?php if($update): ?>
     <script type="text/javascript" src="/bootstrap/js/bootstrap.js"></script>
  <?php endif; ?>


    <script>

      function chk_keep(){

          $("#keep").change( function(){
                          
              
              if($("#keep").is(":checked"))
                 $("input[name='keep']").val("keep");
              else
                 $("input[name='keep']").val("nop");


            });


      }

       $(chk_keep);

    </script>

  </body>
</html>

