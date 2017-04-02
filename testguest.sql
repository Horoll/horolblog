/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.14 : Database - testguest
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`testguest` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `testguest`;

/*Table structure for table `tg_article` */

DROP TABLE IF EXISTS `tg_article`;

CREATE TABLE `tg_article` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tg_reid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '评论对应的博客id',
  `tg_username` varchar(20) NOT NULL COMMENT '用户名',
  `tg_tag` varchar(20) DEFAULT NULL COMMENT '标签',
  `tg_title` varchar(200) DEFAULT NULL COMMENT '标题',
  `tg_content` text NOT NULL COMMENT '正文',
  `tg_readcount` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `tg_commendcount` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `tg_date` datetime NOT NULL COMMENT '发表时间',
  `tg_last_modify_date` datetime DEFAULT NULL COMMENT '最后修改时间',
  `tg_fine` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=162 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tg_article` */

insert  into `tg_article`(`tg_id`,`tg_reid`,`tg_username`,`tg_tag`,`tg_title`,`tg_content`,`tg_readcount`,`tg_commendcount`,`tg_date`,`tg_last_modify_date`,`tg_fine`) values (1,0,'lkc','123','12','223',1,0,'2016-11-08 13:28:48',NULL,0),(2,0,'lkc','test','发表博客test','发表博客test',1,0,'2016-11-08 13:29:24',NULL,0),(3,0,'lkc','test2','test2','test2',1,0,'2016-11-08 13:35:05',NULL,0),(4,0,'root','text3 root','text3 root','text3 root',2,0,'2016-11-08 20:57:56',NULL,0),(5,0,'lkc','测试ubb','测试ubb功能','[size=10]10px[/size] [size=12]12px[/size] [size=14]14px[/size] [size=16]16px[/size] [b]粗体[/b] [i]斜体[/i] [u]下划线[/u] [s]删除线[/s]\r\n[color=#f00]红色[/color] [color=#ff0]黄色[/color] [url]http://www.baidu.com[/url]\r\n[email]640246255@qq.com[/email]\r\n',87,0,'2016-11-09 09:01:08',NULL,0),(6,0,'lkc','ubb测试2','ubb测试2','[size=20]20px[/size]\r\n[b]粗体[/b]\r\n[i]斜体[/i]\r\n[u]下划线[/u]\r\n[s]删除线[/s]\r\n[color=#f60]橙色[/color]\r\n[url]http://www.baidu.com[/url]\r\n[email]640246255@qq.com[/email]\r\n[img]图片[/img]',64,0,'2016-11-09 09:34:18',NULL,1),(7,0,'lkc','qwdqqdqq','qawddq','dqwddqdqdqwd',5,0,'2016-11-09 10:19:35',NULL,0),(8,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',7,0,'2016-11-09 10:20:21',NULL,0),(9,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',4,0,'2016-11-09 10:20:32',NULL,0),(10,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',2,0,'2016-11-09 10:20:34',NULL,0),(11,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',1,0,'2016-11-09 10:20:37',NULL,0),(12,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',3,0,'2016-11-09 10:20:39',NULL,0),(13,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',1,0,'2016-11-09 10:20:43',NULL,0),(14,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',5,0,'2016-11-09 10:20:45',NULL,0),(15,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',5,0,'2016-11-09 10:20:47',NULL,0),(16,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',5,0,'2016-11-09 10:20:49',NULL,0),(17,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',16,0,'2016-11-09 10:20:52',NULL,0),(18,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',59,0,'2016-11-09 10:20:54',NULL,0),(19,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',5,1,'2016-11-09 10:20:56',NULL,0),(20,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',8,0,'2016-11-09 10:20:59',NULL,0),(21,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',36,0,'2016-11-09 10:21:01',NULL,0),(22,0,'lkc','测试,主页,tag','测试主页的博客标题长度 以及tag','测试主页的博客标题长度 以及tag',15,0,'2016-11-09 10:21:02',NULL,0),(23,0,'root','','测试 js验证一级tag是否能为空','测试 js验证一级tag是否能为空',5,0,'2016-11-09 16:03:32',NULL,0),(24,0,'root','请用逗号隔开','阿萨德','asdaaaaaaaaaaaa',10,0,'2016-11-09 16:13:35',NULL,0),(25,0,'root','请用逗号隔开','测试 js验证一级tag是否能为空','测试 js验证一级tag是否能为空',132,1,'2016-11-09 16:18:26',NULL,0),(26,5,'root',NULL,NULL,'root回复id=5的博客',0,0,'2016-11-10 00:05:19',NULL,0),(27,5,'root',NULL,NULL,'root评论id=5的博客',0,0,'2016-11-10 00:08:15',NULL,0),(28,5,'root',NULL,NULL,'root评论id=5的博客',0,0,'2016-11-10 00:16:52',NULL,0),(29,5,'root',NULL,NULL,'root发给id=5的博客',0,0,'2016-11-10 00:18:54',NULL,0),(30,5,'root',NULL,NULL,'root评论id=5的博客',0,0,'2016-11-10 00:33:49',NULL,0),(31,23,'lkc',NULL,NULL,'lkc发送给id=23的评论',0,0,'2016-11-10 09:32:42',NULL,0),(32,0,'lkc','测试评论功能','测试评论功能','测试评论功能!!!!!!!!!!',151,2,'2016-11-10 09:38:02',NULL,0),(33,32,'lkc',NULL,NULL,'lkc评论id=32的博客',0,0,'2016-11-10 10:13:48',NULL,0),(34,32,'root',NULL,NULL,'root评论id=32的博客',0,0,'2016-11-10 10:14:17',NULL,0),(35,32,'user6',NULL,NULL,'user6评论id=32的博客',0,0,'2016-11-10 10:14:50',NULL,0),(36,32,'user6',NULL,NULL,'user6评论id=32的博客',0,0,'2016-11-10 21:18:51',NULL,0),(37,32,'user6',NULL,NULL,'user6评论id=32的博客',0,0,'2016-11-10 21:18:56',NULL,0),(38,32,'user6',NULL,NULL,'user6评论id=32的博客',0,0,'2016-11-10 21:18:59',NULL,0),(39,32,'user6',NULL,NULL,'user6评论id=32的博客',0,0,'2016-11-10 21:19:03',NULL,0),(40,32,'user6',NULL,NULL,'user6评论id=32的博客',0,0,'2016-11-10 21:19:06',NULL,0),(41,32,'user6',NULL,NULL,'user6评论id=32的博客',0,0,'2016-11-10 21:19:09',NULL,0),(42,32,'user6',NULL,NULL,'user6评论id=32的博客',0,0,'2016-11-10 21:19:18',NULL,0),(43,32,'user6',NULL,NULL,'user6评论id=32的博客',0,0,'2016-11-10 21:19:30',NULL,0),(44,32,'user6',NULL,NULL,'user6评论id=32的博客',0,0,'2016-11-10 21:19:34',NULL,0),(45,32,'user6',NULL,NULL,'user6评论id=32的博客',0,0,'2016-11-10 21:19:36',NULL,0),(46,0,'user6','测试签名','测试评论数','[size=20]测试评论数[/size]\r\n[b] 测试评论数[/b]\r\n[i] 测试评论数[/i]\r\n[u] 测试评论数[/u]\r\n[s] 测试评论数[/s]\r\n[color=#f90]测试评论数[/color]\r\n[b]新[/b]测试签名功能',105,15,'2016-11-10 21:49:22','2016-11-12 12:51:17',0),(47,46,'user6',NULL,NULL,'第一条评论',0,0,'2016-11-10 21:51:20',NULL,0),(48,46,'user6',NULL,NULL,'第2条评论',0,0,'2016-11-10 21:51:26',NULL,0),(49,46,'user6',NULL,NULL,'第3条评论',0,0,'2016-11-10 21:51:31',NULL,0),(50,46,'user6',NULL,NULL,'第4条评论',0,0,'2016-11-10 21:51:36',NULL,0),(51,46,'user6',NULL,NULL,'第5条评论',0,0,'2016-11-10 21:51:41',NULL,0),(52,46,'user6',NULL,NULL,'第6条评论',0,0,'2016-11-10 21:51:46',NULL,0),(53,46,'user6',NULL,NULL,'第7条评论',0,0,'2016-11-10 21:51:55',NULL,0),(54,46,'user6',NULL,NULL,'第8条评论',0,0,'2016-11-10 21:51:59',NULL,0),(55,46,'user6',NULL,NULL,'第9条评论',0,0,'2016-11-10 21:52:28',NULL,0),(56,46,'user6',NULL,NULL,'第10条评论',0,0,'2016-11-10 21:52:34',NULL,0),(57,46,'user6',NULL,NULL,'第11条评论',0,0,'2016-11-10 21:52:38',NULL,0),(58,46,'user6',NULL,NULL,'第12条评论',0,0,'2016-11-10 21:55:50',NULL,0),(59,0,'root','已经修改，博客,内容','测试博客修改功能','测试博客修改功能 最后修改时间为20：34',126,3,'2016-11-11 12:58:32','2016-11-11 20:34:49',1),(60,59,'root',NULL,NULL,'评论一条吧',0,0,'2016-11-11 19:01:14',NULL,0),(61,32,'root',NULL,NULL,'评论一条吧',0,0,'2016-11-11 19:02:10',NULL,0),(62,32,'root',NULL,NULL,'再评论一条吧',0,0,'2016-11-11 19:02:29',NULL,0),(63,59,'root',NULL,NULL,'评论第二条',0,0,'2016-11-11 19:02:52',NULL,0),(64,59,'root',NULL,NULL,'评论一下吧',0,0,'2016-11-11 20:34:03',NULL,0),(65,46,'user6',NULL,NULL,'万一评论很长呢？我看看签名会怎么样？\r\n万一评论很长呢？我看看签名会怎么样？\r\n万一评论很长呢？我看看签名会怎么样？\r\n万一评论很长呢？我看看签名会怎么样？\r\n万一评论很长呢？我看看签名会怎么样？\r\n万一评论很长呢？我看看签名会怎么样？\r\n万一评论很长呢？我看看签名会怎么样？\r\n万一评论很长呢？我看看签名会怎么样？',0,0,'2016-11-12 12:41:22',NULL,0),(66,46,'user6',NULL,NULL,'[img]C:\\Users\\lkc\\Desktop\\图\\1.png[/img]',0,0,'2016-11-12 13:33:15',NULL,0),(67,46,'user6',NULL,NULL,'[img]C:\\Users\\lkc\\Desktop\\图标\\发信息.png[/img]',0,0,'2016-11-12 13:43:16',NULL,0),(68,0,'user6','测试发博客间隔功能','测试发博客间隔功能','测试发博客间隔功能测试发博客间隔功能',1,0,'2016-11-12 14:34:48',NULL,0),(69,0,'user6','测试发博客间隔功能','测试发博客间隔功能','测试发博客间隔功能测试发博客间隔功能',4,0,'2016-11-12 14:34:52',NULL,0),(70,0,'user6','测试发博客间隔功能','测试发博客间隔功能','测试发博客间隔功能测试发博客间隔功能',3,0,'2016-11-12 14:35:06',NULL,0),(71,0,'user6','测试发博客间隔功能','测试发博客间隔功能','测试发博客间隔功能测试发博客间隔功能',2,0,'2016-11-12 14:36:07',NULL,0),(72,0,'user6','测试发博客间隔功能','测试发博客间隔功能','测试发博客间隔功能测试发博客间隔功能',5,0,'2016-11-12 14:37:11',NULL,0),(73,0,'user6','测试','测试发表博客时间间隔功能','测试发表博客时间间隔功能',9,0,'2016-11-12 14:51:25',NULL,0),(74,0,'user6','测试','测试发表博客时间间隔功能','测试发表博客时间间隔功能',41,5,'2016-11-12 14:52:31',NULL,0),(75,74,'user6',NULL,NULL,'测试发表评论的间隔问题',0,0,'2016-11-12 14:59:58',NULL,0),(76,74,'user6',NULL,NULL,'测试发表评论的间隔问题',0,0,'2016-11-12 15:00:33',NULL,0),(77,0,'lkc','测试','测试一下能否将发帖时间写入数据库','测试一下能否将发帖时间写入数据库',3,0,'2016-11-12 15:36:25',NULL,0),(78,0,'lkc','测试','测试一下能否将发帖时间写入数据库','测试一下能否将发帖时间写入数据库',3,0,'2016-11-12 15:37:26',NULL,0),(79,0,'lkc','测试','测试发帖从数据库中取出最后发帖时间','测试发帖从数据库中取出最后发帖时间',6,0,'2016-11-12 15:43:07',NULL,0),(80,0,'lkc','测试','测试时间戳是否写入了数据库','测试时间戳是否写入了数据库',7,1,'2016-11-12 15:57:48',NULL,0),(81,0,'lkc','测试','测试数据库检验发帖间隔方法','测试数据库检验发帖间隔方法',12,2,'2016-11-12 16:01:20',NULL,0),(82,81,'lkc',NULL,NULL,'[i][color=#f90]测试评论间隔[/color][/i]',0,0,'2016-11-12 16:09:04',NULL,0),(83,81,'lkc',NULL,NULL,'[i][color=#f90]测试评论间隔[/color][/i]',0,0,'2016-11-12 16:09:27',NULL,0),(84,0,'lkc','测试','测试发博客间隔功能修改','测试发博客间隔功能修改测试发博客间隔功能修改',36,2,'2016-11-13 15:32:31',NULL,0),(85,84,'lkc',NULL,NULL,'测试评论时间间隔的修改',0,0,'2016-11-13 15:33:46',NULL,0),(86,84,'lkc',NULL,NULL,'测试评论时间间隔的修改',0,0,'2016-11-13 15:34:32',NULL,0),(87,0,'root','wfew fwe f*|*气温多起','wfew fwe f*|*气温多起','wfew fwe f*|*气温多起',18,3,'2016-11-13 19:37:44',NULL,0),(88,87,'root',NULL,NULL,'wfew fwe f*|*气温多起',0,0,'2016-11-13 19:38:43',NULL,0),(89,87,'root',NULL,NULL,'wfew fwe f非法wd 字dwq符1d|非dd法d字q符1气温多起',0,0,'2016-11-13 19:39:05',NULL,0),(90,87,'root',NULL,NULL,'非 法 字 符1|非 法 字 符 2',0,0,'2016-11-13 19:39:54',NULL,0),(91,0,'lkc','加精','测试一下删除 加精功能','测试一下删除 加精功能',28,0,'2016-11-14 09:58:25','2016-11-20 10:06:41',0),(92,19,'root',NULL,NULL,'管理员root评论',0,0,'2016-11-17 20:03:07',NULL,0),(93,25,'root',NULL,NULL,'测试评论签名是否正常',0,0,'2016-11-17 20:05:18',NULL,0),(94,74,'root',NULL,NULL,'检查评论签名\r\n是否正常',0,0,'2016-11-17 20:07:06',NULL,0),(95,74,'root',NULL,NULL,'检查评论签名\r\n是否正常',0,0,'2016-11-17 20:09:59',NULL,0),(96,74,'lkc',NULL,NULL,'[b]沉迷于改bug，拔不出来[/b]',0,0,'2016-11-17 20:18:40',NULL,0),(101,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:36:25',NULL,0),(102,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:36:31',NULL,0),(103,0,'lkc','分页','测试分页','测试分页',5,0,'2016-11-22 14:36:37',NULL,0),(104,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:36:41',NULL,0),(100,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:33:22',NULL,0),(99,80,'cheng',NULL,NULL,'[b][/b][img]<script><script>[/img]',0,0,'2016-11-21 18:57:51',NULL,0),(105,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:36:45',NULL,0),(106,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:36:48',NULL,0),(107,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:36:52',NULL,0),(108,0,'lkc','分页','测试分页','测试分页',2,0,'2016-11-22 14:36:55',NULL,0),(109,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:40:07',NULL,0),(110,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:40:15',NULL,0),(111,0,'lkc','分页','测试分页','测试分页',1,0,'2016-11-22 14:40:43',NULL,0),(112,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:41:01',NULL,0),(113,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:41:07',NULL,0),(114,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:41:12',NULL,0),(115,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:41:16',NULL,0),(116,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:41:21',NULL,0),(117,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:41:24',NULL,0),(118,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:41:28',NULL,0),(119,0,'lkc','分页','测试分页','测试分页',1,0,'2016-11-22 14:41:53',NULL,0),(120,0,'lkc','分页','测试分页','测试分页',0,0,'2016-11-22 14:41:57',NULL,0),(121,0,'lkc','测试分页','测试分页','测试分页}',0,0,'2016-11-22 14:47:56',NULL,0),(122,0,'lkc','测试分页','测试分页','测试分页}',1,0,'2016-11-22 14:48:01',NULL,0),(123,0,'lkc','测试分页','测试分页','测试分页}',2,0,'2016-11-22 14:48:05',NULL,0),(124,0,'lkc','测试分页','测试分页','测试分页}',5,2,'2016-11-22 14:48:08',NULL,0),(125,0,'lkc','测试分页','测试分页','测试分页}',5,0,'2016-11-22 14:48:11',NULL,1),(143,0,'lkc','沃尔夫我','erererererererererererer','而二二二二二二二二二二而温柔',12,1,'2016-12-03 15:09:54',NULL,1),(129,0,'lkc','加精','测试博客加精功能','测试博客加精功能测试博客加精功能测试博客加精功能测试博客加精功能功能',88,1,'2016-11-28 15:31:45','2016-11-28 17:24:00',1),(145,0,'lkc','测试标签','<script>dasdad</script>','<script>dasdad</script>',33,3,'2016-12-05 15:42:29','2016-12-08 13:44:40',0),(146,145,'lkc',NULL,NULL,'<h3>wqd</h3>',0,0,'2016-12-05 15:42:59',NULL,0),(147,145,'lkc',NULL,NULL,'dewqdqqwd',0,0,'2016-12-05 15:43:17',NULL,0),(148,145,'lkc',NULL,NULL,'[u]egrerg [/u]',0,0,'2016-12-05 15:45:26',NULL,0),(149,124,'lkc',NULL,NULL,'插入[b][/b]之间即可放大字号哦。',0,0,'2016-12-05 16:12:29',NULL,0),(150,124,'lkc',NULL,NULL,'比如咱们这么写：[b]Oracle[/b]就可以看到加粗的[b]Oracle[/b]哦。',0,0,'2016-12-05 16:13:58',NULL,0),(151,129,'root',NULL,NULL,'[i][b][size=40]qwerwefuiofajflaskj[/size][/b][/i]',0,0,'2016-12-07 14:30:44',NULL,0),(152,0,'lkc','测试','测试居左居右居中','[text-align=left]居左[/text-align]\r\n[text-align=center]居中[/text-align]\r\n[text-align=right]居右[/text-align]',13,1,'2016-12-19 22:37:06',NULL,0),(153,152,'lkc',NULL,NULL,'<span style=\\\"text-align:right\\\">居右</span>',0,0,'2016-12-19 22:37:59',NULL,0),(154,0,'lkc','111111111111','测试 居左居右','[text-align=left]1111111111111111111111111[/text-align]\r\n[text-align=center]1111111111111111111111111[/text-align]\r\n[text-align=right]1111111111111111111111111[/text-align]',8,0,'2016-12-19 23:23:18',NULL,0),(155,0,'lkc','','123123123','[text-align=left]1111111111111111111111111111111111111111111[/text-align]\r\n[text-align=center]1111111111111111111111111111111111111111111[/text-align]\r\n[text-align=right]1111111111111111111111111111111111111111111[/text-align]',38,1,'2016-12-19 23:24:43',NULL,0),(156,155,'lkc',NULL,NULL,'1111111111111111111111111111111111111111111\r\n1111111111111111111111111111111111111111111\r\n1111111111111111111111111111111111111111111',0,0,'2016-12-19 23:25:05',NULL,0),(157,143,'lkc',NULL,NULL,'[text-align=center]123[/text-align][text-align=left]123[/text-align][text-align=right]123[/text-align]',0,0,'2016-12-27 10:50:30',NULL,0),(158,0,'lkc','展示，asdasd','展示展示展示展示展示','[size=20]展示[/size]  [b]展示[/b]\r\n[i]展示[/i][u]展示[/u][s][u]iasgdioua[/u][/s]\r\n\r\n\r\n\r\n[color=#ff0]asdasd[/color][color=#f00]asdadasd[/color]\r\n\r\n[text-align=left]实打实的[/text-align]\r\n\r\n[text-align=center]使得发达省份[/text-align]',17,1,'2016-12-27 16:23:16',NULL,1),(160,158,'lkc',NULL,NULL,'<script>',0,0,'2016-12-27 16:24:43',NULL,0),(161,0,'lkc','展示 ，测试','<script>','[size=24]zxczcx[/size]\r\n\r\n\r\n[color=#ff0]asdsdsad[/color]',5,0,'2016-12-29 17:11:19',NULL,1);

/*Table structure for table `tg_dir` */

DROP TABLE IF EXISTS `tg_dir`;

CREATE TABLE `tg_dir` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `tg_name` varchar(20) NOT NULL COMMENT '相册名',
  `tg_type` tinyint(1) unsigned NOT NULL COMMENT '是否加密',
  `tg_password` char(40) DEFAULT NULL COMMENT '相册密码',
  `tg_content` varchar(200) DEFAULT NULL COMMENT '相册描述',
  `tg_face` varchar(200) DEFAULT NULL COMMENT '相册封面路径',
  `tg_dir` varchar(200) NOT NULL COMMENT '相册的文件夹路径',
  `tg_date` datetime NOT NULL COMMENT '相册创建时间',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `tg_dir` */

insert  into `tg_dir`(`tg_id`,`tg_name`,`tg_type`,`tg_password`,`tg_content`,`tg_face`,`tg_dir`,`tg_date`) values (11,'插画',0,'','一些插画','./photo/1480488312/1481003277.jpg','1480488312','2016-11-30 14:45:12'),(12,'班级活动',1,'d93a5def7511da3d0f2d171d9c344e91','','./photo/1482827352/1482827480.jpg','1482827352','2016-12-27 16:29:12');

/*Table structure for table `tg_friend` */

DROP TABLE IF EXISTS `tg_friend`;

CREATE TABLE `tg_friend` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `tg_touser` varchar(20) NOT NULL COMMENT '被添加的好友',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '发送人',
  `tg_content` varchar(200) NOT NULL COMMENT '验证信息',
  `tg_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否通过 好友申请',
  `tg_date` datetime NOT NULL COMMENT '申请发送时间',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tg_friend` */

insert  into `tg_friend`(`tg_id`,`tg_touser`,`tg_fromuser`,`tg_content`,`tg_state`,`tg_date`) values (10,'牛毅','lkc','你好啊小牛',0,'2016-11-17 16:07:23'),(11,'牛毅','root','hi,加个好友吧..',0,'2016-11-17 20:43:51'),(12,'','1234567','hi,加个好友吧..',0,'2016-11-21 19:20:35'),(13,'user23','ratsui','hi,加个好友吧..',1,'2016-11-22 20:48:37'),(14,'ratsui','lkc','hi,加个好友吧..',1,'2016-11-22 20:49:43'),(15,'root','lkc','hi,加个好友吧..',1,'2016-11-23 09:28:55'),(16,'lx','lkc','hi,加个好友吧..',0,'2016-11-23 09:48:01'),(17,'lkc','user25','hi,加个好友吧..',1,'2016-11-24 13:15:16'),(18,'刘波','lkc','hi,加个好友吧..',0,'2016-12-07 16:54:54'),(19,'haha','lkc','hi,加个好友吧..',1,'2016-12-27 16:26:19');

/*Table structure for table `tg_gift` */

DROP TABLE IF EXISTS `tg_gift`;

CREATE TABLE `tg_gift` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `tg_touser` varchar(20) NOT NULL COMMENT '接受人',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '发送人',
  `tg_number` mediumint(8) unsigned NOT NULL COMMENT '礼物数量',
  `tg_content` varchar(200) NOT NULL COMMENT '信息内容',
  `tg_date` datetime NOT NULL COMMENT '发送时间',
  `tg_state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tg_gift` */

insert  into `tg_gift`(`tg_id`,`tg_touser`,`tg_fromuser`,`tg_number`,`tg_content`,`tg_date`,`tg_state`) values (1,'root','lkc',10,'给你送点礼物~~','2016-11-05 20:38:21',0),(4,'lkc','root',10,'从博客界面送的10个礼物','2016-11-08 21:38:12',1),(3,'lkc','root',8,'8','2016-11-05 22:03:27',1),(5,'lkc','root',53,'wfew fwe f非法da字符1|非法d字符1气温多起wfew fwe f*|*气温多起','2016-11-13 19:43:41',1),(6,'root','lkc',10,'给你送点礼物~~','2016-11-17 20:24:22',0),(7,'牛毅','lkc',20,'送你20个礼物','2016-11-17 20:43:30',0),(8,'11155','root',100,'小韩啊送你一些gifts啊','2016-11-19 16:08:38',0),(9,'','1234567',1,'给你送点礼物~~','2016-11-21 19:20:02',0),(10,'ratsui','lkc',100,'给你送点礼物~~','2016-11-23 10:02:51',0),(11,'root','lkc',1,'给你送点礼物~~','2016-11-23 10:03:07',0),(12,'ratsui','lkc',1,'给你送点礼物~~','2016-11-23 10:19:13',0),(13,'root','lkc',6,'给你送点礼物~~','2016-11-23 10:24:44',0);

/*Table structure for table `tg_guest` */

DROP TABLE IF EXISTS `tg_guest`;

CREATE TABLE `tg_guest` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `tg_touser` varchar(20) NOT NULL COMMENT '被留言人',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '留言人',
  `tg_content` varchar(200) NOT NULL COMMENT '留言',
  `tg_date` datetime NOT NULL COMMENT '发送时间',
  `tg_state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `tg_guest` */

