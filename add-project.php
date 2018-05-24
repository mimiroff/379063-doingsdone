<?php
require_once 'functions.php';
require_once 'init.php';
require_once 'data.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

$is_error = false;
$project_id = 0;

$required = ['name'];
$errors = [];
$rules = ['name' => 'check_project_name'];
$errors_messages = ['name' => 'Укажите название проекта',
    'check_project_name' => 'Данный проект уже существует'];

if (!$user || $_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Location: /index.php');
    exit;
} elseif ($user && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_project = $_POST;

    foreach ($new_project as $key => $value) {
        if (in_array($key, $required) && $value == '') {
            $errors[$key] = $errors_messages[$key];
        }

        if (array_key_exists($key, $rules) && $new_project[$key] != '') {
            $result = call_user_func($rules[$key], $link, $value, $user['id']);

            if (!$result) {
                $errors[$key] = $errors_messages[$rules[$key]];
            }
        }
    }

    if ($errors) {
        $is_error = true;
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
        $modal_project = renderTemplate(
            './templates/modal-project.php',
            [
                'errors' => $errors
            ]
        );
    } else {

        $project_name = $new_project['name'];
        $user_id = $user['id'];

        $sql = 'INSERT INTO `projects` (`project_name`, `user_id`) VALUES (?, ?)';
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, 'si', $project_name, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_error($link);

        $project = get_project_by_name($link, $project_name, $user_id);
        $project_id = $project['id'];
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

        $modal_project = renderTemplate(
            './templates/modal-project.php',
            []
        );
    }
    $layout_content = renderTemplate(
        './templates/layout.php',
        [
            'title' => 'Дела в порядке',
            'content' => $page_content,
            'user' => $user,
            'modal_project' => $modal_project,
            'is_error' => $is_error
        ]
    );
    print ($layout_content);
}