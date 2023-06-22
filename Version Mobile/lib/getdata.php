<?php
require 'conexion.php';
header('Content-Type: application/json');
$idusuario = $_POST['idusuario'];
$stmt = $db->prepare("SELECT idregistro, inicio_prestamo, fin_prestamo, fechas_extendidas, recurso_id FROM registros WHERE idusuario = ' $idusuario ';");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);

?>
