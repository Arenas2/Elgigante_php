<?php
include_once("../funciones.php");
include_once("header.php");
?>

<h1 class="text-center">Sucursales</h1>

<form role="form" method="post" id="source_form" action="./inc/procesa_editar_sucursales.php" form-data-pjax_>

<?php
$query_Sucursales = "SELECT * FROM `Sucursales` ORDER BY `id` DESC;";
$result_Sucursales = $mysqli->query($query_Sucursales);
$num_Sucursales = $result_Sucursales->num_rows;
if ($num_Sucursales >= 1) {
while($Sucursales = $result_Sucursales->fetch_array(MYSQLI_ASSOC)) {
$form .= <<<EOF
<div class="row">
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Sucursal">Sucursal</label>
<input type="text" name="sucursal[{$Sucursales['id']}][Sucursal]" value="{$Sucursales['Sucursal']}" placeholder="Sucursal" id="input-payment-Sucursal" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Direccion">Direccion</label>
<input type="text" name="sucursal[{$Sucursales['id']}][Direccion]" value="{$Sucursales['Direccion']}" placeholder="Direccion" id="input-payment-Direccion" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Telefono">Telefono</label>
<input type="text" name="sucursal[{$Sucursales['id']}][Telefono]" value="{$Sucursales['Telefono']}" placeholder="Telefono" id="input-payment-Telefono" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Referencia">Referencia</label>
<input type="text" name="sucursal[{$Sucursales['id']}][Referencia]" value="{$Sucursales['Referencia']}" placeholder="Referencia" id="input-payment-Referencia" class="form-control" />
</div>
<div class="form-group required col-sm-6">
<label class="control-label" for="input-payment-Referencia">Email's</label>
<input type="text" name="sucursal[{$Sucursales['id']}][Email]" value="{$Sucursales['Email']}" placeholder="Email,email" id="input-payment-Email" class="form-control" />
</div>

<input type="hidden" name="sucursal[{$Sucursales['id']}][Lat]" value="{$Sucursales['Lat']}" placeholder="Lat" id="input-payment-Lat" class="form-control" />
<input type="hidden" name="sucursal[{$Sucursales['id']}][Lng]" value="{$Sucursales['Lng']}" placeholder="Lng" id="input-payment-Lng" class="form-control" />
</div>
<br>
EOF;
/*
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-id">id</label>
<input type="text" name="sucursal[{$Sucursales['id']}][id]" value="{$Sucursales['id']}" placeholder="id" id="input-payment-id" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Calle">Calle</label>
<input type="text" name="sucursal[{$Sucursales['id']}][Calle]" value="{$Sucursales['Calle']}" placeholder="Calle" id="input-payment-Calle" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Numero">Numero</label>
<input type="text" name="sucursal[{$Sucursales['id']}][Numero]" value="{$Sucursales['Numero']}" placeholder="Numero" id="input-payment-Numero" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Colonia">Colonia</label>
<input type="text" name="sucursal[{$Sucursales['id']}][Colonia]" value="{$Sucursales['Colonia']}" placeholder="Colonia" id="input-payment-Colonia" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Municipio">Municipio</label>
<input type="text" name="sucursal[{$Sucursales['id']}][Municipio]" value="{$Sucursales['Municipio']}" placeholder="Municipio" id="input-payment-Municipio" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Estado">Estado</label>
<input type="text" name="sucursal[{$Sucursales['id']}][Estado]" value="{$Sucursales['Estado']}" placeholder="Estado" id="input-payment-Estado" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-CodigoPostal">CodigoPostal</label>
<input type="text" name="sucursal[{$Sucursales['id']}][CodigoPostal]" value="{$Sucursales['CodigoPostal']}" placeholder="CodigoPostal" id="input-payment-CodigoPostal" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Estatus">Estatus</label>
<input type="text" name="sucursal[{$Sucursales['id']}][Estatus]" value="{$Sucursales['Estatus']}" placeholder="Estatus" id="input-payment-Estatus" class="form-control" />
</div>
*/
}
echo $form;
} else { ?>
<div class="text-center text-warning">Aun no se agregan sucursales</div>
<?php } ?>
<hr id="agrega_nueva">
<h3 class="text-center">Agregar Nueva</h3>
<?php
$n = 0;
$form2 = <<<EOF
<div class="row">
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Sucursal">Sucursal</label>
<input type="text" name="new_sucursal[{$n}][Sucursal]" value="{$Sucursales['Sucursal']}" placeholder="Sucursal" id="input-payment-Sucursal" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Direccion">Direccion</label>
<input type="text" name="new_sucursal[{$n}][Direccion]" value="{$Sucursales['Direccion']}" placeholder="Direccion" id="input-payment-Direccion" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Telefono">Telefono</label>
<input type="text" name="new_sucursal[{$n}][Telefono]" value="{$Sucursales['Telefono']}" placeholder="Telefono" id="input-payment-Telefono" class="form-control" />
</div>
<div class="form-group required col-sm-3">
<label class="control-label" for="input-payment-Referencia">Referencia</label>
<input type="text" name="new_sucursal[{$n}][Referencia]" value="{$Sucursales['Referencia']}" placeholder="Referencia" id="input-payment-Referencia" class="form-control" />
</div>
<div class="form-group required col-sm-6">
<label class="control-label" for="input-payment-Email">Email's</label>
<input type="text" name="new_sucursal[{$n}][Email]" value="{$Sucursales['Email']}" placeholder="Email" id="input-payment-Email" class="form-control" />
</div>

<input type="hidden" name="new_sucursal[{$n}][Lat]" value="{$Sucursales['Lat']}" placeholder="Lat" id="input-payment-Lat" class="form-control" />
<input type="hidden" name="new_sucursal[{$n}][Lng]" value="{$Sucursales['Lng']}" placeholder="Lng" id="input-payment-Lng" class="form-control" />
</div>
<br>
EOF;
echo $form2;
?>

<div id="response_form" align="center">...</div>

<div class="row">
<div class="col-sm-12" align="center">
<div id="submit_form_">
<button type="submit" class="btn btn-success" id="submit_form">Guardar</button>
</div>
</div>
</div>

</form>

<br>
<br>


<?php
//$nojquery = "1";
echo FormTarget_Ajax($target_id);
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>