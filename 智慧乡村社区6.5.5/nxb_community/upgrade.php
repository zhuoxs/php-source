<?php


//广告表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_adv') . " (
`aid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`img` text DEFAULT NULL COMMENT '广告图片地址',
`url` text DEFAULT NULL COMMENT '广告链接',
`title` varchar(255) DEFAULT NULL COMMENT '广告标题',
`createtime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告表' AUTO_INCREMENT=1 ;";

pdo_query($sql);

//分类表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_menu') . " (
`meid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`mimg` text DEFAULT NULL COMMENT '分类图片地址',
`jump` int(1) DEFAULT NULL COMMENT '是否跳转超链接：0为正常，1为跳转',
`murl` text DEFAULT NULL COMMENT '分类转向链接',
`mtitle` varchar(255) DEFAULT NULL COMMENT '分类标题',
`mtype` int(1) DEFAULT NULL COMMENT '分类的类型，导航是1，滑动导航是2',
`mstatus` int(1) DEFAULT NULL COMMENT '分类的发布状态， 1代表普通会员 2代表认证村民 3社区书记 4管理员',
`createtime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`meid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分类表' AUTO_INCREMENT=1 ;";

pdo_query($sql);


//会员表
$sql=
"CREATE TABLE IF NOT EXISTS " . tablename('bc_community_member') . " (
`mid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL COMMENT '所属公众号',
`openid` varchar(100) NOT NULL COMMENT '会员OPENID',
`idcard` bigint(18) NOT NULL COMMENT '身份证号码',
`grade` int(10) NOT NULL COMMENT '会员等级',
`userip` varchar(100) NOT NULL COMMENT '会员IP',
`gag` int(1) NOT NULL COMMENT '是否禁言：0为正常，1为禁言',
`blacklist` int(1) NOT NULL COMMENT '是否拉黑：0为正常，1为拉黑',
`nickname` varchar(100) NOT NULL COMMENT '会员昵称',
`realname` varchar(50) NOT NULL COMMENT '会员真实姓名',
`tel` bigint(14) NOT NULL COMMENT '会员电话',
`coid` int(11) NOT NULL COMMENT '市ID',
`dong` int(11) NOT NULL COMMENT '县区ID',
`danyuan` int(11) NOT NULL COMMENT '镇ID',
`menpai` int(11) NOT NULL COMMENT '村ID',
`address` varchar(255) NOT NULL COMMENT '会员地址',
`avatar` text NOT NULL COMMENT '会员头像',
`integral` varchar(20) NOT NULL COMMENT '会员积分',
`country` varchar(10) NOT NULL COMMENT '国家',
`province` varchar(10) NOT NULL COMMENT '省份',
`city` varchar(10) NOT NULL COMMENT '县区',
`createtime` int(10) NOT NULL,
PRIMARY KEY (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

pdo_query($sql);

//短信群
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_group') . " (
`gid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`gname` varchar(255) DEFAULT NULL COMMENT '群名称',
`gstatus` int(1) DEFAULT NULL COMMENT '群状态：0为正常，1为禁用',
`gmember` text DEFAULT NULL COMMENT '群成员',
`gctime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信群' AUTO_INCREMENT=1 ;";

pdo_query($sql);

//短信群管理员
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_gmanage') . " (
`gmid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`openid` varchar(100) NOT NULL COMMENT '会员OPENID',
`gmname` varchar(255) DEFAULT NULL COMMENT '管理员用户名',
`gmpassword` varchar(255) DEFAULT NULL COMMENT '管理员用户密码',
`gmctime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`gmid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信群管理员' AUTO_INCREMENT=1 ;";

pdo_query($sql);



//帖子表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_news') . " (
`nid` int(10) NOT NULL AUTO_INCREMENT,
`weid` int(10) NOT NULL COMMENT '所属公众号',
`nmenu` int(10) NOT NULL COMMENT '所属分类',
`mid` int(10) NOT NULL COMMENT '发布会员id',
`ntitle` varchar(255) NOT NULL COMMENT '帖子标题',
`ntext` text NOT NULL COMMENT '帖子内容',
`nimg` text NOT NULL COMMENT '帖子图片',

`time` text NOT NULL COMMENT '时间',
`qidian` text NOT NULL COMMENT '起点',
`zhongdian` text NOT NULL COMMENT '终点',
`dunwei` varchar(50) NOT NULL COMMENT '吨位（发货量）',
`yunfei` text NOT NULL COMMENT '运费',
`lxfs` varchar(50) NOT NULL COMMENT '联系方式',
`beizhu` text NOT NULL COMMENT '备注',
`didian` text NOT NULL COMMENT '地点',
`peoplenum` varchar(50) NOT NULL COMMENT '人数',
`njmc` text NOT NULL COMMENT '农机名称',
`jxdx` varchar(50) NOT NULL COMMENT '机型大小',
`ts` varchar(50) NOT NULL COMMENT '台数',
`dwgs` varchar(100) NOT NULL COMMENT '单位/工时',
`name` varchar(50) NOT NULL COMMENT '姓名',
`sfz` varchar(50) NOT NULL COMMENT '身份证',
`qsl` varchar(50) NOT NULL COMMENT '起收量',
`fmzl` text NOT NULL COMMENT '贩卖种类',
`producttype` varchar(50) NOT NULL COMMENT '产品类型',
`remark` text NOT NULL COMMENT '备注',
`top` int(1) NOT NULL COMMENT '是否置顶',
`wishrl` int(1) NOT NULL COMMENT '是否认领',
`wishurl` text NOT NULL COMMENT '微心愿超链接',
`wishtel` bigint(11) NOT NULL COMMENT '微心愿认领手机号码',
`wishname` varchar(50) NOT NULL COMMENT '微心愿认领人姓名',
`wishcode` int(6) NOT NULL COMMENT '微心愿认领手机验证码',
`wishcompany` text NOT NULL COMMENT '微心愿认领人所在单位',
`status` int(1) NOT NULL COMMENT '是否审核',
`browser` int(10) NOT NULL COMMENT '浏览量',
`nctime` int(10) NOT NULL,

PRIMARY KEY (`nid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='帖子表' AUTO_INCREMENT=1 ;";

pdo_query($sql);

//评论表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_comment') . " (
`cid` int(10) NOT NULL AUTO_INCREMENT,
`weid` int(10) NOT NULL COMMENT '所属公众号',
`newsid` int(10) NOT NULL COMMENT '所属帖子ID',
`mid` int(10) NOT NULL COMMENT '发布会员id',
`comment` varchar(255) NOT NULL COMMENT '评论内容',
`cctime` int(10) NOT NULL,
PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='评论表' AUTO_INCREMENT=1 ;";

pdo_query($sql);

//基础设置表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_base') . " (
`id` int(10) NOT NULL AUTO_INCREMENT,
`weid` int(10) NOT NULL COMMENT '所属公众号',
`title` varchar(50) NOT NULL COMMENT '模块标题',
`bg` text NOT NULL COMMENT '首页背景',
`remark` text NOT NULL COMMENT '备注说明之类的',
`notice` text NOT NULL COMMENT '公告栏通知',
`noticeurl` text NOT NULL COMMENT '通知链接',
`zdymenu` varchar(50) NOT NULL COMMENT '自定义底部导航名称',
`zdymenuid` varchar(50) NOT NULL COMMENT '自定义分类ID',
`copyright` varchar(255) NOT NULL COMMENT '版权文字',
`agreement` varchar(255) NOT NULL COMMENT '协议',
`ewm` text NOT NULL  COMMENT '二维码',
`createtime` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='基础设置' AUTO_INCREMENT=1 ;";

pdo_query($sql);

//建议表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_proposal') . " (
`pid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`mid` int(11) DEFAULT NULL COMMENT '用户ID',
`ptype` int(11) DEFAULT NULL COMMENT '建议所属类型id',
`ptext` varchar(255) DEFAULT NULL COMMENT '建议文字',
`paddress` varchar(255) DEFAULT NULL COMMENT '建议人详细地址',
`pimg` text DEFAULT NULL COMMENT '建议图片',
`pctime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='建议表' AUTO_INCREMENT=1 ;";

pdo_query($sql);


//问题类型表

$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_type') . " (
`tid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`tname` varchar(255) DEFAULT NULL COMMENT '问题类型名称',
`tstatus` int(1) DEFAULT NULL COMMENT '问题类型状态：0为正常，1为禁用',
`tctime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='问题类型表' AUTO_INCREMENT=1 ;";

pdo_query($sql);

//点赞表

$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_thumbs') . " (
`thid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`newsid` int(11) DEFAULT NULL COMMENT '帖子id',
`mid` int(11) DEFAULT NULL COMMENT '用户ID',
`thstatus` int(11) NOT NULL COMMENT '点赞状态，1点赞 0取消赞',
`thctime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`thid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='点赞表' AUTO_INCREMENT=1 ;";

pdo_query($sql);



//村民信息库表

$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_information') . " (
`inid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`realname` varchar(50) DEFAULT NULL COMMENT '真实姓名',
`identitycard` varchar(50) DEFAULT NULL COMMENT '身份证',
`inctime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`inid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='村民信息库表' AUTO_INCREMENT=1 ;";

pdo_query($sql);

//小区表

$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_community') . " (
`coid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`coname` varchar(255) DEFAULT NULL COMMENT '问题类型名称',
`cotime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`coid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小区表' AUTO_INCREMENT=1 ;";

pdo_query($sql);

//志愿服务报名表

$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_report') . " (
`reid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`mid` int(11) DEFAULT NULL COMMENT '用户ID',
`newsid` int(11) DEFAULT NULL COMMENT '活动帖子ID',
`username` varchar(50) DEFAULT NULL COMMENT '真实姓名',
`telephone` bigint(11) DEFAULT NULL COMMENT '联系电话',
`createtime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`reid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='志愿服务报名表' AUTO_INCREMENT=1 ;";

pdo_query($sql);



//2017.07.17
if(!pdo_fieldexists('bc_community_community', 'cocontant')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_community')." ADD `cocontant` varchar(50) NOT NULL COMMENT '小区联系人'; ");
}
if(!pdo_fieldexists('bc_community_proposal', 'phandle')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_proposal')." ADD `phandle` text NOT NULL COMMENT '处理详情'; ");
}
if(!pdo_fieldexists('bc_community_proposal', 'phandleper')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_proposal')." ADD `phandleper` varchar(50) NOT NULL COMMENT '处理人'; ");
}
if(!pdo_fieldexists('bc_community_proposal', 'phandletime')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_proposal')." ADD `phandletime` int(11) NOT NULL COMMENT '处理时间'; ");
}
if(!pdo_fieldexists('bc_community_proposal', 'pstatus')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_proposal')." ADD `pstatus` int(1) NOT NULL COMMENT '处理状态'; ");
}


/**2018.05.04 peng***/
//新增帖子发布权限表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_authority') . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`authortitle` varchar(50) DEFAULT NULL COMMENT '权限名称',
`createtime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新增帖子发布权限表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

if(!pdo_fieldexists('bc_community_menu', 'authorid')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_menu')." ADD `authorid` varchar(100) NOT NULL COMMENT '发布权限ID集合'; ");
}

if(!pdo_fieldexists('bc_community_base', 'zdyurl')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_base')." ADD `zdyurl` text NOT NULL COMMENT '自定义导航链接'; ");
}

/**2018.05.08 peng***/
//管理权限表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_jurisdiction') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`lev` tinyint(1) DEFAULT NULL COMMENT '级别0是市1是区县2是镇3是村',
`pid` int(10) NOT NULL COMMENT '父级ID',
`uname` varchar(50) NOT NULL COMMENT '用户名',
`upsd` varchar(150) NOT NULL COMMENT '用户密码',
`townid` int(10) NOT NULL COMMENT '村镇ID',
`ctime` int(10) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理权限表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//村镇管理表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_town') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`lev` tinyint(1) DEFAULT NULL COMMENT '级别0是市1是区县2是镇3是村',
`pid` int(10) NOT NULL COMMENT '父级ID',
`name` varchar(50) NOT NULL COMMENT '名称',
`cover` text NOT NULL COMMENT '封面图片',
`photo` text NOT NULL COMMENT '相册',
`remark` varchar(250) NOT NULL COMMENT '简介',
`comment` text NOT NULL COMMENT '详情',
`status` tinyint(1) NOT NULL COMMENT '',
`paixu` int(10) NOT NULL COMMENT '排序',
`latlong` varchar(40) NOT NULL COMMENT '经纬度',
`contacts` varchar(40) NOT NULL COMMENT '联系人',
`tel` varchar(40) NOT NULL COMMENT '联系电话',
`ctime` int(10) NOT NULL COMMENT '创建时间',
`rd` int(10) NOT NULL COMMENT '发帖总数',
`color` varchar(40) NOT NULL COMMENT '按钮颜色',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='村镇管理表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//平台首页导航表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_nav') . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`mimg` text DEFAULT NULL COMMENT '分类图片地址',
`jump` int(1) DEFAULT NULL COMMENT '是否跳转超链接：0为正常，1为跳转',
`murl` text DEFAULT NULL COMMENT '导航转向链接',
`mtitle` varchar(255) DEFAULT NULL COMMENT '标题',
`createtime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='bc_community_nav' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//关注表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_guanzhu') . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`townid` int(11) DEFAULT NULL COMMENT '村镇ID',
`mid` int(11) DEFAULT NULL COMMENT '用户ID',
`createtime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='bc_community_guanzhu' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//认证表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_renzheng') . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`townid` int(11) DEFAULT NULL COMMENT '村镇ID',
`mid` int(11) DEFAULT NULL COMMENT '用户ID',
`createtime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='bc_community_renzheng' AUTO_INCREMENT=1 ;";
pdo_query($sql);


//救助扶贫表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_help') . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`townid` int(11) DEFAULT NULL COMMENT '村镇ID',
`mid` int(11) DEFAULT NULL COMMENT '用户ID',
`uname` varchar(40) DEFAULT NULL COMMENT '姓名',
`sex` tinyint(1) DEFAULT NULL COMMENT '性别',
`age` varchar(20) DEFAULT NULL COMMENT '年龄',
`tel` varchar(30) DEFAULT NULL COMMENT '电话',
`xueli` varchar(30) DEFAULT NULL COMMENT '学历',
`family` varchar(30) DEFAULT NULL COMMENT '家庭成员',
`stzk` varchar(30) DEFAULT NULL COMMENT '身体状况',
`jtsr` tinyint(1) DEFAULT NULL COMMENT '家庭收入1是0-5000元2是5000-10000元3是10000至3万元4是3万元至10万元5是10万元以上6是其它',
`jtzk` varchar(100) DEFAULT NULL COMMENT '家庭状况',
`nhgs` varchar(250) DEFAULT NULL COMMENT '农户故事',
`jtcp` varchar(100) DEFAULT NULL COMMENT '家庭产品',
`jiage` varchar(100) DEFAULT NULL COMMENT '价格',
`songhuo` varchar(100) DEFAULT NULL COMMENT '送货',
`srly` varchar(100) DEFAULT NULL COMMENT '收入来源',
`cpxq` varchar(200) DEFAULT NULL COMMENT '产品详情',
`cover` text DEFAULT NULL COMMENT '封面图片',
`photo` text DEFAULT NULL COMMENT '相册',
`createtime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='bc_community_help' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//乡村组织级别表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_organlev') . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`townid` int(11) DEFAULT NULL COMMENT '村镇ID',
`organname` varchar(50) DEFAULT NULL COMMENT '乡村组织级别名称',
`ctime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='乡村组织级别表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//乡村组织成员表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_organuser') . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL COMMENT '公众号ID',
`townid` int(11) DEFAULT NULL COMMENT '村镇ID',
`organid` int(11) DEFAULT NULL COMMENT '乡村组织级别ID',
`username` varchar(50) DEFAULT NULL COMMENT '成员姓名',
`cover` text DEFAULT NULL COMMENT '头像',
`sex` tinyint(1) DEFAULT NULL COMMENT '性别1男2女',
`tel` varchar(40) DEFAULT NULL COMMENT '联系电话',
`zhiwei` varchar(100) DEFAULT NULL COMMENT '职位',
`company` varchar(100) DEFAULT NULL COMMENT '工作单位',
`comment` text DEFAULT NULL COMMENT '简介',
`ctime` int(11) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='乡村组织成员表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//种养技术分类
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_coursetype') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`pid` int(10) NOT NULL COMMENT '分类父ID',
`title` varchar(100) NOT NULL COMMENT '分类名称',
`cover`  text NOT NULL COMMENT '分类图标',
`paixu`  int(10) NOT NULL COMMENT '排序',
`status`  tinyint(1) NOT NULL COMMENT '状态0显示1隐藏',
`ctime` int(10) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='种养技术分类' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//种养技术课程表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_courselesson') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`townid` int(11) DEFAULT NULL COMMENT '村镇ID',
`userid` int(10) NOT NULL COMMENT '发布人ID',
`typeid` int(10) NOT NULL COMMENT '课程分类id',
`title` varchar(100) NOT NULL COMMENT '课程标题',
`comment` text NOT NULL COMMENT '课程介绍',
`cover`  text NOT NULL COMMENT '课程封面图片',
`clicks` int(10) NOT NULL COMMENT '点击量',
`status` tinyint(1) NOT NULL COMMENT '审核状态1已审核2未审核',
`ctime` int(10) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='种养技术课程表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//种养技术课时表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_coursesection') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`townid` int(11) DEFAULT NULL COMMENT '村镇ID',
`userid` int(10) NOT NULL COMMENT '发布人ID',
`typeid` int(10) NOT NULL COMMENT '课程分类id',
`lessonid` int(10) NOT NULL COMMENT '课程id',
`title` varchar(100) NOT NULL COMMENT '课时标题',
`videourl` text NOT NULL COMMENT '视频链接',
`audiourl` text NOT NULL COMMENT '音频链接',
`clicks` int(10) NOT NULL COMMENT '点击量',
`status` tinyint(1) NOT NULL COMMENT '审核状态1已审核2未审核',
`ctime` int(10) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='种养技术课时表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//消息表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_messages') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`mid` int(11) NOT NULL COMMENT '用户id',
`townid` int(11) NOT NULL COMMENT '乡镇id',
`villageid` int(11) NOT NULL COMMENT '村庄id',
`type` varchar(50) NOT NULL COMMENT '消息主题',
`manageid` int(11) NOT NULL COMMENT '发布管理员ID',
`title` varchar(100) NOT NULL COMMENT '消息标题',
`content` varchar(255) NOT NULL COMMENT '消息内容',
`status` tinyint(1) NOT NULL COMMENT '阅读状态0为未读1为已读',
`ctime` int(10) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='消息表' AUTO_INCREMENT=1 ;";
pdo_query($sql);


