/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2013/11/19 12:39:52                          */
/*==============================================================*/


/*==============================================================*/
/* Table: xcms_ad_banner                                        */
/*==============================================================*/
create table xcms_ad_banner
(
   id                   int(11) unsigned not null auto_increment,
   is_using             tinyint(1) not null default 0 comment '是否在使用，0-否，1-是',
   list_order           int(11) unsigned not null default 0 comment '显示顺序，默认为0',
   path                 text not null,
   add_time             int(11) not null,
   banner_type          tinyint(2) not null comment '0-网站，1-app',
   primary key (id)
);

alter table xcms_ad_banner comment '首页广告banner';

/*==============================================================*/
/* Table: xcms_area                                             */
/*==============================================================*/
create table xcms_area
(
   id                   int(11) unsigned not null auto_increment,
   fid                  int(11) unsigned not null,
   level2               int(11) unsigned not null,
   lft                  int(11) unsigned not null,
   rgt                  int(11) unsigned not null,
   area_name            varchar(20) not null,
   primary key (id)
);

alter table xcms_area comment '地区';

/*==============================================================*/
/* Table: xcms_article                                          */
/*==============================================================*/
create table xcms_article
(
   id                   int(11) unsigned not null auto_increment,
   title                varchar(20) not null,
   content              text not null,
   add_time             int(11) unsigned not null,
   art_type             tinyint(2) not null comment '文章类型，0-公告，1-帮助文档',
   click                int(11) not null default 0 comment '点击量',
   primary key (id)
);

alter table xcms_article comment '网站公告，帮助文档';

/*==============================================================*/
/* Table: xcms_auth_groups                                      */
/*==============================================================*/
create table xcms_auth_groups
(
   id                   int(11) unsigned not null auto_increment,
   group_name           varchar(50) not null comment '用户组名称',
   description          text comment '用户组描述',
   enabled              tinyint(1) not null default 0 comment '是否禁止使用，0代表开始，1代表禁止，默认为0',
   list_order           int(5) not null default 0 comment '显示顺序，默认为0',
   primary key (id)
);

alter table xcms_auth_groups comment '存放用户组信息';

/*==============================================================*/
/* Table: xcms_auth_roles                                       */
/*==============================================================*/
create table xcms_auth_roles
(
   id                   int(11) unsigned not null auto_increment,
   fid                  int(11) unsigned not null,
   level                int(11) unsigned not null comment '所属的等级',
   lft                  int(11) unsigned not null comment '用于二叉搜索树',
   rgt                  int(11) unsigned not null comment '用于二叉搜索树',
   role_name            varchar(50) not null comment '角色名称',
   description          text comment '角色描述',
   enabled              tinyint(1) not null default 0 comment '是否禁止使用，0表示开启，1表示关闭，默认为0',
   list_order           int(5) not null default 0 comment '显示顺序，默认为0',
   primary key (id)
);

alter table xcms_auth_roles comment '角色';

/*==============================================================*/
/* Table: xcms_auth_group_role                                  */
/*==============================================================*/
create table xcms_auth_group_role
(
   role_id              int(11) unsigned not null,
   group_id             int(11) unsigned not null,
   is_default           tinyint(1) default 1 comment '是否是该用户组的默认角色，0为是，1为否，默认为1',
   primary key (role_id, group_id),
   constraint FK_GROUP_ROLE_G foreign key (group_id)
      references xcms_auth_groups (id) on delete cascade on update cascade,
   constraint FK_GROUP_ROLE_R foreign key (role_id)
      references xcms_auth_roles (id) on delete cascade on update cascade
);

alter table xcms_auth_group_role comment '关联用户组和角色';

/*==============================================================*/
/* Table: xcms_auth_mutex                                       */
/*==============================================================*/
create table xcms_auth_mutex
(
   role1                int(11) unsigned not null,
   role2                int(11) unsigned not null,
   description          text,
   primary key (role1, role2),
   constraint FK_ROLE_MUTEX_R1 foreign key (role1)
      references xcms_auth_roles (id) on delete cascade on update cascade,
   constraint FK_ROLE_MUTEX_R2 foreign key (role2)
      references xcms_auth_roles (id) on delete cascade on update cascade
);

alter table xcms_auth_mutex comment '角色互斥';

