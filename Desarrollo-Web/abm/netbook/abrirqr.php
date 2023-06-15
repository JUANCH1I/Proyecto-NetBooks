<?php
$nombre = $_GET['nombre'];
$nombreImagen = 'qrcodes/qrcode_' . $nombre . '.png'; // Ruta relativa a la imagen

header('Content-Type: image/png'); // Establecer el tipo de contenido como imagen/png

readfile($nombreImagen); // Leer y mostrar el contenido de la imagen
?>