if(!pdo_fieldexists('bc_community_news', 'coid')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_news')." ADD `coid` int(11) NOT NULL COMMENT '市ID'; ");
}
if(!pdo_fieldexists('bc_community_news', 'dong')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_news')." dong `pstatus` int(11) NOT NULL COMMENT '县区ID'; ");
}
if(!pdo_fieldexists('bc_community_news', 'danyuan')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_news')." ADD `danyuan` int(11) NOT NULL COMMENT '镇ID'; ");
}
if(!pdo_fieldexists('bc_community_news', 'menpai')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_news')." ADD `menpai` int(11) NOT NULL COMMENT '村ID'; ");
}
if(!pdo_fieldexists('bc_community_member', 'isrz')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_member')." ADD `isrz` tinyint(1) NOT NULL COMMENT '是否认证1是0否'; ");
}
if(!pdo_fieldexists('bc_community_menu', 'townid')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_menu')." ADD `townid` int(10) NOT NULL COMMENT '村镇ID'; ");
}
if(!pdo_fieldexists('bc_community_base', 'cmslogo1')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_base')." ADD `cmslogo1` text NOT NULL COMMENT '后台登录LOGO1'; ");
}
if(!pdo_fieldexists('bc_community_base', 'cmslogo2')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_base')." ADD `cmslogo2` text NOT NULL COMMENT '后台左上角LOGO2'; ");
}
if(!pdo_fieldexists('bc_community_base', 'tianqi')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_base')." ADD `tianqi` text NOT NULL COMMENT '天气代码'; ");
}
if(!pdo_fieldexists('bc_community_base', 'tianqibg')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_base')." ADD `tianqibg` varchar(20) NOT NULL COMMENT '天气代码背景色'; ");
}
if(!pdo_fieldexists('bc_community_base', 'zdymenu4')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_base')." ADD `zdymenu4` text NOT NULL COMMENT '底部第四个自定义底部导航名称'; ");
}
if(!pdo_fieldexists('bc_community_base', 'zdyurl4')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_base')." ADD `zdyurl4` text NOT NULL COMMENT '底部第四个自定义导航链接'; ");
}

