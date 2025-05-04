<?php
ob_start();
?>
<h2>Редактировать автомобиль</h2>
<?php if (isset($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="POST">
    <label>Марка</label>
    <input type="text" name="brand" value="<?php echo htmlspecialchars($vehicle['brand']); ?>" required>
    <label>Модель</label>
    <input type="text" name="model" value="<?php echo htmlspecialchars($vehicle['model']); ?>" required>
    <label>Год</label>
    <input type="number" name="year" value="<?php echo htmlspecialchars($vehicle['year']); ?>" required min="1900" max="<?php echo date('Y'); ?>">
    <label>Цвет</label>
    <input type="text" name="color" value="<?php echo htmlspecialchars($vehicle['color']); ?>" required>
    <label>Пробег (км)</label>
    <input type="number" name="mileage" value="<?php echo htmlspecialchars($vehicle['mileage']); ?>" required min="0">
    <label>Тип топлива</label>
    <select name="fuel_type" required>
        <option value="petrol" <?php echo $vehicle['fuel_type'] === 'petrol' ? 'selected' : ''; ?>>Бензин</option>
        <option value="diesel" <?php echo $vehicle['fuel_type'] === 'diesel' ? 'selected' : ''; ?>>Дизель</option>
        <option value="electric" <?php echo $vehicle['fuel_type'] === 'electric' ? 'selected' : ''; ?>>Электрический</option>
        <option value="hybrid" <?php echo $vehicle['fuel_type'] === 'hybrid' ? 'selected' : ''; ?>>Гибрид</option>
    </select>
    <button type="submit">Сохранить</button>
</form>
<?php
$content = ob_get_clean();
include BASE_PATH . 'views/layouts/main.php';
?>