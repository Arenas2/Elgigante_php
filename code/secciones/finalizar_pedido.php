<?php
$ver_resumen = $mysqli->real_escape_string($_REQUEST['ver_resumen']);
$GetId_Pedido = $mysqli->real_escape_string($_REQUEST['id_pedido']);
$GetCat = $mysqli->real_escape_string($_REQUEST['cat']);
$GetCatQ = $_REQUEST['cat_q'];
$GetOrden = $mysqli->real_escape_string($_REQUEST['orden']);
$GetQ = $mysqli->real_escape_string($_REQUEST['q']);
?>
<style>
body {
background-color: #E01212;
}
</style>
<?php
$query_Sesion_Carrito = "SELECT * FROM `Sesion_Carrito` WHERE `Id_Pedido` = '$GetId_Pedido' ORDER BY `id` DESC;";
$result_Sesion_Carrito = $mysqli->query($query_Sesion_Carrito);
$num_Sesion_Carrito = $result_Sesion_Carrito->num_rows;
if ($num_Sesion_Carrito >= 1) {
$row_Sesion_Carrito = $result_Sesion_Carrito->fetch_array(MYSQLI_ASSOC);
$Id_Pedido = $row_Sesion_Carrito['Id_Pedido'];
$Estatus_Pedido = $row_Sesion_Carrito['Estatus'];

$query_Sesion_Carrito_Prods = "SELECT * FROM `Sesion_Carrito_Prods` WHERE `Id_Pedido` = '$Id_Pedido' ORDER BY `id` DESC;";
$result_Sesion_Carrito_Prods = $mysqli->query($query_Sesion_Carrito_Prods);
$num_Sesion_Carrito_Prods = $result_Sesion_Carrito_Prods->num_rows;
if ($num_Sesion_Carrito_Prods >= 1) {
$lista_productos = "";
while($row_Sesion_Carrito_Prods = $result_Sesion_Carrito_Prods->fetch_array(MYSQLI_ASSOC)) {
$Id_Producto = $row_Sesion_Carrito_Prods['Id_Producto'];
$Num_Prods = $row_Sesion_Carrito_Prods['Num_Prods'];

$query_Productos = "SELECT * FROM `Productos` WHERE `id` = '".$Id_Producto."' AND `Estatus` = 'Activo' ORDER BY `id` DESC LIMIT 1;";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
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
$Mensaje_HTML_clean2 = substr($Mensaje_HTML_clean, 0, 350)."...";
if (strlen($Mensaje_HTML_clean) > 300) {
$Mensaje_Corto = substr($Mensaje_HTML_clean, 0, 300)."...";
}	else {
$Mensaje_Corto = $Mensaje_HTML;
}
$query_Imagenes_Adjuntas = "SELECT * FROM `Imagenes_Adjuntas` WHERE `Tipo` = 'producto' AND `Id_Tipo` = '$Id_Producto' ORDER BY `id` DESC;";
$result_Imagenes_Adjuntas = $mysqli->query($query_Imagenes_Adjuntas);
$num_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->num_rows;
$img_param = "quality=100&resize=100,100"; //quality=80&resize=50,50 quality=80&h=120
if ($num_Imagenes_Adjuntas >= 1) {
$row_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->fetch_array(MYSQLI_ASSOC);
$Imagenes_Adjuntas_Print = <<<EOF
<img class="img-responsive" src="{$url_server_img}/img_adjunta/{$row_Imagenes_Adjuntas['Tipo']}/{$Id_Producto}/{$row_Imagenes_Adjuntas['Nombre_Img']}?{$img_param}" alt="{$Producto}" border="0">
EOF;
} else {
$Imagenes_Adjuntas_Print = <<<EOF
<img class="img-responsive" src="{$url_server_img}/images/No_Foto.jpg?{$img_param}" alt="{$Producto}" border="0">
EOF;
}

if($Estatus_Pedido == "Pendiente"){
$boton_delete = <<<EOF
<a href="javascript:;" class="text-danger elimina_producto" id_producto="{$Id_Producto}" style="text-decoration:none;"><i class="fa fa-times-circle" aria-hidden="true"></i></a>

EOF;
} else {
$boton_delete = "";
}

$lista_productos .= <<<EOF
<div class="row">
<div class="col-sm-3" align="center">
<a href="javascript:;" data-toggle="modal" class="load_modal ver_prod_info" id_producto="{$Id_Producto}" data-target="#modal" style="text-decoration:none;" title="{$Mensaje_HTML_clean}">{$Imagenes_Adjuntas_Print}</a>
</div>
<div class="col-sm-8">
<div align=""><b>{$Producto}</b></div>
<div align="justify">{$Mensaje_HTML_clean2}</div>
<div align="justify"><input type="number" class="form-control" name="producto[{$Id_Producto}]" style="width:80px;" value="{$Num_Prods}"></div>
</div>
<div class="col-sm-1" align="center">
{$boton_delete}
</div>
</div>
<br>
EOF;
}
} else {
$lista_productos .= <<<EOF
<div class="row">
<div class="col-sm-12" align="center">
<h3 class="text-danger">No tiene productos en su carrito.</h3>
</div>
</div>
<br>
EOF;
}
?>

<br>

<form role="form" method="post" id="source_form" action="<?php echo $url_server; ?>/Procesa_Finalizar_Pedido.php" form-data-pjax_>
<input type="hidden" name="Id_Pedido" value="<?php echo $GetId_Pedido; ?>">
<div class="container">
<div align="center">
<a href="<?php echo $url_server; ?>/ver/productos" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
</div>

<div class="row" style="background-color:#0B2347;color:#ffffff;min-height:80px;">
<div class="col-sm-6"><h2>SU CARRITO</h2></div>
<div class="col-sm-6"></div>
</div>
<div class="row" style="">
<div class="col-sm-6 col_prods" style="background-color:#ffffff;min-height:473px;">

<h4 class="text-danger">Sus Art&iacute;culos:</h4>
<br>

<?php
echo $lista_productos;
?>

</div>
<div class="col-sm-6 col_form" style="background-color:#A9ABAE;color:#ffffff;padding-right:40px;padding-left:40px;padding-bottom:40px;">

<h2 style="color:#ffffff;">ORDENA</h2>
<div class="form-group">
<label for="Nombre">Nombre</label>
<input type="text" class="form-control" name="Nombre" id="Nombre" value="<?php echo $row_Sesion_Carrito['Nombre']; ?>">
</div>
<div class="form-group">
<label for="Telefono">Tel&eacute;fono</label>
<input type="text" class="form-control" name="Telefono" id="Telefono" value="<?php echo $row_Sesion_Carrito['Telefono']; ?>">
</div>
<div class="form-group">
<label for="Email">Email</label>
<input type="text" class="form-control" name="Email" id="Email" value="<?php echo $row_Sesion_Carrito['Email']; ?>">
</div>
<div class="form-group">
<label for="Direccion">Direcci&oacute;n</label>
<input type="text" class="form-control" name="Direccion" id="Direccion" value="<?php echo $row_Sesion_Carrito['Direccion']; ?>">
</div>
<div class="form-group">
<label for="Ciudad">Ciudad</label>
<input type="text" class="form-control" name="Ciudad" id="Ciudad" value="<?php echo $row_Sesion_Carrito['Ciudad']; ?>">
</div>
<div class="form-group">
<label for="Tienda_mas_cercana">Tienda m&aacute;s cercana</label>
<select name="Tienda" class="form-control" id="Tienda_mas_cercana">
<?php
$query_Sucursales = "SELECT * FROM `Sucursales` ORDER BY `Sucursal` ASC;";
$result_Sucursales = $mysqli->query($query_Sucursales);
$num_Sucursales = $result_Sucursales->num_rows;
if ($num_Sucursales >= 1) { $input_select = "";
while ($Sucursales = $result_Sucursales->fetch_array(MYSQLI_ASSOC)) {
if($row_Sesion_Carrito['Tienda'] == $Sucursales['id']){
$input_select .= <<<EOF
<option value="{$Sucursales['id']}" selected>{$Sucursales['Sucursal']}</option>
EOF;
} else {
$input_select .= <<<EOF
<option value="{$Sucursales['id']}">{$Sucursales['Sucursal']}</option>
EOF;
}
}
}
echo $input_select;
?>
</select>
</div>

</div>
</div>

<input type="hidden" name="Lat" value="" id="User_Lat">
<input type="hidden" name="Lng" value="" id="User_Lon">

<div class="row" style="background-color:#0B2347;min-height:100px;color:#ffffff;">
<div class="col-sm-4">
<?php if($Estatus_Pedido == "Pendiente"){ ?>
<br>
<button type="button" class="btn btn-danger btn-lg" id="submit_form">ENVIAR PEDIDO</button>
<br>
<h4>Al recibir tu pedido<br>nos comunicaremos contigo<br>v&iacute;a telef&oacute;nica para darte<br>toda la informaci&oacute;n y<br>precios</h4>
<br>
<?php } else { ?>
<h3>Usted solo puede visualizar los datos y productos ingresados en este pedido.</h3>
<?php } ?>
</div>
<div class="col-sm-4">
<div id="response_form" align="center"></div>
</div>
<div class="col-sm-4" style="background: url('https:<?php echo $url_server_img; ?>/img/productos_listado/Back_Envia_Contacto.png?quality=100&h=180') no-repeat right bottom;">
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div>
</div>

</div>

</form>

<script>
$(document).ready(function() {
var height = $(".col_prods").height();
$('.col_form').css('height',height)
});
</script>

<br>
<br>

<?php
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);

} else { ?>
<h2 style="text-align: center;" class="text-danger">Lo sentimos, pero la categor&iacute;a que busca no se encuentra disponible o estamos actualiz&aacute;ndola.</h2>
<?php } ?>