if(!pdo_fieldexists('bc_community_help', 'menpai')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_help')." ADD `menpai` int(11) NOT NULL COMMENT '村ID'; ");
}
if(!pdo_fieldexists('bc_community_courselesson', 'menpai')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_courselesson')." ADD `menpai` int(11) NOT NULL COMMENT '村ID'; ");
}

if(!pdo_fieldexists('bc_community_organlev', 'villageid')) {
	pdo_query("ALTER TABLE ".tablename('bc_community_organlev')." ADD `villageid` int(11) NOT NULL COMMENT '村庄ID'; ");
}




//商城基础设置表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_base') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`shopname` varchar(50) NOT NULL COMMENT '商城名称',
`content` text NOT NULL COMMENT '商城入驻说明',
`ctime` int(10) NOT NULL COMMENT '创建时间',
`danyuan` int(11) NOT NULL COMMENT '镇ID',
`menpai` int(11) NOT NULL COMMENT '村ID',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商城基础设置表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//大客户预约表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_bespeak') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`mid` int(11) NOT NULL COMMENT '用户id',
`sid` int(11) NOT NULL COMMENT '商家id',
`pid` int(10) NOT NULL COMMENT '产品ID',
`content` text NOT NULL COMMENT '预约说明',
`contacts` varchar(50) NOT NULL COMMENT '联系人',
`mobile` varchar(50) NOT NULL COMMENT '联系电话',
`ctime` int(10) NOT NULL COMMENT '创建时间',
`danyuan` int(11) NOT NULL COMMENT '预约商户所属镇ID',
`menpai` int(11) NOT NULL COMMENT '预约商户所属村ID',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='大客户预约表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//商城banner
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_banner') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`simg` text NOT NULL COMMENT '图片地址',
`surl` text NOT NULL COMMENT '链接',
`stitle` varchar(255) NOT NULL COMMENT '标题',
`ctime` int(10) NOT NULL COMMENT '创建时间',
`danyuan` int(11) NOT NULL COMMENT '镇ID',
`menpai` int(11) NOT NULL COMMENT '村ID',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商城banner' AUTO_INCREMENT=1 ;";
pdo_query($sql);


