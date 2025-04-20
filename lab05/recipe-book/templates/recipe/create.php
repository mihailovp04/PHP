<?php
/**
 * Шаблон формы добавления рецепта
 * @var array $categories Список категорий
 * @var array $errors Ошибки валидации
 */
ob_start();
?>
<h2>Добавить рецепт</h2>
<form method="POST" action="<?php echo BASE_URL; ?>?action=store">
    <div>
        <label>Название:</label>
        <input type="text" name="title" required>
        <?php if (isset($errors['title'])): ?>
            <p class="error"><?php echo htmlspecialchars($errors['title']); ?></p>
        <?php endif; ?>
    </div>
    <div>
        <label>Категория:</label>
        <select name="category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label>Ингредиенты:</label>
        <textarea name="ingredients"></textarea>
    </div>
    <div>
        <label>Описание:</label>
        <textarea name="description"></textarea>
    </div>
    <div>
        <label>Теги:</label>
        <input type="text" name="tags">
    </div>
    <div>
        <label>Шаги:</label>
        <textarea name="steps"></textarea>
    </div>
    <button type="submit">Сохранить</button>
</form>
<?php
$content = ob_get_clean();
$title = 'Добавить рецепт';
require_once __DIR__ . '/../layout.php';