-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2019-06-22 15:59:59
-- 服务器版本： 5.6.43-log
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `www_wulitan_com`
--

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_address`
--

CREATE TABLE `ims_xc_xinguwu_address` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式',
  `region` varchar(50) NOT NULL DEFAULT '' COMMENT '省市区',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '地址详情',
  `ison` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否设为默认地址',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地址管理' ROW_FORMAT=COMPACT;



-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_autonum`
--

CREATE TABLE `ims_xc_xinguwu_autonum` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `num` int(11) DEFAULT '0',
  `keyval` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自动编号';

--
-- 转存表中的数据 `ims_xc_xinguwu_autonum`
--

INSERT INTO `ims_xc_xinguwu_autonum` (`id`, `uniacid`, `num`, `keyval`) VALUES
(1, 42, 11, 'order');

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_bargain`
--

CREATE TABLE `ims_xc_xinguwu_bargain` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `attr_name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名称',
  `floor_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '底价',
  `bargain_range` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价范围',
  `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `time_range` int(11) NOT NULL DEFAULT '0' COMMENT '时间限制(分)',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `good_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品显示价格',
  `good_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '砍价人数',
  `limit_num` int(11) NOT NULL DEFAULT '0' COMMENT '数量限制',
  `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示',
  `share` varchar(500) NOT NULL DEFAULT '' COMMENT '分享内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砍价列表';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_bargain_self`
--

CREATE TABLE `ims_xc_xinguwu_bargain_self` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `bargain_id` int(11) NOT NULL DEFAULT '0' COMMENT '砍价列表id',
  `new_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前的价格',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态(1进行中,2已砍至低价,3已失效,4已交易)',
  `avatarurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `endtime` datetime DEFAULT NULL COMMENT '结束时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='我的砍价列表';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_bargain_self_log`
--

CREATE TABLE `ims_xc_xinguwu_bargain_self_log` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `bargain_self_id` int(11) NOT NULL DEFAULT '0' COMMENT '发起砍价id',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `cut_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '帮砍的金额',
  `avatarurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='帮砍记录';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_brokerage_order`
--

CREATE TABLE `ims_xc_xinguwu_brokerage_order` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `order` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单价格',
  `get_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返佣',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态1已付款2已完成',
  `isoff` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否已失效'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金记录';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_category`
--

CREATE TABLE `ims_xc_xinguwu_category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名称',
  `uniacid` int(11) DEFAULT NULL,
  `father_id` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `modifytime` datetime DEFAULT NULL COMMENT '修改时间',
  `feature` int(11) NOT NULL DEFAULT '0' COMMENT '规格 id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='类别' ROW_FORMAT=COMPACT;


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_club`
--

CREATE TABLE `ims_xc_xinguwu_club` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态1正常2申请-1关闭',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '社团名称',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(11) DEFAULT NULL COMMENT '联系方式',
  `region` varchar(50) NOT NULL DEFAULT '' COMMENT '省市区',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `longitude` varchar(255) NOT NULL DEFAULT '' COMMENT '经度',
  `latitude` varchar(255) NOT NULL DEFAULT '' COMMENT '纬度',
  `modifytime` datetime DEFAULT NULL COMMENT '修改日志',
  `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金',
  `totalbrokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '成交单数',
  `avatar` varchar(255) DEFAULT NULL,
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注(服务时间)',
  `formid` text COMMENT '模版消息id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团长';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_club_brokerage`
--

CREATE TABLE `ims_xc_xinguwu_club_brokerage` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1收入-1支出',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动',
  `now_brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动之后的佣金',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态2申请',
  `avatarurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `order` varchar(20) NOT NULL DEFAULT '' COMMENT '单号',
  `deposit_time` datetime DEFAULT NULL COMMENT '提现时间',
  `alipay` varchar(50) NOT NULL DEFAULT '' COMMENT '支付宝账号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='社区佣金';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_club_label`
--

CREATE TABLE `ims_xc_xinguwu_club_label` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1几日达',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `tip` varchar(50) NOT NULL DEFAULT '' COMMENT '说明',
  `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `modifytime` varchar(50) NOT NULL DEFAULT '' COMMENT '修改时间',
  `start` int(11) NOT NULL DEFAULT '0',
  `end` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='社区团标签';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_club_member`
--

CREATE TABLE `ims_xc_xinguwu_club_member` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '联系方式',
  `region` varchar(50) NOT NULL DEFAULT '' COMMENT '地址',
  `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成交佣金',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '消费单数',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '地址详情',
  `club_id` int(11) NOT NULL DEFAULT '0' COMMENT '团长id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='社团成员';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_club_statistics`
--

CREATE TABLE `ims_xc_xinguwu_club_statistics` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '成交单数',
  `date` date DEFAULT NULL COMMENT '日期',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `club_id` int(11) NOT NULL DEFAULT '0' COMMENT '社团id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='今日统计';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_club_statistics_day`
--

CREATE TABLE `ims_xc_xinguwu_club_statistics_day` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `club_id` int(11) NOT NULL DEFAULT '0',
  `good_name` varchar(255) NOT NULL DEFAULT '',
  `good_id` int(11) NOT NULL DEFAULT '0',
  `num` int(11) DEFAULT '0',
  `date` date DEFAULT NULL,
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `img` varchar(255) DEFAULT NULL,
  `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_club_statistics_month`
--

CREATE TABLE `ims_xc_xinguwu_club_statistics_month` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `club_id` int(11) NOT NULL DEFAULT '0',
  `good_name` varchar(255) NOT NULL DEFAULT '',
  `good_id` int(11) NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `num` int(11) NOT NULL DEFAULT '0',
  `img` varchar(255) DEFAULT NULL,
  `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品统计月表';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_club_statistics_total`
--

CREATE TABLE `ims_xc_xinguwu_club_statistics_total` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `club_id` int(11) NOT NULL DEFAULT '0' COMMENT '社团id',
  `good_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `img` varchar(255) DEFAULT NULL,
  `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='社团统计';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_club_statistics_week`
--

CREATE TABLE `ims_xc_xinguwu_club_statistics_week` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `club_id` int(11) NOT NULL DEFAULT '0',
  `good_name` varchar(255) NOT NULL DEFAULT '',
  `good_id` int(11) NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `num` int(11) NOT NULL DEFAULT '0',
  `img` varchar(255) DEFAULT NULL,
  `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='统计商品周表';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_comment`
--

CREATE TABLE `ims_xc_xinguwu_comment` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `text` varchar(255) NOT NULL DEFAULT '' COMMENT '文本',
  `imgs` text COMMENT '图集',
  `anonymity` tinyint(3) NOT NULL DEFAULT '0' COMMENT '匿名',
  `goodcom` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1非常差2差3一般4好5非常好',
  `service_attitude` int(11) NOT NULL DEFAULT '0' COMMENT '服务态度',
  `logistics_speed` tinyint(3) NOT NULL DEFAULT '0' COMMENT '发货速度',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `reply` varchar(255) NOT NULL DEFAULT '' COMMENT '商家回复',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatarurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论列表';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_deposit_log`
--

CREATE TABLE `ims_xc_xinguwu_deposit_log` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `order` bigint(20) NOT NULL DEFAULT '0' COMMENT '商户订单号',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `payment_no` varchar(50) NOT NULL DEFAULT '' COMMENT '微信订单号',
  `payment_time` datetime DEFAULT NULL COMMENT '微信支付时间',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `wechat` varchar(255) NOT NULL DEFAULT '' COMMENT '微信号',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `alipay` varchar(50) NOT NULL DEFAULT '' COMMENT '支付宝账号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现记录';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_distribution`
--

CREATE TABLE `ims_xc_xinguwu_distribution` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `wechat` varchar(255) NOT NULL DEFAULT '' COMMENT '微信号',
  `phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '我的佣金',
  `brokerage_yet` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已提现佣金',
  `order_num` int(11) NOT NULL DEFAULT '0' COMMENT '分销订单数',
  `log_num` int(11) NOT NULL DEFAULT '0' COMMENT '提现记录数',
  `team_num` int(11) NOT NULL DEFAULT '0' COMMENT '团队数',
  `brokerage_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计佣金',
  `formid` text COMMENT '模版消息id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销用户';

--
-- 转存表中的数据 `ims_xc_xinguwu_distribution`
--

INSERT INTO `ims_xc_xinguwu_distribution` (`id`, `uniacid`, `openid`, `name`, `wechat`, `phone`, `status`, `brokerage`, `brokerage_yet`, `order_num`, `log_num`, `team_num`, `brokerage_total`, `formid`) VALUES
(1, 28, 'oQQwf5ckRy-0nuMJZdaKLUyyIrKQ', '', '', 0, 1, '0.00', '0.00', 0, 0, 0, '0.00', NULL),
(2, 28, 'oQQwf5UNtbYz44mnoiikkSoDh7UY', '', '', 0, 1, '0.00', '0.00', 0, 0, 0, '0.00', NULL),
(3, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', '黄国德', 'cocore', 18664830801, -1, '0.00', '0.00', 0, 0, 13, '0.00', NULL),
(4, 42, 'oJ6_m5bFn1k1f1Ksy4M8oOaARlxg', '皮皮', '15018811011', 15018811011, -1, '16.00', '0.00', 2, 0, 1, '16.00', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_feature`
--

