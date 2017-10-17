<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>El Gigante de los Azulejos y Marmoles</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $url_server; ?>/estilos.css?<?php echo time(); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo $url_server; ?>/js/image-picker/image-picker.css">

<!--[if lt IE 9]>
<script src="<?php echo $url_server; ?>/js/image-picker/image-picker.js" type="text/javascript"></script>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<link rel="stylesheet" type="text/css" href="<?php echo $url_server; ?>/js/image-picker/image-picker.css">
<script src="<?php echo $url_server; ?>/js/image-picker/image-picker.js" type="text/javascript"></script>

<script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.min.js"></script>
<script src="//maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&region=mx&language=es&lang=es&libraries=places,geometry,weather,visualization&key=AIzaSyAVF9sgVqv_OXalg-7WTWO9d6WUyk-hMGU"></script>
<style>
.grid-item { width: 200px; } .grid-item--width2 { width: 400px; }
</style>

<script src="<?php echo $url_server; ?>/scripts/header.js" type="text/javascript"></script>

<script type="text/javascript">
window.smartlook||(function(d) {
var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
c.charset='utf-8';c.src='//rec.smartlook.com/recorder.js';h.appendChild(c);
})(document);
smartlook('init', '86c06bd2f187c8b368e6516621f4658a18727798');
</script>

</head>
<body>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-77076245-1', 'auto');
ga('require', 'linkid');
ga('send', 'pageview');
</script>

<div class="div_header_back">
<div class="container">
<div class="row row_custom hidden-xs">
<div class="col-xs-6" align="left">
<a href="<?php echo $url_server; ?>/"><img src="<?php echo $url_server; ?>/Logo2.png" class="img-responsive_" style="margin-top: 40px;border: 0;max-height: 70px;"></a>
</div>
<div class="col-xs-6" align="right">
<a href="<?php echo $url_server; ?>/ver/blog" class="visible-lg-block"><img src="<?php echo $url_server; ?>/El_Placer_de_Elegir.png" class="img-responsive_" style="margin-top: 65px; max-height: 30px;"></a>
</div>
</div>

<div align="center" class="visible-xs-block">
<a href="<?php echo $url_server; ?>/"><img src="<?php echo $url_server; ?>/images/No_Foto.png" class="img-responsive_" style="margin-top: 40px;border: 0;max-height: 70px;"></a>
</div>

</div>
</div>

<div class="div_menu_header_back">
<div align="center">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Menu</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> 
      <ul class="nav navbar-nav">
        <li><a href="<?php echo $url_server; ?>/ver/productos">PRODUCTOS</a></li>
        <li><a href="<?php echo $url_server; ?>/ver/galeria">GALER&Iacute;A</a></li>
        <li><a href="<?php echo $url_server; ?>/ver/promociones">PROMOCIONES</a></li>
        <li><a href="<?php echo $url_server; ?>/ver/catalogos">CAT&Aacute;LOGOS</a></li>
        <!-- <li><a href="<?php echo $url_server; ?>/ver/disenador_en_linea">DISE&Ntilde;ADOR EN L&Iacute;NEA</a></li> -->
        <li><a href="<?php echo $url_server; ?>/ver/tiendas">TIENDAS</a></li>
        <li><a href="<?php echo $url_server; ?>/ver/porque_nos_prefieren">&iquest;POR QU&Eacute; NOS PREFIEREN?</a></li>
        <!--<li><a href="<?php echo $url_server; ?>/ver/blog">BLOG &ldquo;EL PLACER DE ELEGIR&rdquo;</a></li>-->
        <li><a href="http://blog.elgigantedelosazulejos.com.mx/">BLOG &ldquo;EL PLACER DE ELEGIR&rdquo;</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
</div>

<!-- FIN HEADER -->
