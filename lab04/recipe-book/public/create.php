<!DOCTYPE html>
<html>
<head>
    <title>Добавить рецепт</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Добавить новый рецепт</h1>
    <?php
    /**
     * Отображает форму для добавления рецепта с учетом предыдущих данных и ошибок.
     * 
     * @param array $_GET Данные из GET-запроса для сохранения значений и ошибок
     */
    ?>
    <form method="POST" action="/recipe-book/public/add-recipe">
        <div>
            <label>Название:</label><br>
            <input type="text" name="title" value="<?php echo isset($_GET['title']) ? htmlspecialchars($_GET['title']) : ''; ?>">
            <?php if(isset($_GET['errors']['title'])) echo '<p class="error">' . $_GET['errors']['title'] . '</p>'; ?>
        </div>

        <div>
            <label>Категория:</label><br>
            <select name="category">
                <option value="main">Основное блюдо</option>
                <option value="dessert">Десерт</option>
                <option value="appetizer">Закуска</option>
            </select>
        </div>

        <div>
            <label>Ингредиенты:</label><br>
            <textarea name="ingredients"><?php echo isset($_GET['ingredients']) ? htmlspecialchars($_GET['ingredients']) : ''; ?></textarea>
            <?php if(isset($_GET['errors']['ingredients'])) echo '<p class="error">' . $_GET['errors']['ingredients'] . '</p>'; ?>
        </div>

        <div>
            <label>Описание:</label><br>
            <textarea name="description"><?php echo isset($_GET['description']) ? htmlspecialchars($_GET['description']) : ''; ?></textarea>
        </div>

        <div>
            <label>Тэги:</label><br>
            <select name="tags[]" multiple>
                <option value="easy">Легко</option>
                <option value="quick">Быстро</option>
                <option value="healthy">Полезно</option>
            </select>
        </div>

        <div>
            <label>Шаги приготовления:</label><br>
            <textarea name="steps"><?php echo isset($_GET['steps']) ? htmlspecialchars($_GET['steps']) : ''; ?></textarea>
        </div>

        <button type="submit">Отправить</button>
    </form>
    <a href="/recipe-book/public/index.php">На главную</a>
</body>
</html>