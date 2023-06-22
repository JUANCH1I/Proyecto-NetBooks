<?php
require 'conexion.php';
header('Content-Type: application/json');
$messages;
$errors;
$user_name = $_POST['user_name'];
$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];
$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

$query_check_user = $db->prepare("SELECT COUNT(*) FROM users WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';");
$query_check_user->execute();
if ($query_check_user->fetchColumn() == 1){
    $errors = "Este nombre de usuario/email ya estan en uso.";
    echo json_encode($errors);
}
else {
    $query_new_user_insert = $db->prepare("INSERT INTO users (`user_name`, `user_password_hash`, `user_email`,`idRol` ) VALUES ('$user_name','$user_password_hash','$user_email','1')");
    $query_new_user_insert->execute();
    if ($query_new_user_insert->rowCount() == 1) {
        $messages = "Tu cuenta ya fue creada. Ya puedes iniciar sesion.";
        echo json_encode($messages);
    } else {
        $errors = "Perdon, tu registracion fallo. Porfavor intentalo devuelta.";
        echo json_encode($errors);
    }
}

?>