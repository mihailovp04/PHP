
# Лабораторная работа №3. Массивы и Функции

## Цель работы

Освоить работу с массивами в PHP, применяя различные операции: создание, добавление, удаление, сортировка и поиск. Закрепить навыки работы с функциями, включая передачу аргументов, возвращаемые значения и анонимные функции.

## Условия задачи

### Задание 1. Работа с массивами

#### 1.1 Подготовка среды

В начале файла включена строгая типизация:

```php
<?php
declare(strict_types=1);
```

#### 1.2 Создание массива транзакций

Создан массив `$transactions`, который содержит информацию о банковских транзакциях с необходимыми полями:

- `id` — уникальный идентификатор транзакции;
- `date` — дата совершения транзакции (формат YYYY-MM-DD);
- `amount` — сумма транзакции;
- `description` — описание назначения платежа;
- `merchant` — название организации, получившей платеж.

Пример массива:

```php
$transactions = [
    [
        "id" => 1,
        "date" => "2025-03-09",
        "amount" => 59.00,
        "description" => "STIKI",
        "merchant" => "Linella",
    ],
    [
        "id" => 2,
        "date" => "2025-03-08",
        "amount" => 1456488.55,
        "description" => "Flowers",
        "merchant" => "AZALIA",
    ],
];
```

#### 1.3 Вывод списка транзакций

С помощью конструкции `foreach` выводится список транзакций в таблице HTML. Каждый элемент массива транзакций отображается в строках таблицы.

Пример:

```html
<table border='1'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Дата</th>
            <th>Сумма</th>
            <th>Описание</th>
            <th>Организация</th>
            <th>Дней с момента транзакции</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= $transaction['id'] ?></td>
                <td><?= $transaction['date'] ?></td>
                <td><?= $transaction['amount'] ?></td>
                <td><?= $transaction['description'] ?></td>
                <td><?= $transaction['merchant'] ?></td>
                <td><?= daysSinceTransaction($transaction['date']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
```

#### 1.4 Реализация функций

- Функция для вычисления общей суммы всех транзакций:

```php
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}
```

- Функция для поиска транзакции по описанию:

```php
function findTransactionByDescription(string $descriptionPart) {
    global $transactions;
    $result = [];
    foreach ($transactions as $transaction) {
        if (strpos($transaction['description'], $descriptionPart) !== false) {
            $result[] = $transaction;
        }
    }
    return $result;
}
```

- Функция для поиска транзакции по ID:

```php
function findTransactionById(int $id) {
    global $transactions;
    foreach ($transactions as $transaction) {
        if ($transaction['id'] === $id) {
            return $transaction;
        }
    }
    return null;
}
```

- Функция для расчета количества дней с момента транзакции:

```php
function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $currentDate = new DateTime();
    $interval = $currentDate->diff($transactionDate);
    return $interval->days;
}
```

- Функция для добавления новой транзакции:

```php
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;
    $transactions[] = [
        'id' => $id,
        'date' => $date,
        'amount' => $amount,
        'description' => $description,
        'merchant' => $merchant
    ];
}
```

#### 1.5 Сортировка транзакций

Использованы функции `usort()` для сортировки транзакций:

- По дате с использованием `strtotime()`.

```php
usort($transactions, fn($a, $b) => strtotime($a['date']) <=> strtotime($b['date']));
```

- По сумме по убыванию.

```php
usort($transactions, fn($a, $b) => $b['amount'] <=> $a['amount']);
```

#### Задание 2. Работа с файловой системой

1. Создана директория "image" для хранения изображений.
2. Реализован скрипт для вывода изображений на веб-страницу:

```php
<?php
$dir = 'image/';
$files = scandir($dir);

if ($files === false) {
    echo "Ошибка при сканировании директории.";
    return;
}

foreach ($files as $file) {
    if ($file != "." && $file != "..") {
        $path = $dir . $file;
        echo "<img src='$path' alt='$file'>";
    }
}

```

## Контрольные вопросы

1. **Что такое массивы в PHP?**
   - Массивы в PHP — это структуры данных, которые могут содержать несколько значений. Каждый элемент массива имеет ключ (индекс) и значение.

2. **Каким образом можно создать массив в PHP?**
   - Массив можно создать с помощью функции `array()` или через короткую синтаксисную форму `[]`.

3. **Для чего используется цикл `foreach`?**
   - Цикл `foreach` используется для обхода элементов массива, что позволяет работать с каждым элементом по очереди.

## Вывод

В ходе выполнения лабораторной работы были освоены основы работы с массивами в PHP, такие как создание, добавление, удаление, сортировка и поиск данных в массиве. Мы реализовали систему управления банковскими транзакциями, которая позволяет добавлять, удалять, искать и сортировать транзакции. Были использованы функции для выполнения различных операций, таких как вычисление общей суммы транзакций и поиск по описанию. Также была реализована функция, которая возвращает количество дней с момента транзакции.

Работа с массивами и функциями PHP позволила углубить понимание структур данных и их обработки в рамках серверного программирования. В результате была реализована полноценная система для работы с транзакциями, которая может быть использована в дальнейшем для более сложных проектов, таких как банковские системы или финансовые приложения.

## Библиография

1. Официальная документация PHP: [https://www.php.net/manual/ru/](https://www.php.net/manual/ru/function.usort.php)
2. Работа с массивами в PHP: [https://www.php.net/manual/ru/language.types.array.php](https://www.php.net/manual/ru/language.types.array.php)
