-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 01 2021 г., 16:26
-- Версия сервера: 10.4.8-MariaDB
-- Версия PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `isup`
--
CREATE DATABASE IF NOT EXISTS `isup` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `isup`;

-- --------------------------------------------------------

--
-- Структура таблицы `course`
--

CREATE TABLE `course` (
  `id` int(1) UNSIGNED NOT NULL,
  `number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `course`
--

INSERT INTO `course` (`id`, `number`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `discipline`
--

CREATE TABLE `discipline` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `discipline`
--

INSERT INTO `discipline` (`id`, `name`) VALUES
(1, 'МДК 05.02'),
(3, 'МДК 01.02 Русский язык с методикой преподавания');

-- --------------------------------------------------------

--
-- Структура таблицы `gdp`
--

CREATE TABLE `gdp` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `discipline_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `gdp`
--

INSERT INTO `gdp` (`id`, `group_id`, `discipline_id`, `teacher_id`) VALUES
(1, 1, 1, 1),
(5, 16, 3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `specialty_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(1) UNSIGNED NOT NULL,
  `curator_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `specialty_id`, `course_id`, `curator_id`) VALUES
(1, 'ИСП-4Б', 1, 4, 1),
(16, 'ПНК-3А', 7, 3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `lecture`
--

CREATE TABLE `lecture` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `pair_number` int(1) NOT NULL,
  `gdp_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lecture`
--

INSERT INTO `lecture` (`id`, `date`, `pair_number`, `gdp_id`) VALUES
(4, '2021-05-14', 1, 1),
(7, '2021-05-14', 2, 1),
(8, '2021-05-26', 1, 1),
(13, '2021-05-15', 1, 1),
(14, '2021-05-16', 1, 1),
(15, '2021-05-21', 1, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `reason`
--

CREATE TABLE `reason` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `reason`
--

INSERT INTO `reason` (`id`, `date_start`, `date_end`, `reason`) VALUES
(1, '2021-05-14', '2021-05-14', 'бла бла бла'),
(4, '2021-05-12', '2021-05-27', 'Дебил'),
(5, '2021-05-13', '2021-05-16', 'asdas dasd asdasdasda adsdasdsadas asddasdasdas asdasdasdasd asdasdasd '),
(6, '2021-05-06', '2021-05-23', 'asdasdas das ddsadsadsa dsadsadasd sadsadasd sdadasdas');

-- --------------------------------------------------------

--
-- Структура таблицы `result`
--

CREATE TABLE `result` (
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `lecture_id` bigint(20) UNSIGNED NOT NULL,
  `result` varchar(1) NOT NULL DEFAULT 'н',
  `reason_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `result`
--

INSERT INTO `result` (`student_id`, `lecture_id`, `result`, `reason_id`) VALUES
(4, 14, 'н', NULL),
(5, 13, 'н', NULL),
(5, 14, 'н', NULL),
(14, 13, 'н', NULL),
(17, 4, 'н', NULL),
(17, 13, 'н', NULL),
(18, 4, 'н', NULL),
(19, 4, 'н', NULL),
(21, 13, 'н', NULL),
(245, 15, 'н', NULL),
(246, 15, 'н', NULL),
(250, 15, 'н', NULL),
(251, 15, 'н', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(1) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Администратор'),
(2, 'Преподаватель');

-- --------------------------------------------------------

--
-- Структура таблицы `specialty`
--

CREATE TABLE `specialty` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `specialty`
--

INSERT INTO `specialty` (`id`, `name`, `code`) VALUES
(1, 'Информационные системы и программирование', '09.02.07'),
(7, 'Преподавание в начальных классах', '44.02.02');

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `name`, `surname`, `group_id`) VALUES
(1, 'Артём', 'Аникин', 1),
(2, 'Михаил', 'Арзамаскин', 1),
(3, 'Даниил', 'Бушуев', 1),
(4, 'Софья', 'Гуревич', 1),
(5, 'Алексей', 'Дудукин', 1),
(6, 'Никита', 'Ивашин', 1),
(7, 'Виктория', 'Кабанова', 1),
(8, 'Иван', 'Калекин', 1),
(9, 'Алина', 'Ликанова', 1),
(10, 'Евгений', 'Морозов', 1),
(11, 'Ян', 'Мохов', 1),
(12, 'Екатерина', 'Неяглова', 1),
(13, 'Алексей', 'Романов', 1),
(14, 'Владимир', 'Савин', 1),
(15, 'Егор', 'Серяков', 1),
(16, 'Андрей', 'Сотников', 1),
(17, 'Егор', 'Стенягин', 1),
(18, 'Данила', 'Тарасов', 1),
(19, 'Максим', 'Тумаков', 1),
(20, 'Артём', 'Чемидронов', 1),
(21, 'Антон', 'Шкенин', 1),
(237, 'Светлана', 'Балакирева', 16),
(238, 'Елизавета', 'Балякина', 16),
(239, 'Валерия', 'Бовина', 16),
(240, 'Кристина', 'Борисова', 16),
(241, 'Анна', 'Ваганова', 16),
(242, 'Ирина', 'Железова', 16),
(243, 'Ксения', 'Козлова', 16),
(244, 'Ольга', 'Козлова', 16),
(245, 'Юлиана', 'Комода', 16),
(246, 'Наталья', 'Корнышева', 16),
(247, 'Ирина', 'Кузина', 16),
(248, 'Александра', 'Лаптева', 16),
(249, 'Алина', 'Лукина', 16),
(250, 'Варвара', 'Малуша', 16),
(251, 'Екатерина', 'Попова', 16),
(252, 'Елена', 'Ростова', 16),
(253, 'Мария', 'Ручкина', 16),
(254, 'Ульяна', 'Рябинова', 16),
(255, 'Дарья', 'Рязанцева', 16),
(256, 'Виктория', 'Смирнова', 16),
(257, 'Наталья', 'Смирнова', 16),
(258, 'Елизавета', 'Сухарева', 16),
(259, 'Марина', 'Табакова', 16),
(260, 'Ирина', 'Толстякова', 16),
(261, 'Мария', 'Царегородцева', 16),
(262, 'Алена', 'Чиркова', 16);

-- --------------------------------------------------------

--
-- Структура таблицы `teacher`
--

CREATE TABLE `teacher` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `patronymic` varchar(50) NOT NULL,
  `role_id` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teacher`
--

INSERT INTO `teacher` (`id`, `login`, `password`, `name`, `surname`, `patronymic`, `role_id`) VALUES
(1, 'admin', '$2y$10$vsRJw6eLkSvFO2yI3Gp/AO9/a1UnWViBnZ8OAS/R0E9UYFC5a.W8e', 'admin', 'admin', 'admin', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `discipline`
--
ALTER TABLE `discipline`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gdp`
--
ALTER TABLE `gdp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `discipline_id` (`discipline_id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `curator_id` (`curator_id`),
  ADD KEY `specialty_id` (`specialty_id`);

--
-- Индексы таблицы `lecture`
--
ALTER TABLE `lecture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gdp_id` (`gdp_id`);

--
-- Индексы таблицы `reason`
--
ALTER TABLE `reason`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`student_id`,`lecture_id`),
  ADD KEY `lecture_id` (`lecture_id`),
  ADD KEY `result_ibfk_3` (`reason_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `specialty`
--
ALTER TABLE `specialty`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `course`
--
ALTER TABLE `course`
  MODIFY `id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `discipline`
--
ALTER TABLE `discipline`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `gdp`
--
ALTER TABLE `gdp`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `lecture`
--
ALTER TABLE `lecture`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `reason`
--
ALTER TABLE `reason`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `specialty`
--
ALTER TABLE `specialty`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT для таблицы `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `gdp`
--
ALTER TABLE `gdp`
  ADD CONSTRAINT `gdp_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `gdp_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`),
  ADD CONSTRAINT `gdp_ibfk_3` FOREIGN KEY (`discipline_id`) REFERENCES `discipline` (`id`);

--
-- Ограничения внешнего ключа таблицы `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `groups_ibfk_2` FOREIGN KEY (`curator_id`) REFERENCES `teacher` (`id`),
  ADD CONSTRAINT `groups_ibfk_3` FOREIGN KEY (`specialty_id`) REFERENCES `specialty` (`id`);

--
-- Ограничения внешнего ключа таблицы `lecture`
--
ALTER TABLE `lecture`
  ADD CONSTRAINT `lecture_ibfk_1` FOREIGN KEY (`gdp_id`) REFERENCES `gdp` (`id`);

--
-- Ограничения внешнего ключа таблицы `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `result_ibfk_2` FOREIGN KEY (`lecture_id`) REFERENCES `lecture` (`id`),
  ADD CONSTRAINT `result_ibfk_3` FOREIGN KEY (`reason_id`) REFERENCES `reason` (`id`);

--
-- Ограничения внешнего ключа таблицы `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Ограничения внешнего ключа таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
