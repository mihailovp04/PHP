<?php

/**
 * Читает рецепты из файла и возвращает их в виде массива объектов.
 * 
 * @return array Массив объектов рецептов или пустой массив, если файл не существует
 */
function getRecipes() {
    $file = __DIR__ . '/../storage/recipes.txt';
    if (!file_exists($file)) {
        return [];
    }
    
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return array_map('json_decode', $lines);
}