<?php
require_once '../helpers.php';

$errors = [];
$data = [
    'title' => filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING),
    'category' => filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING),
    'ingredients' => filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_STRING),
    'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
    'tags' => filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY) ?? [],
    'steps' => filter_input(INPUT_POST, 'steps', FILTER_SANITIZE_STRING),
    'created_at' => date('Y-m-d H:i:s')
];

if (empty($data['title'])) {
    $errors['title'] = 'Название обязательно';
}
if (empty($data['ingredients'])) {
    $errors['ingredients'] = 'Ингредиенты обязательны';
}

if (!empty($errors)) {
    $query = http_build_query([
        'errors' => $errors,
        'title' => $data['title'],
        'ingredients' => $data['ingredients'],
        'description' => $data['description'],
        'steps' => $data['steps']
    ]);
    header("Location: /recipe-book/public/create.php?$query");
    exit;
}

$data['steps'] = array_filter(explode("\n", trim($data['steps'])));

file_put_contents('../../storage/recipes.txt', json_encode($data) . PHP_EOL, FILE_APPEND);
header('Location: /recipe-book/public/index.php');
exit;