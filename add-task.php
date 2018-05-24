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

$required_task = ['name', 'project'];
$errors = [];
$rules = ['date' => 'validate_date', 'project' => 'check_project', 'name' => 'validate_task_name'];
$errors_messages = ['name' => 'Укажите название задачи',
    'project' => 'Укажите проект',
    'validate_task_name' => 'Укажите название задачи',
    'check_project' => 'Выбран несуществующий проект',
    'validate_date' => 'Укажите срок выполнения в правильном формате: ГГГГ-ММ-ДД ЧЧ:ММ'];

if (!$user || $_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Location: /index.php');
    exit;
} elseif ($user && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_task = $_POST;

    foreach ($new_task as $key => $value) {
        if (in_array($key, $required_task) && $value == '') {
            $errors[$key] = $errors_messages[$key];
        }

        if (array_key_exists($key, $rules) && $new_task[$key] != '') {
            if ($key == 'project') {
                if ($value != 'Входящие') {
                    $result = call_user_func($rules[$key], $link, $value, $user['id']);
                } else {
                    $result = true;
                }
            } else {
                $result = call_user_func($rules[$key], $value);
            }

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
        $modal_task = renderTemplate(
            './templates/modal-task.php',
            [
                'projects' => get_projects_by_user($link, $user['id']),
                'errors' => $errors
            ]
        );
    } else {
        if (is_uploaded_file($_FILES['preview']['tmp_name'])) {
            $file_name = $_FILES['preview']['name'];
            $path = './';
            $file_url = str_replace(' ', '', $path . $file_name);
            move_uploaded_file($_FILES['preview']['tmp_name'], $file_url);
        }

        $start_date = date('Y-m-d H:i:s');
        $task_name = $new_task['name'];
        $deadline = $new_task['date'] ? $new_task['date'] : null;
        $author_id = $user['id'];
        $project_id = $new_task['project'] != 'Входящие' ? $new_task['project'] : null;
        $sql = 'INSERT INTO `tasks` (`start_date`, `task_name`, `file_name`, `file_path`, `deadline`, `author_id`, `project_id`) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssii', $start_date, $task_name, $file_name, $file_url, $deadline, $author_id, $project_id);
        mysqli_stmt_execute($stmt);
        mysqli_error($link);

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

        $modal_task = renderTemplate(
            './templates/modal-task.php',
            [
                'projects' => get_projects_by_user($link, $user['id'])
            ]
        );
    }
    $layout_content = renderTemplate(
        './templates/layout.php',
        [
            'title' => 'Дела в порядке',
            'content' => $page_content,
            'user' => $user,
            'modal_task' => $modal_task,
            'is_error' => $is_error
        ]
    );
    print ($layout_content);
}
