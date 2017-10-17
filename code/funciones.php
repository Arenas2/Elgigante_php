<?php

session_start();

date_default_timezone_set('America/Mexico_City');

// $debug = "0";
// if($debug == ":("){ error_reporting(E_ALL); ini_set('display_errors', '1'); $debug_mode = "1"; }
// else { error_reporting(0); ini_set('display_errors', '0'); }

header('Content-Type: text/html; charset=ISO-8859-1');

$GetHeaders = apache_request_headers();

include_once("db.php");

function Valida($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
function Valida_utf8($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = utf8_decode($data);
	return $data;
}

$Id_Video_Promos = "eqpdpemm30g";
$random = substr(md5(uniqid(rand())),0,6);

$title_page = "";
$Data_Id = $_SESSION['Data_id'];
$Check_Usuario = $_SESSION['Data_Usuario'];
$Data_Usuario = $_SESSION['Data_Usuario'];
$session_id = session_id();

if($Data_Usuario == "")
	{ $Check_Usuario = "Invitad@"; }
else{}


function url_server()
{
	$isSecure = false;
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
		$isSecure = true;
	}
	$HTTP = $isSecure ? 'https:' : 'http:';
	$server = $_SERVER["SERVER_NAME"];

	$url_server = 'localhost:8080/';

	//
	// $url_server = "//".$server."";
	// $server_url = $HTTP."//".$server.":";

	return $url_server;
}


function CheckExist_Usuario($get_current_user)
{
	global $mysqli;
	$query_Nombre_Usuario = "SELECT * FROM `Usuarios` where `Id_Usuario` = '$get_current_user' ORDER BY id DESC";
	$result_Nombre_Usuario = $mysqli->query($query_Nombre_Usuario);
	if($result_Nombre_Usuario->num_rows >=1)
		{ $existe = "1"; }
	else
		{ $existe = ""; }
	return $existe;
}

function Nombre_Usuario($get_current_user){
	global $mysqli;
	if($get_current_user != ""){
		// `id` = '".$get_current_user."' OR  OR `Usuario` = '".$get_current_user."'
		$query_Nombre_Usuario = "SELECT * FROM `Usuarios` where `Id_Usuario` = '".$get_current_user."' ORDER BY id DESC LIMIT 1";
		$result_Nombre_Usuario = $mysqli->query($query_Nombre_Usuario);
		if($result_Nombre_Usuario->num_rows >=1)
		{
			while($row_Nombre_Usuario=$result_Nombre_Usuario->fetch_array(MYSQLI_ASSOC))
			{
				$GetNombre = ucwords(strtolower($row_Nombre_Usuario['Nombre']));
				$GetApellidos = ucwords(strtolower($row_Nombre_Usuario['Apellidos']));
			}
		}
		else
			{  }
		return "".$GetNombre." ".$GetApellidos."";
	}
}

function Email_Usuario($get_current_user)
{
	global $mysqli;
	$query_Email_Usuario = "SELECT * FROM `Usuarios` where `Id_Usuario` = '".$get_current_user."' ORDER BY id DESC LIMIT 1";
	$result_Email_Usuario = $mysqli->query($query_Email_Usuario);
	if($result_Email_Usuario->num_rows >=1)
	{
		while($row_Email_Usuario= $result_Email_Usuario->fetch_array(MYSQLI_ASSOC)) {
			$GetEmail = $row_Email_Usuario['Email'];
		}
	}
	else
		{  }
	return $GetEmail;
}

function ip()
{
	$pss =  $_SERVER['HTTP_X_FORWARDED_FOR'];
	$alt_ip = $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) { $alt_ip = $_SERVER['HTTP_CF_CONNECTING_IP']; }
	//else if (isset($_SERVER['HTTP_CLIENT_IP'])) { $alt_ip = $_SERVER['HTTP_CLIENT_IP']; }
	else if (isset($_SERVER['REMOTE_ADDR'])) { $alt_ip = $_SERVER['REMOTE_ADDR']; }
	//return $alt_ip;
	if ($pss == "") { $IP = $alt_ip; } else { $IP = $pss; }
	return $IP;
}

function user_agent()
{
	return $_SERVER['HTTP_USER_AGENT'];
}

$uri = $_SERVER["REQUEST_URI"];
$return = Valida($_REQUEST['return']);

$isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	$isSecure = true;
}
$HTTP = $isSecure ? 'https:' : 'http:';

if($server == "")
	{ $server = $_SERVER["SERVER_NAME"]; }
else {  }

//$url_server = $HTTP."//".$server."";
//$server_x= $HTTP."//".$server."";
$url_server = "//".$server.":8080";
$server_url = "//".$server.":8080";

$url_thumbs = $server_url."/img.php";
// $url_server_img = "//i2.wp.com/".$server.":8080";
// $server_url_img = "//i2.wp.com/".$server.":8080";

