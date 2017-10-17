<style>
body {
background-color: #F4F5F6;
}
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
}
</style>

<br>
<br>

<div class="container" align="center">
<img src="<?php echo $url_server_img; ?>/img/galerias/Header_Galeria.png" class="img-responsive">
</div>

<br>
<br>

<div class="container" align="center">
<div class="row">
<?php
$GetEntradas_Array = GetEntradas_Array("galeria_imagenes", "", "DESC");
//echo json_encode($GetEntradas_Array);
//$param_img = "quality=100&height=500";
$param_img = "quality=100&resize=500,500";
$num_entradas = $GetEntradas_Array['num'];
$Entradas = $GetEntradas_Array['entradas'];
foreach($Entradas as $Entrada){
$GetEntradasImagenes_Array = GetEntradasImagenes_Array($Entrada['Tipo'], $Entrada['id'], "");
$img_array = $GetEntradasImagenes_Array['imagenes'][0];
$otros_array = $GetEntradasImagenes_Array['otros'][0];
if($GetEntradasImagenes_Array['num'] >=1){
$categoria_print .= <<<EOF
<div class="grid-item col-sm-6" align="center" style="" title="{$Entrada['Entrada']}">
<a href="{$url_server_img}/img_adjunta/{$img_array['Tipo']}/{$Entrada['id']}/{$img_array['Nombre_Img']}" target="_blank" title="{$Entrada['Entrada']}">
<img class="img_shadow_cat_ img-responsive" src="{$url_server_img}/img_adjunta/{$img_array['Tipo']}/{$Entrada['id']}/{$img_array['Nombre_Img']}?{$param_img}">
</a>
</div>
EOF;
} else {
$categoria_print .= <<<EOF
<div class="grid-item col-sm-6" align="center" style="" title="{$Entrada['Entrada']}">
<img class="img_shadow_cat_ img-responsive" data-gallery src="{$url_server_img}/images/No_Foto.jpg?{$param_img}">
</div>
EOF;
}
}
echo $categoria_print;
?>
</div>
</div>

<!-- <hr>
<div class="container" align="center">
<img src="<?php echo $url_server_img; ?>/img/tmp/Galerias2.png" class="img-responsive">
</div> -->

<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
<div class="slides"></div>
<h3 class="title"></h3>
<a class="prev"><</a>
<a class="next">></a>
<a class="close">&times;</a>
<a class="play-pause"></a>
<ol class="indicator"></ol>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo $url_server; ?>/js/file_upload_assets/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<!--[if (gte IE 8)&(lt IE 10)]>
<script src="<?php echo $url_server; ?>/js/file_upload_assets/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