insert  into `tg_guest`(`tg_id`,`tg_touser`,`tg_fromuser`,`tg_content`,`tg_date`,`tg_state`) values (1,'lkc','root','测试留言','2016-11-26 22:38:58',0),(2,'lkc','user23','测试留言','2016-11-26 22:40:32',0),(3,'lkc','root','测试留言','2016-11-26 22:57:27',0),(4,'lkc','root','一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一','2016-11-26 23:02:43',0),(5,'lkc','root','一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一一','2016-11-26 23:04:25',0),(6,'lkc','haha','asdhasodahd','2016-12-27 16:14:59',0),(7,'haha','lkc','留言','2016-12-28 11:07:01',0),(8,'haha','lkc','大撒旦撒旦','2016-12-29 17:09:46',0);

/*Table structure for table `tg_message` */

DROP TABLE IF EXISTS `tg_message`;

CREATE TABLE `tg_message` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '信息id',
  `tg_touser` varchar(20) NOT NULL COMMENT '收信人',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '发信人',
  `tg_content` varchar(200) NOT NULL COMMENT '信息内容',
  `tg_date` datetime NOT NULL COMMENT '发送时间',
  `tg_state` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

/*Data for the table `tg_message` */

insert  into `tg_message`(`tg_id`,`tg_touser`,`tg_fromuser`,`tg_content`,`tg_date`,`tg_state`) values (72,'root','lkc','haqwd[qwd','2016-11-04 17:12:11',1),(88,'haha','lkc','你好啊','2016-12-29 17:09:30',1),(56,'student','lkc','zzhdc','2016-11-04 12:48:54',1),(49,'user','lkc','微软官方为给我','2016-11-04 11:02:10',1),(51,'student','lkc','ergwrgeatgerg e','2016-11-04 11:02:25',1),(52,'user6','lkc','qw dqw fwgklgfwpfounwpo','2016-11-04 11:02:32',1),(53,'user4','lkc','4thesptghesja[ gijwrfo[ wqfopqwifwff','2016-11-04 11:02:41',1),(54,'user6','lkc','wrtgfwege wrgeg e','2016-11-04 11:02:54',1),(55,'user3','lkc','qwtfwgfw gwe rggawrg werg','2016-11-04 11:03:02',1),(87,'haha','lkc','发送信息','2016-12-28 11:08:19',0),(86,'haha','lkc','阿萨德','2016-12-28 11:06:46',0),(73,'root','lkc','adasda','2016-11-05 20:33:25',1),(75,'root','lkc','啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊AAAAAAAAAAAAAAAAawa','2016-11-09 11:09:53',0),(76,'root','root','root发送给root','2016-11-09 13:47:33',0),(78,'root','lkc','lkc发送给root','2016-11-17 20:24:05',0),(81,'牛毅','lkc','牛毅你能看到我发给你的消息吗？什么时候看到了qq上给我说下','2016-11-17 20:43:04',0),(82,'11155','root','哈本儿韩定成','2016-11-18 16:31:30',0),(83,'牛毅','1234567','','2016-11-21 19:01:15',0),(84,'for','1234567','123','2016-11-21 19:19:11',0),(85,'ratsui','lkc','11111111','2016-11-22 20:49:17',1);

