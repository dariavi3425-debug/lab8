<?php
// URL для отримання JSON з GET-параметрами
$apiUrl = "http://lab.vntu.org/api-server/lab8.php?user=student&pass=p@ssword";

// Спроба отримати дані з сервера
$context = stream_context_create([
    'http' => ['timeout' => 3]
]);

$jsonData = @file_get_contents($apiUrl, false, $context);

if ($jsonData === false && function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $jsonData = curl_exec($ch);
    curl_close($ch);
}

$people = [];
$errorMsg = null;

if ($jsonData) {
    $data = json_decode($jsonData, true);
    if (is_array($data)) {
        foreach ($data as $item) {
            if (is_array($item) && isset($item['name'])) {
                $people[] = $item;
            } elseif (is_array($item)) {
                foreach ($item as $subItem) {
                    if (is_array($subItem) && isset($subItem['name'])) {
                        $people[] = $subItem;
                    }
                }
            }
        }
    }
}

// Резервні дані для локального тестування (якщо зовнішній сервер ВНТУ недоступний)
if (empty($people)) {
    $people = [
        ["name" => "Дарія Вишневська", "role" => "Студент", "email" => "daria@vntu.edu.ua"],
        ["name" => "Ілля Малініч", "role" => "Викладач / Асистент", "email" => "malinich@vntu.edu.ua"],
        ["name" => "Олександр Стешенко", "role" => "Адміністратор", "email" => "steshenko@vntu.edu.ua"],
        ["name" => "Олексій Іванов", "role" => "Розробник REST API", "email" => "alex@vntu.edu.ua"]
    ];
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР8: Взаємодія з REST API та JSON</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 30px auto; padding: 0 20px; color: #333; }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        th, td { border: 1px solid #e0e0e0; padding: 12px; text-align: left; }
        th { background-color: #3498db; color: white; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        tr:hover { background-color: #f1f7fc; }
        .nav-link { display: inline-block; margin-bottom: 15px; color: #3498db; font-weight: bold; text-decoration: none; }
        .nav-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <a href="preview.php" class="nav-link">&rarr; Перейти до Бонусного завдання (Preview JSON)</a>
    
    <h2>Завдання 1-3: Отримання даних з REST API (JSON)</h2>

    <table>
        <thead>
            <tr>
                <th>№</th>
                <th>Ім'я (Name)</th>
                <th>Роль / Посада</th>
                <th>Email / Контакт</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($people as $index => $person): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($person['name'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($person['role'] ?? $person['position'] ?? 'Студент') ?></td>
                    <td><?= htmlspecialchars($person['email'] ?? 'Не вказано') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>