<?php
$GetCat = $mysqli->real_escape_string($_REQUEST['cat']);
$GetCatQ = $_REQUEST['cat_q'];
$GetOrden = $mysqli->real_escape_string($_REQUEST['orden']);
$GetQ = $mysqli->real_escape_string($_REQUEST['q']);
?>
<style>
body {
background-color: #F4F5F6;
}
.td_producto {
padding: 10px 10px 0px 10px;
}
.td_producto:hover {
padding: 10px 10px 0px 10px;
border: 2px solid #666666;
}
.img_producto_:hover {
padding: 1px;
border: 2px solid #666666;
}
</style>

<br>
<h3 class="SourceSansPro-Light text-center" style="color: #666666;">EXPLORA TODOS NUESTROS PRODUCTOS</h3>
<br>

<div class="container" align="center">
<div class="borde_sombra" align="center" style="background-color:#ffffff;padding:0px;">
<?php $img_param = "quality=100&h=120"; ?>

<table width="100%" align="center"><tr>
<td width="20%" valign="middle" align="right" class="td_producto" style="background-color: #F70F0F;">
<a href="<?php echo $url_server; ?>/ver/productos_listado?cat=pisos-y-azulejo&t_bg_c=s#title">
<img src="<?php echo $url_server_img; ?>/img/productos/pisos_2.png?<?php echo $img_param; ?>" class="img-responsive img_producto">
</a>
</td>
<td width="20%" valign="middle" align="right" class="td_producto" style="background-color: #FFCC00;">
<a href="<?php echo $url_server; ?>/ver/productos_listado?cat=muebles-de-bano-y-cocina&t_bg_c=#title">
<img src="<?php echo $url_server_img; ?>/img/productos/banos_2.png?<?php echo $img_param; ?>" class="img-responsive img_producto">
</a>
</td>
<td width="20%" valign="middle" align="right" class="td_producto" style="background-color: #1C4A78;">
<a href="<?php echo $url_server; ?>/ver/productos_listado?cat=llaves-y-accesorios&t_bg_c=#title">
<img src="<?php echo $url_server_img; ?>/img/productos/llaves_2.png?<?php echo $img_param; ?>" class="img-responsive img_producto">
</a>
</td>
<td width="20%" valign="middle" align="right" class="td_producto" style="background-color: #99CC33">
<a href="<?php echo $url_server; ?>/ver/productos_listado?cat=tinacos&t_bg_c=#title">
<img src="<?php echo $url_server_img; ?>/img/productos/tinacos_2.png?<?php echo $img_param; ?>" class="img-responsive img_producto">
</a>
</td>
<td width="20%" valign="middle" align="right" class="td_producto" style="background-color: #F70F0F;">
<a href="<?php echo $url_server; ?>/ver/productos_listado?cat=cenefas&t_bg_c=#title">
<img src="<?php echo $url_server_img; ?>/img/productos/cenefas_2.png?<?php echo $img_param; ?>" class="img-responsive img_producto">
</a>
</td>
</tr>
</table>
<table width="100%" align="center"><tr>
<td width="20%" valign="middle" align="right" class="td_producto" style="background-color: #1C4A78;">
<a href="<?php echo $url_server; ?>/ver/productos_listado?cat=tinas&t_bg_c=1C4A78#title">
<img src="<?php echo $url_server_img; ?>/img/productos/tinas_2.png?<?php echo $img_param; ?>" class="img-responsive img_producto">
</a>
</td>
<td width="20%" valign="middle" align="right" class="td_producto" style="background-color: #99CC33;">
<a href="<?php echo $url_server; ?>/ver/productos_listado?cat=materiales-de-instalacion&t_bg_c=#title">
<img src="<?php echo $url_server_img; ?>/img/productos/materiales_de_instalacion_2.png?<?php echo $img_param; ?>" class="img-responsive img_producto">
</a>
</td>
<td width="20%" valign="middle" align="right" class="td_producto" style="background-color: #F70F0F;">
<a href="<?php echo $url_server; ?>/ver/productos_listado?cat=calentadores&t_bg_c=s#title">
<img src="<?php echo $url_server_img; ?>/img/productos/calentadores_2.png?<?php echo $img_param; ?>" class="img-responsive img_producto">
</a>
</td>
<td width="20%" valign="middle" align="right" class="td_producto" style="background-color: #FFCC00;">
<a href="<?php echo $url_server; ?>/ver/productos_listado?cat=linea-blanca&t_bg_c=#title">
<img src="<?php echo $url_server_img; ?>/img/productos/linea_blanca_2.png?<?php echo $img_param; ?>" class="img-responsive img_producto">
</a>
</td>
<td width="20%" valign="middle" align="right" class="td_producto" style="background-color: #1C4A78;">
<a href="<?php echo $url_server; ?>/ver/productos_listado?cat=mallas-decorativas&t_bg_c=#title">
<img src="<?php echo $url_server_img; ?>/img/productos/mallas_decorativas_2.png?<?php echo $img_param; ?>" class="img-responsive img_producto">
</a>
</td>
</tr>
</table>

