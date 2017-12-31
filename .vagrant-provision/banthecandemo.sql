-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: banthecan-demo
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.17.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `group_code` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  KEY `fk_auth_item_group_code` (`group_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_group`
--

DROP TABLE IF EXISTS `auth_item_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_group` (
  `code` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_group`
--

LOCK TABLES `auth_item_group` WRITE;
/*!40000 ALTER TABLE `auth_item_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `board`
--

DROP TABLE IF EXISTS `board`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL COMMENT 'Yii blameable behavior',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Yii blameable behavior',
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `max_lanes` int(11) NOT NULL COMMENT '# of lanes',
  `backlog_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Backlog',
  `kanban_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Kanban',
  `completed_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Completed',
  `ticket_backlog_configuration` text COLLATE utf8_unicode_ci,
  `ticket_completed_configuration` text COLLATE utf8_unicode_ci,
  `entry_column` int(11) DEFAULT NULL COMMENT 'Column ID for Tickets coming from the Backlog',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Initial Board design';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `board`
--

LOCK TABLES `board` WRITE;
/*!40000 ALTER TABLE `board` DISABLE KEYS */;
INSERT INTO `board` VALUES (112,1456654650,1483053199,137,NULL,'Lorem Testum','Description Text: Optio rerum consequatur veritatis nihil. Expedita quo culpa rem sapiente totam ipsam. Omnis a natus odio et consequatur. Omnis praesentium vitae quasi nostrum amet ad consequatur sunt.',1,'Vorschläge','TOP','Completed','a:6:{i:0;s:16:\"CreateResolution\";i:1;s:10:\"CreateTask\";i:2;s:10:\"CopyTicket\";i:3;s:15:\"MoveToCompleted\";i:4;s:12:\"MoveToKanban\";i:5;s:4:\"Vote\";}','a:5:{i:0;s:16:\"CreateResolution\";i:1;s:10:\"CreateTask\";i:2;s:10:\"CopyTicket\";i:3;s:13:\"MoveToBacklog\";i:4;s:12:\"MoveToKanban\";}',379),(114,1476897360,1483053167,137,NULL,'Xenodoofia','A second board',1,'BillBack','BillKan','BillyComp','a:1:{i:0;s:12:\"MoveToKanban\";}','a:1:{i:0;s:13:\"MoveToBacklog\";}',384);
/*!40000 ALTER TABLE `board` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `column`
--

DROP TABLE IF EXISTS `column`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `column` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL COMMENT 'Yii Blameable',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Yii Blameable',
  `board_id` int(11) NOT NULL,
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL,
  `receiver` tinytext COLLATE utf8_unicode_ci,
  `ticket_column_configuration` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `board_fkey` (`board_id`)
) ENGINE=InnoDB AUTO_INCREMENT=385 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='colums fo a board';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `column`
--

LOCK TABLES `column` WRITE;
/*!40000 ALTER TABLE `column` DISABLE KEYS */;
INSERT INTO `column` VALUES (379,1456654650,1483643238,137,137,112,'Agenda',1,'381','a:1:{i:0;s:13:\"MoveToBacklog\";}'),(380,1456654650,1513984349,137,137,112,'Waiting',2,'381','a:1:{i:0;s:13:\"MoveToBacklog\";}'),(381,1456654650,1513984460,137,137,112,'Discussion',3,'380,382','a:1:{i:0;s:13:\"MoveToBacklog\";}'),(382,1456654650,1513984519,137,137,112,'Action',4,'379,381','a:2:{i:0;s:10:\"CreateTask\";i:1;s:13:\"MoveToBacklog\";}'),(383,1456654650,1513984541,137,137,112,'Protocol',5,'380','a:2:{i:0;s:13:\"MoveToBacklog\";i:1;s:15:\"MoveToCompleted\";}'),(384,1482890769,1503516075,NULL,137,114,'Incoming',1,'384','a:2:{i:0;s:16:\"CreateResolution\";i:1;s:10:\"CreateTask\";}');
/*!40000 ALTER TABLE `column` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m160118_193925_add_ticket_protocol_field',1453236326),('m160227_135915_tasks_add_completed',1456581937),('m160310_212821_VotePriority',1457648869),('m160320_221138_decoration_data',1458512068),('m170824_164933_add_board_id',1503593639);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `public_email` varchar(255) DEFAULT NULL,
  `gravatar_email` varchar(255) DEFAULT NULL,
  `gravatar_id` varchar(32) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `bio` text,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resolution`
--

DROP TABLE IF EXISTS `resolution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resolution` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'main key; apc basic Yii table',
  `created_at` int(11) NOT NULL COMMENT 'create timestamp; apc basic Yii table',
  `updated_at` int(11) NOT NULL COMMENT 'update timestamp; apc basic Yii table',
  `created_by` int(11) NOT NULL COMMENT 'create blame; apc basic Yii table',
  `updated_by` int(11) NOT NULL COMMENT 'update blame; apc basic Yii table',
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `board_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resolution`
--

LOCK TABLES `resolution` WRITE;
/*!40000 ALTER TABLE `resolution` DISABLE KEYS */;
INSERT INTO `resolution` VALUES (1,1455841515,1503923323,137,137,'sdg - the xeno dude','Fragen Sie Ihre Apotheker',10323,114),(2,1456583481,1456583481,138,137,'We Say ','This is the way it is dude',10324,112),(3,1503854014,1503854014,137,137,'Dude','',5,114),(4,1503854046,1503854046,137,137,'Dude Twin','',5,112);
/*!40000 ALTER TABLE `resolution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `id` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` VALUES ('0rum9dkg0mofbii8ck0i3vmei4',1507462302,'__flash|a:0:{}__id|i:137;activeBoard|s:3:\"112\";'),('5m00c4jqd6ngn941qgn0lqgmbk',1513721344,'__flash|a:0:{}__id|i:137;activeBoard|s:3:\"112\";__returnUrl|s:6:\"/board\";'),('5napg46u38tbk3mi855cbv2r6a',1513098804,'__flash|a:0:{}'),('7i0fjbadlmamghmc10bsgndnh2ep3ihsldf7a261a6p44m8fnu50',1506451565,'__flash|a:0:{}__id|i:137;activeBoard|s:3:\"112\";'),('96c6eggcrokb40pe8of04gskjt',1514038168,'__flash|a:0:{}'),('a74t9q98khpkjr3nug0fpkh6k1',1511733342,'__flash|a:0:{}__id|i:137;activeBoard|s:3:\"112\";__returnUrl|s:14:\"/board/backlog\";'),('air4ss3ube05tesev3jni7svus',1512935277,'__flash|a:0:{}__id|i:137;activeBoard|s:3:\"112\";'),('c33esc0rv4q4t5gl84agtebvdp',1512938943,'__flash|a:0:{}'),('g97rg0pjuogaq79k7g2li281nc',1514038200,'__flash|a:0:{}__id|i:137;activeBoard|s:3:\"112\";'),('ja5c1sq9j6nfr36ftgu959lovn',1513019460,'__flash|a:0:{}__returnUrl|s:9:\"/sitenews\";'),('jhbhbebeiq6l8qvnppck37ipht',1511735825,'__flash|a:0:{}__id|i:137;activeBoard|s:3:\"112\";__returnUrl|s:14:\"/board/backlog\";'),('n69vgg6a325dt8t5dubce8duf0',1513987287,'__flash|a:0:{}__id|i:137;activeBoard|s:3:\"112\";__returnUrl|s:6:\"/board\";'),('qmlohvh55m2en8cendl5cc4a24',1513986395,'__flash|a:0:{}__returnUrl|s:6:\"/board\";__id|i:137;activeBoard|s:3:\"112\";'),('s5sh7l6anlm4lcd7ods1i1tbak',1513286234,'__flash|a:0:{}__id|i:137;activeBoard|s:3:\"112\";'),('sdq0mnbbl9r971f3cebia1snm4',1514038163,'__flash|a:0:{}'),('v3ndn67vk98gl26tppsvosr7p8',1513292230,'__flash|a:0:{}__id|i:137;activeBoard|s:3:\"112\";__returnUrl|s:6:\"/board\";');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_news`
--

DROP TABLE IF EXISTS `site_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'main key; apc basic Yii table',
  `created_at` int(11) NOT NULL COMMENT 'create timestamp; apc basic Yii table',
  `updated_at` int(11) NOT NULL COMMENT 'update timestamp; apc basic Yii table',
  `created_by` int(11) NOT NULL COMMENT 'create blame; apc basic Yii table',
  `updated_by` int(11) NOT NULL COMMENT 'update blame; apc basic Yii table',
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `board_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_news`
--

LOCK TABLES `site_news` WRITE;
/*!40000 ALTER TABLE `site_news` DISABLE KEYS */;
INSERT INTO `site_news` VALUES (1,1477759583,1503924498,137,137,'Hey boy!','Hmmmm',114);
/*!40000 ALTER TABLE `site_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frequency` int(11) NOT NULL,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tagname_index` (`name`(16))
) ENGINE=InnoDB AUTO_INCREMENT=252 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (229,38,'TagEos'),(230,40,'TagQuos'),(231,35,'TagSed'),(232,32,'TagId'),(247,5,'junk4'),(248,10,'junk1'),(249,1,'AveryLongTag'),(250,1,'YetAnotherTag'),(251,1,'thisisatag');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'main key; apc basic Yii table',
  `created_at` int(11) NOT NULL COMMENT 'create timestamp; apc basic Yii table',
  `updated_at` int(11) NOT NULL COMMENT 'update timestamp; apc basic Yii table',
  `created_by` int(11) NOT NULL COMMENT 'create blame; apc basic Yii table',
  `updated_by` int(11) NOT NULL COMMENT 'update blame; apc basic Yii table',
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `ticket_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `completed` tinyint(1) DEFAULT NULL,
  `board_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` VALUES (6,1457204441,1488483876,138,137,'Test Task','Does it work? Maybe it does, hmm?',10473,137,0,112),(7,1457204441,1488483888,138,137,'Test Task Dude','2.0 Does it work?  Maybe it does, hmmm?',10473,139,0,112),(9,1503516120,1503516120,137,137,'Billy Ticket','Xenodofia',10503,138,0,114),(10,1503853090,1503853090,137,137,'Billy 2.0','',0,NULL,0,114),(11,1503853123,1503922465,137,137,'Billy 3.0 gonna change','',10503,NULL,0,112);
/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `column_id` int(11) DEFAULT '0',
  `board_id` int(11) NOT NULL,
  `ticket_order` int(11) DEFAULT NULL COMMENT 'Order of the tickets within a particular column, backlog, completed',
  `protocol` text COLLATE utf8_unicode_ci,
  `vote_priority` int(11) DEFAULT NULL,
  `decoration_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `column_id` (`column_id`),
  KEY `board_id` (`board_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10504 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` VALUES (10323,1455790677,1503921437,137,137,'Dolor quo error voluptatem.','Perferendis maxime dolorum dolorem dicta. Quo et unde fugit mollitia. Aut ut ex rerum.',0,114,1,'dxyz',1,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:1:{i:137;i:1;}}}'),(10325,1455436821,1475009514,137,137,'Nulla aut quasi ipsam ut.','Voluptate alias ea neque blanditiis porro dolorem non quis. Maiores est reiciendis maiores aut dolor nihil voluptas. Et labore facilis eum debitis necessitatibus ut.',0,112,0,'',-1,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:1:{i:137;i:-1;}}}'),(10326,1454695252,1456654650,137,137,'Eos eum vel voluptas rerum.','Quis sit laudantium aut. Fugiat rem minus adipisci temporibus aut. Quaerat quisquam ratione dolor ut et.',0,112,0,NULL,NULL,''),(10327,1454539703,1456654651,137,137,'Omnis sint at itaque.','Ut quasi ad sequi quis quae pariatur vitae. Eveniet fuga velit qui numquam repudiandae sed velit cum. Culpa et itaque reiciendis. Repellat optio quasi reprehenderit numquam ut.',0,112,0,NULL,NULL,''),(10328,1456524519,1456654651,137,137,'Illo et ratione neque nulla.','Nostrum consequuntur saepe eveniet quae. Velit consectetur omnis quo est iure alias ducimus. Consequatur impedit possimus cum maxime.',0,112,0,NULL,NULL,''),(10329,1455953062,1456654651,137,137,'Quidem deserunt id eaque.','Est ducimus culpa vel ab vero. Quibusdam doloremque odio corporis sunt quia dolor nisi. Provident in inventore explicabo repellat.',0,112,0,NULL,NULL,''),(10330,1455271008,1458901866,137,137,'Et sunt et odit ut omnis.','Blanditiis sint consequatur veritatis voluptatum dolor. Placeat sint consectetur eos possimus pariatur. Sunt perferendis dolorum quae iusto.',0,112,0,NULL,-1,''),(10331,1454825751,1456654651,137,137,'Et fugit animi omnis aut.','Quae voluptas magnam minus odio aut et non. Et similique quidem aut unde. Totam ea praesentium aut eum illum nam. Impedit voluptatibus praesentium voluptatem error corrupti impedit.',0,112,0,NULL,NULL,''),(10332,1454541180,1475009505,137,137,'Atque ex dicta sit qui quo.','Itaque error voluptate placeat nulla et illum corporis. Id harum quos facilis eaque. Ut possimus et dolor labore. Voluptatem cumque eligendi incidunt sequi et.',0,112,0,NULL,-1,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:0:{}}}'),(10333,1454775555,1456654651,137,137,'Id inventore rerum et fuga.','Amet in tempore voluptatem velit deserunt occaecati a. Mollitia aliquid eius quaerat deserunt. Laborum quod dolorum velit quaerat facilis odio.',0,112,0,NULL,NULL,''),(10334,1455913381,1503921684,137,137,'Quo est et eaque et.','Illo nihil omnis repellat ut ex voluptatem nam. Voluptas nobis tempore sit earum. Recusandae dolores ut sed architecto consequatur numquam debitis. Libero sit eos eum voluptatum corrupti est.',0,114,0,'',NULL,'a:0:{}'),(10335,1455306377,1456654651,137,137,'Vel ut vero harum ab.','Maiores a neque nulla sint. Expedita consequatur nemo dolor aut. Ipsa sint est earum quidem. Et mollitia possimus unde repudiandae error quidem.',0,112,0,NULL,NULL,''),(10336,1456525689,1456654651,137,137,'Nostrum ipsam ut magnam.','Eum sit voluptatibus culpa quisquam ut quis laudantium. Qui ab dicta hic alias et quo. Ut corporis at eos doloremque sunt qui iusto. Expedita qui qui voluptas sapiente sint ex corrupti.',0,112,0,NULL,NULL,''),(10337,1454731374,1479748067,137,137,'Praesentium eum alias itaque.','Et molestiae in neque. Consequuntur quo suscipit doloremque eos aperiam alias odio. Saepe consequuntur officia explicabo earum temporibus mollitia veritatis. Sed quia saepe dolores eum voluptas.',0,112,0,'xx',0,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:1:{i:137;i:-1;}}}'),(10338,1455653395,1456654651,137,137,'Sed mollitia expedita non.','Est aliquam corrupti voluptatem ut nisi officiis. Quisquam est natus temporibus illum enim. Quis animi iste eius omnis. Molestias saepe quod perspiciatis et enim.',0,112,0,NULL,NULL,''),(10339,1456220383,1456654652,137,137,'Rem magni consequuntur error.','Voluptate cum ab ducimus ad expedita optio. Sit in enim totam et consequuntur in ipsum. Qui doloremque voluptatibus repellat aut sint. Non a voluptas consequatur porro sunt et a.',0,112,0,NULL,NULL,''),(10340,1456481778,1456654652,137,137,'Totam eos quis odit est.','Quisquam eum sunt ut voluptatem enim dignissimos inventore. Aut eos aut voluptatum assumenda officiis. Consectetur id et magnam eos accusamus amet.',0,112,0,NULL,NULL,''),(10341,1456232843,1456654652,137,137,'Sunt sit ut eos non minus.','Consequuntur ipsum pariatur rerum. Fugit et incidunt aut similique qui rerum quasi. Praesentium eligendi at est iusto. Doloremque velit omnis velit dolore dolorum neque.',0,112,0,NULL,NULL,''),(10342,1456281462,1513712883,137,137,'Vitae ad quos qui ut et.','Nostrum dolorem nihil rerum qui voluptatem praesentium soluta. Qui non voluptatum magni pariatur est. Consequatur hic doloremque dicta fugiat sit ex unde at.',379,112,0,NULL,0,'a:0:{}'),(10343,1456206339,1456654652,137,137,'Ea debitis quis nobis.','Nobis nisi vel at ut recusandae exercitationem nulla. Ad sed rerum itaque non quis eos facilis. Cupiditate non aut officiis.',0,112,0,NULL,NULL,''),(10344,1455975797,1456654652,137,137,'Quia placeat est suscipit.','Facere earum culpa vitae amet non cumque corrupti qui. Modi molestiae temporibus et expedita. Dolorem ex minima pariatur in.',0,112,0,NULL,NULL,''),(10345,1456497194,1456654652,137,137,'Cumque optio molestias est.','Impedit voluptatibus ut maxime a et. Aut corrupti neque omnis incidunt blanditiis sed quia placeat. Repudiandae vel ut rerum qui ut sint vitae accusantium. Tenetur est tenetur voluptas occaecati.',0,112,0,NULL,NULL,''),(10346,1454204385,1456654652,137,137,'Nihil rem vero et modi.','Commodi deserunt accusamus enim voluptatem consequatur iure mollitia non. Fuga sequi autem et ut quam enim. Est commodi ut tenetur ea est. Dolore autem omnis qui laboriosam est eum.',0,112,0,NULL,NULL,''),(10347,1455020069,1456654652,137,137,'Ut quod molestias id.','Non fugiat pariatur necessitatibus et omnis molestiae. Quo earum quaerat aspernatur. Debitis ut sed natus tempora necessitatibus. Commodi est dolorem quis sit cum.',0,112,0,NULL,NULL,''),(10348,1456565890,1479676094,137,137,'Sit esse dolores delectus et. Sit esse dolores delectus et. Sit esse dolores delectus et. Sit esse dolores delectus et. Dudestein. Sit esse dolores delectus et. Sit esse dolores delectus et. Sit esse dolores delectus et. Sit esse dolores delectus et. ','Rem soluta nam repellendus molestiae iusto veritatis et. Enim est ea voluptas numquam expedita. Aliquid quo quidem recusandae libero nulla quia qui. Aut qui sit natus earum laborum nihil.',0,112,0,'',0,'a:0:{}'),(10349,1454117126,1474997958,137,137,'Est fuga non tenetur autem.','Saepe beatae vitae qui voluptates. Explicabo eius ut aperiam. Magni assumenda et et reprehenderit sed suscipit voluptatem facilis. Maxime sunt voluptate ex et rerum nihil expedita est.',0,112,0,'',NULL,'a:0:{}'),(10350,1455845493,1458859537,137,137,'Aut fugiat magnam et sit.','Consequatur omnis et doloribus et. Repellat eius exercitationem eaque nisi animi quas. Natus sit nemo dolores labore voluptas eos. Quo ipsa quos voluptatem aut omnis placeat.',0,112,0,NULL,-1,''),(10351,1456087916,1456654652,137,137,'Ut reprehenderit tempore aut.','Doloribus commodi sit optio et soluta aperiam quod. Illo sunt deserunt perspiciatis fuga voluptatum magnam.',0,112,0,NULL,NULL,''),(10352,1455110432,1456654652,137,137,'Officiis nostrum in quia.','Quas quod sunt delectus amet. Rerum quia expedita soluta. Impedit et voluptatem odio est nemo. Quidem sit voluptatem aspernatur omnis voluptas ut laboriosam.',0,112,0,NULL,NULL,''),(10353,1455620993,1456654653,137,137,'In tempore qui sed molestias.','Eum qui itaque qui saepe. Aut quidem perspiciatis at adipisci et. Fugit doloremque quisquam nam.',0,112,0,NULL,NULL,''),(10354,1455737263,1456654653,137,137,'Id officiis ut quo.','Maiores nihil vel qui non et. Aut adipisci blanditiis sit et. Voluptas molestiae rerum ullam libero eos eum.',0,112,0,NULL,NULL,''),(10355,1454346735,1456654653,137,137,'Quo vel voluptatum id enim.','Placeat ut voluptatem assumenda quis provident fuga. Iure sed nostrum expedita.',0,112,0,NULL,NULL,''),(10356,1455051436,1456654653,137,137,'Minima at et et enim ut.','Dolorum aut quasi nisi. Nobis incidunt tenetur qui et deserunt et. Iusto iure consequatur aut dolor id quod aperiam.',0,112,0,NULL,NULL,''),(10357,1454834180,1456654653,137,137,'Quam ut nostrum aut vel.','Aliquam ut dolor quasi in delectus. Et et eligendi et corrupti. Molestiae et voluptatem vel ab assumenda et.',0,112,0,NULL,NULL,''),(10358,1454856122,1456654653,137,137,'Sunt est amet omnis ipsam.','Laborum veniam excepturi qui fugit. Facilis explicabo eaque dignissimos quo hic vitae repellendus. Totam omnis et vel quia recusandae. Nihil id omnis repellat ut vel.',0,112,0,NULL,NULL,''),(10359,1455536634,1456654653,137,137,'Aut sint et et.','Sequi tenetur iure quod placeat. Laboriosam maxime fuga ut sed. Minus voluptate et id saepe consequatur perferendis aut non.',0,112,0,NULL,NULL,''),(10360,1454206987,1456654653,137,137,'In et sit quia maxime et.','Et id eos ut maxime natus delectus. Et tempora voluptas nemo sit architecto. Eum quo excepturi nulla sunt. Omnis perspiciatis consequuntur eius. Quia ducimus dolorem nulla harum.',0,112,0,NULL,NULL,''),(10361,1454631257,1456654653,137,137,'Eum ut natus deserunt.','Eveniet rerum autem similique aut labore. Qui debitis omnis et exercitationem. Dolores cumque eos laudantium inventore tenetur molestiae nihil.',0,112,0,NULL,NULL,''),(10362,1456151971,1458859533,137,137,'Nemo eos et fuga commodi.','Sapiente omnis et unde facilis aliquam nam nam. Rem fugit suscipit ipsa et ullam aut iusto iure. Doloribus sunt sed adipisci porro qui non. In ad minima ut distinctio facere.',0,112,0,'',-1,''),(10363,1455606140,1456654653,137,137,'Nemo expedita in quisquam.','Delectus vel molestiae reprehenderit explicabo ex culpa vel. Explicabo vero perspiciatis minima nobis. Voluptatem placeat dolor quidem eum.',0,112,0,NULL,NULL,''),(10364,1455520747,1456654653,137,137,'Fuga veniam iure culpa.','Enim nesciunt accusamus dolores ab laboriosam aut ut. Id atque ut quo vero sit incidunt. Voluptas atque repellendus quia vero et sint quia.',0,112,0,NULL,NULL,''),(10365,1456580697,1480159703,137,137,'In consequuntur ut est unde.','Facere in sit ut tempora ut soluta. Repellendus fugiat excepturi ut est autem. Optio error ut tenetur quidem voluptatem dolor vitae. Inventore reprehenderit dolore rem ab excepturi aliquid libero.',-1,112,0,'g',1,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:1:{i:137;i:1;}}}'),(10366,1454732804,1456654654,137,137,'Nisi rerum velit hic hic.','Quae dolorum sunt aut. Vel omnis incidunt numquam est. Repellendus quia cumque aut architecto. Laboriosam non quas beatae voluptas eum exercitationem harum.',0,112,0,NULL,NULL,''),(10367,1456539460,1456654654,137,137,'Est dolores eos minus aut.','Aperiam omnis sint non omnis iusto tempora. Amet reiciendis molestiae officiis est at officiis nobis. Mollitia sit enim eos voluptatem. Vel inventore nihil qui qui.',0,112,0,NULL,NULL,''),(10368,1455930527,1456654654,137,137,'Laboriosam quos aliquid ea.','Inventore tempore cupiditate sunt recusandae. Doloribus sit alias in commodi ratione maiores. Aut praesentium error rem molestiae. Tempora sint dolor quis et est.',0,112,0,NULL,NULL,''),(10369,1454910198,1456654654,137,137,'Non ea sit aut voluptatem.','Et ut nostrum omnis et. Minus eius iste porro maiores vitae culpa temporibus omnis. Non quia est optio sed.',0,112,0,NULL,NULL,''),(10370,1454903402,1475009520,137,137,'Unde reiciendis dolore rerum.','Et minus voluptas a dolor quis voluptas nihil asperiores. Omnis consequuntur qui sunt tempore soluta explicabo architecto. Vel quisquam consequatur sequi laudantium necessitatibus.',0,112,0,NULL,-1,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:1:{i:137;i:-1;}}}'),(10371,1454387070,1456654654,137,137,'Dolorum vel non quas maiores.','Odio ut consectetur eius ut deleniti consequuntur eum. Neque ut sed pariatur. Blanditiis eos repellendus iusto neque.',0,112,0,NULL,NULL,''),(10372,1455954000,1456654654,137,137,'Enim nam enim quos soluta.','Ea corporis non unde distinctio. Animi ea odio odit et odit et repellendus possimus.',0,112,0,NULL,NULL,''),(10373,1455757019,1456654654,137,137,'Sed sit quis blanditiis.','Unde et illo id ex omnis et qui. Recusandae et odit aut quis. Qui vel accusantium et omnis sapiente.',0,112,0,NULL,NULL,''),(10374,1456347578,1456654654,137,137,'Vel fuga qui commodi.','Praesentium exercitationem aperiam consectetur. Maxime est quia dignissimos alias voluptatum. Similique provident excepturi non rerum ut distinctio aut.',0,112,0,NULL,NULL,''),(10375,1454740781,1458592431,137,137,'Aspernatur corporis dolor ea.','Quo maiores in quis ut unde sint nemo. Autem libero qui qui ut. Et incidunt eos nihil ipsam quia. Laboriosam qui ipsum repellat autem architecto eos. Odio magni libero omnis hic aliquam.',-1,112,0,NULL,NULL,''),(10376,1454264321,1456654654,137,137,'Quae corporis esse ea.','Commodi unde saepe et reiciendis quis. Officia aut repellendus dolore quia natus sed. Earum praesentium qui consequatur asperiores dolores. Molestiae eligendi perferendis aliquid possimus aut libero.',0,112,0,NULL,NULL,''),(10377,1456361840,1456654655,137,137,'Fuga porro eum eos sint.','Dolorem deserunt minima ut. Sunt magni et ipsa dolorum iusto explicabo cupiditate. Beatae velit et iure non.\nEt ex illum ipsa quia. Vitae quis non eveniet voluptatibus doloribus.',0,112,0,NULL,NULL,''),(10378,1456063263,1456654655,137,137,'In voluptatibus atque ipsa.','Reprehenderit est molestiae a eum laboriosam nihil quam possimus. Debitis magnam dolores quas nulla ut unde magnam. Officia fugit qui iusto tempore saepe possimus blanditiis.',0,112,0,NULL,NULL,''),(10379,1456281532,1458859540,137,137,'Voluptatem et eaque qui est.','Et natus porro ipsam nesciunt labore placeat quia nam. A placeat quaerat quis quisquam aliquam harum. Quo sit sunt aliquid quaerat nobis est molestiae. Quidem similique harum autem.',0,112,0,NULL,0,''),(10380,1454892468,1475009517,137,137,'Unde iure ea nesciunt aut.','Placeat sit nemo itaque dignissimos minima modi in. Distinctio alias optio magnam iure in. Exercitationem officiis aut eligendi ducimus et itaque veritatis.',0,112,0,NULL,-1,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:1:{i:137;i:-1;}}}'),(10381,1456578191,1513719479,137,137,'Quia qui quae beatae et.','Deserunt sunt dolorum molestias tempore itaque libero quo. Dicta et earum nam non eligendi architecto. Alias molestiae quas ipsum voluptatum qui.',381,112,0,NULL,NULL,'a:0:{}'),(10382,1454781634,1456654655,137,137,'Rerum rem id officia.','Id explicabo rerum voluptas ut. Praesentium et veritatis aliquid placeat consequatur. Quo iste assumenda aliquam est cumque et cum tenetur.',0,112,0,NULL,NULL,''),(10383,1455752235,1456654655,137,137,'Vel id unde magnam.','Enim aut neque assumenda quasi. Et eius rerum omnis cupiditate non maiores eligendi praesentium. Error qui sint fugiat. Doloribus minus voluptatem optio id.',0,112,0,NULL,NULL,''),(10384,1455795215,1456654655,137,137,'Iure quas et modi.','Corporis voluptatem expedita non placeat non. Quia repellendus ut sunt consequuntur ut et. Ipsa adipisci velit ut ut ut non architecto. Quae explicabo ut nihil in amet similique.',0,112,0,NULL,NULL,''),(10385,1454449226,1479667756,137,137,'Delectus sapiente hic autem.','Suscipit voluptas inventore voluptas aut natus minus. Sapiente consectetur error atque aspernatur sint ut consectetur. Nihil sint corrupti corrupti eum.',0,112,0,'',3,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:1:{i:137;i:1;}}}'),(10386,1455731347,1458594186,137,137,'Velit porro unde praesentium.','Ducimus fugiat odio et magni. Mollitia ullam est et asperiores odit rerum. Sunt nostrum nulla quia non debitis quia. Possimus ut dolor autem vero quod qui et et.',0,112,0,NULL,-1,''),(10387,1455064025,1456654655,137,137,'Tempore ut est quis amet.','Sint necessitatibus sed vero rerum neque voluptas ipsum commodi. Veritatis hic nobis explicabo qui. Commodi ut hic suscipit ex et. Aut cupiditate sed explicabo qui dolorum quibusdam maiores illo.',0,112,0,NULL,NULL,''),(10388,1455878472,1456654656,137,137,'Ut nemo at mollitia.','Excepturi eum ea aspernatur modi sed. Nisi itaque assumenda similique neque sint occaecati. Id a incidunt tempora voluptas. Dolor et illum suscipit ullam et.',0,112,0,NULL,NULL,''),(10389,1454153709,1456654656,137,137,'Pariatur et omnis sit veniam.','Officia et est cumque dolore non eaque alias. Omnis voluptates dignissimos cupiditate ut doloremque dolor. Rerum fuga magnam voluptas nihil quis assumenda minus esse. Sed sunt et voluptas ratione.',0,112,0,NULL,NULL,''),(10390,1455342700,1456654656,137,137,'Officia rerum autem a.','Ex unde quibusdam vero ut eveniet. Et id provident consequatur recusandae rerum quidem voluptatum. Voluptatem minus placeat dolor consequatur placeat quis provident.',0,112,0,NULL,NULL,''),(10391,1455315867,1478354215,137,137,'Aut quisquam quia amet porro. dude','Laboriosam est rem rerum pariatur. Dicta alias natus debitis qui voluptatum. Sunt ab hic illum animi est sunt. Atque omnis veniam nulla non aliquam et omnis. dude',0,112,2,'',2,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:1:{i:137;i:1;}}}'),(10392,1455076546,1456654656,137,137,'Cupiditate quia vero aliquam.','Dolorem qui laborum esse est nemo alias. Minus quis eius qui consequatur rerum repudiandae quisquam. Corrupti tempora doloremque nihil in. Quo enim assumenda explicabo minima iure voluptatibus id.',0,112,0,NULL,NULL,''),(10393,1454793792,1456654656,137,137,'Et veniam fuga omnis.','Et nulla est voluptas quibusdam. Quo facilis libero magnam atque dolores repellat. Rerum minima qui dolor modi aliquid dignissimos corrupti.',0,112,0,NULL,NULL,''),(10394,1456242056,1513719479,137,137,'Eos ut ad a ipsum.','Possimus quia mollitia voluptatem est. Sed et debitis voluptatem. Error et et rem iste magni. Incidunt id sed rerum adipisci non voluptatibus minus.',381,112,3,NULL,NULL,'a:0:{}'),(10395,1456232488,1479680785,137,137,'Quo voluptatem rerum nihil.','Cupiditate molestiae illum et esse et maiores. Veritatis molestiae inventore et voluptas dicta tenetur iusto est. Voluptas aut nam architecto numquam.',0,112,2,NULL,NULL,'a:0:{}'),(10396,1454586031,1456654656,137,137,'Molestiae repellat aut saepe.','Tempora ipsum quis sed. Quas consectetur alias quo beatae rerum consequuntur. Optio facere ipsam exercitationem id eveniet. Necessitatibus pariatur error consequatur voluptatem omnis perspiciatis ea.',0,112,0,NULL,NULL,''),(10397,1454627950,1456654656,137,137,'Et dolor ipsum harum est.','Voluptatem temporibus et blanditiis voluptate neque ut. Assumenda consequuntur dolorum praesentium corrupti. Quibusdam quae temporibus maiores aliquid quia et aut.',0,112,0,NULL,NULL,''),(10398,1455538550,1456654656,137,137,'Et reprehenderit veniam iure.','Et tempora voluptas dolor et quos voluptatibus voluptatem. At ipsa et sed ad ducimus libero at dolorem.',0,112,0,NULL,NULL,''),(10399,1454663930,1456654656,137,137,'Omnis qui aut labore ab.','Cumque reprehenderit esse officia rerum totam amet. Rerum sed et dolorem ipsa. Recusandae accusamus est assumenda iste libero pariatur molestiae.',0,112,0,NULL,NULL,''),(10400,1455649130,1456654657,137,137,'Sit non quos ut consequuntur.','Molestiae aliquid fuga quibusdam debitis explicabo numquam perspiciatis fugiat. Aut et ipsum quia alias omnis. Quaerat ut dolor et quidem qui. Libero ullam sed ipsum nisi dolore placeat.',0,112,0,NULL,NULL,''),(10401,1455108578,1513719482,137,137,'Veritatis rerum possimus ut.','### Header\r\nDudeList\r\n- One\r\n- Tow\r\n\r\n- [x] Finish my changes\r\n- [ ] Push my commits to GitHub\r\n- [ ] Open a pull request\r\n\r\n[Billston Bob](http://abc.junk.com)\r\n\r\n@octocat :+1: This PR looks great - it\'s ready to merge! :shipit:',380,112,1,'#### Protokoll',0,'a:0:{}'),(10402,1455258618,1456654657,137,137,'Rerum in illum et omnis et.','Numquam magni neque laboriosam et sed a. Mollitia commodi omnis est aspernatur minus dolorum velit a. Tempore sed architecto assumenda laudantium nam.',0,112,0,NULL,NULL,''),(10403,1455768913,1456654657,137,137,'Nam provident ex iste in.','Optio optio alias rerum vel eveniet quibusdam qui. Molestiae ut ullam sed vero. Maxime dolorum dolorem quasi error. Animi ut voluptas et natus voluptas.',0,112,0,NULL,NULL,''),(10404,1455875215,1456654657,137,137,'Odio minus quis quam nobis.','Dolores sint ipsa vel occaecati. Quo aut unde id voluptatem eligendi dolores sint. Commodi qui repellendus sed quam eligendi aliquid quia.',0,112,0,NULL,NULL,''),(10405,1455295327,1456654657,137,137,'Omnis itaque recusandae a.','Iusto similique ea consequuntur ut illum. Placeat laudantium culpa voluptatem omnis veniam et. Omnis quam incidunt eveniet sunt animi.',0,112,0,NULL,NULL,''),(10406,1456372253,1456654657,137,137,'Iure quos in doloremque.','Quas quia similique provident. Delectus nam ea facere odit neque. At aut aut voluptas ipsum.',0,112,0,NULL,NULL,''),(10407,1454169793,1456654657,137,137,'Dolores iure itaque nobis et.','Esse debitis officia omnis cumque. Molestias commodi laudantium sed temporibus. Voluptas dolores quibusdam labore et optio magni culpa.',0,112,0,NULL,NULL,''),(10408,1456002396,1456654657,137,137,'Est et voluptate eius fugiat.','Soluta iure voluptatem et magni error dolorem. Sed eaque veniam recusandae fugit voluptate voluptas deleniti. Ut harum at et quis qui accusamus molestiae.',0,112,0,NULL,NULL,''),(10409,1455964771,1456654657,137,137,'Dolor alias soluta et.','Cum qui in dolorem ut aut ab est. Quaerat voluptatem illum aspernatur.',0,112,0,NULL,NULL,''),(10410,1455972392,1456654657,137,137,'Velit aliquam expedita quia.','Qui sit doloribus impedit velit. Quidem voluptatum accusantium delectus inventore. Sunt dolorem repellendus quo quaerat debitis aliquid qui.',0,112,0,NULL,NULL,''),(10411,1454143683,1456654657,137,137,'Est voluptas facere aut est.','Sunt labore fugit earum laudantium. Voluptas nihil velit est quia et laborum. Dolores vel est delectus nobis facere itaque et eos. Provident similique magni exercitationem ducimus numquam deleniti.',0,112,0,NULL,NULL,''),(10412,1454656961,1456654658,137,137,'Ut porro porro ut.','Aliquid quis consequuntur et fugit dicta explicabo. Hic animi et ratione voluptates culpa. Quia ullam deleniti velit.',0,112,0,NULL,NULL,''),(10413,1454925117,1456654658,137,137,'Iusto dolores ex dolore.','Nemo sed tempore eveniet aut culpa. Ipsum blanditiis non sapiente dolores aut. Quod ut dignissimos dolore similique tenetur.',0,112,0,NULL,NULL,''),(10414,1455095543,1476034122,137,137,'Unde explicabo porro iste. (dude)','Veritatis ducimus saepe et libero laboriosam et. Accusantium eligendi et aut et a. Aperiam est ea eligendi sed ipsum suscipit. Quod distinctio labore quod tempora.',-1,112,0,'',8,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:1:{i:137;i:-1;}}}'),(10415,1454766505,1456654658,137,137,'Facilis neque labore non.','Voluptas est at modi laboriosam hic. Est soluta aliquam sint quia deleniti dolorem eaque. Adipisci expedita quisquam est eum eum hic illum.',0,112,0,NULL,NULL,''),(10416,1454149699,1458902256,137,137,'Quia sapiente aut ab sit.','Vel qui pariatur sequi iste dolorum nihil cumque. Qui ipsam quam quo voluptatem commodi sed. Ipsam quasi veritatis possimus quam.',0,112,0,NULL,-1,''),(10417,1455094709,1458430896,137,138,'Aut in accusamus vel quidem.','Est enim odit eum ratione mollitia. A autem atque voluptates ex. Temporibus sit vel corrupti voluptatem.',0,112,0,NULL,-1,''),(10418,1454310873,1456654658,137,137,'Sapiente quo quo voluptates.','Rerum cumque veniam et pariatur. Ea reprehenderit cupiditate amet molestias. Sunt quisquam vel ea alias deleniti. Vel nihil aut in consectetur. Voluptate aperiam sed rem aspernatur.',0,112,0,NULL,NULL,''),(10419,1455423637,1456654658,137,137,'Et saepe ad et libero nam.','Et doloremque quidem molestiae aperiam ducimus. Sunt voluptas dolor ratione ipsa quasi facere. Et sunt beatae soluta corrupti. Non incidunt ut ut aut et architecto fugit.',0,112,0,NULL,NULL,''),(10420,1456145741,1458430755,137,138,'Culpa et at perferendis odit.','Molestiae ipsum dolore soluta eaque aut rerum cumque sequi. Possimus non temporibus esse eveniet. Delectus id labore cum aut. Et et exercitationem sit distinctio recusandae recusandae saepe.',0,112,0,NULL,NULL,''),(10421,1455961209,1456654658,137,137,'Dolores aliquam occaecati et.','Cumque consequatur omnis maiores placeat rerum vel ut. Qui consectetur suscipit maiores eveniet. Dolorem qui quo ratione magni facere eum. Cumque suscipit autem itaque est animi dignissimos autem.',0,112,0,NULL,NULL,''),(10422,1456158676,1456654658,137,137,'Sint id quisquam voluptatem.','Eos adipisci sunt quam perspiciatis quod adipisci exercitationem. Laborum eveniet placeat et fugit numquam. Magnam et nihil laudantium rerum.',0,112,0,NULL,NULL,''),(10423,1455945043,1456654658,137,137,'Libero eos ipsam ea eaque.','Sint sapiente accusantium eaque laborum. Excepturi laboriosam minus a odit ratione autem. Ea non reiciendis rerum sit laborum cupiditate accusantium a. Est animi omnis atque sed libero aut autem.',-1,112,0,NULL,NULL,''),(10424,1455023975,1456654659,137,137,'Quia eius et ipsa quia.','Nisi sed laboriosam et fuga. Et fugit ut exercitationem aut. Sit id quia tempore sed itaque.\nPariatur dolorum ut quos mollitia eum. Quis nemo ex odio cumque. Ipsam totam explicabo non sit.',-1,112,0,NULL,NULL,''),(10425,1454366750,1456654659,137,137,'Nostrum officia natus cum.','Corrupti eum rerum laborum cumque quis eligendi ea. Autem unde sunt quis saepe fugit nobis nihil quibusdam. Voluptates ipsa odio molestiae repellat.',-1,112,0,NULL,NULL,''),(10426,1454918612,1456654659,137,137,'Et ut qui explicabo sunt.','Rem voluptatem aut ab repudiandae. Ad quia eveniet ullam qui tenetur reiciendis.',-1,112,0,NULL,NULL,''),(10427,1456065739,1456654659,137,137,'Tenetur et dolores quas.','Sapiente inventore est rerum optio. Enim ad est praesentium consequatur quia esse quia. Vitae doloremque ipsa sed repellat aliquid. Repellendus quaerat optio voluptatem harum vero itaque sed.',-1,112,0,NULL,NULL,''),(10428,1455475686,1456654659,137,137,'Ut sed provident dolorem eos.','Voluptatem delectus veritatis sit sed voluptates. Laudantium soluta ipsam atque consequatur ex occaecati. Modi quam et sed eligendi.',-1,112,0,NULL,NULL,''),(10429,1455504875,1456654659,137,137,'Et delectus et amet.','Ipsam qui eius reiciendis et quas sint. Ut nesciunt sunt suscipit provident est. Tempore fugiat iusto omnis voluptate quia quia. Sapiente beatae nemo non saepe ratione qui odio.',-1,112,0,NULL,NULL,''),(10430,1454244535,1456654659,137,137,'Voluptates ducimus iusto est.','Est est eos veritatis autem quaerat fugit. Temporibus quia consequatur voluptates quam iusto ratione. Autem voluptatem quia et suscipit dolor.',-1,112,0,NULL,NULL,''),(10431,1454305402,1456654659,137,137,'Officiis ut quae laboriosam.','Beatae modi qui et velit doloremque hic. Dolorem quidem deserunt velit iste laborum. Sed rem ducimus excepturi minus.',-1,112,0,NULL,NULL,''),(10432,1454137948,1456654659,137,137,'Nam ea ea nihil odio quis.','Expedita suscipit dolorum qui voluptas ullam ut. Qui corporis enim aperiam eligendi sit. Est architecto consequatur sint commodi cupiditate.',-1,112,0,NULL,NULL,''),(10433,1456500196,1513719482,137,137,'begin This is a very long word dueimamazing short word','',380,112,2,'',NULL,'a:0:{}'),(10434,1455440573,1456654659,137,137,'Dignissimos fuga qui illum.','Est ullam ad quis. Repellat repellat omnis tempora minima velit qui architecto. Dolores voluptatem non natus. Omnis maiores est consequatur sunt.',-1,112,0,NULL,NULL,''),(10435,1455149166,1456654659,137,137,'Qui non aut iusto recusandae.','Consequatur sit ipsam in rerum. Officia sequi aut velit velit mollitia aliquid. Non in sit itaque repellendus aliquam corporis nesciunt.',-1,112,0,NULL,NULL,''),(10436,1455120189,1456654659,137,137,'Ipsa autem maiores fuga vel.','Qui repellendus esse dolores sequi et rerum id sunt. Temporibus quos animi quisquam numquam.',-1,112,0,NULL,NULL,''),(10437,1454782870,1456654659,137,137,'Iste atque facilis qui error.','Omnis vel sit assumenda quam illo dolor. Earum enim voluptates aut numquam dolore nobis. Rem autem suscipit quia necessitatibus. Ipsam excepturi voluptas nostrum velit rem et qui.',-1,112,0,NULL,NULL,''),(10438,1456417758,1456654659,137,137,'Voluptatibus qui velit dicta.','Facilis minus eaque maiores sint fuga dolorum maiores. Molestias asperiores autem rerum nesciunt harum facere amet. Sapiente dolor aspernatur et veniam cumque.',-1,112,0,NULL,NULL,''),(10439,1456326266,1456654659,137,137,'Dicta vel non hic nostrum.','Exercitationem explicabo inventore nulla aliquid rerum adipisci magni. Eos reprehenderit occaecati sed praesentium. Velit quod qui consequatur.',-1,112,0,NULL,NULL,''),(10440,1456241617,1456654659,137,137,'In tempore distinctio et qui.','Voluptatem omnis sunt et. Necessitatibus id voluptas saepe nesciunt. Minima necessitatibus blanditiis quam. Et molestias omnis rem sequi.',-1,112,0,NULL,NULL,''),(10441,1456236016,1456654660,137,137,'Quia est et sint ad tenetur.','Animi ut voluptas dolorum magni odit adipisci fugit. Esse reiciendis itaque fugit perferendis.',-1,112,0,NULL,NULL,''),(10442,1455347783,1456654660,137,137,'Porro et est quo sed.','Et soluta nostrum sunt et rerum vel dolor. Et non molestias fugiat sint corrupti iure. Aliquid laboriosam vitae sint nam unde. Dolorem odio laboriosam debitis quae sequi harum hic.',-1,112,0,NULL,NULL,''),(10443,1456653921,1456654660,137,137,'Tempora veniam et et totam.','Hic suscipit minima aut ex minus. Repellat quisquam vero velit consequatur. Aut aut minima molestiae aut quasi.',-1,112,0,NULL,NULL,''),(10444,1454335858,1456654660,137,137,'Qui et sunt unde aperiam.','Ipsam natus et accusamus ab corrupti. Culpa id laborum culpa omnis. Esse et sit est et et repellat perferendis. Magnam labore nemo placeat illo voluptatem maxime.',-1,112,0,NULL,NULL,''),(10445,1455314316,1456654660,137,137,'Accusantium sunt et dolor.','Aut consequuntur cum unde. Aliquam doloremque quo vitae velit esse minus. Rem qui cupiditate porro. Sit quisquam ea ullam nisi.',-1,112,0,NULL,NULL,''),(10446,1455457764,1456654660,137,137,'Quos quia ut maiores quia.','Itaque et expedita aut ut ipsum necessitatibus quia. Deserunt molestiae quis doloremque corporis veniam corporis quam. Voluptatem minima consequatur tempora aut sed vero dolor. Optio aut eos autem.',-1,112,0,NULL,NULL,''),(10447,1454741447,1456654660,137,137,'Quo omnis quia sit et.','Alias voluptatibus ab fugit reiciendis. Unde ut et quis ut rerum. Et eligendi dolore neque iste sequi qui.',-1,112,0,NULL,NULL,''),(10448,1455708679,1456654660,137,137,'Earum earum ipsa ab iusto.','Aut nihil amet exercitationem necessitatibus. Voluptate et qui labore minima molestiae aut. Numquam sed laudantium sapiente vel laudantium natus veniam tenetur. Porro corrupti autem veniam.',-1,112,0,NULL,NULL,''),(10449,1455844796,1456654660,137,137,'Culpa eos et explicabo sequi.','Consectetur tempora quod vero omnis quae ipsa aliquam. Porro fugit iste minus expedita quia pariatur assumenda quidem. Architecto non et veniam quis dicta. Voluptates saepe quae rerum et.',-1,112,0,NULL,NULL,''),(10450,1455954968,1456654660,137,137,'Et dolore rerum odit et.','Non excepturi ut nihil veritatis. Quod praesentium eaque ipsam nihil. Sint iure delectus corporis qui nostrum cum.',-1,112,0,NULL,NULL,''),(10451,1456209590,1456654661,137,137,'Illo natus inventore nostrum.','Eum nisi quo quos praesentium reprehenderit temporibus. Et qui et tenetur in saepe. Minima sunt et aut earum quia.',-1,112,0,NULL,NULL,''),(10452,1456133237,1456654661,137,137,'Qui omnis et amet.','Officiis rerum facere pariatur ex recusandae quia ipsum expedita. Qui ut velit beatae inventore deserunt itaque culpa. Rem qui quia numquam vel ipsa rem.',-1,112,0,NULL,NULL,''),(10453,1454692888,1456654661,137,137,'Corporis et sed sed repellat.','Quia inventore non dolorem iste nostrum quia. Amet sint distinctio ut ea aut ullam. Quis omnis saepe asperiores dignissimos quae et illo.',-1,112,0,NULL,NULL,''),(10454,1454732388,1456654661,137,137,'Est et aut ex quidem.','Facilis assumenda sequi neque numquam reiciendis omnis eos. Accusamus ratione at quia quia eum eveniet qui. Consequatur temporibus consequatur nisi.',-1,112,0,NULL,NULL,''),(10455,1455401626,1456654661,137,137,'Tempora laboriosam in dolor.','Similique nihil officia non aut quo. Aut sit quia est vitae. Voluptas molestias velit animi temporibus sed et. Voluptas quasi perspiciatis repellat autem.',-1,112,0,NULL,NULL,''),(10456,1454631228,1456654661,137,137,'Sit eaque in beatae.','Et sapiente quaerat saepe doloribus aut eos vel aperiam. Illum praesentium consectetur beatae architecto consequatur qui hic. Et nemo ut quisquam nemo aut autem ad et.',-1,112,0,NULL,NULL,''),(10457,1454748960,1456654661,137,137,'Numquam aut ducimus nobis et.','Molestiae aut dolore accusamus quia. Nisi est exercitationem accusamus officiis aut qui. Voluptas voluptatem unde delectus rerum earum dolore.',-1,112,0,NULL,NULL,''),(10458,1454132206,1456654661,137,137,'Dolor repellendus at et.','Omnis enim officiis debitis nam temporibus. Quas non eius ut aperiam nobis. Libero voluptatum fuga in quia ut omnis.',-1,112,0,NULL,NULL,''),(10459,1454590257,1456654661,137,137,'Illum hic id quo voluptate.','Corrupti voluptas ut nam optio possimus omnis quia. Quibusdam quas sunt fuga qui voluptas. Incidunt repellendus ut ut architecto repellat pariatur odit.',-1,112,0,NULL,NULL,''),(10460,1455409298,1456654661,137,137,'Sunt eum cumque et voluptate.','Magnam veniam assumenda id atque rerum. Est omnis quae enim voluptates asperiores rerum molestiae cupiditate. Dolorem necessitatibus voluptatem distinctio sed. Et nisi omnis ex nihil velit rerum.',-1,112,0,NULL,NULL,''),(10461,1456338358,1456654662,137,137,'A sapiente et reiciendis.','Repellendus sequi facere ea repudiandae quibusdam. Reprehenderit enim sint non omnis. Non ipsum harum itaque error. Suscipit eum sit ducimus natus est harum deserunt.',-1,112,0,NULL,NULL,''),(10462,1456202526,1456654662,137,137,'Doloremque est et ipsa rerum.','Itaque sit et accusantium pariatur. Magnam labore voluptatum sapiente corporis. Minus provident sint totam et impedit.',-1,112,0,NULL,NULL,''),(10463,1454387347,1456654662,137,137,'Voluptas et rem quod impedit.','Culpa omnis officiis saepe in. Enim quia et reiciendis id.',-1,112,0,NULL,NULL,''),(10464,1455705403,1456654662,137,137,'Ipsa et est sed ab.','Sit quis est aliquid cumque et et qui. Animi itaque tempore nisi pariatur repellendus asperiores. In et maiores qui assumenda ea doloremque et.',-1,112,0,NULL,NULL,''),(10465,1454803147,1456654662,137,137,'Eius magni ea eum.','Accusantium at dolor voluptatem non sit aliquid sed. Facilis non pariatur laudantium. Ex rerum cumque non voluptates. Et qui in exercitationem vel sit.',-1,112,0,NULL,NULL,''),(10466,1456131201,1456654662,137,137,'Dolor autem maiores nobis.','Et veniam quam quia nulla. Vero maiores et velit cum est architecto. Suscipit molestiae quia eos dolor nobis eius. Reiciendis aut sit commodi.',-1,112,0,NULL,NULL,''),(10467,1454164723,1456654662,137,137,'Ea est ut minus aut.','Neque iure non ipsa et corrupti perspiciatis itaque harum. Ut non molestiae fugit eum at.',-1,112,0,NULL,NULL,''),(10468,1456071539,1456654662,137,137,'Modi non earum sed.','Nisi occaecati aut quasi delectus. Excepturi vero placeat accusamus ut. Aut ex molestias aut rerum necessitatibus dignissimos et. Facere doloremque nemo iste nemo.',-1,112,0,NULL,NULL,''),(10469,1456003422,1456654662,137,137,'Eligendi eaque nulla ut.','Sit quisquam aliquam quos repudiandae. Expedita aliquid ipsam laborum beatae. Sunt et voluptate voluptatem commodi perspiciatis.',-1,112,0,NULL,NULL,''),(10470,1456424770,1503338489,137,137,'Ut eos numquam tenetur qui.','Modi officiis qui cum est. Tenetur magni qui cumque voluptatibus sint et. Deserunt autem ut ex voluptas quis. Qui et voluptatum error tempore.',0,112,0,NULL,NULL,'a:0:{}'),(10471,1455568431,1456654663,137,137,'Aspernatur harum quia est.','Porro consequatur minima magni illo omnis. Repellendus occaecati et vero corrupti illo in qui. Non et ipsam voluptatem deserunt delectus et aliquid.',-1,112,0,NULL,NULL,''),(10472,1455893341,1456654663,137,137,'Aut ea qui illum sed.','Maiores vitae quidem quisquam. Soluta molestiae officiis distinctio molestias corrupti qui. Amet dolorum dolorem quia ut totam.\nEst corporis voluptatum maxime ea qui. Rerum necessitatibus et aut.',-1,112,0,NULL,NULL,''),(10473,1454809060,1458331603,137,138,'Hic reiciendis ad rem.','Consequatur voluptatibus debitis eveniet sint vitae et officiis. Officiis similique recusandae aut maiores qui. Porro doloremque consequatur nihil ratione ullam. Qui odit ab dolore officia error.',0,112,0,NULL,NULL,''),(10474,1456121239,1458595570,137,137,'Eaque sit sit aut quo.','Ipsa aut non iure. Sint ullam mollitia aut rerum reiciendis. Similique vel impedit officiis aut eos consequuntur qui. Perspiciatis quas et minus sunt sunt reiciendis architecto.',0,112,1,NULL,NULL,''),(10475,1455717169,1458595571,137,137,'Sit illo modi qui.','Error molestiae illo eum molestias. Iusto provident et molestiae voluptas expedita sit. Amet sunt sunt nihil facere aut modi et.',0,112,2,NULL,NULL,''),(10476,1455276370,1458595572,137,137,'Sit deleniti illum aut ut.','Corrupti molestias voluptatibus consequatur dolorem asperiores quo est. Molestias beatae nam officia. Non voluptatibus enim illum omnis ut.',0,112,3,NULL,NULL,''),(10477,1454873546,1479588414,137,137,'Ut rerum molestiae quam.','Magni exercitationem mollitia unde. Aliquam dicta expedita ducimus non accusamus qui.',-1,112,1,'x',10,'a:0:{}'),(10478,1456654978,1513712878,137,137,'Copy - Hic reiciendis ad rem.','Consequatur voluptatibus debitis eveniet sint vitae et officiis. Officiis similique recusandae aut maiores qui. Porro doloremque consequatur nihil ratione ullam. Qui odit ab dolore officia error.',379,112,1,NULL,1,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:1:{i:137;i:1;}}}'),(10479,1458394591,1513719482,138,137,'Copy - In consequuntur ut est unde.','Facere in sit ut tempora ut soluta. Repellendus fugiat excepturi ut est autem. Optio error ut tenetur quidem voluptatem dolor vitae. Inventore reprehenderit dolore rem ab excepturi aliquid libero.',380,112,0,NULL,-2,'a:0:{}'),(10493,1474802094,1479747124,137,137,'x','',-1,112,NULL,NULL,NULL,'a:0:{}'),(10494,1474802115,1479680227,137,137,'v','',-1,112,0,NULL,NULL,'a:0:{}'),(10495,1474802961,1479669450,137,137,'gh','',-1,112,NULL,NULL,NULL,'a:0:{}'),(10496,1474802981,1503338493,137,137,'hj','',0,112,0,NULL,NULL,'a:0:{}'),(10497,1474803006,1513712872,137,137,'hhjhjjx','',379,112,1,'',NULL,'a:0:{}'),(10498,1475007345,1513719479,137,137,'Integrate PHP and JavaScript','In ticketSorting.js constants are required in order to reference Html/Dom-Elements which are created in _column.php.  \r\nDRY - I need to be able to define such constants in PHP and have them transported to JS. So Somehow I need a linkage. At SCM/ICM-Webservices we have the same problem using Magento.\r\n\r\nI need a general procedure/pattern in which constants from PHP are written and then loaded into JavaScript globally.\r\n\r\nIn this specific case it\'s the constant for the vollapsable button IDs \"button-\"',381,112,4,'',1,'a:1:{s:35:\"common_models_ticketDecoration_Vote\";a:1:{s:15:\"backlogPriority\";a:1:{i:137;i:1;}}}'),(10499,1479587083,1513984149,137,137,'Copy - hhjhjj','',382,112,0,NULL,NULL,'a:0:{}'),(10500,1479669333,1479679036,137,137,'Copy - x','',-1,112,NULL,NULL,NULL,'a:0:{}'),(10501,1479669344,1479669344,137,137,'Copy - Copy - x','',0,112,NULL,NULL,NULL,'a:0:{}'),(10502,1479677860,1503338491,137,137,'Copy - gh','',0,112,1,NULL,NULL,'a:0:{}'),(10503,1503515896,1503777799,137,137,'Billy Ticket','',384,114,NULL,NULL,NULL,'a:0:{}');
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_tag_mm`
--

DROP TABLE IF EXISTS `ticket_tag_mm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_tag_mm` (
  `ticket_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  UNIQUE KEY `ticket_id` (`ticket_id`,`tag_id`) COMMENT 'Enforce unique Ticket-Tag pairs',
  KEY `ticket_index` (`ticket_id`),
  KEY `tag_index` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_tag_mm`
--

LOCK TABLES `ticket_tag_mm` WRITE;
/*!40000 ALTER TABLE `ticket_tag_mm` DISABLE KEYS */;
INSERT INTO `ticket_tag_mm` VALUES (10337,248),(10348,247),(10348,248),(10349,248),(10365,229),(10385,247),(10385,248),(10391,229),(10391,230),(10391,231),(10391,232),(10391,249),(10391,250),(10391,251),(10401,248),(10477,247),(10477,248);
/*!40000 ALTER TABLE `ticket_tag_mm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Too small?',
  `password_reset_token` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Too small?',
  `email` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Too small?',
  `status` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `password` tinytext COLLATE utf8_unicode_ci,
  `board_id` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Standard Yii User-DB';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (137,'demo','$2y$13$A6io5qw/jTOqX5/Ykt1RIe3bLvhAvcYwHlmFw2h9s92OH83cvOVc.','','mymail@andypotter.org','Iq1xRg9GImv0wIap-vyhD4v2wqQo49ba',30,1456654649,1485377776,'','112,114'),(138,'demo2','$2y$13$A6io5qw/jTOqX5/Ykt1RIe3bLvhAvcYwHlmFw2h9s92OH83cvOVc.','','feg-do@andypotter.org','Iq1xRg9GImv0wIap-vyhD4v2wqQo49ba',10,1456654649,1503002204,'','114'),(139,'demo3','','','apc@andypotter.org','',20,1482442668,1503171580,NULL,'112');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-30 14:08:39
