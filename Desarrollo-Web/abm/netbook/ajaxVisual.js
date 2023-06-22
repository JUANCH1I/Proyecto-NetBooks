$(document).ready(function() {

    setInterval(function() {
      $.ajax({
        url: 'actualizarVisual.php',
        type: 'GET',
        dataType: 'json', // <-- Asegúrate de tener esto
        success: function(data) {
            let recursos = data.recursos; // No necesitas parsear ya que dataType es 'json'
            let recursosHtml = '';
            recursos.forEach(recurso => {
                recursosHtml += generarRecursosDiv(recurso);
            });
            document.getElementById('netbookContainer').innerHTML = recursosHtml;
        },
        error: function(xhr, status, error) {
            if (xhr.status === 500) {
              alert('Hubo un error en el servidor: ' + xhr.responseJSON.error);
            } else {
              alert('Hubo un error al actualizar la información. Por favor, inténtalo de nuevo.');
            }
          }          
      });
    }, 10000);  

    function generarRecursosDiv(recurso) {
          const color = recurso.recurso_estado == 1 ? '#d4edda' : (recurso.recurso_estado == 2 ? '#f8d7da' : '#ffeeba');
          return `
          <div class='netbook'  style='background-color: ${color}; width: 50px; height: 50px; margin: 10px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.15); display: flex; justify-content: center; align-items: center;'>
              <img src='netbook.png' alt='Netbook' style='width: 50%;'>
          </div>
          `;
    }
    
});
