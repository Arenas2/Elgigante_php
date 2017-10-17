<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../../funciones.php");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
include_once("../funciones.admin.php");
include_once("../header.php");

$msg_error = ""; $msg = "";
$FechaRegistro = time();

$id_prod = Valida_utf8($_REQUEST['id_cosa']);
$GetCat_Slug = Valida_utf8($_REQUEST['slug']);
$Tipo = Valida_utf8($_REQUEST['tipo']);
$is_new_id = Valida_utf8($_REQUEST['is_new_id']);

?><?php

if($Tipo == "pagina") {
$Tipo = "pagina";
$Title = "Pagina";
$TipoQuery = "Paginas";
$return_to = "Categorias.php?tipo=".$Tipo."&eliminado=".$id_prod;
$query_Productos = "SELECT * FROM `Paginas` WHERE `id` = '$id_prod' OR `Slug` = '$id_prod' ORDER BY `id` DESC LIMIT 1;";
$query_Productos_DEL = "DELETE FROM `Paginas` WHERE `id` = '$id_prod' OR `Slug` = '$id_prod' ORDER BY `id` DESC LIMIT 1;";
} else if($Tipo == "producto") {
$Tipo = "producto";
$Title = "Producto";
$TipoQuery = "Productos";
$return_to = "Categorias.php?tipo=&eliminado=".$id_prod;
$query_Productos = "SELECT * FROM `Productos` WHERE `id` = '$id_prod' OR `Slug` = '$id_prod' ORDER BY `id` DESC LIMIT 1;";
$query_Productos_DEL = "DELETE FROM `Productos` WHERE `id` = '$id_prod' OR `Slug` = '$id_prod' ORDER BY `id` DESC LIMIT 1;";
$DeleteSub = "DELETE FROM `Productos_Rel_Categorias` WHERE `Id_Producto` = '".$id_prod."';";
if(!$mysqli->query($DeleteSub)){
echo $mysqli->error."<hr>";
}
} else {
$return_to = "Entradas.php?tipo=".$Tipo."&eliminado=".$id_prod;
$query_Productos = "SELECT * FROM `Entradas` WHERE `id` = '$id_prod' AND `Tipo` = '$Tipo' ORDER BY `id` DESC LIMIT 1;";
$query_Productos_DEL = "DELETE FROM `Entradas` WHERE `id` = '$id_prod' AND `Tipo` = '$Tipo' ORDER BY `id` DESC LIMIT 1;";
$DeleteSub = "DELETE FROM `Entradas_Rel_Categorias` WHERE `Tipo` = '$Tipo' AND `Id_Producto` = '".$id_prod."';";
if(!$mysqli->query($DeleteSub)){
echo $mysqli->error."<hr>";
}
}

//$msg .= "".$Tipo.": ";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) {
$row_Productos = $result_Productos->fetch_array(MYSQLI_ASSOC);
//$msg .= "Existe <br>";

$query_Imagenes_Adjuntas = "SELECT * FROM `Imagenes_Adjuntas` WHERE `Tipo` = '$Tipo' AND `Id_Tipo` = '$id_prod' ORDER BY `id` DESC;";
$result_Imagenes_Adjuntas = $mysqli->query($query_Imagenes_Adjuntas);
$num_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->num_rows;
if ($num_Imagenes_Adjuntas >= 1) { ?>
<h3 class="text-center">Eliminando entrada</h3>
<h4 class="text-center"><div id='log_verif_<?php echo $id_prod; ?>'></div></h4>
<div class="progress progress-striped active">
<div class="progress-bar progress_verif_<?php echo $id_prod; ?>" style="width:0%;" id="progress_verif_<?php echo $id_prod; ?>"></div>
</div>
<?php
$regs = "1";
while($row_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->fetch_array(MYSQLI_ASSOC)){
$id = $row_Imagenes_Adjuntas['id'];
$Id_Img = $row_Imagenes_Adjuntas['Id_Img'];
$Nombre_Img = $row_Imagenes_Adjuntas['Nombre_Img'];
$Usuario = $row_Imagenes_Adjuntas['Usuario'];
$FechaHora = $row_Imagenes_Adjuntas['FechaHora'];
$Tamano = $row_Imagenes_Adjuntas['Tamano'];
$Img_Tipo = $row_Imagenes_Adjuntas['Img_Tipo'];
$Url = $row_Imagenes_Adjuntas['Url'];
$Tipo = $row_Imagenes_Adjuntas['Tipo'];
$Id_Tipo = $row_Imagenes_Adjuntas['Id_Tipo'];
$Url_S3 = $row_Imagenes_Adjuntas['Url_S3'];

$img_file = "../../lib/files/".$Tipo."/".$Id_Tipo."/thumbnail/".$Nombre_Img."";
$thumb_file = "../../lib/files/".$Tipo."/".$Id_Tipo."/".$Nombre_Img."";

if (is_file($img_file)) {
//echo "Existe: ".$img_file."<br>";
unlink($img_file);
} else {
$msg .= "No existe: ".$img_file."<br>";
}

if (is_file($thumb_file)) {
//echo "Existe: ".$thumb_file."<br>";
unlink($thumb_file);
} else {
$msg .= "No existe: ".$thumb_file."<br>";
}

$query_del = "DELETE FROM `Imagenes_Adjuntas` WHERE `Nombre_Img` = '".$Nombre_Img."' AND `Tipo` = '".$Tipo."' AND `Id_Tipo` = '".$Id_Tipo."';";
$result_del = $mysqli->query($query_del);
//echo $num_Imagenes_Adjuntas."<br>".$query_del."<br>";
//$msg .= "Imagenes borradas: OK <br>";

$regs_percent = $regs/$num_Imagenes_Adjuntas;
$percent = number_format($regs_percent * 100, 2 ) . '%';

$info_reg = <<<EOF
<script>
$("#log_verif_{$id_prod}").html("Borrando imagenes: {$regs} de {$num_Imagenes_Adjuntas} ({$percent})");
$(".progress_verif_{$id_prod}").width('{$percent}');
$("#progress_verif_{$id_prod}").width('{$percent}');
</script>
EOF;
echo $info_reg;
$regs++;
}
} else {
$msg .= "Sin imagenes para borrar.<br>";
}

} else {
$msg_error .= "Error";
$info_reg = <<<EOF
<h2 class='text-center text-danger'>Entrada no existente, regrese y verifique con soporte.</h2>
EOF;
echo $info_reg;
}
?>

<?php
if($msg_error != "") { ?>
<div class="list-group"><b><?php echo $msg_error; ?></b></div>
<?php } else if($msg_error == "") {

if($mysqli->query($query_Productos_DEL)){ ?>
<?php echo $msg; ?>
<h3 class="text-center text-success">Entrada borrada, regresando...</h3>
<script>
setTimeout(function(){
location = "../<?php echo $return_to; ?>";
}, 3000);
</script>
<?php
} else {
echo "Error al eliminar entrada: ".$query_Productos_DEL."<br>".$mysqli->error;
}
}
?>

<?php
include_once("../footer.php");
?>
