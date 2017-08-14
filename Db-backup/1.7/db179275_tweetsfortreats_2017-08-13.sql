# ************************************************************
# Sequel Pro SQL dump
# Version 4500
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: internal-db.s179275.gridserver.com (MySQL 5.1.67-rel14.3)
# Database: db179275_tweetsfortreats
# Generation Time: 2017-08-13 18:48:37 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tweetsfortreats_general
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tweetsfortreats_general`;

CREATE TABLE `tweetsfortreats_general` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `token` longtext,
  `hashtag` text,
  `duration` text,
  `user_id` text,
  `time_reset` int(11) NOT NULL,
  `empty` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tweetsfortreats_general` WRITE;
/*!40000 ALTER TABLE `tweetsfortreats_general` DISABLE KEYS */;

INSERT INTO `tweetsfortreats_general` (`id`, `token`, `hashtag`, `duration`, `user_id`, `time_reset`, `empty`)
VALUES
	(1,'AAAAAAAAAAAAAAAAAAAAAHM0RQAAAAAAXuD9W%2Be3KxuUYQGuiyq6Im2AU1c%3DAnDfPUEA8VtALH0SLo8nsB33yLHGZwTY6xWQUwk','TreatsTest','1','3230138123',1479775866,0);

/*!40000 ALTER TABLE `tweetsfortreats_general` ENABLE KEYS */;
UNLOCK TABLES;


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
	('1904428771','littlepeacebell',1,16,1455902052,NULL,NULL),
	('1416085208','BurgerBrethren',1,1,1455961012,NULL,NULL),
	('893513508','Mark4783',1,2,1455978813,NULL,NULL),
	('314750546','t3st',1,4,1456049714,NULL,NULL),
	('225010133','fi_henderson',1,2,1456058661,NULL,NULL),
	('3030862403','alice_burden',1,1,1456065048,NULL,NULL),
	('16465246','AndyPalmer',1,3,1456131209,NULL,NULL),
	('522931415','joyjetoapple',1,1,1456154834,NULL,NULL),
	('623570183','moon_lunatics',1,1,1456301008,NULL,NULL),
	('31892609','ticktricktrack',1,3,1456302059,NULL,NULL),
	('38875654','olispleen',1,1,1456413938,NULL,NULL),
	('587317717','BHSportsTherapy',1,4,1456655345,NULL,NULL),
	('97526395','MERRIMAKING',1,1,1457009379,NULL,NULL),
	('44345799','DrTabz',1,1,1457013975,NULL,NULL),
	('3334962915','TheAndrewFisher',1,1,1457014101,NULL,NULL),
	('338480805','DonnaComerford',1,1,1457098446,NULL,NULL),
	('26763831','framos735',1,1,1457364886,NULL,NULL),
	('2785362466','BrightonDogCare',1,1,1457542982,NULL,NULL),
	('32514191','natdodd',1,10,1457612267,NULL,NULL),
	('152737043','HamSughes',1,1,1458297353,NULL,NULL),
	('2697993903','dannyjarcher870',1,1,1458297554,NULL,NULL),
	('960863834','ItsmeMaggieG',1,1,1458298196,NULL,NULL),
	('772679521','Nagjazzle',1,1,1458321403,NULL,NULL),
	('3430176922','MrMackerel789',1,5,1458386636,NULL,NULL),
	('162651896','Nikcoole',1,1,1458390585,NULL,NULL),
	('946448586','StressedJenny',1,3,1458915745,NULL,NULL),
	('2419194338','weareblacksun',1,9,1459260660,NULL,NULL),
	('2273502103','smalltypedesign',1,1,1459328220,NULL,NULL),
	('128487509','VintageOwl',1,1,1459520700,NULL,NULL),
	('2462874834','ragsrevival',1,1,1459599219,NULL,NULL),
	('15047211','bearoon',1,1,1459760092,NULL,NULL),
	('4736096116','Uni_Fire_Guy',1,1,1459777912,NULL,NULL),
	('415788856','AttackPanicPete',1,1,1459778066,NULL,NULL),
	('19003671','Mighty_Ginge',1,6,1460367084,NULL,NULL),
	('3380625994','beachtapeband',1,4,1460636403,NULL,NULL),
	('486812573','merri0tt',1,1,1460815949,NULL,NULL),
	('418996856','GeorgieDavis_',1,3,1460816095,NULL,NULL),
	('378845108','george_palms',1,1,1461156991,NULL,NULL),
	('609182453','CSNewland',1,1,1461157027,NULL,NULL),
	('2660099736','morericepleasee',1,5,1461337655,NULL,NULL),
	('138348867','DanJMcauliffe',1,9,1461684491,NULL,NULL),
	('428577233','mighty_mess',1,2,1468435617,NULL,NULL),
	('2491184216','thejohnnyluu',1,1,1468603985,NULL,NULL),
	('74454110','RosalieHoskins',1,1,1468604715,NULL,NULL),
	('2194243387','RyanPlyanLion',1,2,1468605360,NULL,NULL),
	('14408363','lewisnyman',1,1,1468605590,NULL,NULL),
	('99793781','Whittakerwoo',1,1,1468605809,NULL,NULL),
	('304395895','PersistentPeril',1,1,1468605842,NULL,NULL),
	('150011964','jameslockehart',1,1,1468606362,NULL,NULL),
	('3665012673','LouisaMD_',1,1,1468607436,NULL,NULL),
	('2541137570','dom_melly',1,2,1468607474,NULL,NULL),
	('285500574','designbysublime',1,1,1468609209,NULL,NULL),
	('96553590','sparetimedesign',1,1,1468609893,NULL,NULL),
	('42256904','steviealanhole',1,1,1468610332,NULL,NULL),
	('546071759','iSquidney',1,1,1468611349,NULL,NULL),
	('2556675080','jemmsla',1,1,1468611470,NULL,NULL),
	('40018196','jeanlucbrouard',1,2,1468611740,NULL,NULL),
	('24567748','jackbolus',1,1,1468613323,NULL,NULL),
	('18630326','willaslettdraws',1,1,1468613546,NULL,NULL),
	('559868212','emcculloch27',1,1,1468613608,NULL,NULL),
	('255976678','jacobsclayton',1,2,1468615422,NULL,NULL),
	('349156272','georgerowe',1,1,1468615493,NULL,NULL),
	('31542280','RosieInman',1,1,1468615714,NULL,NULL),
	('9717162','purge',1,1,1468615784,NULL,NULL),
	('384471473','gangband420',1,1,1468616279,NULL,NULL),
	('394749444','aspaceforme',1,1,1468616608,NULL,NULL),
	('3230138123','IWantTreats',1,2,1470737538,NULL,NULL),
	('27408336','xpengler',1,3,1471690053,NULL,NULL),
	('104830972','puree_design',1,3,1473063669,NULL,NULL),
	('163961334','CreatedInEden',1,2,1473065089,NULL,NULL),
	('314141727','Carolin6868',1,1,1473065263,NULL,NULL),
	('84324512','arcaderage',1,1,1473065303,NULL,NULL),
	('551801154','LesiaBi',1,2,1473065387,NULL,NULL),
	('187541868','bermondseymike',1,1,1473069979,NULL,NULL),
	('3239061400','WolfAndJewel',1,1,1473070219,NULL,NULL),
	('108904110','gabydutton',1,2,1473071087,NULL,NULL),
	('49622764','edusmartin',1,1,1473073492,NULL,NULL),
	('79131603','bardinf',1,2,1473073679,NULL,NULL),
	('4266651520','getaroundin',1,1,1473077010,NULL,NULL),
	('46981779','rosscoombes',1,1,1473077266,NULL,NULL),
	('16563829','seanom',1,2,1473080329,NULL,NULL),
	('19463868','andomain',1,1,1473080611,NULL,NULL),
	('17074487','hannahwinter27',1,1,1473080926,NULL,NULL),
	('25680869','husamelfaki',1,1,1473081016,NULL,NULL),
	('117516411','RubyChilds',1,3,1473081105,NULL,NULL),
	('24595718','MGGoode',1,1,1473083554,NULL,NULL),
	('8662002','bonatto',1,2,1473084553,NULL,NULL),
	('21992321','joportus',1,1,1473088866,NULL,NULL),
	('3397940026','byhajra',1,3,1473088933,NULL,NULL),
	('460605554','OliverElmes',1,2,1473093957,NULL,NULL),
	('140872617','HeatherDeLand',1,2,1473101645,NULL,NULL),
	('99495219','jimange',1,1,1473107410,NULL,NULL),
	('45105785','wearegraphite',1,1,1473109530,NULL,NULL),
	('905934379','joshyouare_art',1,1,1473110529,NULL,NULL),
	('217357138','digiantelope',1,1,1473112581,NULL,NULL),
	('26310254','geo_anderson_',1,2,1473151199,NULL,NULL),
	('18020792','MrTomYoull',1,1,1473157946,NULL,NULL),
	('14243246','conradr',1,1,1473158042,NULL,NULL),
	('487918330','KathrynLWebb',1,2,1473159763,NULL,NULL),
	('3757421535','katetyrer97',1,1,1473166149,NULL,NULL),
	('437647237','AlexBerrrry',1,1,1473166371,NULL,NULL),
	('211564378','femkesvs',1,1,1473167234,NULL,NULL),
	('2291093665','CerebraxApp',1,1,1473171431,NULL,NULL),
	('68943393','BeckyBirdUK',1,5,1473171862,NULL,NULL),
	('87904052','andrewpledger',1,1,1473174602,NULL,NULL),
	('343914941','trexpert',1,4,1473175150,NULL,NULL),
	('38200360','renebach',1,1,1473179433,NULL,NULL),
	('23459486','nilane',1,1,1473179460,NULL,NULL),
	('53420750','dancewithjtee',1,1,1473185936,NULL,NULL),
	('88416891','lucle_',1,1,1473189793,NULL,NULL),
	('708610552793337857','awmugridge',1,1,1473193876,NULL,NULL),
	('24150611','markdanson',1,1,1473196144,NULL,NULL),
	('4089200667','loliboldu',1,1,1473196203,NULL,NULL),
	('15569673','craigrcoles',1,2,1473196469,NULL,NULL),
	('3062226515','digitalshoguns',1,1,1473237879,NULL,NULL),
	('2482297602','mrwillington',1,1,1473242603,NULL,NULL),
	('2280580621','willsgrigg',1,1,1473242654,NULL,NULL),
	('14979810','iamwillweaver',1,2,1473256227,NULL,NULL),
	('44370384','nmurraywillis',1,1,1473256497,NULL,NULL);

