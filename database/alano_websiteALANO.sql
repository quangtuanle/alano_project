-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2015 at 03:11 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `alano_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `about` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7D3656A435C246D5` (`password`),
  UNIQUE KEY `UNIQ_7D3656A4E7927C74` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `email`, `name`, `gender`, `avatar`, `about`, `type`) VALUES
(1, 'quangtuanle', '123456', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `published_at` datetime NOT NULL,
  `num_view` int(11) NOT NULL,
  `num_like` int(11) NOT NULL,
  `num_unlike` int(11) NOT NULL,
  `num_share` int(11) NOT NULL,
  `tag` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `special_tag` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66BDAFD8C8` (`author`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `author`, `title`, `summary`, `content`, `published_at`, `num_view`, `num_like`, `num_unlike`, `num_share`, `tag`, `special_tag`) VALUES
(1, NULL, 'Công bố single tiếp theo của Adele sau bão "Hello"', 'Ca khúc được fan yêu thích thứ nhì "25" vừa được chọn để "lên thớt" sau single gây bão "Hello".', 'Ca khúc nào từ "25" sẽ được Adele chọn "lên thớt" sau bản hit gây bão "Hello"? Câu trả lời vừa có vào hôm nay và đó chính là "When We Were Young".', '2015-12-16 00:00:00', 0, 0, 0, 0, 'Giải trí', 'Trending'),
(2, NULL, 'Suzy ra bộ ảnh mới', 'Bộ ảnh mới đây thực hiện gây nhiều chú ý', '<img src="http://i.imgur.com/yaLXuyX.jpg" />', '2015-12-16 00:00:00', 0, 0, 0, 0, 'Giải trí', 'Trending'),
(3, NULL, 'Big Bang sẽ vắng mặt ở tất cả các show âm nhạc tổng kết năm', 'YG vừa thông báo Big Bang sẽ "mất dạng" tại tất cả các bữa tiệc âm nhạc và giải thưởng cuối năm nay.', 'Có vẻ như loạt show âm nhạc tổng kết năm sắp tới đây sẽ bớt thú vị đi nhiều, ít nhất là đối với fan Big Bang, bởi 5 chàng trai sẽ vắng mặt trong tất cả các sự kiện của cả SBS, KBS và MBC.', '2015-12-16 00:00:00', 0, 0, 0, 0, 'Giải trí', 'Trending'),
(4, NULL, 'Bài báo 1', 'pppp', 'pppp', '2015-12-16 00:00:00', 0, 0, 0, 0, 'pp', 'Trending'),
(5, NULL, 'Bài báo 2', '9999999999999999', '99999', '2015-12-16 00:00:00', 0, 0, 0, 0, 'Giải trí', 'Trending');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_category` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `published_at` datetime NOT NULL,
  `num_like` int(11) NOT NULL,
  `num_un_like` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526C7294869C` (`article_id`),
  KEY `IDX_9474526CBDAFD8C8` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `detailarticle`
--

CREATE TABLE IF NOT EXISTS `detailarticle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `credit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_70E4FA78F85E0677` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `published_at` datetime NOT NULL,
  `link_source` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status_link` int(11) NOT NULL,
  `num_like` int(11) NOT NULL,
  `num_share` int(11) NOT NULL,
  `num_comment` int(11) NOT NULL,
  `same_news` longtext COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tag` longtext COLLATE utf8_unicode_ci NOT NULL,
  `num_same` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `num_identity` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_426EF392F85E0677` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66BDAFD8C8` FOREIGN KEY (`author`) REFERENCES `account` (`id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CBDAFD8C8` FOREIGN KEY (`author`) REFERENCES `account` (`id`),
  ADD CONSTRAINT `FK_9474526C7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `FK_MEMBER_ACCOUNT` FOREIGN KEY (`id`) REFERENCES `account` (`id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `FK_STAFF_ACCOUNT` FOREIGN KEY (`id`) REFERENCES `account` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