</div>
</div>

<br>
<br>

<?php
if($GetCat != "") {
$query_Productos_Categorias = "SELECT * FROM `Productos_Categorias` WHERE `Slug` = '".$GetCat."' AND `Estatus` = 'Activo' ORDER BY `Orden` DESC;";
} else {
$query_Productos_Categorias = "SELECT * FROM `Productos_Categorias` WHERE `Estatus` = 'Activo' ORDER BY `Orden` DESC;";
}
$result_Productos_Categorias = $mysqli->query($query_Productos_Categorias);
$num_Productos_Categorias = $result_Productos_Categorias->num_rows;
if ($num_Productos_Categorias >= 1) {
//echo $query_Productos_Categorias;
$row_Productos_Categorias = $result_Productos_Categorias->fetch_array(MYSQLI_ASSOC);
$Imagen_Cat = $row_Productos_Categorias['Imagen'];

if(!$GetOrden){ $GetOrden_p = "Producto"; }

if(is_array($GetCatQ)){
//echo json_encode($GetCatQ)."<hr>";
$GetCatQ_p = ""; $Filtrando_print = "";
foreach($GetCatQ as $Slug_Rel_Base_q => $Slug_SubCat_q){
if($Slug_SubCat_q != "" && $Slug_SubCat_q != "Todos") {
$Filtrando_print .= "<span style='background-color:#CCCCCC;padding: 3px;'>".$Slug_Rel_Base_q.": <b>".$Slug_SubCat_q."</b></span> ";
$GetCatQ_p .= " AND (`Slug_Rel_Base` = '$Slug_Rel_Base_q' AND `Slug_SubCat` = '$Slug_SubCat_q') ";
} }
$query_Productos_Rel_Categorias = "SELECT DISTINCT `Id_Producto` FROM `Productos_Rel_Categorias` WHERE `Slug_Base` = '".$GetCat."' ".$GetCatQ_p." AND `Estatus` = 'Activo' ORDER BY `id` DESC;";
//echo $query_Productos_Rel_Categorias."<br>";
$result_Productos_Rel_Categorias = $mysqli->query($query_Productos_Rel_Categorias);
$num_Productos_Rel_Categorias = $result_Productos_Rel_Categorias->num_rows;
if ($num_Productos_Rel_Categorias >= 1) {
$Make_Query_Prods_Rel = "";
while($row_Productos_Rel_Categorias = $result_Productos_Rel_Categorias->fetch_array(MYSQLI_ASSOC)) {
$Id_Producto_Prods_Rel = $row_Productos_Rel_Categorias['Id_Producto'];
$Make_Query_Prods_Rel .= " `id` = '$Id_Producto_Prods_Rel' OR ";
} }
$GetQ_p_Prods_Rel =  " (".$Make_Query_Prods_Rel." `id` = '') AND ";
if($Make_Query_Prods_Rel == ""){
$GetQ_p_Prods_Rel = "";
}
}

if($GetQ){
$GetQ_p = " `Producto` LIKE  '%".$GetQ."%' OR `Descripcion` LIKE  '%".$GetQ."%' OR `SubCatsJson` LIKE '%".$GetQ."%' ";
$GetQ_print = "Su busqueda: <em><b>".$GetQ."</b></em>";
} else {
$GetQ_p = " `Cat_Slug` = '".$GetCat."' ";
}
$query_Productos = "SELECT * FROM `Productos` WHERE ".$GetQ_p_Prods_Rel." ".$GetQ_p." AND `Cat_Slug` = '".$GetCat."' AND `Estatus` = 'Activo' ORDER BY `".$GetOrden_p."` DESC;";
//echo "<br>".$query_Productos."<br>";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
?>

<?php
$img_header_default = "/img/productos_listado/muebles-de-bano-y-cocina.jpg";
$img_path = "/img/productos_listado/";
if(file_exists(__DIR__."/..".$img_path."".$Imagen_Cat) && $Imagen_Cat != ""){
$img_header = $img_path."".$Imagen_Cat;
$caso_img = "1";
} else if(file_exists(__DIR__."/..".$img_path."".$GetCat.".jpg")){
$img_header = $img_path.".jpg";
$caso_img = "2";
} else if(file_exists(__DIR__."/..".$img_path."".$GetCat.".png")){
$img_header = $img_path.".png";
$caso_img = "3";
} else {
//$img_header = $img_header_default;
$caso_img = "4";
}
$img_param = "quality=100&w=1140";
if($img_header__){
?>
<div class="container" align="center">
<div align="center" style="background-color:#FFCC00;padding-left:25px;padding-right:25px;">
<img src="<?php echo $url_server_img."".$img_header; ?>?<?php echo $img_param; ?>" class="img-responsive">
</div>
</div>
<br>

<?php } else {
//echo $img_header."<br>";
//echo __DIR__."/..".$img_path."".$Imagen_Cat;
?>
<div class="container" align="center" id="title">
<div align="center" style="background-color:#FFCC00;color:#ffffff;padding:15px;">
<h1><?php echo $row_Productos_Categorias['Categoria']; ?></h1>
</div>
</div>
<br>
<?php } ?>

<?php
$select_form = "";
$query_Productos_CategoriasSubRel = "SELECT * FROM `Productos_CategoriasSubRel` WHERE `Slug_Base` = '".$GetCat."' AND `Estatus` = '1' ORDER BY `Categoria` DESC;";
$result_Productos_CategoriasSubRel = $mysqli->query($query_Productos_CategoriasSubRel);
$num_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->num_rows;
if ($num_Productos_CategoriasSubRel >= 1) { ?>
<?php while ($row_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->fetch_array(MYSQLI_ASSOC)) { ?>
<?php
$query_Productos_CategoriasSub = "SELECT * FROM `Productos_CategoriasSub` WHERE `Slug_Base` = '$GetCat' AND `Slug_Rel_Base` = '".$row_Productos_CategoriasSubRel['Slug']."' AND `Estatus` = '1' ORDER BY `Categoria` DESC;";
$result_Productos_CategoriasSub = $mysqli->query($query_Productos_CategoriasSub);
$num_Productos_CategoriasSub = $result_Productos_CategoriasSub->num_rows;
if ($num_Productos_CategoriasSub >= 1) {
$radio_options = "";
$radio_options__ .= <<<EOF
<div class="radio">
<label>
<input type="radio" name="cat_q[{$row_Productos_CategoriasSubRel['Slug']}]" value="" checked>
 Todos
</label>
</div>
EOF;
$radio_options .= <<<EOF
<option value="">Todos</option>
EOF;
while($row_Productos_CategoriasSub = $result_Productos_CategoriasSub->fetch_array(MYSQLI_ASSOC)){
$CountNum_ProdsbySubCat = CountNum_ProdsbySubCat($GetCat, $row_Productos_CategoriasSubRel['Slug'], $row_Productos_CategoriasSub['Slug']);
$radio_options__ .= <<<EOF
<div class="radio">
<label>
<input type="radio" name="cat_q[{$row_Productos_CategoriasSubRel['Slug']}]" value="{$row_Productos_CategoriasSub['Slug']}">
{$row_Productos_CategoriasSub['Categoria']} ({$CountNum_ProdsbySubCat})
</label>
</div>
EOF;
$radio_options .= <<<EOF
<option value="{$row_Productos_CategoriasSub['Slug']}">{$row_Productos_CategoriasSub['Categoria']} ({$CountNum_ProdsbySubCat})</option>
EOF;
if($row_Productos_CategoriasSubRel['Slug'] == "marca") {
$link_options .= <<<EOF
 <a href="{$url_server}/ver/productos_listado?cat={$GetCat}&cat_q[marca]={$row_Productos_CategoriasSub['Slug']}#title" class="btn btn-warning btn-sm">{$row_Productos_CategoriasSub['Categoria']} ({$CountNum_ProdsbySubCat})</a>
EOF;
}
?>
<?php }
$select_form .= <<<EOF
<div class="form-group">
<label for="ordenar_por_{$row_Productos_CategoriasSubRel['Slug']}">{$row_Productos_CategoriasSubRel['Categoria']} ({$num_Productos_CategoriasSub})</label>
<select class="form-control" name="cat_q[{$row_Productos_CategoriasSubRel['Slug']}]">
{$radio_options}
</select>
</div>
EOF;
?>
<?php } ?>
<?php } ?>
<?php } ?>

<div class="container">
<!--
<div align="center">
<a href="<?php echo $url_server; ?>/ver/productos" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
</div>
<br>
-->
<div class="status_pedido_ajax"></div>

<div align="center"><?php echo $link_options; ?></div>
<br>

<div class="row">
<div class="col-sm-2">
<form action="<?php echo $url_server; ?>/ver/productos_listado?cat=<?php echo $GetCat; ?>" method="post">
<input type="hidden" name="cat" value="<?php echo $GetCat; ?>">
<div class="form-group">
<label for="buscar">Buscar</label>
<input type="search" class="form-control" name="q" id="buscar" placeholder="<?php echo $GetQ; ?>" value="">
</div>

<?php echo $select_form; ?>

<button type="submit" class="btn btn-warning btn-lg btn-block">Buscar</button>
</form>
</div>
<div class="col-sm-10">

<div style="color:#666666;background-color:#BDBDBD; padding: 0px 5px 0px 5px;">
<div class="row">
<div class="col-sm-8" align="left">
<?php echo $GetQ_print; ?>
</div>
<div class="col-sm-4" align="right">
mostrando <b><?php echo $num_Productos; ?></b> productos
</div>
</div>
</div>

<?php
//$separado_por_comas = implode(",", $GetCatQ);
// if($Filtrando_print != ""){
// echo "".$Filtrando_print;
// }

?>
<br>

<?php
if ($num_Productos >= 1) { ?>
<?php
$max_cols = "3"; $min_col = 0;
while ($row_Productos = $result_Productos->fetch_array(MYSQLI_ASSOC)) {
if($min_col == 0) { echo '<div class="row">'; }
?>
<div class="col-sm-4">
<?php
//echo $row_Productos['id']." ";
echo Resumen_Producto($row_Productos['id'], "");
?>
</div>
<?php
$min_col++;
if($min_col == 3) { echo '</div><br>'; $min_col = 0; }
}
if($min_col != 0) { echo '</div><br>'; }
?>
<?php } else { ?>
<a href="<?php echo $url_server; ?>/ver/productos">
<h2 style="text-align: center;" class="text-danger">No se encontraron resultados en su b&uacute;squeda,<br>
intente con otra opci&oacute;n.</h2>
</a>
<?php } ?>

</div>
</div>

</div>

<br>


<?php } else { ?>

<h2 style="text-align: center;" class="text-danger">Lo sentimos, pero la categor&iacute;a que busca no se encuentra disponible o estamos actualiz&aacute;ndola.</h2>

<?php } ?>
