<?php
include_once("funciones.php");
$GetLat = $mysqli->real_escape_string($_REQUEST['lat']);
$GetLon = $mysqli->real_escape_string($_REQUEST['lon']);

$GetAccion = $mysqli->real_escape_string($_REQUEST['accion']);
$GetId_Producto = $mysqli->real_escape_string($_REQUEST['id_producto']);
$user_agent = user_agent();
$IP = ip(); $Session_Id = $session_id;

if($GetAccion == "add_prod_cot"){
$query_Sesion_Carrito = "SELECT * FROM `Sesion_Carrito` WHERE `Session_Id` = '$session_id' ORDER BY `id` DESC;";
$result_Sesion_Carrito = $mysqli->query($query_Sesion_Carrito);
$num_Sesion_Carrito = $result_Sesion_Carrito->num_rows;
if ($num_Sesion_Carrito >= 1) {
$row_Sesion_Carrito = $result_Sesion_Carrito->fetch_array(MYSQLI_ASSOC);
$Id_Pedido = $row_Sesion_Carrito['Id_Pedido'];
$Query_Session = "UPDATE `Sesion_Carrito` SET `Lat` = '$GetLat', `Lng` = '$GetLon', `IP` = '".$IP."',
 `User_Agent` = '".$user_agent."', `FechaHora` = '".time()."' WHERE `Session_Id` = '".$session_id."';";
$mysqli->query($Query_Session);
$query_Sesion_Carrito_Prods = "SELECT * FROM `Sesion_Carrito_Prods` WHERE `Session_Id` = '$Session_Id' AND `Id_Pedido` = '$Id_Pedido' AND `Id_Producto` = '".$GetId_Producto."' ORDER BY `id` DESC;";
$result_Sesion_Carrito_Prods = $mysqli->query($query_Sesion_Carrito_Prods);
$num_Sesion_Carrito_Prods = $result_Sesion_Carrito_Prods->num_rows;
if ($num_Sesion_Carrito_Prods >= 1) {
$row_Sesion_Carrito_Prods = $result_Sesion_Carrito_Prods->fetch_array(MYSQLI_ASSOC);
$Num_Prods = $row_Sesion_Carrito_Prods['Num_Prods'];
$Num_Prods = intval($Num_Prods+1);
$Query_Session_Prods = "UPDATE `Sesion_Carrito_Prods` SET
 `Num_Prods` = '".$Num_Prods."', `FechaHora` = '".time()."'
 WHERE `Session_Id` = '$Session_Id' AND `Id_Pedido` = '$Id_Pedido' AND `Id_Producto` = '".$GetId_Producto."';";
$mysqli->query($Query_Session_Prods);
} else {
$Num_Prods = "1";
$Query_Session_Prods = "INSERT INTO `Sesion_Carrito_Prods` (
`Session_Id`, `Id_Pedido`, `Id_Producto`, `Num_Prods`, `FechaHora`, `Estatus`
) VALUES (
'$Session_Id', '$Id_Pedido', '".$GetId_Producto."', '1', '".time()."', 'Pendiente'
);";
$mysqli->query($Query_Session_Prods);
}
$msg_session = "<div class='alert alert-success text-center'>Se ha registrado su producto.  <a href='".$url_server."/ver/finalizar_pedido?id_pedido=".$Id_Pedido."' class='btn btn-success btn-xs'>Finalizar Pedido</a></div>";
?>
(<?php echo $Num_Prods; ?>) PRODUCTO AGREGADO
<?php } else {
$Id_Pedido = $random;
$Num_Prods = "1";
$Query_Session = "INSERT INTO `Sesion_Carrito`
(`Session_Id`, `Id_Pedido`, `IP`, `User_Agent`, `Estatus`, `FechaHora`)
 VALUES
('$session_id', '$Id_Pedido', '$IP', '$user_agent', 'Pendiente', '".time()."');";
$mysqli->query($Query_Session);

$Query_Session_Prods = "INSERT INTO `Sesion_Carrito_Prods` (
`Session_Id`, `Id_Pedido`, `Id_Producto`, `Num_Prods`, `FechaHora`, `Estatus`
) VALUES (
'$session_id', '$Id_Pedido', '".$GetId_Producto."', '1', '".time()."', 'Pendiente'
);";
$mysqli->query($Query_Session_Prods);

$msg_session = "<div class='alert alert-success text-center'>Se ha registrado su primer producto en el pedido.  <a href='".$url_server."/ver/finalizar_pedido?id_pedido=".$Id_Pedido."' class='btn btn-success btn-xs'>Finalizar Pedido</a></div>";
?>
(<?php echo $Num_Prods; ?>) PRODUCTO AGREGADO
<?php } ?>

<?php } else if ($GetAccion=="get_info_prod_cot") {
$query_Sesion_Carrito_Prods = "SELECT * FROM `Sesion_Carrito_Prods` WHERE `Session_Id` = '".$Session_Id."' ORDER BY `id` DESC;";
$result_Sesion_Carrito_Prods = $mysqli->query($query_Sesion_Carrito_Prods);
$num_Sesion_Carrito_Prods = $result_Sesion_Carrito_Prods->num_rows;
if($num_Sesion_Carrito_Prods >=1){
$row_Sesion_Carrito_Prods = $result_Sesion_Carrito_Prods->fetch_array(MYSQLI_ASSOC);
$msg_session = "<div class='alert alert-success text-center'>Actualmente tiene <b>".$num_Sesion_Carrito_Prods."</b> productos en su cotizaci&oacute;n. <a href='".$url_server."/ver/finalizar_pedido?id_pedido=".$row_Sesion_Carrito_Prods['Id_Pedido']."' class='btn btn-success btn-xs'>Finalizar Pedido</a></div>";
}
?>
<?php } else if ($GetAccion=="elimina_prod_cot"){
$query_Sesion_Carrito_Prods = "SELECT * FROM `Sesion_Carrito_Prods` WHERE `Session_Id` = '".$Session_Id."' AND `Id_Producto` = '".$GetId_Producto."' ORDER BY `id` DESC;";
$result_Sesion_Carrito_Prods = $mysqli->query($query_Sesion_Carrito_Prods);
$num_Sesion_Carrito_Prods = $result_Sesion_Carrito_Prods->num_rows;
if($num_Sesion_Carrito_Prods >=1) {
$Delete_Prod = "DELETE FROM `Sesion_Carrito_Prods` WHERE `Session_Id` = '".$Session_Id."' AND `Id_Producto` = '".$GetId_Producto."';";
$mysqli->query($Delete_Prod); ?>
<script>
location = "";
</script>
<?php } } else { ?>
<?php } ?>

<script type="text/javascript">
$(document).ready(function() {
$(".status_pedido_ajax").html("<?php echo $msg_session; ?>");
});
</script>