/*==============================================================*/
/* Table: xcms_auth_operation                                   */
/*==============================================================*/
create table xcms_auth_operation
(
   id                   int(11) unsigned not null auto_increment,
   fid                  int(11) unsigned not null,
   level2               int(11) unsigned not null,
   lft                  int(11) unsigned not null comment '用于二叉搜索树',
   rgt                  int(11) unsigned not null comment '用于二叉搜索树',
   operation_name       varchar(20) not null,
   description          text,
   module               varchar(30),
   controller           varchar(30) not null,
   action               varchar(30) not null,
   enabled              tinyint(1) not null default 0 comment '是否禁止使用，0表示开启，1表示关闭，默认为0',
   list_order           int(5) not null default 0 comment '显示顺序，默认为0',
   primary key (id)
);

alter table xcms_auth_operation comment '操作';

/*==============================================================*/
/* Index: unique_module_controller_action                       */
/*==============================================================*/
create unique index unique_module_controller_action on xcms_auth_operation
(
   module,
   controller,
   action
);

/*==============================================================*/
/* Table: xcms_auth_resource                                    */
/*==============================================================*/
create table xcms_auth_resource
(
   id                   int(11) unsigned not null auto_increment,
   resource_name        varchar(50) not null,
   description          text,
   r_type               varchar(20) not null comment '资源作为父类，r_type表示该资源的子类类型',
   primary key (id)
);

alter table xcms_auth_resource comment '资源';

/*==============================================================*/
/* Table: xcms_auth_permission                                  */
/*==============================================================*/
create table xcms_auth_permission
(
   id                   int(11) unsigned not null auto_increment,
   operation_id         int(11) unsigned not null,
   resource_id          int(11) unsigned default NULL comment '权限管理的资源，可以为NULL',
   permission_name      varchar(20) not null,
   description          text default NULL comment '权限描述，默认为空',
   primary key (id),
   constraint FK_PERMISSION_OPERATION_RESOURCE_O foreign key (operation_id)
      references xcms_auth_operation (id) on delete cascade on update cascade,
   constraint FK_PERMISSION_OPERATION_RESOURCE_R foreign key (resource_id)
      references xcms_auth_resource (id) on delete cascade on update cascade
);

alter table xcms_auth_permission comment '权限=操作[+资源]';

/*==============================================================*/
/* Index: unique_operation_resource                             */
/*==============================================================*/
create unique index unique_operation_resource on xcms_auth_permission
(
   resource_id,
   operation_id
);

/*==============================================================*/
/* Table: xcms_auth_protected_file                              */
/*==============================================================*/
create table xcms_auth_protected_file
(
   id                   int(11) unsigned not null,
   path                 text not null,
   is_dir               tinyint(1) not null comment '是否为目录，0-是，1-否',
   primary key (id),
   constraint FK_REOUSRCE_PROTECTED_FILE_F foreign key (id)
      references xcms_auth_resource (id) on delete cascade on update cascade
);

alter table xcms_auth_protected_file comment '控制文件系统中文件访问权限。继承自资源';

/*==============================================================*/
/* Table: xcms_auth_protected_table                             */
/*==============================================================*/
create table xcms_auth_protected_table
(
   id                   int(11) unsigned not null,
   table_name           varchar(30) not null,
   field_name           varchar(20) default NULL comment '受控数据表内字段，可为空',
   description          text,
   primary key (id),
   constraint FK_RESOURCE_PROTECTED_RESOURCE_P foreign key (id)
      references xcms_auth_resource (id) on delete cascade on update cascade
);

alter table xcms_auth_protected_table comment '受到保护的数据表，字段。继承自资源';

/*==============================================================*/
/* Index: unique_table_field_resource_type                      */
/*==============================================================*/
create unique index unique_table_field_resource_type on xcms_auth_protected_table
(
   table_name,
   field_name
);

/*==============================================================*/
/* Index: resource_type                                         */
/*==============================================================*/
create index resource_type on xcms_auth_resource
(
   r_type
);

/*==============================================================*/
/* Table: xcms_auth_role_permission                             */
/*==============================================================*/
create table xcms_auth_role_permission
(
   role_id              int(11) unsigned not null,
   permission_id        int(11) unsigned not null,
   is_default           tinyint(1) default 1 comment '是否是该角色的默认权限，0为是，1为否，默认为1',
   primary key (role_id, permission_id),
   constraint FK_ROLE_PERMISSION_R foreign key (role_id)
      references xcms_auth_roles (id) on delete cascade on update cascade,
   constraint FK_ROLE_PERMISSION_P foreign key (permission_id)
      references xcms_auth_permission (id) on delete cascade on update cascade
);

