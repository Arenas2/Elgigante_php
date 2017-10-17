<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../../funciones.php");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$msg_error = ""; $msg = "";
$FechaRegistro = time();

$Tipo = Valida_utf8($_REQUEST['Tipo']);
$tipo = Valida_utf8($_REQUEST['tipo']);
$id_tipo = Valida_utf8($_REQUEST['id_tipo']);
$Cat_Slug = Valida_utf8($_REQUEST['Cat_Slug']);
$Slug = Valida_utf8($_REQUEST['Slug']);
$Entrada = Valida_utf8($_REQUEST['Entrada']);
$Descripcion = Valida_utf8($_REQUEST['Descripcion']);
$Precio = Valida_utf8($_REQUEST['Precio']);
$Estatus = Valida_utf8($_REQUEST['Estatus']);
$Tipo = Valida_utf8($_REQUEST['tipo']);
$subcat = $_REQUEST['subcat'];
$SubCatsJson = json_encode($subcat);

if($Slug == ""){
$Slug = urls__($Producto);
}

if($Entrada != "") {
$query_Entradas = "SELECT * FROM `Entradas` WHERE `id` = '".$id_tipo."' ORDER BY `id` DESC LIMIT 1";
$result_Entradas = $mysqli->query($query_Entradas);
$num_Entradas = $result_Entradas->num_rows;
if ($num_Entradas >= 1) {
$new_entrada = "UPDATE `Entradas` SET `Cat_Slug` = '$Cat_Slug', `Slug` = '$Slug', `Entrada` = '$Entrada', `Descripcion` = '$Descripcion', `Precio` = '$Precio', `FechaActualizacion` = '$FechaRegistro', `Estatus` = '$Estatus', `SubCatsJson` = '$SubCatsJson' WHERE `Tipo` = '$Tipo' AND `id` = '$id_tipo';";
$msg_estatus = '<div class="alert alert-success text-center"><b>Entrada actualizada...</b></div>';
} else {
$new_entrada = "INSERT INTO `Entradas` (
`Tipo`, `Cat_Slug`, `Slug`, `Entrada`, `Descripcion`, `Precio`, `Fechaingreso`, `Estatus`, `SubCatsJson`
) VALUES (
'$Tipo', '$Cat_Slug', '$Slug', '$Entrada', '$Descripcion', '$Precio', '$FechaRegistro', '$Estatus', '".$mysqli->real_escape_string($SubCatsJson)."');";
$msg_estatus = '<div class="alert alert-success text-center"><b>Entrada agregada...</b></div>';
}


$count_newsub = 0;
if(is_array($subcat)){
$DeleteSub = "DELETE FROM `Entradas_Rel_Categorias` WHERE `Tipo` = '".$Tipo."' AND `Id_Producto` = '".$id_tipo."' AND `Slug_Base` = '".$Cat_Slug."';";
if(!$mysqli->query($DeleteSub)){
echo $mysqli->error."<hr>";
}
foreach($subcat as $key_sub => $arr1_sub){
if(is_array($arr1_sub)){
foreach($arr1_sub as $key_sub2 => $arr1_sub2){
//$query_Productos_Rel_Categorias = "SELECT * FROM `Productos_Rel_Categorias` WHERE `Id_Producto` = '$id_prod' AND `Slug_Base` = '$Cat_Slug' AND `Slug_Rel_Base` = '$key_sub' AND `Slug_SubCat` = '$arr1_sub2' ORDER BY `id` DESC;";
$InsertSub = "INSERT INTO `Entradas_Rel_Categorias` (
`Tipo`, `Id_Producto`, `Slug_Base`, `Slug_Rel_Base`, `Slug_SubCat`, `Estatus`, `FechaHora`
) VALUES (
'$Tipo', '$id_tipo', '$Cat_Slug', '$key_sub', '$arr1_sub2', 'Activo', '".time()."');";
if($mysqli->query($InsertSub)){
$count_newsub++;
}
//echo "".$key_sub.": ".$arr1_sub2."<br>".$InsertSub."<hr>";
}
} else {
//$query_Productos_Rel_Categorias = "SELECT * FROM `Productos_Rel_Categorias` WHERE `Id_Producto` = '$id_prod' AND `Slug_Base` = '$Cat_Slug' AND `Slug_Rel_Base` = '$key_sub' AND `Slug_SubCat` = '$arr1_sub' ORDER BY `id` DESC;";
$InsertSub = "INSERT INTO `Entradas_Rel_Categorias` (
`Tipo`, `Id_Producto`, `Slug_Base`, `Slug_Rel_Base`, `Slug_SubCat`, `Estatus`, `FechaHora`
) VALUES (
'".$Tipo."', '$id_tipo', '$Cat_Slug', '$key_sub', '$arr1_sub', 'Activo', '".time()."');";
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
if ($result = $mysqli->query($new_entrada)) {
$new_id = $mysqli->insert_id;
if($new_id){
$id_prod_ = $new_id;
} else {
$id_prod_ = $id_tipo;
}
//echo json_encode($_REQUEST);
echo $msg_estatus; ?>
<script>
location = "../Entradas.php?tipo=<?php echo $Tipo; ?>&ver=entrada&id_tipo=<?php echo $id_prod_; ?>&guardada=ok";
</script>
<?php  } } else { ?>
<div class="alert alert-error text-center"><b>Error</b><br><?php echo $mysqli->error; ?></div>
<?php } } else { ?>
Para ingresar/actualizar <?php echo $Tipo; ?>, debe llevar nombre y descripci&oacute;n.
<?php }
//echo $new_entrada."<br>";
echo $mysqli->error;
?>
