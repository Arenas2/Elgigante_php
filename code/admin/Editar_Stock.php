<?php
include_once("../funciones.php");
include_once("funciones.admin.php");
include_once("header.php");

$ver = Valida_utf8($_REQUEST['ver']);
$slug = Valida_utf8($_REQUEST['slug']);
$id_prod = Valida_utf8($_REQUEST['id_prod']);
$Tipo = Valida_utf8($_REQUEST['tipo']);

$query_Productos = "SELECT * FROM `Productos` WHERE `id` = '$id_prod' ORDER BY `id` DESC LIMIT 1";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) {
$row_Productos = $result_Productos->fetch_array(MYSQLI_ASSOC);

$query_Productos_Stock = "SELECT * FROM `Productos_Stock` WHERE `Id_Producto` = '$id_prod' ORDER BY `id` DESC;";
$result_Productos_Stock = $mysqli->query($query_Productos_Stock);
$num_Productos_Stock = $result_Productos_Stock->num_rows;
if ($num_Productos_Stock >= 1) {
$row_Productos_Stock = $result_Productos_Stock->fetch_array(MYSQLI_ASSOC);
$id_stock = $row_Productos_Stock['id'];
$Id_Producto = $row_Productos_Stock['Id_Producto'];
$En_Stock = $row_Productos_Stock['En_Stock'];
} else {
$query_NewStock = "INSERT INTO `Productos_Stock` ( `Id_Producto`, `En_Stock` ) VALUES ( '" . $id_prod . "', '0')";
$mysqli->query($query_NewStock);
$En_Stock = "0";
}

?>

<form role="form" method="post" id="source_form" action="./inc/procesa_editar_stock.php" form-data-pjax_>
<input type="hidden" name="id_prod" value="<?php echo $id_prod; ?>">
<input type="hidden" name="id_stock" value="<?php echo $id_stock; ?>">

<h3 align="center">Editando Stock: <?php echo $row_Productos['Producto']; ?></h3>

<div class="row">

<div id="En_Stock" class="col-sm-12" title="En_Stock">
<div class="form-group">
<label for="En_Stock">Productos en Stock</label>

<div class="input-group">
<input type="text" class="form-control En_Stock" name="En_Stock" placeholder="Productos en Stock" value="<?php echo $En_Stock; ?>" "required">
<span class="input-group-addon"><i class="fa fa-info"></i></span>
</div>
</div>
</div>

</div>


<div id="response_form" align="center">...</div>

<div class="row">
<div class="col-sm-4" align="right">
<a href="Stock.php?id_prod=<?php echo $id_prod; ?>" class="btn btn-danger"
   title="Cancelar y Regresar a la p&aacute;gina anterior">Cancelar</a>
</div>
<div class="col-sm-4" align="center">
</div>
<div class="col-sm-4" align="left">
<div id="submit_form_">
<button type="submit" class="btn btn-success" id="submit_form">Guardar</button>
</div>
</div>
</div>

</form>

<?php } else { ?>

<h1 class="text-align text-success">Producto no encontrado.</h1>

<?php } ?>


<?php
//$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>