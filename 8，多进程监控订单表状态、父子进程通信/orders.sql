/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-05-25 21:10:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_user` varchar(50) DEFAULT NULL,
  `order_ispay` bit(1) DEFAULT b'0',
  `order_notice` bit(1) DEFAULT b'0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('1', 'zhangsan', '\0', '\0');
INSERT INTO `orders` VALUES ('2', 'lisi', '', '');
INSERT INTO `orders` VALUES ('3', 'wanghu', '\0', '\0');
INSERT INTO `orders` VALUES ('4', 'aaa', '\0', '\0');
INSERT INTO `orders` VALUES ('5', 'bb', '\0', '\0');
INSERT INTO `orders` VALUES ('6', 'cc', '\0', '\0');
INSERT INTO `orders` VALUES ('7', 'dd', '\0', '\0');
INSERT INTO `orders` VALUES ('8', 'ee', '\0', '\0');
INSERT INTO `orders` VALUES ('9', 'ff', '\0', '\0');
INSERT INTO `orders` VALUES ('10', 'gg', '\0', '\0');
INSERT INTO `orders` VALUES ('11', 'hh', '\0', '\0');
INSERT INTO `orders` VALUES ('12', 'jj', '\0', '\0');
INSERT INTO `orders` VALUES ('13', 'kk', '\0', '\0');
INSERT INTO `orders` VALUES ('14', 'll', '\0', '\0');
INSERT INTO `orders` VALUES ('15', 'ii', '\0', '\0');
INSERT INTO `orders` VALUES ('16', 'oo', '\0', '\0');
INSERT INTO `orders` VALUES ('17', 'pp', '\0', '\0');
INSERT INTO `orders` VALUES ('18', 'ert', '\0', '\0');
INSERT INTO `orders` VALUES ('19', 'ceee', '\0', '\0');
INSERT INTO `orders` VALUES ('20', 'dfefw', '\0', '\0');
INSERT INTO `orders` VALUES ('21', 'aabb', '\0', '\0');
INSERT INTO `orders` VALUES ('22', 'aacc', '\0', '\0');
INSERT INTO `orders` VALUES ('23', 'aadd', '\0', '\0');
INSERT INTO `orders` VALUES ('24', 'aaff', '\0', '\0');
INSERT INTO `orders` VALUES ('25', 'aaee', '\0', '\0');
INSERT INTO `orders` VALUES ('26', 'aatrr', '\0', '\0');
