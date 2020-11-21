<?php
global $_W, $_GPC;
include 'common.php';
$base=$this->get_base(); 
$title=$base['title'];
//查询缓存是否存在，如果有，就直接登录后台，如果没有就显示登录页
//$webtoken = $_SESSION['webtoken']; //cache_load('webtoken');
//$manageuser= cache_load('manageuser');
$webtoken= $_SESSION['webtoken'];



if($webtoken==''){

	header('Location: '.$_W['siteroot'].'web/index.php?c=user&a=login&referer='.urlencode($_W['siteroot'].'app/'.$this->createMobileUrl('manage_login_go')));
	//include $this->template('manage_login');
}else{
	
	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}
	
	//通过缓存查找到管理员信息
	//$manageid = $_SESSION['manageid']; //cache_load('manageid');
    $manageid = $_SESSION['manageid'];
	
	$manage=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$manageid));





    $region = array(
        '北京',
        '天津',
        '上海',
        '重庆',
        '河北',
        '河南',
        '云南',
        '辽宁',
        '黑龙江',
        '湖南',
        '安徽',
        '山东',
        '新疆',
        '江苏',
        '浙江',
        '江西',
        '湖北',
        '广西',
        '甘肃',
        '山西',
        '内蒙古',
        '陕西',
        '吉林',
        '福建',
        '贵州',
        '广东',
        '青海',
        '西藏',
        '四川',
        '宁夏',
        '海南',
        '台湾',
        '香港',
        '澳门'
    );







	$data = array();

	if($manage['lev'] == 0){
        $data['renkou'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid",array(':uniacid'=>$_W['uniacid'])));   //认证总人口
        $data['orders'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_mall_orders')." WHERE weid=:uniacid AND postatus>0 AND postatus<7",array(':uniacid'=>$_W['uniacid'])));  //商城订单
        $data['orderprice'] = floatval(pdo_fetchcolumn("SELECT SUM(orderprice) FROM ".tablename('bc_community_mall_orders')." WHERE weid=:uniacid AND postatus>0 AND postatus<7",array(':uniacid'=>$_W['uniacid'])));  //商城订单成交总额
        $data['browser'] = intval(pdo_fetchcolumn("SELECT SUM(browser) FROM ".tablename('bc_community_news')." WHERE weid=:uniacid",array(':uniacid'=>$_W['uniacid'])));  //总浏览量


        $data['renkou_wrz'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=0",array(':uniacid'=>$_W['uniacid'])));   //未认证总人口
        $data['renkou_danyuan'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND isdanyuan=1",array(':uniacid'=>$_W['uniacid'])));   //认证人口中的党员数
        $data['renkou_bl'] = number_format($data['renkou']/($data['renkou']+$data['renkou_wrz']),4)*100;   //认证人口比例
        $data['renkou_wrz_bl'] = number_format($data['renkou_wrz']/($data['renkou']+$data['renkou_wrz']),4)*100;  //未认证人口比例
        $data['renkou_danyuan_bl'] = number_format($data['renkou_danyuan']/$data['renkou'],4)*100;  //认证人口中的党员比例

        $data['renkou_man'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND gender=1",array(':uniacid'=>$_W['uniacid'])));   //认证人口中的男性数
        $data['renkou_woman'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND gender=2",array(':uniacid'=>$_W['uniacid'])));   //认证人口中的女性数
        $data['renkou_canji'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND disability=1",array(':uniacid'=>$_W['uniacid'])));   //认证人口中的残疾人数
        $data['renkou_pinkun'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND poor=1",array(':uniacid'=>$_W['uniacid'])));   //认证人口中的贫困人数
        $data['renkou_gugua'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND lonely=1",array(':uniacid'=>$_W['uniacid'])));   //认证人口中的孤寡老人人数
        $data['renkou_liushou'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND children=1",array(':uniacid'=>$_W['uniacid'])));   //认证人口中的留守儿童人数

        $data['daishenghe'] = pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=0 ORDER BY createtime DESC ",array(':uniacid'=>$_W['uniacid']));
        $data['daishenghe']['help'] = pdo_fetch("SELECT * FROM ".tablename('bc_community_help')." WHERE weid=:uniacid AND mid=".$data['daishenghe']['mid'],array(':uniacid'=>$_W['uniacid']));
        $data['daishenghe']['createtime'] = date("Y-m-d",$data['daishenghe']['createtime']);
        $data['daishenghe']['cun'] = pdo_fetchcolumn("SELECT name FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND id=:townid ",array(':uniacid'=>$_W['uniacid'],':townid'=>$data['daishenghe']['menpai']));




    }elseif($manage['lev'] == 2){  //镇级
        $data['renkou'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));
        $data['orders'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_mall_orders')." WHERE weid=:uniacid AND postatus>0 AND postatus<7 AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));  //商城订单
        $data['orderprice'] = floatval(pdo_fetchcolumn("SELECT SUM(orderprice) FROM ".tablename('bc_community_mall_orders')." WHERE weid=:uniacid AND postatus>0 AND postatus<7 AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid']))); //商城订单成交总额
        $data['browser'] = intval(pdo_fetchcolumn("SELECT SUM(browser) FROM ".tablename('bc_community_news')." WHERE weid=:uniacid AND danyuan=".$manage['townid'],array(':uniacid'=>$_W['uniacid'])));  //总浏览量

        $data['renkou_wrz'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=0 AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));  //未认证总人口
        $data['renkou_danyuan'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND isdanyuan=1 AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的党员数
        $data['renkou_bl'] = number_format($data['renkou']/($data['renkou']+$data['renkou_wrz']),4)*100;
        $data['renkou_wrz_bl'] = number_format($data['renkou_wrz']/($data['renkou']+$data['renkou_wrz']),4)*100;
        $data['renkou_danyuan_bl'] = number_format($data['renkou_danyuan']/$data['renkou'],4)*100;

        $data['renkou_man'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND gender=1 AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的男性数
        $data['renkou_woman'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND gender=2 AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));  //认证人口中的女性数
        $data['renkou_canji'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND disability=1 AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的残疾人数
        $data['renkou_pinkun'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND poor=1 AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的贫困人数
        $data['renkou_gugua'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND lonely=1 AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的孤寡老人人数
        $data['renkou_liushou'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND children=1 AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的留守儿童人数


        $data['daishenghe'] = pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=0 AND danyuan=:townid ORDER BY createtime DESC ",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid']));
        $data['daishenghe']['help'] = pdo_fetch("SELECT * FROM ".tablename('bc_community_help')." WHERE weid=:uniacid AND mid=".$data['daishenghe']['mid'],array(':uniacid'=>$_W['uniacid']));
        $data['daishenghe']['createtime'] = date("Y-m-d",$data['daishenghe']['createtime']);
        $data['daishenghe']['cun'] = pdo_fetchcolumn("SELECT name FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND id=:townid ",array(':uniacid'=>$_W['uniacid'],':townid'=>$data['daishenghe']['menpai']));
    }elseif($manage['lev'] == 3){  //村级
        $data['renkou'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND menpai=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));
        $data['orders'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_mall_orders')." WHERE weid=:uniacid AND postatus>0 AND postatus<7 AND menpai=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));  //商城订单
        $data['orderprice'] = floatval(pdo_fetchcolumn("SELECT SUM(orderprice) FROM ".tablename('bc_community_mall_orders')." WHERE weid=:uniacid AND postatus>0 AND postatus<7 AND danyuan=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));  //商城订单成交总额
        $data['browser'] = intval(pdo_fetchcolumn("SELECT SUM(browser) FROM ".tablename('bc_community_news')." WHERE weid=:uniacid AND menpai=".$manage['townid'],array(':uniacid'=>$_W['uniacid'])));  //总浏览量



        $data['renkou_wrz'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=0 AND menpai=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));  //未认证总人口
        $data['renkou_danyuan'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND isdanyuan=1 AND menpai=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的党员数
        $data['renkou_bl'] = number_format($data['renkou']/($data['renkou']+$data['renkou_wrz']),4)*100;
        $data['renkou_wrz_bl'] = number_format($data['renkou_wrz']/($data['renkou']+$data['renkou_wrz']),4)*100;
        $data['renkou_danyuan_bl'] = number_format($data['renkou_danyuan']/$data['renkou'],4)*100;

        $data['renkou_man'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND gender=1 AND menpai=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的男性数
        $data['renkou_woman'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND gender=2 AND menpai=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));  //认证人口中的女性数
        $data['renkou_canji'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND disability=1 AND menpai=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的残疾人数
        $data['renkou_pinkun'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND poor=1 AND menpai=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的贫困人数
        $data['renkou_gugua'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND lonely=1 AND menpai=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的孤寡老人人数
        $data['renkou_liushou'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=1 AND children=1 AND menpai=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid'])));   //认证人口中的留守儿童人数



        $data['daishenghe'] = pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND isrz=0 AND menpai=:townid ORDER BY createtime DESC ",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid']));
        $data['daishenghe']['help'] = pdo_fetch("SELECT * FROM ".tablename('bc_community_help')." WHERE weid=:uniacid AND mid=".$data['daishenghe']['mid'],array(':uniacid'=>$_W['uniacid']));
        $data['daishenghe']['createtime'] = date("Y-m-d",$data['daishenghe']['createtime']);
        $data['daishenghe']['cun'] = pdo_fetchcolumn("SELECT name FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND id=:townid ",array(':uniacid'=>$_W['uniacid'],':townid'=>$data['daishenghe']['menpai']));

    }

    $data['xcfg'] = array();
    foreach ($region as $value){
        $tmp = array();
        $tmp['name'] = $value;
        $tmp['number'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND province = :province",array(':uniacid'=>$_W['uniacid'],':province'=>$value)));   //乡村数
        $data['xcfg'][] = $tmp;
    }

    $data['sj_number'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev = 0",array(':uniacid'=>$_W['uniacid'])));   //市级数
    $data['zj_number'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev = 2",array(':uniacid'=>$_W['uniacid'])));   //市级数
    $data['cj_number'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev = 3",array(':uniacid'=>$_W['uniacid'])));   //市级数
    $data['cz_total'] =  $data['sj_number']+$data['zj_number']+$data['cj_number']; //村镇总数
    $data['sj_proportion'] = $data['sj_number']/$data['cz_total']*100;
    $data['zj_proportion'] = $data['zj_number']/$data['cz_total']*100;
    $data['cj_proportion'] = $data['cj_number']/$data['cz_total']*100;





    $orderdate = array();
    for($i=6;$i>=0;$i--){
        $tmp = array();
        $tmp['begin'] = mktime(0,0,0,date('m'),date('d')-(1+$i),date('Y'));
        $tmp['end'] = mktime(0,0,0,date('m'),date('d')-$i,date('Y'))-1;
        $tmp['date'] = date('Y-m-d',$tmp['begin']);
        $orderdate[] = $tmp;
    }
    foreach ($orderdate as $key=>$value){
        $orderdate[$key]['order_count'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_mall_orders')." WHERE weid=:uniacid AND poctime>:starttime AND poctime<:endtime",array(':uniacid'=>$_W['uniacid'],':starttime'=>$value['begin'],':endtime'=>$value['end'])));  //商城订单
    }


    //统计月人口排行
    $month = date("Y-m",time());
    $today = date("Y-m-d");
    $Dmonth=getthemonth($today);
    //print_r(getnearlymonth(7));



    $town = pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid",array(':uniacid'=>$_W['uniacid']));
    foreach ($town as $key=>$value){
        $town[$key]['month_count'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("bc_community_member")." WHERE weid=:uniacid AND isrz=1 AND menpai=:town_id AND createtime>:begin AND createtime<:end",array(':uniacid'=>$_W['uniacid'],':town_id'=>$value['id'],':begin'=>$Dmonth[0],':end'=>$Dmonth[1])));

        $tmp = array();
        $tmp['month'] = $month;
        $tmp['weid'] = $_W['uniacid'];
        $tmp['add_count'] = $town[$key]['month_count'];
        $tmp['count'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("bc_community_member")." WHERE weid=:uniacid AND isrz=1 AND menpai=:town_id",array(':uniacid'=>$_W['uniacid'],':town_id'=>$value['id'])));
        if($tmp['add_count']>0){
            $tmp['proportion'] = number_format($tmp['add_count']/$tmp['count']*100,2);
        }

        $tmp['town_id'] = $value['id'];
        $count = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("bc_community_population_top")." WHERE weid=".$_W['uniacid']." AND month='".$month."' AND town_id=".$value['id']));
        if($count>0){
            pdo_update('bc_community_population_top', $tmp, array('weid' => $_W['uniacid'],'month'=>$month,'town_id'=>$value['id']));
        }else{
            pdo_insert('bc_community_population_top', $tmp);
        }
    }
    $renkoutop = pdo_fetchall("SELECT A.*,B.name,C.name as zenname FROM ".tablename('bc_community_population_top')." A LEFT JOIN ".tablename('bc_community_town')." B ON A.town_id=B.id LEFT JOIN ".tablename('bc_community_town')." C ON B.pid=C.id WHERE A.weid=:uniacid AND B.lev=3 AND month='".$month."' ORDER BY A.proportion DESC LIMIT 0,9",array(':uniacid'=>$_W['uniacid']));
    foreach ($renkoutop as $key=>$value){
        $renkoutop[$key]['list'] = pdo_fetchall("SELECT * FROM ".tablename('bc_community_population_top')." WHERE weid=:uniacid AND town_id=".$value['town_id']." ORDER BY month DESC LIMIT 0,9",array(':uniacid'=>$_W['uniacid']));
    }


    //种植信息
    $zhongzhi = array();
    $zhongzhi[] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("nx_information_plant")." WHERE weid=:uniacid AND varieties='水稻'",array(':uniacid'=>$_W['uniacid'])));
    $zhongzhi[] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("nx_information_plant")." WHERE weid=:uniacid AND varieties='小麦'",array(':uniacid'=>$_W['uniacid'])));
    $zhongzhi[] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("nx_information_plant")." WHERE weid=:uniacid AND varieties='玉米'",array(':uniacid'=>$_W['uniacid'])));
    $zhongzhi[] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("nx_information_plant")." WHERE weid=:uniacid AND varieties='蔬菜'",array(':uniacid'=>$_W['uniacid'])));
    $zhongzhi[] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("nx_information_plant")." WHERE weid=:uniacid AND varieties='其它'",array(':uniacid'=>$_W['uniacid'])));
    //养植信息
    $yangzhi = array();
    $yangzhi[] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("nx_information_breed")." WHERE weid=:uniacid AND varieties='牛'",array(':uniacid'=>$_W['uniacid'])));
    $yangzhi[] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("nx_information_breed")." WHERE weid=:uniacid AND varieties='羊'",array(':uniacid'=>$_W['uniacid'])));
    $yangzhi[] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("nx_information_breed")." WHERE weid=:uniacid AND varieties='猪'",array(':uniacid'=>$_W['uniacid'])));
    $yangzhi[] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("nx_information_breed")." WHERE weid=:uniacid AND varieties='鸡鸭'",array(':uniacid'=>$_W['uniacid'])));
    $yangzhi[] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename("nx_information_breed")." WHERE weid=:uniacid AND varieties='其它'",array(':uniacid'=>$_W['uniacid'])));





	include $this->template('manage_index');
}



/**
 * 获取最近七天所有日期
 */
function get_weeks($time = '', $format='Y-m-d'){
    $time = $time != '' ? $time : time();
    //组合数据
    $date = [];
    for ($i=1; $i<=7; $i++){
        $date[$i] = date($format ,strtotime( '+' . $i-7 .' days', $time));
    }
    return $date;
}
//获取每月开始和结束时间戳
function getthemonth($date)
{
    $firstday = date('Y-m-01', strtotime($date));
    $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
    $firstday = strtotime($firstday);
    $lastday = strtotime($lastday)+86399;

    return array($firstday,$lastday);
}

//获取最近几个月的月份时间
function getnearlymonth($num){
    $return = array();
    $t = date('Y-m-d',time());
    for ($i=0;$i<$num;$i++){
        $return[] = date("Y-m",strtotime("$t -".$i." month"));
    }
    return $return;
}



?>