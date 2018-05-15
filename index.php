<?php

require_once 'functions.php';
require_once 'data.php';

$link = mysqli_connect('localhost', 'root', '', 'doingsdone-379063');

if(!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}

mysqli_set_charset($link, 'utf8');


$user = 1;
$page_content = renderTemplate(
    './templates/index.php',
    [
        'projects' => get_projects_by_user($link, $user),
        'tasks' => get_tasks_by_user($link, $user),
        'show_complete_tasks' => $show_complete_tasks,
        'link' => $link
    ]
);

$layout_content = renderTemplate(
    './templates/layout.php',
    [
        'title' => 'Дела в порядке',
        'content' => $page_content,
        'user' => 'Илья'
    ]
);

print($layout_content);
