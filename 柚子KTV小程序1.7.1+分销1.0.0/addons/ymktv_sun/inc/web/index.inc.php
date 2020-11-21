<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$op = $_GPC["op"];
if($op=="code"){
    if (checksubmit()) {
        $data = array();
        $data_first = $_GPC["indata"];
        $code = $data_first["code"];
        if(empty($code)){
            message('请输入激活码进行激活!', $this->createWebUrl('index'), 'error');
        }
        $ip_arr = gethostbynamel($_SERVER['HTTP_HOST']);
        $ip = $ip_arr?$ip_arr[0]:0;
        $toactive = encryptcode("35bcr/gGmbqRZmM3gx9efUySl+Z0XHe+7qtHS412VSPG9dGuTbxFC4IcCo4KjVQt", 'D','',0) . '/toactive.php?c=1&p=35&k='.$code.'&i='.$ip.'&u=' . $_SERVER['HTTP_HOST'];
        $toactive = tocurl($toactive,10);
        $toactive = trim($toactive, "\xEF\xBB\xBF");//去除bom头
        $json_toactive = json_decode($toactive,true);

        if($json_toactive["code"]===0){
            $input_data = array();
            $input_data["we7.cc"] = md5("we7_key");
            $input_data["keyid"] = $json_toactive["data"]["id"];
            $input_data["domain"] = $json_toactive["data"]["domain"];
            $input_data["ip"] = $json_toactive["data"]["ip"];
            $input_data["loca_ip"] = "127.0.0.1";
            $input_data["pid"] = $json_toactive["data"]["pid"];
            $input_data["time"] = time();
            $input_data["issa"] = $json_toactive["issa"];
            $input_data_s = serialize($input_data);
            $input_data_s = encryptcode($input_data_s, 'E','',0);
            $res = pdo_update('ymktv_sun_acode', array("code"=>$input_data_s), array('id' =>1));
            if(!$res){
                $res = pdo_insert('ymktv_sun_acode', array("code"=>$input_data_s,"id"=>1,"time"=>time()));
            }
            message('激活成功!', $this->createWebUrl('index'), '');
        }else{
            message('激活失败!', $this->createWebUrl('index'), 'error');
        }
    }
    echo "error";
    exit;
}

