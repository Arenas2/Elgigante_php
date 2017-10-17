<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../../funciones.php");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$msg_error = ""; $msg = "";
$FechaRegistro = time();

$GetSucursal = $_REQUEST['sucursal'];
$GetNew_Sucursal = $_REQUEST['new_sucursal'];

if(is_array($GetSucursal)) {
//echo json_encode($GetSucursal)."<br>";
foreach ($GetSucursal as $key1 => $val1) {
$Sucursal_utf8 = utf8_decode($val1['Sucursal']);
$Direccion_utf8 = utf8_decode($val1['Direccion']);
$Telefono_utf8 = utf8_decode($val1['Telefono']);
$Referencia_utf8 = utf8_decode($val1['Referencia']);
$Email_utf8 = utf8_decode($val1['Email']);
$query_Sucursales = "UPDATE `Sucursales` SET `Sucursal` = '$Sucursal_utf8', `Direccion` = '$Direccion_utf8', `Telefono` = '$Telefono_utf8', `Referencia` = '$Referencia_utf8', `Email` = '$Email_utf8' WHERE `id` = '".$key1."' ORDER BY `id` DESC;";
$mysqli->query($query_Sucursales);
}
}

if(is_array($GetNew_Sucursal)) {
//echo json_encode($GetNew_Sucursal)."<br>";
foreach ($GetNew_Sucursal as $key2 => $val2) {
$Sucursal2_utf8 = utf8_decode($val2['Sucursal']);
$Direccion2_utf8 = utf8_decode($val2['Direccion']);
$Telefono2_utf8 = utf8_decode($val2['Telefono']);
$Email2_utf8 = utf8_decode($val2['Email']);
if($Sucursal2_utf8 != "") {
$query_Sucursales2 = "INSERT INTO `Sucursales` (
`Sucursal`, `Direccion`, `Calle`, `Numero`, `Colonia`, `Municipio`, `Estado`, `CodigoPostal`, `Lat`, `Lng`, `Telefono`, `Referencia`, `Email`, `Estatus`
) VALUES (
'" . $Sucursal2_utf8 . "', '" . $Direccion2_utf8 . "', '$Calle', '$Numero', '$Colonia', '$Municipio', '$Estado', '$CodigoPostal', '$Lat', '$Lng', '" . $Telefono2_utf8 . "', '$Referencia', '$Email2_utf8', 'Activo'
);";
$mysqli->query($query_Sucursales2); 
}
}
}
?>
<div class="alert alert-success">Datos procesados, refrescando...</div>
<script>
location = "";
</script>
