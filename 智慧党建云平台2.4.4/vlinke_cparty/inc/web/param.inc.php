<?php
global $_W, $_GPC;
load()->func('tpl');


$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op==="reset") {
    $result = pdo_delete($this->table_param, array("uniacid"=>$_W['uniacid']));
    if (!empty($result)) {
        message("数据重置成功，请速速重新配置提交保存！", referer(), 'success');
    }
    message("数据重置失败，请稍后重试！", referer(), 'error');
}

$homeconarr = array("article"=>"党建动态", "edulesson"=>"学习课程", "activity"=>"最新活动", "seritem"=>"志愿服务", "exapaper"=>"考试项目");
$wxapphomeconarr = array("article"=>"党建动态", "edulesson"=>"学习课程", "activity"=>"最新活动", "seritem"=>"志愿服务", "exapaper"=>"考试项目");

if ($op !== 'display') {
    $randkey = rand_str(6,1);
    include $this->template('param', TEMPLATE_INCLUDEPATH);
    die;
}


$param = pdo_get($this->table_param,array("uniacid"=>$_W['uniacid']));
if (checksubmit('submit')) {

    $homenav['number'] = intval($_GPC['homenav']['number']);
    $homenav['info'] = array_values($_GPC['homenav']['info']);
	$homenav = iserializer($homenav);
    $homecon = iserializer(array_values($_GPC['homecon']));
    $footnav = iserializer(array_values($_GPC['footnav']));
    $mynav = iserializer(array_values($_GPC['mynav']));

    $wxapphomenav['number'] = intval($_GPC['wxapphomenav']['number']);
    $wxapphomenav['info'] = array_values($_GPC['wxapphomenav']['info']);
	if(!empty($wxapphomenav['info'])){
		foreach ($wxapphomenav['info'] as $k => $v) {
			if($v['sta']==2){
				$wxapphomenav['info'][$k]['url'] = urlencode($v['url']);
			}
		}
	}
    $wxapphomenav = iserializer($wxapphomenav);
	
    $wxapphomecon = iserializer(array_values($_GPC['wxapphomecon']));
    $wxappfootnav = $_GPC['wxappfootnav'];
    if (!empty($wxappfootnav['list'])) {
        foreach ($wxappfootnav['list'] as $k => $v) {
            $wxappfootnav['list'][$k]['iconPath'] = tomedia($v['iconPath']);
            $wxappfootnav['list'][$k]['selectedIconPath'] = tomedia($v['selectedIconPath']);
        }
    }
    $wxappfootnav = iserializer($wxappfootnav);
	
	$gpc_wxappmynav = array_values($_GPC['wxappmynav']);
	if(!empty($gpc_wxappmynav)){
		foreach ($gpc_wxappmynav as $k => $v) {
			if($v['sta']==2){
				$gpc_wxappmynav[$k]['url'] = urlencode($v['url']);
			}
		}
	}
    $wxappmynav = iserializer($gpc_wxappmynav);

    $telephonestr = trim($_GPC['telephone']);
    $telephonestr = empty($telephonestr) ? iserializer(array()) : iserializer(explode("\r\n",$telephonestr));

    $data = array(
        'uniacid'            => $_W['uniacid'],
        'title'              => trim($_GPC['title']),
        'nicktil'            => trim($_GPC['nicktil']),
        'openhome'           => intval($_GPC['openhome']),
        'openart'            => intval($_GPC['openart']),
        
        'expcount'           => trim($_GPC['expcount']),
        'serintegral'        => intval($_GPC['serintegral']),
        'actintegral'        => intval($_GPC['actintegral']),
        'exadaystatus'       => intval($_GPC['exadaystatus']),
        'exaeverynum'        => intval($_GPC['exaeverynum']),
        'exaeveryint'        => intval($_GPC['exaeveryint']),
        
        'loginpic'           => trim($_GPC['loginpic']),
        'loginmobile'        => intval($_GPC['loginmobile']),
        'loginidnumber'      => intval($_GPC['loginidnumber']),
        
        'mypic'              => trim($_GPC['mypic']),
        'telephone'          => $telephonestr,
        'aboutus'            => $_GPC['aboutus'],
        
        'sharetitle'         => trim($_GPC['sharetitle']),
        'sharepic'           => trim($_GPC['sharepic']),
        'sharedesc'          => trim($_GPC['sharedesc']),
        'wxappsharetitle'    => trim($_GPC['wxappsharetitle']),
        'wxappshareimageurl' => trim($_GPC['wxappshareimageurl']),
        
        'pclogo'             => trim($_GPC['pclogo']),
        'pcfoot'             => $_GPC['pcfoot'],
        
        'homenav'            => $homenav,
        'homecon'            => $homecon,
        'footnav'            => $footnav,
        'mynav'              => $mynav,
        
        'wxapphomenav'       => $wxapphomenav,
        'wxapphomecon'       => $wxapphomecon,
        'wxappfootnav'       => $wxappfootnav,
        'wxappmynav'         => $wxappmynav
        );
    
    // var_dump($data);die;

    if (!empty($param)) {
        pdo_update($this->table_param, $data, array('id'=>$param['id']));
    } else {
        pdo_insert($this->table_param, $data);
    }
    message('更新参数成功！', referer(), 'success');
}






