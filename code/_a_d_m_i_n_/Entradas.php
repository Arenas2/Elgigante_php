<?php
include_once("../funciones.php");
include_once("header.php");
$self = $_SERVER['PHP_SELF'];

$ver = Valida_utf8($_REQUEST['ver']);
$slug = Valida_utf8($_REQUEST['slug']);
$id_tipo = Valida_utf8($_REQUEST['id_tipo']);
$Id_Tipo = $id_tipo;
$Tipo = Valida_utf8($_REQUEST['tipo']);
if($Tipo == ""){ $Tipo_def = "default"; }

$is_new_id = Valida_utf8($_REQUEST['is_new_id']);
$id_prod = Valida_utf8($_REQUEST['id_prod']);

$SubTipo = Valida_utf8($_REQUEST['subtipo']);
if($SubTipo != ""){ $SubTipo_Q = " AND `SubTipo` = '$SubTipo' "; }

$Cat_Slug = Valida_utf8($_REQUEST['Cat_Slug']);
if($Cat_Slug) { $Cat_Slug_query = "`Cat_Slug` = '$Cat_Slug' AND "; $Cats_Slug_query = "`Slug` = '$Cat_Slug' AND "; } else { $Cat_Slug_query = ""; $Cats_Slug_query = ""; }

$FechaRegistro = time();

$query_Entradas_Tipos = "SELECT * FROM `Entradas_Tipos` WHERE `Tipo` = '$Tipo' AND `Estatus` = 'Activo' ORDER BY `id` DESC;";
$result_Entradas_Tipos = $mysqli->query($query_Entradas_Tipos);
$num_Entradas_Tipos = $result_Entradas_Tipos->num_rows;
if ($num_Entradas_Tipos >= 1) {
$row_Entradas_Tipos = $result_Entradas_Tipos->fetch_array(MYSQLI_ASSOC);
$Tipo = $row_Entradas_Tipos['Tipo'];
$Singular = $row_Entradas_Tipos['Singular'];
$Plural = $row_Entradas_Tipos['Plural'];
$Descripcion = $row_Entradas_Tipos['Descripcion'];
$UsaPrecio = $row_Entradas_Tipos['UsaPrecio'];
} else {
$Tipo = $Tipo_def;
$Singular = "Entrada";
$Plural = "Entradas";
$Descripcion = "Entradas";
$UsaPrecio = "";
}

$query_Entradas_Categorias = "SELECT * FROM `Entradas_Categorias` WHERE `Tipo` = '$Tipo' AND `Estatus` = 'Activo' ORDER BY `id` DESC;";
//echo $query_Entradas_Categorias."<br>";
$result_Entradas_Categorias = $mysqli->query($query_Entradas_Categorias);
$num_Entradas_Categorias = $result_Entradas_Categorias->num_rows;
if ($num_Entradas_Categorias >= 1) {
$total_all_regs = 0;
while($row_Entradas_Categorias = $result_Entradas_Categorias->fetch_array(MYSQLI_ASSOC)){
$query_Entradas = "SELECT * FROM `Entradas` WHERE `Tipo` = '".$Tipo."' ".$SubTipo_Q." AND `Cat_Slug` = '".$row_Entradas_Categorias['Slug']."' ORDER BY `id` DESC;";
//echo $query_Entradas."<br>";
$result_Entradas = $mysqli->query($query_Entradas);
$num_Entradas = $result_Entradas->num_rows;
if ($num_Entradas >= 1) { $num_Entradas_print ='<span class="badge">'.$num_Entradas.'</span>'; } else { $num_Entradas_print=''; }
$count_entradas_bycat = "";
$row_Entradas_Categorias_print .= <<<EOF
<a href="{$self}?tipo={$Tipo}&ver=cat&Cat_Slug={$row_Entradas_Categorias['Slug']}" class="list-group-item"> {$num_Entradas_print}
{$row_Entradas_Categorias['Categoria']}
</a>
EOF;
$total_all_regs = $total_all_regs+$num_Productos;

if($row_Entradas_Categorias['Slug'] == $Cat_Slug){
$options_cat_print .= '<option value="' . $row_Entradas_Categorias['Slug'] . '" selected>' . $row_Entradas_Categorias['Categoria'] . '</option>';
} else {
$options_cat_print .= '<option value="' . $row_Entradas_Categorias['Slug'] . '">' . $row_Entradas_Categorias['Categoria'] . '</option>';
}

}
} else {
$row_Entradas_Categorias_print .= <<<EOF
<a href="#{$self}?tipo={$Tipo}&ver=cat&slug=" class="list-group-item">
Sin registros
</a>
EOF;
}
?>

