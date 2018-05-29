<?php
require_once 'init.php';
require_once 'functions.php';
require_once 'vendor/autoload.php';

$transport = new Swift_SmtpTransport('phpdemo.ru', 25);
$transport->setUsername('keks@phpdemo.ru');
$transport->setPassword('htmlacademy');

$mailer = new Swift_Mailer($transport);

$message = new Swift_Message('Уведомление от сервиса «Дела в порядке»');
$message->setFrom(	'keks@phpdemo.ru');
$message->setContentType('text/plain');

$hot_tasks = get_hot_tasks($link, 3600);
var_dump($hot_tasks);

foreach ($hot_tasks as $task) {
    $message->setTo($task['email']);
    $message->setBody('Уважаемый(ая), ' . $task['name'] . '. У вас запланированна задача ' . $task['task_name'] . ' на ' . $task['deadline'] . '.');
    $mailer->send($message);
};
