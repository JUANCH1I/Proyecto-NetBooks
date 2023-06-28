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
    $consultaSQL = "SELECT registros.idregistro, users.user_name, DATE_FORMAT(registros.inicio_prestamo, '%d/%m %H:%i') AS inicio_prestamo, DATE_FORMAT(horario.horario, '%H:%i') AS fin_prestamo, COALESCE(registros.fechas_extendidas, '----') AS fechas_extendidas, recurso.recurso_nombre FROM registros INNER JOIN users ON registros.idusuario = users.user_id INNER JOIN recurso ON recurso.recurso_id = registros.idrecurso INNER JOIN horario ON horario.id = registros.fin_prestamo WHERE registros.opcion <> 'Pending' and registros.devuelto = 1 ORDER BY registros.idregistro desc;";
  } else {
    $consultaSQL = "SELECT registros.idregistro, users.user_name, DATE_FORMAT(registros.inicio_prestamo, '%d/%m %H:%i') AS inicio_prestamo, DATE_FORMAT(horario.horario, '%H:%i') AS fin_prestamo, COALESCE(registros.fechas_extendidas, '----') AS fechas_extendidas, recurso.recurso_nombre FROM registros INNER JOIN users ON registros.idusuario = users.user_id INNER JOIN recurso ON recurso.recurso_id = registros.idrecurso INNER JOIN horario ON horario.id = registros.fin_prestamo WHERE registros.opcion <> 'Pending' and registros.devuelto = 1 ORDER BY registros.idregistro desc ;";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumnos = $sentencia->fetchAll();
} catch (PDOException $error) {
  $error = $error->getMessage();
}
$conexion = conexion();
$statement = $conexion->prepare("SELECT id, DATE_FORMAT(horario, '%H:%i') AS horario FROM horario");
$statement->execute();
$datos = $statement->fetchAll();
$titulo = isset($_POST['apellido']) ? 'Lista de prestamos (' . $_POST['apellido'] . ')' : 'Lista de alumnos';
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
      <a href="/Desarrollo-Web/index.php" class="btn btn-primary mt-4">Volver al inicio</a>
      <a href="agregarMaterial.php" class="btn btn-primary mt-4">Agregar material</a>
      <a href="visual.php" class="btn btn-primary mt-4">Forma visual</a>
      <a href="abm.php" class="btn btn-primary mt-4">Ver activos</a>
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
      <h2 class="mt-3">
        <?= $titulo ?>
      </h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Alumno</th>
            <th>Inicio prestamo</th>
            <th>Fin prestamo</th>
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
                <td><?php echo escapar($fila["idregistro"]); ?></td>
                <td><?php echo escapar($fila["user_name"]); ?></td>
                <td><?php echo escapar(($fila["inicio_prestamo"])); ?></td>
                <td><?php echo escapar($fila["fin_prestamo"]); ?></td>
                <td><?php echo escapar($fila["fechas_extendidas"]); ?></td>
                <td><?php echo escapar($fila["recurso_nombre"]); ?></td>
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