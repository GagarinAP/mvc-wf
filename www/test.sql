/*
SQL for test examples
*/

-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Час створення: Лис 22 2014 р., 16:48
-- Версія сервера: 5.6.20
-- Версія PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База даних: `test`
--

-- --------------------------------------------------------

--
-- Структура таблиці `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
`id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(512) NOT NULL,
  `content` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп даних таблиці `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `title`, `content`, `date_created`) VALUES
(1, 0, 'test1', 'lorem ipsum dolor sit amet 1', '0000-00-00 00:00:00'),
(2, 0, 'test1', 'lorem ipsum dolor sit amet 1', '0000-00-00 00:00:00'),
(3, 0, 'test1', 'lorem ipsum dolor sit amet 1', '0000-00-00 00:00:00'),
(4, 0, '23123123', 'qwe qwe qwe ', '0000-00-00 00:00:00'),
(5, 1, 'wer ', 'we ', '2014-11-19 09:52:13'),
(6, 1, 'wer ', 'we ', '2014-11-19 09:56:11'),
(7, 1, 'wer ', 'we ', '2014-11-19 09:56:40'),
(8, 1, 'Test 3', 'Ð’ ÑÐ²ÐµÐ¶ÐµÐ¹ Ð²ÐµÑ€ÑÐ¸Ð¸ Ð”ÐµÐ½Ð²ÐµÑ€Ð° Ð¸ÑÐ¿Ñ€Ð°Ð²Ð»ÐµÐ½Ð° Ð¾ÑˆÐ¸Ð±ÐºÐ°, Ð¸Ð·-Ð·Ð° ÐºÐ¾Ñ‚Ð¾Ñ€Ð¾Ð¹ Ð² Windows 7 Ð¸Ð½Ð¾Ð³Ð´Ð° Ð½Ðµ ÑÐ¾Ð·Ð´Ð°Ð²Ð°Ð»Ð¸ÑÑŒ Ð²Ð¸Ñ€Ñ‚ÑƒÐ°Ð»ÑŒÐ½Ñ‹Ðµ Ñ…Ð¾ÑÑ‚Ñ‹.\r\nÐžÐ±Ð½Ð¾Ð²Ð¸Ð»Ð°ÑÑŒ Ð²ÐµÑ€ÑÐ¸Ñ MySQL Ð´Ð¾ 5.5 Ð¸ phpMyAdmin Ð´Ð¾ 3.5.1. Ð•ÑÐ»Ð¸ Ð²Ñ‹ Ð¾Ð±Ð½Ð¾Ð²Ð»ÑÐµÑ‚ÐµÑÑŒ ÑÐ¾ ÑÑ‚Ð°Ñ€Ð¾Ð¹ Ð²ÐµÑ€ÑÐ¸Ð¸ Ð”ÐµÐ½Ð²ÐµÑ€Ð°, ÑÐ¼. Ð¸Ð½ÑÑ‚Ñ€ÑƒÐºÑ†Ð¸Ð¸ Ð¿Ð¾ Ð¿ÐµÑ€ÐµÐ½Ð¾ÑÑƒ Ð‘Ð”.\r\nÐ£ Ð²Ð°Ñ Ð°Ð½Ð³Ð»Ð¸Ð¹ÑÐºÐ°Ñ Windows Ð¸ Ð² ÐºÐ¾Ð½ÑÐ¾Ð»Ð¸ Ð”ÐµÐ½Ð²ÐµÑ€Ð° - Ð¸ÐµÑ€Ð¾Ð³Ð»Ð¸Ñ„Ñ‹?', '2014-11-19 09:59:23'),
(9, 1, 'Test 3', 'Ð’ ÑÐ²ÐµÐ¶ÐµÐ¹ Ð²ÐµÑ€ÑÐ¸Ð¸ Ð”ÐµÐ½Ð²ÐµÑ€Ð° Ð¸ÑÐ¿Ñ€Ð°Ð²Ð»ÐµÐ½Ð° Ð¾ÑˆÐ¸Ð±ÐºÐ°, Ð¸Ð·-Ð·Ð° ÐºÐ¾Ñ‚Ð¾Ñ€Ð¾Ð¹ Ð² Windows 7 Ð¸Ð½Ð¾Ð³Ð´Ð° Ð½Ðµ ÑÐ¾Ð·Ð´Ð°Ð²Ð°Ð»Ð¸ÑÑŒ Ð²Ð¸Ñ€Ñ‚ÑƒÐ°Ð»ÑŒÐ½Ñ‹Ðµ Ñ…Ð¾ÑÑ‚Ñ‹.\r\nÐžÐ±Ð½Ð¾Ð²Ð¸Ð»Ð°ÑÑŒ Ð²ÐµÑ€ÑÐ¸Ñ MySQL Ð´Ð¾ 5.5 Ð¸ phpMyAdmin Ð´Ð¾ 3.5.1. Ð•ÑÐ»Ð¸ Ð²Ñ‹ Ð¾Ð±Ð½Ð¾Ð²Ð»ÑÐµÑ‚ÐµÑÑŒ ÑÐ¾ ÑÑ‚Ð°Ñ€Ð¾Ð¹ Ð²ÐµÑ€ÑÐ¸Ð¸ Ð”ÐµÐ½Ð²ÐµÑ€Ð°, ÑÐ¼. Ð¸Ð½ÑÑ‚Ñ€ÑƒÐºÑ†Ð¸Ð¸ Ð¿Ð¾ Ð¿ÐµÑ€ÐµÐ½Ð¾ÑÑƒ Ð‘Ð”.\r\nÐ£ Ð²Ð°Ñ Ð°Ð½Ð³Ð»Ð¸Ð¹ÑÐºÐ°Ñ Windows Ð¸ Ð² ÐºÐ¾Ð½ÑÐ¾Ð»Ð¸ Ð”ÐµÐ½Ð²ÐµÑ€Ð° - Ð¸ÐµÑ€Ð¾Ð³Ð»Ð¸Ñ„Ñ‹?', '2014-11-19 09:59:23');

-- --------------------------------------------------------

--
-- Структура таблиці `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
`id` bigint(20) unsigned NOT NULL,
  `user` varchar(32) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `text` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп даних таблиці `messages`
