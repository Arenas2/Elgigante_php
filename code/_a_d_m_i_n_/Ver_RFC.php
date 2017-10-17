<?php
include_once("../funciones.php");
include_once("funciones.admin.php");
include_once("header.php");

$get_id = Valida_utf8($_REQUEST['id']);
$slug = Valida_utf8($_REQUEST['slug']);
$id_prod = Valida_utf8($_REQUEST['id_prod']);
$Tipo = Valida_utf8($_REQUEST['tipo']);

?>
<h3 class="text-center text-info">RFC del Cliente</h3>
<?php
$query_Datos_RFC = "SELECT * FROM `Datos_RFC` WHERE `id` = '".$get_id."' ORDER BY `id` DESC LIMIT 1;";
$result_Datos_RFC = $mysqli->query($query_Datos_RFC);
$num_Datos_RFC = $result_Datos_RFC->num_rows;
if ($num_Datos_RFC >= 1) {
$table_template = <<<EOF
<div class="table-responsive_">
<table id="Tabla_Reporte" class="table table-hover display_ nowrap_ tabla_reporte" width="100%" border="1" cellspacing="0" cellpadding="0">
<thead>
<tr>
<th id="1">RFC</th>
<th id="2">Nombre de la Empresa</th>
<th id="3">Calle</th>
<th id="4">Numero</th>
<th id="5">Colonia</th>
<th id="6">Municipio</th>
<th id="7">Estado</th>
<th id="8">CP</th>
</tr>
</thead>
<tbody id="Reporte_Content">
EOF;
$Link_RFC = "";
while($row_Datos_RFC = $result_Datos_RFC->fetch_array(MYSQLI_ASSOC)) {
//echo json_encode($row_Datos_RFC);
$table_template .= <<<EOF
<tr>
<td>{$row_Datos_RFC['RFC']}</td>
<td>{$row_Datos_RFC['Empresa']}</td>
<td>{$row_Datos_RFC['Calle']}</td>
<td>{$row_Datos_RFC['Numero']}</td>
<td>{$row_Datos_RFC['Colonia']}</td>
<td>{$row_Datos_RFC['Municipio']}</td>
<td>{$row_Datos_RFC['Estado']}</td>
<td>{$row_Datos_RFC['CodigoPostal']}</td>
</tr>
EOF;
}
$table_template .= <<<EOF
</tbody></table>
</div>
EOF;
} else {
$table_template = <<<EOF
Sin Datos de RFC
EOF;
}
?>


<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Datos Registrados</h3>
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
{ extend: 'csvHtml5', title: 'Usuarios' },
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
,"aaSorting": [ [0,'DESC'] ]});
});
</script>




<?php
//$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>
