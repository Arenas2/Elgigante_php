<?php

$signo = '$';
function Resumen_Producto_old($Id_Producto, $mostrar_precios){
$url_server = $GLOBALS['url_server'];
$url_server_img = $GLOBALS['url_server_img'];
$mysqli = $GLOBALS['mysqli'];

$query_Productos = "SELECT * FROM `Productos` WHERE `id` = '".$Id_Producto."' ORDER BY `id` DESC LIMIT 1;";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;

if ($num_Productos >= 1) {
$row_Productos = $result_Productos->fetch_array(MYSQLI_ASSOC);
$id_prod = $row_Productos['id'];
$Cat_Slug = $row_Productos['Cat_Slug'];
//$Slug = $row_Productos['Slug'];
$Producto_print = $row_Productos['Producto'];
$Descripcion = $row_Productos['Descripcion'];
$Precio = $row_Productos['Precio'];

if ($Precio) {
$Precio_print = "$" . $Precio . "";
} else {
$Precio_print = "" . $Precio . "";
}

$Mensaje_HTML = htmlspecialchars_decode($Descripcion);
$Mensaje_HTML_clean = strip_tags($Mensaje_HTML, '');
$Mensaje_HTML_clean2 = substr($Mensaje_HTML_clean, 0, 200) . "...";

if (strlen($Mensaje_HTML_clean) > 300) {
$Mensaje_Corto = substr($Mensaje_HTML_clean, 0, 300) . "...";
} else {
$Mensaje_Corto = $Mensaje_HTML;
}

$query_Imagenes_Adjuntas = "SELECT * FROM `Imagenes_Adjuntas` WHERE `Id_Tipo` = '$id_prod' ORDER BY `id` ASC;";
$result_Imagenes_Adjuntas = $mysqli->query($query_Imagenes_Adjuntas);
$num_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->num_rows;
if ($num_Imagenes_Adjuntas >= 1) {
$row_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->fetch_array(MYSQLI_ASSOC);
$Imagenes_Adjuntas_Print = <<<EOF
<img itemprop="image" src="{$url_server_img}/img_adjunta/{$row_Imagenes_Adjuntas['Tipo']}/{$id_prod}/{$row_Imagenes_Adjuntas['Nombre_Img']}?quality=80&resize=550,650" class="img-responsive"/>
EOF;
$Imagenes_Adjuntas_Zoom_Print = <<<EOF
{$url_server_img}/img_adjunta/{$row_Imagenes_Adjuntas['Tipo']}/{$id_prod}/{$row_Imagenes_Adjuntas['Nombre_Img']}
EOF;
} else {
$Imagenes_Adjuntas_Print = <<<EOF
<img src="{$url_server}/image/No_Foto.jpg" class="img-responsive"/>
EOF;
$Imagenes_Adjuntas_Zoom_Print = $url_server."/image/No_Foto.jpg";
}

if($mostrar_precios){
$mostrar_precios_print = <<<EOF
<div class="price" itemtype="http://schema.org/Offer" itemscope itemprop="offers">
<span class="special-price">{$Precio_print}</span>

</div>
EOF;
$mostrar_nombre_print = <<<EOF
<h3 class="name"><a href="{$url_server}/prod/{$id_prod}">{$Producto_print}</a></h3>
EOF;
$mostrar_agregar_print = <<<EOF
<input type="button" value="Agregar" onclick="cart.addcart('{$Id_Producto}');" class="button"/>
EOF;
}

$Resumen_Producto = <<<EOF
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
<div class="product-block item-default" itemtype="http://schema.org/Product" itemscope>
<div class="image">

<!-- text sale-->
<a class="img" href="{$url_server}/prod/{$id_prod}">
{$Imagenes_Adjuntas_Print}
</a>
<meta content="{$Producto_print}" itemprop="name">
<!-- zoom image-->
<a href="{$Imagenes_Adjuntas_Zoom_Print}" class="info-view product-zoom" title="{$Producto_print}">
<i class="fa fa-search-plus"></i></a>

<!-- quickview
<a class="pav-colorbox iframe-link cboxElement" href="{$url_server}/info_prod.iframe.php?id_prod={$id_prod}"
   title="Quick View">
<span>Mas Info</span>
</a>
-->
</div>

<div class="product-meta">
{$mostrar_nombre_print}
<div class="description" itemprop="description">
{$Mensaje_Corto}
</div>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<meta content="{$Precio}" itemprop="price">
<meta content="MXN" itemprop="priceCurrency">
</div>
{$mostrar_precios_print}
<!--
<div class="rating">
<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
</div>
-->
<div class="cart">
{$mostrar_agregar_print}
</div>
</div>
</div>
</div>
EOF;

}
return $Resumen_Producto;
}

