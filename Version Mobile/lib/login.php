<?php

    include 'conexion.php';
    
    $user_login_status;
    $idusuario;
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $login_check = $db->prepare("SELECT COUNT(*)  FROM users WHERE user_email = '$user_email';");
    $login_check->execute();
            if ($login_check->fetchColumn() == 1) {
                $password_check = $db->prepare("SELECT `user_id`, `user_name`, `user_password_hash`, `user_email`, `idRol` FROM `users` WHERE user_email = '$user_email';");
                $password_check -> execute();
                $result_row = $password_check->fetch(PDO::FETCH_ASSOC);
                if(password_verify($user_password, $result_row['user_password_hash'])){

                        $user_id = $result_row['user_id'];
                        $_SESSION['user_login_status'] = 1;
                        $logindata = array(['idusuario' => strval($user_id),'user_login_status' => '1',]);
         
                        echo json_encode($logindata);
                    }
                    else{
                        $error[] = 'Contraseña incorrecta';
                        echo json_encode($error);
                    }
                }
                else
                    {
                        $error[] = 'Email incorrecto';
                        echo json_encode($error);
                    }
                
                        // write user data into PHP SESSION (a file on your server)
                
            


    ?>