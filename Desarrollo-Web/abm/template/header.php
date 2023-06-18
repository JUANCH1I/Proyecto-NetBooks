<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="script.js"></script>
  <script>
    $(document).ready(function() {

      <?php if (!empty($notification)) { ?>
        $('#returnNotificationModal').modal('show');
      <?php } ?>

      $('#acceptReturn').click(function() {
        handleReturn('accepted');
      });

      $('#denyReturn').click(function() {
        handleReturn('denied');
      });

      function handleReturn(status) {
        $.ajax({
          url: 'handle_return.php',
          type: 'POST',
          data: {
            status: status,
            id: '<?php echo $notification['id']; ?>',
            alumno: '<?php echo $notification['user_id']; ?>',
            material: '<?php echo $notification['idMaterial']; ?>',
            opcion: '<?php echo $notification['opciones']; ?>',
            hora_inicio: $('#hora_inicio').val(), // nuevo campo
            hora_final: $('#horario').val() // nuevo campo
          },
          error: function(error) {
            alert('Hubo un error al manejar la devolución. Por favor, inténtalo de nuevo.');
          }
        });
      }
    });
  </script>


  <style>
    footer {
      width: 100%;
      position: absolute;
      bottom: 0;
    }
  </style>
  <link rel="stylesheet" href="style.css">
  <title>Presma</title>
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
          <li><a href="/Desarrollo-Web/index.php" class="nav-link px-2 text-secondary">Inicio</a></li>
          <li><a href='../abmPersonas/abmPersonas.php' class="nav-link px-2 text-white">Usuarios</a></li>
          <li><a href="../netbook/abm.php" class="nav-link px-2 text-white">NetBooks</a></li>
          <li><a href="../netbook/qr.php" class="nav-link px-2 text-white">Generar Qr</a></li>
          <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
          <li><a href="/Desarrollo-Web/index.php?logout" class="nav-link px-2 text-white">Cerrar sesion</a></li>
        </ul>

        <div class="text-end" bis_skin_checked="1">
          <a href="#" class="btn btn-warning"><?php echo $_SESSION['user_name']; ?></a>
        </div>
      </div>
    </div>
  </header>