/*Table structure for table `tg_photo` */

DROP TABLE IF EXISTS `tg_photo`;

CREATE TABLE `tg_photo` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `tg_name` varchar(20) DEFAULT NULL COMMENT '图片名',
  `tg_dir` varchar(200) NOT NULL COMMENT '图片路径',
  `tg_content` varchar(200) DEFAULT NULL COMMENT '图片简介',
  `tg_date` datetime NOT NULL COMMENT '图片添加时间',
  `tg_sid` mediumint(8) unsigned NOT NULL COMMENT '图片所属的相册id',
  `tg_user` varchar(20) NOT NULL DEFAULT 'root' COMMENT '上传者',
  `tg_read_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `tg_comment_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论次数',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tg_photo` */

insert  into `tg_photo`(`tg_id`,`tg_name`,`tg_dir`,`tg_content`,`tg_date`,`tg_sid`,`tg_user`,`tg_read_count`,`tg_comment_count`) values (18,'雪之下雪乃','./photo/1480488312/1480933848.png','雪之下雪乃','2016-12-05 18:31:07',11,'lkc',1,0),(19,'夜景','./photo/1480488312/1480933880.jpg','夜景','2016-12-05 18:31:26',11,'lkc',1,0),(21,'','./photo/1480488312/1481003277.jpg','','2016-12-06 13:47:59',11,'lkc',7,1),(23,'','./photo/1480488312/1481006489.jpg','','2016-12-06 14:41:31',11,'lkc',16,2),(24,'','./photo/1480488312/1481006505.jpg','','2016-12-06 14:41:47',11,'lkc',10,1),(22,'风车','./photo/1480488312/1481006469.jpg','风车','2016-12-06 14:41:15',11,'lkc',2,0),(26,'展示','./photo/1482827352/1482827480.jpg','展示','2016-12-27 16:32:10',12,'lkc',8,0);

