<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("../../funciones.php");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$msg_error = ""; $msg = "";
$FechaRegistro = time();

$id_prod = Valida_utf8($_REQUEST['id_prod']);
$GetCat_Slug = Valida_utf8($_REQUEST['slug']);
$is_new_id = Valida_utf8($_REQUEST['is_new_id']);

if($Tipo == "pagina") {
$Tipo = "pagina";
$Title = "Pagina";
$TipoQuery = "Paginas";
$query_Productos = "SELECT * FROM `Paginas` WHERE `id` = '$id_prod' OR `Slug` = '$id_prod' ORDER BY `id` DESC LIMIT 1;";
} else {
$Tipo = "producto";
$Title = "Producto";
$TipoQuery = "Productos";
$query_Productos = "SELECT * FROM `Productos` WHERE `id` = '$id_prod' OR `Slug` = '$id_prod' ORDER BY `id` DESC LIMIT 1;";
}

$result_Productos = $mysqli->query($query_Productos);
$num_Productos = $result_Productos->num_rows;
if ($num_Productos >= 1) {

} else {

$new_producto = "INSERT INTO `".$TipoQuery."` (
`Cat_Slug`, `Slug`, `Producto`, `Descripcion`, `Precio`, `Fechaingreso`, `Estatus`
) VALUES (
'$GetCat_Slug', '$random', 'Borrador ".$Title." ".date('d-m-Y h:i:s', time())."', '$Descripcion', '$Precio', '$FechaRegistro','Borrador');";

$mysqli->query($new_producto);
$id_prod = $mysqli->insert_id;
$alert_new_id = <<<EOF
<script>
location = "./Categorias.php?ver=prod&slug={$GetCat_Slug}&id_prod={$id_prod}&is_new_id=1&tipo={$Tipo}";
</script>
EOF;
}

if($is_new_id == "1")
{
/*
Creando nuevo
<p>Se gener&oacute; un nuevo borrador con el <b><a href="./Categorias.php?ve=prod&slug={$GetCat_Slug}&id_prod={$id_prod}">id: {$id_prod}</a></b>, por favor no actualice o cierre esta ventana hasta que guarde la informaci&oacute;n del producto.</p>
*/
$alert_new_id = <<<EOF
<div class="alert alert-dismissible alert-warning">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<p>Se gener&oacute; un nuevo borrador con el <b><a href="./Categorias.php?ve=prod&slug={$GetCat_Slug}&id_prod={$id_prod}&tipo={$Tipo}">id: {$id_prod}</a></b>, por favor no actualice o cierre esta ventana hasta que guarde la informaci&oacute;n del producto.</p>
</div>
EOF;
}

echo $alert_new_id;

//$Tipo = "producto";
$Id_Nota = $id_prod;
$Id_Tipo = $id_prod;

$row_Productos = $result_Productos->fetch_array(MYSQLI_ASSOC);

$Cat_Slug = $row_Productos['Cat_Slug'];
$Slug = $row_Productos['Slug'];
$Producto = $row_Productos['Producto'];
$Descripcion = $row_Productos['Descripcion'];
$Precio = $row_Productos['Precio'];
$Estatus = $row_Productos['Estatus'];

if($Cat_Slug == ""){
$Cat_Slug = $GetCat_Slug;
}

$query_Productos_Categorias = "SELECT * FROM `".$TipoQuery."_Categorias` ORDER BY `Categoria` ASC;";
$result_Productos_Categorias = $mysqli->query($query_Productos_Categorias);
$num_Productos_Categorias = $result_Productos_Categorias->num_rows;
if ($num_Productos_Categorias >= 1) {
while($row_Productos_Categorias = $result_Productos_Categorias->fetch_array(MYSQLI_ASSOC)){
if($row_Productos_Categorias['Slug'] == $Cat_Slug){
$options_cat_print .= '<option value="' . $row_Productos_Categorias['Slug'] . '" selected>' . $row_Productos_Categorias['Categoria'] . '</option>';
} else {
$options_cat_print .= '<option value="' . $row_Productos_Categorias['Slug'] . '">' . $row_Productos_Categorias['Categoria'] . '</option>';
}
}
}

$query_Productos_Estatus = "SELECT * FROM `".$TipoQuery."_Estatus` ORDER BY `id` ASC;";
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

<form role="form" method="post" id="source_form" action="./inc/procesa_nuevo_prod.php" form-data-pjax >

<div class="row">
<div id="Producto" class="col-sm-7" title="Producto">
<label for="Producto">Nombre del Item</label>
<input type="text" class="form-control Producto" name="Producto" placeholder="Producto" value="<?php echo $row_Productos['Producto']; ?>" required>
</div>

<div id="Precio" class="col-sm-2" title="Precio">
<?php if($Tipo != "pagina") { ?>
<label for="Precio">Precio $</label>
<input type="number" class="form-control Precio" name="Precio" step="any" placeholder="Precio" value="<?php echo $row_Productos['Precio']; ?>">
<?php } ?>
</div>

