-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: localhost    Database: microred
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `acos`
--

DROP TABLE IF EXISTS `acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_acos_lft_rght` (`lft`,`rght`),
  KEY `idx_acos_alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` VALUES (1,NULL,NULL,NULL,'controllers',1,82),(8,1,NULL,NULL,'Groups',2,13),(9,8,NULL,NULL,'index',3,4),(10,8,NULL,NULL,'view',5,6),(11,8,NULL,NULL,'add',7,8),(12,8,NULL,NULL,'edit',9,10),(13,8,NULL,NULL,'delete',11,12),(20,1,NULL,NULL,'Pages',14,17),(21,20,NULL,NULL,'display',15,16),(22,1,NULL,NULL,'Parametros',18,29),(23,22,NULL,NULL,'index',19,20),(24,22,NULL,NULL,'view',21,22),(25,22,NULL,NULL,'add',23,24),(26,22,NULL,NULL,'edit',25,26),(27,22,NULL,NULL,'delete',27,28),(46,1,NULL,NULL,'Users',30,47),(47,46,NULL,NULL,'login',31,32),(48,46,NULL,NULL,'logout',33,34),(49,46,NULL,NULL,'index',35,36),(50,46,NULL,NULL,'view',37,38),(51,46,NULL,NULL,'add',39,40),(52,46,NULL,NULL,'edit',41,42),(53,46,NULL,NULL,'delete',43,44),(54,1,NULL,NULL,'AclExtras',48,49),(55,1,NULL,NULL,'DebugKit',50,57),(56,55,NULL,NULL,'ToolbarAccess',51,56),(57,56,NULL,NULL,'history_state',52,53),(58,56,NULL,NULL,'sql_explain',54,55),(61,46,NULL,NULL,'initDB',45,46),(62,1,NULL,NULL,'Permisos',58,71),(63,62,NULL,NULL,'roles',59,60),(64,62,NULL,NULL,'aplicaciones',61,62),(65,62,NULL,NULL,'add',63,64),(66,62,NULL,NULL,'acceso',65,66),(67,62,NULL,NULL,'edit',67,68),(68,62,NULL,NULL,'delete',69,70),(73,1,NULL,NULL,'Menus',72,81),(74,73,NULL,NULL,'index',73,74),(75,73,NULL,NULL,'add',75,76),(79,73,NULL,NULL,'delete',77,78),(80,73,NULL,NULL,'edit',79,80);
