INSERT INTO `users` (`email`, `password`, `register_date`, `name`, `contacts`) VALUES
  ('vasya@mail.ru', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', '2018-04-01 12:00:00', 'Василий', 'vasya@mail.ru'),
  ('valkira@mail.ru', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', '2018-04-10 12:00:00', 'Кира', 'valkira@mail.ru');

INSERT INTO `projects` (`project_name`, `user_id`) VALUES
  ('Все', 1),
  ('Входящие', 1),
  ('Учеба', 2),
  ('Работа', 1),
  ('Домашние дела', 2),
  ('Авто', 1);

INSERT INTO `tasks` (`start_date`, `end_date`, `task_name`, `file_path`, `deadline`, `author_id`, `project_id`) VALUES
  ('2018-05-01 12:00:00', NULL, 'Собеседование в IT компании', NULL, '2018-06-01 12:00:00', 1, 4),
  ('2018-05-01 12:00:00', NULL, 'Выполнить тестовое задание', NULL, '2018-05-25 12:00:00', 1, 4),
  ('2018-04-20 12:00:00', '2018-04-21 12:00:00', 'Сделать задание первого раздела', NULL, '2018-04-21 12:00:00', 2, 3),
  ('2018-04-20 12:00:00', NULL, 'Встреча с другом', NULL, '2018-04-22 12:00:00', 1, 2),
  ('2018-04-22 12:00:00', NULL, 'Купить корм для кота', NULL, NULL, 2, 5),
  ('2018-05-08 12:00:00', NULL, 'Заказать пиццу', NULL, NULL, 2, 5);

-- получить список из всех проектов для одного пользователя
SELECT * FROM `projects` WHERE `user_id` = 1;

-- получить список из всех задач для одного проекта
SELECT * FROM `tasks` WHERE `project_id` = 4;

-- пометить задачу как выполненную
UPDATE `tasks` SET `end_date` = CURDATE() WHERE `id` = 6;

-- получить все задачи для завтрашнего дня
SELECT * FROM `tasks` WHERE `deadline` = CURDATE() + INTERVAL 1 DAY;

-- обновить название задачи по её идентификатору
UPDATE `tasks` SET `task_name` = 'Купить нового кота' WHERE `id` = 5;