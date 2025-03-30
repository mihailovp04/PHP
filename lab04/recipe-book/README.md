# Лабораторная работа №4. Обработка и валидация форм

## Цель работы

Освоить основные принципы работы с HTML-формами в PHP, включая отправку данных на сервер и их обработку, включая валидацию данных.

Данная работа станет основой для дальнейшего изучения разработки веб-приложений. Дальнейшие лабораторные работы будут основываться на данной.

## Условие

В данной работе используется проект "Каталог рецептов". В дальнейшем лабораторные работы будут основаны на ней.

Студенты должны выбрать тему проекта для лабораторной работы, которая будет развиваться на протяжении курса.

**Например**:

- ToDo-лист;
- Блог;
- Система управления задачами;
- другие.

Для данной лабораторной работы в качестве примера используется проект **"Каталог рецептов"**, можно выбрать данную тему.

---

## Задания

### Задание 1. Создание проекта

1. Создайте корневую директорию проекта (например, `recipe-book`).
2. Организуйте файловую структуру проекта.

### Задание 2. Создание формы добавления рецепта

1. Создайте HTML-форму для добавления рецепта.
2. Форма должна содержать следующие поля:
   - Название рецепта (`<input type="text">`);
   - Категория рецепта (`<select>`);
   - Ингредиенты (`<textarea>`);
   - Описание рецепта (`<textarea>`);
   - Тэги (выпадающий список с возможностью выбора нескольких значений, `<select multiple>`).
3. Добавьте поле для **шагов приготовления рецепта**. Реализуйте один из двух вариантов:
   - **Простой вариант**: `<textarea>`, где каждый шаг начинается с новой строки.
   - **Расширенный вариант (на более высокую оценку)**: динамическое добавление шагов с помощью JavaScript (кнопка "Добавить шаг"), где каждый шаг — отдельное поле ввода.
4. Добавьте кнопку **"Отправить"** для отправки формы.

### Задание 3. Обработка формы

1. Создайте в директории `handlers` файл, который будет обрабатывать данные формы.
2. **В обработчике реализуйте**:
   - Фильрацию данных;
   - Валидацию данных;
   - Сохранение данных в файл `storage/recipes.txt` в формате JSON.
3. Чтобы избежать дублирования кода и улучшить его читаемость, рекомендуется вынести повторяющиеся операции в отдельные вспомогательные функции, разместив их в файле `src/helpers.php`.
4. После успешного сохранения данных выполните перенаправление пользователя на главную страницу.
5. Если валидация не пройдена, отобразите соответствующие ошибки на странице добавления рецепта под соответствующими полями.

Для сохранения данных в файл можно использовать разные подходы. Один из вариантов — сохранять данные в текстовый файл, где каждая строка представляет собой отдельный JSON-объект:

```php
$formData = // данные формы;

// валидация данных

file_put_contents('<filename>', json_encode($formData) . PHP_EOL, FILE_APPEND);
```

### Задание 4. Отображение рецептов

1. В файле `public/index.php` отобразите 2 последних рецепта из `storage/recipes.txt`:

   ```php
   // Читаем данные из файла
   $recipes = file('<filename>', FILE_IGNORE_NEW_LINES);

   // Преобразуем строки JSON в массив
   $recipes = array_map('json_decode', $recipes);

   // Получаем два последних рецепта
   $latestRecipes = array_slice($recipes, -2);
   ```

2. В файле `public/recipe/index.php` отобразите все рецепты из файла `storage/recipes.txt`.

### Дополнительное задание

1. Реализуйте пагинацию (постраничный вывод) списка рецептов.
2. На странице `public/recipe/index.php` отображайте по 5 рецептов на страницу.
3. Для этого используйте GET-параметр page, например:
   - `/recipe/index.php?page=2` — отобразить 2 страницу рецептов.
   - `/recipe/index.php?page=3` — отобразить 3 страницу рецептов.
   - Если страница не указана, отобразите первую страницу.

## Выполнение

### Структура проекта

```sh
recipe-book/
├── README.md
├── public/
│   ├── index.php           # Главная страница и маршрутизация
│   ├── create.php          # Форма добавления рецепта
│   └── recipes.php         # Все рецепты с пагинацией
├── src/
│   ├── handlers/
│   │   └── recipeHandler.php  # Резервный обработчик
│   └── helpers.php         # Вспомогательные функции
└── storage/
    └── recipes.txt         # Хранилище рецептов
```

1. public/index.php – Главная страница

Выводит два последних рецепта. Используется маршрутизация для обработки формы.

```php
$recipes = getRecipes();
$latestRecipes = array_slice($recipes, -2);
```

```php
<?php foreach ($latestRecipes as $recipe): ?>
    <div>
        <h2><?php echo htmlspecialchars($recipe->title); ?></h2>
        <p><strong>Категория:</strong> <?php echo htmlspecialchars($recipe->category); ?></p>
        <p><strong>Ингредиенты:</strong> <?php echo htmlspecialchars($recipe->ingredients); ?></p>
        <p><strong>Описание:</strong> <?php echo htmlspecialchars($recipe->description); ?></p>
        <p><strong>Тэги:</strong> <?php echo htmlspecialchars(implode(', ', $recipe->tags)); ?></p>
        <p><strong>Шаги:</strong></p>
        <ol>
            <?php foreach ($recipe->steps as $step): ?>
                <li><?php echo htmlspecialchars($step); ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
<?php endforeach; ?>
```

Краткое пояснение:

