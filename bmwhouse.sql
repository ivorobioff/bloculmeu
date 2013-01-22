/*
Navicat MySQL Data Transfer

Source Server         : redstap.local
Source Server Version : 50140
Source Host           : localhost:3306
Source Database       : bmwhouse

Target Server Type    : MYSQL
Target Server Version : 50140
File Encoding         : 65001

Date: 2012-12-19 23:35:02
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `admin_users`
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `insert_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES ('1', 'i_am_vib@yahoo.com', '9ce5e1a612c61cb9a705fe7a86eded30', 'admin', '2012-11-25 16:22:10');

-- ----------------------------
-- Table structure for `grid_test`
-- ----------------------------
DROP TABLE IF EXISTS `grid_test`;
CREATE TABLE `grid_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of grid_test
-- ----------------------------
INSERT INTO `grid_test` VALUES ('1', 'Super1', '1', '1');
INSERT INTO `grid_test` VALUES ('2', 'Super2', '0', '2');
INSERT INTO `grid_test` VALUES ('3', 'Super3', '1', '12');
INSERT INTO `grid_test` VALUES ('4', 'Super4', '1', '4');
INSERT INTO `grid_test` VALUES ('5', 'Super5', '0', '5');
INSERT INTO `grid_test` VALUES ('6', 'Super6', '0', '9');
INSERT INTO `grid_test` VALUES ('7', 'Super7', '1', '7');
INSERT INTO `grid_test` VALUES ('8', 'Super8', '0', '8');
INSERT INTO `grid_test` VALUES ('9', 'Super9', '0', '6');
INSERT INTO `grid_test` VALUES ('10', 'Super10', '0', '11');
INSERT INTO `grid_test` VALUES ('11', 'Super11', '1', '10');
INSERT INTO `grid_test` VALUES ('12', 'Super12', '1', '3');
INSERT INTO `grid_test` VALUES ('13', 'Super13', '0', '13');

-- ----------------------------
-- Table structure for `modules`
-- ----------------------------
DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `menu` text,
  `pin` tinyint(1) DEFAULT '0',
  `guid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of modules
-- ----------------------------

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `insert_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------

-- ----------------------------
-- Table structure for `news_lang`
-- ----------------------------
DROP TABLE IF EXISTS `news_lang`;
CREATE TABLE `news_lang` (
  `id` tinyint(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `body` text,
  `title` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news_lang
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `insert_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
