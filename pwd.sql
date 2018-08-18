# Host: localhost  (Version: 5.5.53)
# Date: 2018-08-17 16:20:30
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "pwd_log"
#

CREATE TABLE `pwd_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `username` text,
  `ev` int(11) NOT NULL,
  `url` text NOT NULL,
  `ip` text NOT NULL,
  `ua` text NOT NULL,
  `json` text NOT NULL,
  `time` text NOT NULL,
  `record` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "pwd_log"
#


#
# Structure for table "pwd_notepad"
#

CREATE TABLE `pwd_notepad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `stime` text NOT NULL,
  `type` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "pwd_notepad"
#


#
# Structure for table "pwd_notice"
#

CREATE TABLE `pwd_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `time` text NOT NULL,
  `level` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "pwd_notice"
#


#
# Structure for table "pwd_plan"
#

CREATE TABLE `pwd_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `stime` text NOT NULL,
  `type` tinyint(2) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "pwd_plan"
#


#
# Structure for table "pwd_pwd"
#

CREATE TABLE `pwd_pwd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` text NOT NULL,
  `descr` text NOT NULL,
  `user` text NOT NULL,
  `passw` text NOT NULL,
  `weburl` text NOT NULL,
  `intime` text NOT NULL,
  `lasttime` text NOT NULL,
  `tpass` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `type` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "pwd_pwd"
#


#
# Structure for table "pwd_set"
#

CREATE TABLE `pwd_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `passw` varchar(32) NOT NULL,
  `qq` int(11) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `title` text NOT NULL,
  `describe` text NOT NULL,
  `keywords` text NOT NULL,
  `sign` tinyint(1) NOT NULL,
  `email_sign` tinyint(1) NOT NULL,
  `ipadmin` text NOT NULL,
  `debug` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "pwd_set"
#

INSERT INTO `pwd_set` VALUES (1,'admin','f26252d7b599373064db0072e1f3bb0b',1170535111,'1170535111@qq.com','标题','描述','关键词',1,1,'123.207.124.37,123.207.123.38',0);

#
# Structure for table "pwd_smtp"
#

CREATE TABLE `pwd_smtp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` text NOT NULL,
  `port` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `sub` text NOT NULL,
  `ssl` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "pwd_smtp"
#

INSERT INTO `pwd_smtp` VALUES (1,'smtp.exmail.qq.com',465,'','','Youngxj',1);

#
# Structure for table "pwd_user"
#

CREATE TABLE `pwd_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `passw` varchar(32) NOT NULL,
  `email` text NOT NULL,
  `qq` int(11) NOT NULL,
  `stime` text NOT NULL,
  `ltime` text NOT NULL,
  `sip` text NOT NULL,
  `lip` text NOT NULL,
  `token` varchar(32) NOT NULL,
  `status` int(11) NOT NULL,
  `error_num` int(11) NOT NULL,
  `email_token` varchar(50) NOT NULL,
  `token_exptime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pwd_user` (`id`, `username`, `passw`, `email`, `qq`, `stime`, `ltime`, `sip`, `lip`, `token`, `status`, `error_num`, `email_token`, `token_exptime`) VALUES
(1, 'admin',  'f26252d7b599373064db0072e1f3bb0b', '1170535111@qq.com',  1170535111, '2018-08-09 14:29:16',  '2018-08-17 17:17:30',  '::1',  '127.0.0.1',  '144512454', 1,  0,  '', '');
#
# Data for table "pwd_user"
#

