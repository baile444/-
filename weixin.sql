-- ----------------------------
-- Table structure for `hcj_admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `hcj_admin_user`;
CREATE TABLE `hcj_admin_user` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userName` varchar(55) NOT NULL,
  `userPwd` char(32) NOT NULL,
  PRIMARY KEY (`userId`),
  KEY `userName` (`userName`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hcj_admin_user
-- ----------------------------
INSERT INTO `hcj_admin_user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e');

