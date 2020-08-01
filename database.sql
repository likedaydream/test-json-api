-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 01 2020 г., 10:57
-- Версия сервера: 10.4.12-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `reviews_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `object_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photos` blob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `object_id`, `username`, `rating`, `description`, `photos`, `created_at`) VALUES
(1, 1, 'name1', 2, 'Here is description 1', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:53:15'),
(2, 1, 'name2', 4, 'Here is description 2', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:53:15'),
(3, 1, 'name3', 2, 'Here is description 3', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:53:15'),
(4, 1, 'name4', 2, 'Here is description 4', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:53:15'),
(5, 1, 'name5', 5, 'Here is description 5', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:53:15'),
(6, 1, 'name6', 2, 'Here is description 6', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:53:15'),
(7, 1, 'name7', 5, 'Here is description 7', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:53:15'),
(8, 1, 'name8', 2, 'Here is description 8', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:53:15'),
(9, 1, 'name9', 1, 'Here is description 9', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:53:15'),
(10, 1, 'name10', 3, 'Here is description 10', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:53:15'),
(11, 1, 'name11', 3, 'Here is description 11', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:55:36'),
(12, 1, 'name12', 5, 'Here is description 12', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:55:36'),
(13, 1, 'name13', 4, 'Here is description 13', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:55:36'),
(14, 1, 'name14', 5, 'Here is description 14', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:55:36'),
(15, 1, 'name15', 5, 'Here is description 15', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:55:36'),
(16, 1, 'name16', 4, 'Here is description 16', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:55:36'),
(17, 1, 'name17', 3, 'Here is description 17', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:55:36'),
(18, 1, 'name18', 5, 'Here is description 18', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:55:36'),
(19, 1, 'name19', 2, 'Here is description 19', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:55:36'),
(20, 1, 'name20', 1, 'Here is description 20', 0x613a333a7b693a303b733a31323a2270686f746f2d6c696e6b2d31223b693a313b733a31323a2270686f746f2d6c696e6b2d32223b693a323b733a31323a2270686f746f2d6c696e6b2d33223b7d, '2020-08-01 07:55:36'),
(21, 1, 'my name', 4, 'my description', 0x613a323a7b693a303b733a383a226d792d70686f746f223b693a313b733a393a226d792d70686f746f32223b7d, '2020-08-01 07:57:00');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;