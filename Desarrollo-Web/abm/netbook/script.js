$(document).ready(function() {
    $('.netbook').click(function() {
        var id = $(this).data('recurso_id');
        var nombre = $(this).data('recurso_nombre');
        var reservadoPor = $(this).data('reservado-por');
        var estado = $(this).data('recurso_estado');
        if (estado === 3) {
            $('#modal-text').html('ID: ' + id + '<br>Nombre: ' + nombre + '<br>Esta netbook está en mantenimiento');
        } else if (estado === 2) {
            $('#modal-text').html('ID: ' + id + '<br>Nombre: ' + nombre + '<br>Esta netbook fue reservada por ' + reservadoPor);
        } else {
            $('#modal-text').html('ID: ' + id + '<br>Nombre: ' + nombre + '<br>Esta netbook está libre');
        }
        $('#myModal').show();
    });

    $('.close').click(function() {
        $('#myModal').hide();
    });
});
