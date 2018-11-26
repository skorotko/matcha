-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Сен 20 2018 г., 00:40
-- Версия сервера: 5.7.22
-- Версия PHP: 7.1.19

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

-- --------------------------------------------------------

--
-- Структура таблицы `all_profile_photos`
--

CREATE TABLE `all_profile_photos` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(256) NOT NULL,
  `path` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `all_profile_photos`
--

INSERT INTO `all_profile_photos` (`id`, `login`, `path`) VALUES
(1, 'asdrasd', ',,,,'),
(2, 'wotedam', ',,,,'),
(3, 'cuvaguhada', ',,,,'),
(4, 'cegeji', ',,,,'),
(5, 'vadeguyiri', ',,,,'),
(6, 'vipufiri', ',,,,'),
(7, 'dacewadiyi', ',,,,'),
(8, 'nutejufegi', ',,,,'),
(9, 'kojewe', ',,,,'),
(10, 'havenuwec', ',,,,'),
(13, 'skorotko', '/user_photos/5b9673158a67a.jpeg,/user_photos/sheptun.jpg,/user_photos/vsarapin.jpg,/user_photos/omelchuk.jpg,/user_photos/mkornie.jpg'),
(14, 'prytkova', ',,,,'),
(15, 'dominator', ',,,,'),
(16, 'valipan', '/user_photos/5b966debb389c.jpeg,/user_photos/5b966e20339dd.jpeg,/user_photos/5b966debbe10d.jpeg,/user_photos/5b966debc2c6c.jpeg,'),
(19, 'valipan', '/user_photos/5b966debb389c.jpeg,/user_photos/5b966e20339dd.jpeg,/user_photos/5b966debbe10d.jpeg,/user_photos/5b966debc2c6c.jpeg,'),
(20, 'Rednada', ',,,,'),
(21, 'nibo', '/user_photos/5b9673a0a53b9.jpeg,/user_photos/5b9673a0aa6b9.jpeg,/user_photos/5b9673a0aded9.jpeg,,'),
(22, 'Hello', ',,,,'),
(23, 'gaviku', '/user_photos/5b96762c26a46.jpeg,/user_photos/5b96762c3b92b.jpeg,,,'),
(24, 'kobavenine', '/user_photos/5b9678fb02244.jpeg,,,,'),
(25, 'Detka', ',,,,'),
(26, 'bitch', ',,,,'),
(27, 'midorfeed', ',,,,'),
(28, 'drish', ',,,,'),
(29, 'imsexyandiknowit', ',,,,'),
(30, 'puvakihop', ',,,,'),
(31, 'chepil', ',,,,'),
(32, 'marlyn', ',,,,'),
(33, 'cortney', ',,,,'),
(34, 'Dfcbkbq', ',,,,'),
(35, 'salami', ',,,,'),
(36, 'kroshka', ',,,,'),
(37, 'hasdh', ',,,,'),
(39, 'dominatorSS', '/user_photos/5ba23e12cdc87.jpeg,/user_photos/5ba23e139d1e7.jpeg,/user_photos/5ba23e1450ff1.jpeg,/user_photos/5ba23e145db89.jpeg,/user_photos/5ba23e4a40827.jpeg');

-- --------------------------------------------------------

--
-- Структура таблицы `base_registration_data`
--

