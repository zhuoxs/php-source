insert into `ims_wlmerchant_adv`(`id`,`uniacid`,`aid`,`advname`,`link`,`thumb`,`displayorder`,`enabled`) values
('1','37','1','幻灯片1','','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/YlkA1SLRrRzhJasa9fcsSK7NhNHNAH.jpg','0','1'),
('2','37','1','幻灯片2','','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/KJ3s4Gh4GDBbKkgjZN6HN66NKtn46A.jpg','0','1'),
('3','37','1','幻灯片3','','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/vCd1DdRDSZfVzPfVVvVd2N447h72zs.jpg','0','1');

insert into `ims_wlmerchant_agentusers`(`id`,`uniacid`,`groupid`,`agentname`,`username`,`password`,`salt`,`realname`,`mobile`,`status`,`joindate`,`joinip`,`lastvisit`,`lastip`,`remark`,`starttime`,`endtime`,`type`) values
('1','37','1','默认代理','demo','3e1eaccc625c34045b187088251ef829','lQi0i57f','微连科技','','1','1478939284','171.221.43.212','1479146809','110.184.29.240','','1478939284','1515859200','0');

insert into `ims_wlmerchant_agentusers_group`(`id`,`uniacid`,`name`,`package`,`isdefault`,`enabled`,`createtime`) values
('1','37','默认分组','','1','1','0');

insert into `ims_wlmerchant_banner`(`id`,`uniacid`,`aid`,`name`,`link`,`thumb`,`displayorder`,`enabled`,`visible_level`) values
('1','37','1','广告','','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/OCKlRGiNrl0ltniuz035FPuvNpGczu.png','0','1','');

insert into `ims_wlmerchant_category_store`(`id`,`uniacid`,`aid`,`name`,`thumb`,`parentid`,`isrecommand`,`description`,`displayorder`,`enabled`,`visible_level`) values
('1','37','1','美食','','0','0',null,'0','1','1'),
('2','37','1','火锅','','1','0',null,'0','1','2'),
('3','37','1','快餐','','1','0',null,'0','1','2'),
('4','37','1','休闲娱乐','','0','0',null,'0','1','1'),
('5','37','1','KTV','','4','0',null,'0','1','2'),
('6','37','1','运动健身','','4','0',null,'0','1','2'),
('7','37','1','自助餐','','1','0',null,'0','1','2'),
('8','37','1','酒店','','0','0',null,'0','1','1'),
('9','37','1','主题酒店','','8','0',null,'0','1','2');

insert into `ims_wlmerchant_goodshouse`(`id`,`uniacid`,`sid`,`aid`,`name`,`code`,`describe`,`detail`,`price`,`oldprice`,`vipprice`,`num`,`levelnum`,`endtime`,`follow`,`tag`,`share_title`,`share_image`,`share_desc`,`unit`,`thumb`,`thumbs`,`salenum`,`displayorder`,`stock`) values
('1','37','0','1','自助牛排海鲜','3','吉布鲁牛排●海鲜单人自助晚餐，限量供应：每人赠送一份生蚝和刺身','',0.00,99.00,0.00,null,null,null,null,'a:0:{}','','','','次','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/N5xe7eMjjxxtT1E0777fj0Je6jf4uJ.jpg','a:2:{i:0;s:52:"http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/B6x9AU8l6e9HX2ol3N233NE22w3apE.jpg";i:1;s:52:"http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/xbcc3oc3R54O4C4JYicc5K8zclWbOK.jpg";}',null,null,null);

insert into `ims_wlmerchant_indexset`(`id`,`uniacid`,`aid`,`key`,`value`) values
('1','37','1','cube','a:6:{i:0;a:3:{s:5:"thumb";s:52:"http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/oo9QgpgL9gtm9GpPA9a9rRhOOQzY63.png";s:4:"link";s:0:"";s:2:"on";i:1;}i:1;a:3:{s:5:"thumb";s:52:"http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/v4Vb5UuBygd4y79dK7yeV71d77BVqV.png";s:4:"link";s:0:"";s:2:"on";i:1;}i:2;a:3:{s:5:"thumb";s:52:"http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/Z772ah2PCWPo25H2P625Ol00632296.png";s:4:"link";s:0:"";s:2:"on";i:1;}i:3;a:3:{s:5:"thumb";s:52:"http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/IS0770JaDlK00rzz7ZaIuad7CDu7C0.png";s:4:"link";s:0:"";s:2:"on";i:1;}i:4;a:3:{s:5:"thumb";s:52:"http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/xm5jkOqLsLStmbBkT5IMsS7i5iSS3k.png";s:4:"link";s:0:"";s:2:"on";i:1;}i:5;a:3:{s:5:"thumb";s:0:"";s:4:"link";s:0:"";s:2:"on";i:0;}}');

