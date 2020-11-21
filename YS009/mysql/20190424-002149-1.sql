-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 3306
-- Database : msvodx_ym
-- 
-- Part : #1
-- Date : 2019-04-24 00:21:49
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `ms_admin`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin`;
CREATE TABLE `ms_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `version` int(10) unsigned NOT NULL DEFAULT '3' COMMENT '版本信息，1尊享版，2高级版，3基础版',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL,
  `nick` varchar(50) NOT NULL DEFAULT '超级管理员' COMMENT '昵称',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `price` float(11,2) NOT NULL COMMENT '权限',
  `remarks` text NOT NULL COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `last_login_ip` varchar(128) NOT NULL COMMENT '最后登陆IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `db_config` text COMMENT '数据库配置',
  `role_id` int(10) NOT NULL DEFAULT '1' COMMENT '角色ID',
  `iframe` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0默认，1框架',
  `auth` text NOT NULL COMMENT '权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 管理用户';


-- -----------------------------
-- Table structure for `ms_admin_annex`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_annex`;
CREATE TABLE `ms_admin_annex` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联的数据ID',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '类型',
  `group` varchar(100) NOT NULL DEFAULT 'sys' COMMENT '文件分组',
  `file` varchar(255) NOT NULL COMMENT '上传文件',
  `hash` varchar(64) NOT NULL COMMENT '文件hash值',
  `size` decimal(12,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '附件大小KB',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '使用状态(0未使用，1已使用)',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `hash` (`hash`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 上传附件';


-- -----------------------------
-- Table structure for `ms_admin_annex_group`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_annex_group`;
CREATE TABLE `ms_admin_annex_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '附件分组',
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '附件数量',
  `size` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '附件大小kb',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 附件分组';

-- -----------------------------
-- Records of `ms_admin_annex_group`
-- -----------------------------
INSERT INTO `ms_admin_annex_group` VALUES ('1', 'sys', '0', '0.00');

-- -----------------------------
-- Table structure for `ms_admin_config`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_config`;
CREATE TABLE `ms_admin_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(20) NOT NULL DEFAULT 'base' COMMENT '分组',
  `title` varchar(20) NOT NULL COMMENT '配置标题',
  `name` varchar(50) NOT NULL COMMENT '配置名称，由英文字母和下划线组成',
  `value` text NOT NULL COMMENT '配置值',
  `remarks` varchar(64) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 系统配置';

-- -----------------------------
-- Records of `ms_admin_config`
-- -----------------------------
INSERT INTO `ms_admin_config` VALUES ('1', 'base', '网站logo', 'site_logo', 'http://ys009.ymyuanma.com/XResource/20190328/ynA4aNRjaPpsRJBK5C7XsmfKykbe4Xyr.png', '网站LOGO图片');
INSERT INTO `ms_admin_config` VALUES ('2', 'base', '网站图标', 'site_favicon', 'http://ys009.ymyuanma.com/favicon.ico', '网站收藏夹图标，它显示位于浏览器的地址栏或者标题前面');
INSERT INTO `ms_admin_config` VALUES ('3', 'base', '网站标题', 'site_title', 'YMYS009_魅思V10程序源码', '');
INSERT INTO `ms_admin_config` VALUES ('4', 'base', '网站关键词', 'site_keywords', '魅思V10程序源码,YMYS009', '网站标题是体现一个网站的主旨，要做到主题突出、标题简洁、连贯等特点，建议不超过28个字');
INSERT INTO `ms_admin_config` VALUES ('5', 'base', '网站描述', 'site_description', 'YMYS009_魅思V10程序源码', '网页的描述信息，搜索引擎采纳后，作为搜索结果中的页面摘要显示，建议不超过80个字');
INSERT INTO `ms_admin_config` VALUES ('6', 'base', 'ICP备案信息', 'site_icp', '备案中...............', 'ICP备案号，用于展示在网站底部');
INSERT INTO `ms_admin_config` VALUES ('7', 'base', '站点统计代码', 'site_statis', '', '第三方流量统计代码，前台调用时请先用 htmlspecialchars_decode函数转义输出');
INSERT INTO `ms_admin_config` VALUES ('8', 'base', '金币汇率', 'gold_exchange_rate', '10', '金币跟人民币的比率,如1元等于10金币则填写 1/10');
INSERT INTO `ms_admin_config` VALUES ('9', 'base', '是否允许提现', 'is_withdrawals', '1', '1为支持，0为不支持');
INSERT INTO `ms_admin_config` VALUES ('10', 'base', '提现频率', 'withdrawals_frequency', '0', '提交了提现申请之后多久可以再次申请');
INSERT INTO `ms_admin_config` VALUES ('11', 'base', '注册奖励', 'register_reward', '10', '新用户注册奖励多少金币');
INSERT INTO `ms_admin_config` VALUES ('12', 'base', '登录奖励', 'login_reward', '0.5', '用户当天首次登录奖励多少金币');
INSERT INTO `ms_admin_config` VALUES ('13', 'base', '签到奖励', 'sign_reward', '1', '用户签到奖励多少金币');
INSERT INTO `ms_admin_config` VALUES ('14', 'base', '宣传奖励', 'propaganda_reward', '3', '用户宣传奖励多少金币');
INSERT INTO `ms_admin_config` VALUES ('15', 'base', '消费有效期', 'message_validity', '24', '视频付费了之后，多长时间内可以免费观看');
INSERT INTO `ms_admin_config` VALUES ('16', 'base', '是否开启验证码', 'verification_code_on', '1', '1为开启，0为不开启');
INSERT INTO `ms_admin_config` VALUES ('17', 'base', '提现最低限额', 'min_withdrawals', '15', '申请提现最低提现金币数');
INSERT INTO `ms_admin_config` VALUES ('18', 'video', '是否支持试看', 'look_at_on', '1', '1为支持，0为不支持');
INSERT INTO `ms_admin_config` VALUES ('19', 'video', '试看的单位', 'look_at_measurement', '2', '试看的单位（部/秒）1为以部为单位，2为以秒为单位');
INSERT INTO `ms_admin_config` VALUES ('20', 'video', '试看的数量', 'look_at_num', '30', '可试看的数量');
INSERT INTO `ms_admin_config` VALUES ('21', 'video', '视频提成', 'commission', '1', '填写1-10的数字，如1，就是1/100');
INSERT INTO `ms_admin_config` VALUES ('22', 'video', '是否开启广告', 'ad_on', '1', '1为开启，0为关闭');
INSERT INTO `ms_admin_config` VALUES ('23', 'video', '是否可跳过广告', 'skip_ad_on', '1', '1为可以，0为不可以');
INSERT INTO `ms_admin_config` VALUES ('24', 'video', '前置广告内容', 'pre_ad', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/0e1dfc0f1c08c75090fee686d97763f1.jpg', '前置广告内容');
INSERT INTO `ms_admin_config` VALUES ('25', 'video', '前置广告外链', 'pre_ad_url', 'http://ys009.ymyuanma.com', '前置广告外链');
INSERT INTO `ms_admin_config` VALUES ('26', 'video', '暂停广告内容', 'suspend_ad', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/0e1dfc0f1c08c75090fee686d97763f1.jpg', '暂停广告内容');
INSERT INTO `ms_admin_config` VALUES ('27', 'video', '暂停广告外链', 'suspend_ad_url', 'http://ys009.ymyuanma.com', '暂停广告外链');
INSERT INTO `ms_admin_config` VALUES ('28', 'attachment', '图片存储方式', 'image_save_server_type', 'web_server', '站内图片使用的存储方式');
INSERT INTO `ms_admin_config` VALUES ('29', 'attachment', '视频存储方式', 'video_save_server_type', 'web_server', '视频资源存储的方式');
INSERT INTO `ms_admin_config` VALUES ('30', 'attachment', '云转码服务器地址', 'yzm_upload_url', '', '直接填写云转码服务器的url或ip即可');
INSERT INTO `ms_admin_config` VALUES ('31', 'attachment', '云转码播放密钥', 'yzm_play_secretkey', '', '防盗密钥需与云转码后台设置的保持一致,无设置请留空.(系统设置->防盗设置->防盗密钥)');
INSERT INTO `ms_admin_config` VALUES ('32', 'attachment', '七牛AccessKey', 'qiniu_accesskey', '', '七牛官网申请，<a href=\"https://www.qiniu.com/\">点击申请</a>');
INSERT INTO `ms_admin_config` VALUES ('33', 'attachment', '七牛SecretKey', 'qiniu_secretkey', '', '七牛官网申请，<a href=\"https://www.qiniu.com/\">点击申请</a>');
INSERT INTO `ms_admin_config` VALUES ('34', 'base', '网站状态', 'site_status', '1', '1为开启，0为不开启');
INSERT INTO `ms_admin_config` VALUES ('35', 'base', '手机网站', 'wap_site_status', '1', '1为开启，0为不开启');
INSERT INTO `ms_admin_config` VALUES ('36', 'attachment', '七牛Bucket', 'qiniu_bucket', '', '你的七牛云存储仓库名称');
INSERT INTO `ms_admin_config` VALUES ('37', 'base', '是否开启伪静态', 'web_mode', '0', '1为开启，0为不开启');
INSERT INTO `ms_admin_config` VALUES ('38', 'attachment', '阿里云存储城市', 'aliyun_oss_city', '深圳', '');
INSERT INTO `ms_admin_config` VALUES ('39', 'attachment', '阿里云AccessKeyId', 'aliyun_accesskey', '', '');
INSERT INTO `ms_admin_config` VALUES ('40', 'attachment', '阿里云AccessKeySecret', 'aliyun_secretkey', '', '');
INSERT INTO `ms_admin_config` VALUES ('41', 'attachment', '阿里云Bucket', 'aliyun_bucket', '', '');
INSERT INTO `ms_admin_config` VALUES ('42', 'attachment', 'webServer地址', 'web_server_url', 'http://ys009.ymyuanma.com', '');
INSERT INTO `ms_admin_config` VALUES ('43', 'commission', '视频提成', 'video_commission', '10', '视频提成，填写1-100的值');
INSERT INTO `ms_admin_config` VALUES ('44', 'commission', '图片提成', 'atlas_commission', '22', '图片提成，填写1-100的值');
INSERT INTO `ms_admin_config` VALUES ('45', 'commission', '小说提成', 'novel_commission', '20', '小说提成，填写1-100的值');
INSERT INTO `ms_admin_config` VALUES ('46', 'commission', '分销商提成', 'agent_commission', '13', '');
INSERT INTO `ms_admin_config` VALUES ('47', 'attachment', '七牛存储服务器地址', 'qiniu_upload_server', '华南', '');
INSERT INTO `ms_admin_config` VALUES ('48', 'attachment', '七牛外链默认域名', 'qiniu_resource_default_domain', '', '');
INSERT INTO `ms_admin_config` VALUES ('49', 'video', '播放视频时广告显示时长', 'play_video_ad_time', '5', '对前置广告生效');
INSERT INTO `ms_admin_config` VALUES ('50', 'base', '评论功能', 'comment_on', '1', '是否开启评论功能，1为开启，0为不开启');
INSERT INTO `ms_admin_config` VALUES ('51', 'base', '评论是都需要审核', 'comment_examine_on', '1', '评论是否需要审核1为需要，0为不需要');
INSERT INTO `ms_admin_config` VALUES ('52', 'email', '邮箱服务器', 'email_host', 'smtp.qq.com', '邮箱服务器');
INSERT INTO `ms_admin_config` VALUES ('53', 'email', '发送者邮箱账号', 'send_email', '123456@qq.com', '发送者邮箱账号');
INSERT INTO `ms_admin_config` VALUES ('54', 'email', '邮箱密码', 'email_password', 'cd5f4s6d4ffef', '发送者邮箱密码');
INSERT INTO `ms_admin_config` VALUES ('55', 'email', '端口号', 'email_port', '25', '邮箱服务器端口号');
INSERT INTO `ms_admin_config` VALUES ('56', 'email', '发送者email地址', 'from_email', '123456@qq.com', '发送者email地址');
INSERT INTO `ms_admin_config` VALUES ('57', 'email', '发件人名称', 'email_from_name', '发件人名称', '发件人名称');
INSERT INTO `ms_admin_config` VALUES ('58', 'base', '一天可获得金币的分享的次数', 'share_num', '10', '一天可获得金币的分享的次数');
INSERT INTO `ms_admin_config` VALUES ('60', 'base', '打赏排行', 'reward_num', '5', '首页打赏排行显示名次：例如首页排行榜显示前五名');
INSERT INTO `ms_admin_config` VALUES ('61', 'base', '系统支付方式码', 'system_payment_code', 'codePay', '');
INSERT INTO `ms_admin_config` VALUES ('63', 'base', '新增资源审核', 'resource_examine_on', '1', '客户上传了新资源（视频、图册、小说）是否需要审核，1为需要，0为不需要');
INSERT INTO `ms_admin_config` VALUES ('64', 'base', '视频重审', 'video_reexamination', '0', '客户编辑视频信息后是否需要重新审核，如修改了标题，标签，视频地址等');
INSERT INTO `ms_admin_config` VALUES ('65', 'base', '图片重审', 'image_reexamination', '0', '客户上传了新的图片或者修改了图册信息后是否需要重新审核');
INSERT INTO `ms_admin_config` VALUES ('66', 'base', '小说重审', 'novel_reexamination', '0', '客户编辑小说信息后是否需要重新审核，如修改了标题，标签，小说内容等');
INSERT INTO `ms_admin_config` VALUES ('67', 'sms', '短信api账号', 'sms_api_account', 'N3896228', '短信接口账号 ');
INSERT INTO `ms_admin_config` VALUES ('68', 'sms', '短信api密码', 'sms_api_password', 'AKSbhUT1Eif4cc', '短信接口密码');
INSERT INTO `ms_admin_config` VALUES ('69', 'sms', '短信api链接', 'sms_send_url', 'http://smssh1.253.com/msg/send/json', '发送短信接口URL');
INSERT INTO `ms_admin_config` VALUES ('70', 'base', '注册验证', 'register_validate', '0', '注册验证方式 0为不需要关闭，1为邮件验证，2为手机短信验证');
INSERT INTO `ms_admin_config` VALUES ('71', 'video', '手机试看部数', 'look_at_num_mobile', '5', '防止UC手机端非法浏览VIP资源，故手机端单独设置');
INSERT INTO `ms_admin_config` VALUES ('72', 'video', '云转码播放域名', 'yzm_video_play_domain', '', '');
INSERT INTO `ms_admin_config` VALUES ('73', 'video', '云转码API密钥', 'yzm_api_secretkey', '', '');
INSERT INTO `ms_admin_config` VALUES ('74', 'video', '视频自动入库分类id', 'sync_add_video_classid', '2', '');
INSERT INTO `ms_admin_config` VALUES ('75', 'video', ' 动入库的视频是否需要审核', 'sync_add_video_need_review', '0', '');
INSERT INTO `ms_admin_config` VALUES ('76', 'base', '手机网站logo', 'site_logo_mobile', 'http://ys009.ymyuanma.com/XResource/20190328/asQ6GrMGTPhYNE6mABZ8TDQ8rKykp4Z6.png', '');
INSERT INTO `ms_admin_config` VALUES ('77', 'base', '友情链接', 'friend_link', 'YM源码|https://www.ymyuanma.com', '每行一条友情链接,单条规则：链接名称|网址,例：Msvodx|http://www.msvod.c');
INSERT INTO `ms_admin_config` VALUES ('78', 'base', '主题basename', 'theme_basename', 'peixun', '');
INSERT INTO `ms_admin_config` VALUES ('79', 'commission', '一级分销商提成', 'one_level_distributor', '1', '一级分销商提成，填写0-100的值');
INSERT INTO `ms_admin_config` VALUES ('80', 'commission', '二级分销商提成', 'second_level_distributor', '3', '二级分销商提成，填写0-100的值');
INSERT INTO `ms_admin_config` VALUES ('81', 'commission', '三级分销商提成', 'three_level_distributor', '5', '三级分销商提成，填写0-100的值');
INSERT INTO `ms_admin_config` VALUES ('82', 'commission', '三级分销商是否与代理商提成可同时获取', 'three_level_distributor_on', '1', '三级分销商是否与代理商提成可同时获取');
INSERT INTO `ms_admin_config` VALUES ('83', 'base', '首页内容个数', 'homepage_resource_num', '8', '首页上每个栏目内容的显示个数');
INSERT INTO `ms_admin_config` VALUES ('84', 'base', '卡密购买链接', 'buy_cardpassword_uri', 'http://www.baidu.com', '用于指引会员在卡密平台上购买本站卡密');
INSERT INTO `ms_admin_config` VALUES ('85', 'base', '客服QQ', 'site_qq', '1919134557', '站点客服QQ，方便用户咨询');
INSERT INTO `ms_admin_config` VALUES ('86', 'gather', '是否开启采集接口', 'resource_gather_status', '1', '是否开启系统采集接口');
INSERT INTO `ms_admin_config` VALUES ('87', 'gather', '接口密钥', 'resource_gather_key', 'kkkkkkk', '接口密钥');
INSERT INTO `ms_admin_config` VALUES ('88', 'gather', '图册采集入库分类', 'resource_gather_atlas_classid', '23', '图册采集入库的分类');
INSERT INTO `ms_admin_config` VALUES ('89', 'gather', '视频采集入库分类', 'resource_gather_video_classid', '10', '视频采集入库的分类');
INSERT INTO `ms_admin_config` VALUES ('90', 'gather', '资讯采集入库分类', 'resource_gather_novel_classid', '17', '小说采集入库的分类');
INSERT INTO `ms_admin_config` VALUES ('91', 'gather', '采集的视频是否需要审核', 'resource_gather_video_need_review', '0', '采集的视频是否需要审核');
INSERT INTO `ms_admin_config` VALUES ('92', 'gather', '采集的小说是否需要审核', 'resource_gather_novel_need_review', '1', '采集的小说是否需要审核');
INSERT INTO `ms_admin_config` VALUES ('93', 'gather', '采集的图册是否需要审核', 'resource_gather_atlas_need_review', '1', '采集的图册是否需要审核');
INSERT INTO `ms_admin_config` VALUES ('94', 'gather', '采集的视频观看金币数', 'resource_gather_video_view_gold', '10', '采集的视频观看金币数');
INSERT INTO `ms_admin_config` VALUES ('95', 'gather', '采集的小说观看金币数', 'resource_gather_novel_view_gold', '3', '采集的小说观看金币数');
INSERT INTO `ms_admin_config` VALUES ('96', 'gather', '采集的图册观看金币数', 'resource_gather_atlas_view_gold', '4', '采集的图册观看金币数');
INSERT INTO `ms_admin_config` VALUES ('97', 'base', '上传视频奖励', 'upload_video_reward', '1', '用户上传视频审核通过后可获取奖励金币数');
INSERT INTO `ms_admin_config` VALUES ('98', 'base', '上传资讯奖励', 'upload_novel_reward', '1', '用户上传资讯审核通过后可获取奖励金币数');
INSERT INTO `ms_admin_config` VALUES ('99', 'base', '资源上传权限', 'upload_permissions', '1', '资源上传权限，1为所有人都可以上传，2为只有会员可以上传');
INSERT INTO `ms_admin_config` VALUES ('100', 'base', '资源上传权限', 'upload_permissions', '1', '资源上传权限，1为所有人都可以上传，2为只有会员可以上传');
INSERT INTO `ms_admin_config` VALUES ('101', 'video', '手机端前置广告内容地址', 'web_pre_ad', 'http://v.msvodx.com/XResource/20180525/JzRWwtacxRWxyzkZw8jzkpxC3GchKT7H.jpg', '手机端前置广告内容');

-- -----------------------------
-- Table structure for `ms_admin_hook`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_hook`;
CREATE TABLE `ms_admin_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '系统插件',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `source` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子来源[plugins.插件名，module.模块名]',
  `intro` varchar(200) NOT NULL DEFAULT '' COMMENT '钩子简介',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 钩子表';

-- -----------------------------
-- Records of `ms_admin_hook`
-- -----------------------------
INSERT INTO `ms_admin_hook` VALUES ('1', '1', 'system_admin_index', '', '后台首页', '1', '1490885108', '1490885108');
INSERT INTO `ms_admin_hook` VALUES ('2', '1', 'system_admin_tips', '', '后台所有页面提示', '1', '1490713165', '1490885137');
INSERT INTO `ms_admin_hook` VALUES ('3', '1', 'system_annex_upload', '', '附件上传钩子，可扩展上传到第三方存储', '1', '1490884242', '1490885121');
INSERT INTO `ms_admin_hook` VALUES ('4', '1', 'system_member_login', '', '会员登陆成功之后的动作', '1', '1490885108', '1490885108');

-- -----------------------------
-- Table structure for `ms_admin_hook_plugins`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_hook_plugins`;
CREATE TABLE `ms_admin_hook_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hook` varchar(32) NOT NULL COMMENT '钩子id',
  `plugins` varchar(32) NOT NULL COMMENT '插件标识',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0',
  `mtime` int(11) unsigned NOT NULL DEFAULT '0',
  `sort` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 钩子-插件对应表';


-- -----------------------------
-- Table structure for `ms_admin_language`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_language`;
CREATE TABLE `ms_admin_language` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '语言包名称',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '编码',
  `locale` varchar(255) NOT NULL DEFAULT '' COMMENT '本地浏览器语言编码',
  `icon` varchar(30) NOT NULL DEFAULT '' COMMENT '图标',
  `pack` varchar(100) NOT NULL DEFAULT '' COMMENT '上传的语言包',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 语言包';

-- -----------------------------
-- Records of `ms_admin_language`
-- -----------------------------
INSERT INTO `ms_admin_language` VALUES ('1', '简体中文', 'zh-cn', 'zh-CN,zh-CN.UTF-8,zh-cn', '', '1', '1', '1');

-- -----------------------------
-- Table structure for `ms_admin_log`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_log`;
CREATE TABLE `ms_admin_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) DEFAULT '',
  `url` varchar(200) DEFAULT '',
  `param` text,
  `remark` varchar(255) DEFAULT '',
  `count` int(10) unsigned NOT NULL DEFAULT '1',
  `ip` varchar(128) DEFAULT '',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 操作日志';

-- -----------------------------
-- Records of `ms_admin_log`
-- -----------------------------
INSERT INTO `ms_admin_log` VALUES ('1', '1', '后台首页', 'admin/index/index', '[]', '浏览数据', '1', '127.0.0.1', '1510054082', '1510054082');
INSERT INTO `ms_admin_log` VALUES ('2', '1', '[示例]列表模板', 'admin/develop/lists', '[]', '浏览数据', '1', '127.0.0.1', '1510054090', '1510054090');
INSERT INTO `ms_admin_log` VALUES ('3', '1', '[示例]编辑模板', 'admin/develop/edit', '[]', '浏览数据', '1', '127.0.0.1', '1510054093', '1510054093');
INSERT INTO `ms_admin_log` VALUES ('4', '1', '附件上传', 'admin/annex/upload', '{\"action\":\"config\",\"noCache\":\"1510054093878\",\"thumb\":\"no\",\"from\":\"ueditor\"}', '浏览数据', '1', '127.0.0.1', '1510054094', '1510054094');
INSERT INTO `ms_admin_log` VALUES ('5', '1', '附件上传', 'admin/annex/upload', '{\"action\":\"config\",\"noCache\":\"1510054093879\",\"thumb\":\"no\",\"from\":\"ueditor\"}', '浏览数据', '1', '127.0.0.1', '1510054094', '1510054094');
INSERT INTO `ms_admin_log` VALUES ('6', '1', '会员等级', 'admin/member/level', '[]', '浏览数据', '2', '127.0.0.1', '1510054127', '1510054178');
INSERT INTO `ms_admin_log` VALUES ('7', '1', '配置管理', 'admin/config/index', '[]', '浏览数据', '4', '127.0.0.1', '1510054133', '1510054189');
INSERT INTO `ms_admin_log` VALUES ('8', '1', '系统设置', 'admin/system/index', '[]', '浏览数据', '2', '127.0.0.1', '1510054134', '1510054159');
INSERT INTO `ms_admin_log` VALUES ('9', '1', '系统配置', 'admin/system/index', '{\"group\":\"sys\"}', '浏览数据', '1', '127.0.0.1', '1510054140', '1510054140');
INSERT INTO `ms_admin_log` VALUES ('10', '1', '上传配置', 'admin/system/index', '{\"group\":\"upload\"}', '浏览数据', '1', '127.0.0.1', '1510054142', '1510054142');
INSERT INTO `ms_admin_log` VALUES ('11', '1', '在线升级', 'admin/upgrade/index', '[]', '浏览数据', '1', '127.0.0.1', '1510054146', '1510054146');
INSERT INTO `ms_admin_log` VALUES ('12', '1', '数据库管理', 'admin/database/index', '[]', '浏览数据', '2', '127.0.0.1', '1510054152', '1510054199');
INSERT INTO `ms_admin_log` VALUES ('13', '1', '系统日志', 'admin/log/index', '[]', '浏览数据', '1', '127.0.0.1', '1510054155', '1510054155');
INSERT INTO `ms_admin_log` VALUES ('14', '1', '系统菜单', 'admin/menu/index', '[]', '浏览数据', '1', '127.0.0.1', '1510054156', '1510054156');
INSERT INTO `ms_admin_log` VALUES ('15', '1', '会员列表', 'admin/member/index', '[]', '浏览数据', '1', '127.0.0.1', '1510054181', '1510054181');
INSERT INTO `ms_admin_log` VALUES ('16', '1', '系统管理员', 'admin/user/index', '[]', '浏览数据', '1', '127.0.0.1', '1510054184', '1510054184');
INSERT INTO `ms_admin_log` VALUES ('17', '1', '数据库管理', 'admin/database/index', '{\"group\":\"import\"}', '浏览数据', '1', '127.0.0.1', '1510054200', '1510054200');
INSERT INTO `ms_admin_log` VALUES ('18', '1', '数据库管理', 'admin/database/index', '{\"group\":\"export\"}', '浏览数据', '1', '127.0.0.1', '1510054201', '1510054201');
INSERT INTO `ms_admin_log` VALUES ('19', '1', '备份数据库', 'admin/database/export', '{\"ids\":[\"ms_admin_annex\",\"ms_admin_annex_group\",\"ms_admin_config\",\"ms_admin_hook\",\"ms_admin_hook_plugins\",\"ms_admin_language\",\"ms_admin_log\",\"ms_admin_member\",\"ms_admin_member_level\",\"ms_admin_menu\",\"ms_admin_menu_lang\",\"ms_admin_module\",\"ms_admin_plugins\",\"ms_admin_role\",\"ms_admin_user\"]}', '保存数据', '1', '127.0.0.1', '1510054204', '1510054204');

-- -----------------------------
-- Table structure for `ms_admin_member`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_member`;
CREATE TABLE `ms_admin_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员等级ID',
  `nick` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `mobile` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '手机号',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(128) NOT NULL COMMENT '密码',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '可用金额',
  `frozen_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '冻结金额',
  `income` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '收入统计',
  `expend` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '开支统计',
  `exper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '经验值',
  `integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `frozen_integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '冻结积分',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '性别(1男，0女)',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `last_login_ip` varchar(128) NOT NULL DEFAULT '' COMMENT '最后登陆IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `login_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期时间(0永久)',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0禁用，1正常)',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1000001 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 会员表';

-- -----------------------------
-- Records of `ms_admin_member`
-- -----------------------------
INSERT INTO `ms_admin_member` VALUES ('1000000', '1', '', 'test', '0', '', '$2y$10$WC0mMyErW1u1JCLXDCbTIuagCceC/kKpjzvCf.cxrVKaxsrZLXrGe', '0.00', '0.00', '0.00', '0.00', '0', '0', '0', '1', '', '', '0', '0', '0', '1', '1493274686');

-- -----------------------------
-- Table structure for `ms_admin_member_level`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_member_level`;
CREATE TABLE `ms_admin_member_level` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL COMMENT '等级名称',
  `min_exper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最小经验值',
  `max_exper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最大经验值',
  `discount` int(2) unsigned NOT NULL DEFAULT '100' COMMENT '折扣率(%)',
  `intro` varchar(255) NOT NULL COMMENT '等级简介',
  `default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '默认等级',
  `expire` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员有效期(天)',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 会员等级';

-- -----------------------------
-- Records of `ms_admin_member_level`
-- -----------------------------
INSERT INTO `ms_admin_member_level` VALUES ('1', '注册会员', '0', '0', '100', '', '1', '0', '1', '0', '1491966814');

-- -----------------------------
-- Table structure for `ms_admin_menu`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_menu`;
CREATE TABLE `ms_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID(快捷菜单专用)',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `module` varchar(20) NOT NULL COMMENT '模块名或插件名，插件名格式:plugins.插件名',
  `title` varchar(20) NOT NULL COMMENT '菜单标题',
  `icon` varchar(80) NOT NULL DEFAULT 'aicon ai-shezhi' COMMENT '菜单图标',
  `url` varchar(200) NOT NULL COMMENT '链接地址(模块/控制器/方法)',
  `param` varchar(200) NOT NULL DEFAULT '' COMMENT '扩展参数',
  `target` varchar(20) NOT NULL DEFAULT '_self' COMMENT '打开方式(_blank,_self)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `debug` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开发模式可见',
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统菜单，系统菜单不可删除',
  `nav` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否为菜单显示，1显示0不显示',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态1显示，0隐藏',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 管理菜单';

