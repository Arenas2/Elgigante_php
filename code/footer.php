

<script type="text/javascript">
$(document).ready(function() {
var geo_lat = window.localStorage.getItem("User_Lat");
var geo_lon = window.localStorage.getItem("User_Lon");
$(".status_pedido_ajax").load("<?php echo $url_server; ?>/load.ajax.php?accion=get_info_prod_cot&lat="+geo_lat+"&lon="+geo_lon); 
});

$(document).ready(function(){
$(".add_prod_cot").click(function(){
var $input = $(this);
var id_producto = $input.attr("id_producto");
$input.html('<i class="fa fa-refresh fa-spin"></i>').load("<?php echo $url_server; ?>/load.ajax.php?accion=add_prod_cot&id_producto="+id_producto);
});
$(".elimina_producto").click(function(){
var $input = $(this);
var id_producto = $input.attr("id_producto");
var confirmText = "<?php echo utf8_decode("¿Eliminar producto del carrito?"); ?>";
if(confirm(confirmText)) {
$input.html('<i class="fa fa-refresh fa-spin"></i>').load("<?php echo $url_server; ?>/load.ajax.php?accion=elimina_prod_cot&id_producto=" + id_producto);
}
});
$(".ver_prod_info").click(function(){
var $input = $(this);
var id_producto = $input.attr("id_producto");
$(".modal-content").html('<div align="center"><i class="fa fa-share fa-spin"></i></div>');
$(".modal-content").load('<?php echo $url_server; ?>/ver_prod_info.php?id_producto='+id_producto);
});
});

function process_inv_pop(url, img){
$('[title]').tooltip('hide');
var to_user_inv = ".process_inv_";
$(".modal-content").html('<div align="center"><i class="fa fa-share fa-spin"></i></div>');
$(".modal-content").load(url, img);
}
</script>

<div class="modal fade bs-example-modal-lg" id="modal"  role="dialog" aria-hidden="true" >
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
</div>
</div>
</div>


<!-- INICIO FOOTER -->
<div class="div_footer_back">
<div class="container">
<div class="row row_custom">
<div class="col-sm-3">
<img src="<?php echo $url_server; ?>/img/Logo_G100.png" style="max-height: 80px;" class="img-responsive">
</div>
<div class="col-sm-3 link_white">
<a href="#<?php echo $url_server; ?>/#">Publicidad</a><br>
<a href="#<?php echo $url_server; ?>/#">Prensa</a><br>
<a href="#<?php echo $url_server; ?>/#">Bolsa de Trabajo</a><br>
<a href="#<?php echo $url_server; ?>/#">Mapa del Sitio</a><br>
</div>
<div class="col-sm-3 link_white">
<a href="<?php echo $url_server; ?>/ver/tiendas">Sucursales</a><br>
<!--
Ll&aacute;manos al
<br>
<h4>01 800 GIGANTE</h4>
-->
</div>
<div class="col-sm-3 link_white">
S&iacute;guienos en:
<h4><a href="https://www.facebook.com/elgigantedelosazulejosymarmoles/?fref=ts" target="_blank"><i class="fa fa-facebook-official"></i></a>
 <a href="#<?php echo $url_server; ?>/#" target="_blank"><i class="fa fa-twitter-square"></i></a>
</h4>
</div>
</div>

</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo $url_server; ?>/js/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<link rel="stylesheet" href="<?php echo $url_server; ?>/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $url_server; ?>/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" href="<?php echo $url_server; ?>/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $url_server; ?>/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?php echo $url_server; ?>/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<link rel="stylesheet" href="<?php echo $url_server; ?>/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $url_server; ?>/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>

<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/573575627b7d53d702e18583/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5738d54120b0ac4e"></script>

</body>
</html>