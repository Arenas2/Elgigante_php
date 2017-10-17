<?php
include_once("../funciones.php");
include_once("funciones.admin.php");
include_once("header.php");

$Id_Pedido = Valida_utf8($_REQUEST['id_pedido']);
$GetId = Valida_utf8($_REQUEST['id']);

$query_Pedidos = "SELECT * FROM `Pedidos` WHERE `id` = '$GetId' OR `Id_Pedido` = '$Id_Pedido' ORDER BY `id` DESC;";
$result_Pedidos = $mysqli->query($query_Pedidos);
$num_Pedidos = $result_Pedidos->num_rows;
if ($num_Pedidos >= 1) {
$Pedidos = $result_Pedidos->fetch_array(MYSQLI_ASSOC);
?>


<form role="form" method="post" id="source_form" action="Procesa_Editar_Pedido.php" >

<input type="hidden" class="form-control id" name="id" placeholder="id" value="<?php echo $Pedidos['id']; ?>" required>

<h2 class="text-center">Id de Pedido: <?php echo $Pedidos['Id_Pedido']; ?></h2>
<div class="row">
<div id="FechaHora" class="col-sm-6" title="FechaHora">
<h5>Fecha de Registro: <?php echo date('d/m/Y H:i:s', $Pedidos['FechaHora']); ?></h5>
<h5>Fecha del Pago: <?php echo date('d/m/Y H:i:s', $Pedidos['FechaHoraPago']); ?></h5>
<h5>Fecha para Entregarse: <?php echo date('d/m/Y H:i:s', $Pedidos['FechaHoraEntrega']); ?></h5>
</div>

<div class="col-sm-6">
<h4>Total: $<?php echo $Pedidos['order_amount']; ?> <?php echo $Pedidos['order_currency']; ?></h4>
</div>

</div>

<div class="row">
<div id="Estatus" class="col-sm-6" title="Estatus">
<div class="form-group">
<label for="Estatus">Estatus (<?php echo $Pedidos['Estatus']; ?>)</label>
<div class="input-group">
<?php
$GetEstatus_Options_Array = GetEstatus_Options_Array("Productos", "Estatus");
//echo json_encode($GetEstatus_Options_Array);
foreach($GetEstatus_Options_Array as $key=>$var){
if($Pedidos['Estatus'] == $var['value']){
$options_estatus .= "<option value='".$var['value']."' selected>".$var['visible']."</a>\n";
} else {
$options_estatus .= "<option value='".$var['value']."'>".$var['visible']."</a>\n";
}
}
?>
<select class="form-control Estatus" name="Estatus" required>
<?php echo $options_estatus; ?>
</select>
<span class="input-group-addon"><i class="fa fa-info"></i></span>
</div>
</div>
</div>

<div id="Estatus_Entrega" class="col-sm-6" title="Estatus_Entrega">
<div class="form-group">
<label for="Estatus_Entrega">Estatus de Entrega (<?php echo $Pedidos['Estatus_Entrega']; ?>)</label>
<div class="input-group">

<?php
$GetEstatus_Options_Array_entrega = GetEstatus_Options_Array("Productos", "Estatus_Entrega");
//echo json_encode($GetEstatus_Options_Array_entrega);
foreach($GetEstatus_Options_Array_entrega as $key_entrega=>$var_entrega){
if($Pedidos['Estatus_Entrega'] == $var['value']){
$options_estatus_entrega .= "<option value='".$var_entrega['value']."' selected>".$var_entrega['visible']."</a>\n";
} else {
$options_estatus_entrega .= "<option value='".$var_entrega['value']."'>".$var_entrega['visible']."</a>\n";
}
}
?>
<select class="form-control Estatus_Entrega" name="Estatus_Entrega"  required>
<?php echo $options_estatus_entrega; ?>
</select>

<span class="input-group-addon"><i class="fa fa-info"></i></span>
</div>
</div>
</div>

<div id="Comentarios" class="col-sm-12" title="Comentarios">
<div class="form-group">
<label for="Comentarios">Comentarios</label>
<div class="input-group">
<textarea class="form-control Comentarios" name="Comentarios" placeholder="Comentarios" required><?php echo $Pedidos['Comentarios']; ?></textarea>
<span class="input-group-addon"><i class="fa fa-info"></i></span>
</div>
</div>
</div>

</div>

<div id="response_form" align="center"> &nbsp; </div>
<hr>

<div class="row">
<div class="col-md-6" align="center">
<a class="btn btn-default" href="Pedidos.php">Cancelar</a>
</div>
<div class="col-md-6" align="center">
<span id="submit_form">
<button class="btn btn-success" id="submit_form" type="button">Guardar</button>
</span>
</div>
</div>

<hr>

<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
Datos adicionales del Gateway de Pagos:
</button>
<div class="collapse" id="collapseExample">
  <div class="well">
order_id: <?php echo $Pedidos['order_id']; ?><br>
session_result: <?php echo $Pedidos['session_result']; ?><br>
session_id: <?php echo $Pedidos['session_id']; ?> <br>
session_updateStatus: <?php echo $Pedidos['session_updateStatus']; ?><br>
session_version: <?php echo $Pedidos['session_version']; ?> <br>
session_successIndicator: <?php echo $Pedidos['session_successIndicator']; ?><br>
Comentarios: <?php echo $Pedidos['Comentarios']; ?>
  </div>
</div>

</form>

<?php } else {?>

<?php } ?>

<?php
//$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>