<script src="//cdn.ckeditor.com/4.5.8/standard-all/ckeditor.js"></script>
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="<?php echo $url_server; ?>/js/file_upload_assets/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo $url_server; ?>/js/file_upload_assets/css/jquery.fileupload-ui.css">
<noscript><link rel="stylesheet" href="<?php echo $url_server; ?>/js/file_upload_assets/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo $url_server; ?>/js/file_upload_assets/css/jquery.fileupload-ui-noscript.css"></noscript>

<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title"><b><?php echo $num_Entradas_Categorias; ?></b> Categor&iacute;as de <b><?php echo $Plural; ?></b><span id="total_all_regs"></span></h3>
</div>
<div class="panel-body">

<div class="row">
<div class="col-sm-3">

<div align="center">
<a href="Entradas_Editar_Categoria.php?id_cat=0&tipo=<?php echo $Tipo; ?>&subtipo=<?php echo $SubTipo; ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Categor&iacute;a</a>
</div>
<div class="list-group">
<?php
echo $row_Entradas_Categorias_print;
?>
</div>

</div>
<div class="col-sm-6">

<?php
if($ver == "") {
?>
<p style="text-align: center;">Click en alguna <strong>categor&iacute;a</strong> para ver las <strong>entradas</strong>
en ella.</p>
<?php
} else if($ver == "cat") {

$query_Entradas_Categorias2 = "SELECT * FROM `Entradas_Categorias` WHERE `Tipo` = '$Tipo' AND `Slug` = '$Cat_Slug' AND `Estatus` = 'Activo' ORDER BY `id` DESC;";
$result_Entradas_Categorias2 = $mysqli->query($query_Entradas_Categorias2);
$num_Entradas_Categorias2 = $result_Entradas_Categorias2->num_rows;
$row_Entradas_Categorias2 = $result_Entradas_Categorias2->fetch_array(MYSQLI_ASSOC);

if ($num_Entradas_Categorias2 >= 1) { ?>
<div class="row">
<div class="col-xs-8" align="left">
<a href="Entradas_Editar_Categoria.php?tipo=<?php echo $Tipo; ?>&id_cat=<?php echo $row_Entradas_Categorias2['id']; ?>&slug=<?php echo $row_Entradas_Categorias2['Slug']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $row_Entradas_Categorias2['Categoria']; ?></a>

<?php
$query_Entradas_CategoriasSubRel = "SELECT * FROM `Entradas_CategoriasSubRel` WHERE `Tipo` = '$Tipo' AND `Slug_Base` = '$Cat_Slug' AND `Estatus` = '1' ORDER BY `id` ASC;";
$result_Entradas_CategoriasSubRel = $mysqli->query($query_Entradas_CategoriasSubRel);
$num_Entradas_CategoriasSubRel = $result_Entradas_CategoriasSubRel->num_rows;
if ($num_Entradas_CategoriasSubRel >= 1) {
while($row_Entradas_CategoriasSubRel = $result_Entradas_CategoriasSubRel->fetch_array(MYSQLI_ASSOC)){
$subcats_print .= <<<EOF
 | <a href="Entradas_Editar_SubCategoria.php?tipo={$Tipo}&cat_base={$Cat_Slug}&id_cat={$row_Entradas_CategoriasSubRel['Slug']}" class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i> {$row_Entradas_CategoriasSubRel['Categoria']}</a>
EOF;
}
echo " ".$subcats_print;
}
?>
</div>
<div class="col-xs-4" align="right">
<a href="<?php echo $self."?tipo=".$Tipo."&ver=entrada&Cat_Slug=".$row_Entradas_Categorias2['Slug']; ?>&is_new_id=1" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> <?php echo $Singular; ?></a>
</div>
</div>

<?php
$query_Entradas = "SELECT * FROM `Entradas` WHERE `Tipo` = '$Tipo' AND `Cat_Slug` = '$Cat_Slug' ORDER BY `id` DESC;";
//echo $query_Entradas;
$result_Entradas = $mysqli->query($query_Entradas);
$num_Entradas = $result_Entradas->num_rows;
if ($num_Entradas >= 1) {
while ($row_Entradas = $result_Entradas->fetch_array(MYSQLI_ASSOC)) {
$id_entrada = $row_Entradas['id'];
$Entrada = $row_Entradas['Entrada'];
$Descripcion = $row_Entradas['Descripcion'];
$Precio = $row_Entradas['Precio'];
$Estatus = $row_Entradas['Estatus'];
$Orden = $row_Entradas['Orden'];
$SubCatsJson = $row_Entradas['SubCatsJson'];
if($Precio){ $Precio_print = ": <span class='text-success'>$".$Precio."</span>"; } else { $Precio_print = ""; }
$Mensaje_HTML = htmlspecialchars_decode($Descripcion);
$Mensaje_HTML_clean = strip_tags($Mensaje_HTML, '');
$Mensaje_HTML_clean2 = substr($Mensaje_HTML_clean, 0, 200) . "...";
if (strlen($Mensaje_HTML_clean) > 300) {
$Mensaje_Corto = substr($Mensaje_HTML_clean, 0, 300) . "...";
}	else {
$Mensaje_Corto = $Mensaje_HTML;
}
$query_Imagenes_Adjuntas = "SELECT * FROM `Imagenes_Adjuntas` WHERE `Tipo` = '$Tipo' AND `Id_Tipo` = '".$id_entrada."' ORDER BY `id` DESC;";
$result_Imagenes_Adjuntas = $mysqli->query($query_Imagenes_Adjuntas);
$num_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->num_rows;
if ($num_Imagenes_Adjuntas >= 1) {
$row_Imagenes_Adjuntas = $result_Imagenes_Adjuntas->fetch_array(MYSQLI_ASSOC);
$Imagenes_Adjuntas_Print = <<<EOF
<img class="media-object" src="{$url_server_img}/img_adjunta/{$row_Imagenes_Adjuntas['Tipo']}/{$id_entrada}/{$row_Imagenes_Adjuntas['Nombre_Img']}?quality=80&resize=50,50" alt="" width="50" height="50">
EOF;
} else {
$Imagenes_Adjuntas_Print = <<<EOF
<img class="media-object" src="{$url_server}/images/No_Foto.jpg" alt="" width="50" height="50">
EOF;
}
if($Estatus == "Activo"){ $Estatus_print = "<span class='label label-success'>".$Estatus."</span>"; } else { $Estatus_print = "<span class='label label-default'>".$Estatus."</span>"; }
$Url_Entrada = "".$self."?tipo=".$Tipo."&ver=entrada&Cat_Slug=".$Cat_Slug."&id_tipo=".$id_entrada;
$Entradas_print .= <<<EOF
<div class="media">
<div class="media-left media-middle">
<a href="{$Url_Entrada}">{$Imagenes_Adjuntas_Print}</a>
</div>
<div class="media-body">
<a href="{$Url_Entrada}" class="no_under">
<h5 class="media-heading">{$Entrada}{$Precio_print}</h5>
{$Mensaje_HTML_clean2}
</a>
<br>{$Estatus_print}
</div>
</div>
EOF;
}
echo $Entradas_print;
}
} else { ?>
<p style="text-align:center;"><strong>Categor&iacute;a</strong>&nbsp;no encontrada.</p>
<?php } ?>

<br>

<?php } else if($ver == "entrada") {
if ($is_new_id == "1") {
//echo $is_new_id;
$new_entrada = "INSERT INTO `Entradas` (
`Tipo`, `Cat_Slug`, `Slug`, `Entrada`, `Descripcion`, `Precio`, `Fechaingreso`, `Estatus`
) VALUES (
'" . $Tipo . "', '$Cat_Slug', '$random', 'Borrador " . $Title . " " . date('d-m-Y h:i:s', time()) . "', '$Descripcion', '$Precio', '$FechaRegistro','Borrador');";
$mysqli->query($new_entrada);
$id_new_entrada = $mysqli->insert_id;
$alert_new_id = <<<EOF
<script>
location = "{$url}?tipo={$Tipo}&ver=entrada&Cat_Slug={$Cat_Slug}&id_tipo={$id_new_entrada}";
</script>
EOF;
echo $alert_new_id;
} else {
// Inicia Ver=Entrada

$query_Entradas = "SELECT * FROM `Entradas` WHERE `Tipo` = '$Tipo' AND `id` = '" . $id_tipo . "' ORDER BY `id` DESC;";
$result_Entradas = $mysqli->query($query_Entradas);
$num_Entradas = $result_Entradas->num_rows;
//if ($num_Entradas >= 1) {
$row_Entradas = $result_Entradas->fetch_array(MYSQLI_ASSOC);
$Estatus = $row_Entradas['Estatus'];

$query_Productos_Estatus = "SELECT * FROM `Entradas_Estatus` ORDER BY `id` ASC;";
$result_Productos_Estatus = $mysqli->query($query_Productos_Estatus);
$num_Productos_Estatus = $result_Productos_Estatus->num_rows;
if ($num_Productos_Estatus >= 1) {
while($row_Productos_Estatus = $result_Productos_Estatus->fetch_array(MYSQLI_ASSOC)){
if($row_Productos_Estatus['Slug'] == $Estatus){
$options_estatus_print .= '<option value="' . $row_Productos_Estatus['Slug'] . '" selected>' . $row_Productos_Estatus['Estatus'] . '</option>';
} else {
$options_estatus_print .= '<option value="' . $row_Productos_Estatus['Slug'] . '">' . $row_Productos_Estatus['Estatus'] . '</option>';
}
}
}
?>
<form role="form" method="post" id="source_form" action="./inc/procesa_nueva_entrada.php" form-data-pjax >

<div class="row">
<div id="Entrada" class="col-sm-7" title="Entrada">
<label for="Entrada">Nombre</label>
<input type="text" class="form-control Entrada" name="Entrada" placeholder="Entrada" value="<?php echo $row_Entradas['Entrada']; ?>" required>
</div>

<div id="Categoria" class="col-sm-3" title="Categoria">
<label for="Categoria">Categor&iacute;a Principal</label>
<select class="form-control Categoria" name="Cat_Slug" required>
<?php echo $options_cat_print; ?>
</select>
</div>

<?php if($UsaPrecio == "1") { ?>
<div id="Precio" class="col-sm-2" title="Precio">
<label for="Precio">Precio $</label>
<input type="number" class="form-control Precio" name="Precio" step="any" placeholder="Precio" value="<?php echo $row_Entradas['Precio']; ?>">
</div>
<?php } ?>

<?php
echo GetOptionsArray_Entradas($Cat_Slug, $Tipo, $Id_Tipo);
?>
</div>
<br>

<div class="row">
<div id="Descripcion" class="col-sm-12" title="Descripcion">
<label for="Descripcion">Descripci&oacute;n</label>
<textarea class="Mensaje1" id="Mensaje1" name="Descripcion" placeholder="Descripcion" required="required"><?php echo $row_Entradas['Descripcion']; ?></textarea>

<br>

<div id="Estatus" class="col-sm-2_" title="Estatus">
<label for="Estatus">Estatus</label>
<select class="form-control Estatus" name="Estatus" required>
<?php echo $options_estatus_print; ?>
</select>
</div>

<hr>
<div id="pjax-container" align="center">
<small class="text-muted">Si esta usando &quot;Adjuntar&nbsp;Im&aacute;genes&quot;, verifique si pulso en el&nbsp;bot&oacute;n&nbsp;de&nbsp;&quot;Subir todas&quot;, de lo contrario estas no se guardaran.</small>
</div>
<br>

<input type="hidden" name="id_prod" value="<?php echo $row_Entradas['id']; ?>">
<input type="hidden" name="id_tipo" value="<?php echo $row_Entradas['id']; ?>">
<input type="hidden" name="Slug" value="<?php echo $row_Entradas['Slug']; ?>">
<input type="hidden" name="Tipo" value="<?php echo $Tipo; ?>">
<input type="hidden" name="tipo" value="<?php echo $Tipo; ?>">
<input type="hidden" name="Id_Tipo" value="<?php echo $Id_Tipo; ?>">

<div class="row">
<div class="col-sm-4" align="right">
<a href="<?php echo $self; ?>?tipo=<?php echo $Tipo; ?>&EdicionCancelada=<?php echo $Id_Tipo; ?>" class="btn btn-warning" title="Cancelar y Regresar a la p&aacute;gina anterior">Cancelar</a>
</div>
<div class="col-sm-4" align="center">
<a href="./inc/eliminar_entrada.php?tipo=<?php echo $Tipo; ?>&id_cosa=<?php echo $row_Entradas['id']; ?>" class="btn btn-danger" data-confirm="&iquest;Desea borrar esta entrada? Esta acci&oacute;n no se puede deshacer."><i class="fa fa-times"></i> Eliminar</a>
</div>
<div class="col-sm-4" align="left">
<div id="submit_form_">
<button type="submit" class="btn btn-success" id="submit_form_">Guardar</button>
</div>
</div>
</div>

</div>
</div>
</form>

<script>
CKEDITOR.replace( 'Mensaje1', {
allowedContent: true,
extraPlugins: 'image2,justify',
height: 500
});
function InsertImg(img_src) {
var editor = CKEDITOR.instances.Mensaje1;
var value = img_src;
if (editor.mode == 'wysiwyg') {
editor.insertHtml( '<img src="'+value+'" class="" width="400" style="padding:5px;">' );
} else {
alert( 'Debe estar en modo Editor (WYSIWYG)' );
}
}
function InsertHTML() {
var editor = CKEDITOR.instances.Mensaje1;
var value = document.getElementById( 'htmlArea' ).value;
if (editor.mode == 'wysiwyg') {
editor.insertHtml( '<p>Texto</p>' );
} else {
alert( 'Debe estar en modo Editor (WYSIWYG)' );
}
}
function InsertText() {
var editor = CKEDITOR.instances.Mensaje1;
var value = document.getElementById( 'txtArea' ).value;
if (editor.mode == 'wysiwyg'){
editor.insertText( value );
} else {
alert('Esta en modo Editor (WYSIWYG)');
}
}
</script>

<?php }
}
?>

