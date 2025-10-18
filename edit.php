<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $rol = $_POST['rol'];

    $stmt = $mysqli->prepare("UPDATE usuarios SET nombre=?, email=?, rol=? WHERE id=?");
    $stmt->bind_param("sssi", $nombre, $email, $rol, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Usuario</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <header>
      <h1>Editar Usuario</h1>
    </header>

    <section class="card">
      <form class="form" method="post">
        <div class="row">
          <label>Nombre</label>
          <input type="text" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
        </div>
        <div class="row">
          <label>Email</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="row">
          <label>Rol</label>
          <select name="rol">
            <option value="user" <?php if($user['rol']=='user') echo 'selected'; ?>>User</option>
            <option value="admin" <?php if($user['rol']=='admin') echo 'selected'; ?>>Admin</option>
          </select>
        </div>
        <div class="row actions">
          <button type="submit">Actualizar</button>
          <a class="btn-link" href="index.php">Volver</a>
        </div>
      </form>
    </section>
  </div>
</body>
</html>
