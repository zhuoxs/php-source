<?php
/**
 * 砍价小程序模块微站定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
define("HTTPSHOST",$_W['attachurl']);
define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page/');

class Sudu8_page_plugin_bargainModuleSite extends WeModuleSite {
     // 砍价设置
    public function doWebset() {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];    
        $bargain = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_bargain_set') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
        if($bargain){
            $bargain['banners'] = unserialize($bargain['banners']);
        }
        if (checksubmit('submit')) {
            $data = array(
                'uniacid' => $_W['uniacid'],
                'banners' => $_GPC['banners'] ? serialize($_GPC['banners']) : '',
                'rules' =>$_GPC['rules'],
                'shareTitle' =>$_GPC['shareTitle'],
                'emailStatus' => $_GPC['emailStatus']
            );
            if(!$bargain){
                $res = pdo_insert('sudu8_page_bargain_set', $data);
            }else{
                $res = pdo_update('sudu8_page_bargain_set', $data ,array('uniacid' => $uniacid));
            }
            if($res){
                message('砍价基础设置  新增/更新成功!', $this->createWebUrl('set', array('op'=>'display')), 'success');
            }else{
                message('砍价基础设置  新增/更新失败!', $this->createWebUrl('set', array('op'=>'display')), 'success');
            }
        }
        include $this->template('set');
    }

    // 砍价邀请管理
    public function doWebcate() {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display','post','delete');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];    
        //产品列表
        if ($op == 'display'){
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_bargain_cate')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $p = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize); 
            $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_bargain_cate')." WHERE uniacid = :uniacid  order by id desc limit ".$p.",".$pagesize, array(':uniacid' => $uniacid));

        }


        //分类修改新增
        if ($op == 'post'){
            $id = intval($_GPC['id']);
            $cate = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_bargain_cate')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $id));

            if (checksubmit('submit')) {
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'title' => $_GPC['title']
                );
                if (!$id) {
                    pdo_insert('sudu8_page_bargain_cate', $data);
                } else {
                    pdo_update('sudu8_page_bargain_cate', $data, array('id' => $id ,'uniacid' => $uniacid));
                }
                message('栏目 添加/修改 成功!', $this->createWebUrl('cate', array('op'=>'display')), 'success');
            }

        }

        //删除栏目
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_bargain_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('栏目不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_bargain_cate', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('cate', array('op'=>'display')), 'success');
        }
        include $this->template('cate');
    }

    // 砍价产品管理
    public function doWebprolist() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display','post','delete','types');
        $op = in_array($op, $ops) ? $op : 'display';
        if ($op == 'display') {
			$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_bargain_pro') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			$pageindex = max(1, intval($_GPC['page']));
			$pagesize = 10;  
			$p = ($pageindex-1) * $pagesize;
			$pager = pagination($total, $pageindex, $pagesize); 
            $products = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_bargain_pro') ." WHERE uniacid = :uniacid ORDER BY num desc limit ".$p.",".$pagesize, array(':uniacid' => $uniacid));
            foreach ($products as $key => &$res) {
                $cate = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_bargain_cate') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $res['cateId']));
                $res['cate'] = $cate['title'];
            }
        }else if ($op == 'post') {
        	$id = intval($_GPC['id']);
        	$products = pdo_get('sudu8_page_bargain_pro', array('uniacid' => $uniacid, 'id' => $id));
        	if($products){
        		$products['masterThumb'] = unserialize($products['masterThumb']);
        		$products['vipConfig'] = unserialize($products['vipConfig']);
        	}
        	$cates = pdo_getAll('sudu8_page_bargain_cate', array('uniacid' => $uniacid));
        	$forms = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE uniacid = :uniacid order by id desc", array(':uniacid' => $uniacid));
            $yunfeiList = pdo_fetchall("SELECT id,name FROM ".tablename('sudu8_page_freight')." WHERE uniacid = :uniacid and is_delete = 0", array(':uniacid' => $uniacid));

            $grade_arr = pdo_fetchall("SELECT id,grade,name FROM ".tablename('sudu8_page_vipgrade')." WHERE uniacid = :uniacid order by grade asc", array(":uniacid" => $uniacid));
		    if(empty($grade_arr)){
		        $data_s = [
		            'uniacid' => $uniacid,
		            'grade' => 1,
		            'name' => '大众会员',
		            'upgrade' => 0,
		            'price' => 0,
		            'status' => 1,
		            'bgcolor' => '#434550',
		            'card_img' => 'static/images/vip_card.png',
		            'descs' => '默认会员等级'
		        ];
		        pdo_insert('sudu8_page_vipgrade',$data_s);
		        $grade_arr[0]['name'] = '大众会员';
		        $grade_arr[0]['grade'] = 1;
		        $grade_arr[0]['id'] = pdo_insertid();
		    }

        	if(checksubmit('submit')){
        		$num = intval($_GPC['num']);
        		$cateId = intval($_GPC['cateId']);
        		$title = $_GPC['title'];
        		$status = $_GPC['status'] ? $_GPC['status'] : 1;
        		$hot = $_GPC['hot'] ? $_GPC['hot'] : 2;
        		$kuaidi = $_GPC['kuaidi'] ? $_GPC['kuaidi'] : 3;
        		$freightId = $_GPC['freightId'];
        		$form_id = $_GPC['form_id'];
        		$price = $_GPC['price'];
        		$kc = intval($_GPC['kc']);
        		$virtualSaleVolume = $_GPC['virtualSaleVolume'];
        		$thumb = $_GPC['thumb'];
        		$shareThumb = $_GPC['shareThumb'];
        		$masterThumb = $_GPC['masterThumb'] ? serialize($_GPC['masterThumb']) : '';
        		$descs = $_GPC['descs'];
        		$labels = $_GPC['labels'];
        		$texts = $_GPC['texts'];
        		$set1 = intval($_GPC['set1']);
        		$set2 = intval($_GPC['set2']);
        		$set3 = intval($_GPC['set3']);
        		$vipConfig = [
        			'set1' => $set1,
        			'set2' => $set2,
        			'set3' => $set3
        		];
        		$vipConfig = serialize($vipConfig);
        		$data = [
        			'uniacid' => $uniacid,
        			'num' => $num,
        			'cateId' => $cateId,
        			'title' => $title,
        			'status' => $status,
        			'hot' => $hot,
        			'kuaidi' => $kuaidi,
        			'freightId' => $freightId,
        			'form_id' => $form_id,
        			'price' => $price,
        			'kc' => $kc,
        			'virtualSaleVolume' => $virtualSaleVolume,
        			'thumb' => $thumb,
        			'shareThumb' => $shareThumb,
        			'masterThumb' => $masterThumb,
        			'descs' => $descs,
        			'labels' => $labels,
        			'texts' => $texts,
        			'vipConfig' => $vipConfig
        		];

	        	if ($id > 0) {
	        		$res = pdo_update('sudu8_page_bargain_pro', $data, array('id' => $id));
	        	} else {
	        		$res = pdo_insert('sudu8_page_bargain_pro', $data);
	        		$id = pdo_insertid();
	        	}
	        	if ($res) {
            		message('添加/修改成功!', $this->createWebUrl('prolist', array('op'=>'types', 'id' => $id)), 'success');
	        	}else{
            		message('添加/修改失败!', $this->createWebUrl('prolist', array('op'=>'post', 'id' => $id)), 'success');
	        	}
        	}
        } else if ($op == 'types') {
        	$id = intval($_GPC['id']);
        	$products = pdo_fetch("SELECT miniPrice,activeBinTime,activeEndTime,activeHours,activeRule,price FROM ".tablename('sudu8_page_bargain_pro')." WHERE id = :id", array("id" => $id));
        	if($products){
                $products['activeBinTime'] = $products['activeBinTime'] > 0 ? date("Y-m-d H:i:s", $products['activeBinTime']) : '';
        		$products['activeEndTime'] = $products['activeEndTime'] > 0 ? date("Y-m-d H:i:s", $products['activeEndTime']) : '';
                $products['activeRule'] = unserialize($products['activeRule']);
        		$price = $products['price'];
        	}else{
        		$price = 0;
        	}
        	if(checksubmit('submit')){
        		$miniPrice = $_GPC['miniPrice'];
        		$activeBinTime = strtotime($_GPC['activeBinTime']);
        		$activeEndTime = strtotime($_GPC['activeEndTime']);
        		$activeHours = $_GPC['activeHours'];
        		$aPersons = $_GPC['aPersons'];
        		$aBinPersons = $_GPC['aBinPersons'];
        		$aBargainOne = $_GPC['aBargainOne'];
        		$aBargainTwo = $_GPC['aBargainTwo'];
        		$aBargainThree = $_GPC['aBargainThree'];
        		$aBargainFour = $_GPC['aBargainFour'];
        		$activeRule = [
        			'aPersons' => $aPersons,
        			'aBinPersons' => $aBinPersons,
        			'aBargainOne' => $aBargainOne,
        			'aBargainTwo' => $aBargainTwo,
        			'aBargainThree' => $aBargainThree,
        			'aBargainFour' => $aBargainFour
        		];
        		$data = [
        			'miniPrice' => $miniPrice,
                    'activeBinTime' => $activeBinTime,
        			'activeEndTime' => $activeEndTime,
        			'activeHours' => $activeHours,
        			'activeRule' => serialize($activeRule)
        		];
        		$res = pdo_update('sudu8_page_bargain_pro', $data, array('id' => $id));
        		if ($res) {
            		message('添加/修改砍价设置成功!', $this->createWebUrl('prolist', array('op'=>'display')), 'success');
	        	}else{
            		message('添加/修改砍价设置失败!', $this->createWebUrl('prolist', array('op'=>'types', 'id' => $id)), 'success');
	        	}
        	}
        } else if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $is = pdo_get('sudu8_page_bargain_pro', array('id' => $id));
            if(!$is){
        		message('商品不存在或已删除!', $this->createWebUrl('prolist', array('op'=>'display')), 'success');
        		exit;
            }
            $res = pdo_delete('sudu8_page_bargain_pro', array('id' => $id));
    		if ($res) {
        		message('商品删除成功!', $this->createWebUrl('prolist', array('op'=>'display')), 'success');
        	}else{
        		message('商品删除失败!', $this->createWebUrl('prolist', array('op'=>'display')), 'success');
        	}
        }
		
        include $this->template('prolist');
    }
    // 砍价管理
    public function doWebbargain() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display');
        $op = in_array($op, $ops) ? $op : 'display';
        $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_bargain_bargainOrder')." as a LEFT JOIN ".tablename('sudu8_page_bargain_pro')." as b on a.proId = b.id WHERE a.uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;  
        $p = ($pageindex-1) * $pagesize;
        $pager = pagination($total, $pageindex, $pagesize); 
        $list = pdo_fetchall("SELECT a.*,b.title,b.thumb,b.price,b.miniPrice FROM ".tablename('sudu8_page_bargain_bargainOrder')." as a LEFT JOIN ".tablename('sudu8_page_bargain_pro')." as b on a.proId = b.id WHERE a.uniacid = :uniacid order by a.id desc limit ".$p.",".$pagesize , array(':uniacid' => $_W['uniacid']));
        foreach ($list as $key => &$value) {
            $receive = pdo_fetchall("SELECT b.avatar FROM ".tablename('sudu8_page_bargain_receive')." as a LEFT JOIN ".tablename('sudu8_page_user')." as b on a.openid = b.openid WHERE a.uniacid = :uniacid and b.uniacid = :uniacid and a.bargain_id = :bargain_id order by a.id asc", array(':uniacid' => $uniacid, ':bargain_id' => $value['id']));
            $value['receive'] = $receive;
            if($value['thumb'] && !stristr($value['thumb']."http")){
                $value['thumb'] = HTTPSHOST.$value['thumb'];
            }
            $value['createtime'] = date("Y-m-d H:i:s", $value['createtime']);
            $value['overtime'] = date("Y-m-d H:i:s", $value['overtime']);
        }
        include $this->template('bargain');
    }

    // 订单管理
    public function doWeborderlist() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display', 'hx', 'fahuo','excel', 'getwuliu', 'confirmtk', 'refuseqx', 'qx');
        $op = in_array($op, $ops) ? $op : 'display';
        $this->doovershare(); //处理过期订单
        if($op == 'getwuliu'){
            $kuaidi = $_GPC['kuaidi'];
            $kuaidihao = $_GPC['kuaidihao'];
            $kd_code = array(
                    '顺丰速运' => 'SFEXPRESS',
                    '韵达' => 'YD',
                    '天天' => 'TTKDEX',
                    '申通' => 'STO',
                    '圆通' => 'YTO',
                    '中通' => 'ZTO',
                    '国通' => 'GTO',
                    '百世汇通' => 'HTKY',
                    'EMS'  => 'EMS',
                    '邮政' => 'CHINAPOST',
                    'FEDEX联邦(国内件)' => 'FEDEX',
                    '宅急送' => 'ZJS',
                    '安捷快递' => 'ANJELEX',
                    '大田物流' => 'DTW',
                    '百福东方' => 'EES',
                    '德邦' => 'DEPPON',
                    'D速物流' => 'DEXP',
                    'COE东方快递' => 'COE',
                    '共速达' => 'GSD',
                    '佳怡物流' => 'JIAYI',
                    '京广速递' => 'KKE',
                    '急先达' => 'JOUST',
                    '加运美' => 'TMS',
                    '晋越快递' => 'PEWKEE',
                    '全晨快递' => 'QCKD',
                    '民航快递' => 'CAE',
                    '龙邦快递' => 'LBEX',
                    '联昊通速递' => 'LTS',
                    '全一快递' => 'APEX',
                    '如风达' => 'RFD',
                    '速尔快递' => 'SURE',
                    '盛丰物流' => 'SFWL',
                    '天地华宇' => 'HOAU',
                    'TNT快递' => 'TNT',
                    'UPS' => 'UPS',
                    '万家物流' => 'WANJIA',
                    '信丰物流' => 'XFEXPRESS',
                    '亚风快递' => 'BROADASIA',
                    '优速' => 'UC56',
                    '远成物流' => 'YCGWL',
                    '运通快递' => 'YTEXPRESS',
                    '源安达快递' => 'YADEX',
                    '中铁快运' => 'CRE',
                    '中邮快递' => 'CNPL',
                    '安能物流' => 'ANE',
                    '九曳供应链' => 'JIUYESCM',
                    '东骏快捷'=>'DJ56',
                    '万象'=>'EWINSHINE',
                    '芝麻开门'=>'ZMKMEX'
                );
            include IA_ROOT.'/addons/sudu8_page/KdSearch.php';
            $ShipperCode = $kd_code[$kuaidi];
            $LogisticCode = $kuaidihao;

            $wuliu = pdo_fetch("SELECT api_type,ebusinessid,appkey FROM ".tablename('sudu8_page_duo_products_yunfei')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
            if(!$wuliu){
                $ebusinessid = 1412090;
                $appkey = '9dc7f785-8ed0-4739-aaa0-ae619d449923';
            }else{
                if($wuliu['api_type'] == 2){
                    $ebusinessid = $wuliu['ebusinessid'];
                    $appkey = $wuliu['appkey'];
                }elseif($wuliu['api_type'] == 3){
                    //阿里云接口
                    $ali_code = array(
                    '顺丰速运' => 'SFEXPRESS',
                    '韵达' => 'YUNDA',
                    '天天' => 'TTKDEX',
                    '申通' => 'STO',
                    '圆通' => 'YTO',
                    '中通' => 'ZTO',
                    '国通' => 'GTO',
                    '百世汇通' => 'HTKY',
                    'EMS'  => 'EMS',
                    '邮政' => 'CHINAPOST',
                    'FEDEX联邦(国内件)' => 'FEDEX',
                    '宅急送' => 'ZJS',
                    '安捷快递' => 'ANJELEX',
                    '大田物流' => 'DTW',
                    '百福东方' => 'EES',
                    '德邦' => 'DEPPON',
                    'D速物流' => 'DEXP',
                    'COE东方快递' => 'COE',
                    '共速达' => 'GSD',
                    '佳怡物流' => 'JIAYI',
                    '京广速递' => 'KKE',
                    '急先达' => 'JOUST',
                    '加运美' => 'TMS',
                    '晋越快递' => 'PEWKEE',
                    '全晨快递' => 'QCKD',
                    '民航快递' => 'CAE',
                    '龙邦快递' => 'LBEX',
                    '联昊通速递' => 'LTS',
                    '全一快递' => 'APEX',
                    '如风达' => 'RFD',
                    '速尔快递' => 'SURE',
                    '盛丰物流' => 'SFWL',
                    '天地华宇' => 'HOAU',
                    'TNT快递' => 'TNT',
                    'UPS' => 'UPS',
                    '万家物流' => 'WANJIA',
                    '信丰物流' => 'XFEXPRESS',
                    '亚风快递' => 'BROADASIA',
                    '优速' => 'UC56',
                    '远成物流' => 'YCGWL',
                    '运通快递' => 'YTEXPRESS',
                    '源安达快递' => 'YADEX',
                    '中铁快运' => 'CRE',
                    '中邮快递' => 'CNPL',
                    '安能物流' => 'ANE',
                    '九曳供应链' => 'JIUYESCM',
                    '东骏快捷'=>'DJ56',
                    '万象'=>'EWINSHINE',
                    '芝麻开门'=>'ZMKMEX'
                );
                    $kuaidi = $ali_code[$kuaidi];
                    // $data = $_POST;
                    $host = "https://wuliu.market.alicloudapi.com";//api访问链接
                    $path = "/kdi";//API访问后缀
                    $method = "GET";
                    $appcode = $wuliu['appcode'];  //阿里云云市场购买的 appcode
                    $headers = array();
                    array_push($headers, "Authorization:APPCODE " . $appcode);
                    $querys = "no=$kuaidihao&type=$kuaidi";  //参数写在这里
                    $bodys = "";
                    $url = $host . $path . "?" . $querys;//url拼接

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_FAILONERROR, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    if (1 == strpos("$".$host, "https://"))
                    {
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                    }
                    $data = curl_exec($curl);

                    curl_close($curl);

                    $res = json_decode($data, true);
                    if($res){
                        if($res['status'] == 0){
                            foreach ($res['result']['list'] as $key => &$value) {
                                $value['AcceptStation'] = $value['status'];
                                $value['AcceptTime'] = $value['time'];
                            }
                            echo json_encode($res['result']['list']);
                        }else{
                            echo json_encode([]);
                        }

                    }else{
                        echo -1;
                    }
                    exit;
                }else{
                    $ebusinessid = 1412090;
                    $appkey = '9dc7f785-8ed0-4739-aaa0-ae619d449923';
                }
            }
            $kd = new KdSearch();
            $return=$kd->getOrderTracesByJson($ebusinessid,$appkey,$ShipperCode,$LogisticCode);
            $result = json_decode($return,true);
            if(!$result['Success']){
                echo -1;
            }else{
                echo json_encode(array_reverse($result['Traces']));
            }
            exit;
        }
        if($op == "hx"){  //核销
            $id = $_GPC['id'];
            $data['hxtime'] = time();
            $data['flag'] = 2;
            $data['hxinfo'] = 'a:1:{i:0;i:1;}';
            $res = pdo_update('sudu8_page_bargain_order', $data, array('id' => $id));
            $info = pdo_fetch("SELECT openid,true_price FROM".tablename('sudu8_page_bargain_order')." WHERE id = :id", array(':id' => $id));
            $this->addAllpay($info['true_price'], $info['openid']);
            $this->checkVipGrade($info['openid']);
            message('核销成功!', $this->createWebUrl('orderlist',array('op'=>'display')), 'success');
        }
        if($op == "fahuo"){  //发货
            $id = $_GPC['id'];
            $data['hxtime'] = time();
            $data['kuaidi'] = $_GPC['kuaidi'];
            $data['kuaidihao'] = $_GPC['kuaidihao'];
            $data['flag'] = 4;
            pdo_update("sudu8_page_bargain_order", $data, array('id'=>$id));
            $info = pdo_fetch("SELECT openid,true_price FROM".tablename('sudu8_page_bargain_order')." WHERE id = :id", array(':id' => $id));
            message('成功!', $this->createWebUrl('orderlist',array('op'=>'display')), 'success');
        }
        if($op == 'confirmtk' || $op == 'qx'){
            $id = trim($_GPC['order']);
            $now = time();
            $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
            if($_GPC['qxbeizhu']){
                $data['qxMsg'] = $_GPC['qxbeizhu'];
            }
            $data['th_orderid'] = $out_refund_no;

            pdo_update("sudu8_page_bargain_order", $data, array("uniacid"=>$uniacid, "id"=>$id));
            $order = pdo_get("sudu8_page_bargain_order", array("uniacid"=>$uniacid, "id"=>$id));

            if($order['wx_price'] > 0){
                require_once MODULE_ROOT."/../sudu8_page/WeixinRefund.php";
                $app = pdo_get("account_wxapp", array("uniacid"=>$uniacid));
                $paycon = pdo_get("uni_settings", array("uniacid"=>$uniacid));
                $datas = unserialize($paycon['payment']);
                $appid = $app['key'];  
                $mch_id = $datas['wechat']['mchid'];
                $zfkey = $datas['wechat']['signkey'];
                $refund_fee = intval($order['wx_price'] * 100);
                $weixinrefund = new WeixinRefund($appid, $zfkey, $mch_id, $order['order_id'], $out_refund_no, $refund_fee, $refund_fee, $uniacid, $types);
                $return = $weixinrefund->refund();

                if(!$return){
                    message('退货失败!请检查系统设置->小程序设置和支付设置');
                }else if($return['result_code'] == "FAIL"){
                    message('退货失败!'.$return['err_code_des']);
                }else if($return['return_code'] == "FAIL"){
                    message('退货失败!'.$return['return_msg']);
                }else{
                    $uid = pdo_getcolumn("sudu8_page_user", array('uniacid' => $uniacid, 'openid' => $order['openid']), 'id');
                    $order = pdo_get("sudu8_page_bargain_order", array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                    $pro = pdo_get("sudu8_page_bargain_pro", array("uniacid"=>$uniacid, "id"=>$order['pid']));
                    //金钱流水
                    $xfmoney = array(
                        "uniacid" => $uniacid,
                        "orderid" => $order['order_id'],
                        "uid" => $uid,
                        "type" => "add",
                        "score" => $order['wx_price'],
                        "message" => "退款退回微信",
                        "creattime" => time()
                    );
                    pdo_insert("sudu8_page_money", $xfmoney);

                    $tk_je = $order['yue_price']; //退回余额
                    if($tk_je > 0){
                        $xfmoney1 = array(
                            "uniacid" => $uniacid,
                            "orderid" => $order['order_id'],
                            "uid" => $uid,
                            "type" => "add",
                            "score" => $tk_je,
                            "message" => "退款退回余额",
                            "creattime" => time()
                        );
                        pdo_insert("sudu8_page_money", $xfmoney1);
                    }
                    $realSaleVolume = $pro['realSaleVolume'] - 1;
                    $kc = $pro['kc'] + 1;

                    pdo_update("sudu8_page_bargain_pro", array("realSaleVolume"=>$realSaleVolume, 'kc' => $kc), array("uniacid"=>$uniacid, "id"=>$order['pid']));
                    if($op == "confirmtk"){
                        pdo_update("sudu8_page_bargain_order", array("flag"=>8), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                    }else{
                        pdo_update("sudu8_page_bargain_order", array("flag"=>5), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                    }
                }
            }else{
                if($op == "confirmtk"){
                    pdo_update("sudu8_page_bargain_order", array("flag"=>8), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                }else{
                    pdo_update("sudu8_page_bargain_order", array("flag"=>5), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                }
                //金钱流水
                if($order['true_price'] > 0){
                    $uid = pdo_getcolumn("sudu8_page_user", array('uniacid' => $uniacid, 'openid' => $order['openid']), 'id');
                    $xfmoney = array(
                        "uniacid" => $uniacid,
                        "orderid" => $order['order_id'],
                        "uid" => $uid,
                        "type" => "add",
                        "score" => $order['true_price'],
                        "message" => "退款退回余额",
                        "creattime" => time()
                    );
                    pdo_insert("sudu8_page_money", $xfmoney);
                }
                $order = pdo_get("sudu8_page_bargain_order", array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));

                pdo_query("UPDATE ".tablename("sudu8_page_user")." SET money = money + ".$order['true_price']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$uid));

                $pro = pdo_get("sudu8_page_bargain_pro", array("uniacid"=>$uniacid, "id"=>$order['pid']));
                
                $realSaleVolume = $pro['realSaleVolume'] - 1;

                $kc = $pro['kc'] + 1;
                pdo_update("sudu8_page_bargain_pro", array("realSaleVolume"=>$realSaleVolume, 'kc' => $kc), array("uniacid"=>$uniacid, "id"=>$pro['id']));
            }

            message('取消成功!', $this->createWebUrl('orderlist', array('op'=>'display')), 'success');

        }
        if($op == 'refuseqx'){
            $id = $_GPC['order'];
            pdo_update("sudu8_page_bargain_order", array("flag"=>1), array("uniacid"=>$uniacid, "id"=>$id));
            message('已拒绝取消!', $this->createWebUrl('orderlist', array('op'=>'display')), 'success');
        }
        if($op == "excel"){
            include IA_ROOT.'/addons/sudu8_page/plugin/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new \PHPExcel();

            /*以下是一些设置*/
            $objPHPExcel->getProperties()->setCreator("砍价订单记录")
                ->setLastModifiedBy("砍价订单记录")
                ->setTitle("砍价订单记录")
                ->setSubject("砍价订单记录")
                ->setDescription("砍价订单记录")
                ->setKeywords("砍价订单记录")
                ->setCategory("砍价订单记录");
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '下单时间');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', '订单编号');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', '订单类型');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', '商品标题');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', '商品单价');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', '支付详情');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', '核销时间');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', '姓名');
            $objPHPExcel->getActiveSheet()->setCellValue('I1', '联系方式');
            $objPHPExcel->getActiveSheet()->setCellValue('J1', '邮编');
            $objPHPExcel->getActiveSheet()->setCellValue('K1', '地址');
            $objPHPExcel->getActiveSheet()->setCellValue('L1', '状态');

            $order_id = $_GPC['order_id'];
            if($order_id){
                $where = " and order_id like '%".$order_id."%'";
            }
            $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_bargain_order')." WHERE uniacid = :uniacid {$where} order by id desc", array(':uniacid' => $_W['uniacid']));

            foreach ($orders as $key => &$res) {

                $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                $res['hxtime'] = intval($res['hxtime']) == 0 ? "未核销" : date("Y-m-d H:i:s",$res['hxtime']);
                if(intval($res['hxtime']) == 0 && $res['nav'] == 1){
                    $res['hxtime'] = "无";
                }

                // 转换地址
                if(!empty($res['m_address'])){
                    $res['address_get'] = unserialize($res['m_address']);
                }else{
                   $res['address_get'] = []; 
                   $res['address_get']['name'] = "";
                   $res['address_get']['mobile'] = "";
                   $res['address_get']['postalcode'] = "";
                   $res['address_get']['address'] = "";
                }

                $num=$key+2;
                if($res['flag'] == 0){
                    $res['flag1'] = '未付款';
                }else if($res['flag'] == 1 && $res['nav'] == 1){
                    $res['flag1'] = '已付款待发货';
                }else if($res['flag'] == 1 && $res['nav'] == 2){
                    $res['flag1'] = '已付款待消费';
                }else if($res['flag'] == 2){
                    $res['flag1'] = '已完成';
                }else if($res['flag'] == 3){
                    $res['flag1'] = '已过期';
                }else if($res['flag'] == 4){
                    $res['flag1'] = '已发货';
                }else if($res['flag'] == 5){
                    $res['flag1'] = '已取消';
                }else if($res['flag'] == 6){
                    $res['flag1'] = '取消中';
                }else if($res['flag'] == 7){
                    $res['flag1'] = '退货中';
                }else if($res['flag'] == 8){
                    $res['flag1'] = '退货成功';
                }else if($res['flag'] == 9){
                    $res['flag1'] = '退货失败';
                }else if($res['flag'] == -1){
                    $res['flag1'] = '已关闭';
                }else if($res['flag'] == -2){
                    $res['flag1'] = '订单无效';
                }
                $priceInfo = "原价：￥".$res['price'].",微信：￥".$res['wx_price'].",余额支付：￥".$res['yue_price'].",运费：￥".$res['yunfei'].",实付：￥".$res['true_price'];
                if($res['nav'] == 1){
                    $orderType = "发货订单";
                }else{
                    $orderType = "到店自取订单";
                }
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValueExplicit('A'.$num, $res['creattime'],'s')
                            ->setCellValueExplicit('B'.$num, $res['order_id'],'s')
                            ->setCellValueExplicit('C'.$num, $orderType,'s')
                            ->setCellValueExplicit('D'.$num, $res['title'],'s')
                            ->setCellValueExplicit('E'.$num, $res['price'],'s')
                            ->setCellValueExplicit('F'.$num, $priceInfo,'s')
                            ->setCellValueExplicit('G'.$num, $res['hxtime'], 's')
                            ->setCellValueExplicit('H'.$num, $res['address_get']['name'], 's')
                            ->setCellValueExplicit('I'.$num, $res['address_get']['mobile'], 's')
                            ->setCellValueExplicit('J'.$num, $res['address_get']['postalcode'], 's')
                            ->setCellValueExplicit('K'.$num, $res['address_get']['address'], 's')
                            ->setCellValueExplicit('L'.$num, $res['flag1'], 's');
            }

            $objPHPExcel->getActiveSheet()->setTitle('导出砍价订单');
            $objPHPExcel->setActiveSheetIndex(0);
            $excelname="砍价订单记录表";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
        
        // 处理30分钟未付款的订单
        $wforders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_bargain_order')." WHERE uniacid = :uniacid and flag = 0" , array(':uniacid' => $_W['uniacid']));
        foreach ($wforders as $key => &$res) {
            $st = $res['creattime'] + 1800;
            if($st < time()){
                $adata = array(
                    "flag" => 3
                );
                pdo_update("sudu8_page_bargain_order", $adata, array('id'=>$res['id']));
            }
        }

        $order_id = $_GPC['order_id'];
        $where = "";
        if($order_id){
            $where = " and order_id like '%".$order_id."%'";
        }
		$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_bargain_order')." WHERE uniacid = :uniacid $where" , array(':uniacid' => $_W['uniacid']));
		$pageindex = max(1, intval($_GPC['page']));
		$pagesize = 10;  
		$p = ($pageindex-1) * $pagesize;
		$pager = pagination($total, $pageindex, $pagesize); 
        $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_bargain_order')." WHERE uniacid = :uniacid $where order by creattime desc limit ".$p.",".$pagesize , array(':uniacid' => $_W['uniacid']));
        foreach ($orders as $key => &$res) {
            // 获取万能表单信息
            if ($res['form_id']) {
                $arr2ss = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['form_id']));
                $res['val'] = unserialize($arr2ss);
             }
            if(!stristr($res['thumb'], 'http')){
                $res['thumb'] = HTTPSHOST.$res['thumb'];
            }
            if($res['hxinfo'] != ""){
                $res['hxinfo'] = unserialize($res['hxinfo']);
                 if($res['hxinfo'][0]==1){
                     $res['hxinfoText']="总账号核销密码或后台核销";
                 }else{
                    $store = pdo_get("sudu8_page_store", ['id' => $res['hxinfo'][1], 'uniacid' => $uniacid]);
                    $staff = pdo_get("sudu8_page_staff", ['id' => $res['hxinfo'][2], 'uniacid' => $uniacid]);
                    $res['hxinfoText']="门店：".$store['title']." 员工：".$staff['realname'];
                 }
            }
            $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
            $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
			
			if($res['hxtime'] == 0 && $res['nav'] == 1){
				$res['hxtime'] = "无";
			}
            $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $res['openid'] ,':uniacid' => $_W['uniacid']));
            // 转换地址
            if(empty($res['m_address'])){
                $res['address_get'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$res['openid'],':id'=>$res['address']));
            }else{
                $res['address_get'] = unserialize($res['m_address']);
            }
        }
        include $this->template('orderlist');
    }


    //判断会员等级是否达到
    public function checkVipGrade($openid){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid ", array(':uniacid' => $uniacid, ':openid' => $openid));

        if(!$userinfo['allpay']){
            $allpays = pdo_fetchcolumn("SELECT sum(score) as allpays FROM ".tablename('sudu8_page_money')." WHERE uniacid = :uniacid and type = 'del' and uid = {$userinfo['id']} and message  IN (:str_1, :str_2, :str_3, :str_4, :str_5, :str_6, :str_7)", array(':uniacid' => $uniacid, ':str_1' => '论坛信息发布', ':str_2' => '微同城信息发布', ':str_3' => '文章全文',':str_4' => '视频消费',':str_5' => '音频消费',':str_6' => '店内支付扣余额',':str_7' => '店内支付微信支付'));
            if($allpays){
                $allpays = round($allpays,2);
            }
            $dan = pdo_fetch("SELECT sum(true_price) as price FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 2", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$dan){
                $dan['price'] = 0;
            }else{
                $dan['price'] = round($dan['price'],2);
            }
            $duo = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 2", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$duo){
                $duo['price'] = 0;
            }else{
                $duo['price'] = round($duo['price'],2);
            }
            $pt = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 2", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$pt){
                $pt['price'] = 0;
            }else{
                $pt['price'] = round($pt['price'],2);
            }
            $food = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_food_order')." WHERE uniacid = :uniacid and uid = :uid", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$food){
                $food['price'] = 0;
            }else{
                $food['price'] = round($food['price'],2);
            }

            $bargain = pdo_fetch("SELECT sum(true_price) as price FROM ".tablename('sudu8_page_bargain_order')." WHERE uniacid = :uniacid and uid = :uid", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$bargain){
                $bargain['price'] = 0;
            }else{
                $bargain['price'] = round($bargain['price'],2);
            }
            $userinfo['allpays'] = $allpays + floatval($dan['price']) + floatval($duo['price']) + floatval($pt['price']) + floatval($food['price']) + floatval($bargain['price']);
            pdo_update("sudu8_page_user", array('allpay' => $userinfo['allpays']), array("id" => $userinfo['id']));
        }else{
            $userinfo['allpays'] = $userinfo['allpay'];
        }
        $result = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_vipgrade')." WHERE uniacid = :uniacid and status = 1 and grade > 1 order by grade desc", array(':uniacid' => $uniacid));
        if($result){
            foreach ($result as $k => $v) {
                if($v['grade'] > $userinfo['grade']){
                    if($userinfo['allpays'] >= $v['upgrade']){
                        $receive = [];
                        $receive['uniacid'] = $uniacid;
                        $receive['vid'] = $v['id'];
                        if($userinfo['grade'] == 0){
                            $vipid = time().''.rand(100000,999999);
                            $data['vipid'] = $vipid;
                            $data['vipcreatetime'] = time();
                        }
                        $data['grade'] = $v['grade'];
                        if($v['score_feedback_flag'] == 1){
                            if($v['score_feedback'] > 0){
                                $receive['score'] = $v['score_feedback'];
                                $data['score'] = $userinfo['score'] + $v['score_feedback'];
                                $score_data = array(
                                    "uniacid" => $uniacid,
                                    "orderid" => '',
                                    "uid" => $userinfo['id'],
                                    "type" => "add",
                                    "score" => $v['score_feedback'],
                                    "message" => "会员等级回馈积分",
                                    "creattime" => time()
                                );
                                pdo_insert("sudu8_page_score", $score_data);
                            }
                        }
                        if($v['coupon_flag'] == 1){
                            $coupon_give = unserialize($v['coupon_give']);
                            if(count($coupon_give) > 0){
                                $receive['coupon'] = $v['coupon_give'];
                                foreach ($coupon_give as $k => $v) {
                                    $coup_info = [];
                                    for($i = 0;$i<$v['coupon_num'];$i++){
                                        $coup = [];
                                        $cid = $v['coupon_id'];
                                        if(count($coup_info) == 0){
                                            $coup_info = pdo_get("sudu8_page_coupon", array('uniacid' => $uniacid, 'id' => $cid));
                                        }

                                        $coup['uniacid'] = $uniacid;
                                        $coup['uid'] = $userinfo['id'];
                                        $coup['cid'] = $cid;
                                        $coup['btime'] = $coup_info['btime'];
                                        $coup['etime'] = $coup_info['etime'];
                                        $coup['ltime'] = time();
                                        pdo_insert('sudu8_page_coupon_user',$coup);
                                    }
                                }
                            }
                        }
                        $receive['openid'] = $openid;
                        pdo_insert('sudu8_page_vip_receive',$receive);
                        pdo_update("sudu8_page_user", $data, array('uniacid' => $uniacid, 'openid' => $openid));
                        break;
                    }
                }
            }
        }
    }
    public function addAllpay($price,$openid){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $str = '论坛信息发布,微同城信息发布,文章全文,视频消费,音频消费,店内支付扣余额,店内支付微信支付';
        $userinfo = pdo_fetch("SELECT id,allpay,grade FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid ", array(':uniacid' => $uniacid, ':openid' => $openid));

        if(!$userinfo['allpay']){
            $allpays = pdo_fetchcolumn("SELECT sum(score) as allpays FROM ".tablename('sudu8_page_money')." WHERE uniacid = :uniacid and type = 'del' and uid = {$userinfo['id']} and message  IN (:str_1, :str_2, :str_3, :str_4, :str_5, :str_6, :str_7)", array(':uniacid' => $uniacid, ':str_1' => '论坛信息发布', ':str_2' => '微同城信息发布', ':str_3' => '文章全文',':str_4' => '视频消费',':str_5' => '音频消费',':str_6' => '店内支付扣余额',':str_7' => '店内支付微信支付'));
            if($allpays){
                $allpays = round($allpays,2);
            }
            $dan = pdo_fetch("SELECT sum(true_price) as price FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 2", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$dan){
                $dan['price'] = 0;
            }else{
                $dan['price'] = round($dan['price'],2);
            }
            $duo = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 2", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$duo){
                $duo['price'] = 0;
            }else{
                $duo['price'] = round($duo['price'],2);
            }
            $pt = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 4", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$pt){
                $pt['price'] = 0;
            }else{
                $pt['price'] = round($pt['price'],2);
            }
            $food = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_food_order')." WHERE uniacid = :uniacid and uid = :uid", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$food){
                $food['price'] = 0;
            }else{
                $food['price'] = round($food['price'],2);
            }
            $bargain = pdo_fetch("SELECT sum(true_price) as price FROM ".tablename('sudu8_page_bargain_order')." WHERE uniacid = :uniacid and uid = :uid", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$bargain){
                $bargain['price'] = 0;
            }else{
                $bargain['price'] = round($bargain['price'],2);
            }
            $userinfo['allpays'] = $allpays + floatval($dan['price']) + floatval($duo['price']) + floatval($pt['price']) + floatval($food['price']) + floatval($bargain['price']);
            pdo_update("sudu8_page_user", array('allpay' => $userinfo['allpays']), array("id" => $userinfo['id']));
        }else{
            $userinfo['allpays'] = $userinfo['allpay'];
            $allpay = round($price + floatval($userinfo['allpay']),2);
            pdo_update("sudu8_page_user", array("allpay" => $allpay), array('id' => $userinfo['id']));
        }

    }

    // 砍价邀请管理
    public function doWebyaoqing() {
            
    	global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display', 'heixiao');
        $op = in_array($op, $ops) ? $op : 'display';

        $this->doovershare();

		$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_pt_share')." WHERE uniacid = :uniacid order by id desc" , array(':uniacid' => $_W['uniacid']));
		$pageindex = max(1, intval($_GPC['page']));
		$pagesize = 10;  
		$p = ($pageindex-1) * $pagesize;
		$pager = pagination($total, $pageindex, $pagesize); 

        $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_share')." WHERE uniacid = :uniacid order by id desc limit ".$p.",".$pagesize , array(':uniacid' => $_W['uniacid']));

        $guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));

        foreach ($orders as $key => &$res) {
        	
        	// 商品
        	$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid, ':id'=>$res['pid']));
        	$pro['thumb'] = HTTPSHOST.$pro['thumb'];
        	$res['pro'] = $pro;
            if(empty($guiz)){
                $overtime = $res['creattime']*1 + (24 * 3600);
            }else{
                $overtime = $res['creattime']*1 + ($guiz['pt_time'] * 3600);
            }
            $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
            $res['overtime'] = date("Y-m-d H:i:s",$overtime);
            // 团员
            $res['team'] = $this->getmytd($res['shareid']);
        } 
		
        include $this->template('yaoqing');
    }

    function getmytd($shareid){
    	global $_GPC, $_W;
        $uniacid = $_W['uniacid'];

        $alllist = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_order')." WHERE pt_order = :pt_order and flag != 0 and uniacid = :uniacid order by creattime" , array(':pt_order' => $shareid,':uniacid' => $_W['uniacid']));
        foreach ($alllist as $key => &$res) {
        	$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $res['openid'] ,':uniacid' => $_W['uniacid']));
        	$res['team'] = $userinfo;
        }
        return $alllist;

    }

    // 砍价邀请管理
    public function doWebptcate() {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display','post','delete');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];    

        //产品列表
        if ($op == 'display'){

			$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_pt_cate')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			$pageindex = max(1, intval($_GPC['page']));
			$pagesize = 10;  
			$p = ($pageindex-1) * $pagesize;
			$pager = pagination($total, $pageindex, $pagesize); 

            $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_pt_cate')." WHERE uniacid = :uniacid  order by num desc limit ".$p.",".$pagesize, array(':uniacid' => $uniacid));
        }


        //分类修改新增
        if ($op == 'post'){
            $id = intval($_GPC['id']);
            $cate = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_cate')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $id));


            if (checksubmit('submit')) {
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'num' => intval($_GPC['num']),         
                    'title' => $_GPC['title'],
                    'creattime' => time()
                );

                if (!$id) {
                    pdo_insert('sudu8_page_pt_cate', $data);
                } else {
                    pdo_update('sudu8_page_pt_cate', $data, array('id' => $id ,'uniacid' => $uniacid));
                }

                message('栏目 添加/修改 成功!', $this->createWebUrl('ptcate', array('op'=>'display')), 'success');
            }

        }

        //删除栏目
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('栏目不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_pt_cate', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('ptcate', array('op'=>'display')), 'success');
        }
        include $this->template('ptcate');
    }

    // 处理过期的订单
    function doovershare(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $now = time();

        $guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
        $allshare = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_share')." WHERE uniacid = :uniacid and flag in (1,2)" , array(':uniacid' => $_W['uniacid']));

        foreach ($allshare as $key => &$res) {

            //$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro') ." WHERE id = :id and uniacid = :uniacid", array(':id'=>$res['pid'],':uniacid' => $_W['uniacid']));

            $max = $res['pt_max']*1;
            $min = $res['pt_min']*1;

            $ct = $res['creattime'];
            if(empty($guiz)){
                $overtime = $ct*1 + 24 * 3600;  //砍价结束的时间
            }else{
                $overtime = $ct*1 + ($guiz['pt_time'] * 3600);  //砍价结束的时间
            }


            // 订单没过期
            if($overtime >= $now){
                // 砍价成功
                if($res['join_count']>=$min){
                    pdo_update("sudu8_page_pt_share",array("flag"=>2),array("id"=>$res['id']));
                }
            }

            // 订单已过期
            if($overtime < $now){
                // 砍价失败
                if($res['join_count']<$min){
                    // 自动成团
                    if($guiz['is_pt']==2){
                        // 生成机器人并完成订单
                        pdo_update("sudu8_page_pt_share",array("flag"=>2,"join_count"=>$min),array("id"=>$res['id']));
                        // 生成机器人订单
                        $xhjc = $min - $res['join_count'];
            
                        $tmp = range(1,30);
                        $arr = array_rand($tmp,$xhjc);

                        for($i=0; $i<$xhjc; $i++){
                            // 获取机器人信息
                            $jqr = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_robot')." WHERE id = :id" , array(':id' => $arr[$i]));
                            $jqrarr = array(
                                "uniacid" => $uniacid,
                                "openid" => $jqr['openid'],
                                "pt_order" => $res['shareid'],
                                "ck" => 2,
                                "jqr" => 2
                            );
                            pdo_insert("sudu8_page_pt_order",$jqrarr);
                        }

                    }else{
       					// 结束订单并退还所有的钱到余额
	        			pdo_update("sudu8_page_pt_share",array("flag"=>3),array("id"=>$res['id']));

	        			$lists = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_order') ." WHERE uniacid = :uniacid and pt_order = :pt_order and jqr = 1", array(':uniacid' => $uniacid, ':pt_order'=>$res['shareid']));
	        			
	        			foreach ($lists as $key1 => &$reb) {
	        				
	        				pdo_update("sudu8_page_pt_order",array("flag"=>5),array("id"=>$reb['id']));

	        				$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $reb['openid'] ,':uniacid' => $_W['uniacid']));
							$pdata=array(
		        					"uniacid"=>$uniacid,
		        					"openid"=>$reb['openid'],
		        					"ptorder"=> $reb['order_id'],
		        					"money"=>$reb['price'],
		        					"creattime"=>time(),
		        					"flag"=>1
		        					);
							pdo_insert("sudu8_page_pt_tx",$pdata);
	        				// 返回钱
			        				// $nowmoney = $user['money'];
			        				// $newmoney = $nowmoney*1 + $reb['price']*1;
	        				// 返回积分
	        				$nowscore = $user['score'];
	        				$newscore = $nowscore*1 + $reb['jf']*1;
                            if($reb['jf']>0){
                                $xfscore=array(
                                        "uniacid"=>$uniacid,
                                        "orderid"=>$reb['id'],
                                        "uid"=>$user["id"],
                                        "type" => "add",
                                        "score" => $reb['jf']*1,
                                        "message" => "砍价退还积分",
                                        "creattime" => time()
                                );
                                pdo_insert("sudu8_page_score", $xfscore);
                            }
	        				pdo_update("sudu8_page_user",array("score"=>$newscore),array("openid"=>$user['openid']));
	        				// 返回优惠券
	        				if($reb['coupon']!=0){
	        					// 先判断优惠券有没有过期了
	        					$coupon = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $reb['coupon'],':uniacid' => $_W['uniacid']));
	        					// 如果没有过期更改优惠券状态
	        					if($coupon['etime']==0){
                                    pdo_update("sudu8_page_coupon_user", array("utime"=>0,"flag"=>0), array("id" => $reb['coupon']));
                                }else{
                                    if($now <= $coupon['etime']){
                                        pdo_update("sudu8_page_coupon_user", array("utime"=>0,"flag"=>0), array("id" => $reb['coupon']));
                                    }
                                }
	        				}
	        			}	 
       				}
                }else{
                    pdo_update("sudu8_page_pt_share",array("flag"=>4),array("id"=>$res['id']));
                }
            }
        }
    }
}
