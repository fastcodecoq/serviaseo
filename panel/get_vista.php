<?php

include(dirname(__FILE__) . "/core/php/config.inc.php");

echo file_get_contents( burl . dpath . "/panel/vistas/". $_GET["f"]);