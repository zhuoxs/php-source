<?php 
$sql="CREATE TABLE IF NOT EXISTS `ims_bc_community__breed` (
  `breid` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `hid` int(10) NOT NULL COMMENT '户ID',
  `bianma` varchar(50) NOT NULL COMMENT '户编码',
  `rarul` varchar(50) NOT NULL COMMENT '村组',
  `bname` varchar(50) NOT NULL COMMENT '姓名',
  `btel` varchar(50) NOT NULL COMMENT '联系电话',
  `varieties` varchar(50) NOT NULL COMMENT '品种',
  `total` varchar(50) NOT NULL COMMENT '出栏数量（头/只）',
  `address` varchar(50) NOT NULL COMMENT '地理位置',
  `photo` text NOT NULL COMMENT '图片',
  `price` varchar(50) NOT NULL COMMENT '市场价格（元/斤）',
  `grossincome` varchar(50) NOT NULL COMMENT '总收入',
  `costexpenditure` varchar(50) NOT NULL COMMENT '成本支出',
  `netincome` varchar(50) NOT NULL COMMENT '总纯收入',
  `brectime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`breid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='养殖性收入表';
CREATE TABLE IF NOT EXISTS `ims_bc_community__family` (
  `fid` int(10) NOT NULL AUTO_INCREMENT COMMENT '家庭成员ID',
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `hid` int(10) NOT NULL COMMENT '户ID',
  `city` varchar(100) NOT NULL COMMENT '市',
  `county` varchar(100) NOT NULL COMMENT '县',
  `town` varchar(100) NOT NULL COMMENT '镇',
  `village` varchar(100) NOT NULL COMMENT '村',
  `bianma` varchar(100) NOT NULL COMMENT '户编码',
  `mbianma` varchar(100) NOT NULL COMMENT '人编码',
  `fname` varchar(100) NOT NULL COMMENT '姓名',
  `sex` int(1) NOT NULL COMMENT '性别1为男2为女',
  `id_card` varchar(255) NOT NULL COMMENT '身份证',
  `guanxi` varchar(100) NOT NULL COMMENT '与户主关系',
  `nation` varchar(100) NOT NULL COMMENT '民族',
  `education` varchar(20) NOT NULL COMMENT '文化程度',
  `school` varchar(255) NOT NULL COMMENT '在校生状况',
  `healthy` varchar(100) NOT NULL COMMENT '健康状况',
  `skill` varchar(100) NOT NULL COMMENT '技能状态',
  `workers` varchar(100) NOT NULL COMMENT '务工状况',
  `workerstime` varchar(100) NOT NULL COMMENT '务工时间',
  `medicalinsurance` int(1) NOT NULL COMMENT '是否参加大病医疗1为是2为否',
  `tpattr` varchar(100) NOT NULL COMMENT '脱贫属性',
  `pkhattr` int(1) NOT NULL COMMENT '贫困户属性1为一般户2为低保户3为低保贫困户',
  `reason` int(1) NOT NULL COMMENT '主要致贫原因1因灾2因病3因残4因学5缺技术6缺水7缺劳力8自身发展不足9其他',
  `wfh` int(1) NOT NULL COMMENT '危房户1为是2为否',
  `ysaq` int(1) NOT NULL COMMENT '饮水安全1为是2为否',
  `yskn` int(1) NOT NULL COMMENT '饮水困难1为是2为否',
  `income` varchar(20) NOT NULL COMMENT '人均纯收入',
  `tel` varchar(100) NOT NULL COMMENT '电话',
  `domicile` varchar(255) NOT NULL COMMENT '户籍派出所',
  `residence` varchar(255) NOT NULL COMMENT '住址',
  `political` varchar(20) NOT NULL COMMENT '政治面貌',
  `marriage` varchar(100) NOT NULL COMMENT '婚姻状况',
  `flow` varchar(100) NOT NULL COMMENT '流动状况',
  `home` varchar(100) NOT NULL COMMENT '居家状况',
  `identity` varchar(100) NOT NULL COMMENT '身份状况',
  `birth` varchar(100) NOT NULL COMMENT '生育状况',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `factime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='家庭成员表';
CREATE TABLE IF NOT EXISTS `ims_bc_community__hus` (
  `hid` int(10) NOT NULL AUTO_INCREMENT COMMENT '户ID',
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `mid` int(10) NOT NULL COMMENT '户主的用户ID',
  `bianma` varchar(255) NOT NULL COMMENT '户编码',
  `hu_no` varchar(255) NOT NULL COMMENT '户口编码',
  `fang_no` varchar(255) NOT NULL COMMENT '房屋编号',
  `huzhu` varchar(255) NOT NULL COMMENT '户主姓名',
  `phone` varchar(255) NOT NULL COMMENT '户主电话',
  `data` text NOT NULL COMMENT '数据',
  `husctime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`hid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='户表';
CREATE TABLE IF NOT EXISTS `ims_bc_community__pinkuns` (
  `pid` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `hid` int(10) NOT NULL COMMENT '户ID',
  `bianma` varchar(255) NOT NULL COMMENT '编码',
  `photo` text NOT NULL COMMENT '照片',
  `issuingauthority` varchar(255) NOT NULL COMMENT '发证机关',
  `cardname` varchar(50) NOT NULL COMMENT '持卡人姓名',
  `address` varchar(255) NOT NULL COMMENT '所在地址',
  `standard` int(1) NOT NULL COMMENT '识别标准',
  `attribute` int(1) NOT NULL COMMENT '贫困户属性',
  `degree` int(1) NOT NULL COMMENT '贫困程度',
  `starttime` varchar(50) NOT NULL COMMENT '发证日期',
  `pname` varchar(50) NOT NULL COMMENT '姓名',
  `sex` varchar(10) NOT NULL COMMENT '性别',
  `idcard` varchar(50) NOT NULL COMMENT '身份证号',
  `yktcard` varchar(50) NOT NULL COMMENT '一卡通号',
  `zrk` varchar(50) NOT NULL COMMENT '总人口',
  `ldl` varchar(50) NOT NULL COMMENT '劳动力',
  `gdmj` varchar(50) NOT NULL COMMENT '耕地面积',
  `tgmj` varchar(50) NOT NULL COMMENT '退耕面积',
  `ggmj` varchar(50) NOT NULL COMMENT '灌溉面积',
  `fueltype` varchar(50) NOT NULL COMMENT '燃料类型',
  `wather` varchar(50) NOT NULL COMMENT '饮水情况',
  `broadcast` varchar(50) NOT NULL COMMENT '是否通广播电视',
  `house` varchar(100) NOT NULL COMMENT '住房类型与面积',
  `reason` varchar(100) NOT NULL COMMENT '贫困原因1因灾2因病3因残4因学5缺技术6缺水7缺劳力8自身发展不足9其他',
  `pctime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='贫困户信息表';
CREATE TABLE IF NOT EXISTS `ims_bc_community__plant` (
  `plaid` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `hid` int(10) NOT NULL COMMENT '户ID',
  `bianma` varchar(50) NOT NULL COMMENT '户编码',
  `rarul` varchar(50) NOT NULL COMMENT '村组',
  `pname` varchar(50) NOT NULL COMMENT '姓名',
  `ptel` varchar(50) NOT NULL COMMENT '联系电话',
  `management` text NOT NULL COMMENT '家庭经营性收入',
  `varieties` varchar(50) NOT NULL COMMENT '品种',
  `area` varchar(50) NOT NULL COMMENT '播种面积',
  `address` varchar(50) NOT NULL COMMENT '地理位置',
  `photo` text NOT NULL COMMENT '图片',
  `yield` varchar(50) NOT NULL COMMENT '总产量',
  `price` varchar(50) NOT NULL COMMENT '市场价格（元/斤）',
  `grossincome` varchar(50) NOT NULL COMMENT '总收入',
  `costexpenditure` varchar(50) NOT NULL COMMENT '成本支出',
  `netincome` varchar(50) NOT NULL COMMENT '总纯收入',
  `plactime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`plaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='种植性收入表';
CREATE TABLE IF NOT EXISTS `ims_bc_community__transfer` (
  `traid` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `hid` int(10) NOT NULL COMMENT '户ID',
  `bianma` varchar(50) NOT NULL COMMENT '户编码',
  `rarul` varchar(50) NOT NULL COMMENT '村组',
  `pname` varchar(50) NOT NULL COMMENT '姓名',
  `ptel` varchar(50) NOT NULL COMMENT '联系电话',
  `transfer` varchar(50) NOT NULL COMMENT '转移性收入',
  `grossincome` varchar(50) NOT NULL COMMENT '总收入',
  `farmland` varchar(50) NOT NULL COMMENT '退耕还林',
  `grassland` varchar(50) NOT NULL COMMENT '草原奖补',
  `commonweal` varchar(50) NOT NULL COMMENT '公益林补助',
  `farmer` varchar(50) NOT NULL COMMENT '农资补贴',
  `seed` varchar(50) NOT NULL COMMENT '良种补贴',
  `allowances` varchar(50) NOT NULL COMMENT '农村低保',
  `birth` varchar(50) NOT NULL COMMENT '计生奖补',
  `poverty` varchar(50) NOT NULL COMMENT '扶贫资金',
  `insurance` varchar(50) NOT NULL COMMENT '保险理赔',
  `pension` varchar(50) NOT NULL COMMENT '养老金',
  `advancedage` varchar(50) NOT NULL COMMENT '高龄津贴',
  `disability` varchar(50) NOT NULL COMMENT '残疾津贴',
  `sociology` varchar(50) NOT NULL COMMENT '社会帮扶',
  `other` varchar(50) NOT NULL COMMENT '其他',
  `tractime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`traid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='转移性收入表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_adv` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `img` text COMMENT '广告图片地址',
  `url` text COMMENT '广告链接',
  `title` varchar(255) DEFAULT NULL COMMENT '广告标题',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='广告表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_authority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `authortitle` varchar(50) DEFAULT NULL COMMENT '权限名称',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新增帖子发布权限表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_base` (
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
  `ewm` text NOT NULL COMMENT '二维码',
  `createtime` int(10) NOT NULL,
  `zdyurl` text NOT NULL COMMENT '自定义导航链接',
  `cmslogo1` text NOT NULL COMMENT '后台登录LOGO1',
  `cmslogo2` text NOT NULL COMMENT '后台左上角LOGO2',
  `tianqi` text NOT NULL COMMENT '天气代码',
  `tianqibg` varchar(20) NOT NULL COMMENT '天气代码背景色',
  `zdymenu4` text NOT NULL COMMENT '底部第四个自定义底部导航名称',
  `zdyurl4` text NOT NULL COMMENT '底部第四个自定义导航链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='基础设置';
CREATE TABLE IF NOT EXISTS `ims_bc_community_comment` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '所属公众号',
  `newsid` int(10) NOT NULL COMMENT '所属帖子ID',
  `mid` int(10) NOT NULL COMMENT '发布会员id',
  `comment` varchar(255) NOT NULL COMMENT '评论内容',
  `cctime` int(10) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_community` (
  `coid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `coname` varchar(255) DEFAULT NULL COMMENT '小区名称',
  `cotime` int(11) NOT NULL COMMENT '创建时间',
  `cocontant` varchar(50) DEFAULT NULL COMMENT '小区联系人',
  PRIMARY KEY (`coid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='小区表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_courselesson` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `townid` int(11) DEFAULT NULL COMMENT '村镇ID',
  `userid` int(10) NOT NULL COMMENT '发布人ID',
  `typeid` int(10) NOT NULL COMMENT '课程分类id',
  `title` varchar(100) NOT NULL COMMENT '课程标题',
  `comment` text NOT NULL COMMENT '课程介绍',
  `cover` text NOT NULL COMMENT '课程封面图片',
  `clicks` int(10) NOT NULL COMMENT '点击量',
  `status` tinyint(1) NOT NULL COMMENT '审核状态1已审核2未审核',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  `menpai` int(11) NOT NULL COMMENT '村ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='种养技术课程表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_coursesection` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='种养技术课时表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_coursetype` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `pid` int(10) NOT NULL COMMENT '分类父ID',
  `title` varchar(100) NOT NULL COMMENT '分类名称',
  `cover` text NOT NULL COMMENT '分类图标',
  `paixu` int(10) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态0显示1隐藏',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='种养技术分类';
CREATE TABLE IF NOT EXISTS `ims_bc_community_gmanage` (
  `gmid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `openid` varchar(100) NOT NULL COMMENT '会员OPENID',
  `gmname` varchar(255) DEFAULT NULL COMMENT '管理员用户名',
  `gmpassword` varchar(255) DEFAULT NULL COMMENT '管理员用户密码',
  `gmctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`gmid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信群管理员';
CREATE TABLE IF NOT EXISTS `ims_bc_community_group` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `gname` varchar(255) DEFAULT NULL COMMENT '群名称',
  `gstatus` int(1) DEFAULT NULL COMMENT '群状态：0为正常，1为禁用',
  `gmember` text COMMENT '群成员',
  `gctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信群';
CREATE TABLE IF NOT EXISTS `ims_bc_community_guanzhu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `townid` int(11) DEFAULT NULL COMMENT '村镇ID',
  `mid` int(11) DEFAULT NULL COMMENT '用户ID',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='bc_community_guanzhu';
CREATE TABLE IF NOT EXISTS `ims_bc_community_help` (
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
  `cover` text COMMENT '封面图片',
  `photo` text COMMENT '相册',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `menpai` int(11) NOT NULL COMMENT '村ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='bc_community_help';
CREATE TABLE IF NOT EXISTS `ims_bc_community_information` (
  `inid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `realname` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `identitycard` varchar(50) DEFAULT NULL COMMENT '身份证',
  `inctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`inid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='居民信息库表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_jurisdiction` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `lev` tinyint(1) DEFAULT NULL COMMENT '级别0是市1是区县2是镇3是村',
  `pid` int(10) NOT NULL COMMENT '父级ID',
  `uname` varchar(50) NOT NULL COMMENT '用户名',
  `upsd` varchar(150) NOT NULL COMMENT '用户密码',
  `townid` int(10) NOT NULL COMMENT '村镇ID',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理权限表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_address` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `mid` int(10) NOT NULL COMMENT '用户ID',
  `contacts` varchar(50) NOT NULL COMMENT '联系人',
  `mobile` varchar(50) NOT NULL COMMENT '联系电话',
  `city` varchar(150) NOT NULL COMMENT '地区',
  `address` varchar(150) NOT NULL COMMENT '联系地址',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='收货地址表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `pid` int(10) NOT NULL COMMENT '分类ID',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章详情';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_arttype` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `pid` int(10) NOT NULL COMMENT '分类父ID',
  `cicon` text NOT NULL COMMENT '分类图标',
  `ctitle` varchar(50) NOT NULL COMMENT '标题',
  `status` tinyint(1) NOT NULL COMMENT '状态1显示2不显示',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  `danyuan` int(11) NOT NULL COMMENT '镇ID',
  `menpai` int(11) NOT NULL COMMENT '村ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章分类';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_banner` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `simg` text NOT NULL COMMENT '图片地址',
  `surl` text NOT NULL COMMENT '链接',
  `stitle` varchar(255) NOT NULL COMMENT '标题',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  `danyuan` int(11) NOT NULL COMMENT '镇ID',
  `menpai` int(11) NOT NULL COMMENT '村ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商城banner';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_base` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `shopname` varchar(50) NOT NULL COMMENT '商城名称',
  `content` text NOT NULL COMMENT '商城入驻说明',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  `danyuan` int(11) NOT NULL COMMENT '镇ID',
  `menpai` int(11) NOT NULL COMMENT '村ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商城基础设置表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_bespeak` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='大客户预约表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `pid` int(10) NOT NULL COMMENT '分类父ID',
  `cicon` text NOT NULL COMMENT '分类图标',
  `ctitle` varchar(50) NOT NULL COMMENT '标题',
  `status` tinyint(1) NOT NULL COMMENT '状态1显示2不显示',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  `danyuan` int(11) NOT NULL COMMENT '镇ID',
  `menpai` int(11) NOT NULL COMMENT '村ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品分类';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_goods` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `mid` int(11) NOT NULL COMMENT '用户id',
  `sid` int(11) NOT NULL COMMENT '商家id',
  `pptid` int(10) NOT NULL COMMENT '产品一级分类ID',
  `ptid` int(10) NOT NULL COMMENT '产品二级分类ID',
  `is_hot` int(1) NOT NULL COMMENT '是否推荐，0表示不推荐，1表示推荐',
  `pimg` text NOT NULL COMMENT '产品封面图片',
  `photo` text NOT NULL COMMENT '产品相册',
  `ptitle` varchar(255) NOT NULL COMMENT '产品标题',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '价格',
  `punit` varchar(50) NOT NULL COMMENT '单位/规格',
  `pqty` int(10) NOT NULL COMMENT '产品总数量',
  `pyqty` int(10) NOT NULL COMMENT '产品已售数量',
  `pcontent` text NOT NULL COMMENT '产品详情',
  `pstatus` int(1) NOT NULL COMMENT '产品状态，0表示待审核，1表示正常，2表示下架',
  `pstrattime` varchar(50) NOT NULL,
  `pctime` int(10) NOT NULL,
  `danyuan` int(11) NOT NULL COMMENT '发布商品的用户所属镇ID',
  `menpai` int(11) NOT NULL COMMENT '发布商品的用户所属村ID',
  `baseyf` decimal(10,2) DEFAULT '0.00' COMMENT '单个规格的运费',
  `addyf` decimal(10,2) DEFAULT '0.00' COMMENT '超出基础运费按规格数量累计',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `mid` int(11) NOT NULL COMMENT '用户id',
  `sid` int(11) NOT NULL COMMENT '商户id',
  `townid` int(11) NOT NULL COMMENT '乡镇id',
  `villageid` int(11) NOT NULL COMMENT '村庄id',
  `type` tinyint(1) NOT NULL COMMENT '日志类型1商品编辑2订单状态变更3订单金额修改',
  `content` varchar(255) NOT NULL COMMENT '日志内容',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户操作日志表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_messages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商城消息表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_nav` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `nicon` text NOT NULL COMMENT '分类图标',
  `nurl` text NOT NULL COMMENT '链接',
  `ntitle` varchar(50) NOT NULL COMMENT '标题',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  `danyuan` int(11) NOT NULL COMMENT '镇ID',
  `menpai` int(11) NOT NULL COMMENT '村ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商城导航';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '产品订单ID',
  `pocode` varchar(30) NOT NULL COMMENT '产品订单编号',
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `pcover` text NOT NULL COMMENT '产品图片快照',
  `poinfo` text NOT NULL COMMENT '产品订单快照',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品订单表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_seller` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商家表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_mall_wallet` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='钱包记录表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_member` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL COMMENT '所属公众号',
  `openid` varchar(100) NOT NULL COMMENT '会员OPENID',
  `idcard` bigint(18) NOT NULL COMMENT '身份证号码',
  `grade` int(11) NOT NULL COMMENT '会员等级 1代表普通会员 2代表认证居民 3社区书记 4代表管理员',
  `userip` varchar(100) NOT NULL COMMENT '会员IP',
  `gag` int(1) NOT NULL COMMENT '是否禁言：0为正常，1为禁言',
  `blacklist` int(1) NOT NULL COMMENT '是否拉黑：0为正常，1为拉黑',
  `nickname` varchar(100) NOT NULL COMMENT '会员昵称',
  `realname` varchar(50) NOT NULL COMMENT '会员真实姓名',
  `tel` bigint(14) NOT NULL COMMENT '会员电话',
  `coid` int(11) NOT NULL COMMENT '小区ID',
  `dong` int(11) NOT NULL COMMENT '栋数',
  `danyuan` int(11) NOT NULL COMMENT '单元',
  `menpai` int(11) NOT NULL COMMENT '门牌',
  `address` varchar(255) NOT NULL COMMENT '会员地址',
  `avatar` text NOT NULL COMMENT '会员头像',
  `integral` varchar(20) NOT NULL COMMENT '会员积分',
  `country` varchar(10) NOT NULL COMMENT '国家',
  `province` varchar(10) NOT NULL COMMENT '省份',
  `city` varchar(10) NOT NULL COMMENT '县区',
  `createtime` int(10) NOT NULL,
  `isrz` tinyint(1) NOT NULL COMMENT '是否认证1是0否',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bc_community_menu` (
  `meid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `mimg` text COMMENT '分类图片地址',
  `jump` int(1) DEFAULT NULL COMMENT '是否跳转超链接：0为正常，1为跳转',
  `murl` text COMMENT '分类转向链接',
  `mtitle` varchar(255) DEFAULT NULL COMMENT '分类标题',
  `mtype` int(1) DEFAULT NULL COMMENT '分类的类型，导航是1，滑动导航是2',
  `mstatus` int(1) DEFAULT NULL COMMENT '分类的发布状态， 1代表普通会员 2代表认证居民 3社区书记 4管理员',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `authorid` varchar(100) NOT NULL COMMENT '发布权限ID集合',
  `townid` int(10) NOT NULL COMMENT '村镇ID',
  PRIMARY KEY (`meid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='分类表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_messages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `mimg` text COMMENT '分类图片地址',
  `jump` int(1) DEFAULT NULL COMMENT '是否跳转超链接：0为正常，1为跳转',
  `murl` text COMMENT '导航转向链接',
  `mtitle` varchar(255) DEFAULT NULL COMMENT '标题',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='bc_community_nav';
CREATE TABLE IF NOT EXISTS `ims_bc_community_news` (
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
  `coid` int(11) NOT NULL COMMENT '市ID',
  `danyuan` int(11) NOT NULL COMMENT '镇ID',
  `menpai` int(11) NOT NULL COMMENT '村ID',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='帖子表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_organlev` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `townid` int(11) DEFAULT NULL COMMENT '村镇ID',
  `organname` varchar(50) DEFAULT NULL COMMENT '乡村组织级别名称',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  `villageid` int(11) NOT NULL COMMENT '村庄ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='乡村组织级别表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_organuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `townid` int(11) DEFAULT NULL COMMENT '村镇ID',
  `organid` int(11) DEFAULT NULL COMMENT '乡村组织级别ID',
  `username` varchar(50) DEFAULT NULL COMMENT '成员姓名',
  `cover` text COMMENT '头像',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别1男2女',
  `tel` varchar(40) DEFAULT NULL COMMENT '联系电话',
  `zhiwei` varchar(100) DEFAULT NULL COMMENT '职位',
  `company` varchar(100) DEFAULT NULL COMMENT '工作单位',
  `comment` text COMMENT '简介',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='乡村组织成员表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_proposal` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `mid` int(11) DEFAULT NULL COMMENT '用户ID',
  `ptype` int(11) DEFAULT NULL COMMENT '建议所属类型id',
  `ptext` varchar(255) DEFAULT NULL COMMENT '建议文字',
  `paddress` varchar(255) DEFAULT NULL COMMENT '建议人详细地址',
  `pimg` text COMMENT '建议图片',
  `pctime` int(11) NOT NULL COMMENT '创建时间',
  `phandle` text NOT NULL COMMENT '处理详情',
  `phandleper` varchar(50) NOT NULL COMMENT '处理人',
  `phandletime` int(11) NOT NULL COMMENT '处理时间',
  `pstatus` int(1) NOT NULL COMMENT '处理状态',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='建议表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_renzheng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `townid` int(11) DEFAULT NULL COMMENT '村镇ID',
  `mid` int(11) DEFAULT NULL COMMENT '用户ID',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='bc_community_renzheng';
CREATE TABLE IF NOT EXISTS `ims_bc_community_report` (
  `reid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `mid` int(11) DEFAULT NULL COMMENT '用户ID',
  `newsid` int(11) DEFAULT NULL COMMENT '活动帖子ID',
  `username` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `telephone` bigint(11) DEFAULT NULL COMMENT '联系电话',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`reid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='志愿服务报名表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_thumbs` (
  `thid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `newsid` int(11) DEFAULT NULL COMMENT '帖子id',
  `mid` int(11) DEFAULT NULL COMMENT '用户ID',
  `thstatus` int(11) NOT NULL COMMENT '点赞状态，1点赞 0取消赞',
  `thctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`thid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='点赞表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_town` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号ID',
  `lev` tinyint(1) DEFAULT NULL COMMENT '级别0是市1是区县2是镇3是村',
  `pid` int(10) NOT NULL COMMENT '父级ID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `cover` text NOT NULL COMMENT '封面图片',
  `photo` text NOT NULL COMMENT '相册',
  `remark` varchar(250) NOT NULL COMMENT '简介',
  `comment` text NOT NULL COMMENT '详情',
  `status` tinyint(1) NOT NULL,
  `paixu` int(10) NOT NULL COMMENT '排序',
  `latlong` varchar(40) NOT NULL COMMENT '经纬度',
  `contacts` varchar(40) NOT NULL COMMENT '联系人',
  `tel` varchar(40) NOT NULL COMMENT '联系电话',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  `rd` int(10) NOT NULL COMMENT '发帖总数',
  `color` varchar(40) NOT NULL COMMENT '按钮颜色',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='村镇管理表';
CREATE TABLE IF NOT EXISTS `ims_bc_community_type` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `tname` varchar(255) DEFAULT NULL COMMENT '问题类型名称',
  `tstatus` int(1) DEFAULT NULL COMMENT '问题类型状态：0为正常，1为禁用',
  `tctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='问题类型表';
";
pdo_run($sql);
if(!pdo_fieldexists("bc_community__breed", "breid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `breid` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community__breed", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community__breed", "hid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `hid` int(10) NOT NULL COMMENT '户ID';");
}
if(!pdo_fieldexists("bc_community__breed", "bianma")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `bianma` varchar(50) NOT NULL COMMENT '户编码';");
}
if(!pdo_fieldexists("bc_community__breed", "rarul")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `rarul` varchar(50) NOT NULL COMMENT '村组';");
}
if(!pdo_fieldexists("bc_community__breed", "bname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `bname` varchar(50) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("bc_community__breed", "btel")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `btel` varchar(50) NOT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists("bc_community__breed", "varieties")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `varieties` varchar(50) NOT NULL COMMENT '品种';");
}
if(!pdo_fieldexists("bc_community__breed", "total")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `total` varchar(50) NOT NULL COMMENT '出栏数量（头/只）';");
}
if(!pdo_fieldexists("bc_community__breed", "address")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `address` varchar(50) NOT NULL COMMENT '地理位置';");
}
if(!pdo_fieldexists("bc_community__breed", "photo")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `photo` text NOT NULL COMMENT '图片';");
}
if(!pdo_fieldexists("bc_community__breed", "price")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `price` varchar(50) NOT NULL COMMENT '市场价格（元/斤）';");
}
if(!pdo_fieldexists("bc_community__breed", "grossincome")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `grossincome` varchar(50) NOT NULL COMMENT '总收入';");
}
if(!pdo_fieldexists("bc_community__breed", "costexpenditure")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `costexpenditure` varchar(50) NOT NULL COMMENT '成本支出';");
}
if(!pdo_fieldexists("bc_community__breed", "netincome")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `netincome` varchar(50) NOT NULL COMMENT '总纯收入';");
}
if(!pdo_fieldexists("bc_community__breed", "brectime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__breed")." ADD   `brectime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community__family", "fid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `fid` int(10) NOT NULL AUTO_INCREMENT COMMENT '家庭成员ID';");
}
if(!pdo_fieldexists("bc_community__family", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community__family", "hid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `hid` int(10) NOT NULL COMMENT '户ID';");
}
if(!pdo_fieldexists("bc_community__family", "city")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `city` varchar(100) NOT NULL COMMENT '市';");
}
if(!pdo_fieldexists("bc_community__family", "county")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `county` varchar(100) NOT NULL COMMENT '县';");
}
if(!pdo_fieldexists("bc_community__family", "town")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `town` varchar(100) NOT NULL COMMENT '镇';");
}
if(!pdo_fieldexists("bc_community__family", "village")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `village` varchar(100) NOT NULL COMMENT '村';");
}
if(!pdo_fieldexists("bc_community__family", "bianma")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `bianma` varchar(100) NOT NULL COMMENT '户编码';");
}
if(!pdo_fieldexists("bc_community__family", "mbianma")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `mbianma` varchar(100) NOT NULL COMMENT '人编码';");
}
if(!pdo_fieldexists("bc_community__family", "fname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `fname` varchar(100) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("bc_community__family", "sex")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `sex` int(1) NOT NULL COMMENT '性别1为男2为女';");
}
if(!pdo_fieldexists("bc_community__family", "id_card")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `id_card` varchar(255) NOT NULL COMMENT '身份证';");
}
if(!pdo_fieldexists("bc_community__family", "guanxi")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `guanxi` varchar(100) NOT NULL COMMENT '与户主关系';");
}
if(!pdo_fieldexists("bc_community__family", "nation")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `nation` varchar(100) NOT NULL COMMENT '民族';");
}
if(!pdo_fieldexists("bc_community__family", "education")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `education` varchar(20) NOT NULL COMMENT '文化程度';");
}
if(!pdo_fieldexists("bc_community__family", "school")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `school` varchar(255) NOT NULL COMMENT '在校生状况';");
}
if(!pdo_fieldexists("bc_community__family", "healthy")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `healthy` varchar(100) NOT NULL COMMENT '健康状况';");
}
if(!pdo_fieldexists("bc_community__family", "skill")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `skill` varchar(100) NOT NULL COMMENT '技能状态';");
}
if(!pdo_fieldexists("bc_community__family", "workers")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `workers` varchar(100) NOT NULL COMMENT '务工状况';");
}
if(!pdo_fieldexists("bc_community__family", "workerstime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `workerstime` varchar(100) NOT NULL COMMENT '务工时间';");
}
if(!pdo_fieldexists("bc_community__family", "medicalinsurance")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `medicalinsurance` int(1) NOT NULL COMMENT '是否参加大病医疗1为是2为否';");
}
if(!pdo_fieldexists("bc_community__family", "tpattr")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `tpattr` varchar(100) NOT NULL COMMENT '脱贫属性';");
}
if(!pdo_fieldexists("bc_community__family", "pkhattr")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `pkhattr` int(1) NOT NULL COMMENT '贫困户属性1为一般户2为低保户3为低保贫困户';");
}
if(!pdo_fieldexists("bc_community__family", "reason")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `reason` int(1) NOT NULL COMMENT '主要致贫原因1因灾2因病3因残4因学5缺技术6缺水7缺劳力8自身发展不足9其他';");
}
if(!pdo_fieldexists("bc_community__family", "wfh")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `wfh` int(1) NOT NULL COMMENT '危房户1为是2为否';");
}
if(!pdo_fieldexists("bc_community__family", "ysaq")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `ysaq` int(1) NOT NULL COMMENT '饮水安全1为是2为否';");
}
if(!pdo_fieldexists("bc_community__family", "yskn")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `yskn` int(1) NOT NULL COMMENT '饮水困难1为是2为否';");
}
if(!pdo_fieldexists("bc_community__family", "income")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `income` varchar(20) NOT NULL COMMENT '人均纯收入';");
}
if(!pdo_fieldexists("bc_community__family", "tel")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `tel` varchar(100) NOT NULL COMMENT '电话';");
}
if(!pdo_fieldexists("bc_community__family", "domicile")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `domicile` varchar(255) NOT NULL COMMENT '户籍派出所';");
}
if(!pdo_fieldexists("bc_community__family", "residence")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `residence` varchar(255) NOT NULL COMMENT '住址';");
}
if(!pdo_fieldexists("bc_community__family", "political")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `political` varchar(20) NOT NULL COMMENT '政治面貌';");
}
if(!pdo_fieldexists("bc_community__family", "marriage")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `marriage` varchar(100) NOT NULL COMMENT '婚姻状况';");
}
if(!pdo_fieldexists("bc_community__family", "flow")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `flow` varchar(100) NOT NULL COMMENT '流动状况';");
}
if(!pdo_fieldexists("bc_community__family", "home")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `home` varchar(100) NOT NULL COMMENT '居家状况';");
}
if(!pdo_fieldexists("bc_community__family", "identity")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `identity` varchar(100) NOT NULL COMMENT '身份状况';");
}
if(!pdo_fieldexists("bc_community__family", "birth")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `birth` varchar(100) NOT NULL COMMENT '生育状况';");
}
if(!pdo_fieldexists("bc_community__family", "remark")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `remark` varchar(255) NOT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("bc_community__family", "factime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__family")." ADD   `factime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community__hus", "hid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__hus")." ADD   `hid` int(10) NOT NULL AUTO_INCREMENT COMMENT '户ID';");
}
if(!pdo_fieldexists("bc_community__hus", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__hus")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community__hus", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__hus")." ADD   `mid` int(10) NOT NULL COMMENT '户主的用户ID';");
}
if(!pdo_fieldexists("bc_community__hus", "bianma")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__hus")." ADD   `bianma` varchar(255) NOT NULL COMMENT '户编码';");
}
if(!pdo_fieldexists("bc_community__hus", "hu_no")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__hus")." ADD   `hu_no` varchar(255) NOT NULL COMMENT '户口编码';");
}
if(!pdo_fieldexists("bc_community__hus", "fang_no")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__hus")." ADD   `fang_no` varchar(255) NOT NULL COMMENT '房屋编号';");
}
if(!pdo_fieldexists("bc_community__hus", "huzhu")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__hus")." ADD   `huzhu` varchar(255) NOT NULL COMMENT '户主姓名';");
}
if(!pdo_fieldexists("bc_community__hus", "phone")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__hus")." ADD   `phone` varchar(255) NOT NULL COMMENT '户主电话';");
}
if(!pdo_fieldexists("bc_community__hus", "data")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__hus")." ADD   `data` text NOT NULL COMMENT '数据';");
}
if(!pdo_fieldexists("bc_community__hus", "husctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__hus")." ADD   `husctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "pid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `pid` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community__pinkuns", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "hid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `hid` int(10) NOT NULL COMMENT '户ID';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "bianma")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `bianma` varchar(255) NOT NULL COMMENT '编码';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "photo")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `photo` text NOT NULL COMMENT '照片';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "issuingauthority")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `issuingauthority` varchar(255) NOT NULL COMMENT '发证机关';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "cardname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `cardname` varchar(50) NOT NULL COMMENT '持卡人姓名';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "address")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `address` varchar(255) NOT NULL COMMENT '所在地址';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "standard")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `standard` int(1) NOT NULL COMMENT '识别标准';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "attribute")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `attribute` int(1) NOT NULL COMMENT '贫困户属性';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "degree")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `degree` int(1) NOT NULL COMMENT '贫困程度';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "starttime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `starttime` varchar(50) NOT NULL COMMENT '发证日期';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "pname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `pname` varchar(50) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "sex")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `sex` varchar(10) NOT NULL COMMENT '性别';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "idcard")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `idcard` varchar(50) NOT NULL COMMENT '身份证号';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "yktcard")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `yktcard` varchar(50) NOT NULL COMMENT '一卡通号';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "zrk")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `zrk` varchar(50) NOT NULL COMMENT '总人口';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "ldl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `ldl` varchar(50) NOT NULL COMMENT '劳动力';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "gdmj")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `gdmj` varchar(50) NOT NULL COMMENT '耕地面积';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "tgmj")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `tgmj` varchar(50) NOT NULL COMMENT '退耕面积';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "ggmj")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `ggmj` varchar(50) NOT NULL COMMENT '灌溉面积';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "fueltype")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `fueltype` varchar(50) NOT NULL COMMENT '燃料类型';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "wather")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `wather` varchar(50) NOT NULL COMMENT '饮水情况';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "broadcast")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `broadcast` varchar(50) NOT NULL COMMENT '是否通广播电视';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "house")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `house` varchar(100) NOT NULL COMMENT '住房类型与面积';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "reason")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `reason` varchar(100) NOT NULL COMMENT '贫困原因1因灾2因病3因残4因学5缺技术6缺水7缺劳力8自身发展不足9其他';");
}
if(!pdo_fieldexists("bc_community__pinkuns", "pctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__pinkuns")." ADD   `pctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community__plant", "plaid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `plaid` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community__plant", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community__plant", "hid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `hid` int(10) NOT NULL COMMENT '户ID';");
}
if(!pdo_fieldexists("bc_community__plant", "bianma")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `bianma` varchar(50) NOT NULL COMMENT '户编码';");
}
if(!pdo_fieldexists("bc_community__plant", "rarul")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `rarul` varchar(50) NOT NULL COMMENT '村组';");
}
if(!pdo_fieldexists("bc_community__plant", "pname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `pname` varchar(50) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("bc_community__plant", "ptel")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `ptel` varchar(50) NOT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists("bc_community__plant", "management")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `management` text NOT NULL COMMENT '家庭经营性收入';");
}
if(!pdo_fieldexists("bc_community__plant", "varieties")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `varieties` varchar(50) NOT NULL COMMENT '品种';");
}
if(!pdo_fieldexists("bc_community__plant", "area")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `area` varchar(50) NOT NULL COMMENT '播种面积';");
}
if(!pdo_fieldexists("bc_community__plant", "address")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `address` varchar(50) NOT NULL COMMENT '地理位置';");
}
if(!pdo_fieldexists("bc_community__plant", "photo")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `photo` text NOT NULL COMMENT '图片';");
}
if(!pdo_fieldexists("bc_community__plant", "yield")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `yield` varchar(50) NOT NULL COMMENT '总产量';");
}
if(!pdo_fieldexists("bc_community__plant", "price")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `price` varchar(50) NOT NULL COMMENT '市场价格（元/斤）';");
}
if(!pdo_fieldexists("bc_community__plant", "grossincome")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `grossincome` varchar(50) NOT NULL COMMENT '总收入';");
}
if(!pdo_fieldexists("bc_community__plant", "costexpenditure")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `costexpenditure` varchar(50) NOT NULL COMMENT '成本支出';");
}
if(!pdo_fieldexists("bc_community__plant", "netincome")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `netincome` varchar(50) NOT NULL COMMENT '总纯收入';");
}
if(!pdo_fieldexists("bc_community__plant", "plactime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__plant")." ADD   `plactime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community__transfer", "traid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `traid` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community__transfer", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community__transfer", "hid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `hid` int(10) NOT NULL COMMENT '户ID';");
}
if(!pdo_fieldexists("bc_community__transfer", "bianma")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `bianma` varchar(50) NOT NULL COMMENT '户编码';");
}
if(!pdo_fieldexists("bc_community__transfer", "rarul")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `rarul` varchar(50) NOT NULL COMMENT '村组';");
}
if(!pdo_fieldexists("bc_community__transfer", "pname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `pname` varchar(50) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("bc_community__transfer", "ptel")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `ptel` varchar(50) NOT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists("bc_community__transfer", "transfer")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `transfer` varchar(50) NOT NULL COMMENT '转移性收入';");
}
if(!pdo_fieldexists("bc_community__transfer", "grossincome")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `grossincome` varchar(50) NOT NULL COMMENT '总收入';");
}
if(!pdo_fieldexists("bc_community__transfer", "farmland")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `farmland` varchar(50) NOT NULL COMMENT '退耕还林';");
}
if(!pdo_fieldexists("bc_community__transfer", "grassland")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `grassland` varchar(50) NOT NULL COMMENT '草原奖补';");
}
if(!pdo_fieldexists("bc_community__transfer", "commonweal")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `commonweal` varchar(50) NOT NULL COMMENT '公益林补助';");
}
if(!pdo_fieldexists("bc_community__transfer", "farmer")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `farmer` varchar(50) NOT NULL COMMENT '农资补贴';");
}
if(!pdo_fieldexists("bc_community__transfer", "seed")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `seed` varchar(50) NOT NULL COMMENT '良种补贴';");
}
if(!pdo_fieldexists("bc_community__transfer", "allowances")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `allowances` varchar(50) NOT NULL COMMENT '农村低保';");
}
if(!pdo_fieldexists("bc_community__transfer", "birth")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `birth` varchar(50) NOT NULL COMMENT '计生奖补';");
}
if(!pdo_fieldexists("bc_community__transfer", "poverty")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `poverty` varchar(50) NOT NULL COMMENT '扶贫资金';");
}
if(!pdo_fieldexists("bc_community__transfer", "insurance")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `insurance` varchar(50) NOT NULL COMMENT '保险理赔';");
}
if(!pdo_fieldexists("bc_community__transfer", "pension")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `pension` varchar(50) NOT NULL COMMENT '养老金';");
}
if(!pdo_fieldexists("bc_community__transfer", "advancedage")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `advancedage` varchar(50) NOT NULL COMMENT '高龄津贴';");
}
if(!pdo_fieldexists("bc_community__transfer", "disability")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `disability` varchar(50) NOT NULL COMMENT '残疾津贴';");
}
if(!pdo_fieldexists("bc_community__transfer", "sociology")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `sociology` varchar(50) NOT NULL COMMENT '社会帮扶';");
}
if(!pdo_fieldexists("bc_community__transfer", "other")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `other` varchar(50) NOT NULL COMMENT '其他';");
}
if(!pdo_fieldexists("bc_community__transfer", "tractime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community__transfer")." ADD   `tractime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_adv", "aid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_adv")." ADD   `aid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_adv", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_adv")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_adv", "img")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_adv")." ADD   `img` text COMMENT '广告图片地址';");
}
if(!pdo_fieldexists("bc_community_adv", "url")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_adv")." ADD   `url` text COMMENT '广告链接';");
}
if(!pdo_fieldexists("bc_community_adv", "title")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_adv")." ADD   `title` varchar(255) DEFAULT NULL COMMENT '广告标题';");
}
if(!pdo_fieldexists("bc_community_adv", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_adv")." ADD   `createtime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_authority", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_authority")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_authority", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_authority")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_authority", "authortitle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_authority")." ADD   `authortitle` varchar(50) DEFAULT NULL COMMENT '权限名称';");
}
if(!pdo_fieldexists("bc_community_authority", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_authority")." ADD   `createtime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_base", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_base", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `weid` int(10) NOT NULL COMMENT '所属公众号';");
}
if(!pdo_fieldexists("bc_community_base", "title")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `title` varchar(50) NOT NULL COMMENT '模块标题';");
}
if(!pdo_fieldexists("bc_community_base", "bg")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `bg` text NOT NULL COMMENT '首页背景';");
}
if(!pdo_fieldexists("bc_community_base", "remark")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `remark` text NOT NULL COMMENT '备注说明之类的';");
}
if(!pdo_fieldexists("bc_community_base", "notice")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `notice` text NOT NULL COMMENT '公告栏通知';");
}
if(!pdo_fieldexists("bc_community_base", "noticeurl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `noticeurl` text NOT NULL COMMENT '通知链接';");
}
if(!pdo_fieldexists("bc_community_base", "zdymenu")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `zdymenu` varchar(50) NOT NULL COMMENT '自定义底部导航名称';");
}
if(!pdo_fieldexists("bc_community_base", "zdymenuid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `zdymenuid` varchar(50) NOT NULL COMMENT '自定义分类ID';");
}
if(!pdo_fieldexists("bc_community_base", "copyright")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `copyright` varchar(255) NOT NULL COMMENT '版权文字';");
}
if(!pdo_fieldexists("bc_community_base", "agreement")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `agreement` varchar(255) NOT NULL COMMENT '协议';");
}
if(!pdo_fieldexists("bc_community_base", "ewm")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `ewm` text NOT NULL COMMENT '二维码';");
}
if(!pdo_fieldexists("bc_community_base", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `createtime` int(10) NOT NULL;");
}
if(!pdo_fieldexists("bc_community_base", "zdyurl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `zdyurl` text NOT NULL COMMENT '自定义导航链接';");
}
if(!pdo_fieldexists("bc_community_base", "cmslogo1")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `cmslogo1` text NOT NULL COMMENT '后台登录LOGO1';");
}
if(!pdo_fieldexists("bc_community_base", "cmslogo2")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `cmslogo2` text NOT NULL COMMENT '后台左上角LOGO2';");
}
if(!pdo_fieldexists("bc_community_base", "tianqi")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `tianqi` text NOT NULL COMMENT '天气代码';");
}
if(!pdo_fieldexists("bc_community_base", "tianqibg")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `tianqibg` varchar(20) NOT NULL COMMENT '天气代码背景色';");
}
if(!pdo_fieldexists("bc_community_base", "zdymenu4")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `zdymenu4` text NOT NULL COMMENT '底部第四个自定义底部导航名称';");
}
if(!pdo_fieldexists("bc_community_base", "zdyurl4")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_base")." ADD   `zdyurl4` text NOT NULL COMMENT '底部第四个自定义导航链接';");
}
if(!pdo_fieldexists("bc_community_comment", "cid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_comment")." ADD   `cid` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_comment", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_comment")." ADD   `weid` int(10) NOT NULL COMMENT '所属公众号';");
}
if(!pdo_fieldexists("bc_community_comment", "newsid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_comment")." ADD   `newsid` int(10) NOT NULL COMMENT '所属帖子ID';");
}
if(!pdo_fieldexists("bc_community_comment", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_comment")." ADD   `mid` int(10) NOT NULL COMMENT '发布会员id';");
}
if(!pdo_fieldexists("bc_community_comment", "comment")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_comment")." ADD   `comment` varchar(255) NOT NULL COMMENT '评论内容';");
}
if(!pdo_fieldexists("bc_community_comment", "cctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_comment")." ADD   `cctime` int(10) NOT NULL;");
}
if(!pdo_fieldexists("bc_community_community", "coid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_community")." ADD   `coid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_community", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_community")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_community", "coname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_community")." ADD   `coname` varchar(255) DEFAULT NULL COMMENT '小区名称';");
}
if(!pdo_fieldexists("bc_community_community", "cotime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_community")." ADD   `cotime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_community", "cocontant")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_community")." ADD   `cocontant` varchar(50) DEFAULT NULL COMMENT '小区联系人';");
}
if(!pdo_fieldexists("bc_community_courselesson", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_courselesson", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_courselesson", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `townid` int(11) DEFAULT NULL COMMENT '村镇ID';");
}
if(!pdo_fieldexists("bc_community_courselesson", "userid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `userid` int(10) NOT NULL COMMENT '发布人ID';");
}
if(!pdo_fieldexists("bc_community_courselesson", "typeid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `typeid` int(10) NOT NULL COMMENT '课程分类id';");
}
if(!pdo_fieldexists("bc_community_courselesson", "title")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `title` varchar(100) NOT NULL COMMENT '课程标题';");
}
if(!pdo_fieldexists("bc_community_courselesson", "comment")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `comment` text NOT NULL COMMENT '课程介绍';");
}
if(!pdo_fieldexists("bc_community_courselesson", "cover")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `cover` text NOT NULL COMMENT '课程封面图片';");
}
if(!pdo_fieldexists("bc_community_courselesson", "clicks")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `clicks` int(10) NOT NULL COMMENT '点击量';");
}
if(!pdo_fieldexists("bc_community_courselesson", "status")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `status` tinyint(1) NOT NULL COMMENT '审核状态1已审核2未审核';");
}
if(!pdo_fieldexists("bc_community_courselesson", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_courselesson", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_courselesson")." ADD   `menpai` int(11) NOT NULL COMMENT '村ID';");
}
if(!pdo_fieldexists("bc_community_coursesection", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_coursesection", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_coursesection", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `townid` int(11) DEFAULT NULL COMMENT '村镇ID';");
}
if(!pdo_fieldexists("bc_community_coursesection", "userid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `userid` int(10) NOT NULL COMMENT '发布人ID';");
}
if(!pdo_fieldexists("bc_community_coursesection", "typeid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `typeid` int(10) NOT NULL COMMENT '课程分类id';");
}
if(!pdo_fieldexists("bc_community_coursesection", "lessonid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `lessonid` int(10) NOT NULL COMMENT '课程id';");
}
if(!pdo_fieldexists("bc_community_coursesection", "title")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `title` varchar(100) NOT NULL COMMENT '课时标题';");
}
if(!pdo_fieldexists("bc_community_coursesection", "videourl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `videourl` text NOT NULL COMMENT '视频链接';");
}
if(!pdo_fieldexists("bc_community_coursesection", "audiourl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `audiourl` text NOT NULL COMMENT '音频链接';");
}
if(!pdo_fieldexists("bc_community_coursesection", "clicks")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `clicks` int(10) NOT NULL COMMENT '点击量';");
}
if(!pdo_fieldexists("bc_community_coursesection", "status")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `status` tinyint(1) NOT NULL COMMENT '审核状态1已审核2未审核';");
}
if(!pdo_fieldexists("bc_community_coursesection", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursesection")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_coursetype", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursetype")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_coursetype", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursetype")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_coursetype", "pid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursetype")." ADD   `pid` int(10) NOT NULL COMMENT '分类父ID';");
}
if(!pdo_fieldexists("bc_community_coursetype", "title")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursetype")." ADD   `title` varchar(100) NOT NULL COMMENT '分类名称';");
}
if(!pdo_fieldexists("bc_community_coursetype", "cover")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursetype")." ADD   `cover` text NOT NULL COMMENT '分类图标';");
}
if(!pdo_fieldexists("bc_community_coursetype", "paixu")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursetype")." ADD   `paixu` int(10) NOT NULL COMMENT '排序';");
}
if(!pdo_fieldexists("bc_community_coursetype", "status")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursetype")." ADD   `status` tinyint(1) NOT NULL COMMENT '状态0显示1隐藏';");
}
if(!pdo_fieldexists("bc_community_coursetype", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_coursetype")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_gmanage", "gmid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_gmanage")." ADD   `gmid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_gmanage", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_gmanage")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_gmanage", "openid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_gmanage")." ADD   `openid` varchar(100) NOT NULL COMMENT '会员OPENID';");
}
if(!pdo_fieldexists("bc_community_gmanage", "gmname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_gmanage")." ADD   `gmname` varchar(255) DEFAULT NULL COMMENT '管理员用户名';");
}
if(!pdo_fieldexists("bc_community_gmanage", "gmpassword")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_gmanage")." ADD   `gmpassword` varchar(255) DEFAULT NULL COMMENT '管理员用户密码';");
}
if(!pdo_fieldexists("bc_community_gmanage", "gmctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_gmanage")." ADD   `gmctime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_group", "gid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_group")." ADD   `gid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_group", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_group")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_group", "gname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_group")." ADD   `gname` varchar(255) DEFAULT NULL COMMENT '群名称';");
}
if(!pdo_fieldexists("bc_community_group", "gstatus")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_group")." ADD   `gstatus` int(1) DEFAULT NULL COMMENT '群状态：0为正常，1为禁用';");
}
if(!pdo_fieldexists("bc_community_group", "gmember")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_group")." ADD   `gmember` text COMMENT '群成员';");
}
if(!pdo_fieldexists("bc_community_group", "gctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_group")." ADD   `gctime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_guanzhu", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_guanzhu")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_guanzhu", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_guanzhu")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_guanzhu", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_guanzhu")." ADD   `townid` int(11) DEFAULT NULL COMMENT '村镇ID';");
}
if(!pdo_fieldexists("bc_community_guanzhu", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_guanzhu")." ADD   `mid` int(11) DEFAULT NULL COMMENT '用户ID';");
}
if(!pdo_fieldexists("bc_community_guanzhu", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_guanzhu")." ADD   `createtime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_help", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_help", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_help", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `townid` int(11) DEFAULT NULL COMMENT '村镇ID';");
}
if(!pdo_fieldexists("bc_community_help", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `mid` int(11) DEFAULT NULL COMMENT '用户ID';");
}
if(!pdo_fieldexists("bc_community_help", "uname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `uname` varchar(40) DEFAULT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("bc_community_help", "sex")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `sex` tinyint(1) DEFAULT NULL COMMENT '性别';");
}
if(!pdo_fieldexists("bc_community_help", "age")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `age` varchar(20) DEFAULT NULL COMMENT '年龄';");
}
if(!pdo_fieldexists("bc_community_help", "tel")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `tel` varchar(30) DEFAULT NULL COMMENT '电话';");
}
if(!pdo_fieldexists("bc_community_help", "xueli")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `xueli` varchar(30) DEFAULT NULL COMMENT '学历';");
}
if(!pdo_fieldexists("bc_community_help", "family")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `family` varchar(30) DEFAULT NULL COMMENT '家庭成员';");
}
if(!pdo_fieldexists("bc_community_help", "stzk")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `stzk` varchar(30) DEFAULT NULL COMMENT '身体状况';");
}
if(!pdo_fieldexists("bc_community_help", "jtsr")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `jtsr` tinyint(1) DEFAULT NULL COMMENT '家庭收入1是0-5000元2是5000-10000元3是10000至3万元4是3万元至10万元5是10万元以上6是其它';");
}
if(!pdo_fieldexists("bc_community_help", "jtzk")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `jtzk` varchar(100) DEFAULT NULL COMMENT '家庭状况';");
}
if(!pdo_fieldexists("bc_community_help", "nhgs")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `nhgs` varchar(250) DEFAULT NULL COMMENT '农户故事';");
}
if(!pdo_fieldexists("bc_community_help", "jtcp")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `jtcp` varchar(100) DEFAULT NULL COMMENT '家庭产品';");
}
if(!pdo_fieldexists("bc_community_help", "jiage")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `jiage` varchar(100) DEFAULT NULL COMMENT '价格';");
}
if(!pdo_fieldexists("bc_community_help", "songhuo")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `songhuo` varchar(100) DEFAULT NULL COMMENT '送货';");
}
if(!pdo_fieldexists("bc_community_help", "srly")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `srly` varchar(100) DEFAULT NULL COMMENT '收入来源';");
}
if(!pdo_fieldexists("bc_community_help", "cpxq")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `cpxq` varchar(200) DEFAULT NULL COMMENT '产品详情';");
}
if(!pdo_fieldexists("bc_community_help", "cover")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `cover` text COMMENT '封面图片';");
}
if(!pdo_fieldexists("bc_community_help", "photo")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `photo` text COMMENT '相册';");
}
if(!pdo_fieldexists("bc_community_help", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `createtime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_help", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_help")." ADD   `menpai` int(11) NOT NULL COMMENT '村ID';");
}
if(!pdo_fieldexists("bc_community_information", "inid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_information")." ADD   `inid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_information", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_information")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_information", "realname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_information")." ADD   `realname` varchar(50) DEFAULT NULL COMMENT '真实姓名';");
}
if(!pdo_fieldexists("bc_community_information", "identitycard")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_information")." ADD   `identitycard` varchar(50) DEFAULT NULL COMMENT '身份证';");
}
if(!pdo_fieldexists("bc_community_information", "inctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_information")." ADD   `inctime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_jurisdiction", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_jurisdiction")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_jurisdiction", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_jurisdiction")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_jurisdiction", "lev")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_jurisdiction")." ADD   `lev` tinyint(1) DEFAULT NULL COMMENT '级别0是市1是区县2是镇3是村';");
}
if(!pdo_fieldexists("bc_community_jurisdiction", "pid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_jurisdiction")." ADD   `pid` int(10) NOT NULL COMMENT '父级ID';");
}
if(!pdo_fieldexists("bc_community_jurisdiction", "uname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_jurisdiction")." ADD   `uname` varchar(50) NOT NULL COMMENT '用户名';");
}
if(!pdo_fieldexists("bc_community_jurisdiction", "upsd")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_jurisdiction")." ADD   `upsd` varchar(150) NOT NULL COMMENT '用户密码';");
}
if(!pdo_fieldexists("bc_community_jurisdiction", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_jurisdiction")." ADD   `townid` int(10) NOT NULL COMMENT '村镇ID';");
}
if(!pdo_fieldexists("bc_community_jurisdiction", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_jurisdiction")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_address", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_address")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_address", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_address")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_address", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_address")." ADD   `mid` int(10) NOT NULL COMMENT '用户ID';");
}
if(!pdo_fieldexists("bc_community_mall_address", "contacts")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_address")." ADD   `contacts` varchar(50) NOT NULL COMMENT '联系人';");
}
if(!pdo_fieldexists("bc_community_mall_address", "mobile")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_address")." ADD   `mobile` varchar(50) NOT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists("bc_community_mall_address", "city")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_address")." ADD   `city` varchar(150) NOT NULL COMMENT '地区';");
}
if(!pdo_fieldexists("bc_community_mall_address", "address")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_address")." ADD   `address` varchar(150) NOT NULL COMMENT '联系地址';");
}
if(!pdo_fieldexists("bc_community_mall_address", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_address")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_article", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_article", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_article", "pid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `pid` int(10) NOT NULL COMMENT '分类ID';");
}
if(!pdo_fieldexists("bc_community_mall_article", "cicon")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `cicon` text NOT NULL COMMENT '封面图片';");
}
if(!pdo_fieldexists("bc_community_mall_article", "ctitle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `ctitle` varchar(50) NOT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("bc_community_mall_article", "content")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `content` text NOT NULL COMMENT '文章内容';");
}
if(!pdo_fieldexists("bc_community_mall_article", "photo")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `photo` text NOT NULL COMMENT '文章图片';");
}
if(!pdo_fieldexists("bc_community_mall_article", "status")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `status` tinyint(1) NOT NULL COMMENT '状态1显示2不显示';");
}
if(!pdo_fieldexists("bc_community_mall_article", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_article", "clidk")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `clidk` int(10) NOT NULL COMMENT '点击量';");
}
if(!pdo_fieldexists("bc_community_mall_article", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `danyuan` int(11) NOT NULL COMMENT '镇ID';");
}
if(!pdo_fieldexists("bc_community_mall_article", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_article")." ADD   `menpai` int(11) NOT NULL COMMENT '村ID';");
}
if(!pdo_fieldexists("bc_community_mall_arttype", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_arttype")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_arttype", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_arttype")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_arttype", "pid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_arttype")." ADD   `pid` int(10) NOT NULL COMMENT '分类父ID';");
}
if(!pdo_fieldexists("bc_community_mall_arttype", "cicon")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_arttype")." ADD   `cicon` text NOT NULL COMMENT '分类图标';");
}
if(!pdo_fieldexists("bc_community_mall_arttype", "ctitle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_arttype")." ADD   `ctitle` varchar(50) NOT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("bc_community_mall_arttype", "status")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_arttype")." ADD   `status` tinyint(1) NOT NULL COMMENT '状态1显示2不显示';");
}
if(!pdo_fieldexists("bc_community_mall_arttype", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_arttype")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_arttype", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_arttype")." ADD   `danyuan` int(11) NOT NULL COMMENT '镇ID';");
}
if(!pdo_fieldexists("bc_community_mall_arttype", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_arttype")." ADD   `menpai` int(11) NOT NULL COMMENT '村ID';");
}
if(!pdo_fieldexists("bc_community_mall_banner", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_banner")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_banner", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_banner")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_banner", "simg")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_banner")." ADD   `simg` text NOT NULL COMMENT '图片地址';");
}
if(!pdo_fieldexists("bc_community_mall_banner", "surl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_banner")." ADD   `surl` text NOT NULL COMMENT '链接';");
}
if(!pdo_fieldexists("bc_community_mall_banner", "stitle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_banner")." ADD   `stitle` varchar(255) NOT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("bc_community_mall_banner", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_banner")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_banner", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_banner")." ADD   `danyuan` int(11) NOT NULL COMMENT '镇ID';");
}
if(!pdo_fieldexists("bc_community_mall_banner", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_banner")." ADD   `menpai` int(11) NOT NULL COMMENT '村ID';");
}
if(!pdo_fieldexists("bc_community_mall_base", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_base")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_base", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_base")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_base", "shopname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_base")." ADD   `shopname` varchar(50) NOT NULL COMMENT '商城名称';");
}
if(!pdo_fieldexists("bc_community_mall_base", "content")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_base")." ADD   `content` text NOT NULL COMMENT '商城入驻说明';");
}
if(!pdo_fieldexists("bc_community_mall_base", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_base")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_base", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_base")." ADD   `danyuan` int(11) NOT NULL COMMENT '镇ID';");
}
if(!pdo_fieldexists("bc_community_mall_base", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_base")." ADD   `menpai` int(11) NOT NULL COMMENT '村ID';");
}
if(!pdo_fieldexists("bc_community_mall_bespeak", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_bespeak")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_bespeak", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_bespeak")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_bespeak", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_bespeak")." ADD   `mid` int(11) NOT NULL COMMENT '用户id';");
}
if(!pdo_fieldexists("bc_community_mall_bespeak", "sid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_bespeak")." ADD   `sid` int(11) NOT NULL COMMENT '商家id';");
}
if(!pdo_fieldexists("bc_community_mall_bespeak", "pid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_bespeak")." ADD   `pid` int(10) NOT NULL COMMENT '产品ID';");
}
if(!pdo_fieldexists("bc_community_mall_bespeak", "content")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_bespeak")." ADD   `content` text NOT NULL COMMENT '预约说明';");
}
if(!pdo_fieldexists("bc_community_mall_bespeak", "contacts")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_bespeak")." ADD   `contacts` varchar(50) NOT NULL COMMENT '联系人';");
}
if(!pdo_fieldexists("bc_community_mall_bespeak", "mobile")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_bespeak")." ADD   `mobile` varchar(50) NOT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists("bc_community_mall_bespeak", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_bespeak")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_bespeak", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_bespeak")." ADD   `danyuan` int(11) NOT NULL COMMENT '预约商户所属镇ID';");
}
if(!pdo_fieldexists("bc_community_mall_bespeak", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_bespeak")." ADD   `menpai` int(11) NOT NULL COMMENT '预约商户所属村ID';");
}
if(!pdo_fieldexists("bc_community_mall_category", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_category")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_category", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_category")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_category", "pid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_category")." ADD   `pid` int(10) NOT NULL COMMENT '分类父ID';");
}
if(!pdo_fieldexists("bc_community_mall_category", "cicon")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_category")." ADD   `cicon` text NOT NULL COMMENT '分类图标';");
}
if(!pdo_fieldexists("bc_community_mall_category", "ctitle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_category")." ADD   `ctitle` varchar(50) NOT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("bc_community_mall_category", "status")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_category")." ADD   `status` tinyint(1) NOT NULL COMMENT '状态1显示2不显示';");
}
if(!pdo_fieldexists("bc_community_mall_category", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_category")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_category", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_category")." ADD   `danyuan` int(11) NOT NULL COMMENT '镇ID';");
}
if(!pdo_fieldexists("bc_community_mall_category", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_category")." ADD   `menpai` int(11) NOT NULL COMMENT '村ID';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_goods", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `mid` int(11) NOT NULL COMMENT '用户id';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "sid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `sid` int(11) NOT NULL COMMENT '商家id';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "pptid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `pptid` int(10) NOT NULL COMMENT '产品一级分类ID';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "ptid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `ptid` int(10) NOT NULL COMMENT '产品二级分类ID';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "is_hot")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `is_hot` int(1) NOT NULL COMMENT '是否推荐，0表示不推荐，1表示推荐';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "pimg")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `pimg` text NOT NULL COMMENT '产品封面图片';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "photo")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `photo` text NOT NULL COMMENT '产品相册';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "ptitle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `ptitle` varchar(255) NOT NULL COMMENT '产品标题';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "price")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `price` decimal(10;");
}
if(!pdo_fieldexists("bc_community_mall_goods", "")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD 2) DEFAULT '0.00' COMMENT '价格';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "punit")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `punit` varchar(50) NOT NULL COMMENT '单位/规格';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "pqty")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `pqty` int(10) NOT NULL COMMENT '产品总数量';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "pyqty")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `pyqty` int(10) NOT NULL COMMENT '产品已售数量';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "pcontent")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `pcontent` text NOT NULL COMMENT '产品详情';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "pstatus")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `pstatus` int(1) NOT NULL COMMENT '产品状态，0表示待审核，1表示正常，2表示下架';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "pstrattime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `pstrattime` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists("bc_community_mall_goods", "pctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `pctime` int(10) NOT NULL;");
}
if(!pdo_fieldexists("bc_community_mall_goods", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `danyuan` int(11) NOT NULL COMMENT '发布商品的用户所属镇ID';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `menpai` int(11) NOT NULL COMMENT '发布商品的用户所属村ID';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "baseyf")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `baseyf` decimal(10;");
}
if(!pdo_fieldexists("bc_community_mall_goods", "")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD 2) DEFAULT '0.00' COMMENT '单个规格的运费';");
}
if(!pdo_fieldexists("bc_community_mall_goods", "addyf")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD   `addyf` decimal(10;");
}
if(!pdo_fieldexists("bc_community_mall_goods", "")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_goods")." ADD 2) DEFAULT '0.00' COMMENT '超出基础运费按规格数量累计';");
}
if(!pdo_fieldexists("bc_community_mall_log", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_log")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_log", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_log")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_log", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_log")." ADD   `mid` int(11) NOT NULL COMMENT '用户id';");
}
if(!pdo_fieldexists("bc_community_mall_log", "sid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_log")." ADD   `sid` int(11) NOT NULL COMMENT '商户id';");
}
if(!pdo_fieldexists("bc_community_mall_log", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_log")." ADD   `townid` int(11) NOT NULL COMMENT '乡镇id';");
}
if(!pdo_fieldexists("bc_community_mall_log", "villageid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_log")." ADD   `villageid` int(11) NOT NULL COMMENT '村庄id';");
}
if(!pdo_fieldexists("bc_community_mall_log", "type")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_log")." ADD   `type` tinyint(1) NOT NULL COMMENT '日志类型1商品编辑2订单状态变更3订单金额修改';");
}
if(!pdo_fieldexists("bc_community_mall_log", "content")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_log")." ADD   `content` varchar(255) NOT NULL COMMENT '日志内容';");
}
if(!pdo_fieldexists("bc_community_mall_log", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_log")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_messages", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_messages")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_messages", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_messages")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_messages", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_messages")." ADD   `mid` int(11) NOT NULL COMMENT '用户id';");
}
if(!pdo_fieldexists("bc_community_mall_messages", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_messages")." ADD   `townid` int(11) NOT NULL COMMENT '乡镇id';");
}
if(!pdo_fieldexists("bc_community_mall_messages", "villageid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_messages")." ADD   `villageid` int(11) NOT NULL COMMENT '村庄id';");
}
if(!pdo_fieldexists("bc_community_mall_messages", "type")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_messages")." ADD   `type` tinyint(1) NOT NULL COMMENT '消息主题1新订单消息2订单状态变更消息3提现消息4提现进度消息';");
}
if(!pdo_fieldexists("bc_community_mall_messages", "title")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_messages")." ADD   `title` varchar(100) NOT NULL COMMENT '消息标题';");
}
if(!pdo_fieldexists("bc_community_mall_messages", "content")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_messages")." ADD   `content` varchar(255) NOT NULL COMMENT '消息内容';");
}
if(!pdo_fieldexists("bc_community_mall_messages", "status")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_messages")." ADD   `status` tinyint(1) NOT NULL COMMENT '阅读状态0为未读1为已读';");
}
if(!pdo_fieldexists("bc_community_mall_messages", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_messages")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_nav", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_nav")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_nav", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_nav")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_nav", "nicon")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_nav")." ADD   `nicon` text NOT NULL COMMENT '分类图标';");
}
if(!pdo_fieldexists("bc_community_mall_nav", "nurl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_nav")." ADD   `nurl` text NOT NULL COMMENT '链接';");
}
if(!pdo_fieldexists("bc_community_mall_nav", "ntitle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_nav")." ADD   `ntitle` varchar(50) NOT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("bc_community_mall_nav", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_nav")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_nav", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_nav")." ADD   `danyuan` int(11) NOT NULL COMMENT '镇ID';");
}
if(!pdo_fieldexists("bc_community_mall_nav", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_nav")." ADD   `menpai` int(11) NOT NULL COMMENT '村ID';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '产品订单ID';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "pocode")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `pocode` varchar(30) NOT NULL COMMENT '产品订单编号';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "pcover")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `pcover` text NOT NULL COMMENT '产品图片快照';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "poinfo")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `poinfo` text NOT NULL COMMENT '产品订单快照';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "pid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `pid` int(10) NOT NULL COMMENT '产品ID';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "sid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `sid` int(10) NOT NULL COMMENT '商家ID';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `mid` int(10) NOT NULL COMMENT '用户ID';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "pnum")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `pnum` int(10) NOT NULL COMMENT '产品数量';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "oneprice")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `oneprice` decimal(10;");
}
if(!pdo_fieldexists("bc_community_mall_orders", "")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD 2) DEFAULT '0.00' COMMENT '产品单价';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "goodsprice")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `goodsprice` decimal(10;");
}
if(!pdo_fieldexists("bc_community_mall_orders", "")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD 2) DEFAULT '0.00' COMMENT '产品总价';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "yf")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `yf` decimal(10;");
}
if(!pdo_fieldexists("bc_community_mall_orders", "")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD 2) DEFAULT '0.00' COMMENT '运费';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "orderprice")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `orderprice` decimal(10;");
}
if(!pdo_fieldexists("bc_community_mall_orders", "")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD 2) DEFAULT '0.00' COMMENT '产品订单总价';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "postatus")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `postatus` int(1) NOT NULL COMMENT '订单状态0未支付1已付款未发货2已付款已发货3已收到货待确认4收货方自然确认5有问题需人工介入处理6人工客服确认';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "remark")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `remark` varchar(255) NOT NULL COMMENT '订单处理备注';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "shuser")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `shuser` varchar(200) NOT NULL COMMENT '收货人';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "shaddress")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `shaddress` varchar(200) NOT NULL COMMENT '收货地址';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "express")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `express` varchar(100) NOT NULL COMMENT '快递记录';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "poctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `poctime` int(10) NOT NULL COMMENT '产品订单创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "potime1")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `potime1` int(10) NOT NULL COMMENT '产品订单支付时间';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "potime2")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `potime2` int(10) NOT NULL COMMENT '产品订单发货时间';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "potime3")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `potime3` int(10) NOT NULL COMMENT '产品订单确认收货时间';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "potime4")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `potime4` int(10) NOT NULL COMMENT '问题订单提交人工客服处理时间';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "potime5")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `potime5` int(10) NOT NULL COMMENT '人工确认订单时间';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "potime6")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `potime6` int(10) NOT NULL COMMENT '商家最后编辑时间';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `danyuan` int(11) NOT NULL COMMENT '商家所属镇ID';");
}
if(!pdo_fieldexists("bc_community_mall_orders", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_orders")." ADD   `menpai` int(11) NOT NULL COMMENT '商家所属村ID';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_seller", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `mid` int(10) NOT NULL COMMENT '用户ID';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "idcard")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `idcard` varchar(20) NOT NULL COMMENT '身份证号';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "cashcard")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `cashcard` varchar(50) NOT NULL COMMENT '提现卡号';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "slogo")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `slogo` text NOT NULL COMMENT '商家LOGO';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "scover")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `scover` text NOT NULL COMMENT '商家封面图片';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "stitle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `stitle` varchar(150) NOT NULL COMMENT '商家名称';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "content")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `content` text NOT NULL COMMENT '商家介绍';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "browse")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `browse` int(10) NOT NULL COMMENT '浏览量';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "tese")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `tese` text NOT NULL COMMENT '商家特色';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "contacts")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `contacts` varchar(50) NOT NULL COMMENT '联系人';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "mobile")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `mobile` varchar(50) NOT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "address")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `address` varchar(150) NOT NULL COMMENT '联系地址';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "longitude")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `longitude` varchar(30) NOT NULL COMMENT '定位经度';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "latitude")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `latitude` varchar(30) NOT NULL COMMENT '定位纬度';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `danyuan` int(11) NOT NULL COMMENT '镇ID';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `menpai` int(11) NOT NULL COMMENT '村ID';");
}
if(!pdo_fieldexists("bc_community_mall_seller", "rz")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_seller")." ADD   `rz` tinyint(1) NOT NULL COMMENT '认证状态0未通过1待完善2已认证';");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD   `mid` int(10) NOT NULL COMMENT '用户ID';");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "amount")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD   `amount` decimal(10;");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD 2) DEFAULT '0.00' COMMENT '金额';");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "type")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD   `type` tinyint(1) NOT NULL COMMENT '类型1收入2提现3平台交易手续费';");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "status")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD   `status` tinyint(1) NOT NULL COMMENT '状态1是已审核0是未审核';");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "remark")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD   `remark` varchar(150) NOT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "etime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD   `etime` int(10) NOT NULL COMMENT '处理时间';");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD   `danyuan` int(11) NOT NULL COMMENT '镇ID';");
}
if(!pdo_fieldexists("bc_community_mall_wallet", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_mall_wallet")." ADD   `menpai` int(11) NOT NULL COMMENT '村ID';");
}
if(!pdo_fieldexists("bc_community_member", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `mid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_member", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `weid` int(11) NOT NULL COMMENT '所属公众号';");
}
if(!pdo_fieldexists("bc_community_member", "openid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `openid` varchar(100) NOT NULL COMMENT '会员OPENID';");
}
if(!pdo_fieldexists("bc_community_member", "idcard")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `idcard` bigint(18) NOT NULL COMMENT '身份证号码';");
}
if(!pdo_fieldexists("bc_community_member", "grade")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `grade` int(11) NOT NULL COMMENT '会员等级 1代表普通会员 2代表认证居民 3社区书记 4代表管理员';");
}
if(!pdo_fieldexists("bc_community_member", "userip")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `userip` varchar(100) NOT NULL COMMENT '会员IP';");
}
if(!pdo_fieldexists("bc_community_member", "gag")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `gag` int(1) NOT NULL COMMENT '是否禁言：0为正常，1为禁言';");
}
if(!pdo_fieldexists("bc_community_member", "blacklist")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `blacklist` int(1) NOT NULL COMMENT '是否拉黑：0为正常，1为拉黑';");
}
if(!pdo_fieldexists("bc_community_member", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `nickname` varchar(100) NOT NULL COMMENT '会员昵称';");
}
if(!pdo_fieldexists("bc_community_member", "realname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `realname` varchar(50) NOT NULL COMMENT '会员真实姓名';");
}
if(!pdo_fieldexists("bc_community_member", "tel")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `tel` bigint(14) NOT NULL COMMENT '会员电话';");
}
if(!pdo_fieldexists("bc_community_member", "coid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `coid` int(11) NOT NULL COMMENT '小区ID';");
}
if(!pdo_fieldexists("bc_community_member", "dong")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `dong` int(11) NOT NULL COMMENT '栋数';");
}
if(!pdo_fieldexists("bc_community_member", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `danyuan` int(11) NOT NULL COMMENT '单元';");
}
if(!pdo_fieldexists("bc_community_member", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `menpai` int(11) NOT NULL COMMENT '门牌';");
}
if(!pdo_fieldexists("bc_community_member", "address")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `address` varchar(255) NOT NULL COMMENT '会员地址';");
}
if(!pdo_fieldexists("bc_community_member", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `avatar` text NOT NULL COMMENT '会员头像';");
}
if(!pdo_fieldexists("bc_community_member", "integral")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `integral` varchar(20) NOT NULL COMMENT '会员积分';");
}
if(!pdo_fieldexists("bc_community_member", "country")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `country` varchar(10) NOT NULL COMMENT '国家';");
}
if(!pdo_fieldexists("bc_community_member", "province")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `province` varchar(10) NOT NULL COMMENT '省份';");
}
if(!pdo_fieldexists("bc_community_member", "city")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `city` varchar(10) NOT NULL COMMENT '县区';");
}
if(!pdo_fieldexists("bc_community_member", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `createtime` int(10) NOT NULL;");
}
if(!pdo_fieldexists("bc_community_member", "isrz")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_member")." ADD   `isrz` tinyint(1) NOT NULL COMMENT '是否认证1是0否';");
}
if(!pdo_fieldexists("bc_community_menu", "meid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_menu")." ADD   `meid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_menu", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_menu")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_menu", "mimg")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_menu")." ADD   `mimg` text COMMENT '分类图片地址';");
}
if(!pdo_fieldexists("bc_community_menu", "jump")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_menu")." ADD   `jump` int(1) DEFAULT NULL COMMENT '是否跳转超链接：0为正常，1为跳转';");
}
if(!pdo_fieldexists("bc_community_menu", "murl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_menu")." ADD   `murl` text COMMENT '分类转向链接';");
}
if(!pdo_fieldexists("bc_community_menu", "mtitle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_menu")." ADD   `mtitle` varchar(255) DEFAULT NULL COMMENT '分类标题';");
}
if(!pdo_fieldexists("bc_community_menu", "mtype")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_menu")." ADD   `mtype` int(1) DEFAULT NULL COMMENT '分类的类型，导航是1，滑动导航是2';");
}
if(!pdo_fieldexists("bc_community_menu", "mstatus")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_menu")." ADD   `mstatus` int(1) DEFAULT NULL COMMENT '分类的发布状态， 1代表普通会员 2代表认证居民 3社区书记 4管理员';");
}
if(!pdo_fieldexists("bc_community_menu", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_menu")." ADD   `createtime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_menu", "authorid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_menu")." ADD   `authorid` varchar(100) NOT NULL COMMENT '发布权限ID集合';");
}
if(!pdo_fieldexists("bc_community_menu", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_menu")." ADD   `townid` int(10) NOT NULL COMMENT '村镇ID';");
}
if(!pdo_fieldexists("bc_community_messages", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_messages")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_messages", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_messages")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_messages", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_messages")." ADD   `mid` int(11) NOT NULL COMMENT '用户id';");
}
if(!pdo_fieldexists("bc_community_messages", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_messages")." ADD   `townid` int(11) NOT NULL COMMENT '乡镇id';");
}
if(!pdo_fieldexists("bc_community_messages", "villageid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_messages")." ADD   `villageid` int(11) NOT NULL COMMENT '村庄id';");
}
if(!pdo_fieldexists("bc_community_messages", "type")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_messages")." ADD   `type` varchar(50) NOT NULL COMMENT '消息主题';");
}
if(!pdo_fieldexists("bc_community_messages", "manageid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_messages")." ADD   `manageid` int(11) NOT NULL COMMENT '发布管理员ID';");
}
if(!pdo_fieldexists("bc_community_messages", "title")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_messages")." ADD   `title` varchar(100) NOT NULL COMMENT '消息标题';");
}
if(!pdo_fieldexists("bc_community_messages", "content")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_messages")." ADD   `content` varchar(255) NOT NULL COMMENT '消息内容';");
}
if(!pdo_fieldexists("bc_community_messages", "status")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_messages")." ADD   `status` tinyint(1) NOT NULL COMMENT '阅读状态0为未读1为已读';");
}
if(!pdo_fieldexists("bc_community_messages", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_messages")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_nav", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_nav")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_nav", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_nav")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_nav", "mimg")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_nav")." ADD   `mimg` text COMMENT '分类图片地址';");
}
if(!pdo_fieldexists("bc_community_nav", "jump")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_nav")." ADD   `jump` int(1) DEFAULT NULL COMMENT '是否跳转超链接：0为正常，1为跳转';");
}
if(!pdo_fieldexists("bc_community_nav", "murl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_nav")." ADD   `murl` text COMMENT '导航转向链接';");
}
if(!pdo_fieldexists("bc_community_nav", "mtitle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_nav")." ADD   `mtitle` varchar(255) DEFAULT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("bc_community_nav", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_nav")." ADD   `createtime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_news", "nid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `nid` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_news", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `weid` int(10) NOT NULL COMMENT '所属公众号';");
}
if(!pdo_fieldexists("bc_community_news", "nmenu")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `nmenu` int(10) NOT NULL COMMENT '所属分类';");
}
if(!pdo_fieldexists("bc_community_news", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `mid` int(10) NOT NULL COMMENT '发布会员id';");
}
if(!pdo_fieldexists("bc_community_news", "ntitle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `ntitle` varchar(255) NOT NULL COMMENT '帖子标题';");
}
if(!pdo_fieldexists("bc_community_news", "ntext")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `ntext` text NOT NULL COMMENT '帖子内容';");
}
if(!pdo_fieldexists("bc_community_news", "nimg")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `nimg` text NOT NULL COMMENT '帖子图片';");
}
if(!pdo_fieldexists("bc_community_news", "time")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `time` text NOT NULL COMMENT '时间';");
}
if(!pdo_fieldexists("bc_community_news", "qidian")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `qidian` text NOT NULL COMMENT '起点';");
}
if(!pdo_fieldexists("bc_community_news", "zhongdian")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `zhongdian` text NOT NULL COMMENT '终点';");
}
if(!pdo_fieldexists("bc_community_news", "dunwei")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `dunwei` varchar(50) NOT NULL COMMENT '吨位（发货量）';");
}
if(!pdo_fieldexists("bc_community_news", "yunfei")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `yunfei` text NOT NULL COMMENT '运费';");
}
if(!pdo_fieldexists("bc_community_news", "lxfs")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `lxfs` varchar(50) NOT NULL COMMENT '联系方式';");
}
if(!pdo_fieldexists("bc_community_news", "beizhu")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `beizhu` text NOT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("bc_community_news", "didian")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `didian` text NOT NULL COMMENT '地点';");
}
if(!pdo_fieldexists("bc_community_news", "peoplenum")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `peoplenum` varchar(50) NOT NULL COMMENT '人数';");
}
if(!pdo_fieldexists("bc_community_news", "njmc")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `njmc` text NOT NULL COMMENT '农机名称';");
}
if(!pdo_fieldexists("bc_community_news", "jxdx")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `jxdx` varchar(50) NOT NULL COMMENT '机型大小';");
}
if(!pdo_fieldexists("bc_community_news", "ts")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `ts` varchar(50) NOT NULL COMMENT '台数';");
}
if(!pdo_fieldexists("bc_community_news", "dwgs")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `dwgs` varchar(100) NOT NULL COMMENT '单位/工时';");
}
if(!pdo_fieldexists("bc_community_news", "name")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `name` varchar(50) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("bc_community_news", "sfz")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `sfz` varchar(50) NOT NULL COMMENT '身份证';");
}
if(!pdo_fieldexists("bc_community_news", "qsl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `qsl` varchar(50) NOT NULL COMMENT '起收量';");
}
if(!pdo_fieldexists("bc_community_news", "fmzl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `fmzl` text NOT NULL COMMENT '贩卖种类';");
}
if(!pdo_fieldexists("bc_community_news", "producttype")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `producttype` varchar(50) NOT NULL COMMENT '产品类型';");
}
if(!pdo_fieldexists("bc_community_news", "remark")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `remark` text NOT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("bc_community_news", "top")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `top` int(1) NOT NULL COMMENT '是否置顶';");
}
if(!pdo_fieldexists("bc_community_news", "wishrl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `wishrl` int(1) NOT NULL COMMENT '是否认领';");
}
if(!pdo_fieldexists("bc_community_news", "wishurl")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `wishurl` text NOT NULL COMMENT '微心愿超链接';");
}
if(!pdo_fieldexists("bc_community_news", "wishtel")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `wishtel` bigint(11) NOT NULL COMMENT '微心愿认领手机号码';");
}
if(!pdo_fieldexists("bc_community_news", "wishname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `wishname` varchar(50) NOT NULL COMMENT '微心愿认领人姓名';");
}
if(!pdo_fieldexists("bc_community_news", "wishcode")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `wishcode` int(6) NOT NULL COMMENT '微心愿认领手机验证码';");
}
if(!pdo_fieldexists("bc_community_news", "wishcompany")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `wishcompany` text NOT NULL COMMENT '微心愿认领人所在单位';");
}
if(!pdo_fieldexists("bc_community_news", "status")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `status` int(1) NOT NULL COMMENT '是否审核';");
}
if(!pdo_fieldexists("bc_community_news", "browser")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `browser` int(10) NOT NULL COMMENT '浏览量';");
}
if(!pdo_fieldexists("bc_community_news", "nctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `nctime` int(10) NOT NULL;");
}
if(!pdo_fieldexists("bc_community_news", "coid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `coid` int(11) NOT NULL COMMENT '市ID';");
}
if(!pdo_fieldexists("bc_community_news", "danyuan")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `danyuan` int(11) NOT NULL COMMENT '镇ID';");
}
if(!pdo_fieldexists("bc_community_news", "menpai")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_news")." ADD   `menpai` int(11) NOT NULL COMMENT '村ID';");
}
if(!pdo_fieldexists("bc_community_organlev", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organlev")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_organlev", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organlev")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_organlev", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organlev")." ADD   `townid` int(11) DEFAULT NULL COMMENT '村镇ID';");
}
if(!pdo_fieldexists("bc_community_organlev", "organname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organlev")." ADD   `organname` varchar(50) DEFAULT NULL COMMENT '乡村组织级别名称';");
}
if(!pdo_fieldexists("bc_community_organlev", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organlev")." ADD   `ctime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_organlev", "villageid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organlev")." ADD   `villageid` int(11) NOT NULL COMMENT '村庄ID';");
}
if(!pdo_fieldexists("bc_community_organuser", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_organuser", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_organuser", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `townid` int(11) DEFAULT NULL COMMENT '村镇ID';");
}
if(!pdo_fieldexists("bc_community_organuser", "organid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `organid` int(11) DEFAULT NULL COMMENT '乡村组织级别ID';");
}
if(!pdo_fieldexists("bc_community_organuser", "username")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `username` varchar(50) DEFAULT NULL COMMENT '成员姓名';");
}
if(!pdo_fieldexists("bc_community_organuser", "cover")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `cover` text COMMENT '头像';");
}
if(!pdo_fieldexists("bc_community_organuser", "sex")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `sex` tinyint(1) DEFAULT NULL COMMENT '性别1男2女';");
}
if(!pdo_fieldexists("bc_community_organuser", "tel")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `tel` varchar(40) DEFAULT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists("bc_community_organuser", "zhiwei")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `zhiwei` varchar(100) DEFAULT NULL COMMENT '职位';");
}
if(!pdo_fieldexists("bc_community_organuser", "company")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `company` varchar(100) DEFAULT NULL COMMENT '工作单位';");
}
if(!pdo_fieldexists("bc_community_organuser", "comment")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `comment` text COMMENT '简介';");
}
if(!pdo_fieldexists("bc_community_organuser", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_organuser")." ADD   `ctime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_proposal", "pid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `pid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_proposal", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_proposal", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `mid` int(11) DEFAULT NULL COMMENT '用户ID';");
}
if(!pdo_fieldexists("bc_community_proposal", "ptype")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `ptype` int(11) DEFAULT NULL COMMENT '建议所属类型id';");
}
if(!pdo_fieldexists("bc_community_proposal", "ptext")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `ptext` varchar(255) DEFAULT NULL COMMENT '建议文字';");
}
if(!pdo_fieldexists("bc_community_proposal", "paddress")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `paddress` varchar(255) DEFAULT NULL COMMENT '建议人详细地址';");
}
if(!pdo_fieldexists("bc_community_proposal", "pimg")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `pimg` text COMMENT '建议图片';");
}
if(!pdo_fieldexists("bc_community_proposal", "pctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `pctime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_proposal", "phandle")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `phandle` text NOT NULL COMMENT '处理详情';");
}
if(!pdo_fieldexists("bc_community_proposal", "phandleper")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `phandleper` varchar(50) NOT NULL COMMENT '处理人';");
}
if(!pdo_fieldexists("bc_community_proposal", "phandletime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `phandletime` int(11) NOT NULL COMMENT '处理时间';");
}
if(!pdo_fieldexists("bc_community_proposal", "pstatus")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_proposal")." ADD   `pstatus` int(1) NOT NULL COMMENT '处理状态';");
}
if(!pdo_fieldexists("bc_community_renzheng", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_renzheng")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_renzheng", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_renzheng")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_renzheng", "townid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_renzheng")." ADD   `townid` int(11) DEFAULT NULL COMMENT '村镇ID';");
}
if(!pdo_fieldexists("bc_community_renzheng", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_renzheng")." ADD   `mid` int(11) DEFAULT NULL COMMENT '用户ID';");
}
if(!pdo_fieldexists("bc_community_renzheng", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_renzheng")." ADD   `createtime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_report", "reid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_report")." ADD   `reid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_report", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_report")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_report", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_report")." ADD   `mid` int(11) DEFAULT NULL COMMENT '用户ID';");
}
if(!pdo_fieldexists("bc_community_report", "newsid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_report")." ADD   `newsid` int(11) DEFAULT NULL COMMENT '活动帖子ID';");
}
if(!pdo_fieldexists("bc_community_report", "username")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_report")." ADD   `username` varchar(50) DEFAULT NULL COMMENT '真实姓名';");
}
if(!pdo_fieldexists("bc_community_report", "telephone")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_report")." ADD   `telephone` bigint(11) DEFAULT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists("bc_community_report", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_report")." ADD   `createtime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_thumbs", "thid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_thumbs")." ADD   `thid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_thumbs", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_thumbs")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_thumbs", "newsid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_thumbs")." ADD   `newsid` int(11) DEFAULT NULL COMMENT '帖子id';");
}
if(!pdo_fieldexists("bc_community_thumbs", "mid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_thumbs")." ADD   `mid` int(11) DEFAULT NULL COMMENT '用户ID';");
}
if(!pdo_fieldexists("bc_community_thumbs", "thstatus")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_thumbs")." ADD   `thstatus` int(11) NOT NULL COMMENT '点赞状态，1点赞 0取消赞';");
}
if(!pdo_fieldexists("bc_community_thumbs", "thctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_thumbs")." ADD   `thctime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_town", "id")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_town", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `weid` int(10) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_town", "lev")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `lev` tinyint(1) DEFAULT NULL COMMENT '级别0是市1是区县2是镇3是村';");
}
if(!pdo_fieldexists("bc_community_town", "pid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `pid` int(10) NOT NULL COMMENT '父级ID';");
}
if(!pdo_fieldexists("bc_community_town", "name")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `name` varchar(50) NOT NULL COMMENT '名称';");
}
if(!pdo_fieldexists("bc_community_town", "cover")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `cover` text NOT NULL COMMENT '封面图片';");
}
if(!pdo_fieldexists("bc_community_town", "photo")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `photo` text NOT NULL COMMENT '相册';");
}
if(!pdo_fieldexists("bc_community_town", "remark")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `remark` varchar(250) NOT NULL COMMENT '简介';");
}
if(!pdo_fieldexists("bc_community_town", "comment")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `comment` text NOT NULL COMMENT '详情';");
}
if(!pdo_fieldexists("bc_community_town", "status")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `status` tinyint(1) NOT NULL;");
}
if(!pdo_fieldexists("bc_community_town", "paixu")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `paixu` int(10) NOT NULL COMMENT '排序';");
}
if(!pdo_fieldexists("bc_community_town", "latlong")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `latlong` varchar(40) NOT NULL COMMENT '经纬度';");
}
if(!pdo_fieldexists("bc_community_town", "contacts")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `contacts` varchar(40) NOT NULL COMMENT '联系人';");
}
if(!pdo_fieldexists("bc_community_town", "tel")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `tel` varchar(40) NOT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists("bc_community_town", "ctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `ctime` int(10) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("bc_community_town", "rd")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `rd` int(10) NOT NULL COMMENT '发帖总数';");
}
if(!pdo_fieldexists("bc_community_town", "color")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_town")." ADD   `color` varchar(40) NOT NULL COMMENT '按钮颜色';");
}
if(!pdo_fieldexists("bc_community_type", "tid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_type")." ADD   `tid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("bc_community_type", "weid")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_type")." ADD   `weid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists("bc_community_type", "tname")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_type")." ADD   `tname` varchar(255) DEFAULT NULL COMMENT '问题类型名称';");
}
if(!pdo_fieldexists("bc_community_type", "tstatus")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_type")." ADD   `tstatus` int(1) DEFAULT NULL COMMENT '问题类型状态：0为正常，1为禁用';");
}
if(!pdo_fieldexists("bc_community_type", "tctime")) {
 pdo_query("ALTER TABLE ".tablename("bc_community_type")." ADD   `tctime` int(11) NOT NULL COMMENT '创建时间';");
}

 ?>