- Функция getRecipes() читает данные из recipes.txt.
- array_slice($recipes, -2) берет последние 2 рецепта.
- Все поля защищены от XSS через htmlspecialchars()

2. public/create.php – Форма добавления рецепта

HTML-форма с простым вариантом шагов. Данные отправляются на маршрут add-recipe

```php
<form method="POST" action="/recipe-book/public/add-recipe">
    <input type="text" name="title" value="<?php echo isset($_GET['title']) ? htmlspecialchars($_GET['title']) : ''; ?>">
    <select name="category">
        <option value="main">Основное блюдо</option>
        <option value="dessert">Десерт</option>
        <option value="appetizer">Закуска</option>
    </select>
    <textarea name="ingredients"><?php echo isset($_GET['ingredients']) ? htmlspecialchars($_GET['ingredients']) : ''; ?></textarea>
    <textarea name="description"><?php echo isset($_GET['description']) ? htmlspecialchars($_GET['description']) : ''; ?></textarea>
    <select name="tags[]" multiple>
        <option value="easy">Легко</option>
        <option value="quick">Быстро</option>
        <option value="healthy">Полезно</option>
    </select>
    <textarea name="steps"><?php echo isset($_GET['steps']) ? htmlspecialchars($_GET['steps']) : ''; ?></textarea>
    <button type="submit">Отправить</button>
</form>
```

Краткое пояснение:

- Поля сохраняют значения при ошибках через GET.
- Ошибки отображаются под полями с помощью isset($_GET['errors']).
- Шаги вводятся в <textarea> с разделением по строкам.

3. public/recipes.php – Все рецепты с пагинацией

Отображает все рецепты с пагинацией по 5 на страницу

```php
$recipes = getRecipes();
$perPage = 5;
$page = max(1, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1);
$offset = ($page - 1) * $perPage;
$paginatedRecipes = array_slice($recipes, $offset, $perPage);
$totalPages = ceil(count($recipes) / $perPage);
```

Краткое пояснение:

- getRecipes() возвращает все рецепты.
- Пагинация через $offset и $perPage.
- Навигация реализована через ссылки с GET-параметром page

4. public/index.php (обработка формы) – Обработка данных

Обрабатывает данные формы на маршруте add-recipe.

```php
$data = [
    'title' => filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS),
    'category' => filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS),
    'ingredients' => filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_SPECIAL_CHARS),
    'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS),
    'tags' => filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY) ?? [],
    'steps' => filter_input(INPUT_POST, 'steps', FILTER_SANITIZE_SPECIAL_CHARS),
    'created_at' => date('Y-m-d H:i:s')
];
if (empty($data['title'])) $errors['title'] = 'Название обязательно';
if (empty($data['ingredients'])) $errors['ingredients'] = 'Ингредиенты обязательны';
if (!empty($errors)) {
    $query = http_build_query(['errors' => $errors, /* ... */]);
    header("Location: /recipe-book/public/create.php?$query");
    exit;
}
$data['steps'] = array_filter(explode("\n", trim($data['steps'])));
file_put_contents('../storage/recipes.txt', json_encode($data) . PHP_EOL, FILE_APPEND);
header('Location: /recipe-book/public/index.php');
```

Краткое пояснение:

- Фильтрация через FILTER_SANITIZE_SPECIAL_CHARS.
- Валидация проверяет обязательные поля.
- Шаги разбиваются на массив через explode()

5. src/helpers.php – Вспомогательные функции

```php
function getRecipes() {
    $file = __DIR__ . '/../storage/recipes.txt';
    if (!file_exists($file)) return [];
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return array_map('json_decode', $lines);
}
```

Краткое пояснение:

- Читает строки из файла и декодирует их в объекты.
- Возвращает массив рецептов

6. storage/recipes.txt – Хранилище рецептов

```sh
{"title":"Тест","category":"main","ingredients":"Мука","description":"Тест","tags":["easy"],"steps":["Шаг 1"],"created_at":"2025-03-30 12:00:00"}
```

Результат:

- Основная страница: Отображает 2 последних рецепта с полными данными.
- Страница добавления рецепта: Форма с валидацией и отображением ошибок.
- Страница со всеми рецептами: Пагинация по 5 рецептов

### Контрольные вопросы

1. Какие методы HTTP применяются для отправки данных формы?

GET — данные в URL, для запросов.
POST — данные в теле запроса, для отправки форм (используется в проекте).
2. Что такое валидация и чем она отличается от фильтрации?

Валидация — проверка данных на корректность (например, пустота).
Фильтрация — очистка данных (например, от спецсимволов). В проекте: валидация — empty(), фильтрация — FILTER_SANITIZE_SPECIAL_CHARS.
3. Какие функции PHP используются для фильтрации данных?

filter_input(), htmlspecialchars() (вывода), trim() (в explode()).

### Вывод

Реализован проект "Каталог рецептов" на PHP.

Освоены работа с формами, фильтрация через filter_input(), валидация, сохранение в JSON и пагинация.

Код структурирован, готов к дальнейшему развитию.

## Библиография

1. Официальная документация PHP: [https://www.php.net/manual/ru/](https://www.php.net/manual/ru/)
2. Работа с массивами в PHP: [https://www.php.net/manual/ru/language.types.array.php](https://www.php.net/manual/ru/language.types.array.php)
3. Работа с файлами в PHP: [https://www.php.net/manual/ru/function.file.php](https://www.php.net/manual/ru/function.file.php)