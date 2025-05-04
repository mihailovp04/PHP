<?php
ob_start();
?>
<h2>Сброс пароля</h2>
<?php if (isset($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<p>Код восстановления: <?php echo isset($_SESSION['reset_code']) ? htmlspecialchars($_SESSION['reset_code']) : 'не доступен'; ?> (в реальном приложении отправляется на email)</p>
<form method="POST">
    <label>Код восстановления</label>
    <input type="text" name="code" required>
    <label>Новый пароль</label>
    <input type="password" name="new_password" required>
    <label>Подтверждение пароля</label>
    <input type="password" name="confirm_password" required>
    <button type="submit">Сбросить пароль</button>
</form>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>