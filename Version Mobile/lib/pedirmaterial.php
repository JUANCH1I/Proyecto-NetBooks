<?php

	require 'conexion.php';
	header('Content-Type: application/json');
	$recurso_id = $_POST['recurso_id'];
	$idusuario = $_POST['idusuario'];
	$stmt = $db -> prepare("UPDATE `recurso` SET `recurso_estado` = '2' WHERE `recurso`.`recurso_id` = ?");
	$result = $stmt->execute([$recurso_id]);
	echo json_encode (["Success" => $result]);
	$stmt = $db -> prepare("INSERT INTO `registros`(`idusuario`, `recurso_id`, `opcion`) VALUES ('$idusuario',?,'Pending')");
	$result = $stmt->execute([$recurso_id]);
	echo json_encode (["Success" => $result]);
	
	
	

?>