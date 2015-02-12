<?php


function graph($title = "Test", $site_name = "Test", $site_description = "Test", $img = NULL, $resize=false, $type="website", $more_og = NULL){
 
 
         $url = "http://$_SERVER[HTTP_HOST]";
 
          if($img === NULL)
            $img = "assets/img/golf.jpg"; //esta la pueden cambiar por su imagen por defecto
 
         $graph = array();
         $graph[] = "<meta property=\"og:title\" content=\"{$title}\" />";
         $graph[] = "<meta property=\"og:type\" content=\"{$type}\" />";
         $graph[] = "<meta property=\"og:url\" content=\"{$url}{$_SERVER["REQUEST_URI"]}\" />";
         $graph[] = "<meta property=\"og:site_name\" content=\"{$site_name}\" />";
         $graph[] = "<meta property=\"og:description\" content=\"{$site_description}\" />";
         $graph[] = "<meta property=\"og:image\" content=\"{$url}{$img}\" />";
 
         $size = getimagesize( $_SERVER["DOCUMENT_ROOT"] . "/". $img);                  
 
         $graph["image_width"] = "<meta property=\"og:image:width\" content=\"{$size[0]}\" />";
         $graph["image_height"] = "<meta property=\"og:image:height\" content=\"{$size[1]}\" />"; 
 
         if(is_array($more_og))
          $graph = array_merge($graph , $more_og);       
 
         echo implode("\n",$graph);
 
    }
