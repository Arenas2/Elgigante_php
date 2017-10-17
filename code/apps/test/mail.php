<?php
include_once("../../funciones.php");
/*
$response_id = "<".sha1(microtime(true))."@elgigantedelosazulejos.com.mx>";
$no_reply = "No Responder <no.reply@elgigantedelosazulejos.com.mx>";
$reply = "ElGigante <soporte@elgigantedelosazulejos.com.mx>";
$headers = "From: ".$reply." \n";
$headers .= "X-MAILER: MyHostMX \n";
//$headers .= "CC: ".$Email." \n";
$headers .= "BCC: ".$reply." \n";
$headers .= "Reply-To: ".$reply." \n";
$headers .= "Return-Path: ".$no_reply." \n";
$headers .= "MIME-Version: 1.0 \n";
$headers .= "Date: ".date('r')." \n";
$headers .= "Message-Id: ".$response_id." \n";
//$headers .= "Content-Type: text/html; charset=windows-1252 \n";
$headers .= "Content-Type: text/html; charset=iso-8859-1 \n";
$headers .= "Content-Transfer-Encoding: 7bit \n";
//mail("contacto@elgigantedelosazulejos.com.mx", "Prueba", "Omitir mensaje", $headers);
mail("soporte@elgigantedelosazulejos.com.mx", "Prueba", "Omitir mensaje", $headers);
//mail("maitret@myhostmx.com", "Prueba", "Omitir mensaje", $headers);
*/
$user_agent = user_agent();
$IP = ip();
$Session_Id = $session_id;
$Data = json_encode($_REQUEST);

$Nombre = "Luigui Maitret";
$Email = "maitret@myhostmx.com";
$Asunto = "Nuevo Pedido: ".$Id_Pedido." / ".$Nombre."";

if($Lat != "" & $Lng != "") {
$Mapa = "<a href='https://www.google.com.mx/maps/?q=" . $Lat . "," . $Lng . "' target='_blank'>Ver Mapa</a>";
} else {
$Mapa = "Sin Ubicaci&oacute;n";
}
$Mensaje = <<<EOF
Se registr&oacute; un nuevo pedido: {$Id_Pedido}
<br>
Nombre: {$Nombre}
<br>
Email: {$Email}
<br>
Tel&eacute;fono: {$Telefono}
<br>
Id de Tienda: {$Tienda} (ver detalles de pedido para mas info)
<br>
Ubicaci&oacute;n: {$Mapa}
<br>
<br>
<hr>
Detalles del Pedido:
<br>
http:{$url_server}/ver/finalizar_pedido?id_pedido={$Id_Pedido}&no_email=1&ver_resumen=1
<br><br>
Ver todos los pedidos:
<br>
http:{$url_server}/_a_d_m_i_n_/Pedidos.php
<hr>
<br>
Datos tecnicos:
<br>
{$Data}
<br>
{$IP}
<br>
{$user_agent}
<br>
{$Session_Id}
EOF;

$Params = array();
$Params['Nombre'] = $Nombre;
$Params['Email'] = $Email;
$Params['Asunto'] = $Asunto;
$Params['Mensaje'] = $Mensaje;
$SendMail = SendMail($Params);

echo json_encode($SendMail);

?>