function info_prod_tr_ajax($Id_Producto){
$url_server = $GLOBALS['url_server'];
$url_server_img = $GLOBALS['url_server_img'];
$mysqli = $GLOBALS['mysqli'];
$query_Productos = "SELECT * FROM `Productos` WHERE `id` = '".$Id_Producto."' ORDER BY `id` DESC LIMIT 1;";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) {
$row_Productos = $result_Productos->fetch_array(MYSQLI_ASSOC);
$info_prod_tr_ajax = <<<EOF
<tr>
<td class="text-center"> <a href="{$url_server}/prod/{$anadido['product_id']}"><img src="{$url_server}/image/No_Foto.jpg"/></a></td>
<td class="text-left"><a href="{$url_server}/prod/{$anadido['product_id']}">{$anadido['product_id']}</a></td>
<td class="text-right">x N</td>
<td class="text-right">$0</td>
<td class="text-center"><button type="button" onclick="cart.remove('{$anadido['product_id']}');" title="Remover" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
</tr>
EOF;
}
return $row_Productos;
}

function info_prod_tr_ajax_img($Id_Producto){
$url_server = $GLOBALS['url_server'];
$url_server_img = $GLOBALS['url_server_img'];
$mysqli = $GLOBALS['mysqli'];
$query_Imagenes_Adjuntas = "SELECT * FROM `Imagenes_Adjuntas` WHERE `Id_Tipo` = '$Id_Producto' ORDER BY `id` ASC LIMIT 1;";
$result_Imagenes_Adjuntas = $mysqli->query($query_Imagenes_Adjuntas);
$num_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->num_rows;
if ($num_Imagenes_Adjuntas >= 1) {
$row_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->fetch_array(MYSQLI_ASSOC);
}
return $row_Imagenes_Adjuntas;
}

function info_prod_array($Id_Producto){
$url_server = $GLOBALS['url_server'];
$url_server_img = $GLOBALS['url_server_img'];
$mysqli = $GLOBALS['mysqli'];
$query_Productos = "SELECT * FROM `Productos` WHERE `id` = '".$Id_Producto."' ORDER BY `id` DESC LIMIT 1;";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) {
$row_Productos = $result_Productos->fetch_array(MYSQLI_ASSOC);
}
return $row_Productos;
}

function Info_Carrito_Prods($row_Sesion_Carrito, $Estatus){
$mysqli = $GLOBALS['mysqli']; $Total_Carro_Info = ""; $Total_Precios_Prods = "0"; $Total_Num_Prods = "0";
if($Estatus == ""){
// AND `Estatus` = 'Pendiente'
$query_Sesion_Carrito_Prods = "SELECT * FROM `Sesion_Carrito_Prods` WHERE `id_pedido` = '" . $row_Sesion_Carrito['id_pedido'] . "' ORDER BY `id` DESC;";
} else {
$query_Sesion_Carrito_Prods = "SELECT * FROM `Sesion_Carrito_Prods` WHERE `id_pedido` = '" . $row_Sesion_Carrito['id_pedido'] . "' AND `Estatus` = '".$Estatus."' ORDER BY `id` DESC;";
}
$result_Sesion_Carrito_Prods = $mysqli->query($query_Sesion_Carrito_Prods);
$num_Sesion_Carrito_Prods = $result_Sesion_Carrito_Prods->num_rows;
if ($num_Sesion_Carrito_Prods >= 1) {
$row_Sesion_Carrito_Prods_array = array();
while ($row_Sesion_Carrito_Prods = $result_Sesion_Carrito_Prods->fetch_array(MYSQLI_ASSOC)) {
$row_Sesion_Carrito_Prods_array[] = $row_Sesion_Carrito_Prods;
$info_prod_array = info_prod_array($row_Sesion_Carrito_Prods['product_id']);
$Precio_Prod = $info_prod_array['Precio'];
$Total_Num_Prods = intval($Total_Num_Prods + $row_Sesion_Carrito_Prods['quantity']);
$Total_Precios_Prods = intval($Total_Precios_Prods + ($row_Sesion_Carrito_Prods['quantity'] * $Precio_Prod));
}

if($row_Sesion_Carrito['requiere_fac']=="1"){
$sum_subtotal_iva = number_format(($Total_Precios_Prods*0.16), 2, '.', '');
$sum_total = number_format(($Total_Precios_Prods+$sum_subtotal_iva), 2, '.', '');
$Total_Precios_Prods = $sum_total;
}
$Total_Carro_Info_Int = number_format($Total_Precios_Prods, 2, '.', '');
$Total_Carro_Info = $Total_Num_Prods . " Productos - $" .$Total_Carro_Info_Int;
} else {
$Total_Carro_Info = $Total_Num_Prods . " Productos";
}
return array("total"=>$Total_Carro_Info,"total_int"=>$Total_Carro_Info_Int,"prods"=>$row_Sesion_Carrito_Prods_array, "total_num_prods"=>$Total_Num_Prods);
}

