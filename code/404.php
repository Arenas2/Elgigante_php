<?php
header('Access-Control-Allow-Origin: *');
//header("content-type: application/javascript");
include_once("funciones.php");
//$ocultasidebar = "1";
include_once("header.php");
?>

<h1 class="text-center text-danger">Pagina no encontrada</h1>

<?php
echo UrlTarget_Ajax($target_url, $target_id);
include_once("footer.php");
?>