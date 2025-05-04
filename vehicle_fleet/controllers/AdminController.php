<?php
require_once 'models/User.php';

/**
 * Authentication controller
 */
class AuthController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    /**
     * Handle user login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            if (empty($username) || empty($password)) {
                $error = "Заполните все поля";
            } else {
                $user = $this->user->login($username, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    header('Location: index.php?action=vehicles');
                    exit;
                } else {
                    $error = "Неверный логин или пароль";
                }
            }
        }
        include 'views/auth/login.php';
    }

    /**
     * Handle user registration
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = "Заполните все поля";
            } elseif ($password !== $confirm_password) {
                $error = "Пароли не совпадают";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Неверный формат email";
            } else {
                if ($this->user->register($username, $email, $password)) {
                    $success = "Регистрация успешна. Войдите в систему.";
                } else {
                    $error = "Ошибка регистрации. Попробуйте снова.";
                }
            }
        }
        include 'views/auth/register.php';
    }

    /**
     * Handle password recovery
     */
    public function recoverPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Введите корректный email";
            } else {
                $code = $this->user->generateResetCode($email);
                if ($code) {
                    $_SESSION['reset_email'] = $email; // Сохраняем email для следующей формы
                    $_SESSION['reset_code'] = $code; // Для эмуляции (в реальном приложении отправляется по email)
                    header('Location: index.php?action=reset'); // Автоматический редирект
                    exit;
                } else {
                    $error = "Email не найден";
                }
            }
        }
        include 'views/auth/recover.php';
    }

    /**
     * Handle password reset
     */
    public function resetPassword() {
        if (!isset($_SESSION['reset_email'])) {
            header('Location: index.php?action=recover');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_SESSION['reset_email'];
            $code = trim($_POST['code']);
            $new_password = trim($_POST['new_password']);
            $confirm_password = trim($_POST['confirm_password']);
            if (empty($code) || empty($new_password) || empty($confirm_password)) {
                $error = "Заполните все поля";
            } elseif ($new_password !== $confirm_password) {
                $error = "Пароли не совпадают";
            } else {
                if ($this->user->resetPassword($email, $code, $new_password)) {
                    unset($_SESSION['reset_email']);
                    unset($_SESSION['reset_code']);
                    $success = "Пароль успешно изменён. Войдите в систему.";
                    include 'views/auth/login.php';
                    return;
                } else {
                    $error = "Неверный код восстановления";
                }
            }
        }
        include 'views/auth/reset.php';
    }

    /**
     * Handle logout
     */
    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
?>