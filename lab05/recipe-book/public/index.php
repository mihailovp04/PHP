<?php
/**
 * Единая точка входа для приложения
 */

require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/controllers/RecipeController.php';

// Установка базового пути
define('BASE_URL', '/recipe-book/public/');

$controller = new RecipeController();

// Маршрутизация
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'show':
        if ($id) $controller->show($id);
        else redirect(BASE_URL);
        break;
    case 'edit':
        if ($id) $controller->edit($id);
        else redirect(BASE_URL);
        break;
    case 'update':
        if ($id) $controller->update($id);
        else redirect(BASE_URL);
        break;
    case 'delete':
        if ($id) $controller->delete($id);
        else redirect(BASE_URL);
        break;
    case 'index':
    default:
        $controller->index();
        break;
}