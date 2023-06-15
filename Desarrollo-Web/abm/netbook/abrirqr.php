<?php
$nombreImagen = 'qrcodes/miimagen.png'; // Ruta relativa a la imagen

header('Content-Type: image/png'); // Establecer el tipo de contenido como imagen/png

readfile($nombreImagen); // Leer y mostrar el contenido de la imagen
?>
