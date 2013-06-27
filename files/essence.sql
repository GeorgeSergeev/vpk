/*
Navicat MySQL Data Transfer

Source Server         : MySql
Source Server Version : 50150
Source Host           : localhost:3306
Source Database       : consulbase

Target Server Type    : MYSQL
Target Server Version : 50150
File Encoding         : 65001

Date: 2012-12-02 00:00:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `essence`
-- ----------------------------
DROP TABLE IF EXISTS `essence`;
CREATE TABLE `consul_essence` (
  `essence_code` int(11) NOT NULL AUTO_INCREMENT,
  `essence_comment` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`essence_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of essence
-- ----------------------------
