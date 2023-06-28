<?php
include '../funciones.php';
$config = include('../db.php');

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

$consultaSQL = "SELECT registros.idregistro, users.user_id, users.user_name, registros.idrecurso, recurso.recurso_nombre, DATE_FORMAT(registros.inicio_prestamo, '%d/%m %H:%i') AS inicio_prestamo, DATE_FORMAT(horario.horario, '%H:%i') AS horario, registros.devuelto FROM registros inner join recurso on recurso.recurso_id = registros.idrecurso inner join users on registros.idusuario = users.user_id inner join horario on horario.id = registros.fin_prestamo  where registros.devuelto = 'Pending' LIMIT 1";
$sentencia = $conexion->prepare($consultaSQL);
$sentencia->execute();

$notificacionDevolucion = $sentencia->fetch(PDO::FETCH_ASSOC);

// Si encontramos una notificación
if ($notificacionDevolucion) {
    // Enviar la notificación como mensaje SSE
    echo "data: " . json_encode($notificacionDevolucion) . "\n\n";
}

flush();
?>