//商品分类
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_category') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`pid` int(10)  NOT NULL COMMENT '分类父ID',
`cicon` text NOT NULL COMMENT '分类图标',
`ctitle` varchar(50) NOT NULL COMMENT '标题',
`status` tinyint(1) NOT NULL COMMENT '状态1显示2不显示',
`ctime` int(10) NOT NULL COMMENT '创建时间',
`danyuan` int(11) NOT NULL COMMENT '镇ID',
`menpai` int(11) NOT NULL COMMENT '村ID',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品分类' AUTO_INCREMENT=1 ;";
pdo_query($sql);


//商城导航
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_nav') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`nicon` text NOT NULL COMMENT '分类图标',
`nurl` text NOT NULL COMMENT '链接',
`ntitle` varchar(50) NOT NULL COMMENT '标题',
`ctime` int(10) NOT NULL COMMENT '创建时间',
`danyuan` int(11) NOT NULL COMMENT '镇ID',
`menpai` int(11) NOT NULL COMMENT '村ID',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商城导航' AUTO_INCREMENT=1 ;";
pdo_query($sql);


//商品表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_goods') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`mid` int(11) NOT NULL COMMENT '用户id',
`sid` int(11) NOT NULL COMMENT '商家id',
`pptid` int(10) NOT NULL COMMENT '产品一级分类ID',
`ptid` int(10) NOT NULL COMMENT '产品二级分类ID',
`is_hot` int(1) NOT NULL COMMENT '是否推荐，0表示不推荐，1表示推荐',
`pimg` text NOT NULL  COMMENT '产品封面图片',
`photo` text NOT NULL  COMMENT '产品相册',
`ptitle` varchar(255) NOT NULL COMMENT '产品标题',
`price` decimal(10,2) DEFAULT '0.00' COMMENT '价格',
`punit` varchar(50) NOT NULL COMMENT '单位/规格',
`pqty` int(10) NOT NULL COMMENT '产品总数量',
`pyqty` int(10) NOT NULL COMMENT '产品已售数量',
`pcontent` text NOT NULL  COMMENT '产品详情',
`pstatus` int(1) NOT NULL COMMENT '产品状态，0表示待审核，1表示正常，2表示下架',
`pstrattime` varchar(50) NOT NULL,
`pctime` int(10) NOT NULL,
`danyuan` int(11) NOT NULL COMMENT '发布商品的用户所属镇ID',
`menpai` int(11) NOT NULL COMMENT '发布商品的用户所属村ID',
`baseyf` decimal(10,2) DEFAULT '0.00' COMMENT '单个规格的运费',
`addyf` decimal(10,2) DEFAULT '0.00' COMMENT '超出基础运费按规格数量累计',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品表' AUTO_INCREMENT=1 ;";
pdo_query($sql);