function GetSubCatProds_Array($Id_Producto, $Slug_Base, $Slug_Rel_Base, $Slug_SubCat){
$mysqli = $GLOBALS['mysqli']; $row_Slug_SubCat = "";
if($Slug_SubCat == ""){
$query_Productos_Rel_Categorias = "SELECT * FROM `Productos_Rel_Categorias` WHERE `Id_Producto` = '$Id_Producto' AND `Slug_Base` = '$Slug_Base' AND `Slug_Rel_Base` = '$Slug_Rel_Base' AND `Estatus` = 'Activo' ORDER BY `id` DESC LIMIT 1;";
} else {
$query_Productos_Rel_Categorias = "SELECT * FROM `Productos_Rel_Categorias` WHERE `Id_Producto` = '$Id_Producto' AND `Slug_Base` = '$Slug_Base' AND `Slug_Rel_Base` = '$Slug_Rel_Base' AND `Slug_SubCat` = '$Slug_SubCat' AND `Estatus` = 'Activo' ORDER BY `id` DESC LIMIT 1;";
}
$result_Productos_Rel_Categorias = $mysqli->query($query_Productos_Rel_Categorias);
$num_Productos_Rel_Categorias = $result_Productos_Rel_Categorias->num_rows;
if ($num_Productos_Rel_Categorias >= 1) {
while($row_Productos_Rel_Categorias = $result_Productos_Rel_Categorias->fetch_array(MYSQLI_ASSOC)){
$row_Slug_SubCat = $row_Productos_Rel_Categorias['Slug_SubCat'];
}
}
return $row_Slug_SubCat;
}

function GetOptionsArray($Slug_Base, $Tipo, $Id_Tipo){
$mysqli = $GLOBALS['mysqli'];
$query_Productos_CategoriasSubRel = "SELECT * FROM `Productos_CategoriasSubRel` WHERE `Slug_Base` = '$Slug_Base' AND `Estatus` ='1' ORDER BY `id` ASC;";
$result_Productos_CategoriasSubRel = $mysqli->query($query_Productos_CategoriasSubRel);
$num_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->num_rows;
if ($num_Productos_CategoriasSubRel >= 1) {
$options_array = array(); $form = "";
while ($row_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->fetch_array(MYSQLI_ASSOC)) {
$query_Productos_CategoriasSub = "SELECT * FROM `Productos_CategoriasSub` WHERE `Slug_Base` = '$Slug_Base' AND `Slug_Rel_Base` = '".$row_Productos_CategoriasSubRel['Slug']."' AND `Estatus` = '1' ORDER BY `Categoria` ASC;";
$result_Productos_CategoriasSub = $mysqli->query($query_Productos_CategoriasSub);
$num_Productos_CategoriasSub = $result_Productos_CategoriasSub->num_rows;
if ($num_Productos_CategoriasSub >= 1) {
$options_cat_print = "";
while($row_Productos_CategoriasSub = $result_Productos_CategoriasSub->fetch_array(MYSQLI_ASSOC)) {
//$options_array['Slug'] = $result_Productos_CategoriasSub['Slug'];
//$options_array['Categoria'] = $result_Productos_CategoriasSub['Categoria'];
$GetSubCatProds_Array = GetSubCatProds_Array($Id_Tipo, $Slug_Base, $row_Productos_CategoriasSubRel['Slug'], $row_Productos_CategoriasSub['Slug']);
if($GetSubCatProds_Array == $row_Productos_CategoriasSub['Slug']){
$options_cat_print .= <<<EOF
<option value="{$row_Productos_CategoriasSub['Slug']}" selected>{$row_Productos_CategoriasSub['Categoria']}</option>
EOF;
} else {
$options_cat_print .= <<<EOF
<option value="{$row_Productos_CategoriasSub['Slug']}">{$row_Productos_CategoriasSub['Categoria']}</option>
EOF;
}
}
$form .= <<<EOF
<div id="{$row_Productos_CategoriasSubRel['Slug']}" class="col-sm-3" title="{$row_Productos_CategoriasSubRel['Categoria']}">
<label for="{$row_Productos_CategoriasSubRel['Slug']}">{$row_Productos_CategoriasSubRel['Categoria']}</label>
<select class="form-control {$row_Productos_CategoriasSubRel['Slug']}" name="subcat[{$row_Productos_CategoriasSubRel['Slug']}][]" multiple>
{$options_cat_print}
</select>
</div>
<script>
$(".{$row_Productos_CategoriasSubRel['Slug']}").select2({

});
</script>
EOF;
} else {
$GetSubCatProds_Array = GetSubCatProds_Array($Id_Tipo, $Slug_Base, $row_Productos_CategoriasSubRel['Slug'], "");
$form .= <<<EOF
<div id="{$row_Productos_CategoriasSubRel['Slug']}" class="col-sm-3" title="{$row_Productos_CategoriasSubRel['Categoria']}">
<label for="{$row_Productos_CategoriasSubRel['Slug']}">{$row_Productos_CategoriasSubRel['Categoria']}</label>
<input type="text" class="form-control {$row_Productos_CategoriasSubRel['Slug']}" name="subcat[{$row_Productos_CategoriasSubRel['Slug']}]" value="{$GetSubCatProds_Array}">
</div>
EOF;
}
}
}
return $form;
}

