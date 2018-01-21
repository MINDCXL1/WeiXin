# Host: bdm290812278.my3w.com  (Version: 5.1.73)
# Date: 2018-01-21 08:42:34
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES gb2312 */;

#
# Structure for table "ims_bargainfor"
#

DROP TABLE IF EXISTS `ims_bargainfor`;
CREATE TABLE `ims_bargainfor` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `useropenid` varchar(255) DEFAULT NULL,
  `helpopenid` varchar(255) DEFAULT NULL,
  `money` varchar(255) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

#
# Data for table "ims_bargainfor"
#

/*!40000 ALTER TABLE `ims_bargainfor` DISABLE KEYS */;
INSERT INTO `ims_bargainfor` VALUES (1,'owReq0faxoj5RcJE49Fmuye8pm_U','owReq0RoqUQE_p9h9tshzg5LNy74','281');
/*!40000 ALTER TABLE `ims_bargainfor` ENABLE KEYS */;