CREATE TABLE `base_registration_data` (
  `login` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `confirmationHash` varchar(256) NOT NULL,
  `confirmationEmail` int(11) NOT NULL DEFAULT '0',
  `onlineStatus` int(11) NOT NULL DEFAULT '0',
  `loginTime` varchar(256) DEFAULT NULL,
  `logoutTime` varchar(256) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `base_registration_data`
--

INSERT INTO `base_registration_data` (`login`, `password`, `email`, `confirmationHash`, `confirmationEmail`, `onlineStatus`, `loginTime`, `logoutTime`, `rating`) VALUES
('bitch', '$2y$10$cKF.lEMix5ikJDHQdErz.exCbH.PeSpOAwbS1pHvZ68FBTeaxZEr6', 'kidus.jaydin@0ne0ak.com', ' ', 1, 0, '10-09-2018/17:00', 'Last seen 10-09-2018 at 17:02', 95),
('cegeji', '$2y$10$nWFFcUZL3mUy.rlQTIQSAey2HtXHpP6zTfqhIbAjJuqK07AUW.ixq', 'cegeji@1shivom.com', ' ', 1, 0, '07-09-2018/14:38', 'Last seen 07-09-2018 at 14:46', 122),
('chepil', '$2y$10$nq1DSc3uUj.VmVAi21aFSudUOlygcaG.CZFgN3qYFSp4gpLzAioy2', 'asdasda1@mail.ru', '', 1, 1, '10-09-2018/17:54', '', 91),
('cortney', '$2y$10$US1mw3gMVC45VKaZ0C6ZS.ojeUG602ZsGN9tykTsPGy.D1FyyVDui', 'cortney.domenick@0ne0ak.com', ' ', 1, 0, '12-09-2018/11:46', 'Last seen 12-09-2018 at 11:56', 63),
('cuvaguhada', '$2y$10$AZCYDJgwojDEEXs2enGdb.3JTh/3G4.5akUqe18RfRjTO48LnUkaq', 'cuvaguhada@zep-hyr.com', ' ', 1, 0, '07-09-2018/14:30', 'Last seen 07-09-2018 at 14:35', 91),
('Detka', '$2y$10$8hjnvKb5ninaPHcltW57aeZ5sag.cE/xbrp2jt3MKZIl5AYoj3CGG', 'zek.tawhid@0ne0ak.com', ' ', 1, 0, '10-09-2018/16:57', 'Last seen 10-09-2018 at 16:59', 96),
('Dfcbkbq', '$2y$10$T5ORsZjsjC0EYGDtlY8swuc88CZBSc5kmhKoK.hURdWu/wVgIHNcC', 'zaiden.sahel@0ne0ak.com', ' ', 1, 0, '12-09-2018/11:58', 'Last seen 12-09-2018 at 12:04', 67),
('dominator', '$2y$10$mT3/7V5CJOaMrQ.paoskFuU1lEAS0yfemRshRIla22uXrtUY3LXc.', 'yicheng.bryker@0ne0ak.com', ' ', 1, 0, '10-09-2018/16:02', 'Last seen 10-09-2018 at 16:18', 92),
('dominatorSS', '$2y$10$IMTx6maTLhPmkehaI5YqpeZeL5lfMWPHKnVyocMSkhOmuuc55HkyK', 'forjobaccss4@gmail.com', ' ', 1, 1, '19-09-2018/15:45', '', 90),
('drish', '$2y$10$pnYhy5qW7UWJc38xWhCWJO.k3swzww6DddrKKqnZvIhjqKyQjBYie', 'joandri.khoa@0ne0ak.com', ' ', 1, 0, '10-09-2018/17:05', 'Last seen 10-09-2018 at 17:10', 101),
('dsheptun', '$2y$10$yKC4mLCFZ64gF03D/SIf.OTzFM7eelgRV6WQI5GPkOSwyCuTndiB6', 'asdads@mail.ru', '', 1, 0, '06-08-2018/19:47', '', 62),
('gaviku', '$2y$10$9Ff9pv3UcxqPkP3xkhCH7O6WatyEalY130OnwZ2TjRnmfQnG8Wdk.', 'gaviku@1shivom.com', ' ', 1, 0, '10-09-2018/16:52', 'Last seen 10-09-2018 at 16:54', 97),
('hasdh', '$2y$10$SqOBNnvxJlWBWkRNX1nzTuNQK3vsPqUYPH8VzxsfrVgD9BRJU0PDy', 'asdasdasdasd@mail.ru', '', 1, 0, NULL, NULL, 0),
('havenuwec', '$2y$10$Skm4IlPUYw3ubL0.iM8mF.6kydZPB98a2gizQS5KM/Nl89hJqIWmW', 'havenuwec@pay-mon.com', ' ', 1, 1, '07-09-2018/15:52', '', 102),
('Hello', '$2y$10$IVbyBJgaWjWMrVCc8mtuqe0NGy27uXNQTST/hU.jI4HF.5T7GOQSK', 'naksh.suraj@0ne0ak.com', ' ', 1, 0, '10-09-2018/16:42', 'Last seen 10-09-2018 at 16:49', 103),
('imsexyandiknowit', '$2y$10$iw36j.oWQYlFp/KjbOiwlOGMkeQdZLl8Npf7cDbLl39r.ooy6I4ru', 'nole.mikai@0ne0ak.com', ' ', 1, 0, '10-09-2018/17:11', 'Last seen 10-09-2018 at 17:12', 94),
('ira', '$2y$10$loknGDXomQNnF2qgDN7gqO5DH22W2AVaGoy0nI3X9tx/6DGP/TfY.', 'fg.omelchuk@gmail.com', ' ', 1, 0, '31-07-2018/11:28', 'Last seen 31-07-2018 at 11:33', 92),
('kobavenine', '$2y$10$gH7MrTln1sNCtzzdxkGkQORZ1c6EpzTNYrC8SxDX4YYqtznO.2gNS', 'kobavenine@poly-swarm.com', ' ', 1, 0, '10-09-2018/16:57', 'Last seen 10-09-2018 at 17:21', 93),
('kroshka', '$2y$10$jL93.l4tQHyXctdTKi/d7O6x5hm695YIA23LKcE9e129nh/629OPq', 'szymon.asil@0ne0ak.com', ' ', 1, 0, '12-09-2018/12:13', 'Last seen 19-09-2018 at 14:57', 89),
('marlyn', '$2y$10$gQi1cT8bgu/wnrcCSGE/E.winJJorgl7h1g8.KvTRT4v69IohBOlW', 'marlyn.roni@0ne0ak.com', ' ', 1, 0, '12-09-2018/11:37', 'Last seen 12-09-2018 at 11:40', 64),
('midorfeed', '$2y$10$dj.vcF1pfMAAKmDlqtMlzux0OT.1wU/qS3jTCIyryyn5mPsp.6tO.', 'bayne.cardale@0ne0ak.com', ' ', 1, 0, '10-09-2018/17:03', 'Last seen 10-09-2018 at 17:04', 90),
('mkornie', '$2y$10$nq1DSc3uUj.VmVAi21aFSudUOlygcaG.CZFgN3qYFSp4gpLzAioy2', 'monashka@mail.ru', '', 1, 0, NULL, 'Last seen 30-07-2018 at 13:54', 106),
('nibo', '$2y$10$GECvjd4QfJixyPRm22slMONdp5wixmFxwHH0lWYXeaqDPEYzdP6uy', 'nibo@fidelium10.com', ' ', 1, 0, '10-09-2018/16:36', 'Last seen 10-09-2018 at 16:38', 108),
('nutejufegi', '$2y$10$Z13NKdj5W2YQQuz6uJBpL.bXRN6uCO1/jf7H0LiTcSz5Zh0aS.p2O', 'nutejufegi@hurify1.com', ' ', 1, 0, '07-09-2018/15:12', 'Last seen 07-09-2018 at 15:34', 167),
('prytkova', '$2y$10$nq1DSc3uUj.VmVAi21aFSudUOlygcaG.CZFgN3qYFSp4gpLzAioy2', 'as1dasda1@mail.ru', '', 1, 1, '07-09-2018/17:45', '', 153),
('puvakihop', '$2y$10$PMsuzgoelYb.MYJweXUsqOjvp.paIPnJSo.56fc/kct6N574Ycu.W', 'puvakihop@zippiex.com', ' ', 1, 0, '10-09-2018/17:22', 'Last seen 10-09-2018 at 17:25', 97),
('Rednada', '$2y$10$HrHb0xsSFEridiJvoDjl.uGfet0VvmTjPKsl4egVryUO7iqNt86MG', 'rourke.leomar@0ne0ak.com', ' ', 1, 1, '10-09-2018/16:19', '', 93),
('salami', '$2y$10$apoE7r2hHl17teE0Y2Kge.OL1D2coL7DBcX/VTJRwfQKlb9ot1sCS', 'astin.thanh@0ne0ak.com', ' ', 1, 0, '12-09-2018/12:06', 'Last seen 12-09-2018 at 12:11', 117),
('skorotko', '$2y$10$wM5OC0eC8W88w2InXoUdoepaPDA0K8uuzwk.1vU7Dkq1EI6zAjPjq', 'korotkovsergey967@gmail.com', ' ', 1, 0, '10-09-2018/17:44', 'Last seen 10-09-2018 at 18:21', 102),
('Tolik', '$2y$10$nq1DSc3uUj.VmVAi21aFSudUOlygcaG.CZFgN3qYFSp4gpLzAioy2', 'dmitry.sheptun@gmail.com', '', 1, 0, '23-08-2018/12:45', 'Last seen 23-08-2018 at 13:07', 83),
('vadeguyiri', '$2y$10$bA48Bqujt1rWkJZq/hNbpexcViuaCeUGkCXr8gdXc35WUfn8Pur6W', 'vadeguyiri@hurify1.com', ' ', 1, 0, '07-09-2018/14:47', 'Last seen 07-09-2018 at 14:51', 99),
('valipan', '$2y$10$023XsH52PBFBF57rZ11cneLeJVZ53LayTQE/35C.MC2KJOZMYq93C', 'valipan@hurify1.com', ' ', 1, 0, '10-09-2018/16:05', 'Last seen 10-09-2018 at 16:18', 90),
('vipufiri', '$2y$10$b.HpQvMb6BkVUCyz14F7IOP3tcYd8tmBXAfsu.QtAFrzWwEPfQLp2', 'vipufiri@travala10.com', ' ', 1, 0, '07-09-2018/14:52', 'Last seen 07-09-2018 at 14:57', 91),
('vomelchu', '$2y$10$nq1DSc3uUj.VmVAi21aFSudUOlygcaG.CZFgN3qYFSp4gpLzAioy2', 'asd@gmail.com', ' ', 1, 0, '30-07-2018/13:55', 'Last seen 30-07-2018 at 13:56', 123),
('vtolochk', '$2y$10$nq1DSc3uUj.VmVAi21aFSudUOlygcaG.CZFgN3qYFSp4gpLzAioy2', 'vtolochk@gmail.com', '', 1, 0, NULL, 'Last seen 31-07-2018 at 11:33', 109),
('wotedam', '$2y$10$XM.LLYqebyjDFokSNU0Pd.6qklEUGfAyE9/m/PuQP01iryfA3gDG.', 'wotedam@bit-degree.com', ' ', 1, 0, '07-09-2018/14:16', 'Last seen 07-09-2018 at 14:26', 119);

-- --------------------------------------------------------

--
-- Структура таблицы `hash_tags`
--

CREATE TABLE `hash_tags` (
  `newid` int(10) UNSIGNED NOT NULL,
  `login` varchar(256) NOT NULL,
  `hash_tags` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `hash_tags`
--

INSERT INTO `hash_tags` (`newid`, `login`, `hash_tags`) VALUES
(5, 'dsheptun', '#astronomy'),
(6, 'prytkova', '#sex'),
(7, 'vomelchu', '#space'),
(9, 'prytkova', '#astronomy'),
(11, 'ira', '#astronomy'),
(12, 'ira', '#space'),
(13, 'dsheptun', '#sex'),
(14, 'mkornie', '#sex'),
(36, 'wotedam', '#sex'),
(37, 'wotedam', '#drugs'),
(38, 'wotedam', '#whore'),
(39, 'wotedam', '#books'),
(40, 'wotedam', '#song'),
(44, 'cuvaguhada', '#money'),
(45, 'cuvaguhada', '#honey'),
(46, 'cuvaguhada', '#cars'),
(176, 'cegeji', '#vitala'),
(177, 'cegeji', '#vodka'),
(178, 'cegeji', '#game'),
(179, 'vadeguyiri', '#lesbi'),
(180, 'vadeguyiri', '#sex'),
(181, 'vadeguyiri', '#mashanonemasha'),
(182, 'vipufiri', '#love'),
(183, 'vipufiri', '#cat'),
(184, 'vipufiri', '#dog'),
(185, 'vipufiri', '#mashanonemasha'),
(186, 'vipufiri', '#sex'),
(188, 'nutejufegi', '#drugs'),
(189, 'nutejufegi', '#porn'),
(190, 'nutejufegi', '#sex'),
(202, 'havenuwec', '#sex'),
(203, 'havenuwec', '#drugs'),
(204, 'havenuwec', '#mashanonemasha'),
(252, 'dominator', '#films '),
(253, 'dominator', '#porn'),
(269, 'valipan', '#sex'),
(270, 'valipan', '#drugs'),
(271, 'valipan', '#gun'),
(292, 'Rednada', '#dog'),
(293, 'Rednada', '#dogs'),
(309, 'nibo', '#astronomy'),
(310, 'nibo', '#food'),
(311, 'nibo', '#drink'),
(312, 'Hello', '#kiev '),
(313, 'Hello', '#astronomy'),
(317, 'gaviku', '#food'),
(318, 'gaviku', '#sex'),
(319, 'gaviku', '#astronomy'),
(320, 'Detka', '#space '),
(321, 'Detka', '#world '),
(322, 'Detka', '#Kiev'),
(326, 'kobavenine', '#sex'),
(327, 'kobavenine', '#drugs'),
(328, 'kobavenine', '#porn'),
(329, 'bitch', '#sex '),
(330, 'bitch', '#sexy '),
(331, 'bitch', '#bitch'),
(332, 'midorfeed', '#dota2'),
(333, 'drish', '#love '),
(334, 'drish', '#sleep '),
(335, 'drish', '#dota2'),
(336, 'imsexyandiknowit', '#glasses'),
(337, 'puvakihop', '#sex '),
(338, 'puvakihop', '#gun'),
(339, 'vtolochk', '#sex'),
(340, 'Tolik', '#sex'),
(342, 'chepil', '#sex'),
(343, 'chepil', '#cash'),
(344, 'skorotko', '#sex'),
(368, 'salami', '#ss'),
(369, 'salami', '#qq'),
(370, 'salami', '#ss'),
(371, 'salami', '#qq'),
(372, 'salami', '#ss'),
(373, 'salami', '#qq'),
(374, 'salami', '#ss'),
(375, 'salami', '#qq'),
(376, 'salami', '#ss'),
(377, 'salami', '#qq'),
(378, 'salami', '#ss'),
(379, 'salami', '#qq'),
(380, 'salami', '#ss'),
(381, 'salami', '#qq'),
(382, 'salami', '#ss'),
(383, 'salami', '#qq'),
(384, 'salami', '#ss'),
(385, 'salami', '#qq'),
(386, 'salami', '#ss'),
(387, 'salami', '#qq'),
(388, 'kroshka', '#adas'),
(389, 'kroshka', '#true'),
(390, 'kroshka', '#false'),
(550, 'dominatorSS', '#asdasd'),
(551, 'dominatorSS', '#asd'),
(552, 'dominatorSS', '#ads1111'),
(553, 'dominatorSS', '#sex');

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `newid` int(10) UNSIGNED NOT NULL,
  `login` varchar(256) NOT NULL,
  `liked_users` varchar(2000) NOT NULL DEFAULT '',
  `messages` int(11) NOT NULL DEFAULT '0',
  `notifications` int(40) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`newid`, `login`, `liked_users`, `messages`, `notifications`) VALUES
(1, 'Tolik', '', 0, 9),
(2, 'chepil', '/skorotko', 0, 6),
(3, 'dsheptun', '', 0, 2),
(4, 'ira', '', 0, 2),
(5, 'prytkova', '', 0, 10),
(7, 'vomelchu', '', 0, 12),
(9, 'vtolochk', '', 0, 5),
(10, 'mkornie', '', 0, 9),
(21, 'skorotko', '/chepil', 0, 0),
(22, 'wotedam', '', 0, 25),
(23, 'cuvaguhada', '', 0, 0),
(24, 'cuvaguhada', '', 0, 0),
(48, 'cegeji', '', 0, 9),
(69, 'vadeguyiri', '', 0, 7),
(70, 'vipufiri', '', 0, 0),
(71, 'nutejufegi', '', 0, 10),
(72, 'nutejufegi', '', 0, 10),
(73, 'nutejufegi', '', 0, 10),
(74, 'nutejufegi', '', 0, 10),
(75, 'nutejufegi', '', 0, 10),
(76, 'havenuwec', '', 0, 11),
(77, 'havenuwec', '', 0, 11),
(78, 'havenuwec', '', 0, 11),
(79, 'dominator', '', 0, 2),
(80, 'valipan', '', 0, 0),
(81, 'Rednada', '', 0, 3),
(82, 'nibo', '', 0, 9),
(83, 'Hello', '', 0, 13),
(84, 'gaviku', '/dsheptun', 0, 7),
(85, 'Detka', '', 0, 6),
(86, 'kobavenine', '', 0, 3),
(87, 'bitch', '', 0, 5),
(88, 'midorfeed', '', 0, 0),
(89, 'drish', '', 0, 11),
(90, 'imsexyandiknowit', '', 0, 4),
(91, 'puvakihop', '', 0, 7),
(92, 'marlyn', '', 0, 4),
(93, 'cortney', '', 0, 3),
(94, 'Dfcbkbq', '', 0, 7),
(95, 'Dfcbkbq', '', 0, 7),
(96, 'salami', '', 0, 27),
(97, 'salami', '', 0, 27),
(98, 'salami', '', 0, 27),
(99, 'salami', '', 0, 27),
(100, 'salami', '', 0, 27),
(101, 'salami', '', 0, 27),
(102, 'salami', '', 0, 27),
(103, 'salami', '', 0, 27),
(104, 'salami', '', 0, 27),
(105, 'salami', '', 0, 27),
(106, 'salami', '', 0, 27),
(107, 'salami', '', 0, 27),
(108, 'kroshka', '', 0, 9),
(109, 'dominatorSS', '', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `personal_likes`
--

CREATE TABLE `personal_likes` (
  `newid` int(10) UNSIGNED NOT NULL,
  `from_user` varchar(256) NOT NULL,
  `to_user` varchar(256) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `personal_likes`
--

INSERT INTO `personal_likes` (`newid`, `from_user`, `to_user`, `count`) VALUES
(1, 'skorotko', 'chepil', 0),
(2, 'chepil', 'skorotko', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users_profile`
--

CREATE TABLE `users_profile` (
  `newid` int(10) UNSIGNED NOT NULL,
  `login` varchar(256) NOT NULL,
  `photo` varchar(256) NOT NULL,
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `gender` varchar(256) NOT NULL,
  `sexual_pref` varchar(256) NOT NULL,
  `birthday` varchar(256) NOT NULL,
  `biography` text,
  `hobby` text,
  `location` varchar(256) NOT NULL,
  `city` varchar(256) DEFAULT NULL,
  `children` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `education` int(11) DEFAULT NULL,
  `attitude` varchar(256) DEFAULT NULL,
  `rating` int(11) DEFAULT '0',
  `blockedUsers` text,
  `SeenUsers` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_profile`
--

INSERT INTO `users_profile` (`newid`, `login`, `photo`, `first_name`, `last_name`, `gender`, `sexual_pref`, `birthday`, `biography`, `hobby`, `location`, `city`, `children`, `height`, `education`, `attitude`, `rating`, `blockedUsers`, `SeenUsers`) VALUES
(2, 'vomelchu', '/user_photos/omelchuk.jpg', 'vadim', 'omelchuk', 'Male', 'Heterosexual', '1990-05-02', 'Я бисексуал и я доволен своей жизнью', '', '50.464061/30.478856', 'Kiev', 0, 150, 1, 'religious', 123, NULL, NULL),
(4, 'dsheptun', '/user_photos/sheptun.jpg', 'dima', 'sheptun', 'Male', 'Heterosexual', '1989-04-02', 'Мы будем делать следующий проект вместе, поэтому я тут', '', '50.460494/30.504143', 'Kiev', 1, 170, 1, 'atheist', 62, NULL, NULL),
(5, 'chepil', '/user_photos/chepil.jpg', 'misha', 'chepil', 'Male', 'Bisexual', '1997-05-01', 'Я не хожу в юнит потому что я работаю непонятно где и зачем, если у меня есть такая классная возможность научиться кодить', '#sex #cash', '50.108535/30.481056', 'Kiev', 1, 180, 0, 'atheist', 91, '.skorotko.', '.skorotko.skorotko.skorotko.skorotko'),
(6, 'prytkova', '/user_photos/prytkova.jpg', 'ksusha', 'prytkova', 'Female', 'Heterosexual', '1994-05-02', 'Я где-то проебалась на целый месяц и не отвечаю Виталику', '', '50.474632/30.500614', 'Kiev', 0, 190, 1, 'atheist', 153, NULL, NULL),
(7, 'ira', '/user_photos/inovykov.jpg', 'Iryna', 'Novykova', 'Female', 'Homosexual', '1997-05-02', 'Я люблю юнит, я делаю фрактол', '', '50.464208899999996/30.466489', 'Kiev', 0, 200, 0, 'follow', 92, NULL, NULL),
(8, 'mkornie', '/user_photos/mkornie.jpg', 'masha', 'no ne masha', 'Female', 'Bisexual', '1992-02-05', 'Люблю грязный секс и пошлости на кухне. Я рождена не для кухни, а для куни.$hello #sex #astronomy &lt;script&gt;alert(&quot;hello&quot;)&lt;/script', '', '50.476325/30.454953', 'Moscow', 0, 210, 1, 'follow', 106, NULL, NULL),
(9, 'vtolochk', '/user_photos/vtolochk.jpg', 'valik', 'tolochko', 'Male', 'Heterosexual', '1996-02-05', 'Ну я люблю кодить и я люблю бабки. Еще люблю кодить за бабки и качать бицуху.', '', '50.492436/30.418217', 'Berlin', 0, 219, 0, 'follow', 109, NULL, NULL),
(25, 'Tolik', '/user_photos/5b69799119a4c.jpeg', 'Aasd', 'Asd', 'Male', 'Bisexual', '2000-08-07', NULL, NULL, '50.468432199999995/30.4528628', 'Kiev', 0, 150, 0, 'atheist', 83, '', NULL),
(28, 'skorotko', '/user_photos/5b7069bc7d0f7.jpeg', 'Фрося', 'Лося', 'Male', 'Homosexual', '1996-08-08', 'Не воровка и не шалава', '#sex', '50.4233/30.5167', 'Kiev', 0, 220, 1, 'follow', 102, '', '.wotedam.wotedam.wotedam.chepil.chepil'),
(29, 'wotedam', '/user_photos/5b9260362e178.jpeg', 'Volter', 'Smith', 'Male', 'Bisexual', '1996-05-08', 'Одинокий мужчина в самом соку! Выбери меня и умрешь от оргазмов.', '#sex #drugs #whore #books #song', '50.4353/30.5167', 'Kiev', 1, 220, 1, 'follow', 119, NULL, NULL),
(30, 'cuvaguhada', '/user_photos/5b9261fd2e653.jpeg', 'Евпатий', 'Захарченко', 'Male', 'Homosexual', '1996-01-28', 'Слегка взорвали, детка я горяч иди ко мне!', '#money #honey #cars', '50.4331/30.5167', 'Kiev', 0, 150, 0, 'atheist', 91, NULL, NULL),
(32, 'cegeji', '/user_photos/5b92641573cfe.jpeg', 'Janna', 'Заглохина', 'Female', 'Heterosexual', '1996-02-07', 'Я люблю Виталика, а он меня нет, помогите(((', '#vitala #vodka #game', '51.4333/31.5167', 'Kiev', 0, 184, 1, 'follow', 122, NULL, NULL),
(76, 'vadeguyiri', '/user_photos/5b9265ca36401.jpeg', 'Larisa', 'Petrova', 'Female', 'Homosexual', '2000-01-19', 'I love sex with my girl', '#lesbi #sex #mashanonemasha', '50.4333/30.5167', 'Kiev', 1, 189, 1, 'atheist', 99, NULL, NULL),
(77, 'vipufiri', '/user_photos/5b9267390b60a.jpeg', 'Vano', 'Langebrad', 'Male', 'Homosexual', '1999-09-16', 'я ебу собак, я ебу котов. 150 см это не рост, а длина.', '#love #cat #dog #mashanonemasha #sex', '50.4333/30.5167', 'Kiev', 0, 150, 0, 'follow', 91, NULL, NULL),
(78, 'nutejufegi', '/user_photos/5b926f9e7fa71.jpeg', 'Лариса', 'Крофт', 'Female', 'Bisexual', '1998-08-26', 'Оружие мое все.', '#sex #drugs #porn', '50.4333/30.5167', 'Georgia', 1, 189, 1, 'follow', 167, NULL, NULL),
(85, 'havenuwec', '/user_photos/5b9274d769d5a.jpeg', 'Volodia', 'Putin', 'Male', 'Bisexual', '1998-05-28', 'I love Ukraine and Crimea and Donbass.\n#sex #drugs #mashanonemasha', '#sex #drugs #mashanonemasha', '50.4333/30.5167', 'Kiev', 1, 177, 1, 'atheist', 102, NULL, NULL),
(86, 'dominator', '/user_photos/5b966d4635170.jpeg', 'Jim', 'Carrey', 'Male', 'Heterosexual', '1996-09-11', 'Love my films', '#films #porn', '50.4333/30.5167', 'Kyiv', 1, 188, 1, 'atheist', 92, NULL, NULL),
(87, 'valipan', '/user_photos/5b966d7624b20.jpeg', 'Valera', 'Obolon', 'Male', 'Homosexual', '1996-06-24', 'Ты просто погляди на мой ствол детка, напиши мне и ты почувствуешь его', '#sex #drugs #gun', '50.4333/30.5167', 'Kyiv', 1, 162, 1, 'religious', 90, NULL, NULL),
(88, 'Rednada', '/user_photos/5b966fb283e1e.jpeg', 'Vasilii', 'Petrovich', 'Male', 'Heterosexual', '2018-09-08', 'Lubli sobachek', '#dog #dogs', '50.4333/30.5167', 'Kyiv', 1, 198, 1, 'follow', 93, NULL, NULL),
(89, 'nibo', '/user_photos/5b96713126708.jpeg', 'Gennadiy', 'Petrovich', 'Male', 'Bisexual', '2018-09-08', 'Сантехник бисексуал ищет друзей', '#astronomy #food #drink', '50.4312/30.5187', 'Kyiv', 1, 170, 1, 'follow', 108, NULL, NULL),
(90, 'Hello', '/user_photos/5b9675ae2c7c6.jpeg', 'Lilya', 'Vasuta', 'Female', 'Bisexual', '1996-08-07', 'Love Kyiv', '#kiev &lt;script&gt;alert(&quot;hello&quot;)&lt;/script&gt; #astronomy', '50.4333/30.5167', 'Kyiv', 0, 187, 1, 'religious', 103, NULL, '.nibo'),
(91, 'gaviku', '/user_photos/5b9675b063fa5.jpeg', 'Luba', 'Vdotia', 'Female', 'Heterosexual', '1999-08-11', 'Люблю булочки и ватрушки, если ты пекарь, мы сойдемся.', '#food #sex #astronomy', '50.4333/30.5167', 'Kyiv', 0, 168, 1, 'follow', 97, NULL, '.nibo.nibo.nibo.nibo.nibo'),
(92, 'Detka', '/user_photos/5b9678704da58.jpeg', 'Yulka', 'Mulka', 'Male', 'Bisexual', '2018-09-10', 'Ya krasavica', '#space #world #Kiev', '50.4113/30.5167', 'Kyiv', 1, 188, 0, 'follow', 96, NULL, '.cuvaguhada'),
(93, 'kobavenine', '/user_photos/5b9678cbae083.jpeg', 'Shabla', 'Petrovna', 'Female', 'Homosexual', '2018-09-09', 'Худая, тупая, Виталик one love.', '#sex #drugs #porn', '50.4333/30.5167', 'Kyiv', 1, 168, 0, 'follow', 93, NULL, NULL),
(94, 'bitch', '/user_photos/5b96796fc8365.jpeg', 'Sexy', 'Bitch', 'Female', 'Homosexual', '1997-12-25', 'Zabila pobrit podmihi', '#sex #sexy #bitch', '50.4333/30.5167', 'Kyiv', 0, 164, 1, 'follow', 95, NULL, NULL),
(95, 'midorfeed', '/user_photos/5b9679ddec0be.jpeg', 'Daite', 'Supporta', 'Male', 'Homosexual', '2018-09-10', 'Lublu fidit midera', '#dota2', '50.4333/30.5167', 'Kyiv', 1, 183, 1, 'follow', 90, NULL, NULL),
(96, 'drish', '/user_photos/5b967a5208ef9.jpeg', 'Loveto', 'Sleep', 'Male', 'Heterosexual', '1997-11-27', 'Love to sleep', '#love #sleep #dota2', '50.3233/30.5267', 'Kyiv', 0, 179, 1, 'atheist', 101, NULL, NULL),
(97, 'imsexyandiknowit', '/user_photos/5b967bc7a35c2.jpeg', 'Best', 'Of the best', 'Male', 'Heterosexual', '1998-12-25', 'Love Glasses', '#glasses', '50.4863/30.5167', 'Kyiv', 1, 198, 1, 'follow', 94, NULL, '.skorotko'),
(98, 'puvakihop', '/user_photos/5b967eb3e3d07.jpeg', 'Alka', 'Pygacheva', 'Female', 'Bisexual', '1998-12-11', 'Секс, наркотики, рок-н-ролл', '#sex #gun', '50.4103/30.5167', 'Kyiv', 1, 171, 1, 'follow', 97, NULL, NULL),
(99, 'marlyn', '/user_photos/5b98d0f046e40.jpeg', 'Миша', 'Вася', 'Male', 'Bisexual', '2018-09-12', NULL, NULL, '50.4073/30.5167', 'Kyiv', 0, 150, 0, 'atheist', 64, NULL, NULL),
(100, 'cortney', '/user_photos/5b98d348033c3.jpeg', 'Вася', 'Пупкин', 'Male', 'Bisexual', '2018-09-12', NULL, NULL, '50.4312/30.5167', 'Kyiv', 0, 150, 0, 'atheist', 63, NULL, NULL),
(102, 'Dfcbkbq', '/user_photos/5b98d6525a14e.jpeg', 'Сказка', 'Позняки', 'Male', 'Bisexual', '2018-09-12', NULL, NULL, '50.4333/30.5167', 'Kyiv', 0, 150, 0, 'atheist', 67, NULL, NULL),
(114, 'salami', '/user_photos/5b98d763f0eab.jpeg', 'Кто', 'Я такой', 'Male', 'Bisexual', '2018-09-12', '#Скачзка#приветжопа#фыв#ss#qq', '#Скачзка#приветжопа#фыв#ss#qq', '50.4333/30.5167', 'Kyiv', 0, 150, 0, 'atheist', 117, NULL, NULL),
(115, 'kroshka', '/user_photos/5b98d93e743c1.jpeg', 'Ab', 'Be', 'Male', 'Bisexual', '2018-09-12', NULL, '$sdfsd $фывыва #adas#боже#какой#мужчина#true#false', '50.4333/30.5167', 'Kyiv', 0, 150, 0, 'atheist', 89, NULL, '.salami'),
(116, 'dominatorSS', '/user_photos/5ba23dfe70d1c.jpeg', 'Виталик', 'Ыывфыв', 'Female', 'Bisexual', '2018-09-03', 'ALLEN KIM\nMy thoughts\nHow to make your own bittorrent client\nMAY 4TH, 2016\nTable of Contents\n\nIntroduction\nAbout this guide\nOverview of bittorrent\nLinks and references\nOpening the torrent file\nBencode\nGetting peers via the tracker\nHttp vs udp vs tcp\nSen', ' #asdasd #asd #ads1111 #sex', '50.4333/30.5167', 'Kyiv', 0, 190, 1, 'follow', 90, NULL, '.gaviku.drish.cegeji.prytkova.vomelchu');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `all_profile_photos`
--
ALTER TABLE `all_profile_photos`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `base_registration_data`
--
ALTER TABLE `base_registration_data`
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `hash_tags`
--
ALTER TABLE `hash_tags`
  ADD PRIMARY KEY (`newid`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`newid`);

--
-- Индексы таблицы `personal_likes`
--
ALTER TABLE `personal_likes`
  ADD PRIMARY KEY (`newid`);

--
-- Индексы таблицы `users_profile`
--
ALTER TABLE `users_profile`
  ADD PRIMARY KEY (`newid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `all_profile_photos`
--
ALTER TABLE `all_profile_photos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `hash_tags`
--
ALTER TABLE `hash_tags`
  MODIFY `newid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=554;

--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `newid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT для таблицы `personal_likes`
--
ALTER TABLE `personal_likes`
  MODIFY `newid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users_profile`
--
ALTER TABLE `users_profile`
  MODIFY `newid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
