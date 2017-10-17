<?php

function InStock($Id_Producto){
$mysqli = $GLOBALS['mysqli'];
$url_server_img = $GLOBALS['url_server_img'];
$url_server = $GLOBALS['url_server'];
$signo = $GLOBALS['signo'];
$En_Stock = "0";
$query_Productos_Stock = " SELECT * FROM `Productos_Stock` WHERE `Id_Producto` = '$Id_Producto' ORDER BY `id` DESC;";
$result_Productos_Stock = $mysqli->query($query_Productos_Stock);
$num_Productos_Stock = $result_Productos_Stock->num_rows;
if ($num_Productos_Stock >= 1) {
$row_Productos_Stock = $result_Productos_Stock->fetch_array(MYSQLI_ASSOC);
$En_Stock = $row_Productos_Stock['En_Stock'];
} else { }
return $En_Stock;
}

function GetPedidos_Admin($Estatus){
$mysqli = $GLOBALS['mysqli'];
$url_server_img = $GLOBALS['url_server_img'];
$url_server = $GLOBALS['url_server'];
$signo = $GLOBALS['signo'];
$anadido_print = "";
$template_print = "";

if($Estatus != ""){
$Estatus_Query = "`Estatus` = '".$Estatus."' AND ";
}

$query_Sesion_Carrito = "SELECT * FROM `Sesion_Carrito` WHERE ".$Estatus_Query." `session_id` != '' ORDER BY `id` DESC";
$result_Sesion_Carrito = $mysqli->query($query_Sesion_Carrito);
$num_Sesion_Carrito = $result_Sesion_Carrito->num_rows;
if ($num_Sesion_Carrito >= 1) {

while($row_Sesion_Carrito = $result_Sesion_Carrito->fetch_array(MYSQLI_ASSOC)) {
//$Info_Carrito_Prods = Info_Carrito_Prods($row_Sesion_Carrito);
//$Total_Carro_Info = $Info_Carrito_Prods['total'];
$sum_subtotal = "0";
$Info_Carrito_Prods = Info_Carrito_Prods($row_Sesion_Carrito, "");
$total_num_prods = $Info_Carrito_Prods['total_num_prods'];
$Total_Carro_Info = $Info_Carrito_Prods['total'];
//$anadido_print_json = json_encode($Info_Carrito_Prods);
foreach ($Info_Carrito_Prods['prods'] as $key_anadido => $anadido) {
$info_prod_tr_ajax = info_prod_tr_ajax($anadido['product_id']);
$info_prod_tr_ajax_img = info_prod_tr_ajax_img($anadido['product_id']);
if ($info_prod_tr_ajax_img) {
$info_prod_tr_ajax_img_print = <<<EOF
<img src="{$url_server_img}/img_adjunta/{$info_prod_tr_ajax_img['Tipo']}/{$anadido['product_id']}/{$info_prod_tr_ajax_img['Nombre_Img']}?quality=50&resize=75,90" class="img-thumbnail" />
EOF;
} else {
$info_prod_tr_ajax_img_print = <<<EOF
<img src="{$url_server_img}/images/No_Foto.jpg?quality=50&resize=75,90"/>
EOF;
}
$Total_Num_Prods = intval($anadido['quantity'] * $info_prod_tr_ajax['Precio']);
$Total_Num_Prods_print = number_format($Total_Num_Prods, 2, '.', '');
$sum_subtotal = ($sum_subtotal + $Total_Num_Prods);
$sum_subtotal_print = number_format($sum_subtotal, 2, '.', '');

$Mensaje_HTML = "" . htmlspecialchars_decode($info_prod_tr_ajax['Descripcion']);
$Desc_Clean = strip_tags($Mensaje_HTML, '');

$anadido_print .= <<<EOF
<tr>
<td class="text-center">
<a href="{$url_server}/prod/{$anadido['product_id']}">{$info_prod_tr_ajax_img_print}</a>
</td>
<td class="text-left"><a href="{$url_server}/prod/{$anadido['product_id']}">{$info_prod_tr_ajax['Producto']}</a>
<br />
<small>{$Desc_Clean}</small>
</td>
<td class="text-left">{$anadido['quantity']}</td>
<td class="text-right">{$signo}{$info_prod_tr_ajax['Precio']}</td>
<td class="text-right">{$signo}{$Total_Num_Prods_print}</td>
</tr>
EOF;
}

$template_print .= <<<EOF
<!-- Inicio Estatus: {$Estatus} -->
<div>
<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#pedido_{$row_Sesion_Carrito['id_pedido']}_{$Estatus}" aria-expanded="false" aria-controls="pedido_{$row_Sesion_Carrito['id_pedido']}">
Estatus: {$row_Sesion_Carrito['Estatus']}, Pedido: {$row_Sesion_Carrito['id_pedido']}
</button>
</div>
<div class="collapse" id="pedido_{$row_Sesion_Carrito['id_pedido']}_{$Estatus}">
<a href="/ver_pedido/{$row_Sesion_Carrito['id_pedido']}" target="_blank">Ver Productos en el Carrito: {$Total_Carro_Info}, estatus: {$row_Sesion_Carrito['Estatus']}, pedido: {$row_Sesion_Carrito['id_pedido']}</a>
<br>
<div class="table-responsive">
<table class="table table-bordered">
<thead>
<tr>
<td class="text-center">Foto</td>
<td class="text-left">Nombre del Producto</td>
<td class="text-left">Cantidad</td>
<td class="text-right" style="min-width: 110px;">Precio unitario</td>
<td class="text-right" style="min-width: 80px;">Total</td>
</tr>
</thead>
<tbody>
{$anadido_print}
</tbody>
</table>
</div>
</div>

<!-- Fin Estatus: {$Estatus} -->

EOF;
}


} else {
$template_print = <<<EOF
Vacio
EOF;
}

return $template_print;
}

function GetEstatus_Options_Array($Tipo, $Tipo_Sub){
$mysqli = $GLOBALS['mysqli'];
$query_config_Estatus = "
SELECT * FROM `config_Estatus` WHERE `Tipo` = '$Tipo' AND `Tipo_Sub` = '$Tipo_Sub' ORDER BY `id` DESC;";
$result_config_Estatus = $mysqli->query($query_config_Estatus);
$num_config_Estatus = $result_config_Estatus->num_rows;
$array_ops = array();
if ($num_config_Estatus >= 1) {
while($row_config_Estatus = $result_config_Estatus->fetch_array(MYSQLI_ASSOC)){
$Estatus = $row_config_Estatus['Estatus'];
$array_ops[] = array("value"=>$Estatus, "visible"=>$Estatus);
}
} else {

}
return $array_ops;
}

?>