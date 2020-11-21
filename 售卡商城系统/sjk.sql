-- MySQL dump 10.13  Distrib 5.5.62, for Linux (x86_64)
--
-- Host: localhost    Database: llk_7cf3_cn
-- ------------------------------------------------------
-- Server version	5.5.62-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `mao_data`
--

DROP TABLE IF EXISTS `mao_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mao_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Z_id` varchar(255) DEFAULT '1',
  `user` varchar(20) NOT NULL DEFAULT '',
  `pass` varchar(20) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `gd_gg` text,
  `qq` varchar(15) DEFAULT NULL COMMENT '客服QQ',
  `wx` varchar(20) DEFAULT NULL COMMENT '客服微信',
  `sj` varchar(15) DEFAULT NULL,
  `url` varchar(30) NOT NULL DEFAULT '' COMMENT '系统分发域名',
  `url_1` varchar(30) DEFAULT NULL COMMENT '备用域名',
  `time` varchar(30) NOT NULL DEFAULT '' COMMENT '网站到期时间',
  `dx_1` varchar(1) DEFAULT '1',
  `dx_2` varchar(255) DEFAULT '1',
  `dx_3` varchar(1) DEFAULT '1',
  `dx_4` varchar(1) DEFAULT '1',
  `yzf_type` varchar(1) DEFAULT '1' COMMENT '/0自定义/1系统支付/2码支付',
  `yzf_id` varchar(50) DEFAULT NULL,
  `yzf_key` varchar(100) DEFAULT NULL,
  `yzf_url` varchar(100) DEFAULT NULL,
  `zfb_zf` varchar(1) DEFAULT '0',
  `qq_zf` varchar(1) DEFAULT '0',
  `wx_zf` varchar(1) DEFAULT '0',
  `tx_zh` varchar(20) DEFAULT '' COMMENT '提现帐号',
  `tx_sm` varchar(10) DEFAULT NULL COMMENT '提现实名',
  `ym_id` varchar(20) DEFAULT NULL COMMENT '友盟',
  `mzf_id` varchar(20) DEFAULT NULL COMMENT '码支付id',
  `mzf_key` varchar(100) DEFAULT NULL COMMENT '码支付key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mao_data`
--

