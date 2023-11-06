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
      if (window.location.href.indexOf("abm.php") > -1) {
        <?php if (!empty($notification)) { ?>
          $('#returnNotificationModal').modal('show');
        <?php } ?>

        <?php if (!empty($notificacionDevolucion)) { ?>
          $('#returnDevolucionModal').modal('show');
        <?php } ?>


        $('#acceptReturn').click(function() {
          if ($('#horario').val() == null || $('#horario').val() == '') {
            alert('Por favor, elija un horario.');
          } else {
            handleReturn('accepted');
          }
        });

        $('#denyReturn').click(function() {
          handleReturn('denied');
        });
        $('#acceptDevolucion').click(function() {
          handleDevolucion('accepted');
        });

        $('#denyDevolucion').click(function() {
          handleDevolucion('denied');
        });

        let isModalOpen = false;
        let notificationId;
        let notificacionIddev;

        $('#returnNotificationModal').on('shown.bs.modal', function() {
          isModalOpen = true;
        });

        $('#returnNotificationModal').on('hidden.bs.modal', function() {
          isModalOpen = false;
        });

        $('#returnDevolucionModal').on('shown.bs.modal', function() {
          if (!isModalOpen) {
            isModalOpen = true;
          } else {
            $('#returnDevolucionModal').modal('hide');
          }
        });

        $('#returnDevolucionModal').on('hidden.bs.modal', function() {
          isModalOpen = false;
        });

        let userLink = document.querySelectorAll('.user_link');

        userLink.forEach(function(link) {
          link.addEventListener('click', function(event) {
            event.preventDefault();

            $('#userModal').modal('show');
          })
        })

        function handleReturn(status) {
          $.ajax({
            url: 'handle_return.php',
            type: 'POST',
            data: {
              status: status,
              id: notificationId, // Cambia esta línea para usar notificationId
              hora: $('#horario').val()
            },
            success: function(response) {
              $('#notificationMessage').text(response);
              $('#acceptReturn, #denyReturn').hide();
            },
            error: function(error) {
              alert('Hubo un error al manejar la devolución. Por favor, inténtalo de nuevo.');
            }
          });
        }

        function abrirModalConNombre(userName) {
          $.ajax({
            url: 'getUserLast.php', // Asegúrate de que esta es la ruta correcta a tu script PHP
            type: 'GET',
            dataType: 'json',
            data: {
              user_name: userName
            },
            success: function(data) {
              if (data.error) {
                alert('Error: ' + data.error);
              } else {
                var html = crearHTMLConPrestamos(data);
                $('#userModal .modal-body').html(html);
                $('#userModal').modal('show');
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error al obtener los datos: ' + textStatus);
            }
          });
        }

        function crearHTMLConPrestamos(data) {
          var html = '<table class="table">';
          html += `
    <thead>
      <tr>
        <th>Nombre del Recurso</th>
        <th>Inicio del Préstamo</th>
        <th>Fin del Préstamo</th>
        <th>Fechas Extendidas</th>
      </tr>
    </thead>
    <tbody>
  `;

          data.forEach(function(prestamo) {
            html += `
      <tr>
        <td>${escaparHTML(prestamo.recurso_nombre)}</td>
        <td>${escaparHTML(prestamo.inicio_prestamo)}</td>
        <td>${escaparHTML(prestamo.horario)}</td>
        <td>${escaparHTML(prestamo.fechas_extendidas || 'N/A')}</td>
      </tr>
    `;
          });

          html += '</tbody></table>';
          return html;
        }



        // Función auxiliar para escapar caracteres especiales de HTML y prevenir inyecciones XSS
        function escaparHTML(str) {
          return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
        }


        function handleDevolucion(status) {
          $.ajax({
            url: 'handle_devolucion.php',
            type: 'POST',
            data: {
              status: status,
              id: notificationIddev,
            },
            success: function(response) {
              $('#devolucionMessage').text(response);
              $('#acceptDevolucion, #denyDevolucion').hide();
            },
            error: function(error) {
              alert('Hubo un error al manejar la devolución. Por favor, inténtalo de nuevo.');
            }
          });
        }

        const source = new EventSource('actualizar.php');
        source.onmessage = function(event) {
          const alumnos = JSON.parse(event.data);
          let html = '';
          alumnos.forEach(alumno => {
            html += generarFilaDeTabla(alumno);
          });
          document.getElementById('cuerpoDeTabla').innerHTML = html;

          // Reasigna los manejadores de eventos a los enlaces .user_link después de la actualización
          $('.user_link').off('click').on('click', function(e) {
            e.preventDefault();
            var userName = $(this).data('username');
            abrirModalConNombre(userName); // Llama a la función para abrir el modal con el nombre del usuario
          });
        };

        function generarFilaDeTabla(alumno) {
          return `
      <tr>
        <td>${escaparHTML(alumno.idregistro)}</td>
        <td><a href="#" class="user_link" data-username="${escaparHTML(alumno.user_name)}">${escaparHTML(alumno.user_name)}</a></td>
        <td>${escaparHTML(alumno.inicio_prestamo)}</td>
        <td>${escaparHTML(alumno.fin_prestamo)}</td>
        <td>${escaparHTML(alumno.fechas_extendidas)}</td>
        <td>${escaparHTML(alumno.recurso_nombre)}</td>
      </tr>
    `;
        }

        let sourceModal = new EventSource('actualizarModal.php');

        sourceModal.onmessage = function(event) {
          const notificacion = JSON.parse(event.data);

          // Comprobar si el modal está abierto
          if (!isModalOpen && notificacion) {
            // Actualizar el contenido del modal
            document.getElementById('notificationMessageUser').textContent = 'Alumno: ' + notificacion.user_name;
            document.getElementById('notificationMessageResource').textContent = 'Material: ' + notificacion.recurso_nombre;
            document.getElementById('notificationMessageStart').textContent = 'Horario inicio: ' + notificacion.inicio_prestamo;

            notificationId = notificacion.idregistro; // Agrega esta línea para almacenar el id de la notificación

            $('#acceptReturn, #denyReturn').show();

            // Abrir el modal
            $('#returnNotificationModal').modal('show');
          }
        };
        let sourceDevolucion = new EventSource('actualizarDevolucion.php');

        sourceDevolucion.onmessage = function(event) {
          const notificacionDevolucion = JSON.parse(event.data);

          // Comprobar si el modal está abierto
          if (!isModalOpen && notificacionDevolucion) {
            // Actualizar el contenido del modal
            document.getElementById('devolucionMessageUser').textContent = 'Alumno: ' + notificacionDevolucion.user_name;
            document.getElementById('devolucionMessageResource').textContent = 'Material: ' + notificacionDevolucion.recurso_nombre;
            document.getElementById('devolucionMessageStart').textContent = 'Horario inicio: ' + notificacionDevolucion.inicio_prestamo;
            document.getElementById('devolucionMessageEnd').textContent = 'Horario final: ' + notificacionDevolucion.horario;

            notificationIddev = notificacionDevolucion.idregistro; // Agrega esta línea para almacenar el id de la notificación

            $('#acceptDevolucion, #denyDevolucion').show();

            // Abrir el modal
            $('#returnDevolucionModal').modal('show');
          }
        };
      };
    });
  </script>


  <style>
    .img>img {
      margin-right: 5px;
    }

    footer {
      width: 100%;
      position: fixed;
      bottom: 0;
    }
  </style>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="../template/logofinal.png" type="image/png">
  <title>Presma</title>
</head>

<body>
  <header class="p-3 bg-dark text-white">
    <div class="container" bis_skin_checked="1">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start" bis_skin_checked="1">
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href='../../index.php' class="nav-link px-2 text-secondary">Inicio</a></li>
          <li><a href='../netbook/abm.php' class="nav-link px-2 text-white">Prestamos</a></li>
          <?php
          if (isset($_SESSION['user_rol'])) {
            if ($_SESSION['user_rol'] == 5) {
              echo '<li><a href="../abmPersonas/abmPersonas.php" class="nav-link px-2 text-white">Usuarios</a></li>';
              echo '<li><a href="../netbook/qr.php" class="nav-link px-2 text-white">Recursos</a></li>';
            }
          } ?>
          <li><a href="/Desarrollo-Web/index.php?logout" class="nav-link px-2 text-white">Cerrar sesion</a></li>
        </ul>

        <div class="text-end" bis_skin_checked="1">
          <a href="#" class="btn btn-warning">
            <?php echo $_SESSION['user_name']; ?>
          </a>
        </div>
      </div>
    </div>
  </header>