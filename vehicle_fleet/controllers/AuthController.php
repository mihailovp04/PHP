<?php
require_once 'models/User.php';
require_once 'models/Vehicle.php';

/**
 * Admin controller
 */
class AdminController {
    private $user;
    private $vehicle;

    public function __construct() {
        $this->user = new User();
        $this->vehicle = new Vehicle();
    }

    /**
     * Admin dashboard
     */
    public function dashboard() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit;
        }
        include 'views/admin/dashboard.php';
    }

    /**
     * Manage users
     */
    public function manageUsers() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $role = trim($_POST['role']);
            if (empty($username) || empty($email) || empty($password) || empty($role)) {
                $error = "Заполните все поля";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Неверный формат email";
            } else {
                if ($this->user->register($username, $email, $password, $role)) {
                    $success = "Пользователь успешно добавлен";
                } else {
                    $error = "Ошибка при добавлении пользователя";
                }
            }
        }
        $users = $this->user->getAll();
        include 'views/admin/manage_users.php';
    }

    /**
     * Manage vehicles
     */
    public function manageVehicles() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit;
        }
        if (isset($_GET['delete_id'])) {
            $this->vehicle->delete($_GET['delete_id'], null);
            header('Location: index.php?action=manage_vehicles');
            exit;
        }
        $vehicles = $this->vehicle->search([]);
        include 'views/admin/manage_vehicles.php';
    }
}
?>