//商家表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_seller') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`mid` int(10) NOT NULL COMMENT '用户ID',
`idcard` varchar(20) NOT NULL COMMENT '身份证号',
`cashcard` varchar(50) NOT NULL COMMENT '提现卡号',
`slogo` text NOT NULL COMMENT '商家LOGO',
`scover` text NOT NULL COMMENT '商家封面图片',
`stitle` varchar(150) NOT NULL COMMENT '商家名称',
`content` text NOT NULL COMMENT '商家介绍',
`browse` int(10) NOT NULL COMMENT '浏览量',
`tese` text NOT NULL COMMENT '商家特色',
`contacts` varchar(50) NOT NULL COMMENT '联系人',
`mobile` varchar(50) NOT NULL COMMENT '联系电话',
`address` varchar(150) NOT NULL COMMENT '联系地址',
`longitude` varchar(30) NOT NULL COMMENT '定位经度',
`latitude` varchar(30) NOT NULL COMMENT '定位纬度',
`ctime` int(10) NOT NULL COMMENT '创建时间',
`danyuan` int(11) NOT NULL COMMENT '镇ID',
`menpai` int(11) NOT NULL COMMENT '村ID',
`rz` tinyint(1) NOT NULL COMMENT '认证状态0未通过1待完善2已认证',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商家表' AUTO_INCREMENT=1 ;";
pdo_query($sql);


