<?php
include '../funciones.php';
$config = include('../db.php');

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

$consultaSQL = "SELECT registros.idregistro, users.user_id, users.user_name, registros.idrecurso, recurso.recurso_nombre, DATE_FORMAT(registros.inicio_prestamo, '%d/%m %H:%i') AS inicio_prestamo, registros.opcion FROM registros inner join recurso on recurso.recurso_id = registros.idrecurso inner join users on registros.idusuario = users.user_id  where registros.opcion = 'Pending' LIMIT 1";
$sentencia = $conexion->prepare($consultaSQL);
$sentencia->execute();

$notificacion = $sentencia->fetch(PDO::FETCH_ASSOC);

// Si encontramos una notificación
if ($notificacion) {
    // Enviar la notificación como mensaje SSE
    echo "data: " . json_encode($notificacion) . "\n\n";
}

flush();
?>