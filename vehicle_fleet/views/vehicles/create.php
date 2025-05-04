<?php
ob_start();
?>
<h2>Добавить автомобиль</h2>
<?php if (isset($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="POST">
    <label>Марка</label>
    <input type="text" name="brand" required>
    <label>Модель</label>
    <input type="text" name="model" required>
    <label>Год</label>
    <input type="number" name="year" required min="1900" max="<?php echo date('Y'); ?>">
    <label>Цвет</label>
    <input type="text" name="color" required>
    <label>Пробег (км)</label>
    <input type="number" name="mileage" required min="0">
    <label>Тип топлива</label>
    <select name="fuel_type" required>
        <option value="petrol">Бензин</option>
        <option value="diesel">Дизель</option>
        <option value="electric">Электрический</option>
        <option value="hybrid">Гибрид</option>
    </select>
    <button type="submit">Добавить</button>
</form>
<?php
$content = ob_get_clean();
include BASE_PATH . 'views/layouts/main.php';
?>