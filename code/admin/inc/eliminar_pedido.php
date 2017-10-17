<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../../funciones.php");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
include_once("../funciones.admin.php");
include_once("../header.php");

$msg_error = ""; $msg = "";
$FechaRegistro = time();
$id_pedido = Valida_utf8($_REQUEST['id_pedido']);

$return_to = "Pedidos.php?id_eliminado=".$id_pedido."&time=".time();
?>

<?php
$DeleteCarrito = "DELETE FROM `Sesion_Carrito` WHERE `Id_Pedido` = '".$id_pedido."';";
$mysqli->query($DeleteCarrito);
//echo $DeleteCarrito."<br>";
$DeleteCarritoSub = "DELETE FROM `Sesion_Carrito_Prods` WHERE `Id_Pedido` = '".$id_pedido."';";
$mysqli->query($DeleteCarritoSub);
//echo $DeleteCarritoSub."<br>";
?>

<?php echo $msg; ?>
<h3 class="text-center text-success">Pedido borrado, regresando...</h3>
<script>
setTimeout(function(){
location = "../<?php echo $return_to; ?>";
}, 2000);
</script>

<?php
include_once("../footer.php");
?>