/*Table structure for table `tg_photo_comment` */

DROP TABLE IF EXISTS `tg_photo_comment`;

CREATE TABLE `tg_photo_comment` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `tg_content` varchar(200) NOT NULL COMMENT '图片评论内容',
  `tg_sid` mediumint(8) unsigned NOT NULL COMMENT '评论图片的id',
  `tg_user` varchar(20) NOT NULL COMMENT '评论者',
  `tg_date` datetime NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `tg_photo_comment` */

insert  into `tg_photo_comment`(`tg_id`,`tg_content`,`tg_sid`,`tg_user`,`tg_date`) values (12,'评论图片',21,'lkc','2016-12-06 13:48:18'),(13,'夜晚的田间',23,'lkc','2016-12-07 15:59:46'),(14,'[text-align=left]ewqw[/text-align][text-align=center]qweqwe[/text-align][text-align=right]qweqwe[/text-align]',23,'lkc','2016-12-19 23:51:04'),(16,'vxcvxcvxv',24,'lkc','2016-12-29 17:13:15');

/*Table structure for table `tg_system` */

DROP TABLE IF EXISTS `tg_system`;

CREATE TABLE `tg_system` (
  `tg_id` mediumint(8) unsigned NOT NULL COMMENT 'ID',
  `tg_webname` varchar(20) NOT NULL COMMENT '网站名称',
  `tg_article` tinyint(2) unsigned NOT NULL DEFAULT '10' COMMENT '每页显示博客数量',
  `tg_blog` tinyint(2) unsigned NOT NULL DEFAULT '20' COMMENT '每页显示用户数量',
  `tg_album` tinyint(2) unsigned NOT NULL DEFAULT '12' COMMENT '每页相册显示数量',
  `tg_photo` tinyint(2) unsigned NOT NULL DEFAULT '10' COMMENT '每页显示图片数量',
  `tg_string` varchar(200) NOT NULL COMMENT '非法字符',
  `tg_post` tinyint(3) unsigned DEFAULT '60' COMMENT '发帖间隔时间',
  `tg_comment` tinyint(2) unsigned NOT NULL DEFAULT '15' COMMENT '评论间隔时间',
  `tg_code` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否使用验证码',
  `tg_register` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否公开注册'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tg_system` */

insert  into `tg_system`(`tg_id`,`tg_webname`,`tg_article`,`tg_blog`,`tg_album`,`tg_photo`,`tg_string`,`tg_post`,`tg_comment`,`tg_code`,`tg_register`) values (1,'Horol.blog',10,20,12,5,'非法字符1|非法字符2',60,15,1,1);

/*Table structure for table `tg_user` */

DROP TABLE IF EXISTS `tg_user`;

CREATE TABLE `tg_user` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `tg_uniqid` char(40) NOT NULL COMMENT '//验证登录的唯一标识符',
  `tg_active` char(40) DEFAULT NULL COMMENT '//激活帐号的唯一标识符',
  `tg_username` varchar(10) NOT NULL COMMENT '//用户名',
  `tg_password` varchar(40) NOT NULL COMMENT '//密码',
  `tg_question` varchar(20) NOT NULL COMMENT '//密码问题',
  `tg_answer` varchar(40) NOT NULL COMMENT '//密码回答',
  `tg_email` varchar(40) DEFAULT NULL COMMENT '//电子邮箱',
  `tg_qq` varchar(10) DEFAULT NULL COMMENT '//qq',
  `tg_sex` char(1) NOT NULL COMMENT '//性别',
  `tg_switch` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启签名',
  `tg_autograph` text COMMENT '签名',
  `tg_level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '权限等级',
  `tg_post_time` bigint(20) DEFAULT NULL COMMENT '最新发送博客时间戳',
  `tg_comment_time` bigint(20) DEFAULT NULL COMMENT '最新发送评论时间戳',
  `tg_reg_time` datetime NOT NULL COMMENT '注册时间',
  `tg_last_time` datetime DEFAULT NULL COMMENT '最近登陆时间',
  `tg_last_ip` varchar(20) DEFAULT NULL COMMENT '最近登录ip',
  `tg_login_count` mediumint(8) DEFAULT NULL COMMENT '登录次数',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tg_user` */

insert  into `tg_user`(`tg_id`,`tg_uniqid`,`tg_active`,`tg_username`,`tg_password`,`tg_question`,`tg_answer`,`tg_email`,`tg_qq`,`tg_sex`,`tg_switch`,`tg_autograph`,`tg_level`,`tg_post_time`,`tg_comment_time`,`tg_reg_time`,`tg_last_time`,`tg_last_ip`,`tg_login_count`) values (22,'dd3b9217ac85fedc5bad08c0557c29c6916a839a',NULL,'lkc','4c2c36663805547aab79f04883c5affd','我会的乐器','0d7a1c149c54b7155d05392ea270ed8b','horol_lkc@126.com','640246255','男',0,'啦啦啦啦啦~~',2,1483002679,1483002795,'2016-10-29 15:59:58','2017-04-01 10:27:42','::1',109),(23,'effb2321dd5f8c3d3f39ddb7a69d372b0f87ce48',NULL,'test','4c2c36663805547aab79f04883c5affd','123','e2207cab223d954fe915b8e2ec2a5d2e','640246255@qq.com','640246255','男',0,NULL,1,NULL,NULL,'2016-10-29 17:19:54','2016-11-01 22:16:12','::1',1),(24,'2474fc4201cb9f1a65e453ce6bdf61106b66e45b',NULL,'user','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2016-10-30 13:09:49','2016-12-01 13:59:58','::1',9),(21,'53867a3a7d2d25f3c09d0dfdc2701c50efa304f9',NULL,'root','c78b6663d47cfbdb4d65ea51c104044e','密码是6个1','c78b6663d47cfbdb4d65ea51c104044e','640246255@qq.com','','男',1,'管理员root的小尾巴',2,1479037064,1481092244,'2016-10-29 12:32:53','2017-01-19 18:50:25','::1',85),(25,'068eb9c7cda9f87631b62df7f6523a2d22a01586',NULL,'user2','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','男',0,NULL,1,NULL,NULL,'2016-10-30 13:12:46','2016-12-01 14:27:00','::1',2),(26,'808d9b93cb79b83ca6a47795c155ea2279bc180c',NULL,'user3','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','18190756096@163.com','','男',0,NULL,1,NULL,NULL,'2016-10-30 13:13:19','2016-11-05 22:05:25','::1',2),(27,'a339d2b343eff38822ab3d4df3b7f95993628619',NULL,'user4','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','男',0,NULL,1,NULL,NULL,'2016-10-30 13:13:49','2016-11-01 22:16:12','::1',1),(28,'f37d68e8733b53b7b462b36b0f1ad85027861d04',NULL,'user5','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','男',0,NULL,1,NULL,NULL,'2016-10-30 14:59:23','2016-11-01 22:16:12','::1',1),(56,'9b219d856f5a9536ecf585d0851a2986f772077d',NULL,'牛毅','12807cf3f0ca5247d0caeb95f551969e','niu','7c291f0f6554abebf40046d65d413cef','294340304@qq.com','294340304','男',0,NULL,0,NULL,NULL,'2016-11-17 12:54:11','2016-11-17 12:54:11','10.2.129.220',0),(30,'c4651f96d53d3c2a482ee00c4b7a8f722b065c1a',NULL,'user6','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','女',1,'[color=#f00]我于杀戮之中盛放，亦如黎明中的花朵[/color]',1,NULL,NULL,'2016-10-30 15:10:19','2016-11-16 16:47:38','::1',15),(31,'e497be4c1b2a718c09279a20d28fcc2ae58e0051',NULL,'123456','d93a5def7511da3d0f2d171d9c344e91','数字','fd541aa70de849af64f27da785bed20b','568496723@qq.com','568496723','女',0,NULL,1,NULL,NULL,'2016-10-30 15:12:20','2016-11-01 22:16:12','::1',1),(32,'a0baaa8e5116a16a16d61a1ff2ce49c15c169bda',NULL,'user7','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','18190756096@163.com','','男',0,NULL,1,NULL,NULL,'2016-10-30 15:55:10','2016-11-01 22:16:12','::1',1),(33,'682d0c0db62a1915be2ac862c333c08142bf8bf8',NULL,'user8','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','18190756096@163.com','','女',0,NULL,0,NULL,NULL,'2016-10-30 19:38:23','2016-11-01 22:16:12','::1',1),(34,'2e5bb84412f56885290ccbd14ebdb172c2b2de46',NULL,'user9','f004a04da1dba354fc086ef8d49fa802','000000','5baf3d2e0da30e074e0a715d0e1f015d','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2016-10-30 19:39:38','2016-11-01 22:16:12','::1',1),(35,'945fbda53a725c6e95664f05574e72fce679942a',NULL,'user10','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2016-10-30 19:40:28','2016-11-12 20:11:41','::1',2),(36,'ba04a5c18b0d6731cb79eb26e53140d967a3d93b',NULL,'user11','7b9e49b79200cb8069dff056cd6aba2b','0000','7b9e49b79200cb8069dff056cd6aba2b','18190756096@163.com','','男',0,NULL,0,NULL,NULL,'2016-10-30 19:44:19','2016-11-01 22:16:12','::1',1),(37,'a420ae2f093e464fed6d28316a5c79fadf51b6d7',NULL,'user12','7b9e49b79200cb8069dff056cd6aba2b','0000','5baf3d2e0da30e074e0a715d0e1f015d','640246255@qq.com','','',0,NULL,0,NULL,NULL,'2016-10-30 19:44:56','2016-11-01 22:16:12','::1',1),(38,'5097335edba4b851ad33a9ae04dd2c7fc4289fef',NULL,'user13','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2016-10-30 19:50:46','2016-11-12 22:08:22','::1',6),(39,'6dcfbea516073988838a3d7b4802631b5eadaf91',NULL,'user14','7b9e49b79200cb8069dff056cd6aba2b','0000','7b9e49b79200cb8069dff056cd6aba2b','640246255@qq.com','640246255','男',0,NULL,0,NULL,NULL,'2016-10-30 20:00:03','2016-11-12 20:07:00','::1',2),(40,'3786637228da8227680a4a59f67f2fe2bd1f2e59',NULL,'user15','7b9e49b79200cb8069dff056cd6aba2b','0000','5baf3d2e0da30e074e0a715d0e1f015d','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2016-10-30 20:01:08','2016-11-26 22:39:30','::1',4),(41,'e9e06dbb0b0a01e619fb5292bdd8e307d6380634',NULL,'user16','7b9e49b79200cb8069dff056cd6aba2b','0000','7b9e49b79200cb8069dff056cd6aba2b','18190756096@163.com','','男',0,NULL,0,NULL,NULL,'2016-10-30 20:02:22','2016-11-01 22:16:12','::1',1),(42,'48854454c2575f37f2dd8d2d0c5f15c69677324c',NULL,'user17','7b9e49b79200cb8069dff056cd6aba2b','0000','5baf3d2e0da30e074e0a715d0e1f015d','640246255@qq.com','','女',0,NULL,0,NULL,NULL,'2016-10-30 20:02:52','2016-11-01 22:16:12','::1',1),(43,'54308a0e8ea0f56d5d13cd919175b1f33c5aebf7',NULL,'user18','7b9e49b79200cb8069dff056cd6aba2b','00','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','女',0,NULL,0,NULL,NULL,'2016-10-30 20:03:22','2016-11-01 22:16:12','::1',1),(44,'472bc7385d739575dac69897bc6dbfc1af5d3da8',NULL,'user19','7b9e49b79200cb8069dff056cd6aba2b','0000','5baf3d2e0da30e074e0a715d0e1f015d','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2016-10-30 20:04:08','2016-11-01 22:16:12','::1',1),(45,'04378925c62d9bd64bdd465e7829a1db050e79a7',NULL,'user20','7b9e49b79200cb8069dff056cd6aba2b','00','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2016-10-30 20:04:30','2016-11-01 22:16:12','::1',1),(46,'da10896f035041a5ac48b55179093e84b53f4dc2',NULL,'user21','7b9e49b79200cb8069dff056cd6aba2b','0000','f004a04da1dba354fc086ef8d49fa802','18190756096@163.com','','男',0,NULL,0,NULL,NULL,'2016-10-30 20:10:20','2016-11-01 22:16:12','::1',1),(47,'f9d1cbeaf7d14a2c19049b00c61aa67d06559f55',NULL,'user22','7b9e49b79200cb8069dff056cd6aba2b','00','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2016-10-30 20:10:51','2016-11-01 22:16:12','::1',1),(48,'2be7e2ad12bd4a0f995c7cba41c72743ad07abc6',NULL,'user23','','0000','7b9e49b79200cb8069dff056cd6aba2b','640246255@qq.com','','女',0,NULL,0,NULL,NULL,'2016-10-30 20:11:11','2016-11-29 21:25:29','::1',10),(49,'56a2398f389d752361a946db909e408c77f2a65c',NULL,'user24','7b9e49b79200cb8069dff056cd6aba2b','0000','5baf3d2e0da30e074e0a715d0e1f015d','18190756096@163.com','','男',0,NULL,0,NULL,NULL,'2016-10-31 20:58:55','2016-12-08 12:55:53','::1',3),(50,'05cb1c19fbb54221c9682157e53ff88aacac596c',NULL,'user25','7b9e49b79200cb8069dff056cd6aba2b','000','5baf3d2e0da30e074e0a715d0e1f015d','18190756096@163.com','','女',0,NULL,0,NULL,NULL,'2016-10-31 23:14:16','2016-12-01 13:41:02','::1',7),(51,'8a2841cb3d951afd85286bfd5afe38083d1b88e4',NULL,'xml','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','女',0,NULL,0,NULL,NULL,'2016-11-06 10:48:24','2016-11-06 10:48:24','::1',0),(52,'ba0815f7eed6ad49853177aa02360714ba545744',NULL,'xml2','7b9e49b79200cb8069dff056cd6aba2b','000000','2e422e0e31a7426c33bb1a781bfae270','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2016-11-06 10:50:43','2016-11-06 10:50:43','::1',0),(55,'c03b75b9372a2f583e093730df9d8b3e7ad9bfee',NULL,'非法字符','c78b6663d47cfbdb4d65ea51c104044e','111','c8180c19e5a1278cddf5248331ef7fa5','18190756096@163.com','','男',0,NULL,0,NULL,NULL,'2016-11-13 23:39:28','2016-11-13 23:39:28','::1',0),(57,'88735843a6fdc5372bc67dd6a935accffe3c4a9f',NULL,'11155','f004a04da1dba354fc086ef8d49fa802','15151','7b9e49b79200cb8069dff056cd6aba2b','1148474075@qq.com','1148474075','男',0,NULL,0,NULL,NULL,'2016-11-18 16:29:44','2016-11-18 16:30:11','192.168.191.9',1),(66,'3efd544717abd32e89624ff76226f34eb5876d4f','9b29a6f39c15efed4d437bafc75c2f910c85c7df','forcheng','6d98843e73ce86944543cf28a038f151','<script>','778c4da66d99ec461b70ad85313a4b50','kdfjsk@qq.com','1212323','中',0,NULL,0,NULL,NULL,'2016-11-21 18:50:10','2016-11-21 18:50:10','10.2.130.53',0),(67,'242b7a89d7dbd41034d2b9b9511e860afe2d9908',NULL,'1234567','6d98843e73ce86944543cf28a038f151','<script>','778c4da66d99ec461b70ad85313a4b50','2871979271@qq.com','12345','女',1,'<script>',0,1479725689,1479725871,'2016-11-21 18:51:41','2016-11-21 19:04:30','10.2.130.53',2),(90,'ca482790cb04bea942de3b6b9ad257b0cdab54ba',NULL,'帅猪2333','9996071ee132fc89bc9488ee50414522','你是猪？','9f687744de93960013429d102d8ea453','897990540@qq.com','897990540','女',0,NULL,0,NULL,NULL,'2016-11-25 10:58:26','2016-11-25 10:59:47','10.2.130.24',1),(89,'c51a552c89a25adefe3b087eed9ad67cfc8e4298',NULL,'ratsui','1ca7d69b4081237a33d2b9d3a116cbea','我是谁','b004f5e74f1e1884ee3fc9a878ccd274','496081759@qq.com','496081759','女',0,NULL,0,NULL,NULL,'2016-11-22 20:47:52','2016-11-22 20:48:15','10.2.130.195',1),(87,'2b6041f9fd0e8a9b03582268cd62de380ab8b255',NULL,'lx','d93a5def7511da3d0f2d171d9c344e91','123456','afda1feb31ae9c3bff0ec654cefc20db','529603373@qq.com','529603373','男',0,NULL,0,NULL,NULL,'2016-11-22 12:30:14','2016-11-22 12:32:04','10.2.130.179',1),(91,'516ccdd129387b743284b4c2b16140dbebf31bb3',NULL,'刘波','d93a5def7511da3d0f2d171d9c344e91','123','174a9535b7fd93ceecbe1fc0392fa0f2','897990540@qq.com','897990540','女',0,NULL,0,NULL,NULL,'2016-12-07 13:34:40','2016-12-07 13:38:06','10.2.130.24',2),(92,'d32a07795239e02af35af32d8642738ee140cdb1',NULL,'测试还原数据库','d93a5def7511da3d0f2d171d9c344e91','123456','afda1feb31ae9c3bff0ec654cefc20db','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2016-12-14 09:57:58','2016-12-14 10:01:39','10.2.130.178',NULL),(93,'9cd494f733d7260fc5eccd6087b3910afd9c9857',NULL,'haha','c78b6663d47cfbdb4d65ea51c104044e','展示','56a83d4ea46b434bb238b2d6db1e7b3a','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2016-12-27 16:13:03','2016-12-29 17:14:29','10.5.57.139',NULL),(98,'497bae0fee286ca251f59fc5ba4e5ef0814f0208',NULL,'测试','d93a5def7511da3d0f2d171d9c344e91','1234','6116afedcb0bc31083935c1c262ff4c9','640246255@qq.com','','男',0,NULL,0,NULL,NULL,'2017-01-25 16:52:19','2017-01-25 16:54:30','::1',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
