/*
Navicat MySQL Data Transfer

Source Server         : lancelot@lightning:3306
Source Server Version : 50614
Source Host           : lightning-db.aliyun.com:3306
Source Database       : lightning

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2013-11-21 01:40:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `xcms_ad_banner`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_ad_banner`;
CREATE TABLE `xcms_ad_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `is_using` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在使用，0-否，1-是',
  `list_order` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '显示顺序，默认为0',
  `path` text NOT NULL,
  `add_time` int(11) NOT NULL,
  `banner_type` tinyint(2) NOT NULL COMMENT '0-网站，1-app',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='首页广告banner';

-- ----------------------------
-- Records of xcms_ad_banner
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_area`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_area`;
CREATE TABLE `xcms_area` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(11) unsigned NOT NULL,
  `level2` int(11) unsigned NOT NULL,
  `lft` int(11) unsigned NOT NULL,
  `rgt` int(11) unsigned NOT NULL,
  `area_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地区';

-- ----------------------------
-- Records of xcms_area
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_article`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_article`;
CREATE TABLE `xcms_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `add_time` int(11) unsigned NOT NULL,
  `art_type` tinyint(2) NOT NULL COMMENT '文章类型，0-公告，1-帮助文档',
  `click` int(11) NOT NULL DEFAULT '0' COMMENT '点击量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站公告，帮助文档';

-- ----------------------------
-- Records of xcms_article
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_auth_group_role`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_auth_group_role`;
CREATE TABLE `xcms_auth_group_role` (
  `role_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `is_default` tinyint(1) DEFAULT '1' COMMENT '是否是该用户组的默认角色，0为是，1为否，默认为1',
  PRIMARY KEY (`role_id`,`group_id`),
  KEY `FK_GROUP_ROLE_G` (`group_id`),
  CONSTRAINT `FK_GROUP_ROLE_G` FOREIGN KEY (`group_id`) REFERENCES `xcms_auth_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_GROUP_ROLE_R` FOREIGN KEY (`role_id`) REFERENCES `xcms_auth_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='关联用户组和角色';

-- ----------------------------
-- Records of xcms_auth_group_role
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_auth_groups`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_auth_groups`;
CREATE TABLE `xcms_auth_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL COMMENT '用户组名称',
  `description` text COMMENT '用户组描述',
  `enabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁止使用，0代表开始，1代表禁止，默认为0',
  `list_order` int(5) NOT NULL DEFAULT '0' COMMENT '显示顺序，默认为0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='存放用户组信息';

-- ----------------------------
-- Records of xcms_auth_groups
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_auth_mutex`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_auth_mutex`;
CREATE TABLE `xcms_auth_mutex` (
  `role1` int(11) unsigned NOT NULL,
  `role2` int(11) unsigned NOT NULL,
  `description` text,
  PRIMARY KEY (`role1`,`role2`),
  KEY `FK_ROLE_MUTEX_R2` (`role2`),
  CONSTRAINT `FK_ROLE_MUTEX_R1` FOREIGN KEY (`role1`) REFERENCES `xcms_auth_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ROLE_MUTEX_R2` FOREIGN KEY (`role2`) REFERENCES `xcms_auth_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色互斥';

-- ----------------------------
-- Records of xcms_auth_mutex
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_auth_operation`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_auth_operation`;
CREATE TABLE `xcms_auth_operation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(11) unsigned NOT NULL,
  `level2` int(11) unsigned NOT NULL,
  `lft` int(11) unsigned NOT NULL COMMENT '用于二叉搜索树',
  `rgt` int(11) unsigned NOT NULL COMMENT '用于二叉搜索树',
  `operation_name` varchar(20) NOT NULL,
  `description` text,
  `module` varchar(30) DEFAULT NULL,
  `controller` varchar(30) NOT NULL,
  `action` varchar(30) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁止使用，0表示开启，1表示关闭，默认为0',
  `list_order` int(5) NOT NULL DEFAULT '0' COMMENT '显示顺序，默认为0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_module_controller_action` (`module`,`controller`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作';

-- ----------------------------
-- Records of xcms_auth_operation
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_auth_permission`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_auth_permission`;
CREATE TABLE `xcms_auth_permission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `operation_id` int(11) unsigned NOT NULL,
  `resource_id` int(11) unsigned DEFAULT NULL COMMENT '权限管理的资源，可以为NULL',
  `permission_name` varchar(20) NOT NULL,
  `description` text COMMENT '权限描述，默认为空',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_operation_resource` (`resource_id`,`operation_id`),
  KEY `FK_PERMISSION_OPERATION_RESOURCE_O` (`operation_id`),
  CONSTRAINT `FK_PERMISSION_OPERATION_RESOURCE_O` FOREIGN KEY (`operation_id`) REFERENCES `xcms_auth_operation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PERMISSION_OPERATION_RESOURCE_R` FOREIGN KEY (`resource_id`) REFERENCES `xcms_auth_resource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限=操作[+资源]';

-- ----------------------------
-- Records of xcms_auth_permission
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_auth_protected_file`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_auth_protected_file`;
CREATE TABLE `xcms_auth_protected_file` (
  `id` int(11) unsigned NOT NULL,
  `path` text NOT NULL,
  `is_dir` tinyint(1) NOT NULL COMMENT '是否为目录，0-是，1-否',
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_REOUSRCE_PROTECTED_FILE_F` FOREIGN KEY (`id`) REFERENCES `xcms_auth_resource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='控制文件系统中文件访问权限。继承自资源';

-- ----------------------------
-- Records of xcms_auth_protected_file
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_auth_protected_table`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_auth_protected_table`;
CREATE TABLE `xcms_auth_protected_table` (
  `id` int(11) unsigned NOT NULL,
  `table_name` varchar(30) NOT NULL,
  `field_name` varchar(20) DEFAULT NULL COMMENT '受控数据表内字段，可为空',
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_table_field_resource_type` (`table_name`,`field_name`),
  CONSTRAINT `FK_RESOURCE_PROTECTED_RESOURCE_P` FOREIGN KEY (`id`) REFERENCES `xcms_auth_resource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='受到保护的数据表，字段。继承自资源';

-- ----------------------------
-- Records of xcms_auth_protected_table
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_auth_resource`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_auth_resource`;
CREATE TABLE `xcms_auth_resource` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `resource_name` varchar(50) NOT NULL,
  `description` text,
  `r_type` varchar(20) NOT NULL COMMENT '资源作为父类，r_type表示该资源的子类类型',
  PRIMARY KEY (`id`),
  KEY `resource_type` (`r_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资源';

-- ----------------------------
-- Records of xcms_auth_resource
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_auth_role_permission`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_auth_role_permission`;
CREATE TABLE `xcms_auth_role_permission` (
  `role_id` int(11) unsigned NOT NULL,
  `permission_id` int(11) unsigned NOT NULL,
  `is_default` tinyint(1) DEFAULT '1' COMMENT '是否是该角色的默认权限，0为是，1为否，默认为1',
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `FK_ROLE_PERMISSION_P` (`permission_id`),
  CONSTRAINT `FK_ROLE_PERMISSION_P` FOREIGN KEY (`permission_id`) REFERENCES `xcms_auth_permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ROLE_PERMISSION_R` FOREIGN KEY (`role_id`) REFERENCES `xcms_auth_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='关联角色和权限';

-- ----------------------------
-- Records of xcms_auth_role_permission
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_auth_roles`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_auth_roles`;
CREATE TABLE `xcms_auth_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(11) unsigned NOT NULL,
  `level` int(11) unsigned NOT NULL COMMENT '所属的等级',
  `lft` int(11) unsigned NOT NULL COMMENT '用于二叉搜索树',
  `rgt` int(11) unsigned NOT NULL COMMENT '用于二叉搜索树',
  `role_name` varchar(50) NOT NULL COMMENT '角色名称',
  `description` text COMMENT '角色描述',
  `enabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁止使用，0表示开启，1表示关闭，默认为0',
  `list_order` int(5) NOT NULL DEFAULT '0' COMMENT '显示顺序，默认为0',
  PRIMARY KEY (`id`),
  KEY `role_list_order` (`list_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色';

-- ----------------------------
-- Records of xcms_auth_roles
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_auth_user_permission`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_auth_user_permission`;
CREATE TABLE `xcms_auth_user_permission` (
  `permission_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `is_own` tinyint(1) NOT NULL COMMENT '用户是否具有这个权限，1代表有，-1代表没有。在权限计算时从总权限中加上或减去这个权限',
  `expire` int(11) unsigned NOT NULL COMMENT '权限过期的绝对时间',
  PRIMARY KEY (`permission_id`,`user_id`),
  KEY `FK_USER_PERMISSION_U` (`user_id`),
  CONSTRAINT `FK_USER_PERMISSION_P` FOREIGN KEY (`permission_id`) REFERENCES `xcms_auth_permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_USER_PERMISSION_U` FOREIGN KEY (`user_id`) REFERENCES `xcms_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='为用户直接赋予或取消某些权限';

-- ----------------------------
-- Records of xcms_auth_user_permission
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_bid`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_bid`;
CREATE TABLE `xcms_bid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `sum` int(11) unsigned NOT NULL COMMENT '金额乘以100',
  `month_rate` int(5) unsigned NOT NULL COMMENT '还款月利率，乘以100',
  `start` int(11) unsigned NOT NULL COMMENT '招标开始日期',
  `end` int(11) unsigned NOT NULL COMMENT '招标结束日期',
  `deadline` int(11) unsigned NOT NULL COMMENT '借款结束日期，绝对时间',
  `progress` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '进度乘以100，默认为0',
  `verify_pregress` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核进度，0-审核中，1-通过，2-未通过',
  `failed_description` tinytext COMMENT '审核失败原因',
  PRIMARY KEY (`id`),
  KEY `FK_FRONT_USER_BID_FU` (`user_id`),
  CONSTRAINT `FK_FRONT_USER_BID_FU` FOREIGN KEY (`user_id`) REFERENCES `xcms_front_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标段信息';

-- ----------------------------
-- Records of xcms_bid
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_bid_meta`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_bid_meta`;
CREATE TABLE `xcms_bid_meta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `bid_id` int(11) unsigned NOT NULL,
  `sum` int(11) unsigned NOT NULL COMMENT '购买金额，乘以100',
  `buy_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FRONT_USER_BID_META_FU` (`user_id`),
  KEY `FK_FRONT_USER_BID_META_BM` (`bid_id`),
  CONSTRAINT `FK_FRONT_USER_BID_META_BM` FOREIGN KEY (`bid_id`) REFERENCES `xcms_bid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_FRONT_USER_BID_META_FU` FOREIGN KEY (`user_id`) REFERENCES `xcms_front_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标段购买信息';

-- ----------------------------
-- Records of xcms_bid_meta
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_credit_grade_settings`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_credit_grade_settings`;
CREATE TABLE `xcms_credit_grade_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(3) NOT NULL COMMENT '等级',
  `start` int(4) NOT NULL COMMENT '起始分数',
  `end` int(4) NOT NULL COMMENT '结束分数',
  `on_recharge` int(5) unsigned NOT NULL COMMENT '充值',
  `on_withdraw` int(5) unsigned NOT NULL COMMENT '提现',
  `on_pay_back` int(5) unsigned NOT NULL COMMENT '还款',
  `on_over6` int(5) unsigned NOT NULL COMMENT '借款大于6月',
  `on_below6` int(5) unsigned NOT NULL COMMENT '借款小于6月',
  `on_loan` int(5) unsigned NOT NULL COMMENT '标段利息的利润',
  `loanable` tinyint(1) NOT NULL COMMENT '该等级能否借款，0-否，1-是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='信用积分等级配置';

-- ----------------------------
-- Records of xcms_credit_grade_settings
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_credit_role`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_credit_role`;
CREATE TABLE `xcms_credit_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(15) NOT NULL,
  `verification_id` int(11) unsigned NOT NULL,
  `optional` tinyint(1) NOT NULL DEFAULT '0' COMMENT '该信用选项是否可以不写，0-否，1-是，默认为0',
  `grade` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_CREDIT_ROL_R` (`verification_id`),
  KEY `xcms_credit_role` (`role`),
  CONSTRAINT `FK_CREDIT_ROL_R` FOREIGN KEY (`verification_id`) REFERENCES `xcms_credit_settings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='社会角色的信用配置，包括每种角色需要填写的资料，每种资料的加分';

-- ----------------------------
-- Records of xcms_credit_role
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_credit_settings`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_credit_settings`;
CREATE TABLE `xcms_credit_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `verification_name` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `verification_type` varchar(255) NOT NULL COMMENT '信息的类型，如text-文字，image-图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='信用验证内容，包含内容的类型，如图片、文字';

-- ----------------------------
-- Records of xcms_credit_settings
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_front_credit`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_front_credit`;
CREATE TABLE `xcms_front_credit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `verification_id` int(11) unsigned NOT NULL,
  `file_type` varchar(15) NOT NULL DEFAULT '文件后缀名',
  `content` text NOT NULL COMMENT '提交内容可以是文字或是URL',
  `submit_time` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '审核状态，0-待审，1-通过，2-失败',
  `description` tinytext COMMENT '未通过审核时，可以填写原因',
  PRIMARY KEY (`id`),
  KEY `FK_FRONT_USER_CREDIT_FU` (`user_id`),
  KEY `FK_FRONT_USER_CREDIT_C` (`verification_id`),
  CONSTRAINT `FK_FRONT_USER_CREDIT_C` FOREIGN KEY (`verification_id`) REFERENCES `xcms_credit_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_FRONT_USER_CREDIT_FU` FOREIGN KEY (`user_id`) REFERENCES `xcms_front_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户提交的信用资料，包含每条资料的审核状态';

-- ----------------------------
-- Records of xcms_front_credit
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_front_user`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_front_user`;
CREATE TABLE `xcms_front_user` (
  `id` int(11) unsigned NOT NULL,
  `pay_password` varchar(60) NOT NULL,
  `balance` int(11) unsigned NOT NULL DEFAULT '0',
  `nickname` varchar(15) NOT NULL,
  `realname` varchar(10) NOT NULL,
  `gender` tinyint(1) DEFAULT NULL COMMENT '0-女，1-男。可为空（保密）',
  `age` int(3) DEFAULT NULL COMMENT '可为空（保密）',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码，唯一，可用于登录',
  `email` varchar(50) NOT NULL COMMENT '邮箱，唯一，用于登录，密码找回，验证',
  `address` tinytext,
  `identity_id` varchar(18) NOT NULL COMMENT '身份证，唯一',
  `bank` varchar(20) NOT NULL,
  `role` varchar(15) NOT NULL COMMENT '用户社会角色，字符串，方便阅读',
  `credit_acceptable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户所属角色的资料是否填写完整，0-否，1-是，修改资料时置0，待审核',
  `credit_grade` int(4) NOT NULL COMMENT '根据信用资料审核程度得到的分数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `front_user_mobile` (`mobile`),
  UNIQUE KEY `front_user_email` (`email`),
  UNIQUE KEY `Index_3` (`identity_id`),
  KEY `front_user_role` (`role`),
  CONSTRAINT `FK_FRONT_BASE_USER_F` FOREIGN KEY (`id`) REFERENCES `xcms_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台用户，继承自网站用户';

-- ----------------------------
-- Records of xcms_front_user
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_front_user_icon`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_front_user_icon`;
CREATE TABLE `xcms_front_user_icon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `path` text NOT NULL,
  `size` varchar(15) DEFAULT NULL COMMENT '头像尺寸（长宽），默认为null，表示使用程序定义的默认尺寸',
  `file_size` int(5) NOT NULL COMMENT '文件大小，单位Byte',
  `in_using` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否正在使用，0-否，1-是，默认为0',
  PRIMARY KEY (`id`),
  KEY `FK_FRONT_USER_ICON_I` (`user_id`),
  CONSTRAINT `FK_FRONT_USER_ICON_I` FOREIGN KEY (`user_id`) REFERENCES `xcms_front_user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户头像，一个用户可以有多个头像和一个正在使用的头像';

-- ----------------------------
-- Records of xcms_front_user_icon
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_front_user_message_board`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_front_user_message_board`;
CREATE TABLE `xcms_front_user_message_board` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `add_time` int(11) unsigned NOT NULL,
  `reply_status` tinyint(1) NOT NULL COMMENT '回复状态，0-未回复，1-已回复',
  `reply_content` text,
  `reply_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FRONT_USER_MSG_BOARD_FU` (`user_id`),
  CONSTRAINT `FK_FRONT_USER_MSG_BOARD_FU` FOREIGN KEY (`user_id`) REFERENCES `xcms_front_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户提问、留言板';

-- ----------------------------
-- Records of xcms_front_user_message_board
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_fund`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_fund`;
CREATE TABLE `xcms_fund` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `log_name_cn` varchar(10) NOT NULL,
  `log_name_en` varchar(20) NOT NULL,
  `value` int(11) unsigned NOT NULL COMMENT '资金值，乘以100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `fund_name_en` (`log_name_en`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资金记录信息，用于简单记录资金总和，如网站所有金额';

-- ----------------------------
-- Records of xcms_fund
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_fund_flow_internal`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_fund_flow_internal`;
CREATE TABLE `xcms_fund_flow_internal` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `to_user` int(11) unsigned NOT NULL,
  `from_user` int(11) unsigned NOT NULL,
  `sum` int(11) unsigned NOT NULL COMMENT '流动金额，乘以100',
  `time` int(11) unsigned NOT NULL,
  `fee` int(5) unsigned NOT NULL COMMENT '手续费，乘以100',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-正在处理，1-成功',
  PRIMARY KEY (`id`),
  KEY `FK_FRONT_USER_FROM_FUND_FLOW_FUF` (`from_user`),
  KEY `FK_FRONT_USER_FUND_FLOW_FUT` (`to_user`),
  CONSTRAINT `FK_FRONT_USER_FROM_FUND_FLOW_FUF` FOREIGN KEY (`from_user`) REFERENCES `xcms_front_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_FRONT_USER_FUND_FLOW_FUT` FOREIGN KEY (`to_user`) REFERENCES `xcms_front_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站内用户资金流动记录';

-- ----------------------------
-- Records of xcms_fund_flow_internal
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_message`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_message`;
CREATE TABLE `xcms_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `via` tinyint(2) NOT NULL COMMENT '0-所以路径，1-邮件，2-短信，3-站内信',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-发送中，1-未读，2-已读，3-发送失败',
  PRIMARY KEY (`id`),
  KEY `FK_FRONT_USER_MESSAGE_FU` (`user_id`),
  CONSTRAINT `FK_FRONT_USER_MESSAGE_FU` FOREIGN KEY (`user_id`) REFERENCES `xcms_front_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站消息';

-- ----------------------------
-- Records of xcms_message
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_notification_settings`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_notification_settings`;
CREATE TABLE `xcms_notification_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `email` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0-否，1-是，默认，1',
  `sms` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0-否，1-是，默认1',
  `internal` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0-否，1-是，默认1',
  PRIMARY KEY (`id`),
  KEY `FK_FRONT_USER_NOTIFY_FU` (`user_id`),
  CONSTRAINT `FK_FRONT_USER_NOTIFY_FU` FOREIGN KEY (`user_id`) REFERENCES `xcms_front_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='信息通知设置，设置用户想要接收的通知类型';

-- ----------------------------
-- Records of xcms_notification_settings
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_operation_log`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_operation_log`;
CREATE TABLE `xcms_operation_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) NOT NULL,
  `controller` varchar(30) NOT NULL,
  `action` varchar(30) NOT NULL,
  `desription` tinytext NOT NULL,
  `time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作日志，用于判断异常行为';

-- ----------------------------
-- Records of xcms_operation_log
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_recharge`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_recharge`;
CREATE TABLE `xcms_recharge` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `sum` int(11) unsigned NOT NULL COMMENT '充值金额，乘以100',
  `fee` int(5) unsigned NOT NULL COMMENT '手续费，乘以100',
  `raise_time` int(11) unsigned NOT NULL COMMENT '订单时间',
  `platform` varchar(255) DEFAULT NULL COMMENT '平台',
  `trade_no` varchar(64) DEFAULT NULL COMMENT '平台订单号',
  `subject` varchar(255) DEFAULT NULL COMMENT '订单名',
  `buyer` varchar(255) DEFAULT NULL COMMENT '平台账号',
  `buyer_id` varchar(255) DEFAULT NULL COMMENT '平台ID',
  `pay_time` int(11) unsigned DEFAULT NULL COMMENT '支付时间',
  `finish_time` int(11) unsigned DEFAULT NULL COMMENT '完成时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-支付创建，1-支付成功，2-支付结束，3-支付关闭',
  PRIMARY KEY (`id`),
  KEY `FK_FRONT_USER_RECHARGE_FU` (`user_id`),
  CONSTRAINT `FK_FRONT_USER_RECHARGE_FU` FOREIGN KEY (`user_id`) REFERENCES `xcms_front_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值记录';

-- ----------------------------
-- Records of xcms_recharge
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_service_qq`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_service_qq`;
CREATE TABLE `xcms_service_qq` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `s_name` varchar(10) NOT NULL,
  `qq` varchar(15) NOT NULL,
  `location` text NOT NULL,
  `status` tinyint(2) DEFAULT NULL COMMENT '客服状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服QQ设置';

-- ----------------------------
-- Records of xcms_service_qq
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_setting`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_setting`;
CREATE TABLE `xcms_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(30) NOT NULL COMMENT '可重复，代表数组',
  `value` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config_name` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站设置';

-- ----------------------------
-- Records of xcms_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_user`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_user`;
CREATE TABLE `xcms_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(60) NOT NULL,
  `uuid` varchar(36) DEFAULT NULL,
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为没锁定，1为锁定，默认为0',
  `user_type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_uuid` (`uuid`),
  KEY `user_type` (`user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站用户表';

-- ----------------------------
-- Records of xcms_user
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_user_group`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_user_group`;
CREATE TABLE `xcms_user_group` (
  `user_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `FK_GROUP_USER_G` (`group_id`),
  CONSTRAINT `FK_GROUP_USER_G` FOREIGN KEY (`group_id`) REFERENCES `xcms_auth_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_GROUP_USER_U` FOREIGN KEY (`user_id`) REFERENCES `xcms_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户用户组关联表';

-- ----------------------------
-- Records of xcms_user_group
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_user_role`;
CREATE TABLE `xcms_user_role` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `FK_USER_ROLE_R` (`role_id`),
  CONSTRAINT `FK_USER_ROLE_R` FOREIGN KEY (`role_id`) REFERENCES `xcms_auth_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_USER_ROLE_U` FOREIGN KEY (`user_id`) REFERENCES `xcms_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色关联表';

-- ----------------------------
-- Records of xcms_user_role
-- ----------------------------

-- ----------------------------
-- Table structure for `xcms_withdraw`
-- ----------------------------
DROP TABLE IF EXISTS `xcms_withdraw`;
CREATE TABLE `xcms_withdraw` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `sum` int(11) unsigned NOT NULL COMMENT '提现金额，乘以100',
  `raise_time` int(11) unsigned NOT NULL,
  `fee` int(5) unsigned NOT NULL,
  `finish_time` int(10) unsigned DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-正在处理，1-成功',
  PRIMARY KEY (`id`),
  KEY `FK_FRONT_USER_WITHDRAW_FU` (`user_id`),
  CONSTRAINT `FK_FRONT_USER_WITHDRAW_FU` FOREIGN KEY (`user_id`) REFERENCES `xcms_front_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现记录';

-- ----------------------------
-- Records of xcms_withdraw
-- ----------------------------
