<?php
//Funciones

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
/*
	Imprime en Json o en Jsonp un array
	Modo de uso:
		toJsonp(array(...), 'miobj');
	Regresa
		var miobj = {...};
*/	
function toJsonp ($_array, $_var) {
	header('Content-type: text/javascript');

	$_json = json_encode($_array);
	if ( isset($_GET['jsonp']) ) {
		echo "var {$_var} = {$_json};";
	} else {
		echo $_json;
	}
}

/*
	Genera un token de usuario
	Modo de uso
		$token = genToken("{$uid}|{$username}|{$password}");
*/
function genToken ($data) {
	$date = date("w j-m-Y g:i:s:a");
	$ip = getIP();
	$uA = getBrowser();
	$plataform = "{$uA['type']}|{$uA['platform']}|{$uA['name']}";

	$token = "{$data}|{$date}|{$ip}|{$plataform}";
	$token = base64_encode($token);
	return $token;
}

function rol2text ($rol, $lang) {
	switch ($rol) {
		case 'admin':
			$rol = $lang->roles->admin;
			break;
		case 'cdc':
			$rol = $lang->roles->cdc;
			break;
		case 'user':
			$rol = $lang->roles->user;
			break;
		case 'demo':
			$rol = $lang->roles->demo;
			break;
		case 'sub':
			$rol = $lang->roles->sub;
			break;
		case 'mod':
			$rol = $lang->roles->mod;
			break;
		case 'god':
			$rol = $lang->roles->god;
			break;
	}
	return $rol;
}

/*
	Genera clave aleatoria con un prefijo
	Modo de uso:
		$key = genKeyUid('prefijo');
	Regresa
		prefijo_SAFagxaGs

	El segundo parámetro le indica el ancho de la cadena
*/
function genKeyUid ( $p, $l = 8 ){
	$rCh = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$key = $p . "_";
	for ( $i = 0; $i < $l; $i++ ){
		$key .= $rCh{ rand(0,61) };
	}
	return $key;
}
/*
	Igual que la anterior pero sin prefijo
*/
function genKey ( $l = 8 ){
	$rCh = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$key = "";
	for ( $i = 0; $i < $l; $i++ ){
		$key .= $rCh{ rand(0,61) };
	}
	return $key;
}

