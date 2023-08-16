<?php

	require 'conexion.php';
	header('Content-Type: application/json');
	$recurso_id = $_POST['recurso_id'];
	$idusuario = $_POST['idusuario'];
	$fecha = $_POST['fecha'];
	$stmt = $db -> prepare("SELECT * FROM `registros` WHERE `idrecurso`='$recurso_id' AND (`devuelto` != 'Accepted' OR `opcion` = 'Pending')");
	$stmt->execute();
	$verif = $stmt->fetch();
	if($verif != null){

		echo json_encode ("Este material se encuentra reservado");
	}
	else{
	$stmt = $db -> prepare("UPDATE `recurso` SET `recurso_estado` = '2' WHERE `recurso`.`recurso_id` = ?");
	$stmt->execute([$recurso_id]);
	$stmt = $db -> prepare("INSERT INTO `registros`(`idusuario`, `idrecurso`, `inicio_prestamo`, `opcion`) VALUES ('$idusuario',?,'$fecha','Pending')");
	$stmt->execute([$recurso_id]);
	$result = "Material reservado con éxito";
	echo json_encode ($result);
	}
	
	
	
	

?>