function GetOptionsArray_Simple($Slug_Base, $Tipo, $Id_Tipo){
$mysqli = $GLOBALS['mysqli'];
$query_Productos_CategoriasSubRel = "SELECT * FROM `Productos_CategoriasSubRel` WHERE `Slug_Base` = '$Slug_Base' AND `Estatus` ='1' ORDER BY `id` ASC;";
$result_Productos_CategoriasSubRel = $mysqli->query($query_Productos_CategoriasSubRel);
$num_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->num_rows;
if ($num_Productos_CategoriasSubRel >= 1) {
$options_array = array(); $form = "";
while ($row_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->fetch_array(MYSQLI_ASSOC)) {
$query_Productos_CategoriasSub = "SELECT * FROM `Productos_CategoriasSub` WHERE `Slug_Base` = '$Slug_Base' AND `Slug_Rel_Base` = '".$row_Productos_CategoriasSubRel['Slug']."' AND `Estatus` = '1' ORDER BY `Categoria` ASC;";
$result_Productos_CategoriasSub = $mysqli->query($query_Productos_CategoriasSub);
$num_Productos_CategoriasSub = $result_Productos_CategoriasSub->num_rows;
if ($num_Productos_CategoriasSub >= 1) {
$options_cat_print = "";
while($row_Productos_CategoriasSub = $result_Productos_CategoriasSub->fetch_array(MYSQLI_ASSOC)) {
//$options_array['Slug'] = $result_Productos_CategoriasSub['Slug'];
//$options_array['Categoria'] = $result_Productos_CategoriasSub['Categoria'];
$GetSubCatProds_Array = GetSubCatProds_Array($Id_Tipo, $Slug_Base, $row_Productos_CategoriasSubRel['Slug'], $row_Productos_CategoriasSub['Slug']);
if($GetSubCatProds_Array == $row_Productos_CategoriasSub['Slug']){
$options_cat_print .= <<<EOF
{$row_Productos_CategoriasSub['Categoria']}
EOF;
$form .= <<<EOF
<div>{$row_Productos_CategoriasSubRel['Categoria']}: {$options_cat_print}</div>
EOF;
}
}

} else {
$GetSubCatProds_Array = GetSubCatProds_Array($Id_Tipo, $Slug_Base, $row_Productos_CategoriasSubRel['Slug'], "");
$form .= <<<EOF
<div>{$row_Productos_CategoriasSubRel['Categoria']}: {$GetSubCatProds_Array}</div>
EOF;
}
}
}
return $form;
}

