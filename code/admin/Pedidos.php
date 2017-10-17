<?php
include_once("../funciones.php");
include_once("funciones.admin.php");
include_once("header.php");

$ver = Valida_utf8($_REQUEST['ver']);
$slug = Valida_utf8($_REQUEST['slug']);
$id_prod = Valida_utf8($_REQUEST['id_prod']);
$Tipo = Valida_utf8($_REQUEST['tipo']);

$query_Sesion_Carrito = "SELECT * FROM `Sesion_Carrito` WHERE `Estatus` != 'Pendiente' ORDER BY `FechaHora` DESC;";
$result_Sesion_Carrito = $mysqli->query($query_Sesion_Carrito);
$num_Sesion_Carrito = $result_Sesion_Carrito->num_rows;
if ($num_Sesion_Carrito >= 1) {
$table_template = <<<EOF
<div class="table-responsive_">
<table id="Tabla_Reporte" class="table table-hover display_ nowrap_ tabla_reporte" width="100%" border="1" cellspacing="0" cellpadding="0">
<thead>
<tr>
<th id="1">Id Pedido</th>
<th id="2">Sucursal</th>
<th id="3">Estatus</th>
<th id="4">Nombre</th>
<th id="">Telefono</th>
<th id="">Email</th>
<th id="">Direccion</th>
<th id="">Ciudad</th>
<th id="">Fecha de ingreso</th>
<th id="">Productos</th>
<th id="">Mapa</th>
</tr>
</thead>
<tbody id="Reporte_Content">
EOF;

while($row_Sesion_Carrito = $result_Sesion_Carrito->fetch_array(MYSQLI_ASSOC)){
$id_ = $row_Sesion_Carrito['id'];
$Session_Id = $row_Sesion_Carrito['Session_Id'];
$Id_Pedido = $row_Sesion_Carrito['Id_Pedido'];
$Nombre = $row_Sesion_Carrito['Nombre'];
$Telefono = $row_Sesion_Carrito['Telefono'];
$Email = $row_Sesion_Carrito['Email'];
$Direccion = $row_Sesion_Carrito['Direccion'];
$Ciudad = $row_Sesion_Carrito['Ciudad'];
$Tienda = $row_Sesion_Carrito['Tienda'];
$Lat = $row_Sesion_Carrito['Lat'];
$Lng = $row_Sesion_Carrito['Lng'];
$IP = $row_Sesion_Carrito['IP'];
$User_Agent = $row_Sesion_Carrito['User_Agent'];
$Estatus = $row_Sesion_Carrito['Estatus'];
$FechaHora = $row_Sesion_Carrito['FechaHora'];
$Data = $row_Sesion_Carrito['Data'];
$FechaHora_ = date('d/m/Y H:i', $FechaHora);
if($Lat != "" & $Lng != "") {
$Mapa = "<a href='https://www.google.com.mx/maps/?q=" . $Lat . "," . $Lng . "' target='_blank'>Ver Mapa</a>";
} else {
$Mapa = "Sin Ubicaci&oacute;n";
}
$Productos = "";

$query_Sucursales = "SELECT * FROM `Sucursales` WHERE `id` = '".$Tienda."'  ORDER BY `id` DESC LIMIT 1;";
$result_Sucursales = $mysqli->query($query_Sucursales);
$num_Sucursales = $result_Sucursales->num_rows;
if($num_Sucursales >=1) {
$Sucursales = $result_Sucursales->fetch_array(MYSQLI_ASSOC);
} else {  }

$table_template .= <<<EOF
<tr class="{$FechaHoraEntrega_Color}">
<td align="center">
<a href="/ver/finalizar_pedido?id_pedido={$Id_Pedido}&no_email=1&ver_resumen=1" target="_blank">{$Id_Pedido}</a>
<br>
<a href="./inc/eliminar_pedido.php?id_pedido={$Id_Pedido}" onclick="return confirm('&iquest;Est&aacute; seguro? Todos los registros de este pedido se eliminaran (productos y datos del contacto)')"><i class="fa fa-trash" aria-hidden="true"></i></a>
</td>
<td title="{$Tienda}">{$Sucursales['Sucursal']}</td>
<td>{$Estatus}</td>
<td><a href="mailto:{$Email}">{$Nombre}</a></td>
<td>{$Telefono}</td>
<td>{$Email}</td>
<td>{$Direccion}</td>
<td>{$Ciudad}</td>
<td data-order="{$FechaHora}">{$FechaHora_}</td>
<td><a href="/ver/finalizar_pedido?id_pedido={$Id_Pedido}&no_email=1&ver_resumen=1" target="_blank">Ver Productos</a></td>
<td>{$Mapa}</td>
</tr>
EOF;

}
$table_template .= <<<EOF
</tbody></table>
</div>
EOF;

} else {
$table_template = <<<EOF
Sin Pedidos
EOF;
}
?>

<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Pedidos Registrados</h3>
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
dom: 'frt',
buttons: [
//{ extend: 'print', text: 'Imprimir', autoPrint: false },, message: mensaje
//{ extend: 'colvis', text: 'Admin. Columnas' },
//{ extend: 'copyHtml5', text: 'Copiar' },
//{ text: '<i class="fa fa-external-link"></i> PDF', action: function ( e, dt, node, config ) { var to_reload = "https://api.cloudconvert.com/convert?apikey=Q2h_md5EznTyacMxOLj5OkznaRhwQnjpO9lMO4POfND8f_0qlotvHX3yTBBDIQgqCltGD6q2hc0N0dfZyxg4XA&input=download&download=inline&save=true&email=true&inputformat=xls&outputformat=pdf&file="+xls_url; window.location = to_reload; }},
//{ extend: 'excelHtml5', title: nombre_archivo },
//{ extend: 'csvHtml5', title: 'Pedidos' },
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
,"aaSorting": [ [8,'DESC'] ]});
});
</script>

<?php
//$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>