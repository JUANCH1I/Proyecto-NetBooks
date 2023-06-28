<?php
try {
    include '../funciones.php';
    $config = include('../db.php');

    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $stmt = $pdo->query("
    SELECT 
        recurso.*, 
        IF(
            (SELECT registros.opcion 
             FROM registros 
             WHERE registros.idrecurso = recurso.recurso_id 
             ORDER BY inicio_prestamo DESC LIMIT 1) = 'Accepted' 
            AND 
            (SELECT registros.devuelto 
             FROM registros 
             WHERE registros.idrecurso = recurso.recurso_id 
             ORDER BY inicio_prestamo DESC LIMIT 1) = 0, 
            'Reservado', 
            'Libre'
        ) as recurso_estado, 
        (SELECT users.user_name 
         FROM registros 
         JOIN users ON registros.idusuario = users.user_id 
         WHERE registros.idrecurso = recurso.recurso_id 
         ORDER BY inicio_prestamo DESC LIMIT 1) as user_name 
    FROM recurso 
    WHERE recurso.recurso_tipo = 1
    ORDER BY recurso.recurso_id
");
    $recursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode(['recursos' => $recursos]);
} catch (Exception $e) {
    // Esto enviará una respuesta con un código de estado 500 y el mensaje de error
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
