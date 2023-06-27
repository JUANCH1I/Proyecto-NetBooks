<?php

	require 'conexion.php';
	header('Content-Type: application/json');
	$recurso_id = $_POST['recurso_id'];
	$stmt = $db -> prepare("SELECT `idregistro` FROM registros WHERE `idrecurso`=? AND `opcion`='Accepted' AND `devuelto` != 'Accepted'");
	$stmt->execute([$recurso_id]);
	$resultado = $stmt->fetch();
	
	if($resultado != null){
	$idregistro = $resultado['idregistro'];
	$stmt = $db -> prepare("UPDATE `recurso` SET `recurso_estado` = '1' WHERE `recurso_id` = ?");
	$stmt->execute([$recurso_id]);
	$stmt = $db -> prepare("UPDATE `registros` SET `devuelto` ='Pending' WHERE `idrecurso` ='$recurso_id' AND `registros`.`idregistro`='$idregistro'");
	$stmt->execute();
	$result = "Material devuelto";
	echo json_encode ($result);
	}
	else{
		$result = "Este material no fue reservado previamente o no se confirmó su reserva";
		echo json_encode ($result);
	}
	

	

?>