<?php
include_once("../funciones.php");
include_once("funciones.admin.php");
include_once("header.php");

$ver = Valida_utf8($_REQUEST['ver']);
$slug = Valida_utf8($_REQUEST['slug']);
$id_prod = Valida_utf8($_REQUEST['id_prod']);
$Tipo = Valida_utf8($_REQUEST['tipo']);

$query_Productos = "SELECT * FROM `Productos` ORDER BY `id` DESC;";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) {

$table_template = <<<EOF
<div class="table-responsive_">
<table id="Tabla_Reporte" class="table table-hover display_ nowrap_ tabla_reporte" width="100%" border="1" cellspacing="0" cellpadding="0">
<thead>
<tr>
<th>Id de Producto</th>
<th id="1">Producto</th>
<th id="1">En Stock</th>
</tr>
</thead>
<tbody id="Reporte_Content">
EOF;

while($row_Productos = $result_Productos->fetch_array(MYSQLI_ASSOC)){

$id = $row_Productos['id'];
$Cat_Slug = $row_Productos['Cat_Slug'];
$Slug = $row_Productos['Slug'];
$Producto = $row_Productos['Producto'];
$Descripcion = $row_Productos['Descripcion'];
$Precio = $row_Productos['Precio'];
$Fechaingreso = $row_Productos['Fechaingreso'];
$FechaActualizacion = $row_Productos['FechaActualizacion'];
$Estatus = $row_Productos['Estatus'];
$Orden = $row_Productos['Orden'];

$En_Stock = InStock($id);

$info_prod_tr_ajax_img = info_prod_tr_ajax_img($id);
if ($info_prod_tr_ajax_img) {
$info_prod_tr_ajax_img_print = <<<EOF
<img src="{$url_server_img}/img_adjunta/producto/{$id}/{$info_prod_tr_ajax_img['Nombre_Img']}?quality=50&resize=75,75" class="img-thumbnail" />
EOF;
} else {
$info_prod_tr_ajax_img_print = <<<EOF
<img src="{$url_server_img}/images/No_Foto.jpg?quality=50&resize=75,90"/>
EOF;
}

$table_template .= <<<EOF
<tr>
<td>{$id}</td>
<td valign="top"><a href="Categorias.php?ver=prod&id_prod={$id}&tipo=producto">{$info_prod_tr_ajax_img_print} {$Producto}</a></td>
<td><b><a href="Editar_Stock.php?id_prod={$id}" title="Editar numero en Stock"><i class="fa fa-pencil-square-o"></i> {$En_Stock}</a></b></td>
</tr>
EOF;

}
$table_template .= <<<EOF
</tbody></table>
</div>
EOF;

} else {
$table_template = <<<EOF
Sin Productos
EOF;
}
?>

<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Stock de Productos</h3>
</div>
<div class="panel-body">

<?php echo $table_template; ?>

</div>
</div>
<script type="text/javascript">
$('#Tabla_Reporte').removeClass( 'display' ).addClass('table table-striped table-bordered');
</script>
<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function($) {
var table = $('#Tabla_Reporte').DataTable({
dom: 'Bfrt',
buttons: [
//{ extend: 'print', text: 'Imprimir', autoPrint: false },, message: mensaje
//{ extend: 'colvis', text: 'Admin. Columnas' },
{ extend: 'copyHtml5', text: 'Copiar' },
//{ text: '<i class="fa fa-external-link"></i> PDF', action: function ( e, dt, node, config ) { var to_reload = "https://api.cloudconvert.com/convert?apikey=Q2h_md5EznTyacMxOLj5OkznaRhwQnjpO9lMO4POfND8f_0qlotvHX3yTBBDIQgqCltGD6q2hc0N0dfZyxg4XA&input=download&download=inline&save=true&email=true&inputformat=xls&outputformat=pdf&file="+xls_url; window.location = to_reload; }},
//{ extend: 'excelHtml5', title: nombre_archivo },
{ extend: 'csvHtml5', title: 'Stock' },
//{ text: '<i class="fa fa-external-link"></i> Excel', action: function ( e, dt, node, config ) { var to_reload = xls_orig; window.location = to_reload; }}
],
		"iDisplayLength": -1,
		"aLengthMenu": [
			[25, 50, 100, 1000, -1],
			[25, 50, 100, 1000, "Todos"]
		],
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json",
			buttons: {
				copyTitle: 'Copiar al Portapapeles',
				copyKeys: 'Presione <i>ctrl</i> o <i>\u2318</i> + <i>C</i> para copiar los datos de la tabla<br> a su portapapeles.<br><br>Para cancelar, click en este mensaje o pulse ESC.'
			}
		}
,"aaSorting": [ [0,'asc'] ]});
});
</script>

<?php
//$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>