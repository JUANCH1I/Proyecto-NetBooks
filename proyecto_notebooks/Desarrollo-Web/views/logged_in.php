<?php
require_once("config/db.php");
function escapar($html)
{
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

$conexion = conexion();
$sql = "SELECT idRol FROM users WHERE user_name= '" . $_SESSION['user_name'] . "';";
$sentencia = $conexion->prepare($sql);
$sentencia->execute();
$alumnos = $sentencia->fetchAll();
foreach ($alumnos as $fila) {
    $_SESSION["rol"] = escapar($fila["idRol"]);
}

switch ($_SESSION['rol']) {
    case 1:
        require_once("templates/headeralu.php");
        break;

    case 2:
        require_once("templates/headerprof.php");
        break;
    case 3:
        require_once("templates/headerreg.php");
        break;

    case 4:
        require_once("templates/header.php");
        break;

    case 5:
        require_once("templates/headeradm.php");
        break;
}
