<?php
include_once("../funciones.php");
include_once("funciones.admin.php");
include_once("header.php");

$ver = Valida_utf8($_REQUEST['ver']);
$slug = Valida_utf8($_REQUEST['slug']);
$id_cat = Valida_utf8($_REQUEST['id_cat']);
$Tipo = Valida_utf8($_REQUEST['tipo']);
$SubTipo = Valida_utf8($_REQUEST['subtipo']);

$query_Entradas_Categorias = "SELECT * FROM `Entradas_Categorias` WHERE `id` = '$id_cat' AND `Tipo` = '$Tipo' ORDER BY `id` DESC;";
$result_Entradas_Categorias = $mysqli->query($query_Entradas_Categorias);
$num_Entradas_Categorias = $result_Entradas_Categorias->num_rows;

if ($num_Entradas_Categorias >= 1 || $id_cat == "0") {
$row_Entradas_Categorias = $result_Entradas_Categorias->fetch_array(MYSQLI_ASSOC);
?>

<form role="form" method="post" id="source_form" action="./inc/procesa_editar_categoria_entrada.php" form-data-pjax_>
<input type="hidden" name="id_cat" value="<?php echo $id_cat; ?>">
<input type="hidden" name="tipo" value="<?php echo $Tipo; ?>">
<input type="hidden" name="subtipo" value="<?php echo $SubTipo; ?>">

<h3 align="center">Editando Categor&iacute;a: <?php echo $row_Entradas_Categorias['Categoria']; ?> </h3>

<div class="row">

<div id="Categoria" class="col-sm-6" title="Categoria">
<div class="form-group">
<label for="Categoria">Categor&iacute;a</label>
<div class="input-group">
<input type="text" class="form-control Categoria" name="Categoria" placeholder="Categoria" value="<?php echo $row_Entradas_Categorias['Categoria']; ?>" required>
<span class="input-group-addon"><i class="fa fa-info"></i></span>
</div>
</div>
</div>

<div id="Descripcion" class="col-sm-6" title="Descripcion">
<div class="form-group">
<label for="Descripcion">Descripcion</label>
<div class="input-group">
<input type="text" class="form-control Descripcion" name="Descripcion" placeholder="Descripcion" value="<?php echo $row_Entradas_Categorias['Descripcion']; ?>" required>
<span class="input-group-addon"><i class="fa fa-info"></i></span>
</div>
</div>
</div>

</div>

<div id="response_form" align="center"></div>

<div class="row">
<div class="col-sm-4" align="right">
<a href="Entradas.php?tipo=<?php echo $Tipo; ?>" class="btn btn-danger" title="Cancelar y Regresar a la p&aacute;gina anterior">Cancelar</a>
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

<p style="text-align: center;">Categor&iacute;a no encontrada</p>

<?php } ?>

<?php
//$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>