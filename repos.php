<?php
// Файл для хранения данных о репозиториях
$repos_file = __DIR__ . '/repos.json';

// Список пользователей GitHub
$users_data = json_decode(file_get_contents(__DIR__ . '/users.json'), true);
$users = $users_data['users'];

// Функция для получения репозиториев пользователя
function fetch_user_repos($username) {
    $url = "https://api.github.com/users/{$username}/repos";
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => [
                'User-Agent: PHP'
            ]
        ]
    ];

    $context = stream_context_create($opts);
    $data = file_get_contents($url, false, $context);
    return json_decode($data, true);
}

// Получаем репозитории всех пользователей
$all_repos = [];

foreach ($users as $user) {
    $user_repos = fetch_user_repos($user);
    if (is_array($user_repos)) {
        $all_repos = array_merge($all_repos, $user_repos);
    }
}

// Сохраняем репозитории в файл
file_put_contents($repos_file, json_encode($all_repos));

echo "Файл repos.php обновлен " . date('Y-m-d H:i:s') . "\n";

