<?php

require_once 'functions.php';
require_once 'init.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

$FILTERS = ['Все задачи', 'Повестка дня', 'Завтра', 'Просроченные'];

$project_id = isset($_SESSION['project_id']) ? (int)$_SESSION['project_id'] : 0;
$show_completed = isset($_SESSION['show_completed']) ? (int)$_SESSION['show_completed'] : 0;
$active_filter = isset($_SESSION['active_filter']) ? (int)$_SESSION['active_filter'] : 0;
$project_errors = [];
$task_errors = [];
$is_error = false;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($user)) {
    $tasks = [];

    if (isset($_GET['show_completed'])) {
        $show_completed = $_GET['show_completed'];
        $_SESSION['show_completed'] = $show_completed;
        header('Location: /index.php');
        exit;
    }

    if (isset($_GET['task_id'])) {
        $task_id = (int)$_GET['task_id'];
        $task = get_task_by_id($link, $task_id);

        $end_date = ($_GET['check'] == '1') ? date('Y-m-d H:i:s') : null;

        $sql = 'UPDATE `tasks` SET `end_date` = ? WHERE `id` = ?';
        $stmt = mysqli_prepare($link, $sql);

        if (!$stmt) {
            var_dump(mysqli_error($link)); exit;
        }
        mysqli_stmt_bind_param($stmt, 'ss', $end_date, $task_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_error ($stmt);
        mysqli_error($link);

        header('Location: /index.php');
        exit;
    }
    if (isset($_GET['error'])) {
        $project_errors = isset($_SESSION['project_errors']) ? $_SESSION['project_errors'] : [];
        $task_errors = isset($_SESSION['task_errors']) ? $_SESSION['task_errors'] : [];
        $is_error = $_GET['error'];
    }
    $modal_task = renderTemplate(
        './templates/modal-task.php',
        [
            'projects' => get_projects_by_user($link, $user['id']),
            'errors' => $task_errors
        ]
    );
    $modal_project = renderTemplate(
        './templates/modal-project.php',
        [
            'errors' => $project_errors
        ]
    );

    if (isset($_GET['id'])) {
        $project_id = $_GET['id'];
        $_SESSION['project_id'] = $project_id;
        if ($_GET['id'] != 0 && check_project($link, $_GET['id'], $user['id'])) {
            $tasks = get_tasks_by_project($link, $project_id);

        } else if ($_GET['id'] == '0') {
            $tasks = get_inbox_tasks_by_user($link, $user['id']);
        }
    } else if (!isset($_GET['id'])) {
        if ($project_id == 0) {
            $tasks = get_inbox_tasks_by_user($link, $user['id']);
        } else {
            $tasks = get_tasks_by_project($link, $project_id);
        }
    } else {
        header('Status: 404, not found');
        http_response_code(404);
        print('Error! Status: ' . http_response_code());
        exit;
    }

    if (isset($_GET['filter'])) {
        $active_filter = $_GET['filter'];
        $filtered_tasks = [];
        if ($active_filter == 1) {
            $last_date = strtotime('tomorrow');
            $first_date = time();
            foreach ($tasks as $task) {
                if ($task['deadline']) {
                    $deadline = strtotime($task['deadline']);
                    if (($last_date > $deadline) && (($first_date - $deadline) < 0)) {
                        $filtered_tasks[] = $task;
                    }
                }
            }
        }
        elseif ($active_filter == 2) {
            $date = strtotime('tomorrow next day');
            foreach ($tasks as $task) {
                if ($task['deadline'] ) {
                    $deadline = strtotime($task['deadline']);
                    if (($date - $deadline) < 86400) {
                        $filtered_tasks[] = $task;
                    }
                }
            }
        }
        elseif ($active_filter == 3) {
            $date = time();
            foreach ($tasks as $task) {
                if ($task['deadline'] && !$task['end_date']) {
                    $deadline = strtotime($task['deadline']);
                    if (($deadline - $date) < 0) {
                        $filtered_tasks[] = $task;
                    }
                }
            }
        }
        elseif ($active_filter == 0) {
            $filtered_tasks = $tasks;
        }
        $tasks = $filtered_tasks;
    }
    $page_content = renderTemplate(
        './templates/index.php',
        [
            'projects' => get_projects_by_user($link, $user['id']),
            'tasks' => $tasks,
            'show_complete_tasks' => $show_completed,
            'link' => $link,
            'active' => $project_id,
            'user' => $user,
            'filters' => $FILTERS,
            'active_filter' => $active_filter
        ]
    );
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
