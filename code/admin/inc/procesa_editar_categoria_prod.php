<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../../funciones.php");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$msg_error = ""; $msg = "";
$FechaRegistro = time();

$id_cat = Valida_utf8($_REQUEST['id_cat']);
$Slug = Valida_utf8($_REQUEST['Slug']);
$Categoria = Valida_utf8($_REQUEST['Categoria']);
$Descripcion = Valida_utf8($_REQUEST['Descripcion']);
$Imagen = Valida_utf8($_REQUEST['Imagen']);
$Estatus = Valida_utf8($_REQUEST['Estatus']);
$Orden = Valida_utf8($_REQUEST['Orden']);

/*
, `Imagen` = '$Imagen', `Estatus` = '$Estatus', `Orden` = '$Orden'
*/
$query_Productos_Categorias = "SELECT * FROM `Productos_Categorias` WHERE `id` = '$id_cat' ORDER BY `id` DESC;";
$result_Productos_Categorias = $mysqli->query($query_Productos_Categorias);
$num_Productos_Categorias = $result_Productos_Categorias->num_rows;
if ($num_Productos_Categorias >= 1) {
$row_Productos_Categorias = $result_Productos_Categorias->fetch_array(MYSQLI_ASSOC);
$Slug = $row_Productos_Categorias['Slug'];
$queryCatProd = "UPDATE `Productos_Categorias` SET `Categoria` = '$Categoria', `Descripcion` = '$Descripcion' WHERE `id` = '$id_cat';";
} else {
$Slug = urls__($Categoria);
$queryCatProd = "INSERT INTO `Productos_Categorias` (
`Slug`, `Categoria`, `Descripcion`, `Imagen`, `Estatus`, `Orden`
) VALUES (
'$Slug', '$Categoria', '$Descripcion', '$Imagen', 'Activo', '1000' );";
}

if($mysqli->query($queryCatProd)){
$msg_estatus = '<div class="alert alert-success text-center"><b>Categoria procesada...</b></div>
<script>
location = "Categorias.php?ver=cat&slug='.$Slug.'&tipo=producto&guardada=ok";
</script>';
} else {
$msg_estatus = '<div class="alert alert-success text-danger"><b>Error al procesar: '.$mysqli->error.'</b></div>';
}
echo $msg_estatus;
?>