if (!empty($param)) {
    $param['telephone']    = implode("\r\n",iunserializer($param['telephone']));
    $param['homenav']      = iunserializer($param['homenav']);
    $param['homecon']      = iunserializer($param['homecon']);
    $param['footnav']      = iunserializer($param['footnav']);
    $param['mynav']        = iunserializer($param['mynav']);
    $param['wxapphomenav'] = iunserializer($param['wxapphomenav']);
	if(!empty($param['wxapphomenav']['info'])){
		foreach ($param['wxapphomenav']['info'] as $k => $v) {
			if($v['sta']==2){
				$param['wxapphomenav']['info'][$k]['url'] = urldecode($v['url']);
			}
		}
	}
    $param['wxapphomecon'] = iunserializer($param['wxapphomecon']);
    $param['wxappfootnav'] = iunserializer($param['wxappfootnav']);
    $param['wxappmynav']   = iunserializer($param['wxappmynav']);
	if(!empty($param['wxappmynav'])){
		foreach ($param['wxappmynav'] as $k => $v) {
			if($v['sta']==2){
				$param['wxappmynav'][$k]['url'] = urldecode($v['url']);
			}
		}
	}

}else{
    $param = array(
        'title'              => "智慧党建",
        'nicktil'            => "党务部",
        'openhome'           => 1,
        'openart'            => 1,
        
        'expcount'           => "党员根据以下缴纳标准自行输入金额支付；\n交纳标准：\n月工资收入（税后）在3000元以下（含3000元）的，交纳月工资收入的0.5%；\n月工资收入（税后）在3000元以上至5000元（含5000元）的，交纳月工资收入的1%；\n月工资收入（税后）在5000元以上至10000元（含10000元）的，交纳月工资收入的1.5%；\n月工资收入（税后）在10000元以上的，交纳月工资收入的2%。",
        'serintegral'        => 10,
        'actintegral'        => 10,
        'exadaystatus'       => 1,
        'exaeverynum'        => 5,
        'exaeveryint'        => 1,
        
        'loginpic'           => MODULE_URL."template/static/loginpic.jpg",
        'loginmobile'        => 1,
        'loginidnumber'      => 0,
        
        'mypic'              => MODULE_URL."template/static/mypic.jpg",
        'telephone'          => "党务电话①###15811112222\n党务电话②###15866668888",
        'aboutus'            => "关于我们介绍",
        
        'sharetitle'         => "智慧党建云平台",
        'sharedesc'          => "智慧党建云平台",
        'sharepic'           => MODULE_URL."template/static/sharepic.jpg",
        'wxappsharetitle'    => "智慧党建云平台",
        'wxappshareimageurl' => MODULE_URL."template/static/wxappsharepic.jpg",
        
        'pclogo'             => MODULE_URL."template/admin/static/images/pclogo.png",
        'pcfoot'             => "<br>Powered by ".$_W['uniaccount']['name']." © ".date(Y)." ".$_SERVER['SERVER_NAME']."<br><br>",

        'homenav' => array(
        	'number' => 5,
        	'info' => array(
	        	0 => array(
                    'til' => "党建动态",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=arthome&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-arthome.png"
	        	),
	        	1 => array(
                    'til' => "党员学习",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=eduhome&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-eduhome.png"
	        	),
	        	2 => array(
                    'til' => "组织活动",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=acthome&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-acthome.png"
	        	),
	        	3 => array(
                    'til' => "志愿服务",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=serhome&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-serhome.png"
	        	),
	        	4 => array(
                    'til' => "监督执纪",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=suphome&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-suphome.png"
	        	),
	        	5 => array(
                    'til' => "积分排行",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=intrank&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-intrank.png"
	        	),
	        	6 => array(
                    'til' => "积分记录",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=integral&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-integral.png"
	        	),
	        	7 => array(
                    'til' => "组织成员",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=mybranch&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-mybranch.png"
	        	),
	        	8 => array(
                    'til' => "党费缴纳",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=expcate&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-expense.png"
	        	),
	        	9 => array(
                    'til' => "通知公告",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=notice&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-notice.png"
	        	),
                10 => array(
                    'til' => "考试中心",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=exahome&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-exahome.png"
                ),
                11 => array(
                    'til' => "党员论坛",
                    'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=bbshome&m=vlinke_cparty",
                    'pic' => MODULE_URL."template/static/home-bbshome.png"
                ),
	        ),
        ),
        'homecon' => array(
            0 => array(
                'tab' => "article",
                'til' => "动态",
            ),
            1 => array(
                'tab' => "edulesson",
                'til' => "课程",
            ),
            2 => array(
                'tab' => "activity",
                'til' => "活动",
            ),
            3 => array(
                'tab' => "seritem",
                'til' => "服务",
            ),
            4 => array(
                'tab' => "exapaper",
                'til' => "考试",
            ),
        ),
        'footnav' => array(
            0 => array(
                'til' => "首页",
                'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=home&m=vlinke_cparty",
                'dos' => "home",
                'pic' => MODULE_URL."template/static/ficon1.png"
            ),
            1 => array(
                'til' => "动态",
                'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=arthome&m=vlinke_cparty",
                'dos' => "arthome,artcate,article,artmessage",
                'pic' => MODULE_URL."template/static/ficon2.png"
            ),
            2 => array(
                'til' => "活动",
                'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=acthome&m=vlinke_cparty",
                'dos' => "acthome,activity,actmessage",
                'pic' => MODULE_URL."template/static/ficon3.png"
            ),
            3 => array(
                'til' => "学习",
                'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=eduhome&m=vlinke_cparty",
                'dos' => "eduhome,edulesson,educhapter,edustudy,educate,edumessage",
                'pic' => MODULE_URL."template/static/ficon4.png"
            ),
            4 => array(
                'til' => "考试",
                'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=exahome&m=vlinke_cparty",
                'dos' => "exahome,exapaper,exaday,exaanswer",
                'pic' => MODULE_URL."template/static/ficon6.png"
            ),
            5 => array(
                'til' => "我的",
                'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=my&m=vlinke_cparty",
                'dos' => "my",
                'pic' => MODULE_URL."template/static/ficon5.png"
            ),
        ),
        'mynav' => array(
            0 => array(
                'til' => "积分记录",
                'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=integral&m=vlinke_cparty",
                'pic' => MODULE_URL."template/static/my-integral.png"
            ),
            1 => array(
                'til' => "学习记录",
                'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=edustudy&m=vlinke_cparty",
                'pic' => MODULE_URL."template/static/my-edustudy.png"
            ),
            2 => array(
                'til' => "志愿服务记录",
                'url' => $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=acthome&m=vlinke_cparty",
                'pic' => MODULE_URL."template/static/my-serlog.png"
            ),
        ),




        'wxapphomenav' => array(
            'number' => 5,
            'info' => array(
                0 => array(
                    'til' => "党建动态",
                    'sta' => 1,
                    'url' => "../art/arthome",
                    'pic' => MODULE_URL."template/static/home-arthome.png"
                ),
                1 => array(
                    'til' => "党员学习",
                    'sta' => 1,
                    'url' => "../edu/eduhome",
                    'pic' => MODULE_URL."template/static/home-eduhome.png"
                ),
                2 => array(
                    'til' => "组织活动",
                    'sta' => 1,
                    'url' => "../act/acthome",
                    'pic' => MODULE_URL."template/static/home-acthome.png"
                ),
                3 => array(
                    'til' => "志愿服务",
                    'sta' => 1,
                    'url' => "../ser/serhome",
                    'pic' => MODULE_URL."template/static/home-serhome.png"
                ),
                4 => array(
                    'til' => "监督执纪",
                    'sta' => 1,
                    'url' => "../sup/suphome",
                    'pic' => MODULE_URL."template/static/home-suphome.png"
                ),
                5 => array(
                    'til' => "积分排行",
                    'sta' => 1,
                    'url' => "../int/intrank",
                    'pic' => MODULE_URL."template/static/home-intrank.png"
                ),
                6 => array(
                    'til' => "积分记录",
                    'sta' => 1,
                    'url' => "../int/integral",
                    'pic' => MODULE_URL."template/static/home-integral.png"
                ),
                7 => array(
                    'til' => "组织成员",
                    'sta' => 1,
                    'url' => "../my/mybranch",
                    'pic' => MODULE_URL."template/static/home-mybranch.png"
                ),
                8 => array(
                    'til' => "党费缴纳",
                    'sta' => 1,
                    'url' => "../exp/expcate",
                    'pic' => MODULE_URL."template/static/home-expense.png"
                ),
                9 => array(
                    'til' => "通知公告",
                    'sta' => 1,
                    'url' => "../notice/notice",
                    'pic' => MODULE_URL."template/static/home-notice.png"
                ),
                10 => array(
                    'til' => "考试中心",
                    'sta' => 1,
                    'url' => "../exa/exahome",
                    'pic' => MODULE_URL."template/static/home-exahome.png"
                ),
                11 => array(
                    'til' => "党员论坛",
                    'sta' => 1,
                    'url' => "../bbs/bbshome",
                    'pic' => MODULE_URL."template/static/home-bbshome.png"
                ),
            )
        ),
        'wxapphomecon' => array(
            0 => array(
                'tab' => "article",
                'til' => "动态",
            ),
            1 => array(
                'tab' => "edulesson",
                'til' => "课程",
            ),
            2 => array(
                'tab' => "activity",
                'til' => "活动",
            ),
            3 => array(
                'tab' => "seritem",
                'til' => "服务",
            ),
            4 => array(
                'tab' => "exapaper",
                'til' => "考试",
            ),
        ),
        'wxappfootnav' => array(
            'color' => "#888888",
            'selectedColor' => "#e64340",
            'backgroundColor' => "#ffffff",
            'borderStyle' => "#e64340",
            'list' => array(
                0 => array(
                    'pagePath' => "/vlinke_cparty/pages/home/home",
                    'iconPath' => MODULE_URL."template/static/barhome.png",
                    'selectedIconPath' => MODULE_URL."template/static/barhomeon.png",
                    'text' => "首页"
                ),
                1 => array(
                    'pagePath' => "/vlinke_cparty/pages/art/arthome",
                    'iconPath' => MODULE_URL."template/static/bararthome.png",
                    'selectedIconPath' => MODULE_URL."template/static/bararthomeon.png",
                    'text' => "动态"
                ),
                2 => array(
                    'pagePath' => "/vlinke_cparty/pages/act/acthome",
                    'iconPath' => MODULE_URL."template/static/baracthome.png",
                    'selectedIconPath' => MODULE_URL."template/static/baracthomeon.png",
                    'text' => "活动"
                ),
                3 => array(
                    'pagePath' => "/vlinke_cparty/pages/edu/eduhome",
                    'iconPath' => MODULE_URL."template/static/bareduhome.png",
                    'selectedIconPath' => MODULE_URL."template/static/bareduhomeon.png",
                    'text' => "学习"
                ),
                4 => array(
                    'pagePath' => "/vlinke_cparty/pages/my/my",
                    'iconPath' => MODULE_URL."template/static/barmy.png",
                    'selectedIconPath' => MODULE_URL."template/static/barmyon.png",
                    'text' => "我的"
                )
            )
        ),
        'wxappmynav' => array(
            0 => array(
                'til' => "积分记录",
                'sta' => 1,
                'url' => '../int/integral',
                'pic' => MODULE_URL."template/static/my-integral.png"
            ),
            1 => array(
                'til' => "学习记录",
                'sta' => 1,
                'url' => '../edu/edustudy',
                'pic' => MODULE_URL."template/static/my-edustudy.png"
            ),
            2 => array(
                'til' => "志愿服务记录",
                'sta' => 1,
                'url' => '../ser/serlog',
                'pic' => MODULE_URL."template/static/my-serlog.png"
            ),
        ),

    );
}


// $wxappfootnavarr = array(0,1,2,3,4);

// var_dump($param);die;

include $this->template('param');
?>