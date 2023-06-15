<?php
include '../funciones.php';
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}
include "../template/header.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluye la biblioteca
include('phpqrcode/qrlib.php'); 

$idnet = $_GET['id'];
    $nombre = $_GET['nombre'];
    // Genera un identificador único para el nombre del archivo
    $filePath = 'qrcodes/qrcode_' . $nombre . '.png';
    QRcode::png($idnet, $filePath);
    echo 'Código QR generado exitosamente!';
?>
<br>
<img src="<?php echo $filePath; ?>" alt="" height="500px" width="500px" style="c"><br>
<a href="./qr.php" class="btn btn-primary mt-4">Volver al inicio</a>
<?php include "../template/footer.php"; ?>