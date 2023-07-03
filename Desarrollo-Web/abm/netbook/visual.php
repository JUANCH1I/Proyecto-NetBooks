<?php
$host = '190.228.29.62';
$db = 'bdwebet29';
$user = 'bdwebet29';
$pass = 'Tecnica29!';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}

$error = false;
$config = include('../db.php');

$stmt = $pdo->query("
SELECT 
recurso.*, 
IF(
    (registros.opcion = 'Accepted' AND registros.devuelto IN ('Denied', 'Pending')), 
    'Ocupado', 
    'Libre'
) as recurso_estado, 
IF(
    (registros.opcion = 'Accepted' AND registros.devuelto IN ('Denied', 'Pending')), 
    users.user_name, 
    'N/A'
) as user_name
FROM recurso 
LEFT JOIN registros 
ON recurso.recurso_id = registros.idrecurso 
AND registros.idregistro = (
    SELECT MAX(idregistro) 
    FROM registros AS r
    WHERE r.idrecurso = recurso.recurso_id
)
LEFT JOIN users 
ON registros.idusuario = users.user_id 
ORDER BY recurso.recurso_id
");






?>

<?php include "../template/header.php"; ?>

<div class="colores">
    <div>
        <div id="c1"></div>
        <p>Libre</p>
    </div>
    <div>
        <div id="c2"></div>
        <p>Reservado</p>
    </div>
    <div>
        <div id="c3"></div>
        <p>Mantenimiento</p>
    </div>
</div>
<div style='display: flex; justify-content:center;'>
    <div id="netbookContainer" style='display: flex; flex-wrap: wrap; width: 500px;'>
        <?php
        while ($row = $stmt->fetch()) {
            $color = $row['recurso_estado'] == 'Libre' ? '#d4edda' : '#f8d7da';
            echo "<div class='netbook' 
                     data-recurso_id='{$row['recurso_id']}' 
                     data-recurso_nombre='{$row['recurso_nombre']}' 
                     data-recurso_estado='{$row['recurso_estado']}' 
                     data-reservado-por='{$row['user_name']}' 
                     style='background-color: {$color}; width: 50px; height: 50px; margin: 10px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.15); display: flex; justify-content: center; align-items: center;'>
                    <img src='netbook.png' alt='Netbook' style='width: 50%;'>
                    <p>{$row['recurso_nombre']}</p>
                  </div>";
        }
        
        ?>
    </div>
    <div id='myModal' class='modal'>
        <div class='modal-content' style="width: 500px;">
            <span class='close'>&times;</span>
            <p id='modal-text'>Some text in the Modal..</p>
        </div>
    </div>
</div>

<?php include "../template/footer.php"; ?>