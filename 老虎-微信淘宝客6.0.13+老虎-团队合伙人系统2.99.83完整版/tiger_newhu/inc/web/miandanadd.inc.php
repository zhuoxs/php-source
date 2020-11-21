<?php
global $_W,$_GPC;
		$cfg = $this->module['config'];
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$itemid=$_GPC['itemid'];
		
		if($operation=="rk"){
			$weid=$_W['uniacid'];
			$miandanset = pdo_fetch ( 'select * from ' . tablename ( $this->modulename . "_miandanset" ) . " where weid='{$weid}'" );
			include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
			include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
			$cfg['ptpid']=$miandanset['miandanpid'];
			$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
			$myck=$ck['data'];
			$turl="https://item.taobao.com/item.htm?id=".$itemid;
			$goods=cjsearch(1,$cfg['ptpid'],$tksign['sign'],$tksign['tbuid'],$_W,$cfg,$turl,2,'','','','',$tm,$px,$yhj);
			
			$res=hqyongjin($turl,$ck,$cfg,$this->modulename,'','',$tksign['sign'],$tksign['tbuid'],$_W,1,$itemid);
// 			echo "<pre>";
// 			print_r($goods);
// 			print_r($res);
// 			exit;
			
			$goods=$goods['result_list']['map_data'];
			if(!empty($goods['coupon_info'])){
				preg_match_all('|减(\d*)元|',$goods['coupon_info'], $returnArr);
				$conmany=$returnArr[1][0];   
			}else{
				$conmany=0;
			}       		
			 $itemendprice=$goods['zk_final_price']-$conmany;
			 if(empty($res['money'])){
				  $rhyurl=$res['itemurl'];
			 }else{
				  $rhyurl=$res['dclickUrl'];
			 }
			 $taokouling=$this->tkl($rhyurl,$goods['pict_url'],$goods['title']);
			 $status=1;
			 $list['weid']=$_W['uniacid'];
			 $list['rate']=$res['commissionRate'];  //佣金比例
			 $list['itemtitle']=$goods['title'];  //标题
			 $list['shoptype']=$goods['user_type'];  //1天猫
			 $list['itemid']=$goods['num_iid'];//商品ID
			 $list['itemprice']=$goods['zk_final_price'];//原价
			 $list['itemendprice']=$itemendprice;//折扣价-优惠券金额
			 $list['couponmoney']=$conmany;//优惠券金额
			 $list['itemsale']=$goods['volume'];//月销量
			 $list['url']=$goods['item_url'];//商品链接
			 $list['shopTitle']=$goods['shop_title'];//店铺名称                 
			 $list['itempic']=$goods['pict_url'];//图片
			 $list['pid']=$cfg['ptpid'];
			 $list['lm']=1;
			 $list['rhyurl']=$rhyurl;
			 $list['tkl']=$taokouling;
			 $list['couponnum']=$goods['coupon_remain_count'];//剩余优惠券数量//用的是总量  
			 
			pdo_insert($this->modulename."_miandangoods", $list);
			 message('商品添加成功！', $this -> createWebUrl('miandanadd', array('op' => 'display')), 'success');
// 			echo "<pre>";
// 			print_r($list);
// 			print_r($res);
// 			print_r($goods);
			exit;
		}
		
		
		
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_miandangoods") . " WHERE id = :id" , array(':id' => $id));
                if (empty($item)){
                    message('抱歉，商品不存在！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['itemtitle'])){
                    message('请输入商品名称名称！');
                }
                $data = array(
                    'weid'=>$_W['uniacid'],
                    'itemtitle'=>$_GPC['itemtitle'],
                    'shoptype'=>$_GPC['shoptype'],
                    'itemid'=>$_GPC['itemid'],
                    'itemprice'=>$_GPC['itemprice'],
                    'itemendprice'=>$_GPC['itemendprice'],
                    'couponmoney'=>$_GPC['couponmoney'],
                    'itemsale'=>$_GPC['itemsale'],
                    'url'  =>$_GPC['url'],
                    'shopTitle'=>$_GPC['shopTitle'],
                    'itempic'=>$_GPC['itempic'],
                    'pid'=>$_GPC['pid'],
                    'lm'=>$_GPC['lm'],
                    'rhyurl'=>$_GPC['rhyurl'],
                    'tkl'=>$_GPC['tkl'],
                    'couponnum'=>$_GPC['couponnum'],
                    'createtime' => TIMESTAMP,);               
                if (!empty($id)){
                    pdo_update($this->modulename."_miandangoods", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_miandangoods", $data);
                }
                message('商品更新成功！', $this -> createWebUrl('miandanadd', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_miandangoods") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，商品' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_miandangoods", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_miandangoods") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY id desc");
		
           
        }
        
        
        include $this -> template('miandanadd');