function GetOptionsArray_NoBreakLine($Slug_Base, $Tipo, $Id_Tipo){
$mysqli = $GLOBALS['mysqli'];
$query_Productos_CategoriasSubRel = "SELECT * FROM `Productos_CategoriasSubRel` WHERE `Slug_Base` = '$Slug_Base' AND `Estatus` ='1' ORDER BY `id` ASC;";
$result_Productos_CategoriasSubRel = $mysqli->query($query_Productos_CategoriasSubRel);
$num_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->num_rows;
if ($num_Productos_CategoriasSubRel >= 1) {
$options_array = array(); $form = "";
while ($row_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->fetch_array(MYSQLI_ASSOC)) {
$query_Productos_CategoriasSub = "SELECT * FROM `Productos_CategoriasSub` WHERE `Slug_Base` = '$Slug_Base' AND `Slug_Rel_Base` = '".$row_Productos_CategoriasSubRel['Slug']."' AND `Estatus` = '1' ORDER BY `Categoria` ASC;";
$result_Productos_CategoriasSub = $mysqli->query($query_Productos_CategoriasSub);
$num_Productos_CategoriasSub = $result_Productos_CategoriasSub->num_rows;
if ($num_Productos_CategoriasSub >= 1) {
$options_cat_print = "";
while($row_Productos_CategoriasSub = $result_Productos_CategoriasSub->fetch_array(MYSQLI_ASSOC)) {
//$options_array['Slug'] = $result_Productos_CategoriasSub['Slug'];
//$options_array['Categoria'] = $result_Productos_CategoriasSub['Categoria'];
$GetSubCatProds_Array = GetSubCatProds_Array($Id_Tipo, $Slug_Base, $row_Productos_CategoriasSubRel['Slug'], $row_Productos_CategoriasSub['Slug']);
if($GetSubCatProds_Array == $row_Productos_CategoriasSub['Slug']){
$options_cat_print .= <<<EOF
{$row_Productos_CategoriasSub['Categoria']}
EOF;
$form .= <<<EOF
 <span class="label label-default">{$row_Productos_CategoriasSubRel['Categoria']}: {$options_cat_print}</span>
EOF;
}
}
} else {
$GetSubCatProds_Array = GetSubCatProds_Array($Id_Tipo, $Slug_Base, $row_Productos_CategoriasSubRel['Slug'], "");
$form .= <<<EOF
 <span class="label label-default">{$row_Productos_CategoriasSubRel['Categoria']}: {$GetSubCatProds_Array}</span>
EOF;
}
}
}
return $form;
}

function CountNum_ProdsbySubCat($Slug_Base, $Slug_Rel_Base, $Slug_SubCat){
$url_server = $GLOBALS['url_server'];
$url_server_img = $GLOBALS['url_server_img'];
$mysqli = $GLOBALS['mysqli'];
$query_Productos_Rel_Categorias = "SELECT DISTINCT `Id_Producto` FROM `Productos_Rel_Categorias` WHERE `Slug_Base` = '".$Slug_Base."' AND `Slug_Rel_Base` = '".$Slug_Rel_Base."' AND `Slug_SubCat` = '".$Slug_SubCat."' AND `Estatus` = 'Activo' ORDER BY `id` DESC;";
$result_Productos_Rel_Categorias = $mysqli->query($query_Productos_Rel_Categorias);
echo $result_Productos_Rel_Categorias;
$num_Productos_Rel_Categorias = $result_Productos_Rel_Categorias->num_rows;
return $num_Productos_Rel_Categorias;
}

