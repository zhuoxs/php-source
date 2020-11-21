<?php
	global $_W,$_GPC;
	include 'common.php';
	
	$sid=intval($_GPC['sid']);
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	$cx=$_GPC['cx'];
	
	$res=pdo_fetchall("SELECT a.*,b.pimg,b.ptitle FROM ".tablename('bc_community_mall_orders')." as a left join ".tablename('bc_community_mall_goods')." as b on a.pid=b.id WHERE a.weid=" . $_W['uniacid'] . $cx." AND a.sid=".$sid." ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
	
		$ht = '';
        foreach ($res as $key => $item) {
       	
        $ht.='<div class="mui-row ml05 mr05 c-wh mt05 pt05 uc-a1 pl05 pr05 oneinfo">'
						.'<div class="mui-col-xs-3">'
							.'<img src="'.tomedia($item['pimg']).'" style="width:60px;height:60px;">'
						.'</div>'
						.'<div class="mui-col-xs-9">'
							.'<p class="t-sbla mb0">'.$item['ptitle'].'</p>'
							.'<p class="mb0 tx-r ulev-1 t-gra">共'.$item['pnum'].'件商品 实付款： <span class="t-red fb">￥'.$item['orderprice'].'</span></p>'
						.'</div>'
						.'<div class="mui-col-xs-12 tx-r pt05 pb05">';
						//订单状态9未支付1已付款未发货2已付款已发货3已收到货待确认4收货方自然确认5有问题需人工介入处理6人工客服确认7已关闭订单
						if($item['postatus']==9){
							$ht.='<button type="button" class="mui-btn mui-btn-default mui-btn-outlined uc-a2 pt02 pb02 ulev-2 mr05">关闭订单</button>'
							.'<button type="button" class="mui-btn mui-btn-danger mui-btn-outlined uc-a2 pt02 pb02 ulev-2 mr05" onclick="ck('.$item['id'].',1);">查看订单</button>';
						}
						if($item['postatus']==1){
							$ht.='<button type="button" class="mui-btn mui-btn-default mui-btn-outlined uc-a2 pt02 pb02 ulev-2 mr05">去发货</button>'
							.'<button type="button" class="mui-btn mui-btn-danger mui-btn-outlined uc-a2 pt02 pb02 ulev-2" onclick="ck('.$item['id'].',1);">查看订单</button>';
						}						
						if($item['postatus']==2){
							$ht.='<button type="button" class="mui-btn mui-btn-default mui-btn-outlined uc-a2 pt02 pb02 ulev-2 mr05">待确认</button>'
							.'<button type="button" class="mui-btn mui-btn-danger mui-btn-outlined uc-a2 pt02 pb02 ulev-2" onclick="ck('.$item['id'].',1);">查看订单</button>';
						}
						if($item['postatus']==3 || $item['postatus']==4){
							$ht.='<button type="button" class="mui-btn mui-btn-danger mui-btn-outlined uc-a2 pt02 pb02 ulev-2" onclick="ck('.$item['id'].',1);">查看订单</button>';
						}
						if($item['postatus']==5 || $item['postatus']==6){
							$ht.='<button type="button" class="mui-btn mui-btn-default mui-btn-outlined uc-a2 pt02 pb02 ulev-2 mr05">平台介入订单</button>'
							.'<button type="button" class="mui-btn mui-btn-danger mui-btn-outlined uc-a2 pt02 pb02 ulev-2" on="ck('.$item['id'].',1);">查看订单</button>';
						}
						if($item['postatus']==7){
							
							$ht.='<button type="button" class="mui-btn mui-btn-default mui-btn-outlined uc-a2 pt02 pb02 ulev-2  mr05" on="ck('.$item['id'].',1);">已关闭</button>'
							.'<button type="button" class="mui-btn mui-btn-danger mui-btn-outlined uc-a2 pt02 pb02 ulev-2" on="ck('.$item['id'].',1);">查看订单</button>';
						}
						$ht.='</div>'
					.'</div>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>