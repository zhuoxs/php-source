<?php 
$sql="CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_actenroll` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `activityid` int(10) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `utype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '报名类型：1自由报名，2指定党员',
  `getval` int(10) NOT NULL DEFAULT '0' COMMENT '得分值',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  `signintime` int(10) DEFAULT '0' COMMENT '签到时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `branchid` int(10) NOT NULL DEFAULT '0' COMMENT '组织ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '活动主题',
  `tilpic` varchar(255) NOT NULL COMMENT '标题图',
  `stime` varchar(255) DEFAULT '0' COMMENT '开始时间',
  `etime` varchar(255) DEFAULT '0' COMMENT '结束时间',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '活动地点',
  `details` text COMMENT '活动详情',
  `getval` int(10) NOT NULL DEFAULT '0' COMMENT '每人得分值',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待审核，2报名中，3已结束',
  `utype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '报名类型：1自由报名，2指定党员，3指定党员&自由报名',
  `unumber` int(10) DEFAULT '0' COMMENT '报名名额上限',
  `endtime` int(10) DEFAULT '0' COMMENT '报名截止时间',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `issign` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启签到：0关闭，1开启',
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '活动组织者',
  `qrcode` varchar(255) NOT NULL COMMENT '公众号签到二维码',
  `wxappqrcode` varchar(255) NOT NULL COMMENT '小程序签到小程序码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_actmessage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `activityid` int(10) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '留言ID',
  `details` text COMMENT '评论内容',
  `picall` text COMMENT '图片',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_artcate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '分类名称',
  `cicon` varchar(255) NOT NULL COMMENT '分类图标',
  `navnumber` int(10) NOT NULL DEFAULT '0' COMMENT '宣传栏导航编号：0不显示',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `branchid` int(10) unsigned NOT NULL COMMENT '发布组织',
  `title` varchar(255) NOT NULL COMMENT '文章标题',
  `link` varchar(255) NOT NULL COMMENT '外链',
  `tilpic` varchar(255) NOT NULL COMMENT '标题图',
  `details` text COMMENT '文章详情',
  `integral` int(10) DEFAULT '0' COMMENT '积分',
  `isslide` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态：0不推荐，1推荐轮播',
  `slidepic` varchar(255) NOT NULL COMMENT '轮播图片',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待审核，2已归档，3已隐藏',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `createtime` int(10) DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_artmessage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `articleid` int(10) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '留言ID',
  `details` text COMMENT '评论内容',
  `picall` text COMMENT '图片',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_bbscate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `branchid` int(10) unsigned NOT NULL COMMENT '发布组织',
  `name` varchar(255) NOT NULL COMMENT '分类名称',
  `cicon` varchar(255) NOT NULL COMMENT '分类图标',
  `ishot` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否属于热门话题：1是，2否',
  `isshow` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示话题：1显示，2隐藏',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_bbscollect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `topicid` int(10) NOT NULL DEFAULT '0' COMMENT '帖子ID',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_bbsreply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `topicid` int(10) NOT NULL DEFAULT '0' COMMENT '帖子ID',
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `details` varchar(500) NOT NULL DEFAULT '' COMMENT '回复内容',
  `islook` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已查看：0未查看，1已查看',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_bbstopic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `details` text COMMENT '内容',
  `picall` text COMMENT '图片',
  `vpath` varchar(255) NOT NULL DEFAULT '' COMMENT '视频',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_bbszan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `topicid` int(10) NOT NULL DEFAULT '0' COMMENT '帖子ID',
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_branch` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `scort` varchar(255) NOT NULL COMMENT '位置',
  `name` varchar(255) NOT NULL COMMENT '组织名称',
  `parentid` int(10) NOT NULL DEFAULT '0' COMMENT '上级组织ID：0为顶级',
  `blevel` tinyint(4) NOT NULL DEFAULT '1' COMMENT '组织级别：1党支部，2党总支，3党委，4单位',
  `telephone` varchar(255) NOT NULL COMMENT '电话',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `lat` decimal(10,6) NOT NULL COMMENT '纬度',
  `lng` decimal(10,6) NOT NULL COMMENT '经度',
  `details` text COMMENT '组织介绍',
  `priority` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_educate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '分类名称',
  `cicon` varchar(255) NOT NULL COMMENT '分类图标',
  `navnumber` int(10) NOT NULL DEFAULT '0' COMMENT '学习栏导航编号：0不显示',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_educhapter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `lessonid` int(10) NOT NULL DEFAULT '0' COMMENT '课程ID',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `link` varchar(255) NOT NULL COMMENT '外链',
  `apath` text COMMENT '音频',
  `vpath` text COMMENT '视频',
  `details` text COMMENT '详情',
  `needtime` int(10) DEFAULT '0' COMMENT '需学习时长',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待审核，2已归档，3已隐藏',
  `createtime` int(10) DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_edulesson` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `tilpic` varchar(255) NOT NULL COMMENT '标题图',
  `apath` text COMMENT '音频',
  `vpath` text COMMENT '视频',
  `details` text COMMENT '课程介绍',
  `integral` int(10) DEFAULT '0' COMMENT '积分',
  `stustatus` tinyint(4) NOT NULL DEFAULT '1' COMMENT '必选修：1必修，2选修',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1更新中，2已结课，3已隐藏',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `createtime` int(10) DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_edulog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `lessonid` int(10) unsigned NOT NULL,
  `chapterid` int(10) unsigned NOT NULL,
  `stutime` int(10) DEFAULT '0' COMMENT '已学习时长',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1未完成，2已完成',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_edumessage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `lessonid` int(10) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '留言ID',
  `details` text COMMENT '评论内容',
  `picall` text COMMENT '图片',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_edustudy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `lessonid` int(10) unsigned NOT NULL,
  `getval` int(10) NOT NULL DEFAULT '0' COMMENT '得分值',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1未完成，2已完成',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_exaanswer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `paperid` int(10) NOT NULL DEFAULT '0' COMMENT '考试项目ID',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '完成情况：0未开始，1答卷中，2已完成',
  `aright` int(10) NOT NULL DEFAULT '0' COMMENT '答对数目',
  `awrong` int(10) NOT NULL DEFAULT '0' COMMENT '答错数目',
  `setval` int(10) NOT NULL DEFAULT '0' COMMENT '总分值',
  `getval` int(10) NOT NULL DEFAULT '0' COMMENT '得分值',
  `integral` int(10) DEFAULT '0' COMMENT '积分值',
  `stime` int(10) DEFAULT '0' COMMENT '开始时间',
  `etime` int(10) DEFAULT '0' COMMENT '结束时间',
  `finishtime` int(10) DEFAULT '0' COMMENT '完成时间',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_exabank` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '题目',
  `tilpic` varchar(255) NOT NULL COMMENT '题目附图',
  `qtype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型：1单选题，2多选题',
  `itema` varchar(255) NOT NULL COMMENT '选择项A',
  `itemb` varchar(255) NOT NULL COMMENT '选择项B',
  `itemc` varchar(255) NOT NULL COMMENT '选择项C',
  `itemd` varchar(255) NOT NULL COMMENT '选择项D',
  `iteme` varchar(255) NOT NULL COMMENT '选择项E',
  `itemf` varchar(255) NOT NULL COMMENT '选择项F',
  `answer` varchar(255) NOT NULL COMMENT '答案',
  `aright` int(10) NOT NULL DEFAULT '0' COMMENT '答对次数',
  `awrong` int(10) NOT NULL DEFAULT '0' COMMENT '答错次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_exacate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '分类名称',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_exaday` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '完成情况：1未完成，2已完成',
  `aright` int(10) NOT NULL DEFAULT '0' COMMENT '答对数目',
  `awrong` int(10) NOT NULL DEFAULT '0' COMMENT '答错数目',
  `integral` int(10) DEFAULT '0' COMMENT '积分值',
  `finishtime` int(10) DEFAULT '0' COMMENT '完成时间',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_exadevery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `bankid` int(10) NOT NULL DEFAULT '0' COMMENT '题库试题ID',
  `aright` int(10) NOT NULL DEFAULT '0' COMMENT '答对次数',
  `awrong` int(10) NOT NULL DEFAULT '0' COMMENT '答错次数',
  `createtime` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_exaitem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `itype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型：1每日测试，2考试项目',
  `foreignid` int(10) NOT NULL DEFAULT '0' COMMENT '外键ID',
  `bankid` int(10) NOT NULL DEFAULT '0' COMMENT '题库试题ID',
  `myanswer` varchar(255) NOT NULL DEFAULT '' COMMENT '答案',
  `isright` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否正确：0未答，1答错，2答对',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_exapaper` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '考试项目标题',
  `singlenum` int(10) NOT NULL DEFAULT '0' COMMENT '单选题数目',
  `singleval` int(10) NOT NULL DEFAULT '0' COMMENT '单选题分值',
  `multinum` int(10) NOT NULL DEFAULT '0' COMMENT '多选题数目',
  `multival` int(10) NOT NULL DEFAULT '0' COMMENT '多选题分值',
  `integral` int(10) DEFAULT '0' COMMENT '最高积分值',
  `timelimit` int(10) DEFAULT '0' COMMENT '考试时限（分钟）',
  `details` text COMMENT '考试说明',
  `starttime` int(10) DEFAULT '0' COMMENT '考试开始时间',
  `endtime` int(10) DEFAULT '0' COMMENT '考试截止时间',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_exapevery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `paperid` int(10) NOT NULL DEFAULT '0' COMMENT '考试项目ID',
  `bankid` int(10) NOT NULL DEFAULT '0' COMMENT '题库试题ID',
  `aright` int(10) NOT NULL DEFAULT '0' COMMENT '答对次数',
  `awrong` int(10) NOT NULL DEFAULT '0' COMMENT '答错次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_expcate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '党费类目',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '支付类型：1自由金额，2固定金额，3指定党员',
  `catemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '固定支付金额',
  `details` text COMMENT '类目说明',
  `endtime` int(10) DEFAULT '0' COMMENT '交费截止时间',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_expense` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '类目ID',
  `userid` int(10) NOT NULL,
  `paynumber` varchar(255) NOT NULL DEFAULT '' COMMENT '编号',
  `paymoney` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `paytime` int(10) DEFAULT '0' COMMENT '支付时间',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待支付，2已支付',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_integral` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `channel` varchar(20) NOT NULL COMMENT '类型：system系统，article浏览，edustudy学习，serlog服务',
  `foreignid` int(10) DEFAULT '0' COMMENT '外键',
  `integral` int(10) DEFAULT '0' COMMENT '积分',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `isrank` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否计入排行：0不计入排行，1计入排行',
  `iyear` varchar(20) DEFAULT '' COMMENT '年',
  `iseason` varchar(20) DEFAULT '' COMMENT '年季',
  `imonth` varchar(20) DEFAULT '' COMMENT '年月',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_leader` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `branchid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `leadname` varchar(255) NOT NULL COMMENT '领导职称',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示在领导栏：1显示，2不显示',
  `isadmin` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否PC端管理该组织：1管理，2不管理',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_msglog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT '0',
  `messageid` int(10) NOT NULL DEFAULT '0' COMMENT '消息ID',
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_msgmessage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT '0',
  `templateid` varchar(50) DEFAULT '' COMMENT '模板ID',
  `templatename` varchar(20) DEFAULT '' COMMENT '模板名称',
  `title` varchar(20) DEFAULT '' COMMENT '消息标题',
  `dataarr` text COMMENT '参数组',
  `url` varchar(255) DEFAULT '' COMMENT '跳转链接',
  `miniprogram` varchar(500) DEFAULT '' COMMENT '跳转小程序',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_msgtemplate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT '0',
  `templateid` varchar(50) DEFAULT '' COMMENT '模板ID',
  `templatename` varchar(20) DEFAULT '' COMMENT '模板名称',
  `dataarr` text COMMENT '参数组',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `branchid` int(10) unsigned NOT NULL COMMENT '发布组织',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '公告主题',
  `details` text COMMENT '公告内容',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_param` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '系统名称',
  `nicktil` varchar(255) NOT NULL COMMENT '系统角色别称',
  `openhome` tinyint(4) NOT NULL DEFAULT '0' COMMENT '开放系统首页：0不开放，1开放',
  `openart` tinyint(4) NOT NULL DEFAULT '0' COMMENT '开放党建动态栏：0不开放，1开放',
  `expcount` text COMMENT '党费计算说明',
  `serintegral` int(10) DEFAULT '0' COMMENT '志愿服务积分值',
  `actintegral` int(10) DEFAULT '0' COMMENT '组织活动积分值',
  `exadaystatus` tinyint(4) NOT NULL DEFAULT '1' COMMENT '每日测试：1开启，2关闭',
  `exaeverynum` int(10) NOT NULL DEFAULT '0' COMMENT '每日答题数目',
  `exaeveryint` int(10) NOT NULL DEFAULT '0' COMMENT '每道题积分值',
  `loginpic` varchar(255) NOT NULL COMMENT '党员登录背景',
  `loginmobile` tinyint(4) NOT NULL DEFAULT '0' COMMENT '手机号：0不填写，1填写不验证，2填写并短信验证',
  `loginidnumber` tinyint(4) NOT NULL DEFAULT '0' COMMENT '身份证号：0不填写，1填写',
  `mypic` varchar(255) NOT NULL COMMENT '个人中心背景',
  `telephone` varchar(255) NOT NULL COMMENT '联系电话',
  `aboutus` text COMMENT '关于我们',
  `sharetitle` varchar(255) NOT NULL COMMENT '分享标题',
  `sharepic` varchar(255) NOT NULL COMMENT '分享小图',
  `sharedesc` varchar(255) NOT NULL COMMENT '分享描述',
  `wxappsharetitle` varchar(255) NOT NULL COMMENT '小程序分享标题',
  `wxappshareimageurl` varchar(255) NOT NULL COMMENT '小程序分享标图',
  `pclogo` varchar(255) NOT NULL COMMENT '组织管理PC端LOGO',
  `pcfoot` text COMMENT '组织管理PC端页脚信息',
  `homenav` text COMMENT '公众号首页导航',
  `homecon` text COMMENT '公众号首页展示',
  `footnav` text COMMENT '公众号底部导航',
  `mynav` text COMMENT '公众号个人中心导航',
  `wxapphomenav` text COMMENT '小程序首页导航',
  `wxapphomecon` text COMMENT '小程序首页展示',
  `wxappmynav` text COMMENT '小程序个人中心导航',
  `wxappfootnav` text COMMENT '小程序底部导航',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_sercate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '分类名称',
  `cicon` varchar(255) NOT NULL COMMENT '分类图标',
  `navnumber` int(10) NOT NULL DEFAULT '0' COMMENT '宣传栏导航编号：0不显示',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_seritem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `branchid` int(10) unsigned NOT NULL COMMENT '发布组织',
  `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `tilpic` varchar(255) NOT NULL COMMENT '标题图',
  `realname` varchar(255) NOT NULL COMMENT '联系人姓名',
  `mobile` varchar(255) NOT NULL COMMENT '联系人手机号',
  `starttime` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `address` varchar(255) NOT NULL COMMENT '地点',
  `unumber` int(10) DEFAULT '0' COMMENT '招募人数',
  `getval` int(10) NOT NULL DEFAULT '0' COMMENT '每人得分值',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待审核，2招募中，3已完成',
  `details` text COMMENT '详细说明',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_serlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `userid` int(10) NOT NULL,
  `itemid` int(10) NOT NULL,
  `getval` int(10) NOT NULL DEFAULT '0' COMMENT '得分值',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_sermessage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `itemid` int(10) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '留言ID',
  `details` text COMMENT '评论内容',
  `picall` text COMMENT '图片',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_slide` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT '0',
  `position` varchar(20) NOT NULL COMMENT '位置：home主页，arthome宣传，eduhome学习，suphome监督，serhome服务',
  `title` varchar(50) DEFAULT '',
  `tilpic` varchar(255) DEFAULT '',
  `link` varchar(255) NOT NULL,
  `wxapptype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '小程序链接类型：1内部网页跳转，2外部网页跳转，3关联小程序跳转',
  `wxapplink` varchar(255) NOT NULL DEFAULT '' COMMENT '小程序链接',
  `priority` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_supmailbox` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `userid` int(10) NOT NULL,
  `luserid` int(10) NOT NULL COMMENT '领导ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '主题',
  `realname` varchar(255) NOT NULL COMMENT '姓名',
  `mobile` varchar(255) NOT NULL COMMENT '手机号',
  `details` text COMMENT '内容描述',
  `reply` text COMMENT '回复',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待回复，2已回复',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_supproposal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `userid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '主题',
  `realname` varchar(255) NOT NULL COMMENT '姓名',
  `mobile` varchar(255) NOT NULL COMMENT '手机号',
  `details` text COMMENT '内容描述',
  `reply` text COMMENT '回复',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待处理，2已处理',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_supreadily` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `userid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '主题',
  `picall` text COMMENT '图片',
  `details` text COMMENT '内容描述',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_supreport` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '主题',
  `details` text COMMENT '内容',
  `picall` text COMMENT '图片',
  `reply` text COMMENT '处理结果',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待处理，2处理中，2已处理',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_vlinke_cparty_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `branchid` int(10) NOT NULL DEFAULT '0' COMMENT '所属组织ID',
  `openid` varchar(255) NOT NULL COMMENT 'OpenID',
  `nickname` varchar(255) NOT NULL COMMENT '昵称',
  `headimgurl` varchar(255) NOT NULL COMMENT '微信头像',
  `wxappopenid` varchar(255) NOT NULL COMMENT 'wxappOpenID',
  `wxappnickname` varchar(255) NOT NULL COMMENT 'wxapp昵称',
  `wxappheadimgurl` varchar(255) NOT NULL COMMENT 'wxapp微信头像',
  `realname` varchar(255) NOT NULL COMMENT '姓名',
  `idnumber` varchar(255) NOT NULL COMMENT '身份证号',
  `mobile` varchar(255) NOT NULL COMMENT '手机号',
  `headpic` varchar(255) NOT NULL COMMENT '真实头像',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1审核，2正常，3禁用',
  `integral` int(10) DEFAULT '0' COMMENT '积分',
  `ulevel` tinyint(4) NOT NULL DEFAULT '1' COMMENT '政治身份：1正式党员，2预备党员，3发展对象，4入党积极分子',
  `partyday` varchar(255) NOT NULL COMMENT '入党日期',
  `birthday` varchar(255) NOT NULL COMMENT '出生日期',
  `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '性别：1男，2女',
  `origin` varchar(255) NOT NULL COMMENT '籍贯',
  `nation` varchar(255) NOT NULL COMMENT '民族',
  `education` varchar(255) NOT NULL COMMENT '文化程度',
  `beizhu` text COMMENT '备注信息',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `recycle` tinyint(4) NOT NULL DEFAULT '0' COMMENT '回收站：0正常，1已回收',
  `loginname` varchar(255) NOT NULL COMMENT '登录用户名',
  `loginpass` varchar(255) NOT NULL COMMENT '登录密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