</div>
<div class="col-sm-3">

<form id="fileupload" action="<?php echo $url_server; ?>/js/file_upload_assets/server/php/" method="POST" enctype="multipart/form-data">
<noscript><input type="hidden" name="redirect" value=""></noscript>
<div class="row fileupload-buttonbar">
<div class="col-sm-12" align="center">
<span class="btn btn-success btn-sm fileinput-button">
<i class="glyphicon glyphicon-plus"></i>
<input type="file" name="files[]" multiple>
</span>
<button type="submit" class="btn btn-primary btn-sm start">
<i class="glyphicon glyphicon-upload"></i>
</button>
<button type="reset" class="btn btn-warning btn-sm cancel">
<i class="glyphicon glyphicon-ban-circle"></i>
</button>
<button type="button" class="btn btn-danger btn-sm delete">
<i class="glyphicon glyphicon-trash"></i>
</button>
<input type="checkbox" class="toggle">
<span class="fileupload-process"></span>
</div>
<div class="col-sm-12 fileupload-progress fade" align="center">
<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
<div class="progress-bar progress-bar-success" style="width:0%;"></div>
</div>
<div class="progress-extended">&nbsp;</div>
</div>
</div>
<table role="presentation" class="table table-striped">
<tbody class="files"></tbody>
</table>
</form>
<small class="text-muted">Una vez que se ha subido alguna imagen, puede dar click sobre ella para incrustarla en el editor.
<br>
Si utiliza el bot&oacute;n de &quot;Subir todas&quot;, es probable que no se guarden con el mismo orden, es recomendable subir una por una.
</small>

