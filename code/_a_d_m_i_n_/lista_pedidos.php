<?php
$query_Sesion_Carrito = "SELECT * FROM `Sesion_Carrito` WHERE `session_id` != '' ORDER BY `id` DESC";
$result_Sesion_Carrito = $mysqli->query($query_Sesion_Carrito);
$num_Sesion_Carrito = $result_Sesion_Carrito->num_rows;
if ($num_Sesion_Carrito >= 1) {
?>
<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Carritos Registrados: <?php echo $num_Sesion_Carrito; ?></h3>
</div>
<div class="panel-body">
<?php
while($row_Sesion_Carrito = $result_Sesion_Carrito->fetch_array(MYSQLI_ASSOC)) {
$Info_Carrito_Prods = Info_Carrito_Prods($row_Sesion_Carrito);
$Total_Carro_Info = $Info_Carrito_Prods['total'];
$sum_subtotal = "0";
$Info_Carrito_Prods = Info_Carrito_Prods($row_Sesion_Carrito);
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
<img src="{$url_server_img}/image/No_Foto.jpg?quality=50&resize=75,90"/>
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
?>
<div>
<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#pedido_<?php echo $row_Sesion_Carrito['id_pedido']; ?>" aria-expanded="false" aria-controls="pedido_<?php echo $row_Sesion_Carrito['id_pedido']; ?>">
Ver Productos en el Carrito: <?php echo $Total_Carro_Info.", estatus: ".$row_Sesion_Carrito['Estatus'].", pedido: ".$row_Sesion_Carrito['id_pedido'].""; ?>
</button>
</div>

<div class="collapse" id="pedido_<?php echo $row_Sesion_Carrito['id_pedido']; ?>">
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
<?php
echo $anadido_print;
?>
</tbody>
</table>
</div>
</div>

<?php } ?>

</div>
</div>
<?php } else { ?>

<?php } ?>