alter table xcms_auth_role_permission comment '关联角色和权限';

/*==============================================================*/
/* Index: role_list_order                                       */
/*==============================================================*/
create index role_list_order on xcms_auth_roles
(
   list_order
);

/*==============================================================*/
/* Table: xcms_user                                             */
/*==============================================================*/
create table xcms_user
(
   id                   int(11) unsigned not null auto_increment,
   password             varchar(60) not null,
   uuid                 varchar(36),
   last_login_time      int(11) unsigned not null default 0,
   last_login_ip        varchar(15) not null default 0,
   locked               tinyint(1) not null default 0 comment '0为没锁定，1为锁定，默认为0',
   user_type            varchar(20) not null,
   primary key (id)
);

alter table xcms_user comment '网站用户表';

/*==============================================================*/
/* Table: xcms_auth_user_permission                             */
/*==============================================================*/
create table xcms_auth_user_permission
(
   permission_id        int(11) unsigned not null,
   user_id              int(11) unsigned not null,
   is_own               tinyint(1) not null comment '用户是否具有这个权限，1代表有，-1代表没有。在权限计算时从总权限中加上或减去这个权限',
   expire               int(11) unsigned not null comment '权限过期的绝对时间',
   primary key (permission_id, user_id),
   constraint FK_USER_PERMISSION_U foreign key (user_id)
      references xcms_user (id) on delete cascade on update cascade,
   constraint FK_USER_PERMISSION_P foreign key (permission_id)
      references xcms_auth_permission (id) on delete cascade on update cascade
);

alter table xcms_auth_user_permission comment '为用户直接赋予或取消某些权限';

/*==============================================================*/
/* Table: xcms_front_user                                       */
/*==============================================================*/
create table xcms_front_user
(
   id                   int(11) unsigned not null,
   pay_password         varchar(60) not null,
   balance              int(11) unsigned not null default 0,
   nickname             varchar(15) not null,
   realname             varchar(10) not null,
   gender               tinyint(1) default NULL comment '0-女，1-男。可为空（保密）',
   age                  int(3) default NULL comment '可为空（保密）',
   mobile               varchar(11) not null comment '手机号码，唯一，可用于登录',
   email                varchar(50) not null comment '邮箱，唯一，用于登录，密码找回，验证',
   address              tinytext default NULL,
   identity_id          varchar(18) not null comment '身份证，唯一',
   bank                 varchar(20) not null,
   role                 varchar(15) not null comment '用户社会角色，字符串，方便阅读',
   credit_acceptable    tinyint(1) not null default 0 comment '用户所属角色的资料是否填写完整，0-否，1-是，修改资料时置0，待审核',
   credit_grade         int(4) not null comment '根据信用资料审核程度得到的分数',
   primary key (id),
   constraint FK_FRONT_BASE_USER_F foreign key (id)
      references xcms_user (id) on delete cascade on update cascade
);

alter table xcms_front_user comment '前台用户，继承自网站用户';

/*==============================================================*/
/* Table: xcms_bid                                              */
/*==============================================================*/
create table xcms_bid
(
   id                   int(11) unsigned not null auto_increment,
   user_id              int(11) unsigned not null,
   title                varchar(50) not null,
   description          text not null,
   sum                  int(11) unsigned not null comment '金额乘以100',
   month_rate           int(5) unsigned not null comment '还款月利率，乘以100',
   start                int(11) unsigned not null comment '招标开始日期',
   end                  int(11) unsigned not null comment '招标结束日期',
   deadline             int(11) unsigned not null comment '借款结束日期，绝对时间',
   progress             int(5) unsigned not null default 0 comment '进度乘以100，默认为0',
   verify_pregress      tinyint(1) unsigned not null default 0 comment '审核进度，0-审核中，1-通过，2-未通过',
   failed_description   tinytext comment '审核失败原因',
   primary key (id),
   constraint FK_FRONT_USER_BID_FU foreign key (user_id)
      references xcms_front_user (id) on delete cascade on update cascade
);

alter table xcms_bid comment '标段信息';

