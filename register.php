<?php

require_once 'init.php';
require_once 'functions.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
session_start();
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

$required = ['name', 'password', 'email'];
$errors = [];
$values = [];
$rules = ['email' => 'validate_email'];
$errors_messages = ['name' => 'Укажите своё имя',
    'password' => 'Укажите пароль',
    'validate_email' => 'Неверный формат адреса электронной почты',
    'email' => 'Укажите адрес электронной почты',
    'check_email' => 'Данный адрес почты уже занят'];

if ($user) {
    header('Location: /index.php');
    exit;
} else {

    $modal_auth = renderTemplate(
        './templates/modal-auth.php',
        [
            'origin' => 'register.php'
        ]
    );

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $page_content = renderTemplate(
            './templates/register.php',
            [
                'modal_auth' => $modal_auth
            ]
        );
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $registration = $_POST;

        foreach ($registration as $key => $value) {
            if (in_array($key, $required) && $value == '') {
                $errors[$key] = $errors_messages[$key];
            } else {
                $values[$key] = $value;
            }
        }

        if ($registration['email'] != '') {
            $result = validate_email($registration['email']);

            if (!$result) {
                $errors['email'] = $errors_messages['validate_email'];
            } else {
                $result = check_email($link, $registration['email']);

                if (!$result) {
                    $errors['email'] = $errors_messages['check_email'];
                }
            }
        }

        if ($errors) {
            $page_content = renderTemplate(
                './templates/register.php',
                [
                    'errors' => $errors,
                    'values' => $values,
                    'modal_auth' => $modal_auth
                ]
            );
        } else {

            $registration_date = date('Y-m-d H:i:s');
            $email = $registration['email'];
            $password = password_hash($registration['password'], PASSWORD_BCRYPT);
            $name = $registration['name'];

            $sql = 'INSERT INTO `users` (`email`, `password`, `register_date`, `name`, `contacts`) VALUES (?, ?, ?, ?, ?)';
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, 'sssss', $email, $password, $registration_date, $name, $email);
            mysqli_stmt_execute($stmt);
            mysqli_error($link);

            $user = search_user_by_email($link, $email);
            $_SESSION['user'] = $user;
            header('Location: /index.php');
            exit;
        }
    }
}

$layout_content = renderTemplate(
    './templates/layout.php',
    [
        'title' => 'Дела в порядке',
        'content' => $page_content,
        'modal_auth' => $modal_auth
    ]
);

print($layout_content);
