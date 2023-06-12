<?php

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El alumno ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito'
  ];

  $config = include('../config/db.php');

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $sancion = [
      "user_name"   => $_POST['nombre'],
      "user_email" => $_POST['email'],
      "user_dni"  => $_POST['dni'],
      "idRol"    => $_POST['rol'],
      "activado"     => $_POST['activado'],
    ];

    $consultaSQL = "INSERT INTO sanciones (idusuario, motivo, periodo)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($sancion)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($sancion);
  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include 'template/header.php'; ?>

<?php
if (isset($resultado)) {
?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
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
      <h2 class="mt-4">Crear una sancion</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">email</label>
          <input type="text" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
          <label for="dni">Dni</label>
          <input type="text" name="dni" id="dni" class="form-control">
        </div>
        <br>
        <div class="form-group">
          <label for="activado">Activado</label>
          <select name="activado" id="activado">
            <option value="1" class="input">Si</option>
            <option value="0" class="input">No</option>
          </select>
        </div>
        <br>
        <div class="form-group">
          <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="abm.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>