<?php

include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'La ' . escapar($_POST['recurso_nombre']) . ' ha sido agregado con éxito'
  ];

  $config = include('../db.php');

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $recurso = [
      "recurso_id"   => $_POST['recurso_id'],
      "recurso_nombre"   => $_POST['recurso_nombre'],
      "recurso_estado"   => $_POST['recurso_estado'],
      "recurso_tipo"   => $_POST['recurso_tipo'],
    ];

    $consultaSQL = "INSERT INTO recurso (recurso_id, recurso_nombre, recurso_estado, recurso_tipo)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($recurso)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($recurso);
  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
require_once("../db.php");
$conexion = conexion();
$statement = $conexion->prepare("SELECT * FROM tipo_recurso");
$statement->execute();
$datos = $statement->fetchAll();
$statement2 = $conexion->prepare("SELECT * FROM estado");
$statement2->execute();
$datosestado = $statement2->fetchAll();
?>

<?php include '../template/header.php'; ?>

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
      <h2 class="mt-4">Agregar un material</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="recurso_id">Codigo del recuros</label>
          <input type="text" name="recurso_id" id="recurso_id" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="recurso_nombre">Nombre del recurso</label>
          <input type="text" name="recurso_nombre" id="recurso_nombre" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="recurso_estado">Estado</label>
          <select name="recurso_estado" id="recurso_estado" class="input" required>
          <option value="" disabled hidden selected >Estado</option>
            <?php foreach ($datosestado as $dato) : ?>
              <option value="<?= $dato['idEstado'] ?>" class="input"><?= $dato['descripcion_estado'] ?></option>
            <?php endforeach; ?>
          </select>
        </div><br>
        <div class="form-group">
          <label for="recurso_tipo">Material</label>
          <select name="recurso_tipo" id="recurso_tipo" class="input" required>
          <option value="" disabled hidden selected >Elegir un material</option>
            <?php foreach ($datos as $dato) : ?>
              <option value="<?= $dato['tipo_recurso_id'] ?>" class="input"><?= $dato['tipo_recurso_nombre'] ?></option>
            <?php endforeach; ?>
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

<?php include '../template/footer.php'; ?>