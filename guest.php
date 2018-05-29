<?php

require_once 'functions.php';
require_once 'init.php';
require_once 'vendor/autoload.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!$user) {
        $page_content = renderTemplate(
            './templates/guest.php',
            []
        );

        $modal_auth = renderTemplate(
            './templates/modal-auth.php',
            [
                'origin' => 'guest.php'
            ]
        );
    } else {
        header('Location: /index.php');
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
}
