<?php

$Get_Id_Entrada = $mysqli->real_escape_string($_REQUEST['ver2']);
if($Get_Id_Entrada == ""){
$GetEntradas_Array = GetEntradas_Array("blog", "", "DESC");
$param_img = "quality=100&resize=280,280";
$num_entradas = $GetEntradas_Array['num'];
$Entradas = $GetEntradas_Array['entradas'];
foreach($Entradas as $Entrada){
$Mensaje_HTML = htmlspecialchars_decode($Entrada['Descripcion']);
$Mensaje_HTML_clean = strip_tags($Mensaje_HTML, '');
//$Mensaje_HTML_clean2 = substr($Mensaje_HTML_clean, 0, 250)."...";
if (strlen($Mensaje_HTML_clean) > 400) {
$Mensaje_Corto = substr($Mensaje_HTML_clean, 0, 400)."...";
}	else {
$Mensaje_Corto = $Mensaje_HTML;
}

$GetEntradasImagenes_Array = GetEntradasImagenes_Array($Entrada['Tipo'], $Entrada['id'], "");
$img_array = $GetEntradasImagenes_Array['imagenes'][0];
$otros_array = $GetEntradasImagenes_Array['otros'][0];
if($GetEntradasImagenes_Array['num'] >=1){
$img_print = <<<EOF
<img class="img-responsive" src="{$url_server_img}/img_adjunta/{$img_array['Tipo']}/{$Entrada['id']}/{$img_array['Nombre_Img']}?{$param_img}">
EOF;
} else {
$img_print = <<<EOF
<img class="img-responsive" data-gallery src="{$url_server_img}/images/No_Foto.jpg?{$param_img}">
EOF;
}

$Entrada_url = urls__($Entrada['Entrada']);
$all_entradas .= <<<EOF
<!--- INICIO POST --->
<a href="{$url_server}/ver/blog/{$Entrada['id']}/{$Entrada_url}" title="{$Entrada['Entrada']}" style="text-decoration:none;color:#000000;">
<div class="row">
<div class="col-sm-4" align="center">
{$img_print}
</div>
<div class="col-sm-8">
<span style="font-size:2em;"><b>{$Entrada['Entrada']}</b></span>
<br>
{$Mensaje_Corto}
</div>
</div>
</a>
<br>
<br>
<!--- FIN POST --->
EOF;
}
} else {

$query_Entradas = "SELECT * FROM `Entradas` WHERE `id` = '".$Get_Id_Entrada."' AND `Tipo` = 'blog' AND `Estatus` = 'Activo' ORDER BY `id` DESC;";
$result_Entradas = $mysqli->query($query_Entradas);
$num_Entradas = $result_Entradas->num_rows;
if ($num_Entradas >= 1) {
$Entrada = $result_Entradas->fetch_array(MYSQLI_ASSOC);

$GetEntradasImagenes_Array = GetEntradasImagenes_Array($Entrada['Tipo'], $Entrada['id'], "");
//$img_array = $GetEntradasImagenes_Array['imagenes'][0];
//$otros_array = $GetEntradasImagenes_Array['otros'][0];
if($GetEntradasImagenes_Array['num'] >=1){
foreach($GetEntradasImagenes_Array['imagenes'] as $img_array) {
$img_print .= <<<EOF
<img class="img-responsive" src="{$url_server_img}/img_adjunta/{$img_array['Tipo']}/{$Entrada['id']}/{$img_array['Nombre_Img']}?{$param_img}">
<br> 
EOF;
}
} else {
$img_print .= <<<EOF
<img class="img-responsive" data-gallery src="{$url_server_img}/images/No_Foto.jpg?{$param_img}">
EOF;
}

$Mensaje_HTML = htmlspecialchars_decode($Entrada['Descripcion']);
$Mensaje_HTML_clean = strip_tags($Mensaje_HTML, '');
//$Mensaje_HTML_clean2 = substr($Mensaje_HTML_clean, 0, 250)."...";
if (strlen($Mensaje_HTML_clean) > 400) {
$Mensaje_Corto = substr($Mensaje_HTML_clean, 0, 400)."...";
}	else {
$Mensaje_Corto = $Mensaje_HTML;
}

$Entrada_url = urls__($Entrada['Entrada']);
$single_entrada .= <<<EOF
<!--- INICIO POST --->
<span style="text-decoration:none;color:#000000;">
<div class="row">
<div class="col-sm-12">
<span style="font-size:2em;"><b>{$Entrada['Entrada']}</b></span>
<br>
{$Mensaje_HTML}
</div>
</div>
</span>
<div class="addthis_sharing_toolbox"></div>
<!--- FIN POST --->
EOF;
}
}
?>

<div style="background-color: #1A1A1A;">
<br>
<div class="container" align="center">
<a href="">
<img src="<?php echo $url_server_img; ?>/img/blog/Blog_Header.png" class="img-responsive">
</a>
</div>
<br>
<br>
</div>

<div style="background-color: #F4F5F6;">
<br>
<br>
<div class="container">

<div class="row row_custom_">
<div class="col-sm-12">

<?php
if($Get_Id_Entrada == "") {
echo $all_entradas;
} else {
echo $single_entrada;
}
?>

</div>
<!--
<div class="col-sm-4" style="background-color:#E21612;color:#ffffff;">
<h1 class="text-center">LO M&Aacute;S LE&Iacute;DO</h1>
</div>
-->

</div>

<!--
<hr>
<img src="<?php echo $url_server_img; ?>/img/tmp/Blog_2.png?0" class="img-responsive">-->

</div>
<br>
<br>
</div>
