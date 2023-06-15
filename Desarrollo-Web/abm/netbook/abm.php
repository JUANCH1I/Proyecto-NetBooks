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

  $consultaSQL = "SELECT pendiente.id, users.user_name, recurso.recurso_nombre, CASE when pendiente.opcion=0 then 'Regresar' else 'Retirar' end as opciones, hora FROM pendiente inner join recurso on recurso.recurso_id = pendiente.idMaterial inner join users on pendiente.idAlumno = users.user_id  where pendiente.opcion = 'Pending' LIMIT 1";
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $notification = null;
  if ($sentencia->rowCount() > 0) {
    // Si hay una devolución pendiente, se almacenará en $notification
    $notification = $sentencia->fetch(PDO::FETCH_ASSOC);
  }

  if (isset($_POST['apellido'])) {
    $consultaSQL = "SELECT registros.idregistro, users.user_name, DATE_FORMAT(registros.inicio_prestamo, '%H:%i') AS inicio_prestamo, DATE_FORMAT(registros.fin_prestamo, '%H:%i') AS fin_prestamo, COALESCE(registros.fechas_extendidas, '----') AS fechas_extendidas, recurso.recurso_nombre FROM registros INNER JOIN users ON registros.idusuario = users.user_id INNER JOIN recurso ON recurso.recurso_id = registros.idrecurso;";
  } else {
    $consultaSQL = "SELECT registros.idregistro, users.user_name, DATE_FORMAT(registros.inicio_prestamo, '%H:%i') AS inicio_prestamo, DATE_FORMAT(registros.fin_prestamo, '%H:%i') AS fin_prestamo, COALESCE(registros.fechas_extendidas, '----') AS fechas_extendidas, recurso.recurso_nombre FROM registros INNER JOIN users ON registros.idusuario = users.user_id INNER JOIN recurso ON recurso.recurso_id = registros.idrecurso;";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumnos = $sentencia->fetchAll();
} catch (PDOException $error) {
  $error = $error->getMessage();
}

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
                <td><?php echo escapar($fila["inicio_prestamo"]); ?></td>
                <td><?php echo escapar($fila["fin_prestamo"]); ?></td>
                <td><?php echo escapar($fila["fechas_extendidas"]); ?></td>
                <td><?php echo escapar($fila["recurso_nombre"]); ?></td>
                <td>
                  <a href="<?= 'sancion.php?id=' . escapar($fila["idregistro"]) ?>">🗑️Borrar</a>
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
<div class="modal" tabindex="-1" role="dialog" id="returnNotificationModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Notificación de Peticion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p id="notificationMessage"><?php echo $notification['user_name'];?></p>  
      <p id="notificationMessage"><?php echo $notification['recurso_nombre'];?></p>
      <p id="notificationMessage"><?php echo $notification['opciones']; ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="acceptReturn">Aceptar</button>
        <button type="button" class="btn btn-danger" id="denyReturn">Rechazar</button>
      </div>
    </div>
  </div>
</div>



<?php include "../template/footer.php"; ?>