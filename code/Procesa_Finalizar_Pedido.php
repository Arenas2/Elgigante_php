<?php
include_once("funciones.php");

$Id_Pedido = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Id_Pedido']));
$Nombre = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Nombre']));
$Telefono = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Telefono']));
$Email = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Email']));
$Direccion = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Direccion']));
$Ciudad = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Ciudad']));
$Tienda = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Tienda']));
$Lat = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Lat']));
$Lng = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Lng']));

$user_agent = user_agent();
$IP = ip();
$Session_Id = $session_id;
$Data = json_encode($_REQUEST);

if($Nombre != "" && $Telefono != "" && $Tienda != ""){

$query_Sesion_Carrito = "SELECT * FROM `Sesion_Carrito` WHERE `Id_Pedido` = '$Id_Pedido' ORDER BY `id` DESC;";
$result_Sesion_Carrito = $mysqli->query($query_Sesion_Carrito);
$num_Sesion_Carrito = $result_Sesion_Carrito->num_rows;
if ($num_Sesion_Carrito >= 1) {
$row_Sesion_Carrito = $result_Sesion_Carrito->fetch_array(MYSQLI_ASSOC);
$Update_Session = "UPDATE `Sesion_Carrito` SET `Nombre` = '$Nombre', `Telefono` = '$Telefono', `Email` = '$Email', `Direccion` = '$Direccion', `Ciudad` = '$Ciudad', `Tienda` = '$Tienda', `Lat` = '$Lat', `Lng` = '$Lng', `IP` = '$IP', `User_Agent` = '$user_agent', `Estatus` = 'Ingresado', `FechaHora` = '".time()."', `Data` = '".$mysqli->real_escape_string($Data)."'
 WHERE `Id_Pedido` = '$Id_Pedido';";
if($mysqli->query($Update_Session)){
$msg = "<div class='alert alert-success'><h3>Su pedido ha finalizado, en breve uno de nuestros ejecutivos se pondr&aacute; en contacto con usted.</h3></div>";

$query_Sucursales = "SELECT * FROM `Sucursales` WHERE `id` = '".$Tienda."' ORDER BY `id` DESC;";
$result_Sucursales = $mysqli->query($query_Sucursales);
$num_Sucursales = $result_Sucursales->num_rows;
if($num_Sucursales >=1) {
$Sucursales = $result_Sucursales->fetch_array(MYSQLI_ASSOC);
$Email_Send = $Sucursales['Email'];
} else {
$Email_Send = "cliker@live.com";
//$Email_Send = "maitret@myhostmx.com";
}

//$Email_Send = "cliker@live.com,soporte@elgigantedelosazulejos.com.mx,contacto@elgigantedelosazulejos.com.mx";
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
Id de Tienda: ({$Tienda}) {$Sucursales['Sucursal']}
<br>
Ubicaci&oacute;n: {$Mapa}
<br>
<br>
<br>
<hr>
Detalles del Pedido:
<br>
http:{$url_server}/ver/finalizar_pedido?id_pedido={$Id_Pedido}&no_email=1&ver_resumen=1
<br><br>
Ver todos los pedidos:
<br>
http:{$url_server}/admin/Pedidos.php
<hr>
<br>
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
$Params['Email'] = $Email_Send;
$Params['Asunto'] = $Asunto;
$Params['Mensaje'] = $Mensaje;
$SendMail = SendMail($Params);
//echo json_encode($SendMail);

session_regenerate_id();
?>
<script>
alert("Su pedido ha finalizado, en breve uno de nuestros ejecutivos se pondr&aacute; en contacto con usted.");
setTimeout(function(){
location = "<?php echo $url_server; ?>";
}, 10000);
</script>
<?php
} else {
$msg = "<div class='alert alert-success'>Su pedido aun no finaliza (".$mysqli->error.")</div>";
$Params_error = array();
$Params_error['Email'] = "maitret@myhostmx.com";
$Params_error['Asunto'] = "Error mysqli: ".$mysqli->error;
$Params_error['Mensaje'] = <<<EOF
{$mysqli->error}
<br>
<br>
{$Data}
EOF;
$SendMail = SendMail($Params_error);

}

}
?>
<?php echo $msg; ?>
<?php } else { ?>
<script>alert("Todos los campos son requeridos.");</script>
<div class="alert alert-danger"><h3>Todos los campos son requeridos.</h3></div>
<?php } ?>