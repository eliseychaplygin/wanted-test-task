<?php
// Загружаем репозитории из файла
$repos_file = __DIR__ . '/repos.json';
$repos = [];

if (file_exists($repos_file)) {
    $repos = json_decode(file_get_contents($repos_file), true);

    // Проверяем на случай пустого файла
    if ($repos === null) {
        $repos = [];
    }
} else {
    echo "Файл репозиториев не найден.";
}

// Сортируем репозитории по дате обновления
usort($repos, function ($a, $b) {
    return strtotime($b['updated_at']) - strtotime($a['updated_at']);
});

// Выбираем только 10 последних репозиториев
$latest_repos = array_slice($repos, 0, 10);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Последние репозитории</title>
</head>
<body>
<h1>10 последних обновленных репозиториев</h1>
<ul>
    <?php if (!empty($latest_repos)): ?>
        <?php foreach ($latest_repos as $repo): ?>
            <li>
                <a href="<?= htmlspecialchars($repo['html_url']) ?>" target="_blank">
                    <?= htmlspecialchars($repo['name']) ?> (<?= htmlspecialchars($repo['owner']['login']) ?>)
                </a>
                - обновлено: <?= htmlspecialchars($repo['updated_at']) ?>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>Нет репозиториев для отображения.</li>
    <?php endif; ?>
</ul>
</body>
</html>