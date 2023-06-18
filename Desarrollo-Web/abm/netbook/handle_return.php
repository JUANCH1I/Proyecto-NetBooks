<?php
$servername = "190.228.29.62";
$username = "bdwebet29";
$password = "Tecnica29!";
$dbname = "bdwebet29";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

$status = $_POST['status'];
$id = $_POST['id'];
$alumno = $_POST['alumno'];
$material = $_POST['material'];
$opcion = $_POST['opcion'];

// El ID del horario seleccionado.
$horario_id = $_POST['hora'];

// Obtén el horario correspondiente al ID del horario.
// Este es un ejemplo y es posible que necesites adaptarlo.
$query = "SELECT horario FROM horario WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $horario_id);
$stmt->execute();
$result = $stmt->get_result();
$horario = $result->fetch_assoc()["horario"];

// Convierte el horario a una cadena de fecha y hora en el formato correcto para MySQL.
// Obtiene el horario de inicio directamente de los datos POST.
$fecha_inicio = date('Y-m-d H:i:s', strtotime($_POST['hora_inicio']));

$query = "SELECT recurso_id FROM recurso WHERE recurso_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $material);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    if ($status == 'accepted') {
        $sql = "UPDATE pendiente SET opcion = 'Accepted' WHERE id = ?; INSERT INTO `registros`(`idusuario`, `inicio_prestamo`, `idrecurso`, `fin_prestamo`) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isii", $alumno, $fecha_inicio, $material, $horario_id);
    } else if ($status == 'denied') {
        $sql = "UPDATE pendiente SET opcion = 'Denied' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    }

    if ($stmt->execute() === TRUE) {
        echo "La devolución ha sido " . ($status == 'accepted' ? 'aceptada' : 'rechazada') . ".";
    } else {
        echo "Error al actualizar el estado de la devolución: " . $conn->error;
    }
} else {
    echo "El id del recurso proporcionado no es válido.";
}

$conn->close();
?>
