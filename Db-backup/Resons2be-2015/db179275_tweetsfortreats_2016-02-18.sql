# ************************************************************
# Sequel Pro SQL dump
# Version 4500
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: internal-db.s179275.gridserver.com (MySQL 5.1.67-rel14.3)
# Database: db179275_tweetsfortreats
# Generation Time: 2016-02-18 14:18:29 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tweetsfortreats_people
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tweetsfortreats_people`;

CREATE TABLE `tweetsfortreats_people` (
  `user_id` text,
  `screen_name` text,
  `nbr_tweets` int(11) DEFAULT NULL,
  `nbr_tweets_alltime` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `reminder` int(1) DEFAULT NULL,
  `following` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tweetsfortreats_people` WRITE;
/*!40000 ALTER TABLE `tweetsfortreats_people` DISABLE KEYS */;

INSERT INTO `tweetsfortreats_people` (`user_id`, `screen_name`, `nbr_tweets`, `nbr_tweets_alltime`, `created_at`, `reminder`, `following`)
VALUES
	('27408336','xpengler',1,10,1441456600,NULL,NULL),
	('2419194338','weareblacksun',2,9,1441618436,NULL,1),
	('1657836672','spencerdkelly',1,2,1441619170,NULL,NULL),
	('14532521','henryryder',1,1,1441619386,NULL,NULL),
	('2491320422','GrantCieciura',1,1,1441619651,NULL,NULL),
	('327502885','BossAlienTweets',1,1,1441624897,NULL,NULL),
	('125096100','terminaidan',1,1,1441625535,NULL,NULL),
	('14152106','jwrosewell',1,1,1441628090,NULL,NULL),
	('180325408','pauwly',1,1,1441629594,NULL,NULL),
	('177524928','svetlatymna',1,1,1441631710,NULL,NULL),
	('71025753','MrAndrewWhittle',1,1,1441634521,NULL,NULL),
	('19677483','judelloo',1,2,1441634582,NULL,NULL),
	('21992321','joportus',1,1,1441639521,NULL,NULL),
	('15454228','hereinthehive',1,1,1441639584,NULL,NULL),
	('438242506','de',1,1,1441639711,NULL,NULL),
	('22194989','jasonbradberry',1,1,1441639856,NULL,NULL),
	('156748799','jencrewdson',1,1,1441643768,NULL,NULL),
	('2194243387','RyanPlyanLion',1,2,1441644089,NULL,NULL),
	('30104562','pedrocyrne',1,1,1441644142,NULL,NULL),
	('85600414','Ph0bu5',1,1,1441651121,NULL,NULL),
	('896230098','ShalynWilkins',1,3,1441652057,NULL,NULL),
	('39793843','terranetwork',1,2,1441652149,NULL,NULL),
	('109205927','mmh2712',1,2,1441656998,NULL,NULL),
	('2817345366','gwenrobledo',1,1,1441657289,NULL,NULL),
	('1055006520','Escape_Tech',1,1,1441657319,NULL,NULL),
	('3313943261','3ll1c4m',1,1,1441657595,NULL,NULL),
	('23438053','katesaker',1,1,1441658291,NULL,NULL),
	('25073934','_craigpaterson',1,2,1441659863,NULL,NULL),
	('428577233','mighty_mess',2,6,1441660213,NULL,1),
	('18999814','IntiOcean',1,2,1441661552,NULL,NULL),
	('119190216','fridaguldberg',1,1,1441706891,NULL,NULL),
	('471017099','BecomeAli',1,1,1441707011,NULL,NULL),
	('58756093','konsumfrau',1,1,1441707362,NULL,NULL),
	('801897','wouter',1,1,1441710667,NULL,NULL),
	('15872025','mr_mg',1,1,1441711242,NULL,NULL),
	('19861675','jesperwahlstrom',1,1,1441711506,NULL,NULL),
	('247938110','kirilhristov',1,1,1441715150,NULL,NULL),
	('905934379','joshyouare_art',1,2,1441715860,NULL,NULL),
	('14077152','markbridge',1,1,1441716621,NULL,NULL),
	('33900416','constancevenn',1,1,1441720525,NULL,NULL),
	('532466109','tomboshting',1,4,1441720841,NULL,NULL),
	('2856694175','dotabouttown',1,1,1441721393,NULL,NULL),
	('441825336','NickPhillipps',1,1,1441721459,NULL,NULL),
	('288155230','ViolaWangStudio',1,3,1441725420,NULL,NULL),
	('19427806','davetremaine',1,2,1441733531,NULL,NULL),
	('23459486','nilane',1,1,1441735722,NULL,NULL),
	('1473132847','harperandfinch',1,1,1441740111,NULL,NULL),
	('135222788','GLeggettDesigns',1,1,1441744720,NULL,NULL),
	('6648482','hashir',1,1,1441803765,NULL,NULL),
	('1904428771','littlepeacebell',1,5,1443610633,NULL,NULL);

/*!40000 ALTER TABLE `tweetsfortreats_people` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
