<?php

declare(strict_types=1);

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

/**
 * Вычисляет общую сумму всех транзакций.
 *
 * @param array $transactions Список транзакций.
 * @return float Общая сумма.
 */
function calculateTotalAmount(array $transactions): float
{
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}

/**
 * Ищет транзакции по части описания.
 *
 * @param array $transactions Список транзакций.
 * @param string $descriptionPart Часть описания.
 * @return array Найденные транзакции.
 */
function findTransactionByDescription(array $transactions, string $descriptionPart): array
{
    return array_filter($transactions, fn($t) => stripos($t['description'], $descriptionPart) !== false);
}

/**
 * Ищет транзакцию по идентификатору (обычный foreach).
 *
 * @param array $transactions Список транзакций.
 * @param int $id Идентификатор транзакции.
 * @return array|null Найденная транзакция или null.
 */
function findTransactionById(array $transactions, int $id): ?array
{
    foreach ($transactions as $transaction) {
        if ($transaction['id'] === $id) {
            return $transaction;
        }
    }
    return null;
}

/**
 * Ищет транзакцию по идентификатору (через array_filter).
 *
 * @param array $transactions Список транзакций.
 * @param int $id Идентификатор транзакции.
 * @return array|null Найденная транзакция или null.
 */
function findTransactionByIdFiltered(array $transactions, int $id): ?array
{
    $filtered = array_filter($transactions, fn($t) => $t['id'] === $id);
    return $filtered ? array_values($filtered)[0] : null;
}

/**
 * Возвращает количество дней с момента транзакции.
 *
 * @param string $date Дата транзакции (YYYY-MM-DD).
 * @return int Количество дней.
 */
function daysSinceTransaction(string $date): int
{
    $transactionDate = new DateTime($date);
    $now = new DateTime();
    return $now->diff($transactionDate)->days;
}

/**
 * Добавляет новую транзакцию.
 *
 * @param int $id ID транзакции.
 * @param string $date Дата в формате YYYY-MM-DD.
 * @param float $amount Сумма транзакции.
 * @param string $description Описание.
 * @param string $merchant Название магазина.
 * @return void
 */
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void
{
    global $transactions;
    $transactions[] = compact("id", "date", "amount", "description", "merchant");
}

/**
 * Удаляет транзакцию по идентификатору.
 *
 * @param int $id Идентификатор транзакции.
 * @return void
 */
function deleteTransaction(int $id): void
{
    global $transactions;
    $transactions = array_filter($transactions, fn($t) => $t['id'] !== $id);
    $transactions = array_values($transactions); // Чтобы сбросить индексы
}

// Сортировка транзакций по дате (по возрастанию)
usort($transactions, fn($a, $b) => strtotime($a['date']) <=> strtotime($b['date']));

// Сортировка транзакций по сумме (по убыванию)
usort($transactions, fn($a, $b) => $b['amount'] <=> $a['amount']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Транзакции</title>
</head>
<body>
    <h2>Список транзакций</h2>
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
    <p><strong>Общая сумма транзакций:</strong> <?= calculateTotalAmount($transactions) ?></p>
</body>
</html>
