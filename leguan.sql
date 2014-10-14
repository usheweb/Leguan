/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : leguan

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2014-10-14 23:57:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `lg_article`
-- ----------------------------
DROP TABLE IF EXISTS `lg_article`;
CREATE TABLE `lg_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) DEFAULT NULL,
  `click` int(11) unsigned NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lg_article
-- ----------------------------
INSERT INTO `lg_article` VALUES ('1', 'title2', '0', 'description3');
INSERT INTO `lg_article` VALUES ('2', 'title', '0', 'description');
INSERT INTO `lg_article` VALUES ('3', '1', '0', null);
INSERT INTO `lg_article` VALUES ('4', 'new \'title', '0', 'test');
INSERT INTO `lg_article` VALUES ('5', 'new \'title', '10', 'test');
INSERT INTO `lg_article` VALUES ('6', 'new \'title', '0', 'test');
INSERT INTO `lg_article` VALUES ('7', 'new \'title', '0', 'test');
INSERT INTO `lg_article` VALUES ('8', 'new \'title', '0', 'test');
INSERT INTO `lg_article` VALUES ('9', 'new \'title', '0', 'test');
INSERT INTO `lg_article` VALUES ('10', 'new \'title', '0', 'test');
INSERT INTO `lg_article` VALUES ('11', 'new \'title', '0', 'test');
INSERT INTO `lg_article` VALUES ('12', 'new \'title', '0', 'test');
INSERT INTO `lg_article` VALUES ('13', 'new \'title', '0', 'test');