/*!40000 ALTER TABLE `acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros`
--

DROP TABLE IF EXISTS `aros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_aros_lft_rght` (`lft`,`rght`),
  KEY `idx_aros_alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros`
--

LOCK TABLES `aros` WRITE;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
INSERT INTO `aros` VALUES (1,NULL,'Group',1,'Administrador',1,4),(2,NULL,'Group',2,'managers',5,8),(3,NULL,'Group',3,'users',9,12),(4,1,'User',1,'cramos',2,3),(5,2,'User',2,'joselo',6,7),(6,3,'User',3,'marisa',10,11),(7,NULL,'Group',4,'Vendedor',13,16),(8,7,'User',4,'paco',14,15);
/*!40000 ALTER TABLE `aros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros_acos`
--

DROP TABLE IF EXISTS `aros_acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`),
  KEY `idx_aco_id` (`aco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros_acos`
--

LOCK TABLES `aros_acos` WRITE;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
INSERT INTO `aros_acos` VALUES (1,1,1,'1','1','1','1'),(2,2,1,'-1','-1','-1','-1'),(7,3,1,'-1','-1','-1','-1'),(10,3,48,'1','1','1','1'),(17,2,8,'1','1','1','1'),(18,2,12,'-1','-1','-1','-1');
/*!40000 ALTER TABLE `aros_acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cake_sessions`
--

DROP TABLE IF EXISTS `cake_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cake_sessions`
--

LOCK TABLES `cake_sessions` WRITE;
/*!40000 ALTER TABLE `cake_sessions` DISABLE KEYS */;
INSERT INTO `cake_sessions` VALUES ('1gf7f3nshdk7qo99guqlveo3j5','Config|a:3:{s:9:\"userAgent\";s:32:\"d40ff99e0ebd93e80d13bf168c45f468\";s:4:\"time\";i:1494728287;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494728287),('2vck8273io269fdeukhicnb081','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494840440;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}Message|a:0:{}',1494840440),('385ugti4g893kdjbr9hebo8bf7','Config|a:3:{s:9:\"userAgent\";s:32:\"d40ff99e0ebd93e80d13bf168c45f468\";s:4:\"time\";i:1494733637;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494733637),('3qvp769g11512m09vrcou2rb25','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494801900;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494801900),('54uv2i6l4g8pb49hqbu9vt1ou2','Config|a:3:{s:9:\"userAgent\";s:32:\"d40ff99e0ebd93e80d13bf168c45f468\";s:4:\"time\";i:1494732547;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494732547),('57e14f19jull565jq8j2dahbk1','Config|a:3:{s:9:\"userAgent\";s:32:\"ceb78607e1f4a530047f42d75d102f28\";s:4:\"time\";i:1494044254;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494044255),('6edkafol5opi6ousfsm46hlkb0','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494825456;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"2\";s:8:\"username\";s:6:\"joselo\";s:8:\"group_id\";s:1:\"2\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:26:18\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";s:19:\"2017-04-26 01:26:20\";s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"2\";s:4:\"name\";s:8:\"managers\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:22:43\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}Message|a:0:{}',1494825456),('7iid1tmo38e53ip7uof99jtqo7','Config|a:3:{s:9:\"userAgent\";s:32:\"d40ff99e0ebd93e80d13bf168c45f468\";s:4:\"time\";i:1494910531;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}Message|a:0:{}',1494910532),('7t5ib7m10bkn27udm1jr5oanc3','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494204705;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494204706),('8q5docdi5ninfktcobbaa05ep4','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494043672;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494043888),('acj7hvpqff0pag1j9inegvsbe5','Config|a:3:{s:9:\"userAgent\";s:32:\"d40ff99e0ebd93e80d13bf168c45f468\";s:4:\"time\";i:1494910957;s:9:\"countdown\";i:10;}',1494910957),('bcdcuvk51soo82bd6rrr6mkec0','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494170642;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494170642),('bo85i3kvh1jen7u3j9b8n582j2','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494782267;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494782267),('br4ei80lrc7f334sjfmfm5fop6','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494142489;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494142490),('bu8cbd29gl3mrb63a48i0uhcj4','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494226407;s:9:\"countdown\";i:10;}Message|a:0:{}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494226407),('c169b3ki8k9qs5gtn5fds4gsa6','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494199196;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494199196),('c82rfh757ltulg7o19jgm4tbs2','Config|a:3:{s:9:\"userAgent\";s:32:\"ceb78607e1f4a530047f42d75d102f28\";s:4:\"time\";i:1494049359;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494049359),('eudo92k90pkdiiuis7koj2tg35','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494049218;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"4\";s:8:\"username\";s:4:\"paco\";s:8:\"group_id\";s:1:\"4\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:0:\"\";s:6:\"creado\";N;s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:8:\"Vendedor\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-05-06 05:53:41\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494049219),('fhchjsidu5t8qvuc0r121tib80','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494146062;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494146063),('gbrl49r9sega5kn6cm3vatu4a5','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494803839;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494803840),('h08qq0ncovn20h1o8ohdb2epv6','Config|a:3:{s:9:\"userAgent\";s:32:\"ceb78607e1f4a530047f42d75d102f28\";s:4:\"time\";i:1494043320;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}Message|a:0:{}',1494043320),('hd4a2l7hk4p9jmgniru2vh2d20','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494569877;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}Message|a:0:{}',1494569877),('js3kargu1eimjuibch0f0otnf4','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494799171;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}Message|a:0:{}',1494799171),('l1e78mfselt06044n328ii0013','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494229375;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494229375),('mtn5b4hdb892ve3u8a3ab9l836','Config|a:3:{s:9:\"userAgent\";s:32:\"d40ff99e0ebd93e80d13bf168c45f468\";s:4:\"time\";i:1494654085;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}Message|a:0:{}',1494654085),('o128fs7u2jusdst1f9ulj8oqr6','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494181792;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}Message|a:0:{}',1494181792),('ocko0u19itl4qfad60003u51n6','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494200337;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494200337),('pmpmr1v0hb0j0k0tdmgfc2b354','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494044211;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494044238),('pq2aug7b3dd1hks4o0oeldog62','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494784078;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494784078),('qgm23heo303e1fbh4vslfsarl0','Config|a:3:{s:9:\"userAgent\";s:32:\"ceb78607e1f4a530047f42d75d102f28\";s:4:\"time\";i:1494135703;s:9:\"countdown\";i:10;}Message|a:0:{}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494135704),('qm2l7kavs10qh65lmqm2f4rol7','Config|a:3:{s:9:\"userAgent\";s:32:\"d40ff99e0ebd93e80d13bf168c45f468\";s:4:\"time\";i:1494654202;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494654202),('qm8htunc7sh32lemk8bcnfk9b6','Config|a:3:{s:9:\"userAgent\";s:32:\"ceb78607e1f4a530047f42d75d102f28\";s:4:\"time\";i:1494044036;s:9:\"countdown\";i:10;}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:51:\"No estÃ¡ autorizado para acceder a esta aplicaciÃ³n\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494044037),('tj3en4kqbco8q2gc5t4034o9n5','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494139035;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}Message|a:0:{}',1494139036),('uqhiodbnhikdeoftjbs22cmi84','Config|a:3:{s:9:\"userAgent\";s:32:\"317a2b6ef8f48dbbc8cb8937d34f2001\";s:4:\"time\";i:1494835345;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:9:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"cramos\";s:8:\"group_id\";s:1:\"1\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:24:19\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;s:5:\"Group\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:13:\"Administrador\";s:6:\"estado\";s:1:\"A\";s:7:\"creador\";s:6:\"cramos\";s:6:\"creado\";s:19:\"2017-04-26 01:19:00\";s:11:\"modificador\";s:0:\"\";s:10:\"modificado\";N;}}}',1494835345);
/*!40000 ALTER TABLE `cake_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `estado` varchar(1) NOT NULL DEFAULT 'A',
  `creador` varchar(45) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `modificador` varchar(45) DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Administrador','A','cramos','2017-04-26 01:19:00','',NULL),(2,'managers','A','cramos','2017-04-26 01:22:43','',NULL),(3,'users','A','cramos','2017-04-26 01:22:56','',NULL),(4,'Vendedor','A','cramos','2017-05-06 05:53:41','',NULL);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `aro_id` int(10) DEFAULT NULL,
  `aco_id` int(10) DEFAULT NULL,
  `creador` varchar(45) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `modificador` varchar(45) DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menus_acos1_idx` (`aco_id`),
  KEY `fk_menus_arod1_idx` (`aro_id`) USING BTREE,
  CONSTRAINT `fk_menus_acos1` FOREIGN KEY (`aco_id`) REFERENCES `acos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_menus_aros1` FOREIGN KEY (`aro_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Permisos',NULL,1,12,1,NULL,NULL,NULL,NULL,NULL),(2,'Grupos',1,2,3,1,9,NULL,NULL,NULL,NULL),(3,'Usuarios',1,4,5,1,49,NULL,NULL,NULL,NULL),(4,'Aplicaciones',1,6,7,1,64,NULL,NULL,NULL,NULL),(5,'Accesos',1,8,9,1,63,NULL,NULL,NULL,NULL),(10,'Permisos',NULL,13,14,2,NULL,NULL,NULL,NULL,NULL),(14,'Menu',1,10,11,1,74,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametros`
--

DROP TABLE IF EXISTS `parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `modulo` varchar(45) NOT NULL,
  `variable` varchar(45) NOT NULL,
  `valor` varchar(45) NOT NULL,
  `creador` varchar(45) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `modificador` varchar(45) DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametros`
--

LOCK TABLES `parametros` WRITE;
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` VALUES (3,'migracion_productos','sizePag','500',NULL,NULL,NULL,NULL),(4,'migracion_productos','page','5',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` char(40) NOT NULL,
  `group_id` int(11) NOT NULL,
  `estado` varchar(1) NOT NULL DEFAULT 'A',
  `creador` varchar(45) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `modificador` varchar(45) DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `fk_users_group1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'cramos','bf6a2efc75b87407bbd2d59cd620f9c4948ce1c9',1,'A','cramos','2017-04-26 01:24:19','',NULL),(2,'joselo','bf6a2efc75b87407bbd2d59cd620f9c4948ce1c9',2,'A','cramos','2017-04-26 01:26:18','','2017-04-26 01:26:20'),(3,'marisa','bf6a2efc75b87407bbd2d59cd620f9c4948ce1c9',3,'A','cramos','2017-04-26 01:26:43','','2017-04-26 01:26:45'),(4,'paco','bf6a2efc75b87407bbd2d59cd620f9c4948ce1c9',4,'A','',NULL,'',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-15 23:04:31
