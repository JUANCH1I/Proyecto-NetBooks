<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
  if ($login->errors) {
    foreach ($login->errors as $error) {
      echo $error;
    }
  }
  if ($login->messages) {
    foreach ($login->messages as $message) {
      echo $message;
    }
  }
}
?>

<!-- login form box -->
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="views\estilo.css">
  <link rel="icon" href="views/templates/logofinal.png" type="image/png">
  <title>Inico de sesion</title>
</head>

<body>
  <div id="formulario">
    <form class="form card" method="post" action="index.php" name="loginform">
      <div class="card_header">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
          <path fill="none" d="M0 0h24v24H0z"></path>
          <path fill="currentColor" d="M4 15h2v5h12V4H6v5H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6zm6-4V8l5 4-5 4v-3H2v-2h8z"></path>
        </svg>
        <h1 class="form_heading">Iniciar sesion</h1>
      </div>
      <div class="field">
        <label for="username">Usuario</label>
        <input class="input" name="user_name" type="text" placeholder="NombreApellido" id="username" required>
      </div>
      <div class="field">
        <label for="password">Contraseña</label>
        <input class="input" name="user_password" type="password" placeholder="Contraseña" id="password" required>
      </div>
      <div class="field">
        <input type="submit" name="login" value="Iniciar sesion" id="submit" class="input" />
      </div>
      <div class="field" id="op">
      <a href="cambio_contraseña.php" id="back">He olvido mi contraseña</a>
      <a href="register.php" id="back">Registrar una nueva cuenta</a>
      </div>
  </div>
  </form>
</body>

</html>