/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50739 (5.7.39)
 Source Host           : localhost:3306
 Source Schema         : test

 Target Server Type    : MySQL
 Target Server Version : 50739 (5.7.39)
 File Encoding         : 65001

 Date: 10/04/2024 11:56:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tp_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin`;
CREATE TABLE `tp_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否超管\n1:是',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `tel` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `login_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT 'IP地址',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登陆时间',
  `last_login_ip` varchar(255) NOT NULL DEFAULT '' COMMENT '上次登陆ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登陆时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1可用0禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tp_admin
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for tp_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_group`;
CREATE TABLE `tp_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` char(100) NOT NULL DEFAULT '' COMMENT '分组名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `rules` char(80) NOT NULL DEFAULT '' COMMENT '规则',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tp_auth_group
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for tp_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_group_access`;
CREATE TABLE `tp_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tp_auth_group_access
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for tp_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_rule`;
CREATE TABLE `tp_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '' COMMENT '权限规则 唯一  模板-控制器-方法',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则名称\n',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1：菜单  2:操作类',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0:禁止 1:开启',
  `uniqid` varchar(100) DEFAULT NULL COMMENT '唯一标识',
  `p_uniqid` varchar(100) DEFAULT NULL COMMENT '父类uid',
  `frontpath` varchar(255) DEFAULT NULL COMMENT '前端路由',
  `template_path` varchar(255) DEFAULT NULL COMMENT '前端模板路径',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `uniqid` (`uniqid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tp_auth_rule
-- ----------------------------
BEGIN;
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
