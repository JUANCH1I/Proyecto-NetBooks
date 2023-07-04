<?php
include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include('../db.php');

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  if (isset($_POST['apellido'])) {
    $consultaSQL = "SELECT user_id, user_name, user_email, rol_descripcion FROM users inner join rol on users.idRol =rol.idRol AND user_name LIKE '%" . $_POST['apellido'] . "%' limit 100";
  } else {
    $consultaSQL = "SELECT user_id, user_name, user_email, rol_descripcion FROM users inner join rol on users.idRol =rol.idRol limit 100";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumnos = $sentencia->fetchAll();
} catch (PDOException $error) {
  $error = $error->getMessage();
}

$titulo = isset($_POST['apellido']) ? 'Lista de alumnos (' . $_POST['apellido'] . ')' : 'Lista de alumnos';
?>

<?php include "../template/header.php"; ?>

<?php
if ($error) {
?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="agregarUsuario.php" class="btn btn-primary mt-4">Crear alumno</a>
      <a href="/Desarrollo-Web/index.php" class="btn btn-primary mt-4">Volver al inicio</a>
      <hr>

      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="apellido" name="apellido" placeholder="Buscar por apellido" class="form-control">
        </div>
        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>"><br>
        <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Activado</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($alumnos && $sentencia->rowCount() > 0) {
            foreach ($alumnos as $fila) {
          ?>
              <tr>
                <td><?php echo escapar($fila["user_id"]); ?></td>
                <td><?php echo escapar($fila["user_name"]); ?></td>
                <td><?php echo escapar($fila["user_email"]); ?></td>
                <td><?php echo escapar($fila["rol_descripcion"]); ?></td>
                <td>
                  <a href="<?= 'borrarUsuario.php?id=' . escapar($fila["user_id"]) ?>">🗑️Borrar</a>
                  <a href="<?= 'editarUsuario.php?id=' . escapar($fila["user_id"]) ?>">✏️Editar</a>
                </td>
              </tr>
          <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>

<?php include "../template/footer.php"; ?>