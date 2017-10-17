<?php
//$delete_bots = "DELETE FROM `Sesion_Carrito` WHERE `User_Agent` = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';";
$delete_bots = "DELETE FROM `Sesion_Carrito` WHERE `User_Agent` = '';";
$delete_bots .= "DELETE FROM `Sesion_Carrito` WHERE `User_Agent` = 'panscient.com';";
$delete_bots .= "DELETE FROM `Sesion_Carrito` WHERE `User_Agent` = 'Mozilla/5.0 (compatible; Google-Structured-Data-Testing-Tool +http://developers.google.com/structured-data/testing-tool/)';";
//$delete_bots .= "DELETE FROM `Sesion_Carrito` WHERE `User_Agent` = 'Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12F70 Safari/600.1.4 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';";
$delete_bots .= "DELETE FROM `Sesion_Carrito` WHERE `User_Agent` LIKE '%Google Search Console%';";
$delete_bots .= "DELETE FROM `Sesion_Carrito` WHERE `User_Agent` LIKE '%Googlebot%';";
$delete_bots .= "DELETE FROM `Sesion_Carrito` WHERE `User_Agent` LIKE '%CloudFlare%';";
$delete_bots .= "DELETE FROM `Sesion_Carrito` WHERE `User_Agent` LIKE '%Google Web Preview%';";
//$mysqli->multi_query($delete_bots);
//$num_del_bots = $mysqli->affected_rows;
$redir = "Pedidos.php?from=".$_SERVER['PHP_SELF']."&deleted_bots=".$num_del_bots;
//$redir = "Categorias.php?from=".$_SERVER['PHP_SELF']."&deleted_bots=".$num_del_bots;
?>
<script>
location = "<?php echo $redir; ?>";
</script>
<?php exit(); ?>
<div class="row">
<!---
<div class="col-sm-4">
<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Todos los Pedidos</h3>
</div>
<div class="panel-body">
<?php
//echo GetPedidos_Admin("");
?>
</div>
</div>
</div>

<div class="col-sm-4">
<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Pedidos Pendientes</h3>
</div>
<div class="panel-body">
<?php
//echo GetPedidos_Admin("Pendiente");
?>
</div>
</div>
</div>

<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Pedidos Completados</h3>
</div>
<div class="panel-body">
<?php
//echo GetPedidos_Admin("Completado");
?>
</div>
</div>
</div>
--->

</div>