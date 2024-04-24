-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 23 2024 г., 17:18
-- Версия сервера: 10.6.9-MariaDB
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tasks`
--

-- --------------------------------------------------------

--
-- Структура таблицы `importance`
--

CREATE TABLE `importance` (
  `importance_id` int(11) NOT NULL,
  `importance_degree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `importance`
--

INSERT INTO `importance` (`importance_id`, `importance_degree`) VALUES
(1, 'критично'),
(2, 'важно'),
(3, 'нормально'),
(4, 'не важно');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(1, 'не исполнено'),
(2, 'исполнено'),
(3, 'отменено');

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT current_timestamp(),
  `importance_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `status_changed` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`task_id`, `description`, `date_create`, `importance_id`, `status_id`, `status_changed`) VALUES
(7, 'Описание дела 1889', '2024-04-19 14:38:34', 1, 1, '2024-04-23 07:33:28'),
(8, 'Описание дела555888', '2024-04-20 17:42:24', 3, 2, '2024-04-23 08:05:27'),
(9, 'Описание дела 85800', '2024-04-22 06:04:03', 1, 1, '2024-04-23 09:21:22'),
(10, 'Описание дела 9999rrrr9', '2024-04-23 08:36:04', 1, 1, NULL),
(11, 'Описание дела 7777777777777777', '2024-04-23 08:47:15', 1, 1, NULL);

--
-- Триггеры `task`
--
DELIMITER $$
CREATE TRIGGER `before_status_id_update` BEFORE UPDATE ON `task` FOR EACH ROW BEGIN

if(old.status_id<>new.status_id)
then 
 set new.status_changed=CURRENT_TIMESTAMP;
end if;


END
$$
DELIMITER ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `importance`
--
ALTER TABLE `importance`
  ADD PRIMARY KEY (`importance_id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `importance_id` (`importance_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `importance`
--
ALTER TABLE `importance`
  MODIFY `importance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`importance_id`) REFERENCES `importance` (`importance_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
