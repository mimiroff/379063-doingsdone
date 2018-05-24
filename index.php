<?php

require_once 'functions.php';
require_once 'data.php';
require_once 'init.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

$is_error = false;
$project_id = 0;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($user)) {
    $modal_task = renderTemplate(
        './templates/modal-task.php',
        [
            'projects' => get_projects_by_user($link, $user['id'])
        ]
    );
    $modal_project = renderTemplate(
        './templates/modal-project.php',
        []
    );
    if (!empty($_GET['id']) && check_project($link, $_GET['id'], $user['id'])) {
        $project_id = $_GET['id'];
        $page_content = renderTemplate(
            './templates/index.php',
            [
                'projects' => get_projects_by_user($link, $user['id']),
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
                'projects' => get_projects_by_user($link, $user['id']),
                'tasks' => get_inbox_tasks_by_user($link, $user['id']),
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
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($user)) {
    header('Location: /guest.php');
    exit;
}

$layout_content = renderTemplate(
    './templates/layout.php',
    [
        'title' => 'Дела в порядке',
        'content' => $page_content,
        'user' => $user,
        'modal_task' => $modal_task,
        'modal_project' => $modal_project,
        'is_error' => $is_error
    ]
);

print($layout_content);