//订单表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_orders') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '产品订单ID',
`pocode` varchar(30) NOT NULL COMMENT '产品订单编号',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`pcover` text NOT NULL COMMENT '产品图片快照',
`poinfo` text NOT NULL  COMMENT '产品订单快照',
`pid` int(10) NOT NULL COMMENT '产品ID',
`sid` int(10) NOT NULL COMMENT '商家ID',
`mid` int(10) NOT NULL COMMENT '用户ID',
`pnum` int(10) NOT NULL COMMENT '产品数量',
`oneprice` decimal(10,2) DEFAULT '0.00' COMMENT '产品单价',
`goodsprice` decimal(10,2) DEFAULT '0.00' COMMENT '产品总价',
`yf` decimal(10,2) DEFAULT '0.00' COMMENT '运费',
`orderprice` decimal(10,2) DEFAULT '0.00' COMMENT '产品订单总价',
`postatus` int(1) NOT NULL COMMENT '订单状态0未支付1已付款未发货2已付款已发货3已收到货待确认4收货方自然确认5有问题需人工介入处理6人工客服确认',
`remark` varchar(255) NOT NULL COMMENT '订单处理备注',
`shuser` varchar(200) NOT NULL COMMENT '收货人',
`shaddress` varchar(200) NOT NULL COMMENT '收货地址',
`express` varchar(100) NOT NULL COMMENT '快递记录',
`poctime` int(10) NOT NULL COMMENT '产品订单创建时间',
`potime1` int(10) NOT NULL COMMENT '产品订单支付时间',
`potime2` int(10) NOT NULL COMMENT '产品订单发货时间',
`potime3` int(10) NOT NULL COMMENT '产品订单确认收货时间',
`potime4` int(10) NOT NULL COMMENT '问题订单提交人工客服处理时间',
`potime5` int(10) NOT NULL COMMENT '人工确认订单时间',
`potime6` int(10) NOT NULL COMMENT '商家最后编辑时间',
`danyuan` int(11) NOT NULL COMMENT '商家所属镇ID',
`menpai` int(11) NOT NULL COMMENT '商家所属村ID',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品订单表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//收货地址表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_address') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`mid` int(10) NOT NULL COMMENT '用户ID',
`contacts` varchar(50) NOT NULL COMMENT '联系人',
`mobile` varchar(50) NOT NULL COMMENT '联系电话',
`city` varchar(150) NOT NULL COMMENT '地区',
`address` varchar(150) NOT NULL COMMENT '联系地址',
`ctime` int(10) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='收货地址表' AUTO_INCREMENT=1 ;";
pdo_query($sql);


