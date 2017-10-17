<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../../funciones.php");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$id_prod = Valida_utf8($_REQUEST['id_prod']);
?>

<form role="form" method="post" id="source_form" action="./inc/procesa_nuevo_prod.php">

<div class="row">

<div id="Producto" class="col-sm-6" title="Producto">
<div class="form-group">
<label for="Producto">Producto</label>
<div class="input-group">
<input type="text" class="form-control Producto" name="Producto" placeholder="Producto" value="<?php echo $Productos['Producto']; ?>" required>
<span class="input-group-addon"><i class="fa fa-info"></i></span>
</div>
</div>
</div>

</div>

<div id="response_form" align="center"> &nbsp; </div>
<hr>

<div class="row">
<div class="col-md-6" align="center">
<a class="btn btn-default" onclick="$.reiniciar('');">Reiniciar</a>
</div>
<div class="col-md-6" align="center">
<span id="submit_form">
<button class="btn btn-success" id="submit_form" type="button">Guardar</button>
</span>
</div>
</div>

</form>

<?php
echo FormTarget_Ajax($target_id);
?>