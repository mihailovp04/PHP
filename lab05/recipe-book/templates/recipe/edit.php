<?php
/**
 * Шаблон формы редактирования рецепта
 * @var array $recipe Данные рецепта
 * @var array $categories Список категорий
 * @var array $errors Ошибки валидации
 */
ob_start();
?>
<h2>Редактировать рецепт</h2>
<form method="POST" action="<?php echo BASE_URL; ?>?action=update&id=<?php echo $recipe['id']; ?>">
    <div>
        <label>Название:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
        <?php if (isset($errors['title'])): ?>
            <p class="error"><?php echo htmlspecialchars($errors['title']); ?></p>
        <?php endif; ?>
    </div>
    <div>
        <label>Категория:</label>
        <select name="category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $recipe['category'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label>Ингредиенты:</label>
        <textarea name="ingredients"><?php echo htmlspecialchars($recipe['ingredients'] ?? ''); ?></textarea>
    </div>
    <div>
        <label>Описание:</label>
        <textarea name="description"><?php echo htmlspecialchars($recipe['description'] ?? ''); ?></textarea>
    </div>
    <div>
        <label>Теги:</label>
        <input type="text" name="tags" value="<?php echo htmlspecialchars($recipe['tags'] ?? ''); ?>">
    </div>
    <div>
        <label>Шаги:</label>
        <textarea name="steps"><?php echo htmlspecialchars($recipe['steps'] ?? ''); ?></textarea>
    </div>
    <button type="submit">Сохранить</button>
</form>
<?php
$content = ob_get_clean();
$title = 'Редактировать рецепт';
require_once __DIR__ . '/../layout.php';