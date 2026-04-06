-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 26, 2011 at 04:55 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `smisdevelopment`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--


CREATE TABLE IF NOT EXISTS `attachments` (
  `id` varchar(36) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `dirname` varchar(255) DEFAULT NULL,
  `basename` varchar(255) NOT NULL,
  `checksum` varchar(255) NOT NULL,
  `group` varchar(255) DEFAULT NULL,
  `alternative` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attachments`
--


-- --------------------------------------------------------

--
-- Table structure for table `campuses`
--

CREATE TABLE IF NOT EXISTS `campuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `campuses`
--

INSERT INTO `campuses` (`id`, `name`, `description`, `created`, `modified`) VALUES
(1, 'The Main Campus', 'located at about 5 km north of Arba Minch town on the road to Addis Ababa', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Abaya Campus', 'located in Secha Kifle Ketema of Arba Minch Town overseeing Lakes\r\nAbabya to the left and Chamo to the right.', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Chamo Campus', 'located  at the southern end of Arba Minch; Secha Kifle Ketema\r\noverseeing Lake Chamo', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Nech Sar Campus', 'Located on the main road from Sikela to Secha ,close to Arba Minch \r\nHospital.', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `region_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=160 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `region_id`, `created`, `modified`) VALUES
(19, 'Abiy Addi', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(20, 'Abomsa', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(21, 'Adet', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(22, 'Adigrat', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(23, 'Addis Ababa', 1, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(24, 'Adis Zemen', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(25, 'Adwa', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(26, 'Agaro', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(27, 'Aksum', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(28, 'Alamata', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(29, 'Alemaya(Haromaya)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(30, 'Aleta Wendo', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(31, 'Arab Minch', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(32, 'Areka', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(33, 'Arsi Negele', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(34, 'Asasa', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(35, 'Asayita', 2, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(36, 'Asbe Teferi(Chiro)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(37, 'Aselea', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(38, 'Asosa', 4, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(39, 'Awasa', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(40, 'Awash Seba Kilo', 2, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(41, 'Awubere', 9, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(42, 'Ayikel (Chilga)', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(43, 'Babille', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(44, 'Bahir Dar', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(45, 'Bako', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(46, 'Bati', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(47, 'Bedele', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(48, 'Boditi', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(49, 'Bonga', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(50, 'Burayu', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(51, 'Bure', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(52, 'Butajira', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(53, 'Chagne', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(54, 'Chuko', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(55, 'Dangila', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(56, 'Debark', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(57, 'Debre Birhan', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(58, 'Debre Markos', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(59, 'Debre Tabor', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(60, 'Debre Zeyit(Bishoftu)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(61, 'Deder', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(62, 'Degeh Bur', 9, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(63, 'Dembi Dolo)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(64, 'Dera', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(65, 'Derwernache', 9, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(66, 'Dese', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(67, 'Dila', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(68, 'Dire Dawa', 5, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(69, 'Dodola', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(70, 'Dolo', 9, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(71, 'Dubti', 2, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(72, 'Durama', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(73, 'Este (Mekane Yesus)', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(74, 'Fiche', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(75, 'Finote Selam', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(76, 'Gambela', 6, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(77, 'Gebre Guracha (Kuyu)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(78, 'Gelemso', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(79, 'Genet(Holata)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(80, 'Gidole', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(81, 'Gimbi', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(82, 'Ginchi', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(83, 'Ginir', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(84, 'Giyon (Waliso)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(85, 'Goba', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(86, 'Gode', 9, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(87, 'Gonder', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(88, 'Guder', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(89, 'Hadero', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(90, 'Hager Hiywet (Ambo)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(91, 'Hagere Maryam', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(92, 'Harer', 7, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(93, 'Hartisheik', 9, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(94, 'Himora', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(95, 'Hosaina', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(96, 'Hurata', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(97, 'Inda Silase', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(98, 'Injibara', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(99, 'Iteya', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(100, 'Jijiga', 9, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(101, 'Jima', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(102, 'Jinka (Bako)', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(103, 'Kebri Dehar', 9, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(104, 'Kembolcha', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(105, 'Kemise', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(106, 'Kibre Mengist (Adola)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(107, 'Kobo', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(108, 'Kofele', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(109, 'K''olito (Alaba K''ulito)', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(110, 'Korem', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(111, 'Lalibela', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(112, 'Leku', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(113, 'Logia', 2, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(114, 'May Cadera (May Kadra)', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(115, 'Maych''ew', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(116, 'Mek''ele (Debub & Semen Mek''ele) ', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(117, 'Mekhoni', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(118, 'Mek''i', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(119, 'Mendi', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(120, 'Mer Awi', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(121, 'Mersa', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(122, 'Metu', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(123, 'Mieso', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(124, 'Mizan', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(125, 'Mojo', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(126, 'Mot''a', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(127, 'Moyale', 0, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(128, 'Nazret(Adama)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(129, 'Nefas Mewcha', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(130, 'Negele', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(131, 'Nejo', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(132, 'Nekemte', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(133, 'Robe (Bale Zone)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(134, 'Robe (Arsi Zone)', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(135, 'Sawla (Felege Neway)', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(136, 'Sebeta', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(137, 'Shakiso', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(138, 'Shambu', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(139, 'Shashemene', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(140, 'Shewa Robit(Kewet)', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(141, 'Shinshicho', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(142, 'Shiraro', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(143, 'Shone', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(144, 'Sodo', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(145, 'Sok''ot''a', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(146, 'Tepi', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(147, 'Tis Abay', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(148, 'Togo Chale (Tog Wajale)', 9, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(149, 'Tulu Bolo', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(150, 'Weldiya', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(151, 'Welenchiti', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(152, 'Welkite', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(153, 'Wenji Gefersa', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(154, 'Werota', 3, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(155, 'Wik''ro', 11, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(156, 'Yabelo', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(157, 'Yirga''Alem', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(158, 'Yirga Chefe', 10, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(159, 'Ziway', 8, '2010-04-15 12:27:11', '2011-04-15 12:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE IF NOT EXISTS `colleges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `shortname` varchar(10) DEFAULT NULL,
  `description` text,
  `type` varchar(200) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `campus_id`, `name`, `shortname`, `description`, `type`, `created`, `modified`) VALUES
(1, 1, 'Arba Minch Institute of Technology ', NULL, NULL, 'institute', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 2, 'College of Natural Sciences', NULL, NULL, 'college', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 4, 'College of Health Sciences', NULL, NULL, 'college', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 4, 'College of Agriculture', NULL, NULL, 'college', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 3, 'College of Business and Economics', NULL, NULL, 'college', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 3, 'College of Social Sciences and Humanity', NULL, NULL, 'college', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `primary_contact` tinyint(1) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `address1` int(11) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `alternative_email` varchar(200) DEFAULT NULL,
  `phone_home` varchar(200) DEFAULT NULL,
  `phone_office` varchar(200) DEFAULT NULL,
  `phone_mobile` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `contacts`
--


-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(3) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=240 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `created`, `modified`) VALUES
(1, 'Afghanistan', 'AF', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(2, 'Albania', 'AL', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(3, 'Algeria', 'DZ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(4, 'American Samoa', 'AS', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(5, 'Andorra', 'AD', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(6, 'Angola', 'AO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(7, 'Anguilla', 'AI', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(8, 'Antarctica', 'AQ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(9, 'Antigua and Barbuda', 'AG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(10, 'Argentina', 'AR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(11, 'Armenia', 'AM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(12, 'Aruba', 'AW', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(13, 'Australia', 'AU', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(14, 'Austria', 'AT', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(15, 'Azerbaijan', 'AZ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(16, 'Bahamas', 'BS', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(17, 'Bahrain', 'BH', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(18, 'Bangladesh', 'BD', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(19, 'Barbados', 'BB', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(20, 'Belarus', 'BY', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(21, 'Belgium', 'BE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(22, 'Belize', 'BZ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(23, 'Benin', 'BJ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(24, 'Bermuda', 'BM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(25, 'Bhutan', 'BT', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(26, 'Bolivia', 'BO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(27, 'Bosnia and Herzegovina', 'BA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(28, 'Botswana', 'BW', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(29, 'Bouvet Island', 'BV', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(30, 'Brazil', 'BR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(31, 'British Indian Ocean Territory', 'IO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(32, 'Brunei Darussalam', 'BN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(33, 'Bulgaria', 'BG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(34, 'Burkina Faso', 'BF', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(35, 'Burundi', 'BI', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(36, 'Cambodia', 'KH', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(37, 'Cameroon', 'CM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(38, 'Canada', 'CA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(39, 'Cape Verde', 'CV', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(40, 'Cayman Islands', 'KY', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(41, 'Central African Republic', 'CF', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(42, 'Chad', 'TD', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(43, 'Chile', 'CL', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(44, 'China', 'CN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(45, 'Christmas Island', 'CX', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(46, 'Cocos (Keeling) Islands', 'CC', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(47, 'Colombia', 'CO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(48, 'Comoros', 'KM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(49, 'Congo', 'CG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(50, 'Congo, the Democratic Republic of the', 'CD', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(51, 'Cook Islands', 'CK', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(52, 'Costa Rica', 'CR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(53, 'Cote D''Ivoire', 'CI', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(54, 'Croatia', 'HR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(55, 'Cuba', 'CU', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(56, 'Cyprus', 'CY', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(57, 'Czech Republic', 'CZ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(58, 'Denmark', 'DK', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(59, 'Djibouti', 'DJ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(60, 'Dominica', 'DM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(61, 'Dominican Republic', 'DO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(62, 'Ecuador', 'EC', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(63, 'Egypt', 'EG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(64, 'El Salvador', 'SV', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(65, 'Equatorial Guinea', 'GQ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(66, 'Eritrea', 'ER', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(67, 'Estonia', 'EE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(68, 'Ethiopia', 'ET', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(69, 'Falkland Islands (Malvinas)', 'FK', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(70, 'Faroe Islands', 'FO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(71, 'Fiji', 'FJ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(72, 'Finland', 'FI', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(73, 'France', 'FR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(74, 'French Guiana', 'GF', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(75, 'French Polynesia', 'PF', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(76, 'French Southern Territories', 'TF', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(77, 'Gabon', 'GA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(78, 'Gambia', 'GM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(79, 'Georgia', 'GE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(80, 'Germany', 'DE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(81, 'Ghana', 'GH', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(82, 'Gibraltar', 'GI', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(83, 'Greece', 'GR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(84, 'Greenland', 'GL', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(85, 'Grenada', 'GD', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(86, 'Guadeloupe', 'GP', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(87, 'Guam', 'GU', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(88, 'Guatemala', 'GT', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(89, 'Guinea', 'GN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(90, 'Guinea-Bissau', 'GW', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(91, 'Guyana', 'GY', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(92, 'Haiti', 'HT', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(93, 'Heard Island and Mcdonald Islands', 'HM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(94, 'Holy See (Vatican City State)', 'VA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(95, 'Honduras', 'HN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(96, 'Hong Kong', 'HK', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(97, 'Hungary', 'HU', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(98, 'Iceland', 'IS', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(99, 'India', 'IN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(100, 'Indonesia', 'ID', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(101, 'Iran, Islamic Republic of', 'IR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(102, 'Iraq', 'IQ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(103, 'Ireland', 'IE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(104, 'Israel', 'IL', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(105, 'Italy', 'IT', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(106, 'Jamaica', 'JM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(107, 'Japan', 'JP', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(108, 'Jordan', 'JO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(109, 'Kazakhstan', 'KZ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(110, 'Kenya', 'KE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(111, 'Kiribati', 'KI', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(112, 'Korea, Democratic People''s Republic of', 'KP', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(113, 'Korea, Republic of', 'KR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(114, 'Kuwait', 'KW', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(115, 'Kyrgyzstan', 'KG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(116, 'Lao People''s Democratic Republic', 'LA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(117, 'Latvia', 'LV', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(118, 'Lebanon', 'LB', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(119, 'Lesotho', 'LS', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(120, 'Liberia', 'LR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(121, 'Libyan Arab Jamahiriya', 'LY', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(122, 'Liechtenstein', 'LI', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(123, 'Lithuania', 'LT', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(124, 'Luxembourg', 'LU', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(125, 'Macao', 'MO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(126, 'Macedonia, the Former Yugoslav Republic of', 'MK', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(127, 'Madagascar', 'MG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(128, 'Malawi', 'MW', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(129, 'Malaysia', 'MY', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(130, 'Maldives', 'MV', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(131, 'Mali', 'ML', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(132, 'Malta', 'MT', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(133, 'Marshall Islands', 'MH', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(134, 'Martinique', 'MQ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(135, 'Mauritania', 'MR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(136, 'Mauritius', 'MU', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(137, 'Mayotte', 'YT', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(138, 'Mexico', 'MX', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(139, 'Micronesia, Federated States of', 'FM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(140, 'Moldova, Republic of', 'MD', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(141, 'Monaco', 'MC', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(142, 'Mongolia', 'MN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(143, 'Montserrat', 'MS', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(144, 'Morocco', 'MA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(145, 'Mozambique', 'MZ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(146, 'Myanmar', 'MM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(147, 'Namibia', 'NA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(148, 'Nauru', 'NR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(149, 'Nepal', 'NP', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(150, 'Netherlands', 'NL', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(151, 'Netherlands Antilles', 'AN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(152, 'New Caledonia', 'NC', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(153, 'New Zealand', 'NZ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(154, 'Nicaragua', 'NI', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(155, 'Niger', 'NE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(156, 'Nigeria', 'NG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(157, 'Niue', 'NU', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(158, 'Norfolk Island', 'NF', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(159, 'Northern Mariana Islands', 'MP', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(160, 'Norway', 'NO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(161, 'Oman', 'OM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(162, 'Pakistan', 'PK', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(163, 'Palau', 'PW', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(164, 'Palestinian Territory, Occupied', 'PS', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(165, 'Panama', 'PA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(166, 'Papua New Guinea', 'PG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(167, 'Paraguay', 'PY', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(168, 'Peru', 'PE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(169, 'Philippines', 'PH', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(170, 'Pitcairn', 'PN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(171, 'Poland', 'PL', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(172, 'Portugal', 'PT', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(173, 'Puerto Rico', 'PR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(174, 'Qatar', 'QA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(175, 'Reunion', 'RE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(176, 'Romania', 'RO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(177, 'Russian Federation', 'RU', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(178, 'Rwanda', 'RW', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(179, 'Saint Helena', 'SH', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(180, 'Saint Kitts and Nevis', 'KN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(181, 'Saint Lucia', 'LC', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(182, 'Saint Pierre and Miquelon', 'PM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(183, 'Saint Vincent and the Grenadines', 'VC', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(184, 'Samoa', 'WS', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(185, 'San Marino', 'SM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(186, 'Sao Tome and Principe', 'ST', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(187, 'Saudi Arabia', 'SA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(188, 'Senegal', 'SN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(189, 'Serbia and Montenegro', 'CS', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(190, 'Seychelles', 'SC', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(191, 'Sierra Leone', 'SL', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(192, 'Singapore', 'SG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(193, 'Slovakia', 'SK', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(194, 'Slovenia', 'SI', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(195, 'Solomon Islands', 'SB', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(196, 'Somalia', 'SO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(197, 'South Africa', 'ZA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(198, 'South Georgia and the South Sandwich Islands', 'GS', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(199, 'Spain', 'ES', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(200, 'Sri Lanka', 'LK', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(201, 'Sudan', 'SD', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(202, 'Suriname', 'SR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(203, 'Svalbard and Jan Mayen', 'SJ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(204, 'Swaziland', 'SZ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(205, 'Sweden', 'SE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(206, 'Switzerland', 'CH', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(207, 'Syrian Arab Republic', 'SY', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(208, 'Taiwan, Province of China', 'TW', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(209, 'Tajikistan', 'TJ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(210, 'Tanzania, United Republic of', 'TZ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(211, 'Thailand', 'TH', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(212, 'Timor-Leste', 'TL', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(213, 'Togo', 'TG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(214, 'Tokelau', 'TK', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(215, 'Tonga', 'TO', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(216, 'Trinidad and Tobago', 'TT', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(217, 'Tunisia', 'TN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(218, 'Turkey', 'TR', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(219, 'Turkmenistan', 'TM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(220, 'Turks and Caicos Islands', 'TC', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(221, 'Tuvalu', 'TV', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(222, 'Uganda', 'UG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(223, 'Ukraine', 'UA', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(224, 'United Arab Emirates', 'AE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(225, 'United Kingdom', 'GB', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(226, 'United States', 'US', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(227, 'United States Minor Outlying Islands', 'UM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(228, 'Uruguay', 'UY', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(229, 'Uzbekistan', 'UZ', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(230, 'Vanuatu', 'VU', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(231, 'Venezuela', 'VE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(232, 'Viet Nam', 'VN', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(233, 'Virgin Islands, British', 'VG', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(234, 'Virgin Islands, U.S.', 'VI', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(235, 'Wallis and Futuna', 'WF', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(236, 'Western Sahara', 'EH', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(237, 'Yemen', 'YE', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(238, 'Zambia', 'ZM', '2010-04-15 12:27:11', '2010-04-15 12:27:11'),
(239, 'Zimbabwe', 'ZW', '2010-04-15 12:27:11', '2010-04-15 12:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `credit_hour` int(11) DEFAULT NULL,
  `laboratory_hour` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `grade_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `courses`
--


-- --------------------------------------------------------

--
-- Table structure for table `courses_staffs`
--

CREATE TABLE IF NOT EXISTS `courses_staffs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `courses_staffs`
--


-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `college_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `college_id`, `description`, `created`, `modified`) VALUES
(1, 'Hydraulic and Water Resource Engineering', 1, '', '2011-08-16 11:52:04', '2011-08-16 11:52:04'),
(2, 'water Resource and Irrigation Engineering', 1, '', '2011-08-16 11:52:46', '2011-08-16 11:52:46'),
(3, 'Water Supply & Environmental Engineering', 1, '', '2011-08-16 12:12:35', '2011-08-16 12:12:35'),
(4, 'Civil and Urban Engineering', 1, '', '2011-08-16 12:13:02', '2011-08-16 12:13:02'),
(5, 'Electrical Engineering ', 1, '', '2011-08-16 12:13:33', '2011-08-16 12:13:33'),
(6, 'Mechanical Engineering ', 1, '', '2011-08-16 12:13:58', '2011-08-16 12:13:58'),
(7, 'Architecture & Urban Planning', 1, '', '2011-08-16 12:14:21', '2011-08-16 12:14:21'),
(8, 'Computer  Engineering ', 1, '', '2011-08-16 12:14:48', '2011-08-16 12:14:48'),
(9, 'Information Technology  ', 1, '', '2011-08-16 12:15:09', '2011-08-16 12:15:09'),
(10, 'Computer Science ', 1, '', '2011-08-16 12:15:34', '2011-08-16 12:15:34'),
(11, 'Hydraulic & Hydropower Engineering', 1, '', '2011-08-16 12:16:00', '2011-08-16 12:16:00'),
(12, 'Irrigation & Drainage Engineering ', 1, '', '2011-08-16 12:16:31', '2011-08-16 12:16:31'),
(13, 'Water Supply & Environmental Engineering ', 1, '', '2011-08-16 12:16:54', '2011-08-16 12:16:54'),
(14, 'Hydrology & Water Resources Management', 1, '', '2011-08-16 12:17:24', '2011-08-16 12:17:24'),
(15, 'Construction Management ', 1, '', '2011-08-16 12:17:49', '2011-08-16 12:17:49'),
(16, 'Power Engineering ', 1, '', '2011-08-16 12:18:16', '2011-08-16 12:18:16'),
(17, 'Industrial Engineering', 1, '', '2011-08-16 12:18:39', '2011-08-16 12:18:39');

-- --------------------------------------------------------

--
-- Table structure for table `departments_changes`
--

CREATE TABLE IF NOT EXISTS `departments_changes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `acadamicyear` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `departments_changes`
--


-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `content` text,
  `college_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `program_type_id` int(11) DEFAULT NULL,
  `acadamicyear` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `offers`
--


-- --------------------------------------------------------

--
-- Table structure for table `placements_results_criterias`
--

CREATE TABLE IF NOT EXISTS `placements_results_criterias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admissionyear` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `result_from` int(11) NOT NULL,
  `result_to` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `placements_results_criterias`
--


-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE IF NOT EXISTS `positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(100) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `position`, `description`) VALUES
(1, 'Graduate Assistant I', NULL),
(2, 'Graduate Assistant II', NULL),
(3, 'Assistant Lecturer', NULL),
(4, 'Lecturer', NULL),
(5, 'Assistant Professor', NULL),
(6, 'Associate Professor', NULL),
(7, 'Professor', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `acadamicyear` varchar(100) DEFAULT NULL,
  `preferences_order` int(11) DEFAULT NULL,
  `preference_deadline` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `preferences`
--


-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE IF NOT EXISTS `programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `shortname` varchar(10) DEFAULT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `programs`
--


-- --------------------------------------------------------

--
-- Table structure for table `program_types`
--

CREATE TABLE IF NOT EXISTS `program_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `shortname` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `program_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `quotas`
--

CREATE TABLE IF NOT EXISTS `quotas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `disability` int(11) DEFAULT NULL,
  `academicyear` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `quotas`
--


-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `short` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '68',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name`, `short`, `description`, `country_id`, `created`, `modified`) VALUES
(1, 'Addis Ababa', 'AA', 'city', 68, '2010-04-15 12:27:11', '2011-04-15 12:27:11'),
(2, 'Afar Region', 'AF', 'state', 68, '2011-04-15 12:27:11', '2010-04-15 12:27:11'),
(3, 'Amhara Region', 'AM', 'state', 68, '2011-04-15 12:27:11', '2010-04-15 12:27:11'),
(4, 'Benishangul-Gumuz Region', 'BE', 'state', 68, '2011-04-15 12:27:11', '2010-04-15 12:27:11'),
(5, 'Dire Dawa', 'DD', 'city', 68, '2011-04-15 12:27:11', '2010-04-15 12:27:11'),
(6, 'Gambela Region', 'GA', 'state', 68, '2011-04-15 12:27:11', '2010-04-15 12:27:11'),
(7, 'Harari Region', 'HA', 'state', 68, '2011-04-15 12:27:11', '2010-04-15 12:27:11'),
(8, 'Oromiya Region', 'OR', 'state', 68, '2011-04-15 12:27:11', '2010-04-15 12:27:11'),
(9, 'Somali Region', 'SO', 'state', 68, '2011-04-15 12:27:11', '2010-04-15 12:27:11'),
(10, 'Southern Nations, Nationalities, and People''s Region', 'SNNP', 'state', 68, '2011-04-15 12:27:11', '2010-04-15 12:27:11'),
(11, 'Tigray Region', 'TI', 'state', 68, '2011-04-15 12:27:11', '2010-04-15 12:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `reserved_places`
--

CREATE TABLE IF NOT EXISTS `reserved_places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `number` int(11) DEFAULT NULL,
  `description` text,
  `acadamicyear` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `reserved_places`
--


-- --------------------------------------------------------

--
-- Table structure for table `selected_students`
--

CREATE TABLE IF NOT EXISTS `selected_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) DEFAULT NULL,
  `middle_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `student_identification` varchar(200) DEFAULT NULL,
  `assignment_type` varchar(200) DEFAULT NULL,
  `prepartory_total_results` int(11) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `program_type_id` int(11) NOT NULL,
  `academicyear` varchar(100) DEFAULT NULL,
  `approval` varchar(250) DEFAULT NULL,
  `applicationstatus` varchar(250) DEFAULT NULL,
  `currentstatus` varchar(250) DEFAULT NULL,
  `placementtype` varchar(250) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `selected_students`
--


-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE IF NOT EXISTS `staffs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `college_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `title_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `ethnicity` varchar(200) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `alternative_email` varchar(200) NOT NULL,
  `phone_home` varchar(200) NOT NULL,
  `phone_office` varchar(200) NOT NULL,
  `phone_mobile` varchar(200) NOT NULL,
  `pobox` varchar(200) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `staffs`
--


-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) NOT NULL,
  `middle_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `selected_student_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `college_id` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `ethnicity` varchar(200) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `language` varchar(200) DEFAULT NULL,
  `is_disable` varchar(3) DEFAULT NULL,
  `studentnumber` int(20) DEFAULT NULL,
  `admissionyear` date DEFAULT NULL,
  `estimated_grad_date` date NOT NULL,
  `country_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `program_id` int(11) DEFAULT NULL,
  `program_type_id` int(11) DEFAULT NULL,
  `zone_subcity` varchar(200) NOT NULL,
  `woreda` varchar(200) NOT NULL,
  `kebele` varchar(200) NOT NULL,
  `house_number` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `email_alternative` varchar(200) DEFAULT NULL,
  `phone_home` varchar(200) NOT NULL,
  `phone_mobile` varchar(200) NOT NULL,
  `pobox` varchar(200) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `students`
--


-- --------------------------------------------------------

--
-- Table structure for table `students_departments`
--

CREATE TABLE IF NOT EXISTS `students_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `college_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `acadamicyear` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `students_departments`
--


-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE IF NOT EXISTS `titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`id`, `title`, `description`) VALUES
(1, 'Dr', 'Doctor'),
(2, 'Lady', 'tle prefixed to the name of the wife (or daughter) of a knight, baron or baronet. '),
(3, 'Lord', 'Title prefixed to the name of a titled nobleman (e.g. duke, marquess, etc) or peer. '),
(4, 'Miss', 'Normal form of title prefixed to an unmarried woman''s name.'),
(5, 'Mr', 'Normal form of title prefixed to a man''s name.'),
(6, 'Mrs', 'Normal form of title prefixed to a married woman''s name.'),
(7, 'Ms', 'Title substituted for Mrs or Miss before name of a woman. '),
(8, 'Rev', 'Reverend'),
(9, 'Sir', 'Title prefixed to the given name of a knight or baronet. ');
