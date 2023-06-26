<?php

	require 'conexion.php';
	header('Content-Type: application/json');
	$recurso_id = $_POST['recurso_id'];
	
	$stmt = $db -> prepare("UPDATE `recurso` SET `recurso_estado` = '1' WHERE `recurso`.`recurso_id` = ?");
	$result = $stmt->execute([$recurso_id]);
	echo json_encode (["Success" => $result]);

	

?>