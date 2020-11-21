<?php 
$sql="CREATE TABLE IF NOT EXISTS `ims_silence_vote_agenthb` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `bill_data` mediumtext NOT NULL COMMENT '海报数据',
  `config` mediumtext COMMENT '相关配置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_agentlevel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `level` int(11) DEFAULT '0',
  `levelname` varchar(255) DEFAULT '0',
  `isdefault` tinyint(1) DEFAULT '0' COMMENT '是否默认等级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_agentlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `username` varchar(255) DEFAULT '',
  `password` varchar(255) DEFAULT '' COMMENT '密码',
  `realname` varchar(255) DEFAULT '' COMMENT '真实姓名',
  `phonenum` varchar(255) DEFAULT '' COMMENT '手机',
  `status` tinyint(1) DEFAULT '0' COMMENT '审核状态',
  `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `agentrecommend` int(11) DEFAULT '0' COMMENT '推荐人id',
  `agentlevel` int(11) DEFAULT '0' COMMENT '经纪人等级',
  `moneyqr` varchar(500) DEFAULT '' COMMENT '收款码',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  `focusticket` varchar(255) DEFAULT '' COMMENT '公众号二维码ticket',
  `focusexpire` int(11) DEFAULT '0' COMMENT 'ticket过期时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_agentqrcode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `agent_id` int(11) DEFAULT '0',
  `qr_path` varchar(500) DEFAULT '' COMMENT '二维码路径',
  `url` varchar(500) DEFAULT '' COMMENT '链接',
  `rid` int(10) DEFAULT '0' COMMENT '活动规则id',
  `createtime` int(10) DEFAULT '0' COMMENT '申请时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_agentread` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `read_id` int(10) DEFAULT '0' COMMENT '活动rid 站内信id',
  `type` varchar(50) DEFAULT '' COMMENT '已读种类 act活动 mesg站内信',
  `agent_id` int(10) DEFAULT '0' COMMENT '经纪人id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_blacklist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `type` varchar(1) DEFAULT '0',
  `value` varchar(50) DEFAULT NULL COMMENT '值',
  `content` varchar(50) DEFAULT NULL COMMENT '昵称，IP地区',
  `status` tinyint(1) DEFAULT '0',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `content` (`content`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_commandvote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `rid` int(11) DEFAULT '0' COMMENT '规则id',
  `commandword` varchar(255) DEFAULT '' COMMENT '口令',
  `commandpiaoshu` int(11) DEFAULT '0' COMMENT '口令抵票数',
  `ismirror` tinyint(1) DEFAULT '0' COMMENT '是否镜像口令',
  `mirrorid` int(11) DEFAULT '0' COMMENT '镜像id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_count` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `pv_total` int(1) NOT NULL,
  `share_total` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`),
  KEY `indx_rid` (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=981 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_domainlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `rid` int(11) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0' COMMENT '1，主域名，0备选域名',
  `domain` varchar(50) DEFAULT NULL COMMENT '域名',
  `extensive` tinyint(1) DEFAULT '0' COMMENT '是否泛域名',
  `description` varchar(255) NOT NULL COMMENT '备注',
  `status` tinyint(1) DEFAULT '0',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `content` (`domain`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_fansdata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(50) NOT NULL COMMENT '用户openid',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `indx_openid` (`openid`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_gift` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `ptid` varchar(128) NOT NULL COMMENT '订单号',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `uniontid` varchar(30) NOT NULL COMMENT '商户单号',
  `paytype` varchar(20) NOT NULL COMMENT '支付类型',
  `oauth_openid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `user_ip` varchar(15) NOT NULL COMMENT '客户端ip',
  `gifttitle` varchar(8) DEFAULT '0' COMMENT '礼物名称',
  `giftcount` int(10) NOT NULL DEFAULT '1' COMMENT '礼物数量',
  `gifticon` varchar(255) NOT NULL COMMENT '礼物图标',
  `fee` decimal(10,2) NOT NULL COMMENT '支付金额',
  `giftvote` varchar(50) NOT NULL COMMENT '抵票数',
  `ispay` int(1) NOT NULL COMMENT '支付状态',
  `isdeal` tinyint(1) NOT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `indx_tid` (`tid`),
  KEY `indx_rid` (`rid`),
  KEY `indx_openid` (`openid`),
  KEY `indx_ptid` (`ptid`)
) ENGINE=InnoDB AUTO_INCREMENT=2708 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_indexagree` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '首页评论ID',
  `hid` int(10) NOT NULL COMMENT '首页活动ID',
  `hdname` varchar(255) DEFAULT NULL COMMENT '活动标题',
  `openid` varchar(100) DEFAULT NULL COMMENT '用户openid',
  `uniacid` varchar(100) NOT NULL COMMENT '微信公众ID',
  `avatar` varchar(500) DEFAULT NULL COMMENT '用户头像',
  `nickname` varchar(255) DEFAULT NULL COMMENT '用户昵称',
  `content` varchar(1000) NOT NULL COMMENT '评论内容',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '审核状态',
  `createtime` varchar(100) DEFAULT NULL COMMENT '评论时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `agent_id` int(11) DEFAULT '0',
  `content` text NOT NULL COMMENT '站内信内容',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  `type` varchar(50) DEFAULT '0' COMMENT '0 给总后台看 1给经纪人看',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_mirrorvote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `rid` int(11) DEFAULT '0' COMMENT '规则id',
  `mirroragent` int(11) DEFAULT '0' COMMENT '镜像经纪人id',
  `title` varchar(255) DEFAULT '' COMMENT '镜像标题',
  `copyright` varchar(255) DEFAULT '' COMMENT '镜像版权',
  `indextoppic` varchar(255) DEFAULT '' COMMENT '首页顶图',
  `votetoppic` varchar(255) DEFAULT '' COMMENT '投票页顶图',
  `ad` varchar(255) DEFAULT '' COMMENT '广告',
  `commandvotepic` varchar(255) DEFAULT '' COMMENT '口令投票引导图片',
  `commandvoteword` varchar(255) DEFAULT '' COMMENT '口令投票引导文字',
  `psdfile` varchar(500) DEFAULT '' COMMENT 'psd文件地址',
  `ageditkl` tinyint(1) DEFAULT '0' COMMENT '经纪人镜像口令权限开关',
  `kljr` tinyint(1) DEFAULT '0' COMMENT '口令兼容开关',
  `mirrorsharetitle` varchar(255) DEFAULT '' COMMENT '镜像分享标题',
  `mirrorsharepic` varchar(255) DEFAULT '' COMMENT '镜像分享图片',
  `mirrorsharedesc` varchar(255) DEFAULT '' COMMENT '镜像分享描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_redpack` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `unionid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户unionid',
  `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `user_ip` varchar(15) NOT NULL COMMENT '客户端ip',
  `mch_billno` varchar(28) DEFAULT '',
  `total_amount` int(10) DEFAULT '0',
  `total_num` int(3) NOT NULL,
  `client_ip` varchar(15) NOT NULL,
  `send_time` varchar(14) DEFAULT '0',
  `send_listid` varchar(32) DEFAULT '0',
  `return_data` text,
  `return_code` varchar(16) NOT NULL,
  `return_msg` varchar(256) NOT NULL,
  `result_code` varchar(16) NOT NULL,
  `err_code` varchar(32) NOT NULL,
  `err_code_des` varchar(128) NOT NULL,
  `rewards` varchar(20) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `title` varchar(100) DEFAULT '',
  `thumb` varchar(255) DEFAULT '' COMMENT '封面',
  `description` varchar(255) DEFAULT '',
  `starttime` int(10) DEFAULT '0',
  `endtime` int(10) DEFAULT '0',
  `apstarttime` int(10) DEFAULT '0' COMMENT '报名时间start',
  `apendtime` int(10) DEFAULT '0' COMMENT '报名时间end',
  `votestarttime` int(10) DEFAULT '0' COMMENT '投票时间start',
  `voteendtime` int(10) DEFAULT '0' COMMENT '投票时间end',
  `topimg` varchar(255) DEFAULT '' COMMENT '背景图片',
  `viewtopimg` varchar(255) DEFAULT '' COMMENT '投票页封面',
  `bgcolor` varchar(255) DEFAULT '' COMMENT '背景颜色',
  `style` varchar(255) DEFAULT '' COMMENT '风格',
  `infomsg` mediumtext COMMENT '活动介绍',
  `eventrule` mediumtext COMMENT '活动规则',
  `prizemsg` mediumtext COMMENT '奖品简介',
  `divtitle` mediumtext COMMENT 'div标题',
  `prizemsgdiv1` mediumtext COMMENT '简介1',
  `prizemsgdiv2` mediumtext COMMENT '简介2',
  `prizemsgdiv3` mediumtext COMMENT '简介3',
  `prizemsgdiv4` mediumtext COMMENT '简介4',
  `prizemsgdiv5` mediumtext COMMENT '简介5',
  `endintro` mediumtext COMMENT '活动结束说明',
  `config` mediumtext COMMENT '相关配置',
  `addata` mediumtext COMMENT '广告配置',
  `giftdata` mediumtext NOT NULL COMMENT '礼物配置数据',
  `bill_data` mediumtext NOT NULL COMMENT '海报数据',
  `applydata` mediumtext NOT NULL COMMENT '报名信息配置',
  `area` varchar(100) DEFAULT '0' COMMENT '地区限制',
  `shareimg` varchar(255) DEFAULT '' COMMENT '分享图标',
  `sharetitle` varchar(100) DEFAULT '' COMMENT '分享标题',
  `sharedesc` varchar(300) DEFAULT '' COMMENT '分享简介',
  `status` tinyint(1) DEFAULT '0',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  `rakebacklevel` tinyint(1) DEFAULT '0' COMMENT '返佣层级',
  `levelonepercent` tinyint(1) DEFAULT '0' COMMENT '一级返佣比例',
  `leveltwopercent` tinyint(1) DEFAULT '0' COMMENT '二级返佣比例',
  `levelthreepercent` tinyint(1) DEFAULT '0' COMMENT '三级返佣比例',
  `rewardagentpercent` tinyint(1) DEFAULT '0' COMMENT '招募选手返佣比例',
  `alevelpercent` text COMMENT '经纪人等级分销返佣比例',
  `arewardpercent` text COMMENT '经纪人等级招募返佣',
  `rewardplayer` tinyint(1) DEFAULT '0' COMMENT '是否开启选手招募选手奖励',
  `rewardplayerpercent` tinyint(1) DEFAULT '0' COMMENT '选手奖励票数比例',
  `activecode` varchar(255) DEFAULT '' COMMENT '活动代号',
  `guardstatus` tinyint(1) DEFAULT '0' COMMENT '是否开启守护神',
  `guardname` varchar(255) DEFAULT '' COMMENT '守护神名称',
  `freezemoney` tinyint(1) DEFAULT '0' COMMENT '活动未结束是否冻结提现',
  `iscommandvote` tinyint(1) DEFAULT '0' COMMENT '是否开启口令投票',
  `commandvotepic` varchar(255) DEFAULT '' COMMENT '口令投票引导图片',
  `commandvotedesc` varchar(255) DEFAULT '' COMMENT '口令投票引导文字',
  `agentlevel` int(11) DEFAULT '0' COMMENT '面向经纪人的等级',
  `robotstatus` tinyint(1) DEFAULT '0' COMMENT '活动是否开启机器人',
  `htmlmode` tinyint(1) DEFAULT '0' COMMENT '模板主题',
  `detailset` mediumtext NOT NULL COMMENT '网页细节设置',
  `diybtnname` varchar(255) NOT NULL COMMENT '自定义按钮名称',
  `diybtnurl` varchar(255) NOT NULL COMMENT '自定义按钮url',
  `maxmirrorcommandps` int(10) DEFAULT '0' COMMENT '镜像口令投票最大抵票数',
  `maxkluse` int(10) DEFAULT '0' COMMENT '口令每日使用次数',
  `djsstatus` tinyint(1) DEFAULT '0' COMMENT '倒计时是否显示',
  `topimga` varchar(255) DEFAULT '' COMMENT '头部图片跳转a标签',
  `indexpic` mediumtext NOT NULL COMMENT '首页循环图片',
  `indexpicbtn` mediumtext NOT NULL COMMENT '首页循环图片按钮',
  `indexpica` mediumtext NOT NULL COMMENT '首页循环图片a标签',
  `upvideotype` tinyint(1) DEFAULT '0' COMMENT '是否开启视频上传',
  `videolbpic` tinyint(1) DEFAULT '0' COMMENT '视频上传是否显示轮播',
  `bmzdy` varchar(255) DEFAULT '' COMMENT '报名自定义字段',
  `mastercount` mediumtext COMMENT '站长统计',
  `viewtopimg1` varchar(255) DEFAULT '' COMMENT '投票页封面1',
  `viewtopimg2` varchar(255) DEFAULT '' COMMENT '投票页封面2',
  `viewtopimg3` varchar(255) DEFAULT '' COMMENT '投票页封面3',
  `viewtopimg4` varchar(255) DEFAULT '' COMMENT '投票页封面4',
  `viewtopimg5` varchar(255) DEFAULT '' COMMENT '投票页封面5',
  `viewtopa` mediumtext COMMENT '投票页封面跳转a',
  `showgr` tinyint(1) DEFAULT '0' COMMENT '是否显示排行榜礼物榜',
  `globaltp` varchar(255) DEFAULT '' COMMENT '全局投票文字',
  `globalp` varchar(255) DEFAULT '' COMMENT '全局票文字',
  `globalttyp` varchar(255) DEFAULT '' COMMENT '首页投TA一票文字',
  `saiqustatus` tinyint(1) DEFAULT '0' COMMENT '活动是否开启赛区',
  `showpvgr` tinyint(1) DEFAULT '0' COMMENT '是否显示送礼页面礼物榜',
  `auditcode` varchar(255) DEFAULT '' COMMENT '商家审核选手密码',
  `viewshowtype` tinyint(1) DEFAULT '0' COMMENT '选手页展示模式',
  `tjshow` tinyint(1) DEFAULT '0' COMMENT '选手页推荐选手是否显示',
  `upaudiotype` tinyint(1) DEFAULT '0' COMMENT '是否开启音频上传',
  `views1` varchar(50) DEFAULT NULL COMMENT '显示图片',
  `views2` varchar(50) DEFAULT NULL COMMENT '显示音频',
  `views3` varchar(50) DEFAULT NULL COMMENT '显示视频',
  `isindextop` varchar(50) DEFAULT NULL COMMENT '是否关闭首页头部图片',
  `index_status` varchar(50) DEFAULT NULL COMMENT '设置活动首页评论的开始和停止',
  `user_status` varchar(50) DEFAULT NULL COMMENT '设置活动中用户评论选手信息的开始和停止',
  `sh_status_index` varchar(50) DEFAULT NULL COMMENT '系统自动审核首页评论',
  `sh_status_user` varchar(50) DEFAULT NULL COMMENT '系统自动审核选手评论',
  `join_btn_show` tinyint(1) DEFAULT '0' COMMENT '报名按钮显示',
  PRIMARY KEY (`id`),
  KEY `indx_rid` (`rid`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_revotedata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `oauth_openid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `user_ip` varchar(15) NOT NULL COMMENT '客户端ip',
  `votetype` tinyint(1) DEFAULT '0' COMMENT '投票类型，2口令投票',
  `reward` tinyint(1) NOT NULL COMMENT '抽奖状态',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  `mirrorid` int(10) DEFAULT '0' COMMENT '对应镜像活动id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_robotlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `reply_id` int(11) DEFAULT '0' COMMENT '活动id',
  `rid` int(11) DEFAULT '0' COMMENT '触发规则id',
  `vuid` int(11) DEFAULT '0' COMMENT '选手id',
  `listrank` varchar(255) DEFAULT '' COMMENT '名次',
  `mode` varchar(255) DEFAULT '' COMMENT '模式',
  `speed` varchar(255) DEFAULT '' COMMENT '速率',
  `gapscore` varchar(255) DEFAULT '' COMMENT '差距分数',
  `balance` tinyint(1) DEFAULT '0' COMMENT '每次加票差额百分比',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_robotstatus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `mode1` int(11) DEFAULT '0' COMMENT '模式1脚本执行状态',
  `mode2` int(11) DEFAULT '0' COMMENT '模式2脚本执行状态',
  `mode3` int(11) DEFAULT '0' COMMENT '模式3脚本执行状态',
  `mode4` int(11) DEFAULT '0' COMMENT '模式4脚本执行状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_saiqu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `reply_id` int(11) DEFAULT '0' COMMENT '活动id',
  `rid` int(11) DEFAULT '0' COMMENT '触发规则id',
  `saiquname` varchar(255) DEFAULT '' COMMENT '赛区名字',
  `saiqupic` varchar(255) DEFAULT '' COMMENT '赛区导航图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_voteagree` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `hid` int(10) NOT NULL COMMENT '活动id',
  `noid` varchar(50) DEFAULT NULL COMMENT '选手编号',
  `uid` int(10) NOT NULL COMMENT '选手ID',
  `username` varchar(255) DEFAULT NULL COMMENT '选手姓名',
  `nick` varchar(255) DEFAULT NULL COMMENT '选手昵称',
  `touxiang` varchar(500) DEFAULT NULL COMMENT '选手头像',
  `resume` varchar(255) DEFAULT NULL COMMENT '选手简历',
  `openid` varchar(100) DEFAULT NULL COMMENT '用户openid',
  `uniacid` varchar(100) NOT NULL COMMENT '微信公众ID',
  `avatar` varchar(500) DEFAULT NULL COMMENT '用户头像',
  `nickname` varchar(255) DEFAULT NULL COMMENT '用户昵称',
  `content` varchar(1000) NOT NULL COMMENT '评论内容',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '审核状态',
  `createtime` varchar(100) DEFAULT NULL COMMENT '评论时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_votedata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `oauth_openid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `user_ip` varchar(15) NOT NULL COMMENT '客户端ip',
  `votetype` tinyint(1) DEFAULT '0' COMMENT '投票类型',
  `reward` tinyint(1) NOT NULL COMMENT '抽奖状态',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  `phoneinfo` mediumtext COMMENT '手机信息',
  PRIMARY KEY (`id`),
  KEY `indx_tid` (`tid`),
  KEY `indx_rid` (`rid`),
  KEY `indx_openid` (`openid`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=104895 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_voteuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `noid` int(10) unsigned NOT NULL DEFAULT '0',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `oauth_openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '真实用户openid',
  `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `user_ip` varchar(15) NOT NULL COMMENT '客户端ip',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `introduction` varchar(255) DEFAULT NULL COMMENT '个人介绍',
  `img1` varchar(255) DEFAULT '' COMMENT '图1',
  `img2` varchar(255) DEFAULT '' COMMENT '图2',
  `img3` varchar(255) DEFAULT '' COMMENT '图3',
  `img4` varchar(255) DEFAULT '' COMMENT '图4',
  `img5` varchar(255) DEFAULT '' COMMENT '图5',
  `details` mediumtext COMMENT '投票详情',
  `joindata` mediumtext NOT NULL COMMENT '报名信息',
  `formatdata` mediumtext COMMENT '上传图片mediaid',
  `votenum` int(255) DEFAULT '0' COMMENT '投一票数量',
  `giftcount` decimal(10,2) NOT NULL COMMENT '礼物数量',
  `vheat` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟热度',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `locktime` int(10) DEFAULT '0' COMMENT '锁定时间',
  `attestation` tinyint(1) DEFAULT '0' COMMENT '认证状态',
  `atmsg` varchar(255) NOT NULL DEFAULT '' COMMENT '认证简介',
  `lastvotetime` int(10) NOT NULL COMMENT '最新投票时间',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  `agent_id` int(10) DEFAULT '0' COMMENT '经纪人id',
  `fromuser_id` int(10) DEFAULT '0' COMMENT '招募本选手的选手id',
  `rewardvote` decimal(11,2) DEFAULT '0.00' COMMENT '招募选手奖励票数',
  `source_id` int(10) DEFAULT '0' COMMENT '云导入标识',
  `resume` text NOT NULL COMMENT '参赛简历',
  `video` varchar(255) DEFAULT '' COMMENT '视频文件路径',
  `fmimg` tinyint(1) DEFAULT '1' COMMENT '封面图顺序',
  `zc` varchar(255) DEFAULT '' COMMENT '主题1职称',
  `saiquid` int(10) DEFAULT '0' COMMENT '赛区id',
  `videoarr` mediumtext COMMENT '多视频存放路径',
  `videodesc` mediumtext COMMENT '多视频描述',
  `audioarr` mediumtext COMMENT '多音频存放路径',
  `audiodesc` mediumtext COMMENT '多音频描述',
  PRIMARY KEY (`id`),
  KEY `indx_rid` (`rid`),
  KEY `indx_openid` (`openid`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=1226 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_silence_vote_withdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `agent_id` int(11) DEFAULT '0',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '提现金额',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 0申请 1提现 2拒绝',
  `createtime` int(10) DEFAULT '0' COMMENT '申请时间',
  `handletime` int(10) DEFAULT '0' COMMENT '处理时间',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
pdo_run($sql);
if(!pdo_fieldexists("silence_vote_agenthb", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agenthb")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_agenthb", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agenthb")." ADD   `rid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_agenthb", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agenthb")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_agenthb", "bill_data")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agenthb")." ADD   `bill_data` mediumtext NOT NULL COMMENT '海报数据';");
}
if(!pdo_fieldexists("silence_vote_agenthb", "config")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agenthb")." ADD   `config` mediumtext COMMENT '相关配置';");
}
if(!pdo_fieldexists("silence_vote_agentlevel", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlevel")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_agentlevel", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlevel")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_agentlevel", "level")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlevel")." ADD   `level` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_agentlevel", "levelname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlevel")." ADD   `levelname` varchar(255) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_agentlevel", "isdefault")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlevel")." ADD   `isdefault` tinyint(1) DEFAULT '0' COMMENT '是否默认等级';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_agentlist", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "username")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `username` varchar(255) DEFAULT '';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "password")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `password` varchar(255) DEFAULT '' COMMENT '密码';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "realname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `realname` varchar(255) DEFAULT '' COMMENT '真实姓名';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "phonenum")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `phonenum` varchar(255) DEFAULT '' COMMENT '手机';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `status` tinyint(1) DEFAULT '0' COMMENT '审核状态';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "agentrecommend")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `agentrecommend` int(11) DEFAULT '0' COMMENT '推荐人id';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "agentlevel")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `agentlevel` int(11) DEFAULT '0' COMMENT '经纪人等级';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "moneyqr")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `moneyqr` varchar(500) DEFAULT '' COMMENT '收款码';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "focusticket")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `focusticket` varchar(255) DEFAULT '' COMMENT '公众号二维码ticket';");
}
if(!pdo_fieldexists("silence_vote_agentlist", "focusexpire")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentlist")." ADD   `focusexpire` int(11) DEFAULT '0' COMMENT 'ticket过期时间';");
}
if(!pdo_fieldexists("silence_vote_agentqrcode", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentqrcode")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_agentqrcode", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentqrcode")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_agentqrcode", "agent_id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentqrcode")." ADD   `agent_id` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_agentqrcode", "qr_path")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentqrcode")." ADD   `qr_path` varchar(500) DEFAULT '' COMMENT '二维码路径';");
}
if(!pdo_fieldexists("silence_vote_agentqrcode", "url")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentqrcode")." ADD   `url` varchar(500) DEFAULT '' COMMENT '链接';");
}
if(!pdo_fieldexists("silence_vote_agentqrcode", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentqrcode")." ADD   `rid` int(10) DEFAULT '0' COMMENT '活动规则id';");
}
if(!pdo_fieldexists("silence_vote_agentqrcode", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentqrcode")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '申请时间';");
}
if(!pdo_fieldexists("silence_vote_agentread", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentread")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_agentread", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentread")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_agentread", "read_id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentread")." ADD   `read_id` int(10) DEFAULT '0' COMMENT '活动rid 站内信id';");
}
if(!pdo_fieldexists("silence_vote_agentread", "type")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentread")." ADD   `type` varchar(50) DEFAULT '' COMMENT '已读种类 act活动 mesg站内信';");
}
if(!pdo_fieldexists("silence_vote_agentread", "agent_id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_agentread")." ADD   `agent_id` int(10) DEFAULT '0' COMMENT '经纪人id';");
}
if(!pdo_fieldexists("silence_vote_blacklist", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_blacklist")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_blacklist", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_blacklist")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_blacklist", "type")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_blacklist")." ADD   `type` varchar(1) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_blacklist", "value")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_blacklist")." ADD   `value` varchar(50) DEFAULT NULL COMMENT '值';");
}
if(!pdo_fieldexists("silence_vote_blacklist", "content")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_blacklist")." ADD   `content` varchar(50) DEFAULT NULL COMMENT '昵称，IP地区';");
}
if(!pdo_fieldexists("silence_vote_blacklist", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_blacklist")." ADD   `status` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_blacklist", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_blacklist")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("silence_vote_blacklist", "content")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_blacklist")." ADD   UNIQUE KEY `content` (`content`);");
}
if(!pdo_fieldexists("silence_vote_blacklist", "indx_uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_blacklist")." ADD   KEY `indx_uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("silence_vote_commandvote", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_commandvote")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_commandvote", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_commandvote")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_commandvote", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_commandvote")." ADD   `rid` int(11) DEFAULT '0' COMMENT '规则id';");
}
if(!pdo_fieldexists("silence_vote_commandvote", "commandword")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_commandvote")." ADD   `commandword` varchar(255) DEFAULT '' COMMENT '口令';");
}
if(!pdo_fieldexists("silence_vote_commandvote", "commandpiaoshu")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_commandvote")." ADD   `commandpiaoshu` int(11) DEFAULT '0' COMMENT '口令抵票数';");
}
if(!pdo_fieldexists("silence_vote_commandvote", "ismirror")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_commandvote")." ADD   `ismirror` tinyint(1) DEFAULT '0' COMMENT '是否镜像口令';");
}
if(!pdo_fieldexists("silence_vote_commandvote", "mirrorid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_commandvote")." ADD   `mirrorid` int(11) DEFAULT '0' COMMENT '镜像id';");
}
if(!pdo_fieldexists("silence_vote_count", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_count")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_count", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_count")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_count", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_count")." ADD   `rid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_count", "tid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_count")." ADD   `tid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_count", "pv_total")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_count")." ADD   `pv_total` int(1) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_count", "share_total")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_count")." ADD   `share_total` int(1) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_count", "indx_uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_count")." ADD   KEY `indx_uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("silence_vote_count", "indx_rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_count")." ADD   KEY `indx_rid` (`rid`);");
}
if(!pdo_fieldexists("silence_vote_domainlist", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_domainlist")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_domainlist", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_domainlist")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_domainlist", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_domainlist")." ADD   `rid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_domainlist", "type")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_domainlist")." ADD   `type` tinyint(1) DEFAULT '0' COMMENT '1，主域名，0备选域名';");
}
if(!pdo_fieldexists("silence_vote_domainlist", "domain")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_domainlist")." ADD   `domain` varchar(50) DEFAULT NULL COMMENT '域名';");
}
if(!pdo_fieldexists("silence_vote_domainlist", "extensive")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_domainlist")." ADD   `extensive` tinyint(1) DEFAULT '0' COMMENT '是否泛域名';");
}
if(!pdo_fieldexists("silence_vote_domainlist", "description")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_domainlist")." ADD   `description` varchar(255) NOT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("silence_vote_domainlist", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_domainlist")." ADD   `status` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_domainlist", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_domainlist")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("silence_vote_domainlist", "content")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_domainlist")." ADD   KEY `content` (`domain`);");
}
if(!pdo_fieldexists("silence_vote_domainlist", "indx_uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_domainlist")." ADD   KEY `indx_uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("silence_vote_fansdata", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_fansdata")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_fansdata", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_fansdata")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_fansdata", "openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_fansdata")." ADD   `openid` varchar(50) NOT NULL COMMENT '用户openid';");
}
if(!pdo_fieldexists("silence_vote_fansdata", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_fansdata")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("silence_vote_fansdata", "indx_openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_fansdata")." ADD   KEY `indx_openid` (`openid`);");
}
if(!pdo_fieldexists("silence_vote_fansdata", "indx_uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_fansdata")." ADD   KEY `indx_uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("silence_vote_gift", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_gift", "tid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `tid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_gift", "ptid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `ptid` varchar(128) NOT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists("silence_vote_gift", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `rid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_gift", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_gift", "uniontid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `uniontid` varchar(30) NOT NULL COMMENT '商户单号';");
}
if(!pdo_fieldexists("silence_vote_gift", "paytype")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `paytype` varchar(20) NOT NULL COMMENT '支付类型';");
}
if(!pdo_fieldexists("silence_vote_gift", "oauth_openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `oauth_openid` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_gift", "openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid';");
}
if(!pdo_fieldexists("silence_vote_gift", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像';");
}
if(!pdo_fieldexists("silence_vote_gift", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称';");
}
if(!pdo_fieldexists("silence_vote_gift", "user_ip")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `user_ip` varchar(15) NOT NULL COMMENT '客户端ip';");
}
if(!pdo_fieldexists("silence_vote_gift", "gifttitle")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `gifttitle` varchar(8) DEFAULT '0' COMMENT '礼物名称';");
}
if(!pdo_fieldexists("silence_vote_gift", "giftcount")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `giftcount` int(10) NOT NULL DEFAULT '1' COMMENT '礼物数量';");
}
if(!pdo_fieldexists("silence_vote_gift", "gifticon")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `gifticon` varchar(255) NOT NULL COMMENT '礼物图标';");
}
if(!pdo_fieldexists("silence_vote_gift", "fee")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `fee` decimal(10,2) NOT NULL COMMENT '支付金额';");
}
if(!pdo_fieldexists("silence_vote_gift", "giftvote")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `giftvote` varchar(50) NOT NULL COMMENT '抵票数';");
}
if(!pdo_fieldexists("silence_vote_gift", "ispay")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `ispay` int(1) NOT NULL COMMENT '支付状态';");
}
if(!pdo_fieldexists("silence_vote_gift", "isdeal")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `isdeal` tinyint(1) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_gift", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `status` tinyint(1) DEFAULT '0' COMMENT '状态';");
}
if(!pdo_fieldexists("silence_vote_gift", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("silence_vote_gift", "indx_tid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   KEY `indx_tid` (`tid`);");
}
if(!pdo_fieldexists("silence_vote_gift", "indx_rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   KEY `indx_rid` (`rid`);");
}
if(!pdo_fieldexists("silence_vote_gift", "indx_openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   KEY `indx_openid` (`openid`);");
}
if(!pdo_fieldexists("silence_vote_gift", "indx_ptid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_gift")." ADD   KEY `indx_ptid` (`ptid`);");
}
if(!pdo_fieldexists("silence_vote_indexagree", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_indexagree")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '首页评论ID';");
}
if(!pdo_fieldexists("silence_vote_indexagree", "hid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_indexagree")." ADD   `hid` int(10) NOT NULL COMMENT '首页活动ID';");
}
if(!pdo_fieldexists("silence_vote_indexagree", "hdname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_indexagree")." ADD   `hdname` varchar(255) DEFAULT NULL COMMENT '活动标题';");
}
if(!pdo_fieldexists("silence_vote_indexagree", "openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_indexagree")." ADD   `openid` varchar(100) DEFAULT NULL COMMENT '用户openid';");
}
if(!pdo_fieldexists("silence_vote_indexagree", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_indexagree")." ADD   `uniacid` varchar(100) NOT NULL COMMENT '微信公众ID';");
}
if(!pdo_fieldexists("silence_vote_indexagree", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_indexagree")." ADD   `avatar` varchar(500) DEFAULT NULL COMMENT '用户头像';");
}
if(!pdo_fieldexists("silence_vote_indexagree", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_indexagree")." ADD   `nickname` varchar(255) DEFAULT NULL COMMENT '用户昵称';");
}
if(!pdo_fieldexists("silence_vote_indexagree", "content")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_indexagree")." ADD   `content` varchar(1000) NOT NULL COMMENT '评论内容';");
}
if(!pdo_fieldexists("silence_vote_indexagree", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_indexagree")." ADD   `status` int(11) NOT NULL DEFAULT '0' COMMENT '审核状态';");
}
if(!pdo_fieldexists("silence_vote_indexagree", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_indexagree")." ADD   `createtime` varchar(100) DEFAULT NULL COMMENT '评论时间';");
}
if(!pdo_fieldexists("silence_vote_message", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_message")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_message", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_message")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_message", "agent_id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_message")." ADD   `agent_id` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_message", "content")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_message")." ADD   `content` text NOT NULL COMMENT '站内信内容';");
}
if(!pdo_fieldexists("silence_vote_message", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_message")." ADD   `status` tinyint(1) DEFAULT '0' COMMENT '状态';");
}
if(!pdo_fieldexists("silence_vote_message", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_message")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("silence_vote_message", "type")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_message")." ADD   `type` varchar(50) DEFAULT '0' COMMENT '0 给总后台看 1给经纪人看';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `rid` int(11) DEFAULT '0' COMMENT '规则id';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "mirroragent")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `mirroragent` int(11) DEFAULT '0' COMMENT '镜像经纪人id';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "title")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `title` varchar(255) DEFAULT '' COMMENT '镜像标题';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "copyright")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `copyright` varchar(255) DEFAULT '' COMMENT '镜像版权';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "indextoppic")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `indextoppic` varchar(255) DEFAULT '' COMMENT '首页顶图';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "votetoppic")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `votetoppic` varchar(255) DEFAULT '' COMMENT '投票页顶图';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "ad")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `ad` varchar(255) DEFAULT '' COMMENT '广告';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "commandvotepic")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `commandvotepic` varchar(255) DEFAULT '' COMMENT '口令投票引导图片';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "commandvoteword")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `commandvoteword` varchar(255) DEFAULT '' COMMENT '口令投票引导文字';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "psdfile")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `psdfile` varchar(500) DEFAULT '' COMMENT 'psd文件地址';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "ageditkl")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `ageditkl` tinyint(1) DEFAULT '0' COMMENT '经纪人镜像口令权限开关';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "kljr")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `kljr` tinyint(1) DEFAULT '0' COMMENT '口令兼容开关';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "mirrorsharetitle")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `mirrorsharetitle` varchar(255) DEFAULT '' COMMENT '镜像分享标题';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "mirrorsharepic")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `mirrorsharepic` varchar(255) DEFAULT '' COMMENT '镜像分享图片';");
}
if(!pdo_fieldexists("silence_vote_mirrorvote", "mirrorsharedesc")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_mirrorvote")." ADD   `mirrorsharedesc` varchar(255) DEFAULT '' COMMENT '镜像分享描述';");
}
if(!pdo_fieldexists("silence_vote_redpack", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_redpack", "tid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `tid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_redpack", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `rid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_redpack", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_redpack", "unionid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `unionid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户unionid';");
}
if(!pdo_fieldexists("silence_vote_redpack", "openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid';");
}
if(!pdo_fieldexists("silence_vote_redpack", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像';");
}
if(!pdo_fieldexists("silence_vote_redpack", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称';");
}
if(!pdo_fieldexists("silence_vote_redpack", "user_ip")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `user_ip` varchar(15) NOT NULL COMMENT '客户端ip';");
}
if(!pdo_fieldexists("silence_vote_redpack", "mch_billno")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `mch_billno` varchar(28) DEFAULT '';");
}
if(!pdo_fieldexists("silence_vote_redpack", "total_amount")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `total_amount` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_redpack", "total_num")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `total_num` int(3) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_redpack", "client_ip")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `client_ip` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_redpack", "send_time")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `send_time` varchar(14) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_redpack", "send_listid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `send_listid` varchar(32) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_redpack", "return_data")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `return_data` text;");
}
if(!pdo_fieldexists("silence_vote_redpack", "return_code")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `return_code` varchar(16) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_redpack", "return_msg")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `return_msg` varchar(256) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_redpack", "result_code")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `result_code` varchar(16) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_redpack", "err_code")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `err_code` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_redpack", "err_code_des")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `err_code_des` varchar(128) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_redpack", "rewards")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `rewards` varchar(20) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_redpack", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `status` tinyint(1) DEFAULT '0' COMMENT '状态';");
}
if(!pdo_fieldexists("silence_vote_redpack", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   `createtime` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_redpack", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_redpack")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("silence_vote_reply", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_reply", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `rid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_reply", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_reply", "title")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `title` varchar(100) DEFAULT '';");
}
if(!pdo_fieldexists("silence_vote_reply", "thumb")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `thumb` varchar(255) DEFAULT '' COMMENT '封面';");
}
if(!pdo_fieldexists("silence_vote_reply", "description")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `description` varchar(255) DEFAULT '';");
}
if(!pdo_fieldexists("silence_vote_reply", "starttime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `starttime` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_reply", "endtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `endtime` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_reply", "apstarttime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `apstarttime` int(10) DEFAULT '0' COMMENT '报名时间start';");
}
if(!pdo_fieldexists("silence_vote_reply", "apendtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `apendtime` int(10) DEFAULT '0' COMMENT '报名时间end';");
}
if(!pdo_fieldexists("silence_vote_reply", "votestarttime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `votestarttime` int(10) DEFAULT '0' COMMENT '投票时间start';");
}
if(!pdo_fieldexists("silence_vote_reply", "voteendtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `voteendtime` int(10) DEFAULT '0' COMMENT '投票时间end';");
}
if(!pdo_fieldexists("silence_vote_reply", "topimg")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `topimg` varchar(255) DEFAULT '' COMMENT '背景图片';");
}
if(!pdo_fieldexists("silence_vote_reply", "viewtopimg")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `viewtopimg` varchar(255) DEFAULT '' COMMENT '投票页封面';");
}
if(!pdo_fieldexists("silence_vote_reply", "bgcolor")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `bgcolor` varchar(255) DEFAULT '' COMMENT '背景颜色';");
}
if(!pdo_fieldexists("silence_vote_reply", "style")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `style` varchar(255) DEFAULT '' COMMENT '风格';");
}
if(!pdo_fieldexists("silence_vote_reply", "infomsg")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `infomsg` mediumtext COMMENT '活动介绍';");
}
if(!pdo_fieldexists("silence_vote_reply", "eventrule")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `eventrule` mediumtext COMMENT '活动规则';");
}
if(!pdo_fieldexists("silence_vote_reply", "prizemsg")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `prizemsg` mediumtext COMMENT '奖品简介';");
}
if(!pdo_fieldexists("silence_vote_reply", "divtitle")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `divtitle` mediumtext COMMENT 'div标题';");
}
if(!pdo_fieldexists("silence_vote_reply", "prizemsgdiv1")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `prizemsgdiv1` mediumtext COMMENT '简介1';");
}
if(!pdo_fieldexists("silence_vote_reply", "prizemsgdiv2")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `prizemsgdiv2` mediumtext COMMENT '简介2';");
}
if(!pdo_fieldexists("silence_vote_reply", "prizemsgdiv3")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `prizemsgdiv3` mediumtext COMMENT '简介3';");
}
if(!pdo_fieldexists("silence_vote_reply", "prizemsgdiv4")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `prizemsgdiv4` mediumtext COMMENT '简介4';");
}
if(!pdo_fieldexists("silence_vote_reply", "prizemsgdiv5")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `prizemsgdiv5` mediumtext COMMENT '简介5';");
}
if(!pdo_fieldexists("silence_vote_reply", "endintro")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `endintro` mediumtext COMMENT '活动结束说明';");
}
if(!pdo_fieldexists("silence_vote_reply", "config")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `config` mediumtext COMMENT '相关配置';");
}
if(!pdo_fieldexists("silence_vote_reply", "addata")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `addata` mediumtext COMMENT '广告配置';");
}
if(!pdo_fieldexists("silence_vote_reply", "giftdata")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `giftdata` mediumtext NOT NULL COMMENT '礼物配置数据';");
}
if(!pdo_fieldexists("silence_vote_reply", "bill_data")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `bill_data` mediumtext NOT NULL COMMENT '海报数据';");
}
if(!pdo_fieldexists("silence_vote_reply", "applydata")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `applydata` mediumtext NOT NULL COMMENT '报名信息配置';");
}
if(!pdo_fieldexists("silence_vote_reply", "area")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `area` varchar(100) DEFAULT '0' COMMENT '地区限制';");
}
if(!pdo_fieldexists("silence_vote_reply", "shareimg")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `shareimg` varchar(255) DEFAULT '' COMMENT '分享图标';");
}
if(!pdo_fieldexists("silence_vote_reply", "sharetitle")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `sharetitle` varchar(100) DEFAULT '' COMMENT '分享标题';");
}
if(!pdo_fieldexists("silence_vote_reply", "sharedesc")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `sharedesc` varchar(300) DEFAULT '' COMMENT '分享简介';");
}
if(!pdo_fieldexists("silence_vote_reply", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `status` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_reply", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("silence_vote_reply", "rakebacklevel")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `rakebacklevel` tinyint(1) DEFAULT '0' COMMENT '返佣层级';");
}
if(!pdo_fieldexists("silence_vote_reply", "levelonepercent")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `levelonepercent` tinyint(1) DEFAULT '0' COMMENT '一级返佣比例';");
}
if(!pdo_fieldexists("silence_vote_reply", "leveltwopercent")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `leveltwopercent` tinyint(1) DEFAULT '0' COMMENT '二级返佣比例';");
}
if(!pdo_fieldexists("silence_vote_reply", "levelthreepercent")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `levelthreepercent` tinyint(1) DEFAULT '0' COMMENT '三级返佣比例';");
}
if(!pdo_fieldexists("silence_vote_reply", "rewardagentpercent")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `rewardagentpercent` tinyint(1) DEFAULT '0' COMMENT '招募选手返佣比例';");
}
if(!pdo_fieldexists("silence_vote_reply", "alevelpercent")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `alevelpercent` text COMMENT '经纪人等级分销返佣比例';");
}
if(!pdo_fieldexists("silence_vote_reply", "arewardpercent")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `arewardpercent` text COMMENT '经纪人等级招募返佣';");
}
if(!pdo_fieldexists("silence_vote_reply", "rewardplayer")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `rewardplayer` tinyint(1) DEFAULT '0' COMMENT '是否开启选手招募选手奖励';");
}
if(!pdo_fieldexists("silence_vote_reply", "rewardplayerpercent")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `rewardplayerpercent` tinyint(1) DEFAULT '0' COMMENT '选手奖励票数比例';");
}
if(!pdo_fieldexists("silence_vote_reply", "activecode")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `activecode` varchar(255) DEFAULT '' COMMENT '活动代号';");
}
if(!pdo_fieldexists("silence_vote_reply", "guardstatus")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `guardstatus` tinyint(1) DEFAULT '0' COMMENT '是否开启守护神';");
}
if(!pdo_fieldexists("silence_vote_reply", "guardname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `guardname` varchar(255) DEFAULT '' COMMENT '守护神名称';");
}
if(!pdo_fieldexists("silence_vote_reply", "freezemoney")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `freezemoney` tinyint(1) DEFAULT '0' COMMENT '活动未结束是否冻结提现';");
}
if(!pdo_fieldexists("silence_vote_reply", "iscommandvote")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `iscommandvote` tinyint(1) DEFAULT '0' COMMENT '是否开启口令投票';");
}
if(!pdo_fieldexists("silence_vote_reply", "commandvotepic")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `commandvotepic` varchar(255) DEFAULT '' COMMENT '口令投票引导图片';");
}
if(!pdo_fieldexists("silence_vote_reply", "commandvotedesc")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `commandvotedesc` varchar(255) DEFAULT '' COMMENT '口令投票引导文字';");
}
if(!pdo_fieldexists("silence_vote_reply", "agentlevel")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `agentlevel` int(11) DEFAULT '0' COMMENT '面向经纪人的等级';");
}
if(!pdo_fieldexists("silence_vote_reply", "robotstatus")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `robotstatus` tinyint(1) DEFAULT '0' COMMENT '活动是否开启机器人';");
}
if(!pdo_fieldexists("silence_vote_reply", "htmlmode")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `htmlmode` tinyint(1) DEFAULT '0' COMMENT '模板主题';");
}
if(!pdo_fieldexists("silence_vote_reply", "detailset")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `detailset` mediumtext NOT NULL COMMENT '网页细节设置';");
}
if(!pdo_fieldexists("silence_vote_reply", "diybtnname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `diybtnname` varchar(255) NOT NULL COMMENT '自定义按钮名称';");
}
if(!pdo_fieldexists("silence_vote_reply", "diybtnurl")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `diybtnurl` varchar(255) NOT NULL COMMENT '自定义按钮url';");
}
if(!pdo_fieldexists("silence_vote_reply", "maxmirrorcommandps")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `maxmirrorcommandps` int(10) DEFAULT '0' COMMENT '镜像口令投票最大抵票数';");
}
if(!pdo_fieldexists("silence_vote_reply", "maxkluse")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `maxkluse` int(10) DEFAULT '0' COMMENT '口令每日使用次数';");
}
if(!pdo_fieldexists("silence_vote_reply", "djsstatus")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `djsstatus` tinyint(1) DEFAULT '0' COMMENT '倒计时是否显示';");
}
if(!pdo_fieldexists("silence_vote_reply", "topimga")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `topimga` varchar(255) DEFAULT '' COMMENT '头部图片跳转a标签';");
}
if(!pdo_fieldexists("silence_vote_reply", "indexpic")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `indexpic` mediumtext NOT NULL COMMENT '首页循环图片';");
}
if(!pdo_fieldexists("silence_vote_reply", "indexpicbtn")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `indexpicbtn` mediumtext NOT NULL COMMENT '首页循环图片按钮';");
}
if(!pdo_fieldexists("silence_vote_reply", "indexpica")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `indexpica` mediumtext NOT NULL COMMENT '首页循环图片a标签';");
}
if(!pdo_fieldexists("silence_vote_reply", "upvideotype")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `upvideotype` tinyint(1) DEFAULT '0' COMMENT '是否开启视频上传';");
}
if(!pdo_fieldexists("silence_vote_reply", "videolbpic")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `videolbpic` tinyint(1) DEFAULT '0' COMMENT '视频上传是否显示轮播';");
}
if(!pdo_fieldexists("silence_vote_reply", "bmzdy")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `bmzdy` varchar(255) DEFAULT '' COMMENT '报名自定义字段';");
}
if(!pdo_fieldexists("silence_vote_reply", "mastercount")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `mastercount` mediumtext COMMENT '站长统计';");
}
if(!pdo_fieldexists("silence_vote_reply", "viewtopimg1")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `viewtopimg1` varchar(255) DEFAULT '' COMMENT '投票页封面1';");
}
if(!pdo_fieldexists("silence_vote_reply", "viewtopimg2")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `viewtopimg2` varchar(255) DEFAULT '' COMMENT '投票页封面2';");
}
if(!pdo_fieldexists("silence_vote_reply", "viewtopimg3")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `viewtopimg3` varchar(255) DEFAULT '' COMMENT '投票页封面3';");
}
if(!pdo_fieldexists("silence_vote_reply", "viewtopimg4")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `viewtopimg4` varchar(255) DEFAULT '' COMMENT '投票页封面4';");
}
if(!pdo_fieldexists("silence_vote_reply", "viewtopimg5")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `viewtopimg5` varchar(255) DEFAULT '' COMMENT '投票页封面5';");
}
if(!pdo_fieldexists("silence_vote_reply", "viewtopa")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `viewtopa` mediumtext COMMENT '投票页封面跳转a';");
}
if(!pdo_fieldexists("silence_vote_reply", "showgr")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `showgr` tinyint(1) DEFAULT '0' COMMENT '是否显示排行榜礼物榜';");
}
if(!pdo_fieldexists("silence_vote_reply", "globaltp")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `globaltp` varchar(255) DEFAULT '' COMMENT '全局投票文字';");
}
if(!pdo_fieldexists("silence_vote_reply", "globalp")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `globalp` varchar(255) DEFAULT '' COMMENT '全局票文字';");
}
if(!pdo_fieldexists("silence_vote_reply", "globalttyp")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `globalttyp` varchar(255) DEFAULT '' COMMENT '首页投TA一票文字';");
}
if(!pdo_fieldexists("silence_vote_reply", "saiqustatus")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `saiqustatus` tinyint(1) DEFAULT '0' COMMENT '活动是否开启赛区';");
}
if(!pdo_fieldexists("silence_vote_reply", "showpvgr")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `showpvgr` tinyint(1) DEFAULT '0' COMMENT '是否显示送礼页面礼物榜';");
}
if(!pdo_fieldexists("silence_vote_reply", "auditcode")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `auditcode` varchar(255) DEFAULT '' COMMENT '商家审核选手密码';");
}
if(!pdo_fieldexists("silence_vote_reply", "viewshowtype")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `viewshowtype` tinyint(1) DEFAULT '0' COMMENT '选手页展示模式';");
}
if(!pdo_fieldexists("silence_vote_reply", "tjshow")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `tjshow` tinyint(1) DEFAULT '0' COMMENT '选手页推荐选手是否显示';");
}
if(!pdo_fieldexists("silence_vote_reply", "upaudiotype")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `upaudiotype` tinyint(1) DEFAULT '0' COMMENT '是否开启音频上传';");
}
if(!pdo_fieldexists("silence_vote_reply", "views1")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `views1` varchar(50) DEFAULT NULL COMMENT '显示图片';");
}
if(!pdo_fieldexists("silence_vote_reply", "views2")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `views2` varchar(50) DEFAULT NULL COMMENT '显示音频';");
}
if(!pdo_fieldexists("silence_vote_reply", "views3")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `views3` varchar(50) DEFAULT NULL COMMENT '显示视频';");
}
if(!pdo_fieldexists("silence_vote_reply", "isindextop")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `isindextop` varchar(50) DEFAULT NULL COMMENT '是否关闭首页头部图片';");
}
if(!pdo_fieldexists("silence_vote_reply", "index_status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `index_status` varchar(50) DEFAULT NULL COMMENT '设置活动首页评论的开始和停止';");
}
if(!pdo_fieldexists("silence_vote_reply", "user_status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `user_status` varchar(50) DEFAULT NULL COMMENT '设置活动中用户评论选手信息的开始和停止';");
}
if(!pdo_fieldexists("silence_vote_reply", "sh_status_index")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `sh_status_index` varchar(50) DEFAULT NULL COMMENT '系统自动审核首页评论';");
}
if(!pdo_fieldexists("silence_vote_reply", "sh_status_user")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `sh_status_user` varchar(50) DEFAULT NULL COMMENT '系统自动审核选手评论';");
}
if(!pdo_fieldexists("silence_vote_reply", "join_btn_show")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   `join_btn_show` tinyint(1) DEFAULT '0' COMMENT '报名按钮显示';");
}
if(!pdo_fieldexists("silence_vote_reply", "indx_rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   KEY `indx_rid` (`rid`);");
}
if(!pdo_fieldexists("silence_vote_reply", "indx_uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_reply")." ADD   KEY `indx_uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("silence_vote_revotedata", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_revotedata", "tid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `tid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_revotedata", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `rid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_revotedata", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_revotedata", "oauth_openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `oauth_openid` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_revotedata", "openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid';");
}
if(!pdo_fieldexists("silence_vote_revotedata", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像';");
}
if(!pdo_fieldexists("silence_vote_revotedata", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称';");
}
if(!pdo_fieldexists("silence_vote_revotedata", "user_ip")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `user_ip` varchar(15) NOT NULL COMMENT '客户端ip';");
}
if(!pdo_fieldexists("silence_vote_revotedata", "votetype")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `votetype` tinyint(1) DEFAULT '0' COMMENT '投票类型，2口令投票';");
}
if(!pdo_fieldexists("silence_vote_revotedata", "reward")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `reward` tinyint(1) NOT NULL COMMENT '抽奖状态';");
}
if(!pdo_fieldexists("silence_vote_revotedata", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `status` tinyint(1) DEFAULT '0' COMMENT '状态';");
}
if(!pdo_fieldexists("silence_vote_revotedata", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("silence_vote_revotedata", "mirrorid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_revotedata")." ADD   `mirrorid` int(10) DEFAULT '0' COMMENT '对应镜像活动id';");
}
if(!pdo_fieldexists("silence_vote_robotlist", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotlist")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_robotlist", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotlist")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_robotlist", "reply_id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotlist")." ADD   `reply_id` int(11) DEFAULT '0' COMMENT '活动id';");
}
if(!pdo_fieldexists("silence_vote_robotlist", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotlist")." ADD   `rid` int(11) DEFAULT '0' COMMENT '触发规则id';");
}
if(!pdo_fieldexists("silence_vote_robotlist", "vuid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotlist")." ADD   `vuid` int(11) DEFAULT '0' COMMENT '选手id';");
}
if(!pdo_fieldexists("silence_vote_robotlist", "listrank")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotlist")." ADD   `listrank` varchar(255) DEFAULT '' COMMENT '名次';");
}
if(!pdo_fieldexists("silence_vote_robotlist", "mode")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotlist")." ADD   `mode` varchar(255) DEFAULT '' COMMENT '模式';");
}
if(!pdo_fieldexists("silence_vote_robotlist", "speed")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotlist")." ADD   `speed` varchar(255) DEFAULT '' COMMENT '速率';");
}
if(!pdo_fieldexists("silence_vote_robotlist", "gapscore")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotlist")." ADD   `gapscore` varchar(255) DEFAULT '' COMMENT '差距分数';");
}
if(!pdo_fieldexists("silence_vote_robotlist", "balance")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotlist")." ADD   `balance` tinyint(1) DEFAULT '0' COMMENT '每次加票差额百分比';");
}
if(!pdo_fieldexists("silence_vote_robotstatus", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotstatus")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_robotstatus", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotstatus")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_robotstatus", "mode1")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotstatus")." ADD   `mode1` int(11) DEFAULT '0' COMMENT '模式1脚本执行状态';");
}
if(!pdo_fieldexists("silence_vote_robotstatus", "mode2")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotstatus")." ADD   `mode2` int(11) DEFAULT '0' COMMENT '模式2脚本执行状态';");
}
if(!pdo_fieldexists("silence_vote_robotstatus", "mode3")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotstatus")." ADD   `mode3` int(11) DEFAULT '0' COMMENT '模式3脚本执行状态';");
}
if(!pdo_fieldexists("silence_vote_robotstatus", "mode4")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_robotstatus")." ADD   `mode4` int(11) DEFAULT '0' COMMENT '模式4脚本执行状态';");
}
if(!pdo_fieldexists("silence_vote_saiqu", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_saiqu")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_saiqu", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_saiqu")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_saiqu", "reply_id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_saiqu")." ADD   `reply_id` int(11) DEFAULT '0' COMMENT '活动id';");
}
if(!pdo_fieldexists("silence_vote_saiqu", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_saiqu")." ADD   `rid` int(11) DEFAULT '0' COMMENT '触发规则id';");
}
if(!pdo_fieldexists("silence_vote_saiqu", "saiquname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_saiqu")." ADD   `saiquname` varchar(255) DEFAULT '' COMMENT '赛区名字';");
}
if(!pdo_fieldexists("silence_vote_saiqu", "saiqupic")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_saiqu")." ADD   `saiqupic` varchar(255) DEFAULT '' COMMENT '赛区导航图片';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "hid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `hid` int(10) NOT NULL COMMENT '活动id';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "noid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `noid` varchar(50) DEFAULT NULL COMMENT '选手编号';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "uid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `uid` int(10) NOT NULL COMMENT '选手ID';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "username")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `username` varchar(255) DEFAULT NULL COMMENT '选手姓名';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "nick")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `nick` varchar(255) DEFAULT NULL COMMENT '选手昵称';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "touxiang")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `touxiang` varchar(500) DEFAULT NULL COMMENT '选手头像';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "resume")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `resume` varchar(255) DEFAULT NULL COMMENT '选手简历';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `openid` varchar(100) DEFAULT NULL COMMENT '用户openid';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `uniacid` varchar(100) NOT NULL COMMENT '微信公众ID';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `avatar` varchar(500) DEFAULT NULL COMMENT '用户头像';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `nickname` varchar(255) DEFAULT NULL COMMENT '用户昵称';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "content")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `content` varchar(1000) NOT NULL COMMENT '评论内容';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `status` int(11) NOT NULL DEFAULT '0' COMMENT '审核状态';");
}
if(!pdo_fieldexists("silence_vote_voteagree", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteagree")." ADD   `createtime` varchar(100) DEFAULT NULL COMMENT '评论时间';");
}
if(!pdo_fieldexists("silence_vote_votedata", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_votedata", "tid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `tid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_votedata", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `rid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_votedata", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_votedata", "oauth_openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `oauth_openid` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists("silence_vote_votedata", "openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid';");
}
if(!pdo_fieldexists("silence_vote_votedata", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像';");
}
if(!pdo_fieldexists("silence_vote_votedata", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称';");
}
if(!pdo_fieldexists("silence_vote_votedata", "user_ip")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `user_ip` varchar(15) NOT NULL COMMENT '客户端ip';");
}
if(!pdo_fieldexists("silence_vote_votedata", "votetype")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `votetype` tinyint(1) DEFAULT '0' COMMENT '投票类型';");
}
if(!pdo_fieldexists("silence_vote_votedata", "reward")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `reward` tinyint(1) NOT NULL COMMENT '抽奖状态';");
}
if(!pdo_fieldexists("silence_vote_votedata", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `status` tinyint(1) DEFAULT '0' COMMENT '状态';");
}
if(!pdo_fieldexists("silence_vote_votedata", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("silence_vote_votedata", "phoneinfo")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   `phoneinfo` mediumtext COMMENT '手机信息';");
}
if(!pdo_fieldexists("silence_vote_votedata", "indx_tid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   KEY `indx_tid` (`tid`);");
}
if(!pdo_fieldexists("silence_vote_votedata", "indx_rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   KEY `indx_rid` (`rid`);");
}
if(!pdo_fieldexists("silence_vote_votedata", "indx_openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   KEY `indx_openid` (`openid`);");
}
if(!pdo_fieldexists("silence_vote_votedata", "indx_uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_votedata")." ADD   KEY `indx_uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("silence_vote_voteuser", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_voteuser", "noid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `noid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `rid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "oauth_openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `oauth_openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '真实用户openid';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "user_ip")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `user_ip` varchar(15) NOT NULL COMMENT '客户端ip';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "name")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `name` varchar(30) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "introduction")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `introduction` varchar(255) DEFAULT NULL COMMENT '个人介绍';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "img1")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `img1` varchar(255) DEFAULT '' COMMENT '图1';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "img2")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `img2` varchar(255) DEFAULT '' COMMENT '图2';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "img3")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `img3` varchar(255) DEFAULT '' COMMENT '图3';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "img4")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `img4` varchar(255) DEFAULT '' COMMENT '图4';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "img5")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `img5` varchar(255) DEFAULT '' COMMENT '图5';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "details")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `details` mediumtext COMMENT '投票详情';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "joindata")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `joindata` mediumtext NOT NULL COMMENT '报名信息';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "formatdata")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `formatdata` mediumtext COMMENT '上传图片mediaid';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "votenum")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `votenum` int(255) DEFAULT '0' COMMENT '投一票数量';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "giftcount")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `giftcount` decimal(10,2) NOT NULL COMMENT '礼物数量';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "vheat")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `vheat` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟热度';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `status` tinyint(1) DEFAULT '0' COMMENT '状态';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "locktime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `locktime` int(10) DEFAULT '0' COMMENT '锁定时间';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "attestation")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `attestation` tinyint(1) DEFAULT '0' COMMENT '认证状态';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "atmsg")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `atmsg` varchar(255) NOT NULL DEFAULT '' COMMENT '认证简介';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "lastvotetime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `lastvotetime` int(10) NOT NULL COMMENT '最新投票时间';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "agent_id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `agent_id` int(10) DEFAULT '0' COMMENT '经纪人id';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "fromuser_id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `fromuser_id` int(10) DEFAULT '0' COMMENT '招募本选手的选手id';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "rewardvote")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `rewardvote` decimal(11,2) DEFAULT '0.00' COMMENT '招募选手奖励票数';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "source_id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `source_id` int(10) DEFAULT '0' COMMENT '云导入标识';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "resume")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `resume` text NOT NULL COMMENT '参赛简历';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "video")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `video` varchar(255) DEFAULT '' COMMENT '视频文件路径';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "fmimg")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `fmimg` tinyint(1) DEFAULT '1' COMMENT '封面图顺序';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "zc")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `zc` varchar(255) DEFAULT '' COMMENT '主题1职称';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "saiquid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `saiquid` int(10) DEFAULT '0' COMMENT '赛区id';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "videoarr")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `videoarr` mediumtext COMMENT '多视频存放路径';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "videodesc")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `videodesc` mediumtext COMMENT '多视频描述';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "audioarr")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `audioarr` mediumtext COMMENT '多音频存放路径';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "audiodesc")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   `audiodesc` mediumtext COMMENT '多音频描述';");
}
if(!pdo_fieldexists("silence_vote_voteuser", "indx_rid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   KEY `indx_rid` (`rid`);");
}
if(!pdo_fieldexists("silence_vote_voteuser", "indx_openid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   KEY `indx_openid` (`openid`);");
}
if(!pdo_fieldexists("silence_vote_voteuser", "indx_uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_voteuser")." ADD   KEY `indx_uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("silence_vote_withdraw", "id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_withdraw")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("silence_vote_withdraw", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_withdraw")." ADD   `uniacid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_withdraw", "agent_id")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_withdraw")." ADD   `agent_id` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("silence_vote_withdraw", "money")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_withdraw")." ADD   `money` decimal(10,2) DEFAULT '0.00' COMMENT '提现金额';");
}
if(!pdo_fieldexists("silence_vote_withdraw", "status")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_withdraw")." ADD   `status` tinyint(1) DEFAULT '0' COMMENT '状态 0申请 1提现 2拒绝';");
}
if(!pdo_fieldexists("silence_vote_withdraw", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_withdraw")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '申请时间';");
}
if(!pdo_fieldexists("silence_vote_withdraw", "handletime")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_withdraw")." ADD   `handletime` int(10) DEFAULT '0' COMMENT '处理时间';");
}
if(!pdo_fieldexists("silence_vote_withdraw", "remark")) {
 pdo_query("ALTER TABLE ".tablename("silence_vote_withdraw")." ADD   `remark` varchar(255) DEFAULT '' COMMENT '备注';");
}

 ?>