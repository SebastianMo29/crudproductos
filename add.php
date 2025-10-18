<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $rol = $_POST['rol'];

    if ($nombre && $email) {
        $stmt = $mysqli->prepare("INSERT INTO usuarios (nombre, email, rol) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $rol);
        $stmt->execute();
    }
}

header("Location: index.php");
exit;
?>
