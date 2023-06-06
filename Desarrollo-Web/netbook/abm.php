<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include('../config/db.php');


try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  if (isset($_POST['apellido'])) {
    $consultaSQL = "SELECT registros.idregistro, users.user_name, registros.periodo_de_prestamo, registros.fechas_extendidas, materiales.nombre from registros inner join users on registros.idusuario = users.user_id inner join materiales on materiales.idmaterial = registros.idmaterial";
  } else {
    $consultaSQL = "SELECT registros.idregistro, users.user_name, registros.periodo_de_prestamo, registros.fechas_extendidas, materiales.nombre from registros inner join users on registros.idusuario = users.user_id inner join materiales on materiales.idmaterial = registros.idmaterial";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumnos = $sentencia->fetchAll();
} catch (PDOException $error) {
  $error = $error->getMessage();
}

$titulo = isset($_POST['apellido']) ? 'Lista de prestamos (' . $_POST['apellido'] . ')' : 'Lista de alumnos';
?>

<?php include "template/header.php"; ?>

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
      <a href="../index.php" class="btn btn-primary mt-4">Volver al inicio</a>
      <a href="visual.php" class="btn btn-primary mt-4">Forma visual</a>
      <hr>

      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="apellido" name="apellido" placeholder="Buscar por alumno" class="form-control">
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
            <th>Alumno</th>
            <th>Periodo prestamo</th>
            <th>Fechas extendidas</th>
            <th>Material retirado</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($alumnos && $sentencia->rowCount() > 0) {
            foreach ($alumnos as $fila) {
          ?>
              <tr>
                <td><?php echo escapar($fila["registros.idregistro"]); ?></td>
                <td><?php echo escapar($fila["users.user_name"]); ?></td>
                <td><?php echo escapar($fila["registros.periodo_de_prestamo"]); ?></td>
                <td><?php echo escapar($fila["registros.fechas_extendidas"]); ?></td>
                <td><?php echo escapar($fila["materiales.nombre"]); ?></td>
                <td>
                  <a href="<?= 'sancion.php?id=' . escapar($fila["registros.idregistro"]) ?>">🗑️Borrar</a>
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

<?php include "template/footer.php"; ?>
