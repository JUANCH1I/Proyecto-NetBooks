<?php
include '../funciones.php';
$config = include('../db.php');

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

$consultaSQL = "SELECT registros.idregistro, users.user_name, DATE_FORMAT(registros.inicio_prestamo, '%d/%m %H:%i') AS inicio_prestamo, DATE_FORMAT(horario.horario, '%H:%i') AS fin_prestamo, COALESCE(registros.fechas_extendidas, '----') AS fechas_extendidas, recurso.recurso_nombre FROM registros INNER JOIN users ON registros.idusuario = users.user_id INNER JOIN recurso ON recurso.recurso_id = registros.idrecurso INNER JOIN horario ON horario.id = registros.fin_prestamo WHERE registros.opcion <> 'Pending' AND registros.devuelto <> 'Accepted' ORDER BY registros.idregistro desc ;";
$sentencia = $conexion->prepare($consultaSQL);
$sentencia->execute();

$alumnos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

echo "data: " . json_encode($alumnos) . "\n\n";

flush();
?>