--

INSERT INTO `messages` (`id`, `user`, `date`, `text`) VALUES
(1, 'Vasya', '2014-11-22 13:44:17', 'Сдесь был Вася!'),
(2, 'John Robinson', '2014-11-22 13:45:05', 'Сам ты Васья'),
(3, 'admin', '2014-11-22 13:45:58', 'Hello wold!'),
(4, 'Anya', '2014-11-22 13:46:34', 'Мальчики не ссорьтесь!!!!'),
(5, 'superadmin', '2014-11-22 13:47:17', 'Server reboot -now');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` bigint(20) unsigned NOT NULL,
  `login` varchar(32) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` char(128) NOT NULL,
  `authkey` char(128) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `authkey`) VALUES
(1, 'admin', 'admin@test3.com', '76f547dc7b75a0554689fd71fdffd76a39ad05301eee960b29c4ac6cae6e32dc626e8d9da98ae7b6459c60006cf3a10d3282005e4fd0ed60fc98eb7c65bb87dd', '76876f1113b0032acd139c8754998f75d3f090f4a997b6cb56d9c564032f75c2831a771ed4571252e03527ce30be3411c185038d9e776dd8596a09436c9b3b84'),
(2, 'usver', 'u@qwerty.com', '76f547dc7b75a0554689fd71fdffd76a39ad05301eee960b29c4ac6cae6e32dc626e8d9da98ae7b6459c60006cf3a10d3282005e4fd0ed60fc98eb7c65bb87dd', ''),
(3, 'user2', 'u2@qwerty.com', '76f547dc7b75a0554689fd71fdffd76a39ad05301eee960b29c4ac6cae6e32dc626e8d9da98ae7b6459c60006cf3a10d3282005e4fd0ed60fc98eb7c65bb87dd', '40452b44c6419ce888f59b94148e105626ab58fe77c1a5fc2ad6606cc99cb8988ef4dd572ea9443d35ea4ff02c1988165abff8ba5eb0f1edb0d30d35cf05058e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
