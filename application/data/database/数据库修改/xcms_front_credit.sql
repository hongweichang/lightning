/*
 Navicat MySQL Data Transfer

 Source Server         : workspace
 Source Server Version : 50144
 Source Host           : localhost
 Source Database       : lightning

 Target Server Version : 50144
 File Encoding         : utf-8

 Date: 11/20/2013 01:59:29 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `xcms_front_credit`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_front_credit`;
CREATE TABLE `xcms_front_credit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `verification_id` int(11) unsigned NOT NULL,
  `file_type` tinytext COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL COMMENT '提交内容可以是文字或是URL',
  `submit_time` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '审核状态，0-待审，1-通过，2-失败',
  `description` tinytext COLLATE utf8_bin COMMENT '未通过审核时，可以填写原因',
  PRIMARY KEY (`id`,`status`),
  KEY `FK_FRONT_USER_CREDIT_FU` (`user_id`),
  KEY `FK_FRONT_USER_CREDIT_C` (`verification_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户提交的信用资料，包含每条资料的审核状态';

-- ----------------------------
--  Records of `xcms_front_credit`
-- ----------------------------
BEGIN;
INSERT INTO `xcms_front_credit` VALUES ('1', '1', '1', 0x66696c65, 0x2f4170706c69636174696f6e732f58414d50502f78616d707066696c65732f6874646f63732f6c696768746e696e672f75706c6f61642f7064662f3230313331312f75736572496e666f323031333131313931303437313237586d38672e3039e7acac3920e7aba0e8a786e59bbe2e706466, '1384858033', '0', null), ('2', '2', '1', 0x66696c65, 0x2f4170706c69636174696f6e732f58414d50502f78616d707066696c65732f6874646f63732f6c696768746e696e672f75706c6f61642f7064662f3230313331312f75736572496e666f3230313331313139313733353532633159394b2e3036e7acac3620e7aba0e585b3e7b3bbe4bba3e695b02e706466, '1384882553', '0', null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
