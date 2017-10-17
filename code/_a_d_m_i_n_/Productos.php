<?php
include_once("../funciones.php");

include_once("header.php");

$ver = Valida_utf8($_REQUEST['ver']);
$slug = Valida_utf8($_REQUEST['slug']);
$id_prod = Valida_utf8($_REQUEST['id_prod']);
$Tipo = Valida_utf8($_REQUEST['tipo']);

if($Tipo == "pagina") {
$Tipo = "pagina";
$Title = "Pagina";
$TipoQuery = "Paginas";
$query_Productos_Categorias = "SELECT * FROM `Paginas_Categorias` ORDER BY `Orden` ASC;";
} else {
$Tipo = "producto";
$Title = "Producto";
$TipoQuery = "Productos";
$query_Productos_Categorias = "SELECT * FROM `Productos_Categorias` ORDER BY `Orden` ASC;";
}

$Id_Nota = $id_prod;

$result_Productos_Categorias = $mysqli->query($query_Productos_Categorias);
$num_Productos_Categorias = $result_Productos_Categorias->num_rows;

?>

<script src="//cdn.ckeditor.com/4.5.4/standard-all/ckeditor.js"></script>

<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo $url_server; ?>/js/jquery_file_upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo $url_server; ?>/js/jquery_file_upload/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo $url_server; ?>/js/jquery_file_upload/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo $url_server; ?>/js/jquery_file_upload/css/jquery.fileupload-ui-noscript.css"></noscript>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Categor&iacute;as de <?php echo $Title; ?></h3>
  </div>
  <div class="panel-body">
<?php
if ($num_Productos_Categorias >= 1) {
while($row_Productos_Categorias = $result_Productos_Categorias->fetch_array(MYSQLI_ASSOC)){

$query_Productos = "SELECT * FROM `".$TipoQuery."` WHERE `Cat_Slug` = '".$row_Productos_Categorias['Slug']."' ORDER BY `id` DESC;";
$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) { $num_Productos_print ='<span class="badge">'.$num_Productos.'</span>'; } else { $num_Productos_print=''; }

$count_prods_bycat = "";
$row_Productos_Categorias_print .= <<<EOF
<a href="javascript:;" onclick="$.ver_prods_cat('{$row_Productos_Categorias['Slug']}');" class="list-group-item"> {$num_Productos_print}
{$row_Productos_Categorias['Categoria']}
</a>
EOF;
}
?>

<div class="row">
<div class="col-sm-3">

<div class="list-group">
<?php
echo $row_Productos_Categorias_print;
?>
</div>

</div>
<div class="col-sm-9">

<div id="response_ver_prods_cat">
<?php if($ver == "prod"){ ?>
<?php
include_once("inc/ajax.ver_prod.php");
?>
<?php } else { ?>
<p style="text-align: center;">Click en alguna categor&iacute;a para ver <?php echo $TipoQuery; ?> en ella.</p>
<?php } ?>
</div>

</div>
</div>

<?php
} else {
}
?>
</div>
</div>

<script>
//$(document).ready(function(){
//$(function () {
var div_ver_prods_cat = $("#response_ver_prods_cat");
var loading_text = '<div class="alert alert-info" align="center"><i class="fa fa-refresh fa-spin"></i> Cargando ...</div>';
var this_url = "Productos.php";
var tipo = "<?php echo $Tipo; ?>";

$.ver_prod_id = function(id_prod) {
div_ver_prods_cat.html(loading_text);
//div_ver_prods_cat.load("inc/ajax.ver_prod.php?id_prod="+id_prod);
history.pushState(null, "", this_url+"?ver=prod&id_prod="+id_prod+"&tipo="+tipo);
window.location = this_url+"?ver=prod&id_prod="+id_prod+"&tipo="+tipo;
}
$.nuevo_prod_cat = function(slug, id_prod) {
div_ver_prods_cat.html(loading_text);
//div_ver_prods_cat.load("inc/ajax.nuevo_prod.php?Cat_Slug="+slug+"&id_prod="+id_prod);
//history.pushState(null, "", this_url+"?ver=nuevo_prod&slug="+slug+"&id_prod="+id_prod);
history.pushState(null, "", this_url+"?ver=prod&slug="+slug+"&id_prod="+id_prod+"&tipo="+tipo);
window.location = this_url+"?ver=prod&slug="+slug+"&id_prod="+id_prod+"&tipo="+tipo;
}
$.ver_prods_cat = function(slug) {
div_ver_prods_cat.html(loading_text);
div_ver_prods_cat.load("inc/ajax.ver_prods.php?Cat_Slug="+slug+"&tipo="+tipo);
history.pushState(null, "", this_url+"?ver=cat&slug="+slug+"&tipo="+tipo);
}