CREATE TABLE `ims_xc_xinguwu_feature` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名',
  `value` varchar(500) DEFAULT '' COMMENT '特征值',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='特征表' ROW_FORMAT=COMPACT;


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_flashsale`
--

CREATE TABLE `ims_xc_xinguwu_flashsale` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `date_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `date_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `contents` longtext COMMENT '内容',
  `good_ids` varchar(1000) DEFAULT NULL,
  `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示 (单选)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='限时抢购';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_goods`
--

CREATE TABLE `ims_xc_xinguwu_goods` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类',
  `bimg` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片  方图',
  `simg` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片   长图',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '销售量',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '商品状态',
  `contents` longtext COMMENT '商品详情',
  `attrs` text COMMENT '商品属性',
  `prices` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格(显示用途)',
  `unit` varchar(10) NOT NULL DEFAULT '' COMMENT '单位',
  `modifytime` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `attr_name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名称',
  `imgs` text NOT NULL COMMENT '商品图集',
  `oprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价(仅用于显示)',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '商品重量(g)',
  `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `video` varchar(255) NOT NULL DEFAULT '' COMMENT '视频地址',
  `is_flash` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否抢购',
  `flash_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '抢购id',
  `param` text COMMENT '商品参数',
  `share` varchar(500) NOT NULL DEFAULT '' COMMENT '分享设置',
  `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示',
  `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '所值佣金',
  `brokerage_two` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `brokerage_there` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级级佣金',
  `club_brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团长佣金',
  `arrive` int(11) NOT NULL DEFAULT '0' COMMENT '几日达标签id',
  `presell` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '预售',
  `presell_time` date DEFAULT NULL COMMENT '预售时间',
  `supplier` varchar(255) NOT NULL DEFAULT '' COMMENT '供应商id集合',
  `content` longtext COMMENT '内容(手机管理端添加)',
  `vprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员折扣',
  `tagsids` varchar(1000) NOT NULL DEFAULT '' COMMENT '标签',
  `ecid` int(11) DEFAULT '1' COMMENT '1 pc -1手机'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品列表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_groupbuy`
--

CREATE TABLE `ims_xc_xinguwu_groupbuy` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `good_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '分类',
  `old_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `show_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '展示价',
  `limit_num` int(11) NOT NULL DEFAULT '0' COMMENT '限购数量',
  `group_num` int(11) NOT NULL DEFAULT '0' COMMENT '已开团数量',
  `pattern` tinyint(3) NOT NULL DEFAULT '0' COMMENT '开团模式 1普通2阶梯',
  `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `attr` text COMMENT '属性',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `modifytime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `duration` int(11) NOT NULL DEFAULT '0' COMMENT '持续时间分钟',
  `tries` tinyint(3) NOT NULL DEFAULT '0' COMMENT '购买次数限制',
  `deadline` datetime DEFAULT NULL COMMENT '活动截止时间',
  `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_group_order`
--

CREATE TABLE `ims_xc_xinguwu_group_order` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `order` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号',
  `list` text COMMENT '订单信息',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '地址信息',
  `paytype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式1余额2微信3抵扣4线下',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单状态1未付款2待发货3已发货4已收货',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `paytime` datetime DEFAULT NULL COMMENT '支付时间',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额(含邮费)',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `totalnum` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `payid` varchar(100) NOT NULL DEFAULT '' COMMENT '用于发送模板消息',
  `pay_wechat` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '微信支付',
  `pay_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额支付',
  `delive_time` datetime DEFAULT NULL COMMENT '发货时间',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式',
  `region` varchar(255) NOT NULL DEFAULT '' COMMENT '省市区',
  `express` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递费用',
  `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `express_number` varchar(255) NOT NULL DEFAULT '' COMMENT '快递单号',
  `express_name` varchar(50) NOT NULL DEFAULT '' COMMENT '快递名称',
  `value` varchar(500) NOT NULL DEFAULT '' COMMENT '信息',
  `score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分',
  `formid` varchar(255) NOT NULL DEFAULT '' COMMENT '用于发送模板消息',
  `express_code` varchar(50) NOT NULL DEFAULT '' COMMENT '快递公司编码',
  `group_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '团状态 1组团中2成功-1失败',
  `out_refund_no` varchar(100) NOT NULL DEFAULT '' COMMENT '商户退款单号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购订单';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_group_sponsor`
--

CREATE TABLE `ims_xc_xinguwu_group_sponsor` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购列表id',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `join_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '参团人数',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `scale` tinyint(3) NOT NULL DEFAULT '0' COMMENT '拼团规模',
  `avatarurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `endtime` datetime DEFAULT NULL COMMENT '结束时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拼团发起表';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_group_tuxedo`
--

CREATE TABLE `ims_xc_xinguwu_group_tuxedo` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `avatarurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `group_sponsor_id` int(11) NOT NULL DEFAULT '0' COMMENT '发起id',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态(1组团中2组团成功 -1 失败)',
  `order` varchar(20) NOT NULL DEFAULT '0' COMMENT '订单号',
  `ishost` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否团主',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购列表id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='参团列表';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_label`
--

CREATE TABLE `ims_xc_xinguwu_label` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名称',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `modifytime` datetime DEFAULT NULL COMMENT '修改时间',
  `imgurl` varchar(500) DEFAULT NULL,
  `itype` int(11) DEFAULT NULL COMMENT '1产品，2固定链接',
  `url` varchar(500) DEFAULT NULL COMMENT '链接',
  `cid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标签';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_labelclass`
--

CREATE TABLE `ims_xc_xinguwu_labelclass` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名称',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `modifytime` datetime DEFAULT NULL COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标签分类';

--
-- 转存表中的数据 `ims_xc_xinguwu_labelclass`
--

