<?php
function getSurveyData() {
    $surveyDir = __DIR__ . '/survey';
    $surveys = [];

    if (is_dir($surveyDir)) {
        $files = scandir($surveyDir);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                $content = file_get_contents($surveyDir . '/' . $file);
                $parsedData = json_decode($content, true);
                if ($parsedData) {
                    $surveys[] = $parsedData;
                }
            }
        }
    }

    if (empty($surveys)) {
        $surveys = [
            [
                "submitted_at" => "2026-11-06 08:17:31",
                "respondent" => [
                    "name" => "Дарія",
                    "email" => "daria@example.com"
                ],
                "answers" => [
                    "favorite_genre" => "Фентезі",
                    "reading_format" => "Паперові книги",
                    "feedback" => "Чудова лабораторія!"
                ]
            ],
            [
                "submitted_at" => "2026-11-06 10:45:12",
                "respondent" => [
                    "name" => "Олексій",
                    "email" => "alex@example.com"
                ],
                "answers" => [
                    "favorite_genre" => "Наукова фантастика",
                    "reading_format" => "Електронні книги (e-book)",
                    "feedback" => "Все працює асинхронно."
                ]
            ]
        ];
    }

    return $surveys;
}

// Якщо файл викликається напряму як API-ендпоінт — виводимо JSON
if (basename($_SERVER['SCRIPT_FILENAME']) === 'json.php') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(getSurveyData(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
?>