-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июл 04 2013 г., 10:11
-- Версия сервера: 5.5.25
-- Версия PHP: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `vpk_base`
--

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_admin`
--

DROP TABLE IF EXISTS `vpk_admin`;
CREATE TABLE IF NOT EXISTS `vpk_admin` (
  `admin_code` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(128) DEFAULT NULL,
  `admin_login` varchar(64) NOT NULL,
  `admin_password` varchar(64) NOT NULL,
  `admin_email` varchar(128) DEFAULT NULL,
  `admin_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`admin_code`),
  UNIQUE KEY `admin_login` (`admin_login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `vpk_admin`
--

INSERT INTO `vpk_admin` (`admin_code`, `admin_name`, `admin_login`, `admin_password`, `admin_email`, `admin_active`) VALUES
(2, 'Георгий', 'george', 'b633e58ff7d328a069f54451d1685e0a', 'pu88@mail.ru', 1),
(3, 'Лебедев Юрий Александрович', 'Lebedev', 'd41d8cd98f00b204e9800998ecf8427e', '', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_admins_permission`
--

DROP TABLE IF EXISTS `vpk_admins_permission`;
CREATE TABLE IF NOT EXISTS `vpk_admins_permission` (
  `permission_code` int(11) NOT NULL,
  `admin_code` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vpk_admins_permission`
--

INSERT INTO `vpk_admins_permission` (`permission_code`, `admin_code`) VALUES
(2, '3'),
(3, '3'),
(4, '3'),
(5, '3'),
(1, '2'),
(2, '2'),
(3, '2'),
(4, '2'),
(5, '2'),
(6, '2');

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_catalog`
--

DROP TABLE IF EXISTS `vpk_catalog`;
CREATE TABLE IF NOT EXISTS `vpk_catalog` (
  `catalog_code` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_icon` varchar(256) DEFAULT NULL,
  `catalog_pos` int(11) NOT NULL,
  `page_code` int(11) NOT NULL,
  `catalog_url` varchar(250) DEFAULT NULL,
  `catalog_parent` int(11) NOT NULL,
  PRIMARY KEY (`catalog_code`),
  KEY `page_code` (`page_code`) USING HASH
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `vpk_catalog`
--

INSERT INTO `vpk_catalog` (`catalog_code`, `catalog_icon`, `catalog_pos`, `page_code`, `catalog_url`, `catalog_parent`) VALUES
(1, NULL, 1, 7, '', 0),
(2, NULL, 2, 8, '', 0),
(3, NULL, 1, 9, '', 1),
(4, NULL, 2, 10, '', 1),
(5, NULL, 3, 11, '', 1),
(6, NULL, 1, 12, '', 2),
(7, NULL, 2, 13, '', 2),
(8, NULL, 1, 14, '', 4),
(9, NULL, 2, 15, '', 4),
(10, NULL, 1, 16, '', 3),
(11, NULL, 2, 17, '', 3),
(12, NULL, 3, 18, '', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_dictionary`
--

DROP TABLE IF EXISTS `vpk_dictionary`;
CREATE TABLE IF NOT EXISTS `vpk_dictionary` (
  `dictionary_code` int(11) NOT NULL AUTO_INCREMENT,
  `essential_code` int(11) NOT NULL,
  `language_code` int(11) NOT NULL,
  `dictionary_translate` varchar(250) NOT NULL,
  PRIMARY KEY (`dictionary_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_essential`
--

DROP TABLE IF EXISTS `vpk_essential`;
CREATE TABLE IF NOT EXISTS `vpk_essential` (
  `essential_code` int(11) NOT NULL AUTO_INCREMENT,
  `essential_name` varchar(250) NOT NULL,
  PRIMARY KEY (`essential_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_language`
--

DROP TABLE IF EXISTS `vpk_language`;
CREATE TABLE IF NOT EXISTS `vpk_language` (
  `language_code` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(250) NOT NULL DEFAULT ' ',
  `language_direct` char(1) NOT NULL DEFAULT 'l',
  `language_charset` varchar(20) NOT NULL DEFAULT 'utf8',
  PRIMARY KEY (`language_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `vpk_language`
--

INSERT INTO `vpk_language` (`language_code`, `language_name`, `language_direct`, `language_charset`) VALUES
(1, 'ru', 'l', 'windows-1251'),
(2, 'eng', 'l', 'windows-1251');

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_news`
--

DROP TABLE IF EXISTS `vpk_news`;
CREATE TABLE IF NOT EXISTS `vpk_news` (
  `news_code` int(11) NOT NULL AUTO_INCREMENT,
  `news_date` date NOT NULL,
  `news_url` varchar(200) DEFAULT '',
  `page_code` int(11) NOT NULL,
  PRIMARY KEY (`news_code`),
  KEY `page_code` (`page_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `vpk_news`
--

INSERT INTO `vpk_news` (`news_code`, `news_date`, `news_url`, `page_code`) VALUES
(2, '2013-06-24', '', 2);

--
-- Триггеры `vpk_news`
--
DROP TRIGGER IF EXISTS `newsBeforeDelete`;
DELIMITER //
CREATE TRIGGER `newsBeforeDelete` BEFORE DELETE ON `vpk_news`
 FOR EACH ROW Delete from vpk_page where  vpk_page.page_code=OLD.page_code
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_page`
--

DROP TABLE IF EXISTS `vpk_page`;
CREATE TABLE IF NOT EXISTS `vpk_page` (
  `page_code` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) CHARACTER SET cp1251 NOT NULL,
  `page_active` tinyint(1) NOT NULL DEFAULT '0',
  `page_url` varchar(255) CHARACTER SET cp1251 DEFAULT NULL,
  `page_type` varchar(10) NOT NULL DEFAULT 'static',
  PRIMARY KEY (`page_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Дамп данных таблицы `vpk_page`
--

INSERT INTO `vpk_page` (`page_code`, `page_name`, `page_active`, `page_url`, `page_type`) VALUES
(1, '123', 0, NULL, 'news'),
(2, '123', 0, '', 'news'),
(3, 'Главная', 0, NULL, 'static'),
(4, 'О проекте', 0, NULL, 'static'),
(5, 'Проектные решения', 0, NULL, 'static'),
(6, 'Контактная информация', 0, NULL, 'static'),
(7, 'Оборудование', 1, NULL, 'department'),
(8, 'Услуги', 1, NULL, 'department'),
(9, 'Расходомеры', 1, NULL, 'department'),
(10, 'Навигационные системы', 1, NULL, 'department'),
(11, 'Инструменты', 0, NULL, 'department'),
(12, 'Сервис', 1, NULL, 'department'),
(13, 'Монтажные работы', 1, NULL, 'department'),
(14, 'Пеленг', 1, NULL, 'department'),
(15, 'prof-GPS', 1, NULL, 'department'),
(16, 'Счетчик топлива VZO 4', 1, NULL, 'department'),
(17, 'ППО-40', 1, NULL, 'department'),
(18, 'DFM-30', 1, NULL, 'department'),
(26, 'Автопарк', 0, NULL, 'solutions'),
(27, 'Скорая помощь', 0, NULL, 'solutions'),
(28, 'Железная дорога', 0, NULL, 'solutions');

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_permission`
--

DROP TABLE IF EXISTS `vpk_permission`;
CREATE TABLE IF NOT EXISTS `vpk_permission` (
  `permission_code` int(11) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(128) NOT NULL DEFAULT '',
  `permission_comment` varchar(128) NOT NULL,
  PRIMARY KEY (`permission_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `vpk_permission`
--

INSERT INTO `vpk_permission` (`permission_code`, `permission_name`, `permission_comment`) VALUES
(1, 'pAdmin', 'Администратор: управление правами доступа'),
(2, 'pStaticTextEdit', 'Редактирование содержания статических страниц'),
(3, 'pCatalogEdit', 'Редактирование каталога продукции и ислуг'),
(4, 'pNewsEdit', 'Редактирование новостей'),
(5, 'pPartnerEdit', 'Редактирование страниц партнеров'),
(6, 'pSolutionEdit', 'Редактирование проектных решений');

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_picture`
--

DROP TABLE IF EXISTS `vpk_picture`;
CREATE TABLE IF NOT EXISTS `vpk_picture` (
  `picture_code` int(11) NOT NULL AUTO_INCREMENT,
  `page_code` int(11) NOT NULL DEFAULT '0',
  `picsmall` varchar(200) DEFAULT NULL,
  `picbig` varchar(200) DEFAULT NULL,
  `picpos` int(11) NOT NULL DEFAULT '0',
  `language_code` int(11) NOT NULL,
  `piccomment` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`picture_code`),
  UNIQUE KEY `picture_code` (`picture_code`),
  KEY `page_code` (`page_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `vpk_picture`
--

INSERT INTO `vpk_picture` (`picture_code`, `page_code`, `picsmall`, `picbig`, `picpos`, `language_code`, `piccomment`) VALUES
(1, 3, 'small1.jpg', 'big1.jpg', 1, 1, 'компас2'),
(2, 3, 'small2.jpg', 'big2.jpg', 2, 1, 'автопилот'),
(3, 3, 'small3.jpg', 'big3.jpg', 3, 2, 'compas'),
(4, 3, 'small4.jpg', 'big4.jpg', 4, 2, 'antenna');

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_solutions`
--

DROP TABLE IF EXISTS `vpk_solutions`;
CREATE TABLE IF NOT EXISTS `vpk_solutions` (
  `solutions_code` int(11) NOT NULL AUTO_INCREMENT,
  `page_code` int(11) NOT NULL,
  `solutions_pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`solutions_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `vpk_solutions`
--

INSERT INTO `vpk_solutions` (`solutions_code`, `page_code`, `solutions_pos`) VALUES
(4, 26, 1),
(5, 27, 2),
(6, 28, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_solution_catalog`
--

DROP TABLE IF EXISTS `vpk_solution_catalog`;
CREATE TABLE IF NOT EXISTS `vpk_solution_catalog` (
  `solution_code` int(11) NOT NULL,
  `catalog_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `vpk_static`
--

DROP TABLE IF EXISTS `vpk_static`;
CREATE TABLE IF NOT EXISTS `vpk_static` (
  `static_code` int(11) NOT NULL AUTO_INCREMENT,
  `page_code` int(11) NOT NULL DEFAULT '0',
  `static_name` varchar(200) NOT NULL DEFAULT '',
  `static_text` text NOT NULL,
  `static_pos` int(11) NOT NULL DEFAULT '0',
  `static_seo_title` text,
  `static_seo_desc` text,
  `static_seo_key` text,
  `lang_code` int(11) NOT NULL,
  `static_abstract` text,
  `static_url` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`static_code`),
  KEY `page_code` (`page_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `vpk_static`
--

INSERT INTO `vpk_static` (`static_code`, `page_code`, `static_name`, `static_text`, `static_pos`, `static_seo_title`, `static_seo_desc`, `static_seo_key`, `lang_code`, `static_abstract`, `static_url`) VALUES
(1, 2, 'Разработка подсистемы ввода новостей', '<p>Новость</p>', 0, NULL, NULL, NULL, 1, '<p>Новость</p>', NULL),
(2, 3, 'Главная', '<p>Это шаблон для заполнения текстом на главной странице</p>', 0, NULL, NULL, NULL, 1, '', NULL),
(3, 3, 'Main', '<p>Tgis is template for main page text</p>', 0, NULL, NULL, NULL, 2, '', NULL),
(4, 6, 'Контактная информация', '<p style="text-align: left;"><strong>ООО "ВПК+". </strong></p>\r\n<p>99014 г.Севастополь, Камышовое шоссе, 49</p>\r\n<p>e-mail: <a href="mailto:VPK.B2B@gmail.com">VPK.B2B@gmail.com</a></p>\r\n<p>тел. (050) 5753779,<br />&nbsp; &nbsp; &nbsp; &nbsp;(096) 9719562</p>', 0, NULL, NULL, NULL, 1, '', NULL),
(5, 6, 'Contact information', '<p><strong>"AIC+" Ltd.</strong></p>\r\n<p>49 Kamishovoe&nbsp;highway<br />Sebastopol, Ukraine,99014&nbsp;</p>\r\n<p>e-mail:&nbsp;<a href="mailto:VPK.B2B@gmail.com">VPK.B2B@gmail.com</a></p>\r\n<p>phone &nbsp;(050) 5753779,<br />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(096) 9719562</p>', 0, NULL, NULL, NULL, 2, '', NULL),
(6, 7, 'Оборудование', '', 0, NULL, NULL, NULL, 1, '', NULL),
(7, 8, 'Услуги', '', 0, NULL, NULL, NULL, 1, '', NULL),
(8, 9, 'Расходомеры', '', 0, NULL, NULL, NULL, 1, '', NULL),
(9, 10, 'Навигационные системы', '', 0, NULL, NULL, NULL, 1, '', NULL),
(10, 11, 'Инструменты', '', 0, NULL, NULL, NULL, 1, '', NULL),
(11, 12, 'Сервис', '', 0, NULL, NULL, NULL, 1, '', NULL),
(12, 13, 'Монтажные работы', '', 0, NULL, NULL, NULL, 1, '', NULL),
(13, 14, 'Пеленг', '', 0, NULL, NULL, NULL, 1, '', NULL),
(14, 15, 'prof-GPS', '', 0, NULL, NULL, NULL, 1, '', NULL),
(15, 16, 'Счетчик топлива VZO 4', '', 0, NULL, NULL, NULL, 1, '', NULL),
(16, 17, 'ППО-40', '', 0, NULL, NULL, NULL, 1, '', NULL),
(17, 18, 'DFM-30', '', 0, NULL, NULL, NULL, 1, '', NULL);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `vpk_picture`
--
ALTER TABLE `vpk_picture`
  ADD CONSTRAINT `vpk_picture_ibfk_1` FOREIGN KEY (`page_code`) REFERENCES `vpk_page` (`page_code`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `vpk_static`
--
ALTER TABLE `vpk_static`
  ADD CONSTRAINT `vpk_static_ibfk_1` FOREIGN KEY (`page_code`) REFERENCES `vpk_page` (`page_code`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