<?php if($ver == "prod"){ ?>
//$.ver_prod_id("<?php echo $id_prod; ?>");
<?php } ?>
<?php if($ver == "nuevo_prod"){ ?>
$.nuevo_prod_cat("<?php echo $slug; ?>", "<?php echo $id_prod; ?>");
<?php } ?>
<?php if($ver == "cat"){ ?>
$.ver_prods_cat("<?php echo $slug; ?>");
<?php } ?>

$.reiniciar = function(id_encuesta){
div_ver_prods_cat.html('<h1 class="text-center"><i class="fa fa-refresh fa-spin"></i></h1>');
window.location = "";
}

$(document).on('click', ':not(form)[data-confirm]', function(){
    return confirm($(this).data('confirm'));
});

$(document).on('submit', 'form[data-confirm]', function(){
    return confirm($(this).data('confirm'));
});

$(document).on('input', 'select', function(event){
    var msg = $(this).children('option:selected').data('confirm');
    if(msg != undefined && !confirm(msg)){
        $(this)[0].selectedIndex = 0;
    }
});

//});
</script>

<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <!-- <p class="name"><small>{%=file.name%}</small></p> -->
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Subiendo...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button title="Iniciar" class="btn btn-primary start btn-sm" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                </button>
            {% } %}
            {% if (!i) { %}
                <button title="Cancelar" class="btn btn-warning cancel btn-sm">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href_="{%=file.url%}" title="{%=file.name%}" download_="{%=file.name%}" data-gallery_ onclick="InsertImg('{%=file.url%}');"><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href_="{%=file.url%}" title="{%=file.name%}" download_="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery_':''%} onclick="InsertImg('{%=file.url%}');"><!-- <small>{%=file.name%}</small> --></a>
                {% } else { %}
                    <!-- <span><small>{%=file.name%}</small></span> -->
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size"><small>{%=o.formatFileSize(file.size)%}</small></span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button title="Eliminar" class="btn btn-danger delete btn-sm" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button title="Cancelar" class="btn btn-warning cancel btn-sm">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>

<script src="<?php echo $url_server; ?>/js/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo $url_server; ?>/js/jquery_file_upload/js/jquery.iframe-transport.js"></script>
<script src="<?php echo $url_server; ?>/js/jquery_file_upload/js/jquery.fileupload.js"></script>
<script src="<?php echo $url_server; ?>/js/jquery_file_upload/js/jquery.fileupload-process.js"></script>
<script src="<?php echo $url_server; ?>/js/jquery_file_upload/js/jquery.fileupload-image.js"></script>
<script src="<?php echo $url_server; ?>/js/jquery_file_upload/js/jquery.fileupload-audio.js"></script>
<script src="<?php echo $url_server; ?>/js/jquery_file_upload/js/jquery.fileupload-video.js"></script>
<script src="<?php echo $url_server; ?>/js/jquery_file_upload/js/jquery.fileupload-validate.js"></script>
<script src="<?php echo $url_server; ?>/js/jquery_file_upload/js/jquery.fileupload-ui.js"></script>
<!-- <script src="<?php echo $url_server; ?>/js/jquery_file_upload/js/main.js"></script> -->
<script>
$(function() {
'use strict';
var url = '<?php echo $url_server; ?>/img_<?php echo $Tipo; ?>/<?php echo $Id_Nota; ?>';
    $('.fileupload').fileupload({
        url: '<?php echo $url_server; ?>/img_<?php echo $Tipo; ?>/<?php echo $Id_Nota; ?>'
    });
    $('.fileupload').fileupload(
    //'add', {files: $('#some-file-input-field')},
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );
        $('.fileupload').addClass('fileupload-processing');
        $.ajax({
           xhrFields: {withCredentials: true},
            //url: url,
            url: $('.fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('.fileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });

});
</script>

<!--[if (gte IE 8)&(lt IE 10)]>
<script src="<?php echo $url_server; ?>/js/jquery_file_upload/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->

<?php
$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>