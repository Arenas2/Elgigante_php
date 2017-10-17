<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");

include_once("../../funciones.php");
$GetAccion = $mysqli->real_escape_string($_REQUEST['accion']);
$GetId_Pedido = $mysqli->real_escape_string($_REQUEST['id_pedido']);
$user_agent = user_agent();
$IP = ip(); $Session_Id = $session_id;

$query_Sesion_Carrito = "SELECT * FROM `Sesion_Carrito` WHERE `Id_Pedido` = '".$GetId_Pedido."' ORDER BY `id` DESC LIMIT 1;";
$result_Sesion_Carrito = $mysqli->query($query_Sesion_Carrito);
$num_Sesion_Carrito = $result_Sesion_Carrito->num_rows;
if ($num_Sesion_Carrito >= 1) {
$row_Sesion_Carrito = $result_Sesion_Carrito->fetch_array(MYSQLI_ASSOC);
?>
<div class="modal-body">
<div style="min-height:250px;padding:0px 5px 5px 5px;">

<?php echo $row_Sesion_Carrito['Estatus']; ?>

</div>
</div>
<?php } else { ?>
<div class="modal-body">
<div style="min-height:250px;padding:0px 5px 5px 5px;" align="center">
<b>Pedido no encontrado.</b>
</div>
</div>
<?php } ?>