/*
	Valida el formato de una url
	Si la url es correcta regresa "true"
	Modo de uso:
		if( !validate_url('http://google.com') ) die ('Url invalida')
*/
function validate_url($url) {
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

/*
	Valida el ancho de una cadena
	Si la cadena es mas grande que el parámetro pasado regresará "false"
	Modo de uso
		$cadea = "Esta es una cadena muy medianamente larga";
		if ( !long_text($cadena, 140) ) die ('La cadena es mas grande que un tweet')
*/
function long_text($txt, $long){
	if ( strlen($txt) > $long ){
		return false;
	}else{
		return true;
	}
}

/*
	Formatea un texto
*/
function delespecialchars ($title){
	$a = "Á É Í Ó Ú Ý á é í ó ú ý À È Ì Ò Ù à è ì ò ù Ä Ë Ï Ö Ü ä ë ï ö ü ÿ Â Ê Î Ô Û â ê î ô û Ç ç Ñ ñ º ª \\ \" · # $ ~ % & ¬ / ( ) = ? ' ¿ ¡ { } + ] [ * ^ . : , ; ´ ` - < > | @ €";
	$a = explode(' ', $a);
	$title = str_replace($a, "_", $title);
	$title = str_replace(" ", "_", $title);
	return $title;
}

/*
	Obtiene un thumbnail de una imagen
	Modeo de uso
		thumbImg('path/to/image', 200);
*/
function thumbImg ($img, $size = 200) {

	$image_type = explode(".", $img);
	$image_type = end($image_type);

	if ( preg_match('/jp/i', $image_type) ) { $image_type = "jpeg"; }

	header("Content-Type: image/" . $image_type);

	$image_p = imagecreatetruecolor( $size, $size );

	list($width_o, $height_o) = getimagesize( $img );

	if ( $width_o > $height_o ) {
		$ratio_o = $width_o / $height_o;

		$height = $size;
		$width = $size * $ratio_o;
	} else {
		$ratio_o = $height_o / $width_o;

		$width = $size;
		$height = $size * $ratio_o;
	}

	switch ( $image_type ){
		case "jpeg": $image = imagecreatefromjpeg( $img ); break;
		case "png": $image = imagecreatefrompng( $img ); break;
		case "gif": $image = imagecreatefromgif( $img ); break;
	}

	imagealphablending($image_p, true);
	imagesavealpha($image_p, true);

	imagecopyresampled( $image_p, $image, 0, 0, 0, 0, $width, $height, $width_o, $height_o );

	switch ( $image_type ){
		case "jpeg": imagejpeg($image_p, null, 100); break;
		case "png":  imagepng($image_p); break;
		case "gif": imagegif($image_p); break;
	}

	imagedestroy($image);
	imagedestroy($image_p);
}

/*
	Obtiene una imágen redimensionada
	Modeo de uso
		resizeImg('path/to/image', 450);
*/
function resizeImg ($img, $size = 450) {

	$image_type = explode(".", $img);
	$image_type = end($image_type);

	if ( preg_match('/jp/i', $image_type) ) { $image_type = "jpeg"; }

	header("Content-Type: image/" . $image_type);

	list($width_o, $height_o) = getimagesize( $img );

	$ratio_o = $height_o / $width_o;

	$width = $size;
	$height = $size * $ratio_o;	

	$image_p = imagecreatetruecolor( $width, $height );

	switch ( $image_type ){
		case "jpeg": $image = imagecreatefromjpeg( $img ); break;
		case "png": $image = imagecreatefrompng( $img ); break;
		case "gif": $image = imagecreatefromgif( $img ); break;
	}

	imagealphablending($image_p, true);
	imagesavealpha($image_p, true);

	imagecopyresampled( $image_p, $image, 0, 0, 0, 0, $width, $height, $width_o, $height_o );

	switch ( $image_type ){
		case "jpeg": imagejpeg($image_p, null, 100); break;
		case "png":  imagepng($image_p); break;
		case "gif": imagegif($image_p); break;
	}

	imagedestroy($image);
	imagedestroy($image_p);
}

/*
	Sube un archivo a partir de la variable $_FILES
	Modo de uso
		uploadfile($_FILES['archivo'], 'path/to/file');
*/
function uploadfile($__FILES, $path){
	$file = genKey();

	$ext = explode('.', $__FILES['name']);
	$ext = '.' . end($ext);
	$uri = $file . $ext;
	move_uploaded_file( $__FILES['tmp_name'], $path . $uri );
	return $uri;
}

/* 
	Cortart texto por numero de palabras
	Modo de uso
		$nuevotexto = cutText($texto, 10);
*/
function cutText($txt, $limit){
	$txt = explode(" ", $txt);
	$txt_cut = "";
	for ( $i = 0; $i < $limit; $i++){
		$txt_cut = $txt_cut . " " . $txt[$i];
	}
	return $txt_cut;
}

/*
	Dannegm Bot
	Conjunto de funciones que ayuda al monitoreo de los paquetes web
*/
/*
	Obtiene un paquete a partir de una solicitud http
	Regresa el código de respuesta, los headers de la petición y el contenido
	Modo de uso
		$request = dnn_bot('http://google.com');
		$headers = $request['headers'];
		$http_code = $request['http_code'];
		$body = $request['body'];

	El script marca una petición al sitio y le devuelve como agente de usuario "DannegmBot/Alpha 1.0"
*/
function dnn_bot ($url) {
	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'DannegmBot/Alpha 1.0');
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$resp = curl_exec($ch);
		$resp = explode("\n\r\n", $resp);
		$headers = $resp[0];
		$_headers = explode("\n", $headers);
		$body = $resp[1];

	curl_close($ch);

	return Array(
		'http_code' => $_headers[0],
		'headers' => $headers,
		'body' => $body
	);
}
/*
	Valida si el sitio existe o es accesible
	Modo de uso
		if ( !validate_site_exist('http://google.com') ) die ('El sitio no existe')
*/
function validate_site_exist ($url) {
	$request = dnn_bot($url);
	$http_code = $request['http_code'];

	if ( preg_match('/OK/i', $http_code) ) {
		return true;
	}else{
		return false;
	}
}
/*
	Obtiene el título de una página específica
	Modo de uso
		$titulo = get_page_title('http://google.com');
*/
function get_page_title ($url) {
	$request = dnn_bot($url);
	$page = $request['body'];

	$title = 'untitle';
	if (preg_match('/\<title\>/i', $page)){
		$title = explode('<title>', $page);
			$title = explode('</title>', $title[1]);
			$title = $title[0];
	}

	return $title;
}

