<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../../funciones.php");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$msg_error = ""; $msg = "";
$FechaRegistro = time();

$id_prod = Valida_utf8($_REQUEST['id_prod']);
$Cat_Slug = Valida_utf8($_REQUEST['Cat_Slug']);
$Slug = Valida_utf8($_REQUEST['Slug']);
$Producto = Valida_utf8($_REQUEST['Producto']);
$Descripcion = Valida_utf8($_REQUEST['Descripcion']);
$Precio = Valida_utf8($_REQUEST['Precio']);
$Estatus = Valida_utf8($_REQUEST['Estatus']);

if($Slug == ""){
$Slug = urls__($Producto);
}

//if($Producto != "" && $Descripcion != "") {
if($Producto != "") {

$query_Productos = "SELECT * FROM `Paginas` WHERE `id` = '$id_prod' ORDER BY `id` DESC LIMIT 1";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) {
$new_producto = "UPDATE `Paginas` SET `Cat_Slug` = '$Cat_Slug', `Slug` = '$Slug', `Producto` = '$Producto', `Descripcion` = '$Descripcion', `Precio` = '$Precio', `FechaActualizacion` = '$FechaRegistro', `Estatus` = '$Estatus' WHERE `id` = '$id_prod';";
$msg_estatus = '<div class="alert alert-success text-center"><b>Pagina actualizada...</b></div>';
} else {
$new_producto = "INSERT INTO `Paginas` (
`Cat_Slug`, `Slug`, `Producto`, `Descripcion`, `Precio`, `Fechaingreso`, `Estatus`
) VALUES (
'$Cat_Slug', '$Slug', '$Producto', '$Descripcion', '$Precio', '$FechaRegistro', '$Estatus');";
$msg_estatus = '<div class="alert alert-success text-center"><b>Pagina agregada...</b></div>';
}


if($msg_error != "") { ?>
<div class="list-group"><b><?php echo $msg_error; ?></b></div>
<?php } else if($msg_error == "") {
if ($result = $mysqli->query($new_producto)) {
$new_id = $mysqli->insert_id;
if($new_id){
$id_prod_ = $new_id;
} else {
$id_prod_ = $id_prod;
}
//echo json_encode($_REQUEST);
echo $msg_estatus; ?>
<script>
location = "../Categorias.php?ver=prod&id_prod=<?php echo $id_prod_; ?>&guardada=ok";
</script>
<?php  } } else { ?>
<div class="alert alert-error text-center"><b>Error</b><br><?php echo mysql_error(); ?></div>
<?php } } else { ?>
Para ingresar/actualizar un producto, debe llevar nombre y descripci&oacute;n.
<?php } ?>