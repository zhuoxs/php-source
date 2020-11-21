<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        if($cfg['miyao']!=$_GPC['miyao']){
          exit(json_encode(array('error' =>2)));
        }

        $qun=$_GPC['qun'];
        $qftype=$_GPC['qftype'];// QQ群1   微信群2
        if($qftype==1){
          $qf=" and qqqun='{$qun}'";
        }elseif($qftype==2){
          $qf=" and weiqun='{$qun}'";
        }
        //echo $qf;
        
        

        //$pindex = max(1, intval($_GPC['page']));
	    //$psize = 200;
        //if (($pindex - 1) * $psize>30000){ //一次3万条的总数都不用求了 直接返回空白
        //    return null;
        //}
        //$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_tbgoodsqf')." where weid='{$_W['uniacid']}' {$qf} and qfzt=0");
       // $pager = pagination($total, $pindex, $psize);
        //if (($pindex - 1) * $psize>$total){ //3万内的求出总数 如果需要的数量比总数还多的 也退出已经没数据了
        //    return null;
        //}
		$list = pdo_fetch("select id,title,price,pic_url,weid,num_iid,tjcontent,coupons_url,coupons_price,tk_rate,org_price,quan_id,videoid,weiqun,qqqun,qfzt from ".tablename($this->modulename."_tbgoodsqf")." where weid='{$_W['uniacid']}' {$qf} and qfzt=0 order by id desc");
		
		
        //yongjin 佣金
        //echo "<pre>";
        //print_r($list);

        if(!empty($list)){
            $mc = mc_fetch($list['openid']);
            $list1['id'] = $list['id'];//商品ID
			$list1['title'] = urlencode($list['title']);//商品名称
			$list1['price'] = $list['price'];//价格
            $list1['pic_url'] = urlencode($list['pic_url']);//图片地址
            $list1['weid'] = $list['weid'];//公众号ID
            $list1['num_iid'] = trim($list['num_iid']);//商品ID
            $list1['tjcontent'] = urlencode($list['tjcontent']);//推荐内容
            $list1['coupons_url'] = urlencode($list['coupons_url']);//优惠券链接
            $list1['coupons_price'] = $list['coupons_price'];//优惠券面额
            $list1['tk_rate'] = $list['tk_rate'];//佣金比例          
            $list1['org_price'] = $list['org_price'];//商品原价
            $list1['quan_id'] = $list['quan_id'];//优惠券ID
            $list1['videoid'] = $list['videoid'];//视频ID
            $list1['weiqun'] = urlencode($list['weiqun']);//微信群
            $list1['qfzt'] = $list['qfzt'];//群发状态 1已经发过
        }else{
          $list1=urlencode('暂无数据');
        }

            
        //exit;
        

//        foreach ($list as $key => $value) {
//			$mc = mc_fetch($value['openid']);
//            $list1[$key]['id'] = $value['id'];//商品ID
//			$list1[$key]['title'] = urlencode($value['title']);//商品名称
//			$list1[$key]['price'] = $value['price'];//价格
//            $list1[$key]['pic_url'] = $value['pic_url'];//图片地址
//            $list1[$key]['weid'] = $value['weid'];//公众号ID
//            $list1[$key]['num_iid'] = $value['num_iid'];//商品ID
//            $list1[$key]['tjcontent'] = urlencode($value['tjcontent']);//推荐内容
//            $list1[$key]['coupons_url'] = $value['coupons_url'];//优惠券链接
//            $list1[$key]['coupons_price'] = $value['coupons_price'];//优惠券面额
//            $list1[$key]['tk_rate'] = $value['tk_rate'];//佣金比例          
//            $list1[$key]['org_price'] = $value['org_price'];//商品原价
//            $list1[$key]['quan_id'] = $value['quan_id'];//优惠券ID
//            $list1[$key]['videoid'] = $value['videoid'];//视频ID
//            $list1[$key]['weiqun'] = urlencode($value['weiqun']);//微信群
//            $list1[$key]['qfzt'] = $value['qfzt'];//群发状态 1已经发过
//		}
        exit(urldecode(json_encode($list1)));
?>