<?php

require_once 'functions.php';
require_once 'init.php';

$page = renderTemplate(
    './templates/guest.php',
    [
        'title' => 'Дела в порядке'
    ]
);

print($page);