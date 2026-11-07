<?php
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/json.php';

// Отримуємо масив анкет безпосередньо викликом функції
$surveys = getSurveyData();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бонусне завдання: Preview JSON даних</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 850px; margin: 30px auto; padding: 0 20px; color: #333; }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        th, td { border: 1px solid #e0e0e0; padding: 10px 12px; text-align: left; }
        th { background-color: #2ecc71; color: white; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        tr:hover { background-color: #f1f7fc; }
        .nav-link { display: inline-block; margin-bottom: 15px; color: #3498db; font-weight: bold; text-decoration: none; }
        .nav-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <a href="index.php" class="nav-link">&larr; Повернутися до основної сторінки (REST API)</a>
    
    <h2>Бонусне завдання: Перегляд відповідей анкет з json.php</h2>

    <table>
        <thead>
            <tr>
                <th>Дата та час</th>
                <th>Ім'я респондента</th>
                <th>Email</th>
                <th>Жанр</th>
                <th>Формат</th>
                <th>Коментар</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($surveys)): ?>
                <?php foreach ($surveys as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['submitted_at'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($item['respondent']['name'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($item['respondent']['email'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($item['answers']['favorite_genre'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($item['answers']['reading_format'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($item['answers']['feedback'] ?? 'N/A') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Не вдалося завантажити дані анкет.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>