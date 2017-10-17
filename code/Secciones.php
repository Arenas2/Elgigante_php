<?php
include_once("funciones.php");
include_once("header.php");
?>

<?php
$ver = Valida_utf8($_REQUEST['ver']);
if($ver == "") {
//include_once("index.default.php");
header("Location: ./?ver=");
} else {
$get_file = "secciones/".$ver.".php";
    if (file_exists($get_file)) {
        include_once($get_file);
    } else {
//include_once("index.default.php");
header("Location: ./?ver=");
}
}
?>

<?php
include_once("footer.php");
?>