$url_server_img = $server_url;
$server_url_img = $server_url;

if($server == "demo.elgigantedelosazulejosgrupo100.com"){
	$isDemo = "1";
} else {
	$isDemo = "";
}

function CheckMovilSession($Data_Nombre)
{
	if(isset($Data_Nombre))
		{ $msg = ""; }
	else
	{
		$msg = '<br><p style="text-align: center;">Sesi&oacute;n expirada, para ingresar solo da click en el logo de CircleRide o en Home (<i class="fa fa-home"></i>).</p><br> '.$Data_Nombre.'';
	}
	return $msg;
}

function UrlTarget_Ajax($target_url, $target_id)
{
	if($target_url =="") { $target_url = "url-target"; } else {  }
	if($target_id =="") { $target_id = ".ajax-content"; } else {  }
	$url_server = url_server();
	/* fa-cloud */
	$print = <<<EOF
<script type="text/javascript">
function url_target(url)
{ $('{$target_id}').html('<div align="center"><br><br><h4><i class="fa fa-spinner fa-spin"></i> Cargando...</h4><br><br><br></div>'); $('{$target_id}').load('{$url_server}' + url); }
</script>
EOF;
	return $print;
}

function FormTarget_Ajax($target_id)
{
	if($target_id =="") { $target_id = "form"; } else {  }
	/*
$url_server = url_server(); fa-spinner fa-cog
//$("#response_{$target_id}").html('Error: <br/> textStatus='+textStatus+', errorThrown='+errorThrown+'');
jQuery(document).ready(function($){
*/

	$print = <<<EOF
<script type="text/javascript">
$(document).ready(function() {
$("#submit_{$target_id}").click(function(){
$("#source_{$target_id}").submit(function(e){
$("#response_{$target_id}").html("<div class='alert alert-info'><b><i class='fa fa-spinner fa-spin'></i> Un momento...</b></div>");
var postData_{$target_id} = $(this).serializeArray(); var formURL_{$target_id} = $(this).attr("action");
$.ajax( { url : formURL_{$target_id}, type: "POST", data : postData_{$target_id}, success:function(data, textStatus, jqXHR){
$("#response_{$target_id}").html(''+data+'');
$('#submit_{$target_id}').prop("disabled",false); }, error: function(jqXHR, textStatus, errorThrown){
$("#response_{$target_id}").html('Error: <br/> '+JSON.stringify(jqXHR)+'');
$('#submit_{$target_id}').prop("disabled",false); } });
e.preventDefault();
$("#source_{$target_id}").unbind(); $('#submit_{$target_id}').prop("disabled",true); }); $("#source_{$target_id}").submit();
});
function getDoc(frame) { var doc = null; try { if (frame.contentWindow) { doc = frame.contentWindow.document; } } catch(err) {  } if (doc) { return doc; } try { doc = frame.contentDocument ? frame.contentDocument : frame.document; } catch(err) { doc = frame.document; } return doc; }
});
</script>
EOF;
	return $print;
}

function urls__($input) {
	$input = utf8_encode($input);
	$input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8");
	$a = array("ñ", "á", "é", "í", "ó", "ú", "ä", "ë", "ï", "ö", "ü");
	$b = array("n", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u");
	$input = str_replace($a, $b, $input);
	$input = preg_replace("/[^a-zA-Z0-9]+/", "-", $input);
	$input = preg_replace("/(-){2,}/", "$1", $input);
	$input = trim($input, "-");
	return "".$input; // Url Amigable
}

function getGUID(){
	if (function_exists('com_create_guid')){
		return com_create_guid();
	}else{
		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);// "-"
		$uuid = chr(123)// "{"
		.substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($charid,20,12)
			.chr(125);// "}"
		return $uuid;
	}
}

function get_curl($url, $post_body, $port="80", $method="POST"){
	if($url !=""){
		$ch = curl_init( );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_PORT, $port );
		//curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $method );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		if($method == "POST") { curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_body ); }
		curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 20 );
		$response_string = curl_exec( $ch );
		$curl_info = curl_getinfo( $ch );
	} else { $response_string = ""; }
	return $response_string;
}

