<style>
body {
background-color: #000000;
}
/*
.grid:after {
  content: '';
  display: block;
  clear: both;
}
.grid-sizer,
.grid-item {
  width: 50%;
}
.grid-item {
  float: left;
}
.grid-item img {
padding: 10px;
display: block;
width: 100%;
}*/
</style>

<br>
<br>

<!-- img src="<?php echo $url_server_img; ?>/img/tmp/Ofertas.png" class="img-responsive"
<img src="<?php echo $url_server_img; ?>/img/tmp/Ofertas2.png?quality=100&h=2000" class="img-responsive">
 -->
<div class="container" align="center">
<img src="<?php echo $url_server_img; ?>/img/promociones/Promociones_Header.png?quality=100&h=2000" class="img-responsive">
</div>

<br>

<div class="container" align="center">
<div class="grid_">
<div class="grid-sizer_"></div>
<div class="row">
<?php
//$param_img = "quality=100&resize=150,150";
$param_img = "quality=100";
$GetEntradas_Array = GetEntradas_Array("promociones", "", "DESC");
//echo json_encode($GetEntradas_Array);
$num_entradas = $GetEntradas_Array['num'];
$Entradas = $GetEntradas_Array['entradas'];
foreach($Entradas as $Entrada){
$GetEntradasImagenes_Array = GetEntradasImagenes_Array($Entrada['Tipo'], $Entrada['id'], "");
$img_array = $GetEntradasImagenes_Array['imagenes'][0];
$otros_array = $GetEntradasImagenes_Array['otros'][0];
if($GetEntradasImagenes_Array['num'] >=1){
$categoria_print .= <<<EOF
<div class="grid-item_ col-sm-12" align="center" style="" title="{$Entrada['Entrada']}">
<a href="{$url_server_img}/img_adjunta/{$img_array['Tipo']}/{$Entrada['id']}/{$img_array['Nombre_Img']}" target="_blank">
<img class="img_shadow_cat_ img-responsive" src="{$url_server_img}/img_adjunta/{$img_array['Tipo']}/{$Entrada['id']}/{$img_array['Nombre_Img']}?{$param_img}">
</a>
</div>
EOF;
} else {
$categoria_print .= <<<EOF
<div class="grid-item_ col-sm-12" align="center" style="" title="{$Entrada['Entrada']}">
<img class="img_shadow_cat_ img-responsive" src="{$url_server_img}/images/No_Foto.jpg?{$param_img}">
</div>
EOF;
}
}
echo $categoria_print;
?>
</div>
</div>
</div>

<script>
$(document).ready(function() {
/*
$('.grid').masonry({
columnWidth: '.grid-sizer',
itemSelector: '.grid-item'
});
 */
});
</script>

<br>
<br>

<a class="fancybox fancybox.iframe" href="https://www.youtube.com/embed/<?php echo $Id_Video_Promos; ?>?autoplay=1&autohide=1&controls=1&modestbranding=1&rel=0&theme=light"></a>
<script type="text/javascript">
/* $(document).ready(function(){
$(".fancybox").fancybox({
maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
padding : '10px'
});
$(".fancybox").eq(0).trigger('click');
}); */
</script>
