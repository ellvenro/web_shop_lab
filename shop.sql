-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 26 2023 г., 15:07
-- Версия сервера: 5.7.33-log
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `клиенты`
--

CREATE TABLE `клиенты` (
  `КодК` int(11) NOT NULL,
  `Фамилия` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Имя` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Телефон` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Дата` date DEFAULT NULL,
  `Логин` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Пароль` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `клиенты`
--

INSERT INTO `клиенты` (`КодК`, `Фамилия`, `Имя`, `Телефон`, `Дата`, `Логин`, `Пароль`) VALUES
(8, 'Иванов', 'Павел', ' +7(983)-956-22-45', '2023-01-04', 'log1', 'pas1'),
(9, 'Антипина', 'Татьяна', '+7(983)-987-23-45', '2022-12-14', 'log2', 'pas2'),
(10, 'Степанова', 'Анна', '+7(913)-254-12-87', '2022-11-09', 'log3', 'pas3'),
(11, 'Артемов', 'Валентин', '+7(913)-323-43-23', '2023-01-11', 'log4', 'pas4'),
(13, 'Фамилия', 'Имя', '+7 983 873 40 53', '2023-03-02', 'log10', 'pas10');

-- --------------------------------------------------------

--
-- Структура таблицы `корзина`
--

CREATE TABLE `корзина` (
  `КодКо` int(11) NOT NULL,
  `КодК` int(11) DEFAULT NULL,
  `КодТ` int(11) DEFAULT NULL,
  `Дата` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `корзина`
--

INSERT INTO `корзина` (`КодКо`, `КодК`, `КодТ`, `Дата`) VALUES
(1, 9, 2, '2023-02-01'),
(2, 11, 6, '2023-02-02'),
(3, 9, 4, '2023-02-03'),
(5, 13, 1, '2023-03-02'),
(6, 13, 2, '2023-03-02'),
(7, 13, 4, '2023-03-02');

-- --------------------------------------------------------

--
-- Структура таблицы `корзинабуф`
--

CREATE TABLE `корзинабуф` (
  `КодТ` int(11) DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `производители`
--

CREATE TABLE `производители` (
  `КодП` int(11) NOT NULL,
  `Производитель` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Сайт` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `производители`
--

INSERT INTO `производители` (`КодП`, `Производитель`, `Сайт`) VALUES
(1, 'Apple', 'https://www.apple.com/ru/'),
(2, 'LENOVO', 'https://shop.lenovo.ru/'),
(3, 'Acer', 'https://ru-store.acer.com/'),
(4, 'ASUS', 'https://www.asus.com/ru/'),
(5, 'HP', 'https://www.hp.com/ru-ru/home.html');

-- --------------------------------------------------------

--
-- Структура таблицы `статистика`
--

CREATE TABLE `статистика` (
  `Вход` int(11) NOT NULL,
  `Пользователь` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `статистика`
--

INSERT INTO `статистика` (`Вход`, `Пользователь`) VALUES
(50, 30);

-- --------------------------------------------------------

--
-- Структура таблицы `типы`
--

CREATE TABLE `типы` (
  `КодТТ` int(11) NOT NULL,
  `Тип` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `типы`
--

INSERT INTO `типы` (`КодТТ`, `Тип`) VALUES
(1, 'Настольный компьютер'),
(2, 'Моноблок'),
(3, 'Неттоп'),
(4, 'Ноутбук'),
(5, 'Нетбук'),
(6, 'Ультрабук'),
(7, 'Планшет'),
(8, 'Игровой ноутбук');

-- --------------------------------------------------------

--
-- Структура таблицы `товары`
--

CREATE TABLE `товары` (
  `КодТ` int(11) NOT NULL,
  `КодП` int(11) DEFAULT NULL,
  `Название` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `КодТТ` int(11) DEFAULT NULL,
  `Описание` text COLLATE utf8mb4_unicode_ci,
  `Стоимость` int(11) DEFAULT NULL,
  `Фото` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `товары`
--

INSERT INTO `товары` (`КодТ`, `КодП`, `Название`, `КодТТ`, `Описание`, `Стоимость`, `Фото`) VALUES
(1, 1, 'iMac 21', 2, '24″ (2021 M1), 16 ГБ, SSD 1024 Гб, Touch ID, серебристый (Z12R000PK)', 212990, 'img1.jpg'),
(2, 1, 'iMac 20', 2, '27″ (2020), Intel Core i7 3,8 - 5,1 ГГц, 8Gb, SSD 2048Gb, AMD Radeon™ Pro 5700XT, серебристый (Z0ZX000PM)', 351990, 'img2.jpg'),
(3, 2, 'ThinkCentre M70q', 3, 'Intel Core i5-10400T 2.00 ГГц, 8 Гб DDR4, SSD 256 Гб, Windows 10 Pro', 62990, 'img3.jpg'),
(4, 4, 'Vivobook S15 M533IA-BN316T', 4, '15.6\' FHD, AMD Ryzen 7 4700U, 8 Гб DDR4, 512 Гб SSD', 65690, 'img4.jpg'),
(5, 4, 'ROG Zephyrus G14 GA401QE-K2156T', 8, '14.0\' QHD, AMD Ryzen 9 5900HS, 16 Гб DDR4 3200 МГц, NVIDIA GeForce RTX 3050 Ti, 512 Гб SSD', 152790, 'img5.jpg'),
(6, 5, 'ProDesk 600', 1, 'Intel Core i5 10500T, DDR4 8ГБ, 256ГБ(SSD), Intel UHD Graphics 630, Windows 10 Professional, черный [1c6y9ea]', 60490, 'img6.jpg'),
(7, 2, 'ThinkStation P340 Tower 30DH00GERU', 1, 'Intel Core i7-10700 2.90 ГГц, 16 Гб DDR4, nVidia Quadro RTX 4000 8 Гб, SSD 512 Гб, Windows 10 Pro', 218590, 'img7.jpg'),
(8, 3, 'Iconia Tab A500', 7, '10.1\", 1280x800, 32 ГБ, Android 4.0, ОЗУ 1 ГБ, Nvidia Tegra 2 1000 МГц, 177x260x13 мм, 5 Мпикс, 2 Мпикс', 2500, 'img8.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `клиенты`
--
ALTER TABLE `клиенты`
  ADD PRIMARY KEY (`КодК`);

--
-- Индексы таблицы `корзина`
--
ALTER TABLE `корзина`
  ADD PRIMARY KEY (`КодКо`),
  ADD KEY `КодК` (`КодК`),
  ADD KEY `КодТ` (`КодТ`);

--
-- Индексы таблицы `производители`
--
ALTER TABLE `производители`
  ADD PRIMARY KEY (`КодП`);

--
-- Индексы таблицы `типы`
--
ALTER TABLE `типы`
  ADD PRIMARY KEY (`КодТТ`);

--
-- Индексы таблицы `товары`
--
ALTER TABLE `товары`
  ADD PRIMARY KEY (`КодТ`),
  ADD KEY `КодП` (`КодП`),
  ADD KEY `КодТТ` (`КодТТ`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `клиенты`
--
ALTER TABLE `клиенты`
  MODIFY `КодК` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `корзина`
--
ALTER TABLE `корзина`
  MODIFY `КодКо` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `производители`
--
ALTER TABLE `производители`
  MODIFY `КодП` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `типы`
--
ALTER TABLE `типы`
  MODIFY `КодТТ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `товары`
--
ALTER TABLE `товары`
  MODIFY `КодТ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `корзина`
--
ALTER TABLE `корзина`
  ADD CONSTRAINT `корзина_ibfk_1` FOREIGN KEY (`КодК`) REFERENCES `клиенты` (`КодК`),
  ADD CONSTRAINT `корзина_ibfk_2` FOREIGN KEY (`КодТ`) REFERENCES `товары` (`КодТ`);

--
-- Ограничения внешнего ключа таблицы `товары`
--
ALTER TABLE `товары`
  ADD CONSTRAINT `товары_ibfk_1` FOREIGN KEY (`КодП`) REFERENCES `производители` (`КодП`),
  ADD CONSTRAINT `товары_ibfk_2` FOREIGN KEY (`КодТТ`) REFERENCES `типы` (`КодТТ`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
