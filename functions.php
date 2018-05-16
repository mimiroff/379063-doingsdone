<?php
/**
 * Функция - шаблонизатор
 *
 * @param string $template_path путь к файлу шаблона
 * @param array $data данные
 * @return string возвращает разметку
 */
function renderTemplate (string $template_path, array $data): string {
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

/**
 * Возвращает количество задач по id проекта
 *
 * @param $link соединение с БД
 * @param int $project_id номер id проекта
 * @return int Количество задач
 */
function count_tasks_by_project ($link, int $project_id): int {
    $sql = 'SELECT * FROM `tasks` WHERE `project_id` = "' . $project_id . '"';
    $result = mysqli_query($link, $sql);

    if(!$result) {
        $error = mysqli_error($link);
        print('Ошибка MySQL: ' . $error);
    }

    $records_count = mysqli_num_rows($result);

    return $records_count;
};

/**
 * Возвращает общее количество задач во всех проектах пользователя
 *
 * @param $link соединение с БД
 * @param array $projects массив проектов пользователя
 * @return int общее количество задач во всех проектах пользователя
 */
function count_total_tasks ($link, array $projects): int {
    $total = 0;
    foreach ($projects as $project) {
        $sql = 'SELECT * FROM `tasks` WHERE `project_id` = "' . $project['id'] . '"';
        $result = mysqli_query($link, $sql);

        if(!$result) {
            $error = mysqli_error($link);
            print('Ошибка MySQL: ' . $error);
        }

        $records_count = mysqli_num_rows($result);
        $total += $records_count;
    }

    return $total;
};

/**
 * функция подсчета оставшего времени до наступления срока выполнения задачи
 *
 * @param string $deadline срок выполнения задачи
 * @param int $mark рубеж значимости
 * @return bool Если время, оставшееся до наступления срока задачи меньше рубежа значимости
 * функция вернёт true, если больше - false. Если срок выполнения задачи не задан - вернёт false
 */
function count_deadline (string $deadline, int $mark): bool {
    $deadline_ts = strtotime($deadline);
    if (is_int($deadline_ts)) {
        $now = time();
        $time_delta = $deadline_ts - $now;
        if ($time_delta < $mark) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
};

/**
 * Возвращает массив проектов, созданных определенным пользователем
 *
 * @param $link соединение с БД
 * @param int $user_id номер id пользователя
 * @return array Возвращает двумерный массив ассоциативных массивов с данными проектов
 */
function get_projects_by_user ($link, int $user_id): array {
    $sql = 'SELECT * FROM `projects` WHERE `user_id` = "' . $user_id . '"';
    $result = mysqli_query($link, $sql);

    if(!$result) {
        $error = mysqli_error($link);
        print('Ошибка MySQL: ' . $error);
    }

    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $projects;
}

/**
 * Возвращает массив задач, созданных определенным пользователем
 *
 * @param $link соединение с БД
 * @param int $user_id номер id пользователя
 * @return array Возвращает двумерный массив ассоциативных массивов с данными задач
 */
function get_tasks_by_user ($link, int $user_id): array {
$sql = 'SELECT * FROM `tasks` WHERE `author_id` = "' . $user_id . '"';
    $result = mysqli_query($link, $sql);

    if(!$result) {
        $error = mysqli_error($link);
        print('Ошибка MySQL: ' . $error);
    }

    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $tasks;
};

/**
 * @param $link соединение с БД
 * @param int $project_id номер id проекта
 * @return array Возвращает двумерный массив ассоциативных массивов с данными задач
 */
function get_tasks_by_project ($link, int $project_id): array {
    $sql = 'SELECT * FROM `tasks` WHERE `project_id` = "' . $project_id . '"';
    $result = mysqli_query($link, $sql);

    if(!$result) {
        $error = mysqli_error($link);
        print('Ошибка MySQL: ' . $error);
    }

    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $tasks;
};

/**
 * @param $link соединение с БД
 * @param int $project_id номер id проекта
 * @param int $user_id номер id пользователя
 * @return bool возвращает true, если проект найден, возвращает false, если проект не найден
 */
function check_project ($link, int $project_id, int $user_id): bool {
    $sql = 'SELECT * FROM `projects` WHERE `id` = "' . $project_id . '" AND `user_id`= "' . $user_id . '"';
    $result = mysqli_query($link, $sql);

    if(!$result) {
        $error = mysqli_error($link);
        print('Ошибка MySQL: ' . $error);
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC) ? true : false;
};