//会员信息
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time3=date("Y-m");
//会员总数
$totalhy=pdo_get('ymktv_sun_user', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
//今日新增会员
$sql=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('ymktv_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jir=count(pdo_fetchall($sql));
//昨日新增
$sql2=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('ymktv_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time2}%' ";
$zuor=count(pdo_fetchall($sql2));
//本月新增
$sql3=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('ymktv_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time3}%' ";
$beny=count(pdo_fetchall($sql3));
//商品一览
//商品总数
$goodstotal1=pdo_get('ymktv_sun_goods', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
$goodstotal2=pdo_get('ymktv_sun_drinks', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
$goodstotal3=pdo_get('ymktv_sun_new_bargain', array('uniacid'=>$_W['uniacid'],'status'=>2), array('count(id) as count'));
$goodstotal = (int)$goodstotal1['count'] + (int)$goodstotal2['count'] + (int)$goodstotal3['count'];

//新增商品
$sql4=" select a.* from (select  id, time  from".tablename('ymktv_sun_goods')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrgoods1=count(pdo_fetchall($sql4));
$sql4=" select a.* from (select  id, d_time as time  from".tablename('ymktv_sun_drinks')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrgoods2=count(pdo_fetchall($sql4));
$sql4=" select a.* from (select  id, selftime as time,status from".tablename('ymktv_sun_new_bargain')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%'  and status=2";
$jrgoods3=count(pdo_fetchall($sql4));
$jrgoods = (int)$jrgoods1 + (int)$jrgoods2 + (int)$jrgoods3;


//总共订单
$totalorder1=pdo_get('ymktv_sun_roomorder', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
$totalorder2=pdo_get('ymktv_sun_order', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
$totalorder3=pdo_get('ymktv_sun_kjorder', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
$totalorder = (int)$totalorder1['count'] + (int)$totalorder2['count'] + (int)$totalorder3['count'];

//代发货订单
$dfhorder1=pdo_get('ymktv_sun_roomorder', array('uniacid'=>$_W['uniacid'],'status'=>0), array('count(id) as count'));
$dfhorder2=pdo_get('ymktv_sun_order', array('uniacid'=>$_W['uniacid'],'status'=>0), array('count(id) as count'));
$dfhorder3=pdo_get('ymktv_sun_kjorder', array('uniacid'=>$_W['uniacid'],'state'=>0), array('count(id) as count'));
$dfhorder = (int)$dfhorder1['count'] + (int)$dfhorder2['count'] + (int)$dfhorder3['count'];

//帖子数量
$tztotal=pdo_get('ymktv_sun_information', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//商户数量
$shtotal=pdo_get('ymktv_sun_store', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//拼车数量
$pctotal=pdo_get('ymktv_sun_car', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//黄页数量
$hytotal=pdo_get('ymktv_sun_yellowstore', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//资讯数量
$zxtotal=pdo_get('ymktv_sun_zx', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));

//数据概况
//今日新增帖子
$sql5=" select a.* from (select id,release_time from".tablename('ymktv_sun_expert')." where uniacid={$_W['uniacid']}) a where release_time like '%{$time}%' ";
$tzinfo=pdo_fetchall($sql5);
$jrtz=count($tzinfo);


//今日新增商户
$sql6=" select a.* from (select  id,FROM_UNIXTIME(sh_time) as time  from".tablename('ymktv_sun_store')." where uniacid={$_W['uniacid']} and state=2) a where time like '%{$time}%' ";
$jrsh=count(pdo_fetchall($sql6));
//获取今日红包金额
$jrhb=0;
if($tzinfo){
foreach($tzinfo as $v){
	if($v['hb_random']==1){
		$jrhb+=$v['hb_money'];
	}
	if($v['hb_random']==2){
		$jrhb+=$v['hb_money']*$v['hb_num'];
	}
}
}

//$jrtmoney=0;
//今日销售金额
//今日订单销售金额
//$sql7=" select  sum(a.money) as ordermoney from (select  id,money,FROM_UNIXTIME(time) as time  from".tablename('ymktv_sun_order')." where uniacid={$_W['uniacid']} and state in (2,3,4,5,7)) a  where time like '%{$time}%' ";
//$ordermoney=pdo_fetch($sql7);



$day_start = strtotime(date("Y-m-d")." 00:00:00");
$day_end   = strtotime(date("Y-m-d")." 23:59:59");

$sday_start = date("Y-m-d")." 00:00:00";
$sday_end   = date("Y-m-d")." 23:59:59";

$where = " where uniacid=".$_W['uniacid']." ";

$day_where = $where." and time >= ".$day_start." and time <= ".$day_end." "; 
$day_where1 = $where." and pay_time >= '".$sday_start."' and pay_time <= '".$sday_end."' "; 

$sql = "select sum(count) as count,sum(money) as money from (select count(id) as count,sum(price) as money from ".tablename('ymktv_sun_roomorder')." ".$day_where." union all select count(id) as count,sum(money) as money from ".tablename('ymktv_sun_order')." ".$day_where1." union all select count(id) as count,sum(price) as money from ".tablename('ymktv_sun_kjorder')." ".$day_where." ) as a ";

$ordermoney = pdo_fetch($sql);




//商家入驻的钱
$sql8=" select sum(money) as storemoney from".tablename('ymktv_sun_storepaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$storemoney=pdo_fetch($sql8);  
//帖子入驻加置顶
$sql9=" select sum(money) as tzmoney from".tablename('ymktv_sun_tzpaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$tzmoney=pdo_fetch($sql9); 
//拼车发布的钱
$sql10=" select sum(money) as pcmoney from".tablename('ymktv_sun_carpaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$pcmoney=pdo_fetch($sql10); 
//114入驻的钱
$sql11=" select sum(money) as hymoney from".tablename('ymktv_sun_yellowpaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$hymoney=pdo_fetch($sql11); 

//今日总金额
//$jrtmoney=$ordermoney['ordermoney']+$storemoney['storemoney']+$tzmoney['tzmoney']+$pcmoney['pcmoney']+$hymoney['hymoney'];

include $this->template('web/index');