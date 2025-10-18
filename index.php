<?php
require 'db.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($q !== '') {
    $sql = "SELECT * FROM usuarios WHERE nombre LIKE ? OR email LIKE ? ORDER BY id DESC";
    $stmt = $mysqli->prepare($sql);
    $like = "%{$q}%";
    $stmt->bind_param('ss', $like, $like);
} else {
    $sql = "SELECT * FROM usuarios ORDER BY id DESC";
    $stmt = $mysqli->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>CRUD - Usuarios</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <header>
      <h1>CRUD Usuarios</h1>
    </header>

    <section class="card">
      <form class="search" method="get">
        <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Buscar por nombre o email...">
        <button type="submit">Buscar</button>
        <?php if($q !== ''): ?>
          <a class="btn-link" href="index.php">Limpiar</a>
        <?php endif; ?>
      </form>

      <h2>Registrar Usuario</h2>
      <form class="form" action="add.php" method="post">
        <div class="row">
          <label>Ingresar Nombre</label>
          <input type="text" name="nombre" required>
        </div>
        <div class="row">
          <label>Ingresar Email</label>
          <input type="email" name="email" required>
        </div>
        <div class="row">
          <label>Ingresar Rol</label>
          <select name="rol">
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div class="row actions">
          <button type="submit">Guardar Formulario</button>
        </div>
      </form>
    </section>

    <section class="card">
      <h2>Listado de Usuarios</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Creado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['rol']); ?></td>
            <td><?php echo $row['fecha_registro']; ?></td>
            <td>
              <a class="edit" href="edit.php?id=<?php echo $row['id']; ?>">Editar</a>
              <a class="delete" href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Eliminar este usuario?');">Eliminar</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </section>

    <footer>
      <p>CRUD sencillo con PHP + MySQLi • Hecho para XAMPP</p>
    </footer>
  </div>
</body>
</html>
