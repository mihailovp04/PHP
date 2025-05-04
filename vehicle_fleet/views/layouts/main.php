<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Система управления автопарком</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Система управления автопарком</h1>
        <nav>
            <a href="index.php">Главная</a>
            <a href="index.php?action=vehicles">Мои автомобили</a>
            <a href="index.php?action=search_vehicles">Поиск</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="index.php?action=admin_dashboard">Админ-панель</a>
                <?php endif; ?>
                <a href="index.php?action=logout">Выйти</a>
            <?php else: ?>
                <a href="index.php?action=login">Вход</a>
                <a href="index.php?action=register">Регистрация</a>
            <?php endif; ?>
        </nav>
    </header>
    <div class="container">
        <?php echo $content; ?>
    </div>
</body>
</html>