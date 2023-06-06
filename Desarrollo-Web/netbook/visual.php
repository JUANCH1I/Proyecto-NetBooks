<?php
$host = 'localhost';
$db = 'login';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}

$error = false;
$config = include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['netbook_id'])) {
    $stmt = $pdo->prepare('UPDATE netbooks SET estado = "reservado", reservado_por = ? WHERE id = ?');
    $stmt->execute([$_POST['nombre'], $_POST['netbook_id']]);
}
$stmt = $pdo->query('SELECT * FROM netbooks ORDER BY id');
?>

<?php include "template/header.php"; ?>

<div class="colores">
    <div><div id="c1"></div><p>Libre</p></div>
    <div><div id="c2"></div><p>Reservado</p></div>
    <div><div id="c3"></div><p>Mantenimiento</p></div>
</div>
<div style='display: flex; justify-content:center;'>
    <div style='display: flex; flex-wrap: wrap; width: 500px;'>
        <?php
        while ($row = $stmt->fetch()) {
            $color = $row['estado'] == 'libre' ? '#d4edda' : ($row['estado'] == 'reservado' ? '#f8d7da' : '#ffeeba');
            $reservadoPor = $row['reservado_por'];
            echo "<div class='netbook' data-reservado-por='$reservadoPor' style='background-color: {$color}; width: 50px; height: 50px; margin: 10px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.15); display: flex; justify-content: center; align-items: center;'>";
            echo "<img src='netbook.png' alt='Netbook' style='width: 50%;'>";
            echo "</div>";
        }
        ?>
    </div>
    <div id='myModal' class='modal'>
        <div class='modal-content'>
            <span class='close'>&times;</span>
            <p id='modal-text'>Some text in the Modal..</p>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>