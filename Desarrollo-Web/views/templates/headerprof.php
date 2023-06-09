<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <title>Presma</title>
  <link rel="stylesheet" href="views/templates/stylelog.css">
</head>

<body>
  <header class="p-3 bg-dark text-white">
    <div class="container" bis_skin_checked="1">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start" bis_skin_checked="1">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
            <use xlink:href="#bootstrap"></use>
          </svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href='/Desarrollo-Web/index.php' class="nav-link px-2 text-secondary">Inicio</a></li>
          <li><a href='netbook/visual.php' class="nav-link px-2 text-white">NetBooks</a></li>
          <li><a href="netbook/abmSanciones.php" class="nav-link px-2 text-white">Sanciones</a></li>
          <li><a href="/Desarrollo-Web/index.php?logout" class="nav-link px-2 text-white">Cerrar sesion</a></li>
        </ul>

        <div class="text-end" bis_skin_checked="1">
          <a href="#" class="btn btn-warning"><?php echo $_SESSION['user_name']; ?></a>
        </div>
      </div>
    </div>
  </header>
  <div class="cuerpo">
    <a href="netbook/abm.php" class="card">
      NetBooks
    </a>
  </div>
  <footer class="bg-light text-center text-lg-start">
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2023 Copyright:
      <a class="text-dark" href="https://mdbootstrap.com/">Presma</a>
    </div>
    <!-- Copyright -->
  </footer>
</body>

</html>