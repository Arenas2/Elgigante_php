<style>
body {
background-color: #000000;
}
</style>

<br>
<br>

<div class="container" align="center">
<!-- <img src="<?php echo $url_server_img; ?>/img/tmp/Catalogos2.png" class="img-responsive">-->
<img src="<?php echo $url_server_img; ?>/img/catalogos/Header_Catalogos.png" class="img-responsive">
</div>

<br>
<br>

<?php
$GetEntradas_Array = GetCategorias_Array("catalogos");
$num_entradas = $GetEntradas_Array['num'];
if($num_entradas >= 1){
$categorias_array = $GetEntradas_Array['categorias'];
$categoria_print = "";
?>
<div class="container" align="center">
<div class="row_">
<?php
$param_img = "quality=100&resize=150,150";
foreach($categorias_array as $categoria){
$GetEntradasImagenes_Array = GetEntradasImagenes_Array($categoria['Tipo'], $categoria['Slug'], "");
$img_array = $GetEntradasImagenes_Array['imagenes'][0];
$otros_array = $GetEntradasImagenes_Array['otros'][0];
//$img_array_json = json_encode($GetEntradasImagenes_Array['imagenes']);
//$otros_array_json = json_encode($GetEntradasImagenes_Array['otros']);
if($otros_array){
$link_otros = " href='".$url_server."/img_adjunta/".$otros_array['Tipo']."/".$categoria['Slug']."/".$otros_array['Nombre_Img']."' target='_blank' ";
} else { $link_otros = ""; }

if($GetEntradasImagenes_Array['num'] >=1){
$categoria_print .= <<<EOF
<div class="col-sm-2" align="center" style="padding-bottom:30px;" title="{$categoria['Categoria']}">
<a {$link_otros}><img class="img_shadow_cat" src="{$url_server_img}/img_adjunta/{$img_array['Tipo']}/{$categoria['Slug']}/{$img_array['Nombre_Img']}?{$param_img}"></a>
</div>
EOF;
} else {
$categoria_print .= <<<EOF
<div class="col-sm-2" align="center" style="padding-bottom:30px;" title="{$categoria['Categoria']}">
<a {$link_otros}><img class="img_shadow_cat" src="{$url_server_img}/images/No_Foto.jpg?{$param_img}"></a>
</div>
EOF;
}

}
echo $categoria_print;
?>
</div>
</div>
<?php } ?>

<br>
<br>

<!-- <div class="container" align="center">
<img src="<?php echo $url_server_img; ?>/img/tmp/Catalogos2.png" class="img-responsive">
</div> -->
