<?php
include '../funciones.php';
$config = include '../db.php';

// Asegúrate de que el archivo db.php contiene la estructura correcta para $config.
$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'] . ';charset=utf8mb4';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
// Asegúrate de que esta es una solicitud AJAX
if (isset($_GET['user_name']) && !empty($_GET['user_name'])) {
    $user_name = $_GET['user_name'];

    try {
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        $consultaSQL = "SELECT registros.idregistro, users.user_name, recurso.recurso_nombre, 
                        DATE_FORMAT(registros.inicio_prestamo, '%d/%m %H:%i') AS inicio_prestamo, 
                        DATE_FORMAT(horario.horario, '%H:%i') AS horario,
                        COALESCE(registros.fechas_extendidas, '----') AS fechas_extendidas 
                        FROM registros 
                        INNER JOIN users ON registros.idusuario = users.user_id 
                        inner join horario on horario.id = registros.fin_prestamo
                        INNER JOIN recurso ON recurso.recurso_id = registros.idrecurso 
                        WHERE users.user_name = :user_name 
                        ORDER BY registros.inicio_prestamo DESC 
                        LIMIT 5";

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':user_name', $user_name, PDO::PARAM_INT);
        $sentencia->execute();

        $prestamosUsuario = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        // Aquí puedes incluir un archivo de plantilla que genere el HTML
        // que será insertado en el modal, o simplemente generar el HTML directamente.
        header('Content-Type: application/json');
        echo json_encode($prestamosUsuario);
    } catch (PDOException $error) {
        // En producción, no deberías exponer detalles del error
        echo json_encode(['error' => 'Error al obtener los préstamos del usuario.']);
    }
} else {
    echo json_encode(['error' => 'No se proporcionó ID de usuario.']);
}
