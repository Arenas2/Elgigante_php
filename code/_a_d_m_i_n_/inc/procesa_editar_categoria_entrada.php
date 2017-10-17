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

$Tipo = Valida_utf8($_REQUEST['tipo']);
$SubTipo = Valida_utf8($_REQUEST['subtipo']);

if($Categoria != "") {
$query_Entradas_Categorias = "SELECT * FROM `Entradas_Categorias` WHERE `id` = '$id_cat' AND `Tipo` = '$Tipo' AND `SubTipo` = '$SubTipo' ORDER BY `id` DESC;";
$result_Entradas_Categorias = $mysqli->query($query_Entradas_Categorias);
$num_Entradas_Categorias = $result_Entradas_Categorias->num_rows;
if ($num_Entradas_Categorias >= 1) {
$row_Entradas_Categorias = $result_Entradas_Categorias->fetch_array(MYSQLI_ASSOC);

$queryCatProd = "UPDATE `Entradas_Categorias` SET `Categoria` = '$Categoria', `Descripcion` = '$Descripcion' WHERE `id` = '$id_cat';";
} else {
$Slug = urls__($Categoria);
$queryCatProd = "INSERT INTO `Entradas_Categorias` (
`Tipo`, `SubTipo`, `Slug`, `Categoria`, `Descripcion`, `Imagen`, `Estatus`, `Orden`
) VALUES (
'$Tipo', '$SubTipo', '$Slug', '$Categoria', '$Descripcion', '$Imagen', 'Activo', '1000');";
}

if ($mysqli->query($queryCatProd)) {
$msg_estatus = '<div class="alert alert-success text-center"><b>Categor&iacute;a procesada.</b></div>
<script>
location = "Entradas.php?ver=cat&slug=' . $Slug . '&tipo=' . $Tipo . '&subtipo=' . $SubTipo . '&guardada=ok";
</script>';
} else {
$msg_estatus = '<div class="alert alert-danger"><b>Error al procesar: ' . $mysqli->error . '</b></div>';
}
} else {
$msg_estatus = '<div class="alert alert-danger"><b>Categor&iacute;a vacia</b></div>';
}
echo $msg_estatus;
?>