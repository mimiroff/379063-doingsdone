<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$categories = ['Все', 'Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто'];

$tasks = [
    [
        'task' => 'Собеседование в IT компании',
        'deadline' => '01.06.2018',
        'category' => $categories[3],
        'is_done' => false
    ],
    [
        'task' => 'Выполнить тестовое задание',
        'deadline' => '25.05.2018',
        'category' => $categories[3],
        'is_done' => false
    ],
    [
        'task' => 'Сделать задание первого раздела',
        'deadline' => '21.04.2018',
        'category' => $categories[2],
        'is_done' => true
    ],
    [
        'task' => 'Встреча с другом',
        'deadline' => '22.04.2018',
        'category' => $categories[1],
        'is_done' => false
    ],
    [
        'task' => 'Купить корм для кота',
        'deadline' => 'Нет',
        'category' => $categories[4],
        'is_done' => false
    ],
    [
        'task' => 'Заказать пиццу',
        'deadline' => 'Нет',
        'category' => $categories[4],
        'is_done' => false
    ]
];
