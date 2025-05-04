<?php
ob_start();
?>
<h2>Админ-панель</h2>
<p><a href="index.php?action=manage_users">Управление пользователями</a></p>
<p><a href="index.php?action=manage_vehicles">Управление автомобилями</a></p>
<?php
$content = ob_get_clean();
include BASE_PATH . 'views/layouts/main.php';
?>