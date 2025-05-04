<?php
require_once 'models/Vehicle.php';

/**
 * Vehicle controller
 */
class VehicleController {
    private $vehicle;

    public function __construct() {
        $this->vehicle = new Vehicle();
    }

    /**
     * Display user's vehicles
     */
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        $vehicles = $this->vehicle->getByUser($_SESSION['user_id']);
        include 'views/vehicles/index.php';
    }

    /**
     * Create a new vehicle
     */
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'brand' => trim($_POST['brand']),
                'model' => trim($_POST['model']),
                'year' => (int)$_POST['year'],
                'color' => trim($_POST['color']),
                'mileage' => (int)$_POST['mileage'],
                'fuel_type' => trim($_POST['fuel_type'])
            ];
            if (empty($data['brand']) || empty($data['model']) || empty($data['year']) || empty($data['color']) || empty($data['mileage']) || empty($data['fuel_type'])) {
                $error = "Заполните все поля";
            } elseif ($data['year'] < 1900 || $data['year'] > date('Y')) {
                $error = "Некорректный год";
            } elseif ($data['mileage'] < 0) {
                $error = "Пробег не может быть отрицательным";
            } else {
                if ($this->vehicle->create($data, $_SESSION['user_id'])) {
                    header('Location: index.php?action=vehicles');
                    exit;
                } else {
                    $error = "Ошибка при добавлении автомобиля";
                }
            }
        }
        include 'views/vehicles/create.php';
    }

    /**
     * Edit a vehicle
     * @param int $id
     */
    public function edit($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        $vehicle = $this->vehicle->getById($id, $_SESSION['user_id']);
        if (!$vehicle) {
            $error = "Автомобиль не найден";
            include 'views/vehicles/index.php';
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'brand' => trim($_POST['brand']),
                'model' => trim($_POST['model']),
                'year' => (int)$_POST['year'],
                'color' => trim($_POST['color']),
                'mileage' => (int)$_POST['mileage'],
                'fuel_type' => trim($_POST['fuel_type'])
            ];
            if (empty($data['brand']) || empty($data['model']) || empty($data['year']) || empty($data['color']) || empty($data['mileage']) || empty($data['fuel_type'])) {
                $error = "Заполните все поля";
            } elseif ($data['year'] < 1900 || $data['year'] > date('Y')) {
                $error = "Некорректный год";
            } elseif ($data['mileage'] < 0) {
                $error = "Пробег не может быть отрицательным";
            } else {
                if ($this->vehicle->update($id, $data, $_SESSION['user_id'])) {
                    header('Location: index.php?action=vehicles');
                    exit;
                } else {
                    $error = "Ошибка при обновлении автомобиля";
                }
            }
        }
        include 'views/vehicles/edit.php';
    }

    /**
     * Delete a vehicle
     * @param int $id
     */
    public function delete($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        if ($this->vehicle->delete($id, $_SESSION['user_id'])) {
            header('Location: index.php?action=vehicles');
            exit;
        } else {
            $error = "Ошибка при удалении автомобиля";
            include 'views/vehicles/index.php';
        }
    }

    /**
     * Search vehicles
     */
    public function search() {
        $vehicles = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criteria = [
                'brand' => trim($_POST['brand']),
                'year' => (int)$_POST['year']
            ];
            $vehicles = $this->vehicle->search($criteria);
        }
        include 'views/vehicles/search.php';
    }
}
?>