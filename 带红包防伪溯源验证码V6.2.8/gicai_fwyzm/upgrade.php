<?php
if(!pdo_tableexists('gicai_fwyzm_diyclass')) {
	pdo_query("
		CREATE TABLE ".tablename('gicai_fwyzm_diyclass')." (
		  `id` int(10) NOT NULL AUTO_INCREMENT,
		  `uniacid` varchar(255) NOT NULL,
		  `fid` int(11) NOT NULL,
		  `title` varchar(255) NOT NULL,
		  `description` varchar(255) NOT NULL,
		  `guanlian` int(11) NOT NULL,
		  `dengji` text NOT NULL,
		  `admins` varchar(255) NOT NULL,
		  `state` int(11) NOT NULL,
		  `addtime` int(10) NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `uniacid` (`uniacid`,`fid`,`state`)
		) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
	"); 
}
if(!pdo_tableexists('gicai_fwyzm_diydata')) {
	pdo_query("
		CREATE TABLE ".tablename('gicai_fwyzm_diydata')." (
		  `id` int(10) NOT NULL AUTO_INCREMENT,
		  `uniacid` varchar(255) NOT NULL,
		  `fid` int(11) NOT NULL,
		  `did` int(11) NOT NULL,
		  `openid` varchar(255) NOT NULL,
		  `cid` int(11) NOT NULL,
		  `codekey` varchar(255) NOT NULL,
		  `pid` int(11) NOT NULL,
		  `pname` varchar(255) NOT NULL,
		  `title` varchar(255) NOT NULL,
		  `description` varchar(255) NOT NULL,
		  `dengji` text NOT NULL,
		  `note` text NOT NULL,
		  `state` int(11) NOT NULL,
		  `addtime` int(10) NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `uniacid` (`uniacid`,`fid`,`state`)
		) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
	"); 
}
if(!pdo_tableexists('gicai_fwyzm_power')) {
	pdo_query("
		CREATE TABLE ".tablename('gicai_fwyzm_power')." (
		  `id` int(10) NOT NULL AUTO_INCREMENT,
		  `uniacid` int(11) NOT NULL,
		  `fid` int(11) NOT NULL,
		  `cid` int(11) NOT NULL,
		  `pid` int(11) NOT NULL,
		  `fieldlx` int(11) NOT NULL,
		  `fieldzdm` varchar(400) NOT NULL,
		  `fieldname` varchar(400) NOT NULL,
		  `fieldatt` varchar(400) NOT NULL,
		  `state` int(11) NOT NULL,
		  `addtime` int(10) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
	"); 
}
if(!pdo_tableexists('gicai_fwyzm_roots')) {
	pdo_query("
		CREATE TABLE ".tablename('gicai_fwyzm_roots')." (
		  `id` int(10) NOT NULL AUTO_INCREMENT,
		  `uniacid` int(11) NOT NULL,
		  `cid` int(11) NOT NULL,
		  `fid` int(11) NOT NULL,
		  `pid` int(11) NOT NULL,
		  `title` varchar(255) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  `images` varchar(400) NOT NULL,
		  `state` int(11) NOT NULL,
		  `zhiwei` varchar(255) NOT NULL,
		  `show` int(11) NOT NULL,
		  `content` text NOT NULL,
		  `time` varchar(255) NOT NULL,
		  `addtime` int(10) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
	");
}
if(pdo_tableexists('gicai_fwyzm_code_data_use')) {
	if(!pdo_fieldexists('gicai_fwyzm_code_data_use','zjilu')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code_data_use')." ADD COLUMN `zjilu` text NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code_data_use','did')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code_data_use')." ADD COLUMN `did` int(10) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code_data_use','pid')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code_data_use')." ADD COLUMN `pid` int(10) NOT NULL;");
	}
	
}
if(pdo_tableexists('gicai_fwyzm_code_data')) {
	if(!pdo_fieldexists('gicai_fwyzm_code_data','minurl')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code_data')." ADD COLUMN `minurl` varchar(255) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code_data','djdata')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code_data')." ADD COLUMN `djdata` text NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code_data','djtype')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code_data')." ADD COLUMN `djtype` int(10) NOT NULL;");
	}
	
}
 


if(pdo_tableexists('gicai_fwyzm_code')) {
	if(!pdo_fieldexists('gicai_fwyzm_code','qrimages')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `qrimages` varchar(255) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code','scdjxx')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `scdjxx` int(10) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code','scqtzx')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `scqtzx` int(10) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code','dengji')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `dengji` text NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code','part')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `part` varchar(500) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code','groups')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `groups` varchar(500) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code','bqfzxl')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `bqfzxl` int(10) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code','noalert')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `noalert` varchar(255) NOT NULL;");
	}
	if(!pdo_fieldexists('gicai_fwyzm_code','nohttp')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `nohttp` varchar(255) NOT NULL;");
	}
	
	if(!pdo_fieldexists('gicai_fwyzm_code','shows')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `shows` int(10) NOT NULL;");
	}
	
	if(!pdo_fieldexists('gicai_fwyzm_code','minurl')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `minurl` int(10) NOT NULL;");
	}
	
	if(!pdo_fieldexists('gicai_fwyzm_code','lengval')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `lengval` varchar(255) NOT NULL;");
	}
	 
	if(!pdo_fieldexists('gicai_fwyzm_code','dengji')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm_code')." ADD COLUMN `dengji` text NOT NULL;");
	}
	 
	  
	
}
if(pdo_tableexists('gicai_fwyzm')) {
	if(!pdo_fieldexists('gicai_fwyzm','oktitle')) {
		pdo_query("ALTER TABLE ".tablename('gicai_fwyzm')." ADD COLUMN `oktitle` varchar(255) NOT NULL;");
	}
}
?>