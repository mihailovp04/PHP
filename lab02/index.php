<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lab02</title>
</head>
<body>

<?php
$dayOfWeek = date('N');

if ($dayOfWeek == 1 || $dayOfWeek == 3 || $dayOfWeek == 5) {
    $johnSchedule = "8:00-12:00";
} else {
    $johnSchedule = "Нерабочий день";
}

if ($dayOfWeek == 2 || $dayOfWeek == 4 || $dayOfWeek == 6) {
    $janeSchedule = "12:00-16:00";
} else {
    $janeSchedule = "Нерабочий день";
}
?>

<table border="1">
    <thead>
        <tr>
            <th>№</th>
            <th>Фамилия Имя</th>
            <th>График работы</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>John Styles</td>
            <td><?= $johnSchedule ?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Jane Doe</td>
            <td><?= $janeSchedule ?></td>
        </tr>
    </tbody>
</table>

</body>
</html>
<br>
<?php
//for
$a = 0;
$b = 0;

for ($i = 0; $i <= 5; $i++) {
   $a += 10;
   $b += 5;
   echo "Step $i: a = $a, b = $b<br>";
}

echo "End of the loop: a = $a, b = $b";
?>
<br>
<?php
//while
$a = 0;
$b = 0;
$i = 0;

while ($i <= 5) {
   $a += 10;
   $b += 5;
   echo "Step $i: a = $a, b = $b<br>";
   $i++;
}

echo "End of the loop: a = $a, b = $b";
?>
<br>
<?php
//do while
$a = 0;
$b = 0;
$i = 0;

do {
   $a += 10;
   $b += 5;
   echo "Step $i: a = $a, b = $b<br>";
   $i++;
} while ($i <= 5);

echo "End of the loop: a = $a, b = $b";
?>