function Resumen_Producto($Id_Producto, $mostrar_precios){
$url_server = $GLOBALS['url_server']; $url_server_img = $GLOBALS['url_server_img']; $mysqli = $GLOBALS['mysqli'];
$query_Productos = "SELECT * FROM `Productos` WHERE `id` = '".$Id_Producto."' AND `Estatus` = 'Activo' ORDER BY `id` DESC LIMIT 1;";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if($num_Productos >= 1) {
$row_Productos = $result_Productos->fetch_array(MYSQLI_ASSOC);
$Cat_Slug = $row_Productos['Cat_Slug'];
$Slug = $row_Productos['Slug'];
$Producto = $row_Productos['Producto'];
$Descripcion = $row_Productos['Descripcion'];
$Precio = $row_Productos['Precio'];
$Estatus = $row_Productos['Estatus'];
if($Precio != "" && $mostrar_precios != ""){ $Precio_print = ": <span class='text-success'>$".$Precio."</span>"; } else { $Precio_print = ""; }
$Mensaje_HTML = htmlspecialchars_decode($Descripcion);
$Mensaje_HTML_clean = strip_tags($Mensaje_HTML, '');
$Mensaje_HTML_clean2 = substr($Mensaje_HTML_clean, 0, 250)."...";
if (strlen($Mensaje_HTML_clean) > 300) {
$Mensaje_Corto = substr($Mensaje_HTML_clean, 0, 300)."...";
}	else {
$Mensaje_Corto = $Mensaje_HTML;
}
$query_Imagenes_Adjuntas = "SELECT * FROM `Imagenes_Adjuntas` WHERE `Tipo` = 'producto' AND `Id_Tipo` = '$Id_Producto' ORDER BY `id` DESC;";
$result_Imagenes_Adjuntas = $mysqli->query($query_Imagenes_Adjuntas);
$num_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->num_rows;
$img_param = "quality=100&resize=120,120"; //quality=80&resize=50,50 quality=80&h=120
if ($num_Imagenes_Adjuntas >= 1) {
$row_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->fetch_array(MYSQLI_ASSOC);
$Nombre_Img = utf8_decode($row_Imagenes_Adjuntas['Nombre_Img']);
$Imagenes_Adjuntas_Print = <<<EOF
<img class="img-responsive" src="{$url_server_img}/img_adjunta/{$row_Imagenes_Adjuntas['Tipo']}/{$Id_Producto}/{$Nombre_Img}?{$img_param}" alt="{$Producto}">
EOF;
} else {
$Imagenes_Adjuntas_Print = <<<EOF
<img class="img-responsive" src="{$url_server_img}/images/No_Foto.jpg?{$img_param}" alt="{$Producto}">
EOF;
}
$GetOptionsArray_Simple = GetOptionsArray_NoBreakLine($Cat_Slug, "", $Id_Producto, "span");
//<div align="justify"><b>{$Id_Producto}</b></div> //<!-- {$url_server}/ver/producto?id={$Id_Producto} -->
$producto_html = <<<EOF
<div class="producto" style="margin:5px 0px 5px 0px; padding:8px;">
<a href="javascript:;" data-toggle="modal" class="load_modal ver_prod_info" id_producto="{$Id_Producto}" data-target="#modal" style="text-decoration:none;color:#000000;" title="{$Mensaje_HTML_clean}">
<div style="min-height:300px;padding:0px 5px 5px 5px;">
<div align="center">{$Imagenes_Adjuntas_Print}</div>
<div align="center"><b>{$Producto}</b></div>
<div align="justify">{$Mensaje_HTML_clean2}</div>
</div>
<div align="">{$GetOptionsArray_Simple}</div>
<div align="justify" class="text-danger">VER M&Aacute;S</div>
</a>
<div align="justify"><a href="javascript:;" id_producto="{$Id_Producto}" class="btn btn-danger btn-xs add_prod_cot">A&Ntilde;ADIR A COTIZACI&Oacute;N</a></div>
</div>
EOF;

} else {
$producto_html = "";;
}
return $producto_html;
}


function GetOptionsArray_Entradas($Slug_Base, $Tipo, $Id_Tipo){
$mysqli = $GLOBALS['mysqli'];
$query_Productos_CategoriasSubRel = "SELECT * FROM `Entradas_CategoriasSubRel` WHERE `Tipo` = '$Tipo' AND `Slug_Base` = '$Slug_Base' AND `Estatus` ='1' ORDER BY `id` ASC;";
$result_Productos_CategoriasSubRel = $mysqli->query($query_Productos_CategoriasSubRel);
$num_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->num_rows;
if ($num_Productos_CategoriasSubRel >= 1) {
$options_array = array(); $form = "";
while ($row_Productos_CategoriasSubRel = $result_Productos_CategoriasSubRel->fetch_array(MYSQLI_ASSOC)) {
$query_Productos_CategoriasSub = "SELECT * FROM `Entradas_CategoriasSub` WHERE `Tipo` = '$Tipo' AND `Slug_Base` = '$Slug_Base' AND `Slug_Rel_Base` = '".$row_Productos_CategoriasSubRel['Slug']."' AND `Estatus` = '1' ORDER BY `Categoria` ASC;";
$result_Productos_CategoriasSub = $mysqli->query($query_Productos_CategoriasSub);
$num_Productos_CategoriasSub = $result_Productos_CategoriasSub->num_rows;
if ($num_Productos_CategoriasSub >= 1) {
$options_cat_print = "";
while($row_Productos_CategoriasSub = $result_Productos_CategoriasSub->fetch_array(MYSQLI_ASSOC)) {
//$options_array['Slug'] = $result_Productos_CategoriasSub['Slug'];
//$options_array['Categoria'] = $result_Productos_CategoriasSub['Categoria'];
$GetSubCatProds_Array = GetSubCatEntradas_Array($Tipo, $Id_Tipo, $Slug_Base, $row_Productos_CategoriasSubRel['Slug'], $row_Productos_CategoriasSub['Slug']);
if($GetSubCatProds_Array == $row_Productos_CategoriasSub['Slug']){
$options_cat_print .= <<<EOF
<option value="{$row_Productos_CategoriasSub['Slug']}" selected>{$row_Productos_CategoriasSub['Categoria']}</option>
EOF;
} else {
$options_cat_print .= <<<EOF
<option value="{$row_Productos_CategoriasSub['Slug']}">{$row_Productos_CategoriasSub['Categoria']}</option>
EOF;
}
}
$form .= <<<EOF
<div id="{$row_Productos_CategoriasSubRel['Slug']}" class="col-sm-3" title="{$row_Productos_CategoriasSubRel['Categoria']}">
<label for="{$row_Productos_CategoriasSubRel['Slug']}">{$row_Productos_CategoriasSubRel['Categoria']}</label>
<select class="form-control {$row_Productos_CategoriasSubRel['Slug']}" name="subcat[{$row_Productos_CategoriasSubRel['Slug']}][]" multiple>
{$options_cat_print}
</select>
</div>
<script>
$(".{$row_Productos_CategoriasSubRel['Slug']}").select2({  });
</script>
EOF;
} else {
$GetSubCatProds_Array = GetSubCatEntradas_Array($Tipo, $Id_Tipo, $Slug_Base, $row_Productos_CategoriasSubRel['Slug'], "");
$form .= <<<EOF
<div id="{$row_Productos_CategoriasSubRel['Slug']}" class="col-sm-3" title="{$row_Productos_CategoriasSubRel['Categoria']}">
<label for="{$row_Productos_CategoriasSubRel['Slug']}">{$row_Productos_CategoriasSubRel['Categoria']}</label>
<input type="text" class="form-control {$row_Productos_CategoriasSubRel['Slug']}" name="subcat[{$row_Productos_CategoriasSubRel['Slug']}]" value="{$GetSubCatProds_Array}">
</div>
EOF;
}
}
}
return $form;
}