//钱包记录表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_wallet') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`mid` int(10) NOT NULL COMMENT '用户ID',
`amount` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
`type` tinyint(1) NOT NULL COMMENT '类型1收入2提现3平台交易手续费',
`status` tinyint(1) NOT NULL COMMENT '状态1是已审核0是未审核',
`remark` varchar(150) NOT NULL COMMENT '备注',
`ctime` int(10) NOT NULL COMMENT '创建时间',
`etime` int(10) NOT NULL COMMENT '处理时间',
`danyuan` int(11) NOT NULL COMMENT '镇ID',
`menpai` int(11) NOT NULL COMMENT '村ID',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='钱包记录表' AUTO_INCREMENT=1 ;";
pdo_query($sql);


//商城消息表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_messages') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`mid` int(11) NOT NULL COMMENT '用户id',
`townid` int(11) NOT NULL COMMENT '乡镇id',
`villageid` int(11) NOT NULL COMMENT '村庄id',
`type` tinyint(1) NOT NULL COMMENT '消息主题1新订单消息2订单状态变更消息3提现消息4提现进度消息',
`title` varchar(100) NOT NULL COMMENT '消息标题',
`content` varchar(255) NOT NULL COMMENT '消息内容',
`status` tinyint(1) NOT NULL COMMENT '阅读状态0为未读1为已读',
`ctime` int(10) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商城消息表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//商户操作日志表
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_log') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`mid` int(11) NOT NULL COMMENT '用户id',
`sid` int(11) NOT NULL COMMENT '商户id',
`townid` int(11) NOT NULL COMMENT '乡镇id',
`villageid` int(11) NOT NULL COMMENT '村庄id',
`type` tinyint(1) NOT NULL COMMENT '日志类型1商品编辑2订单状态变更3订单金额修改',
`content` varchar(255) NOT NULL COMMENT '日志内容',
`ctime` int(10) NOT NULL COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商户操作日志表' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//文章分类
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_arttype') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`pid` int(10)  NOT NULL COMMENT '分类父ID',
`cicon` text NOT NULL COMMENT '分类图标',
`ctitle` varchar(50) NOT NULL COMMENT '标题',
`status` tinyint(1) NOT NULL COMMENT '状态1显示2不显示',
`ctime` int(10) NOT NULL COMMENT '创建时间',
`danyuan` int(11) NOT NULL COMMENT '镇ID',
`menpai` int(11) NOT NULL COMMENT '村ID',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章分类' AUTO_INCREMENT=1 ;";
pdo_query($sql);