/*==============================================================*/
/* Table: xcms_bid_meta                                         */
/*==============================================================*/
create table xcms_bid_meta
(
   id                   int(11) unsigned not null auto_increment,
   user_id              int(11) unsigned not null,
   bid_id               int(11) unsigned not null,
   sum                  int(11) unsigned not null comment '购买金额，乘以100',
   buy_time             int(11) unsigned not null,
   primary key (id),
   constraint FK_FRONT_USER_BID_META_FU foreign key (user_id)
      references xcms_front_user (id) on delete cascade on update cascade,
   constraint FK_FRONT_USER_BID_META_BM foreign key (bid_id)
      references xcms_bid (id) on delete cascade on update cascade
);

alter table xcms_bid_meta comment '标段购买信息';

/*==============================================================*/
/* Table: xcms_credit_grade_settings                            */
/*==============================================================*/
create table xcms_credit_grade_settings
(
   id                   int(11) unsigned not null auto_increment,
   level                int(3) not null comment '等级',
   start                int(4) not null comment '起始分数',
   end                  int(4) not null comment '结束分数',
   on_recharge          int(5) unsigned not null comment '充值',
   on_withdraw          int(5) unsigned not null comment '提现',
   on_pay_back          int(5) unsigned not null comment '还款',
   on_over6             int(5) unsigned not null comment '借款大于6月',
   on_below6            int(5) unsigned not null comment '借款小于6月',
   on_loan              int(5) unsigned not null comment '标段利息的利润',
   loanable             tinyint(1) not null comment '该等级能否借款，0-否，1-是',
   primary key (id)
);

alter table xcms_credit_grade_settings comment '信用积分等级配置';

/*==============================================================*/
/* Table: xcms_credit_settings                                  */
/*==============================================================*/
create table xcms_credit_settings
(
   id                   int(11) unsigned not null auto_increment,
   verification_name    varchar(10) not null,
   description          text not null,
   verification_type    varchar(30) not null comment '信息的类型，如text-文字，image-图片',
   primary key (id)
);

alter table xcms_credit_settings comment '信用验证内容，包含内容的类型，如图片、文字';

/*==============================================================*/
/* Table: xcms_credit_role                                      */
/*==============================================================*/
create table xcms_credit_role
(
   id                   int(11) unsigned not null auto_increment,
   role                 varchar(15) not null,
   verification_id      int(11) unsigned not null,
   optional             tinyint(1) not null default 0 comment '该信用选项是否可以不写，0-否，1-是，默认为0',
   grade                int(5) not null,
   primary key (id),
   constraint FK_CREDIT_ROL_R foreign key (verification_id)
      references xcms_credit_settings (id) on delete restrict on update restrict
);

alter table xcms_credit_role comment '社会角色的信用配置，包括每种角色需要填写的资料，每种资料的加分';

/*==============================================================*/
/* Index: xcms_credit_role                                      */
/*==============================================================*/
create index xcms_credit_role on xcms_credit_role
(
   role
);

/*==============================================================*/
/* Table: xcms_front_credit                                     */
/*==============================================================*/
create table xcms_front_credit
(
   id                   int(11) unsigned not null auto_increment,
   user_id              int(11) unsigned not null,
   verification_id      int(11) unsigned not null,
   content              text not null comment '提交内容可以是文字或是URL',
   submit_time          int(11) not null,
   status               tinyint(2) not null comment '审核状态，0-待审，1-通过，2-失败',
   description          tinytext default NULL comment '未通过审核时，可以填写原因',
   primary key (id),
   constraint FK_FRONT_USER_CREDIT_FU foreign key (user_id)
      references xcms_front_user (id) on delete cascade on update cascade,
   constraint FK_FRONT_USER_CREDIT_C foreign key (verification_id)
      references xcms_credit_settings (id) on delete cascade on update cascade
);

alter table xcms_front_credit comment '用户提交的信用资料，包含每条资料的审核状态';

/*==============================================================*/
/* Index: front_user_mobile                                     */
/*==============================================================*/
create unique index front_user_mobile on xcms_front_user
(
   mobile
);

/*==============================================================*/
/* Index: front_user_email                                      */
/*==============================================================*/
create unique index front_user_email on xcms_front_user
(
   email
);

/*==============================================================*/
/* Index: Index_3                                               */
/*==============================================================*/
create unique index Index_3 on xcms_front_user
(
   identity_id
);

/*==============================================================*/
/* Index: front_user_role                                       */
/*==============================================================*/
create index front_user_role on xcms_front_user
(
   role
);

