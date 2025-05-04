<?php
ob_start();
?>
<h2>Вход</h2>
<?php if (isset($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="POST">
    <label>Логин</label>
    <input type="text" name="username" required>
    <label>Пароль</label>
    <input type="password" name="password" required>
    <button type="submit">Войти</button>
</form>
<p><a href="index.php?action=recover">Забыли пароль?</a></p>
<?php
$content = ob_get_clean();
include BASE_PATH . 'views/layouts/main.php';
?>