/*
	Te regresa el nombre del mes a partir de su numero
*/
function format_mes ($m){
	$mesTxt = 'nohay enero febrero marzo abril mayo junio julio agosto septiembre octubre noviembre diciembre';
	$mes = explode(' ', $mesTxt);
	$mes = $mes[$m];
	return $mes;
}

/*
	Te regresa el numero de la semana a partir de su numero
	(domingo es el día 0)
	Modo de uso
		$dia = set_day_text(4);
*/
function format_day ($d){
	$diaTxt = 'domingo lunes martes miércoles jueves viernes sábado';
	$dia = explode(' ', $diaTxt);
	$dia = $dia[$d];
	return $dia;
}

/*
	Regresa
		1 de enero del 2013
	A partir de
		01-01-2013
	Modo de uso
		$fecha = format_date('01-01-2013');
*/


/*
	Es como el array $_GET pero sin necesitad de una petición http
	Modo de uso
		$url = "http://google.com/?s=Busqueda&opt=Opciones&lang=Lenguaje";
		$google_vars = urlGet ($url);
		$search= $google_vars['s'];
		$options = $google_vars['opt'];
		$lang = $google_vars['lang'];
*/
function urlGet ($url){
	$_getStrings = explode('?', $url);
	$getStrings = $_getStrings[1];
	if ($getStrings) {
		$getKeys = explode('&', $getStrings);
		$get = array();

		for($i = 0; $i < count($getKeys); $i++){
			$tmp = explode('=', $getKeys[$i]);
			$get[$tmp[0]] = $tmp[1];
		}
		return $get;
	}else{
		return false;
	}
}

/*
	Obtiene el porcentaje representativo de un numero a otro numero, ej. 25 es el "50%" de 50
	Modo de uso
		$percent = isPercentOf(25, 50);

	Primer parámetro es el indice a obtener
	Segundo parámetro es el indice del 100%
*/
function isPercentOf ($p, $m){
	$percent = $m / 100;
	$percent = $p / $percent;
	$percent = number_format($percent, 0);
	return $percent;
}
/*
	Obtiene el valor del porcentaje por ejemplo. 190 es el 16% de 1,200
	Modo de uso
		$percent = percent(1200, 16);

	Primer parámetro es el total
	Segundo parámetro es el porcentaje a obtener
*/
function percent ($p, $m){
	$percent = $m / 100;
	$percent = $p * $percent;
	$percent = number_format($percent, 0);
	return $percent;
}

/*
	Formatea las coordenadas
*/
function format_coor ($coor){
	$coor = cleantext($coor);
	$coor = str_split($coor);
	$coor = array_reverse($coor);
	$res = "";
	for( $i = count($coor) -1; $i >= 0; $i-- ){
		if( $i==4 ){
			$res .= ".";
		}
		$res .= $coor[$i];
	}
	return $res;
}

function getIP () {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$myip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$myip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$myip = $_SERVER['REMOTE_ADDR'];
	}
	//return sprintf("%u", ip2long($myip));
	//return ip2long($myip);
	return $myip;
}

