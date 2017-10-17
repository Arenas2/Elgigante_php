
<style>
body
/*{
background-color: #000000;
}*/
</style>

<div class="container" align="center">

<?php
$GetEntradas_Array = GetEntradas_Array("slider_index", "", "DESC");
$param_img = "quality=100&resize=1140,360";
$num_entradas = $GetEntradas_Array['num'];
$Entradas = $GetEntradas_Array['entradas'];
$count_slide = 0;
foreach($Entradas as $Entrada){

$GetEntradasImagenes_Array = GetEntradasImagenes_Array($Entrada['Tipo'], $Entrada['id'], "");
$img_array = $GetEntradasImagenes_Array['imagenes'][0];
$otros_array = $GetEntradasImagenes_Array['otros'][0];
if($GetEntradasImagenes_Array['num'] >=1){
$img_print = <<<EOF
<img src="{$url_server_img}/img_adjunta/{$img_array['Tipo']}/{$Entrada['id']}/{$img_array['Nombre_Img']}?{$param_img}">
EOF;

if($count_slide == 0) {
$indicador_print .= '<li data-target="#carousel-example-generic" data-slide-to="'.$count_slide.'" class="active"></li>';
$indicador_print .= "\n";
$carousel_print = '<div class="item active">';
} else {
$indicador_print .= '<li data-target="#carousel-example-generic" data-slide-to="'.$count_slide.'"></li>';
$indicador_print .= "\n";
$carousel_print = '<div class="item ">';
}

$slider_all .= <<<EOF
{$carousel_print}
{$img_print}
</div>\n
EOF;

} else {
$img_print_nouuu = <<<EOF
<img src="{$url_server_img}/images/No_Foto.jpg?{$param_img}">
EOF;
}

$count_slide++;
}
?>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
<ol class="carousel-indicators">
<?php echo $indicador_print; ?>
</ol>

<div class="carousel-inner" role="listbox">
<?php
echo $slider_all;
?>
</div>
<!--
<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
<span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
<span class="sr-only">Next</span>
</a>
-->
</div>

<div class="row row_custom">
<div class="col-sm-8 back_cover" style="height:250px;padding-top:140px;padding-right:0px;background-image:url('<?php echo $url_server_img; ?>/img/Index_Conoce_Nuestros_Productos_Back.jpg');bottom:0;position:inherit;"><a href="<?php echo $url_server; ?>/ver/productos"><img src="<?php echo $url_server_img; ?>/img/Index_Conoce_Nuestros_Productos2.png" style="max-height:80px;"></a></div>
<div class="col-sm-4" style="height:250px;padding-top:140px;padding-left:0px;background-color:#E01212;"><a href="<?php echo $url_server; ?>/ver/catalogos"><img src="<?php echo $url_server_img; ?>/img/Index_Descarga_Nuestros_Catalogos.jpg" style="max-height:80px;"></a></div>
</div>

<div class="row row_custom">
<div class="col-sm-2" style="height:250px;padding-top:140px;padding-left:0px;background-color:#0B2347;"><a href="<?php echo $url_server; ?>/ver/porque_nos_prefieren"><img src="<?php echo $url_server_img; ?>/img/Txt_Porque_nos_prefieren.png" style="max-height:70px;"></a></div>
<div class="col-sm-6 back_cover" style="height:250px;padding-top:0px;padding-right:0px;background-image:url('<?php echo $url_server_img; ?>/img/Back_Conoce_nuestras_tiendas2.png?quality=100&h=250');bottom:0;position:inherit;">
<a href="<?php echo $url_server; ?>/ver/tiendas" style="text-decoration: none;">
<div style="height:200px;width:250px;">&nbsp; &nbsp;</div>
<!--<img src="<?php echo $url_server_img; ?>/img/Txt_Conoce_nuestras_tiendas.png" style="max-height:80px;"
<img src="<?php echo $url_server_img; ?>/img/Back_Conoce_nuestras_tiendas2.png?quality=100&h=250" class="img-responsive">
-->
</a></div>
<div class="col-sm-4 text-left back_cover" style="height:250px;padding-top:30px;padding-left:30px;background-image:url('<?php echo $url_server_img; ?>/img/Back_Visita_nuestra_galeria.jpg');bottom:0;position:inherit;"><a href="<?php echo $url_server; ?>/ver/galeria"><img src="<?php echo $url_server_img; ?>/img/Txt_Visita_nuestra_galeria.png" style="max-height:70px;"></a></div>
</div>

<div class="row row_custom">
<div class="col-sm-6 text-left back_cover" style="height:250px;padding-top:30px;padding-left:40px;background-color:#E01212;"><a href="<?php echo $url_server; ?>/ver/promociones"><img src="<?php echo $url_server_img; ?>/img/Txt_Grandes_Descuentos.png" style="max-height:180px;"></a></div>
<div class="col-sm-6 text-left back_cover" style="height:250px;padding-top:30px;padding-left:30px;background-image:url('<?php echo $url_server_img; ?>/img/Back_Disenamos_tu_espacio_2.jpg');bottom:0;position:inherit;"><a href="<?php echo $url_server; ?>/img_adjunta/catalogos/aquaspa-muebles/AquaSpa.pdf?<?php echo $url_server; ?>/ver/disenador_en_linea"><img src="<?php echo $url_server_img; ?>/img/Txt_Disenamos_tu_espacio.2.png" style="max-height:70px;"></a></div>
</div>

</div>

<a class="fancybox fancybox.iframe" href="https://www.youtube.com/embed/<?php echo $Id_Video_Promos; ?>?autoplay=1&autohide=1&controls=1&modestbranding=1&rel=0&theme=light"></a>
<script type="text/javascript">
/* Tambien en promociones
$(document).ready(function(){
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
