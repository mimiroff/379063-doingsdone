<?php
require_once('functions.php');
require_once('init.php');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$is_error = false;
$required = ['email', 'password'];
$errors = [];
$errors_messages = [
                    'required' => [
                                     'email' => 'Введите свой email',
                                     'password' => 'Введите пароль'
                                  ],
                    'auth' => [
                                'email' => 'Такой пользователь не найден',
                                'password' => 'Вы ввели неверный пароль'
                    ]
];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = $_POST;
    $origin = $_POST['origin'];

    foreach ($fields as $key => $value) {
        if (in_array($key, $required) && $value == '') {
            $errors[$key] = $errors_messages['required'][$key];
        }
    }
    if (empty($errors)) {
        $user = search_user_by_email($link, $fields['email']);
        if (!empty($user)) {
            if (password_verify($fields['password'], $user['password'])) {
                $_SESSION['user'] = $user;
            } else {
                $errors['password'] = $errors_messages['auth']['password'];
            }
        } else {
            $errors['email'] = $errors_messages['auth']['email'];
        }
    }

    if (!empty($errors)) {
        $is_error = true;
        $modal_auth = renderTemplate(
            './templates/modal-auth.php',
            [
                'values' => $fields,
                'errors' => $errors,
                'origin' => $origin
            ]
        );

        if ($origin == 'register.php') {
            $page_content = renderTemplate(
                './templates/' . $origin .'',
                ['modal_auth' => $modal_auth]
            );
        } else {
            $page_content = renderTemplate(
                './templates/' . $origin .'',
                []
            );
        }
    } else {
        header('Location: /index.php');
        exit();
    }
    $layout_content = renderTemplate(
        './templates/layout.php',
        [
            'title' => 'Дела в порядке',
            'content' => $page_content,
            'modal_auth' => $modal_auth,
            'is_error' => $is_error
        ]
    );

    print($layout_content);
}