";
pdo_run($sql);
if(!pdo_fieldexists("vlinke_cparty_actenroll", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actenroll")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_actenroll", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actenroll")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_actenroll", "activityid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actenroll")." ADD   `activityid` int(10) NOT NULL DEFAULT '0' COMMENT '活动ID';");
}
if(!pdo_fieldexists("vlinke_cparty_actenroll", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actenroll")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID';");
}
if(!pdo_fieldexists("vlinke_cparty_actenroll", "utype")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actenroll")." ADD   `utype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '报名类型：1自由报名，2指定党员';");
}
if(!pdo_fieldexists("vlinke_cparty_actenroll", "getval")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actenroll")." ADD   `getval` int(10) NOT NULL DEFAULT '0' COMMENT '得分值';");
}
if(!pdo_fieldexists("vlinke_cparty_actenroll", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actenroll")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_actenroll", "signintime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actenroll")." ADD   `signintime` int(10) DEFAULT '0' COMMENT '签到时间';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "branchid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `branchid` int(10) NOT NULL DEFAULT '0' COMMENT '组织ID';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `title` varchar(255) NOT NULL DEFAULT '' COMMENT '活动主题';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "tilpic")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `tilpic` varchar(255) NOT NULL COMMENT '标题图';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "stime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `stime` varchar(255) DEFAULT '0' COMMENT '开始时间';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "etime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `etime` varchar(255) DEFAULT '0' COMMENT '结束时间';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "address")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `address` varchar(255) NOT NULL DEFAULT '' COMMENT '活动地点';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `details` text COMMENT '活动详情';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "getval")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `getval` int(10) NOT NULL DEFAULT '0' COMMENT '每人得分值';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待审核，2报名中，3已结束';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "utype")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `utype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '报名类型：1自由报名，2指定党员，3指定党员&自由报名';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "unumber")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `unumber` int(10) DEFAULT '0' COMMENT '报名名额上限';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "endtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `endtime` int(10) DEFAULT '0' COMMENT '报名截止时间';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "issign")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `issign` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启签到：0关闭，1开启';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '活动组织者';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "qrcode")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `qrcode` varchar(255) NOT NULL COMMENT '公众号签到二维码';");
}
if(!pdo_fieldexists("vlinke_cparty_activity", "wxappqrcode")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_activity")." ADD   `wxappqrcode` varchar(255) NOT NULL COMMENT '小程序签到小程序码';");
}
if(!pdo_fieldexists("vlinke_cparty_actmessage", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actmessage")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_actmessage", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actmessage")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_actmessage", "activityid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actmessage")." ADD   `activityid` int(10) NOT NULL DEFAULT '0' COMMENT '活动ID';");
}
if(!pdo_fieldexists("vlinke_cparty_actmessage", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actmessage")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '留言ID';");
}
if(!pdo_fieldexists("vlinke_cparty_actmessage", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actmessage")." ADD   `details` text COMMENT '评论内容';");
}
if(!pdo_fieldexists("vlinke_cparty_actmessage", "picall")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actmessage")." ADD   `picall` text COMMENT '图片';");
}
if(!pdo_fieldexists("vlinke_cparty_actmessage", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_actmessage")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_artcate", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artcate")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_artcate", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artcate")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_artcate", "name")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artcate")." ADD   `name` varchar(255) NOT NULL COMMENT '分类名称';");
}
if(!pdo_fieldexists("vlinke_cparty_artcate", "cicon")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artcate")." ADD   `cicon` varchar(255) NOT NULL COMMENT '分类图标';");
}
if(!pdo_fieldexists("vlinke_cparty_artcate", "navnumber")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artcate")." ADD   `navnumber` int(10) NOT NULL DEFAULT '0' COMMENT '宣传栏导航编号：0不显示';");
}
if(!pdo_fieldexists("vlinke_cparty_artcate", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artcate")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_article", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_article", "cateid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "branchid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `branchid` int(10) unsigned NOT NULL COMMENT '发布组织';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `title` varchar(255) NOT NULL COMMENT '文章标题';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "link")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `link` varchar(255) NOT NULL COMMENT '外链';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "tilpic")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `tilpic` varchar(255) NOT NULL COMMENT '标题图';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `details` text COMMENT '文章详情';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "integral")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `integral` int(10) DEFAULT '0' COMMENT '积分';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "isslide")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `isslide` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态：0不推荐，1推荐轮播';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "slidepic")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `slidepic` varchar(255) NOT NULL COMMENT '轮播图片';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待审核，2已归档，3已隐藏';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_article", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_article")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '发布时间';");
}
if(!pdo_fieldexists("vlinke_cparty_artmessage", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artmessage")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_artmessage", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artmessage")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_artmessage", "articleid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artmessage")." ADD   `articleid` int(10) NOT NULL DEFAULT '0' COMMENT '文章ID';");
}
if(!pdo_fieldexists("vlinke_cparty_artmessage", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artmessage")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '留言ID';");
}
if(!pdo_fieldexists("vlinke_cparty_artmessage", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artmessage")." ADD   `details` text COMMENT '评论内容';");
}
if(!pdo_fieldexists("vlinke_cparty_artmessage", "picall")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artmessage")." ADD   `picall` text COMMENT '图片';");
}
if(!pdo_fieldexists("vlinke_cparty_artmessage", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_artmessage")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_bbscate", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscate")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_bbscate", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscate")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_bbscate", "branchid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscate")." ADD   `branchid` int(10) unsigned NOT NULL COMMENT '发布组织';");
}
if(!pdo_fieldexists("vlinke_cparty_bbscate", "name")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscate")." ADD   `name` varchar(255) NOT NULL COMMENT '分类名称';");
}
if(!pdo_fieldexists("vlinke_cparty_bbscate", "cicon")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscate")." ADD   `cicon` varchar(255) NOT NULL COMMENT '分类图标';");
}
if(!pdo_fieldexists("vlinke_cparty_bbscate", "ishot")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscate")." ADD   `ishot` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否属于热门话题：1是，2否';");
}
if(!pdo_fieldexists("vlinke_cparty_bbscate", "isshow")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscate")." ADD   `isshow` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示话题：1显示，2隐藏';");
}
if(!pdo_fieldexists("vlinke_cparty_bbscate", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscate")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_bbscollect", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscollect")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_bbscollect", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscollect")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_bbscollect", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscollect")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID';");
}
if(!pdo_fieldexists("vlinke_cparty_bbscollect", "topicid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscollect")." ADD   `topicid` int(10) NOT NULL DEFAULT '0' COMMENT '帖子ID';");
}
if(!pdo_fieldexists("vlinke_cparty_bbscollect", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbscollect")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_bbsreply", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbsreply")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_bbsreply", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbsreply")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_bbsreply", "topicid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbsreply")." ADD   `topicid` int(10) NOT NULL DEFAULT '0' COMMENT '帖子ID';");
}
if(!pdo_fieldexists("vlinke_cparty_bbsreply", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbsreply")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID';");
}
if(!pdo_fieldexists("vlinke_cparty_bbsreply", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbsreply")." ADD   `details` varchar(500) NOT NULL DEFAULT '' COMMENT '回复内容';");
}
if(!pdo_fieldexists("vlinke_cparty_bbsreply", "islook")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbsreply")." ADD   `islook` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已查看：0未查看，1已查看';");
}
if(!pdo_fieldexists("vlinke_cparty_bbsreply", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbsreply")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_bbstopic", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbstopic")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_bbstopic", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbstopic")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_bbstopic", "cateid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbstopic")." ADD   `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID';");
}
if(!pdo_fieldexists("vlinke_cparty_bbstopic", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbstopic")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID';");
}
if(!pdo_fieldexists("vlinke_cparty_bbstopic", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbstopic")." ADD   `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题';");
}
if(!pdo_fieldexists("vlinke_cparty_bbstopic", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbstopic")." ADD   `details` text COMMENT '内容';");
}
if(!pdo_fieldexists("vlinke_cparty_bbstopic", "picall")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbstopic")." ADD   `picall` text COMMENT '图片';");
}
if(!pdo_fieldexists("vlinke_cparty_bbstopic", "vpath")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbstopic")." ADD   `vpath` varchar(255) NOT NULL DEFAULT '' COMMENT '视频';");
}
if(!pdo_fieldexists("vlinke_cparty_bbstopic", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbstopic")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_bbszan", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbszan")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_bbszan", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbszan")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_bbszan", "topicid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbszan")." ADD   `topicid` int(10) NOT NULL DEFAULT '0' COMMENT '帖子ID';");
}
if(!pdo_fieldexists("vlinke_cparty_bbszan", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbszan")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID';");
}
if(!pdo_fieldexists("vlinke_cparty_bbszan", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_bbszan")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "scort")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `scort` varchar(255) NOT NULL COMMENT '位置';");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "name")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `name` varchar(255) NOT NULL COMMENT '组织名称';");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "parentid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `parentid` int(10) NOT NULL DEFAULT '0' COMMENT '上级组织ID：0为顶级';");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "blevel")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `blevel` tinyint(4) NOT NULL DEFAULT '1' COMMENT '组织级别：1党支部，2党总支，3党委，4单位';");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "telephone")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `telephone` varchar(255) NOT NULL COMMENT '电话';");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "address")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `address` varchar(255) NOT NULL COMMENT '地址';");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "lat")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `lat` decimal(10,6) NOT NULL COMMENT '纬度';");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "lng")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `lng` decimal(10,6) NOT NULL COMMENT '经度';");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `details` text COMMENT '组织介绍';");
}
if(!pdo_fieldexists("vlinke_cparty_branch", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_branch")." ADD   `priority` int(10) NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_educate", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educate")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_educate", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educate")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_educate", "name")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educate")." ADD   `name` varchar(255) NOT NULL COMMENT '分类名称';");
}
if(!pdo_fieldexists("vlinke_cparty_educate", "cicon")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educate")." ADD   `cicon` varchar(255) NOT NULL COMMENT '分类图标';");
}
if(!pdo_fieldexists("vlinke_cparty_educate", "navnumber")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educate")." ADD   `navnumber` int(10) NOT NULL DEFAULT '0' COMMENT '学习栏导航编号：0不显示';");
}
if(!pdo_fieldexists("vlinke_cparty_educate", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educate")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "lessonid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `lessonid` int(10) NOT NULL DEFAULT '0' COMMENT '课程ID';");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `title` varchar(255) NOT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "link")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `link` varchar(255) NOT NULL COMMENT '外链';");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "apath")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `apath` text COMMENT '音频';");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "vpath")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `vpath` text COMMENT '视频';");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `details` text COMMENT '详情';");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "needtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `needtime` int(10) DEFAULT '0' COMMENT '需学习时长';");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待审核，2已归档，3已隐藏';");
}
if(!pdo_fieldexists("vlinke_cparty_educhapter", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_educhapter")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '发布时间';");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "cateid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID';");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `title` varchar(255) NOT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "tilpic")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `tilpic` varchar(255) NOT NULL COMMENT '标题图';");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "apath")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `apath` text COMMENT '音频';");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "vpath")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `vpath` text COMMENT '视频';");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `details` text COMMENT '课程介绍';");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "integral")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `integral` int(10) DEFAULT '0' COMMENT '积分';");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "stustatus")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `stustatus` tinyint(4) NOT NULL DEFAULT '1' COMMENT '必选修：1必修，2选修';");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1更新中，2已结课，3已隐藏';");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_edulesson", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulesson")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '发布时间';");
}
if(!pdo_fieldexists("vlinke_cparty_edulog", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulog")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_edulog", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulog")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_edulog", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulog")." ADD   `userid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_edulog", "lessonid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulog")." ADD   `lessonid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_edulog", "chapterid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulog")." ADD   `chapterid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_edulog", "stutime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulog")." ADD   `stutime` int(10) DEFAULT '0' COMMENT '已学习时长';");
}
if(!pdo_fieldexists("vlinke_cparty_edulog", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulog")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1未完成，2已完成';");
}
if(!pdo_fieldexists("vlinke_cparty_edulog", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edulog")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_edumessage", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edumessage")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_edumessage", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edumessage")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_edumessage", "lessonid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edumessage")." ADD   `lessonid` int(10) NOT NULL DEFAULT '0' COMMENT '活动ID';");
}
if(!pdo_fieldexists("vlinke_cparty_edumessage", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edumessage")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '留言ID';");
}
if(!pdo_fieldexists("vlinke_cparty_edumessage", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edumessage")." ADD   `details` text COMMENT '评论内容';");
}
if(!pdo_fieldexists("vlinke_cparty_edumessage", "picall")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edumessage")." ADD   `picall` text COMMENT '图片';");
}
if(!pdo_fieldexists("vlinke_cparty_edumessage", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edumessage")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_edustudy", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edustudy")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_edustudy", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edustudy")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_edustudy", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edustudy")." ADD   `userid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_edustudy", "lessonid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edustudy")." ADD   `lessonid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_edustudy", "getval")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edustudy")." ADD   `getval` int(10) NOT NULL DEFAULT '0' COMMENT '得分值';");
}
if(!pdo_fieldexists("vlinke_cparty_edustudy", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edustudy")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1未完成，2已完成';");
}
if(!pdo_fieldexists("vlinke_cparty_edustudy", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_edustudy")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "paperid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `paperid` int(10) NOT NULL DEFAULT '0' COMMENT '考试项目ID';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '完成情况：0未开始，1答卷中，2已完成';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "aright")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `aright` int(10) NOT NULL DEFAULT '0' COMMENT '答对数目';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "awrong")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `awrong` int(10) NOT NULL DEFAULT '0' COMMENT '答错数目';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "setval")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `setval` int(10) NOT NULL DEFAULT '0' COMMENT '总分值';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "getval")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `getval` int(10) NOT NULL DEFAULT '0' COMMENT '得分值';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "integral")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `integral` int(10) DEFAULT '0' COMMENT '积分值';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "stime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `stime` int(10) DEFAULT '0' COMMENT '开始时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "etime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `etime` int(10) DEFAULT '0' COMMENT '结束时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "finishtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `finishtime` int(10) DEFAULT '0' COMMENT '完成时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exaanswer", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaanswer")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "cateid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `title` varchar(255) NOT NULL DEFAULT '' COMMENT '题目';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "tilpic")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `tilpic` varchar(255) NOT NULL COMMENT '题目附图';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "qtype")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `qtype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型：1单选题，2多选题';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "itema")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `itema` varchar(255) NOT NULL COMMENT '选择项A';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "itemb")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `itemb` varchar(255) NOT NULL COMMENT '选择项B';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "itemc")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `itemc` varchar(255) NOT NULL COMMENT '选择项C';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "itemd")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `itemd` varchar(255) NOT NULL COMMENT '选择项D';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "iteme")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `iteme` varchar(255) NOT NULL COMMENT '选择项E';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "itemf")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `itemf` varchar(255) NOT NULL COMMENT '选择项F';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "answer")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `answer` varchar(255) NOT NULL COMMENT '答案';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "aright")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `aright` int(10) NOT NULL DEFAULT '0' COMMENT '答对次数';");
}
if(!pdo_fieldexists("vlinke_cparty_exabank", "awrong")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exabank")." ADD   `awrong` int(10) NOT NULL DEFAULT '0' COMMENT '答错次数';");
}
if(!pdo_fieldexists("vlinke_cparty_exacate", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exacate")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_exacate", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exacate")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_exacate", "name")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exacate")." ADD   `name` varchar(255) NOT NULL COMMENT '分类名称';");
}
if(!pdo_fieldexists("vlinke_cparty_exacate", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exacate")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_exaday", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaday")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_exaday", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaday")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_exaday", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaday")." ADD   `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题';");
}
if(!pdo_fieldexists("vlinke_cparty_exaday", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaday")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID';");
}
if(!pdo_fieldexists("vlinke_cparty_exaday", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaday")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '完成情况：1未完成，2已完成';");
}
if(!pdo_fieldexists("vlinke_cparty_exaday", "aright")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaday")." ADD   `aright` int(10) NOT NULL DEFAULT '0' COMMENT '答对数目';");
}
if(!pdo_fieldexists("vlinke_cparty_exaday", "awrong")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaday")." ADD   `awrong` int(10) NOT NULL DEFAULT '0' COMMENT '答错数目';");
}
if(!pdo_fieldexists("vlinke_cparty_exaday", "integral")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaday")." ADD   `integral` int(10) DEFAULT '0' COMMENT '积分值';");
}
if(!pdo_fieldexists("vlinke_cparty_exaday", "finishtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaday")." ADD   `finishtime` int(10) DEFAULT '0' COMMENT '完成时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exaday", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaday")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exadevery", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exadevery")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_exadevery", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exadevery")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_exadevery", "bankid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exadevery")." ADD   `bankid` int(10) NOT NULL DEFAULT '0' COMMENT '题库试题ID';");
}
if(!pdo_fieldexists("vlinke_cparty_exadevery", "aright")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exadevery")." ADD   `aright` int(10) NOT NULL DEFAULT '0' COMMENT '答对次数';");
}
if(!pdo_fieldexists("vlinke_cparty_exadevery", "awrong")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exadevery")." ADD   `awrong` int(10) NOT NULL DEFAULT '0' COMMENT '答错次数';");
}
if(!pdo_fieldexists("vlinke_cparty_exadevery", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exadevery")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '添加时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exaitem", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaitem")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_exaitem", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaitem")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_exaitem", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaitem")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID';");
}
if(!pdo_fieldexists("vlinke_cparty_exaitem", "itype")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaitem")." ADD   `itype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型：1每日测试，2考试项目';");
}
if(!pdo_fieldexists("vlinke_cparty_exaitem", "foreignid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaitem")." ADD   `foreignid` int(10) NOT NULL DEFAULT '0' COMMENT '外键ID';");
}
if(!pdo_fieldexists("vlinke_cparty_exaitem", "bankid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaitem")." ADD   `bankid` int(10) NOT NULL DEFAULT '0' COMMENT '题库试题ID';");
}
if(!pdo_fieldexists("vlinke_cparty_exaitem", "myanswer")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaitem")." ADD   `myanswer` varchar(255) NOT NULL DEFAULT '' COMMENT '答案';");
}
if(!pdo_fieldexists("vlinke_cparty_exaitem", "isright")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaitem")." ADD   `isright` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否正确：0未答，1答错，2答对';");
}
if(!pdo_fieldexists("vlinke_cparty_exaitem", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exaitem")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `title` varchar(255) NOT NULL DEFAULT '' COMMENT '考试项目标题';");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "singlenum")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `singlenum` int(10) NOT NULL DEFAULT '0' COMMENT '单选题数目';");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "singleval")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `singleval` int(10) NOT NULL DEFAULT '0' COMMENT '单选题分值';");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "multinum")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `multinum` int(10) NOT NULL DEFAULT '0' COMMENT '多选题数目';");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "multival")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `multival` int(10) NOT NULL DEFAULT '0' COMMENT '多选题分值';");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "integral")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `integral` int(10) DEFAULT '0' COMMENT '最高积分值';");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "timelimit")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `timelimit` int(10) DEFAULT '0' COMMENT '考试时限（分钟）';");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `details` text COMMENT '考试说明';");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "starttime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `starttime` int(10) DEFAULT '0' COMMENT '考试开始时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "endtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `endtime` int(10) DEFAULT '0' COMMENT '考试截止时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exapaper", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapaper")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_exapevery", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapevery")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_exapevery", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapevery")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_exapevery", "paperid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapevery")." ADD   `paperid` int(10) NOT NULL DEFAULT '0' COMMENT '考试项目ID';");
}
if(!pdo_fieldexists("vlinke_cparty_exapevery", "bankid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapevery")." ADD   `bankid` int(10) NOT NULL DEFAULT '0' COMMENT '题库试题ID';");
}
if(!pdo_fieldexists("vlinke_cparty_exapevery", "aright")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapevery")." ADD   `aright` int(10) NOT NULL DEFAULT '0' COMMENT '答对次数';");
}
if(!pdo_fieldexists("vlinke_cparty_exapevery", "awrong")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_exapevery")." ADD   `awrong` int(10) NOT NULL DEFAULT '0' COMMENT '答错次数';");
}
if(!pdo_fieldexists("vlinke_cparty_expcate", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expcate")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_expcate", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expcate")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_expcate", "name")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expcate")." ADD   `name` varchar(255) NOT NULL COMMENT '党费类目';");
}
if(!pdo_fieldexists("vlinke_cparty_expcate", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expcate")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '支付类型：1自由金额，2固定金额，3指定党员';");
}
if(!pdo_fieldexists("vlinke_cparty_expcate", "catemoney")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expcate")." ADD   `catemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '固定支付金额';");
}
if(!pdo_fieldexists("vlinke_cparty_expcate", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expcate")." ADD   `details` text COMMENT '类目说明';");
}
if(!pdo_fieldexists("vlinke_cparty_expcate", "endtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expcate")." ADD   `endtime` int(10) DEFAULT '0' COMMENT '交费截止时间';");
}
if(!pdo_fieldexists("vlinke_cparty_expcate", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expcate")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_expense", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expense")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_expense", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expense")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_expense", "cateid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expense")." ADD   `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '类目ID';");
}
if(!pdo_fieldexists("vlinke_cparty_expense", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expense")." ADD   `userid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_expense", "paynumber")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expense")." ADD   `paynumber` varchar(255) NOT NULL DEFAULT '' COMMENT '编号';");
}
if(!pdo_fieldexists("vlinke_cparty_expense", "paymoney")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expense")." ADD   `paymoney` decimal(10,2) DEFAULT '0.00' COMMENT '金额';");
}
if(!pdo_fieldexists("vlinke_cparty_expense", "paytime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expense")." ADD   `paytime` int(10) DEFAULT '0' COMMENT '支付时间';");
}
if(!pdo_fieldexists("vlinke_cparty_expense", "remark")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expense")." ADD   `remark` varchar(255) DEFAULT '' COMMENT '备注';");
}
if(!pdo_fieldexists("vlinke_cparty_expense", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expense")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待支付，2已支付';");
}
if(!pdo_fieldexists("vlinke_cparty_expense", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_expense")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID';");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "channel")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `channel` varchar(20) NOT NULL COMMENT '类型：system系统，article浏览，edustudy学习，serlog服务';");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "foreignid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `foreignid` int(10) DEFAULT '0' COMMENT '外键';");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "integral")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `integral` int(10) DEFAULT '0' COMMENT '积分';");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "remark")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `remark` varchar(255) DEFAULT '' COMMENT '备注';");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "isrank")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `isrank` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否计入排行：0不计入排行，1计入排行';");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "iyear")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `iyear` varchar(20) DEFAULT '' COMMENT '年';");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "iseason")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `iseason` varchar(20) DEFAULT '' COMMENT '年季';");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "imonth")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `imonth` varchar(20) DEFAULT '' COMMENT '年月';");
}
if(!pdo_fieldexists("vlinke_cparty_integral", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_integral")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_leader", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_leader")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_leader", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_leader")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_leader", "branchid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_leader")." ADD   `branchid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_leader", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_leader")." ADD   `userid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_leader", "leadname")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_leader")." ADD   `leadname` varchar(255) NOT NULL COMMENT '领导职称';");
}
if(!pdo_fieldexists("vlinke_cparty_leader", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_leader")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示在领导栏：1显示，2不显示';");
}
if(!pdo_fieldexists("vlinke_cparty_leader", "isadmin")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_leader")." ADD   `isadmin` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否PC端管理该组织：1管理，2不管理';");
}
if(!pdo_fieldexists("vlinke_cparty_leader", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_leader")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_msglog", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msglog")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_msglog", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msglog")." ADD   `uniacid` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("vlinke_cparty_msglog", "messageid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msglog")." ADD   `messageid` int(10) NOT NULL DEFAULT '0' COMMENT '消息ID';");
}
if(!pdo_fieldexists("vlinke_cparty_msglog", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msglog")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID';");
}
if(!pdo_fieldexists("vlinke_cparty_msglog", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msglog")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_msgmessage", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgmessage")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_msgmessage", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgmessage")." ADD   `uniacid` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("vlinke_cparty_msgmessage", "templateid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgmessage")." ADD   `templateid` varchar(50) DEFAULT '' COMMENT '模板ID';");
}
if(!pdo_fieldexists("vlinke_cparty_msgmessage", "templatename")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgmessage")." ADD   `templatename` varchar(20) DEFAULT '' COMMENT '模板名称';");
}
if(!pdo_fieldexists("vlinke_cparty_msgmessage", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgmessage")." ADD   `title` varchar(20) DEFAULT '' COMMENT '消息标题';");
}
if(!pdo_fieldexists("vlinke_cparty_msgmessage", "dataarr")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgmessage")." ADD   `dataarr` text COMMENT '参数组';");
}
if(!pdo_fieldexists("vlinke_cparty_msgmessage", "url")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgmessage")." ADD   `url` varchar(255) DEFAULT '' COMMENT '跳转链接';");
}
if(!pdo_fieldexists("vlinke_cparty_msgmessage", "miniprogram")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgmessage")." ADD   `miniprogram` varchar(500) DEFAULT '' COMMENT '跳转小程序';");
}
if(!pdo_fieldexists("vlinke_cparty_msgmessage", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgmessage")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_msgtemplate", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgtemplate")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_msgtemplate", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgtemplate")." ADD   `uniacid` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("vlinke_cparty_msgtemplate", "templateid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgtemplate")." ADD   `templateid` varchar(50) DEFAULT '' COMMENT '模板ID';");
}
if(!pdo_fieldexists("vlinke_cparty_msgtemplate", "templatename")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgtemplate")." ADD   `templatename` varchar(20) DEFAULT '' COMMENT '模板名称';");
}
if(!pdo_fieldexists("vlinke_cparty_msgtemplate", "dataarr")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_msgtemplate")." ADD   `dataarr` text COMMENT '参数组';");
}
if(!pdo_fieldexists("vlinke_cparty_notice", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_notice")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_notice", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_notice")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_notice", "branchid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_notice")." ADD   `branchid` int(10) unsigned NOT NULL COMMENT '发布组织';");
}
if(!pdo_fieldexists("vlinke_cparty_notice", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_notice")." ADD   `title` varchar(255) NOT NULL DEFAULT '' COMMENT '公告主题';");
}
if(!pdo_fieldexists("vlinke_cparty_notice", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_notice")." ADD   `details` text COMMENT '公告内容';");
}
if(!pdo_fieldexists("vlinke_cparty_notice", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_notice")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_notice", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_notice")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_param", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_param", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `title` varchar(255) NOT NULL COMMENT '系统名称';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "nicktil")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `nicktil` varchar(255) NOT NULL COMMENT '系统角色别称';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "openhome")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `openhome` tinyint(4) NOT NULL DEFAULT '0' COMMENT '开放系统首页：0不开放，1开放';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "openart")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `openart` tinyint(4) NOT NULL DEFAULT '0' COMMENT '开放党建动态栏：0不开放，1开放';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "expcount")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `expcount` text COMMENT '党费计算说明';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "serintegral")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `serintegral` int(10) DEFAULT '0' COMMENT '志愿服务积分值';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "actintegral")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `actintegral` int(10) DEFAULT '0' COMMENT '组织活动积分值';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "exadaystatus")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `exadaystatus` tinyint(4) NOT NULL DEFAULT '1' COMMENT '每日测试：1开启，2关闭';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "exaeverynum")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `exaeverynum` int(10) NOT NULL DEFAULT '0' COMMENT '每日答题数目';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "exaeveryint")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `exaeveryint` int(10) NOT NULL DEFAULT '0' COMMENT '每道题积分值';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "loginpic")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `loginpic` varchar(255) NOT NULL COMMENT '党员登录背景';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "loginmobile")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `loginmobile` tinyint(4) NOT NULL DEFAULT '0' COMMENT '手机号：0不填写，1填写不验证，2填写并短信验证';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "loginidnumber")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `loginidnumber` tinyint(4) NOT NULL DEFAULT '0' COMMENT '身份证号：0不填写，1填写';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "mypic")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `mypic` varchar(255) NOT NULL COMMENT '个人中心背景';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "telephone")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `telephone` varchar(255) NOT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "aboutus")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `aboutus` text COMMENT '关于我们';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "sharetitle")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `sharetitle` varchar(255) NOT NULL COMMENT '分享标题';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "sharepic")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `sharepic` varchar(255) NOT NULL COMMENT '分享小图';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "sharedesc")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `sharedesc` varchar(255) NOT NULL COMMENT '分享描述';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "wxappsharetitle")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `wxappsharetitle` varchar(255) NOT NULL COMMENT '小程序分享标题';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "wxappshareimageurl")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `wxappshareimageurl` varchar(255) NOT NULL COMMENT '小程序分享标图';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "pclogo")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `pclogo` varchar(255) NOT NULL COMMENT '组织管理PC端LOGO';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "pcfoot")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `pcfoot` text COMMENT '组织管理PC端页脚信息';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "homenav")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `homenav` text COMMENT '公众号首页导航';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "homecon")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `homecon` text COMMENT '公众号首页展示';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "footnav")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `footnav` text COMMENT '公众号底部导航';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "mynav")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `mynav` text COMMENT '公众号个人中心导航';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "wxapphomenav")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `wxapphomenav` text COMMENT '小程序首页导航';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "wxapphomecon")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `wxapphomecon` text COMMENT '小程序首页展示';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "wxappmynav")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `wxappmynav` text COMMENT '小程序个人中心导航';");
}
if(!pdo_fieldexists("vlinke_cparty_param", "wxappfootnav")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_param")." ADD   `wxappfootnav` text COMMENT '小程序底部导航';");
}
if(!pdo_fieldexists("vlinke_cparty_sercate", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sercate")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_sercate", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sercate")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_sercate", "name")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sercate")." ADD   `name` varchar(255) NOT NULL COMMENT '分类名称';");
}
if(!pdo_fieldexists("vlinke_cparty_sercate", "cicon")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sercate")." ADD   `cicon` varchar(255) NOT NULL COMMENT '分类图标';");
}
if(!pdo_fieldexists("vlinke_cparty_sercate", "navnumber")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sercate")." ADD   `navnumber` int(10) NOT NULL DEFAULT '0' COMMENT '宣传栏导航编号：0不显示';");
}
if(!pdo_fieldexists("vlinke_cparty_sercate", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sercate")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "branchid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `branchid` int(10) unsigned NOT NULL COMMENT '发布组织';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "cateid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `cateid` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "tilpic")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `tilpic` varchar(255) NOT NULL COMMENT '标题图';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "realname")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `realname` varchar(255) NOT NULL COMMENT '联系人姓名';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "mobile")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `mobile` varchar(255) NOT NULL COMMENT '联系人手机号';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "starttime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `starttime` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "endtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "address")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `address` varchar(255) NOT NULL COMMENT '地点';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "unumber")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `unumber` int(10) DEFAULT '0' COMMENT '招募人数';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "getval")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `getval` int(10) NOT NULL DEFAULT '0' COMMENT '每人得分值';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待审核，2招募中，3已完成';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `details` text COMMENT '详细说明';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_seritem", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_seritem")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_serlog", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_serlog")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_serlog", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_serlog")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_serlog", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_serlog")." ADD   `userid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_serlog", "itemid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_serlog")." ADD   `itemid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_serlog", "getval")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_serlog")." ADD   `getval` int(10) NOT NULL DEFAULT '0' COMMENT '得分值';");
}
if(!pdo_fieldexists("vlinke_cparty_serlog", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_serlog")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_sermessage", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sermessage")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_sermessage", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sermessage")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_sermessage", "itemid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sermessage")." ADD   `itemid` int(10) NOT NULL DEFAULT '0' COMMENT '活动ID';");
}
if(!pdo_fieldexists("vlinke_cparty_sermessage", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sermessage")." ADD   `userid` int(10) NOT NULL DEFAULT '0' COMMENT '留言ID';");
}
if(!pdo_fieldexists("vlinke_cparty_sermessage", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sermessage")." ADD   `details` text COMMENT '评论内容';");
}
if(!pdo_fieldexists("vlinke_cparty_sermessage", "picall")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sermessage")." ADD   `picall` text COMMENT '图片';");
}
if(!pdo_fieldexists("vlinke_cparty_sermessage", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_sermessage")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_slide", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_slide")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_slide", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_slide")." ADD   `uniacid` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("vlinke_cparty_slide", "position")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_slide")." ADD   `position` varchar(20) NOT NULL COMMENT '位置：home主页，arthome宣传，eduhome学习，suphome监督，serhome服务';");
}
if(!pdo_fieldexists("vlinke_cparty_slide", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_slide")." ADD   `title` varchar(50) DEFAULT '';");
}
if(!pdo_fieldexists("vlinke_cparty_slide", "tilpic")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_slide")." ADD   `tilpic` varchar(255) DEFAULT '';");
}
if(!pdo_fieldexists("vlinke_cparty_slide", "link")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_slide")." ADD   `link` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_slide", "wxapptype")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_slide")." ADD   `wxapptype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '小程序链接类型：1内部网页跳转，2外部网页跳转，3关联小程序跳转';");
}
if(!pdo_fieldexists("vlinke_cparty_slide", "wxapplink")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_slide")." ADD   `wxapplink` varchar(255) NOT NULL DEFAULT '' COMMENT '小程序链接';");
}
if(!pdo_fieldexists("vlinke_cparty_slide", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_slide")." ADD   `priority` int(10) NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_supmailbox", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supmailbox")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_supmailbox", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supmailbox")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_supmailbox", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supmailbox")." ADD   `userid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_supmailbox", "luserid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supmailbox")." ADD   `luserid` int(10) NOT NULL COMMENT '领导ID';");
}
if(!pdo_fieldexists("vlinke_cparty_supmailbox", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supmailbox")." ADD   `title` varchar(255) NOT NULL DEFAULT '' COMMENT '主题';");
}
if(!pdo_fieldexists("vlinke_cparty_supmailbox", "realname")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supmailbox")." ADD   `realname` varchar(255) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("vlinke_cparty_supmailbox", "mobile")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supmailbox")." ADD   `mobile` varchar(255) NOT NULL COMMENT '手机号';");
}
if(!pdo_fieldexists("vlinke_cparty_supmailbox", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supmailbox")." ADD   `details` text COMMENT '内容描述';");
}
if(!pdo_fieldexists("vlinke_cparty_supmailbox", "reply")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supmailbox")." ADD   `reply` text COMMENT '回复';");
}
if(!pdo_fieldexists("vlinke_cparty_supmailbox", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supmailbox")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待回复，2已回复';");
}
if(!pdo_fieldexists("vlinke_cparty_supmailbox", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supmailbox")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_supproposal", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supproposal")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_supproposal", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supproposal")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_supproposal", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supproposal")." ADD   `userid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_supproposal", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supproposal")." ADD   `title` varchar(255) NOT NULL DEFAULT '' COMMENT '主题';");
}
if(!pdo_fieldexists("vlinke_cparty_supproposal", "realname")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supproposal")." ADD   `realname` varchar(255) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("vlinke_cparty_supproposal", "mobile")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supproposal")." ADD   `mobile` varchar(255) NOT NULL COMMENT '手机号';");
}
if(!pdo_fieldexists("vlinke_cparty_supproposal", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supproposal")." ADD   `details` text COMMENT '内容描述';");
}
if(!pdo_fieldexists("vlinke_cparty_supproposal", "reply")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supproposal")." ADD   `reply` text COMMENT '回复';");
}
if(!pdo_fieldexists("vlinke_cparty_supproposal", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supproposal")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待处理，2已处理';");
}
if(!pdo_fieldexists("vlinke_cparty_supproposal", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supproposal")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_supreadily", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreadily")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_supreadily", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreadily")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_supreadily", "userid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreadily")." ADD   `userid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_supreadily", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreadily")." ADD   `title` varchar(255) NOT NULL DEFAULT '' COMMENT '主题';");
}
if(!pdo_fieldexists("vlinke_cparty_supreadily", "picall")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreadily")." ADD   `picall` text COMMENT '图片';");
}
if(!pdo_fieldexists("vlinke_cparty_supreadily", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreadily")." ADD   `details` text COMMENT '内容描述';");
}
if(!pdo_fieldexists("vlinke_cparty_supreadily", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreadily")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_supreport", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreport")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_supreport", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreport")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_supreport", "title")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreport")." ADD   `title` varchar(255) NOT NULL DEFAULT '' COMMENT '主题';");
}
if(!pdo_fieldexists("vlinke_cparty_supreport", "details")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreport")." ADD   `details` text COMMENT '内容';");
}
if(!pdo_fieldexists("vlinke_cparty_supreport", "picall")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreport")." ADD   `picall` text COMMENT '图片';");
}
if(!pdo_fieldexists("vlinke_cparty_supreport", "reply")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreport")." ADD   `reply` text COMMENT '处理结果';");
}
if(!pdo_fieldexists("vlinke_cparty_supreport", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreport")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1待处理，2处理中，2已处理';");
}
if(!pdo_fieldexists("vlinke_cparty_supreport", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_supreport")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "id")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("vlinke_cparty_user", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("vlinke_cparty_user", "branchid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `branchid` int(10) NOT NULL DEFAULT '0' COMMENT '所属组织ID';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "openid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `openid` varchar(255) NOT NULL COMMENT 'OpenID';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `nickname` varchar(255) NOT NULL COMMENT '昵称';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "headimgurl")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `headimgurl` varchar(255) NOT NULL COMMENT '微信头像';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "wxappopenid")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `wxappopenid` varchar(255) NOT NULL COMMENT 'wxappOpenID';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "wxappnickname")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `wxappnickname` varchar(255) NOT NULL COMMENT 'wxapp昵称';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "wxappheadimgurl")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `wxappheadimgurl` varchar(255) NOT NULL COMMENT 'wxapp微信头像';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "realname")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `realname` varchar(255) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "idnumber")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `idnumber` varchar(255) NOT NULL COMMENT '身份证号';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "mobile")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `mobile` varchar(255) NOT NULL COMMENT '手机号';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "headpic")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `headpic` varchar(255) NOT NULL COMMENT '真实头像';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "status")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1审核，2正常，3禁用';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "integral")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `integral` int(10) DEFAULT '0' COMMENT '积分';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "ulevel")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `ulevel` tinyint(4) NOT NULL DEFAULT '1' COMMENT '政治身份：1正式党员，2预备党员，3发展对象，4入党积极分子';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "partyday")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `partyday` varchar(255) NOT NULL COMMENT '入党日期';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "birthday")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `birthday` varchar(255) NOT NULL COMMENT '出生日期';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "sex")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '性别：1男，2女';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "origin")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `origin` varchar(255) NOT NULL COMMENT '籍贯';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "nation")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `nation` varchar(255) NOT NULL COMMENT '民族';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "education")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `education` varchar(255) NOT NULL COMMENT '文化程度';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "beizhu")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `beizhu` text COMMENT '备注信息';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `createtime` int(10) DEFAULT '0' COMMENT '创建时间';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "priority")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `priority` int(10) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "recycle")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `recycle` tinyint(4) NOT NULL DEFAULT '0' COMMENT '回收站：0正常，1已回收';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "loginname")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `loginname` varchar(255) NOT NULL COMMENT '登录用户名';");
}
if(!pdo_fieldexists("vlinke_cparty_user", "loginpass")) {
 pdo_query("ALTER TABLE ".tablename("vlinke_cparty_user")." ADD   `loginpass` varchar(255) NOT NULL COMMENT '登录密码';");
}

 ?>