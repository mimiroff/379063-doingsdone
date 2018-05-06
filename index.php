<?php

require_once 'functions.php';
require_once 'data.php';

$page_content = renderTemplate(
    './templates/index.php',
    [
        'categories' => $categories,
        'tasks' => $tasks,
        'show_complete_tasks' => $show_complete_tasks
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