/*!40000 ALTER TABLE `tweetsfortreats_people` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tweetsfortreats_people_website
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tweetsfortreats_people_website`;

CREATE TABLE `tweetsfortreats_people_website` (
  `user_id` text,
  `screen_name` text,
  `nbr_tweets` int(11) DEFAULT NULL,
  `nbr_tweets_alltime` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `reminder` int(1) DEFAULT NULL,
  `following` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tweetsfortreats_people_website` WRITE;
/*!40000 ALTER TABLE `tweetsfortreats_people_website` DISABLE KEYS */;

INSERT INTO `tweetsfortreats_people_website` (`user_id`, `screen_name`, `nbr_tweets`, `nbr_tweets_alltime`, `created_at`, `reminder`, `following`)
VALUES
	('2419194338','weareblacksun',1,1,1441139144,NULL,NULL),
	('1677906224','AnnaChocola',1,1,1441541017,NULL,NULL),
	('63582147','medienwunder',1,1,1441609780,NULL,NULL),
	('6091382','grrtbrtr',1,1,1441610660,NULL,NULL),
	('87753078','stalin',1,1,1441623139,NULL,NULL),
	('38852480','KSCB92',1,1,1441628372,NULL,NULL),
	('51735628','chequepa',1,1,1441640489,NULL,NULL),
	('3371865370','charlie_tweeet',1,3,1441640776,NULL,NULL),
	('855089509','williams_ct92',1,1,1441655590,NULL,NULL),
	('2194243387','RyanPlyanLion',1,3,1441664980,NULL,NULL),
	('119096136','Vincen7Su',1,1,1441676127,NULL,NULL),
	('1904428771','littlepeacebell',1,10,1441146584,NULL,NULL),
	('95050481','OvertonGraphics',1,1,1441788710,NULL,NULL),
	('1435763318','Mhomas_tichalak',1,1,1441114106,NULL,NULL),
	('160847260','AkikoYing',1,1,1442070326,NULL,NULL),
	('61059128','judelowes',1,1,1442332489,NULL,NULL),
	('428577233','mighty_mess',1,1,1443094027,NULL,NULL),
	('763233668','Busta_tuiter',1,1,1444752062,NULL,NULL),
	('155506728','sophieszilady',1,1,1445333689,NULL,NULL),
	('81801765','crushcreative',1,2,1449139029,NULL,NULL),
	('107235226','EWF81',1,1,1449139263,NULL,NULL),
	('1580750388','kahsuit',1,2,1453348975,NULL,NULL),
	('2585793926','j_haseltine',1,1,1459931188,NULL,NULL),
	('459610383','lucy_croucher',1,2,1464018654,NULL,NULL),
	('45808325','jankenpopp',1,1,1465215271,NULL,NULL),
	('2280580621','willsgrigg',1,1,1466433629,NULL,NULL),
	('752512779660193792','PeterRPonte',1,1,1470062223,NULL,NULL),
	('127227264','JOSETHORNTON',1,3,1487600416,NULL,NULL),
	('245970823','RenatoNL',1,3,1487635607,NULL,NULL),
	('49821644','GiuliLazo',1,1,1487691866,NULL,NULL),
	('4274957536','NathanNatani',1,1,1490036391,NULL,NULL),
	('892044434','13sxpatel',1,1,1490038622,NULL,NULL),
	('2717461868','TEAaToria',1,1,1490087830,NULL,NULL),
	('925911943','alfpagon',1,1,1495465040,NULL,NULL);

