<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");

include_once("funciones.php");
$GetAccion = $mysqli->real_escape_string($_REQUEST['accion']);
$GetId_Producto = $mysqli->real_escape_string($_REQUEST['id_producto']);
$Id_Producto = $GetId_Producto;
$user_agent = user_agent();
$IP = ip(); $Session_Id = $session_id;

$query_Productos = "SELECT * FROM `Productos` WHERE `id` = '".$GetId_Producto."' OR `Slug` = '".$GetId_Producto."' ORDER BY `id` DESC LIMIT 1;";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) {
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

$query_Imagenes_Adjuntas = "SELECT * FROM `Imagenes_Adjuntas` WHERE `Tipo` = 'producto' AND `Id_Tipo` = '$GetId_Producto' ORDER BY `id` DESC;";
$result_Imagenes_Adjuntas = $mysqli->query($query_Imagenes_Adjuntas);
$num_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->num_rows;
$img_param = "quality=100&h=150"; //quality=80&resize=50,50 quality=80&h=120
if ($num_Imagenes_Adjuntas >= 1) {
$row_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->fetch_array(MYSQLI_ASSOC);
$Imagenes_Adjuntas_Print = <<<EOF
<img class="img-responsive img-thumbnail" src="{$url_server_img}/img_adjunta/{$row_Imagenes_Adjuntas['Tipo']}/{$Id_Producto}/{$row_Imagenes_Adjuntas['Nombre_Img']}?{$img_param}" alt="{$Producto}">
EOF;
} else {
$Imagenes_Adjuntas_Print = <<<EOF
<img class="img-responsive img-thumbnail" src="{$url_server_img}/images/No_Foto.jpg?{$img_param}" alt="{$Producto}">
EOF;
}
$GetOptionsArray_Simple = GetOptionsArray_Simple($Cat_Slug, "", $Id_Producto, "span");
$producto_html = <<<EOF
<div style="min-height:250px;padding:0px 5px 5px 5px;">
<div align="center">{$Imagenes_Adjuntas_Print}</div>
<div align="center"><b>{$Producto}</b></div>
<div class="well well-sm" align="justify">{$Mensaje_HTML}</div>
<div align="">{$GetOptionsArray_Simple}</div>
</div>
EOF;
?>
<div class="modal-body">
<?php
//echo GetOptionsArray_Simple($Cat_Slug, $Tipo, $GetId_Producto);
//echo json_encode($row_Productos);
echo $producto_html;
?>
</div>
<?php } else { ?>
<div class="modal-body">
<h1 class="text-center text-danger">Producto no encontrado.</h1>
</div>
<?php } ?>