function EnviaEmail($Para_Email, $Nombre, $Asunto, $Mail_Template){
	global $mysqli;
	global $Check_Usuario;
	$TEXT = "Hola ".$Nombre.", tiene una nueva notificaci&oacute;n.";
	$Mail_Template = utf8_encode($Mail_Template);
	$Asunto = utf8_encode($Asunto);
	$Nombre = utf8_encode($Nombre);
	$DefaultFrom = "ElGigante <no.responder@elgigantedelosazulejosgrupo100.com>";
	$url = 'https://api.mailgun.net/v3/elgigantedelosazulejosgrupo100.com/messages';
	$api = "api:key-_-GENERA-UNA-NUEVA-KEY";
	$params = array(
		'to'        => $Para_Email,
		//'cc'        => '',
		'bcc'        => 'maitret@myhostmx.com,contacto@elgigantedelosazulejosgrupo100.com,soporte@elgigantedelosazulejosgrupo100.com',
		'subject'   => $Asunto,
		'html'      => $Mail_Template,
		'text'      => $TEXT,
		'from'      => $DefaultFrom,
		'o:tracking' => 'True'
	);
	$request =  $url.'';
	$session = curl_init($request);
	curl_setopt($session, CURLOPT_POST, true);
	curl_setopt($session, CURLOPT_POSTFIELDS, $params);
	curl_setopt($session, CURLOPT_HEADER, false);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($session, CURLOPT_USERPWD, $api);
	curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

	$response = curl_exec($session);
	curl_close($session);
	$response_json = $response;
	$json = json_decode($response);

	$response_message = $json->message;
	$response_id_bad = $json->id;
	$phrase  = $response_id_bad;
	$bad = array("<", ">");
	$good   = array("", "");
	$response_id = str_replace($bad, $good, $phrase);

	if ($json->message=='Queued. Thank you.')
	{
		$Estatus_Envio = "1";
	}
	else
	{
		$Estatus_Envio = "0";
	}

	$query_Envios_Email = "SELECT * FROM `Envios_Email` WHERE `response_id` = '".$response_id."' ORDER BY `id` DESC;";
	$result_Envios_Email = $mysqli->query($query_Envios_Email);
	$num_Envios_Email = $result_Envios_Email->num_rows;
	if ($num_Envios_Email >= 1) {
		while($row_Envios_Email = $result_Envios_Email->fetch_array(MYSQLI_ASSOC)){
			$response_id = $row_Envios_Email['response_id'];
			$query_update_email = "";
			//$mysqli->query($query_update_email);
		}
	} else {
		$query_insert_email = "INSERT INTO `Envios_Email` (
`Usuario`, `Email_Usuario`, `FechaEnvio`, `Nombre`, `Asunto`, `Mensaje`, `Estatus`, `FechaEstatus`, `response_id`, `response`
) VALUES (
'".$Check_Usuario."', '$Para_Email', '".time()."', '$Nombre', '$Asunto', '".$mysqli->real_escape_string($Mail_Template)."', '$Estatus_Envio', '".time()."', '$response_id', '".$response_json."'
)";
		$mysqli->query($query_insert_email);
	}


	return $Estatus_Envio;
}

include_once("funciones.templates.php");

/*
Para habilitar Mcrypt:
sudo php5enmod mcrypt && sudo service apache2 restart
*/

function Encrypt_String($data, $key = "MyHostMX"){
	return base64_encode(
		mcrypt_encrypt(
			MCRYPT_RIJNDAEL_128,
			$key,
			$data,
			MCRYPT_MODE_CBC,
			"\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
		)
	);
}
function Decrypt_String($data, $key = "MyHostMX"){
	$decode = base64_decode($data);
	return mcrypt_decrypt(
		MCRYPT_RIJNDAEL_128,
		$key,
		$decode,
		MCRYPT_MODE_CBC,
		"\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
	);
}
/* !kQm*fF3pXe1Kbm%9 */

function Encrypt_String2($decrypted, $password='MyHostMX', $salt='OLAKASE') {
	// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
	$key = hash('SHA256', $salt . $password, true);
	// Build $iv and $iv_base64.  We use a block size of 128 bits (AES compliant) and CBC mode.  (Note: ECB mode is inadequate as IV is not used.)
	srand(); $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
	if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
	// Encrypt $decrypted and an MD5 of $decrypted using $key.  MD5 is fine to use here because it's just to verify successful decryption.
	$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
	// We're done!
	return $iv_base64 . $encrypted;
}

function Decrypt_String2($encrypted, $password='MyHostMX2', $salt='OLAKASE') {
	// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
	$key = hash('SHA256', $salt . $password, true);
	// Retrieve $iv which is the first 22 characters plus ==, base64_decoded.
	$iv = base64_decode(substr($encrypted, 0, 22) . '==');
	// Remove $iv from $encrypted.
	$encrypted = substr($encrypted, 22);
	// Decrypt the data.  rtrim won't corrupt the data because the last 32 characters are the md5 hash; thus any \0 character has to be padding.
	$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
	// Retrieve $hash which is the last 32 characters of $decrypted.
	$hash = substr($decrypted, -32);
	// Remove the last 32 characters from $decrypted.
	$decrypted = substr($decrypted, 0, -32);
	// Integrity check.  If this fails, either the data is corrupted, or the password/salt was incorrect.
	if (md5($decrypted) != $hash) return false;
	// Yay!
	return $decrypted;
}

?>
