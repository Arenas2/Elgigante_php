<?php
include_once("../funciones.php");
include_once("funciones.admin.php");
include_once("header.php");

$ver = Valida_utf8($_REQUEST['ver']);
$slug = Valida_utf8($_REQUEST['slug']);
$id_prod = Valida_utf8($_REQUEST['id_prod']);
$Tipo = Valida_utf8($_REQUEST['tipo']);


$query_Usuarios = "SELECT * FROM `Usuarios` ORDER BY `id` DESC;";

$result_Usuarios = $mysqli->query($query_Usuarios);
$num_Usuarios = $result_Usuarios->num_rows;
if ($num_Usuarios >= 1) {

$table_template = <<<EOF
<div class="table-responsive_">
<table id="Tabla_Reporte" class="table table-hover display_ nowrap_ tabla_reporte" width="100%" border="1" cellspacing="0" cellpadding="0">
<thead>
<tr>
<th>Id</th>
<th id="1">Nombre</th>
<th id="2">Email</th>
<th id="3">Telefono</th>
<th id="4">Direccion</th>
<th id="5">Empresa</th>
<th id="6">Fecha Nac.</th>
<th id="7">Fecha de Registro</th>
<th id="8">Newsletter</th>
</tr>
</thead>
<tbody id="Reporte_Content">
EOF;

while($row_Usuarios = $result_Usuarios->fetch_array(MYSQLI_ASSOC)){

$id = $row_Usuarios['id'];
$Id_Usuario = $row_Usuarios['Id_Usuario'];
$Usuario = $row_Usuarios['Usuario'];
$Password = $row_Usuarios['Password'];
$Email = $row_Usuarios['Email'];
$Nombre = $row_Usuarios['Nombre'];
$Apellidos = $row_Usuarios['Apellidos'];
$FechaNacimiento = $row_Usuarios['FechaNacimiento'];
$Telefono = $row_Usuarios['Telefono'];
$Direccion = $row_Usuarios['Direccion'];
$Empresa = $row_Usuarios['Empresa'];
$Acepta_Terminos = $row_Usuarios['Acepta_Terminos'];
$Newsletter = $row_Usuarios['Newsletter'];
$FechaRegistro = $row_Usuarios['FechaRegistro'];
$IP = $row_Usuarios['IP'];
$User_Agent = $row_Usuarios['User_Agent'];
$FechaUltima = $row_Usuarios['FechaUltima'];
$Estatus = $row_Usuarios['Estatus'];

$FechaRegistro_ = date('d/m/Y H:i', $FechaRegistro);

$table_template .= <<<EOF
<tr>
<td>{$id}</td>
<td>{$Nombre} {$Apellidos}</td>
<td title="">{$Email}</td>
<td>{$Telefono}</td>
<td>{$Direccion}</td>
<td>{$Empresa}</td>
<td>{$FechaNacimiento}</td>
<td>{$FechaRegistro_}</td>
<td>{$Newsletter}</td>
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
<h3 class="panel-title">Usuarios Registrados</h3>
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
,"aaSorting": [ [0,'asc'] ]});
});
</script>

<?php
//$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>