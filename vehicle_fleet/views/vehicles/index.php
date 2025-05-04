<?php
ob_start();
?>
<h2>Мои автомобили</h2>
<p><a href="index.php?action=create_vehicle">Добавить автомобиль</a></p>
<?php if (isset($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<table>
    <tr>
        <th>Марка</th>
        <th>Модель</th>
        <th>Год</th>
        <th>Цвет</th>
        <th>Пробег</th>
        <th>Тип топлива</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($vehicles as $vehicle): ?>
        <tr>
            <td><?php echo htmlspecialchars($vehicle['brand']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['model']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['year']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['color']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['mileage']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['fuel_type']); ?></td>
            <td>
                <a class="action" href="index.php?action=edit_vehicle&id=<?php echo $vehicle['id']; ?>">Редактировать</a>
                <a class="action" href="index.php?action=delete_vehicle&id=<?php echo $vehicle['id']; ?>" onclick="return confirm('Вы уверены?');">Удалить</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php
$content = ob_get_clean();
include BASE_PATH . 'views/layouts/main.php';
?>