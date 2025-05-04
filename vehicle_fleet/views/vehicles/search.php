<?php
ob_start();
?>
<h2>Поиск автомобилей</h2>
<form method="POST">
    <label>Марка</label>
    <input type="text" name="brand">
    <label>Год</label>
    <input type="number" name="year" min="1900" max="<?php echo date('Y'); ?>">
    <button type="submit">Найти</button>
</form>
<?php if (!empty($vehicles)): ?>
    <h3>Результаты поиска</h3>
    <table>
        <tr>
            <th>Марка</th>
            <th>Модель</th>
            <th>Год</th>
            <th>Цвет</th>
            <th>Пробег</th>
            <th>Тип топлива</th>
        </tr>
        <?php foreach ($vehicles as $vehicle): ?>
            <tr>
                <td><?php echo htmlspecialchars($vehicle['brand']); ?></td>
                <td><?php echo htmlspecialchars($vehicle['model']); ?></td>
                <td><?php echo htmlspecialchars($vehicle['year']); ?></td>
                <td><?php echo htmlspecialchars($vehicle['color']); ?></td>
                <td><?php echo htmlspecialchars($vehicle['mileage']); ?></td>
                <td><?php echo htmlspecialchars($vehicle['fuel_type']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<?php
$content = ob_get_clean();
include BASE_PATH . 'views/layouts/main.php';
?>