<?php



$db_server_main_db = "130.211.165.85:4306";
$db_username_main_db = 'root';
$db_password_main_db = 'root';
$db_name_main_db = 'gigante';
$server = $_SERVER["SERVER_NAME"];

$mysqli = new mysqli($db_server_main_db, $db_username_main_db, $db_password_main_db, $db_name_main_db);
if ($mysqli -> connect_errno) {
echo "Lo sentimos pero se presento un error al conectarse en la base de datos MySQLi (" . $mysqli -> connect_errno . ") " . $mysqli -> connect_error;
}
$db = mysql_connect($db_server_main_db, $db_username_main_db, $db_password_main_db, MYSQL_CLIENT_SSL);
$mydb = mysql_select_db($db_name_main_db);

?>