insert into `ims_wlmerchant_merchantdata`(`id`,`uniacid`,`aid`,`provinceid`,`areaid`,`distid`,`storename`,`mobile`,`onelevel`,`twolevel`,`logo`,`introduction`,`address`,`location`,`realname`,`tel`,`enabled`,`status`,`groupid`,`storehours`,`endtime`,`createtime`,`remark`) values
('1','37','1','510000','510100','510104','吉布鲁海鲜牛排自助餐厅(百伦店)','02887128411','1','7','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/wTwtn8t22tA9tYKdKttFLT3TtA3osa.jpg','','百伦广场美食街2楼(热风楼上)','a:2:{s:3:"lng";s:10:"104.093616";s:3:"lat";s:9:"30.669431";}','','','1','2','1','a:2:{s:9:"startTime";s:5:"09:00";s:7:"endTime";s:5:"22:00";}','1510329600','1478846264',null),
('2','37','1','510000','510100','510105','小龙坎原味老火锅(鹏瑞利店)','18180567768','1','2','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/wkgL1LM1K3leDeMY2e1Zxxlz2Me2L2.jpg','','光华北三路55号鹏瑞利青羊广场3F36号','a:2:{s:3:"lng";s:10:"104.067923";s:3:"lat";s:9:"30.679943";}','','','1','2','1','a:2:{s:9:"startTime";s:5:"09:00";s:7:"endTime";s:5:"22:00";}','1510329600','1478847069',null),
('3','37','1','510000','510100','510107','成都天域风情酒店(红牌楼锦里武侯祠店)','02885098777','8','9','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/Ep6A6ac7aSCaAG17a2V33A888Wtf13.jpg','','红牌楼佳灵路20号九峰汽配大厦C座','a:2:{s:3:"lng";s:10:"104.048341";s:3:"lat";s:9:"30.640633";}','','','1','2','1','a:2:{s:9:"startTime";s:5:"10:00";s:7:"endTime";s:5:"22:00";}','1510329600','1478847310',null),
('4','37','1','510000','510100','510107','酷必乐ktv(红牌楼店)','02861988966','4','5','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/w156xGO11qXZ66xgv7xZnUv66xNQ76.jpg','','长城西一路153号(丽都花园)','a:2:{s:3:"lng";s:9:"104.05869";s:3:"lat";s:9:"30.636158";}','','','1','2','1','a:2:{s:9:"startTime";s:5:"12:00";s:7:"endTime";s:5:"02:00";}','1510329600','1478847456',null),
('5','37','1','510000','510100','510107','金属感健身','13608041312','4','6','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/oJKuJvq9vzVCq9kQrvT9xivQIucGKj.jpg','','长华路19号万科汇智中心8楼811室','a:2:{s:3:"lng";s:10:"104.029944";s:3:"lat";s:8:"30.65306";}','','','1','2','1','a:2:{s:9:"startTime";s:5:"10:00";s:7:"endTime";s:5:"22:00";}','1510329600','1478847604',null),
('6','37','1','510000','510100','510122','德克士(双楠店)','02885088258','1','3','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/sww1wwzxO3sNnB9BGUfNWqBQbwaOuu.jpg','','双楠路279号','a:2:{s:3:"lng";s:10:"104.039143";s:3:"lat";s:7:"30.5919";}','','','1','2','1','a:2:{s:9:"startTime";s:5:"09:00";s:7:"endTime";s:5:"21:00";}','1510329600','1478847749',null);

