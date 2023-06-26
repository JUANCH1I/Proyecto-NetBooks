<?php
require 'conexion.php';
header('Content-Type: application/json');
$idusuario = $_POST['idusuario'];
$stmt = $db->prepare("SELECT user_id, user_name, user_email, idRol, user_password_hash  FROM users WHERE user_id = '" . $idusuario . "';");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);

?>