//文章详情
$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_mall_article') . " (
`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '',
`weid` int(10) NOT NULL COMMENT '公众号ID',
`pid` int(10)  NOT NULL COMMENT '分类ID',
`cicon` text NOT NULL COMMENT '封面图片',
`ctitle` varchar(50) NOT NULL COMMENT '标题',
`content` text NOT NULL COMMENT '文章内容',
`photo` text NOT NULL COMMENT '文章图片',
`status` tinyint(1) NOT NULL COMMENT '状态1显示2不显示',
`ctime` int(10) NOT NULL COMMENT '创建时间',
`clidk` int(10) NOT NULL COMMENT '点击量',
`danyuan` int(11) NOT NULL COMMENT '镇ID',
`menpai` int(11) NOT NULL COMMENT '村ID',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章详情' AUTO_INCREMENT=1 ;";
pdo_query($sql);


if(!pdo_fieldexists('bc_community_news', 'choice')) {
    pdo_query("ALTER TABLE ".tablename('bc_community_news')." ADD `choice` TINYINT(1) NOT NULL DEFAULT '0'; ");
}

if(!pdo_fieldexists('nx_information_plant', 'total_area')) {
    pdo_query("ALTER TABLE ".tablename('nx_information_plant')." ADD `total_area` DECIMAL(10,2) NOT NULL; ");
}

if(!pdo_fieldexists('nx_information_plant', 'plant_type')) {
    pdo_query("ALTER TABLE ".tablename('nx_information_plant')." ADD `plant_type` VARCHAR(20) NOT NULL; ");
}

if(!pdo_fieldexists('nx_information_family', 'birthday')) {
    pdo_query("ALTER TABLE ".tablename('nx_information_family')." ADD `birthday` INT(10) NOT NULL; ");
}

if(!pdo_fieldexists('nx_information_family', 'lonely')) {
    pdo_query("ALTER TABLE ".tablename('nx_information_family')." ADD `lonely` SMALLINT(1) NOT NULL DEFAULT '0' COMMENT '孤寡老人' AFTER `birthday`, ADD `children` SMALLINT(1) NOT NULL DEFAULT '0' COMMENT '留守儿童' AFTER `lonely`, ADD `poverty` SMALLINT(1) NOT NULL DEFAULT '0' COMMENT '贫困家庭' AFTER `children`, ADD `disability` SMALLINT(1) NOT NULL DEFAULT '0' COMMENT '残疾人群' AFTER `poverty`; ");
}

if(!pdo_fieldexists('bc_community_authority', 'town_id')) {
    pdo_query("ALTER TABLE ".tablename('bc_community_authority')." ADD `town_id` INT(10) NOT NULL DEFAULT '0'; ");
}

if(!pdo_fieldexists('bc_community_proposal', 'town_id')) {
    pdo_query("ALTER TABLE ".tablename('bc_community_proposal')." ADD `town_id` INT(10) NOT NULL; ");
}

if(!pdo_fieldexists('bc_community_type', 'town_id')) {
    pdo_query("ALTER TABLE ".tablename('bc_community_type')." ADD `town_id` MEDIUMINT(8) NOT NULL; ");
}

if(!pdo_fieldexists('bc_community_coursetype', 'town_id')) {
    pdo_query("ALTER TABLE ".tablename('bc_community_coursetype')." ADD `town_id` INT(10) NOT NULL DEFAULT '0'; ");
}

if(!pdo_fieldexists('bc_community_tour_sights', 'good')) {
    pdo_query("ALTER TABLE ".tablename('bc_community_tour_sights')." ADD `good` INT(10) NOT NULL COMMENT '好评' AFTER `dateline`, ADD `general` INT(10) NOT NULL COMMENT '中评' AFTER `good`, ADD `poor` INT(10) NOT NULL COMMENT '差评' AFTER `general`; ");
}

if(!pdo_fieldexists('bc_community_tour_food', 'good')) {
    pdo_query("ALTER TABLE ".tablename('bc_community_tour_food')." ADD `good` INT(10) NOT NULL COMMENT '好评' AFTER `dateline`, ADD `general` INT(10) NOT NULL COMMENT '中评' AFTER `good`, ADD `poor` INT(10) NOT NULL COMMENT '差评' AFTER `general`; ");
}

if(!pdo_fieldexists('bc_community_tour_hotel', 'good')) {
    pdo_query("ALTER TABLE ".tablename('bc_community_tour_hotel')." ADD `good` INT(10) NOT NULL COMMENT '好评' AFTER `dateline`, ADD `general` INT(10) NOT NULL COMMENT '中评' AFTER `good`, ADD `poor` INT(10) NOT NULL COMMENT '差评' AFTER `general`; ");
}


$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_assess_log') . " (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `link_id` int(10) NOT NULL COMMENT '连接评价内容的ID',
  `assess` tinyint(1) NOT NULL COMMENT '评价内容：1好评2中评3差评',
  `a_type` smallint(4) NOT NULL COMMENT '价格类型：1景点2美食3住宿',
  `dateline` int(10) NOT NULL COMMENT '评价时间',
  `mid` int(10) NOT NULL COMMENT '评价人ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
pdo_query($sql);

$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_tour_comment') . " (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `link_id` int(10) NOT NULL COMMENT '评论链接ID',
  `mid` int(10) NOT NULL COMMENT '评论人ID',
  `ctype` smallint(1) NOT NULL COMMENT '评论类型：1景点2美食3住宿',
  `message` text NOT NULL,
  `dateline` int(10) NOT NULL COMMENT '评论时间',
  `likes` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
pdo_query($sql);

$sql="
CREATE TABLE IF NOT EXISTS " . tablename('bc_community_tour_like_log') . " (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `link_id` int(10) NOT NULL,
  `mid` int(10) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
pdo_query($sql);

$sql="CREATE TABLE IF NOT EXISTS ".tablename('bc_community_messages_record')." (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `message_id` int(10) NOT NULL,
  `mid` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `read_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
pdo_query($sql);

if(!pdo_fieldexists('bc_community_organuser', 'displayorder')) {
    pdo_query("ALTER TABLE ".tablename('bc_community_organuser')." ADD `displayorder` SMALLINT(4) NOT NULL DEFAULT '0'; ");
}

if(!pdo_fieldexists('bc_community_organuser', 'article_index_name')) {
    pdo_query("ALTER TABLE ".tablename('bc_community_base')." ADD `article_index_name` VARCHAR(100) NOT NULL;");
}


$sql="CREATE TABLE IF NOT EXISTS ".tablename("bc_community_article")." (
  `aid` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `class_id` int(10) NOT NULL,
  `author_id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `click` int(10) NOT NULL DEFAULT '0',
  `town_id` int(10) NOT NULL,
  `slide` smallint(1) NOT NULL DEFAULT '0',
  `recommend` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL,
  `good` int(10) NOT NULL DEFAULT '0',
  `general` int(10) NOT NULL DEFAULT '0',
  `poor` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS ".tablename('bc_community_article_class')." (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `town_id` int(10) NOT NULL DEFAULT '0',
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `classname` varchar(60) NOT NULL COMMENT '分类名称',
  `displayorder` smallint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS ".tablename('bc_community_article_nav')." (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0',
  `title` varchar(80) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `article_class` int(10) NOT NULL DEFAULT '0',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";
pdo_query($sql);

$sql="CREATE TABLE IF NOT EXISTS ".tablename('bc_community_service')." (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0',
  `town_id` int(10) NOT NULL DEFAULT '0',
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `service_name` varchar(100) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS ".tablename('bc_community_slide')." (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0',
  `type` int(10) NOT NULL COMMENT '1更多服务',
  `title` varchar(100) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  `link_id` int(10) NOT NULL DEFAULT '0',
  `town_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";
pdo_query($sql);
