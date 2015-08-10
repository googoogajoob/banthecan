-- phpMyAdmin SQL Dump
-- version 4.2.13.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 09, 2015 at 11:41 PM
-- Server version: 10.0.20-MariaDB
-- PHP Version: 5.6.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `banthecan-demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `group_code` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_group`
--

DROP TABLE IF EXISTS `auth_item_group`;
CREATE TABLE IF NOT EXISTS `auth_item_group` (
  `code` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

DROP TABLE IF EXISTS `board`;
CREATE TABLE IF NOT EXISTS `board` (
`id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'Yii blameable behavior',
  `updated_by` int(11) NOT NULL COMMENT 'Yii blameable behavior',
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `max_lanes` int(11) NOT NULL COMMENT '# of lanes',
  `entry_column` int(11) NOT NULL COMMENT 'Column ID for Tickets coming from the Backlog'
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Initial Board design';

-- --------------------------------------------------------

--
-- Table structure for table `column`
--

DROP TABLE IF EXISTS `column`;
CREATE TABLE IF NOT EXISTS `column` (
`id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'Yii Blameable',
  `updated_by` int(11) NOT NULL COMMENT 'Yii Blameable',
  `board_id` int(11) NOT NULL,
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL,
  `receiver` tinytext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='colums fo a board';

-- --------------------------------------------------------

--
-- Table structure for table `dektrium-user`
--

DROP TABLE IF EXISTS `dektrium-user`;
CREATE TABLE IF NOT EXISTS `dektrium-user` (
`id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(60) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='dektrium user DB';

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `public_email` varchar(255) DEFAULT NULL,
  `gravatar_email` varchar(255) DEFAULT NULL,
  `gravatar_id` varchar(32) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `bio` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `social_account`
--

DROP TABLE IF EXISTS `social_account`;
CREATE TABLE IF NOT EXISTS `social_account` (
`id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
`id` int(11) NOT NULL,
  `frequency` int(11) NOT NULL,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_top`
--

DROP TABLE IF EXISTS `temp_top`;
CREATE TABLE IF NOT EXISTS `temp_top` (
  `fromP` text COLLATE utf8_unicode_ci NOT NULL,
  `top` text COLLATE utf8_unicode_ci NOT NULL,
  `createT` int(11) NOT NULL,
  `updateT` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
`id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `column_id` int(11) DEFAULT '0',
  `board_id` int(11) NOT NULL,
  `ticket_order` int(11) NOT NULL COMMENT 'Order of the tickets within a particular column, backlog, completed'
) ENGINE=InnoDB AUTO_INCREMENT=311 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_tag_mm`
--

DROP TABLE IF EXISTS `ticket_tag_mm`;
CREATE TABLE IF NOT EXISTS `ticket_tag_mm` (
  `ticket_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE IF NOT EXISTS `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Too small?',
  `password_reset_token` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Too small?',
  `email` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Too small?',
  `status` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `password` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `board_id` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Standard Yii User-DB';

-- --------------------------------------------------------

--
-- Table structure for table `user_visit_log`
--

DROP TABLE IF EXISTS `user_visit_log`;
CREATE TABLE IF NOT EXISTS `user_visit_log` (
`id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `language` char(2) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `visit_time` int(11) NOT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `os` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `webvimark-user`
--

DROP TABLE IF EXISTS `webvimark-user`;
CREATE TABLE IF NOT EXISTS `webvimark-user` (
`id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `superadmin` tinyint(1) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `registration_ip` varchar(15) DEFAULT NULL,
  `bind_to_ip` varchar(255) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `email_confirmed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='webvimark User DB';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
 ADD PRIMARY KEY (`item_name`,`user_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
 ADD PRIMARY KEY (`name`), ADD KEY `rule_name` (`rule_name`), ADD KEY `idx-auth_item-type` (`type`), ADD KEY `fk_auth_item_group_code` (`group_code`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
 ADD PRIMARY KEY (`parent`,`child`), ADD KEY `child` (`child`);

--
-- Indexes for table `auth_item_group`
--
ALTER TABLE `auth_item_group`
 ADD PRIMARY KEY (`code`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
 ADD PRIMARY KEY (`name`);

--
-- Indexes for table `board`
--
ALTER TABLE `board`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `column`
--
ALTER TABLE `column`
 ADD PRIMARY KEY (`id`), ADD KEY `board_fkey` (`board_id`);

--
-- Indexes for table `dektrium-user`
--
ALTER TABLE `dektrium-user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user_unique_username` (`username`), ADD UNIQUE KEY `user_unique_email` (`email`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
 ADD PRIMARY KEY (`version`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `social_account`
--
ALTER TABLE `social_account`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `account_unique` (`provider`,`client_id`), ADD KEY `fk_user_account` (`user_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `tagname_index` (`name`(16));

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
 ADD PRIMARY KEY (`id`), ADD KEY `column_id` (`column_id`);

--
-- Indexes for table `ticket_tag_mm`
--
ALTER TABLE `ticket_tag_mm`
 ADD KEY `ticket_index` (`ticket_id`), ADD KEY `tag_index` (`tag_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
 ADD UNIQUE KEY `token_unique` (`user_id`,`code`,`type`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_visit_log`
--
ALTER TABLE `user_visit_log`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `webvimark-user`
--
ALTER TABLE `webvimark-user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `column`
--
ALTER TABLE `column`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `dektrium-user`
--
ALTER TABLE `dektrium-user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `social_account`
--
ALTER TABLE `social_account`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=311;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `user_visit_log`
--
ALTER TABLE `user_visit_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `webvimark-user`
--
ALTER TABLE `webvimark-user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