function GetSubCatEntradas_Array($Tipo, $Id_Producto, $Slug_Base, $Slug_Rel_Base, $Slug_SubCat){
$mysqli = $GLOBALS['mysqli']; $row_Slug_SubCat = "";
if($Slug_SubCat == ""){
$query_Productos_Rel_Categorias = "SELECT * FROM `Entradas_Rel_Categorias` WHERE `Tipo` = '$Tipo' AND `Id_Producto` = '$Id_Producto' AND `Slug_Base` = '$Slug_Base' AND `Slug_Rel_Base` = '$Slug_Rel_Base' AND `Estatus` = 'Activo' ORDER BY `id` DESC LIMIT 1;";
} else {
$query_Productos_Rel_Categorias = "SELECT * FROM `Entradas_Rel_Categorias` WHERE `Tipo` = '$Tipo' AND `Id_Producto` = '$Id_Producto' AND `Slug_Base` = '$Slug_Base' AND `Slug_Rel_Base` = '$Slug_Rel_Base' AND `Slug_SubCat` = '$Slug_SubCat' AND `Estatus` = 'Activo' ORDER BY `id` DESC LIMIT 1;";
}
$result_Productos_Rel_Categorias = $mysqli->query($query_Productos_Rel_Categorias);
$num_Productos_Rel_Categorias = $result_Productos_Rel_Categorias->num_rows;
if ($num_Productos_Rel_Categorias >= 1) {
while($row_Productos_Rel_Categorias = $result_Productos_Rel_Categorias->fetch_array(MYSQLI_ASSOC)){
$row_Slug_SubCat = $row_Productos_Rel_Categorias['Slug_SubCat'];
}
}
return $row_Slug_SubCat;
}

function GetEntradas_Array($Tipo, $Cat_Slug, $Order="DESC"){
$mysqli = $GLOBALS['mysqli'];
$Entradas_array = array();
if($Cat_Slug != "") {
$query_Entradas = "SELECT * FROM `Entradas` WHERE `Tipo` = '".$Tipo."' AND `Cat_Slug` = '".$Cat_Slug."' AND `Estatus` = 'Activo' ORDER BY `id` ".$Order.";";
} else {
$query_Entradas = "SELECT * FROM `Entradas` WHERE `Tipo` = '".$Tipo."' AND `Estatus` = 'Activo' ORDER BY `id` ".$Order.";";
}
$result_Entradas = $mysqli->query($query_Entradas);
$num_Entradas = $result_Entradas->num_rows;
if ($num_Entradas >= 1) {
while ($row_Entradas = $result_Entradas->fetch_array(MYSQLI_ASSOC)) {
$Entradas_array[] = $row_Entradas;
} }
return array("num"=>$num_Entradas, "entradas"=>$Entradas_array);
}

