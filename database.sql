# ************************************************************
# Sequel Pro SQL dump
# Version 3958
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.25)
# Database: WebEngi
# Generation Time: 2013-01-11 16:14:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table InsertFancyNameHere_article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `InsertFancyNameHere_article`;

CREATE TABLE `InsertFancyNameHere_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pageId` int(11) unsigned NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '0',
  `h1` varchar(128) NOT NULL DEFAULT '',
  `h2` varchar(128) DEFAULT '',
  `content` text,
  `authorId` int(10) unsigned NOT NULL DEFAULT '0',
  `creationDate` datetime NOT NULL,
  `updateDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pageId` (`pageId`),
  CONSTRAINT `InsertFancyNameHere_article_ibfk_1` FOREIGN KEY (`pageId`) REFERENCES `InsertFancyNameHere_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `InsertFancyNameHere_article` WRITE;
/*!40000 ALTER TABLE `InsertFancyNameHere_article` DISABLE KEYS */;

INSERT INTO `InsertFancyNameHere_article` (`id`, `pageId`, `display`, `h1`, `h2`, `content`, `authorId`, `creationDate`, `updateDate`)
VALUES
	(2,1,1,'Eine Überschrift','Unterüberschrift','<p><b>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam faucibus ornare felis eu porttitor. Suspendisse potenti. Pellentesque eget lectus nibh. Aliquam adipiscing leo id dui mollis mattis. Suspendisse elit ante, lacinia ac dapibus quis, fringilla et nisl. Mauris non nunc est, sagittis aliquet massa. Cras erat nisl, commodo id ornare ut, feugiat sed dui. Nunc tortor sem, accumsan sit amet iaculis at, adipiscing eleifend purus. Quisque aliquam placerat lorem vitae viverra. Duis vitae quam ante, sed mattis diam. Aenean ornare fringilla lacus sit amet viverra. Ut non nisi eget felis viverra pellentesque. </b><br />Cras lacus est, tempor in ultricies ac, mattis vel mi. Sed vel diam eu sem ultrices scelerisque eget eu nulla.Aenean nisi odio, viverra eget condimentum sit amet, ornare quis libero. Morbi a risus turpis. Vestibulum porttitor libero at odio sodales pretium. Suspendisse pharetra tincidunt enim sit amet tincidunt. Fusce posuere augue viverra mi pulvinar et pellentesque mauris tempor. Aenean viverra orci in ipsum elementum laoreet. Aenean tincidunt justo lorem. Vestibulum sit amet felis aliquam risus porttitor ullamcorper. Nullam non leo ac turpis porttitor tincidunt.</p>',1,'2013-01-11 17:05:15','2013-01-11 17:05:15'),
	(3,4,0,'Bla','','<p>13123131312311</p>',1,'2013-01-11 17:12:59','2013-01-11 17:12:59'),
	(4,4,1,'Kuchen','kekse','<p>test Test!</p>',1,'2013-01-11 17:13:23','2013-01-11 17:13:23');

/*!40000 ALTER TABLE `InsertFancyNameHere_article` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table InsertFancyNameHere_page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `InsertFancyNameHere_page`;

CREATE TABLE `InsertFancyNameHere_page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `parentId` (`parentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `InsertFancyNameHere_page` WRITE;
/*!40000 ALTER TABLE `InsertFancyNameHere_page` DISABLE KEYS */;

INSERT INTO `InsertFancyNameHere_page` (`id`, `parentId`, `name`)
VALUES
	(1,0,'Index1'),
	(3,0,'Test2'),
	(4,0,'test2');

/*!40000 ALTER TABLE `InsertFancyNameHere_page` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
