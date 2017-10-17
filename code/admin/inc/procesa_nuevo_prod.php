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

$Tipo = Valida_utf8($_REQUEST['tipo']);

$subcat = $_REQUEST['subcat'];
$SubCatsJson = json_encode($subcat);


if($Tipo == "pagina") {
$Tipo = "pagina";
$Title = "Pagina";
$TipoQuery = "Paginas";
$query_Productos = "SELECT * FROM `Paginas` WHERE `id` = '$id_prod' ORDER BY `id` DESC LIMIT 1";
} else {
$Tipo = "producto";
$Title = "Producto";
$TipoQuery = "Productos";
$query_Productos = "SELECT * FROM `Productos` WHERE `id` = '$id_prod' ORDER BY `id` DESC LIMIT 1";
}


if($Slug == ""){
$Slug = urls__($Producto);
}

//if($Producto != "" && $Descripcion != "") {
if($Producto != "") {


$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) {
$new_producto = "UPDATE `".$TipoQuery."` SET `Cat_Slug` = '$Cat_Slug', `Slug` = '$Slug', `Producto` = '$Producto', `Descripcion` = '$Descripcion', `Precio` = '$Precio', `FechaActualizacion` = '$FechaRegistro', `Estatus` = '$Estatus', `SubCatsJson` = '$SubCatsJson' WHERE `id` = '$id_prod';";
$msg_estatus = '<div class="alert alert-success text-center"><b>'.$Title.' actualizad@...</b></div>';
} else {
$new_producto = "INSERT INTO `".$TipoQuery."` (
`Cat_Slug`, `Slug`, `Producto`, `Descripcion`, `Precio`, `Fechaingreso`, `Estatus`, `SubCatsJson`
) VALUES (
'$Cat_Slug', '$Slug', '$Producto', '$Descripcion', '$Precio', '$FechaRegistro', '$Estatus', '".$mysqli->real_escape_string($SubCatsJson)."');";
$msg_estatus = '<div class="alert alert-success text-center"><b>'.$Title.' agregad@...</b></div>';
}
//echo "<br>".$SubCatsJson."<br>".$new_producto."<br>";
$count_newsub = 0;
if(is_array($subcat)){
$DeleteSub = "DELETE FROM `Productos_Rel_Categorias` WHERE `Id_Producto` = '".$id_prod."' AND `Slug_Base` = '".$Cat_Slug."';";
if(!$mysqli->query($DeleteSub)){
echo $mysqli->error."<hr>";
}
foreach($subcat as $key_sub => $arr1_sub){
if(is_array($arr1_sub)){
foreach($arr1_sub as $key_sub2 => $arr1_sub2){
//$query_Productos_Rel_Categorias = "SELECT * FROM `Productos_Rel_Categorias` WHERE `Id_Producto` = '$id_prod' AND `Slug_Base` = '$Cat_Slug' AND `Slug_Rel_Base` = '$key_sub' AND `Slug_SubCat` = '$arr1_sub2' ORDER BY `id` DESC;";
$InsertSub = "INSERT INTO `Productos_Rel_Categorias` (
`Id_Producto`, `Slug_Base`, `Slug_Rel_Base`, `Slug_SubCat`, `Estatus`, `FechaHora`
) VALUES (
'$id_prod', '$Cat_Slug', '$key_sub', '$arr1_sub2', 'Activo', '".time()."');";
if($mysqli->query($InsertSub)){
$count_newsub++;
}
//echo "".$key_sub.": ".$arr1_sub2."<br>".$InsertSub."<hr>";
}
} else {
//$query_Productos_Rel_Categorias = "SELECT * FROM `Productos_Rel_Categorias` WHERE `Id_Producto` = '$id_prod' AND `Slug_Base` = '$Cat_Slug' AND `Slug_Rel_Base` = '$key_sub' AND `Slug_SubCat` = '$arr1_sub' ORDER BY `id` DESC;";
$InsertSub = "INSERT INTO `Productos_Rel_Categorias` (
`Id_Producto`, `Slug_Base`, `Slug_Rel_Base`, `Slug_SubCat`, `Estatus`, `FechaHora`
) VALUES (
'$id_prod', '$Cat_Slug', '$key_sub', '$arr1_sub', 'Activo', '".time()."');";
if($mysqli->query($InsertSub)){
$count_newsub++;
}
//echo "".$key_sub.": ".$arr1_sub."<br>".$InsertSub."<hr>";
}
}
echo "<div align='center'>Se agregaron ".$count_newsub." nuevo(s) filtro(s).</div>";
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
location = "../Categorias.php?ver=prod&id_prod=<?php echo $id_prod_; ?>&tipo=<?php echo $Tipo;?>&guardada=ok";
</script>
<?php  } } else { ?>
<div class="alert alert-error text-center"><b>Error</b><br><?php echo $mysqli->error; ?></div>
<?php } } else { ?>
Para ingresar/actualizar <?php echo $Tipo; ?>, debe llevar nombre y descripci&oacute;n.
<?php } ?>