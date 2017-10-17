<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../../funciones.php");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$msg_error = ""; $msg = "";
$FechaRegistro = time();

$Slug_Base = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Slug_Base']));
$Slug_Rel_Base = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Slug_Rel_Base']));
$Slug = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Slug']));
$Categoria = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Categoria']));
$Descripcion = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Descripcion']));
$Imagen = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Imagen']));
$Estatus = $mysqli->real_escape_string(Valida_utf8($_REQUEST['Estatus']));
$Getsubcats = $_REQUEST['subcat'];
$GetNueva_Cat = $_REQUEST['Nueva_Cat'];

if($Estatus == ""){ $Estatus = "1"; }

if(is_array($Getsubcats)){
//echo json_encode($Getsubcats)."<br>";
foreach($Getsubcats as $key1 => $val1){
$Categoria_utf8 = utf8_decode($val1['Categoria']);
$Descripcion_utf8 = utf8_decode($val1['Descripcion']);
$query_Productos_CategoriasSub = "SELECT * FROM `Productos_CategoriasSub` WHERE `Slug_Base` = '$Slug_Base' AND `Slug_Rel_Base` = '$Slug_Rel_Base' AND `Slug` = '".$key1."' ORDER BY `id` DESC;";
//echo $query_Productos_CategoriasSub."<br>";
$result_Productos_CategoriasSub = $mysqli->query($query_Productos_CategoriasSub);
$num_Productos_CategoriasSub = $result_Productos_CategoriasSub->num_rows;
if ($num_Productos_CategoriasSub >= 1) {
$Update = "UPDATE `Productos_CategoriasSub` SET `Categoria` = '".$Categoria_utf8."', `Descripcion` = '".$Descripcion_utf8."', `Imagen` = '$Imagen', `Estatus` = '$Estatus', `Orden` = '$Orden' WHERE `Slug_Base` = '$Slug_Base' AND `Slug_Rel_Base` = '$Slug_Rel_Base' AND `Slug` = '".$key1."';";
$mysqli->query($Update);
//echo $Update."<br>";
} else {

}
}


}
echo "<hr>";
if(is_array($GetNueva_Cat)){
$count_new = 0;
//echo json_encode($GetNueva_Cat);
foreach($GetNueva_Cat as $val2) {
$New_Slug = urls__($val2['Categoria']);
$Categoria2_utf8 = utf8_decode($val2['Categoria']);
$Descripcion2_utf8 = utf8_decode($val2['Descripcion']);
if($Categoria2_utf8 != ""){
if($Descripcion2_utf8 == "") { $Descripcion2_utf8 = $Categoria2_utf8; }
$query_Productos_CategoriasSub2 = "SELECT * FROM `Productos_CategoriasSub` WHERE `Slug_Base` = '$Slug_Base' AND `Slug_Rel_Base` = '$Slug_Rel_Base' AND `Slug` = '".$New_Slug."' ORDER BY `id` DESC;";
$result_Productos_CategoriasSub2 = $mysqli->query($query_Productos_CategoriasSub2);
$num_Productos_CategoriasSub2 = $result_Productos_CategoriasSub2->num_rows;
if ($num_Productos_CategoriasSub2 >= 1) {  } else {
$Insert2 .= "INSERT INTO `Productos_CategoriasSub` (
`Slug_Base`, `Slug_Rel_Base`, `Slug`, `Categoria`, `Descripcion`, `Imagen`, `Estatus`, `Orden`
) VALUES (
'$Slug_Base', '$Slug_Rel_Base', '$New_Slug', '$Categoria2_utf8', '$Descripcion2_utf8', '$Imagen', '$Estatus', '$Orden'
);\n";
$count_new++;
}
}
}
if($count_new >= 1){
if($mysqli->multi_query($Insert2)){
echo "<h3 class='text-success'>Se procesaron ".$count_new." nueva(s) subcategoria(s). Refrescando para agregar nuevos...</h3>"; ?>
<script>
location = "";
</script>
<?php
//echo "<br>".$Insert2."<br>";
} else {
echo $mysqli->error;
}} else {
echo "No se registro alguna nueva subcategoria";
}
}

