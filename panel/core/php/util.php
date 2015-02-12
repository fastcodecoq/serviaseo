<?php

$dbname = "serviaseo";

function nAle($l, $c = 'abcdefghijklmnopqrstuvwxyz1234567890'){
	
    for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
    return $s;


}

function json($code, $vars){

    if(empty($vars) || $vars == NULL)
       $vars = array();

    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');

    echo json_encode(array("success" => $code , "rs" => $vars));

}

function ofuscar($str){

    $letras = "abcdefghijklmnopqrstuvwxyz";
    $nums_ =  "0123456789.-,^=?¿";
    $abc = explode("",$letras);
    $nums = explode("",$nums);

    for($i=0; $i < count($str); $i++)
    {



    }



}



function makeCol(){

	$con = new Mongo();
	$col =  $con->scholes->medios;
	$col->ensureIndex(array('x' => 1), array("unique" => true));

}


function clean($el){

   $el =  preg_replace("/<.+<\/.+>+/i", "", $el);   
   $el =  preg_replace("/(\+)ADw-(.*)?(\+)AD4-/i", "", $el); 
   $el =  preg_replace('/"javascript:.+"+/i', "", $el);

   return $el;   
 
}

function clean_($el){

  // $el =  preg_replace("/<.+<\/.+>+/i", "", $el);   
   $el =  preg_replace("/<script.+>+/i", "", $el);   
   $el =  preg_replace("/<style.+>+/i", "", $el);   
   $el =  preg_replace("/<object.+>+/i", "", $el);     
   $el =  preg_replace("/(\+)ADw-(.*)?(\+)AD4-/i", "", $el);   
   $el =  preg_replace("/<\?+(.*)(\?>)+/i", "", $el);   
   $el =  preg_replace("/<link.+\/>+/i", "", $el);
   $el =  preg_replace('/javascript:.+(;|}|\))+/i', "", $el);
   $el =  preg_replace('/function (.+)?\(\){.+}+/i', "", $el);
   


   return $el;   
 
}

function format_date ($date = "test" , $phrase_text = null, $format_date = "Ymd", $date_separator = "-", $days_months = null) {

      if($date == "test" OR $date == "")
        $date = date("Y-m-d");

      if($date_separator == "" OR $date_separator == null)
         $date_separator = "-";

      if(($phrase_text == "" && $phrase_text != null))
        $phrase_text = "El {day_name} {day} de {month_name} de {year}";

      if($date == "phrase"){

        if($days_months != "en")
        $phrase_text = "El {day_name} {day} de {month_name} de {year}";
        else
        $phrase_text = "The {day_name} {day} of {month_name} of {year}";

        $date = date("Y-m-d");

      }

      if($format_date == "" OR $format_date == null)
        $format_date = "Ymd";


      if($date_separator == "" OR $date_separator == null)
        $date_separator = "-";



      $fd = str_split(strtolower($format_date));
      $vars_pos = array();

      //finding vals position
      for($i=0 ; $i<count($fd) ; $i++)
      {

          if($fd[$i] == "y" )
             $vars_pos["year"] = $i;

           if($fd[$i] == "d" )
             $vars_pos["day"] = $i;
          
          if($fd[$i] == "m" )
             $vars_pos["month"] = $i;        

      }

      $date_ = explode($date_separator,$date);

      $dia = (int) $date_[$vars_pos["day"]];
      $mes = (int) $date_[$vars_pos["month"]];
      $year = (int) $date_[$vars_pos["year"]];

      $diasem = date("w",mktime(0, 0, 0, $mes, $dia, $year));

   if($days_months == null OR $days_months == "en"){

    if($days_months != "en")
    {

    $tMes = 'nohay Enero Febrero Marzo Abril Mayo Junio Julio Agosto Septiembre Octubre Noviembre Diciembre';
    $tDia = 'Domingo Lunes Martes Miércoles Jueves Viernes Sábado';

    }else{

    $tDia = "Sunday Monday Tuesday Wenesday Thursday Friday Saturday";
    $tMes = "Null January Febrary March April May June July August September October November December";

    }


     }
     else
     {


      $tDia = $days_months[0];
      $tMes = $days_months[1];

     }

      $tMes = explode(' ', $tMes);
      $tDia = explode(' ', $tDia);

      $diasem = $tDia[$diasem];
      $n_mes = $tMes[$mes];
      $short_day = substr($diasem,0,3);
      $short_month = substr($n_mes,0,3);

    if($phrase_text == null)
      return array(
                    "day_name" => $diasem , 
                    "month_name" => $n_mes,  
                    "day" => $dia,  
                    "mes" => $mes,  
                    "year" => $year, 
                    "short_day" => $short_day,
                    "short_month" => $short_month,
                    "original_date" => $date );
    else{


      $phrase = str_replace("{day_name}", $diasem, $phrase_text);
      $phrase = str_replace("{day_name_short}", $short_day, $phrase);
      $phrase = str_replace("{month_name}", $n_mes, $phrase);
      $phrase = str_replace("{month_name_short}", $short_month, $phrase);
      $phrase = str_replace("{day}", $dia, $phrase);
      $phrase = str_replace("{month}", $mes, $phrase);
      $phrase = str_replace("{year}", $year, $phrase);

      return $phrase;


    }
      

  }


  if(isset($_GET["_test_"])){


    switch ($_GET["_test_"]) {
      
      case 'fecha':


          $date_ = format_date();

          var_dump($date_);

        break;        


    }


  }

 function chkActivity($app, $ses_api){

       return true;
          
          if(!$ses_api->is_active()){
            $app->logout("me");          
            echo "<script>window.location = '/panel/login'</script>";            
            }

 }  


  function chkLogin($app , $redirect = "/panel/login", $make = "redirect" ){


    if(empty($redirect))
      $redirect = dpath . "/panel/login";    

        

    if(!$app->isLoged("me")){

  
        
         if($redirect!="nop")
           echo "<script>window.location = '" . dpath . "/panel/login' </script>";
         
       }
    else
    {   
        
    


       if($make != "redirect")
         return true;
       else
         if($redirect!="nop")
         echo "<script>window.location = '" .dpath. "{$redirect}'</script>";  
         else
         echo "<script>window.location = '" .dpath. "/panel'</script>";           


    }


  }




  function getInfo($user){

      $user_ = $_COOKIE["user"];
      return $user->getInfo($user_);

  }



  function login($user,$data){

     if( $user->login($data) )
         {
                 
           setcookie("firstime", md5("yes"), time() + 60, "/");
           return true;

         }
     else
      {

        return array( "error" => $user->error() );

      }

  }


  function logout($user_api){


            
      if($user_api->logout("me"))
         echo "<script>window.location = '" .dpath. "/panel/login'</script>";        
      else
        die("Problemas con el logout");         


  }


  function get_ads_img(){

      return file_get_contents(dirname(__FILE__) . "/app.ads.php");

  }