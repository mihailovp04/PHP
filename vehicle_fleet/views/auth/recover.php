<?php
ob_start();
?>
<h2>Восстановление пароля</h2>
<?php if (isset($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<?php if (isset($_SESSION['reset_code'])): ?>
    <p class="success">Код восстановления отправлен на ваш email (эмуляция). Переход на страницу сброса...</p>
    <meta http-equiv="refresh" content="2;url=index.php?action=reset">
<?php else: ?>
    <form method="POST">
        <label>Email</label>
        <input type="email" name="email" required>
        <button type="submit">Отправить код</button>
    </form>
<?php endif; ?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>