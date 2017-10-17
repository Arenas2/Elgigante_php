<?php
include_once("../funciones.php");
include_once("funciones.admin.php");
include_once("header.php");

$Id_Pedido = Valida_utf8($_REQUEST['id_pedido']);

$query_Pedidos_Transacciones = "SELECT * FROM `Pedidos_Transacciones` WHERE `Id_Pedido` = '$Id_Pedido' ORDER BY `id` DESC;";
$result_Pedidos_Transacciones = $mysqli->query($query_Pedidos_Transacciones);
$num_Pedidos_Transacciones = $result_Pedidos_Transacciones->num_rows;
if ($num_Pedidos_Transacciones >= 1) {
$Info_Trans = "";
while ($row_Pedidos_Transacciones = $result_Pedidos_Transacciones->fetch_array(MYSQLI_ASSOC)) {

$Info_Trans .= "<tr>";
foreach ($row_Pedidos_Transacciones as $var => $val){
$Info_Trans .= "<td>";
if($var == "Data"){
$Data_array = json_decode($val);
$Info_Trans .= "<ul>";
foreach ($Data_array as $var2 => $val2){
$Info_Trans .= "<li>".$var2.": ".$val2."</li>";
}
$Info_Trans .= "</ul>";
} else {
$Info_Trans .= "".$var.": ".$val."";
}
$Info_Trans .= "</td>";
}
$Info_Trans .= "</tr>";

}

?>
<?php } else { ?>

Transacci&oacute;n no encontrada.

<?php } ?>


<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Datos de la Transacci&oacute;n de la orden: <?php echo $Id_Pedido; ?></h3>
</div>
<div class="panel-body">

<div class="table-responsive_">
<table id="Tabla_Reporte" class="table table-hover display_ nowrap_ tabla_reporte" width="100%" border="1" cellspacing="0" cellpadding="0">
<tbody id="Reporte_Content">
<?php echo $Info_Trans; ?>
</tbody></table>
</div>

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
{ extend: 'csvHtml5', title: 'Transaccion' },
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
,"aaSorting": [ [4,'DESC'] ]});
});
</script>

<?php
//$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>
