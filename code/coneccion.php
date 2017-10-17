<?php
$servername = "130.211.165.85";
$port = "4306";
$username = "root";
$password = "root";
$db = "gigante";

try {
    $mbd = new PDO('mysql:host=localhost;port=4306;dbname=gigante', $username, $password);
    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
