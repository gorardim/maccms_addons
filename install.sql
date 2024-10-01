-- ----------------------------
-- Table structure for mac_feedback
-- ----------------------------
DROP TABLE IF EXISTS `mac_feedback`;
CREATE TABLE `mac_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' ,
  `user_name` varchar(60) NOT NULL DEFAULT '' ,
  `user_email` varchar(60) NOT NULL DEFAULT '' ,
  `user_tel` varchar(60) NOT NULL DEFAULT '' ,
  `content` varchar(191) NOT NULL DEFAULT '',
  `remarks` varchar(191) NOT NULL DEFAULT '',
  `ip` varchar(20) NOT NULL DEFAULT '0' ,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `content` (`content`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table data for mac_feedback
-- ----------------------------
INSERT INTO `mac_feedback` VALUES (1, 1, 'test', 'test@gmail.com', '123456789', 'test', 'test', '192.168.65.1', 1, 0, '2019-07-01 00:00:00', '2019-07-01 00:00:00');
INSERT INTO `mac_feedback` VALUES (2, 1, 'test1', 'test1@gmail.com', '123456789', 'test1', 'test1', '192.168.65.2', 1, 0, '2019-07-01 00:00:00', '2019-07-01 00:00:00');