$(document).ready(function() {
    $('.netbook').click(function() {
        var reservadoPor = $(this).data('reservado-por');
        var estado = $(this).data('estado');
        if (estado === 'mantenimiento') {
            $('#modal-text').text('Esta netbook está en mantenimiento');
        } else if (reservadoPor) {
            $('#modal-text').text('Esta netbook fue reservada por ' + reservadoPor);
        } else {
            $('#modal-text').text('Esta netbook está libre');
        }
        $('#myModal').show();
    });

    $('.close').click(function() {
        $('#myModal').hide();
    });
});
