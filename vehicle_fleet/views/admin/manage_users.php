<?php
ob_start();
?>
<h2>Управление пользователями</h2>
<?php if (isset($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<?php if (isset($success)): ?>
    <p class="success"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>
<h3>Добавить нового пользователя</h3>
<form method="POST">
    <label>Логин</label>
    <input type="text" name="username" required>
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Пароль</label>
    <input type="password" name="password" required>
    <label>Роль</label>
    <select name="role" required>
        <option value="user">Пользователь</option>
        <option value="admin">Администратор</option>
    </select>
    <button type="submit">Добавить</button>
</form>
<h3>Список пользователей</h3>
<table>
    <tr>
        <th>Логин</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Дата регистрации</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['role']); ?></td>
            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php
$content = ob_get_clean();
include BASE_PATH . 'views/layouts/main.php';
?>