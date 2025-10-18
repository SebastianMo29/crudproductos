<?php
$mysqli = new mysqli("db", "user", "user123", "crud_db");

if ($mysqli->connect_errno) {
    echo "Error al conectar a MySQL: " . $mysqli->connect_error;
    exit();
}
?>
