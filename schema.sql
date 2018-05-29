CREATE DATABASE `doingsdone-379063` CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `doingsdone-379063`;

CREATE TABLE `users` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL,
  `password` CHAR(60) NOT NULL,
  `register_date` DATETIME NOT NULL,
  `name` VARCHAR(128) NOT NULL,
  `contacts` TEXT NOT NULL,
  `is_deleted` TINYINT(1) UNSIGNED DEFAULT 0
);

CREATE TABLE `projects` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `project_name` VARCHAR(255) NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `tasks` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `start_date` DATETIME NOT NULL,
  `end_date` DATETIME,
  `task_name` VARCHAR(255) NOT NULL,
  `file_name` VARCHAR(255),
  `file_path` VARCHAR(255),
  `deadline` DATETIME,
  `author_id` INT UNSIGNED NOT NULL,
  `project_id` INT UNSIGNED,
  FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE UNIQUE INDEX email ON `users`(`email`);
CREATE FULLTEXT INDEX task_search ON `tasks`(`task_name`);
CREATE INDEX project ON `projects`(`project_name`);
CREATE INDEX t_name ON `tasks`(`task_name`);
CREATE INDEX s_date ON `tasks`(`start_date`);
CREATE INDEX d_line ON `tasks`(`deadline`);