/*==============================================================*/
/* Table: xcms_front_user_icon                                  */
/*==============================================================*/
create table xcms_front_user_icon
(
   id                   int(11) unsigned not null auto_increment,
   user_id              int(11) unsigned not null,
   path                 text not null,
   size                 varchar(15) default NULL comment '头像尺寸（长宽），默认为null，表示使用程序定义的默认尺寸',
   file_size            int(5) not null comment '文件大小，单位Byte',
   in_using             tinyint(1) not null default 0 comment '是否正在使用，0-否，1-是，默认为0',
   primary key (id),
   constraint FK_FRONT_USER_ICON_I foreign key (user_id)
      references xcms_front_user (id) on update cascade
);

alter table xcms_front_user_icon comment '用户头像，一个用户可以有多个头像和一个正在使用的头像';

/*==============================================================*/
/* Table: xcms_front_user_message_board                         */
/*==============================================================*/
create table xcms_front_user_message_board
(
   id                   int(11) unsigned not null auto_increment,
   user_id              int(11) unsigned not null,
   title                varchar(20) not null,
   content              text not null,
   add_time             int(11) unsigned not null,
   reply_status         tinyint(1) not null comment '回复状态，0-未回复，1-已回复',
   reply_content        text,
   reply_time           int(11) unsigned,
   primary key (id),
   constraint FK_FRONT_USER_MSG_BOARD_FU foreign key (user_id)
      references xcms_front_user (id) on delete cascade on update cascade
);

alter table xcms_front_user_message_board comment '用户提问、留言板';

/*==============================================================*/
/* Table: xcms_fund                                             */
/*==============================================================*/
create table xcms_fund
(
   id                   int(11) unsigned not null auto_increment,
   log_name_cn          varchar(10) not null,
   log_name_en          varchar(20) not null,
   value                int(11) unsigned not null comment '资金值，乘以100',
   primary key (id)
);

alter table xcms_fund comment '资金记录信息，用于简单记录资金总和，如网站所有金额';

/*==============================================================*/
/* Index: fund_name_en                                          */
/*==============================================================*/
create unique index fund_name_en on xcms_fund
(
   log_name_en
);

/*==============================================================*/
/* Table: xcms_fund_flow_internal                               */
/*==============================================================*/
create table xcms_fund_flow_internal
(
   id                   int(11) unsigned not null auto_increment,
   to_user              int(11) unsigned not null,
   from_user            int(11) unsigned not null,
   sum                  int(11) unsigned not null comment '流动金额，乘以100',
   time                 int(11) unsigned not null,
   fee                  int(5) unsigned not null comment '手续费，乘以100',
   status               tinyint(1) not null default 0 comment '0-正在处理，1-成功',
   primary key (id),
   constraint FK_FRONT_USER_FROM_FUND_FLOW_FUF foreign key (from_user)
      references xcms_front_user (id) on delete cascade on update cascade,
   constraint FK_FRONT_USER_FUND_FLOW_FUT foreign key (to_user)
      references xcms_front_user (id) on delete cascade on update cascade
);

alter table xcms_fund_flow_internal comment '站内用户资金流动记录';

/*==============================================================*/
/* Table: xcms_message                                          */
/*==============================================================*/
create table xcms_message
(
   id                   int(11) unsigned not null auto_increment,
   user_id              int(11) unsigned not null,
   title                varchar(20) not null,
   content              text not null,
   time                 int(11) unsigned not null,
   via                  tinyint(2) not null comment '0-所以路径，1-邮件，2-短信，3-站内信',
   status               tinyint(1) not null default 0 comment '0-发送中，1-未读，2-已读，3-发送失败',
   primary key (id),
   constraint FK_FRONT_USER_MESSAGE_FU foreign key (user_id)
      references xcms_front_user (id) on delete cascade on update cascade
);

alter table xcms_message comment '网站消息';

/*==============================================================*/
/* Table: xcms_notification_settings                            */
/*==============================================================*/
create table xcms_notification_settings
(
   id                   int(11) unsigned not null auto_increment,
   user_id              int(11) unsigned not null,
   email                tinyint(1) not null default 1 comment '0-否，1-是，默认，1',
   sms                  tinyint(1) not null default 1 comment '0-否，1-是，默认1',
   internal             tinyint(1) not null default 1 comment '0-否，1-是，默认1',
   primary key (id),
   constraint FK_FRONT_USER_NOTIFY_FU foreign key (user_id)
      references xcms_front_user (id) on delete cascade on update cascade
);

