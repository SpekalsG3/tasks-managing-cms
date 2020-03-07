-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3308
-- Время создания: Мар 07 2020 г., 20:41
-- Версия сервера: 8.0.18
-- Версия PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testingtask`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `author` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `task` varchar(200) DEFAULT NULL,
  `done` tinyint(1) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `edited` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`author`, `email`, `task`, `done`, `id`, `edited`) VALUES
('top user', 'asdf@gmail.com', 'qwerty hello', 1, 1, 1),
('test', 'test@test.test', 'Hello World', 1, 12, 0),
('&lt;script&gt;alert()&lt;/script&gt;', 'asdf@asdf.asd', 'something (wow) interesting', 0, 26, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
