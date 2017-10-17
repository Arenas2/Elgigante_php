<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../../funciones.php");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$msg_error = ""; $msg = "";
$FechaRegistro = time();

$Id_Producto = Valida_utf8($_REQUEST['id_prod']);
$En_Stock = Valida_utf8($_REQUEST['En_Stock']);

$query_Productos = "SELECT * FROM `Productos` WHERE `id` = '$Id_Producto' ORDER BY `id` DESC LIMIT 1";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) {

$query_UpdateStock = "UPDATE `Productos_Stock` SET `En_Stock` = '$En_Stock' WHERE `Id_Producto` = '$Id_Producto';";
$mysqli->query($query_UpdateStock);
$msg_estatus = '<div class="alert alert-success text-center"><b>Producto actualizado...</b></div>
<script>
location = "Stock.php?id_prod='.$id_prod.'&guardada=ok";
</script>';

} else {
$msg_estatus = '<div class="alert alert-success text-danger"><b>Producto no encontrado</b></div>';
}
echo $msg_estatus;
?>