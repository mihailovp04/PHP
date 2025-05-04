<?php
ob_start();
require_once 'config/database.php';
$conn = getDBConnection();
$sql = "SELECT brand, model, year FROM vehicles ORDER BY created_at DESC LIMIT 3";
$result = $conn->query($sql);
$vehicles = $result->fetch_all(MYSQLI_ASSOC);
?>
<h2>Добро пожаловать</h2>
<h3>Последние добавленные автомобили</h3>
<table>
    <tr>
        <th>Марка</th>
        <th>Модель</th>
        <th>Год</th>
    </tr>
    <?php foreach ($vehicles as $vehicle): ?>
        <tr>
            <td><?php echo htmlspecialchars($vehicle['brand']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['model']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['year']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php
$content = ob_get_clean();
include BASE_PATH . 'views/layouts/main.php'; // Абсолютный путь
?>