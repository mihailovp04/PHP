<?php
/**
 * Перенаправление на указанный URL
 * @param string $url URL для редиректа
 */
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

/**
 * Экранирование HTML-символов
 * @param string|null $string Входная строка
 * @return string Экранированная строка
 */
function escape(?string $string): string {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}