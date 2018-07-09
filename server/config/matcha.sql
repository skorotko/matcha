-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июл 07 2018 г., 02:10
-- Версия сервера: 5.7.22
-- Версия PHP: 7.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `matcha`
--
CREATE DATABASE IF NOT EXISTS `matcha` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `matcha`;

-- --------------------------------------------------------

--
-- Структура таблицы `hash_tags`
--

CREATE TABLE `hash_tags` (
  `id` int(128) NOT NULL,
  `login` varchar(256) NOT NULL,
  `hash_tags` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users_profile`
--

CREATE TABLE `users_profile` (
  `id` int(128) NOT NULL,
  `photo` varchar(256) NOT NULL,
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `gender` varchar(256) NOT NULL,
  `sexual_pref` varchar(256) NOT NULL,
  `biography` varchar(256) DEFAULT NULL,
  `hobby` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `hash_tags`
--
ALTER TABLE `hash_tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_profile`
--
ALTER TABLE `users_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `hash_tags`
--
ALTER TABLE `hash_tags`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users_profile`
--
ALTER TABLE `users_profile`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