LOCK TABLES `mao_data` WRITE;
/*!40000 ALTER TABLE `mao_data` DISABLE KEYS */;
INSERT INTO `mao_data` VALUES (1,'1','admin','Gsgz9yckswPK6','售卡商城系统','猫咪流量卡商城','猫咪流量卡商城',99.98,'懒人源码 www.lanrenzhijia.com','8139306','gzs5320','18813240652','llk.7cf3.cn','','2099-07-25','1','1','1','1','0','0000','0000','https://0000/','0','0','1','911877625@qq.com','机器猫','1277743887','','');
/*!40000 ALTER TABLE `mao_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mao_dindan`
--

DROP TABLE IF EXISTS `mao_dindan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mao_dindan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `M_id` varchar(10) NOT NULL DEFAULT '',
  `M_sp` varchar(10) NOT NULL DEFAULT '',
  `ddh` varchar(50) NOT NULL DEFAULT '',
  `sjh` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `sl` varchar(10) NOT NULL DEFAULT '1',
  `dj_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `yf_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `time` varchar(50) NOT NULL DEFAULT '',
  `zt` varchar(1) NOT NULL DEFAULT '1' COMMENT '/1未处理/0已付款(待)/2已处理/',
  `xm` varchar(10) DEFAULT '' COMMENT '收件人',
  `dz` varchar(100) DEFAULT '' COMMENT '收件地址',
  `xxdz` varchar(100) DEFAULT '' COMMENT '详细地址',
  `ly` varchar(30) DEFAULT '',
  `jzxm` varchar(10) DEFAULT '' COMMENT '机主姓名',
  `sfzh` varchar(30) DEFAULT '' COMMENT '机主身份证号',
  `mgz` varchar(255) DEFAULT NULL COMMENT '免冠照',
  `sfz1` varchar(255) DEFAULT NULL COMMENT '身份证正面',
  `sfz2` varchar(255) DEFAULT NULL COMMENT '身份证反面',
  `kdgs` varchar(20) DEFAULT '' COMMENT '快递公司',
  `ydh` varchar(50) DEFAULT NULL COMMENT '运单号',
  `msg` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mao_dindan`
--

LOCK TABLES `mao_dindan` WRITE;
/*!40000 ALTER TABLE `mao_dindan` DISABLE KEYS */;
INSERT INTO `mao_dindan` VALUES (1,'1','2','20190725215436923','17608535320','【中国移动】移动金诚卡','1',0.50,6.00,6.50,'2019-07-25 21:54:35','1','','','','','','',NULL,NULL,NULL,'',NULL,NULL),(2,'1','3','20190726103117682','13164928402','【中国联通】联通超神卡','1',1.00,6.00,7.00,'2019-07-26 10:31:17','1','','','','','','',NULL,NULL,NULL,'',NULL,NULL);
/*!40000 ALTER TABLE `mao_dindan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mao_gd`
--

DROP TABLE IF EXISTS `mao_gd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mao_gd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `M_id` varchar(10) NOT NULL DEFAULT '',
  `users` varchar(50) NOT NULL DEFAULT '',
  `type` varchar(1) NOT NULL DEFAULT '',
  `ddh` varchar(50) DEFAULT NULL,
  `kh` varchar(50) DEFAULT NULL,
  `wt` text,
  `img` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `zt` varchar(1) DEFAULT NULL,
  `msg` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mao_gd`
--

LOCK TABLES `mao_gd` WRITE;
/*!40000 ALTER TABLE `mao_gd` DISABLE KEYS */;
/*!40000 ALTER TABLE `mao_gd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mao_shop`
--

DROP TABLE IF EXISTS `mao_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mao_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `M_id` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `img` varchar(255) DEFAULT NULL,
  `type` varchar(1) NOT NULL DEFAULT '' COMMENT '1电/2移/3联',
  `tj` varchar(1) NOT NULL DEFAULT '1' COMMENT '0推荐/1默认',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `yf_price` decimal(10,2) DEFAULT '0.00',
  `youhui_zhang` varchar(10) NOT NULL DEFAULT '0',
  `youhui_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `kucun` varchar(10) NOT NULL DEFAULT '0',
  `xiaoliang` varchar(10) NOT NULL DEFAULT '0',
  `beizhu` text,
  `xq` text,
  `slxd_zt` varchar(1) NOT NULL DEFAULT '1' COMMENT '数量下单/0开启/1关闭',
  `rwzl_zt` varchar(1) NOT NULL DEFAULT '1' COMMENT '0开启/1关闭',
  `dqpb` text COMMENT '地区屏蔽',
  `zt` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mao_shop`
--

LOCK TABLES `mao_shop` WRITE;
/*!40000 ALTER TABLE `mao_shop` DISABLE KEYS */;
INSERT INTO `mao_shop` VALUES (1,'1','【信速】【电信极速卡】','/upload/20190725214503592.jpg','1','0',1.00,6.00,'50',0.50,'1000','12',NULL,'<p><span><strong><span>【信速科技】电信极速卡，现货15万</span></strong></span></p><p><span><strong><span>非定向、动态IP、不锁设备、充值插卡即用、售后无忧！</span></strong></span></p><p><span><strong><span><br></span></strong></span></p><p><span><strong><span>公司直招一级代理，千起40%，顶返45%</span></strong></span></p><p><span><strong><span>欢迎有激活量或被其他公司套路过的代理跳槽</span></strong></span><span><strong><span></span></strong><strong><span></span></strong><strong><span></span></strong></span></p><p><strong><span><br></span></strong></p><p><strong><span>新手看价格，老手求质量，<span>勿拿定向池子卡的返利对比！</span>稳定才是王道，客户不流失。</span></strong></p><p><strong><span>电话微信同号。</span></strong></p>','0','0','','0'),(2,'1','移动金诚卡','/upload/20190725215027158.png','2','1',0.50,6.00,'0',0.50,'1000','23',NULL,'<h1 style=\"text-align: center;\">金诚卡全网招商</h1><p><span>政策：</span><span>比</span><span>拼市场无限量套餐 利润让步最大</span></p><p>&nbsp; &nbsp; &nbsp; -------------------------------------</p><p><span>&nbsp;&nbsp;<span>&nbsp;凡是在物联卡之家看到信息者</span></span><span>全部最低成本&nbsp;</span>&nbsp;<span>19.9出卡照样有利润 本公司实力大力扶持大小代理</span></p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;---------------------------------------------------------------------------------------------------</p><p><span>售后：</span><span>凡是代理我公司的卡</span><span>&nbsp;</span><span>永久售后</span>&nbsp;&nbsp;<span>公司1对1售后体系无需担心客户难题 您只需要负责出卡收钱 简单明了</span><span>&nbsp;</span></p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ----------------------------------------------------------------------------------------------------------</p><p><span>套餐：</span><span>此套餐为</span><span>15包无限量套餐 60G后限速3.1Mb</span>&nbsp;&nbsp;<span>套餐周期为30天 无时间套路</span></p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-------------------------------------------------------------------------------------</p><p><span>卡片属性：</span><span>无需繁琐设置APN&nbsp; 可随意换设备 操作简单 充值直接使用 免认证</span></p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-----------------------------------------------------------------</p><p><span>权限:&nbsp; &nbsp;&nbsp;</span><span>支持OEM对接 支持全网套餐定制&nbsp;</span></p>','1','1','','0'),(3,'1','联通超神卡','/upload/20190725215310806.jpg','3','1',1.00,6.00,'0',1.00,'1000','16',NULL,'<h1><strong><span>土豆3切卡板、实时返利、高返利，&nbsp;OEM可对接微信支付、分润秒结&nbsp;&nbsp;</span></strong><strong></strong></h1><h4><strong><span>&nbsp;</span></strong><strong></strong></h4><h1><p><span>&nbsp;</span></p><p><strong><span>（</span></strong><strong><span>新手看价格&nbsp;老手求质量&nbsp;流量卡赚钱是靠长久稳定&nbsp;不是拿货价多低&nbsp;返点多高</span></strong><strong><span>&nbsp;&nbsp;）</span></strong></p></h1><h2><strong><span>我们保证在维持正常运营情况下，最大让利，公司几十万张卡随时发货，可视频看货&nbsp;&nbsp;</span></strong><strong></strong></h2><h1><strong><span>我们承诺</span></strong><strong><span>死卡包换</span></strong><strong><span>&nbsp;&nbsp;</span></strong><strong><span>售后有保障</span></strong><strong><span>&nbsp;公司所有卡品一切</span></strong><strong><span>从稳定出发服务，无需担心</span></strong><strong></strong></h1><h1><strong><span>咨询者免费送卡测试，0风险</span></strong></h1>','1','1','','0');
/*!40000 ALTER TABLE `mao_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mao_tx`
--

DROP TABLE IF EXISTS `mao_tx`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mao_tx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `M_id` varchar(10) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `time` varchar(50) DEFAULT NULL,
  `zt` varchar(255) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mao_tx`
--

LOCK TABLES `mao_tx` WRITE;
/*!40000 ALTER TABLE `mao_tx` DISABLE KEYS */;
/*!40000 ALTER TABLE `mao_tx` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mao_user`
--

DROP TABLE IF EXISTS `mao_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mao_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `M_id` varchar(10) NOT NULL DEFAULT '',
  `users` varchar(50) NOT NULL DEFAULT '',
  `pass` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mao_user`
--

LOCK TABLES `mao_user` WRITE;
/*!40000 ALTER TABLE `mao_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `mao_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mao_wuliu`
--

DROP TABLE IF EXISTS `mao_wuliu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mao_wuliu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `M_id` varchar(10) NOT NULL DEFAULT '',
  `users` varchar(50) DEFAULT NULL,
  `ddh` varchar(50) DEFAULT NULL,
  `msg` text,
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mao_wuliu`
--

LOCK TABLES `mao_wuliu` WRITE;
/*!40000 ALTER TABLE `mao_wuliu` DISABLE KEYS */;
/*!40000 ALTER TABLE `mao_wuliu` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-26 11:46:29