insert into `ims_wlmerchant_merchantuser`(`id`,`uniacid`,`mid`,`storeid`,`name`,`mobile`,`account`,`salt`,`password`,`groupid`,`areaid`,`endtime`,`createtime`,`limit`,`reject`,`status`,`enabled`,`ismain`) values
('1','37','0','1','','','admin',null,'ourteam1204',null,'',null,'1478846264','',null,'2','0','1'),
('2','37','0','2','','','',null,'',null,'',null,'1478847069','',null,'2','0','1'),
('3','37','0','3','','','',null,'',null,'',null,'1478847310','',null,'2','0','1'),
('4','37','0','4','','','',null,'',null,'',null,'1478847456','',null,'2','0','1'),
('5','37','0','5','','','',null,'',null,'',null,'1478847604','',null,'2','0','1'),
('6','37','0','6','','','',null,'',null,'',null,'1478847749','',null,'2','0','1');

insert into `ims_wlmerchant_nav`(`id`,`uniacid`,`aid`,`name`,`link`,`thumb`,`displayorder`,`enabled`) values
('1','37','1','抢购','http://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_merchant&p=rush&ac=home&do=index&','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/w9jbbQcFbebBzoBB822mH982buu9oh.png','0','1'),
('2','37','1','火锅','http://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_merchant&p=store&ac=merchant&do=index&cid=1&pid=2','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/iN7uLh1w1unNlYHaCaYNLxCw7KH2rU.png','0','1'),
('3','37','1','酒店','http://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_merchant&p=store&ac=merchant&do=index&cid=8','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/pfdlGJ5FmgJRu6pGmdOL9DOGG9iuvd.png','0','1'),
('4','37','1','KTV','http://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_merchant&p=store&ac=merchant&do=index&cid=4&pid=5','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/xrzYf6MJCA46z46q64J6WbSoq4666W.png','0','1'),
('5','37','1','运动健身','http://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_merchant&p=store&ac=merchant&do=index&cid=4&pid=6','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/ERd47yGl4i7ay7TJxa8zIJK27yG7Dl.png','0','1'),
('6','37','1','快餐','http://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_merchant&p=store&ac=merchant&do=index&cid=1&pid=3','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/n9A060L0yII9p00I66001AllzaumU2.png','0','1'),
('7','37','1','自助餐','http://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_merchant&p=store&ac=merchant&do=index&cid=1&pid=7','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/G87ECWcq8WV8zzj7YtT20b7qqtqB2w.png','0','1'),
('8','37','1','更多分类','http://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_merchant&p=store&ac=merchant&do=index','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/xAYn44lfa7KLMqF7d4A4QfAuz7LdRd.png','0','1');

insert into `ims_wlmerchant_notice`(`id`,`uniacid`,`aid`,`title`,`content`,`enabled`,`createtime`) values
('1','37','1','智慧城市O2O上线了，欢迎咨询！','<p>智慧城市O2O上线了，欢迎咨询！双十一七折优惠！！！</p>','1','1478841455');

insert into `ims_wlmerchant_oparea`(`id`,`uniacid`,`areaid`,`aid`,`status`,`ishot`) values
('4','37','510100','1','1','0');

insert into `ims_wlmerchant_storeusers_group`(`id`,`uniacid`,`name`,`package`,`isdefault`,`enabled`,`createtime`) values
('1','37','商户分组','0','1','1','1478846100');

insert into `ims_wlmerchant_rush_activity`(`id`,`uniacid`,`sid`,`aid`,`name`,`code`,`detail`,`price`,`oldprice`,`vipprice`,`num`,`levelnum`,`status`,`starttime`,`endtime`,`follow`,`tag`,`share_title`,`share_image`,`share_desc`,`unit`,`thumb`,`thumbs`,`cutofftime`) values
('1','37','1','1','自助牛排海鲜',null,'',0.02,99.00,0.01,'10','0','2','1478847600','1506787200',null,'a:0:{}','','','','次','http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/N5xe7eMjjxxtT1E0777fj0Je6jf4uJ.jpg','a:2:{i:0;s:52:"http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/B6x9AU8l6e9HX2ol3N233NE22w3apE.jpg";i:1;s:52:"http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2016/11/xbcc3oc3R54O4C4JYicc5K8zclWbOK.jpg";}','1514649600');

