<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        if($cfg['miyao']!=$_GPC['miyao']){
          exit(json_encode(array('error' =>2)));
        }

        $pindex = max(1, intval($_GPC['page']));
	    $psize = 200;
		$list = pdo_fetchall("select title,price,pic_url,weid,num_iid,tjcontent,coupons_url,coupons_price,tk_rate,org_price from ".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' and dingxianurl<>'' order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_tbgoods')." where weid='{$_W['uniacid']}' and dingxianurl<>''");
		$pager = pagination($total, $pindex, $psize);
        //yongjin 佣金
        //echo "<pre>";
        //print_r($list);
        //exit;
        

        foreach ($list as $key => $value) {
            if($cfg['fxkg']==1){//开启返现
              $yongjin=$value['price']*$value['tk_rate']/100;
              $fanyong=$cfg['zgf']*$yongjin/100;
              $fanyong=number_format($fanyong, 2, '.', '');
            }
            

			$mc = mc_fetch($value['openid']);
			$list1[$key]['title'] = urlencode($value['title']);
			$list1[$key]['price'] = $value['price'];
            $list1[$key]['pic_url'] = $value['pic_url'];
            $list1[$key]['weid'] = $value['weid'];
            $list1[$key]['num_iid'] = $value['num_iid'];
            $list1[$key]['tjcontent'] = urlencode($value['tjcontent']);
            $list1[$key]['coupons_url'] = $value['coupons_url'];
            $list1[$key]['coupons_price'] = $value['coupons_price'];//优惠券面额
            $list1[$key]['tk_rate'] = $value['tk_rate'];//优惠券面额            
            $list1[$key]['yongjin'] = $yongjin;
            $list1[$key]['fanyong'] = $fanyong;
            $list1[$key]['org_price'] = $value['org_price'];
            //$list1[$key]['quan_id'] = $value['quan_id'];
		}
        exit(urldecode(json_encode(array('total' => $total, 'content' => $list1))));
?>