-- -----------------------------
-- Records of `ms_admin_menu`
-- -----------------------------
INSERT INTO `ms_admin_menu` VALUES ('1', '0', '0', 'admin', '首页', '', 'admin/index', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('2', '0', '0', 'admin', '系统', '', 'admin/system', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('3', '0', '0', 'admin', '插件', 'aicon ai-shezhi', 'admin/plugins', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('4', '0', '1', 'admin', '快捷菜单', 'aicon ai-shezhi', 'admin/quick', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('5', '0', '3', 'admin', '插件列表', 'aicon ai-shezhi', 'admin/plugins', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('6', '0', '2', 'admin', '系统功能', 'aicon ai-shezhi', 'admin/system', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('7', '0', '2', 'admin', '会员管理', 'aicon ai-shezhi', 'admin/member', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('8', '0', '2', 'admin', '系统扩展', 'aicon ai-shezhi', 'admin/extend', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('9', '0', '2', 'admin', '开发专用', 'aicon ai-shezhi', 'admin/develop', '', '_self', '4', '1', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('10', '0', '6', 'admin', '系统设置', '', 'admin/system/index', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('11', '0', '6', 'admin', '配置管理', '', 'admin/config/index', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('12', '0', '6', 'admin', '系统菜单', '', 'admin/menu/index', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('13', '0', '6', 'admin', '管理员角色', '', 'admin/user/role', '', '_self', '4', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('14', '0', '6', 'admin', '系统管理员', '', 'admin/user/index', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('15', '0', '6', 'admin', '系统日志', '', 'admin/log/index', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('16', '0', '6', 'admin', '附件管理', '', 'admin/annex/index', '', '_self', '7', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('17', '0', '8', 'admin', '模块管理', '', 'admin/module/index', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('18', '0', '8', 'admin', '插件管理', '', 'admin/plugins/index', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('19', '0', '8', 'admin', '钩子管理', '', 'admin/hook/index', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('20', '0', '7', 'admin', '会员等级', '', 'admin/member/level', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('21', '0', '7', 'admin', '会员列表', '', 'admin/member/index', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('22', '0', '9', 'admin', '[示例]列表模板', '', 'admin/develop/lists', '', '_self', '1', '1', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('23', '0', '9', 'admin', '[示例]编辑模板', '', 'admin/develop/edit', '', '_self', '2', '1', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('24', '0', '4', 'admin', '后台首页', '', 'admin/index/index', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('25', '0', '4', 'admin', '清空缓存', '', 'admin/index/clear', '', '_self', '1', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('26', '0', '12', 'admin', '添加菜单', '', 'admin/menu/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('27', '0', '12', 'admin', '修改菜单', '', 'admin/menu/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('28', '0', '12', 'admin', '删除菜单', '', 'admin/menu/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('29', '0', '12', 'admin', '状态设置', '', 'admin/menu/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('30', '0', '12', 'admin', '排序设置', '', 'admin/menu/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('31', '0', '12', 'admin', '添加快捷菜单', '', 'admin/menu/quick', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('32', '0', '12', 'admin', '导出菜单', '', 'admin/menu/export', '', '_self', '7', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('33', '0', '13', 'admin', '添加角色', '', 'admin/user/addrole', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('34', '0', '13', 'admin', '修改角色', '', 'admin/user/editrole', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('35', '0', '13', 'admin', '删除角色', '', 'admin/user/delrole', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('36', '0', '13', 'admin', '状态设置', '', 'admin/user/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('37', '0', '14', 'admin', '添加管理员', '', 'admin/user/adduser', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('38', '0', '14', 'admin', '修改管理员', '', 'admin/user/edituser', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('39', '0', '14', 'admin', '删除管理员', '', 'admin/user/deluser', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('40', '0', '14', 'admin', '状态设置', '', 'admin/user/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('41', '0', '14', 'admin', '个人信息设置', '', 'admin/user/info', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('42', '0', '18', 'admin', '安装插件', '', 'admin/plugins/install', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('43', '0', '18', 'admin', '卸载插件', '', 'admin/plugins/uninstall', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('44', '0', '18', 'admin', '删除插件', '', 'admin/plugins/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('45', '0', '18', 'admin', '状态设置', '', 'admin/plugins/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('46', '0', '18', 'admin', '设计插件', '', 'admin/plugins/design', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('47', '0', '18', 'admin', '运行插件', '', 'admin/plugins/run', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('48', '0', '18', 'admin', '更新插件', '', 'admin/plugins/update', '', '_self', '7', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('49', '0', '18', 'admin', '插件配置', '', 'admin/plugins/setting', '', '_self', '8', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('50', '0', '19', 'admin', '添加钩子', '', 'admin/hook/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('51', '0', '19', 'admin', '修改钩子', '', 'admin/hook/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('52', '0', '19', 'admin', '删除钩子', '', 'admin/hook/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('53', '0', '19', 'admin', '状态设置', '', 'admin/hook/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('54', '0', '19', 'admin', '插件排序', '', 'admin/hook/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('55', '0', '11', 'admin', '添加配置', '', 'admin/config/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('56', '0', '11', 'admin', '修改配置', '', 'admin/config/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('57', '0', '11', 'admin', '删除配置', '', 'admin/config/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('58', '0', '11', 'admin', '状态设置', '', 'admin/config/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('59', '0', '11', 'admin', '排序设置', '', 'admin/config/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('60', '0', '10', 'admin', '基础配置', '', 'admin/system/index', 'group=base', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('61', '0', '10', 'admin', '系统配置', '', 'admin/system/index', 'group=sys', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('62', '0', '10', 'admin', '上传配置', '', 'admin/system/index', 'group=upload', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('63', '0', '10', 'admin', '开发配置', '', 'admin/system/index', 'group=develop', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('64', '0', '17', 'admin', '设计模块', '', 'admin/module/design', '', '_self', '6', '1', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('65', '0', '17', 'admin', '安装模块', '', 'admin/module/install', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('66', '0', '17', 'admin', '卸载模块', '', 'admin/module/uninstall', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('67', '0', '17', 'admin', '状态设置', '', 'admin/module/status', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('68', '0', '17', 'admin', '设置默认模块', '', 'admin/module/setdefault', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('69', '0', '17', 'admin', '删除模块', '', 'admin/module/del', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('70', '0', '21', 'admin', '添加会员', '', 'admin/member/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('71', '0', '21', 'admin', '修改会员', '', 'admin/member/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('72', '0', '21', 'admin', '删除会员', '', 'admin/member/del', 'table=admin_member', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('73', '0', '21', 'admin', '状态设置', '', 'admin/member/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('74', '0', '21', 'admin', '[弹窗]会员选择', '', 'admin/member/pop', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('75', '0', '20', 'admin', '添加会员等级', '', 'admin/member/addlevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('76', '0', '20', 'admin', '修改会员等级', '', 'admin/member/editlevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('77', '0', '20', 'admin', '删除会员等级', '', 'admin/member/dellevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('78', '0', '16', 'admin', '附件上传', '', 'admin/annex/upload', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('79', '0', '16', 'admin', '删除附件', '', 'admin/annex/del', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('80', '0', '8', 'admin', '在线升级', '', 'admin/upgrade/index', '', '_self', '4', '0', '1', '1', '1', '1491352728');
INSERT INTO `ms_admin_menu` VALUES ('81', '0', '80', 'admin', '获取升级列表', '', 'admin/upgrade/lists', '', '_self', '0', '0', '1', '1', '1', '1491353504');
INSERT INTO `ms_admin_menu` VALUES ('82', '0', '80', 'admin', '安装升级包', '', 'admin/upgrade/install', '', '_self', '0', '0', '1', '1', '1', '1491353568');
INSERT INTO `ms_admin_menu` VALUES ('83', '0', '80', 'admin', '下载升级包', '', 'admin/upgrade/download', '', '_self', '0', '0', '1', '1', '1', '1491395830');
INSERT INTO `ms_admin_menu` VALUES ('84', '0', '6', 'admin', '数据库管理', '', 'admin/database/index', '', '_self', '8', '0', '1', '1', '1', '1491461136');
INSERT INTO `ms_admin_menu` VALUES ('85', '0', '84', 'admin', '备份数据库', '', 'admin/database/export', '', '_self', '0', '0', '1', '1', '1', '1491461250');
INSERT INTO `ms_admin_menu` VALUES ('86', '0', '84', 'admin', '恢复数据库', '', 'admin/database/import', '', '_self', '0', '0', '1', '1', '1', '1491461315');
INSERT INTO `ms_admin_menu` VALUES ('87', '0', '84', 'admin', '优化数据库', '', 'admin/database/optimize', '', '_self', '0', '0', '1', '1', '1', '1491467000');
INSERT INTO `ms_admin_menu` VALUES ('88', '0', '84', 'admin', '删除备份', '', 'admin/database/del', '', '_self', '0', '0', '1', '1', '1', '1491467058');
INSERT INTO `ms_admin_menu` VALUES ('89', '0', '84', 'admin', '修复数据库', '', 'admin/database/repair', '', '_self', '0', '0', '1', '1', '1', '1491880879');
INSERT INTO `ms_admin_menu` VALUES ('90', '0', '21', 'admin', '设置默认等级', '', 'admin/member/setdefault', '', '_self', '0', '0', '1', '1', '1', '1491966585');
INSERT INTO `ms_admin_menu` VALUES ('91', '0', '10', 'admin', '数据库配置', '', 'admin/system/index', 'group=databases', '_self', '5', '0', '1', '1', '1', '1492072213');
INSERT INTO `ms_admin_menu` VALUES ('92', '0', '17', 'admin', '模块打包', '', 'admin/module/package', '', '_self', '7', '0', '1', '1', '1', '1492134693');
INSERT INTO `ms_admin_menu` VALUES ('93', '0', '18', 'admin', '插件打包', '', 'admin/plugins/package', '', '_self', '0', '0', '1', '1', '1', '1492134743');
INSERT INTO `ms_admin_menu` VALUES ('94', '0', '17', 'admin', '主题管理', '', 'admin/module/theme', '', '_self', '8', '0', '1', '1', '1', '1492433470');
INSERT INTO `ms_admin_menu` VALUES ('95', '0', '17', 'admin', '设置默认主题', '', 'admin/module/setdefaulttheme', '', '_self', '9', '0', '1', '1', '1', '1492433618');
INSERT INTO `ms_admin_menu` VALUES ('96', '0', '17', 'admin', '删除主题', '', 'admin/module/deltheme', '', '_self', '10', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('97', '0', '6', 'admin', '语言包管理', '', 'admin/language/index', '', '_self', '11', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('98', '0', '97', 'admin', '添加语言包', '', 'admin/language/add', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('99', '0', '97', 'admin', '修改语言包', '', 'admin/language/edit', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('100', '0', '97', 'admin', '删除语言包', '', 'admin/language/del', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('101', '0', '97', 'admin', '排序设置', '', 'admin/language/sort', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('102', '0', '97', 'admin', '状态设置', '', 'admin/language/status', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('103', '0', '16', 'admin', '收藏夹图标上传', '', 'admin/annex/favicon', '', '_self', '3', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('104', '0', '17', 'admin', '导入模块', '', 'admin/module/import', '', '_self', '11', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('105', '0', '4', 'admin', '欢迎页面', '', 'admin/index/welcome', '', '_self', '100', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('106', '0', '4', 'admin', '布局切换', '', 'admin/user/iframe', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('107', '0', '15', 'admin', '删除日志', '', 'admin/log/del', 'table=admin_log', '_self', '100', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('108', '0', '15', 'admin', '清空日志', '', 'admin/log/clear', '', '_self', '100', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('109', '0', '7', 'admin', '5555', '', 'admin/member/domainname', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('110', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('111', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('112', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('113', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('114', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('115', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('116', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('117', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('118', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('119', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('120', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('121', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('122', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('123', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('124', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('125', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('126', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('127', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('128', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('129', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu` VALUES ('130', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');

-- -----------------------------
-- Table structure for `ms_admin_menu_copy1`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_menu_copy1`;
CREATE TABLE `ms_admin_menu_copy1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID(快捷菜单专用)',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `module` varchar(20) NOT NULL COMMENT '模块名或插件名，插件名格式:plugins.插件名',
  `title` varchar(20) NOT NULL COMMENT '菜单标题',
  `icon` varchar(80) NOT NULL DEFAULT 'aicon ai-shezhi' COMMENT '菜单图标',
  `url` varchar(200) NOT NULL COMMENT '链接地址(模块/控制器/方法)',
  `param` varchar(200) NOT NULL DEFAULT '' COMMENT '扩展参数',
  `target` varchar(20) NOT NULL DEFAULT '_self' COMMENT '打开方式(_blank,_self)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `debug` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开发模式可见',
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统菜单，系统菜单不可删除',
  `nav` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否为菜单显示，1显示0不显示',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态1显示，0隐藏',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 管理菜单';

-- -----------------------------
-- Records of `ms_admin_menu_copy1`
-- -----------------------------
INSERT INTO `ms_admin_menu_copy1` VALUES ('1', '0', '0', 'admin', '首页', '', 'admin/index', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('2', '0', '0', 'admin', '系统', '', 'admin/system', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('3', '0', '0', 'admin', '插件', 'aicon ai-shezhi', 'admin/plugins', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('4', '0', '1', 'admin', '快捷菜单', 'aicon ai-shezhi', 'admin/quick', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('5', '0', '3', 'admin', '插件列表', 'aicon ai-shezhi', 'admin/plugins', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('6', '0', '2', 'admin', '系统功能', 'aicon ai-shezhi', 'admin/system', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('7', '0', '2', 'admin', '会员管理', 'aicon ai-shezhi', 'admin/member', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('8', '0', '2', 'admin', '系统扩展', 'aicon ai-shezhi', 'admin/extend', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('9', '0', '2', 'admin', '开发专用', 'aicon ai-shezhi', 'admin/develop', '', '_self', '4', '1', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('10', '0', '6', 'admin', '系统设置', '', 'admin/system/index', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('11', '0', '6', 'admin', '配置管理', '', 'admin/config/index', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('12', '0', '6', 'admin', '系统菜单', '', 'admin/menu/index', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('13', '0', '6', 'admin', '管理员角色', '', 'admin/user/role', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('14', '0', '6', 'admin', '系统管理员', '', 'admin/user/index', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('15', '0', '6', 'admin', '系统日志', '', 'admin/log/index', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('16', '0', '6', 'admin', '附件管理', '', 'admin/annex/index', '', '_self', '7', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('17', '0', '8', 'admin', '模块管理', '', 'admin/module/index', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('18', '0', '8', 'admin', '插件管理', '', 'admin/plugins/index', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('19', '0', '8', 'admin', '钩子管理', '', 'admin/hook/index', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('20', '0', '7', 'admin', '会员等级', '', 'admin/member/level', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('21', '0', '7', 'admin', '会员列表', '', 'admin/member/index', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('22', '0', '9', 'admin', '[示例]列表模板', '', 'admin/develop/lists', '', '_self', '1', '1', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('23', '0', '9', 'admin', '[示例]编辑模板', '', 'admin/develop/edit', '', '_self', '2', '1', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('24', '0', '4', 'admin', '后台首页', '', 'admin/index/index', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('25', '0', '4', 'admin', '清空缓存', '', 'admin/index/clear', '', '_self', '1', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('26', '0', '12', 'admin', '添加菜单', '', 'admin/menu/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('27', '0', '12', 'admin', '修改菜单', '', 'admin/menu/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('28', '0', '12', 'admin', '删除菜单', '', 'admin/menu/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('29', '0', '12', 'admin', '状态设置', '', 'admin/menu/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('30', '0', '12', 'admin', '排序设置', '', 'admin/menu/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('31', '0', '12', 'admin', '添加快捷菜单', '', 'admin/menu/quick', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('32', '0', '12', 'admin', '导出菜单', '', 'admin/menu/export', '', '_self', '7', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('33', '0', '13', 'admin', '添加角色', '', 'admin/user/addrole', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('34', '0', '13', 'admin', '修改角色', '', 'admin/user/editrole', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('35', '0', '13', 'admin', '删除角色', '', 'admin/user/delrole', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('36', '0', '13', 'admin', '状态设置', '', 'admin/user/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('37', '0', '14', 'admin', '添加管理员', '', 'admin/user/adduser', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('38', '0', '14', 'admin', '修改管理员', '', 'admin/user/edituser', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('39', '0', '14', 'admin', '删除管理员', '', 'admin/user/deluser', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('40', '0', '14', 'admin', '状态设置', '', 'admin/user/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('41', '0', '14', 'admin', '个人信息设置', '', 'admin/user/info', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('42', '0', '18', 'admin', '安装插件', '', 'admin/plugins/install', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('43', '0', '18', 'admin', '卸载插件', '', 'admin/plugins/uninstall', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('44', '0', '18', 'admin', '删除插件', '', 'admin/plugins/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('45', '0', '18', 'admin', '状态设置', '', 'admin/plugins/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('46', '0', '18', 'admin', '设计插件', '', 'admin/plugins/design', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('47', '0', '18', 'admin', '运行插件', '', 'admin/plugins/run', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('48', '0', '18', 'admin', '更新插件', '', 'admin/plugins/update', '', '_self', '7', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('49', '0', '18', 'admin', '插件配置', '', 'admin/plugins/setting', '', '_self', '8', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('50', '0', '19', 'admin', '添加钩子', '', 'admin/hook/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('51', '0', '19', 'admin', '修改钩子', '', 'admin/hook/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('52', '0', '19', 'admin', '删除钩子', '', 'admin/hook/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('53', '0', '19', 'admin', '状态设置', '', 'admin/hook/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('54', '0', '19', 'admin', '插件排序', '', 'admin/hook/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('55', '0', '11', 'admin', '添加配置', '', 'admin/config/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('56', '0', '11', 'admin', '修改配置', '', 'admin/config/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('57', '0', '11', 'admin', '删除配置', '', 'admin/config/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('58', '0', '11', 'admin', '状态设置', '', 'admin/config/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('59', '0', '11', 'admin', '排序设置', '', 'admin/config/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('60', '0', '10', 'admin', '基础配置', '', 'admin/system/index', 'group=base', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('61', '0', '10', 'admin', '系统配置', '', 'admin/system/index', 'group=sys', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('62', '0', '10', 'admin', '上传配置', '', 'admin/system/index', 'group=upload', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('63', '0', '10', 'admin', '开发配置', '', 'admin/system/index', 'group=develop', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('64', '0', '17', 'admin', '设计模块', '', 'admin/module/design', '', '_self', '6', '1', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('65', '0', '17', 'admin', '安装模块', '', 'admin/module/install', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('66', '0', '17', 'admin', '卸载模块', '', 'admin/module/uninstall', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('67', '0', '17', 'admin', '状态设置', '', 'admin/module/status', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('68', '0', '17', 'admin', '设置默认模块', '', 'admin/module/setdefault', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('69', '0', '17', 'admin', '删除模块', '', 'admin/module/del', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('70', '0', '21', 'admin', '添加会员', '', 'admin/member/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('71', '0', '21', 'admin', '修改会员', '', 'admin/member/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('72', '0', '21', 'admin', '删除会员', '', 'admin/member/del', 'table=admin_member', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('73', '0', '21', 'admin', '状态设置', '', 'admin/member/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('74', '0', '21', 'admin', '[弹窗]会员选择', '', 'admin/member/pop', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('75', '0', '20', 'admin', '添加会员等级', '', 'admin/member/addlevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('76', '0', '20', 'admin', '修改会员等级', '', 'admin/member/editlevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('77', '0', '20', 'admin', '删除会员等级', '', 'admin/member/dellevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('78', '0', '16', 'admin', '附件上传', '', 'admin/annex/upload', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('79', '0', '16', 'admin', '删除附件', '', 'admin/annex/del', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('80', '0', '8', 'admin', '在线升级', '', 'admin/upgrade/index', '', '_self', '4', '0', '1', '1', '1', '1491352728');
INSERT INTO `ms_admin_menu_copy1` VALUES ('81', '0', '80', 'admin', '获取升级列表', '', 'admin/upgrade/lists', '', '_self', '0', '0', '1', '1', '1', '1491353504');
INSERT INTO `ms_admin_menu_copy1` VALUES ('82', '0', '80', 'admin', '安装升级包', '', 'admin/upgrade/install', '', '_self', '0', '0', '1', '1', '1', '1491353568');
INSERT INTO `ms_admin_menu_copy1` VALUES ('83', '0', '80', 'admin', '下载升级包', '', 'admin/upgrade/download', '', '_self', '0', '0', '1', '1', '1', '1491395830');
INSERT INTO `ms_admin_menu_copy1` VALUES ('84', '0', '6', 'admin', '数据库管理', '', 'admin/database/index', '', '_self', '8', '0', '1', '1', '1', '1491461136');
INSERT INTO `ms_admin_menu_copy1` VALUES ('85', '0', '84', 'admin', '备份数据库', '', 'admin/database/export', '', '_self', '0', '0', '1', '1', '1', '1491461250');
INSERT INTO `ms_admin_menu_copy1` VALUES ('86', '0', '84', 'admin', '恢复数据库', '', 'admin/database/import', '', '_self', '0', '0', '1', '1', '1', '1491461315');
INSERT INTO `ms_admin_menu_copy1` VALUES ('87', '0', '84', 'admin', '优化数据库', '', 'admin/database/optimize', '', '_self', '0', '0', '1', '1', '1', '1491467000');
INSERT INTO `ms_admin_menu_copy1` VALUES ('88', '0', '84', 'admin', '删除备份', '', 'admin/database/del', '', '_self', '0', '0', '1', '1', '1', '1491467058');
INSERT INTO `ms_admin_menu_copy1` VALUES ('89', '0', '84', 'admin', '修复数据库', '', 'admin/database/repair', '', '_self', '0', '0', '1', '1', '1', '1491880879');
INSERT INTO `ms_admin_menu_copy1` VALUES ('90', '0', '21', 'admin', '设置默认等级', '', 'admin/member/setdefault', '', '_self', '0', '0', '1', '1', '1', '1491966585');
INSERT INTO `ms_admin_menu_copy1` VALUES ('91', '0', '10', 'admin', '数据库配置', '', 'admin/system/index', 'group=databases', '_self', '5', '0', '1', '1', '1', '1492072213');
INSERT INTO `ms_admin_menu_copy1` VALUES ('92', '0', '17', 'admin', '模块打包', '', 'admin/module/package', '', '_self', '7', '0', '1', '1', '1', '1492134693');
INSERT INTO `ms_admin_menu_copy1` VALUES ('93', '0', '18', 'admin', '插件打包', '', 'admin/plugins/package', '', '_self', '0', '0', '1', '1', '1', '1492134743');
INSERT INTO `ms_admin_menu_copy1` VALUES ('94', '0', '17', 'admin', '主题管理', '', 'admin/module/theme', '', '_self', '8', '0', '1', '1', '1', '1492433470');
INSERT INTO `ms_admin_menu_copy1` VALUES ('95', '0', '17', 'admin', '设置默认主题', '', 'admin/module/setdefaulttheme', '', '_self', '9', '0', '1', '1', '1', '1492433618');
INSERT INTO `ms_admin_menu_copy1` VALUES ('96', '0', '17', 'admin', '删除主题', '', 'admin/module/deltheme', '', '_self', '10', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('97', '0', '6', 'admin', '语言包管理', '', 'admin/language/index', '', '_self', '11', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('98', '0', '97', 'admin', '添加语言包', '', 'admin/language/add', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('99', '0', '97', 'admin', '修改语言包', '', 'admin/language/edit', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('100', '0', '97', 'admin', '删除语言包', '', 'admin/language/del', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('101', '0', '97', 'admin', '排序设置', '', 'admin/language/sort', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('102', '0', '97', 'admin', '状态设置', '', 'admin/language/status', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('103', '0', '16', 'admin', '收藏夹图标上传', '', 'admin/annex/favicon', '', '_self', '3', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('104', '0', '17', 'admin', '导入模块', '', 'admin/module/import', '', '_self', '11', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('105', '0', '4', 'admin', '欢迎页面', '', 'admin/index/welcome', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('106', '0', '4', 'admin', '布局切换', '', 'admin/user/iframe', '', '_self', '100', '0', '1', '1', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('107', '0', '15', 'admin', '删除日志', '', 'admin/log/del', 'table=admin_log', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('108', '0', '15', 'admin', '清空日志', '', 'admin/log/clear', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('109', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('110', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('111', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('112', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('113', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('114', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('115', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('116', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('117', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('118', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('119', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('120', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('121', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('122', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('123', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('124', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('125', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('126', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('127', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('128', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('129', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('130', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `ms_admin_menu_copy1` VALUES ('131', '0', '1', 'admin', '视频管理', 'aicon ai-shezhi', 'admin/video', '', '_self', '0', '0', '0', '1', '1', '1510110844');
INSERT INTO `ms_admin_menu_copy1` VALUES ('132', '0', '131', 'admin', '视频上传', 'aicon ai-tuichu', 'admin/video/upload', '', '_self', '0', '0', '0', '1', '1', '1510110945');
INSERT INTO `ms_admin_menu_copy1` VALUES ('133', '0', '6', 'admin', '数据库配置', 'aicon ai-shezhi', 'admin/dbconfig/index', '', '_self', '2', '0', '0', '1', '1', '1510133228');
INSERT INTO `ms_admin_menu_copy1` VALUES ('134', '0', '4', 'admin', '标签管理', 'fa fa-tags', 'admin/index/taglist', 't=list', '_self', '0', '0', '1', '1', '1', '1510193325');
INSERT INTO `ms_admin_menu_copy1` VALUES ('136', '0', '134', 'admin', '排序配置', '', 'admin/index/khsort', '', '_self', '0', '0', '1', '1', '1', '1510208623');
INSERT INTO `ms_admin_menu_copy1` VALUES ('137', '0', '134', 'admin', '状态开关', '', 'admin/index/khstatus', '', '_self', '0', '0', '1', '1', '1', '1510209960');
INSERT INTO `ms_admin_menu_copy1` VALUES ('138', '1', '4', 'admin', '后台首页', '', 'admin/index/index', '', '_self', '100', '0', '0', '0', '1', '1510210445');
INSERT INTO `ms_admin_menu_copy1` VALUES ('139', '0', '134', 'admin', '删除标签', '', 'admin/index/khdel', '', '_self', '0', '0', '1', '1', '1', '1510210570');

-- -----------------------------
-- Table structure for `ms_admin_menu_lang`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_menu_lang`;
CREATE TABLE `ms_admin_menu_lang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(120) NOT NULL DEFAULT '' COMMENT '标题',
  `lang` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '语言包',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `ms_admin_menu_lang`
-- -----------------------------
INSERT INTO `ms_admin_menu_lang` VALUES ('131', '1', '首页', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('132', '2', '系统', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('133', '3', '插件', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('134', '4', '快捷菜单', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('135', '5', '插件列表', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('136', '6', '系统功能', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('137', '7', '会员管理', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('138', '8', '系统扩展', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('139', '9', '开发专用', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('140', '10', '系统设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('141', '11', '配置管理', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('142', '12', '系统菜单', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('143', '13', '管理员角色', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('144', '14', '系统管理员', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('145', '15', '系统日志', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('146', '16', '附件管理', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('147', '17', '模块管理', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('148', '18', '插件管理', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('149', '19', '钩子管理', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('150', '20', '会员等级', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('151', '21', '会员列表', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('152', '22', '[示例]列表模板', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('153', '23', '[示例]编辑模板', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('154', '24', '后台首页', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('155', '25', '清空缓存', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('156', '26', '添加菜单', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('157', '27', '修改菜单', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('158', '28', '删除菜单', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('159', '29', '状态设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('160', '30', '排序设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('161', '31', '添加快捷菜单', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('162', '32', '导出菜单', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('163', '33', '添加角色', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('164', '34', '修改角色', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('165', '35', '删除角色', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('166', '36', '状态设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('167', '37', '添加管理员', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('168', '38', '修改管理员', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('169', '39', '删除管理员', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('170', '40', '状态设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('171', '41', '个人信息设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('172', '42', '安装插件', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('173', '43', '卸载插件', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('174', '44', '删除插件', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('175', '45', '状态设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('176', '46', '设计插件', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('177', '47', '运行插件', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('178', '48', '更新插件', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('179', '49', '插件配置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('180', '50', '添加钩子', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('181', '51', '修改钩子', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('182', '52', '删除钩子', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('183', '53', '状态设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('184', '54', '插件排序', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('185', '55', '添加配置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('186', '56', '修改配置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('187', '57', '删除配置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('188', '58', '状态设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('189', '59', '排序设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('190', '60', '基础配置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('191', '61', '系统配置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('192', '62', '上传配置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('193', '63', '开发配置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('194', '64', '设计模块', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('195', '65', '安装模块', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('196', '66', '卸载模块', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('197', '67', '状态设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('198', '68', '设置默认模块', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('199', '69', '删除模块', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('200', '70', '添加会员', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('201', '71', '修改会员', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('202', '72', '删除会员', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('203', '73', '状态设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('204', '74', '[弹窗]会员选择', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('205', '75', '添加会员等级', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('206', '76', '修改会员等级', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('207', '77', '删除会员等级', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('208', '78', '附件上传', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('209', '79', '删除附件', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('210', '80', '在线升级', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('211', '81', '获取升级列表', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('212', '82', '安装升级包', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('213', '83', '下载升级包', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('214', '84', '数据库管理', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('215', '85', '备份数据库', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('216', '86', '恢复数据库', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('217', '87', '优化数据库', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('218', '88', '删除备份', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('219', '89', '修复数据库', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('220', '90', '设置默认等级', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('221', '91', '数据库配置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('222', '92', '模块打包', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('223', '93', '插件打包', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('224', '94', '主题管理', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('225', '95', '设置默认主题', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('226', '96', '删除主题', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('227', '97', '语言包管理', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('228', '98', '添加语言包', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('229', '99', '修改语言包', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('230', '100', '删除语言包', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('231', '101', '排序设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('232', '102', '状态设置', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('233', '103', '收藏夹图标上传', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('234', '104', '导入模块', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('235', '105', '欢迎页面', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('236', '106', '布局切换', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('237', '107', '删除日志', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('238', '108', '清空日志', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('239', '109', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('240', '110', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('241', '111', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('242', '112', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('243', '113', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('244', '114', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('245', '115', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('246', '116', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('247', '117', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('248', '118', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('249', '119', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('250', '120', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('251', '121', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('252', '122', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('253', '123', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('254', '124', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('255', '125', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('256', '126', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('257', '127', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('258', '128', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('259', '129', '预留占位', '1');
INSERT INTO `ms_admin_menu_lang` VALUES ('260', '130', '预留占位', '1');

-- -----------------------------
-- Table structure for `ms_admin_module`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_module`;
CREATE TABLE `ms_admin_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '系统模块',
  `name` varchar(50) NOT NULL COMMENT '模块名(英文)',
  `identifier` varchar(100) NOT NULL COMMENT '模块标识(模块名(字母).开发者标识.module)',
  `title` varchar(50) NOT NULL COMMENT '模块标题',
  `intro` varchar(255) NOT NULL COMMENT '模块简介',
  `author` varchar(100) NOT NULL COMMENT '作者',
  `icon` varchar(80) NOT NULL DEFAULT 'aicon ai-mokuaiguanli' COMMENT '图标',
  `version` varchar(20) NOT NULL COMMENT '版本号',
  `url` varchar(255) NOT NULL COMMENT '链接',
  `sort` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未安装，1未启用，2已启用',
  `default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '默认模块(只能有一个)',
  `config` text NOT NULL COMMENT '配置',
  `app_id` varchar(30) NOT NULL DEFAULT '0' COMMENT '应用市场ID(0本地)',
  `theme` varchar(50) NOT NULL DEFAULT 'default' COMMENT '主题模板',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE,
  UNIQUE KEY `identifier` (`identifier`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 模块';

-- -----------------------------
-- Records of `ms_admin_module`
-- -----------------------------
INSERT INTO `ms_admin_module` VALUES ('1', '1', 'admin', 'admin.hisiphp.module', '系统管理模块', '系统核心模块，用于后台各项管理功能模块及功能拓展', 'HisiPHP官方出品', '', '1.0.0', 'http://www.hisiphp.com', '0', '1', '0', '', '0', 'default', '1489998096', '1489998096');
INSERT INTO `ms_admin_module` VALUES ('2', '1', 'index', 'index.hisiphp.module', '系统默认模块', '仅供前端插件访问和应用市场推送安装，禁止在此模块下面开发任何东西。', 'HisiPHP官方出品', '', '1.0.0', 'http://www.hisiphp.com', '0', '1', '0', '', '0', 'default', '1489998096', '1489998096');
INSERT INTO `ms_admin_module` VALUES ('3', '1', 'install', 'install.hisiphp.module', '系统安装模块', '系统安装模块，勿动。', 'HisiPHP官方出品', '', '1.0.0', 'http://www.hisiphp.com', '0', '1', '0', '', '0', 'default', '1489998096', '1489998096');

-- -----------------------------
-- Table structure for `ms_admin_plugins`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_plugins`;
CREATE TABLE `ms_admin_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL COMMENT '插件名称(英文)',
  `title` varchar(32) NOT NULL COMMENT '插件标题',
  `icon` varchar(64) NOT NULL COMMENT '图标',
  `intro` text NOT NULL COMMENT '插件简介',
  `author` varchar(32) NOT NULL COMMENT '作者',
  `url` varchar(255) NOT NULL COMMENT '作者主页',
  `version` varchar(16) NOT NULL DEFAULT '' COMMENT '版本号',
  `identifier` varchar(64) NOT NULL DEFAULT '' COMMENT '插件唯一标识符',
  `config` text NOT NULL COMMENT '插件配置',
  `app_id` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '来源(0本地)',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 插件表';


-- -----------------------------
-- Table structure for `ms_admin_role`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_role`;
CREATE TABLE `ms_admin_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '角色名称',
  `intro` varchar(200) NOT NULL COMMENT '角色简介',
  `auth` text NOT NULL COMMENT '角色权限',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 管理角色';

-- -----------------------------
-- Records of `ms_admin_role`
-- -----------------------------
INSERT INTO `ms_admin_role` VALUES ('1', '超级管理员', '拥有系统最高权限', '0', '1489411760', '0', '1');
INSERT INTO `ms_admin_role` VALUES ('2', '系统管理员', '拥有系统管理员权限', '[\"1\",\"4\",\"25\",\"24\",\"2\",\"6\",\"10\",\"60\",\"61\",\"62\",\"63\",\"91\",\"11\",\"55\",\"56\",\"57\",\"58\",\"59\",\"12\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"13\",\"33\",\"34\",\"35\",\"36\",\"14\",\"37\",\"38\",\"39\",\"40\",\"41\",\"16\",\"78\",\"79\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"7\",\"20\",\"75\",\"76\",\"77\",\"21\",\"90\",\"70\",\"71\",\"72\",\"73\",\"74\",\"8\",\"17\",\"65\",\"66\",\"67\",\"68\",\"94\",\"95\",\"18\",\"42\",\"43\",\"45\",\"47\",\"48\",\"49\",\"19\",\"80\",\"81\",\"82\",\"83\",\"9\",\"22\",\"23\",\"3\",\"5\"]', '1489411760', '0', '1');

-- -----------------------------
-- Table structure for `ms_admin_user`
-- -----------------------------
DROP TABLE IF EXISTS `ms_admin_user`;
CREATE TABLE `ms_admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL,
  `nick` varchar(50) NOT NULL COMMENT '昵称',
  `mobile` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `auth` text NOT NULL COMMENT '权限',
  `iframe` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0默认，1框架',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `last_login_ip` varchar(128) NOT NULL COMMENT '最后登陆IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 管理用户';

-- -----------------------------
-- Records of `ms_admin_user`
-- -----------------------------
INSERT INTO `ms_admin_user` VALUES ('1', '1', 'admin', '$2y$10$yY9EPacS/nbVUMkhSX7MLuHB/SXzvPEScY82ZE3b5U3Fgy55AkXju', '超级管理员', '', '', '', '0', '1', '127.0.0.1', '1510054076', '1510054078', '1510054078');

-- -----------------------------
-- Table structure for `ms_advertisement`
-- -----------------------------
DROP TABLE IF EXISTS `ms_advertisement`;
CREATE TABLE `ms_advertisement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) DEFAULT NULL COMMENT '类型，1广告代码，2用户自定义图片',
  `content` text COMMENT '广告代码',
  `titles` varchar(255) DEFAULT NULL COMMENT '标题',
  `info` varchar(255) DEFAULT NULL COMMENT '详细信息',
  `url` varchar(255) DEFAULT NULL COMMENT '外链',
  `position_id` int(11) DEFAULT NULL COMMENT '广告位',
  `add_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `begin_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `status` int(1) DEFAULT '1' COMMENT '状态1开启，0关闭',
  `host` varchar(255) DEFAULT NULL COMMENT '所属域名',
  `target` int(1) DEFAULT '1' COMMENT '是否新页面打开1为是，0为否',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告表';

-- -----------------------------
-- Records of `ms_advertisement`
-- -----------------------------
INSERT INTO `ms_advertisement` VALUES ('8', '2', 'http://ys009.ymyuanma.com/XResource/20190412/X2dt2DEXacfPp8zwMdeadeEyjbJ5iJ5Q.png', '首页广告1', '112', 'https://www.ymyuanma.com/', '1', '1555038647', '1516636800', '1577808000', '1', '', '0');
INSERT INTO `ms_advertisement` VALUES ('10', '2', '', 'YTY', '', '', '0', '1520245442', '1520179200', '1520179200', '1', '', '1');
INSERT INTO `ms_advertisement` VALUES ('11', '2', '', 'TYTYTYT', 'TYTYT', '', '0', '1520245458', '1520179200', '1520179200', '1', '', '1');
INSERT INTO `ms_advertisement` VALUES ('12', '2', 'http://ys009.ymyuanma.com/XResource/20190420/XdAscBSSh777z35af8J8MWKmjcdiwbGp.jpg', '对联-左', 'TYTYTY', 'https://www.ymyuanma.com/', '2', '1555745594', '1554048000', '1778688000', '1', '', '1');
INSERT INTO `ms_advertisement` VALUES ('13', '2', 'http://ys009.ymyuanma.com/XResource/20190420/pDaXQSQFchd4ZrpGdJisH2P4F6J4C32e.jpg', '对联-右', '11', 'https://www.ymyuanma.com/', '3', '1555745493', '1555430400', '1595520000', '1', '', '1');
INSERT INTO `ms_advertisement` VALUES ('15', '2', 'http://ys008.ymyuanma.com/template/ys008/html/style/images/15382154564658495ad11.png', '底部悬浮广告', '112', 'https://www.ymyuanma.com/', '4', '1555039016', '1554825600', '1594915200', '1', '', '1');
INSERT INTO `ms_advertisement` VALUES ('16', '2', 'http://ys009.ymyuanma.com/XResource/20190412/X2dt2DEXacfPp8zwMdeadeEyjbJ5iJ5Q.png', '首页广告位2', '', 'https://www.ymyuanma.com/', '8', '1555038997', '1554912000', '1624550400', '1', '', '1');
INSERT INTO `ms_advertisement` VALUES ('17', '2', 'http://ys009.ymyuanma.com/XResource/20190412/X2dt2DEXacfPp8zwMdeadeEyjbJ5iJ5Q.png', '视频列表横幅', '', 'https://www.ymyuanma.com/', '9', '1555039619', '1554998400', '1616601600', '1', '', '1');
INSERT INTO `ms_advertisement` VALUES ('18', '2', 'http://ys009.ymyuanma.com/XResource/20190412/X2dt2DEXacfPp8zwMdeadeEyjbJ5iJ5Q.png', '视频播放器下方', '', 'https://www.ymyuanma.com/', '5', '1555050922', '1554998400', '1619107200', '1', '', '1');
INSERT INTO `ms_advertisement` VALUES ('19', '2', 'http://ys009.ymyuanma.com/XResource/20190412/X2dt2DEXacfPp8zwMdeadeEyjbJ5iJ5Q.png', '图片列表横幅', '', 'https://www.ymyuanma.com/', '10', '1555051833', '1554998400', '1603296000', '1', '', '1');
INSERT INTO `ms_advertisement` VALUES ('20', '2', 'http://ys009.ymyuanma.com/XResource/20190412/X2dt2DEXacfPp8zwMdeadeEyjbJ5iJ5Q.png', '文章列表横幅', '', 'https://www.ymyuanma.com/', '11', '1555051841', '1554998400', '1616342400', '1', '', '1');

-- -----------------------------
-- Table structure for `ms_advertisement_position`
-- -----------------------------
DROP TABLE IF EXISTS `ms_advertisement_position`;
CREATE TABLE `ms_advertisement_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '广告标题',
  `width` int(11) DEFAULT NULL COMMENT '广告宽度',
  `height` int(11) DEFAULT NULL COMMENT '广告高度',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告位表';

-- -----------------------------
-- Records of `ms_advertisement_position`
-- -----------------------------
INSERT INTO `ms_advertisement_position` VALUES ('1', '首页广告位1', '1245', '134');
INSERT INTO `ms_advertisement_position` VALUES ('2', '对联-左', '200', '400');
INSERT INTO `ms_advertisement_position` VALUES ('3', '对联-右', '200', '400');
INSERT INTO `ms_advertisement_position` VALUES ('4', '底部悬浮广告', '1000', '70');
INSERT INTO `ms_advertisement_position` VALUES ('5', '视频播放器下方', '920', '99');
INSERT INTO `ms_advertisement_position` VALUES ('6', '收银台右侧广告', '255', '630');
INSERT INTO `ms_advertisement_position` VALUES ('8', '首页广告位2', '1245', '134');
INSERT INTO `ms_advertisement_position` VALUES ('9', '视频列表横幅', '1245', '134');
INSERT INTO `ms_advertisement_position` VALUES ('10', '图片列表横幅', '1245', '134');
INSERT INTO `ms_advertisement_position` VALUES ('11', '文章列表横幅', '1245', '134');

-- -----------------------------
-- Table structure for `ms_agent_apply`
-- -----------------------------
DROP TABLE IF EXISTS `ms_agent_apply`;
CREATE TABLE `ms_agent_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '会员id',
  `apply_time` int(10) NOT NULL COMMENT '申请时间',
  `status` tinyint(1) NOT NULL COMMENT '状态0为拒绝1为通过2为未处理',
  `last_time` int(10) NOT NULL COMMENT '最后处理时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='会员代理审核记录表';

-- -----------------------------
-- Records of `ms_agent_apply`
-- -----------------------------
INSERT INTO `ms_agent_apply` VALUES ('39', '3', '1554349029', '0', '1554349029');
INSERT INTO `ms_agent_apply` VALUES ('40', '4', '1554349133', '1', '1554349166');
INSERT INTO `ms_agent_apply` VALUES ('41', '6', '1554631741', '0', '1554631741');

-- -----------------------------
-- Table structure for `ms_atlas`
-- -----------------------------
DROP TABLE IF EXISTS `ms_atlas`;
CREATE TABLE `ms_atlas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `info` text COMMENT '说明',
  `short_info` varchar(90) DEFAULT NULL COMMENT '短说明',
  `key_word` text COMMENT '关键词',
  `cover` varchar(255) DEFAULT NULL COMMENT '封面',
  `add_time` int(10) DEFAULT NULL COMMENT '上传时间',
  `update_time` int(10) DEFAULT NULL COMMENT '修改时间',
  `gold` int(11) DEFAULT NULL COMMENT '观看需要金币',
  `click` int(11) DEFAULT '0' COMMENT '总点击量',
  `good` int(11) DEFAULT '0' COMMENT '总赞数',
  `user_id` int(11) DEFAULT '0' COMMENT '上传者id',
  `class` text COMMENT '所属分类',
  `tag` text COMMENT '所属标签',
  `status` int(2) DEFAULT '1' COMMENT '状态1为显示，0为隐藏',
  `is_check` int(1) DEFAULT '0' COMMENT '是否审核 。1审核通过，2审核未通过，0待审核',
  `hint` varchar(255) DEFAULT NULL COMMENT '驳回原因',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=630 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='相册表(图集表)';

-- -----------------------------
-- Records of `ms_atlas`
-- -----------------------------
INSERT INTO `ms_atlas` VALUES ('626', '图集01', '&lt;p&gt;&lt;img src=&quot;http://ys009.ymyuanma.com/XResource/20190328/664e45dba98e7dc0fb39ff72da26eb5c.jpg&quot;/&gt;&lt;/p&gt;', '', '', 'http://ys009.ymyuanma.com/XResource/20190328/ZZpB2sQGjBQhn4ysMREWf7cJrBCm3KRF.jpg', '1553769971', '1553770283', '0', '0', '0', '0', '12', '12', '1', '1', '');
INSERT INTO `ms_atlas` VALUES ('628', '标题测试3322', 'asd', '', '', 'http://ys009.ymyuanma.com/XResource/20190328/ZZpB2sQGjBQhn4ysMREWf7cJrBCm3KRF.jpg', '1553841521', '1553841521', '0', '4', '0', '0', '1', '', '1', '1', '');
INSERT INTO `ms_atlas` VALUES ('629', '标题测试3是是是322', 'asd', '', '', 'http://ys009.ymyuanma.com/XResource/20190328/ZZpB2sQGjBQhn4ysMREWf7cJrBCm3KRF.jpg', '1553842089', '1553842089', '0', '7', '0', '0', '4', '', '1', '1', '');

-- -----------------------------
-- Table structure for `ms_atlas_good_log`
-- -----------------------------
DROP TABLE IF EXISTS `ms_atlas_good_log`;
CREATE TABLE `ms_atlas_good_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `atlas_id` int(11) DEFAULT NULL COMMENT '点赞的视频id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `add_time` int(10) DEFAULT NULL COMMENT '点赞时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='图集收藏日志表';


-- -----------------------------
-- Table structure for `ms_atlas_watch_log`
-- -----------------------------
DROP TABLE IF EXISTS `ms_atlas_watch_log`;
CREATE TABLE `ms_atlas_watch_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `atlas_id` int(11) NOT NULL COMMENT '图集id',
  `user_id` int(11) DEFAULT '0' COMMENT '用户Id',
  `user_ip` varchar(15) DEFAULT NULL COMMENT '用户ip',
  `view_time` int(10) NOT NULL COMMENT '观看时间',
  `gold` int(11) DEFAULT NULL COMMENT '消费金币数',
  `is_try_see` int(255) DEFAULT '0' COMMENT '是否为试看，1：试看',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='相册观看日志表';


-- -----------------------------
-- Table structure for `ms_banner`
-- -----------------------------
DROP TABLE IF EXISTS `ms_banner`;
CREATE TABLE `ms_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `images_url` varchar(255) NOT NULL COMMENT '图片url',
  `url` varchar(255) DEFAULT NULL COMMENT '外链',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `info` varchar(255) DEFAULT NULL COMMENT '说明',
  `target` int(1) DEFAULT '1' COMMENT '是否新页面打开1为是，0为否',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='首页banner配置表';

-- -----------------------------
-- Records of `ms_banner`
-- -----------------------------
INSERT INTO `ms_banner` VALUES ('6', '首页AD', 'http://ys009.ymyuanma.com/XResource/20190408/CXisZzjHMzBidJwxtfxk2d3tKQihXPCd.jpg', 'https:/www.ymyuanma.com/', '1', '1', '1', '1');
INSERT INTO `ms_banner` VALUES ('16', 'AD2', 'http://ys009.ymyuanma.com/XResource/20190121/BCyEa5F4hz68wDm4GjpfBTaMte7jN3jZ.jpg', 'https:/www.ymyuanma.com/', '0', '0', '0', '1');

-- -----------------------------
-- Table structure for `ms_card_password`
-- -----------------------------
DROP TABLE IF EXISTS `ms_card_password`;
CREATE TABLE `ms_card_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` varchar(32) DEFAULT NULL COMMENT '卡号',
  `card_type` int(1) DEFAULT NULL COMMENT '卡类型1为vip卡，2为金币卡',
  `out_time` int(11) DEFAULT NULL COMMENT '过期时间',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `status` int(1) DEFAULT '0' COMMENT '状态，0未使用，1已使用',
  `price` int(11) DEFAULT NULL COMMENT '价格金额',
  `gold` int(11) DEFAULT '0' COMMENT '金币数',
  `vip_time` int(11) DEFAULT '0' COMMENT '会员时间，当为永久会员的时候为999999999',
  `use_time` int(11) DEFAULT NULL COMMENT '充值卡使用时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='充值卡';


-- -----------------------------
-- Table structure for `ms_class`
-- -----------------------------
DROP TABLE IF EXISTS `ms_class`;
CREATE TABLE `ms_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL COMMENT '分类名字',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `pid` int(11) DEFAULT '0' COMMENT '父类id',
  `type` int(2) DEFAULT NULL COMMENT '所属模块1为电影，2图片，3小说',
  `last_time` int(11) DEFAULT NULL COMMENT '最后处理时间',
  `read_group` text COMMENT '可读会员组',
  `upload_group` text COMMENT '可上传会员组',
  `status` int(2) DEFAULT '1' COMMENT '状态1开启，0关闭',
  `home_dispay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否首页展示当前分类，1为在首页展示，0为不展示',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=191 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='资源分类表(视频|小说|图片)';

-- -----------------------------
-- Records of `ms_class`
-- -----------------------------
INSERT INTO `ms_class` VALUES ('2', '亚洲', '0', '0', '1', '1553766445', '0', '0', '1', '1');
INSERT INTO `ms_class` VALUES ('3', '王者宣策', '0', '1', '1', '1510725910', '0', '0', '1', '0');
INSERT INTO `ms_class` VALUES ('8', '唐朝小说', '6', '0', '3', '1532682491', '0', '0', '1', '1');
INSERT INTO `ms_class` VALUES ('9', '日韩', '1', '0', '1', '1553767434', '0', '0', '1', '1');
INSERT INTO `ms_class` VALUES ('10', '国产', '2', '0', '1', '1553767468', '0', '0', '1', '1');
INSERT INTO `ms_class` VALUES ('12', '自拍原创', '6', '0', '2', '1528722534', '0', '0', '1', '0');
INSERT INTO `ms_class` VALUES ('13', '贴图区', '0', '0', '2', '1528722552', '0', '0', '1', '0');
INSERT INTO `ms_class` VALUES ('57', '欧美', '3', '0', '1', '1548133256', '0', '0', '1', '1');
INSERT INTO `ms_class` VALUES ('58', 'VIP专区', '4', '0', '1', '1532682987', '0', '0', '1', '1');
INSERT INTO `ms_class` VALUES ('59', '御女', '5', '0', '1', '1532683034', '0', '0', '1', '1');
INSERT INTO `ms_class` VALUES ('60', '学生', '6', '0', '1', '1532683043', '0', '0', '1', '1');
INSERT INTO `ms_class` VALUES ('61', '中文', '7', '0', '1', '1532683064', '0', '0', '1', '1');
INSERT INTO `ms_class` VALUES ('62', '美女图片', '0', '0', '2', '1551006996', '0', '0', '1', '0');

-- -----------------------------
-- Table structure for `ms_comment`
-- -----------------------------
DROP TABLE IF EXISTS `ms_comment`;
CREATE TABLE `ms_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_user` int(11) NOT NULL COMMENT '发送用户id',
  `to_user` int(11) DEFAULT NULL COMMENT '接收用户id（当是回帖的时候存在）',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `resources_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '资源类型',
  `resources_id` int(11) DEFAULT NULL COMMENT '资源id',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态（0为未处理，1为通过，2为拒绝）',
  `add_time` int(10) NOT NULL COMMENT '评论时间',
  `last_time` int(10) DEFAULT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统评论表';

-- -----------------------------
-- Records of `ms_comment`
-- -----------------------------
INSERT INTO `ms_comment` VALUES ('1', '4', '0', '还可以。', '1', '157', '1', '1555424307', '1555424326');

-- -----------------------------
-- Table structure for `ms_domain_cname_binding`
-- -----------------------------
DROP TABLE IF EXISTS `ms_domain_cname_binding`;
CREATE TABLE `ms_domain_cname_binding` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '会员id',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `webhost` varchar(255) DEFAULT NULL COMMENT '域名地址',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态0为未处理，1为已通过，2为已拒绝',
  `last_time` int(11) DEFAULT NULL COMMENT '最后修改的时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='域名绑定表';

-- -----------------------------
-- Records of `ms_domain_cname_binding`
-- -----------------------------
INSERT INTO `ms_domain_cname_binding` VALUES ('7', '4', '1554967836', '123.com', '1', '1554967836');

-- -----------------------------
-- Table structure for `ms_draw_money_account`
-- -----------------------------
DROP TABLE IF EXISTS `ms_draw_money_account`;
CREATE TABLE `ms_draw_money_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `title` varchar(64) DEFAULT NULL COMMENT '标题',
  `type` tinyint(1) DEFAULT '1' COMMENT '收款方式（1.支付宝2银行卡）',
  `account` varchar(64) DEFAULT NULL COMMENT '账号',
  `account_name` varchar(32) DEFAULT NULL COMMENT '收款人姓名',
  `bank` varchar(128) DEFAULT NULL COMMENT '收款卡所属银行',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='提现帐户信息表';


-- -----------------------------
-- Table structure for `ms_draw_money_log`
-- -----------------------------
DROP TABLE IF EXISTS `ms_draw_money_log`;
CREATE TABLE `ms_draw_money_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `gold` int(11) DEFAULT NULL COMMENT '金币数',
  `money` int(11) DEFAULT NULL COMMENT '金额',
  `add_time` int(11) NOT NULL COMMENT '提交时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  `status` int(1) DEFAULT '0' COMMENT '状态（0未处理，1已完成，2已拒绝）',
  `info` text COMMENT '收款信息json（收款方式（支付宝or银行卡），收款账号，银行卡号（收款方式为银行卡的时候存在） ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='提现记录表';


-- -----------------------------
-- Table structure for `ms_gift`
-- -----------------------------
DROP TABLE IF EXISTS `ms_gift`;
CREATE TABLE `ms_gift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT '礼物名称',
  `images` varchar(255) NOT NULL COMMENT '礼物图标',
  `price` int(11) NOT NULL COMMENT '需要的金币数',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `info` varchar(255) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='打赏奖品表';

-- -----------------------------
-- Records of `ms_gift`
-- -----------------------------
INSERT INTO `ms_gift` VALUES ('2', '钻戒', 'http://ys009.ymyuanma.com/XResource/20190130/Hpjc7bmeyxdQMrtZeGtNksJpeAKz8Ji4.gif', '15', '2', '1', '钻戒');
INSERT INTO `ms_gift` VALUES ('7', '玫瑰', 'http://ys009.ymyuanma.com/XResource/20190130/aFthRkMrMSiwAk2Y5bKZ46X5YJMpS45X.gif', '2', '5', '1', '玫瑰');
INSERT INTO `ms_gift` VALUES ('8', '哈雷女郎', 'http://ys009.ymyuanma.com/XResource/20190130/ARNnpmnrhAKdYKXrTepS6ZhJPmZzae8y.gif', '20', '1', '1', '哈雷女郎');
INSERT INTO `ms_gift` VALUES ('9', '亲一个', 'http://ys009.ymyuanma.com/XResource/20190130/ENRNtfCKNeBkQ2YszjEs6brp5axXpxkK.gif', '5', '4', '1', '亲一个');
INSERT INTO `ms_gift` VALUES ('10', '炸弹', 'http://ys009.ymyuanma.com/XResource/20190130/Q5ZwnKEbQQ3nMQDE3CQjkhdJZaR2ePS8.gif', '1', '6', '1', '炸弹');
INSERT INTO `ms_gift` VALUES ('11', '内裤', 'http://ys009.ymyuanma.com/XResource/20190130/7ByA2xTAKrZphChF8Tm2z7apNkbeWbK2.gif', '10', '3', '1', '内裤');

-- -----------------------------
-- Table structure for `ms_gold_log`
-- -----------------------------
DROP TABLE IF EXISTS `ms_gold_log`;
CREATE TABLE `ms_gold_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `gold` int(11) DEFAULT NULL COMMENT '金币数',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `module` varchar(64) DEFAULT NULL COMMENT '来源模块',
  `explain` varchar(255) DEFAULT NULL COMMENT '说明描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=642 DEFAULT CHARSET=utf8 COMMENT='金币明细表';

-- -----------------------------
-- Records of `ms_gold_log`
-- -----------------------------
INSERT INTO `ms_gold_log` VALUES ('608', '1', '1', '1548758233', 'login', '登录奖励');
INSERT INTO `ms_gold_log` VALUES ('609', '1', '1', '1549032462', 'login', '登录奖励');
INSERT INTO `ms_gold_log` VALUES ('610', '0', '300', '1549034132', 'Order', '充值金币');
INSERT INTO `ms_gold_log` VALUES ('611', '2', '50', '1554216136', 'register', '注册奖励');
INSERT INTO `ms_gold_log` VALUES ('612', '2', '-20', '1554216145', 'video', '视频内容扣费');
INSERT INTO `ms_gold_log` VALUES ('613', '2', '-20', '1554216230', 'video', '视频内容扣费');
INSERT INTO `ms_gold_log` VALUES ('614', '2', '1', '1554216399', 'sign', '签到奖励');
INSERT INTO `ms_gold_log` VALUES ('615', '3', '50', '1554349007', 'register', '注册奖励');
INSERT INTO `ms_gold_log` VALUES ('616', '4', '50', '1554349123', 'register', '注册奖励');
INSERT INTO `ms_gold_log` VALUES ('617', '4', '1', '1554364272', 'sign', '签到奖励');
INSERT INTO `ms_gold_log` VALUES ('618', '5', '50', '1554364440', 'register', '注册奖励');
INSERT INTO `ms_gold_log` VALUES ('619', '6', '50', '1554631726', 'register', '注册奖励');
INSERT INTO `ms_gold_log` VALUES ('620', '7', '1', '1554632045', 'login', '登录奖励');
INSERT INTO `ms_gold_log` VALUES ('621', '7', '1', '1554709769', 'login', '登录奖励');
INSERT INTO `ms_gold_log` VALUES ('622', '7', '1', '1554709774', 'sign', '签到奖励');
INSERT INTO `ms_gold_log` VALUES ('623', '4', '1', '1554967088', 'login', '登录奖励');
INSERT INTO `ms_gold_log` VALUES ('624', '4', '1', '1554967094', 'sign', '签到奖励');
INSERT INTO `ms_gold_log` VALUES ('625', '4', '-20', '1554968569', 'video', '视频内容扣费');
INSERT INTO `ms_gold_log` VALUES ('626', '4', '-20', '1554968640', 'video', '视频内容扣费');
INSERT INTO `ms_gold_log` VALUES ('627', '4', '-1', '1554971769', 'reward', '打赏消费');
INSERT INTO `ms_gold_log` VALUES ('628', '4', '1', '1555424282', 'login', '登录奖励');
INSERT INTO `ms_gold_log` VALUES ('629', '4', '-1', '1555424337', 'reward', '打赏消费');
INSERT INTO `ms_gold_log` VALUES ('630', '4', '1', '1555468571', 'login', '登录奖励');
INSERT INTO `ms_gold_log` VALUES ('631', '4', '1', '1555469549', 'sign', '签到奖励');
INSERT INTO `ms_gold_log` VALUES ('632', '4', '1', '1555578831', 'login', '登录奖励');
INSERT INTO `ms_gold_log` VALUES ('633', '4', '1', '1555901998', 'login', '登录奖励');
INSERT INTO `ms_gold_log` VALUES ('634', '4', '1', '1555919534', 'sign', '签到奖励');
INSERT INTO `ms_gold_log` VALUES ('635', '0', '10', '1555919808', 'Order', '充值金币');
INSERT INTO `ms_gold_log` VALUES ('636', '0', '10', '1555920461', 'Order', '充值金币');
INSERT INTO `ms_gold_log` VALUES ('637', '7', '1', '1556008637', 'login', '登录奖励');
INSERT INTO `ms_gold_log` VALUES ('638', '1', '1', '1556019976', 'login', '登录奖励');
INSERT INTO `ms_gold_log` VALUES ('639', '8', '10', '1556027075', 'register', '注册奖励');
INSERT INTO `ms_gold_log` VALUES ('640', '8', '1', '1556027084', 'sign', '签到奖励');
INSERT INTO `ms_gold_log` VALUES ('641', '9', '10', '1556027266', 'register', '注册奖励');

-- -----------------------------
-- Table structure for `ms_gold_package`
-- -----------------------------
DROP TABLE IF EXISTS `ms_gold_package`;
CREATE TABLE `ms_gold_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '套餐名称',
  `price` double(10,2) DEFAULT NULL COMMENT '价格',
  `gold` int(11) DEFAULT NULL COMMENT '金币个数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='金币套餐';

-- -----------------------------
-- Records of `ms_gold_package`
-- -----------------------------
INSERT INTO `ms_gold_package` VALUES ('6', '300金币', '30', '300');
INSERT INTO `ms_gold_package` VALUES ('8', '500金币', '50', '500');
INSERT INTO `ms_gold_package` VALUES ('9', '1000金币', '100', '1000');
INSERT INTO `ms_gold_package` VALUES ('10', '3000金币', '300', '3000');

-- -----------------------------
-- Table structure for `ms_gratuity_record`
-- -----------------------------
DROP TABLE IF EXISTS `ms_gratuity_record`;
CREATE TABLE `ms_gratuity_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `gratuity_time` int(10) NOT NULL COMMENT '打赏时间',
  `gift_info` varchar(255) NOT NULL COMMENT '打赏礼物信息json，包含礼物名称，礼物费用',
  `content_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '打赏内容类型 1:视频 2:图片 3:小说',
  `content_id` int(11) NOT NULL COMMENT '打赏内容id',
  `price` int(10) NOT NULL DEFAULT '0' COMMENT '打赏价格',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=398 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='打赏记录表';

-- -----------------------------
-- Records of `ms_gratuity_record`
-- -----------------------------
INSERT INTO `ms_gratuity_record` VALUES ('396', '4', '1554971769', '{\"id\":10,\"name\":\"\\u70b8\\u5f39\",\"images\":\"http:\\/\\/ys009.ymyuanma.com\\/XResource\\/20190130\\/Q5ZwnKEbQQ3nMQDE3CQjkhdJZaR2ePS8.gif\",\"price\":1,\"info\":\"\\u70b8\\u5f39\"}', '1', '47', '1');
INSERT INTO `ms_gratuity_record` VALUES ('397', '4', '1555424336', '{\"id\":10,\"name\":\"\\u70b8\\u5f39\",\"images\":\"http:\\/\\/ys009.ymyuanma.com\\/XResource\\/20190130\\/Q5ZwnKEbQQ3nMQDE3CQjkhdJZaR2ePS8.gif\",\"price\":1,\"info\":\"\\u70b8\\u5f39\"}', '1', '157', '1');

-- -----------------------------
-- Table structure for `ms_image`
-- -----------------------------
DROP TABLE IF EXISTS `ms_image`;
CREATE TABLE `ms_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `atlas_id` int(11) DEFAULT NULL COMMENT '图集id',
  `info` text COMMENT '说明',
  `url` varchar(255) DEFAULT NULL COMMENT '链接',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(2) DEFAULT '1' COMMENT '显示隐藏',
  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='图片表';

-- -----------------------------
-- Records of `ms_image`
-- -----------------------------
INSERT INTO `ms_image` VALUES ('71', '', '626', '', 'http://ys009.ymyuanma.com/XResource/20190328/sj5GG4dMWznftnNkCmfX4bMAGbE4cmFj.jpg', '0', '1', '1553770063');
INSERT INTO `ms_image` VALUES ('72', '', '626', '', 'http://ys009.ymyuanma.com/XResource/20190328/TeNhsZsMBnDCt5erS5PD78EQyBPGRTXA.jpg', '0', '1', '1553770063');
INSERT INTO `ms_image` VALUES ('73', '', '626', '', 'http://ys009.ymyuanma.com/XResource/20190328/JRymPaxtQx3FeDDprj567NtzNRWYj5jH.jpg', '0', '1', '1553770063');
INSERT INTO `ms_image` VALUES ('74', '', '626', '', 'http://ys009.ymyuanma.com/XResource/20190328/pkXYRScXHr7rWN6x3y5c8McNRESY3xW4.jpg', '0', '1', '1553770063');
INSERT INTO `ms_image` VALUES ('75', '', '626', '', 'http://ys009.ymyuanma.com/XResource/20190328/c3AjGejpXHAEMXPixXXjBwbDz4efHA5f.jpg', '0', '1', '1553770063');
INSERT INTO `ms_image` VALUES ('76', '', '626', '', 'http://ys009.ymyuanma.com/XResource/20190328/PEfHSAt3x2j6kCSYaCRbzztf5tFnehA8.jpg', '0', '1', '1553770063');
INSERT INTO `ms_image` VALUES ('77', '', '626', '', 'http://ys009.ymyuanma.com/XResource/20190328/jeiaStStZFXt5h8Pt3wK63MYd72Wd36f.jpg', '0', '1', '1553770063');
INSERT INTO `ms_image` VALUES ('78', '图片1', '628', '', 'http://ys009.ymyuanma.com/XResource/20190328/ZZpB2sQGjBQhn4ysMREWf7cJrBCm3KRF.jpg', '0', '1', '1553841521');
INSERT INTO `ms_image` VALUES ('79', '图片2', '628', '', 'http://ys009.ymyuanma.com/XResource/20190328/ZZpB2sQGjBQhn4ysMREWf7cJrBCm3KRF.jpg', '0', '1', '1553841521');
INSERT INTO `ms_image` VALUES ('80', '图片3', '628', '', 'http://ys009.ymyuanma.com/XResource/20190328/ZZpB2sQGjBQhn4ysMREWf7cJrBCm3KRF.jpg', '0', '1', '1553841521');
INSERT INTO `ms_image` VALUES ('81', '图片1', '629', '', 'http://ys009.ymyuanma.com/XResource/20190328/ZZpB2sQGjBQhn4ysMREWf7cJrBCm3KRF.jpg', '0', '1', '1553842089');
INSERT INTO `ms_image` VALUES ('82', '图片2', '629', '', 'http://ys009.ymyuanma.com/XResource/20190328/ZZpB2sQGjBQhn4ysMREWf7cJrBCm3KRF.jpg', '0', '1', '1553842089');
INSERT INTO `ms_image` VALUES ('83', '图片3', '629', '', 'http://ys009.ymyuanma.com/XResource/20190328/ZZpB2sQGjBQhn4ysMREWf7cJrBCm3KRF.jpg', '0', '1', '1553842089');

-- -----------------------------
-- Table structure for `ms_image_collection`
-- -----------------------------
DROP TABLE IF EXISTS `ms_image_collection`;
CREATE TABLE `ms_image_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `image_id` int(11) DEFAULT NULL COMMENT '图片id',
  `collection_time` int(11) DEFAULT NULL COMMENT '收藏时间',
  `atlas_id` int(11) DEFAULT NULL COMMENT '所属客户图集',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='图片收藏表';

-- -----------------------------
-- Records of `ms_image_collection`
-- -----------------------------
INSERT INTO `ms_image_collection` VALUES ('1', '3', '157', '1516424614', '2');
INSERT INTO `ms_image_collection` VALUES ('2', '3', '157', '1516424619', '1');
INSERT INTO `ms_image_collection` VALUES ('3', '3', '789', '1516585537', '2');
INSERT INTO `ms_image_collection` VALUES ('4', '3', '84', '1516605188', '2');
INSERT INTO `ms_image_collection` VALUES ('5', '3', '1332', '1516805829', '2');
INSERT INTO `ms_image_collection` VALUES ('6', '20', '6677', '1516873419', '44');
INSERT INTO `ms_image_collection` VALUES ('7', '20', '677', '1516873457', '44');
INSERT INTO `ms_image_collection` VALUES ('8', '3', '194', '1517746126', '3');
INSERT INTO `ms_image_collection` VALUES ('9', '3', '8015', '1517746164', '2');
INSERT INTO `ms_image_collection` VALUES ('10', '4', '82', '1554967208', '45');

-- -----------------------------
-- Table structure for `ms_login_log`
-- -----------------------------
DROP TABLE IF EXISTS `ms_login_log`;
CREATE TABLE `ms_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `login_time` int(10) DEFAULT NULL COMMENT '登录时间',
  `ip` varchar(32) DEFAULT NULL COMMENT 'ip',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=832 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='登陆日志表';

-- -----------------------------
-- Records of `ms_login_log`
-- -----------------------------
INSERT INTO `ms_login_log` VALUES ('808', '1', '1548758233', '117.42.189.114');
INSERT INTO `ms_login_log` VALUES ('809', '1', '1548758549', '117.42.189.114');
INSERT INTO `ms_login_log` VALUES ('810', '1', '1548768249', '182.108.171.164');
INSERT INTO `ms_login_log` VALUES ('811', '1', '1549032462', '182.87.244.11');
INSERT INTO `ms_login_log` VALUES ('812', '7', '1554632045', '110.54.203.241');
INSERT INTO `ms_login_log` VALUES ('813', '7', '1554709769', '223.73.222.121');
INSERT INTO `ms_login_log` VALUES ('814', '7', '1554709966', '223.73.222.121');
INSERT INTO `ms_login_log` VALUES ('815', '7', '1554714686', '223.73.222.121');
INSERT INTO `ms_login_log` VALUES ('816', '7', '1554720069', '223.73.222.121');
INSERT INTO `ms_login_log` VALUES ('817', '7', '1554720314', '223.73.222.121');
INSERT INTO `ms_login_log` VALUES ('818', '7', '1554720453', '223.73.222.121');
INSERT INTO `ms_login_log` VALUES ('819', '7', '1554720564', '223.73.222.121');
INSERT INTO `ms_login_log` VALUES ('820', '7', '1554720828', '223.73.222.121');
INSERT INTO `ms_login_log` VALUES ('821', '7', '1554738780', '113.71.36.123');
INSERT INTO `ms_login_log` VALUES ('822', '4', '1554967088', '223.73.222.18');
INSERT INTO `ms_login_log` VALUES ('823', '4', '1554968563', '223.73.222.18');
INSERT INTO `ms_login_log` VALUES ('824', '4', '1554971734', '223.73.222.18');
INSERT INTO `ms_login_log` VALUES ('825', '4', '1555424282', '14.213.133.19');
INSERT INTO `ms_login_log` VALUES ('826', '4', '1555468571', '223.73.222.171');
INSERT INTO `ms_login_log` VALUES ('827', '4', '1555578831', '47.91.220.217');
INSERT INTO `ms_login_log` VALUES ('828', '4', '1555901998', '223.73.222.115');
INSERT INTO `ms_login_log` VALUES ('829', '7', '1556008637', '223.73.222.22');
INSERT INTO `ms_login_log` VALUES ('830', '7', '1556012635', '223.73.222.22');
INSERT INTO `ms_login_log` VALUES ('831', '1', '1556019976', '117.42.9.225');

-- -----------------------------
-- Table structure for `ms_login_setting`
-- -----------------------------
DROP TABLE IF EXISTS `ms_login_setting`;
CREATE TABLE `ms_login_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_code` varchar(50) NOT NULL COMMENT '登录方式的code',
  `login_name` varchar(255) NOT NULL COMMENT '登录名称',
  `config` text COMMENT '登录方式配置信息',
  `status` int(1) DEFAULT '1' COMMENT '是否开户，1：开启，0：关闭',
  `add_time` int(10) DEFAULT NULL COMMENT '安装时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='支付配置表';

-- -----------------------------
-- Records of `ms_login_setting`
-- -----------------------------
INSERT INTO `ms_login_setting` VALUES ('1', 'qq', 'QQ登录', '[{\"name\":\"APPID\",\"type\":\"text\",\"value\":\"01459043\",\"desc\":\"APPID\"},{\"name\":\"APPKey\",\"type\":\"text\",\"value\":\"e4f10c0c0404bf61de486cf1ec717be\",\"desc\":\"APPKey\"}]', '0', '1514888879', '1519263473');
INSERT INTO `ms_login_setting` VALUES ('2', 'wechat', '微信登录', '[{\"name\":\"APPID\",\"type\":\"text\",\"value\":\"asdada\",\"desc\":\"APPID\"},{\"name\":\"APPKey\",\"type\":\"text\",\"value\":\"23242342\",\"desc\":\"APPKey\"}]', '0', '1514888906', '1515029281');

-- -----------------------------
-- Table structure for `ms_member`
-- -----------------------------
DROP TABLE IF EXISTS `ms_member`;
CREATE TABLE `ms_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT '1' COMMENT '所属会员组id,1:普通会员，2:vip会员',
  `username` varchar(32) NOT NULL COMMENT '账号',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `tel` varchar(13) DEFAULT NULL COMMENT '手机',
  `nickname` varchar(64) DEFAULT NULL COMMENT '昵称',
  `headimgurl` varchar(255) DEFAULT NULL COMMENT '头像',
  `email` varchar(64) DEFAULT NULL COMMENT '邮件',
  `money` int(11) DEFAULT '0' COMMENT '金币',
  `out_time` bigint(10) DEFAULT NULL COMMENT '过期时间',
  `is_agent` tinyint(1) DEFAULT '0' COMMENT '是否是代理商,0:不是，1：是',
  `is_permanent` tinyint(1) DEFAULT '0' COMMENT '是否永久用户',
  `add_time` int(10) NOT NULL COMMENT '添加时间',
  `last_time` int(10) DEFAULT NULL COMMENT '最后登录时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别1为男2为女',
  `last_ip` varchar(20) DEFAULT NULL COMMENT '最后登录的ip',
  `login_count` int(11) DEFAULT '0' COMMENT '登录次数',
  `agent_config` varchar(500) DEFAULT NULL COMMENT '代理相关站点设置',
  `access_token` varchar(32) DEFAULT NULL COMMENT '验证token',
  `pid` int(11) NOT NULL COMMENT '代理商id',
  `openid` varchar(255) DEFAULT NULL COMMENT '第三方登录openid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='会员信息表';

-- -----------------------------
-- Records of `ms_member`
-- -----------------------------
INSERT INTO `ms_member` VALUES ('1', '1', 'admin', 'a15e2ce635da5f36bcf51007009ccd8f', '', '管理员', '/static/images/user_dafault_headimg.jpg', '', '355', '1590938195', '1', '0', '1548035650', '1556019976', '1', '0', '117.42.9.225', '2', 'a:6:{s:11:\"domain_name\";s:0:\"\";s:10:\"site_title\";s:0:\"\";s:13:\"site_keywords\";s:0:\"\";s:16:\"site_description\";s:0:\"\";s:9:\"site_logo\";s:0:\"\";s:16:\"site_logo_mobile\";s:0:\"\";}', '0de2e8e196190a0d5cbb7786f00f7805', '0', '');
INSERT INTO `ms_member` VALUES ('2', '1', '50014909', '3ab238d835468497a8d9d8c16b3459e5', '', '50014909', '/static/images/user_dafault_headimg.jpg', '', '11', '0', '0', '0', '1554216136', '1554216136', '1', '0', '', '0', '', '001308076c7c231bb97890613b724b2e', '0', '');
INSERT INTO `ms_member` VALUES ('3', '1', 'williams99', 'd477887b0636e5d87f79cc25c99d7dc9', '', 'williams99', '/static/images/user_dafault_headimg.jpg', '', '50', '0', '0', '0', '1554349007', '1554349007', '1', '0', '', '0', '', '59a8d8e0887748cece06f7de0460b462', '0', '');
INSERT INTO `ms_member` VALUES ('4', '1', 'qwe123', '130811dbd239c97bd9ce933de7349f20', '', 'qwe123', '/static/images/user_dafault_headimg.jpg', '', '37', '1556524798', '1', '0', '1554349123', '1555901998', '1', '0', '223.73.222.115', '2', 'a:6:{s:11:\"domain_name\";s:7:\"123.com\";s:10:\"site_title\";s:0:\"\";s:13:\"site_keywords\";s:0:\"\";s:16:\"site_description\";s:0:\"\";s:9:\"site_logo\";s:0:\"\";s:16:\"site_logo_mobile\";s:0:\"\";}', 'e3bc459a08a475dcc61aa010f597753e', '0', '');
INSERT INTO `ms_member` VALUES ('5', '1', 'qwe456', '027c63753299d9a2b2979e1a198f1548', '', 'qwe456', '/static/images/user_dafault_headimg.jpg', '', '50', '0', '0', '0', '1554364440', '1554364440', '1', '0', '', '0', '', 'f74d47da035d1b6456dc86352fd270dc', '0', '');
INSERT INTO `ms_member` VALUES ('6', '1', 'web123321', '9db06bcff9248837f86d1a6bcf41c9e7', '', '1', '/static/images/user_dafault_headimg.jpg', '', '50', '0', '0', '0', '1554631726', '1554631726', '1', '0', '', '0', '', '1926ae3331d6b6c46c9394c1608d35c3', '0', '');
INSERT INTO `ms_member` VALUES ('7', '1', 'ymyuanma', '5633aa295caba27a57652323190f2854', '', 'ymyuanma', '', 'ymyuanma', '4', '0', '1', '1', '1554631865', '1556012635', '1', '1', '223.73.222.22', '2', '', 'da836a6adc1005aa63558cd6773cf5c6', '0', '');
INSERT INTO `ms_member` VALUES ('8', '1', 'qwe777@126.com', '130811dbd239c97bd9ce933de7349f20', '', 'qwe777', '/static/images/user_dafault_headimg.jpg', 'qwe777@126.com', '11', '0', '0', '0', '1556027075', '1556027075', '1', '0', '', '0', '', '860c0aade1958a590c128db3e19a37e1', '0', '');
INSERT INTO `ms_member` VALUES ('9', '1', '205687930@qq.com', '305fe71663ce896c427ce505fdceb903', '', 'bsk888', '/static/images/user_dafault_headimg.jpg', '205687930@qq.com', '10', '0', '0', '0', '1556027266', '1556027266', '1', '0', '', '0', '', '75b91b39b4766d8597b0ed8fc78efeee', '0', '');

-- -----------------------------
-- Table structure for `ms_member_copy`
-- -----------------------------
DROP TABLE IF EXISTS `ms_member_copy`;
CREATE TABLE `ms_member_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT '1' COMMENT '所属会员组id,1:普通会员，2:vip会员',
  `username` varchar(32) NOT NULL COMMENT '账号',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `tel` varchar(13) DEFAULT NULL COMMENT '手机',
  `nickname` varchar(64) DEFAULT NULL COMMENT '昵称',
  `headimgurl` varchar(255) DEFAULT NULL COMMENT '头像',
  `email` varchar(64) DEFAULT NULL COMMENT '邮件',
  `money` int(11) DEFAULT '0' COMMENT '金币',
  `out_time` bigint(10) DEFAULT NULL COMMENT '过期时间',
  `is_agent` tinyint(1) DEFAULT '0' COMMENT '是否是代理商,0:不是，1：是',
  `is_permanent` tinyint(1) DEFAULT '0' COMMENT '是否永久用户',
  `add_time` int(10) NOT NULL COMMENT '添加时间',
  `last_time` int(10) DEFAULT NULL COMMENT '最后登录时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别1为男2为女',
  `last_ip` varchar(20) DEFAULT NULL COMMENT '最后登录的ip',
  `login_count` int(11) DEFAULT '0' COMMENT '登录次数',
  `agent_config` varchar(500) DEFAULT NULL COMMENT '代理相关站点设置',
  `access_token` varchar(32) DEFAULT NULL COMMENT '验证token',
  `pid` int(11) NOT NULL COMMENT '代理商id',
  `openid` varchar(255) DEFAULT NULL COMMENT '第三方登录openid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='会员信息表';

-- -----------------------------
-- Records of `ms_member_copy`
-- -----------------------------
INSERT INTO `ms_member_copy` VALUES ('1', '1', 'admin', 'a15e2ce635da5f36bcf51007009ccd8f', '', '管理员', '/static/images/user_dafault_headimg.jpg', '', '52', '0', '1', '0', '1548035650', '1548166490', '1', '0', '117.42.9.89', '2', 'a:6:{s:11:\"domain_name\";s:0:\"\";s:10:\"site_title\";s:0:\"\";s:13:\"site_keywords\";s:0:\"\";s:16:\"site_description\";s:0:\"\";s:9:\"site_logo\";s:0:\"\";s:16:\"site_logo_mobile\";s:0:\"\";}', 'cb7f94e9aa8b837b3b4eed9a7c3c70c3', '0', '');

-- -----------------------------
-- Table structure for `ms_menu`
-- -----------------------------
DROP TABLE IF EXISTS `ms_menu`;
CREATE TABLE `ms_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT '0' COMMENT '父级菜单id',
  `name` varchar(32) DEFAULT NULL COMMENT '菜单名字',
  `url` varchar(255) DEFAULT NULL COMMENT '菜单链接',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(11) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '类型1为url为地址，2为url为分类id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='前端菜单表';

-- -----------------------------
-- Records of `ms_menu`
-- -----------------------------
INSERT INTO `ms_menu` VALUES ('2', '1', '王者荣耀', '{\"cid\":2,\"type\":1}', '1', '1', '2');
INSERT INTO `ms_menu` VALUES ('4', '1', '嘎嘎嘎', '{\"cid\":2,\"type\":1}', '0', '0', '2');
INSERT INTO `ms_menu` VALUES ('5', '1', '汪汪', '2', '0', '0', '2');
INSERT INTO `ms_menu` VALUES ('7', '1', '111', '{\"cid\":8,\"type\":1}', '0', '0', '2');
INSERT INTO `ms_menu` VALUES ('12', '11', '最新视频', '{\"cid\":\"2\",\"type\":1}', '0', '1', '2');
INSERT INTO `ms_menu` VALUES ('14', '13', '鲁班小说', '{\"cid\":\"11\",\"type\":3}', '0', '1', '2');
INSERT INTO `ms_menu` VALUES ('17', '16', '最新图片', '{\"cid\":\"3\",\"type\":2}', '0', '1', '2');
INSERT INTO `ms_menu` VALUES ('21', '11', '最热视频', '{\"cid\":\"10\",\"type\":1}', '0', '1', '2');
INSERT INTO `ms_menu` VALUES ('22', '11', '测试视频', '{\"cid\":\"10\",\"type\":1}', '0', '1', '2');
INSERT INTO `ms_menu` VALUES ('23', '11', '女娲展示', '{\"cid\":\"14\",\"type\":1}', '0', '1', '2');
INSERT INTO `ms_menu` VALUES ('24', '11', '百度', 'http://www.baidu.com', '0', '1', '1');
INSERT INTO `ms_menu` VALUES ('25', '0', '首页', '/', '0', '1', '1');
INSERT INTO `ms_menu` VALUES ('26', '0', '视频', '{\"cid\":\"video\"}', '1', '1', '2');
INSERT INTO `ms_menu` VALUES ('33', '0', '图区', '{\"cid\":\"images\"}', '3', '1', '2');
INSERT INTO `ms_menu` VALUES ('63', '60', '高分电影', '{\"cid\":\"54\",\"type\":1}', '0', '1', '2');
INSERT INTO `ms_menu` VALUES ('64', '60', '成人影院', '{\"cid\":\"55\",\"type\":1}', '0', '1', '2');
INSERT INTO `ms_menu` VALUES ('70', '0', '唐朝小说', '{\"cid\":\"novel\"}', '2', '1', '2');
INSERT INTO `ms_menu` VALUES ('71', '0', 'APP下载', '#', '4', '1', '1');
INSERT INTO `ms_menu` VALUES ('72', '26', '国产', '{\"cid\":\"10\",\"type\":1}', '3', '1', '2');
INSERT INTO `ms_menu` VALUES ('73', '26', '欧美', '{\"cid\":\"57\",\"type\":1}', '4', '1', '2');
INSERT INTO `ms_menu` VALUES ('74', '26', '中文', '{\"cid\":\"61\",\"type\":1}', '5', '1', '2');
INSERT INTO `ms_menu` VALUES ('75', '26', 'VIP专区', '{\"cid\":\"58\",\"type\":1}', '6', '1', '2');
INSERT INTO `ms_menu` VALUES ('76', '26', '御女', '{\"cid\":\"59\",\"type\":1}', '7', '1', '2');
INSERT INTO `ms_menu` VALUES ('77', '26', '亚洲', '{\"cid\":\"2\",\"type\":1}', '1', '1', '2');
INSERT INTO `ms_menu` VALUES ('78', '26', '日韩', '{\"cid\":\"9\",\"type\":1}', '2', '1', '2');
INSERT INTO `ms_menu` VALUES ('79', '26', '学生', '{\"cid\":\"6\",\"type\":1}', '8', '1', '2');

-- -----------------------------
-- Table structure for `ms_notice`
-- -----------------------------
DROP TABLE IF EXISTS `ms_notice`;
CREATE TABLE `ms_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text COMMENT '内容',
  `out_time` bigint(20) DEFAULT NULL COMMENT '过期时间',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  `sort` tinyint(1) DEFAULT NULL COMMENT '排序',
  `type` tinyint(1) DEFAULT NULL COMMENT '内容展示方式1为弹出层，2为页面转跳',
  `url` varchar(255) DEFAULT NULL COMMENT '转跳网址',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='公告数据表格';

-- -----------------------------
-- Records of `ms_notice`
-- -----------------------------
INSERT INTO `ms_notice` VALUES ('1', '网站公告001', '                                                V10版本全新架构，后台操作更加简洁,让您更轻松，有效的管理您的网站，告别之前版本繁琐复杂的操作。        ', '1571241600', '1', '0', '1', '');
INSERT INTO `ms_notice` VALUES ('2', '网站公告002', '            网站公告002            ', '1581350400', '1', '0', '1', '&lt;NULL&gt;');
INSERT INTO `ms_notice` VALUES ('3', '网站公告003', '网站公告003', '1550678400', '1', '0', '1', '');
INSERT INTO `ms_notice` VALUES ('4', '网站公告004', '            网站公告004          ', '1550160000', '1', '0', '1', '');
INSERT INTO `ms_notice` VALUES ('5', '网站公告005', '            网站公告005           ', '1526227200', '1', '0', '1', '');
INSERT INTO `ms_notice` VALUES ('6', '网站公告006', '网站公告006', '0', '1', '0', '1', '');
INSERT INTO `ms_notice` VALUES ('7', '网站公告007', '网站公告007', '0', '1', '0', '1', '');
INSERT INTO `ms_notice` VALUES ('8', '网站公告008', '网站公告008 ', '0', '1', '0', '1', '');

-- -----------------------------
-- Table structure for `ms_novel`
-- -----------------------------
DROP TABLE IF EXISTS `ms_novel`;
CREATE TABLE `ms_novel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` text COMMENT '说明',
  `short_info` varchar(90) DEFAULT NULL COMMENT '短说明',
  `key_word` text COMMENT '关键词',
  `thumbnail` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `add_time` int(10) DEFAULT '0' COMMENT '添加',
  `status` int(2) DEFAULT '1' COMMENT '显示隐藏',
  `update_time` int(10) DEFAULT '0' COMMENT '修改时间',
  `click` int(11) DEFAULT '0' COMMENT '总点击量',
  `good` int(11) DEFAULT '0' COMMENT '总点赞数',
  `user_id` int(11) DEFAULT '0' COMMENT '上传者id',
  `class` text COMMENT '所属分类',
  `tag` text COMMENT '所属标签',
  `gold` int(11) DEFAULT NULL COMMENT '观看金币',
  `is_check` int(1) DEFAULT '0' COMMENT '是否审核 。1审核通过，2审核未通过，0待审核',
  `hint` varchar(255) DEFAULT NULL COMMENT '驳回原因',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='小说表';

-- -----------------------------
-- Records of `ms_novel`
-- -----------------------------
INSERT INTO `ms_novel` VALUES ('1', '民间笑话荟萃', '&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;1。&lt;a href=&quot;http://www.duwenzhang.com/huati/laogong/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;老公&lt;/a&gt;发工资了，拿回家准备讨好&lt;a href=&quot;http://www.duwenzhang.com/huati/laopo/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;老婆&lt;/a&gt;。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　就对他的老婆说：“亲爱的，我发工资了。亲我一下钱归你了。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　老婆迟迟无动于衷。老公见老婆没有反应。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　又喊了一句：“你要是再不来我就去找人伺候我了，把钱都给她了。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　老婆淡淡地回了一句：“你要是敢去，这些钱你是怎么花的，我就怎么赚回来。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　2。&lt;a href=&quot;http://www.duwenzhang.com/huati/laopo/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;妻子&lt;/a&gt;突然问&lt;a href=&quot;http://www.duwenzhang.com/huati/laogong/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;丈夫&lt;/a&gt;：“你爱我吗？” “爱，当然爱！”丈夫毫不犹豫地回答。 妻子想了想又问：“你是不是怕&lt;a href=&quot;http://www.duwenzhang.com/huati/shanghai/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;伤害&lt;/a&gt;我才说的？” 丈夫连忙说：“不，不，我是怕你伤害我才说的。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　3。小明数学不好被&lt;a href=&quot;http://www.duwenzhang.com/huati/fumu/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;父母&lt;/a&gt;转学到一间教会学校。半年后数学成绩全A。&lt;a href=&quot;http://www.duwenzhang.com/huati/muqin/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;妈妈&lt;/a&gt;问：“是修女教得好？是教材好？是祷告？……”“都不是，”小明说，“进学校的第一天，我看见一个人被钉死在加号上面，我就知道……他们是玩真的。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　4。在公厕里，忽然听到厕间有人说话：“哥们儿，有手纸吗？”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　我翻了翻口袋：“抱歉，没有。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　过了几秒钟，那人又问：“那有小块报纸吗？”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　我&lt;a href=&quot;http://www.duwenzhang.com/huati/wunai/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;无奈&lt;/a&gt;地一笑：“对不起，没有，我只是来小便的。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　又过了几秒钟，厕间门缝塞出一张10元人民币：“能帮我换成10张1块的吗？”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　我把钱递过去，厕间里传来一声咆哮：“你别给我十个硬币啊！”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　5。 20年前&lt;a href=&quot;http://www.duwenzhang.com/huati/fuqin/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;爸爸&lt;/a&gt;抱着你等车，人都笑话&lt;a href=&quot;http://www.duwenzhang.com/huati/haizi/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;孩子&lt;/a&gt;长得难看，爸爸哭了。一卖香蕉的老大爷拍拍爸爸说：“大&lt;a href=&quot;http://www.duwenzhang.com/huati/xiongdi/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;兄弟&lt;/a&gt;别哭了，拿只香蕉给猴子吃吧！真可怜，饿的都没毛了。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　6。 话说某位女士一时兴起，买了一只母鹦鹉。没想到带回家里，它说的第一句话就是：“想跟我上床吗？”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　女士一听，心想：坏了，外人还以为这话是我教的呢， 这不把我的淑女形象全给毁了。于是她想尽办法，想交那只鹦鹉说些高雅的东西，可是那只母鹦鹉算是铁了心了，只会说一句话：“想跟我上床吗？”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　……怎么办呢？在那位女士&lt;a href=&quot;http://www.duwenzhang.com/huati/shiqu/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;失去&lt;/a&gt;主张的时候，听说神父那儿也养了一只鹦鹉（公的），而且那只鹦鹉，不但不讲粗话，反而是个虔诚的教徒，每天大部分&lt;a href=&quot;http://www.duwenzhang.com/huati/shijian/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;时间&lt;/a&gt;里都在祷告。于是那位女士去找神父求助。神父明白她的来意之后，面色微难的说：“这个，很难办呀，其实那只鹦鹉，也并没有刻意的教它什么，它之所以这么虔诚，也可能是长期在此受熏陶的缘故吧。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　神父见女士很失落，便说道：“这样吧，你把那只鹦鹉带到我这里来，我把它们放在一起。&lt;a href=&quot;http://www.duwenzhang.com/huati/xiwang/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;希望&lt;/a&gt;经过一段时间，你那只鹦鹉能够被感化。我只能做这些了，有没有效果，就看神的旨意了……”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　女士一听，也只能这样了，不是有句话叫：近朱者赤吗？试试吧。于是她把鹦鹉带到神父那里。神父依照诺言把两只鹦鹉放在了一起。开始母鹦鹉还有些拘谨，看那只公鹦鹉在笼子的一角，默默的祷告，还真不忍心打扰。可是她还是管不住自己，终于朗声说道：“想跟我上床吗？“&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　公鹦鹉听到这话，停止了祷告，转身看了看母鹦鹉，忽然泪如雨下：“感谢上帝，我祷告这么多年的&lt;a href=&quot;http://www.duwenzhang.com/huati/yuanwang/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;愿望&lt;/a&gt;终于实现了……”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　7。青年跋涉深山，历经险阻，终于找到了隐居山中的禅师，他迫不及待地问道：“我长得丑，我该怎么办？”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　“长得丑就应该像我一样。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　青年点点头：“心如止水，独善其身？”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　“不，长得丑就要像我一样赶紧找个深山躲起来。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　8。本人女，以前一百四十多斤，现在瘦下来了。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　某日准备出门找不到电话了，于是拿老爸电话打我电话，打过去老爸电话上华丽丽地显示了“大肥猪”三个字。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　9。突然停电了，“大热的天，还让不让人活了，真烦人。”我抱怨道。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　儿子却在一旁笑呵呵地说：“我觉得停电也挺好的。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　听他这么说，就更加来气了：“大热天的，停电有啥好处啊？就知道瞎说！”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　儿子被我训得低下头，小声嘟囔道：“停电我就不用做作业了呗……”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　10。 渔夫晚上捕鱼回来，看见儿子正与邻居家的姑娘披着渔网在亲热，渔夫怒问：你们这是干嘛？&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　儿笑笑，说：老爸，你不懂，我们这叫网恋！&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　11。一次学校让买学习资料，大家都是7块钱，我为了让自己能有点零用钱花一张嘴就要了10块，结果老妈不信我，就跑去问家对面的同班同学，当时那心里忐忑的差点就说实话了。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　没想到老妈一回来就说：“一看上课就没听&lt;a href=&quot;http://www.duwenzhang.com/huati/laoshi/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;老师&lt;/a&gt;讲课，人家明明是12块！”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　12。 地铁人满为患，可那些&lt;a href=&quot;http://www.duwenzhang.com/huati/nvhai/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;女孩&lt;/a&gt;宁愿站着也不愿意坐我身边的空位。直到我到站了也没人来坐。“难道因为我的帅让她们小鹿乱撞了而不敢靠近我？下次是不是应该戴个口罩出门？”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　我一边把袜子穿好准备下车一边反思。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　13。 经过不懈&lt;a href=&quot;http://www.duwenzhang.com/huati/nuli/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;努力&lt;/a&gt;，我戒掉了睡前玩手机的&lt;a href=&quot;http://www.duwenzhang.com/huati/xiguan/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;习惯&lt;/a&gt;，但不知道能坚持多久，总不能一辈子不睡觉吧！&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　14。　——研表究明，汉字的序顺并不定一能影阅响读，比如当你看完这句话后，才发这现里的字全是都乱的。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　15。 一天傍晚在小河边，阿Q对他的的新交&lt;a href=&quot;http://www.duwenzhang.com/huati/nvpengyou/index1.html&quot; target=&quot;_blank&quot; style=&quot;color: rgb(51, 51, 51); text-decoration-line: none;&quot;&gt;女朋友&lt;/a&gt;说：我可以讲一个字让你笑。女友说不信。阿Q这时，走到了一只哈八狗面前，扑通一声跪地上，只听一声大喊：爹。结果引来了所有闻言者的哄堂大笑。阿Q回过头来对女友又喊了一句：妈。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　16。 一位男子跑进车厢，着急地嚷嚷：“隔壁车厢里有一位太太晕过去了，谁带了威士忌？”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　乘客中很快有人拿出了威士忌。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　这位男子接过。喝了几大口，然后将酒瓶还给乘客道：“太谢谢你了，我这人看见女士晕倒就难受，这下好多了。”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　17。 第一天，小白兔去河边钓鱼，什么也没钓到，回家了。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　第二天，小白兔又去河边钓鱼，还是什么也没钓到，回家了。&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　第三天，小白兔刚到河边，一条大鱼从河里跳出来，冲着小白兔大叫：&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　你他妈的要是再敢用胡箩卜当鱼饵，我就扁死你！&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　18。 顾客：“你们卖的酒怎么没有酒味啊？”&lt;/p&gt;&lt;p style=&quot;white-space: normal; font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px;&quot;&gt;　　服务员接过一闻：“啊，真对不起，忘记给您掺酒了。”&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '民间笑话荟萃', '', 'http://ys009.ymyuanma.com/XResource/20190328/MQPk7DTyQKjDXyhE7iK75S5Bi7PTY3kx.jpg', '1553769807', '1', '1553770395', '0', '0', '0', '8', '16', '0', '1', '');

-- -----------------------------
-- Table structure for `ms_novel_collection`
-- -----------------------------
DROP TABLE IF EXISTS `ms_novel_collection`;
CREATE TABLE `ms_novel_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  `novel_id` int(11) DEFAULT '0' COMMENT '小说id',
  `collection_time` int(10) DEFAULT '0' COMMENT '收藏时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='小说收藏表';


-- -----------------------------
-- Table structure for `ms_novel_good_log`
-- -----------------------------
DROP TABLE IF EXISTS `ms_novel_good_log`;
CREATE TABLE `ms_novel_good_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `novel_id` int(11) DEFAULT NULL COMMENT '点赞的视频id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `add_time` int(10) DEFAULT NULL COMMENT '点赞时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='小说收藏日志表';


-- -----------------------------
-- Table structure for `ms_novel_watch_log`
-- -----------------------------
DROP TABLE IF EXISTS `ms_novel_watch_log`;
CREATE TABLE `ms_novel_watch_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `novel_id` int(11) NOT NULL COMMENT '小说id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户Id',
  `user_ip` varchar(15) DEFAULT NULL COMMENT '用户ip',
  `view_time` int(10) NOT NULL COMMENT '观看时间',
  `gold` int(11) DEFAULT NULL COMMENT '消费金币',
  `is_try_see` int(1) DEFAULT '0' COMMENT '是否为试看，1：试看',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='小说阅读日志表';


-- -----------------------------
-- Table structure for `ms_order`
-- -----------------------------
DROP TABLE IF EXISTS `ms_order`;
CREATE TABLE `ms_order` (
  `order_sn` varchar(20) NOT NULL COMMENT '订单号，全局唯一',
  `user_id` int(11) DEFAULT NULL COMMENT '订单发起会员id',
  `payment_code` varchar(20) DEFAULT NULL COMMENT '支付方式code,如codePay',
  `pay_channel` varchar(20) DEFAULT NULL COMMENT '支付渠道， wxpay,alipay,qqpay',
  `price` float(10,2) NOT NULL COMMENT '订单金额',
  `real_pay_price` float DEFAULT NULL COMMENT '真实支付金额',
  `third_id` varchar(40) DEFAULT NULL COMMENT '第三方支付的识别号',
  `buy_type` int(1) DEFAULT NULL COMMENT '购买类型，1:金币，2:vip',
  `buy_glod_num` int(11) DEFAULT NULL COMMENT '购买的金币个数',
  `buy_vip_info` varchar(500) DEFAULT NULL COMMENT '购买vip的信息，如套餐信息',
  `status` int(1) DEFAULT '0' COMMENT '0：未支付，1：已支付',
  `from_agent_id` int(11) DEFAULT NULL COMMENT '充值来源代理商id',
  `from_domain` varchar(300) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL COMMENT '订单创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '订单更新时间',
  `pay_time` int(11) DEFAULT NULL COMMENT '订单支付时间',
  PRIMARY KEY (`order_sn`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='订单表（vip购买及金币充值）';

-- -----------------------------
-- Records of `ms_order`
-- -----------------------------
INSERT INTO `ms_order` VALUES ('2019042215542369022', '4', 'codePay', 'wxPay', '1', '0', '', '1', '10', '', '0', '0', 'http://ys009.ymyuanma.com', '1555919663', '1555919663', '0');
INSERT INTO `ms_order` VALUES ('2019042215552768632', '4', 'codePay', 'wxPay', '1', '1', '115559197323733512719997336', '1', '10', '', '1', '0', 'http://ys009.ymyuanma.com', '1555919727', '1555919808', '1555919808');
INSERT INTO `ms_order` VALUES ('2019042215592312870', '4', 'codePay', 'wxPay', '1', '1', '115559199713733515568527651', '2', '0', '{\"id\":10,\"name\":\"7天体验套餐\",\"days\":7,\"price\":\"1.00\",\"permanent\":0,\"info\":\"7天体验VIP会员套餐\"}', '1', '0', 'http://ys009.ymyuanma.com', '1555919963', '1555919998', '1555919998');
INSERT INTO `ms_order` VALUES ('2019042216041231867', '4', 'codePay', 'aliPay', '1', '1', '115559202571733510167404395', '1', '10', '', '0', '0', 'http://ys009.ymyuanma.com', '1555920252', '1555920253', '0');
INSERT INTO `ms_order` VALUES ('2019042216044675543', '4', 'codePay', 'aliPay', '1', '1.01', '115559202911733513136721076', '1', '10', '', '1', '0', 'http://ys009.ymyuanma.com', '1555920286', '1555920461', '1555920461');

-- -----------------------------
-- Table structure for `ms_payment`
-- -----------------------------
DROP TABLE IF EXISTS `ms_payment`;
CREATE TABLE `ms_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_code` varchar(50) NOT NULL COMMENT '支付方式的code',
  `pay_name` varchar(255) NOT NULL COMMENT '支付名称',
  `config` text COMMENT '支付方式配置信息',
  `status` int(1) DEFAULT '1' COMMENT '是否开户，1：开启，0：关闭',
  `is_third_payment` int(1) DEFAULT '0' COMMENT '是否为第三方支付，1是 0否（原生支付）',
  `add_time` int(10) DEFAULT NULL COMMENT '安装时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='支付配置表';

-- -----------------------------
-- Records of `ms_payment`
-- -----------------------------
INSERT INTO `ms_payment` VALUES ('1', 'codePay', '码支付', '[{\"name\":\"merchant_id\",\"type\":\"string\",\"value\":\"18545\",\"desc\":\"\\u5546\\u6237id\"},{\"name\":\"key\",\"type\":\"string\",\"value\":\"8d9df45B09DXbyf6d54f6sdjH0uqS\",\"desc\":\"\\u7801\\u652f\\u4ed8\\u901a\\u4fe1\\u5bc6\\u94a5\"},{\"name\":\"min_money\",\"type\":\"string\",\"value\":\"1\",\"desc\":\"\\u6700\\u4f4e\\u652f\\u4ed8\\u91d1\\u989d\"}]', '1', '1', '1514888879', '1556033375');
INSERT INTO `ms_payment` VALUES ('2', 'wxPay', '微信支付', '[{\"name\":\"appid\",\"type\":\"string\",\"value\":\"wx1e076868fbfb4195\",\"desc\":\"\\u516c\\u4f17\\u53f7appid\"},{\"name\":\"secret_key\",\"type\":\"string\",\"value\":\"2bbd1843b672d41b96c18893915365a5\",\"desc\":\"\\u516c\\u4f17\\u53f7SecretKey\"},{\"name\":\"mch_id\",\"type\":\"string\",\"value\":\"1458366102\",\"desc\":\"\\u5546\\u6237\\u53f7\"},{\"name\":\"key\",\"type\":\"string\",\"value\":\"Jgp2OmiuIBskZ523bll6cS6xhvpwCrTk\",\"desc\":\"API\\u5bc6\\u94a5\"},{\"name\":\"notify_url\",\"type\":\"string\",\"value\":\"http:\\/\\/payer.free.ngrok.cc\\/pay_notify\\/wxpayNotify\",\"desc\":\"\\u901a\\u77e5\\u56de\\u8c03\\u5730\\u5740\"},{\"name\":\"min_money\",\"type\":\"int\",\"value\":\"0.01\",\"desc\":\"\\u6700\\u5c0f\\u652f\\u4ed8\\u91d1\\u989d\"}]', '1', '0', '1514888906', '1521312943');
INSERT INTO `ms_payment` VALUES ('3', 'aliPay', '支付宝支付', '[{\"name\":\"appid\",\"type\":\"string\",\"value\":\"2017071907814717\",\"desc\":\"appid\"},{\"name\":\"md5_key\",\"type\":\"string\",\"value\":\"bgsdshzscyaqprnmlk5i3oa03dkh7euc\",\"desc\":\"MD5\\u5bc6\\u94a5\"},{\"name\":\"user_private_key\",\"type\":\"textarea\",\"value\":\"MIIEpAIBAAKCAQEA9TVmwFMr5zhLR1R2g1SwXaOe6tJLL2diOslZqoo+0TX\\/KjgqmaUaj0zeqV4ypZvu6bKmBDpEejV7H2l8NYR7K9c7Nr1r\\/LzbYEXaf9IU1ZjHx47MULJ4d+76Oj+E3EcByuB7SKkyk1gh94pEv2YBK8Rvt22foud\\/wyhkLF1YhMOBCiJsCjvIKwkb8SVKhU8sRnKxvpjaBQGkq53ybe8Kn+XoSpkLjR5dhRmY9cKUcJydQE0uv77XOCT4u8tbS2zSbr+ZRqPuLcngJmZhaFe3OECwfxok5Lgs7vBgSPVnar+78cqS71x9d1Py\\/O72pScm7D10PZ10iB8rJhdfdpzFbwIDAQABAoIBAQCZl\\/Cbyb03YSiuLnbpvrOWg\\/X4Su9zawO5pQP4cg31CCij7niosyWW22ShnHKHD8ywMAoTndfk4PkVbQKzlx98D550pGQu9LFJdZfu9s28Ga4SDx1l8tTI8zVkJQN44zV5OfGfSvR2HP9xyfdUGHXlT29W62DSLsX1nahZrcLTrVSPTyEMLbLMT0Q69zkWxbxKAbbrB2vic5JAXmeKKXYdQem4oUA48aT4xuoJqnpBb3iN8FI0L0JbjBBLfq5PBTD4q8EAYI4CZKfcFCorB2KSdBopsrBlHkkcBP7vimFclLa2I2FTTsC2gCOdgHfLWS5cZgdzrinHYuwUUuHR0PmhAoGBAP4HV0OtWvsquxE6Wxu47i4NmrcbOI3Ds+EPjVwrZRfIjGlDSc4rCX0Z\\/zeDb9tNrI1rqhZd1DXgNqm0hlKWaIpuGnnSnBzfmoVb5Vj45JBXyRu6\\/d82ykjDoYyqDcfbJi22bh49DIMIYy5ufp1JNz73rJHnEo1asvRFloAdlSCRAoGBAPccidAoJzHNXIM4R89CuSpgJNJBJ5464kk2ktxQMJU519WbmVhFrT6xnA\\/8hn8EIgUIhcjTJ+JwBLwgU58f8d2wh+1h5gpMQP0oLunyFMUx4cwrUc8U49frYwNpRAZdMU3baUfcT\\/c1K3YwYoJbUEzL4pjnLHXB2d\\/DQZGFxoX\\/AoGAaXYSvH4T74Jl91kKyg+UknoDaVFbwT8mRqF2RnWdmqof4POWiIlFfzJzylA++ATfRjcUfgSmPVfAWeQgf9kBvbbINxtAxJvwQr1MEgwCmApZ67FOBIVypZLSVtuirP5Gc2Pxg4xEzYGF65jj59ilnvakJk6QXS7ybIcXXEjryIECgYEAq5F25b1bKSrKNpkW0oIjCZbjOc\\/e7+82OVrYsHpEoPceMcLsvurxk\\/vAvSC5SOrXq+L08DAbGw5nWy6eoHaPeTodxeUY0MGMxbfmiqt3XEp72UOic0KvxrQ5dJ7bigeeOc5C1I\\/UPXD\\/EfoaCyPXJtrQIxUuOzwyRzfMCHt3EIUCgYAlqQ\\/KpdnUXUoRpv\\/pvPSAGqwONCDiZkmvHqEKTiMJ0mzZ\\/lACpbh+Nqmh9WTR47myVqAiMfOkG+wiZ+OsbyJh2jbQVV2ltaPVm3FekZQ9VVwNOQR3hbjZwwCCL5nsmKnDIWPZv8O8meZoXLYC5V6\\/QkHEMQqGTVQ3k5buZ4o2XA==\",\"desc\":\"\\u5f00\\u53d1\\u8005\\u79c1\\u94a5\"},{\"name\":\"ali_public_key\",\"type\":\"textarea\",\"value\":\"MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnner9A9etcVd\\/h5qhVwJUCyd2gAN929t8CFUX3nWjY8xiCd9wxoAhBxSo7SwL4eyhHvzh41dhoaYOBuaN2Gj3laQc4n6nOlIKzC0uWYokmbqrgSf1hKaJHnm6i3d\\/bQ3T1QiaMdNB+pMKngMUEbKX3btS2v0mGgmuMn58r5Rk3LjdNiQkd64bwUdwW\\/p63YKxHoCJ\\/4OVGLpPQK\\/h+ZBzYQS8A\\/SCK5pQNEt1N4I3G+YYvzULx5QjV631n9X5\\/o5dMSZmrS0QEXYX2h3uQiVq14864Kw\\/QyBseUsqPcCOM4NQvSQIufc4\\/OhQ\\/Hn\\/cH71ZweYn4dUPFH+nWra0MUtQIDAQAB\",\"desc\":\"\\u652f\\u4ed8\\u5b9d\\u516c\\u94a5\"},{\"name\":\"min_money\",\"type\":\"int\",\"value\":\"0.01\",\"desc\":\"\\u6700\\u5c0f\\u652f\\u4ed8\\u91d1\\u989d\"},{\"name\":\"notify_url\",\"type\":\"string\",\"value\":\"http:\\/\\/payer.free.ngrok.cc\\/pay_notify\\/alipayNotify\",\"desc\":\"\\u5f02\\u6b65\\u901a\\u77e5\\u5730\\u5740\"},{\"name\":\"return_url\",\"type\":\"string\",\"value\":\"http:\\/\\/payer.free.ngrok.cc\\/member\\/member\",\"desc\":\"\\u652f\\u4ed8\\u5b8c\\u6210\\u56de\\u8df3\\u5730\\u5740\"}]', '1', '0', '1514888916', '1520838809');

-- -----------------------------
-- Table structure for `ms_recharge_package`
-- -----------------------------
DROP TABLE IF EXISTS `ms_recharge_package`;
CREATE TABLE `ms_recharge_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '套餐名字',
  `sort` int(11) NOT NULL COMMENT '排序',
  `days` int(11) NOT NULL COMMENT '套餐时长（天为单位）',
  `price` decimal(11,2) DEFAULT NULL COMMENT '价格',
  `permanent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否永久套餐1为是',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `info` varchar(255) DEFAULT NULL COMMENT '说明',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='vip套餐表';

-- -----------------------------
-- Records of `ms_recharge_package`
-- -----------------------------
INSERT INTO `ms_recharge_package` VALUES ('1', '包月套餐', '2', '30', '88.00', '0', '1', '包月套餐，有效时间30天,每天不到3元，所有精彩内容无限制观看。');
INSERT INTO `ms_recharge_package` VALUES ('2', '包季套餐', '3', '90', '188.00', '0', '1', '包季套餐，有效时间90天,每天才约2元，所有精彩内容无限制观看。');
INSERT INTO `ms_recharge_package` VALUES ('3', '包年套餐', '4', '365', '388.00', '0', '1', '包年套餐，有效时间365天,每天才约1元，所有精彩内容无限制观看。');
INSERT INTO `ms_recharge_package` VALUES ('8', '永久套餐', '5', '0', '588.00', '1', '1', '永久套餐，不受时间限制，可以永久使用。');

-- -----------------------------
-- Table structure for `ms_share_log`
-- -----------------------------
DROP TABLE IF EXISTS `ms_share_log`;
CREATE TABLE `ms_share_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '分享者id',
  `share_time` int(10) NOT NULL COMMENT '分享时间',
  `to_ip` varchar(32) NOT NULL COMMENT '被分享者ip',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='分享日志表';


-- -----------------------------
-- Table structure for `ms_sign`
-- -----------------------------
DROP TABLE IF EXISTS `ms_sign`;
CREATE TABLE `ms_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `sign_time` int(10) DEFAULT NULL COMMENT '签到日期',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=147 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='会员签到日志表';

-- -----------------------------
-- Records of `ms_sign`
-- -----------------------------
INSERT INTO `ms_sign` VALUES ('140', '2', '1554216399');
INSERT INTO `ms_sign` VALUES ('141', '4', '1554364272');
INSERT INTO `ms_sign` VALUES ('142', '7', '1554709774');
INSERT INTO `ms_sign` VALUES ('143', '4', '1554967094');
INSERT INTO `ms_sign` VALUES ('144', '4', '1555469549');
INSERT INTO `ms_sign` VALUES ('145', '4', '1555919534');
INSERT INTO `ms_sign` VALUES ('146', '8', '1556027084');

-- -----------------------------
-- Table structure for `ms_tag`
-- -----------------------------
DROP TABLE IF EXISTS `ms_tag`;
CREATE TABLE `ms_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(64) NOT NULL COMMENT '标签名字',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `type` int(2) DEFAULT '1' COMMENT '所属模块1视频，2图片，3小说',
  `status` int(2) DEFAULT '1' COMMENT '开启状态1为开启，0为关闭',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='资源标签表(视频|小说|图片)';

-- -----------------------------
-- Records of `ms_tag`
-- -----------------------------
INSERT INTO `ms_tag` VALUES ('3', '美女图片', '6', '2', '1');
INSERT INTO `ms_tag` VALUES ('5', '日常生活', '0', '3', '1');
INSERT INTO `ms_tag` VALUES ('10', '兴趣交流', '0', '3', '1');
INSERT INTO `ms_tag` VALUES ('11', '校园美女', '5', '2', '1');
INSERT INTO `ms_tag` VALUES ('12', '网红写真', '4', '2', '1');
INSERT INTO `ms_tag` VALUES ('13', '主播美女', '3', '2', '1');
INSERT INTO `ms_tag` VALUES ('14', '时事经济', '0', '3', '1');
INSERT INTO `ms_tag` VALUES ('15', '求助求档', '0', '3', '1');
INSERT INTO `ms_tag` VALUES ('16', '会员闲谈吹水', '0', '3', '1');
INSERT INTO `ms_tag` VALUES ('22', '可爱美眉', '2', '2', '1');
INSERT INTO `ms_tag` VALUES ('23', '成熟妹子', '1', '2', '1');
INSERT INTO `ms_tag` VALUES ('55', '女仆', '0', '1', '1');
INSERT INTO `ms_tag` VALUES ('58', '嫩模', '0', '1', '1');
INSERT INTO `ms_tag` VALUES ('59', '少女', '0', '1', '1');
INSERT INTO `ms_tag` VALUES ('60', '萝莉', '0', '1', '1');
INSERT INTO `ms_tag` VALUES ('61', '性感', '0', '1', '1');
INSERT INTO `ms_tag` VALUES ('62', '清纯', '0', '1', '1');
INSERT INTO `ms_tag` VALUES ('63', '偷拍', '0', '1', '1');
INSERT INTO `ms_tag` VALUES ('64', '女郎', '0', '1', '1');
INSERT INTO `ms_tag` VALUES ('65', '学妹', '0', '1', '1');
INSERT INTO `ms_tag` VALUES ('66', '熟女', '0', '1', '1');
INSERT INTO `ms_tag` VALUES ('67', '禁忌', '0', '1', '1');
INSERT INTO `ms_tag` VALUES ('68', '主播', '0', '1', '1');

-- -----------------------------
-- Table structure for `ms_user_atlas`
-- -----------------------------
DROP TABLE IF EXISTS `ms_user_atlas`;
CREATE TABLE `ms_user_atlas` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `title` varchar(255) DEFAULT NULL COMMENT '图集标题',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `add_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员自定义相册表';

-- -----------------------------
-- Records of `ms_user_atlas`
-- -----------------------------
INSERT INTO `ms_user_atlas` VALUES ('45', '4', '001', '0', '1554967191');

-- -----------------------------
-- Table structure for `ms_version_role`
-- -----------------------------
DROP TABLE IF EXISTS `ms_version_role`;
CREATE TABLE `ms_version_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '角色名称',
  `intro` varchar(200) NOT NULL COMMENT '角色简介',
  `auth` text NOT NULL COMMENT '角色权限',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 版本管理表';

-- -----------------------------
-- Records of `ms_version_role`
-- -----------------------------
INSERT INTO `ms_version_role` VALUES ('1', '专享版', '价格：8888', '[\"10\",\"60\",\"61\",\"62\",\"63\",\"91\",\"14\",\"41\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"133\",\"140\",\"142\",\"191\",\"229\",\"243\",\"241\",\"245\",\"313\",\"263\",\"266\",\"319\",\"28\",\"31\",\"136\",\"137\",\"139\",\"158\",\"169\",\"171\",\"174\",\"176\",\"206\",\"207\",\"208\",\"212\",\"213\",\"214\",\"210\",\"216\",\"211\",\"294\",\"295\",\"296\",\"240\",\"247\",\"244\",\"246\",\"250\",\"251\",\"310\",\"311\",\"312\",\"255\",\"256\",\"257\",\"264\",\"132\",\"143\",\"185\",\"249\",\"149\",\"152\",\"153\",\"175\",\"178\",\"156\",\"167\",\"177\",\"217\",\"220\",\"221\",\"222\",\"223\",\"234\",\"235\",\"262\",\"279\",\"282\",\"305\",\"148\",\"154\",\"162\",\"163\",\"190\",\"192\",\"196\",\"197\",\"203\",\"218\",\"236\",\"280\",\"283\",\"302\",\"303\",\"304\",\"307\",\"308\",\"309\",\"151\",\"155\",\"165\",\"166\",\"170\",\"186\",\"189\",\"219\",\"237\",\"281\",\"284\",\"300\",\"301\",\"306\",\"315\",\"316\",\"317\",\"318\",\"320\",\"20\",\"75\",\"76\",\"77\",\"21\",\"70\",\"71\",\"72\",\"73\",\"74\",\"90\",\"180\",\"181\",\"187\",\"188\",\"194\",\"195\",\"199\",\"200\",\"201\",\"202\",\"204\",\"226\",\"227\",\"228\",\"231\",\"232\",\"233\",\"260\",\"261\"]', '1489411760', '0', '1');
INSERT INTO `ms_version_role` VALUES ('2', '高级版', '价格：5888', '[\"10\",\"60\",\"61\",\"62\",\"63\",\"91\",\"14\",\"41\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"133\",\"140\",\"142\",\"191\",\"229\",\"243\",\"241\",\"245\",\"313\",\"263\",\"319\",\"28\",\"31\",\"136\",\"137\",\"139\",\"158\",\"169\",\"171\",\"174\",\"176\",\"210\",\"216\",\"211\",\"294\",\"295\",\"296\",\"240\",\"247\",\"244\",\"246\",\"250\",\"251\",\"310\",\"311\",\"312\",\"255\",\"256\",\"257\",\"264\",\"132\",\"143\",\"185\",\"249\",\"149\",\"152\",\"153\",\"175\",\"178\",\"156\",\"167\",\"177\",\"217\",\"220\",\"221\",\"222\",\"223\",\"234\",\"235\",\"262\",\"279\",\"282\",\"305\",\"148\",\"154\",\"162\",\"163\",\"190\",\"192\",\"196\",\"197\",\"203\",\"218\",\"236\",\"280\",\"283\",\"302\",\"303\",\"304\",\"307\",\"308\",\"309\",\"151\",\"155\",\"165\",\"166\",\"170\",\"186\",\"189\",\"219\",\"237\",\"281\",\"284\",\"300\",\"301\",\"306\",\"315\",\"316\",\"317\",\"318\",\"20\",\"75\",\"76\",\"77\",\"21\",\"70\",\"71\",\"72\",\"73\",\"74\",\"90\",\"180\",\"181\",\"194\",\"195\",\"199\",\"200\",\"201\",\"202\",\"204\",\"226\",\"227\",\"228\",\"231\",\"232\",\"233\",\"260\",\"261\"]', '1489411760', '0', '1');
INSERT INTO `ms_version_role` VALUES ('4', '基础版', '价格2888', '[\"10\",\"60\",\"61\",\"62\",\"63\",\"91\",\"14\",\"41\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"133\",\"140\",\"142\",\"191\",\"229\",\"243\",\"241\",\"245\",\"313\",\"263\",\"319\",\"28\",\"31\",\"136\",\"137\",\"139\",\"158\",\"169\",\"171\",\"174\",\"176\",\"210\",\"216\",\"211\",\"294\",\"295\",\"296\",\"240\",\"247\",\"244\",\"246\",\"250\",\"251\",\"310\",\"311\",\"312\",\"264\",\"132\",\"143\",\"185\",\"249\",\"149\",\"152\",\"153\",\"175\",\"178\",\"156\",\"167\",\"177\",\"217\",\"220\",\"221\",\"222\",\"223\",\"234\",\"235\",\"262\",\"279\",\"282\",\"305\",\"148\",\"154\",\"162\",\"163\",\"190\",\"192\",\"196\",\"197\",\"203\",\"218\",\"236\",\"280\",\"283\",\"302\",\"303\",\"304\",\"307\",\"308\",\"309\",\"151\",\"155\",\"165\",\"166\",\"170\",\"186\",\"189\",\"219\",\"237\",\"281\",\"284\",\"300\",\"301\",\"306\",\"20\",\"75\",\"76\",\"77\",\"21\",\"70\",\"71\",\"72\",\"73\",\"74\",\"90\",\"180\",\"181\",\"226\",\"227\",\"228\",\"231\",\"232\",\"233\"]', '1489411760', '0', '1');
INSERT INTO `ms_version_role` VALUES ('5', '测试版本', '0', '[\"10\",\"60\",\"61\",\"62\",\"63\",\"91\",\"14\",\"41\",\"84\",\"85\",\"86\",\"87\",\"89\",\"133\",\"140\",\"142\",\"191\",\"229\",\"243\",\"241\",\"245\",\"263\",\"266\",\"319\",\"31\",\"136\",\"137\",\"158\",\"169\",\"174\",\"176\",\"206\",\"207\",\"208\",\"213\",\"214\",\"210\",\"216\",\"211\",\"240\",\"247\",\"244\",\"246\",\"255\",\"256\",\"257\",\"264\",\"132\",\"143\",\"185\",\"249\",\"149\",\"152\",\"153\",\"156\",\"217\",\"220\",\"221\",\"222\",\"223\",\"234\",\"235\",\"262\",\"148\",\"154\",\"162\",\"163\",\"190\",\"192\",\"196\",\"197\",\"203\",\"218\",\"236\",\"151\",\"155\",\"165\",\"166\",\"170\",\"186\",\"189\",\"219\",\"237\",\"315\",\"316\",\"317\",\"318\",\"20\",\"75\",\"76\",\"21\",\"70\",\"71\",\"73\",\"74\",\"90\",\"180\",\"187\",\"188\",\"194\",\"195\",\"199\",\"200\",\"201\",\"226\",\"228\",\"231\",\"232\",\"233\",\"260\",\"261\"]', '1516777434', '0', '1');

-- -----------------------------
-- Table structure for `ms_video`
-- -----------------------------
DROP TABLE IF EXISTS `ms_video`;
CREATE TABLE `ms_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(255) NOT NULL COMMENT '视频标题',
  `info` text COMMENT '说明',
  `short_info` varchar(90) DEFAULT NULL COMMENT '短说明',
  `key_word` text COMMENT '关键词',
  `url` varchar(255) DEFAULT NULL COMMENT '视频播放地址',
  `download_url` varchar(255) DEFAULT NULL COMMENT '下载地址',
  `add_time` int(10) NOT NULL COMMENT '上传时间',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `play_time` varchar(20) DEFAULT NULL COMMENT '视频时长',
  `click` int(11) DEFAULT '0' COMMENT '总点击量',
  `good` int(11) DEFAULT '0' COMMENT '总点赞数',
  `thumbnail` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '上传者id，管理员为0',
  `class` text COMMENT '所属分类',
  `tag` text COMMENT '所属标签',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态1为显示，0为隐藏',
  `type` tinyint(2) DEFAULT '0' COMMENT '视频集为1 单视频为0',
  `pid` int(11) DEFAULT '0' COMMENT '当是分集的时候存在该字段',
  `diversity_data` text COMMENT '分集详情',
  `gold` int(11) DEFAULT '0' COMMENT '观看需要金币',
  `reco` int(1) DEFAULT '0' COMMENT '推荐星级',
  `sort` int(3) DEFAULT '0' COMMENT '视频分集序号',
  `is_check` int(1) DEFAULT '0' COMMENT '是否审核 。1审核通过，2审核未通过，0待审核',
  `hint` varchar(255) DEFAULT NULL COMMENT '驳回原因',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=176 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='视频表';

-- -----------------------------
-- Records of `ms_video`
-- -----------------------------
INSERT INTO `ms_video` VALUES ('5', 'マジ軟派、初撮れおな 19歳 ', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201759', '1547201759', '18:16', '24', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/381d33d1158cb1003325c4fd6b237e66.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('6', 'マジ軟派、初撮れおな 19歳 215', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201760', '1547201760', '18:16', '22', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f6b60e3632eb0e21c3e9bad4d42a0f0f.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('7', 'マジ軟派、初撮れおな 19歳 214', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201760', '1547201760', '18:16', '26', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/a4a56de77d434a660dadf1a34e82e0b8.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('8', 'マジ軟派、初撮れおな 19歳 216', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201761', '1547201761', '18:16', '25', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/431238205967629a92e48ff2832076c5.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('9', 'マジ軟派、初撮れおな 19歳 218', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201762', '1547201762', '18:16', '34', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/8194fa24bb4379b35bea80ca800e41b7.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('10', 'マジ軟派、初撮れおな 19歳 219', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201763', '1547201763', '18:16', '29', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/bc38c5690993e98e9b288be0d49b5471.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('11', 'マジ軟派、初撮れおな 19歳 220', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201763', '1547201763', '18:16', '26', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/2b0fd16e52fe11d71c55f89f0d500139.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('12', 'マジ軟派、初撮れおな 19歳 223', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201764', '1547201764', '18:16', '29', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/28aea194222b00f29c01ed02439f9f68.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('13', 'マジ軟派、初撮れおな 19歳 221', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201765', '1547201765', '18:16', '24', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f12821a916b98b6d7c20f1deccb5f092.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('14', 'マジ軟派、初撮れおな 19歳 217', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201765', '1547201765', '18:16', '30', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/2dfd68c72d1edd86d840ee76b82022f2.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('15', 'マジ軟派、初撮れおな 19歳 222', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201766', '1547201766', '18:16', '46', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/2c13af1070fc730ffa8dbdb0b82969a3.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('16', 'マジ軟派、初撮れおな 19歳 228', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201767', '1547201767', '18:16', '54', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/b895ebc8c07239ba6dee0d2c151ed37f.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('17', 'マジ軟派、初撮れおな 19歳 227', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201767', '1547201767', '18:16', '24', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/af3d5f6546559bfa4a434a3d08e2b48e.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('18', 'マジ軟派、初撮れおな 19歳 226', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201768', '1547201768', '18:16', '25', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/0c33660f13f37e601b86c950edd3a79e.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('19', 'マジ軟派、初撮れおな 19歳 224', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201769', '1547201769', '18:16', '76', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/457d8047dc1dca2568a04b73873118f1.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('20', 'マジ軟派、初撮れおな 19歳 1', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201769', '1547201769', '18:16', '26', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/182f6bee452e7b76161f3071eb3e8773.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('21', 'マジ軟派、初撮れおな 19歳 9', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201770', '1547201770', '18:16', '26', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/a7851606352a08c03c3521d8e0a641d0.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('22', 'マジ軟派、初撮れおな 19歳 10', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201771', '1547201771', '18:16', '27', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/a93ba8937d196e6fe0d2816e54ccdc48.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('23', 'マジ軟派、初撮れおな 19歳 11', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201771', '1547201771', '18:16', '30', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/b8f6fdc680755c0a74f26902bfa704c3.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('24', 'マジ軟派、初撮れおな 19歳 12', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201772', '1547201772', '18:16', '22', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/c8e8de58a1eead3cf09ee22e98275397.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('25', 'マジ軟派、初撮れおな 19歳 309', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201773', '1547201773', '18:16', '84', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/1228eb9bfc8510013b11b969f1427c7f.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('26', 'マジ軟派、初撮れおな 19歳 308', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201773', '1547201773', '18:16', '67', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/7d671022942c2b15256239436f755768.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('27', 'マジ軟派、初撮れおな 19歳 307', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201774', '1547201774', '18:16', '69', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/c590dcf5965f923be39bce7960ba8780.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('28', 'マジ軟派、初撮れおな 19歳 304', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201775', '1547201775', '18:16', '52', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/05cbc3e0a433ee4fa049b99cf1766487.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('29', 'マジ軟派、初撮れおな 19歳 301', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201775', '1547201775', '18:16', '58', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/5fdb6bd7ed5bedcd982ca1a3302e4a0a.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('30', 'マジ軟派、初撮れおな 19歳 3', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201776', '1547201776', '18:16', '24', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f275cc725b1f8c5b848f12eadd1b1344.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('31', 'マジ軟派、初撮れおな 19歳 4', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201777', '1547201777', '18:16', '23', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/655a79a8f48559ecfef93cd84ab3d793.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('32', 'マジ軟派、初撮れおな 19歳 5', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201778', '1547201778', '18:16', '22', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/697910c6ba1db52bc27aed2c48dfff6a.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('33', 'マジ軟派、初撮れおな 19歳 6', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201779', '1547201779', '18:16', '25', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/3f40fa2faa5f26ea3e4f1d0f63b4bc74.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('34', 'マジ軟派、初撮れおな 19歳 7', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201779', '1547201779', '18:16', '27', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/84a508c3281935b0c1f82db448e45259.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('35', 'マジ軟派、初撮れおな 19歳 8', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201780', '1547201780', '18:16', '51', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/579e8c3e4e60d3ac5003514dcd23d562.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('36', 'マジ軟派、初撮れおな 19歳 320', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201781', '1547201781', '18:16', '25', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/53fcdc8d1ebb3b28b8ebfb5e9efcbd2c.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('37', 'マジ軟派、初撮れおな 19歳 319', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201781', '1547201781', '18:16', '26', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/d5d90cbdbeba61ae864e7a8c385df703.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('38', 'マジ軟派、初撮れおな 19歳 318', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201782', '1547201782', '18:16', '25', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/49127e493deb358ec0ba6e24e608e18c.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('39', 'マジ軟派、初撮れおな 19歳 310', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201783', '1547201783', '18:16', '54', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/689e62e609db4d83b3463708993ca2e6.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('40', 'マジ軟派、初撮れおな 19歳 324', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201783', '1547201783', '18:16', '33', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/1f997fb7b15a3e48973fce856e4b4f38.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('41', 'マジ軟派、初撮れおな 19歳 323', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201784', '1547201784', '18:16', '39', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f85f8b337e65ea7ac654580e8e07e8c4.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('42', 'マジ軟派、初撮れおな 19歳 322', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201785', '1547201785', '18:16', '34', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/e4bb0ac2621da38ed61fc20674f95cfb.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('43', 'マジ軟派、初撮れおな 19歳 321', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201785', '1547201785', '18:16', '43', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/30d4f6cef6bb47bba6227248de6d6b10.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('44', 'マジ軟派、初撮れおな 19歳 336', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201786', '1547201786', '18:16', '47', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/4359b352d10129565e5c2d12c0146f8a.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('45', 'マジ軟派、初撮れおな 19歳 335', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201787', '1547201787', '18:16', '41', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/2892b4bdd113dea0afc2f38689a3fe7a.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('46', 'マジ軟派、初撮れおな 19歳 334', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201787', '1547201787', '18:16', '44', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/67518577896c2d04eb2f79b15328cb04.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('47', 'マジ軟派、初撮れおな 19歳 333', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201788', '1547201788', '18:16', '82', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/118f0b182f5ba5a7602eb096fb6b83a5.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('48', 'マジ軟派、初撮れおな 19歳 332', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201789', '1547201789', '18:16', '35', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f5b6c80fca25661face0388b4fa77e1b.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('49', 'マジ軟派、初撮れおな 19歳 331', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201789', '1547201789', '18:16', '47', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/ee5ff2c346bf95b238afde33a27a0f98.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('50', 'マジ軟派、初撮れおな 19歳 330', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201790', '1547201790', '18:16', '37', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/bbdfd834ebc662ef9ecbc17d1eac59f3.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('51', 'マジ軟派、初撮れおな 19歳 329', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201791', '1547201791', '18:16', '45', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/ce2d10791a67ff8ffc6bcd06f886c222.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('52', 'マジ軟派、初撮れおな 19歳 328', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201791', '1547201791', '18:16', '41', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/e6a3d09513f680c7fb79de7aadeadae1.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('53', 'マジ軟派、初撮れおな 19歳 327', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201792', '1547201792', '18:16', '49', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/81420a409f8f757cee40ec29ce2722fa.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('54', 'マジ軟派、初撮れおな 19歳 326', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201792', '1547201792', '18:16', '47', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/e6fc37ffb10d7084e1d9df5f5b4c147b.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('55', 'マジ軟派、初撮れおな 19歳 325', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201793', '1547201793', '18:16', '63', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/9229e75729a712bbea0ea8cc817b7790.jpg', '0', '59', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('56', 'マジ軟派、初撮れおな 19歳 340', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201794', '1547201794', '18:17', '67', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/cad382487566e84a70810b6c5f8c5371.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('57', 'マジ軟派、初撮れおな 19歳 338', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201795', '1547201795', '18:17', '68', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f2b2a5d83185623ab774ae86074811b4.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('58', 'マジ軟派、初撮れおな 19歳 337', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201795', '1547201795', '18:17', '66', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/59411f10f1ff4228d2ab2cd8a77262f9.jpg', '0', '60', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('59', 'マジ軟派、初撮れおな 19歳 303', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201796', '1547201796', '18:17', '77', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/0c37a056157d8de6273128881e171302.jpg', '0', '61', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('60', 'マジ軟派、初撮れおな 19歳 0217', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201797', '1547201797', '18:17', '28', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/2dfd68c72d1edd86d840ee76b82022f2.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('61', 'マジ軟派、初撮れおな 19歳 0221', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201797', '1547201797', '18:17', '28', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f12821a916b98b6d7c20f1deccb5f092.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('62', 'マジ軟派、初撮れおな 19歳 0223', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201798', '1547201798', '18:17', '27', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/28aea194222b00f29c01ed02439f9f68.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('63', 'マジ軟派、初撮れおな 19歳 0220', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201799', '1547201799', '18:17', '28', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/2b0fd16e52fe11d71c55f89f0d500139.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('64', 'マジ軟派、初撮れおな 19歳 0219', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201799', '1547201799', '18:17', '21', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/bc38c5690993e98e9b288be0d49b5471.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('65', 'マジ軟派、初撮れおな 19歳 0218', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201800', '1547201800', '18:17', '32', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/8194fa24bb4379b35bea80ca800e41b7.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('66', 'マジ軟派、初撮れおな 19歳 0216', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201801', '1547201801', '18:17', '25', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/431238205967629a92e48ff2832076c5.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('67', 'マジ軟派、初撮れおな 19歳 0214', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201801', '1547201801', '18:17', '20', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/a4a56de77d434a660dadf1a34e82e0b8.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('68', 'マジ軟派、初撮れおな 19歳 0215', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201802', '1547201802', '18:17', '27', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f6b60e3632eb0e21c3e9bad4d42a0f0f.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('69', 'マジ軟派、初撮れおな 19歳 000', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201803', '1547201803', '18:17', '26', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/381d33d1158cb1003325c4fd6b237e66.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('70', 'マジ軟派、初撮れおな 19歳 2300', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201803', '1547201803', '18:17', '31', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/d9e146e4a15b110f6b7977171918f7f2.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('71', 'マジ軟派、初撮れおな 19歳 2250', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201804', '1547201804', '18:17', '25', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/b70f69480f67ba657b4a6d8d9e2912b3.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('72', 'マジ軟派、初撮れおな 19歳 1i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201805', '1547201805', '18:17', '22', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/182f6bee452e7b76161f3071eb3e8773.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('73', 'マジ軟派、初撮れおな 19歳 2i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201805', '1547201805', '18:17', '26', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/a5115054a65c16ea79fd1d37b188794f.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('74', 'マジ軟派、初撮れおな 19歳 229i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201806', '1547201806', '18:17', '24', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/2a0e1684ae9c0a107cacb58793d6133f.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('75', 'マジ軟派、初撮れおな 19歳 227i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201807', '1547201807', '18:17', '28', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/af3d5f6546559bfa4a434a3d08e2b48e.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('76', 'マジ軟派、初撮れおな 19歳 226i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201807', '1547201807', '18:17', '32', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/0c33660f13f37e601b86c950edd3a79e.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('77', 'マジ軟派、初撮れおな 19歳 0224', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201808', '1547201808', '18:17', '22', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/457d8047dc1dca2568a04b73873118f1.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('78', 'マジ軟派、初撮れおな 19歳 0228', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201809', '1547201809', '18:17', '70', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/b895ebc8c07239ba6dee0d2c151ed37f.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('79', 'マジ軟派、初撮れおな 19歳 0222', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201809', '1547201809', '18:17', '46', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/2c13af1070fc730ffa8dbdb0b82969a3.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('80', 'マジ軟派、初撮れおな 19歳 012', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201810', '1547201810', '18:17', '27', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/c8e8de58a1eead3cf09ee22e98275397.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('81', 'マジ軟派、初撮れおな 19歳 011', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201811', '1547201811', '18:17', '34', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/b8f6fdc680755c0a74f26902bfa704c3.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('82', 'マジ軟派、初撮れおな 19歳 010', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201811', '1547201811', '18:17', '29', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/a93ba8937d196e6fe0d2816e54ccdc48.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('83', 'マジ軟派、初撮れおな 19歳 09', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201812', '1547201812', '18:17', '25', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/a7851606352a08c03c3521d8e0a641d0.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('84', 'マジ軟派、初撮れおな 19歳 08', '', '苏打水对暗号是的', 'saidghiasgdi', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201813', '1547266767', '18:17', '563', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/579e8c3e4e60d3ac5003514dcd23d562.jpg', '0', '10', '0', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('85', 'マジ軟派、初撮れおな 19歳 07', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201814', '1547201814', '18:17', '28', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/84a508c3281935b0c1f82db448e45259.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('86', 'マジ軟派、初撮れおな 19歳 05', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201815', '1547201815', '18:17', '22', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/697910c6ba1db52bc27aed2c48dfff6a.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('87', 'マジ軟派、初撮れおな 19歳 06', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201816', '1547201816', '18:17', '22', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/3f40fa2faa5f26ea3e4f1d0f63b4bc74.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('88', 'マジ軟派、初撮れおな 19歳 04', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201817', '1547201817', '18:17', '26', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/655a79a8f48559ecfef93cd84ab3d793.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('89', 'マジ軟派、初撮れおな 19歳 03', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201817', '1547201817', '18:17', '27', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f275cc725b1f8c5b848f12eadd1b1344.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('90', 'マジ軟派、初撮れおな 19歳 320i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201818', '1547201818', '18:17', '27', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/53fcdc8d1ebb3b28b8ebfb5e9efcbd2c.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('91', 'マジ軟派、初撮れおな 19歳 319i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201819', '1547201819', '18:17', '19', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/d5d90cbdbeba61ae864e7a8c385df703.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('92', 'マジ軟派、初撮れおな 19歳 318i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201819', '1547201819', '18:17', '30', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/49127e493deb358ec0ba6e24e608e18c.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('93', 'マジ軟派、初撮れおな 19歳 0310', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201850', '1547201850', '18:17', '87', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/689e62e609db4d83b3463708993ca2e6.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('94', 'マジ軟派、初撮れおな 19歳 0309', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201850', '1547201850', '18:17', '169', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/1228eb9bfc8510013b11b969f1427c7f.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('95', 'マジ軟派、初撮れおな 19歳 0308', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201851', '1547201851', '18:17', '79', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/7d671022942c2b15256239436f755768.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('96', 'マジ軟派、初撮れおな 19歳 0307', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201852', '1547201852', '18:17', '131', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/c590dcf5965f923be39bce7960ba8780.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('97', 'マジ軟派、初撮れおな 19歳 0304', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201852', '1547201852', '18:17', '83', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/05cbc3e0a433ee4fa049b99cf1766487.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('98', 'マジ軟派、初撮れおな 19歳 0301', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201853', '1547201853', '18:17', '166', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/5fdb6bd7ed5bedcd982ca1a3302e4a0a.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('99', 'マジ軟派、初撮れおな 19歳 302', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201854', '1547201854', '18:17', '213', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/95dedf20177bc7ef6229236af1b05e97.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('100', 'マジ軟派、初撮れおな 19歳 327i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201854', '1547201854', '18:17', '78', '1', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/81420a409f8f757cee40ec29ce2722fa.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('101', 'マジ軟派、初撮れおな 19歳 326i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201855', '1547201855', '18:17', '49', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/e6fc37ffb10d7084e1d9df5f5b4c147b.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('102', 'マジ軟派、初撮れおな 19歳 325i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201856', '1547201856', '18:17', '89', '1', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/9229e75729a712bbea0ea8cc817b7790.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('103', 'マジ軟派、初撮れおな 19歳 324i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201856', '1547201856', '18:17', '55', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/1f997fb7b15a3e48973fce856e4b4f38.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('104', 'マジ軟派、初撮れおな 19歳 323i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201857', '1547201857', '18:17', '64', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f85f8b337e65ea7ac654580e8e07e8c4.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('105', 'マジ軟派、初撮れおな 19歳 322i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201858', '1547201858', '18:17', '74', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/e4bb0ac2621da38ed61fc20674f95cfb.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('106', 'マジ軟派、初撮れおな 19歳 321i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201858', '1547201858', '18:17', '57', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/30d4f6cef6bb47bba6227248de6d6b10.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('107', 'マジ軟派、初撮れおな 19歳 330i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201859', '1547201859', '18:17', '106', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/bbdfd834ebc662ef9ecbc17d1eac59f3.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('108', 'マジ軟派、初撮れおな 19歳 0332', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201860', '1547201860', '18:17', '49', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f5b6c80fca25661face0388b4fa77e1b.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('109', 'マジ軟派、初撮れおな 19歳 0331', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201860', '1547201860', '18:17', '48', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/ee5ff2c346bf95b238afde33a27a0f98.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('110', 'マジ軟派、初撮れおな 19歳 0333', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201861', '1547201861', '18:17', '68', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/118f0b182f5ba5a7602eb096fb6b83a5.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('111', 'マジ軟派、初撮れおな 19歳 0334', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201862', '1547201862', '18:17', '49', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/67518577896c2d04eb2f79b15328cb04.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('112', 'マジ軟派、初撮れおな 19歳 0335', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201862', '1547201862', '18:17', '48', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/2892b4bdd113dea0afc2f38689a3fe7a.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('113', 'マジ軟派、初撮れおな 19歳 0340', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201863', '1547201863', '18:17', '47', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/cad382487566e84a70810b6c5f8c5371.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('114', 'マジ軟派、初撮れおな 19歳 0338', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201864', '1547201864', '18:17', '73', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f2b2a5d83185623ab774ae86074811b4.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('115', 'マジ軟派、初撮れおな 19歳 0337', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201864', '1547201864', '18:17', '48', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/59411f10f1ff4228d2ab2cd8a77262f9.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('116', 'マジ軟派、初撮れおな 19歳 0336', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201865', '1547201865', '18:17', '77', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/4359b352d10129565e5c2d12c0146f8a.jpg', '0', '10', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('117', 'マジ軟派、初撮れおな 19歳 329i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201866', '1547201866', '18:17', '117', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/ce2d10791a67ff8ffc6bcd06f886c222.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('118', 'マジ軟派、初撮れおな 19歳 328i', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201866', '1547201866', '18:17', '112', '1', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/e6a3d09513f680c7fb79de7aadeadae1.jpg', '0', '9', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('119', 'マジ軟派、初撮れおな 19歳 13', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201867', '1547201867', '18:17', '33', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/8f6a30b64af9a5b6fe31a097779c42c2.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('120', 'マジ軟派、初撮れおな 19歳 253', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201868', '1547201868', '18:17', '24', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/da0a2def729929873ef3d3b7107fd710.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('121', 'マジ軟派、初撮れおな 19歳 254', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201868', '1547201868', '18:17', '24', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/9bb79aec99f564ca59a8f4e059f1096b.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('122', 'マジ軟派、初撮れおな 19歳 0303', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201869', '1547201869', '18:17', '257', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/0c37a056157d8de6273128881e171302.jpg', '0', '2', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('123', 'マジ軟派、初撮れおな 19歳 257', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201870', '1547201870', '18:17', '35', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/981ace114aca78b77b8282f3bc84a422.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('124', 'マジ軟派、初撮れおな 19歳 258', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201870', '1547201870', '18:17', '29', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f3e1121e60400f30cf837d0eb1102813.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('125', 'マジ軟派、初撮れおな 19歳 14', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201871', '1547201871', '18:17', '21', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/7107c4cb46a2ca36b14b744bcaa1627c.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('126', 'マジ軟派、初撮れおな 19歳 408', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201872', '1547201872', '18:17', '25', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/43b8b6cca54c6dbe8e2da390ef124bae.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('127', 'マジ軟派、初撮れおな 19歳 407', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201872', '1547201872', '18:17', '24', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/1d63e9556818b008e0e37b842dbcf126.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('128', 'マジ軟派、初撮れおな 19歳 406', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201873', '1547201873', '18:17', '43', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/9281287b48357b80b60925aa5cd27923.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('129', 'マジ軟派、初撮れおな 19歳 405', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201874', '1547201874', '18:17', '38', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/7e78c95eb357cd3167266318ad530928.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('130', 'マジ軟派、初撮れおな 19歳 404', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201874', '1547201874', '18:17', '21', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/010342912ef2c2ffefde524294ac0226.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('131', 'マジ軟派、初撮れおな 19歳 403', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201875', '1547201875', '18:17', '77', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/ddb95806e10bd10c02576a1b5dd6e413.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('132', 'マジ軟派、初撮れおな 19歳 401', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201876', '1547201876', '18:17', '37', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/ed0f441657e630fbaff16e25682dda6f.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('133', 'マジ軟派、初撮れおな 19歳 400', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201876', '1547201876', '18:17', '34', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/45f5ff86dc8dfb54059812b3239f793c.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('134', 'マジ軟派、初撮れおな 19歳 260', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201877', '1547201877', '18:17', '45', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/1142b77fd03fa53feaf40f63e2ea91fc.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('135', 'マジ軟派、初撮れおな 19歳 248', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201878', '1547201878', '18:17', '50', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/c648948c247ec03915f1db773a47ea21.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('136', 'マジ軟派、初撮れおな 19歳 250', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201878', '1547201878', '18:17', '65', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/2522871d5e52854579cb3c5f1c5ba321.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('137', 'マジ軟派、初撮れおな 19歳 251', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201879', '1547201879', '18:17', '62', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/138db35494c850632f7a8c09e4e82335.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('138', 'マジ軟派、初撮れおな 19歳 410', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201880', '1547201880', '18:17', '74', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/c6d1718d664c7c4199e7c99276ada6e2.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('139', 'マジ軟派、初撮れおな 19歳 409', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201880', '1547201880', '18:17', '102', '1', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/829f30cd843ad74e3fc8352f914edf7a.jpg', '0', '57', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('140', 'マジ軟派、初撮れおな 19歳 262', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201881', '1547201881', '18:17', '65', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/f7c0034ea02e01d8290195d7d0c43eab.jpg', '0', '58', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('141', 'マジ軟派、初撮れおな 19歳 263', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201882', '1547201882', '18:17', '72', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/a5b96acbf9e48d2c16324d1c05c9f243.jpg', '0', '58', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('142', 'マジ軟派、初撮れおな 19歳 240', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201882', '1547201882', '18:17', '69', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/8991183942160382eeb907efe1b4c539.jpg', '0', '58', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('143', 'マジ軟派、初撮れおな 19歳 252', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201883', '1547201883', '18:17', '141', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/b8e2575c4221e963a1c6f2acf4dfd375.jpg', '0', '58', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('144', 'マジ軟派、初撮れおな 19歳 238', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201884', '1547201884', '18:17', '135', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/7e9ccce820851ec2e25205ad5edc06aa.jpg', '0', '58', '68', '1', '0', '0', '', '0', '4', '0', '1', '');
INSERT INTO `ms_video` VALUES ('145', 'マジ軟派、初撮れおな 19歳 417', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201885', '1547201885', '18:17', '2554', '5', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/8fa553a95b2aa92dcec358de4889398b.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('146', 'マジ軟派、初撮れおな 19歳 416', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201885', '1547201885', '18:17', '1879', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/e1d0676350b7ec09c76d2b5bd8b2e956.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('147', 'マジ軟派、初撮れおな 19歳 415', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201886', '1547201886', '18:17', '1484', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/e4957732807b00f33fb71382d65c24da.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('148', 'マジ軟派、初撮れおな 19歳 414', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201886', '1547201886', '18:17', '1422', '1', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/8ef48dcc3c524d97b7822dbee010f3d6.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('149', 'マジ軟派、初撮れおな 19歳 413', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201887', '1547201887', '18:17', '1294', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/2ccf42fece8fa0dde9614c08acc6704d.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('150', 'マジ軟派、初撮れおな 19歳 412', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201888', '1547201888', '18:17', '1279', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/5e0a0e50722aa916bb8f903d103e3a3b.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('151', 'マジ軟派、初撮れおな 19歳 411', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201889', '1547201889', '18:17', '1212', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/0e1dfc0f1c08c75090fee686d97763f1.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('152', 'マジ軟派、初撮れおな 19歳 247', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201889', '1547201889', '18:17', '1261', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/9e15d42852cef978509dbd174be1adbe.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('153', 'マジ軟派、初撮れおな 19歳 255', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201890', '1547201890', '18:17', '1272', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/a4a9effe9e573289dec78a72317bfbbe.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('154', 'マジ軟派、初撮れおな 19歳 256', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201890', '1547201890', '18:17', '1319', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/a9851dd15a184a91d900f0cfd4ab25bc.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('155', 'マジ軟派、初撮れおな 19歳 249', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201891', '1547201891', '18:17', '1088', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/7e6176fcdcb5b9783e6460205aa8aeba.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('156', 'マジ軟派、初撮れおな 19歳 236', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201892', '1547201892', '18:17', '1103', '1', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/e55310ec914147a181be6cbc3d155464.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('157', 'マジ軟派、初撮れおな 19歳 419', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201893', '1547201893', '18:17', '1251', '2', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/694ec0513167590b2b24eaf36d2d4a9c.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('158', 'マジ軟派、初撮れおな 19歳 418', '', '', '', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201893', '1547201893', '18:17', '1112', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/8462a3bf7d1d1c3052cc569816fdb1de.jpg', '0', '58', '68', '1', '0', '0', '', '20', '10', '0', '1', '');
INSERT INTO `ms_video` VALUES ('159', 'マジ軟派、初撮れおな 19歳 420', '&lt;p&gt;视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介视频简介&lt;/p&gt;', '546545646', '454545', 'http://yzm.ymyuanma.com/video/m3u8/2018/06/16/eeda7bef/m3u8.m3u8', '', '1547201894', '1554260552', '18:17', '1320', '0', 'http://vhd101v10.ymyuanma.com/upload/vod/20181206-1/912186d174dd1ac126c9ce5cfd736881.jpg', '0', '58', '0', '1', '0', '0', '', '20', '0', '0', '1', '');

-- -----------------------------
-- Table structure for `ms_video_collection`
-- -----------------------------
DROP TABLE IF EXISTS `ms_video_collection`;
CREATE TABLE `ms_video_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  `video_id` int(11) DEFAULT '0' COMMENT '视频id',
  `collection_time` int(10) DEFAULT '0' COMMENT '收藏时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='视频收藏表';


-- -----------------------------
-- Table structure for `ms_video_good_log`
-- -----------------------------
DROP TABLE IF EXISTS `ms_video_good_log`;
CREATE TABLE `ms_video_good_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) DEFAULT NULL COMMENT '点赞的视频id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `add_time` int(10) DEFAULT NULL COMMENT '点赞时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='视频点赞记录表';

-- -----------------------------
-- Records of `ms_video_good_log`
-- -----------------------------
INSERT INTO `ms_video_good_log` VALUES ('83', '157', '4', '1555424290');

-- -----------------------------
-- Table structure for `ms_video_watch_log`
-- -----------------------------
DROP TABLE IF EXISTS `ms_video_watch_log`;
CREATE TABLE `ms_video_watch_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) NOT NULL COMMENT '视频id',
  `user_id` int(11) DEFAULT '0' COMMENT '用户Id',
  `user_ip` varchar(15) DEFAULT '0' COMMENT '用户ip',
  `gold` int(11) DEFAULT NULL COMMENT '消费金币数',
  `view_time` int(10) NOT NULL COMMENT '观看时间',
  `is_try_see` int(1) DEFAULT '0' COMMENT '是否为试看，1：试看',
  `is_myself` int(1) DEFAULT '0' COMMENT '是否为自己发布的视频,1:是,0:不是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2329 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='视频观看日志表';

-- -----------------------------
-- Records of `ms_video_watch_log`
-- -----------------------------
INSERT INTO `ms_video_watch_log` VALUES ('2272', '105', '0', '183.28.31.121', '0', '1553768742', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2273', '157', '2', '42.202.32.187', '20', '1554216145', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2274', '158', '2', '42.202.32.187', '20', '1554216230', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2275', '84', '2', '42.202.32.187', '0', '1554216415', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2276', '153', '2', '42.202.32.187', '0', '1554217048', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2277', '152', '2', '42.202.32.187', '0', '1554217073', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2278', '152', '0', '14.213.132.82', '0', '1554217266', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2279', '157', '0', '113.96.219.247', '0', '1554217276', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2280', '154', '0', '113.96.219.247', '0', '1554217308', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2281', '155', '0', '14.213.132.82', '0', '1554217341', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2282', '39', '2', '42.202.32.187', '0', '1554218473', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2283', '26', '2', '42.202.32.187', '0', '1554218484', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2284', '19', '2', '42.202.32.187', '0', '1554218700', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2285', '158', '0', '113.71.36.180', '0', '1554219054', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2286', '118', '0', '113.71.36.180', '0', '1554219083', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2287', '122', '0', '113.71.36.180', '0', '1554219094', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2288', '117', '0', '113.71.36.180', '0', '1554219108', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2289', '138', '0', '113.71.36.180', '0', '1554219116', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2290', '158', '0', '101.228.66.112', '0', '1554259929', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2291', '152', '0', '101.228.66.112', '0', '1554259985', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2292', '156', '0', '14.213.132.82', '0', '1554260517', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2293', '159', '0', '14.213.132.82', '0', '1554260597', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2294', '84', '3', '222.127.135.250', '0', '1554349205', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2295', '84', '0', '223.73.222.18', '0', '1554966779', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2296', '27', '4', '223.73.222.18', '0', '1554967758', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2297', '106', '4', '223.73.222.18', '0', '1554968218', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2298', '47', '4', '223.73.222.18', '0', '1554968234', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2299', '156', '0', '223.73.222.18', '0', '1554968483', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2300', '156', '4', '223.73.222.18', '20', '1554968569', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2301', '155', '4', '223.73.222.18', '20', '1554968640', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2302', '159', '4', '223.73.222.18', '0', '1554972891', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2303', '151', '4', '223.73.222.18', '0', '1554975281', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2304', '152', '0', '14.223.167.246', '0', '1554984974', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2305', '159', '0', '223.73.222.18', '0', '1555050504', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2306', '154', '0', '223.73.222.18', '0', '1555053107', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2307', '157', '0', '223.73.222.18', '0', '1555054228', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2308', '84', '0', '223.73.222.18', '0', '1555059724', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2309', '107', '0', '223.73.222.18', '0', '1555062148', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2310', '122', '0', '223.73.222.18', '0', '1555062204', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2311', '159', '0', '223.73.222.143', '0', '1555386447', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2312', '157', '4', '14.213.133.19', '0', '1555424289', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2313', '158', '0', '223.73.222.171', '0', '1555468532', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2314', '84', '4', '223.73.222.171', '0', '1555469492', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2315', '138', '4', '223.73.222.171', '0', '1555470672', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2316', '29', '0', '223.73.222.171', '0', '1555473690', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2317', '157', '4', '223.73.222.171', '0', '1555474009', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2318', '159', '0', '223.73.222.115', '0', '1555745777', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2319', '155', '0', '223.73.222.115', '0', '1555746482', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2320', '159', '0', '223.73.222.22', '0', '1556008544', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2321', '159', '7', '223.73.222.22', '20', '1556008643', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2322', '122', '7', '223.73.222.22', '0', '1556010613', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2323', '47', '0', '223.73.222.22', '0', '1556011099', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2324', '84', '0', '223.73.222.22', '0', '1556011791', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2325', '157', '7', '223.73.222.22', '20', '1556012637', '0', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2326', '157', '0', '123.55.39.49', '0', '1556017784', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2327', '153', '0', '221.120.161.91', '0', '1556027588', '1', '0');
INSERT INTO `ms_video_watch_log` VALUES ('2328', '105', '', '14.213.133.196', '0', '1556034909', '0', '0');

-- -----------------------------
-- Table structure for `ms_website_group_setting`
-- -----------------------------
DROP TABLE IF EXISTS `ms_website_group_setting`;
CREATE TABLE `ms_website_group_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT ' 序号',
  `domain` varchar(255) DEFAULT NULL COMMENT '域名',
  `logo_url` varchar(255) DEFAULT NULL COMMENT '网站logo地址',
  `site_title` varchar(255) DEFAULT NULL COMMENT '站点title',
  `site_keywords` varchar(255) DEFAULT NULL COMMENT '站点keywords',
  `site_description` varchar(255) DEFAULT NULL COMMENT '站点description',
  `add_time` int(10) NOT NULL COMMENT '添加时间',
  `site_logo_mobile` varchar(255) DEFAULT NULL COMMENT '手机站logo地址',
  `site_statis` text COMMENT '第三方流量统计代码，前台调用时请先用 htmlspecialchars_decode函数转义输出',
  `friend_link` text COMMENT '每行一条友情链接,单条规则：链接名称|网址,例：Msvodx|http://www.msvod.cc',
  `site_icp` varchar(64) DEFAULT NULL COMMENT 'icp备案号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='站群配置表';


-- -----------------------------
-- Table structure for `mss_admin`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin`;
CREATE TABLE `mss_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `version` int(10) unsigned NOT NULL DEFAULT '3' COMMENT '版本信息，1全能版，2旗舰版，3专享版',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL,
  `nick` varchar(50) NOT NULL DEFAULT '超级管理员' COMMENT '昵称',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `price` float(11,2) NOT NULL COMMENT '权限',
  `remarks` text NOT NULL COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `last_login_ip` varchar(128) NOT NULL COMMENT '最后登陆IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `db_config` text COMMENT '数据库配置',
  `role_id` int(10) NOT NULL DEFAULT '1' COMMENT '角色ID',
  `iframe` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0默认，1框架',
  `auth` text NOT NULL COMMENT '权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 管理用户';


-- -----------------------------
-- Table structure for `mss_admin_annex`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_annex`;
CREATE TABLE `mss_admin_annex` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联的数据ID',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '类型',
  `group` varchar(100) NOT NULL DEFAULT 'sys' COMMENT '文件分组',
  `file` varchar(255) NOT NULL COMMENT '上传文件',
  `hash` varchar(64) NOT NULL COMMENT '文件hash值',
  `size` decimal(12,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '附件大小KB',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '使用状态(0未使用，1已使用)',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `hash` (`hash`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 上传附件';


-- -----------------------------
-- Table structure for `mss_admin_annex_group`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_annex_group`;
CREATE TABLE `mss_admin_annex_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '附件分组',
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '附件数量',
  `size` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '附件大小kb',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 附件分组';

-- -----------------------------
-- Records of `mss_admin_annex_group`
-- -----------------------------
INSERT INTO `mss_admin_annex_group` VALUES ('1', 'sys', '0', '0.00');

-- -----------------------------
-- Table structure for `mss_admin_config`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_config`;
CREATE TABLE `mss_admin_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统配置(1是，0否)',
  `group` varchar(20) NOT NULL DEFAULT 'base' COMMENT '分组',
  `title` varchar(20) NOT NULL COMMENT '配置标题',
  `name` varchar(50) NOT NULL COMMENT '配置名称，由英文字母和下划线组成',
  `value` text NOT NULL COMMENT '配置值',
  `type` varchar(20) NOT NULL DEFAULT 'input' COMMENT '配置类型()',
  `options` text NOT NULL COMMENT '配置项(选项名:选项值)',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '文件上传接口',
  `tips` varchar(255) NOT NULL COMMENT '配置提示',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 系统配置';

-- -----------------------------
-- Records of `mss_admin_config`
-- -----------------------------
INSERT INTO `mss_admin_config` VALUES ('1', '1', 'sys', '扩展配置分组', 'config_group', '', 'array', ' ', '', '请按如下格式填写：&lt;br&gt;键值:键名&lt;br&gt;键值:键名&lt;br&gt;&lt;span style=&quot;color:#f00&quot;&gt;键值只能为英文、数字、下划线&lt;/span&gt;', '1', '1', '1492140215', '1492140215');
INSERT INTO `mss_admin_config` VALUES ('13', '1', 'base', '网站域名', 'site_domain', '', 'input', '', '', '', '2', '1', '1492140215', '1492140215');
INSERT INTO `mss_admin_config` VALUES ('14', '1', 'upload', '图片上传大小限制', 'upload_image_size', '0', 'input', '', '', '单位：KB，0表示不限制大小', '3', '1', '1490841797', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('15', '1', 'upload', '允许上传图片格式', 'upload_image_ext', 'jpg,png,gif,jpeg,ico', 'input', '', '', '多个格式请用英文逗号（,）隔开', '4', '1', '1490842130', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('16', '1', 'upload', '缩略图裁剪方式', 'thumb_type', '2', 'select', '1:等比例缩放
2:缩放后填充
3:居中裁剪
4:左上角裁剪
5:右下角裁剪
6:固定尺寸缩放
', '', '', '5', '1', '1490842450', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('17', '1', 'upload', '图片水印开关', 'image_watermark', '1', 'switch', '0:关闭
1:开启', '', '', '6', '1', '1490842583', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('18', '1', 'upload', '图片水印图', 'image_watermark_pic', '/upload/sys/image/49/4d0430eaf30318ef847086d0b63db0.png', 'image', '', '', '', '7', '1', '1490842679', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('19', '1', 'upload', '图片水印透明度', 'image_watermark_opacity', '50', 'input', '', '', '可设置值为0~100，数字越小，透明度越高', '8', '1', '1490857704', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('20', '1', 'upload', '图片水印图位置', 'image_watermark_location', '9', 'select', '7:左下角
1:左上角
4:左居中
9:右下角
3:右上角
6:右居中
2:上居中
8:下居中
5:居中', '', '', '9', '1', '1490858228', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('21', '1', 'upload', '文件上传大小限制', 'upload_file_size', '0', 'input', '', '', '单位：KB，0表示不限制大小', '1', '1', '1490859167', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('22', '1', 'upload', '允许上传文件格式', 'upload_file_ext', 'doc,docx,xls,xlsx,ppt,pptx,pdf,wps,txt,rar,zip', 'input', '', '', '多个格式请用英文逗号（,）隔开', '2', '1', '1490859246', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('23', '1', 'upload', '文字水印开关', 'text_watermark', '0', 'switch', '0:关闭
1:开启', '', '', '10', '1', '1490860872', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('24', '1', 'upload', '文字水印内容', 'text_watermark_content', '', 'input', '', '', '', '11', '1', '1490861005', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('25', '1', 'upload', '文字水印字体', 'text_watermark_font', '', 'file', '', '', '不上传将使用系统默认字体', '12', '1', '1490861117', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('26', '1', 'upload', '文字水印字体大小', 'text_watermark_size', '20', 'input', '', '', '单位：px(像素)', '13', '1', '1490861204', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('27', '1', 'upload', '文字水印颜色', 'text_watermark_color', '#000000', 'input', '', '', '文字水印颜色，格式:#000000', '14', '1', '1490861482', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('28', '1', 'upload', '文字水印位置', 'text_watermark_location', '7', 'select', '7:左下角
1:左上角
4:左居中
9:右下角
3:右上角
6:右居中
2:上居中
8:下居中
5:居中', '', '', '11', '1', '1490861718', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('29', '1', 'upload', '缩略图尺寸', 'thumb_size', '300x300;500x500', 'input', '', '', '为空则不生成，生成 500x500 的缩略图，则填写 500x500，多个规格填写参考 300x300;500x500;800x800', '4', '1', '1490947834', '1491040778');
INSERT INTO `mss_admin_config` VALUES ('30', '1', 'develop', '开发模式', 'app_debug', '0', 'switch', '0:关闭
1:开启', '', '', '0', '1', '1491005004', '1492093874');
INSERT INTO `mss_admin_config` VALUES ('31', '1', 'develop', '页面Trace', 'app_trace', '0', 'switch', '0:关闭
1:开启', '', '', '0', '1', '1491005081', '1492093874');
INSERT INTO `mss_admin_config` VALUES ('33', '1', 'sys', '富文本编辑器', 'editor', 'UEditor', 'select', 'ueditor:UEditor
umeditor:UMEditor
kindeditor:KindEditor
ckeditor:CKEditor', '', '', '2', '1', '1491142648', '1492140215');
INSERT INTO `mss_admin_config` VALUES ('35', '1', 'databases', '备份目录', 'backup_path', './backup/database/', 'input', '', '', '数据库备份路径,路径必须以 / 结尾', '0', '1', '1491881854', '1491965974');
INSERT INTO `mss_admin_config` VALUES ('36', '1', 'databases', '备份分卷大小', 'part_size', '20971520', 'input', '', '', '用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '0', '1', '1491881975', '1491965974');
INSERT INTO `mss_admin_config` VALUES ('37', '1', 'databases', '备份压缩开关', 'compress', '1', 'switch', '0:关闭
1:开启', '', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '0', '1', '1491882038', '1491965974');
INSERT INTO `mss_admin_config` VALUES ('38', '1', 'databases', '备份压缩级别', 'compress_level', '4', 'radio', '1:最低
4:一般
9:最高', '', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '0', '1', '1491882154', '1491965974');
INSERT INTO `mss_admin_config` VALUES ('39', '1', 'base', '网站状态', 'site_status', '0', 'switch', '0:关闭
1:开启', '', '站点关闭后将不能访问，后台可正常登录', '1', '1', '1492049460', '1494690024');
INSERT INTO `mss_admin_config` VALUES ('40', '1', 'sys', '后台管理路径', 'admin_path', 'admin.php', 'input', '', '', '必须以.php为后缀', '0', '1', '1492139196', '1492140215');
INSERT INTO `mss_admin_config` VALUES ('41', '1', 'base', '网站标题', 'site_title', 'msvods视频系统', 'input', '', '', '网站标题是体现一个网站的主旨，要做到主题突出、标题简洁、连贯等特点，建议不超过28个字', '6', '1', '1492502354', '1494695131');
INSERT INTO `mss_admin_config` VALUES ('42', '1', 'base', '网站关键词', 'site_keywords', 'msvods视频系统', 'input', '', '', '网页内容所包含的核心搜索关键词，多个关键字请用英文逗号&quot;,&quot;分隔', '7', '1', '1494690508', '1494690780');
INSERT INTO `mss_admin_config` VALUES ('43', '1', 'base', '网站描述', 'site_description', 'msvods视频系统', 'textarea', '', '', '网页的描述信息，搜索引擎采纳后，作为搜索结果中的页面摘要显示，建议不超过80个字', '8', '1', '1494690669', '1494691075');
INSERT INTO `mss_admin_config` VALUES ('44', '1', 'base', 'ICP备案信息', 'site_icp', '', 'input', '', '', '请填写ICP备案号，用于展示在网站底部，ICP备案官网：&lt;a href=&quot;http://www.miibeian.gov.cn&quot; target=&quot;_blank&quot;&gt;http://www.miibeian.gov.cn&lt;/a&gt;', '9', '1', '1494691721', '1494692046');
INSERT INTO `mss_admin_config` VALUES ('45', '1', 'base', '站点统计代码', 'site_statis', '', 'textarea', '', '', '第三方流量统计代码，前台调用时请先用 htmlspecialchars_decode函数转义输出', '10', '1', '1494691959', '1494694797');
INSERT INTO `mss_admin_config` VALUES ('46', '1', 'base', '网站名称', 'site_name', 'msvods视频系统', 'input', '', '', '将显示在浏览器窗口标题等位置', '3', '1', '1494692103', '1494694680');
INSERT INTO `mss_admin_config` VALUES ('47', '1', 'base', '网站LOGO', 'site_logo', '', 'image', '', '', '网站LOGO图片', '4', '1', '1494692345', '1494693235');
INSERT INTO `mss_admin_config` VALUES ('48', '1', 'base', '网站图标', 'site_favicon', '', 'image', '', '/admin/annex/favicon', '又叫网站收藏夹图标，它显示位于浏览器的地址栏或者标题前面，&lt;strong class=&quot;red&quot;&gt;.ico格式&lt;/strong&gt;，&lt;a href=&quot;https://www.baidu.com/s?ie=UTF-8&amp;wd=favicon&quot; target=&quot;_blank&quot;&gt;点此了解网站图标&lt;/a&gt;', '5', '1', '1494692781', '1494693966');
INSERT INTO `mss_admin_config` VALUES ('49', '1', 'base', '手机网站', 'wap_site_status', '1', 'switch', '0:关闭
1:开启', '', '如果有手机网站，请设置为开启状态，否则只显示PC网站', '2', '1', '1498405436', '1498405436');
INSERT INTO `mss_admin_config` VALUES ('50', '1', 'sys', '云端推送', 'cloud_push', '0', 'switch', '0:关闭
1:开启', '', '关闭之后，无法通过云端推送安装扩展', '3', '1', '1504250320', '1504250320');
INSERT INTO `mss_admin_config` VALUES ('51', '0', 'base', '手机网站域名', 'wap_domain', 'msvods视频系统', 'input', '', '', '手机访问将自动跳转至此域名', '2', '1', '1504304776', '1504304837');
INSERT INTO `mss_admin_config` VALUES ('52', '0', 'sys', '多语言支持', 'multi_language', '0', 'switch', '0:关闭
1:开启', '', '开启后你可以自由上传多种语言包', '4', '1', '1506532211', '1506532211');

-- -----------------------------
-- Table structure for `mss_admin_hook`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_hook`;
CREATE TABLE `mss_admin_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '系统插件',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `source` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子来源[plugins.插件名，module.模块名]',
  `intro` varchar(200) NOT NULL DEFAULT '' COMMENT '钩子简介',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 钩子表';

-- -----------------------------
-- Records of `mss_admin_hook`
-- -----------------------------
INSERT INTO `mss_admin_hook` VALUES ('1', '1', 'system_admin_index', '', '后台首页', '1', '1490885108', '1490885108');
INSERT INTO `mss_admin_hook` VALUES ('2', '1', 'system_admin_tips', '', '后台所有页面提示', '1', '1490713165', '1490885137');
INSERT INTO `mss_admin_hook` VALUES ('3', '1', 'system_annex_upload', '', '附件上传钩子，可扩展上传到第三方存储', '1', '1490884242', '1490885121');
INSERT INTO `mss_admin_hook` VALUES ('4', '1', 'system_member_login', '', '会员登陆成功之后的动作', '1', '1490885108', '1490885108');

-- -----------------------------
-- Table structure for `mss_admin_hook_plugins`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_hook_plugins`;
CREATE TABLE `mss_admin_hook_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hook` varchar(32) NOT NULL COMMENT '钩子id',
  `plugins` varchar(32) NOT NULL COMMENT '插件标识',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0',
  `mtime` int(11) unsigned NOT NULL DEFAULT '0',
  `sort` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 钩子-插件对应表';


-- -----------------------------
-- Table structure for `mss_admin_language`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_language`;
CREATE TABLE `mss_admin_language` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '语言包名称',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '编码',
  `locale` varchar(255) NOT NULL DEFAULT '' COMMENT '本地浏览器语言编码',
  `icon` varchar(30) NOT NULL DEFAULT '' COMMENT '图标',
  `pack` varchar(100) NOT NULL DEFAULT '' COMMENT '上传的语言包',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 语言包';

-- -----------------------------
-- Records of `mss_admin_language`
-- -----------------------------
INSERT INTO `mss_admin_language` VALUES ('1', '简体中文', 'zh-cn', 'zh-CN,zh-CN.UTF-8,zh-cn', '', '1', '1', '1');

-- -----------------------------
-- Table structure for `mss_admin_log`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_log`;
CREATE TABLE `mss_admin_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) DEFAULT '',
  `url` varchar(200) DEFAULT '',
  `param` text,
  `remark` varchar(255) DEFAULT '',
  `count` int(10) unsigned NOT NULL DEFAULT '1',
  `ip` varchar(128) DEFAULT '',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3924 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 操作日志';

-- -----------------------------
-- Records of `mss_admin_log`
-- -----------------------------
INSERT INTO `mss_admin_log` VALUES ('3923', '2', '备份数据库', 'admin/database/export', '{\"ids\":[\"ms_admin\",\"ms_admin_annex\",\"ms_admin_annex_group\",\"ms_admin_config\",\"ms_admin_hook\",\"ms_admin_hook_plugins\",\"ms_admin_language\",\"ms_admin_log\",\"ms_admin_member\",\"ms_admin_member_level\",\"ms_admin_menu\",\"ms_admin_menu_copy1\",\"ms_admin_menu_lang\",\"ms_admin_module\",\"ms_admin_plugins\",\"ms_admin_role\",\"ms_admin_user\",\"ms_advertisement\",\"ms_advertisement_position\",\"ms_agent_apply\",\"ms_atlas\",\"ms_atlas_good_log\",\"ms_atlas_watch_log\",\"ms_banner\",\"ms_card_password\",\"ms_class\",\"ms_comment\",\"ms_domain_cname_binding\",\"ms_draw_money_account\",\"ms_draw_money_log\",\"ms_gift\",\"ms_gold_log\",\"ms_gold_package\",\"ms_gratuity_record\",\"ms_image\",\"ms_image_collection\",\"ms_login_log\",\"ms_login_setting\",\"ms_member\",\"ms_member_copy\",\"ms_menu\",\"ms_notice\",\"ms_novel\",\"ms_novel_collection\",\"ms_novel_good_log\",\"ms_novel_watch_log\",\"ms_order\",\"ms_payment\",\"ms_recharge_package\",\"ms_share_log\",\"ms_sign\",\"ms_tag\",\"ms_user_atlas\",\"ms_version_role\",\"ms_video\",\"ms_video_collection\",\"ms_video_good_log\",\"ms_video_watch_log\",\"ms_website_group_setting\",\"mss_admin\",\"mss_admin_annex\",\"mss_admin_annex_group\",\"mss_admin_config\",\"mss_admin_hook\",\"mss_admin_hook_plugins\",\"mss_admin_language\",\"mss_admin_log\",\"mss_admin_member\",\"mss_admin_member_level\",\"mss_admin_menu\",\"mss_admin_menu_copy1\",\"mss_admin_menu_lang\",\"mss_admin_module\",\"mss_admin_plugins\",\"mss_admin_role\",\"mss_admin_user\",\"mss_card_password\",\"mss_domain_cname_binding\",\"mss_gold_package\",\"mss_login_setting\",\"mss_notice\",\"mss_version_role\",\"mss_video\"]}', '保存数据', '1', '47.91.220.217', '1556036509', '1556036509');

-- -----------------------------
-- Table structure for `mss_admin_member`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_member`;
CREATE TABLE `mss_admin_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员等级ID',
  `nick` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `mobile` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '手机号',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(128) NOT NULL COMMENT '密码',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '可用金额',
  `frozen_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '冻结金额',
  `income` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '收入统计',
  `expend` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '开支统计',
  `exper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '经验值',
  `integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `frozen_integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '冻结积分',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '性别(1男，0女)',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `last_login_ip` varchar(128) NOT NULL DEFAULT '' COMMENT '最后登陆IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `login_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期时间(0永久)',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0禁用，1正常)',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 会员表';


-- -----------------------------
-- Table structure for `mss_admin_member_level`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_member_level`;
CREATE TABLE `mss_admin_member_level` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL COMMENT '等级名称',
  `min_exper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最小经验值',
  `max_exper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最大经验值',
  `discount` int(2) unsigned NOT NULL DEFAULT '100' COMMENT '折扣率(%)',
  `intro` varchar(255) NOT NULL COMMENT '等级简介',
  `default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '默认等级',
  `expire` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员有效期(天)',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 会员等级';

-- -----------------------------
-- Records of `mss_admin_member_level`
-- -----------------------------
INSERT INTO `mss_admin_member_level` VALUES ('1', '注册会员', '0', '0', '100', '', '1', '0', '1', '0', '1491966814');

-- -----------------------------
-- Table structure for `mss_admin_menu`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_menu`;
CREATE TABLE `mss_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID(快捷菜单专用)',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `module` varchar(20) NOT NULL COMMENT '模块名或插件名，插件名格式:plugins.插件名',
  `title` varchar(20) NOT NULL COMMENT '菜单标题',
  `icon` varchar(80) NOT NULL DEFAULT 'aicon ai-shezhi' COMMENT '菜单图标',
  `url` varchar(200) NOT NULL COMMENT '链接地址(模块/控制器/方法)',
  `param` varchar(200) NOT NULL DEFAULT '' COMMENT '扩展参数',
  `target` varchar(20) NOT NULL DEFAULT '_self' COMMENT '打开方式(_blank,_self)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `debug` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开发模式可见',
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统菜单，系统菜单不可删除',
  `nav` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否为菜单显示，1显示0不显示',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态1显示，0隐藏',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=336 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 管理菜单';

-- -----------------------------
-- Records of `mss_admin_menu`
-- -----------------------------
INSERT INTO `mss_admin_menu` VALUES ('1', '0', '0', 'admin', '首页', '', 'admin/index', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('2', '0', '0', 'admin', '系统', '', 'admin/system', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('3', '0', '0', 'admin', '插件', 'aicon ai-shezhi', 'admin/plugins', '', '_self', '0', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('4', '0', '1', 'admin', '快捷菜单', 'aicon ai-shezhi', 'admin/quick', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('5', '0', '3', 'admin', '插件列表', 'aicon ai-shezhi', 'admin/plugins', '', '_self', '0', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('6', '0', '2', 'admin', '系统功能', 'fa fa-cog', 'admin/system', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('7', '0', '252', 'admin', '会员管理', 'fa fa-user-circle-o', 'admin/member', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('8', '0', '2', 'admin', '系统扩展', 'aicon ai-shezhi', 'admin/extend', '', '_self', '3', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('9', '0', '2', 'admin', '开发专用', 'aicon ai-shezhi', 'admin/develop', '', '_self', '4', '1', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('10', '0', '6', 'admin', '系统设置', '', 'admin/system/index', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('11', '0', '6', 'admin', '配置管理', '', 'admin/config/index', '', '_self', '2', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('12', '0', '2', 'admin', '系统菜单', '', 'admin/menu/index', '', '_self', '3', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('13', '0', '6', 'admin', '管理员角色', '', 'admin/user/role', '', '_self', '4', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('14', '0', '6', 'admin', '系统管理员', '', 'admin/user/index', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('15', '0', '6', 'admin', '系统日志', '', 'admin/log/index', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('16', '0', '6', 'admin', '附件管理', '', 'admin/annex/index', '', '_self', '7', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('17', '0', '8', 'admin', '模块管理', '', 'admin/module/index', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('18', '0', '8', 'admin', '插件管理', '', 'admin/plugins/index', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('19', '0', '8', 'admin', '钩子管理', '', 'admin/hook/index', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('20', '0', '7', 'admin', '会员等级', '', 'admin/member/level', '', '_self', '1', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('21', '0', '7', 'admin', '会员列表', 'fa fa-list', 'admin/member/index', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('22', '0', '9', 'admin', '[示例]列表模板', '', 'admin/develop/lists', '', '_self', '1', '1', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('23', '0', '9', 'admin', '[示例]编辑模板', '', 'admin/develop/edit', '', '_self', '2', '1', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('24', '0', '4', 'admin', '后台首页', '', 'admin/index/index', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('25', '0', '4', 'admin', '清空缓存', '', 'admin/index/clear', '', '_self', '1', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('26', '0', '12', 'admin', '添加菜单', '', 'admin/menu/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('27', '0', '12', 'admin', '修改菜单', '', 'admin/menu/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('28', '0', '12', 'admin', '删除菜单', '', 'admin/menu/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('29', '0', '12', 'admin', '状态设置', '', 'admin/menu/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('30', '0', '12', 'admin', '排序设置', '', 'admin/menu/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('31', '0', '12', 'admin', '添加快捷菜单', '', 'admin/menu/quick', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('32', '0', '12', 'admin', '导出菜单', '', 'admin/menu/export', '', '_self', '7', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('33', '0', '13', 'admin', '添加角色', '', 'admin/user/addrole', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('34', '0', '13', 'admin', '修改角色', '', 'admin/user/editrole', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('35', '0', '13', 'admin', '删除角色', '', 'admin/user/delrole', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('36', '0', '13', 'admin', '状态设置', '', 'admin/user/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('37', '0', '14', 'admin', '添加管理员', '', 'admin/user/adduser', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('38', '0', '14', 'admin', '修改管理员', '', 'admin/user/edituser', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('39', '0', '14', 'admin', '删除管理员', '', 'admin/user/deluser', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('40', '0', '14', 'admin', '状态设置', '', 'admin/user/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('41', '0', '14', 'admin', '个人信息设置', '', 'admin/user/info', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('42', '0', '18', 'admin', '安装插件', '', 'admin/plugins/install', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('43', '0', '18', 'admin', '卸载插件', '', 'admin/plugins/uninstall', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('44', '0', '18', 'admin', '删除插件', '', 'admin/plugins/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('45', '0', '18', 'admin', '状态设置', '', 'admin/plugins/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('46', '0', '18', 'admin', '设计插件', '', 'admin/plugins/design', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('47', '0', '18', 'admin', '运行插件', '', 'admin/plugins/run', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('48', '0', '18', 'admin', '更新插件', '', 'admin/plugins/update', '', '_self', '7', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('49', '0', '18', 'admin', '插件配置', '', 'admin/plugins/setting', '', '_self', '8', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('50', '0', '19', 'admin', '添加钩子', '', 'admin/hook/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('51', '0', '19', 'admin', '修改钩子', '', 'admin/hook/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('52', '0', '19', 'admin', '删除钩子', '', 'admin/hook/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('53', '0', '19', 'admin', '状态设置', '', 'admin/hook/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('54', '0', '19', 'admin', '插件排序', '', 'admin/hook/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('55', '0', '11', 'admin', '添加配置', '', 'admin/config/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('56', '0', '11', 'admin', '修改配置', '', 'admin/config/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('57', '0', '11', 'admin', '删除配置', '', 'admin/config/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('58', '0', '11', 'admin', '状态设置', '', 'admin/config/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('59', '0', '11', 'admin', '排序设置', '', 'admin/config/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('60', '0', '10', 'admin', '基础配置', '', 'admin/system/index', 'group=base', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('61', '0', '10', 'admin', '系统配置', '', 'admin/system/index', 'group=sys', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('62', '0', '10', 'admin', '上传配置', '', 'admin/system/index', 'group=upload', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('63', '0', '10', 'admin', '开发配置', '', 'admin/system/index', 'group=develop', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('64', '0', '17', 'admin', '设计模块', '', 'admin/module/design', '', '_self', '6', '1', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('65', '0', '17', 'admin', '安装模块', '', 'admin/module/install', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('66', '0', '17', 'admin', '卸载模块', '', 'admin/module/uninstall', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('67', '0', '17', 'admin', '状态设置', '', 'admin/module/status', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('68', '0', '17', 'admin', '设置默认模块', '', 'admin/module/setdefault', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('69', '0', '17', 'admin', '删除模块', '', 'admin/module/del', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('70', '0', '21', 'admin', '添加会员', '', 'admin/member/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('71', '0', '21', 'admin', '修改会员', '', 'admin/member/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('72', '0', '21', 'admin', '删除会员', '', 'admin/member/del', 'table=admin_member', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('73', '0', '21', 'admin', '状态设置', '', 'admin/member/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('74', '0', '21', 'admin', '[弹窗]会员选择', '', 'admin/member/pop', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('75', '0', '20', 'admin', '添加会员等级', '', 'admin/member/addlevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('76', '0', '20', 'admin', '修改会员等级', '', 'admin/member/editlevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('77', '0', '20', 'admin', '删除会员等级', '', 'admin/member/dellevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('78', '0', '16', 'admin', '附件上传', '', 'admin/annex/upload', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('79', '0', '16', 'admin', '删除附件', '', 'admin/annex/del', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('80', '0', '8', 'admin', '在线升级', '', 'admin/upgrade/index', '', '_self', '4', '0', '1', '1', '1', '1491352728');
INSERT INTO `mss_admin_menu` VALUES ('81', '0', '80', 'admin', '获取升级列表', '', 'admin/upgrade/lists', '', '_self', '0', '0', '1', '1', '1', '1491353504');
INSERT INTO `mss_admin_menu` VALUES ('82', '0', '80', 'admin', '安装升级包', '', 'admin/upgrade/install', '', '_self', '0', '0', '1', '1', '1', '1491353568');
INSERT INTO `mss_admin_menu` VALUES ('83', '0', '80', 'admin', '下载升级包', '', 'admin/upgrade/download', '', '_self', '0', '0', '1', '1', '1', '1491395830');
INSERT INTO `mss_admin_menu` VALUES ('84', '0', '6', 'admin', '数据库管理', '', 'admin/database/index', '', '_self', '4', '0', '1', '1', '1', '1491461136');
INSERT INTO `mss_admin_menu` VALUES ('85', '0', '84', 'admin', '备份数据库', '', 'admin/database/export', '', '_self', '0', '0', '1', '1', '1', '1491461250');
INSERT INTO `mss_admin_menu` VALUES ('86', '0', '84', 'admin', '恢复数据库', '', 'admin/database/import', '', '_self', '0', '0', '1', '1', '1', '1491461315');
INSERT INTO `mss_admin_menu` VALUES ('87', '0', '84', 'admin', '优化数据库', '', 'admin/database/optimize', '', '_self', '0', '0', '1', '1', '1', '1491467000');
INSERT INTO `mss_admin_menu` VALUES ('88', '0', '84', 'admin', '删除备份', '', 'admin/database/del', '', '_self', '0', '0', '1', '1', '1', '1491467058');
INSERT INTO `mss_admin_menu` VALUES ('89', '0', '84', 'admin', '修复数据库', '', 'admin/database/repair', '', '_self', '0', '0', '1', '1', '1', '1491880879');
INSERT INTO `mss_admin_menu` VALUES ('90', '0', '21', 'admin', '设置默认等级', '', 'admin/member/setdefault', '', '_self', '0', '0', '1', '1', '1', '1491966585');
INSERT INTO `mss_admin_menu` VALUES ('91', '0', '10', 'admin', '数据库配置', '', 'admin/system/index', 'group=databases', '_self', '3', '0', '1', '1', '1', '1492072213');
INSERT INTO `mss_admin_menu` VALUES ('92', '0', '17', 'admin', '模块打包', '', 'admin/module/package', '', '_self', '7', '0', '1', '1', '1', '1492134693');
INSERT INTO `mss_admin_menu` VALUES ('93', '0', '18', 'admin', '插件打包', '', 'admin/plugins/package', '', '_self', '0', '0', '1', '1', '1', '1492134743');
INSERT INTO `mss_admin_menu` VALUES ('94', '0', '17', 'admin', '主题管理', '', 'admin/module/theme', '', '_self', '8', '0', '1', '1', '1', '1492433470');
INSERT INTO `mss_admin_menu` VALUES ('95', '0', '17', 'admin', '设置默认主题', '', 'admin/module/setdefaulttheme', '', '_self', '9', '0', '1', '1', '1', '1492433618');
INSERT INTO `mss_admin_menu` VALUES ('96', '0', '17', 'admin', '删除主题', '', 'admin/module/deltheme', '', '_self', '10', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('97', '0', '6', 'admin', '语言包管理', '', 'admin/language/index', '', '_self', '11', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('98', '0', '97', 'admin', '添加语言包', '', 'admin/language/add', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('99', '0', '97', 'admin', '修改语言包', '', 'admin/language/edit', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('100', '0', '97', 'admin', '删除语言包', '', 'admin/language/del', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('101', '0', '97', 'admin', '排序设置', '', 'admin/language/sort', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('102', '0', '97', 'admin', '状态设置', '', 'admin/language/status', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('103', '0', '16', 'admin', '收藏夹图标上传', '', 'admin/annex/favicon', '', '_self', '3', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('104', '0', '17', 'admin', '导入模块', '', 'admin/module/import', '', '_self', '11', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('105', '0', '4', 'admin', '欢迎页面', '', 'admin/index/welcome', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('106', '0', '4', 'admin', '布局切换', '', 'admin/user/iframe', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('107', '0', '15', 'admin', '删除日志', '', 'admin/log/del', 'table=admin_log', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('108', '0', '15', 'admin', '清空日志', '', 'admin/log/clear', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('109', '0', '17', 'admin', '编辑模块', '', 'admin/module/edit', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('110', '0', '17', 'admin', '模块图标上传', '', 'admin/module/icon', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('111', '0', '18', 'admin', '导入插件', '', 'admin/plugins/import', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('112', '0', '19', 'admin', '钩子插件状态', '', 'admin/hook/hookPluginsStatus', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('113', '0', '4', 'admin', '设置主题', '', 'admin/user/setTheme', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('114', '0', '8', 'admin', '应用市场', 'aicon ai-app-store', 'admin/store/index', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('115', '0', '114', 'admin', '安装应用', '', 'admin/store/install', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('116', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('117', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('118', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('119', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('120', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('121', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('122', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('123', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('124', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('125', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('126', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('127', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('128', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('129', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('130', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('131', '0', '238', 'admin', '视频管理', 'fa fa-video-camera', 'admin/video', '', '_self', '0', '0', '0', '1', '1', '1510110844');
INSERT INTO `mss_admin_menu` VALUES ('132', '0', '131', 'admin', '视频上传', 'aicon ai-tuichu', 'admin/video/upload', '', '_self', '0', '0', '0', '1', '1', '1510110945');
INSERT INTO `mss_admin_menu` VALUES ('133', '0', '6', 'admin', '数据库配置', 'aicon ai-shezhi', 'admin/dbconfig/index', '', '_self', '2', '0', '0', '1', '1', '1510133228');
INSERT INTO `mss_admin_menu` VALUES ('134', '0', '2', 'admin', '资源标签管理', 'aicon ai-shezhi', 'admin/index/taglist', '', '_self', '0', '0', '1', '0', '1', '1510193325');
INSERT INTO `mss_admin_menu` VALUES ('136', '0', '134', 'admin', '排序配置', '', 'admin/index/khsort', '', '_self', '0', '0', '1', '0', '1', '1510208623');
INSERT INTO `mss_admin_menu` VALUES ('137', '0', '134', 'admin', '状态开关', '', 'admin/index/khstatus', '', '_self', '0', '0', '1', '0', '1', '1510209960');
INSERT INTO `mss_admin_menu` VALUES ('139', '0', '134', 'admin', '删除标签', '', 'admin/index/khdel', '', '_self', '0', '0', '1', '0', '1', '1510210570');
INSERT INTO `mss_admin_menu` VALUES ('140', '0', '6', 'admin', '视频设置', '', 'admin/system/video', '', '_self', '1', '0', '1', '0', '1', '1510210570');
INSERT INTO `mss_admin_menu` VALUES ('142', '0', '6', 'admin', '附件设置', ' ', 'admin/system/attachment', '', '_self', '0', '0', '1', '0', '1', '1510210570');
INSERT INTO `mss_admin_menu` VALUES ('143', '0', '131', 'admin', '视频列表', 'fa fa-laptop', 'admin/video/lists', '', '_self', '0', '0', '0', '1', '1', '1510542225');
INSERT INTO `mss_admin_menu` VALUES ('147', '0', '2', 'admin', '分类管理', 'aicon ai-shezhi', 'admin/index/class', '', '_self', '0', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('148', '0', '161', 'admin', '图片标签', '', 'admin/index/taglist', 'type=2', '_self', '3', '0', '0', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('149', '0', '131', 'admin', '视频标签', '', 'admin/index/taglist', 'type=1', '_self', '0', '0', '0', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('151', '0', '164', 'admin', '资讯标签', '', 'admin/index/taglist', 'type=3', '_self', '3', '0', '0', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu` VALUES ('152', '0', '131', 'admin', '状态开启', '', 'admin/video/khstatus', '', '_self', '0', '0', '0', '0', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('153', '0', '131', 'admin', '视频分类', '', 'admin/index/classlist', 'type=1', '_self', '0', '0', '0', '1', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('154', '0', '161', 'admin', '图片分类', '', 'admin/index/classlist', 'type=2', '_self', '4', '0', '0', '1', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('155', '0', '164', 'admin', '资讯分类', '', 'admin/index/classlist', 'type=3', '_self', '4', '0', '0', '1', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('156', '0', '131', 'admin', '视频编辑', '', 'admin/video/edit', '', '_self', '0', '0', '1', '0', '1', '1510568721');
INSERT INTO `mss_admin_menu` VALUES ('157', '0', '2', 'admin', '个性化设置', 'fa fa-tachometer', 'admin/personality', '', '_self', '1', '0', '1', '1', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('158', '0', '157', 'admin', 'Banner图管理', 'aicon ai-shezhi', 'admin/banner/index', '', '_self', '0', '0', '0', '1', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('161', '0', '238', 'admin', '图片管理', 'fa fa-image', 'admin/image', '', '_self', '2', '0', '0', '1', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('162', '0', '161', 'admin', '添加图册', 'aicon ai-shezhi', 'admin/image/add', '', '_self', '1', '0', '0', '1', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('163', '0', '161', 'admin', '图册列表', 'aicon ai-shezhi', 'admin/image/lists', '', '_self', '2', '0', '0', '1', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('164', '0', '238', 'admin', '资讯管理', 'fa fa-book', 'admin/novel', '', '_self', '2', '0', '0', '1', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('165', '0', '164', 'admin', '添加资讯', 'aicon ai-shezhi', 'admin/novel/add', '', '_self', '1', '0', '0', '1', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('166', '0', '164', 'admin', '资讯列表', 'aicon ai-shezhi', 'admin/novel/lists', '', '_self', '2', '0', '0', '1', '1', '1510561408');
INSERT INTO `mss_admin_menu` VALUES ('167', '0', '131', 'admin', '视频删除', '', 'admin/video/khdel', '', '_self', '0', '0', '0', '0', '1', '1510625120');
INSERT INTO `mss_admin_menu` VALUES ('169', '0', '157', 'admin', 'banner图添加', '', 'admin/banner/add', '', '_self', '0', '0', '0', '0', '1', '1510625216');
INSERT INTO `mss_admin_menu` VALUES ('170', '0', '164', 'admin', '更换状态', '', 'admin/banner/khstatus', '', '_self', '0', '0', '0', '0', '1', '1510625216');
INSERT INTO `mss_admin_menu` VALUES ('171', '0', '157', 'admin', '删除banner', '', 'admin/banner/khdel', '', '_self', '0', '0', '0', '0', '1', '1510625216');
INSERT INTO `mss_admin_menu` VALUES ('172', '0', '2', 'admin', '状态设置', 'aicon ai-shezhi', 'admin/config/khstatus', '', '_self', '0', '0', '0', '0', '1', '1510625216');
INSERT INTO `mss_admin_menu` VALUES ('173', '0', '2', 'admin', '删除设置', 'aicon ai-shezhi', 'admin/config/khdel', '', '_self', '0', '0', '0', '0', '1', '1510625216');
INSERT INTO `mss_admin_menu` VALUES ('174', '0', '157', 'admin', 'banner编辑', 'aicon ai-shezhi', 'admin/banner/edit', '', '_self', '0', '0', '0', '0', '1', '1510625216');
INSERT INTO `mss_admin_menu` VALUES ('175', '0', '153', 'admin', '分类编辑', '', 'admin/index/classedit', '', '_self', '0', '0', '0', '0', '1', '1510651398');
INSERT INTO `mss_admin_menu` VALUES ('176', '0', '157', 'admin', 'banner排序', 'aicon ai-shezhi', 'admin/banner/khsort', '', '_self', '0', '0', '0', '0', '1', '1510651398');
INSERT INTO `mss_admin_menu` VALUES ('177', '0', '131', 'admin', '分类添加', '', 'admin/index/classadd', '', '_self', '0', '0', '0', '0', '1', '1510717807');
INSERT INTO `mss_admin_menu` VALUES ('178', '0', '153', 'admin', '添加分类', '', 'admin/index/classadd', '', '_self', '0', '0', '0', '0', '1', '1510724492');
INSERT INTO `mss_admin_menu` VALUES ('180', '0', '7', 'admin', '会员排序', 'aicon ai-shezhi', 'admin/member/khsort', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('181', '0', '7', 'admin', '会员状态设置', 'aicon ai-shezhi', 'admin/member/khstatus', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('185', '0', '143', 'admin', '随机点击', '', 'admin/video/randclick', 'callback=rand', '_self', '0', '0', '1', '0', '1', '1510885657');
INSERT INTO `mss_admin_menu` VALUES ('186', '0', '164', 'admin', '资讯编辑', '', 'admin/novel/edit', '', '_self', '0', '0', '0', '0', '1', '1511168478');
INSERT INTO `mss_admin_menu` VALUES ('187', '0', '7', 'admin', '代理商状态设置', 'aicon ai-shezhi', 'admin/member/isAgent', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('188', '0', '7', 'admin', '代理商申请记录', 'aicon ai-shezhi', 'admin/member/agentApply', '', '_self', '0', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('189', '0', '164', 'admin', '资讯随机数', '', 'admin/novel/randclick', '', '_self', '0', '0', '0', '0', '1', '1511230058');
INSERT INTO `mss_admin_menu` VALUES ('190', '0', '161', 'admin', '图片随机点击', '', 'admin/image/randclick', '', '_self', '0', '0', '0', '0', '1', '1511249923');
INSERT INTO `mss_admin_menu` VALUES ('191', '0', '6', 'admin', '提成设置', 'aicon ai-shezhi', 'admin/system/commission', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('192', '0', '161', 'admin', '图集修改', '', 'admin/image/edit', '', '_self', '0', '0', '0', '0', '1', '1511258208');
INSERT INTO `mss_admin_menu` VALUES ('193', '0', '252', 'admin', '充值管理', 'fa fa-cny', 'admin/recharge', '', '_self', '5', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('194', '0', '193', 'admin', '充值记录', 'aicon ai-shezhi', 'admin/recharge/index', '', '_self', '0', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('195', '0', '193', 'admin', '充值套餐', 'aicon ai-shezhi', 'admin/recharge/package', '', '_self', '0', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('196', '0', '161', 'admin', '图片列表', '', 'admin/image/imagelists', '', '_self', '0', '0', '0', '0', '1', '1511321596');
INSERT INTO `mss_admin_menu` VALUES ('197', '0', '161', 'admin', '添加图片', '', 'admin/image/addimages', '', '_self', '0', '0', '0', '0', '1', '1511330347');
INSERT INTO `mss_admin_menu` VALUES ('199', '0', '193', 'admin', '充值排序', 'aicon ai-shezhi', 'admin/recharge/khsort', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('200', '0', '193', 'admin', '充值状态设置', 'aicon ai-shezhi', 'admin/recharge/status', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('201', '0', '193', 'admin', '添加套餐', 'aicon ai-shezhi', 'admin/recharge/addpackage', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('202', '0', '193', 'admin', '编辑充值套餐', 'aicon ai-shezhi', 'admin/recharge/editpackage', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('203', '0', '161', 'admin', '图片编辑', '', 'admin/image/imageedit', '', '_self', '0', '0', '0', '0', '1', '1511403917');
INSERT INTO `mss_admin_menu` VALUES ('204', '0', '193', 'admin', '删除充值套餐', 'aicon ai-shezhi', 'admin/recharge/del', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('205', '0', '252', 'admin', '打赏管理', 'fa fa-money', 'admin/gratuity', '', '_self', '5', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('206', '0', '205', 'admin', '打赏记录', 'aicon ai-shezhi', 'admin/gratuity/index', '', '_self', '0', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('207', '0', '205', 'admin', '礼物管理', 'aicon ai-shezhi', 'admin/gratuity/gift', '', '_self', '0', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('208', '0', '205', 'admin', '添加礼物', 'aicon ai-shezhi', 'admin/gratuity/addgift', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('209', '0', '2', 'admin', '前台菜单', 'fa fa-navicon', 'admin/menus', '', '_self', '0', '0', '1', '1', '1', '1511489496');
INSERT INTO `mss_admin_menu` VALUES ('210', '0', '209', 'admin', '添加菜单', '', 'admin/menus/add', '', '_self', '0', '0', '0', '1', '1', '1511489715');
INSERT INTO `mss_admin_menu` VALUES ('211', '0', '209', 'admin', '菜单管理', '', 'admin/menus/manager', '', '_self', '0', '0', '0', '1', '1', '1511489833');
INSERT INTO `mss_admin_menu` VALUES ('212', '0', '205', 'admin', '打赏删除', 'aicon ai-shezhi', 'admin/gratuity/del', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('213', '0', '205', 'admin', '打赏状态', 'aicon ai-shezhi', 'admin/gratuity/status', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('214', '0', '205', 'admin', '礼物编辑', 'aicon ai-shezhi', 'admin/gratuity/editgift', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('216', '0', '210', 'admin', '编辑菜单', '', 'admin/menus/edit', '', '_self', '0', '0', '0', '0', '1', '1511748074');
INSERT INTO `mss_admin_menu` VALUES ('217', '0', '131', 'admin', '视频批量修改', '', 'admin/video/batch_edit', '', '_self', '0', '0', '0', '1', '1', '1511767505');
INSERT INTO `mss_admin_menu` VALUES ('218', '0', '161', 'admin', '图片批量修改', '', 'admin/image/batch_edit', '', '_self', '0', '0', '0', '1', '1', '1511921093');
INSERT INTO `mss_admin_menu` VALUES ('219', '0', '164', 'admin', '资讯批量修改', '', 'admin/novel/batch_edit', '', '_self', '0', '0', '0', '1', '1', '1511921921');
INSERT INTO `mss_admin_menu` VALUES ('220', '0', '131', 'admin', '视频集', '', 'admin/video/video_gather', '', '_self', '0', '0', '1', '1', '1', '1511940474');
INSERT INTO `mss_admin_menu` VALUES ('221', '0', '220', 'admin', '创建视频集', '', 'admin/video/gather_upload', '', '_self', '0', '0', '1', '0', '1', '1511949839');
INSERT INTO `mss_admin_menu` VALUES ('222', '0', '220', 'admin', '视频集编辑', '', 'admin/video/gather_edit', '', '_self', '0', '0', '1', '0', '1', '1511951223');
INSERT INTO `mss_admin_menu` VALUES ('223', '0', '220', 'admin', '视频选取', '', 'admin/video/video_gather_lists', '', '_self', '0', '0', '1', '0', '1', '1512011804');
INSERT INTO `mss_admin_menu` VALUES ('225', '0', '252', 'admin', '评论管理', 'fa fa-commenting', 'admin/comment', '', '_self', '8', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('226', '0', '225', 'admin', '评论列表', 'aicon ai-shezhi', 'admin/comment/index', '', '_self', '0', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('227', '0', '225', 'admin', '评论删除', 'aicon ai-shezhi', 'admin/comment/khdel', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('228', '0', '225', 'admin', '评论状态', 'aicon ai-shezhi', 'admin/comment/status', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('229', '0', '6', 'admin', '邮件设置', 'aicon ai-shezhi', 'admin/system/email', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('230', '0', '252', 'admin', '消费记录', 'fa fa-bar-chart', 'admin/recharge', '', '_self', '0', '0', '0', '1', '1', '1514169385');
INSERT INTO `mss_admin_menu` VALUES ('231', '0', '230', 'admin', '视频消费', '', 'admin/recharge/consume', 'type=1', '_self', '0', '0', '1', '1', '1', '1514169674');
INSERT INTO `mss_admin_menu` VALUES ('232', '0', '230', 'admin', '图片消费', '', 'admin/recharge/consume', 'type=2', '_self', '0', '0', '1', '1', '1', '1514169752');
INSERT INTO `mss_admin_menu` VALUES ('233', '0', '230', 'admin', '资讯消费', '', 'admin/recharge/consume', 'type=3', '_self', '0', '0', '1', '1', '1', '1514169798');
INSERT INTO `mss_admin_menu` VALUES ('234', '0', '131', 'admin', '视频审核', 'aicon ai-shezhi', 'admin/video/videocheck', '', '_self', '0', '0', '1', '1', '1', '1514253693');
INSERT INTO `mss_admin_menu` VALUES ('235', '0', '131', 'admin', '审核', 'aicon ai-shezhi', 'admin/config/khcheck', '', '_self', '0', '0', '0', '0', '1', '1514259043');
INSERT INTO `mss_admin_menu` VALUES ('236', '0', '161', 'admin', '图册审核', '', 'admin/image/imgcheck', '', '_self', '0', '0', '1', '1', '1', '1514267229');
INSERT INTO `mss_admin_menu` VALUES ('237', '0', '164', 'admin', '资讯审核', '', 'admin/novel/novelcheck', '', '_self', '0', '0', '1', '1', '1', '1514269949');
INSERT INTO `mss_admin_menu` VALUES ('238', '0', '0', 'admin', '资源', 'aicon ai-shezhi', 'admin/', '', '_self', '0', '0', '1', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('239', '0', '2', 'admin', '广告设置', 'fa fa-file-image-o', 'admin/poster', '', '_self', '0', '0', '1', '1', '1', '1514448080');
INSERT INTO `mss_admin_menu` VALUES ('240', '0', '239', 'admin', '广告列表', '', 'admin/poster/lists', '', '_self', '0', '0', '1', '1', '1', '1514448150');
INSERT INTO `mss_admin_menu` VALUES ('241', '0', '243', 'admin', '支付方式列表', 'aicon ai-shezhi', 'admin/paySetting/paymentList', '', '_self', '1', '0', '1', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('243', '0', '6', 'admin', '支付设置', 'aicon ai-shezhi', 'admin/paySetting/index', '', '_self', '1', '0', '1', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('244', '0', '239', 'admin', '广告位管理', '', 'admin/poster/alimama', '', '_self', '0', '0', '1', '1', '1', '1514866102');
INSERT INTO `mss_admin_menu` VALUES ('245', '0', '243', 'admin', '支付方式配置参数', 'aicon ai-shezhi', 'admin/paySetting/setting', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('246', '0', '244', 'admin', '添加广告位', '', 'admin/poster/add', '', '_self', '0', '0', '0', '1', '1', '1514896329');
INSERT INTO `mss_admin_menu` VALUES ('247', '0', '240', 'admin', '广告添加', '', 'admin/poster/add_poster', '', '_self', '0', '0', '0', '0', '1', '1514949940');
INSERT INTO `mss_admin_menu` VALUES ('249', '0', '143', 'admin', '预览视频', 'aicon ai-shezhi', 'admin/video/play', '', '_self', '0', '0', '1', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('250', '0', '239', 'admin', '广告位编辑', '', 'admin/poster/edit', '', '_self', '0', '0', '0', '0', '1', '1516071330');
INSERT INTO `mss_admin_menu` VALUES ('251', '0', '239', 'admin', '广告编辑', '', 'admin/poster/edit_poster', '', '_self', '0', '0', '1', '0', '1', '1516073949');
INSERT INTO `mss_admin_menu` VALUES ('252', '0', '0', 'admin', '会员', 'aicon ai-shezhi', 'admin/member/index', '', '_self', '0', '0', '1', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('253', '0', '2', 'admin', '站群管理', 'fa fa-sitemap', 'admin/websitegroup', '', '_self', '0', '0', '1', '1', '1', '1516081658');
INSERT INTO `mss_admin_menu` VALUES ('255', '0', '253', 'admin', '站群列表', '', 'admin/websitegroup/netlist', '', '_self', '0', '0', '1', '1', '1', '1516082684');
INSERT INTO `mss_admin_menu` VALUES ('256', '0', '253', 'admin', '站群添加', '', 'admin/websitegroup/add_website', '', '_self', '0', '0', '1', '1', '1', '1516086077');
INSERT INTO `mss_admin_menu` VALUES ('257', '0', '253', 'admin', '站群编辑', '', 'admin/websitegroup/edit_website', '', '_self', '0', '0', '1', '0', '1', '1516089348');
INSERT INTO `mss_admin_menu` VALUES ('259', '0', '252', 'admin', '提现管理', 'fa fa-exchange', 'admin/websitegroup/del', '', '_self', '0', '0', '1', '1', '1', '1516173752');
INSERT INTO `mss_admin_menu` VALUES ('260', '0', '259', 'admin', '提现列表', '', 'admin/drawmoney/draw_money_list', '', '_self', '0', '0', '1', '1', '1', '1516177135');
INSERT INTO `mss_admin_menu` VALUES ('261', '0', '259', 'admin', '提现审核', '', 'admin/drawmoney/agreen', '', '_self', '0', '0', '1', '0', '1', '1516184025');
INSERT INTO `mss_admin_menu` VALUES ('262', '0', '131', 'admin', '视频状态修改', 'aicon ai-shezhi', 'admin/video/status', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('263', '0', '6', 'admin', '短信设置', 'aicon ai-shezhi', 'admin/system/sms', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('264', '0', '6', 'admin', '清前台缓存', '', 'admin/system/tools', '', '_self', '0', '0', '1', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('265', '0', '2', 'admin', '工具集', 'fa fa-gavel', '', '', '_self', '88', '0', '1', '0', '0', '0');
INSERT INTO `mss_admin_menu` VALUES ('266', '0', '6', 'admin', '视频自动入库', 'aicon ai-shezhi', 'admin/system/syncAddVideo', '', '_self', '50', '0', '1', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('279', '0', '131', 'admin', '删除视频标签', 'aicon ai-shezhi', 'admin/video/deletetag', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('280', '0', '161', 'admin', '删除图片标签', 'aicon ai-shezhi', 'admin/image/deletetag', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('281', '0', '164', 'admin', '删除资讯标签', 'aicon ai-shezhi', 'admin/novel/deletetag', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('282', '0', '131', 'admin', '删除视频分类', 'aicon ai-shezhi', 'admin/video/deleteClass', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('283', '0', '161', 'admin', '删除图片分类', 'aicon ai-shezhi', 'admin/image/deleteClass', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('284', '0', '164', 'admin', '删除资讯分类', 'aicon ai-shezhi', 'admin/novel/deleteClass', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('294', '0', '209', 'admin', '修改菜单状态', 'aicon ai-shezhi', 'admin/menus/status', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('295', '0', '209', 'admin', '修改菜单排序', 'aicon ai-shezhi', 'admin/menus/sort', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('296', '0', '209', 'admin', '删除菜单', 'aicon ai-shezhi', 'admin/menus/del', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('300', '0', '164', 'admin', '修改资讯状态', 'aicon ai-shezhi', 'admin/novel/status', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('301', '0', '164', 'admin', '删除资讯', 'aicon ai-shezhi', 'admin/novel/del', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('302', '0', '161', 'admin', '更改图册状态', 'aicon ai-shezhi', 'admin/image/status', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('303', '0', '161', 'admin', '删除相册', 'aicon ai-shezhi', 'admin/image/del', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('304', '0', '161', 'admin', '审核图册', 'aicon ai-shezhi', 'admin/image/check', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('305', '0', '131', 'admin', '审核视频', 'aicon ai-shezhi', 'admin/video/check', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('306', '0', '164', 'admin', '审核资讯', 'aicon ai-shezhi', 'admin/novel/check', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('307', '0', '161', 'admin', '修改图片状态', 'aicon ai-shezhi', 'admin/image/image_status', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('308', '0', '161', 'admin', '修改图片排序', 'aicon ai-shezhi', 'admin/image/image_sort', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('309', '0', '161', 'admin', '删除图片', 'aicon ai-shezhi', 'admin/image/image_del', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('310', '0', '239', 'admin', '删除广告', 'aicon ai-shezhi', 'admin/poster/del', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('311', '0', '239', 'admin', '更改广告状态', 'aicon ai-shezhi', 'admin/poster/status', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('312', '0', '239', 'admin', '删除广告位', 'aicon ai-shezhi', 'admin/poster/poster_del', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('313', '0', '243', 'admin', '更改支付方式状态', 'aicon ai-shezhi', 'admin/paySetting/status', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('314', '0', '252', 'admin', '卡密管理', 'aicon ai-shezhi', 'admin/cardPassword', '', '_self', '4', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('315', '0', '314', 'admin', '卡密列表', 'aicon ai-shezhi', 'admin/cardPassword/index', '', '_self', '2', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('316', '0', '314', 'admin', '添加卡密', 'aicon ai-shezhi', 'admin/cardPassword/add', '', '_self', '1', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('317', '0', '314', 'admin', '编辑卡密', 'aicon ai-shezhi', 'admin/cardPassword/edit', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('318', '0', '314', 'admin', '删除卡密', 'aicon ai-shezhi', 'admin/cardPassword/del', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('319', '0', '6', 'admin', '友情链接', 'aicon ai-shezhi', 'admin/system/friendlink', '', '_self', '60', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('320', '0', '314', 'admin', '导出卡密', 'aicon ai-shezhi', 'admin/cardpassword/export', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('321', '0', '2', 'admin', '公告设置', 'fa fa-book', 'admin/notice', '', '_self', '0', '0', '1', '1', '1', '1514448080');
INSERT INTO `mss_admin_menu` VALUES ('322', '0', '321', 'admin', '公告列表', '', 'admin/notice/index', '', '_self', '0', '0', '1', '1', '1', '1514448080');
INSERT INTO `mss_admin_menu` VALUES ('323', '0', '321', 'admin', '公告添加', '', 'admin/notice/add', '', '_self', '0', '0', '0', '0', '1', '1514448080');
INSERT INTO `mss_admin_menu` VALUES ('324', '0', '321', 'admin', '公告编辑', 'aicon ai-shezhi', 'admin/notice/edit', '', '_self', '0', '0', '0', '0', '1', '1514448080');
INSERT INTO `mss_admin_menu` VALUES ('325', '0', '321', 'admin', '更换状态', '', 'admin/notice/khstatus', '', '_self', '0', '0', '0', '0', '1', '1510625216');
INSERT INTO `mss_admin_menu` VALUES ('326', '0', '321', 'admin', '删除公告', '', 'admin/notice/del', '', '_self', '0', '0', '0', '0', '1', '1510625216');
INSERT INTO `mss_admin_menu` VALUES ('327', '0', '321', 'admin', '排序公告', 'aicon ai-shezhi', 'admin/notice/khsort', '', '_self', '0', '0', '0', '0', '1', '1510625216');
INSERT INTO `mss_admin_menu` VALUES ('328', '0', '193', 'admin', '金币套餐', 'aicon ai-shezhi', 'admin/recharge/goldpackage', '', '_self', '0', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('329', '0', '193', 'admin', '添加金币套餐', 'aicon ai-shezhi', 'admin/recharge/addgoldpackage', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('330', '0', '193', 'admin', '编辑金币套餐', 'aicon ai-shezhi', 'admin/recharge/editgoldpackage', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('331', '0', '7', 'admin', '代理商域名管理', 'aicon ai-shezhi', 'admin/member/domainname', '', '_self', '0', '0', '0', '1', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('332', '0', '6', 'admin', '采集管理', 'aicon ai-shezhi', 'admin/system/gather', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('333', '0', '253', 'admin', '删除站群', '', 'admin/websitegroup/del', '', '_self', '0', '0', '1', '0', '1', '1516082684');
INSERT INTO `mss_admin_menu` VALUES ('334', '0', '265', 'admin', '工具', '', 'admin/system/replaceResourceUrl', '', '_self', '0', '0', '0', '0', '1', '0');
INSERT INTO `mss_admin_menu` VALUES ('335', '0', '321', 'admin', '删除公告', '', 'admin/notice/khdel', '', '_self', '0', '0', '0', '0', '1', '1510625216');

-- -----------------------------
-- Table structure for `mss_admin_menu_copy1`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_menu_copy1`;
CREATE TABLE `mss_admin_menu_copy1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID(快捷菜单专用)',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `module` varchar(20) NOT NULL COMMENT '模块名或插件名，插件名格式:plugins.插件名',
  `title` varchar(20) NOT NULL COMMENT '菜单标题',
  `icon` varchar(80) NOT NULL DEFAULT 'aicon ai-shezhi' COMMENT '菜单图标',
  `url` varchar(200) NOT NULL COMMENT '链接地址(模块/控制器/方法)',
  `param` varchar(200) NOT NULL DEFAULT '' COMMENT '扩展参数',
  `target` varchar(20) NOT NULL DEFAULT '_self' COMMENT '打开方式(_blank,_self)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `debug` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开发模式可见',
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统菜单，系统菜单不可删除',
  `nav` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否为菜单显示，1显示0不显示',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态1显示，0隐藏',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 管理菜单';

-- -----------------------------
-- Records of `mss_admin_menu_copy1`
-- -----------------------------
INSERT INTO `mss_admin_menu_copy1` VALUES ('1', '0', '0', 'admin', '首页', '', 'admin/index', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('2', '0', '0', 'admin', '系统', '', 'admin/system', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('3', '0', '0', 'admin', '插件', 'aicon ai-shezhi', 'admin/plugins', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('4', '0', '1', 'admin', '快捷菜单', 'aicon ai-shezhi', 'admin/quick', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('5', '0', '3', 'admin', '插件列表', 'aicon ai-shezhi', 'admin/plugins', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('6', '0', '2', 'admin', '系统功能', 'aicon ai-shezhi', 'admin/system', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('7', '0', '2', 'admin', '会员管理', 'aicon ai-shezhi', 'admin/member', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('8', '0', '2', 'admin', '系统扩展', 'aicon ai-shezhi', 'admin/extend', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('9', '0', '2', 'admin', '开发专用', 'aicon ai-shezhi', 'admin/develop', '', '_self', '4', '1', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('10', '0', '6', 'admin', '系统设置', '', 'admin/system/index', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('11', '0', '6', 'admin', '配置管理', '', 'admin/config/index', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('12', '0', '6', 'admin', '系统菜单', '', 'admin/menu/index', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('13', '0', '6', 'admin', '管理员角色', '', 'admin/user/role', '', '_self', '4', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('14', '0', '6', 'admin', '系统管理员', '', 'admin/user/index', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('15', '0', '6', 'admin', '系统日志', '', 'admin/log/index', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('16', '0', '6', 'admin', '附件管理', '', 'admin/annex/index', '', '_self', '7', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('17', '0', '8', 'admin', '模块管理', '', 'admin/module/index', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('18', '0', '8', 'admin', '插件管理', '', 'admin/plugins/index', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('19', '0', '8', 'admin', '钩子管理', '', 'admin/hook/index', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('20', '0', '7', 'admin', '会员等级', '', 'admin/member/level', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('21', '0', '7', 'admin', '会员列表', '', 'admin/member/index', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('22', '0', '9', 'admin', '[示例]列表模板', '', 'admin/develop/lists', '', '_self', '1', '1', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('23', '0', '9', 'admin', '[示例]编辑模板', '', 'admin/develop/edit', '', '_self', '2', '1', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('24', '0', '4', 'admin', '后台首页', '', 'admin/index/index', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('25', '0', '4', 'admin', '清空缓存', '', 'admin/index/clear', '', '_self', '1', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('26', '0', '12', 'admin', '添加菜单', '', 'admin/menu/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('27', '0', '12', 'admin', '修改菜单', '', 'admin/menu/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('28', '0', '12', 'admin', '删除菜单', '', 'admin/menu/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('29', '0', '12', 'admin', '状态设置', '', 'admin/menu/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('30', '0', '12', 'admin', '排序设置', '', 'admin/menu/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('31', '0', '12', 'admin', '添加快捷菜单', '', 'admin/menu/quick', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('32', '0', '12', 'admin', '导出菜单', '', 'admin/menu/export', '', '_self', '7', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('33', '0', '13', 'admin', '添加角色', '', 'admin/user/addrole', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('34', '0', '13', 'admin', '修改角色', '', 'admin/user/editrole', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('35', '0', '13', 'admin', '删除角色', '', 'admin/user/delrole', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('36', '0', '13', 'admin', '状态设置', '', 'admin/user/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('37', '0', '14', 'admin', '添加管理员', '', 'admin/user/adduser', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('38', '0', '14', 'admin', '修改管理员', '', 'admin/user/edituser', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('39', '0', '14', 'admin', '删除管理员', '', 'admin/user/deluser', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('40', '0', '14', 'admin', '状态设置', '', 'admin/user/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('41', '0', '14', 'admin', '个人信息设置', '', 'admin/user/info', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('42', '0', '18', 'admin', '安装插件', '', 'admin/plugins/install', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('43', '0', '18', 'admin', '卸载插件', '', 'admin/plugins/uninstall', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('44', '0', '18', 'admin', '删除插件', '', 'admin/plugins/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('45', '0', '18', 'admin', '状态设置', '', 'admin/plugins/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('46', '0', '18', 'admin', '设计插件', '', 'admin/plugins/design', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('47', '0', '18', 'admin', '运行插件', '', 'admin/plugins/run', '', '_self', '6', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('48', '0', '18', 'admin', '更新插件', '', 'admin/plugins/update', '', '_self', '7', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('49', '0', '18', 'admin', '插件配置', '', 'admin/plugins/setting', '', '_self', '8', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('50', '0', '19', 'admin', '添加钩子', '', 'admin/hook/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('51', '0', '19', 'admin', '修改钩子', '', 'admin/hook/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('52', '0', '19', 'admin', '删除钩子', '', 'admin/hook/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('53', '0', '19', 'admin', '状态设置', '', 'admin/hook/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('54', '0', '19', 'admin', '插件排序', '', 'admin/hook/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('55', '0', '11', 'admin', '添加配置', '', 'admin/config/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('56', '0', '11', 'admin', '修改配置', '', 'admin/config/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('57', '0', '11', 'admin', '删除配置', '', 'admin/config/del', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('58', '0', '11', 'admin', '状态设置', '', 'admin/config/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('59', '0', '11', 'admin', '排序设置', '', 'admin/config/sort', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('60', '0', '10', 'admin', '基础配置', '', 'admin/system/index', 'group=base', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('61', '0', '10', 'admin', '系统配置', '', 'admin/system/index', 'group=sys', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('62', '0', '10', 'admin', '上传配置', '', 'admin/system/index', 'group=upload', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('63', '0', '10', 'admin', '开发配置', '', 'admin/system/index', 'group=develop', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('64', '0', '17', 'admin', '设计模块', '', 'admin/module/design', '', '_self', '6', '1', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('65', '0', '17', 'admin', '安装模块', '', 'admin/module/install', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('66', '0', '17', 'admin', '卸载模块', '', 'admin/module/uninstall', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('67', '0', '17', 'admin', '状态设置', '', 'admin/module/status', '', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('68', '0', '17', 'admin', '设置默认模块', '', 'admin/module/setdefault', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('69', '0', '17', 'admin', '删除模块', '', 'admin/module/del', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('70', '0', '21', 'admin', '添加会员', '', 'admin/member/add', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('71', '0', '21', 'admin', '修改会员', '', 'admin/member/edit', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('72', '0', '21', 'admin', '删除会员', '', 'admin/member/del', 'table=admin_member', '_self', '3', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('73', '0', '21', 'admin', '状态设置', '', 'admin/member/status', '', '_self', '4', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('74', '0', '21', 'admin', '[弹窗]会员选择', '', 'admin/member/pop', '', '_self', '5', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('75', '0', '20', 'admin', '添加会员等级', '', 'admin/member/addlevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('76', '0', '20', 'admin', '修改会员等级', '', 'admin/member/editlevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('77', '0', '20', 'admin', '删除会员等级', '', 'admin/member/dellevel', '', '_self', '0', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('78', '0', '16', 'admin', '附件上传', '', 'admin/annex/upload', '', '_self', '1', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('79', '0', '16', 'admin', '删除附件', '', 'admin/annex/del', '', '_self', '2', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('80', '0', '8', 'admin', '在线升级', '', 'admin/upgrade/index', '', '_self', '4', '0', '1', '1', '1', '1491352728');
INSERT INTO `mss_admin_menu_copy1` VALUES ('81', '0', '80', 'admin', '获取升级列表', '', 'admin/upgrade/lists', '', '_self', '0', '0', '1', '1', '1', '1491353504');
INSERT INTO `mss_admin_menu_copy1` VALUES ('82', '0', '80', 'admin', '安装升级包', '', 'admin/upgrade/install', '', '_self', '0', '0', '1', '1', '1', '1491353568');
INSERT INTO `mss_admin_menu_copy1` VALUES ('83', '0', '80', 'admin', '下载升级包', '', 'admin/upgrade/download', '', '_self', '0', '0', '1', '1', '1', '1491395830');
INSERT INTO `mss_admin_menu_copy1` VALUES ('84', '0', '6', 'admin', '数据库管理', '', 'admin/database/index', '', '_self', '8', '0', '1', '1', '1', '1491461136');
INSERT INTO `mss_admin_menu_copy1` VALUES ('85', '0', '84', 'admin', '备份数据库', '', 'admin/database/export', '', '_self', '0', '0', '1', '1', '1', '1491461250');
INSERT INTO `mss_admin_menu_copy1` VALUES ('86', '0', '84', 'admin', '恢复数据库', '', 'admin/database/import', '', '_self', '0', '0', '1', '1', '1', '1491461315');
INSERT INTO `mss_admin_menu_copy1` VALUES ('87', '0', '84', 'admin', '优化数据库', '', 'admin/database/optimize', '', '_self', '0', '0', '1', '1', '1', '1491467000');
INSERT INTO `mss_admin_menu_copy1` VALUES ('88', '0', '84', 'admin', '删除备份', '', 'admin/database/del', '', '_self', '0', '0', '1', '1', '1', '1491467058');
INSERT INTO `mss_admin_menu_copy1` VALUES ('89', '0', '84', 'admin', '修复数据库', '', 'admin/database/repair', '', '_self', '0', '0', '1', '1', '1', '1491880879');
INSERT INTO `mss_admin_menu_copy1` VALUES ('90', '0', '21', 'admin', '设置默认等级', '', 'admin/member/setdefault', '', '_self', '0', '0', '1', '1', '1', '1491966585');
INSERT INTO `mss_admin_menu_copy1` VALUES ('91', '0', '10', 'admin', '数据库配置', '', 'admin/system/index', 'group=databases', '_self', '5', '0', '1', '1', '1', '1492072213');
INSERT INTO `mss_admin_menu_copy1` VALUES ('92', '0', '17', 'admin', '模块打包', '', 'admin/module/package', '', '_self', '7', '0', '1', '1', '1', '1492134693');
INSERT INTO `mss_admin_menu_copy1` VALUES ('93', '0', '18', 'admin', '插件打包', '', 'admin/plugins/package', '', '_self', '0', '0', '1', '1', '1', '1492134743');
INSERT INTO `mss_admin_menu_copy1` VALUES ('94', '0', '17', 'admin', '主题管理', '', 'admin/module/theme', '', '_self', '8', '0', '1', '1', '1', '1492433470');
INSERT INTO `mss_admin_menu_copy1` VALUES ('95', '0', '17', 'admin', '设置默认主题', '', 'admin/module/setdefaulttheme', '', '_self', '9', '0', '1', '1', '1', '1492433618');
INSERT INTO `mss_admin_menu_copy1` VALUES ('96', '0', '17', 'admin', '删除主题', '', 'admin/module/deltheme', '', '_self', '10', '0', '1', '1', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('97', '0', '6', 'admin', '语言包管理', '', 'admin/language/index', '', '_self', '11', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('98', '0', '97', 'admin', '添加语言包', '', 'admin/language/add', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('99', '0', '97', 'admin', '修改语言包', '', 'admin/language/edit', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('100', '0', '97', 'admin', '删除语言包', '', 'admin/language/del', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('101', '0', '97', 'admin', '排序设置', '', 'admin/language/sort', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('102', '0', '97', 'admin', '状态设置', '', 'admin/language/status', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('103', '0', '16', 'admin', '收藏夹图标上传', '', 'admin/annex/favicon', '', '_self', '3', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('104', '0', '17', 'admin', '导入模块', '', 'admin/module/import', '', '_self', '11', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('105', '0', '4', 'admin', '欢迎页面', '', 'admin/index/welcome', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('106', '0', '4', 'admin', '布局切换', '', 'admin/user/iframe', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('107', '0', '15', 'admin', '删除日志', '', 'admin/log/del', 'table=admin_log', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('108', '0', '15', 'admin', '清空日志', '', 'admin/log/clear', '', '_self', '100', '0', '1', '0', '1', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('109', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('110', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('111', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('112', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('113', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('114', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('115', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('116', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('117', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('118', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('119', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('120', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('121', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('122', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('123', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('124', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('125', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('126', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('127', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('128', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('129', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('130', '0', '4', 'admin', '预留占位', '', '', '', '_self', '100', '0', '1', '1', '0', '1490315067');
INSERT INTO `mss_admin_menu_copy1` VALUES ('131', '0', '1', 'admin', '视频管理', 'aicon ai-shezhi', 'admin/video', '', '_self', '0', '0', '0', '1', '1', '1510110844');
INSERT INTO `mss_admin_menu_copy1` VALUES ('132', '0', '131', 'admin', '视频上传', 'aicon ai-tuichu', 'admin/video/upload', '', '_self', '0', '0', '0', '1', '1', '1510110945');
INSERT INTO `mss_admin_menu_copy1` VALUES ('133', '0', '6', 'admin', '数据库配置', 'aicon ai-shezhi', 'admin/dbconfig/index', '', '_self', '2', '0', '0', '1', '1', '1510133228');
INSERT INTO `mss_admin_menu_copy1` VALUES ('134', '0', '4', 'admin', '标签管理', 'fa fa-tags', 'admin/index/taglist', 't=list', '_self', '0', '0', '1', '1', '1', '1510193325');
INSERT INTO `mss_admin_menu_copy1` VALUES ('136', '0', '134', 'admin', '排序配置', '', 'admin/index/khsort', '', '_self', '0', '0', '1', '1', '1', '1510208623');
INSERT INTO `mss_admin_menu_copy1` VALUES ('137', '0', '134', 'admin', '状态开关', '', 'admin/index/khstatus', '', '_self', '0', '0', '1', '1', '1', '1510209960');
INSERT INTO `mss_admin_menu_copy1` VALUES ('138', '1', '4', 'admin', '后台首页', '', 'admin/index/index', '', '_self', '100', '0', '0', '0', '1', '1510210445');
INSERT INTO `mss_admin_menu_copy1` VALUES ('139', '0', '134', 'admin', '删除标签', '', 'admin/index/khdel', '', '_self', '0', '0', '1', '1', '1', '1510210570');

-- -----------------------------
-- Table structure for `mss_admin_menu_lang`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_menu_lang`;
CREATE TABLE `mss_admin_menu_lang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(120) NOT NULL DEFAULT '' COMMENT '标题',
  `lang` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '语言包',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- -----------------------------
-- Records of `mss_admin_menu_lang`
-- -----------------------------
INSERT INTO `mss_admin_menu_lang` VALUES ('131', '1', '首页', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('132', '2', '系统', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('133', '3', '插件', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('134', '4', '快捷菜单', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('135', '5', '插件列表', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('136', '6', '系统功能', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('137', '7', '会员管理', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('138', '8', '系统扩展', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('139', '9', '开发专用', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('140', '10', '系统设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('141', '11', '配置管理', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('142', '12', '系统菜单', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('143', '13', '管理员角色', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('144', '14', '系统管理员', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('145', '15', '系统日志', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('146', '16', '附件管理', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('147', '17', '模块管理', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('148', '18', '插件管理', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('149', '19', '钩子管理', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('150', '20', '会员等级', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('151', '21', '会员列表', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('152', '22', '[示例]列表模板', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('153', '23', '[示例]编辑模板', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('154', '24', '后台首页', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('155', '25', '清空缓存', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('156', '26', '添加菜单', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('157', '27', '修改菜单', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('158', '28', '删除菜单', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('159', '29', '状态设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('160', '30', '排序设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('161', '31', '添加快捷菜单', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('162', '32', '导出菜单', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('163', '33', '添加角色', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('164', '34', '修改角色', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('165', '35', '删除角色', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('166', '36', '状态设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('167', '37', '添加管理员', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('168', '38', '修改管理员', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('169', '39', '删除管理员', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('170', '40', '状态设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('171', '41', '个人信息设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('172', '42', '安装插件', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('173', '43', '卸载插件', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('174', '44', '删除插件', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('175', '45', '状态设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('176', '46', '设计插件', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('177', '47', '运行插件', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('178', '48', '更新插件', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('179', '49', '插件配置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('180', '50', '添加钩子', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('181', '51', '修改钩子', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('182', '52', '删除钩子', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('183', '53', '状态设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('184', '54', '插件排序', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('185', '55', '添加配置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('186', '56', '修改配置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('187', '57', '删除配置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('188', '58', '状态设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('189', '59', '排序设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('190', '60', '基础配置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('191', '61', '系统配置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('192', '62', '上传配置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('193', '63', '开发配置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('194', '64', '设计模块', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('195', '65', '安装模块', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('196', '66', '卸载模块', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('197', '67', '状态设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('198', '68', '设置默认模块', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('199', '69', '删除模块', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('200', '70', '添加会员', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('201', '71', '修改会员', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('202', '72', '删除会员', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('203', '73', '状态设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('204', '74', '[弹窗]会员选择', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('205', '75', '添加会员等级', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('206', '76', '修改会员等级', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('207', '77', '删除会员等级', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('208', '78', '附件上传', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('209', '79', '删除附件', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('210', '80', '在线升级', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('211', '81', '获取升级列表', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('212', '82', '安装升级包', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('213', '83', '下载升级包', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('214', '84', '数据库管理', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('215', '85', '备份数据库', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('216', '86', '恢复数据库', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('217', '87', '优化数据库', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('218', '88', '删除备份', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('219', '89', '修复数据库', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('220', '90', '设置默认等级', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('221', '91', '数据库配置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('222', '92', '模块打包', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('223', '93', '插件打包', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('224', '94', '主题管理', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('225', '95', '设置默认主题', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('226', '96', '删除主题', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('227', '97', '语言包管理', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('228', '98', '添加语言包', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('229', '99', '修改语言包', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('230', '100', '删除语言包', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('231', '101', '排序设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('232', '102', '状态设置', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('233', '103', '收藏夹图标上传', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('234', '104', '导入模块', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('235', '105', '欢迎页面', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('236', '106', '布局切换', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('237', '107', '删除日志', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('238', '108', '清空日志', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('239', '109', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('240', '110', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('241', '111', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('242', '112', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('243', '113', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('244', '114', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('245', '115', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('246', '116', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('247', '117', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('248', '118', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('249', '119', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('250', '120', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('251', '121', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('252', '122', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('253', '123', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('254', '124', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('255', '125', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('256', '126', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('257', '127', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('258', '128', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('259', '129', '预留占位', '1');
INSERT INTO `mss_admin_menu_lang` VALUES ('260', '130', '预留占位', '1');

-- -----------------------------
-- Table structure for `mss_admin_module`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_module`;
CREATE TABLE `mss_admin_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '系统模块',
  `name` varchar(50) NOT NULL COMMENT '模块名(英文)',
  `identifier` varchar(100) NOT NULL COMMENT '模块标识(模块名(字母).开发者标识.module)',
  `title` varchar(50) NOT NULL COMMENT '模块标题',
  `intro` varchar(255) NOT NULL COMMENT '模块简介',
  `author` varchar(100) NOT NULL COMMENT '作者',
  `icon` varchar(80) NOT NULL DEFAULT 'aicon ai-mokuaiguanli' COMMENT '图标',
  `version` varchar(20) NOT NULL COMMENT '版本号',
  `url` varchar(255) NOT NULL COMMENT '链接',
  `sort` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未安装，1未启用，2已启用',
  `default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '默认模块(只能有一个)',
  `config` text NOT NULL COMMENT '配置',
  `app_id` varchar(30) NOT NULL DEFAULT '0' COMMENT '应用市场ID(0本地)',
  `theme` varchar(50) NOT NULL DEFAULT 'default' COMMENT '主题模板',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE,
  UNIQUE KEY `identifier` (`identifier`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 模块';

-- -----------------------------
-- Records of `mss_admin_module`
-- -----------------------------
INSERT INTO `mss_admin_module` VALUES ('1', '1', 'admin', 'admin.hisiphp.module', '系统管理模块', '系统核心模块，用于后台各项管理功能模块及功能拓展', 'HisiPHP官方出品', '', '1.0.0', 'http://www.hisiphp.com', '0', '2', '0', '', '0', 'default', '1489998096', '1489998096');
INSERT INTO `mss_admin_module` VALUES ('2', '1', 'index', 'index.hisiphp.module', '系统默认模块', '仅供前端插件访问和应用市场推送安装，禁止在此模块下面开发任何东西。', 'HisiPHP官方出品', '', '1.0.0', 'http://www.hisiphp.com', '0', '2', '0', '', '0', 'default', '1489998096', '1489998096');
INSERT INTO `mss_admin_module` VALUES ('3', '1', 'install', 'install.hisiphp.module', '系统安装模块', '系统安装模块，勿动。', 'HisiPHP官方出品', '', '1.0.0', 'http://www.hisiphp.com', '0', '2', '0', '', '0', 'default', '1489998096', '1489998096');

-- -----------------------------
-- Table structure for `mss_admin_plugins`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_plugins`;
CREATE TABLE `mss_admin_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL COMMENT '插件名称(英文)',
  `title` varchar(32) NOT NULL COMMENT '插件标题',
  `icon` varchar(64) NOT NULL COMMENT '图标',
  `intro` text NOT NULL COMMENT '插件简介',
  `author` varchar(32) NOT NULL COMMENT '作者',
  `url` varchar(255) NOT NULL COMMENT '作者主页',
  `version` varchar(16) NOT NULL DEFAULT '' COMMENT '版本号',
  `identifier` varchar(64) NOT NULL DEFAULT '' COMMENT '插件唯一标识符',
  `config` text NOT NULL COMMENT '插件配置',
  `app_id` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '来源(0本地)',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 插件表';


-- -----------------------------
-- Table structure for `mss_admin_role`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_role`;
CREATE TABLE `mss_admin_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '角色名称',
  `intro` varchar(200) NOT NULL COMMENT '角色简介',
  `auth` text NOT NULL COMMENT '角色权限',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 管理角色';

-- -----------------------------
-- Records of `mss_admin_role`
-- -----------------------------
INSERT INTO `mss_admin_role` VALUES ('1', '超级管理员', '拥有系统最高权限', '0', '1489411760', '0', '1');
INSERT INTO `mss_admin_role` VALUES ('2', '系统管理员', '拥有系统管理员权限', '[\"1\",\"4\",\"25\",\"24\",\"2\",\"6\",\"10\",\"60\",\"61\",\"62\",\"63\",\"91\",\"11\",\"55\",\"56\",\"57\",\"58\",\"59\",\"12\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"13\",\"33\",\"34\",\"35\",\"36\",\"14\",\"37\",\"38\",\"39\",\"40\",\"41\",\"16\",\"78\",\"79\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"7\",\"20\",\"75\",\"76\",\"77\",\"21\",\"90\",\"70\",\"71\",\"72\",\"73\",\"74\",\"8\",\"17\",\"65\",\"66\",\"67\",\"68\",\"94\",\"95\",\"18\",\"42\",\"43\",\"45\",\"47\",\"48\",\"49\",\"19\",\"80\",\"81\",\"82\",\"83\",\"9\",\"22\",\"23\",\"3\",\"5\"]', '1489411760', '0', '1');
INSERT INTO `mss_admin_role` VALUES ('3', '什么都用不了', 'test', '[\"1\",\"4\",\"25\",\"24\",\"2\",\"6\",\"10\",\"60\",\"61\",\"62\",\"63\",\"91\",\"11\",\"55\",\"56\",\"57\",\"58\",\"59\",\"12\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"13\",\"33\",\"34\",\"35\",\"36\",\"14\",\"37\",\"38\",\"39\",\"40\",\"41\",\"16\",\"78\",\"79\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"7\",\"20\",\"75\",\"76\",\"77\",\"21\",\"90\",\"70\",\"71\",\"72\",\"73\",\"74\",\"8\",\"17\",\"65\",\"66\",\"67\",\"68\",\"94\",\"95\",\"18\",\"42\",\"43\",\"45\",\"47\",\"48\",\"49\",\"19\",\"80\",\"81\",\"82\",\"83\",\"9\",\"22\",\"23\",\"3\",\"5\"]', '1489411760', '0', '1');

-- -----------------------------
-- Table structure for `mss_admin_user`
-- -----------------------------
DROP TABLE IF EXISTS `mss_admin_user`;
CREATE TABLE `mss_admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `version` int(10) unsigned NOT NULL DEFAULT '3' COMMENT '版本信息，1尊享版，2高级版，3基础版',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL,
  `nick` varchar(50) NOT NULL DEFAULT '超级管理员' COMMENT '昵称',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `price` float(11,2) NOT NULL COMMENT '权限',
  `remarks` text NOT NULL COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `last_login_ip` varchar(128) NOT NULL COMMENT '最后登陆IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `db_config` text COMMENT '数据库配置',
  `role_id` int(10) NOT NULL DEFAULT '1' COMMENT '角色ID',
  `iframe` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0默认，1框架',
  `auth` text NOT NULL COMMENT '权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 管理用户';

-- -----------------------------
-- Records of `mss_admin_user`
-- -----------------------------
INSERT INTO `mss_admin_user` VALUES ('2', '1', 'admin', '$2y$10$XgbZcby0Yp7rTqutwPF1te.o5kegX.rZyd9VUSLI6wC81IY.DSbWy', '超级管理员', '13200000000', '0@0.com', '0', 'asdasd', '1', '14.213.133.196', '1556036422', '1510054078', '1556036422', '{\"type\":\"mysql\",\"hostname\":\"127.0.0.1\",\"database\":\"msvodx_ym\",\"username\":\"msvodx_ym\",\"password\":\"aTYWxjczzzrPpm8X\",\"hostport\":\"3306\",\"charset\":\"utf8\",\"prefix\":\"ms_\"}', '1', '1', '');

-- -----------------------------
-- Table structure for `mss_card_password`
-- -----------------------------
DROP TABLE IF EXISTS `mss_card_password`;
CREATE TABLE `mss_card_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` varchar(32) DEFAULT NULL COMMENT '卡号',
  `card_type` int(1) DEFAULT NULL COMMENT '卡类型1为vip卡，2为金币卡',
  `out_time` int(11) DEFAULT NULL COMMENT '过期时间',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `status` int(1) DEFAULT '0' COMMENT '状态，0未使用，1已使用',
  `price` int(11) DEFAULT NULL COMMENT '价格金额',
  `gold` int(11) DEFAULT '0' COMMENT '金币数',
  `vip_time` int(11) DEFAULT '0' COMMENT '会员时间，当为永久会员的时候为999999999',
  `use_time` int(11) DEFAULT NULL COMMENT '充值卡使用时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


-- -----------------------------
-- Table structure for `mss_domain_cname_binding`
-- -----------------------------
DROP TABLE IF EXISTS `mss_domain_cname_binding`;
CREATE TABLE `mss_domain_cname_binding` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '会员id',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `webhost` varchar(255) DEFAULT NULL COMMENT '域名地址',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态0为未处理，1为已通过，2为已拒绝',
  `last_time` int(11) DEFAULT NULL COMMENT '最后修改的时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='域名绑定表';


-- -----------------------------
-- Table structure for `mss_gold_package`
-- -----------------------------
DROP TABLE IF EXISTS `mss_gold_package`;
CREATE TABLE `mss_gold_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '套餐名称',
  `price` double(10,2) DEFAULT NULL COMMENT '价格',
  `gold` int(11) DEFAULT NULL COMMENT '金币个数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


-- -----------------------------
-- Table structure for `mss_login_setting`
-- -----------------------------
DROP TABLE IF EXISTS `mss_login_setting`;
CREATE TABLE `mss_login_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_code` varchar(50) NOT NULL COMMENT '登录方式的code',
  `login_name` varchar(255) NOT NULL COMMENT '登录名称',
  `config` text COMMENT '登录方式配置信息',
  `status` int(1) DEFAULT '1' COMMENT '是否开户，1：开启，0：关闭',
  `add_time` int(10) DEFAULT NULL COMMENT '安装时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='支付配置表';

-- -----------------------------
-- Records of `mss_login_setting`
-- -----------------------------
INSERT INTO `mss_login_setting` VALUES ('1', 'qq', 'QQ登录', '[{\"name\":\"APPID\",\"type\":\"text\",\"value\":\"01459043\",\"desc\":\"APPID\"},{\"name\":\"APPKey\",\"type\":\"text\",\"value\":\"e4f10c0c0404bf61de486cf1ec717be\",\"desc\":\"APPKey\"}]', '0', '1514888879', '1519263473');
INSERT INTO `mss_login_setting` VALUES ('2', 'wechat', '微信登录', '[{\"name\":\"APPID\",\"type\":\"text\",\"value\":\"asdada\",\"desc\":\"APPID\"},{\"name\":\"APPKey\",\"type\":\"text\",\"value\":\"23242342\",\"desc\":\"APPKey\"}]', '0', '1514888906', '1515029281');

-- -----------------------------
-- Table structure for `mss_notice`
-- -----------------------------
DROP TABLE IF EXISTS `mss_notice`;
CREATE TABLE `mss_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text COMMENT '内容',
  `out_time` bigint(20) DEFAULT NULL COMMENT '过期时间',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  `sort` tinyint(1) DEFAULT NULL COMMENT '排序',
  `type` tinyint(1) DEFAULT NULL COMMENT '内容展示方式1为弹出层，2为页面转跳',
  `url` varchar(255) DEFAULT NULL COMMENT '转跳网址',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


-- -----------------------------
-- Table structure for `mss_version_role`
-- -----------------------------
DROP TABLE IF EXISTS `mss_version_role`;
CREATE TABLE `mss_version_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '角色名称',
  `intro` varchar(200) NOT NULL COMMENT '角色简介',
  `auth` text NOT NULL COMMENT '角色权限',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='[系统] 版本管理表';

-- -----------------------------
-- Records of `mss_version_role`
-- -----------------------------
INSERT INTO `mss_version_role` VALUES ('1', '开源版', '价格：3888', '[\"10\",\"60\",\"61\",\"62\",\"63\",\"91\",\"14\",\"41\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"133\",\"140\",\"142\",\"191\",\"229\",\"243\",\"241\",\"245\",\"313\",\"263\",\"266\",\"319\",\"28\",\"31\",\"136\",\"137\",\"139\",\"158\",\"169\",\"171\",\"174\",\"176\",\"206\",\"207\",\"208\",\"212\",\"213\",\"214\",\"210\",\"216\",\"211\",\"294\",\"295\",\"296\",\"240\",\"247\",\"244\",\"246\",\"250\",\"251\",\"310\",\"311\",\"312\",\"255\",\"256\",\"257\",\"264\",\"132\",\"143\",\"185\",\"249\",\"149\",\"152\",\"153\",\"175\",\"178\",\"156\",\"167\",\"177\",\"217\",\"220\",\"221\",\"222\",\"223\",\"234\",\"235\",\"262\",\"279\",\"282\",\"305\",\"148\",\"154\",\"162\",\"163\",\"190\",\"192\",\"196\",\"197\",\"203\",\"218\",\"236\",\"280\",\"283\",\"302\",\"303\",\"304\",\"307\",\"308\",\"309\",\"151\",\"155\",\"165\",\"166\",\"170\",\"186\",\"189\",\"219\",\"237\",\"281\",\"284\",\"300\",\"301\",\"306\",\"315\",\"316\",\"317\",\"318\",\"320\",\"20\",\"75\",\"76\",\"77\",\"21\",\"70\",\"71\",\"72\",\"73\",\"74\",\"90\",\"180\",\"181\",\"187\",\"188\",\"194\",\"195\",\"199\",\"200\",\"201\",\"202\",\"204\",\"226\",\"227\",\"228\",\"231\",\"232\",\"233\",\"260\",\"261\"]', '1489411760', '0', '1');
INSERT INTO `mss_version_role` VALUES ('2', '旗舰版', '价格：388', '[\"10\",\"60\",\"61\",\"62\",\"63\",\"91\",\"14\",\"41\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"133\",\"140\",\"142\",\"191\",\"229\",\"243\",\"241\",\"245\",\"313\",\"263\",\"319\",\"28\",\"31\",\"136\",\"137\",\"139\",\"158\",\"169\",\"171\",\"174\",\"176\",\"210\",\"216\",\"211\",\"294\",\"295\",\"296\",\"240\",\"247\",\"244\",\"246\",\"250\",\"251\",\"310\",\"311\",\"312\",\"255\",\"256\",\"257\",\"264\",\"132\",\"143\",\"185\",\"249\",\"149\",\"152\",\"153\",\"175\",\"178\",\"156\",\"167\",\"177\",\"217\",\"220\",\"221\",\"222\",\"223\",\"234\",\"235\",\"262\",\"279\",\"282\",\"305\",\"148\",\"154\",\"162\",\"163\",\"190\",\"192\",\"196\",\"197\",\"203\",\"218\",\"236\",\"280\",\"283\",\"302\",\"303\",\"304\",\"307\",\"308\",\"309\",\"151\",\"155\",\"165\",\"166\",\"170\",\"186\",\"189\",\"219\",\"237\",\"281\",\"284\",\"300\",\"301\",\"306\",\"315\",\"316\",\"317\",\"318\",\"20\",\"75\",\"76\",\"77\",\"21\",\"70\",\"71\",\"72\",\"73\",\"74\",\"90\",\"180\",\"181\",\"194\",\"195\",\"199\",\"200\",\"201\",\"202\",\"204\",\"226\",\"227\",\"228\",\"231\",\"232\",\"233\",\"260\",\"261\"]', '1489411760', '0', '1');
INSERT INTO `mss_version_role` VALUES ('4', '专享版', '价格 : 188', '[\"10\",\"60\",\"61\",\"62\",\"63\",\"91\",\"14\",\"41\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"133\",\"140\",\"142\",\"191\",\"229\",\"243\",\"241\",\"245\",\"313\",\"263\",\"319\",\"28\",\"31\",\"136\",\"137\",\"139\",\"158\",\"169\",\"171\",\"174\",\"176\",\"210\",\"216\",\"211\",\"294\",\"295\",\"296\",\"240\",\"247\",\"244\",\"246\",\"250\",\"251\",\"310\",\"311\",\"312\",\"264\",\"132\",\"143\",\"185\",\"249\",\"149\",\"152\",\"153\",\"175\",\"178\",\"156\",\"167\",\"177\",\"217\",\"220\",\"221\",\"222\",\"223\",\"234\",\"235\",\"262\",\"279\",\"282\",\"305\",\"148\",\"154\",\"162\",\"163\",\"190\",\"192\",\"196\",\"197\",\"203\",\"218\",\"236\",\"280\",\"283\",\"302\",\"303\",\"304\",\"307\",\"308\",\"309\",\"151\",\"155\",\"165\",\"166\",\"170\",\"186\",\"189\",\"219\",\"237\",\"281\",\"284\",\"300\",\"301\",\"306\",\"20\",\"75\",\"76\",\"77\",\"21\",\"70\",\"71\",\"72\",\"73\",\"74\",\"90\",\"180\",\"181\",\"226\",\"227\",\"228\",\"231\",\"232\",\"233\"]', '1489411760', '0', '1');
INSERT INTO `mss_version_role` VALUES ('5', '测试版本', '价格 : 88', '[\"10\",\"60\",\"61\",\"62\",\"63\",\"91\",\"14\",\"41\",\"84\",\"85\",\"86\",\"87\",\"89\",\"133\",\"140\",\"142\",\"191\",\"229\",\"243\",\"241\",\"245\",\"263\",\"266\",\"319\",\"31\",\"136\",\"137\",\"158\",\"169\",\"174\",\"176\",\"206\",\"207\",\"208\",\"213\",\"214\",\"210\",\"216\",\"211\",\"240\",\"247\",\"244\",\"246\",\"255\",\"256\",\"257\",\"264\",\"132\",\"143\",\"185\",\"249\",\"149\",\"152\",\"153\",\"156\",\"217\",\"220\",\"221\",\"222\",\"223\",\"234\",\"235\",\"262\",\"148\",\"154\",\"162\",\"163\",\"190\",\"192\",\"196\",\"197\",\"203\",\"218\",\"236\",\"151\",\"155\",\"165\",\"166\",\"170\",\"186\",\"189\",\"219\",\"237\",\"315\",\"316\",\"317\",\"318\",\"20\",\"75\",\"76\",\"21\",\"70\",\"71\",\"73\",\"74\",\"90\",\"180\",\"187\",\"188\",\"194\",\"195\",\"199\",\"200\",\"201\",\"226\",\"228\",\"231\",\"232\",\"233\",\"260\",\"261\"]', '1516777434', '0', '1');

-- -----------------------------
-- Table structure for `mss_video`
-- -----------------------------
DROP TABLE IF EXISTS `mss_video`;
CREATE TABLE `mss_video` (
  `id` int(11) NOT NULL COMMENT 'id',
  `title` varchar(255) NOT NULL COMMENT '视频标题',
  `info` text COMMENT '说明',
  `short_info` varchar(90) DEFAULT NULL COMMENT '短说明',
  `key_word` text COMMENT '关键词',
  `url` varchar(255) DEFAULT NULL COMMENT '视频播放地址',
  `download_url` varchar(255) DEFAULT NULL COMMENT '下载地址',
  `add_time` int(10) NOT NULL COMMENT '上传时间',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `pay_time` int(10) DEFAULT NULL COMMENT '视频时长',
  `click` int(11) DEFAULT '0' COMMENT '总点击量',
  `good` int(11) DEFAULT '0' COMMENT '总点赞数',
  `thumbnail` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `user_id` int(11) DEFAULT NULL COMMENT '上传者id',
  `class` text COMMENT '所属分类',
  `tag` text COMMENT '所属标签',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态1为显示，0为隐藏',
  `pid` int(11) DEFAULT NULL COMMENT '当是分集的时候存在该字段',
  `diversity_data` text COMMENT '分集详情',
  `gold` int(11) DEFAULT NULL COMMENT '观看需要金币',
  `hint` varchar(255) DEFAULT NULL COMMENT '驳回原因',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

