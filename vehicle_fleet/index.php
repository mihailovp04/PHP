<?php
session_start();
define('BASE_PATH', __DIR__ . '/'); 
require_once 'config/database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/VehicleController.php';
require_once 'controllers/AdminController.php';

$authController = new AuthController();
$vehicleController = new VehicleController();
$adminController = new AdminController();

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'register':
        $authController->register();
        break;
    case 'recover':
        $authController->recoverPassword();
        break;
    case 'reset':
        $authController->resetPassword();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'vehicles':
        $vehicleController->index();
        break;
    case 'create_vehicle':
        $vehicleController->create();
        break;
    case 'edit_vehicle':
        $vehicleController->edit($_GET['id'] ?? 0);
        break;
    case 'delete_vehicle':
        $vehicleController->delete($_GET['id'] ?? 0);
        break;
    case 'search_vehicles':
        $vehicleController->search();
        break;
    case 'admin_dashboard':
        $adminController->dashboard();
        break;
    case 'manage_users':
        $adminController->manageUsers();
        break;
    case 'manage_vehicles':
        $adminController->manageVehicles();
        break;
    default:
        include 'views/home.php';
}
?>