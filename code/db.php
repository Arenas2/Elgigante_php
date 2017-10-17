<?php

$db_server_main_db = "130.211.165.85";
$port = '4306';
// $db_server_main_db = "127.0.0.1";
$db_username_main_db = 'root';
$db_password_main_db = 'root';
$db_name_main_db = 'gigante';
$server = $_SERVER["SERVER_NAME"];


$mysqli = new mysqli($db_server_main_db, $db_username_main_db, $db_password_main_db, $db_name_main_db, $port);

if ($mysqli -> connect_errno) {
    echo "Lo sentimos pero se presento un error al conectarse en la base de datos MySQLi (" . $mysqli -> connect_errno . ") " . $mysqli -> connect_error;
}

$sql = "SELECT * FROM Entradas";

if (!$resultado = $mysqli->query($sql)) {
    // ¡Oh, no! La consulta falló.
    echo "Lo sentimos, este sitio web está experimentando problemas.";

    // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
    // cómo obtener información del error
    echo "Error: La ejecución de la consulta falló debido a: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
}

// function pingAddress($ip) {
//     $pingresult = exec("/bin/ping -n 3 $ip", $outcome, $status);
//     if (0 == $status) {
//         $status = "alive";
//     } else {
//         $status = "dead";
//     }
//     echo "The IP address, $ip, is  ".$status;
// }
//
// pingAddress("130.211.165.85");

// $db = mysql_connect('130.211.165.85:4306', $db_username_main_db, $db_password_main_db, MYSQL_CLIENT_SSL);
// $mydb = mysql_select_db($db_name_main_db);


// try {
//     $mysqli = new PDO('mysql:host=localhost;port=4306;dbname=gigante', 'root', 'root');
// } catch (PDOException $e) {
//     echo 'Falló la conexión: ' . $e->getMessage();
// }


?>