function GetEntradasImagenes_Array($Tipo, $Id_Tipo, $Limit){
$mysqli = $GLOBALS['mysqli'];
$Entradas_array = array();
$Otros_array = array();
if($Limit != "") { $Limit_q = "LIMIT ".$Limit.""; } else { $Limit_q = ""; }
if($Id_Tipo != "") {
$query_Imagenes_Adjuntas = "SELECT * FROM `Imagenes_Adjuntas` WHERE `Tipo` = '$Tipo' AND `Id_Tipo` = '$Id_Tipo' ORDER BY `id` ASC ".$Limit_q.";";
} else {
$query_Imagenes_Adjuntas = "SELECT * FROM `Imagenes_Adjuntas` WHERE `Tipo` = '$Tipo' ORDER BY `id` ASC;";
}
$result_Imagenes_Adjuntas = $mysqli->query($query_Imagenes_Adjuntas);
$num_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->num_rows;
if ($num_Imagenes_Adjuntas >= 1) {
while($row_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->fetch_array(MYSQLI_ASSOC)) {
if($row_Imagenes_Adjuntas['Img_Tipo']=="image/png" || $row_Imagenes_Adjuntas['Img_Tipo']=="image/jpeg"){
$Entradas_array[] = $row_Imagenes_Adjuntas;
} else {
$Otros_array[] = $row_Imagenes_Adjuntas;
}
}
}
return array("num"=>$num_Imagenes_Adjuntas,"imagenes"=>$Entradas_array,"otros"=>$Otros_array);
}

function GetCategorias_Array($Tipo){
$mysqli = $GLOBALS['mysqli'];
$Cats_array = array();
$query_Entradas_Categorias = "SELECT * FROM `Entradas_Categorias` WHERE `Tipo` = '$Tipo' AND `Estatus` = 'Activo' ORDER BY `id` ASC;";
$result_Entradas_Categorias = $mysqli->query($query_Entradas_Categorias);
$num_Entradas_Categorias = $result_Entradas_Categorias->num_rows;
if ($num_Entradas_Categorias >= 1) {
while($row_Entradas_Categorias = $result_Entradas_Categorias->fetch_array(MYSQLI_ASSOC)) {
$Cats_array[] = $row_Entradas_Categorias;
}
}
return array("num"=>$num_Entradas_Categorias, "categorias"=>$Cats_array);
}

function SendMail($Params){
/*
$Params['Nombre'] = $Nombre;
$Params['Email'] = $Email;
$Params['Asunto'] = $Asunto;
$Params['Mensaje'] = $Mensaje;
$SendMail = SendMail($Params);
*/
$Domain = "elgigantedelosazulejos.com.mx";
$Asunto = utf8_encode($Params['Asunto']);
$Mail_Template = utf8_encode($Params['Mensaje']);
$DefaultFrom = "El Gigante <no.responder@".$Domain.">";
//$TEXT = "Hola ".$Params['Nombre'].", tiene una nueva notificaci&oacute;n.";
$TEXT = strip_tags($Mail_Template, '');
$url = "https://api.mailgun.net/v3/".$Domain."/messages";
$api = "api:key-3038afb47955b923ec06692ccfa3e20f";
//if(filter_var($Params['Email'], FILTER_VALIDATE_EMAIL) && $Params['Email'] != "") {
//if($Params['Nombre'] != "") { $Email = $Params['Nombre']." <".$Params['Email'].">"; } else { $Email = $Params['Email']; }
$Email = $Params['Email'];
$params = array(
'to' => $Email,
'bcc' => 'maitret@myhostmx.com',
'subject' => $Asunto,
'html' => $Mail_Template,
'text' => $TEXT,
'from' => $DefaultFrom,
'o:tracking' => 'True'
);
$session = curl_init($url);
curl_setopt ($session, CURLOPT_POST, true);
curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
curl_setopt($session, CURLOPT_USERPWD, $api);
curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
$response = curl_exec($session);
curl_close($session);

$json = json_decode($response);
$response_message = $json->message;
$response_id_bad = $json->id;
if ($json->message=='Queued. Thank you.') { $Estatus_Envio = "1"; }
else { $Estatus_Envio = "0"; }
$phrase  = $response_id_bad;
$bad = array("<", ">");
$good   = array("", "");
$response_id = str_replace($bad, $good, $phrase);
//} else { $Estatus_Envio = "-1"; }
return array("estatus"=>$Estatus_Envio, "response_id"=>$response_id, "response"=>$response);
}

?>
