<?php
// функция - шаблонизатор, принимает параметры путь к файлу шаблона и данные
function renderTemplate ($template_path, $data) {
    if(is_file($template_path)) {
        foreach($data as $key => $value) {
            ${$key} = $value;
        }
        ob_start();
        require_once $template_path;
        return ob_get_clean();
    } else {
        return '';
    }
};

// функция подсчета задач по категориям, принимает параметрами массив задач и категорию
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
};
