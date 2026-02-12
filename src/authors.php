<?php
require 'db.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = esc($_POST['name']);
    $conn->query("INSERT INTO authors (name) VALUES ('$name')");
    header('Location: authors.php'); exit;
}

if ($action === 'delete') {
    $id = (int)$_GET['id'];
    $conn->query("DELETE FROM authors WHERE id=$id");
    header('Location: authors.php'); exit;
}

if ($action === 'edit') {
    $id = (int)($_GET['id'] ?? 0);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = esc($_POST['name']);
        $conn->query("UPDATE authors SET name='$name' WHERE id=$id");
        header('Location: authors.php'); exit;
    }
    $row = $conn->query("SELECT * FROM authors WHERE id=$id")->fetch_assoc();
}

?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Autores</title></head>
<body>
  <h1>Autores</h1>
  <a href="index.php">Inicio</a> | <a href="authors.php?action=create">Nuevo autor</a>

  <?php if($action==='create' || $action==='edit'): ?>
    <h2><?php echo $action==='create' ? 'Crear' : 'Editar'; ?></h2>
    <form method="post">
      <label>Nombre: <input name="name" value="<?php echo $row['name'] ?? '' ?>"></label>
      <button type="submit">Guardar</button>
    </form>
  <?php endif; ?>

  <?php if($action==='list'): ?>
    <table border="1" cellpadding="6" style="border-collapse:collapse;margin-top:10px">
      <tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>
      <?php
      $res = $conn->query('SELECT * FROM authors');
      while($r = $res->fetch_assoc()):
      ?>
        <tr>
          <td><?php echo $r['id'] ?></td>
          <td><?php echo htmlspecialchars($r['name']) ?></td>
          <td>
            <a href="authors.php?action=edit&id=<?php echo $r['id'] ?>">Editar</a>
            <a href="authors.php?action=delete&id=<?php echo $r['id'] ?>" onclick="return confirm('Eliminar?')">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php endif; ?>
</body>
</html>
