<?php
require 'db.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = esc($_POST['title']);
    $author_id = (int)$_POST['author_id'];
    $year = (int)$_POST['year'];
    $conn->query("INSERT INTO books (title, author_id, published_year) VALUES ('$title', $author_id, $year)");
    header('Location: books.php'); exit;
}

if ($action === 'delete') {
    $id = (int)$_GET['id'];
    $conn->query("DELETE FROM books WHERE id=$id");
    header('Location: books.php'); exit;
}

if ($action === 'edit') {
    $id = (int)($_GET['id'] ?? 0);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = esc($_POST['title']);
        $author_id = (int)$_POST['author_id'];
        $year = (int)$_POST['year'];
        $conn->query("UPDATE books SET title='$title', author_id=$author_id, published_year=$year WHERE id=$id");
        header('Location: books.php'); exit;
    }
    $row = $conn->query("SELECT * FROM books WHERE id=$id")->fetch_assoc();
}

$authors = $conn->query('SELECT * FROM authors');

?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Libros</title></head>
<body>
  <h1>Libros</h1>
  <a href="index.php">Inicio</a> | <a href="books.php?action=create">Nuevo libro</a>

  <?php if($action==='create' || $action==='edit'): ?>
    <h2><?php echo $action==='create' ? 'Crear' : 'Editar'; ?></h2>
    <form method="post">
      <label>Título: <input name="title" value="<?php echo $row['title'] ?? '' ?>"></label><br>
      <label>Año: <input name="year" value="<?php echo $row['published_year'] ?? '' ?>"></label><br>
      <label>Autor: <select name="author_id">
        <?php
        $authors->data_seek(0);
        while($a = $authors->fetch_assoc()):
        ?>
          <option value="<?php echo $a['id'] ?>" <?php if(isset($row['author_id']) && $row['author_id']==$a['id']) echo 'selected' ?>><?php echo htmlspecialchars($a['name']) ?></option>
        <?php endwhile; ?>
      </select></label>
      <button type="submit">Guardar</button>
    </form>
  <?php endif; ?>

  <?php if($action==='list'): ?>
    <table border="1" cellpadding="6" style="border-collapse:collapse;margin-top:10px">
      <tr><th>ID</th><th>Título</th><th>Año</th><th>Autor</th><th>Acciones</th></tr>
      <?php
      $res = $conn->query('SELECT b.*, a.name as author FROM books b LEFT JOIN authors a ON b.author_id=a.id');
      while($r = $res->fetch_assoc()):
      ?>
        <tr>
          <td><?php echo $r['id'] ?></td>
          <td><?php echo htmlspecialchars($r['title']) ?></td>
          <td><?php echo $r['published_year'] ?></td>
          <td><?php echo htmlspecialchars($r['author']) ?></td>
          <td>
            <a href="books.php?action=edit&id=<?php echo $r['id'] ?>">Editar</a>
            <a href="books.php?action=delete&id=<?php echo $r['id'] ?>" onclick="return confirm('Eliminar?')">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php endif; ?>
</body>
</html>