</div>
</div>


</div>
</div>

</div>
</div>


<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
<div class="slides"></div>
<h3 class="title"></h3>
<a class="prev"><</a>
<a class="next">></a>
<a class="close">&times;</a>
<a class="play-pause"></a>
<ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<tr class="template-upload fade">
<td>
<span class="preview" title="{%=file.name%}"></span>
<div class="name_"><strong class="error text-danger"></strong></div>
</td>
<td>
<p class="size">Un momento...</p>
<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
</td>
<td>
{% if (!i && !o.options.autoUpload) { %}
<button class="btn btn-primary btn-sm start" disabled>
<i class="glyphicon glyphicon-upload"></i>
</button>
{% } %}
{% if (!i) { %}
<button class="btn btn-warning btn-sm cancel">
<i class="glyphicon glyphicon-ban-circle"></i>
</button>
{% } %}
</td>
</tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<tr class="template-download fade">
<td>
<span class="preview">
{% if (file.thumbnailUrl) { %}
<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery onclick="InsertImg('{%=file.url%}');"><img src="{%=file.thumbnailUrl%}"></a>
{% } %}
</span>
{% if (file.error) { %}
<div><span class="label label-danger">Error</span> {%=file.error%}</div>
{% } %}</td>
<!--<td>
<p class="name">
{% if (file.url) { %}
<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
{% } else { %}
<span>{%=file.name%}</span>
{% } %}
</p>
{% if (file.error) { %}
<div><span class="label label-danger">Error</span> {%=file.error%}</div>
{% } %}
</td>-->
<td>
<span class="size">{%=o.formatFileSize(file.size)%}</span>
</td>
<td>
{% if (file.deleteUrl) { %}
<button class="btn btn-danger delete btn-sm" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
<i class="glyphicon glyphicon-trash"></i>
</button>
<input type="checkbox" name="delete" value="1" class="toggle">
{% } else { %}
<button class="btn btn-warning cancel btn-sm">
<i class="glyphicon glyphicon-ban-circle"></i>
</button>
{% } %}
</td>
</tr>
{% } %}
</script>
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

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo $url_server; ?>/js/file_upload_assets/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo $url_server; ?>/js/file_upload_assets/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo $url_server; ?>/js/file_upload_assets/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo $url_server; ?>/js/file_upload_assets/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo $url_server; ?>/js/file_upload_assets/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo $url_server; ?>/js/file_upload_assets/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo $url_server; ?>/js/file_upload_assets/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo $url_server; ?>/js/file_upload_assets/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<!--- script src="<?php echo $url_server; ?>/js/file_upload_assets/js/main.js?<?php echo time(); ?>"></script --->
<?php if($id_tipo == ""){ $Id_Tipo = "0"; } ?>
<script>
$(function () {
'use strict';
// Initialize the jQuery File Upload widget:
$('#fileupload').fileupload({
// Uncomment the following to send cross-domain cookies:
//xhrFields: {withCredentials: true},
//url: '<?php echo $url_server; ?>/js/file_upload_assets/server/php/'
<?php
if($ver == ""){
$Id_Tipo_Img = $Tipo;
} else if($ver == "cat"){
$Id_Tipo_Img = $Cat_Slug;
} else {
$Id_Tipo_Img = $Id_Tipo;
}
?>
url: '<?php echo $url_server; ?>/img_<?php echo $Tipo; ?>/<?php echo $Id_Tipo_Img; ?>'
});
// Enable iframe cross-domain access via redirect option:
$('#fileupload').fileupload(
'option',
'redirect',
window.location.href.replace(
/\/[^\/]*$/,
'/cors/result.html?%s'
)
);
if (window.location.hostname === 'blueimp.github.io') {
// Demo settings:
$('#fileupload').fileupload('option', {
url: '//jquery-file-upload.appspot.com/',
// Enable image resizing, except for Android and Opera,
// which actually support image resizing, but fail to
// send Blob objects via XHR requests:
disableImageResize: /Android(?!.*Chrome)|Opera/
.test(window.navigator.userAgent),
maxFileSize: 999000,
acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
});
// Upload server status check for browsers with CORS support:
if ($.support.cors) {
$.ajax({
url: '//jquery-file-upload.appspot.com/',
type: 'HEAD'
}).fail(function () {
$('<div class="alert alert-danger"/>')
.text('Upload server currently unavailable - ' +
new Date())
.appendTo('#fileupload');
});
}
} else {
// Load existing files:
$('#fileupload').addClass('fileupload-processing');
$.ajax({
// Uncomment the following to send cross-domain cookies:
//xhrFields: {withCredentials: true},
url: $('#fileupload').fileupload('option', 'url'),
dataType: 'json',
context: $('#fileupload')[0]
}).always(function () {
$(this).removeClass('fileupload-processing');
}).done(function (result) {
$(this).fileupload('option', 'done')
.call(this, $.Event('done'), {result: result});
});
}
});
</script>
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="<?php echo $url_server; ?>/js/file_upload_assets/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->

<?php
$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>
