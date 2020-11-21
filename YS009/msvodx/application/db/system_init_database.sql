/*
 Date: 09/04/2018 16:48:31
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ms_admin_config
-- ----------------------------
DROP TABLE IF EXISTS `ms_admin_config`;
CREATE TABLE `ms_admin_config`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'base' COMMENT '分组',
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置标题',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置名称，由英文字母和下划线组成',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置值',
  `remarks` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 96 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '[系统] 系统配置' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ms_admin_config
-- ----------------------------
INSERT INTO `ms_admin_config` VALUES (1, 'base', '网站logo', 'site_logo', 'https://vodx.oss-cn-shenzhen.aliyuncs.com/20180307/4WDddTtMKGpt45QCxrQmKMKtZQMsK7J5.png', '网站LOGO图片');
INSERT INTO `ms_admin_config` VALUES (2, 'base', '网站图标', 'site_favicon', 'http://client.meisicms.com/favicon.ico', '网站收藏夹图标，它显示位于浏览器的地址栏或者标题前面');
INSERT INTO `ms_admin_config` VALUES (3, 'base', '网站标题', 'site_title', '视频点播系统专家', '');
INSERT INTO `ms_admin_config` VALUES (4, 'base', '网站关键词', 'site_keywords', '视频系统,视频系统软件源码,视频程序,视频app开发,网络视频系统,嵌入式视频app开发 互联网创新模式,互联网技术服务解决方案', '网站标题是体现一个网站的主旨，要做到主题突出、标题简洁、连贯等特点，建议不超过28个字');
INSERT INTO `ms_admin_config` VALUES (5, 'base', '网站描述', 'site_description', '魅思是国内领先视频系统开发商,国内领先的视频系统程序软件开发、视频源码出售,核心视频系统技术,适用美女秀场视频、电商视频、教育视频、金融视频、游戏等多行业。魅思提供全方位的互联网产业链服务。我们洞察市场、深谙技术、引入资本运作,帮助您在互联网领域实现互联网化转型,抓住互联网+传统企业的新机遇！', '网页的描述信息，搜索引擎采纳后，作为搜索结果中的页面摘要显示，建议不超过80个字');
INSERT INTO `ms_admin_config` VALUES (6, 'base', 'ICP备案信息', 'site_icp', '粤ICP10003013211', 'ICP备案号，用于展示在网站底部');
INSERT INTO `ms_admin_config` VALUES (7, 'base', '站点统计代码', 'site_statis', '', '第三方流量统计代码，前台调用时请先用 htmlspecialchars_decode函数转义输出');
INSERT INTO `ms_admin_config` VALUES (8, 'base', '金币汇率', 'gold_exchange_rate', '15', '金币跟人民币的比率,如1元等于10金币则填写 1/10');
INSERT INTO `ms_admin_config` VALUES (9, 'base', '是否允许提现', 'is_withdrawals', '1', '1为支持，0为不支持');
INSERT INTO `ms_admin_config` VALUES (10, 'base', '提现频率', 'withdrawals_frequency', '0', '提交了提现申请之后多久可以再次申请');
INSERT INTO `ms_admin_config` VALUES (11, 'base', '注册奖励', 'register_reward', '1', '新用户注册奖励多少金币');
INSERT INTO `ms_admin_config` VALUES (12, 'base', '登录奖励', 'login_reward', '1', '用户当天首次登录奖励多少金币');
INSERT INTO `ms_admin_config` VALUES (13, 'base', '签到奖励', 'sign_reward', '1', '用户签到奖励多少金币');
INSERT INTO `ms_admin_config` VALUES (14, 'base', '宣传奖励', 'propaganda_reward', '1', '用户宣传奖励多少金币');
INSERT INTO `ms_admin_config` VALUES (15, 'base', '消费有效期', 'message_validity', '1', '视频付费了之后，多长时间内可以免费观看');
INSERT INTO `ms_admin_config` VALUES (16, 'base', '是否开启验证码', 'verification_code_on', '1', '1为开启，0为不开启');
INSERT INTO `ms_admin_config` VALUES (17, 'base', '提现最低限额', 'min_withdrawals', '20', '申请提现最低提现金币数');
INSERT INTO `ms_admin_config` VALUES (18, 'video', '是否支持试看', 'look_at_on', '1', '1为支持，0为不支持');
INSERT INTO `ms_admin_config` VALUES (19, 'video', '试看的单位', 'look_at_measurement', '1', '试看的单位（部/秒）1为以部为单位，2为以秒为单位');
INSERT INTO `ms_admin_config` VALUES (20, 'video', '试看的数量', 'look_at_num', '3', '可试看的数量');
INSERT INTO `ms_admin_config` VALUES (21, 'video', '视频提成', 'commission', '1', '填写1-10的数字，如1，就是1/100');
INSERT INTO `ms_admin_config` VALUES (22, 'video', '是否开启广告', 'ad_on', '1', '1为开启，0为关闭');
INSERT INTO `ms_admin_config` VALUES (23, 'video', '是否可跳过广告', 'skip_ad_on', '1', '1为可以，0为不可以');
INSERT INTO `ms_admin_config` VALUES (24, 'video', '前置广告内容', 'pre_ad', 'http://v.meisicms.cn/uploadfile/2017/0824/20170824112033621.jpg', '前置广告内容');
INSERT INTO `ms_admin_config` VALUES (25, 'video', '前置广告外链', 'pre_ad_url', 'http://baidu.com', '前置广告外链');
INSERT INTO `ms_admin_config` VALUES (26, 'video', '暂停广告内容', 'suspend_ad', 'http://v.meisicms.cn/uploadfile/2017/0824/20170824112033621.jpg', '暂停广告内容');
INSERT INTO `ms_admin_config` VALUES (27, 'video', '暂停广告外链', 'suspend_ad_url', 'http://baidu.com', '暂停广告外链');
INSERT INTO `ms_admin_config` VALUES (28, 'attachment', '图片存储方式', 'image_save_server_type', 'web_server', '站内图片使用的存储方式');
INSERT INTO `ms_admin_config` VALUES (29, 'attachment', '视频存储方式', 'video_save_server_type', 'yunzhuanma', '视频资源存储的方式');
INSERT INTO `ms_admin_config` VALUES (30, 'attachment', '云转码服务器地址', 'yzm_upload_url', 'http://ms.92xj.net:2000', '直接填写云转码服务器的url或ip即可');
INSERT INTO `ms_admin_config` VALUES (31, 'attachment', '云转码播放密钥', 'yzm_play_secretkey', 'msvodx', '防盗密钥需与云转码后台设置的保持一致,无设置请留空.(系统设置->防盗设置->防盗密钥)');
INSERT INTO `ms_admin_config` VALUES (32, 'attachment', '七牛AccessKey', 'qiniu_accesskey', '', '七牛官网申请，<a href=\"https://www.qiniu.com/\">点击申请</a>');
INSERT INTO `ms_admin_config` VALUES (33, 'attachment', '七牛SecretKey', 'qiniu_secretkey', '', '七牛官网申请，<a href=\"https://www.qiniu.com/\">点击申请</a>');
INSERT INTO `ms_admin_config` VALUES (34, 'base', '网站状态', 'site_status', '1', '1为开启，0为不开启');
INSERT INTO `ms_admin_config` VALUES (35, 'base', '手机网站', 'wap_site_status', '1', '1为开启，0为不开启');
INSERT INTO `ms_admin_config` VALUES (36, 'attachment', '七牛Bucket', 'qiniu_bucket', '', '你的七牛云存储仓库名称');
INSERT INTO `ms_admin_config` VALUES (37, 'base', '是否开启伪静态', 'web_mode', '0', '1为开启，0为不开启');
INSERT INTO `ms_admin_config` VALUES (38, 'attachment', '阿里云存储城市', 'aliyun_oss_city', '北京', '');
INSERT INTO `ms_admin_config` VALUES (39, 'attachment', '阿里云AccessKeyId', 'aliyun_accesskey', 'LTAIG4qLNXrDJCtnx', '');
INSERT INTO `ms_admin_config` VALUES (40, 'attachment', '阿里云AccessKeySecret', 'aliyun_secretkey', 'x37mJm8AyCT11O6sVXkwE0EdoI5eLWO', '');
INSERT INTO `ms_admin_config` VALUES (41, 'attachment', '阿里云Bucket', 'aliyun_bucket', 'wufui', '');
INSERT INTO `ms_admin_config` VALUES (42, 'attachment', 'webServer地址', 'web_server_url', 'http://www.client.com', '');
INSERT INTO `ms_admin_config` VALUES (43, 'commission', '视频提成', 'video_commission', '10', '视频提成，填写1-100的值');
INSERT INTO `ms_admin_config` VALUES (44, 'commission', '图片提成', 'atlas_commission', '10', '图片提成，填写1-100的值');
INSERT INTO `ms_admin_config` VALUES (45, 'commission', '小说提成', 'novel_commission', '10', '小说提成，填写1-100的值');
INSERT INTO `ms_admin_config` VALUES (46, 'commission', '分销商提成', 'agent_commission', '10', '');
INSERT INTO `ms_admin_config` VALUES (47, 'attachment', '七牛存储服务器地址', 'qiniu_upload_server', '华南', '');
INSERT INTO `ms_admin_config` VALUES (48, 'attachment', '七牛外链默认域名', 'qiniu_resource_default_domain', '', '');
INSERT INTO `ms_admin_config` VALUES (49, 'video', '播放视频时广告显示时长', 'play_video_ad_time', '3', '对前置广告生效');
INSERT INTO `ms_admin_config` VALUES (50, 'base', '评论功能', 'comment_on', '1', '是否开启评论功能，1为开启，0为不开启');
INSERT INTO `ms_admin_config` VALUES (51, 'base', '评论是都需要审核', 'comment_examine_on', '1', '评论是否需要审核1为需要，0为不需要');
INSERT INTO `ms_admin_config` VALUES (52, 'email', '邮箱服务器', 'email_host', 'smtp.163.com', '邮箱服务器');
INSERT INTO `ms_admin_config` VALUES (53, 'email', '发送者邮箱账号', 'send_email', 'msvod888@163.com', '发送者邮箱账号');
INSERT INTO `ms_admin_config` VALUES (54, 'email', '邮箱密码', 'email_password', 'abvcdef888', '发送者邮箱密码');
INSERT INTO `ms_admin_config` VALUES (55, 'email', '端口号', 'email_port', '25', '邮箱服务器端口号');
INSERT INTO `ms_admin_config` VALUES (56, 'email', '发送者email地址', 'from_email', 'msvod888@163.com', '发送者email地址');
INSERT INTO `ms_admin_config` VALUES (57, 'email', '发件人名称', 'email_from_name', 'MsvodX官网', '发件人名称');
INSERT INTO `ms_admin_config` VALUES (58, 'base', '一天可获得金币的分享的次数', 'share_num', '20', '一天可获得金币的分享的次数');
INSERT INTO `ms_admin_config` VALUES (60, 'base', '打赏排行', 'reward_num', '2', '首页打赏排行显示名次：例如首页排行榜显示前五名');
INSERT INTO `ms_admin_config` VALUES (61, 'base', '系统支付方式码', 'system_payment_code', 'codePay', NULL);
INSERT INTO `ms_admin_config` VALUES (63, 'base', '新增资源审核', 'resource_examine_on', '1', '客户上传了新资源（视频、图册、小说）是否需要审核，1为需要，0为不需要');
INSERT INTO `ms_admin_config` VALUES (64, 'base', '视频重审', 'video_reexamination', '1', '客户编辑视频信息后是否需要重新审核，如修改了标题，标签，视频地址等');
INSERT INTO `ms_admin_config` VALUES (65, 'base', '图片重审', 'image_reexamination', '1', '客户上传了新的图片或者修改了图册信息后是否需要重新审核');
INSERT INTO `ms_admin_config` VALUES (66, 'base', '小说重审', 'novel_reexamination', '1', '客户编辑小说信息后是否需要重新审核，如修改了标题，标签，小说内容等');
INSERT INTO `ms_admin_config` VALUES (67, 'sms', '短信api账号', 'sms_api_account', 'N380662238', '短信接口账号 ');
INSERT INTO `ms_admin_config` VALUES (68, 'sms', '短信api密码', 'sms_api_password', 'AKSbhUT1Eif4acc', '短信接口密码');
INSERT INTO `ms_admin_config` VALUES (69, 'sms', '短信api链接', 'sms_send_url', 'http://smssh1.253.com/msg/send/json', '发送短信接口URL');
INSERT INTO `ms_admin_config` VALUES (70, 'base', '注册验证', 'register_validate', '0', '注册验证方式 0为不需要关闭，1为邮件验证，2为手机短信验证');
INSERT INTO `ms_admin_config` VALUES (71, 'video', '手机试看部数', 'look_at_num_mobile', '3', '防止UC手机端非法浏览VIP资源，故手机端单独设置');
INSERT INTO `ms_admin_config` VALUES (72, 'video', '云转码播放域名', 'yzm_video_play_domain', 'http://ms.92xj.net:2100', NULL);
INSERT INTO `ms_admin_config` VALUES (73, 'video', '云转码API密钥', 'yzm_api_secretkey', 'msvod', NULL);
INSERT INTO `ms_admin_config` VALUES (74, 'video', '视频自动入库分类id', 'sync_add_video_classid', '10', NULL);
INSERT INTO `ms_admin_config` VALUES (75, 'video', '自动入库的视频是否需要审核', 'sync_add_video_need_review', '0', NULL);
INSERT INTO `ms_admin_config` VALUES (76, 'base', '手机网站logo', 'site_logo_mobile', 'https://wufui.oss-cn-beijing.aliyuncs.com/20180402/EYFjZjTZpHiHWMWPQzEft6mTZmR3k33s.jpg', NULL);
INSERT INTO `ms_admin_config` VALUES (77, 'base', '友情链接', 'friend_link', '魅思|http://www.msvod.cc\r\n百度|http://www.baidu.com\r\n优酷|http://www.youku.com', '每行一条友情链接,单条规则：链接名称|网址,例：Msvodx|http://www.msvod.c');
INSERT INTO `ms_admin_config` VALUES (78, 'base', '主题basename', 'theme_basename', 'default', NULL);
INSERT INTO `ms_admin_config` VALUES (79, 'commission', '一级分销商提成', 'one_level_distributor', '1', '一级分销商提成，填写0-100的值');
INSERT INTO `ms_admin_config` VALUES (80, 'commission', '二级分销商提成', 'second_level_distributor', '3', '二级分销商提成，填写0-100的值');
INSERT INTO `ms_admin_config` VALUES (81, 'commission', '三级分销商提成', 'three_level_distributor', '5', '三级分销商提成，填写0-100的值');
INSERT INTO `ms_admin_config` VALUES (82, 'commission', '三级分销商是否与代理商提成可同时获取', 'three_level_distributor_on', '0', '三级分销商是否与代理商提成可同时获取');
INSERT INTO `ms_admin_config` VALUES (83, 'base', '首页内容个数', 'homepage_resource_num', '15', '首页上每个栏目内容的显示个数');
INSERT INTO `ms_admin_config` VALUES (84, 'base', '卡密码购买链接', 'buy_cardpassword_uri', 'http://www.baidu.com', '用于指引会员在卡密平台上购买本站卡密');
INSERT INTO `ms_admin_config` VALUES (85, 'gather', '是否开启采集接口', 'resource_gather_status', '1', '是否开启系统采集接口');
INSERT INTO `ms_admin_config` VALUES (86, 'gather', '接口密钥', 'resource_gather_key', 'AxkXeZR56NrTBSNS3H', '接口密钥');
INSERT INTO `ms_admin_config` VALUES (87, 'gather', '图册采集入库分类', 'resource_gather_atlas_classid', '23', '图册采集入库的分类');
INSERT INTO `ms_admin_config` VALUES (88, 'gather', '视频采集入库分类', 'resource_gather_video_classid', '14', '视频采集入库的分类');
INSERT INTO `ms_admin_config` VALUES (89, 'gather', '资讯采集入库分类', 'resource_gather_novel_classid', '17', '小说采集入库的分类');
INSERT INTO `ms_admin_config` VALUES (90, 'gather', '采集的视频是否需要审核', 'resource_gather_video_need_review', '1', '采集的视频是否需要审核');
INSERT INTO `ms_admin_config` VALUES (91, 'gather', '采集的小说是否需要审核', 'resource_gather_novel_need_review', '0', '采集的小说是否需要审核');
INSERT INTO `ms_admin_config` VALUES (92, 'gather', '采集的图册是否需要审核', 'resource_gather_atlas_need_review', '1', '采集的图册是否需要审核');
INSERT INTO `ms_admin_config` VALUES (93, 'gather', '采集的视频观看金币数', 'resource_gather_video_view_gold', '1', '采集的视频观看金币数');
INSERT INTO `ms_admin_config` VALUES (94, 'gather', '采集的小说观看金币数', 'resource_gather_novel_view_gold', '0', '采集的小说观看金币数');
INSERT INTO `ms_admin_config` VALUES (95, 'gather', '采集的图册观看金币数', 'resource_gather_atlas_view_gold', '3', '采集的图册观看金币数');

-- ----------------------------
-- Table structure for ms_advertisement
-- ----------------------------
DROP TABLE IF EXISTS `ms_advertisement`;
CREATE TABLE `ms_advertisement`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) DEFAULT NULL COMMENT '类型，1广告代码，2用户自定义图片',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '广告代码',
  `titles` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '标题',
  `info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '详细信息',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '外链',
  `position_id` int(11) DEFAULT NULL COMMENT '广告位',
  `add_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `begin_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `status` int(1) DEFAULT 1 COMMENT '状态1开启，0关闭',
  `host` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '所属域名',
  `target` int(1) DEFAULT 1 COMMENT '是否新页面打开1为是，0为否',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '广告表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ms_advertisement
-- ----------------------------
INSERT INTO `ms_advertisement` VALUES (8, 2, 'http://sp.msvodx.com/XResource/20180123/cYzmGNZrbNxJEEisi488m2PizSEFwHTw.png', '首页广告1', '', 'http://www.msvod.cc/', 1, 1516691534, 1516636800, 1577808000, 1, '', 0);

-- ----------------------------
-- Table structure for ms_advertisement_position
-- ----------------------------
DROP TABLE IF EXISTS `ms_advertisement_position`;
CREATE TABLE `ms_advertisement_position`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '广告标题',
  `width` int(11) DEFAULT NULL COMMENT '广告宽度',
  `height` int(11) DEFAULT NULL COMMENT '广告高度',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '广告位表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ms_advertisement_position
-- ----------------------------
INSERT INTO `ms_advertisement_position` VALUES (1, '首页广告位1', 300, 100);
INSERT INTO `ms_advertisement_position` VALUES (2, '首页广告位2', 300, 250);
INSERT INTO `ms_advertisement_position` VALUES (3, '首页广告1', 266, 362);
INSERT INTO `ms_advertisement_position` VALUES (4, '广告2', 366, 35);
INSERT INTO `ms_advertisement_position` VALUES (5, '广告6', 212, 3212);
INSERT INTO `ms_advertisement_position` VALUES (6, '收银台右侧广告', 255, 630);

-- ----------------------------
-- Table structure for ms_agent_apply
-- ----------------------------
DROP TABLE IF EXISTS `ms_agent_apply`;
CREATE TABLE `ms_agent_apply`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '会员id',
  `apply_time` int(10) NOT NULL COMMENT '申请时间',
  `status` tinyint(1) NOT NULL COMMENT '状态0为拒绝1为通过2为未处理',
  `last_time` int(10) NOT NULL COMMENT '最后处理时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员代理审核记录表' ROW_FORMAT = Fixed;


-- ----------------------------
-- Table structure for ms_atlas
-- ----------------------------
DROP TABLE IF EXISTS `ms_atlas`;
CREATE TABLE `ms_atlas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '标题',
  `info` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '说明',
  `short_info` varchar(90) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '短说明',
  `key_word` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '关键词',
  `cover` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '封面',
  `add_time` int(10) DEFAULT NULL COMMENT '上传时间',
  `update_time` int(10) DEFAULT NULL COMMENT '修改时间',
  `gold` int(11) DEFAULT NULL COMMENT '观看需要金币',
  `click` int(11) DEFAULT 0 COMMENT '总点击量',
  `good` int(11) DEFAULT 0 COMMENT '总赞数',
  `user_id` int(11) DEFAULT 0 COMMENT '上传者id',
  `class` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '所属分类',
  `tag` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '所属标签',
  `status` int(2) DEFAULT 1 COMMENT '状态1为显示，0为隐藏',
  `is_check` int(1) DEFAULT 0 COMMENT '是否审核 。1审核通过，2审核未通过，0待审核',
  `hint` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '驳回原因',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '相册表(图集表)' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_atlas_good_log
-- ----------------------------
DROP TABLE IF EXISTS `ms_atlas_good_log`;
CREATE TABLE `ms_atlas_good_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `atlas_id` int(11) DEFAULT NULL COMMENT '点赞的视频id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `add_time` int(10) DEFAULT NULL COMMENT '点赞时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '图集收藏日志表' ROW_FORMAT = Fixed;


-- ----------------------------
-- Table structure for ms_atlas_watch_log
-- ----------------------------
DROP TABLE IF EXISTS `ms_atlas_watch_log`;
CREATE TABLE `ms_atlas_watch_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `atlas_id` int(11) NOT NULL COMMENT '图集id',
  `user_id` int(11) DEFAULT 0 COMMENT '用户Id',
  `user_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '用户ip',
  `view_time` int(10) NOT NULL COMMENT '观看时间',
  `gold` int(11) DEFAULT NULL COMMENT '消费金币数',
  `is_try_see` int(255) DEFAULT 0 COMMENT '是否为试看，1：试看',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '相册观看日志表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_banner
-- ----------------------------
DROP TABLE IF EXISTS `ms_banner`;
CREATE TABLE `ms_banner`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '名称',
  `images_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图片url',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '外链',
  `sort` int(11) DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) DEFAULT 1 COMMENT '状态',
  `info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '说明',
  `target` int(1) DEFAULT 1 COMMENT '是否新页面打开1为是，0为否',
  `fid` int(11) DEFAULT 0 COMMENT '关联站群，0为主站',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '首页banner配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ms_banner
-- ----------------------------
INSERT INTO `ms_banner` VALUES (6, '首页AD', 'http://sp.msvodx.com/XResource/20180209/sSypyBEXkbZcCXjDhsyD4rpcA26azH4j.png', 'http://www.msvod.cc/', 3, 1, '1', 1, 0);
INSERT INTO `ms_banner` VALUES (7, '首页ADasdasd', 'http://sp.msvodx.com/XResource/20180209/sSypyBEXkbZcCXjDhsyD4rpcA26azH4j.png', 'http://www.msvod.cc/', 3, 1, '1', 1, 5);


-- ----------------------------
-- Table structure for ms_card_password
-- ----------------------------
DROP TABLE IF EXISTS `ms_card_password`;
CREATE TABLE `ms_card_password`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '卡号',
  `card_type` int(1) DEFAULT NULL COMMENT '卡类型1为vip卡，2为金币卡',
  `out_time` int(11) DEFAULT NULL COMMENT '过期时间',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `status` int(1) DEFAULT 0 COMMENT '状态，0未使用，1已使用',
  `price` int(11) DEFAULT NULL COMMENT '价格金额',
  `gold` int(11) DEFAULT 0 COMMENT '金币数',
  `vip_time` int(11) DEFAULT 0 COMMENT '会员时间，当为永久会员的时候为999999999',
  `use_time` int(11) DEFAULT NULL COMMENT '充值卡使用时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '卡密表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_class
-- ----------------------------
DROP TABLE IF EXISTS `ms_class`;
CREATE TABLE `ms_class`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '分类名字',
  `sort` int(11) DEFAULT 0 COMMENT '排序',
  `pid` int(11) DEFAULT 0 COMMENT '父类id',
  `type` int(2) DEFAULT NULL COMMENT '所属模块1为电影，2图片，3小说',
  `last_time` int(11) DEFAULT NULL COMMENT '最后处理时间',
  `read_group` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '可读会员组',
  `upload_group` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '可上传会员组',
  `status` int(2) DEFAULT 1 COMMENT '状态1开启，0关闭',
  `home_dispay` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否首页展示当前分类，1为在首页展示，0为不展示',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '资源分类表(视频|小说|图片)' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ms_class
-- ----------------------------
INSERT INTO `ms_class` VALUES (2, '韩流频道', 5, 0, 1, 1516254823, '0', '0', 1, 1);
INSERT INTO `ms_class` VALUES (3, '王者宣策', 0, 1, 1, 1510725910, '0', '0', 1, 0);
INSERT INTO `ms_class` VALUES (9, '华语频道', 0, 0, 1, 1516254842, '0', '0', 1, 1);
INSERT INTO `ms_class` VALUES (11, '王者荣耀', 1, 8, 3, 1513908860, '0', '0', 1, 1);
INSERT INTO `ms_class` VALUES (13, '清纯美眉', 0, 0, 2, 1516421368, '0', '0', 1, 0);
INSERT INTO `ms_class` VALUES (14, '日语频道', 0, 0, 1, 1516254925, '0', '0', 1, 0);
INSERT INTO `ms_class` VALUES (15, '新闻资讯', 0, 0, 3, 1513908907, '0', '0', 1, 1);
INSERT INTO `ms_class` VALUES (16, '玄幻小说', 0, 0, 3, 1513909479, '0', '0', 1, 1);
INSERT INTO `ms_class` VALUES (17, '言情小说', 0, 0, 3, 1513909492, '0', '0', 1, 0);
INSERT INTO `ms_class` VALUES (18, '绝地逢生', 0, 8, 3, 1513908874, '0', '0', 1, 0);
INSERT INTO `ms_class` VALUES (27, '舞蹈视频', 0, 0, 1, 1513910194, '0', '0', 1, 0);
INSERT INTO `ms_class` VALUES (8, '游戏攻略', 6, 0, 3, 1513908844, '0', '0', 1, 0);
INSERT INTO `ms_class` VALUES (19, '美女校花', 0, 0, 2, 1517195089, '0', '0', 1, 0);
INSERT INTO `ms_class` VALUES (24, '明星写真', 0, 0, 2, 1516421431, '0', '0', 1, 0);
INSERT INTO `ms_class` VALUES (29, 'MsvodX教程', 0, 0, 1, 1517496301, '0', '0', 1, 0);

-- ----------------------------
-- Table structure for ms_comment
-- ----------------------------
DROP TABLE IF EXISTS `ms_comment`;
CREATE TABLE `ms_comment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to_id` int(11) NOT NULL DEFAULT 0 COMMENT '回复消息的父id',
  `send_user` int(11) NOT NULL COMMENT '发送用户id',
  `to_user` int(11) DEFAULT NULL COMMENT '接收用户id（当是回帖的时候存在）',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `resources_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '资源类型',
  `resources_id` int(11) DEFAULT NULL COMMENT '资源id',
  `status` tinyint(1) DEFAULT 0 COMMENT '状态（0为未处理，1为通过，2为拒绝）',
  `add_time` int(10) NOT NULL COMMENT '评论时间',
  `last_time` int(10) DEFAULT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统评论表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ms_domain_cname_binding
-- ----------------------------
DROP TABLE IF EXISTS `ms_domain_cname_binding`;
CREATE TABLE `ms_domain_cname_binding`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '会员id',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `webhost` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '域名地址',
  `status` tinyint(1) DEFAULT 0 COMMENT '状态0为未处理，1为已通过，2为已拒绝',
  `last_time` int(11) DEFAULT NULL COMMENT '最后修改的时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '域名绑定表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_draw_money_account
-- ----------------------------
DROP TABLE IF EXISTS `ms_draw_money_account`;
CREATE TABLE `ms_draw_money_account`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '标题',
  `type` tinyint(1) DEFAULT 1 COMMENT '收款方式（1.支付宝2银行卡）',
  `account` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '账号',
  `account_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '收款人姓名',
  `bank` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '收款卡所属银行',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '提现帐户信息表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_draw_money_log
-- ----------------------------
DROP TABLE IF EXISTS `ms_draw_money_log`;
CREATE TABLE `ms_draw_money_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `gold` int(11) DEFAULT NULL COMMENT '金币数',
  `money` int(11) DEFAULT NULL COMMENT '金额',
  `add_time` int(11) NOT NULL COMMENT '提交时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  `status` int(1) DEFAULT 0 COMMENT '状态（0未处理，1已完成，2已拒绝）',
  `info` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '收款信息json（收款方式（支付宝or银行卡），收款账号，银行卡号（收款方式为银行卡的时候存在） ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '提现记录表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_gift
-- ----------------------------
DROP TABLE IF EXISTS `ms_gift`;
CREATE TABLE `ms_gift`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '礼物名称',
  `images` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '礼物图标',
  `price` int(11) NOT NULL COMMENT '需要的金币数',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '打赏奖品表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ms_gift
-- ----------------------------
INSERT INTO `ms_gift` VALUES (1, '火麒麟', 'http://oz58x3ytv.bkt.clouddn.com/wlar4yxnlkphgqg9b4kf9yuzuzmd6csk.gif', 11, 9, 1, '火麒麟');
INSERT INTO `ms_gift` VALUES (2, '冰麒麟', 'http://v.msvodx.com/XResource/20180225/ZMfEa4MBZRntJfz8yRrME6Fy6XPssC6F.gif', 88, 0, 1, '冰麒麟');
INSERT INTO `ms_gift` VALUES (5, '神龟', 'http://oz58x3ytv.bkt.clouddn.com/2wy6y7rh5rprpvoz97ykvyek5wde68q1.gif', 8, 99, 1, '神龟');
INSERT INTO `ms_gift` VALUES (6, '艺奇', 'http://oz58x3ytv.bkt.clouddn.com/da0m5kennlg53o03ygdwe7fm1minwxg1.gif', 10, 1, 1, '艺奇');

-- ----------------------------
-- Table structure for ms_gold_log
-- ----------------------------
DROP TABLE IF EXISTS `ms_gold_log`;
CREATE TABLE `ms_gold_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `gold` int(11) DEFAULT NULL COMMENT '金币数',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `module` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '来源模块',
  `explain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '说明描述',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '金币明细表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_gold_package
-- ----------------------------
DROP TABLE IF EXISTS `ms_gold_package`;
CREATE TABLE `ms_gold_package`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '套餐名称',
  `price` double(10, 2) DEFAULT NULL COMMENT '价格',
  `gold` int(11) DEFAULT NULL COMMENT '金币个数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '金币套餐表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ms_gold_package
-- ----------------------------
INSERT INTO `ms_gold_package` VALUES (1, '测试套餐1', 10.00, 100);
INSERT INTO `ms_gold_package` VALUES (2, '测试套餐2', 30.00, 300);
INSERT INTO `ms_gold_package` VALUES (3, '测试套餐3', 45.00, 500);
INSERT INTO `ms_gold_package` VALUES (4, '测试套餐4', 70.00, 800);

-- ----------------------------
-- Table structure for ms_gratuity_record
-- ----------------------------
DROP TABLE IF EXISTS `ms_gratuity_record`;
CREATE TABLE `ms_gratuity_record`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `gratuity_time` int(10) NOT NULL COMMENT '打赏时间',
  `gift_info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '打赏礼物信息json，包含礼物名称，礼物费用',
  `content_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '打赏内容类型 1:视频 2:图片 3:小说',
  `content_id` int(11) NOT NULL COMMENT '打赏内容id',
  `price` int(10) NOT NULL DEFAULT 0 COMMENT '打赏价格',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '打赏记录表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_image
-- ----------------------------
DROP TABLE IF EXISTS `ms_image`;
CREATE TABLE `ms_image`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '标题',
  `atlas_id` int(11) DEFAULT NULL COMMENT '图集id',
  `info` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '说明',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '链接',
  `sort` int(11) DEFAULT 0 COMMENT '排序',
  `status` int(2) DEFAULT 1 COMMENT '显示隐藏',
  `add_time` int(11) DEFAULT 0 COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '图片表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_image_collection
-- ----------------------------
DROP TABLE IF EXISTS `ms_image_collection`;
CREATE TABLE `ms_image_collection`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `image_id` int(11) DEFAULT NULL COMMENT '图片id',
  `collection_time` int(11) DEFAULT NULL COMMENT '收藏时间',
  `atlas_id` int(11) DEFAULT NULL COMMENT '所属客户图集',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '图片收藏表' ROW_FORMAT = Fixed;


-- ----------------------------
-- Table structure for ms_login_log
-- ----------------------------
DROP TABLE IF EXISTS `ms_login_log`;
CREATE TABLE `ms_login_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `login_time` int(10) DEFAULT NULL COMMENT '登录时间',
  `ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'ip',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '登陆日志表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_login_setting
-- ----------------------------
DROP TABLE IF EXISTS `ms_login_setting`;
CREATE TABLE `ms_login_setting`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录方式的code',
  `login_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录名称',
  `config` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '登录方式配置信息',
  `status` int(1) DEFAULT 1 COMMENT '是否开户，1：开启，0：关闭',
  `add_time` int(10) DEFAULT NULL COMMENT '安装时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '支付配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ms_login_setting
-- ----------------------------
INSERT INTO `ms_login_setting` VALUES (1, 'qq', 'QQ登录', '[{\"name\":\"APPID\",\"type\":\"text\",\"value\":\"101459043\",\"desc\":\"APPID\"},{\"name\":\"APPKey\",\"type\":\"text\",\"value\":\"ee4f10c0c0404bf61de486cf1ec717be\",\"desc\":\"APPKey\"}]', 0, 1514888835, 1519263423);
INSERT INTO `ms_login_setting` VALUES (2, 'wechat', '微信登录', '[{\"name\":\"APPID\",\"type\":\"text\",\"value\":\"wx61f95e78cf0934e7\",\"desc\":\"APPID\"},{\"name\":\"APPKey\",\"type\":\"text\",\"value\":\"6fc1bfa2d44d329c4e6ab9f4b5957a1e\",\"desc\":\"APPKey\"}]', 0, 1514888835, 1519263423);

-- ----------------------------
-- Table structure for ms_member
-- ----------------------------
DROP TABLE IF EXISTS `ms_member`;
CREATE TABLE `ms_member`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL COMMENT '上级代理商id',
  `gid` int(11) DEFAULT 1 COMMENT '所属会员组id,1:普通会员，2:vip会员',
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `tel` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '手机',
  `nickname` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '昵称',
  `headimgurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '头像',
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '邮件',
  `money` int(11) DEFAULT 0 COMMENT '金币',
  `out_time` bigint(10) DEFAULT NULL COMMENT '过期时间',
  `is_agent` tinyint(1) DEFAULT 0 COMMENT '是否是代理商,0:不是，1：是',
  `is_permanent` tinyint(1) DEFAULT 0 COMMENT '是否永久用户',
  `add_time` int(10) NOT NULL COMMENT '添加时间',
  `last_time` int(10) DEFAULT NULL COMMENT '最后登录时间',
  `status` tinyint(1) DEFAULT 1 COMMENT '状态',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别1为男2为女',
  `last_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '最后登录的ip',
  `login_count` int(11) DEFAULT 0 COMMENT '登录次数',
  `agent_config` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '代理相关站点设置',
  `access_token` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '验证token',
  `openid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '第三方登录openid',
  `unionid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '微信用户全平台唯一id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员信息表' ROW_FORMAT = Compact;


-- ----------------------------
-- Table structure for ms_menu
-- ----------------------------
DROP TABLE IF EXISTS `ms_menu`;
CREATE TABLE `ms_menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT 0 COMMENT '父级菜单id',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '菜单名字',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '菜单链接',
  `sort` int(11) DEFAULT 0 COMMENT '排序',
  `status` tinyint(11) NOT NULL DEFAULT 1 COMMENT '是否显示',
  `type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '类型1为url为地址，2为url为分类id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '前端菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ms_menu
-- ----------------------------
INSERT INTO `ms_menu` VALUES (30, 0, '小说', '{\"cid\":\"novel\"}', 3, 1, 2);
INSERT INTO `ms_menu` VALUES (2, 1, '王者荣耀', '{\"cid\":2,\"type\":1}', 1, 1, 2);
INSERT INTO `ms_menu` VALUES (12, 11, '最新视频', '{\"cid\":\"2\",\"type\":1}', 0, 1, 2);
INSERT INTO `ms_menu` VALUES (28, 26, '游戏视频', '{\"cid\":\"9\",\"type\":1}', 9, 1, 2);
INSERT INTO `ms_menu` VALUES (14, 13, '鲁班小说', '{\"cid\":\"11\",\"type\":3}', 0, 1, 2);
INSERT INTO `ms_menu` VALUES (31, 26, '所有视频', '/video/lists', 1, 1, 1);
INSERT INTO `ms_menu` VALUES (26, 0, '视频', '{\"cid\":\"video\"}', 2, 1, 2);
INSERT INTO `ms_menu` VALUES (17, 16, '最新图片', '{\"cid\":\"3\",\"type\":2}', 0, 1, 2);
INSERT INTO `ms_menu` VALUES (25, 0, '首页', '/', 1, 1, 1);
INSERT INTO `ms_menu` VALUES (21, 11, '最热视频', '{\"cid\":\"10\",\"type\":1}', 0, 1, 2);
INSERT INTO `ms_menu` VALUES (24, 11, '百度', 'http://www.baidu.com', 0, 1, 1);
INSERT INTO `ms_menu` VALUES (29, 26, '最新视频', '/video/lists/orderCode/lastTime.html', 3, 1, 1);
INSERT INTO `ms_menu` VALUES (32, 26, '最热视频', '/video/lists/orderCode/hot.html', 0, 1, 1);
INSERT INTO `ms_menu` VALUES (33, 0, '图片', '{\"cid\":\"images\"}', 4, 1, 2);
INSERT INTO `ms_menu` VALUES (39, 30, '科幻', 'http://www.msvod.cc/', 0, 1, 1);
INSERT INTO `ms_menu` VALUES (40, 30, '恐怖悬疑', 'http://www.msvod.cc/', 0, 1, 1);

-- ----------------------------
-- Table structure for ms_notice
-- ----------------------------
DROP TABLE IF EXISTS `ms_notice`;
CREATE TABLE `ms_notice`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '内容',
  `out_time` bigint(20) DEFAULT NULL COMMENT '过期时间',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  `sort` tinyint(1) DEFAULT NULL COMMENT '排序',
  `type` tinyint(1) DEFAULT NULL COMMENT '内容展示方式1为弹出层，2为页面转跳',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '转跳网址',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '公告表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ms_notice
-- ----------------------------
INSERT INTO `ms_notice` VALUES (1, '根据版权方要求，名师机构为单独付费板块。魅思所有学员可享受折扣低价，付费会员更可尊享折上折，快来学习吧。', '根据版权方要求，名师机构为单独付费板块。<br>魅思所有学员可享受折扣低价，付费会员更可尊享折上折，快来学习吧。', 1582041600, 1, 0, 1, NULL);

-- ----------------------------
-- Table structure for ms_novel
-- ----------------------------
DROP TABLE IF EXISTS `ms_novel`;
CREATE TABLE `ms_novel`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '说明',
  `short_info` varchar(90) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '短说明',
  `key_word` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '关键词',
  `thumbnail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '缩略图',
  `add_time` int(10) DEFAULT 0 COMMENT '添加',
  `status` int(2) DEFAULT 1 COMMENT '显示隐藏',
  `update_time` int(10) DEFAULT 0 COMMENT '修改时间',
  `click` int(11) DEFAULT 0 COMMENT '总点击量',
  `good` int(11) DEFAULT 0 COMMENT '总点赞数',
  `user_id` int(11) DEFAULT 0 COMMENT '上传者id',
  `class` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '所属分类',
  `tag` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '所属标签',
  `gold` int(11) DEFAULT NULL COMMENT '观看金币',
  `is_check` int(1) DEFAULT 0 COMMENT '是否审核 。1审核通过，2审核未通过，0待审核',
  `hint` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '驳回原因',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '小说表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_novel_collection
-- ----------------------------
DROP TABLE IF EXISTS `ms_novel_collection`;
CREATE TABLE `ms_novel_collection`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0 COMMENT '用户id',
  `novel_id` int(11) DEFAULT 0 COMMENT '小说id',
  `collection_time` int(10) DEFAULT 0 COMMENT '收藏时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '小说收藏表' ROW_FORMAT = Fixed;


-- ----------------------------
-- Table structure for ms_novel_good_log
-- ----------------------------
DROP TABLE IF EXISTS `ms_novel_good_log`;
CREATE TABLE `ms_novel_good_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `novel_id` int(11) DEFAULT NULL COMMENT '点赞的视频id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `add_time` int(10) DEFAULT NULL COMMENT '点赞时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '小说收藏日志表' ROW_FORMAT = Fixed;


-- ----------------------------
-- Table structure for ms_novel_watch_log
-- ----------------------------
DROP TABLE IF EXISTS `ms_novel_watch_log`;
CREATE TABLE `ms_novel_watch_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `novel_id` int(11) NOT NULL COMMENT '小说id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户Id',
  `user_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '用户ip',
  `view_time` int(10) NOT NULL COMMENT '观看时间',
  `gold` int(11) DEFAULT NULL COMMENT '消费金币',
  `is_try_see` int(1) DEFAULT 0 COMMENT '是否为试看，1：试看',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '小说阅读日志表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_order
-- ----------------------------
DROP TABLE IF EXISTS `ms_order`;
CREATE TABLE `ms_order`  (
  `order_sn` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号，全局唯一',
  `user_id` int(11) DEFAULT NULL COMMENT '订单发起会员id',
  `payment_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '支付方式code,如codePay',
  `pay_channel` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '支付渠道， wxpay,alipay,qqpay',
  `price` float(10, 2) NOT NULL COMMENT '订单金额',
  `real_pay_price` float DEFAULT NULL COMMENT '真实支付金额',
  `third_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '第三方支付的识别号',
  `buy_type` int(1) DEFAULT NULL COMMENT '购买类型，1:金币，2:vip',
  `buy_glod_num` int(11) DEFAULT NULL COMMENT '购买的金币个数',
  `buy_vip_info` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '购买vip的信息，如套餐信息',
  `status` int(1) DEFAULT 0 COMMENT '0：未支付，1：已支付',
  `from_agent_id` int(11) DEFAULT NULL COMMENT '充值来源代理商id',
  `from_domain` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL COMMENT '订单创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '订单更新时间',
  `pay_time` int(11) DEFAULT NULL COMMENT '订单支付时间',
  PRIMARY KEY (`order_sn`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单表（vip购买及金币充值）' ROW_FORMAT = Compact;


-- ----------------------------
-- Table structure for ms_payment
-- ----------------------------
DROP TABLE IF EXISTS `ms_payment`;
CREATE TABLE `ms_payment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付方式的code',
  `pay_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付名称',
  `config` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '支付方式配置信息',
  `status` int(1) DEFAULT 1 COMMENT '是否开户，1：开启，0：关闭',
  `is_third_payment` int(1) DEFAULT 0 COMMENT '是否为第三方支付，1是 0否（原生支付）',
  `add_time` int(10) DEFAULT NULL COMMENT '安装时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '支付配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ms_payment
-- ----------------------------
INSERT INTO `ms_payment` VALUES (1, 'codePay', '码支付', '[{\"name\":\"merchant_id\",\"type\":\"string\",\"value\":\"18709\",\"desc\":\"\\u5546\\u6237id\"},{\"name\":\"key\",\"type\":\"string\",\"value\":\"UM6iE8R9UD44MHxyB0qRvlXpF6jgqfOk\",\"desc\":\"\\u7801\\u652f\\u4ed8\\u901a\\u4fe1\\u5bc6\\u94a5\"},{\"name\":\"min_money\",\"type\":\"string\",\"value\":\"100\",\"desc\":\"\\u6700\\u4f4e\\u652f\\u4ed8\\u91d1\\u989d\"}]', 1, 1, 1514888879, 1520324536);
INSERT INTO `ms_payment` VALUES (2, 'wxPay', '微信支付', '[{\"name\":\"appid\",\"type\":\"string\",\"value\":\"wx1e076868fbfb4195\",\"desc\":\"\\u516c\\u4f17\\u53f7appid\"},{\"name\":\"secret_key\",\"type\":\"string\",\"value\":\"2bbd1843b672d41b96c18893915365a5\",\"desc\":\"\\u516c\\u4f17\\u53f7SecretKey\"},{\"name\":\"mch_id\",\"type\":\"string\",\"value\":\"1458366102\",\"desc\":\"\\u5546\\u6237\\u53f7\"},{\"name\":\"key\",\"type\":\"string\",\"value\":\"Jgp2OmiuIBskZ523bll6cS6xhvpwCrTk\",\"desc\":\"API\\u5bc6\\u94a5\"},{\"name\":\"notify_url\",\"type\":\"string\",\"value\":\"http:\\/\\/payer.free.ngrok.cc\\/pay_notify\\/wxpayNotify\",\"desc\":\"\\u901a\\u77e5\\u56de\\u8c03\\u5730\\u5740\"},{\"name\":\"min_money\",\"type\":\"int\",\"value\":\"0.01\",\"desc\":\"\\u6700\\u5c0f\\u652f\\u4ed8\\u91d1\\u989d\"}]', 1, 0, 1514888906, 1521461639);
INSERT INTO `ms_payment` VALUES (3, 'aliPay', '支付宝支付', '[{\"name\":\"appid\",\"type\":\"string\",\"value\":\"2017071907814717\",\"desc\":\"appid\"},{\"name\":\"md5_key\",\"type\":\"string\",\"value\":\"bgsdshzscyaqprnmlk5i3oa03dkh7euc\",\"desc\":\"MD5\\u5bc6\\u94a5\"},{\"name\":\"user_private_key\",\"type\":\"textarea\",\"value\":\"MIIEpAIBAAKCAQEA9TVmwFMr5zhLR1R2g1SwXaOe6tJLL2diOslZqoo+0TX\\/KjgqmaUaj0zeqV4ypZvu6bKmBDpEejV7H2l8NYR7K9c7Nr1r\\/LzbYEXaf9IU1ZjHx47MULJ4d+76Oj+E3EcByuB7SKkyk1gh94pEv2YBK8Rvt22foud\\/wyhkLF1YhMOBCiJsCjvIKwkb8SVKhU8sRnKxvpjaBQGkq53ybe8Kn+XoSpkLjR5dhRmY9cKUcJydQE0uv77XOCT4u8tbS2zSbr+ZRqPuLcngJmZhaFe3OECwfxok5Lgs7vBgSPVnar+78cqS71x9d1Py\\/O72pScm7D10PZ10iB8rJhdfdpzFbwIDAQABAoIBAQCZl\\/Cbyb03YSiuLnbpvrOWg\\/X4Su9zawO5pQP4cg31CCij7niosyWW22ShnHKHD8ywMAoTndfk4PkVbQKzlx98D550pGQu9LFJdZfu9s28Ga4SDx1l8tTI8zVkJQN44zV5OfGfSvR2HP9xyfdUGHXlT29W62DSLsX1nahZrcLTrVSPTyEMLbLMT0Q69zkWxbxKAbbrB2vic5JAXmeKKXYdQem4oUA48aT4xuoJqnpBb3iN8FI0L0JbjBBLfq5PBTD4q8EAYI4CZKfcFCorB2KSdBopsrBlHkkcBP7vimFclLa2I2FTTsC2gCOdgHfLWS5cZgdzrinHYuwUUuHR0PmhAoGBAP4HV0OtWvsquxE6Wxu47i4NmrcbOI3Ds+EPjVwrZRfIjGlDSc4rCX0Z\\/zeDb9tNrI1rqhZd1DXgNqm0hlKWaIpuGnnSnBzfmoVb5Vj45JBXyRu6\\/d82ykjDoYyqDcfbJi22bh49DIMIYy5ufp1JNz73rJHnEo1asvRFloAdlSCRAoGBAPccidAoJzHNXIM4R89CuSpgJNJBJ5464kk2ktxQMJU519WbmVhFrT6xnA\\/8hn8EIgUIhcjTJ+JwBLwgU58f8d2wh+1h5gpMQP0oLunyFMUx4cwrUc8U49frYwNpRAZdMU3baUfcT\\/c1K3YwYoJbUEzL4pjnLHXB2d\\/DQZGFxoX\\/AoGAaXYSvH4T74Jl91kKyg+UknoDaVFbwT8mRqF2RnWdmqof4POWiIlFfzJzylA++ATfRjcUfgSmPVfAWeQgf9kBvbbINxtAxJvwQr1MEgwCmApZ67FOBIVypZLSVtuirP5Gc2Pxg4xEzYGF65jj59ilnvakJk6QXS7ybIcXXEjryIECgYEAq5F25b1bKSrKNpkW0oIjCZbjOc\\/e7+82OVrYsHpEoPceMcLsvurxk\\/vAvSC5SOrXq+L08DAbGw5nWy6eoHaPeTodxeUY0MGMxbfmiqt3XEp72UOic0KvxrQ5dJ7bigeeOc5C1I\\/UPXD\\/EfoaCyPXJtrQIxUuOzwyRzfMCHt3EIUCgYAlqQ\\/KpdnUXUoRpv\\/pvPSAGqwONCDiZkmvHqEKTiMJ0mzZ\\/lACpbh+Nqmh9WTR47myVqAiMfOkG+wiZ+OsbyJh2jbQVV2ltaPVm3FekZQ9VVwNOQR3hbjZwwCCL5nsmKnDIWPZv8O8meZoXLYC5V6\\/QkHEMQqGTVQ3k5buZ4o2XA==\",\"desc\":\"\\u5f00\\u53d1\\u8005\\u79c1\\u94a5\"},{\"name\":\"ali_public_key\",\"type\":\"textarea\",\"value\":\"MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnner9A9etcVd\\/h5qhVwJUCyd2gAN929t8CFUX3nWjY8xiCd9wxoAhBxSo7SwL4eyhHvzh41dhoaYOBuaN2Gj3laQc4n6nOlIKzC0uWYokmbqrgSf1hKaJHnm6i3d\\/bQ3T1QiaMdNB+pMKngMUEbKX3btS2v0mGgmuMn58r5Rk3LjdNiQkd64bwUdwW\\/p63YKxHoCJ\\/4OVGLpPQK\\/h+ZBzYQS8A\\/SCK5pQNEt1N4I3G+YYvzULx5QjV631n9X5\\/o5dMSZmrS0QEXYX2h3uQiVq14864Kw\\/QyBseUsqPcCOM4NQvSQIufc4\\/OhQ\\/Hn\\/cH71ZweYn4dUPFH+nWra0MUtQIDAQAB\",\"desc\":\"\\u652f\\u4ed8\\u5b9d\\u516c\\u94a5\"},{\"name\":\"min_money\",\"type\":\"int\",\"value\":\"0.01\",\"desc\":\"\\u6700\\u5c0f\\u652f\\u4ed8\\u91d1\\u989d\"},{\"name\":\"notify_url\",\"type\":\"string\",\"value\":\"http:\\/\\/payer.free.ngrok.cc\\/pay_notify\\/alipayNotify\",\"desc\":\"\\u5f02\\u6b65\\u901a\\u77e5\\u5730\\u5740\"},{\"name\":\"return_url\",\"type\":\"string\",\"value\":\"http:\\/\\/payer.free.ngrok.cc\\/member\\/member\",\"desc\":\"\\u652f\\u4ed8\\u5b8c\\u6210\\u56de\\u8df3\\u5730\\u5740\"}]', 1, 0, 1514888916, 1520838809);

-- ----------------------------
-- Table structure for ms_recharge_package
-- ----------------------------
DROP TABLE IF EXISTS `ms_recharge_package`;
CREATE TABLE `ms_recharge_package`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '套餐名字',
  `sort` int(11) NOT NULL COMMENT '排序',
  `days` int(11) NOT NULL COMMENT '套餐时长（天为单位）',
  `price` decimal(11, 2) DEFAULT NULL COMMENT '价格',
  `permanent` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否永久套餐1为是',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '说明',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'vip套餐表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ms_recharge_package
-- ----------------------------
INSERT INTO `ms_recharge_package` VALUES (1, '包月套餐', 2, 30, 0.01, 0, 1, '包月套餐，有效时间30天，价格只需要188元,精彩内容等着你。');
INSERT INTO `ms_recharge_package` VALUES (2, '包季套餐', 3, 90, 388.00, 0, 1, '季度套餐，有效时间90天，价格只需要388');
INSERT INTO `ms_recharge_package` VALUES (3, '包年套餐', 4, 365, 888.00, 0, 1, NULL);
INSERT INTO `ms_recharge_package` VALUES (8, '永久套餐', 5, 0, 1888.00, 1, 1, '永久套餐，不受时间限制，可以永久使用，仅需888');

-- ----------------------------
-- Table structure for ms_share_log
-- ----------------------------
DROP TABLE IF EXISTS `ms_share_log`;
CREATE TABLE `ms_share_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '分享者id',
  `share_time` int(10) NOT NULL COMMENT '分享时间',
  `to_ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '被分享者ip',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分享日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ms_sign
-- ----------------------------
DROP TABLE IF EXISTS `ms_sign`;
CREATE TABLE `ms_sign`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `sign_time` int(10) DEFAULT NULL COMMENT '签到日期',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员签到日志表' ROW_FORMAT = Fixed;


-- ----------------------------
-- Table structure for ms_tag
-- ----------------------------
DROP TABLE IF EXISTS `ms_tag`;
CREATE TABLE `ms_tag`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标签名字',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `type` int(2) DEFAULT 1 COMMENT '所属模块1视频，2图片，3小说',
  `status` int(2) DEFAULT 1 COMMENT '开启状态1为开启，0为关闭',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '资源标签表(视频|小说|图片)' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ms_tag
-- ----------------------------
INSERT INTO `ms_tag` VALUES (5, '战争', 0, 3, 1);
INSERT INTO `ms_tag` VALUES (10, '军事', 0, 3, 1);
INSERT INTO `ms_tag` VALUES (12, '刺客', 8, 2, 1);
INSERT INTO `ms_tag` VALUES (13, '射手', 7, 2, 1);
INSERT INTO `ms_tag` VALUES (14, '美女', 0, 3, 1);
INSERT INTO `ms_tag` VALUES (15, '青春', 0, 3, 1);
INSERT INTO `ms_tag` VALUES (16, '科技', 0, 3, 1);

-- ----------------------------
-- Table structure for ms_user_atlas
-- ----------------------------
DROP TABLE IF EXISTS `ms_user_atlas`;
CREATE TABLE `ms_user_atlas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '图集标题',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `add_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员自定义相册表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_video
-- ----------------------------
DROP TABLE IF EXISTS `ms_video`;
CREATE TABLE `ms_video`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频标题',
  `info` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '说明',
  `short_info` varchar(90) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '短说明',
  `key_word` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '关键词',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '视频播放地址',
  `download_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '下载地址',
  `add_time` int(10) NOT NULL COMMENT '上传时间',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `play_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '视频时长',
  `click` int(11) DEFAULT 0 COMMENT '总点击量',
  `good` int(11) DEFAULT 0 COMMENT '总点赞数',
  `thumbnail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '缩略图',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '上传者id，管理员为0',
  `class` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '所属分类',
  `tag` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '所属标签',
  `status` int(2) NOT NULL DEFAULT 1 COMMENT '状态1为显示，0为隐藏',
  `type` tinyint(2) DEFAULT 0 COMMENT '视频集为1 单视频为0',
  `pid` int(11) DEFAULT 0 COMMENT '当是分集的时候存在该字段',
  `diversity_data` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '分集详情',
  `gold` int(11) DEFAULT 0 COMMENT '观看需要金币',
  `reco` int(1) DEFAULT 0 COMMENT '推荐星级',
  `sort` int(3) DEFAULT 0 COMMENT '视频分集序号',
  `is_check` int(1) DEFAULT 0 COMMENT '是否审核 。1审核通过，2审核未通过，0待审核',
  `hint` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '驳回原因',
  `img` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '视频截图',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_video_collection
-- ----------------------------
DROP TABLE IF EXISTS `ms_video_collection`;
CREATE TABLE `ms_video_collection`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0 COMMENT '用户id',
  `video_id` int(11) DEFAULT 0 COMMENT '视频id',
  `collection_time` int(10) DEFAULT 0 COMMENT '收藏时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频收藏表' ROW_FORMAT = Fixed;


-- ----------------------------
-- Table structure for ms_video_good_log
-- ----------------------------
DROP TABLE IF EXISTS `ms_video_good_log`;
CREATE TABLE `ms_video_good_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) DEFAULT NULL COMMENT '点赞的视频id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `add_time` int(10) DEFAULT NULL COMMENT '点赞时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频点赞记录表' ROW_FORMAT = Fixed;


-- ----------------------------
-- Table structure for ms_video_watch_log
-- ----------------------------
DROP TABLE IF EXISTS `ms_video_watch_log`;
CREATE TABLE `ms_video_watch_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) NOT NULL COMMENT '视频id',
  `user_id` int(11) DEFAULT 0 COMMENT '用户Id',
  `user_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0' COMMENT '用户ip',
  `gold` int(11) DEFAULT NULL COMMENT '消费金币数',
  `view_time` int(10) NOT NULL COMMENT '观看时间',
  `is_try_see` int(1) DEFAULT 0 COMMENT '是否为试看，1：试看',
  `is_myself` int(1) DEFAULT 0 COMMENT '是否为自己发布的视频,1:是,0:不是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频观看日志表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for ms_website_group_setting
-- ----------------------------
DROP TABLE IF EXISTS `ms_website_group_setting`;
CREATE TABLE `ms_website_group_setting`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT ' 序号',
  `domain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '域名',
  `logo_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '网站logo地址',
  `site_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '站点title',
  `site_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '站点keywords',
  `site_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '站点description',
  `add_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `site_logo_mobile` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '手机站logo地址',
  `friend_link` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '每行一条友情链接,单条规则：链接名称|网址,例：Msvodx|http://www.msvod.c',
  `site_statis` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '第三方流量统计代码，前台调用时请先用 htmlspecialchars_decode函数转义输出',
  `site_icp` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'icp备案号',
  `buy_cardpassword_uri` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '购买卡密网址',
  `close_pay` tinyint(1) DEFAULT NULL COMMENT '是否关闭支付',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '站群配置表' ROW_FORMAT = Dynamic;


SET FOREIGN_KEY_CHECKS = 1;