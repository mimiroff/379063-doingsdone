<?php

require_once('functions.php');
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

function count_projects($tasks, $project) {
    $total_counter = 0;
    $project_counter = 0;
    foreach ($tasks as $task_list) {
        $total_counter++;
        foreach ($task_list as $category => $project_name) {
            if ($category == 'category' && $project_name == $project) {
                $project_counter++;
            }
        }
    }
    if ($project == 'Все') {
        return $total_counter;
    } else {
        return $project_counter;
    }
}

$page_content = renderTemplate('./templates/index.php', ['categories' => $categories, 'tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);
$layout_content = renderTemplate('./templates/layout.php', ['title' => 'Дела в порядке', 'content' => $page_content, 'user' => 'Илья']);
print($layout_content);
?>
