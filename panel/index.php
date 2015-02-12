<?php


require_once("core/php/users_api.php");


try{

$date = date("Y") ."-". date("m") ."-" . (date("d")-1);

$last_conn = format_date($date,"Último acceso el {day_name} {day} de {month_name} de {year}");

$update = false;

$user_api = new User();


 if(isset($_POST["logout"])){

     $ses_api = new sessions_("nop");
     $ses_api->die_session();
     logout($user_api);

    }


 if(chkLogin($user_api,'','return'))
   {

  
   
   $ses_api = new sessions_("nop");     
   
   if(isset($_COOKIE["firstime"]))
     {
    

     if($_COOKIE["firstime"] != md5("yes"))
       die; 
   
      $ses_api = new sessions_();
      setcookie("firstime","", time() - 3600, "/");

      if($ses_api){

        if(!$ses_api->is_active($ses_api->gTok()))
          {              

      
           logout($user_api);


          }else
          $user = getInfo($user_api);


       }

     } 

  else 
     if(!$ses_api->is_active())
    {              


        
     logout($user_api);


    }else{

       

        if(!$ses_api->is_active("me")){

         
           $ses_api->die_session();
           logout($user_api);

         }else{
    
          $user = getInfo($user_api);

         }


    }  

   }
 
 }
   
 catch(Exception $e){

     echo $e->getMessage();
     die;

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
  	  <link rel="stylesheet/less" href="less/medios.less" />

      <link rel="icon" href="favicon.ico" type="image/x-icon" />


  	  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  	  <script type="text/javascript" src="../js/less.js"></script>
      <script src="js/consoleIE.js"></script>  
      
      

  </head>

  <body>

  	  <div id="container"class="row-fluid">

  	  	  <header class="span12 clearfix">

  	  	  	<div class="span6">

  	  	  	 <figure><img src="http://gomosoft.pro/img/gomoB.png" alt="" width="40"/></figure>
  	  	  	 <h3 class="logo"><b style="color:#777">CMS</b><em><font >2Lite</font></em></h3>

  	  	  	</div>


            <div  class="span6" id="aside-logo" >

             <figure><img src="http://gomosoft.pro/img/gomoB.png" alt="" width="44"/></figure>
             <h3 class="logo"><b style="color:#777">CMS</b><em><font >Lite</font></em></h3>

            </div>


  	  	  	<div class="span6 pull-right">
                
  	  	  		  <small class="acceso pull-right">
                 &nbsp; <a href="#!/profile" ><b style="color: #009966;"><?php echo $user["name"]; ?></b></a> &nbsp;
                 <a href="#salir" title="Opciones" class="hidden"> <i class="icon-cog" style="color: rgba(0, 0, 0, 0.53); font-size: 1.3em;"></i></a>
              &nbsp;
              
                <a href="#submit" data-role="logout"  rel="norel" title="Salir"> <i class="icon-signout" style="color: rgba(0, 0, 0, 0.53); font-size: 1.3em;"></i></a>            
  	  	  	   </small>

              <form name='logout' action="index.php" method="post" class="hidden" style="display:none">
                <input type="hidden" name="logout" />                
              </form>

               <div class="profile_thumb pull-right">
                   <a href="#">
                    <?php 
                    if(empty($user["avatar"]))                    
                     echo '<img src="img/anonymous.png" width="60" />' ;
                    else
                     echo "<img src='{$user['avatar']}' width='60' />";
                    ?>
                   </a>
                </div>
  	  	  	</div>

           
  	  	  </header>

         
         

  	  	   <div id="panel" class="span12">  

  	  	   	

           <?php echo file_get_contents(burl . dpath . "/panel/vistas/aside.php"); ?>
           <?php echo file_get_contents(burl . dpath . "/panel/vistas/medios.php"); ?>


          <div class="span8" id="content-wrap">

            <?php if($update): ?>
             <div class="span12">
               
               <div class="alert alert-info span10" style="margin-left:5em" >
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Enhorabuena: hay una nueva <strong>Actualización </strong> disponible, te invitamos a ver <a href="#">las mejoras</a>
                </div>
          
             </div>
             <?php endif; ?>

  	  	   	 <div class="span12" id="content">

  	  	   	 	

  	  	   	 </div>

          </div>          

  	  	   </div>

  	  </div>

  <?php if($update): ?>
     <script type="text/javascript" src="/bootstrap/js/bootstrap.js"></script>
  <?php endif; ?>

<div class="cargando" style="display: block;">
                  
                  <figure>
                      <img src="http://gomosoft.pro/img/gomoB.png" alt="" width="80">
                      <span>Cargando...</span>
                 </figure>

                  </div>
      <script src="/js/dialogs.js"></script>

  </body>
</html>