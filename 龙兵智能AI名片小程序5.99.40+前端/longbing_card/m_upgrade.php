<?php 
pdo_query("CREATE TABLE IF NOT EXISTS `ims_longbing_card_articles` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(100) NOT NULL   COMMENT '标题',
`cover` varchar(500) NOT NULL   COMMENT '封面图',
`view_count` int(10) NOT NULL   COMMENT '浏览量',
`top` int(10) NOT NULL   COMMENT '排序值',
`content` longtext(),
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`modular_id` int(5) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_boss` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`boss` varchar(2000) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_boss_cache` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`cache_key` varchar(200) NOT NULL,
`cache_data` text() NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_call` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`phone` varchar(20) NOT NULL,
`modular_id` int(5) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`top` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_chart` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`content` varchar(500) NOT NULL,
`uid` int(11) NOT NULL,
`other_uid` int(11) NOT NULL,
`is_read` tinyint(4) NOT NULL   COMMENT '1--已读  0--未读',
`kind` varchar(30) NOT NULL   COMMENT 'txt 文本 img 图片 vioce语音',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_chat` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '发起会话的用户id',
`target_id` int(10) NOT NULL   COMMENT '会话对象用户id',
`type` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '类型: 1=>one2one 2=>gourp',
`gourp_ids` text()    COMMENT '此群组中的用户id',
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_client_info` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户id',
`staff_id` int(10) NOT NULL   COMMENT '员工id',
`name` varchar(20) NOT NULL   COMMENT '姓名',
`sex` varchar(10) NOT NULL   COMMENT '性别',
`phone` varchar(20) NOT NULL   COMMENT '手机号',
`email` varchar(20) NOT NULL   COMMENT '邮箱',
`company` varchar(50) NOT NULL   COMMENT '公司',
`position` varchar(20) NOT NULL   COMMENT '职位',
`address` varchar(100) NOT NULL   COMMENT '详细地址',
`birthday` varchar(20) NOT NULL   COMMENT '生日',
`is_mask` varchar(3) NOT NULL   COMMENT '是否屏蔽',
`remark` varchar(500) NOT NULL   COMMENT '备注',
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_collection` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`uid` int(11) NOT NULL   COMMENT '当前用户id',
`to_uid` int(10) NOT NULL   COMMENT '被收藏人id (名片人id)',
`from_uid` int(10) NOT NULL   COMMENT '分享人id',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`scene` int(10) NOT NULL,
`status` int(5) NOT NULL DEFAULT NULL DEFAULT '1',
`is_qr` int(3) NOT NULL,
`openGId` varchar(100) NOT NULL,
`is_group` int(3) NOT NULL,
`type` int(3) NOT NULL,
`target_id` int(10) NOT NULL,
`handover_id` int(10) NOT NULL,
`handover_name` varchar(50) NOT NULL,
`distribution` int(3) NOT NULL   COMMENT '是否是后台分配的',
`is_auto` int(3) NOT NULL,
`intention` int(3) NOT NULL,
`rate` int(4) NOT NULL DEFAULT NULL DEFAULT '5',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_company` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`name` varchar(50) NOT NULL   COMMENT '公司名称',
`addr` varchar(100) NOT NULL   COMMENT '公司地址',
`logo` varchar(255) NOT NULL   COMMENT '公司logo',
`url` varchar(50) NOT NULL   COMMENT '公司网址',
`phone` varchar(100) NOT NULL   COMMENT '联系方式',
`desc` text() NOT NULL   COMMENT '商城背景图',
`culture` text() NOT NULL   COMMENT '官网轮播图',
`longitude` varchar(50) NOT NULL   COMMENT '经度',
`latitude` varchar(50) NOT NULL   COMMENT '纬度',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`short_name` varchar(100) NOT NULL,
`shop_name` varchar(50) NOT NULL,
`top` int(10) NOT NULL,
`pid` int(10) NOT NULL,
`auth_code` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_company_goods` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`company_id` int(10) NOT NULL   COMMENT '公司id',
`goods_id` int(10) NOT NULL   COMMENT '商品id',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_config` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`multi` int(11) NOT NULL   COMMENT '是否允许一个用户拥有多张名片',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`show_card` int(3) NOT NULL,
`copyright` varchar(200) NOT NULL,
`mini_template_id` varchar(200) NOT NULL,
`mini_app_name` varchar(20) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`allow_create` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_text` varchar(100) NOT NULL DEFAULT NULL DEFAULT '创建我的智能名片',
`logo_switch` int(3) NOT NULL,
`logo_text` varchar(100) NOT NULL,
`logo_phone` varchar(20) NOT NULL,
`notice_switch` int(3) NOT NULL,
`notice_i` int(10) NOT NULL,
`min_tmppid` varchar(200) NOT NULL,
`order_overtime` int(10) NOT NULL DEFAULT NULL DEFAULT '1800',
`collage_overtime` int(10) NOT NULL DEFAULT NULL DEFAULT '172800',
`force_phone` int(3) NOT NULL,
`staff_extract` int(3) NOT NULL,
`first_extract` int(3) NOT NULL,
`sec_extract` int(3) NOT NULL,
`code` varchar(20) NOT NULL,
`corpid` varchar(200) NOT NULL,
`corpsecret` varchar(200) NOT NULL,
`agentid` varchar(200) NOT NULL,
`wx_appid` varchar(100) NOT NULL,
`wx_tplid` varchar(100) NOT NULL,
`redis_pas` varchar(100) NOT NULL,
`cash_mini` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`admin_account` varchar(50) NOT NULL,
`plug_form` int(4) NOT NULL,
`btn_consult` varchar(20) NOT NULL DEFAULT NULL DEFAULT '咨询',
`btn_sale` varchar(20) NOT NULL DEFAULT NULL DEFAULT '销售管家',
`btn_code_err` varchar(200) NOT NULL DEFAULT NULL DEFAULT '免审口令填写错误',
`btn_code_miss` varchar(200) NOT NULL DEFAULT NULL DEFAULT '免审口令未填写',
`preview_switch` int(4) NOT NULL,
`btn_talk` varchar(20) NOT NULL DEFAULT NULL DEFAULT '面议',
`receiving` int(10) NOT NULL DEFAULT NULL DEFAULT '5',
`ios_pay` int(4) NOT NULL DEFAULT NULL DEFAULT '1',
`android_pay` int(4) NOT NULL DEFAULT NULL DEFAULT '1',
`self_text` varchar(200) NOT NULL DEFAULT NULL DEFAULT '自提商品',
`default_video` varchar(200) NOT NULL,
`default_voice` varchar(200) NOT NULL,
`card_type` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`order_pwd` varchar(40) NOT NULL,
`exchange_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`motto_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`default_voice_switch` int(3) NOT NULL,
`myshop_switch` int(3) NOT NULL,
`aliyun_sms_access_key_id` varchar(50) NOT NULL,
`aliyun_sms_access_key_secret` varchar(50) NOT NULL,
`default_shop_name` varchar(500) NOT NULL   COMMENT '默认商城名称',
`default_shop_pic` varchar(500) NOT NULL   COMMENT '默认商城背景图',
`default_video_cover` varchar(500) NOT NULL   COMMENT '视频默认封面图',
`appoint_pic` varchar(500) NOT NULL   COMMENT '预约背景图',
`appoint_name` varchar(500) NOT NULL   COMMENT '预约标题',
`click_copy_way` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '点击版权效果 1 => 拨打电话 2 => 跳转网页 3 => 跳转小程序 4 => 查看大图',
`click_copy_show_img` varchar(500) NOT NULL   COMMENT '当点击版权效果是查看大图时, 弹出此图片',
`click_copy_content` varchar(500) NOT NULL   COMMENT '点击版权效果 手机号 网址 appid',
`question_switch` int(3) NOT NULL   COMMENT '是否开启问卷功能',
`question_text` varchar(200) NOT NULL DEFAULT NULL DEFAULT '问卷'  COMMENT '问卷文字',
`shop_version` int(3) NOT NULL,
`shop_carousel_more` varchar(300) NOT NULL,
`exchange_btn` varchar(40) NOT NULL DEFAULT NULL DEFAULT '交换手机号',
`my_shop_limit` int(10) NOT NULL,
`autograph` int(11) NOT NULL,
`signature` int(11) NOT NULL,
`vr_tittle` varchar(50) NOT NULL DEFAULT NULL DEFAULT 'VR全景',
`vr_cover` varchar(300) NOT NULL,
`vr_path` varchar(300) NOT NULL,
`vr_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`qr_avatar_switch` int(3) NOT NULL,
`auto_switch` int(3) NOT NULL   COMMENT '自动分配员工开关',
`auto_switch_way` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '自动分配推荐员工方式',
`coupon_pass` int(11) NOT NULL   COMMENT '线下福包核销密码',
`job_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_contact` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`name1` varchar(30) NOT NULL   COMMENT '联系人',
`phone1` varchar(30) NOT NULL   COMMENT '联系方式',
`name2` varchar(30) NOT NULL   COMMENT '联系人',
`phone2` varchar(30) NOT NULL   COMMENT '联系方式',
`name3` varchar(30) NOT NULL   COMMENT '联系人',
`phone3` varchar(30) NOT NULL   COMMENT '联系方式',
`address` varchar(100) NOT NULL   COMMENT '详细地址',
`longitude` varchar(30) NOT NULL   COMMENT '经度',
`latitude` varchar(30) NOT NULL   COMMENT '纬度',
`content` text(),
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`modular_id` int(5) NOT NULL,
`show_map` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`show_map_desc` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_copy_count` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`to_uid` int(10) NOT NULL,
`type` int(3) NOT NULL   COMMENT '鎿嶄綔鍐呭, 1=>鍚屾鍒伴€氳褰?2=>鎷ㄦ墦鎵嬫満鍙?3=>鎷ㄦ墦搴ф満鍙?4=>澶嶅埗寰俊 5=>澶嶅埗閭 6=>澶嶅埗鍏徃鍚?7=>鏌ョ湅瀹氫綅',
`target` varchar(200) NOT NULL,
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_count` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`to_uid` int(10) NOT NULL,
`type` int(3) NOT NULL   COMMENT '浏览内容,sign=view时 1=>浏览商城列表 2=>浏览商品详情 3=>浏览动态列表 4=>点赞动态 5=>动态留言 6=>浏览公司官网 7=>浏览动态详情  sign=copy时 1=>同步到通讯录 2=>拨打手机号 3=>拨打座机号 4=>复制微信 5=>复制邮箱 6=>复制公司名 7=>查看定位 8=>咨询产品 9=>播放语音  当sign=praise时 1 语音点赞 2 人气(查看),3 点赞   4 分享',
`sign` varchar(10) NOT NULL,
`target` varchar(200) NOT NULL,
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`scene` int(10) NOT NULL,
`unread` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_coupon` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(500) NOT NULL   COMMENT '标题',
`type` int(10) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '优惠券类型 1 => 线上; 2 => 线下',
`company_id` int(5) NOT NULL,
`full` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '满',
`reduce` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '减',
`number` int(10) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '人数',
`top` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`end_time` int(11) NOT NULL,
`limit_type` int(11) NOT NULL   COMMENT '限制类型0：不限制；1：分类，2：商品',
`limit_goods` text() NOT NULL   COMMENT '限制商品',
`limit_cate` varchar(225) NOT NULL   COMMENT '限制分类',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_coupon_record` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户id',
`staff_id` int(10) NOT NULL   COMMENT '员工id',
`coupon_id` int(10) NOT NULL   COMMENT '福包id',
`title` varchar(500) NOT NULL   COMMENT '标题',
`type` int(10) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '优惠券类型 1 => 线上; 2 => 线下',
`company_id` int(5) NOT NULL,
`full` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '满',
`reduce` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '减',
`end_time` int(11) NOT NULL   COMMENT '过期时间',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`desc_coupon` varchar(500) NOT NULL,
`limit_type` int(11) NOT NULL   COMMENT '限制类型',
`limit_cate` varchar(255) NOT NULL   COMMENT '限用分类',
`limit_goods` text() NOT NULL   COMMENT '限用商品',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_culture` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`content` text(),
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`modular_id` int(5) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_custom_qr` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '员工id',
`title` varchar(100) NOT NULL   COMMENT '自定义码标题',
`content` varchar(1000) NOT NULL   COMMENT '自定义码内容',
`path` varchar(200) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_custom_qr_record` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户id',
`staff_id` int(10) NOT NULL   COMMENT '员工id',
`qr_id` int(10) NOT NULL   COMMENT '自定义码id',
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_date` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`staff_id` int(10) NOT NULL,
`date` varchar(20) NOT NULL,
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_desc` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`content` longtext(),
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`modular_id` int(5) NOT NULL,
`introduction` longtext(),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_extension` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '员工id',
`goods_id` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_form` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`name` varchar(200) NOT NULL,
`phone` varchar(200) NOT NULL,
`content` varchar(2000) NOT NULL,
`bac1` varchar(2000) NOT NULL,
`bac2` varchar(2000) NOT NULL,
`bac3` varchar(2000) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`modular_id` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_formId` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`formId` varchar(100) NOT NULL,
`status` int(3) NOT NULL   COMMENT '1=>未使用过 2=>使用过',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_forward` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户转发人的id',
`staff_id` int(10) NOT NULL   COMMENT '员工id',
`type` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1=>转发名片 2=>转发商品 3=>转发动态 4=>转发公司官网',
`target_id` int(10) NOT NULL   COMMENT '转发内容的id 当type=2,3时有效',
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_goods` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`name` varchar(50) NOT NULL   COMMENT '商品名',
`cover` varchar(500) NOT NULL   COMMENT '商品封面图',
`images` varchar(5000) NOT NULL   COMMENT '商品轮播图',
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`view_count` int(10) NOT NULL   COMMENT '商品浏览量',
`sale_count` int(10) NOT NULL   COMMENT '商品销售量',
`desc` varchar(500) NOT NULL   COMMENT '商品简介',
`content` longtext(),
`top` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`type` int(10) NOT NULL,
`collage_count` int(10) NOT NULL,
`is_collage` int(10) NOT NULL,
`freight` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`recommend` int(3) NOT NULL,
`stock` int(10) NOT NULL,
`type_p` int(10) NOT NULL,
`image_url` varchar(2000) NOT NULL,
`unit` varchar(100) NOT NULL DEFAULT NULL DEFAULT '个',
`is_self` int(4) NOT NULL,
`extract` int(10) NOT NULL,
`s_title` varchar(500) NOT NULL   COMMENT '副标题',
`switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`staff_switch` int(3) NOT NULL,
`staff_extract` int(11) NOT NULL,
`company_id` varchar(256) NOT NULL   COMMENT '所属公司id',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_goods_collection` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(11) NOT NULL   COMMENT '用户的fans_id',
`goods_id` int(11) NOT NULL   COMMENT '商品id',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_group_number` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`staff_id` int(10) NOT NULL,
`openGId` varchar(100) NOT NULL,
`number` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_group_sending` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`content` varchar(2000) NOT NULL,
`type` int(10) NOT NULL,
`staff_id` int(10) NOT NULL,
`remark` varchar(200) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_handover` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`old_id` int(10) NOT NULL   COMMENT '员工id',
`new_id` int(10) NOT NULL   COMMENT '员工id',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_house` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`create_time` int(11),
`update_time` int(11),
`status` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1-正常  0-下架   -1 假删除',
`title` varchar(50) NOT NULL   COMMENT '房源标题',
`category` int(11) NOT NULL   COMMENT '分类',
`imgs` varchar(700) NOT NULL   COMMENT '图集',
`video_cover` varchar(300) NOT NULL   COMMENT '视频封面',
`video` varchar(300) NOT NULL   COMMENT '视频资源',
`labels` varchar(100) NOT NULL   COMMENT '标签，用英文逗号隔开',
`longitude` varchar(30) NOT NULL,
`latitude` varchar(30) NOT NULL,
`attrs` varchar(300) NOT NULL   COMMENT '房源属性，json字符串',
`community_attrs` varchar(300) NOT NULL   COMMENT '小区属性json字符串',
`community_info` varchar(1000) NOT NULL   COMMENT '小区信息',
`top` int(11) NOT NULL   COMMENT '排序',
`price` double(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '单位（万）售价-从属性中单独拿出来 做筛选',
`huxing_id` int(11) NOT NULL   COMMENT '户型id',
`area_id` int(11) NOT NULL   COMMENT '区域Id',
`vr_cover` varchar(300) NOT NULL,
`vr_path` varchar(300) NOT NULL,
`address` varchar(255) NOT NULL   COMMENT '长地址',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_house_ad` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`status` char(2) NOT NULL DEFAULT NULL DEFAULT '1',
`type` char(2) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1-房源首页',
`path` varchar(255) NOT NULL   COMMENT '图片',
`link` varchar(255) NOT NULL   COMMENT '跳转',
`link_type` char(2) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '跳转类型 1-电话 2小程序  3网页  4-内部页面',
`top` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_house_appointment` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`uid` int(11) NOT NULL,
`to_uid` int(11) NOT NULL,
`house_id` int(11) NOT NULL,
`date` int(11) NOT NULL   COMMENT '预约时间 时间戳',
`status` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`contact` varchar(30) NOT NULL   COMMENT '联系人',
`tel` varchar(30) NOT NULL   COMMENT '联系电话',
`avatar` varchar(400) NOT NULL   COMMENT '头像',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_house_area` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`status` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1',
`title` varchar(255) NOT NULL,
`sort` int(11) NOT NULL,
`pid` int(11) NOT NULL,
`level` tinyint(2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_house_category` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(40) NOT NULL   COMMENT '分类名',
`uniacid` int(10) NOT NULL,
`top` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`img` varchar(500) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_house_collect` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`uid` int(11) NOT NULL,
`house_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_house_huxing` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`title` varchar(30) NOT NULL   COMMENT '户型',
`sort` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_house_price` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`title` varchar(30) NOT NULL   COMMENT '价格区间显示标题',
`value` varchar(30) NOT NULL   COMMENT '实际代表的值',
`sort` int(11) NOT NULL   COMMENT '排序',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_job` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`name` varchar(50) NOT NULL   COMMENT '名称',
`status` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`top` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_jobs` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(100) NOT NULL   COMMENT '招聘职位',
`money` varchar(20) NOT NULL   COMMENT '薪资',
`experience` varchar(20) NOT NULL   COMMENT '经验',
`education` varchar(20) NOT NULL   COMMENT '学历',
`top` int(10) NOT NULL,
`content` text(),
`phone` varchar(20) NOT NULL   COMMENT 'hr电话',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`modular_id` int(5) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_key` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`domain_keys` text()    COMMENT '域名秘钥',
`domain_name` varchar(100) NOT NULL   COMMENT '域名',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`domain_id` varchar(50) NOT NULL,
`website_id` varchar(100)    COMMENT '站点id',
`website_keys` text()    COMMENT '站点秘钥',
`version_id` char(32) NOT NULL,
`branch_id` char(32) NOT NULL,
`version_name` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_label` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`name` varchar(20) NOT NULL   COMMENT '标签',
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_message` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`chat_id` int(10) NOT NULL   COMMENT '会话记录表id',
`user_id` int(10) NOT NULL   COMMENT '发送消息用户id',
`target_id` int(10) NOT NULL   COMMENT '接收消息用户id',
`content` text()    COMMENT '消息内容',
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1=>未读消息 2=>已读 3=>已撤销 4=>已删除',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`message_type` varchar(50) NOT NULL DEFAULT NULL DEFAULT 'text',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_mini` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`mini` varchar(100) NOT NULL,
`modular_id` int(5) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`top` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_modular` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`name` varchar(100) NOT NULL   COMMENT '模块名',
`show_name` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '前台是否显示模块名',
`cover` varchar(500) NOT NULL   COMMENT '图标',
`identification` varchar(20) NOT NULL   COMMENT '模块标识',
`table_name` varchar(200) NOT NULL   COMMENT '表名',
`type` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1=>文章列表, 2=>图文详情, 3=>招聘信息, 4=>联系我们, 5=>员工展示',
`top` int(10) NOT NULL   COMMENT '排序值',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`show_top` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`show_more` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`show` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`remark` varchar(100) NOT NULL,
`list_limit` int(3) NOT NULL DEFAULT NULL DEFAULT '3',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_pages` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(20) NOT NULL,
`page` varchar(200) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_plug_form` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户id',
`to_uid` int(10) NOT NULL   COMMENT '名片id',
`name` varchar(50) NOT NULL,
`phone` varchar(50) NOT NULL,
`content` varchar(500) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_poster` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(500) NOT NULL   COMMENT '标题',
`img` varchar(500) NOT NULL   COMMENT '海报链接',
`type_id` int(10) NOT NULL,
`company_id` int(5) NOT NULL,
`top` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`cover` varchar(300) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_poster_type` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(500) NOT NULL   COMMENT '标题',
`company_id` int(5) NOT NULL,
`top` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_praise` (
`id` int(20) NOT NULL  AUTO_INCREMENT,
`uid` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`to_uid` int(11) NOT NULL   COMMENT '被点赞者id',
`type` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '类型  1 语音点赞 2 人气(查看),3 点赞   4 分享',
`create_time` int(11),
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_qn_answer` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`q_id` int(10) NOT NULL   COMMENT '问题id',
`user_id` int(10) NOT NULL   COMMENT '用户id',
`staff_id` int(10) NOT NULL   COMMENT '员工id',
`answer` varchar(300) NOT NULL   COMMENT '答案',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_qn_question` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`naire_id` int(10) NOT NULL   COMMENT '问卷id',
`title` varchar(100) NOT NULL   COMMENT '问卷名称',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_qn_questionnaire` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(100) NOT NULL   COMMENT '问卷名称',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_quick_reply` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`content` text(),
`number` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`type` int(3) NOT NULL,
`top` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_radar_msg` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`sign` varchar(200) NOT NULL,
`type` int(3) NOT NULL,
`mini` int(10) NOT NULL   COMMENT '发送激励提醒最小取值',
`max` int(10) NOT NULL   COMMENT '发送激励提醒最大取值',
`pid` int(10) NOT NULL,
`msg` varchar(100) NOT NULL   COMMENT '发送激励提醒内容',
`operation` varchar(100) NOT NULL   COMMENT '客户操作',
`item` varchar(100) NOT NULL   COMMENT '客户操作的内容',
`show_count` int(3) NOT NULL   COMMENT '是否展示第几次',
`table_name` varchar(100) NOT NULL   COMMENT '对象表名',
`field` varchar(100) NOT NULL   COMMENT '数据表中的字段，多个字段用英文逗号隔开',
`send` int(3) NOT NULL   COMMENT '是否发送通知 0 = 不发送，1 = 员工，2 = 客户，3 = 员工和客户',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_rate` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`staff_id` int(10) NOT NULL,
`rate` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_reply_type` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(20) NOT NULL,
`top` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_selling_cash_water` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户id',
`account` varchar(50) NOT NULL,
`money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '提现金额',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`cash_no` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_selling_profit` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户id',
`total_profit` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '总收益',
`total_postal` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '总提现',
`postaling` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '提现中',
`waiting` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`profit` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_selling_water` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户id',
`source_id` int(10) NOT NULL   COMMENT '来源用户id',
`order_id` int(10) NOT NULL   COMMENT '订单id',
`type` int(10) NOT NULL   COMMENT '类型 1=>员工提成；2=>一级上线提成；3=>二级上线提成',
`title` varchar(100) NOT NULL,
`img` varchar(500) NOT NULL,
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '售价',
`extract` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '提成百分比',
`waiting` int(10) NOT NULL   COMMENT '1=>未入账',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`goods_id` int(10) NOT NULL,
`buy_number` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_share_group` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '员工id',
`openGId` varchar(100) NOT NULL   COMMENT '群对当前小程序的唯一 ID',
`view_card` int(10) NOT NULL   COMMENT '浏览名片的次数',
`view_custom_qr` varchar(1000) NOT NULL   COMMENT '浏览自定义码集合',
`view_goods` varchar(1000) NOT NULL   COMMENT '浏览商品集合',
`view_timeline` varchar(1000) NOT NULL   COMMENT '浏览商品集合',
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`client_id` int(10) NOT NULL,
`target_id` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_address` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`name` varchar(30) NOT NULL,
`sex` varchar(30) NOT NULL,
`phone` varchar(30) NOT NULL,
`address` varchar(50) NOT NULL,
`address_detail` varchar(100) NOT NULL,
`province` varchar(30) NOT NULL,
`city` varchar(30) NOT NULL,
`area` varchar(30) NOT NULL,
`uniacid` int(10) NOT NULL,
`is_default` int(3) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_carousel` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`c_id` int(10) NOT NULL   COMMENT '公司id',
`img` varchar(300) NOT NULL   COMMENT '图片地址',
`top` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_collage` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`goods_id` int(10) NOT NULL,
`spe_price_id` int(10) NOT NULL,
`number` int(10) NOT NULL,
`people` int(10) NOT NULL DEFAULT NULL DEFAULT '2',
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`limit` int(3) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_collage_list` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '发起拼团人',
`goods_id` int(10) NOT NULL,
`collage_id` int(10) NOT NULL   COMMENT '拼团条件id',
`name` varchar(30) NOT NULL,
`cover` varchar(200) NOT NULL,
`number` int(10) NOT NULL   COMMENT '拼团人数',
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '单价',
`collage_status` int(3) NOT NULL   COMMENT '拼团状态 0=>未支付; 1=>拼团中; 2=>拼团人满; 3=>拼团完成; 4=>拼团失败',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`left_number` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_order` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`address_id` int(10) NOT NULL,
`pay_status` int(3) NOT NULL   COMMENT '支付状态 0=>未支付; 1=>已支付; 2=>已退款',
`order_status` int(3) NOT NULL   COMMENT '订单状态 0=>未完成; 1=>已取消 2=>已发货; 3=>已完成; 4=>已评价',
`type` int(3) NOT NULL   COMMENT '订单类型 0=>普通订单; 1=>拼团订单',
`collage_id` int(3) NOT NULL   COMMENT '拼团记录id',
`freight` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`total_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`out_trade_no` varchar(50) NOT NULL,
`courier_number` varchar(50) NOT NULL   COMMENT '快递单号',
`name` varchar(30) NOT NULL,
`sex` varchar(30) NOT NULL,
`phone` varchar(30) NOT NULL,
`address` varchar(50) NOT NULL,
`address_detail` varchar(100) NOT NULL,
`province` varchar(30) NOT NULL,
`city` varchar(30) NOT NULL,
`area` varchar(30) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`to_uid` int(10) NOT NULL,
`out_refund_no` varchar(50) NOT NULL,
`express_company` varchar(50) NOT NULL,
`express_phone` varchar(50) NOT NULL,
`record_id` int(10) NOT NULL,
`record_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`transaction_id` varchar(100) NOT NULL,
`write_off_id` int(10) NOT NULL,
`refund_status` int(3) NOT NULL,
`company_id` int(10) NOT NULL,
`zt_name` varchar(30) NOT NULL   COMMENT '自提订单的客户姓名',
`zt_phone` varchar(30) NOT NULL   COMMENT '自提订单的客户联系方式',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_order_item` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`order_id` int(10) NOT NULL,
`goods_id` int(10) NOT NULL,
`name` varchar(30) NOT NULL,
`cover` varchar(200) NOT NULL,
`spe_price_id` int(10) NOT NULL,
`content` varchar(50) NOT NULL,
`number` int(10) NOT NULL,
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_order_refund` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`order_id` int(10) NOT NULL   COMMENT '订单id',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1 => 退款中, 2 => 已退款, 3 => 已拒绝',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_search` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`keyword` varchar(30) NOT NULL,
`number` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_spe` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`goods_id` int(10) NOT NULL,
`title` varchar(20) NOT NULL   COMMENT '规格名',
`pid` int(10) NOT NULL   COMMENT '0=>顶级规格;其他=>上级规格id',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_spe_price` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`goods_id` int(10) NOT NULL,
`spe_id_1` varchar(100) NOT NULL,
`spe_id_2` varchar(100) NOT NULL,
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`stock` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_standard` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`goods_id` int(10) NOT NULL,
`title` varchar(30) NOT NULL,
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`stock` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_trolley` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`goods_id` int(10) NOT NULL,
`user_id` int(10) NOT NULL,
`name` varchar(30) NOT NULL,
`cover` varchar(200) NOT NULL,
`spe_price_id` int(10) NOT NULL,
`content` varchar(50) NOT NULL,
`number` int(10) NOT NULL,
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`freight` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_type` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(20) NOT NULL   COMMENT '分类名',
`cover` varchar(200) NOT NULL,
`pid` int(10) NOT NULL   COMMENT '0=>顶级分类;其他=>上级分类id',
`top` int(10) NOT NULL   COMMENT '排序值, 倒序',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_shop_user_collage` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '发起拼团人',
`collage_id` int(10) NOT NULL   COMMENT '拼团条件id',
`collage_status` int(3) NOT NULL   COMMENT '拼团状态 0=>未支付; 1=>拼团中; 2=>拼团人满; 3=>拼团完成; 4=>拼团失败',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_staffs` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`name` varchar(100) NOT NULL   COMMENT '标题',
`cover` varchar(500) NOT NULL   COMMENT '头像',
`job` varchar(20) NOT NULL   COMMENT '职位',
`experience1` varchar(100) NOT NULL   COMMENT '经历1',
`experience2` varchar(100) NOT NULL   COMMENT '经历2',
`experience3` varchar(100) NOT NULL   COMMENT '经历3',
`top` int(10) NOT NULL   COMMENT '排序值',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`modular_id` int(5) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_start` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户id',
`staff_id` int(10) NOT NULL   COMMENT '员工id',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_tabbar` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`menu1_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '名片',
`menu2_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '商城',
`menu3_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '动态',
`menu4_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '官网',
`menu1_is_hide` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`menu2_is_hide` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`menu3_is_hide` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`menu4_is_hide` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`menu1_url` varchar(500) NOT NULL,
`menu2_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT 'longbing_card/pages/index/index?currentTabBar=toShop',
`menu3_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT 'longbing_card/pages/index/index?currentTabBar=toNews',
`menu4_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT 'longbing_card/pages/index/index?currentTabBar=toCompany',
`menu1_url_out` varchar(500) NOT NULL,
`menu2_url_out` varchar(500) NOT NULL,
`menu3_url_out` varchar(500) NOT NULL,
`menu4_url_out` varchar(500) NOT NULL,
`menu1_url_jump_way` int(3) NOT NULL,
`menu2_url_jump_way` int(3) NOT NULL,
`menu3_url_jump_way` int(3) NOT NULL,
`menu4_url_jump_way` int(3) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`menu_appoint_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '预约',
`menu_appoint_is_hide` int(10) NOT NULL DEFAULT NULL DEFAULT '1',
`menu_appoint_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT '/longbing_card/reserve/pages/index/index',
`menu_appoint_url_out` varchar(500) NOT NULL,
`menu_appoint_url_jump_way` int(3) NOT NULL,
`menu_activity_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '活动报名',
`menu_activity_is_show` int(10) NOT NULL,
`menu_activity_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT '/longbing_card/enroll/pages/index',
`menu_activity_url_out` varchar(500) NOT NULL,
`menu_activity_url_jump_way` int(3) NOT NULL,
`menu_house_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '房产',
`menu_house_is_show` int(2) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '是否展示',
`menu_house_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT '/longbing_card/house/pages/index/index',
`menu_house_url_out` varchar(500) NOT NULL,
`menu_house_url_jump_way` int(2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_tags` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户id',
`tag` varchar(50) NOT NULL,
`count` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`top` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_timeline` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(100) NOT NULL   COMMENT '标题',
`cover` varchar(5000) NOT NULL,
`content` longtext(),
`top` int(10) NOT NULL   COMMENT '排序值',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`user_id` int(10) NOT NULL,
`type` int(3) NOT NULL,
`url_type` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`article_id` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_timeline_comment` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`timeline_id` int(10) NOT NULL,
`content` varchar(1000) NOT NULL   COMMENT '鍐呭',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_timeline_thumbs` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`timeline_id` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_user` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`openid` varchar(100) NOT NULL,
`nickName` varchar(100) NOT NULL,
`avatarUrl` varchar(300) NOT NULL,
`pid` int(10) NOT NULL   COMMENT '上级id',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`is_staff` tinyint(4) NOT NULL   COMMENT '是否是公司员工  1 是否 0 不是',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`is_qr` int(3) NOT NULL,
`is_group` int(3) NOT NULL,
`type` int(3) NOT NULL,
`target_id` int(10) NOT NULL,
`scene` int(10) NOT NULL,
`openGId` varchar(50) NOT NULL,
`qr_path` varchar(200) NOT NULL,
`is_boss` int(3) NOT NULL,
`create_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`ip` varchar(50) NOT NULL,
`import` int(3) NOT NULL   COMMENT '是否是后台导入',
`pay_qr` varchar(300) NOT NULL,
`unionid` varchar(40) NOT NULL,
`is_article` int(3) NOT NULL,
`lock_id` int(10) NOT NULL,
`city` varchar(30) NOT NULL,
`province` varchar(30) NOT NULL,
`country` varchar(30) NOT NULL,
`gender` int(3) NOT NULL,
`language` varchar(30) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_user_follow` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`staff_id` int(10) NOT NULL,
`content` varchar(200) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`type` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_user_info` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`fans_id` int(11) NOT NULL   COMMENT '对应ims_mc_mapping_fans 表id',
`is_staff` tinyint(2) NOT NULL   COMMENT '是否是公司员工  1 是 0 不是',
`name` varchar(50) NOT NULL   COMMENT '员工名字',
`avatar` varchar(255) NOT NULL   COMMENT '头像',
`job_id` int(11) NOT NULL   COMMENT '职位id',
`company_id` int(11) NOT NULL   COMMENT '公司id',
`phone` varchar(20) NOT NULL   COMMENT '手机号',
`wechat` varchar(50) NOT NULL   COMMENT '微信',
`telephone` varchar(20) NOT NULL   COMMENT '电话',
`email` varchar(50) NOT NULL   COMMENT '邮箱',
`voice` varchar(500)    COMMENT '语音介绍',
`voice_time` int(10) NOT NULL   COMMENT '语音长短',
`desc` varchar(255) NOT NULL   COMMENT '个性签名',
`images` text(),
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`update_time` int(11) NOT NULL,
`create_time` int(11) NOT NULL,
`is_default` int(3) NOT NULL,
`top` int(5) NOT NULL,
`my_url` varchar(300) NOT NULL,
`my_video` varchar(300) NOT NULL,
`card_type` varchar(50) NOT NULL DEFAULT NULL DEFAULT 'cardType1',
`my_video_cover` varchar(500) NOT NULL,
`share_text` varchar(2000) NOT NULL,
`t_number` int(10) NOT NULL,
`view_number` int(10) NOT NULL,
`phone400` varchar(20) NOT NULL,
`ww_account` varchar(200) NOT NULL,
`bg` varchar(200) NOT NULL,
`bg_switch` int(4) NOT NULL,
`autograph` int(11) NOT NULL,
`signature` int(11) NOT NULL,
`vr_tittle` varchar(50) NOT NULL DEFAULT NULL DEFAULT 'VR全景',
`vr_cover` varchar(300) NOT NULL,
`vr_path` varchar(300) NOT NULL,
`vr_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`auto_count` int(3) NOT NULL,
`share_number` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_user_label` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户id',
`staff_id` int(10) NOT NULL   COMMENT '员工id',
`lable_id` int(10) NOT NULL   COMMENT '标签id',
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_user_mark` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户转发人的id',
`staff_id` int(10) NOT NULL   COMMENT '员工id',
`mark` int(3) NOT NULL   COMMENT '1=>跟进中,2=>已成交',
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_user_phone` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '发起会话的用户id',
`to_uid` int(10) NOT NULL,
`phone` varchar(20) NOT NULL   COMMENT '手机号',
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_user_poster` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`title` varchar(500) NOT NULL   COMMENT '标题',
`img` varchar(500) NOT NULL   COMMENT '海报链接',
`user_id` int(10) NOT NULL,
`top` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_user_shop` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`goods_id` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_user_sk` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`sk` varchar(500) NOT NULL   COMMENT '标题',
`user_id` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_user_tags` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '用户id',
`tag_id` varchar(50) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_v2_standard` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`goods_id` int(10) NOT NULL,
`title` varchar(50) NOT NULL,
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`stock` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_value` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`staff_id` int(10) NOT NULL,
`client` int(10) NOT NULL,
`charm` int(10) NOT NULL,
`interaction` int(10) NOT NULL,
`product` int(10) NOT NULL,
`website` int(10) NOT NULL,
`active` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_video` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`cover` varchar(500) NOT NULL   COMMENT '视频封面图',
`title` varchar(500) NOT NULL   COMMENT '标题',
`video` varchar(500) NOT NULL   COMMENT '视频链接',
`modular_id` int(5) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`top` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_view_count` (
`id` int(20) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`to_uid` int(10) NOT NULL,
`type` int(3) NOT NULL   COMMENT '浏览内容, 1=>浏览商城列表 2=>浏览商品详情 3=>浏览动态列表 4=>点赞动态 5=>动态留言 6=>浏览公司官网 7=>浏览动态详情',
`target` varchar(200) NOT NULL,
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_card_web` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`web` varchar(300) NOT NULL,
`modular_id` int(5) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`top` int(10) NOT NULL,
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_cardauth2_activity` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`modular_id` int(10) NOT NULL,
`sign` int(10) NOT NULL,
`count` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_cardauth2_article` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`modular_id` int(10) NOT NULL,
`number` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_cardauth2_boss` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`modular_id` int(10) NOT NULL,
`sign` int(10) NOT NULL,
`count` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_cardauth2_config` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`modular_id` int(10) NOT NULL   COMMENT '模块id',
`number` int(10) NOT NULL   COMMENT '限制创建名片的数量',
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`remark` varchar(200) NOT NULL,
`end_time` int(10) NOT NULL,
`mini_name` varchar(100) NOT NULL,
`copyright_id` int(10) NOT NULL,
`send_switch` int(3) NOT NULL,
`boos` int(10) NOT NULL,
`appoint` int(3) NOT NULL,
`payqr` int(3) NOT NULL,
`shop_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`timeline_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`website_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`article` int(3) NOT NULL,
`activity_switch` int(3) NOT NULL,
`pay_shop` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`house_switch` int(3) NOT NULL,
`tool_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_cardauth2_copyright` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
`image` varchar(300) NOT NULL,
`text` varchar(50) NOT NULL,
`phone` varchar(20) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_cardauth2_default` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`card_number` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`send_switch` int(3) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longbing_cardauth2_house` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`modular_id` int(10) NOT NULL,
`sign` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`status` int(3) NOT NULL DEFAULT NULL DEFAULT '1',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`count` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if(pdo_tableexists('longbing_card_articles')) {
 if(!pdo_fieldexists('longbing_card_articles',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_articles')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_articles')) {
 if(!pdo_fieldexists('longbing_card_articles',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_articles')." ADD `title` varchar(100) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('longbing_card_articles')) {
 if(!pdo_fieldexists('longbing_card_articles',  'cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_articles')." ADD `cover` varchar(500) NOT NULL   COMMENT '封面图';");
 }
}
if(pdo_tableexists('longbing_card_articles')) {
 if(!pdo_fieldexists('longbing_card_articles',  'view_count')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_articles')." ADD `view_count` int(10) NOT NULL   COMMENT '浏览量';");
 }
}
if(pdo_tableexists('longbing_card_articles')) {
 if(!pdo_fieldexists('longbing_card_articles',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_articles')." ADD `top` int(10) NOT NULL   COMMENT '排序值';");
 }
}
if(pdo_tableexists('longbing_card_articles')) {
 if(!pdo_fieldexists('longbing_card_articles',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_articles')." ADD `content` longtext();");
 }
}
if(pdo_tableexists('longbing_card_articles')) {
 if(!pdo_fieldexists('longbing_card_articles',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_articles')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_articles')) {
 if(!pdo_fieldexists('longbing_card_articles',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_articles')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_articles')) {
 if(!pdo_fieldexists('longbing_card_articles',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_articles')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_articles')) {
 if(!pdo_fieldexists('longbing_card_articles',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_articles')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_articles')) {
 if(!pdo_fieldexists('longbing_card_articles',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_articles')." ADD `modular_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_boss')) {
 if(!pdo_fieldexists('longbing_card_boss',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_boss')) {
 if(!pdo_fieldexists('longbing_card_boss',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_boss')) {
 if(!pdo_fieldexists('longbing_card_boss',  'boss')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss')." ADD `boss` varchar(2000) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_boss')) {
 if(!pdo_fieldexists('longbing_card_boss',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_boss')) {
 if(!pdo_fieldexists('longbing_card_boss',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_boss')) {
 if(!pdo_fieldexists('longbing_card_boss',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_boss')) {
 if(!pdo_fieldexists('longbing_card_boss',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_boss_cache')) {
 if(!pdo_fieldexists('longbing_card_boss_cache',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss_cache')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_boss_cache')) {
 if(!pdo_fieldexists('longbing_card_boss_cache',  'cache_key')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss_cache')." ADD `cache_key` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_boss_cache')) {
 if(!pdo_fieldexists('longbing_card_boss_cache',  'cache_data')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss_cache')." ADD `cache_data` text() NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_boss_cache')) {
 if(!pdo_fieldexists('longbing_card_boss_cache',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss_cache')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_boss_cache')) {
 if(!pdo_fieldexists('longbing_card_boss_cache',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss_cache')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_boss_cache')) {
 if(!pdo_fieldexists('longbing_card_boss_cache',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss_cache')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_boss_cache')) {
 if(!pdo_fieldexists('longbing_card_boss_cache',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_boss_cache')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_call')) {
 if(!pdo_fieldexists('longbing_card_call',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_call')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_call')) {
 if(!pdo_fieldexists('longbing_card_call',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_call')." ADD `phone` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_call')) {
 if(!pdo_fieldexists('longbing_card_call',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_call')." ADD `modular_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_call')) {
 if(!pdo_fieldexists('longbing_card_call',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_call')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_call')) {
 if(!pdo_fieldexists('longbing_card_call',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_call')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_call')) {
 if(!pdo_fieldexists('longbing_card_call',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_call')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_call')) {
 if(!pdo_fieldexists('longbing_card_call',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_call')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_call')) {
 if(!pdo_fieldexists('longbing_card_call',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_call')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_chart')) {
 if(!pdo_fieldexists('longbing_card_chart',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chart')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_chart')) {
 if(!pdo_fieldexists('longbing_card_chart',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chart')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_chart')) {
 if(!pdo_fieldexists('longbing_card_chart',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chart')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_chart')) {
 if(!pdo_fieldexists('longbing_card_chart',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chart')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_chart')) {
 if(!pdo_fieldexists('longbing_card_chart',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chart')." ADD `content` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_chart')) {
 if(!pdo_fieldexists('longbing_card_chart',  'uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chart')." ADD `uid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_chart')) {
 if(!pdo_fieldexists('longbing_card_chart',  'other_uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chart')." ADD `other_uid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_chart')) {
 if(!pdo_fieldexists('longbing_card_chart',  'is_read')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chart')." ADD `is_read` tinyint(4) NOT NULL   COMMENT '1--已读  0--未读';");
 }
}
if(pdo_tableexists('longbing_card_chart')) {
 if(!pdo_fieldexists('longbing_card_chart',  'kind')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chart')." ADD `kind` varchar(30) NOT NULL   COMMENT 'txt 文本 img 图片 vioce语音';");
 }
}
if(pdo_tableexists('longbing_card_chat')) {
 if(!pdo_fieldexists('longbing_card_chat',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chat')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_chat')) {
 if(!pdo_fieldexists('longbing_card_chat',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chat')." ADD `user_id` int(10) NOT NULL   COMMENT '发起会话的用户id';");
 }
}
if(pdo_tableexists('longbing_card_chat')) {
 if(!pdo_fieldexists('longbing_card_chat',  'target_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chat')." ADD `target_id` int(10) NOT NULL   COMMENT '会话对象用户id';");
 }
}
if(pdo_tableexists('longbing_card_chat')) {
 if(!pdo_fieldexists('longbing_card_chat',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chat')." ADD `type` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '类型: 1=>one2one 2=>gourp';");
 }
}
if(pdo_tableexists('longbing_card_chat')) {
 if(!pdo_fieldexists('longbing_card_chat',  'gourp_ids')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chat')." ADD `gourp_ids` text()    COMMENT '此群组中的用户id';");
 }
}
if(pdo_tableexists('longbing_card_chat')) {
 if(!pdo_fieldexists('longbing_card_chat',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chat')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_chat')) {
 if(!pdo_fieldexists('longbing_card_chat',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chat')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_chat')) {
 if(!pdo_fieldexists('longbing_card_chat',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chat')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_chat')) {
 if(!pdo_fieldexists('longbing_card_chat',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_chat')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `staff_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `name` varchar(20) NOT NULL   COMMENT '姓名';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'sex')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `sex` varchar(10) NOT NULL   COMMENT '性别';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `phone` varchar(20) NOT NULL   COMMENT '手机号';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'email')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `email` varchar(20) NOT NULL   COMMENT '邮箱';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'company')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `company` varchar(50) NOT NULL   COMMENT '公司';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'position')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `position` varchar(20) NOT NULL   COMMENT '职位';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'address')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `address` varchar(100) NOT NULL   COMMENT '详细地址';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'birthday')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `birthday` varchar(20) NOT NULL   COMMENT '生日';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'is_mask')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `is_mask` varchar(3) NOT NULL   COMMENT '是否屏蔽';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `remark` varchar(500) NOT NULL   COMMENT '备注';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_client_info')) {
 if(!pdo_fieldexists('longbing_card_client_info',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_client_info')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `uid` int(11) NOT NULL   COMMENT '当前用户id';");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'to_uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `to_uid` int(10) NOT NULL   COMMENT '被收藏人id (名片人id)';");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'from_uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `from_uid` int(10) NOT NULL   COMMENT '分享人id';");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'scene')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `scene` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `status` int(5) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'is_qr')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `is_qr` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'openGId')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `openGId` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'is_group')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `is_group` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `type` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'target_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `target_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'handover_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `handover_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'handover_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `handover_name` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'distribution')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `distribution` int(3) NOT NULL   COMMENT '是否是后台分配的';");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'is_auto')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `is_auto` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'intention')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `intention` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_collection')) {
 if(!pdo_fieldexists('longbing_card_collection',  'rate')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_collection')." ADD `rate` int(4) NOT NULL DEFAULT NULL DEFAULT '5';");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `name` varchar(50) NOT NULL   COMMENT '公司名称';");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'addr')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `addr` varchar(100) NOT NULL   COMMENT '公司地址';");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'logo')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `logo` varchar(255) NOT NULL   COMMENT '公司logo';");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'url')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `url` varchar(50) NOT NULL   COMMENT '公司网址';");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `phone` varchar(100) NOT NULL   COMMENT '联系方式';");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'desc')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `desc` text() NOT NULL   COMMENT '商城背景图';");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'culture')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `culture` text() NOT NULL   COMMENT '官网轮播图';");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'longitude')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `longitude` varchar(50) NOT NULL   COMMENT '经度';");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'latitude')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `latitude` varchar(50) NOT NULL   COMMENT '纬度';");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'short_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `short_name` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'shop_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `shop_name` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `pid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_company')) {
 if(!pdo_fieldexists('longbing_card_company',  'auth_code')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company')." ADD `auth_code` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_company_goods')) {
 if(!pdo_fieldexists('longbing_card_company_goods',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company_goods')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_company_goods')) {
 if(!pdo_fieldexists('longbing_card_company_goods',  'company_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company_goods')." ADD `company_id` int(10) NOT NULL   COMMENT '公司id';");
 }
}
if(pdo_tableexists('longbing_card_company_goods')) {
 if(!pdo_fieldexists('longbing_card_company_goods',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company_goods')." ADD `goods_id` int(10) NOT NULL   COMMENT '商品id';");
 }
}
if(pdo_tableexists('longbing_card_company_goods')) {
 if(!pdo_fieldexists('longbing_card_company_goods',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company_goods')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_company_goods')) {
 if(!pdo_fieldexists('longbing_card_company_goods',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company_goods')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_company_goods')) {
 if(!pdo_fieldexists('longbing_card_company_goods',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company_goods')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_company_goods')) {
 if(!pdo_fieldexists('longbing_card_company_goods',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_company_goods')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'multi')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `multi` int(11) NOT NULL   COMMENT '是否允许一个用户拥有多张名片';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'show_card')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `show_card` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'copyright')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `copyright` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'mini_template_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `mini_template_id` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'mini_app_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `mini_app_name` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'allow_create')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `allow_create` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'create_text')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `create_text` varchar(100) NOT NULL DEFAULT NULL DEFAULT '创建我的智能名片';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'logo_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `logo_switch` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'logo_text')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `logo_text` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'logo_phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `logo_phone` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'notice_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `notice_switch` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'notice_i')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `notice_i` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'min_tmppid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `min_tmppid` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'order_overtime')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `order_overtime` int(10) NOT NULL DEFAULT NULL DEFAULT '1800';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'collage_overtime')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `collage_overtime` int(10) NOT NULL DEFAULT NULL DEFAULT '172800';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'force_phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `force_phone` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'staff_extract')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `staff_extract` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'first_extract')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `first_extract` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'sec_extract')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `sec_extract` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'code')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `code` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'corpid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `corpid` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'corpsecret')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `corpsecret` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'agentid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `agentid` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'wx_appid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `wx_appid` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'wx_tplid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `wx_tplid` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'redis_pas')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `redis_pas` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'cash_mini')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `cash_mini` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'admin_account')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `admin_account` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'plug_form')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `plug_form` int(4) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'btn_consult')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `btn_consult` varchar(20) NOT NULL DEFAULT NULL DEFAULT '咨询';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'btn_sale')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `btn_sale` varchar(20) NOT NULL DEFAULT NULL DEFAULT '销售管家';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'btn_code_err')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `btn_code_err` varchar(200) NOT NULL DEFAULT NULL DEFAULT '免审口令填写错误';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'btn_code_miss')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `btn_code_miss` varchar(200) NOT NULL DEFAULT NULL DEFAULT '免审口令未填写';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'preview_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `preview_switch` int(4) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'btn_talk')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `btn_talk` varchar(20) NOT NULL DEFAULT NULL DEFAULT '面议';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'receiving')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `receiving` int(10) NOT NULL DEFAULT NULL DEFAULT '5';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'ios_pay')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `ios_pay` int(4) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'android_pay')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `android_pay` int(4) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'self_text')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `self_text` varchar(200) NOT NULL DEFAULT NULL DEFAULT '自提商品';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'default_video')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `default_video` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'default_voice')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `default_voice` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'card_type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `card_type` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'order_pwd')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `order_pwd` varchar(40) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'exchange_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `exchange_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'motto_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `motto_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'default_voice_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `default_voice_switch` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'myshop_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `myshop_switch` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'aliyun_sms_access_key_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `aliyun_sms_access_key_id` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'aliyun_sms_access_key_secret')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `aliyun_sms_access_key_secret` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'default_shop_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `default_shop_name` varchar(500) NOT NULL   COMMENT '默认商城名称';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'default_shop_pic')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `default_shop_pic` varchar(500) NOT NULL   COMMENT '默认商城背景图';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'default_video_cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `default_video_cover` varchar(500) NOT NULL   COMMENT '视频默认封面图';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'appoint_pic')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `appoint_pic` varchar(500) NOT NULL   COMMENT '预约背景图';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'appoint_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `appoint_name` varchar(500) NOT NULL   COMMENT '预约标题';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'click_copy_way')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `click_copy_way` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '点击版权效果 1 => 拨打电话 2 => 跳转网页 3 => 跳转小程序 4 => 查看大图';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'click_copy_show_img')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `click_copy_show_img` varchar(500) NOT NULL   COMMENT '当点击版权效果是查看大图时, 弹出此图片';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'click_copy_content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `click_copy_content` varchar(500) NOT NULL   COMMENT '点击版权效果 手机号 网址 appid';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'question_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `question_switch` int(3) NOT NULL   COMMENT '是否开启问卷功能';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'question_text')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `question_text` varchar(200) NOT NULL DEFAULT NULL DEFAULT '问卷'  COMMENT '问卷文字';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'shop_version')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `shop_version` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'shop_carousel_more')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `shop_carousel_more` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'exchange_btn')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `exchange_btn` varchar(40) NOT NULL DEFAULT NULL DEFAULT '交换手机号';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'my_shop_limit')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `my_shop_limit` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'autograph')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `autograph` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'signature')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `signature` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'vr_tittle')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `vr_tittle` varchar(50) NOT NULL DEFAULT NULL DEFAULT 'VR全景';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'vr_cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `vr_cover` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'vr_path')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `vr_path` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'vr_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `vr_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'qr_avatar_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `qr_avatar_switch` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'auto_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `auto_switch` int(3) NOT NULL   COMMENT '自动分配员工开关';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'auto_switch_way')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `auto_switch_way` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '自动分配推荐员工方式';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'coupon_pass')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `coupon_pass` int(11) NOT NULL   COMMENT '线下福包核销密码';");
 }
}
if(pdo_tableexists('longbing_card_config')) {
 if(!pdo_fieldexists('longbing_card_config',  'job_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_config')." ADD `job_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'name1')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `name1` varchar(30) NOT NULL   COMMENT '联系人';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'phone1')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `phone1` varchar(30) NOT NULL   COMMENT '联系方式';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'name2')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `name2` varchar(30) NOT NULL   COMMENT '联系人';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'phone2')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `phone2` varchar(30) NOT NULL   COMMENT '联系方式';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'name3')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `name3` varchar(30) NOT NULL   COMMENT '联系人';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'phone3')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `phone3` varchar(30) NOT NULL   COMMENT '联系方式';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'address')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `address` varchar(100) NOT NULL   COMMENT '详细地址';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'longitude')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `longitude` varchar(30) NOT NULL   COMMENT '经度';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'latitude')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `latitude` varchar(30) NOT NULL   COMMENT '纬度';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `content` text();");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `modular_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'show_map')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `show_map` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_contact')) {
 if(!pdo_fieldexists('longbing_card_contact',  'show_map_desc')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_contact')." ADD `show_map_desc` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_copy_count')) {
 if(!pdo_fieldexists('longbing_card_copy_count',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_copy_count')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_copy_count')) {
 if(!pdo_fieldexists('longbing_card_copy_count',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_copy_count')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_copy_count')) {
 if(!pdo_fieldexists('longbing_card_copy_count',  'to_uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_copy_count')." ADD `to_uid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_copy_count')) {
 if(!pdo_fieldexists('longbing_card_copy_count',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_copy_count')." ADD `type` int(3) NOT NULL   COMMENT '鎿嶄綔鍐呭, 1=>鍚屾鍒伴€氳褰?2=>鎷ㄦ墦鎵嬫満鍙?3=>鎷ㄦ墦搴ф満鍙?4=>澶嶅埗寰俊 5=>澶嶅埗閭 6=>澶嶅埗鍏徃鍚?7=>鏌ョ湅瀹氫綅';");
 }
}
if(pdo_tableexists('longbing_card_copy_count')) {
 if(!pdo_fieldexists('longbing_card_copy_count',  'target')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_copy_count')." ADD `target` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_copy_count')) {
 if(!pdo_fieldexists('longbing_card_copy_count',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_copy_count')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_copy_count')) {
 if(!pdo_fieldexists('longbing_card_copy_count',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_copy_count')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_copy_count')) {
 if(!pdo_fieldexists('longbing_card_copy_count',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_copy_count')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_count')) {
 if(!pdo_fieldexists('longbing_card_count',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_count')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_count')) {
 if(!pdo_fieldexists('longbing_card_count',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_count')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_count')) {
 if(!pdo_fieldexists('longbing_card_count',  'to_uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_count')." ADD `to_uid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_count')) {
 if(!pdo_fieldexists('longbing_card_count',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_count')." ADD `type` int(3) NOT NULL   COMMENT '浏览内容,sign=view时 1=>浏览商城列表 2=>浏览商品详情 3=>浏览动态列表 4=>点赞动态 5=>动态留言 6=>浏览公司官网 7=>浏览动态详情  sign=copy时 1=>同步到通讯录 2=>拨打手机号 3=>拨打座机号 4=>复制微信 5=>复制邮箱 6=>复制公司名 7=>查看定位 8=>咨询产品 9=>播放语音  当sign=praise时 1 语音点赞 2 人气(查看),3 点赞   4 分享';");
 }
}
if(pdo_tableexists('longbing_card_count')) {
 if(!pdo_fieldexists('longbing_card_count',  'sign')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_count')." ADD `sign` varchar(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_count')) {
 if(!pdo_fieldexists('longbing_card_count',  'target')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_count')." ADD `target` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_count')) {
 if(!pdo_fieldexists('longbing_card_count',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_count')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_count')) {
 if(!pdo_fieldexists('longbing_card_count',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_count')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_count')) {
 if(!pdo_fieldexists('longbing_card_count',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_count')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_count')) {
 if(!pdo_fieldexists('longbing_card_count',  'scene')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_count')." ADD `scene` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_count')) {
 if(!pdo_fieldexists('longbing_card_count',  'unread')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_count')." ADD `unread` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `title` varchar(500) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `type` int(10) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '优惠券类型 1 => 线上; 2 => 线下';");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'company_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `company_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'full')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `full` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '满';");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'reduce')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `reduce` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '减';");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `number` int(10) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '人数';");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `status` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'end_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `end_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'limit_type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `limit_type` int(11) NOT NULL   COMMENT '限制类型0：不限制；1：分类，2：商品';");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'limit_goods')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `limit_goods` text() NOT NULL   COMMENT '限制商品';");
 }
}
if(pdo_tableexists('longbing_card_coupon')) {
 if(!pdo_fieldexists('longbing_card_coupon',  'limit_cate')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon')." ADD `limit_cate` varchar(225) NOT NULL   COMMENT '限制分类';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `staff_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'coupon_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `coupon_id` int(10) NOT NULL   COMMENT '福包id';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `title` varchar(500) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `type` int(10) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '优惠券类型 1 => 线上; 2 => 线下';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'company_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `company_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'full')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `full` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '满';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'reduce')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `reduce` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '减';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'end_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `end_time` int(11) NOT NULL   COMMENT '过期时间';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'desc_coupon')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `desc_coupon` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'limit_type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `limit_type` int(11) NOT NULL   COMMENT '限制类型';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'limit_cate')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `limit_cate` varchar(255) NOT NULL   COMMENT '限用分类';");
 }
}
if(pdo_tableexists('longbing_card_coupon_record')) {
 if(!pdo_fieldexists('longbing_card_coupon_record',  'limit_goods')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_coupon_record')." ADD `limit_goods` text() NOT NULL   COMMENT '限用商品';");
 }
}
if(pdo_tableexists('longbing_card_culture')) {
 if(!pdo_fieldexists('longbing_card_culture',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_culture')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_culture')) {
 if(!pdo_fieldexists('longbing_card_culture',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_culture')." ADD `content` text();");
 }
}
if(pdo_tableexists('longbing_card_culture')) {
 if(!pdo_fieldexists('longbing_card_culture',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_culture')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_culture')) {
 if(!pdo_fieldexists('longbing_card_culture',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_culture')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_culture')) {
 if(!pdo_fieldexists('longbing_card_culture',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_culture')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_culture')) {
 if(!pdo_fieldexists('longbing_card_culture',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_culture')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_culture')) {
 if(!pdo_fieldexists('longbing_card_culture',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_culture')." ADD `modular_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_custom_qr')) {
 if(!pdo_fieldexists('longbing_card_custom_qr',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_custom_qr')) {
 if(!pdo_fieldexists('longbing_card_custom_qr',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr')." ADD `user_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_custom_qr')) {
 if(!pdo_fieldexists('longbing_card_custom_qr',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr')." ADD `title` varchar(100) NOT NULL   COMMENT '自定义码标题';");
 }
}
if(pdo_tableexists('longbing_card_custom_qr')) {
 if(!pdo_fieldexists('longbing_card_custom_qr',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr')." ADD `content` varchar(1000) NOT NULL   COMMENT '自定义码内容';");
 }
}
if(pdo_tableexists('longbing_card_custom_qr')) {
 if(!pdo_fieldexists('longbing_card_custom_qr',  'path')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr')." ADD `path` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_custom_qr')) {
 if(!pdo_fieldexists('longbing_card_custom_qr',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_custom_qr')) {
 if(!pdo_fieldexists('longbing_card_custom_qr',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_custom_qr')) {
 if(!pdo_fieldexists('longbing_card_custom_qr',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_custom_qr')) {
 if(!pdo_fieldexists('longbing_card_custom_qr',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_custom_qr_record')) {
 if(!pdo_fieldexists('longbing_card_custom_qr_record',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr_record')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_custom_qr_record')) {
 if(!pdo_fieldexists('longbing_card_custom_qr_record',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr_record')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_custom_qr_record')) {
 if(!pdo_fieldexists('longbing_card_custom_qr_record',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr_record')." ADD `staff_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_custom_qr_record')) {
 if(!pdo_fieldexists('longbing_card_custom_qr_record',  'qr_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr_record')." ADD `qr_id` int(10) NOT NULL   COMMENT '自定义码id';");
 }
}
if(pdo_tableexists('longbing_card_custom_qr_record')) {
 if(!pdo_fieldexists('longbing_card_custom_qr_record',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr_record')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_custom_qr_record')) {
 if(!pdo_fieldexists('longbing_card_custom_qr_record',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr_record')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_custom_qr_record')) {
 if(!pdo_fieldexists('longbing_card_custom_qr_record',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr_record')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_custom_qr_record')) {
 if(!pdo_fieldexists('longbing_card_custom_qr_record',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_custom_qr_record')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_date')) {
 if(!pdo_fieldexists('longbing_card_date',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_date')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_date')) {
 if(!pdo_fieldexists('longbing_card_date',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_date')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_date')) {
 if(!pdo_fieldexists('longbing_card_date',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_date')." ADD `staff_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_date')) {
 if(!pdo_fieldexists('longbing_card_date',  'date')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_date')." ADD `date` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_date')) {
 if(!pdo_fieldexists('longbing_card_date',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_date')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_date')) {
 if(!pdo_fieldexists('longbing_card_date',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_date')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_date')) {
 if(!pdo_fieldexists('longbing_card_date',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_date')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_desc')) {
 if(!pdo_fieldexists('longbing_card_desc',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_desc')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_desc')) {
 if(!pdo_fieldexists('longbing_card_desc',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_desc')." ADD `content` longtext();");
 }
}
if(pdo_tableexists('longbing_card_desc')) {
 if(!pdo_fieldexists('longbing_card_desc',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_desc')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_desc')) {
 if(!pdo_fieldexists('longbing_card_desc',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_desc')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_desc')) {
 if(!pdo_fieldexists('longbing_card_desc',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_desc')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_desc')) {
 if(!pdo_fieldexists('longbing_card_desc',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_desc')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_desc')) {
 if(!pdo_fieldexists('longbing_card_desc',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_desc')." ADD `modular_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_desc')) {
 if(!pdo_fieldexists('longbing_card_desc',  'introduction')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_desc')." ADD `introduction` longtext();");
 }
}
if(pdo_tableexists('longbing_card_extension')) {
 if(!pdo_fieldexists('longbing_card_extension',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_extension')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_extension')) {
 if(!pdo_fieldexists('longbing_card_extension',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_extension')." ADD `user_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_extension')) {
 if(!pdo_fieldexists('longbing_card_extension',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_extension')." ADD `goods_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_extension')) {
 if(!pdo_fieldexists('longbing_card_extension',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_extension')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_extension')) {
 if(!pdo_fieldexists('longbing_card_extension',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_extension')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_extension')) {
 if(!pdo_fieldexists('longbing_card_extension',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_extension')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_extension')) {
 if(!pdo_fieldexists('longbing_card_extension',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_extension')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `name` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `phone` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `content` varchar(2000) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'bac1')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `bac1` varchar(2000) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'bac2')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `bac2` varchar(2000) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'bac3')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `bac3` varchar(2000) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_form')) {
 if(!pdo_fieldexists('longbing_card_form',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_form')." ADD `modular_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_formId')) {
 if(!pdo_fieldexists('longbing_card_formId',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_formId')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_formId')) {
 if(!pdo_fieldexists('longbing_card_formId',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_formId')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_formId')) {
 if(!pdo_fieldexists('longbing_card_formId',  'formId')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_formId')." ADD `formId` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_formId')) {
 if(!pdo_fieldexists('longbing_card_formId',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_formId')." ADD `status` int(3) NOT NULL   COMMENT '1=>未使用过 2=>使用过';");
 }
}
if(pdo_tableexists('longbing_card_formId')) {
 if(!pdo_fieldexists('longbing_card_formId',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_formId')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_formId')) {
 if(!pdo_fieldexists('longbing_card_formId',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_formId')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_formId')) {
 if(!pdo_fieldexists('longbing_card_formId',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_formId')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_forward')) {
 if(!pdo_fieldexists('longbing_card_forward',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_forward')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_forward')) {
 if(!pdo_fieldexists('longbing_card_forward',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_forward')." ADD `user_id` int(10) NOT NULL   COMMENT '用户转发人的id';");
 }
}
if(pdo_tableexists('longbing_card_forward')) {
 if(!pdo_fieldexists('longbing_card_forward',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_forward')." ADD `staff_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_forward')) {
 if(!pdo_fieldexists('longbing_card_forward',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_forward')." ADD `type` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1=>转发名片 2=>转发商品 3=>转发动态 4=>转发公司官网';");
 }
}
if(pdo_tableexists('longbing_card_forward')) {
 if(!pdo_fieldexists('longbing_card_forward',  'target_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_forward')." ADD `target_id` int(10) NOT NULL   COMMENT '转发内容的id 当type=2,3时有效';");
 }
}
if(pdo_tableexists('longbing_card_forward')) {
 if(!pdo_fieldexists('longbing_card_forward',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_forward')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_forward')) {
 if(!pdo_fieldexists('longbing_card_forward',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_forward')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_forward')) {
 if(!pdo_fieldexists('longbing_card_forward',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_forward')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_forward')) {
 if(!pdo_fieldexists('longbing_card_forward',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_forward')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `name` varchar(50) NOT NULL   COMMENT '商品名';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `cover` varchar(500) NOT NULL   COMMENT '商品封面图';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'images')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `images` varchar(5000) NOT NULL   COMMENT '商品轮播图';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'view_count')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `view_count` int(10) NOT NULL   COMMENT '商品浏览量';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'sale_count')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `sale_count` int(10) NOT NULL   COMMENT '商品销售量';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'desc')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `desc` varchar(500) NOT NULL   COMMENT '商品简介';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `content` longtext();");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `type` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'collage_count')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `collage_count` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'is_collage')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `is_collage` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'freight')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `freight` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'recommend')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `recommend` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'stock')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `stock` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'type_p')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `type_p` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'image_url')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `image_url` varchar(2000) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'unit')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `unit` varchar(100) NOT NULL DEFAULT NULL DEFAULT '个';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'is_self')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `is_self` int(4) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'extract')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `extract` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  's_title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `s_title` varchar(500) NOT NULL   COMMENT '副标题';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'staff_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `staff_switch` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'staff_extract')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `staff_extract` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods')) {
 if(!pdo_fieldexists('longbing_card_goods',  'company_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods')." ADD `company_id` varchar(256) NOT NULL   COMMENT '所属公司id';");
 }
}
if(pdo_tableexists('longbing_card_goods_collection')) {
 if(!pdo_fieldexists('longbing_card_goods_collection',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods_collection')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_goods_collection')) {
 if(!pdo_fieldexists('longbing_card_goods_collection',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods_collection')." ADD `user_id` int(11) NOT NULL   COMMENT '用户的fans_id';");
 }
}
if(pdo_tableexists('longbing_card_goods_collection')) {
 if(!pdo_fieldexists('longbing_card_goods_collection',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods_collection')." ADD `goods_id` int(11) NOT NULL   COMMENT '商品id';");
 }
}
if(pdo_tableexists('longbing_card_goods_collection')) {
 if(!pdo_fieldexists('longbing_card_goods_collection',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods_collection')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods_collection')) {
 if(!pdo_fieldexists('longbing_card_goods_collection',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods_collection')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_goods_collection')) {
 if(!pdo_fieldexists('longbing_card_goods_collection',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods_collection')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_goods_collection')) {
 if(!pdo_fieldexists('longbing_card_goods_collection',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_goods_collection')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_number')) {
 if(!pdo_fieldexists('longbing_card_group_number',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_number')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_group_number')) {
 if(!pdo_fieldexists('longbing_card_group_number',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_number')." ADD `staff_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_number')) {
 if(!pdo_fieldexists('longbing_card_group_number',  'openGId')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_number')." ADD `openGId` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_number')) {
 if(!pdo_fieldexists('longbing_card_group_number',  'number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_number')." ADD `number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_number')) {
 if(!pdo_fieldexists('longbing_card_group_number',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_number')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_number')) {
 if(!pdo_fieldexists('longbing_card_group_number',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_number')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_group_number')) {
 if(!pdo_fieldexists('longbing_card_group_number',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_number')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_number')) {
 if(!pdo_fieldexists('longbing_card_group_number',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_number')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_sending')) {
 if(!pdo_fieldexists('longbing_card_group_sending',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_sending')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_group_sending')) {
 if(!pdo_fieldexists('longbing_card_group_sending',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_sending')." ADD `content` varchar(2000) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_sending')) {
 if(!pdo_fieldexists('longbing_card_group_sending',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_sending')." ADD `type` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_sending')) {
 if(!pdo_fieldexists('longbing_card_group_sending',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_sending')." ADD `staff_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_sending')) {
 if(!pdo_fieldexists('longbing_card_group_sending',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_sending')." ADD `remark` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_sending')) {
 if(!pdo_fieldexists('longbing_card_group_sending',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_sending')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_sending')) {
 if(!pdo_fieldexists('longbing_card_group_sending',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_sending')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_group_sending')) {
 if(!pdo_fieldexists('longbing_card_group_sending',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_sending')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_group_sending')) {
 if(!pdo_fieldexists('longbing_card_group_sending',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_group_sending')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_handover')) {
 if(!pdo_fieldexists('longbing_card_handover',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_handover')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_handover')) {
 if(!pdo_fieldexists('longbing_card_handover',  'old_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_handover')." ADD `old_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_handover')) {
 if(!pdo_fieldexists('longbing_card_handover',  'new_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_handover')." ADD `new_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_handover')) {
 if(!pdo_fieldexists('longbing_card_handover',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_handover')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_handover')) {
 if(!pdo_fieldexists('longbing_card_handover',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_handover')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_handover')) {
 if(!pdo_fieldexists('longbing_card_handover',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_handover')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_handover')) {
 if(!pdo_fieldexists('longbing_card_handover',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_handover')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `create_time` int(11);");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `update_time` int(11);");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `status` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1-正常  0-下架   -1 假删除';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `title` varchar(50) NOT NULL   COMMENT '房源标题';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'category')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `category` int(11) NOT NULL   COMMENT '分类';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'imgs')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `imgs` varchar(700) NOT NULL   COMMENT '图集';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'video_cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `video_cover` varchar(300) NOT NULL   COMMENT '视频封面';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'video')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `video` varchar(300) NOT NULL   COMMENT '视频资源';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'labels')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `labels` varchar(100) NOT NULL   COMMENT '标签，用英文逗号隔开';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'longitude')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `longitude` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'latitude')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `latitude` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'attrs')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `attrs` varchar(300) NOT NULL   COMMENT '房源属性，json字符串';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'community_attrs')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `community_attrs` varchar(300) NOT NULL   COMMENT '小区属性json字符串';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'community_info')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `community_info` varchar(1000) NOT NULL   COMMENT '小区信息';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `top` int(11) NOT NULL   COMMENT '排序';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `price` double(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '单位（万）售价-从属性中单独拿出来 做筛选';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'huxing_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `huxing_id` int(11) NOT NULL   COMMENT '户型id';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'area_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `area_id` int(11) NOT NULL   COMMENT '区域Id';");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'vr_cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `vr_cover` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'vr_path')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `vr_path` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house')) {
 if(!pdo_fieldexists('longbing_card_house',  'address')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house')." ADD `address` varchar(255) NOT NULL   COMMENT '长地址';");
 }
}
if(pdo_tableexists('longbing_card_house_ad')) {
 if(!pdo_fieldexists('longbing_card_house_ad',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_ad')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_house_ad')) {
 if(!pdo_fieldexists('longbing_card_house_ad',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_ad')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_ad')) {
 if(!pdo_fieldexists('longbing_card_house_ad',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_ad')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_ad')) {
 if(!pdo_fieldexists('longbing_card_house_ad',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_ad')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_ad')) {
 if(!pdo_fieldexists('longbing_card_house_ad',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_ad')." ADD `status` char(2) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_house_ad')) {
 if(!pdo_fieldexists('longbing_card_house_ad',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_ad')." ADD `type` char(2) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1-房源首页';");
 }
}
if(pdo_tableexists('longbing_card_house_ad')) {
 if(!pdo_fieldexists('longbing_card_house_ad',  'path')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_ad')." ADD `path` varchar(255) NOT NULL   COMMENT '图片';");
 }
}
if(pdo_tableexists('longbing_card_house_ad')) {
 if(!pdo_fieldexists('longbing_card_house_ad',  'link')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_ad')." ADD `link` varchar(255) NOT NULL   COMMENT '跳转';");
 }
}
if(pdo_tableexists('longbing_card_house_ad')) {
 if(!pdo_fieldexists('longbing_card_house_ad',  'link_type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_ad')." ADD `link_type` char(2) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '跳转类型 1-电话 2小程序  3网页  4-内部页面';");
 }
}
if(pdo_tableexists('longbing_card_house_ad')) {
 if(!pdo_fieldexists('longbing_card_house_ad',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_ad')." ADD `top` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `uid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'to_uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `to_uid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'house_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `house_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'date')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `date` int(11) NOT NULL   COMMENT '预约时间 时间戳';");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `status` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'contact')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `contact` varchar(30) NOT NULL   COMMENT '联系人';");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'tel')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `tel` varchar(30) NOT NULL   COMMENT '联系电话';");
 }
}
if(pdo_tableexists('longbing_card_house_appointment')) {
 if(!pdo_fieldexists('longbing_card_house_appointment',  'avatar')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_appointment')." ADD `avatar` varchar(400) NOT NULL   COMMENT '头像';");
 }
}
if(pdo_tableexists('longbing_card_house_area')) {
 if(!pdo_fieldexists('longbing_card_house_area',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_area')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_house_area')) {
 if(!pdo_fieldexists('longbing_card_house_area',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_area')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_area')) {
 if(!pdo_fieldexists('longbing_card_house_area',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_area')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_area')) {
 if(!pdo_fieldexists('longbing_card_house_area',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_area')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_area')) {
 if(!pdo_fieldexists('longbing_card_house_area',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_area')." ADD `status` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_house_area')) {
 if(!pdo_fieldexists('longbing_card_house_area',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_area')." ADD `title` varchar(255) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_area')) {
 if(!pdo_fieldexists('longbing_card_house_area',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_area')." ADD `sort` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_area')) {
 if(!pdo_fieldexists('longbing_card_house_area',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_area')." ADD `pid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_area')) {
 if(!pdo_fieldexists('longbing_card_house_area',  'level')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_area')." ADD `level` tinyint(2) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_category')) {
 if(!pdo_fieldexists('longbing_card_house_category',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_category')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_house_category')) {
 if(!pdo_fieldexists('longbing_card_house_category',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_category')." ADD `title` varchar(40) NOT NULL   COMMENT '分类名';");
 }
}
if(pdo_tableexists('longbing_card_house_category')) {
 if(!pdo_fieldexists('longbing_card_house_category',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_category')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_category')) {
 if(!pdo_fieldexists('longbing_card_house_category',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_category')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_category')) {
 if(!pdo_fieldexists('longbing_card_house_category',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_category')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_house_category')) {
 if(!pdo_fieldexists('longbing_card_house_category',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_category')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_category')) {
 if(!pdo_fieldexists('longbing_card_house_category',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_category')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_category')) {
 if(!pdo_fieldexists('longbing_card_house_category',  'img')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_category')." ADD `img` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_collect')) {
 if(!pdo_fieldexists('longbing_card_house_collect',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_collect')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_house_collect')) {
 if(!pdo_fieldexists('longbing_card_house_collect',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_collect')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_collect')) {
 if(!pdo_fieldexists('longbing_card_house_collect',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_collect')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_collect')) {
 if(!pdo_fieldexists('longbing_card_house_collect',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_collect')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_collect')) {
 if(!pdo_fieldexists('longbing_card_house_collect',  'uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_collect')." ADD `uid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_collect')) {
 if(!pdo_fieldexists('longbing_card_house_collect',  'house_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_collect')." ADD `house_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_huxing')) {
 if(!pdo_fieldexists('longbing_card_house_huxing',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_huxing')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_house_huxing')) {
 if(!pdo_fieldexists('longbing_card_house_huxing',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_huxing')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_huxing')) {
 if(!pdo_fieldexists('longbing_card_house_huxing',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_huxing')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_huxing')) {
 if(!pdo_fieldexists('longbing_card_house_huxing',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_huxing')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_huxing')) {
 if(!pdo_fieldexists('longbing_card_house_huxing',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_huxing')." ADD `title` varchar(30) NOT NULL   COMMENT '户型';");
 }
}
if(pdo_tableexists('longbing_card_house_huxing')) {
 if(!pdo_fieldexists('longbing_card_house_huxing',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_huxing')." ADD `sort` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_price')) {
 if(!pdo_fieldexists('longbing_card_house_price',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_price')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_house_price')) {
 if(!pdo_fieldexists('longbing_card_house_price',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_price')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_price')) {
 if(!pdo_fieldexists('longbing_card_house_price',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_price')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_price')) {
 if(!pdo_fieldexists('longbing_card_house_price',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_price')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_house_price')) {
 if(!pdo_fieldexists('longbing_card_house_price',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_price')." ADD `title` varchar(30) NOT NULL   COMMENT '价格区间显示标题';");
 }
}
if(pdo_tableexists('longbing_card_house_price')) {
 if(!pdo_fieldexists('longbing_card_house_price',  'value')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_price')." ADD `value` varchar(30) NOT NULL   COMMENT '实际代表的值';");
 }
}
if(pdo_tableexists('longbing_card_house_price')) {
 if(!pdo_fieldexists('longbing_card_house_price',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_house_price')." ADD `sort` int(11) NOT NULL   COMMENT '排序';");
 }
}
if(pdo_tableexists('longbing_card_job')) {
 if(!pdo_fieldexists('longbing_card_job',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_job')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_job')) {
 if(!pdo_fieldexists('longbing_card_job',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_job')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_job')) {
 if(!pdo_fieldexists('longbing_card_job',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_job')." ADD `name` varchar(50) NOT NULL   COMMENT '名称';");
 }
}
if(pdo_tableexists('longbing_card_job')) {
 if(!pdo_fieldexists('longbing_card_job',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_job')." ADD `status` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_job')) {
 if(!pdo_fieldexists('longbing_card_job',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_job')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_job')) {
 if(!pdo_fieldexists('longbing_card_job',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_job')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_job')) {
 if(!pdo_fieldexists('longbing_card_job',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_job')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `title` varchar(100) NOT NULL   COMMENT '招聘职位';");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'money')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `money` varchar(20) NOT NULL   COMMENT '薪资';");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'experience')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `experience` varchar(20) NOT NULL   COMMENT '经验';");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'education')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `education` varchar(20) NOT NULL   COMMENT '学历';");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `content` text();");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `phone` varchar(20) NOT NULL   COMMENT 'hr电话';");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_jobs')) {
 if(!pdo_fieldexists('longbing_card_jobs',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_jobs')." ADD `modular_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_key')) {
 if(!pdo_fieldexists('longbing_card_key',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_key')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_key')) {
 if(!pdo_fieldexists('longbing_card_key',  'domain_keys')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_key')." ADD `domain_keys` text()    COMMENT '域名秘钥';");
 }
}
if(pdo_tableexists('longbing_card_key')) {
 if(!pdo_fieldexists('longbing_card_key',  'domain_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_key')." ADD `domain_name` varchar(100) NOT NULL   COMMENT '域名';");
 }
}
if(pdo_tableexists('longbing_card_key')) {
 if(!pdo_fieldexists('longbing_card_key',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_key')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_key')) {
 if(!pdo_fieldexists('longbing_card_key',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_key')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_key')) {
 if(!pdo_fieldexists('longbing_card_key',  'domain_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_key')." ADD `domain_id` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_key')) {
 if(!pdo_fieldexists('longbing_card_key',  'website_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_key')." ADD `website_id` varchar(100)    COMMENT '站点id';");
 }
}
if(pdo_tableexists('longbing_card_key')) {
 if(!pdo_fieldexists('longbing_card_key',  'website_keys')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_key')." ADD `website_keys` text()    COMMENT '站点秘钥';");
 }
}
if(pdo_tableexists('longbing_card_key')) {
 if(!pdo_fieldexists('longbing_card_key',  'version_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_key')." ADD `version_id` char(32) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_key')) {
 if(!pdo_fieldexists('longbing_card_key',  'branch_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_key')." ADD `branch_id` char(32) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_key')) {
 if(!pdo_fieldexists('longbing_card_key',  'version_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_key')." ADD `version_name` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_label')) {
 if(!pdo_fieldexists('longbing_card_label',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_label')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_label')) {
 if(!pdo_fieldexists('longbing_card_label',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_label')." ADD `name` varchar(20) NOT NULL   COMMENT '标签';");
 }
}
if(pdo_tableexists('longbing_card_label')) {
 if(!pdo_fieldexists('longbing_card_label',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_label')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_label')) {
 if(!pdo_fieldexists('longbing_card_label',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_label')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_label')) {
 if(!pdo_fieldexists('longbing_card_label',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_label')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_label')) {
 if(!pdo_fieldexists('longbing_card_label',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_label')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_message')) {
 if(!pdo_fieldexists('longbing_card_message',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_message')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_message')) {
 if(!pdo_fieldexists('longbing_card_message',  'chat_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_message')." ADD `chat_id` int(10) NOT NULL   COMMENT '会话记录表id';");
 }
}
if(pdo_tableexists('longbing_card_message')) {
 if(!pdo_fieldexists('longbing_card_message',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_message')." ADD `user_id` int(10) NOT NULL   COMMENT '发送消息用户id';");
 }
}
if(pdo_tableexists('longbing_card_message')) {
 if(!pdo_fieldexists('longbing_card_message',  'target_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_message')." ADD `target_id` int(10) NOT NULL   COMMENT '接收消息用户id';");
 }
}
if(pdo_tableexists('longbing_card_message')) {
 if(!pdo_fieldexists('longbing_card_message',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_message')." ADD `content` text()    COMMENT '消息内容';");
 }
}
if(pdo_tableexists('longbing_card_message')) {
 if(!pdo_fieldexists('longbing_card_message',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_message')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1=>未读消息 2=>已读 3=>已撤销 4=>已删除';");
 }
}
if(pdo_tableexists('longbing_card_message')) {
 if(!pdo_fieldexists('longbing_card_message',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_message')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_message')) {
 if(!pdo_fieldexists('longbing_card_message',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_message')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_message')) {
 if(!pdo_fieldexists('longbing_card_message',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_message')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_message')) {
 if(!pdo_fieldexists('longbing_card_message',  'message_type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_message')." ADD `message_type` varchar(50) NOT NULL DEFAULT NULL DEFAULT 'text';");
 }
}
if(pdo_tableexists('longbing_card_mini')) {
 if(!pdo_fieldexists('longbing_card_mini',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_mini')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_mini')) {
 if(!pdo_fieldexists('longbing_card_mini',  'mini')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_mini')." ADD `mini` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_mini')) {
 if(!pdo_fieldexists('longbing_card_mini',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_mini')." ADD `modular_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_mini')) {
 if(!pdo_fieldexists('longbing_card_mini',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_mini')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_mini')) {
 if(!pdo_fieldexists('longbing_card_mini',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_mini')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_mini')) {
 if(!pdo_fieldexists('longbing_card_mini',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_mini')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_mini')) {
 if(!pdo_fieldexists('longbing_card_mini',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_mini')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_mini')) {
 if(!pdo_fieldexists('longbing_card_mini',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_mini')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `name` varchar(100) NOT NULL   COMMENT '模块名';");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'show_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `show_name` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '前台是否显示模块名';");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `cover` varchar(500) NOT NULL   COMMENT '图标';");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'identification')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `identification` varchar(20) NOT NULL   COMMENT '模块标识';");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'table_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `table_name` varchar(200) NOT NULL   COMMENT '表名';");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `type` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1=>文章列表, 2=>图文详情, 3=>招聘信息, 4=>联系我们, 5=>员工展示';");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `top` int(10) NOT NULL   COMMENT '排序值';");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'show_top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `show_top` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'show_more')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `show_more` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'show')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `show` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `remark` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_modular')) {
 if(!pdo_fieldexists('longbing_card_modular',  'list_limit')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_modular')." ADD `list_limit` int(3) NOT NULL DEFAULT NULL DEFAULT '3';");
 }
}
if(pdo_tableexists('longbing_card_pages')) {
 if(!pdo_fieldexists('longbing_card_pages',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_pages')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_pages')) {
 if(!pdo_fieldexists('longbing_card_pages',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_pages')." ADD `title` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_pages')) {
 if(!pdo_fieldexists('longbing_card_pages',  'page')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_pages')." ADD `page` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_pages')) {
 if(!pdo_fieldexists('longbing_card_pages',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_pages')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_pages')) {
 if(!pdo_fieldexists('longbing_card_pages',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_pages')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_pages')) {
 if(!pdo_fieldexists('longbing_card_pages',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_pages')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_pages')) {
 if(!pdo_fieldexists('longbing_card_pages',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_pages')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_plug_form')) {
 if(!pdo_fieldexists('longbing_card_plug_form',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_plug_form')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_plug_form')) {
 if(!pdo_fieldexists('longbing_card_plug_form',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_plug_form')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_plug_form')) {
 if(!pdo_fieldexists('longbing_card_plug_form',  'to_uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_plug_form')." ADD `to_uid` int(10) NOT NULL   COMMENT '名片id';");
 }
}
if(pdo_tableexists('longbing_card_plug_form')) {
 if(!pdo_fieldexists('longbing_card_plug_form',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_plug_form')." ADD `name` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_plug_form')) {
 if(!pdo_fieldexists('longbing_card_plug_form',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_plug_form')." ADD `phone` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_plug_form')) {
 if(!pdo_fieldexists('longbing_card_plug_form',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_plug_form')." ADD `content` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_plug_form')) {
 if(!pdo_fieldexists('longbing_card_plug_form',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_plug_form')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_plug_form')) {
 if(!pdo_fieldexists('longbing_card_plug_form',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_plug_form')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_plug_form')) {
 if(!pdo_fieldexists('longbing_card_plug_form',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_plug_form')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_plug_form')) {
 if(!pdo_fieldexists('longbing_card_plug_form',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_plug_form')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster')) {
 if(!pdo_fieldexists('longbing_card_poster',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_poster')) {
 if(!pdo_fieldexists('longbing_card_poster',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster')." ADD `title` varchar(500) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('longbing_card_poster')) {
 if(!pdo_fieldexists('longbing_card_poster',  'img')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster')." ADD `img` varchar(500) NOT NULL   COMMENT '海报链接';");
 }
}
if(pdo_tableexists('longbing_card_poster')) {
 if(!pdo_fieldexists('longbing_card_poster',  'type_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster')." ADD `type_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster')) {
 if(!pdo_fieldexists('longbing_card_poster',  'company_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster')." ADD `company_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster')) {
 if(!pdo_fieldexists('longbing_card_poster',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster')) {
 if(!pdo_fieldexists('longbing_card_poster',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster')) {
 if(!pdo_fieldexists('longbing_card_poster',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_poster')) {
 if(!pdo_fieldexists('longbing_card_poster',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster')) {
 if(!pdo_fieldexists('longbing_card_poster',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster')) {
 if(!pdo_fieldexists('longbing_card_poster',  'cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster')." ADD `cover` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster_type')) {
 if(!pdo_fieldexists('longbing_card_poster_type',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster_type')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_poster_type')) {
 if(!pdo_fieldexists('longbing_card_poster_type',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster_type')." ADD `title` varchar(500) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('longbing_card_poster_type')) {
 if(!pdo_fieldexists('longbing_card_poster_type',  'company_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster_type')." ADD `company_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster_type')) {
 if(!pdo_fieldexists('longbing_card_poster_type',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster_type')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster_type')) {
 if(!pdo_fieldexists('longbing_card_poster_type',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster_type')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster_type')) {
 if(!pdo_fieldexists('longbing_card_poster_type',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster_type')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_poster_type')) {
 if(!pdo_fieldexists('longbing_card_poster_type',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster_type')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_poster_type')) {
 if(!pdo_fieldexists('longbing_card_poster_type',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_poster_type')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_praise')) {
 if(!pdo_fieldexists('longbing_card_praise',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_praise')." ADD `id` int(20) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_praise')) {
 if(!pdo_fieldexists('longbing_card_praise',  'uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_praise')." ADD `uid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_praise')) {
 if(!pdo_fieldexists('longbing_card_praise',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_praise')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_praise')) {
 if(!pdo_fieldexists('longbing_card_praise',  'to_uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_praise')." ADD `to_uid` int(11) NOT NULL   COMMENT '被点赞者id';");
 }
}
if(pdo_tableexists('longbing_card_praise')) {
 if(!pdo_fieldexists('longbing_card_praise',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_praise')." ADD `type` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '类型  1 语音点赞 2 人气(查看),3 点赞   4 分享';");
 }
}
if(pdo_tableexists('longbing_card_praise')) {
 if(!pdo_fieldexists('longbing_card_praise',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_praise')." ADD `create_time` int(11);");
 }
}
if(pdo_tableexists('longbing_card_praise')) {
 if(!pdo_fieldexists('longbing_card_praise',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_praise')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_qn_answer')) {
 if(!pdo_fieldexists('longbing_card_qn_answer',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_answer')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_qn_answer')) {
 if(!pdo_fieldexists('longbing_card_qn_answer',  'q_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_answer')." ADD `q_id` int(10) NOT NULL   COMMENT '问题id';");
 }
}
if(pdo_tableexists('longbing_card_qn_answer')) {
 if(!pdo_fieldexists('longbing_card_qn_answer',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_answer')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_qn_answer')) {
 if(!pdo_fieldexists('longbing_card_qn_answer',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_answer')." ADD `staff_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_qn_answer')) {
 if(!pdo_fieldexists('longbing_card_qn_answer',  'answer')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_answer')." ADD `answer` varchar(300) NOT NULL   COMMENT '答案';");
 }
}
if(pdo_tableexists('longbing_card_qn_answer')) {
 if(!pdo_fieldexists('longbing_card_qn_answer',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_answer')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_qn_answer')) {
 if(!pdo_fieldexists('longbing_card_qn_answer',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_answer')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_qn_answer')) {
 if(!pdo_fieldexists('longbing_card_qn_answer',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_answer')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_qn_answer')) {
 if(!pdo_fieldexists('longbing_card_qn_answer',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_answer')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_qn_question')) {
 if(!pdo_fieldexists('longbing_card_qn_question',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_question')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_qn_question')) {
 if(!pdo_fieldexists('longbing_card_qn_question',  'naire_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_question')." ADD `naire_id` int(10) NOT NULL   COMMENT '问卷id';");
 }
}
if(pdo_tableexists('longbing_card_qn_question')) {
 if(!pdo_fieldexists('longbing_card_qn_question',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_question')." ADD `title` varchar(100) NOT NULL   COMMENT '问卷名称';");
 }
}
if(pdo_tableexists('longbing_card_qn_question')) {
 if(!pdo_fieldexists('longbing_card_qn_question',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_question')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_qn_question')) {
 if(!pdo_fieldexists('longbing_card_qn_question',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_question')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_qn_question')) {
 if(!pdo_fieldexists('longbing_card_qn_question',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_question')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_qn_question')) {
 if(!pdo_fieldexists('longbing_card_qn_question',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_question')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_qn_questionnaire')) {
 if(!pdo_fieldexists('longbing_card_qn_questionnaire',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_questionnaire')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_qn_questionnaire')) {
 if(!pdo_fieldexists('longbing_card_qn_questionnaire',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_questionnaire')." ADD `title` varchar(100) NOT NULL   COMMENT '问卷名称';");
 }
}
if(pdo_tableexists('longbing_card_qn_questionnaire')) {
 if(!pdo_fieldexists('longbing_card_qn_questionnaire',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_questionnaire')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_qn_questionnaire')) {
 if(!pdo_fieldexists('longbing_card_qn_questionnaire',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_questionnaire')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_qn_questionnaire')) {
 if(!pdo_fieldexists('longbing_card_qn_questionnaire',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_questionnaire')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_qn_questionnaire')) {
 if(!pdo_fieldexists('longbing_card_qn_questionnaire',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_qn_questionnaire')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_quick_reply')) {
 if(!pdo_fieldexists('longbing_card_quick_reply',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_quick_reply')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_quick_reply')) {
 if(!pdo_fieldexists('longbing_card_quick_reply',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_quick_reply')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_quick_reply')) {
 if(!pdo_fieldexists('longbing_card_quick_reply',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_quick_reply')." ADD `content` text();");
 }
}
if(pdo_tableexists('longbing_card_quick_reply')) {
 if(!pdo_fieldexists('longbing_card_quick_reply',  'number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_quick_reply')." ADD `number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_quick_reply')) {
 if(!pdo_fieldexists('longbing_card_quick_reply',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_quick_reply')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_quick_reply')) {
 if(!pdo_fieldexists('longbing_card_quick_reply',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_quick_reply')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_quick_reply')) {
 if(!pdo_fieldexists('longbing_card_quick_reply',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_quick_reply')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_quick_reply')) {
 if(!pdo_fieldexists('longbing_card_quick_reply',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_quick_reply')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_quick_reply')) {
 if(!pdo_fieldexists('longbing_card_quick_reply',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_quick_reply')." ADD `type` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_quick_reply')) {
 if(!pdo_fieldexists('longbing_card_quick_reply',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_quick_reply')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'sign')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `sign` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `type` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'mini')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `mini` int(10) NOT NULL   COMMENT '发送激励提醒最小取值';");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'max')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `max` int(10) NOT NULL   COMMENT '发送激励提醒最大取值';");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `pid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'msg')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `msg` varchar(100) NOT NULL   COMMENT '发送激励提醒内容';");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'operation')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `operation` varchar(100) NOT NULL   COMMENT '客户操作';");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'item')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `item` varchar(100) NOT NULL   COMMENT '客户操作的内容';");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'show_count')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `show_count` int(3) NOT NULL   COMMENT '是否展示第几次';");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'table_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `table_name` varchar(100) NOT NULL   COMMENT '对象表名';");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'field')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `field` varchar(100) NOT NULL   COMMENT '数据表中的字段，多个字段用英文逗号隔开';");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'send')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `send` int(3) NOT NULL   COMMENT '是否发送通知 0 = 不发送，1 = 员工，2 = 客户，3 = 员工和客户';");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_radar_msg')) {
 if(!pdo_fieldexists('longbing_card_radar_msg',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_radar_msg')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_rate')) {
 if(!pdo_fieldexists('longbing_card_rate',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_rate')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_rate')) {
 if(!pdo_fieldexists('longbing_card_rate',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_rate')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_rate')) {
 if(!pdo_fieldexists('longbing_card_rate',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_rate')." ADD `staff_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_rate')) {
 if(!pdo_fieldexists('longbing_card_rate',  'rate')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_rate')." ADD `rate` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_rate')) {
 if(!pdo_fieldexists('longbing_card_rate',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_rate')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_rate')) {
 if(!pdo_fieldexists('longbing_card_rate',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_rate')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_rate')) {
 if(!pdo_fieldexists('longbing_card_rate',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_rate')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_reply_type')) {
 if(!pdo_fieldexists('longbing_card_reply_type',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_reply_type')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_reply_type')) {
 if(!pdo_fieldexists('longbing_card_reply_type',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_reply_type')." ADD `title` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_reply_type')) {
 if(!pdo_fieldexists('longbing_card_reply_type',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_reply_type')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_reply_type')) {
 if(!pdo_fieldexists('longbing_card_reply_type',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_reply_type')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_reply_type')) {
 if(!pdo_fieldexists('longbing_card_reply_type',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_reply_type')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_reply_type')) {
 if(!pdo_fieldexists('longbing_card_reply_type',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_reply_type')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_reply_type')) {
 if(!pdo_fieldexists('longbing_card_reply_type',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_reply_type')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_cash_water')) {
 if(!pdo_fieldexists('longbing_card_selling_cash_water',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_cash_water')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_selling_cash_water')) {
 if(!pdo_fieldexists('longbing_card_selling_cash_water',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_cash_water')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_selling_cash_water')) {
 if(!pdo_fieldexists('longbing_card_selling_cash_water',  'account')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_cash_water')." ADD `account` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_cash_water')) {
 if(!pdo_fieldexists('longbing_card_selling_cash_water',  'money')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_cash_water')." ADD `money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '提现金额';");
 }
}
if(pdo_tableexists('longbing_card_selling_cash_water')) {
 if(!pdo_fieldexists('longbing_card_selling_cash_water',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_cash_water')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_cash_water')) {
 if(!pdo_fieldexists('longbing_card_selling_cash_water',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_cash_water')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_selling_cash_water')) {
 if(!pdo_fieldexists('longbing_card_selling_cash_water',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_cash_water')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_cash_water')) {
 if(!pdo_fieldexists('longbing_card_selling_cash_water',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_cash_water')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_cash_water')) {
 if(!pdo_fieldexists('longbing_card_selling_cash_water',  'cash_no')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_cash_water')." ADD `cash_no` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_profit')) {
 if(!pdo_fieldexists('longbing_card_selling_profit',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_profit')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_selling_profit')) {
 if(!pdo_fieldexists('longbing_card_selling_profit',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_profit')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_selling_profit')) {
 if(!pdo_fieldexists('longbing_card_selling_profit',  'total_profit')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_profit')." ADD `total_profit` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '总收益';");
 }
}
if(pdo_tableexists('longbing_card_selling_profit')) {
 if(!pdo_fieldexists('longbing_card_selling_profit',  'total_postal')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_profit')." ADD `total_postal` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '总提现';");
 }
}
if(pdo_tableexists('longbing_card_selling_profit')) {
 if(!pdo_fieldexists('longbing_card_selling_profit',  'postaling')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_profit')." ADD `postaling` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '提现中';");
 }
}
if(pdo_tableexists('longbing_card_selling_profit')) {
 if(!pdo_fieldexists('longbing_card_selling_profit',  'waiting')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_profit')." ADD `waiting` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_selling_profit')) {
 if(!pdo_fieldexists('longbing_card_selling_profit',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_profit')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_profit')) {
 if(!pdo_fieldexists('longbing_card_selling_profit',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_profit')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_selling_profit')) {
 if(!pdo_fieldexists('longbing_card_selling_profit',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_profit')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_profit')) {
 if(!pdo_fieldexists('longbing_card_selling_profit',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_profit')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_profit')) {
 if(!pdo_fieldexists('longbing_card_selling_profit',  'profit')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_profit')." ADD `profit` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'source_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `source_id` int(10) NOT NULL   COMMENT '来源用户id';");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'order_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `order_id` int(10) NOT NULL   COMMENT '订单id';");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `type` int(10) NOT NULL   COMMENT '类型 1=>员工提成；2=>一级上线提成；3=>二级上线提成';");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `title` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'img')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `img` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '售价';");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'extract')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `extract` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '提成百分比';");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'waiting')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `waiting` int(10) NOT NULL   COMMENT '1=>未入账';");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `goods_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_selling_water')) {
 if(!pdo_fieldexists('longbing_card_selling_water',  'buy_number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_selling_water')." ADD `buy_number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `user_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'openGId')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `openGId` varchar(100) NOT NULL   COMMENT '群对当前小程序的唯一 ID';");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'view_card')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `view_card` int(10) NOT NULL   COMMENT '浏览名片的次数';");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'view_custom_qr')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `view_custom_qr` varchar(1000) NOT NULL   COMMENT '浏览自定义码集合';");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'view_goods')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `view_goods` varchar(1000) NOT NULL   COMMENT '浏览商品集合';");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'view_timeline')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `view_timeline` varchar(1000) NOT NULL   COMMENT '浏览商品集合';");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'client_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `client_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_share_group')) {
 if(!pdo_fieldexists('longbing_card_share_group',  'target_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_share_group')." ADD `target_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `name` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'sex')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `sex` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `phone` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'address')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `address` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'address_detail')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `address_detail` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'province')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `province` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'city')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `city` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'area')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `area` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'is_default')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `is_default` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_address')) {
 if(!pdo_fieldexists('longbing_card_shop_address',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_address')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_carousel')) {
 if(!pdo_fieldexists('longbing_card_shop_carousel',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_carousel')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_carousel')) {
 if(!pdo_fieldexists('longbing_card_shop_carousel',  'c_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_carousel')." ADD `c_id` int(10) NOT NULL   COMMENT '公司id';");
 }
}
if(pdo_tableexists('longbing_card_shop_carousel')) {
 if(!pdo_fieldexists('longbing_card_shop_carousel',  'img')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_carousel')." ADD `img` varchar(300) NOT NULL   COMMENT '图片地址';");
 }
}
if(pdo_tableexists('longbing_card_shop_carousel')) {
 if(!pdo_fieldexists('longbing_card_shop_carousel',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_carousel')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_carousel')) {
 if(!pdo_fieldexists('longbing_card_shop_carousel',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_carousel')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_carousel')) {
 if(!pdo_fieldexists('longbing_card_shop_carousel',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_carousel')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_carousel')) {
 if(!pdo_fieldexists('longbing_card_shop_carousel',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_carousel')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_carousel')) {
 if(!pdo_fieldexists('longbing_card_shop_carousel',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_carousel')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_collage',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_collage',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage')." ADD `goods_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_collage',  'spe_price_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage')." ADD `spe_price_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_collage',  'number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage')." ADD `number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_collage',  'people')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage')." ADD `people` int(10) NOT NULL DEFAULT NULL DEFAULT '2';");
 }
}
if(pdo_tableexists('longbing_card_shop_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_collage',  'price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_shop_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_collage',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_collage',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_collage',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_collage',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_collage',  'limit')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage')." ADD `limit` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `user_id` int(10) NOT NULL   COMMENT '发起拼团人';");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `goods_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'collage_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `collage_id` int(10) NOT NULL   COMMENT '拼团条件id';");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `name` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `cover` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `number` int(10) NOT NULL   COMMENT '拼团人数';");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '单价';");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'collage_status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `collage_status` int(3) NOT NULL   COMMENT '拼团状态 0=>未支付; 1=>拼团中; 2=>拼团人满; 3=>拼团完成; 4=>拼团失败';");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_collage_list')) {
 if(!pdo_fieldexists('longbing_card_shop_collage_list',  'left_number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_collage_list')." ADD `left_number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'address_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `address_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'pay_status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `pay_status` int(3) NOT NULL   COMMENT '支付状态 0=>未支付; 1=>已支付; 2=>已退款';");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'order_status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `order_status` int(3) NOT NULL   COMMENT '订单状态 0=>未完成; 1=>已取消 2=>已发货; 3=>已完成; 4=>已评价';");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `type` int(3) NOT NULL   COMMENT '订单类型 0=>普通订单; 1=>拼团订单';");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'collage_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `collage_id` int(3) NOT NULL   COMMENT '拼团记录id';");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'freight')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `freight` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'total_price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `total_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'out_trade_no')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `out_trade_no` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'courier_number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `courier_number` varchar(50) NOT NULL   COMMENT '快递单号';");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `name` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'sex')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `sex` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `phone` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'address')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `address` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'address_detail')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `address_detail` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'province')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `province` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'city')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `city` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'area')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `area` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'to_uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `to_uid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'out_refund_no')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `out_refund_no` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'express_company')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `express_company` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'express_phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `express_phone` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'record_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `record_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'record_money')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `record_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'transaction_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `transaction_id` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'write_off_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `write_off_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'refund_status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `refund_status` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'company_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `company_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'zt_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `zt_name` varchar(30) NOT NULL   COMMENT '自提订单的客户姓名';");
 }
}
if(pdo_tableexists('longbing_card_shop_order')) {
 if(!pdo_fieldexists('longbing_card_shop_order',  'zt_phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order')." ADD `zt_phone` varchar(30) NOT NULL   COMMENT '自提订单的客户联系方式';");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'order_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `order_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `goods_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `name` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `cover` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'spe_price_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `spe_price_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `content` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_item')) {
 if(!pdo_fieldexists('longbing_card_shop_order_item',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_item')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_refund')) {
 if(!pdo_fieldexists('longbing_card_shop_order_refund',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_refund')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_refund')) {
 if(!pdo_fieldexists('longbing_card_shop_order_refund',  'order_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_refund')." ADD `order_id` int(10) NOT NULL   COMMENT '订单id';");
 }
}
if(pdo_tableexists('longbing_card_shop_order_refund')) {
 if(!pdo_fieldexists('longbing_card_shop_order_refund',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_refund')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_refund')) {
 if(!pdo_fieldexists('longbing_card_shop_order_refund',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_refund')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '1 => 退款中, 2 => 已退款, 3 => 已拒绝';");
 }
}
if(pdo_tableexists('longbing_card_shop_order_refund')) {
 if(!pdo_fieldexists('longbing_card_shop_order_refund',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_refund')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_order_refund')) {
 if(!pdo_fieldexists('longbing_card_shop_order_refund',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_order_refund')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_search')) {
 if(!pdo_fieldexists('longbing_card_shop_search',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_search')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_search')) {
 if(!pdo_fieldexists('longbing_card_shop_search',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_search')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_search')) {
 if(!pdo_fieldexists('longbing_card_shop_search',  'keyword')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_search')." ADD `keyword` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_search')) {
 if(!pdo_fieldexists('longbing_card_shop_search',  'number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_search')." ADD `number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_search')) {
 if(!pdo_fieldexists('longbing_card_shop_search',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_search')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_search')) {
 if(!pdo_fieldexists('longbing_card_shop_search',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_search')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_search')) {
 if(!pdo_fieldexists('longbing_card_shop_search',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_search')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_search')) {
 if(!pdo_fieldexists('longbing_card_shop_search',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_search')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe')) {
 if(!pdo_fieldexists('longbing_card_shop_spe',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe')) {
 if(!pdo_fieldexists('longbing_card_shop_spe',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe')." ADD `goods_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe')) {
 if(!pdo_fieldexists('longbing_card_shop_spe',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe')." ADD `title` varchar(20) NOT NULL   COMMENT '规格名';");
 }
}
if(pdo_tableexists('longbing_card_shop_spe')) {
 if(!pdo_fieldexists('longbing_card_shop_spe',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe')." ADD `pid` int(10) NOT NULL   COMMENT '0=>顶级规格;其他=>上级规格id';");
 }
}
if(pdo_tableexists('longbing_card_shop_spe')) {
 if(!pdo_fieldexists('longbing_card_shop_spe',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe')) {
 if(!pdo_fieldexists('longbing_card_shop_spe',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_spe')) {
 if(!pdo_fieldexists('longbing_card_shop_spe',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe')) {
 if(!pdo_fieldexists('longbing_card_shop_spe',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe_price')) {
 if(!pdo_fieldexists('longbing_card_shop_spe_price',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe_price')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe_price')) {
 if(!pdo_fieldexists('longbing_card_shop_spe_price',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe_price')." ADD `goods_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe_price')) {
 if(!pdo_fieldexists('longbing_card_shop_spe_price',  'spe_id_1')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe_price')." ADD `spe_id_1` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe_price')) {
 if(!pdo_fieldexists('longbing_card_shop_spe_price',  'spe_id_2')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe_price')." ADD `spe_id_2` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe_price')) {
 if(!pdo_fieldexists('longbing_card_shop_spe_price',  'price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe_price')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_shop_spe_price')) {
 if(!pdo_fieldexists('longbing_card_shop_spe_price',  'stock')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe_price')." ADD `stock` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe_price')) {
 if(!pdo_fieldexists('longbing_card_shop_spe_price',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe_price')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe_price')) {
 if(!pdo_fieldexists('longbing_card_shop_spe_price',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe_price')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_spe_price')) {
 if(!pdo_fieldexists('longbing_card_shop_spe_price',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe_price')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_spe_price')) {
 if(!pdo_fieldexists('longbing_card_shop_spe_price',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_spe_price')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_standard')) {
 if(!pdo_fieldexists('longbing_card_shop_standard',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_standard')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_standard')) {
 if(!pdo_fieldexists('longbing_card_shop_standard',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_standard')." ADD `goods_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_standard')) {
 if(!pdo_fieldexists('longbing_card_shop_standard',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_standard')." ADD `title` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_standard')) {
 if(!pdo_fieldexists('longbing_card_shop_standard',  'price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_standard')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_shop_standard')) {
 if(!pdo_fieldexists('longbing_card_shop_standard',  'stock')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_standard')." ADD `stock` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_standard')) {
 if(!pdo_fieldexists('longbing_card_shop_standard',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_standard')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_standard')) {
 if(!pdo_fieldexists('longbing_card_shop_standard',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_standard')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_standard')) {
 if(!pdo_fieldexists('longbing_card_shop_standard',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_standard')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_standard')) {
 if(!pdo_fieldexists('longbing_card_shop_standard',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_standard')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `goods_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `name` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `cover` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'spe_price_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `spe_price_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `content` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'freight')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `freight` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_trolley')) {
 if(!pdo_fieldexists('longbing_card_shop_trolley',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_trolley')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_type')) {
 if(!pdo_fieldexists('longbing_card_shop_type',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_type')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_type')) {
 if(!pdo_fieldexists('longbing_card_shop_type',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_type')." ADD `title` varchar(20) NOT NULL   COMMENT '分类名';");
 }
}
if(pdo_tableexists('longbing_card_shop_type')) {
 if(!pdo_fieldexists('longbing_card_shop_type',  'cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_type')." ADD `cover` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_type')) {
 if(!pdo_fieldexists('longbing_card_shop_type',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_type')." ADD `pid` int(10) NOT NULL   COMMENT '0=>顶级分类;其他=>上级分类id';");
 }
}
if(pdo_tableexists('longbing_card_shop_type')) {
 if(!pdo_fieldexists('longbing_card_shop_type',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_type')." ADD `top` int(10) NOT NULL   COMMENT '排序值, 倒序';");
 }
}
if(pdo_tableexists('longbing_card_shop_type')) {
 if(!pdo_fieldexists('longbing_card_shop_type',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_type')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_type')) {
 if(!pdo_fieldexists('longbing_card_shop_type',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_type')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_type')) {
 if(!pdo_fieldexists('longbing_card_shop_type',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_type')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_type')) {
 if(!pdo_fieldexists('longbing_card_shop_type',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_type')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_user_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_user_collage',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_user_collage')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_shop_user_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_user_collage',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_user_collage')." ADD `user_id` int(10) NOT NULL   COMMENT '发起拼团人';");
 }
}
if(pdo_tableexists('longbing_card_shop_user_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_user_collage',  'collage_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_user_collage')." ADD `collage_id` int(10) NOT NULL   COMMENT '拼团条件id';");
 }
}
if(pdo_tableexists('longbing_card_shop_user_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_user_collage',  'collage_status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_user_collage')." ADD `collage_status` int(3) NOT NULL   COMMENT '拼团状态 0=>未支付; 1=>拼团中; 2=>拼团人满; 3=>拼团完成; 4=>拼团失败';");
 }
}
if(pdo_tableexists('longbing_card_shop_user_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_user_collage',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_user_collage')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_user_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_user_collage',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_user_collage')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_shop_user_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_user_collage',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_user_collage')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_shop_user_collage')) {
 if(!pdo_fieldexists('longbing_card_shop_user_collage',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_shop_user_collage')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `name` varchar(100) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `cover` varchar(500) NOT NULL   COMMENT '头像';");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'job')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `job` varchar(20) NOT NULL   COMMENT '职位';");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'experience1')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `experience1` varchar(100) NOT NULL   COMMENT '经历1';");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'experience2')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `experience2` varchar(100) NOT NULL   COMMENT '经历2';");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'experience3')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `experience3` varchar(100) NOT NULL   COMMENT '经历3';");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `top` int(10) NOT NULL   COMMENT '排序值';");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_staffs')) {
 if(!pdo_fieldexists('longbing_card_staffs',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_staffs')." ADD `modular_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_start')) {
 if(!pdo_fieldexists('longbing_card_start',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_start')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_start')) {
 if(!pdo_fieldexists('longbing_card_start',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_start')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_start')) {
 if(!pdo_fieldexists('longbing_card_start',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_start')." ADD `staff_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_start')) {
 if(!pdo_fieldexists('longbing_card_start',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_start')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_start')) {
 if(!pdo_fieldexists('longbing_card_start',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_start')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_start')) {
 if(!pdo_fieldexists('longbing_card_start',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_start')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_start')) {
 if(!pdo_fieldexists('longbing_card_start',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_start')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu1_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu1_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '名片';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu2_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu2_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '商城';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu3_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu3_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '动态';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu4_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu4_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '官网';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu1_is_hide')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu1_is_hide` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu2_is_hide')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu2_is_hide` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu3_is_hide')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu3_is_hide` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu4_is_hide')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu4_is_hide` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu1_url')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu1_url` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu2_url')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu2_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT 'longbing_card/pages/index/index?currentTabBar=toShop';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu3_url')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu3_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT 'longbing_card/pages/index/index?currentTabBar=toNews';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu4_url')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu4_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT 'longbing_card/pages/index/index?currentTabBar=toCompany';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu1_url_out')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu1_url_out` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu2_url_out')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu2_url_out` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu3_url_out')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu3_url_out` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu4_url_out')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu4_url_out` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu1_url_jump_way')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu1_url_jump_way` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu2_url_jump_way')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu2_url_jump_way` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu3_url_jump_way')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu3_url_jump_way` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu4_url_jump_way')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu4_url_jump_way` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_appoint_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_appoint_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '预约';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_appoint_is_hide')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_appoint_is_hide` int(10) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_appoint_url')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_appoint_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT '/longbing_card/reserve/pages/index/index';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_appoint_url_out')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_appoint_url_out` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_appoint_url_jump_way')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_appoint_url_jump_way` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_activity_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_activity_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '活动报名';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_activity_is_show')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_activity_is_show` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_activity_url')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_activity_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT '/longbing_card/enroll/pages/index';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_activity_url_out')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_activity_url_out` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_activity_url_jump_way')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_activity_url_jump_way` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_house_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_house_name` varchar(20) NOT NULL DEFAULT NULL DEFAULT '房产';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_house_is_show')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_house_is_show` int(2) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '是否展示';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_house_url')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_house_url` varchar(500) NOT NULL DEFAULT NULL DEFAULT '/longbing_card/house/pages/index/index';");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_house_url_out')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_house_url_out` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tabbar')) {
 if(!pdo_fieldexists('longbing_card_tabbar',  'menu_house_url_jump_way')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tabbar')." ADD `menu_house_url_jump_way` int(2) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tags')) {
 if(!pdo_fieldexists('longbing_card_tags',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tags')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_tags')) {
 if(!pdo_fieldexists('longbing_card_tags',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tags')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_tags')) {
 if(!pdo_fieldexists('longbing_card_tags',  'tag')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tags')." ADD `tag` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tags')) {
 if(!pdo_fieldexists('longbing_card_tags',  'count')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tags')." ADD `count` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tags')) {
 if(!pdo_fieldexists('longbing_card_tags',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tags')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tags')) {
 if(!pdo_fieldexists('longbing_card_tags',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tags')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_tags')) {
 if(!pdo_fieldexists('longbing_card_tags',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tags')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tags')) {
 if(!pdo_fieldexists('longbing_card_tags',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tags')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_tags')) {
 if(!pdo_fieldexists('longbing_card_tags',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_tags')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `title` varchar(100) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `cover` varchar(5000) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `content` longtext();");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `top` int(10) NOT NULL   COMMENT '排序值';");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `type` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'url_type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `url_type` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_timeline')) {
 if(!pdo_fieldexists('longbing_card_timeline',  'article_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline')." ADD `article_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline_comment')) {
 if(!pdo_fieldexists('longbing_card_timeline_comment',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_comment')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_timeline_comment')) {
 if(!pdo_fieldexists('longbing_card_timeline_comment',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_comment')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline_comment')) {
 if(!pdo_fieldexists('longbing_card_timeline_comment',  'timeline_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_comment')." ADD `timeline_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline_comment')) {
 if(!pdo_fieldexists('longbing_card_timeline_comment',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_comment')." ADD `content` varchar(1000) NOT NULL   COMMENT '鍐呭';");
 }
}
if(pdo_tableexists('longbing_card_timeline_comment')) {
 if(!pdo_fieldexists('longbing_card_timeline_comment',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_comment')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline_comment')) {
 if(!pdo_fieldexists('longbing_card_timeline_comment',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_comment')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_timeline_comment')) {
 if(!pdo_fieldexists('longbing_card_timeline_comment',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_comment')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline_comment')) {
 if(!pdo_fieldexists('longbing_card_timeline_comment',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_comment')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline_thumbs')) {
 if(!pdo_fieldexists('longbing_card_timeline_thumbs',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_thumbs')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_timeline_thumbs')) {
 if(!pdo_fieldexists('longbing_card_timeline_thumbs',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_thumbs')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline_thumbs')) {
 if(!pdo_fieldexists('longbing_card_timeline_thumbs',  'timeline_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_thumbs')." ADD `timeline_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline_thumbs')) {
 if(!pdo_fieldexists('longbing_card_timeline_thumbs',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_thumbs')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline_thumbs')) {
 if(!pdo_fieldexists('longbing_card_timeline_thumbs',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_thumbs')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_timeline_thumbs')) {
 if(!pdo_fieldexists('longbing_card_timeline_thumbs',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_thumbs')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_timeline_thumbs')) {
 if(!pdo_fieldexists('longbing_card_timeline_thumbs',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_timeline_thumbs')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `openid` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'nickName')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `nickName` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'avatarUrl')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `avatarUrl` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `pid` int(10) NOT NULL   COMMENT '上级id';");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'is_staff')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `is_staff` tinyint(4) NOT NULL   COMMENT '是否是公司员工  1 是否 0 不是';");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'is_qr')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `is_qr` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'is_group')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `is_group` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `type` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'target_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `target_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'scene')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `scene` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'openGId')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `openGId` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'qr_path')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `qr_path` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'is_boss')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `is_boss` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'create_money')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `create_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'ip')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `ip` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'import')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `import` int(3) NOT NULL   COMMENT '是否是后台导入';");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'pay_qr')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `pay_qr` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'unionid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `unionid` varchar(40) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'is_article')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `is_article` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'lock_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `lock_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'city')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `city` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'province')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `province` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'country')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `country` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'gender')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `gender` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user')) {
 if(!pdo_fieldexists('longbing_card_user',  'language')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user')." ADD `language` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_follow')) {
 if(!pdo_fieldexists('longbing_card_user_follow',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_follow')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_user_follow')) {
 if(!pdo_fieldexists('longbing_card_user_follow',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_follow')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_follow')) {
 if(!pdo_fieldexists('longbing_card_user_follow',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_follow')." ADD `staff_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_follow')) {
 if(!pdo_fieldexists('longbing_card_user_follow',  'content')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_follow')." ADD `content` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_follow')) {
 if(!pdo_fieldexists('longbing_card_user_follow',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_follow')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user_follow')) {
 if(!pdo_fieldexists('longbing_card_user_follow',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_follow')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_follow')) {
 if(!pdo_fieldexists('longbing_card_user_follow',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_follow')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_follow')) {
 if(!pdo_fieldexists('longbing_card_user_follow',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_follow')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_follow')) {
 if(!pdo_fieldexists('longbing_card_user_follow',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_follow')." ADD `type` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'fans_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `fans_id` int(11) NOT NULL   COMMENT '对应ims_mc_mapping_fans 表id';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'is_staff')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `is_staff` tinyint(2) NOT NULL   COMMENT '是否是公司员工  1 是 0 不是';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `name` varchar(50) NOT NULL   COMMENT '员工名字';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'avatar')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `avatar` varchar(255) NOT NULL   COMMENT '头像';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'job_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `job_id` int(11) NOT NULL   COMMENT '职位id';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'company_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `company_id` int(11) NOT NULL   COMMENT '公司id';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `phone` varchar(20) NOT NULL   COMMENT '手机号';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'wechat')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `wechat` varchar(50) NOT NULL   COMMENT '微信';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'telephone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `telephone` varchar(20) NOT NULL   COMMENT '电话';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'email')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `email` varchar(50) NOT NULL   COMMENT '邮箱';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'voice')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `voice` varchar(500)    COMMENT '语音介绍';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'voice_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `voice_time` int(10) NOT NULL   COMMENT '语音长短';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'desc')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `desc` varchar(255) NOT NULL   COMMENT '个性签名';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'images')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `images` text();");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'is_default')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `is_default` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `top` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'my_url')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `my_url` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'my_video')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `my_video` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'card_type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `card_type` varchar(50) NOT NULL DEFAULT NULL DEFAULT 'cardType1';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'my_video_cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `my_video_cover` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'share_text')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `share_text` varchar(2000) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  't_number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `t_number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'view_number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `view_number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'phone400')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `phone400` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'ww_account')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `ww_account` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'bg')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `bg` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'bg_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `bg_switch` int(4) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'autograph')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `autograph` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'signature')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `signature` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'vr_tittle')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `vr_tittle` varchar(50) NOT NULL DEFAULT NULL DEFAULT 'VR全景';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'vr_cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `vr_cover` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'vr_path')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `vr_path` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'vr_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `vr_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'auto_count')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `auto_count` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_info')) {
 if(!pdo_fieldexists('longbing_card_user_info',  'share_number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_info')." ADD `share_number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_label')) {
 if(!pdo_fieldexists('longbing_card_user_label',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_label')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_user_label')) {
 if(!pdo_fieldexists('longbing_card_user_label',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_label')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_user_label')) {
 if(!pdo_fieldexists('longbing_card_user_label',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_label')." ADD `staff_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_user_label')) {
 if(!pdo_fieldexists('longbing_card_user_label',  'lable_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_label')." ADD `lable_id` int(10) NOT NULL   COMMENT '标签id';");
 }
}
if(pdo_tableexists('longbing_card_user_label')) {
 if(!pdo_fieldexists('longbing_card_user_label',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_label')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user_label')) {
 if(!pdo_fieldexists('longbing_card_user_label',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_label')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_label')) {
 if(!pdo_fieldexists('longbing_card_user_label',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_label')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_label')) {
 if(!pdo_fieldexists('longbing_card_user_label',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_label')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_mark')) {
 if(!pdo_fieldexists('longbing_card_user_mark',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_mark')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_user_mark')) {
 if(!pdo_fieldexists('longbing_card_user_mark',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_mark')." ADD `user_id` int(10) NOT NULL   COMMENT '用户转发人的id';");
 }
}
if(pdo_tableexists('longbing_card_user_mark')) {
 if(!pdo_fieldexists('longbing_card_user_mark',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_mark')." ADD `staff_id` int(10) NOT NULL   COMMENT '员工id';");
 }
}
if(pdo_tableexists('longbing_card_user_mark')) {
 if(!pdo_fieldexists('longbing_card_user_mark',  'mark')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_mark')." ADD `mark` int(3) NOT NULL   COMMENT '1=>跟进中,2=>已成交';");
 }
}
if(pdo_tableexists('longbing_card_user_mark')) {
 if(!pdo_fieldexists('longbing_card_user_mark',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_mark')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user_mark')) {
 if(!pdo_fieldexists('longbing_card_user_mark',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_mark')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_mark')) {
 if(!pdo_fieldexists('longbing_card_user_mark',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_mark')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_mark')) {
 if(!pdo_fieldexists('longbing_card_user_mark',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_mark')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_phone')) {
 if(!pdo_fieldexists('longbing_card_user_phone',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_phone')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_user_phone')) {
 if(!pdo_fieldexists('longbing_card_user_phone',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_phone')." ADD `user_id` int(10) NOT NULL   COMMENT '发起会话的用户id';");
 }
}
if(pdo_tableexists('longbing_card_user_phone')) {
 if(!pdo_fieldexists('longbing_card_user_phone',  'to_uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_phone')." ADD `to_uid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_phone')) {
 if(!pdo_fieldexists('longbing_card_user_phone',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_phone')." ADD `phone` varchar(20) NOT NULL   COMMENT '手机号';");
 }
}
if(pdo_tableexists('longbing_card_user_phone')) {
 if(!pdo_fieldexists('longbing_card_user_phone',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_phone')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user_phone')) {
 if(!pdo_fieldexists('longbing_card_user_phone',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_phone')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_phone')) {
 if(!pdo_fieldexists('longbing_card_user_phone',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_phone')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_phone')) {
 if(!pdo_fieldexists('longbing_card_user_phone',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_phone')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_poster')) {
 if(!pdo_fieldexists('longbing_card_user_poster',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_poster')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_user_poster')) {
 if(!pdo_fieldexists('longbing_card_user_poster',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_poster')." ADD `title` varchar(500) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('longbing_card_user_poster')) {
 if(!pdo_fieldexists('longbing_card_user_poster',  'img')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_poster')." ADD `img` varchar(500) NOT NULL   COMMENT '海报链接';");
 }
}
if(pdo_tableexists('longbing_card_user_poster')) {
 if(!pdo_fieldexists('longbing_card_user_poster',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_poster')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_poster')) {
 if(!pdo_fieldexists('longbing_card_user_poster',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_poster')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_poster')) {
 if(!pdo_fieldexists('longbing_card_user_poster',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_poster')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_poster')) {
 if(!pdo_fieldexists('longbing_card_user_poster',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_poster')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user_poster')) {
 if(!pdo_fieldexists('longbing_card_user_poster',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_poster')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_poster')) {
 if(!pdo_fieldexists('longbing_card_user_poster',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_poster')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_shop')) {
 if(!pdo_fieldexists('longbing_card_user_shop',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_shop')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_user_shop')) {
 if(!pdo_fieldexists('longbing_card_user_shop',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_shop')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_shop')) {
 if(!pdo_fieldexists('longbing_card_user_shop',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_shop')." ADD `goods_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_shop')) {
 if(!pdo_fieldexists('longbing_card_user_shop',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_shop')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_shop')) {
 if(!pdo_fieldexists('longbing_card_user_shop',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_shop')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user_shop')) {
 if(!pdo_fieldexists('longbing_card_user_shop',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_shop')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_shop')) {
 if(!pdo_fieldexists('longbing_card_user_shop',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_shop')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_sk')) {
 if(!pdo_fieldexists('longbing_card_user_sk',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_sk')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_user_sk')) {
 if(!pdo_fieldexists('longbing_card_user_sk',  'sk')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_sk')." ADD `sk` varchar(500) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('longbing_card_user_sk')) {
 if(!pdo_fieldexists('longbing_card_user_sk',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_sk')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_sk')) {
 if(!pdo_fieldexists('longbing_card_user_sk',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_sk')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_sk')) {
 if(!pdo_fieldexists('longbing_card_user_sk',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_sk')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user_sk')) {
 if(!pdo_fieldexists('longbing_card_user_sk',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_sk')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_sk')) {
 if(!pdo_fieldexists('longbing_card_user_sk',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_sk')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_tags')) {
 if(!pdo_fieldexists('longbing_card_user_tags',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_tags')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_user_tags')) {
 if(!pdo_fieldexists('longbing_card_user_tags',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_tags')." ADD `user_id` int(10) NOT NULL   COMMENT '用户id';");
 }
}
if(pdo_tableexists('longbing_card_user_tags')) {
 if(!pdo_fieldexists('longbing_card_user_tags',  'tag_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_tags')." ADD `tag_id` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_tags')) {
 if(!pdo_fieldexists('longbing_card_user_tags',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_tags')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_tags')) {
 if(!pdo_fieldexists('longbing_card_user_tags',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_tags')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_user_tags')) {
 if(!pdo_fieldexists('longbing_card_user_tags',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_tags')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_user_tags')) {
 if(!pdo_fieldexists('longbing_card_user_tags',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_user_tags')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_v2_standard')) {
 if(!pdo_fieldexists('longbing_card_v2_standard',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_v2_standard')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_v2_standard')) {
 if(!pdo_fieldexists('longbing_card_v2_standard',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_v2_standard')." ADD `goods_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_v2_standard')) {
 if(!pdo_fieldexists('longbing_card_v2_standard',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_v2_standard')." ADD `title` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_v2_standard')) {
 if(!pdo_fieldexists('longbing_card_v2_standard',  'price')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_v2_standard')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('longbing_card_v2_standard')) {
 if(!pdo_fieldexists('longbing_card_v2_standard',  'stock')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_v2_standard')." ADD `stock` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_v2_standard')) {
 if(!pdo_fieldexists('longbing_card_v2_standard',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_v2_standard')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_v2_standard')) {
 if(!pdo_fieldexists('longbing_card_v2_standard',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_v2_standard')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_v2_standard')) {
 if(!pdo_fieldexists('longbing_card_v2_standard',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_v2_standard')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_v2_standard')) {
 if(!pdo_fieldexists('longbing_card_v2_standard',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_v2_standard')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'staff_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `staff_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'client')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `client` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'charm')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `charm` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'interaction')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `interaction` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'product')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `product` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'website')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `website` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'active')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `active` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_value')) {
 if(!pdo_fieldexists('longbing_card_value',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_value')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_video')) {
 if(!pdo_fieldexists('longbing_card_video',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_video')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_video')) {
 if(!pdo_fieldexists('longbing_card_video',  'cover')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_video')." ADD `cover` varchar(500) NOT NULL   COMMENT '视频封面图';");
 }
}
if(pdo_tableexists('longbing_card_video')) {
 if(!pdo_fieldexists('longbing_card_video',  'title')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_video')." ADD `title` varchar(500) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('longbing_card_video')) {
 if(!pdo_fieldexists('longbing_card_video',  'video')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_video')." ADD `video` varchar(500) NOT NULL   COMMENT '视频链接';");
 }
}
if(pdo_tableexists('longbing_card_video')) {
 if(!pdo_fieldexists('longbing_card_video',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_video')." ADD `modular_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_video')) {
 if(!pdo_fieldexists('longbing_card_video',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_video')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_video')) {
 if(!pdo_fieldexists('longbing_card_video',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_video')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_video')) {
 if(!pdo_fieldexists('longbing_card_video',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_video')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_video')) {
 if(!pdo_fieldexists('longbing_card_video',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_video')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_video')) {
 if(!pdo_fieldexists('longbing_card_video',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_video')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_view_count')) {
 if(!pdo_fieldexists('longbing_card_view_count',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_view_count')." ADD `id` int(20) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_view_count')) {
 if(!pdo_fieldexists('longbing_card_view_count',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_view_count')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_view_count')) {
 if(!pdo_fieldexists('longbing_card_view_count',  'to_uid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_view_count')." ADD `to_uid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_view_count')) {
 if(!pdo_fieldexists('longbing_card_view_count',  'type')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_view_count')." ADD `type` int(3) NOT NULL   COMMENT '浏览内容, 1=>浏览商城列表 2=>浏览商品详情 3=>浏览动态列表 4=>点赞动态 5=>动态留言 6=>浏览公司官网 7=>浏览动态详情';");
 }
}
if(pdo_tableexists('longbing_card_view_count')) {
 if(!pdo_fieldexists('longbing_card_view_count',  'target')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_view_count')." ADD `target` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_view_count')) {
 if(!pdo_fieldexists('longbing_card_view_count',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_view_count')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_view_count')) {
 if(!pdo_fieldexists('longbing_card_view_count',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_view_count')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_view_count')) {
 if(!pdo_fieldexists('longbing_card_view_count',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_view_count')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_web')) {
 if(!pdo_fieldexists('longbing_card_web',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_web')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_card_web')) {
 if(!pdo_fieldexists('longbing_card_web',  'web')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_web')." ADD `web` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_web')) {
 if(!pdo_fieldexists('longbing_card_web',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_web')." ADD `modular_id` int(5) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_web')) {
 if(!pdo_fieldexists('longbing_card_web',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_web')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_web')) {
 if(!pdo_fieldexists('longbing_card_web',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_web')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_card_web')) {
 if(!pdo_fieldexists('longbing_card_web',  'top')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_web')." ADD `top` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_web')) {
 if(!pdo_fieldexists('longbing_card_web',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_web')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_card_web')) {
 if(!pdo_fieldexists('longbing_card_web',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_card_web')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_activity')) {
 if(!pdo_fieldexists('longbing_cardauth2_activity',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_activity')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_cardauth2_activity')) {
 if(!pdo_fieldexists('longbing_cardauth2_activity',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_activity')." ADD `modular_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_activity')) {
 if(!pdo_fieldexists('longbing_cardauth2_activity',  'sign')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_activity')." ADD `sign` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_activity')) {
 if(!pdo_fieldexists('longbing_cardauth2_activity',  'count')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_activity')." ADD `count` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_activity')) {
 if(!pdo_fieldexists('longbing_cardauth2_activity',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_activity')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_activity')) {
 if(!pdo_fieldexists('longbing_cardauth2_activity',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_activity')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_activity')) {
 if(!pdo_fieldexists('longbing_cardauth2_activity',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_activity')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_activity')) {
 if(!pdo_fieldexists('longbing_cardauth2_activity',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_activity')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_article')) {
 if(!pdo_fieldexists('longbing_cardauth2_article',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_article')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_cardauth2_article')) {
 if(!pdo_fieldexists('longbing_cardauth2_article',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_article')." ADD `modular_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_article')) {
 if(!pdo_fieldexists('longbing_cardauth2_article',  'number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_article')." ADD `number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_article')) {
 if(!pdo_fieldexists('longbing_cardauth2_article',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_article')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_article')) {
 if(!pdo_fieldexists('longbing_cardauth2_article',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_article')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_article')) {
 if(!pdo_fieldexists('longbing_cardauth2_article',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_article')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_article')) {
 if(!pdo_fieldexists('longbing_cardauth2_article',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_article')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_boss')) {
 if(!pdo_fieldexists('longbing_cardauth2_boss',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_boss')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_cardauth2_boss')) {
 if(!pdo_fieldexists('longbing_cardauth2_boss',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_boss')." ADD `modular_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_boss')) {
 if(!pdo_fieldexists('longbing_cardauth2_boss',  'sign')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_boss')." ADD `sign` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_boss')) {
 if(!pdo_fieldexists('longbing_cardauth2_boss',  'count')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_boss')." ADD `count` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_boss')) {
 if(!pdo_fieldexists('longbing_cardauth2_boss',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_boss')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_boss')) {
 if(!pdo_fieldexists('longbing_cardauth2_boss',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_boss')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_boss')) {
 if(!pdo_fieldexists('longbing_cardauth2_boss',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_boss')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_boss')) {
 if(!pdo_fieldexists('longbing_cardauth2_boss',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_boss')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `modular_id` int(10) NOT NULL   COMMENT '模块id';");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `number` int(10) NOT NULL   COMMENT '限制创建名片的数量';");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `remark` varchar(200) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'end_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `end_time` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'mini_name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `mini_name` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'copyright_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `copyright_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'send_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `send_switch` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'boos')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `boos` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'appoint')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `appoint` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'payqr')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `payqr` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'shop_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `shop_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'timeline_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `timeline_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'website_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `website_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'article')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `article` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'activity_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `activity_switch` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'pay_shop')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `pay_shop` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'house_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `house_switch` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_config')) {
 if(!pdo_fieldexists('longbing_cardauth2_config',  'tool_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_config')." ADD `tool_switch` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_copyright')) {
 if(!pdo_fieldexists('longbing_cardauth2_copyright',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_copyright')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_cardauth2_copyright')) {
 if(!pdo_fieldexists('longbing_cardauth2_copyright',  'name')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_copyright')." ADD `name` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_copyright')) {
 if(!pdo_fieldexists('longbing_cardauth2_copyright',  'image')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_copyright')." ADD `image` varchar(300) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_copyright')) {
 if(!pdo_fieldexists('longbing_cardauth2_copyright',  'text')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_copyright')." ADD `text` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_copyright')) {
 if(!pdo_fieldexists('longbing_cardauth2_copyright',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_copyright')." ADD `phone` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_copyright')) {
 if(!pdo_fieldexists('longbing_cardauth2_copyright',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_copyright')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_copyright')) {
 if(!pdo_fieldexists('longbing_cardauth2_copyright',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_copyright')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_copyright')) {
 if(!pdo_fieldexists('longbing_cardauth2_copyright',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_copyright')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_copyright')) {
 if(!pdo_fieldexists('longbing_cardauth2_copyright',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_copyright')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_default')) {
 if(!pdo_fieldexists('longbing_cardauth2_default',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_default')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_cardauth2_default')) {
 if(!pdo_fieldexists('longbing_cardauth2_default',  'card_number')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_default')." ADD `card_number` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_default')) {
 if(!pdo_fieldexists('longbing_cardauth2_default',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_default')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_default')) {
 if(!pdo_fieldexists('longbing_cardauth2_default',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_default')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_default')) {
 if(!pdo_fieldexists('longbing_cardauth2_default',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_default')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_default')) {
 if(!pdo_fieldexists('longbing_cardauth2_default',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_default')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_default')) {
 if(!pdo_fieldexists('longbing_cardauth2_default',  'send_switch')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_default')." ADD `send_switch` int(3) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_house')) {
 if(!pdo_fieldexists('longbing_cardauth2_house',  'id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_house')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('longbing_cardauth2_house')) {
 if(!pdo_fieldexists('longbing_cardauth2_house',  'modular_id')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_house')." ADD `modular_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_house')) {
 if(!pdo_fieldexists('longbing_cardauth2_house',  'sign')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_house')." ADD `sign` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_house')) {
 if(!pdo_fieldexists('longbing_cardauth2_house',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_house')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_house')) {
 if(!pdo_fieldexists('longbing_cardauth2_house',  'status')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_house')." ADD `status` int(3) NOT NULL DEFAULT NULL DEFAULT '1';");
 }
}
if(pdo_tableexists('longbing_cardauth2_house')) {
 if(!pdo_fieldexists('longbing_cardauth2_house',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_house')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_house')) {
 if(!pdo_fieldexists('longbing_cardauth2_house',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_house')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('longbing_cardauth2_house')) {
 if(!pdo_fieldexists('longbing_cardauth2_house',  'count')) {
  pdo_query("ALTER TABLE ".tablename('longbing_cardauth2_house')." ADD `count` int(10) NOT NULL;");
 }
}