INSERT INTO `ims_xc_xinguwu_labelclass` (`id`, `name`, `uniacid`, `status`, `createtime`, `sorts`, `modifytime`) VALUES
(1, '冬季品牌馆', 42, 1, '2019-05-23 04:26:51', 0, NULL),
(2, '夏季时装馆', 42, 1, '2019-05-24 03:10:21', 0, NULL),
(3, '秋季舒适馆', 42, 1, '2019-05-24 03:36:09', 0, NULL),
(4, '春季生活街', 42, 1, '2019-05-24 14:50:36', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_live`
--

CREATE TABLE `ims_xc_xinguwu_live` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '房间标题',
  `stream` varchar(20) DEFAULT NULL COMMENT '流名称',
  `pusher` varchar(255) NOT NULL DEFAULT '' COMMENT '推流地址',
  `player` varchar(255) NOT NULL DEFAULT '' COMMENT '播放地址',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `contents` text NOT NULL COMMENT '内容',
  `isplay` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '1播放中-1空闲',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '使用者姓名',
  `modifytime` datetime DEFAULT NULL COMMENT '修改时间',
  `start_time` datetime DEFAULT NULL COMMENT '开始直播时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束直播时间',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '观看人数',
  `groupid` varchar(255) NOT NULL DEFAULT '' COMMENT '群组id',
  `errmsg` varchar(255) NOT NULL DEFAULT '' COMMENT '回调信息',
  `goods` varchar(255) NOT NULL DEFAULT '' COMMENT '商品ID集合'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='直播列表';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_live_dialog`
--

CREATE TABLE `ims_xc_xinguwu_live_dialog` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT '0',
  `live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间ID',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `fromAccountNick` varchar(255) DEFAULT NULL COMMENT '昵称',
  `avatarurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '类型'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='直播对话信息';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_live_dynamic`
--

CREATE TABLE `ims_xc_xinguwu_live_dynamic` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间id',
  `contents` text COMMENT '内容',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='直播动态信息表';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_live_focus`
--

CREATE TABLE `ims_xc_xinguwu_live_focus` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间id',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='直播间关注';



-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_live_playback`
--

CREATE TABLE `ims_xc_xinguwu_live_playback` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间id',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `video_url` varchar(255) NOT NULL DEFAULT '' COMMENT '回放地址',
  `file_size` varchar(50) NOT NULL DEFAULT '0' COMMENT '大小 (字节)',
  `file_id` varchar(100) NOT NULL DEFAULT '' COMMENT '点播file id',
  `file_format` varchar(10) NOT NULL DEFAULT '' COMMENT '文件格式',
  `duration` int(11) NOT NULL DEFAULT '0' COMMENT '推流时长(秒)',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `img` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `avatarurl` varchar(255) DEFAULT NULL,
  `contents` text,
  `isshow` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='直播回放';


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_member`
--

CREATE TABLE `ims_xc_xinguwu_member` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatarurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `gender` tinyint(3) NOT NULL DEFAULT '0' COMMENT '性别',
  `totalamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总共充值',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现有余额',
  `exp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '经验',
  `score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分',
  `totalscore` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '历史总积分',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `modifytime` datetime DEFAULT NULL COMMENT '修改时间',
  `level` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '等级(-1表示没有等级',
  `one` varchar(40) NOT NULL DEFAULT '0' COMMENT '一级',
  `two` varchar(40) NOT NULL DEFAULT '0' COMMENT '二级',
  `there` varchar(40) NOT NULL DEFAULT '0' COMMENT '三级',
  `garder` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销等级',
  `one_order` int(11) NOT NULL DEFAULT '0' COMMENT '一级贡献订单',
  `two_order` int(11) NOT NULL DEFAULT '0' COMMENT '二级贡献订单',
  `there_order` int(11) NOT NULL DEFAULT '0' COMMENT '三级贡献订单',
  `one_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级贡献佣金',
  `two_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级贡献佣金',
  `there_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级贡献佣金',
  `is_distributor` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否为分销商',
  `date` date DEFAULT NULL COMMENT '登录日志',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `admin` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '客服人员1是-1不是',
  `admin1` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '员工',
  `admin2` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '管理员',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(20) NOT NULL DEFAULT '0' COMMENT '联系方式',
  `sig` varchar(500) NOT NULL DEFAULT '' COMMENT '云通信签名',
  `sig_endtime` datetime DEFAULT NULL COMMENT '签名过期时间',
  `is_club` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '团长',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '动力币',
  `totalstep` int(11) NOT NULL DEFAULT '0' COMMENT '总步数',
  `sport_remind` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '运动提醒',
  `totalcoin` int(11) NOT NULL DEFAULT '0' COMMENT '总动力币',
  `reach` int(11) NOT NULL DEFAULT '0' COMMENT '达标次数',
  `attend` int(11) NOT NULL DEFAULT '0' COMMENT '参加次数',
  `sport_avatars` int(11) NOT NULL DEFAULT '0' COMMENT '好友个数',
  `is_supplier` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '供应商',
  `pow` int(11) NOT NULL DEFAULT '0' COMMENT '调试'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员信息' ROW_FORMAT=COMPACT;


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_member_amount_log`
--

CREATE TABLE `ims_xc_xinguwu_member_amount_log` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0' COMMENT '模块',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `costsamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动金额',
  `surplusamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '剩余金额',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  `itype` int(11) DEFAULT '1' COMMENT '1收入，-1为支出',
  `cid` int(11) DEFAULT '1' COMMENT '1 用户操作 2管理员操作',
  `opusername` varchar(255) DEFAULT NULL COMMENT '操作人'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;



-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_member_exp_log`
--

CREATE TABLE `ims_xc_xinguwu_member_exp_log` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '交易时间',
  `costsexp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '获取经验',
  `surplusexp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现在经验',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `itype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1+ ;-1 -',
  `cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1用户操作2管理员操作',
  `opusername` varchar(255) NOT NULL DEFAULT '' COMMENT '操作人'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='经验记录';

--
-- 转存表中的数据 `ims_xc_xinguwu_member_exp_log`
--

INSERT INTO `ims_xc_xinguwu_member_exp_log` (`id`, `uniacid`, `openid`, `createtime`, `costsexp`, `surplusexp`, `remarks`, `itype`, `cid`, `opusername`) VALUES
(1, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', '2019-06-13 10:35:09', '-3633.00', '0.42', '经验充值', -1, 2, '');

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_member_score_log`
--

CREATE TABLE `ims_xc_xinguwu_member_score_log` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `costscore` decimal(10,2) DEFAULT '0.00' COMMENT '消费积分',
  `surplusscore` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '剩余积分',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `itype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1积分收入,-1积分支出',
  `cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1用户操作2管理员操作',
  `opusername` varchar(255) NOT NULL DEFAULT '' COMMENT '操作人',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分记录表';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_moban_user`
--

CREATE TABLE `ims_xc_xinguwu_moban_user` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `headimgurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `status` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '状态',
  `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建日期',
  `ident` varchar(50) NOT NULL DEFAULT '' COMMENT '标识'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='绑定模板消息用户';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_mycard`
--

CREATE TABLE `ims_xc_xinguwu_mycard` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `voucherid` int(11) NOT NULL DEFAULT '0' COMMENT '卡券id',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '领取时间',
  `usetime` datetime DEFAULT NULL COMMENT '使用时间',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '卡券使用备注',
  `voucherstatus` tinyint(3) NOT NULL DEFAULT '0' COMMENT '卡券状态(1未使用,2已使用,3已过期)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='我的卡券' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `ims_xc_xinguwu_mycard`
--

INSERT INTO `ims_xc_xinguwu_mycard` (`id`, `uniacid`, `openid`, `voucherid`, `createtime`, `usetime`, `remark`, `voucherstatus`) VALUES
(1, 28, 'oQQwf5ckRy-0nuMJZdaKLUyyIrKQ', 1, '2018-12-06 18:01:23', NULL, '', 1),
(2, 28, 'oQQwf5ckRy-0nuMJZdaKLUyyIrKQ', 2, '2018-12-06 18:09:58', NULL, '', 1),
(3, 28, 'oQQwf5UNtbYz44mnoiikkSoDh7UY', 1, '2019-01-10 15:50:58', NULL, '', 1),
(4, 28, 'oQQwf5UNtbYz44mnoiikkSoDh7UY', 2, '2019-01-10 15:50:59', NULL, '', 1),
(5, 42, 'oJ6_m5Qd_2KyOALf-r_Zgmelu6cg', 4, '2019-05-07 06:00:39', NULL, '', 1),
(6, 42, 'oJ6_m5Qd_2KyOALf-r_Zgmelu6cg', 3, '2019-05-07 06:00:45', NULL, '', 1),
(7, 42, 'oJ6_m5Qd_2KyOALf-r_Zgmelu6cg', 6, '2019-05-07 06:09:49', NULL, '', 1),
(8, 42, 'oJ6_m5cHLqdiT0MTNyQuVGZS9EgA', 3, '2019-05-12 17:10:05', NULL, '', 1),
(9, 42, 'oJ6_m5cHLqdiT0MTNyQuVGZS9EgA', 4, '2019-05-12 17:10:06', NULL, '', 1),
(10, 42, 'oJ6_m5cHLqdiT0MTNyQuVGZS9EgA', 6, '2019-05-12 17:10:07', NULL, '', 1),
(11, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', 3, '2019-05-23 15:40:51', '2019-06-13 17:59:43', '211587598300000267', 2),
(12, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', 4, '2019-05-23 15:40:53', NULL, '', 1),
(13, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', 5, '2019-05-23 15:40:54', NULL, '', 1),
(14, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', 6, '2019-05-23 15:40:56', '2019-06-13 18:00:23', '211587602300000378', 2),
(15, 42, 'oJ6_m5Sp8quzBiII8-8h1wb7CIvw', 5, '2019-05-24 04:46:17', NULL, '', 1),
(16, 42, 'oJ6_m5Z3ycJsbKEUgPwqHZpnOEpc', 3, '2019-05-31 00:50:44', NULL, '', 1),
(17, 42, 'oJ6_m5VHvUuuszDqzCXMSktru3wU', 4, '2019-06-12 16:38:20', NULL, '', 1),
(18, 42, 'oJ6_m5VHvUuuszDqzCXMSktru3wU', 5, '2019-06-12 16:38:23', NULL, '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_online`
--

CREATE TABLE `ims_xc_xinguwu_online` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `member` int(11) NOT NULL DEFAULT '0' COMMENT '未读条数',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `content` longtext COMMENT '内容',
  `updatetime` varchar(50) DEFAULT NULL COMMENT '更新时间',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_online_log`
--

CREATE TABLE `ims_xc_xinguwu_online_log` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1文本2图片',
  `content` longtext COMMENT '内容',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `duty` tinyint(3) NOT NULL DEFAULT '1' COMMENT '身份1客户 2客服'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服记录';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_order`
--

CREATE TABLE `ims_xc_xinguwu_order` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户id',
  `unionid` varchar(64) NOT NULL DEFAULT '' COMMENT '用户标识',
  `order` varchar(20) NOT NULL DEFAULT '0' COMMENT '订单号',
  `list` text COMMENT '订单信息',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '地址信息',
  `paytype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式1余额2微信3余额不足微信抵扣4线下支付',
  `cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1 正常订单 2 积分订单4砍价6抢购',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单状态1未付款2待发货3待收货4退款5完成',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `paytime` datetime DEFAULT NULL COMMENT '支付时间',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额(实付金额)',
  `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额(不含邮费)',
  `express` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递费用',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `totalnum` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `refund` tinyint(3) NOT NULL DEFAULT '0' COMMENT '退款状态(1申请2成功3拒绝)',
  `refund_value` varchar(500) NOT NULL DEFAULT '' COMMENT '退款内容',
  `payid` varchar(255) NOT NULL DEFAULT '' COMMENT '用于发送模板消息',
  `pay_wechat` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '通过微信支付的金额',
  `pay_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '通过余额支付的金额',
  `myvoucher` int(11) NOT NULL DEFAULT '0' COMMENT '我的卡 id',
  `deliver_time` datetime DEFAULT NULL COMMENT '发货时间',
  `score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '赠送的积分数(所需的积分数)',
  `refuse` varchar(500) NOT NULL DEFAULT '' COMMENT '拒绝退款理由',
  `exp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '获得的经验',
  `phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式',
  `region` varchar(255) NOT NULL DEFAULT '' COMMENT '地址(省市区)',
  `module` varchar(255) DEFAULT NULL COMMENT '用户支付回调验证(废弃)',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `express_number` varchar(20) NOT NULL DEFAULT '' COMMENT '快递单号',
  `express_name` varchar(255) NOT NULL DEFAULT '' COMMENT '快递公司名称',
  `remind` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提醒发货',
  `formid` varchar(255) NOT NULL DEFAULT '' COMMENT '表单id用于发送模板消息',
  `express_code` varchar(50) NOT NULL DEFAULT '' COMMENT '快递公司编码',
  `value` text NOT NULL COMMENT '信息',
  `group_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '团购状态 1组团中 2组团成功 -1组团失败',
  `out_refund_no` varchar(100) NOT NULL DEFAULT '' COMMENT '商户退款单号',
  `vendor_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '卖家备注',
  `out_refund_time` datetime DEFAULT NULL COMMENT '退款成功时间',
  `refund_error_msg` varchar(255) NOT NULL DEFAULT '' COMMENT '退款错误回调信息',
  `community_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团点优惠',
  `community_brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '社区团佣金',
  `club_id` int(11) NOT NULL DEFAULT '0' COMMENT '团长id',
  `hex` varchar(50) NOT NULL DEFAULT '' COMMENT '核销码',
  `hex_time` datetime DEFAULT NULL COMMENT '核销时间',
  `is_community` tinyint(3) NOT NULL DEFAULT '0' COMMENT '社区团',
  `community_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '自提状态1待自提2已取货',
  `comment` tinyint(3) DEFAULT NULL COMMENT '评价',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '针对限购产品',
  `expires` int(11) NOT NULL DEFAULT '0' COMMENT '失效时间',
  `activityid` int(11) NOT NULL DEFAULT '0' COMMENT '活动id',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '主要针对 活动团购，限制抢购'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单列表' ROW_FORMAT=COMPACT;


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_other`
--

CREATE TABLE `ims_xc_xinguwu_other` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `contents` longtext COMMENT '内容',
  `keyval` varchar(20) NOT NULL DEFAULT '' COMMENT '关键字',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `modifytime` datetime DEFAULT NULL COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='杂项' ROW_FORMAT=COMPACT;


-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_recharge`
--

CREATE TABLE `ims_xc_xinguwu_recharge` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分',
  `exp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '经验',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1',
  `tid` varchar(255) NOT NULL DEFAULT '' COMMENT '单号',
  `payid` varchar(100) NOT NULL DEFAULT '' COMMENT '用于模板消息',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `paytime` datetime DEFAULT NULL COMMENT '支付时间',
  `cid` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1用户2管理员',
  `remark` text COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值记录';

--
-- 转存表中的数据 `ims_xc_xinguwu_recharge`
--

INSERT INTO `ims_xc_xinguwu_recharge` (`id`, `uniacid`, `openid`, `fee`, `score`, `exp`, `status`, `tid`, `payid`, `createtime`, `paytime`, `cid`, `remark`) VALUES
(1, 28, 'oQQwf5ckRy-0nuMJZdaKLUyyIrKQ', '200.00', '0.00', '0.00', 1, '', '', '2018-12-06 15:51:09', NULL, 1, NULL),
(2, 28, 'oQQwf5ckRy-0nuMJZdaKLUyyIrKQ', '9999.00', '0.00', '0.00', 2, '后台充值', '', '2019-02-20 09:34:26', '2019-02-20 17:34:26', 2, NULL),
(3, 28, 'oQQwf5UNtbYz44mnoiikkSoDh7UY', '9999.00', '0.00', '0.00', 2, '后台充值', '', '2019-02-20 09:36:20', '2019-02-20 17:36:20', 2, NULL),
(5, 42, 'oJ6_m5W9dsUuAxLg7Vd9_cHpGDcg', '1000.00', '0.00', '0.00', 2, '后台充值', '', '2019-05-08 08:09:20', '2019-05-08 16:09:20', 2, NULL),
(7, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', '1.50', '1.00', '0.00', 2, '11905237', 'wx201742236410195983577b9d3547971715', '2019-05-20 09:42:23', '2019-05-20 17:42:29', 1, NULL),
(8, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', '100888.00', '0.00', '0.00', 2, '后台充值', '', '2019-05-31 16:23:17', '2019-06-01 00:23:17', 2, NULL),
(9, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', '1.50', '1.00', '0.00', 2, '11902109', 'wx1314421084135971263cacca1788045900', '2019-06-13 06:42:10', '2019-06-13 14:42:15', 1, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_shop`
--

CREATE TABLE `ims_xc_xinguwu_shop` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) DEFAULT NULL COMMENT '商品名称',
  `img` varchar(255) DEFAULT NULL COMMENT '商品图片',
  `integral` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '所需积分',
  `inventory` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `recommend` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `hot` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否热门',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '商品状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `bag` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否包邮',
  `weight` int(11) DEFAULT NULL COMMENT '重量(g)',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '所需金额'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分兑换商品' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `ims_xc_xinguwu_shop`
