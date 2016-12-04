/*
Navicat MySQL Data Transfer

Source Server         : mulhealth
Source Server Version : 50629
Source Host           : 121.43.96.68:3306
Source Database       : dy

Target Server Type    : MYSQL
Target Server Version : 50629
File Encoding         : 65001

Date: 2016-11-30 17:40:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_admin
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin`;
CREATE TABLE `tb_admin` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '登录帐号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '备用字段',
  `authKey` char(200) NOT NULL DEFAULT '' COMMENT '密码',
  `accessToken` char(200) NOT NULL DEFAULT '' COMMENT '备用',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '昵称',
  `thumb` varchar(225) NOT NULL DEFAULT '' COMMENT '头像，备用字段',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱，备用字段',
  `status` smallint(4) NOT NULL DEFAULT '1' COMMENT '状态 1正常，0禁用户',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `role_id` mediumint(11) unsigned NOT NULL DEFAULT '1' COMMENT '权限分组',
  `company_id` smallint(4) unsigned DEFAULT '0' COMMENT '公司ID',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_admin
-- ----------------------------
INSERT INTO `tb_admin` VALUES ('1', 'admin', '5d4dcaaedbdac33ee7f6c68249814bfb', 'test100key', '100-token', '管理员', '/avatar/1422621856.jpg', 'admin@vsochina.com', '1', '0', '0', '1', '5');
INSERT INTO `tb_admin` VALUES ('2', 'huangbo', '67a212628f7195d1c63bc4f4600d5aa5', '', '', '黄波', '', '2@qq.com', '1', '0', '0', '1', '2');
INSERT INTO `tb_admin` VALUES ('6', 'Vincent', '2b2af08c09f1de8e69377c03dfb7e794', '', '', '李明', '', 'test@tempires.com', '1', '0', '0', '9', '1');
INSERT INTO `tb_admin` VALUES ('7', 'sumiao', 'b15c68d292143b3077a7696dbcde7231', '', '', '速秒社区', '', '482658', '1', '0', '0', '1', '0');

-- ----------------------------
-- Table structure for tb_cases
-- ----------------------------
DROP TABLE IF EXISTS `tb_cases`;
CREATE TABLE `tb_cases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '案例ID',
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '标题',
  `pic` varchar(1000) NOT NULL DEFAULT '' COMMENT '案例图片',
  `detail` text NOT NULL COMMENT '案例描述',
  `tags` varchar(150) NOT NULL DEFAULT '' COMMENT '标签',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（1-正常；2-删除）',
  `create_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='产品案例';

-- ----------------------------
-- Records of tb_cases
-- ----------------------------
INSERT INTO `tb_cases` VALUES ('6', '案例', '[\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/ee8e6f864dc1c664833fb2b0bec8c491.jpg\",\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/2d658ea0b878cefb74bdfe4e76f13bb3.jpg\",\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/a1d9c261036cf5574a8be794c96b94cc.jpg\"]', '<p>案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例案例</p>', '商品', '1', '1480054723', '1480056931');

-- ----------------------------
-- Table structure for tb_cell
-- ----------------------------
DROP TABLE IF EXISTS `tb_cell`;
CREATE TABLE `tb_cell` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '细胞培养ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `pics` text NOT NULL COMMENT '细胞培养图片',
  `create_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='细胞培养';

-- ----------------------------
-- Records of tb_cell
-- ----------------------------

-- ----------------------------
-- Table structure for tb_comment
-- ----------------------------
DROP TABLE IF EXISTS `tb_comment`;
CREATE TABLE `tb_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论父ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论者用户ID',
  `pics` mediumtext NOT NULL COMMENT '评论图片',
  `content` text NOT NULL COMMENT '评论内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（1-正常；2-删除）',
  `create_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='评论表';

-- ----------------------------
-- Records of tb_comment
-- ----------------------------
INSERT INTO `tb_comment` VALUES ('1', '0', '0', '', '12212121', '1', '1480345642', '1480345642');
INSERT INTO `tb_comment` VALUES ('2', '0', '0', '', '12212121323223', '1', '1480345697', '1480345697');
INSERT INTO `tb_comment` VALUES ('3', '0', '0', '', 'ddd', '1', '1480345797', '1480345797');
INSERT INTO `tb_comment` VALUES ('4', '0', '0', '', 'fff', '1', '1480345846', '1480345846');
INSERT INTO `tb_comment` VALUES ('5', '0', '13', '', '12', '1', '1480345872', '1480345872');
INSERT INTO `tb_comment` VALUES ('6', '0', '13', '[\"http:\\/\\/www.mulhealth.com\\/upload\\/comment\\/2016\\/11\\/28\\/0cf1bbf553686ca5f7d71022a300b58a.jpg\",\"http:\\/\\/www.mulhealth.com\\/upload\\/comment\\/2016\\/11\\/28\\/3b786ecaf8c5b6e5229eabe8a2883c5e.jpg\"]', '黄波', '1', '1480347194', '1480347194');
INSERT INTO `tb_comment` VALUES ('7', '0', '13', '', 'ttt', '1', '1480348580', '1480348580');

-- ----------------------------
-- Table structure for tb_comment_like
-- ----------------------------
DROP TABLE IF EXISTS `tb_comment_like`;
CREATE TABLE `tb_comment_like` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '点赞ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞人用户ID',
  `cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论ID',
  `create_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `cid` (`cid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='评论点赞表';

-- ----------------------------
-- Records of tb_comment_like
-- ----------------------------

-- ----------------------------
-- Table structure for tb_knowledge
-- ----------------------------
DROP TABLE IF EXISTS `tb_knowledge`;
CREATE TABLE `tb_knowledge` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '知识ID',
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '标题',
  `pic` varchar(1000) NOT NULL DEFAULT '' COMMENT '知识图片',
  `detail` text NOT NULL COMMENT '知识描述',
  `tags` varchar(150) NOT NULL DEFAULT '' COMMENT '标签',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（1-正常；2-删除）',
  `create_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='产品知识';

-- ----------------------------
-- Records of tb_knowledge
-- ----------------------------
INSERT INTO `tb_knowledge` VALUES ('2', '知识', '[\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/62d91586fa7ef5753d9f507f7b10296a.jpg\"]', '<p>知识知识<br/></p><p>知识知识<br/></p><p>知识知识<br/></p><p><br/></p>', '测试;商品', '1', '1480054789', '1480056370');
INSERT INTO `tb_knowledge` VALUES ('3', '知识2', '[\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/297a7e9e98096ea8d5352d0f46cb0c62.jpg\",\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/a366a535dceeb4caa9c3f7d71ac158c5.jpg\",\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/6f3c0827763dc1ca9347959c0517152b.jpg\"]', '<p>2121122112<br/></p>', '知识;12', '1', '1480057441', '1480057457');

-- ----------------------------
-- Table structure for tb_meta
-- ----------------------------
DROP TABLE IF EXISTS `tb_meta`;
CREATE TABLE `tb_meta` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT COMMENT '公司介绍ID',
  `key` varchar(100) NOT NULL DEFAULT '' COMMENT '扩展字段key',
  `value` text NOT NULL COMMENT '扩展字段值',
  `create_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='扩展信息表';

-- ----------------------------
-- Records of tb_meta
-- ----------------------------

-- ----------------------------
-- Table structure for tb_privilege
-- ----------------------------
DROP TABLE IF EXISTS `tb_privilege`;
CREATE TABLE `tb_privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grouptype` smallint(4) unsigned DEFAULT '1' COMMENT '所属权限分组(1系统内置模块 2自定义模块)',
  `route` varchar(225) NOT NULL COMMENT '权限路由地址',
  `desc` varchar(255) NOT NULL COMMENT '权限路由描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_privilege
-- ----------------------------
INSERT INTO `tb_privilege` VALUES ('1', '1', 'team/team/list', '团队列表');
INSERT INTO `tb_privilege` VALUES ('2', '1', 'team/team/add', '添加成员');
INSERT INTO `tb_privilege` VALUES ('3', '1', 'team/team/update', '编辑成员');
INSERT INTO `tb_privilege` VALUES ('4', '1', 'team/team/del', '删除成员');
INSERT INTO `tb_privilege` VALUES ('5', '1', 'team/role/list', '角色列表');
INSERT INTO `tb_privilege` VALUES ('6', '1', 'team/role/add', '添加角色');
INSERT INTO `tb_privilege` VALUES ('7', '1', 'team/role/update', '编辑角色');
INSERT INTO `tb_privilege` VALUES ('8', '1', 'team/role/del', '删除角色');
INSERT INTO `tb_privilege` VALUES ('9', '1', 'team/role/review', '角色预览');
INSERT INTO `tb_privilege` VALUES ('10', '1', 'team/privilege/list', '权限路由');
INSERT INTO `tb_privilege` VALUES ('11', '1', 'team/privilege/add', '添加权限');
INSERT INTO `tb_privilege` VALUES ('12', '1', 'team/privilege/update', '编辑权限');
INSERT INTO `tb_privilege` VALUES ('13', '1', 'team/privilege/del', '删除权限节点');
INSERT INTO `tb_privilege` VALUES ('14', '1', 'team/privilege/review', '权限预览');
INSERT INTO `tb_privilege` VALUES ('15', '2', 'user/usr/list', '用户列表数据');
INSERT INTO `tb_privilege` VALUES ('16', '2', 'user/usr/list-view', '用户列表页面');
INSERT INTO `tb_privilege` VALUES ('17', '2', 'user/usr/export', '用户搜索结果导出');
INSERT INTO `tb_privilege` VALUES ('18', '2', 'vip/group/list', '特权列表数据');
INSERT INTO `tb_privilege` VALUES ('19', '2', 'vip/group/list-view', '特权列表页面');
INSERT INTO `tb_privilege` VALUES ('20', '2', 'vip/group/update', '特权数据更新');
INSERT INTO `tb_privilege` VALUES ('21', '2', 'vip/group/view', '特权数据查看');
INSERT INTO `tb_privilege` VALUES ('22', '2', 'vip/group/edit', '特权数据增加/修改');
INSERT INTO `tb_privilege` VALUES ('23', '2', 'vip/vip/list-info', '会员配置-会员录入');
INSERT INTO `tb_privilege` VALUES ('24', '2', 'vip/vip/list-finance', '会员配置-财务审核');
INSERT INTO `tb_privilege` VALUES ('25', '2', 'vip/vip/list-operate', '会员配置-运营审核');
INSERT INTO `tb_privilege` VALUES ('26', '2', 'vip/vip/list', '会员配置-会员列表');

-- ----------------------------
-- Table structure for tb_privilege_group
-- ----------------------------
DROP TABLE IF EXISTS `tb_privilege_group`;
CREATE TABLE `tb_privilege_group` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(20) NOT NULL DEFAULT '' COMMENT '分组名称',
  `grouptype` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '分组属性',
  `groupdesc` varchar(100) NOT NULL DEFAULT '' COMMENT '分组描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='权限分组';

-- ----------------------------
-- Records of tb_privilege_group
-- ----------------------------
INSERT INTO `tb_privilege_group` VALUES ('1', '权限管理', '2', '超级管理员权限，用于权限管理，分配');
INSERT INTO `tb_privilege_group` VALUES ('2', '会员配置', '1', '会员中心权限相关');

-- ----------------------------
-- Table structure for tb_project
-- ----------------------------
DROP TABLE IF EXISTS `tb_project`;
CREATE TABLE `tb_project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目ID',
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '标题',
  `pic` varchar(1000) NOT NULL DEFAULT '' COMMENT '项目图片',
  `detail` text NOT NULL COMMENT '项目描述',
  `tags` varchar(150) NOT NULL DEFAULT '' COMMENT '标签',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（1-正常；2-删除）',
  `create_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='产品项目';

-- ----------------------------
-- Records of tb_project
-- ----------------------------
INSERT INTO `tb_project` VALUES ('3', '图片', '[\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/fb6d7c13411efb6310b82299332f7c31.jpg\",\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/f79c7ddc515dfe2918f264cd4dec05b7.jpg\",\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/073cad153cba57c13dc9b3a716ea997d.jpg\"]', '<p>121221<br/></p>', '测试;12', '1', '1480041449', '1480041449');
INSERT INTO `tb_project` VALUES ('4', '测试', '[\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/39aec669e9ca3ddda17e910e953154b5.jpg\",\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/c232d990c1840d9198340a180fbbbc93.jpg\",\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/5acfbdc73b39c1cfcce99c936097dffc.jpg\"]', '<p>测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试</p><p><br/></p><p>测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试</p><p><br/></p><p><br/></p>', '案例;测试;项目', '1', '1480053634', '1480056796');
INSERT INTO `tb_project` VALUES ('5', '项目2', '[\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/35de7ae677354c58d05d70508b04eaf3.jpg\",\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/7a01e3b940617ff31478610c962c3f5d.jpg\"]', '<p>122121211212<br/></p>', '商品', '1', '1480057532', '1480057869');
INSERT INTO `tb_project` VALUES ('6', '忏悔', '[\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/80ead3935d7ae1a9176923b6558031c7.jpg\",\"http:\\/\\/www.mulhealth_back.com\\/upload\\/case\\/2016\\/11\\/25\\/54681a01571a348a6b80e002037f79ad.jpg\"]', '<p>21212<br/></p>', '项目', '1', '1480060399', '1480060399');

-- ----------------------------
-- Table structure for tb_report
-- ----------------------------
DROP TABLE IF EXISTS `tb_report`;
CREATE TABLE `tb_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '报告编号',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `pic` varchar(250) NOT NULL DEFAULT '' COMMENT '体检报告图',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '体检时间',
  `weight` decimal(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '体重（公斤）',
  `height` decimal(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '身高（cm）',
  `systolic` decimal(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '收缩压（mnHg）',
  `diastolic` decimal(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '舒张压（mnHg）',
  `heartrate` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '心率（次/分）',
  `bmi` decimal(4,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '体重指数',
  `vision` decimal(4,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '视力',
  `create_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='健康报告';

-- ----------------------------
-- Records of tb_report
-- ----------------------------

-- ----------------------------
-- Table structure for tb_role
-- ----------------------------
DROP TABLE IF EXISTS `tb_role`;
CREATE TABLE `tb_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(225) NOT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_role
-- ----------------------------
INSERT INTO `tb_role` VALUES ('1', 'admin', '超级管理员');
INSERT INTO `tb_role` VALUES ('2', '管理员', '管理员，超级管理员之下');
INSERT INTO `tb_role` VALUES ('9', '运营管理员', '负责普通的运营，管理员之下');

-- ----------------------------
-- Table structure for tb_role_privilege
-- ----------------------------
DROP TABLE IF EXISTS `tb_role_privilege`;
CREATE TABLE `tb_role_privilege` (
  `role_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_role_privilege
-- ----------------------------
INSERT INTO `tb_role_privilege` VALUES ('1', '1');
INSERT INTO `tb_role_privilege` VALUES ('1', '2');
INSERT INTO `tb_role_privilege` VALUES ('1', '3');
INSERT INTO `tb_role_privilege` VALUES ('1', '4');
INSERT INTO `tb_role_privilege` VALUES ('1', '5');
INSERT INTO `tb_role_privilege` VALUES ('1', '6');
INSERT INTO `tb_role_privilege` VALUES ('1', '7');
INSERT INTO `tb_role_privilege` VALUES ('1', '8');
INSERT INTO `tb_role_privilege` VALUES ('1', '9');
INSERT INTO `tb_role_privilege` VALUES ('1', '10');
INSERT INTO `tb_role_privilege` VALUES ('1', '11');
INSERT INTO `tb_role_privilege` VALUES ('1', '12');
INSERT INTO `tb_role_privilege` VALUES ('1', '13');
INSERT INTO `tb_role_privilege` VALUES ('1', '14');
INSERT INTO `tb_role_privilege` VALUES ('1', '15');
INSERT INTO `tb_role_privilege` VALUES ('1', '16');
INSERT INTO `tb_role_privilege` VALUES ('1', '17');
INSERT INTO `tb_role_privilege` VALUES ('1', '18');
INSERT INTO `tb_role_privilege` VALUES ('1', '19');
INSERT INTO `tb_role_privilege` VALUES ('1', '20');
INSERT INTO `tb_role_privilege` VALUES ('1', '21');
INSERT INTO `tb_role_privilege` VALUES ('1', '22');
INSERT INTO `tb_role_privilege` VALUES ('1', '23');
INSERT INTO `tb_role_privilege` VALUES ('1', '24');
INSERT INTO `tb_role_privilege` VALUES ('1', '25');
INSERT INTO `tb_role_privilege` VALUES ('1', '26');
INSERT INTO `tb_role_privilege` VALUES ('7', '15');
INSERT INTO `tb_role_privilege` VALUES ('7', '16');
INSERT INTO `tb_role_privilege` VALUES ('7', '17');
INSERT INTO `tb_role_privilege` VALUES ('7', '18');
INSERT INTO `tb_role_privilege` VALUES ('7', '19');
INSERT INTO `tb_role_privilege` VALUES ('7', '20');
INSERT INTO `tb_role_privilege` VALUES ('7', '21');
INSERT INTO `tb_role_privilege` VALUES ('7', '22');
INSERT INTO `tb_role_privilege` VALUES ('7', '24');
INSERT INTO `tb_role_privilege` VALUES ('7', '26');
INSERT INTO `tb_role_privilege` VALUES ('8', '15');
INSERT INTO `tb_role_privilege` VALUES ('8', '16');
INSERT INTO `tb_role_privilege` VALUES ('8', '17');
INSERT INTO `tb_role_privilege` VALUES ('8', '18');
INSERT INTO `tb_role_privilege` VALUES ('8', '19');
INSERT INTO `tb_role_privilege` VALUES ('8', '20');
INSERT INTO `tb_role_privilege` VALUES ('8', '21');
INSERT INTO `tb_role_privilege` VALUES ('8', '22');
INSERT INTO `tb_role_privilege` VALUES ('8', '25');
INSERT INTO `tb_role_privilege` VALUES ('8', '26');
INSERT INTO `tb_role_privilege` VALUES ('6', '15');
INSERT INTO `tb_role_privilege` VALUES ('6', '16');
INSERT INTO `tb_role_privilege` VALUES ('6', '17');
INSERT INTO `tb_role_privilege` VALUES ('6', '18');
INSERT INTO `tb_role_privilege` VALUES ('6', '19');
INSERT INTO `tb_role_privilege` VALUES ('6', '20');
INSERT INTO `tb_role_privilege` VALUES ('6', '21');
INSERT INTO `tb_role_privilege` VALUES ('6', '22');
INSERT INTO `tb_role_privilege` VALUES ('6', '23');
INSERT INTO `tb_role_privilege` VALUES ('6', '24');
INSERT INTO `tb_role_privilege` VALUES ('6', '25');
INSERT INTO `tb_role_privilege` VALUES ('6', '26');
INSERT INTO `tb_role_privilege` VALUES ('6', '2');
INSERT INTO `tb_role_privilege` VALUES ('6', '12');
INSERT INTO `tb_role_privilege` VALUES ('2', '15');
INSERT INTO `tb_role_privilege` VALUES ('2', '16');
INSERT INTO `tb_role_privilege` VALUES ('2', '17');
INSERT INTO `tb_role_privilege` VALUES ('2', '18');
INSERT INTO `tb_role_privilege` VALUES ('2', '19');
INSERT INTO `tb_role_privilege` VALUES ('2', '20');
INSERT INTO `tb_role_privilege` VALUES ('2', '21');
INSERT INTO `tb_role_privilege` VALUES ('2', '22');
INSERT INTO `tb_role_privilege` VALUES ('2', '23');
INSERT INTO `tb_role_privilege` VALUES ('2', '24');
INSERT INTO `tb_role_privilege` VALUES ('2', '25');
INSERT INTO `tb_role_privilege` VALUES ('2', '26');
INSERT INTO `tb_role_privilege` VALUES ('2', '1');
INSERT INTO `tb_role_privilege` VALUES ('2', '2');
INSERT INTO `tb_role_privilege` VALUES ('2', '3');
INSERT INTO `tb_role_privilege` VALUES ('2', '4');
INSERT INTO `tb_role_privilege` VALUES ('2', '5');
INSERT INTO `tb_role_privilege` VALUES ('2', '6');
INSERT INTO `tb_role_privilege` VALUES ('2', '7');
INSERT INTO `tb_role_privilege` VALUES ('2', '8');
INSERT INTO `tb_role_privilege` VALUES ('2', '9');
INSERT INTO `tb_role_privilege` VALUES ('2', '10');
INSERT INTO `tb_role_privilege` VALUES ('2', '11');
INSERT INTO `tb_role_privilege` VALUES ('2', '12');
INSERT INTO `tb_role_privilege` VALUES ('2', '13');
INSERT INTO `tb_role_privilege` VALUES ('2', '14');
INSERT INTO `tb_role_privilege` VALUES ('9', '15');
INSERT INTO `tb_role_privilege` VALUES ('9', '16');
INSERT INTO `tb_role_privilege` VALUES ('9', '17');
INSERT INTO `tb_role_privilege` VALUES ('9', '18');
INSERT INTO `tb_role_privilege` VALUES ('9', '19');
INSERT INTO `tb_role_privilege` VALUES ('9', '20');
INSERT INTO `tb_role_privilege` VALUES ('9', '21');
INSERT INTO `tb_role_privilege` VALUES ('9', '22');
INSERT INTO `tb_role_privilege` VALUES ('9', '23');
INSERT INTO `tb_role_privilege` VALUES ('9', '24');
INSERT INTO `tb_role_privilege` VALUES ('9', '25');
INSERT INTO `tb_role_privilege` VALUES ('9', '26');
INSERT INTO `tb_role_privilege` VALUES ('9', '1');
INSERT INTO `tb_role_privilege` VALUES ('9', '2');
INSERT INTO `tb_role_privilege` VALUES ('9', '3');
INSERT INTO `tb_role_privilege` VALUES ('9', '4');
INSERT INTO `tb_role_privilege` VALUES ('9', '5');
INSERT INTO `tb_role_privilege` VALUES ('9', '6');
INSERT INTO `tb_role_privilege` VALUES ('9', '7');
INSERT INTO `tb_role_privilege` VALUES ('9', '8');
INSERT INTO `tb_role_privilege` VALUES ('9', '9');
INSERT INTO `tb_role_privilege` VALUES ('9', '10');
INSERT INTO `tb_role_privilege` VALUES ('9', '11');
INSERT INTO `tb_role_privilege` VALUES ('9', '12');
INSERT INTO `tb_role_privilege` VALUES ('9', '13');
INSERT INTO `tb_role_privilege` VALUES ('9', '14');

-- ----------------------------
-- Table structure for tb_tags
-- ----------------------------
DROP TABLE IF EXISTS `tb_tags`;
CREATE TABLE `tb_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '标签类型（1-项目；2-案例；3-知识）',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '标签',
  `create_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='标签表';

-- ----------------------------
-- Records of tb_tags
-- ----------------------------
INSERT INTO `tb_tags` VALUES ('2', '1', '测试', '1479960305', '1479960305');
INSERT INTO `tb_tags` VALUES ('4', '0', '商品', '1480040286', '1480040286');
INSERT INTO `tb_tags` VALUES ('6', '2', '案例1', '1480055198', '1480055198');
INSERT INTO `tb_tags` VALUES ('7', '1', '项目', '1480055212', '1480055212');
INSERT INTO `tb_tags` VALUES ('8', '3', '知识', '1480057303', '1480057303');
INSERT INTO `tb_tags` VALUES ('9', '0', '不限', '1480061401', '1480061401');

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '账号',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `authKey` varchar(50) NOT NULL DEFAULT '' COMMENT 'authKey',
  `id_card` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  `nick` varchar(30) NOT NULL DEFAULT '' COMMENT '用户微信昵称',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '用户真实姓名',
  `avatar` varchar(250) NOT NULL DEFAULT '' COMMENT '用户头像',
  `sex` tinyint(2) unsigned NOT NULL DEFAULT '2' COMMENT '性别（1-男；2-女）',
  `age` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '用户手机号码',
  `address` varchar(300) NOT NULL DEFAULT '' COMMENT '通讯地址',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（1-启用；2-禁用）',
  `update_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `login_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT ' 自动登录时间',
  PRIMARY KEY (`uid`),
  KEY `authKey` (`authKey`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `id_card` (`id_card`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COMMENT='用户基本信息表';

-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` VALUES ('13', '1', '0a57e14ac949ae72708583324befd111', 'GfHcVdBwbnQlT_SsigMllnHCdcRGp9C1', '513822198708093232', '大波波1333', '黄波1', 'http://www.mulhealth.com/upload/case/2016/11/28/f495bff03fba21da60c8f0dd5217e205.jpg', '2', '29', '15950055205', '12211212放的地方', '1', '1480475283', '1479617154', '1480474221');
INSERT INTO `tb_user` VALUES ('14', '', '39e6eb73f7e775ea8d5cc71f221f6ab1', 'YrH2CbsVDOhOc5gic_3kW5R3Mtm6842u', '513822198908093131', '茂茂', '黄茂', 'http://www.mulhealth.com/upload/case/2016/11/27/a87a9501e11f95f1f11990999c67f0fc.jpg', '1', '27', '15950055278', '上海市松江区', '1', '1480251135', '1480250250', '1480250776');
