<?php
ob_start();
?>
<h2>Регистрация</h2>
<?php if (isset($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<?php if (isset($success)): ?>
    <p class="success"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>
<form method="POST">
    <label>Логин</label>
    <input type="text" name="username" required>
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Пароль</label>
    <input type="password" name="password" required>
    <label>Подтверждение пароля</label>
    <input type="password" name="confirm_password" required>
    <button type="submit">Зарегистрироваться</button>
</form>
<?php
$content = ob_get_clean();
include BASE_PATH . 'views/layouts/main.php';
?>