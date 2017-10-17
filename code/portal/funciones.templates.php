<?php

$signo = '$';
function Resumen_Producto($Id_Producto, $mostrar_precios){
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

?>