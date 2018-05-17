<?php

require_once 'functions.php';
require_once 'data.php';

$link = mysqli_connect('localhost', 'root', '', 'doingsdone-379063');

if(!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}

mysqli_set_charset($link, 'utf8');

$user_id = 1;
$user = get_user_data_by_id($link, $user_id);

if (!empty($_GET['id']) && check_project($link, $_GET['id'], $user_id)) {
    $project_id = $_GET['id'];
    $page_content = renderTemplate(
        './templates/index.php',
        [
            'projects' => get_projects_by_user($link, $user_id),
            'tasks' => get_tasks_by_project($link, $project_id),
            'show_complete_tasks' => $show_complete_tasks,
            'link' => $link,
            'active' => $project_id,
            'user' => $user
        ]
    );
} else if (!isset($_GET['id'])) {
    $project_id = 0;
    $page_content = renderTemplate(
        './templates/index.php',
        [
            'projects' => get_projects_by_user($link, $user_id),
            'tasks' => get_inbox_tasks_by_user($link, $user_id),
            'show_complete_tasks' => $show_complete_tasks,
            'link' => $link,
            'active' => $project_id,
            'user' => $user
        ]
    );
} else {
    header('Status: 404, not found');
    http_response_code(404);
    print('Error! Status: ' . http_response_code());
    exit;
}

$layout_content = renderTemplate(
    './templates/layout.php',
    [
        'title' => 'Дела в порядке',
        'content' => $page_content,
        'user' => $user
    ]
);

print($layout_content);
