<?php

function get_vista( ){
   


  if(!isset($_GET["v"]))
      return "home.php";
   else
     switch ($_GET["v"]) {
     
            

              case 'nosotros':

              return "nosotros.php";

              break;

              case 'servicio':

              return "servicio_al_cliente.php";

              break;




              case 'contacto':

              return "contacto.php" ;

              break;

              case 'servicios':

              return "servicios.php" ;

              break;


               case 'cobertura':

              return "cobertura_.php" ;

              break;

        

              
              default:              

              return "home.php";

              break;



    }


  }