# Host: bdm290812278.my3w.com  (Version: 5.1.73)
# Date: 2018-01-21 08:42:44
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES gb2312 */;

#
# Structure for table "ims_bargain"
#

DROP TABLE IF EXISTS `ims_bargain`;
CREATE TABLE `ims_bargain` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `money` varchar(255) DEFAULT '0' COMMENT '原价',
  `newmoney` varchar(255) DEFAULT '0' COMMENT '被砍后的价格',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

#
# Data for table "ims_bargain"
#

/*!40000 ALTER TABLE `ims_bargain` DISABLE KEYS */;
INSERT INTO `ims_bargain` VALUES (1,'owReq0faxoj5RcJE49Fmuye8pm_U','初衷','800','700'),(2,'owReq0RoqUQE_p9h9tshzg5LNy74','Sun_girl','800','700');
/*!40000 ALTER TABLE `ims_bargain` ENABLE KEYS */;
