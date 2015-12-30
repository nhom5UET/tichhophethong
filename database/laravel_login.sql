-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2015 at 12:22 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laravel_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `ck_contact`
--

CREATE TABLE IF NOT EXISTS `ck_contact` (
  `contact_id` int(10) unsigned NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middel_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ck_contacts`
--

CREATE TABLE IF NOT EXISTS `ck_contacts` (
  `contact_id` int(10) unsigned NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `middel_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `contact_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_1` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_2` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2015_11_24_163032_create_users', 1),
('2015_12_01_161525_create_patients', 2),
('2015_12_01_162841_create_patients', 3),
('2015_12_01_164800_create_patients', 4),
('2015_12_01_171704_create_patients', 5),
('2015_12_01_212353_create_ck_contact', 6),
('2015_12_01_214137_create_ck_contacts', 7),
('2015_12_01_225821_create_ck_contacts', 8),
('2015_12_01_230049_create_ck_contacts', 9),
('2015_12_01_235816_create_ck_contactss', 10),
('2015_12_02_001453_create_ck_contactss', 11),
('2015_12_02_001922_create_ck_contacts1', 12),
('2015_12_02_002308_create_ck_contacts1', 13),
('2015_12_02_010522_create_pacientes', 14),
('2015_12_02_015413_create_pacientes1', 15),
('2015_12_02_022731_create_patientgaia', 16),
('2015_12_02_030600_create_pacientes2', 17),
('2015_11_24_163032_create_users', 1),
('2015_12_01_161525_create_patients', 2),
('2015_12_01_162841_create_patients', 3),
('2015_12_01_164800_create_patients', 4),
('2015_12_01_171704_create_patients', 5),
('2015_12_01_212353_create_ck_contact', 6),
('2015_12_01_214137_create_ck_contacts', 7),
('2015_12_01_225821_create_ck_contacts', 8),
('2015_12_01_230049_create_ck_contacts', 9),
('2015_12_01_235816_create_ck_contactss', 10),
('2015_12_02_001453_create_ck_contactss', 11),
('2015_12_02_001922_create_ck_contacts1', 12),
('2015_12_02_002308_create_ck_contacts1', 13),
('2015_12_02_010522_create_pacientes', 14),
('2015_12_02_015413_create_pacientes1', 15),
('2015_12_02_022731_create_patientgaia', 16),
('2015_12_02_030600_create_pacientes2', 17);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `id_patient` int(10) unsigned NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middelname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phonenumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `displayname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postalcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id_patient`, `firstname`, `middelname`, `lastname`, `phonenumber`, `displayname`, `email`, `address`, `city`, `state`, `postalcode`, `country`, `created_at`, `updated_at`) VALUES
(1, 'dao', 'huy', 'hoang', '1121212121', 'hoang', 'hoang@gmail.com', 'xuanthuy', 'hanoi', 'good', '1221', 'vietnam', '2015-12-01 10:19:58', '2015-12-01 10:19:58'),
(2, '', 'a', 'Đào Huy', '01678928866', 'ad', 'huyhoanguet94@gmail.com', 'University of Engineering and Technology - Viet Nam National University Ha Noi', 'Ha Noi', 'State', '100000', 'Việt Nam', '2015-12-01 12:33:39', '2015-12-01 12:33:39'),
(3, 'sdkfja', 'kjskdfj', 'kljklsdfj', '1921982', 'kdjfask', 'viet@gmail.com', 'djas', 'kjk', 'kjk', 'jk', 'jlk', '2015-12-01 13:21:32', '2015-12-01 13:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `updated_at`) VALUES
(1, 'huyhoangbt2', 'd93a5def7511da3d0f2d171d9c344e91', 'hoang@gmail.com', '2015-11-24 10:58:14', '2015-11-24 10:58:14'),
(2, 'test', 'd93a5def7511da3d0f2d171d9c344e91', 'test@gmail.com', '2015-11-24 11:27:52', '2015-11-24 11:27:52'),
(3, 'huyhoang', 'd93a5def7511da3d0f2d171d9c344e91', 'huy@gmail.com', '2015-11-25 03:57:03', '2015-11-25 03:57:03'),
(4, 'test1', 'd93a5def7511da3d0f2d171d9c344e91', 'test1@gmail.com', '2015-11-25 03:58:59', '2015-11-25 03:58:59'),
(5, 'test2', 'd93a5def7511da3d0f2d171d9c344e91', 'test2@gmail.com', '2015-11-25 11:03:43', '2015-11-25 11:03:43'),
(6, 'admin', '0c7540eb7e65b553ec1ba6b20de79608', 'admin@gmail.com', '2015-11-29 05:26:30', '2015-11-29 05:26:30'),
(7, 'admin', '2e1b0765593f50bb3ed4d1a2d7535522', 'admin@gmail.com', '2015-12-02 07:16:50', '2015-12-02 07:16:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ck_contact`
--
ALTER TABLE `ck_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `ck_contacts`
--
ALTER TABLE `ck_contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id_patient`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ck_contact`
--
ALTER TABLE `ck_contact`
  MODIFY `contact_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ck_contacts`
--
ALTER TABLE `ck_contacts`
  MODIFY `contact_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id_patient` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