--

INSERT INTO `ims_xc_xinguwu_shop` (`id`, `uniacid`, `name`, `img`, `integral`, `inventory`, `recommend`, `hot`, `status`, `createtime`, `bag`, `weight`, `price`) VALUES
(1, 28, '123', 'images/28/2018/12/VotCyOoNnpCT8p6c98TN6cZ9o9tk28.jpg', '5000.00', 999, 1, 1, 1, '2018-12-06 18:17:05', -1, 500, '0.00'),
(3, 42, 'PULL＆BEAR 春秋宽松慵懒长款洋气毛衣女新款 09559378', 'images/42/2019/04/f7466e7G6sHtGR55Z525672ZL4Qv5H.jpg', '1000.00', 99, 1, 1, 1, '2019-04-29 07:56:19', 1, 10, '30.00'),
(4, 42, 'PULL＆BEAR 女装2019新款潮宽松连帽长袖卫衣女春秋薄款 05590379', 'images/42/2019/04/TEwxy37Y79Gx9YXw7f9k3oXO8OZpe2.jpg', '1000.00', 99, 1, 1, 1, '2019-04-29 07:56:49', 1, 10, '30.00'),
(5, 42, '烟花烫夏装女2019新款时尚优雅宽松雪纺裙裤休闲裤阔腿裤 眉缓', 'images/42/2019/04/NcR4jrfj8It7RJiC4jZHbFWTTJ47t7.jpg', '1000.00', 999, 1, 1, 1, '2019-04-29 07:58:58', 1, 0, '65.00');

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_special`
--

CREATE TABLE `ims_xc_xinguwu_special` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '专题名称',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '展示图片',
  `about` varchar(255) NOT NULL DEFAULT '' COMMENT '摘要',
  `video_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '视频模式',
  `video` varchar(255) NOT NULL DEFAULT '' COMMENT '视频地址',
  `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `contents` longtext COMMENT '内容',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `modifytime` datetime DEFAULT NULL COMMENT '修改时间',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `ready` int(11) NOT NULL DEFAULT '0' COMMENT '阅读量',
  `like` int(11) NOT NULL DEFAULT '0' COMMENT '点赞量',
  `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示',
  `poster` varchar(255) NOT NULL DEFAULT '' COMMENT '视频封面',
  `ad_img` varchar(255) NOT NULL DEFAULT '' COMMENT '广告图片',
  `ad_link` varchar(255) NOT NULL DEFAULT '' COMMENT '广告跳转地址',
  `recom` varchar(255) NOT NULL DEFAULT '' COMMENT '推荐商品'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='专题';