alter table xcms_notification_settings comment '信息通知设置，设置用户想要接收的通知类型';

/*==============================================================*/
/* Table: xcms_operation_log                                    */
/*==============================================================*/
create table xcms_operation_log
(
   id                   int(11) unsigned not null auto_increment,
   module               varchar(30) not null,
   controller           varchar(30) not null,
   action               varchar(30) not null,
   desription           tinytext not null,
   time                 int(11) unsigned not null,
   primary key (id)
);

alter table xcms_operation_log comment '操作日志，用于判断异常行为';

/*==============================================================*/
/* Table: xcms_recharge                                         */
/*==============================================================*/
create table xcms_recharge
(
   id                   int(11) unsigned not null auto_increment,
   user_id              int(11) unsigned not null,
   sum                  int(11) unsigned not null comment '充值金额，乘以100',
   time                 int(11) unsigned not null,
   serial_number        varchar(64) not null,
   fee                  int(5) unsigned not null comment '手续费，乘以100',
   status               tinyint(1) not null default 0 comment '0-正在处理，1-成功',
   primary key (id),
   constraint FK_FRONT_USER_RECHARGE_FU foreign key (user_id)
      references xcms_front_user (id) on delete cascade on update cascade
);

alter table xcms_recharge comment '充值记录';

/*==============================================================*/
/* Table: xcms_service_qq                                       */
/*==============================================================*/
create table xcms_service_qq
(
   id                   int(11) unsigned not null auto_increment,
   s_name               varchar(10) not null,
   qq                   varchar(15) not null,
   location             text not null,
   status               tinyint(2) comment '客服状态',
   primary key (id)
);

alter table xcms_service_qq comment '客服QQ设置';

/*==============================================================*/
/* Table: xcms_setting                                          */
/*==============================================================*/
create table xcms_setting
(
   id                   int(11) unsigned not null auto_increment,
   setting_key          varchar(30) not null comment '可重复，代表数组',
   value                varchar(30) not null,
   primary key (id)
);

alter table xcms_setting comment '网站设置';

/*==============================================================*/
/* Index: config_name                                           */
/*==============================================================*/
create unique index config_name on xcms_setting
(
   setting_key
);

/*==============================================================*/
/* Index: user_uuid                                             */
/*==============================================================*/
create unique index user_uuid on xcms_user
(
   uuid
);

/*==============================================================*/
/* Index: user_type                                             */
/*==============================================================*/
create index user_type on xcms_user
(
   user_type
);

/*==============================================================*/
/* Table: xcms_user_group                                       */
/*==============================================================*/
create table xcms_user_group
(
   user_id              int(11) unsigned not null,
   group_id             int(11) unsigned not null,
   primary key (user_id, group_id),
   constraint FK_GROUP_USER_U foreign key (user_id)
      references xcms_user (id) on delete cascade on update cascade,
   constraint FK_GROUP_USER_G foreign key (group_id)
      references xcms_auth_groups (id) on delete cascade on update cascade
);

alter table xcms_user_group comment '用户用户组关联表';

/*==============================================================*/
/* Table: xcms_user_role                                        */
/*==============================================================*/
create table xcms_user_role
(
   user_id              int(11) unsigned not null,
   role_id              int(11) unsigned not null,
   primary key (user_id, role_id),
   constraint FK_USER_ROLE_U foreign key (user_id)
      references xcms_user (id) on delete cascade on update cascade,
   constraint FK_USER_ROLE_R foreign key (role_id)
      references xcms_auth_roles (id) on delete cascade on update cascade
);

alter table xcms_user_role comment '用户角色关联表';

/*==============================================================*/
/* Table: xcms_withdraw                                         */
/*==============================================================*/
create table xcms_withdraw
(
   id                   int(11) unsigned not null auto_increment,
   user_id              int(11) unsigned not null,
   sum                  int(11) unsigned not null comment '提现金额，乘以100',
   time                 int(11) unsigned not null,
   fee                  int(5) unsigned not null,
   status               tinyint(1) not null default 0 comment '0-正在处理，1-成功',
   primary key (id),
   constraint FK_FRONT_USER_WITHDRAW_FU foreign key (user_id)
      references xcms_front_user (id) on delete cascade on update cascade
);

alter table xcms_withdraw comment '提现记录';