<div id="Categoria" class="col-sm-3" title="Categoria">
<label for="Categoria">Categor&iacute;a Principal</label>
<select class="form-control Categoria" name="Cat_Slug" required>
<?php echo $options_cat_print; ?>
</select>
</div>

<?php
echo GetOptionsArray($Cat_Slug, $Tipo, $Id_Tipo);
?>

</div>
<br>

<div class="row">
<div id="Descripcion" class="col-sm-9" title="Descripcion">
<label for="Descripcion">Descripcion</label>
<textarea class="Mensaje1" id="Mensaje1" name="Descripcion" placeholder="Descripcion" required="required"><?php echo $row_Productos['Descripcion']; ?></textarea>

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

<input type="hidden" name="id_prod" value="<?php echo $row_Productos['id']; ?>">
<input type="hidden" name="Slug" value="<?php echo $row_Productos['Slug']; ?>">

<input type="hidden" name="Tipo" value="<?php echo $Tipo; ?>">
<input type="hidden" name="tipo" value="<?php echo $Tipo; ?>">
<input type="hidden" name="Id_Tipo" value="<?php echo $Id_Tipo; ?>">

<div class="row">
<div class="col-sm-4" align="right">
<a href="./?tipo=<?php echo $Tipo; ?>&EdicionCancelada=<?php echo $Id_Nota; ?>" class="btn btn-warning" title="Cancelar y Regresar a la p&aacute;gina anterior">Cancelar</a>
</div>
<div class="col-sm-4" align="center">
<a href="./inc/eliminar_entrada.php?&tipo=<?php echo $Tipo; ?>&id_cosa=<?php echo $row_Productos['id']; ?>" class="btn btn-danger" data-confirm="&iquest;Desea borrar esta entrada? Esta acci&oacute;n no se puede deshacer."><i class="fa fa-times"></i> Eliminar</a>
</div>
<div class="col-sm-4" align="left">
<div id="submit_form_">
<button type="submit" class="btn btn-success" id="submit_form_">Guardar</button>
</div>
</div>
</div>

</div>
</form>

<div class="col-sm-3">

<i class="fa fa-upload"></i> <i class="fa fa-picture-o"></i> Adjuntar Im&aacute;genes

<form class="fileupload" id="fileupload" action="<?php echo $url_server; ?>/img_<?php echo $Tipo; ?>/<?php echo $Id_Nota; ?>" method="POST" enctype="multipart/form-data">

<input type="hidden" name="nota" value="<?php echo $Id_Nota; ?>">
<input type="hidden" name="Tipo" value="<?php echo $Tipo; ?>">
<input type="hidden" name="Id_Tipo" value="<?php echo $Id_Tipo; ?>">

        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-xs-12" align="center">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-sm btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <input type="file" name="files[]" multiple accept="image/pjpeg,image/jpeg,image/png,image/gif,image/bmp">
                </span>
                <button type="submit" class="btn btn-sm btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                </button>
                <button type="reset" class="btn btn-sm btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                </button>
                <input type="checkbox" class="toggle">
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-xs-12 fileupload-progress fade" align="center">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
</form>

<small class="text-muted">Una vez que se ha subido alguna imagen, puede dar click sobre ella para incrustarla en el editor.
<br>
Si utiliza el bot&oacute;n de &quot;Subir todas&quot;, es probable que no se guarden con el mismo orden, es recomendable subir una por una.
</small>

</div>
</div>

<script>
CKEDITOR.replace( 'Mensaje1', {
allowedContent: true,
extraPlugins: 'image2,justify',
height: 300
});
function InsertImg(img_src) {
var editor = CKEDITOR.instances.Mensaje1;
var value = img_src;
if ( editor.mode == 'wysiwyg' )
{
editor.insertHtml( '<img src="'+value+'" class="" width="400" style="padding:5px;">' );
}
else
alert( 'Debe estar en modo Editor (WYSIWYG)' );
}
function InsertHTML() {
var editor = CKEDITOR.instances.Mensaje1;
var value = document.getElementById( 'htmlArea' ).value;
if ( editor.mode == 'wysiwyg' )
{
editor.insertHtml( '<p>Texto</p>' );
}
else
alert( 'Debe estar en modo Editor (WYSIWYG)' );
}
function InsertText() {
var editor = CKEDITOR.instances.Mensaje1;
var value = document.getElementById( 'txtArea' ).value;
if ( editor.mode == 'wysiwyg' )
{
editor.insertText( value );
}
else
alert( 'Esta en modo Editor (WYSIWYG)' );
}
</script>

<?php
/* } else { ?>
<div class="alert alert-danger" align="center">Producto no encontrado</div>
<?php } */
?>

<?php
//$nojquery = "1";
//echo FormTarget_Ajax($target_id);
?>