--
-- 转存表中的数据 `ims_xc_xinguwu_special`
--

INSERT INTO `ims_xc_xinguwu_special` (`id`, `uniacid`, `name`, `img`, `about`, `video_type`, `video`, `sorts`, `status`, `contents`, `createtime`, `modifytime`, `cid`, `ready`, `like`, `isindex`, `poster`, `ad_img`, `ad_link`, `recom`) VALUES
(1, 28, '牛肉全部使用顺丰快递邮寄24内到达', 'images/28/2018/12/o9LSIV59SVZU6l9R8Yl8249Y5o49WD.jpg', '', -1, '', 0, 1, '&lt;p&gt;&lt;img src=&quot;https://www.wulitan.com/attachment/images/28/2018/12/n24iemmwTklm91tmMKWVHvh1L2D8im.jpg&quot; width=&quot;100%&quot; alt=&quot;TB2Wy8LdAfb_uJkSmLyXXcxoXXa_!!2501758866.jpg&quot;/&gt;&lt;img src=&quot;https://www.wulitan.com/attachment/images/28/2018/12/OpPnu5XzS9IXIiIbO5B0anAxBD39R5.jpg&quot; width=&quot;100%&quot; alt=&quot;TB2BiRBjYtlpuFjSspfXXXLUpXa_!!2501758866.jpg&quot;/&gt;&lt;/p&gt;', '2018-12-06 16:55:16', '2018-12-07 15:01:30', 1, 37, 1, 1, '', '', '', '[{\"id\":\"1\",\"cid\":\"1\"},{\"id\":\"3\",\"cid\":\"1\"},{\"id\":\"4\",\"cid\":\"1\"},{\"id\":\"2\",\"cid\":\"1\"}]'),
(2, 42, '2019夏装新款时尚圆领百搭显瘦气质短袖笑脸字母印花t恤女上衣', 'images/42/2019/04/f7466e7G6sHtGR55Z525672ZL4Qv5H.jpg', 'PULL＆BEAR 春秋宽松慵懒长款洋气毛衣女新款 09559378', -1, '', 0, 1, '&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/ApoGGmRGB2QyCQzoQm3EgQvQcrvuQU.jpg&quot; alt=&quot;2.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/NjCcCThMJZq6cZCKSH6k4CqiiCJ9ih.jpg&quot; alt=&quot;4.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/f7466e7G6sHtGR55Z525672ZL4Qv5H.jpg&quot; alt=&quot;3.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/L8q36PJj38383TZa7TBSkJ3tKZ7P88.jpg&quot; alt=&quot;1.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '2019-04-25 08:23:52', '2019-04-29 16:08:00', 2, 25, 3, 1, 'images/42/2019/04/f7466e7G6sHtGR55Z525672ZL4Qv5H.jpg', 'images/42/2019/04/bJZsinjIPPJ71JgZNZjsDdp7SkJ4Jk.png', '/xc_xinguwu/live/liveList/liveList', '[{\"id\":\"11\",\"cid\":\"1\"},{\"id\":\"10\",\"cid\":\"1\"}]'),
(3, 42, '烟花烫夏装女2019新款时尚优雅宽松雪纺裙裤休闲裤阔腿裤 眉缓', 'images/42/2019/04/NcR4jrfj8It7RJiC4jZHbFWTTJ47t7.jpg', '烟花烫夏装女2019新款时尚优雅宽松雪纺裙裤休闲裤阔腿裤 眉缓', -1, '', 0, 1, '&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/NcR4jrfj8It7RJiC4jZHbFWTTJ47t7.jpg&quot; alt=&quot;3.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/IzjeVXoiPOvpqI6IzQcL7ilq7ci5Ix.jpg&quot; alt=&quot;4.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/gEGWzk01WWqKF60Qrrj4DlaJK0fDJ1.jpg&quot; alt=&quot;2.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/wE89cRn8vM4CDLi4d8rF9NdCcCrDhF.jpg&quot; alt=&quot;5.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/mGmKnIu07MUiV936mIiwZn8UUNkNVA.jpg&quot; alt=&quot;1.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/beW5yyzfMq55006F6Yir5iYx0WrBIR.jpg&quot; alt=&quot;55.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '2019-04-29 08:13:20', NULL, 2, 22, 1, 1, 'images/42/2019/04/NcR4jrfj8It7RJiC4jZHbFWTTJ47t7.jpg', 'images/42/2019/04/bJZsinjIPPJ71JgZNZjsDdp7SkJ4Jk.png', '/xc_xinguwu/live/liveList/liveList', '[{\"id\":\"9\",\"cid\":\"1\"},{\"id\":\"8\",\"cid\":\"1\"},{\"id\":\"7\",\"cid\":\"1\"},{\"id\":\"5\",\"cid\":\"1\"}]'),
(4, 42, '烟花烫2019新款女裙子棉时尚气质修身简约七分袖大摆连衣裙 荧玉', 'images/42/2019/04/rBJxVmX898M8jXXMo69POixmbMjxIB.jpg', '烟花烫2019新款女裙子棉时尚气质修身简约七分袖大摆连衣裙 荧玉', -1, '', 0, 1, '&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/n2lL88vljbp2QIvPMj22B2OM5QWU2j.jpg&quot; alt=&quot;4.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/ouGY2tVUy1ccUg8gT8VpG5R5u5HTUV.jpg&quot; alt=&quot;3.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/o98O9qeb75B955k8eAwEk8eaOZegop.jpg&quot; alt=&quot;5.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/rBJxVmX898M8jXXMo69POixmbMjxIB.jpg&quot; alt=&quot;2.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/L90QrDa14FIanZ4C44IbRVADID293c.jpg&quot; alt=&quot;1.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/qp5IfE5IY56fKIISy5L22y6W52QF5W.jpg&quot; alt=&quot;55.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '2019-04-29 08:14:58', '2019-06-14 14:45:54', 0, 14, 1, 1, 'images/42/2019/04/rBJxVmX898M8jXXMo69POixmbMjxIB.jpg', 'images/42/2019/05/XJUwPSTxwBsudmUnmJpTXmZ812mwO2.jpg', '/xc_xinguwu/live/liveList/liveList', '[{\"id\":\"5\",\"cid\":\"1\"},{\"id\":\"7\",\"cid\":\"1\"},{\"id\":\"8\",\"cid\":\"1\"},{\"id\":\"9\",\"cid\":\"1\"},{\"id\":\"94\",\"cid\":\"1\"},{\"id\":\"93\",\"cid\":\"1\"},{\"id\":\"82\",\"cid\":\"1\"},{\"id\":\"81\",\"cid\":\"1\"}]');

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_specialclass`
--

CREATE TABLE `ims_xc_xinguwu_specialclass` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '专题名称',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='专题分类';

--
-- 转存表中的数据 `ims_xc_xinguwu_specialclass`
--

INSERT INTO `ims_xc_xinguwu_specialclass` (`id`, `uniacid`, `name`, `status`, `sorts`, `createtime`) VALUES
(1, 28, '物流配送', 1, 0, '2018-12-06 17:14:14');

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_special_like`
--

CREATE TABLE `ims_xc_xinguwu_special_like` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `special_id` int(11) NOT NULL DEFAULT '0' COMMENT '专题id',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1已点赞 -1 已取消点赞'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='专题点赞';

--
-- 转存表中的数据 `ims_xc_xinguwu_special_like`
--

INSERT INTO `ims_xc_xinguwu_special_like` (`id`, `uniacid`, `openid`, `special_id`, `createtime`, `status`) VALUES
(1, 28, 'oQQwf5ckRy-0nuMJZdaKLUyyIrKQ', 1, '2018-12-06 16:56:45', 1),
(2, 42, 'oJ6_m5ZuwyDBxip_sTElMhnlBBj8', 2, '2019-04-28 12:59:41', 1),
(3, 42, 'oJ6_m5bFn1k1f1Ksy4M8oOaARlxg', 2, '2019-04-29 08:08:34', 1),
(4, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', 2, '2019-04-29 08:26:24', 1),
(5, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', 3, '2019-05-18 07:51:42', 1),
(6, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', 4, '2019-05-18 07:51:54', 1);

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_sport_chall`
--

CREATE TABLE `ims_xc_xinguwu_sport_chall` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `step` int(11) NOT NULL DEFAULT '0' COMMENT '步数',
  `ticket` int(11) NOT NULL DEFAULT '0' COMMENT '门票',
  `award` int(11) NOT NULL DEFAULT '0' COMMENT '奖励',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `modifytime` datetime DEFAULT NULL COMMENT '修改日志',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `join_num` int(11) NOT NULL DEFAULT '0' COMMENT '参加人数',
  `finish_num` int(11) DEFAULT '0' COMMENT '完成人数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='步数宝活动';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_sport_chall_log`
--

CREATE TABLE `ims_xc_xinguwu_sport_chall_log` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `chall_id` int(11) NOT NULL DEFAULT '0' COMMENT '挑战项目id',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1进行中2已提交3超时',
  `submission_time` datetime DEFAULT NULL COMMENT '提交时间',
  `value` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='挑战记录';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_sport_coin_log`
--

CREATE TABLE `ims_xc_xinguwu_sport_coin_log` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '改变数值',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='动力币记录';

--
-- 转存表中的数据 `ims_xc_xinguwu_sport_coin_log`
--

INSERT INTO `ims_xc_xinguwu_sport_coin_log` (`id`, `uniacid`, `openid`, `createtime`, `fee`, `title`, `remark`) VALUES
(1, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', '2019-05-07 04:27:55', '24.00', '使用2418步兑换', 'step_log_id:1;当前汇率:100');

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_sport_friend`
--

CREATE TABLE `ims_xc_xinguwu_sport_friend` (
  `id` int(11) NOT NULL,
  `openid` varchar(40) DEFAULT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `avatarurl` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='运动好友列表';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_sport_good`
--

CREATE TABLE `ims_xc_xinguwu_sport_good` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `imgs` text COMMENT '图集',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '动力币',
  `o_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'price',
  `cashed` int(11) NOT NULL DEFAULT '0' COMMENT '已兑数量',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '取货模式 1快递2自提',
  `contents` longtext COMMENT '内容',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `modifytime` datetime DEFAULT NULL COMMENT '修改日志',
  `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='步数宝商品列表';

--
-- 转存表中的数据 `ims_xc_xinguwu_sport_good`
--

INSERT INTO `ims_xc_xinguwu_sport_good` (`id`, `uniacid`, `name`, `img`, `imgs`, `coin`, `o_price`, `price`, `cashed`, `stock`, `type`, `contents`, `createtime`, `status`, `modifytime`, `sorts`, `isindex`) VALUES
(1, 42, 'PULL＆BEAR 春秋宽松慵懒长款洋气毛衣女新款 09559378', 'images/42/2019/04/f7466e7G6sHtGR55Z525672ZL4Qv5H.jpg', '[\"images\\/42\\/2019\\/04\\/ApoGGmRGB2QyCQzoQm3EgQvQcrvuQU.jpg\",\"images\\/42\\/2019\\/04\\/NjCcCThMJZq6cZCKSH6k4CqiiCJ9ih.jpg\",\"images\\/42\\/2019\\/04\\/f7466e7G6sHtGR55Z525672ZL4Qv5H.jpg\",\"images\\/42\\/2019\\/04\\/L8q36PJj38383TZa7TBSkJ3tKZ7P88.jpg\"]', 1000, '68.00', '0.00', 251, 999, 1, '&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/ApoGGmRGB2QyCQzoQm3EgQvQcrvuQU.jpg&quot; alt=&quot;2.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/NjCcCThMJZq6cZCKSH6k4CqiiCJ9ih.jpg&quot; alt=&quot;4.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/f7466e7G6sHtGR55Z525672ZL4Qv5H.jpg&quot; alt=&quot;3.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://zbwq7.oss-cn-shenzhen.aliyuncs.com/images/42/2019/04/L8q36PJj38383TZa7TBSkJ3tKZ7P88.jpg&quot; alt=&quot;1.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '2019-04-29 08:22:59', 1, '2019-05-03 17:53:26', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_sport_order`
--

CREATE TABLE `ims_xc_xinguwu_sport_order` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `order` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `list` text NOT NULL COMMENT '商品信息',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '动力币',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态1待发货2已发货3已完成4待核销',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '模式1快递2自提',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系方式',
  `region` varchar(255) NOT NULL DEFAULT '',
  `detail` varchar(255) NOT NULL DEFAULT '',
  `sport_good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `sure_time` datetime DEFAULT NULL COMMENT '确认时间',
  `deliver_time` datetime DEFAULT NULL COMMENT '发货时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='步数宝兑换订单';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_sport_step_log`
--

CREATE TABLE `ims_xc_xinguwu_sport_step_log` (
  `id` int(11) NOT NULL,
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '步数',
  `date` date DEFAULT NULL COMMENT '日期',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  `uniacid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='步数记录';

--
-- 转存表中的数据 `ims_xc_xinguwu_sport_step_log`
--

INSERT INTO `ims_xc_xinguwu_sport_step_log` (`id`, `openid`, `num`, `date`, `createtime`, `uniacid`) VALUES
(1, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', 2418, '2019-05-07', '2019-05-07 04:27:55', 42);

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_supplier`
--

CREATE TABLE `ims_xc_xinguwu_supplier` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '联系方式',
  `wechat` varchar(100) NOT NULL DEFAULT '' COMMENT '微信号',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `apply` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1正常2申请3不通过',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `apply_time` varchar(50) NOT NULL DEFAULT '' COMMENT '审核时间',
  `formid` text COMMENT '模版消息id',
  `remark` text COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='供应商';

--
-- 转存表中的数据 `ims_xc_xinguwu_supplier`
--

INSERT INTO `ims_xc_xinguwu_supplier` (`id`, `uniacid`, `openid`, `name`, `phone`, `wechat`, `status`, `apply`, `createtime`, `apply_time`, `formid`, `remark`) VALUES
(1, 42, 'oJ6_m5bFn1k1f1Ksy4M8oOaARlxg', '彭惜徐', '15018811011', '15018811011', 1, 1, '2019-04-30 07:21:53', '2019-04-30 15:22:07', NULL, NULL),
(2, 42, 'oJ6_m5bdSWs1PMfEvPhO6QQhEw70', '黄国德', '18664830801', 'cocore', 1, 1, '2019-05-04 05:54:44', '2019-05-04 13:54:55', NULL, NULL),
(3, 42, 'oJ6_m5eWfF4bAnlI_SSVqV7vodt4', '倪彪', '15115066776', '15115066776', 1, 1, '2019-05-05 06:49:11', '2019-05-06 22:34:35', NULL, NULL),
(4, 42, 'oJ6_m5ZuwyDBxip_sTElMhnlBBj8', '黄国祥', '18600409233', '18600409233', 1, 1, '2019-05-07 03:46:28', '2019-05-18 14:37:01', NULL, NULL),
(5, 42, 'oJ6_m5ZAbHl7pxTm1oFcgN4PErQc', '黄渤', '18814112814', 'huangshangabcd', 1, 1, '2019-05-20 04:03:34', '2019-05-20 12:03:51', NULL, NULL),
(6, 42, 'oJ6_m5S0_rro_RgVrsSDR7lc-aB8', '刘光敏', '13928741105', '13928741105', 1, 1, '2019-05-23 11:17:12', '2019-05-24 16:50:57', NULL, NULL),
(7, 42, 'oJ6_m5aiBgaahprv7WE70z2PvPRM', '万晓然', '13312839400', '13312839400', 1, 1, '2019-05-30 06:17:48', '2019-05-30 14:18:05', NULL, NULL),
(8, 42, 'oJ6_m5WshqDzScdx-k3-b810ybuU', '郭', '15989020039', 'oiminkwok', 1, 1, '2019-06-12 05:21:49', '2019-06-15 17:08:03', 'f035ce6bb19f4739aa560148d60e6314', ''),
(9, 42, 'oJ6_m5Z3ycJsbKEUgPwqHZpnOEpc', '曾玉荣', '13692550696', '13692550696', 1, 1, '2019-06-15 11:20:37', '2019-06-15 19:47:14', 'cf1c36b5a4a64e6c9c4de732ea9b01cf', ''),
(10, 42, 'oJ6_m5Wq0Sih__zf0wqQIR3wRUbQ', '花花', '18968579850', 'tzxcwl001', 1, 1, '2019-06-22 03:14:20', '2019-06-22 11:14:34', '3f5b36295fdc47c5a53a6829455cd503', '');

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_supplier_order`
--

CREATE TABLE `ims_xc_xinguwu_supplier_order` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `list` longtext COMMENT '订单内容',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `deliver_time` varchar(50) NOT NULL DEFAULT '' COMMENT '发货时间',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注信息',
  `settlement_time` varchar(50) NOT NULL DEFAULT '' COMMENT '结算时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='供应商订单';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_supplier_staff`
--

CREATE TABLE `ims_xc_xinguwu_supplier_staff` (
  `id` int(11) NOT NULL,
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商id',
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '员工名称',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '员工号码',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态 1 正常 2 申请中',
  `uniacid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='供应商员工';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_supplier_statistics`
--

CREATE TABLE `ims_xc_xinguwu_supplier_statistics` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '用户标识',
  `good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `attrs` text COMMENT '属性内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='供应商销售统计';

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_vip`
--

CREATE TABLE `ims_xc_xinguwu_vip` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(20) DEFAULT NULL COMMENT '名称',
  `ex` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '升级经验',
  `discount` decimal(10,2) NOT NULL DEFAULT '10.00' COMMENT '折扣',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建',
  `modifytime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  `color` varchar(10) NOT NULL DEFAULT '',
  `colorend` varchar(10) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员等级配置';

--
-- 转存表中的数据 `ims_xc_xinguwu_vip`
--

INSERT INTO `ims_xc_xinguwu_vip` (`id`, `uniacid`, `name`, `ex`, `discount`, `status`, `createtime`, `modifytime`, `icon`, `color`, `colorend`) VALUES
(1, 42, '普通会员', '0.00', '100.00', 1, '2019-04-29 08:21:33', '0000-00-00 00:00:00', 'images/42/2019/04/ceVFxEF1lwZUV71XEv7E1nl3uhwEvn.png', '#434343', '#434343'),
(2, 42, '高级会员', '10000.00', '95.00', 1, '2019-05-04 07:09:34', '0000-00-00 00:00:00', 'images/42/2019/04/ceVFxEF1lwZUV71XEv7E1nl3uhwEvn.png', '#666666', '#434343'),
(3, 42, '超级会员', '30000.00', '88.00', 1, '2019-05-04 07:10:20', '0000-00-00 00:00:00', 'images/42/2019/04/ceVFxEF1lwZUV71XEv7E1nl3uhwEvn.png', '#434343', '#434343');

-- --------------------------------------------------------

--
-- 表的结构 `ims_xc_xinguwu_voucher`
--

CREATE TABLE `ims_xc_xinguwu_voucher` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '卡券类别1满减2抵用3折扣',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `discount` decimal(2,1) NOT NULL DEFAULT '0.0' COMMENT '折扣',
  `replace` int(11) NOT NULL DEFAULT '0' COMMENT '抵用',
  `reduce` int(11) NOT NULL DEFAULT '0' COMMENT '减免',
  `full` int(11) NOT NULL DEFAULT '0' COMMENT '满',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `numlimit` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否数量限制(-1不限制;1限制)',
  `modifytime` datetime DEFAULT NULL COMMENT '修改时间',
  `date_start` date NOT NULL DEFAULT '0000-00-00' COMMENT '开始时间',
  `date_end` date NOT NULL DEFAULT '0000-00-00' COMMENT '结束时间',
  `explain` varchar(255) NOT NULL DEFAULT '' COMMENT '使用说明',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '卡券名称',
  `open` tinyint(3) NOT NULL DEFAULT '1' COMMENT '公开发行'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='卡券列表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `ims_xc_xinguwu_voucher`
--

INSERT INTO `ims_xc_xinguwu_voucher` (`id`, `uniacid`, `cid`, `num`, `createtime`, `discount`, `replace`, `reduce`, `full`, `status`, `numlimit`, `modifytime`, `date_start`, `date_end`, `explain`, `name`, `open`) VALUES
(1, 28, 1, 0, '2018-12-06 18:01:12', '0.0', 0, 5, 100, 1, -1, '2019-02-25 12:31:45', '2018-12-01', '2019-03-01', '1', '', 1),
(2, 28, 1, 0, '2018-12-06 18:02:06', '0.0', 0, 20, 300, 1, -1, '2019-02-25 12:31:54', '2018-12-01', '2019-03-01', '1', '', 1),
(7, 42, 3, 0, '2019-06-13 03:01:34', '9.9', 0, 0, 0, 1, -1, NULL, '2019-06-13', '2020-01-30', '', '10元折扣券', 1),
(8, 42, 2, 0, '2019-06-13 03:02:21', '0.0', 10, 0, 0, 1, -1, NULL, '2019-06-13', '2019-12-27', '', '50元抵用券', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ims_xc_xinguwu_address`
--
ALTER TABLE `ims_xc_xinguwu_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_autonum`
--
ALTER TABLE `ims_xc_xinguwu_autonum`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniacid` (`uniacid`,`keyval`);

--
-- Indexes for table `ims_xc_xinguwu_bargain`
--
ALTER TABLE `ims_xc_xinguwu_bargain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_bargain_self`
--
ALTER TABLE `ims_xc_xinguwu_bargain_self`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28),`bargain_id`);

--
-- Indexes for table `ims_xc_xinguwu_bargain_self_log`
--
ALTER TABLE `ims_xc_xinguwu_bargain_self_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bargain_self_id` (`bargain_self_id`);

--
-- Indexes for table `ims_xc_xinguwu_brokerage_order`
--
ALTER TABLE `ims_xc_xinguwu_brokerage_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28)),
  ADD KEY `order` (`order`);

--
-- Indexes for table `ims_xc_xinguwu_category`
--
ALTER TABLE `ims_xc_xinguwu_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_club`
--
ALTER TABLE `ims_xc_xinguwu_club`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_club_brokerage`
--
ALTER TABLE `ims_xc_xinguwu_club_brokerage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_club_label`
--
ALTER TABLE `ims_xc_xinguwu_club_label`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_club_member`
--
ALTER TABLE `ims_xc_xinguwu_club_member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_id` (`club_id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_club_statistics`
--
ALTER TABLE `ims_xc_xinguwu_club_statistics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_id` (`club_id`,`date`);

--
-- Indexes for table `ims_xc_xinguwu_club_statistics_day`
--
ALTER TABLE `ims_xc_xinguwu_club_statistics_day`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_id` (`club_id`,`date`);

--
-- Indexes for table `ims_xc_xinguwu_club_statistics_month`
--
ALTER TABLE `ims_xc_xinguwu_club_statistics_month`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_id` (`club_id`,`date`);

--
-- Indexes for table `ims_xc_xinguwu_club_statistics_total`
--
ALTER TABLE `ims_xc_xinguwu_club_statistics_total`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `ims_xc_xinguwu_club_statistics_week`
--
ALTER TABLE `ims_xc_xinguwu_club_statistics_week`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_id` (`club_id`,`date`);

--
-- Indexes for table `ims_xc_xinguwu_comment`
--
ALTER TABLE `ims_xc_xinguwu_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_deposit_log`
--
ALTER TABLE `ims_xc_xinguwu_deposit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_distribution`
--
ALTER TABLE `ims_xc_xinguwu_distribution`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_feature`
--
ALTER TABLE `ims_xc_xinguwu_feature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_flashsale`
--
ALTER TABLE `ims_xc_xinguwu_flashsale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date_start` (`date_start`,`date_end`);

--
-- Indexes for table `ims_xc_xinguwu_goods`
--
ALTER TABLE `ims_xc_xinguwu_goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_groupbuy`
--
ALTER TABLE `ims_xc_xinguwu_groupbuy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `good_id` (`good_id`);

--
-- Indexes for table `ims_xc_xinguwu_group_order`
--
ALTER TABLE `ims_xc_xinguwu_group_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28),`order`),
  ADD KEY `order` (`order`);

--
-- Indexes for table `ims_xc_xinguwu_group_sponsor`
--
ALTER TABLE `ims_xc_xinguwu_group_sponsor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28)),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `ims_xc_xinguwu_group_tuxedo`
--
ALTER TABLE `ims_xc_xinguwu_group_tuxedo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28)),
  ADD KEY `group_sponsor_id` (`group_sponsor_id`);

--
-- Indexes for table `ims_xc_xinguwu_label`
--
ALTER TABLE `ims_xc_xinguwu_label`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `ims_xc_xinguwu_labelclass`
--
ALTER TABLE `ims_xc_xinguwu_labelclass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_live`
--
ALTER TABLE `ims_xc_xinguwu_live`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_live_dialog`
--
ALTER TABLE `ims_xc_xinguwu_live_dialog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_live_dynamic`
--
ALTER TABLE `ims_xc_xinguwu_live_dynamic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `live_id` (`live_id`);

--
-- Indexes for table `ims_xc_xinguwu_live_focus`
--
ALTER TABLE `ims_xc_xinguwu_live_focus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`),
  ADD KEY `live_id` (`live_id`);

--
-- Indexes for table `ims_xc_xinguwu_live_playback`
--
ALTER TABLE `ims_xc_xinguwu_live_playback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_member`
--
ALTER TABLE `ims_xc_xinguwu_member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_member_amount_log`
--
ALTER TABLE `ims_xc_xinguwu_member_amount_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_member_exp_log`
--
ALTER TABLE `ims_xc_xinguwu_member_exp_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_member_score_log`
--
ALTER TABLE `ims_xc_xinguwu_member_score_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_moban_user`
--
ALTER TABLE `ims_xc_xinguwu_moban_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_mycard`
--
ALTER TABLE `ims_xc_xinguwu_mycard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28),`voucherid`);

--
-- Indexes for table `ims_xc_xinguwu_online`
--
ALTER TABLE `ims_xc_xinguwu_online`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`createtime`,`member`);

--
-- Indexes for table `ims_xc_xinguwu_online_log`
--
ALTER TABLE `ims_xc_xinguwu_online_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`type`,`createtime`);

--
-- Indexes for table `ims_xc_xinguwu_order`
--
ALTER TABLE `ims_xc_xinguwu_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28),`order`),
  ADD KEY `order` (`order`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `ims_xc_xinguwu_other`
--
ALTER TABLE `ims_xc_xinguwu_other`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_recharge`
--
ALTER TABLE `ims_xc_xinguwu_recharge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_shop`
--
ALTER TABLE `ims_xc_xinguwu_shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_special`
--
ALTER TABLE `ims_xc_xinguwu_special`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `ims_xc_xinguwu_specialclass`
--
ALTER TABLE `ims_xc_xinguwu_specialclass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_special_like`
--
ALTER TABLE `ims_xc_xinguwu_special_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28),`special_id`);

--
-- Indexes for table `ims_xc_xinguwu_sport_chall`
--
ALTER TABLE `ims_xc_xinguwu_sport_chall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_sport_chall_log`
--
ALTER TABLE `ims_xc_xinguwu_sport_chall_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chall_id` (`chall_id`);

--
-- Indexes for table `ims_xc_xinguwu_sport_coin_log`
--
ALTER TABLE `ims_xc_xinguwu_sport_coin_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_sport_friend`
--
ALTER TABLE `ims_xc_xinguwu_sport_friend`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`(28));

--
-- Indexes for table `ims_xc_xinguwu_sport_good`
--
ALTER TABLE `ims_xc_xinguwu_sport_good`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_sport_order`
--
ALTER TABLE `ims_xc_xinguwu_sport_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_sport_step_log`
--
ALTER TABLE `ims_xc_xinguwu_sport_step_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_supplier`
--
ALTER TABLE `ims_xc_xinguwu_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_supplier_order`
--
ALTER TABLE `ims_xc_xinguwu_supplier_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_supplier_staff`
--
ALTER TABLE `ims_xc_xinguwu_supplier_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_supplier_statistics`
--
ALTER TABLE `ims_xc_xinguwu_supplier_statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_vip`
--
ALTER TABLE `ims_xc_xinguwu_vip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_xc_xinguwu_voucher`
--
ALTER TABLE `ims_xc_xinguwu_voucher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date_end` (`date_end`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_address`
--
ALTER TABLE `ims_xc_xinguwu_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_autonum`
--
ALTER TABLE `ims_xc_xinguwu_autonum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_bargain`
--
ALTER TABLE `ims_xc_xinguwu_bargain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_bargain_self`
--
ALTER TABLE `ims_xc_xinguwu_bargain_self`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_bargain_self_log`
--
ALTER TABLE `ims_xc_xinguwu_bargain_self_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_brokerage_order`
--
ALTER TABLE `ims_xc_xinguwu_brokerage_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_category`
--
ALTER TABLE `ims_xc_xinguwu_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_club`
--
ALTER TABLE `ims_xc_xinguwu_club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_club_brokerage`
--
ALTER TABLE `ims_xc_xinguwu_club_brokerage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_club_label`
--
ALTER TABLE `ims_xc_xinguwu_club_label`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_club_member`
--
ALTER TABLE `ims_xc_xinguwu_club_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_club_statistics`
--
ALTER TABLE `ims_xc_xinguwu_club_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_club_statistics_day`
--
ALTER TABLE `ims_xc_xinguwu_club_statistics_day`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_club_statistics_month`
--
ALTER TABLE `ims_xc_xinguwu_club_statistics_month`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_club_statistics_total`
--
ALTER TABLE `ims_xc_xinguwu_club_statistics_total`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_club_statistics_week`
--
ALTER TABLE `ims_xc_xinguwu_club_statistics_week`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_comment`
--
ALTER TABLE `ims_xc_xinguwu_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_deposit_log`
--
ALTER TABLE `ims_xc_xinguwu_deposit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_distribution`
--
ALTER TABLE `ims_xc_xinguwu_distribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_feature`
--
ALTER TABLE `ims_xc_xinguwu_feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_flashsale`
--
ALTER TABLE `ims_xc_xinguwu_flashsale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_goods`
--
ALTER TABLE `ims_xc_xinguwu_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_groupbuy`
--
ALTER TABLE `ims_xc_xinguwu_groupbuy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_group_order`
--
ALTER TABLE `ims_xc_xinguwu_group_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_group_sponsor`
--
ALTER TABLE `ims_xc_xinguwu_group_sponsor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_group_tuxedo`
--
ALTER TABLE `ims_xc_xinguwu_group_tuxedo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_label`
--
ALTER TABLE `ims_xc_xinguwu_label`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_labelclass`
--
ALTER TABLE `ims_xc_xinguwu_labelclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_live`
--
ALTER TABLE `ims_xc_xinguwu_live`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_live_dialog`
--
ALTER TABLE `ims_xc_xinguwu_live_dialog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=369;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_live_dynamic`
--
ALTER TABLE `ims_xc_xinguwu_live_dynamic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_live_focus`
--
ALTER TABLE `ims_xc_xinguwu_live_focus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_live_playback`
--
ALTER TABLE `ims_xc_xinguwu_live_playback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_member`
--
ALTER TABLE `ims_xc_xinguwu_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_member_amount_log`
--
ALTER TABLE `ims_xc_xinguwu_member_amount_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_member_exp_log`
--
ALTER TABLE `ims_xc_xinguwu_member_exp_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_member_score_log`
--
ALTER TABLE `ims_xc_xinguwu_member_score_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_moban_user`
--
ALTER TABLE `ims_xc_xinguwu_moban_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_mycard`
--
ALTER TABLE `ims_xc_xinguwu_mycard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_online`
--
ALTER TABLE `ims_xc_xinguwu_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_online_log`
--
ALTER TABLE `ims_xc_xinguwu_online_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_order`
--
ALTER TABLE `ims_xc_xinguwu_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_other`
--
ALTER TABLE `ims_xc_xinguwu_other`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_recharge`
--
ALTER TABLE `ims_xc_xinguwu_recharge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_shop`
--
ALTER TABLE `ims_xc_xinguwu_shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_special`
--
ALTER TABLE `ims_xc_xinguwu_special`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_specialclass`
--
ALTER TABLE `ims_xc_xinguwu_specialclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_special_like`
--
ALTER TABLE `ims_xc_xinguwu_special_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_sport_chall`
--
ALTER TABLE `ims_xc_xinguwu_sport_chall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_sport_chall_log`
--
ALTER TABLE `ims_xc_xinguwu_sport_chall_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_sport_coin_log`
--
ALTER TABLE `ims_xc_xinguwu_sport_coin_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_sport_friend`
--
ALTER TABLE `ims_xc_xinguwu_sport_friend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_sport_good`
--
ALTER TABLE `ims_xc_xinguwu_sport_good`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_sport_order`
--
ALTER TABLE `ims_xc_xinguwu_sport_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_sport_step_log`
--
ALTER TABLE `ims_xc_xinguwu_sport_step_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_supplier`
--
ALTER TABLE `ims_xc_xinguwu_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_supplier_order`
--
ALTER TABLE `ims_xc_xinguwu_supplier_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_supplier_staff`
--
ALTER TABLE `ims_xc_xinguwu_supplier_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_supplier_statistics`
--
ALTER TABLE `ims_xc_xinguwu_supplier_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_vip`
--
ALTER TABLE `ims_xc_xinguwu_vip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `ims_xc_xinguwu_voucher`
--
ALTER TABLE `ims_xc_xinguwu_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
