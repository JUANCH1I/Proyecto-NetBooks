<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  // si el usuario no está conectado, redirigir a la página de inicio de sesión
  header("Location: not_logged_in.php");
  exit;
}

if (isset($_POST['submit'])) {
  // Comprueba si las contraseñas son iguales
  if ($_POST['nueva_contrasena'] !== $_POST['confirmar_contrasena']) {
    die('Las contraseñas no coinciden.');
  }

  $config = include '../config/db.php';
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $nueva_contrasena = $_POST['nueva_contrasena'];
  $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

  // Actualiza la contraseña del usuario
  $consultaSQL = "UPDATE users SET user_password_hash = :password WHERE user_id = :id";
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute(['password' => $nueva_contrasena_hash, 'id' => $_SESSION['user_id']]);

  // Actualiza la tabla user_security para indicar que el usuario ya no necesita cambiar la contraseña
  $consultaSQL = "UPDATE user_security SET must_change_password = FALSE WHERE user_id = :user_id";
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute(['user_id' => $_SESSION['user_id']]);

  // Redirecciona al usuario a donde sea necesario
  header("Location: ../index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <title>Presma</title>
  <link rel="icon" href="views/templates/logofinal.png" type="image/png">
  <link rel="stylesheet" href="templates/stylelog.css">
</head>

<body>
  <header class="p-3 bg-dark text-white">
    <div class="container" bis_skin_checked="1">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start" bis_skin_checked="1">
        <div class="text-end" bis_skin_checked="1">
          <a href="#" class="btn btn-warning"><?php echo $_SESSION['user_name']; ?></a>
        </div>
      </div>
    </div>
  </header>
  <div class="container" style="display: flex; height: 100%; justify-content:center; align-items: center;">
    <div class="row" style="width: 50vw;">
      <div class="col-md-12">
        <h2 class="mt-4">Cambia tu contraseña</h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nueva_contrasena">Nueva contraseña</label>
            <input type="password" name="nueva_contrasena" id="nueva_contrasena" class="form-control">
          </div>
          <div class="form-group">
            <label for="confirmar_contrasena">Confirma tu nueva contraseña</label>
            <input type="password" name="confirmar_contrasena" id="confirmar_contrasena" class="form-control">
          </div>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Cambiar contraseña">
          </div>
        </form>
      </div>
    </div>
  </div>
  <footer class="bg-light text-center text-lg-start" style="position: fixed; bottom: 0px; width:100%;">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2023 Copyright:
            <a class="text-dark" href="https://mdbootstrap.com/">Presma</a>
        </div>
        <!-- Copyright -->
    </footer>
</body>

</html>
