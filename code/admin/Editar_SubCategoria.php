<?php
include_once("../funciones.php");
include_once("funciones.admin.php");
include_once("header.php");

$ver = Valida_utf8($_REQUEST['ver']);
$slug = Valida_utf8($_REQUEST['slug']);
$id_cat = Valida_utf8($_REQUEST['id_cat']);
$cat_base = Valida_utf8($_REQUEST['cat_base']);
$Tipo = Valida_utf8($_REQUEST['tipo']);
$max_n = intval(Valida_utf8($_REQUEST['max_n']));

if($max_n == ""){
$max_n = "10";
}

$query_Productos_CategoriasSubRel = "SELECT * FROM `Productos_CategoriasSubRel` WHERE `Slug_Base` = '".$cat_base."' AND `Slug` = '$id_cat' AND `Estatus` ='1' ORDER BY `id` DESC LIMIT 1;";
$result_Productos_CategoriasSubRel = $mysqli->query($query_Productos_CategoriasSubRel);
$num_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->num_rows;
if ($num_Productos_CategoriasSubRel >= 1) {
$row_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->fetch_array(MYSQLI_ASSOC);
?>

<form role="form" method="post" id="source_form" action="./inc/procesa_editar_subcategoria_prod.php" form-data-pjax_>

<h3 class="text-center">Editar Existentes</h3>
<?php
$query_Productos_CategoriasSub = "SELECT * FROM `Productos_CategoriasSub` WHERE `Slug_Base` = '$cat_base' AND `Slug_Rel_Base` = '".$row_Productos_CategoriasSubRel['Slug']."' AND `Estatus` = '1' ORDER BY `id` ASC;";
$result_Productos_CategoriasSub = $mysqli->query($query_Productos_CategoriasSub);
$num_Productos_CategoriasSub = $result_Productos_CategoriasSub->num_rows;
if ($num_Productos_CategoriasSub >= 1) {
$options_cat_print = "";
while ($row_Productos_CategoriasSub = $result_Productos_CategoriasSub->fetch_array(MYSQLI_ASSOC)) {
//$options_array['Slug'] = $result_Productos_CategoriasSub['Slug'];
//$options_array['Categoria'] = $result_Productos_CategoriasSub['Categoria'];
$options_cat_print .= <<<EOF
{$row_Productos_CategoriasSub['Slug']} {$row_Productos_CategoriasSub['Categoria']}
EOF;
$form .= <<<EOF
<div class="row">
<div id="{$row_Productos_CategoriasSub['Slug']}" class="col-sm-6" title="{$row_Productos_CategoriasSub['Categoria']}">
<label for="{$row_Productos_CategoriasSub['Slug']}">Categoria</label>
<input type="text" class="form-control {$row_Productos_CategoriasSub['Slug']}" name="subcat[{$row_Productos_CategoriasSub['Slug']}][Categoria]" value="{$row_Productos_CategoriasSub['Categoria']}" required>
</div>
<div id="{$row_Productos_CategoriasSub['Slug']}" class="col-sm-6" title="{$row_Productos_CategoriasSub['Categoria']}">
<label for="{$row_Productos_CategoriasSub['Slug']}">Descripcion</label>
<input type="text" class="form-control {$row_Productos_CategoriasSub['Slug']}" name="subcat[{$row_Productos_CategoriasSub['Slug']}][Descripcion]" value="{$row_Productos_CategoriasSub['Descripcion']}" required>
</div>
</div>
<br>
EOF;
}
echo $form;
} else { ?>
<div class="text-center text-warning">Aun no se agregan subcategorias</div>
<?php } ?>

<hr id="agrega_nueva">
<h3 class="text-center">Agregar Nuevas <a href="./Editar_SubCategoria.php?cat_base=<?php echo $cat_base; ?>&id_cat=<?php echo $id_cat; ?>&max_n=<?php echo intval($max_n+1); ?>#agrega_nueva">+</a></h3>
<?php
for($n=1;$n<=$max_n;$n++){
$new_cats_form .= <<<EOF
<div class="row">
<div  class="col-sm-6" title="Nueva">
<label>Nueva Categoria {$n}</label>
<input type="text" class="form-control" name="Nueva_Cat[{$n}][Categoria]" value="" placeholder="Ingrese Categoria" required>
</div>
<div class="col-sm-6">
<label for="">Nueva Descripcion {$n}</label>
<input type="text" class="form-control" name="Nueva_Cat[{$n}][Descripcion]" value="" placeholder="Ingrese descripcion" required>
</div>
</div>
<br>
EOF;
}
echo $new_cats_form;
?>

<input type="hidden" name="Slug_Base" value="<?php echo $cat_base; ?>">
<input type="hidden" name="Slug_Rel_Base" value="<?php echo $id_cat; ?>">

<div id="response_form" align="center">...</div>

<div class="row">
<div class="col-sm-12" align="center">
<div id="submit_form_">
<button type="submit" class="btn btn-success" id="submit_form">Guardar</button>
</div>
</div>
</div>

</form>

<br>
<br>

<?php } else { ?>
Categoria no encontrada!
<?php } ?>


<?php
//$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>

