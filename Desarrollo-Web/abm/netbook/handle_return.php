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

// Aquí debes obtener el ID de la devolución que estás manejando.
// Este es solo un ejemplo y es probable que necesites adaptarlo a tu lógica de negocio.
$id = $_POST['id'];
$alumno = $_POST['alumno'];
$material = $_POST['idMaterial'];
$opcion = $_POST['opcion'];

if ($status == 'accepted') {
  $sql = "UPDATE pendiente SET opcion = 'Accepted' WHERE id = $id";
  $sql = "INSERT INTO `registros`(`idusuario`, `inicio_prestamo`, `fechas_extendidas`, `idrecurso`, `fin_prestamo`) VALUES ('','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]') ";
} else if ($status == 'denied') {
  $sql = "UPDATE pendiente SET opcion = 'Denied' WHERE id = $id";
}

if ($conn->query($sql) === TRUE) {
  echo "La devolución ha sido " . ($status == 'accepted' ? 'aceptada' : 'rechazada') . ".";
} else {
  echo "Error al actualizar el estado de la devolución: " . $conn->error;
}

$conn->close();