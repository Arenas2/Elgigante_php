<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../funciones.php");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$msg_error = ""; $msg = "";
$FechaRegistro = time();

$get_id = $mysqli->real_escape_string(Valida_utf8($_REQUEST['id']));
$Estatus = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Estatus']));
$Estatus_Entrega = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Estatus_Entrega']));
//$order_amount = $mysqli->real_escape_string(Valida_utf8($_REQUEST['order_amount']));
$Comentarios = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Comentarios']));

//if($Producto != "" && $Descripcion != "") {
if($get_id != "") {

$query_Productos = "SELECT * FROM `Pedidos` WHERE `id` = '$get_id' ORDER BY `id` DESC LIMIT 1";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) {
$new_producto = "UPDATE `Pedidos` SET `Estatus` = '$Estatus', `Estatus_Entrega` = '$Estatus_Entrega', `Comentarios` = '$Comentarios' WHERE `id` = '".$get_id."';";
$msg_estatus = '<div class="alert alert-success text-center"><b>Pedido Actualizado...</b></div>';
} else {
$msg_error = '<div class="alert alert-success text-center"><b>Pedido no encontrado...</b></div>';
}

if($msg_error != "") { ?>
<div class="list-group"><b><?php echo $msg_error; ?></b></div>
<?php } else if($msg_error == "") {
if ($result = $mysqli->query($new_producto)) {
$new_id = $mysqli->insert_id;
if($new_id){
$id_prod_ = $new_id;
} else {
$id_prod_ = $id_prod;
}
//echo json_encode($_REQUEST);
echo $msg_estatus; ?>
<script>
location = "Pedidos.php?id_update=<?php echo $get_id; ?>&guardada=ok";
</script>
<?php  } } else { ?>
<div class="alert alert-error text-center"><b>Error</b><br><?php echo mysql_error(); ?></div>
<?php } } else { ?>
Para actualizar un pedido, es necesario un id :/ ...
<?php } ?>