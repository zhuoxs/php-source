<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        if($cfg['miyao']!=$_GPC['miyao']){
          exit(json_encode(array('error' =>2)));
        }

        if(empty($_GPC['del'])){
            if($cfg['ljcjk']==1){
              $qf=" and qf=1";
            }
        }       
        

        $pindex = max(1, intval($_GPC['page']));
	    $psize = 200;
        if (($pindex - 1) * $psize>30000){ //一次3万条的总数都不用求了 直接返回空白
            return null;
        }
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_tbgoods')." where weid='{$_W['uniacid']}' {$qf}");
        $pager = pagination($total, $pindex, $psize);
        if (($pindex - 1) * $psize>$total){ //3万内的求出总数 如果需要的数量比总数还多的 也退出已经没数据了
            return null;
        }
		$list = pdo_fetchall("select title,price,pic_url,weid,num_iid,tjcontent,coupons_url,coupons_price,tk_rate,org_price,quan_id,istmall from ".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' {$qf} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		
		
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
			$list1[$key]['title'] = urlencode($value['title']);//商品名称
			$list1[$key]['price'] = $value['price'];//价格
            $list1[$key]['pic_url'] = $value['pic_url'];//图片地址
            $list1[$key]['weid'] = $value['weid'];//公众号ID
            $list1[$key]['num_iid'] = $value['num_iid'];//商品ID
            $list1[$key]['tjcontent'] = urlencode($value['tjcontent']);//推荐内容
            $list1[$key]['coupons_url'] = $value['coupons_url'];//优惠券链接
            $list1[$key]['coupons_price'] = $value['coupons_price'];//优惠券面额
            $list1[$key]['tk_rate'] = $value['tk_rate'];//佣金比例          
            $list1[$key]['org_price'] = $value['org_price'];//商品原价
            $list1[$key]['quan_id'] = $value['quan_id'];//优惠券ID
            $list1[$key]['zgf'] = $cfg['zgf'];//自购返比例
            $list1[$key]['fxtype'] = $cfg['fxtype'];//0 不返  1积分  2余额
		}
        exit(urldecode(json_encode(array('total' => $total, 'content' => $list1))));
?>