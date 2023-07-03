$(document).ready(function() {
    // Delega el evento a un elemento padre, en este caso, document
    $(document).on('click', '.netbook', function() {
        var id = $(this).data('recurso_id');
        var nombre = $(this).data('recurso_nombre');
        var reservadoPor = $(this).data('reservado-por');
        var estado = $(this).data('recurso_estado');
        if (estado === 'En mantenimiento') {
            $('#modal-text').html('ID: ' + id + '<br>Nombre: ' + nombre + '<br>Esta netbook está en mantenimiento');
        } else if (estado === 'Ocupado') {
            $('#modal-text').html('ID: ' + id + '<br>Nombre: ' + nombre + '<br>Esta netbook fue reservada por ' + reservadoPor);
        } else {
            $('#modal-text').html('ID: ' + id + '<br>Nombre: ' + nombre + '<br>Esta netbook está libre');
        }
        
        $('#myModal').show();
    });

    $(document).on('click', '.close', function() {
        $('#myModal').hide();
    });
});