/*!40000 ALTER TABLE `tweetsfortreats_people_website` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tweetsfortreats_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tweetsfortreats_users`;

CREATE TABLE `tweetsfortreats_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` text,
  `screen_name` text,
  `oauth_token` text,
  `oauth_token_secret` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tweetsfortreats_users` WRITE;
/*!40000 ALTER TABLE `tweetsfortreats_users` DISABLE KEYS */;

INSERT INTO `tweetsfortreats_users` (`id`, `user_id`, `screen_name`, `oauth_token`, `oauth_token_secret`)
VALUES
	(14,'2419194338','weareblacksun','2419194338-AFqNZvSb7vARwtqpj3PX5kVtXUCF6RGEhaq9yf7','yx2gNnVUuIrqZ5Zcdg9FzGgdmN41dnb8YaZNXojZwycgS'),
	(19,'428577233','mighty_mess','428577233-TVt20PKjbZU4RkDct7CVIZiJIwhPOKg3Mm4Qlf3i','KGVeHuECfRv9BhPEFyzxqeGzSSCisy8SLaJgq4o1MTOv1'),
	(20,'3005549057','drum_robot','3005549057-89jBAp4XqKruiPY8ooNWlodEuJYK0s8XKcvgfwv','Hq8jeYLxJU3xU93CePEvBzc1ZQiowTl46VYuSjHiWi13N'),
	(22,'3230138123','IWantTreats','3230138123-0umbwkJYj9b9QkqfG7whZNl0KGlg2mizwJaFUYb','SKgyqmcCiRGn0MBOYlOfQevIV0xvFzQe3ZJViXGUjzTNl'),
	(24,'1543294441','TCoffeeCounter','1543294441-zT577xKITk298ZyjnW7wdTm2jyRoWpHM8LzZhgX','OMeAXiPs8uTGWuEtGhr5Rp3yOYTuP49wX9bz5IZtjDrAp');

/*!40000 ALTER TABLE `tweetsfortreats_users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