/*
	Obtiene información del cliente a partir de el userAgent
	Modo de uso
		$client = getBrowser();

		$userAgent = $client['userAgent'];
		$nombre_del_navegador = $client['name'];
		$motor_de_reenderizado = $client['engine'];
		$desktop_mobil_tablet = $client['type'];
		$version_del_navegador = $client['version'];
		$sistema_operativo = $client['plataform'];
*/
function getBrowser () {
	$u_agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version = "";
	$ub = "";


	// Sistemas Operativos

	// Linux
	if ( preg_match('/linux/i', $u_agent) ) {
		$platform = 'Linux';
	}
	if ( preg_match('/Ubuntu/i', $u_agent) ) {
		$platform = 'Ubuntu';
	}
	if ( preg_match('/CrOS/i', $u_agent) ) {
		$platform = 'Chrome OS';
	}

	// Windows
	if ( preg_match('/windows|win32/i', $u_agent) ) {
		$platform = 'Windows';
	}
	if ( preg_match('/NT 5.1/i', $u_agent) ) {
		$platform = 'Windows XP';
	}
	if ( preg_match('/NT 6/i', $u_agent) ) {
		$platform = 'Windows Vista';
	}
	if ( preg_match('/NT 6.1/i', $u_agent) ) {
		$platform = 'Windows 7';
	}
	if ( preg_match('/NT 6.2/i', $u_agent) ) {
		$platform = 'Windows 8';
	}
	if ( preg_match('/Windows Phone OS|XBLWP|ZuneWP/i', $u_agent) ) {
		$platform = 'Windows Phone';
	}

	// MacOS
	if ( preg_match('/macintosh|mac os x/i', $u_agent) ) {
		$platform = 'Mac';
	}
	if ( preg_match('/X 10.3|X 10_3/i', $u_agent) ) {
		$platform = 'Mac OS X Phanter';
	}
	if ( preg_match('/X 10.4|X 10_4/i', $u_agent) ) {
		$platform = 'Mac OS X Tiger';
	}
	if ( preg_match('/X 10.5|X 10_5/i', $u_agent) ) {
		$platform = 'Mac OS X Leopard';
	}
	if ( preg_match('/X 10.6|X 10_6/i', $u_agent) ) {
		$platform = 'Mac OS X Snow Leopard';
	}
	if ( preg_match('/X 10.7|X 10_7/i', $u_agent) ) {
		$platform = 'Mac OS X Lion';
	}
	if ( preg_match('/X 10.8|X 10_8/i', $u_agent) ) {
		$platform = 'Mac OS X Mountain Lion';
	}

	// iOS
	if ( preg_match('/iPad/i', $u_agent) ) {
		$platform = 'iPad';
	}
	if ( preg_match('/iPhone/i', $u_agent) ) {
		$platform = 'iPhone';
	}
	if ( preg_match('/iPod/i', $u_agent) ) {
		$platform = 'iPod';
	}

	// Android
	if ( preg_match('/Android/i', $u_agent) ) {
		$platform = 'Android';
	}
	// BlackBerry
	if ( preg_match('/BlackBerry/i', $u_agent) ) {
		$platform = 'BlackBerry';
	}
	// Symbian
	if ( preg_match('/SymbianOS|Symbian/i', $u_agent) ) {
		$platform = 'Symbian';
	}
	// MeeGo
	if ( preg_match('/MeeGo/i', $u_agent) ) {
		$platform = 'MeeGo';
	}

	// Navegadores

	// Chafaexplorer
	if( preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent) ) {
		$bname = 'Internet Explorer';
		$ub = "MSIE";
	// Firefox
	}elseif( preg_match('/Firefox/i',$u_agent) ){
		$bname = 'Mozilla Firefox';
		$ub = "Firefox";
	// Chrome
	}elseif( preg_match('/Chrome/i',$u_agent) ){
		$bname = 'Google Chrome';
		$ub = "Chrome";
	// Safari
	}elseif( preg_match('/Safari/i',$u_agent) ){
		$bname = 'Apple Safari';
		$ub = "Safari";
	// Opera
	}elseif( preg_match('/Opera/i',$u_agent) ){
		$bname = 'Opera';
		$ub = "Opera";
	// Android
	}elseif( preg_match('/Android/i',$u_agent) ){
		$bname = 'Android';
		$ub = "Navegador de android";
	}

	// Motores
	$eng = 'not found';
	if( preg_match('/Presto/i',$u_agent) ){
		$eng = 'Presto';
	}elseif( preg_match('/Trident|MSIE/i',$u_agent) ){
		$eng = 'Trident';
	}elseif( preg_match('/AppleWebKit\/53/i',$u_agent) ){
		$eng = 'WebKit';
	}elseif( preg_match('/Gecko\/20100101/i',$u_agent) ){
		$eng = 'Gecko';
	}elseif( preg_match('/Blink/i',$u_agent) ){
		$eng = 'Blink';
	}

	// Tipo
	$type = 'Desktop';
	if( preg_match('/Tablet/i',$u_agent) ){
		$type = 'Tablet';
	}elseif( preg_match('/Touch/i',$u_agent) ){
		$type = 'Touch';
	}elseif( preg_match('/Mobi/i',$u_agent) ){
		$type = 'Mobil';
	}

	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

	if ( !preg_match_all($pattern, $u_agent, $matches) ) {
		// just continue
	}

	$i = count($matches['browser']);

	if ( $i != 1 ) {
		if ( strripos($u_agent, "Version") < strripos($u_agent, $ub) ){
			$version= $matches['version'][0];
		}else{
			$version= $matches['version'][1];
		}
	}else{
		$version= $matches['version'][0];
	}

	if ( $version == null || $version == "" ){
		$version = "?";
	}
	return array(
		'userAgent' => $u_agent,
		'name' => $bname,
		'nav' => $ub,
		'engine' => $eng,
		'type' => $type,
		'version' => $version,
		'platform' => $platform
	);
}
/*
	Detecta si el navegador es soporta html5
	if ( html5support() == 'nope') die ('El navegador es muy obsoleto')
*/
function html5support () {
	$nav = getBrowser();
	$ver = explode('0', $nav['version']);
	if (
		( $nav['engine'] == 'WebKit' ) ||
		( $nav['engine'] == 'Gecko' ) ||
		( $nav['nav'] == 'Opera' && $nav['version'] == 'Tablet' ) ||
		( $nav['nav'] == 'Opera' && $nav['version'] == 'Mobi' )
	){
		return "yep";
	}elseif ( 
		( $nav['nav'] == 'Chrome' && $ver[0] < 14 ) ||
		( $nav['nav'] == 'Firefox' && $ver[0] < 4 ) ||
		( $nav['nav'] == 'Safari' && $ver[0] < 5 ) ||
		( $nav['nav'] == 'Opera' && $ver[0] < 10 ) ||
		( $nav['nav'] == 'MSIE' && $ver[0] < 9  )
	){
		return "nope";
	}else{
		return "yep";
	}
}
/*
	Detecta si se está navegando desde un ó
	if ( mobilsupport() == 'nope') die ('Tú no eres un móvil')
*/
function mobilsupport () {
	$nav = getBrowser();
	if ( 
		( $nav['platform'] == 'iPad' ) ||
		( $nav['platform'] == 'iPhone' ) ||
		( $nav['platform'] == 'iPod' ) ||
		( $nav['platform'] == 'Android' ) ||
		( $nav['platform'] == 'BlackBerry' ) ||
		( $nav['platform'] == 'Symbian' ) ||
		( $nav['platform'] == 'MeeGo' ) ||
		( $nav['nav'] == 'Opera' && $nav['version'] == 'Tablet' ) ||
		( $nav['nav'] == 'Opera' && $nav['version'] == 'Mobi' )
	){
		return "yep";
	}else{
		return "nope";
	}
}