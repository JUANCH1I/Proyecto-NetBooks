<?php
try {
    include '../funciones.php';
    $config = include('../db.php');

    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $stmt = $conexion->query('SELECT * FROM recurso WHERE recurso_tipo = 1 ORDER BY recurso_id desc');

    $recursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode(['recursos' => $recursos]);
} catch (Exception $e) {
    // Esto enviará una respuesta con un código de estado 500 y el mensaje de error
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
