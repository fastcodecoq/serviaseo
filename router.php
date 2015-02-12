<?

  $url = strip_tags($_GET["to"]);  
  echo "<script>window.top.location = '{$url}';</script>";