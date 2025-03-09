<?php
/**
 * Получает список файлов из указанной директории.
 *
 * @param string $dir Путь к директории.
 * @return array|false Список файлов или false при ошибке.
 */
function getFilesFromDirectory(string $dir)
{
    $files = scandir($dir);

    if ($files === false) {
        echo "Ошибка при сканировании директории.";
        return false;
    }

    return $files;
}

$dir = 'image/';
$files = getFilesFromDirectory($dir);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Галерея изображений</title>
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .gallery img {
            width: 200px; 
            height: auto; 
        }
        .footer {
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Галерея изображений</h1>
    </header>
    <main>
        <div class="gallery">
            <?php
            if ($files !== false) {
                foreach ($files as $file) {
                    if ($file != "." && $file != "..") {
                        $path = $dir . $file;
                        echo "<img src='$path' alt='$file'>";
                    }
                }
            }
            ?>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; 2025 USM FMI</p>
    </footer>
</body>
</html>
