<?php
require_once 'functions.php';
require_once 'init.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

$project_id = isset($_SESSION['project_id']) ? (int)$_SESSION['project_id'] : 0;

$required = ['name'];
$errors = [];
$_SESSION['project_errors'] = $errors;
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

    if (!empty($errors)) {
        $_SESSION['project_errors'] = $errors;
        header('Location: /index.php?error=true');
        exit;
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
        $_SESSION['project_errors'] = [];
        header('Location: /index.php?id=' . $project_id . '');
        exit;
    }
}
