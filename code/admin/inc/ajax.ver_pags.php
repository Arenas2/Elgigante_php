<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../../funciones.php");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$Cat_Slug = Valida_utf8($_REQUEST['Cat_Slug']);

if($Cat_Slug) { $Cat_Slug_query = "`Cat_Slug` = '$Cat_Slug' AND "; } else { $Cat_Slug_query = ""; }

$query_Productos_Categorias = "SELECT * FROM `Paginas_Categorias` WHERE `Slug` = '".$Cat_Slug."' ORDER BY `id` DESC;";
$result_Productos_Categorias = $mysqli->query($query_Productos_Categorias);
$num_Productos_Categorias = $result_Productos_Categorias->num_rows;
$row_Productos_Categorias = $result_Productos_Categorias->fetch_array(MYSQLI_ASSOC);

$query_Productos = "SELECT * FROM `Paginas` WHERE ".$Cat_Slug_query." `Producto` != '' ORDER BY `id` DESC;";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;

?>
<div align="right">
<a href="javascript:;" onclick="$.nuevo_pag_cat('<?php echo $row_Productos_Categorias['Slug']; ?>','');" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Producto</a>
</div>
<div align="center"><h4>Paginas en la categor&iacute;a <b><?php echo $row_Productos_Categorias['Categoria']; ?></b>: <?php echo $num_Productos; ?></h4></div>
<?php
if ($num_Productos >= 1) {
while($row_Productos = $result_Productos->fetch_array(MYSQLI_ASSOC)){
$id_pag = $row_Productos['id'];
$Cat_Slug = $row_Productos['Cat_Slug'];
//$Slug = $row_Productos['Slug'];
$Producto = $row_Productos['Producto'];
$Descripcion = $row_Productos['Descripcion'];
$Precio = $row_Productos['Precio'];
$Estatus = $row_Productos['Estatus'];

if($Precio){ $Precio_print = ": <span class='text-success'>$".$Precio."</span>"; } else { $Precio_print = ""; }

$Mensaje_HTML = htmlspecialchars_decode($Descripcion);
$Mensaje_HTML_clean = strip_tags($Mensaje_HTML, '');
$Mensaje_HTML_clean2 = substr($Mensaje_HTML_clean, 0, 200) . "...";
if (strlen($Mensaje_HTML_clean) > 300) {
$Mensaje_Corto = substr($Mensaje_HTML_clean, 0, 300) . "...";
}	else {
$Mensaje_Corto = $Mensaje_HTML;
}

$query_Imagenes_Adjuntas = "SELECT * FROM `Imagenes_Adjuntas` WHERE `Id_Tipo` = '$id_pag' ORDER BY `id` DESC;";
$result_Imagenes_Adjuntas = $mysqli->query($query_Imagenes_Adjuntas);
$num_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->num_rows;
if ($num_Imagenes_Adjuntas >= 1) {
$row_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->fetch_array(MYSQLI_ASSOC);
/* //i2.wp.com/?quality=50&w=100"
/compress_img_ext?ext=&s=50
 */
$Imagenes_Adjuntas_Print = <<<EOF
<img class="media-object" src="{$url_server_img}/img_adjunta/{$row_Imagenes_Adjuntas['Tipo']}/{$id_pag}/{$row_Imagenes_Adjuntas['Nombre_Img']}?quality=80&w=50&h=50" alt="" width="50" height="50">
EOF;
} else {
$Imagenes_Adjuntas_Print = <<<EOF
<img class="media-object" src="{$url_server}/images/No_Foto.jpg" alt="" width="50" height="50">
EOF;
}

if($Estatus == "Activo"){ $Estatus_print = "<span class='label label-success'>".$Estatus."</span>"; } else { $Estatus_print = "<span class='label label-default'>".$Estatus."</span>"; }

$Productos_print .= <<<EOF
<div class="media">
<div class="media-left media-middle">
<a href="javascript:;" onclick="$.ver_pag_id('{$id_pag}');">{$Imagenes_Adjuntas_Print}</a>
</div>
<div class="media-body">
<a href="javascript:;" class="no_under" onclick="$.ver_pag_id('{$id_pag}');">
<h5 class="media-heading">{$Producto}{$Precio_print}</h5>
{$Mensaje_HTML_clean2}
</a>
<br>{$Estatus_print}
</div>
</div>
EOF;
}
echo $Productos_print;
?>
<?php } else { ?>
<div class="alert alert-danger" align="center"><i class="fa fa-info-circle"></i> No se encontraron paginas en esta categor&iacute;a.</div>
<?php } ?>