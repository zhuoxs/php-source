<?php
 global $_W,$_GPC;

        load ()->func ( 'tpl' );
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $fzlist = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_fztype") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY px desc");
        $ztlist = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_zttype") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY px desc");
        $time24=time()-86400;   
        //$qfsum = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('stat_msg_history')." where uniacid='{$_W['uniacid']}' and createtime>{$time24} order by id desc");
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_newtbgoods") . " WHERE id = :id" , array(':id' => $id));
                if (empty($item)){
                    message('抱歉，兑换商品不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['itemtitle'])){
                    message('请输入商品名称！');
                }
                if (empty($_GPC['itemid'])){
                    message('请输入商品ID！');
                }
                if (empty($_GPC['quan_id'])){
                    message('请输入优惠券ID！');
                }

                //echo strtotime($_GPC['coupons_end']);
                //echo "<pre>";
                //print_r($_GPC);
                //exit;
                $data = array(
                    'weid' => $_W['weid'], 
                    'fqcat'=>$_GPC['fqcat'],
                    'quan_id'=>$_GPC['quan_id'],
                    'itemid'=>$_GPC['itemid'],
					'itemtitle'=>$_GPC['itemtitle'],
					'itemshorttitle'=>$_GPC['itemshorttitle'],
					'itemdesc'=>$_GPC['itemdesc'],
					'itemprice'=>$_GPC['itemprice'],
					'itemsale'=>$_GPC['itemsale'],
					'itemsale2'=>$_GPC['itemsale2'],
					'conversion_ratio'=>$_GPC['conversion_ratio'],
					'itempic'=>$_GPC['itempic'],
					'itemendprice'=>$_GPC['itemendprice'],
					'shoptype'=>$_GPC['shoptype'],
					'userid'=>$_GPC['userid'],
					'sellernick'=>$_GPC['sellernick'],
					'tktype'=>$_GPC['tktype'],
					'tkrates'=>$_GPC['tkrates'],
					'ctrates'=>$_GPC['ctrates'],
					'cuntao'=>$_GPC['cuntao'],
					'tkmoney'=>$_GPC['tkmoney'],
					'tkurl'=>$_GPC['tkurl'],
					'couponurl'=>$_GPC['couponurl'],
					'planlink'=>$_GPC['planlink'],
					'couponmoney'=>$_GPC['couponmoney'],
					'couponsurplus'=>$_GPC['couponsurplus'],
					'couponreceive'=>$_GPC['couponreceive'],
					'couponreceive2'=>$_GPC['couponreceive2'],
					'couponnum'=>$_GPC['couponnum'],
					'couponexplain'=>$_GPC['couponexplain'],
					'couponstarttime'=>strtotime($_GPC['couponstarttime']),
					'couponendtime'=>strtotime($_GPC['couponendtime']),
					//'starttime'=>$_GPC['starttime'],
					'isquality'=>$_GPC['isquality'], 
					'item_status'=>$_GPC['item_status'],
					'report_status'=>$_GPC['report_status'],
					'is_brand'=>$_GPC['is_brand'],
					'is_live'=>$_GPC['is_live'],
					'videoid'=>$_GPC['videoid'],
					'activity_type'=>$_GPC['activity_type'],
                    'createtime' => TIMESTAMP);               
                if (!empty($id)){
                    pdo_update($this->modulename."_newtbgoods", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_newtbgoods", $data);
                }
                message('商品更新成功！', $this -> createWebUrl('tbgoods', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_newtbgoods") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，商品' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_newtbgoods", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
           
            if (checksubmit('submit')){
               foreach ($_GPC['id'] as $id){
                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_newtbgoods') . " WHERE id = :id", array(':id' => $id));
                    if (empty($row)){
                        continue;
                    }
                     pdo_delete($this->modulename."_newtbgoods", array('id' => $id));
                }
              message('批量删除成功', referer(), 'success');
            }
            if(checksubmit('submitzd')){//设置置顶
              if(!$_GPC['id']){
                message('请选择置顶商品', referer(), 'error');
              }
              foreach ($_GPC['id'] as $id){
                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_newtbgoods') . " WHERE id = :id", array(':id' => $id));
                    if (empty($row)){
                        continue;
                    }
                    pdo_update($this->modulename."_newtbgoods",array('zd'=>1), array('id' => $id));
                }
                message('批量置顶设置成功', referer(), 'success');
            }
            if(checksubmit('submitrq')){//设置叮咚抢
              if(!$_GPC['id']){
                message('请选择人气商品', referer(), 'error');
              }
              foreach ($_GPC['id'] as $id){
                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_newtbgoods') . " WHERE id = :id", array(':id' => $id));
                    if (empty($row)){
                        continue;
                    }
                    pdo_update($this->modulename."_newtbgoods",array('tj'=>2), array('id' => $id));
                }
                message('批量人气设置成功', referer(), 'success');
            }
            if(checksubmit('submitqxzd')){//取消置顶
              if(!$_GPC['id']){
                message('请选择商品', referer(), 'error');
              }
              foreach ($_GPC['id'] as $id){
                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_newtbgoods') . " WHERE id = :id", array(':id' => $id));
                    if (empty($row)){
                        continue;
                    }
                    pdo_update($this->modulename."_newtbgoods",array('zd'=>0), array('id' => $id));
                }
                message('批量【取消】成功', referer(), 'success');
            }
            if(checksubmit('submitqxfl')){//批量分类
              if(!$_GPC['id']){
                message('请选择商品', referer(), 'error');
              }
              foreach ($_GPC['id'] as $id){
                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_newtbgoods') . " WHERE id = :id", array(':id' => $id));
                    if (empty($row)){
                        continue;
                    }
                    pdo_update($this->modulename."_newtbgoods",array('fqcat'=>$_GPC['type']), array('id' => $id));
                }
                message('批量【分类】成功', referer(), 'success');
            }
            if(checksubmit('submitqxzt')){//批量专题
              if(!$_GPC['id']){
                message('请选择商品', referer(), 'error');
              }
              
              foreach ($_GPC['id'] as $id){
                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_newtbgoods') . " WHERE id = :id", array(':id' => $id));
                    if (empty($row)){
                        continue;
                    }
                 
                    $a=pdo_update($this->modulename."_newtbgoods",array('zt'=>$_GPC['zt']), array('id' => $id));
            
                }
                message('批量【专题分组】成功', referer(), 'success');
            }
            if(checksubmit('submitms')){//设置秒杀
              if(!$_GPC['id']){
                message('请选择秒杀商品', referer(), 'error');
              }
              foreach ($_GPC['id'] as $id){
                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_newtbgoods') . " WHERE id = :id", array(':id' => $id));
                    if (empty($row)){
                        continue;
                    }
                    pdo_update($this->modulename."_newtbgoods",array('tj'=>1), array('id' => $id));
                }
                message('批量秒杀设置成功', referer(), 'success');
            }
            if(checksubmit('submitmsqx')){//取消秒杀
              if(!$_GPC['id']){
                message('请选择秒杀商品', referer(), 'error');
              }
              foreach ($_GPC['id'] as $id){
                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_newtbgoods') . " WHERE id = :id", array(':id' => $id));
                    if (empty($row)){
                        continue;
                    }
                    pdo_update($this->modulename."_newtbgoods",array('tj'=>0), array('id' => $id));
                }
                message('批量取消秒杀成功', referer(), 'success');
            }

            if(checksubmit('qf')){//群发库
                if(!$_GPC['id']){
                    message('请选择入库商品', referer(), 'error');
                  }
                  foreach ($_GPC['id'] as $id){
                        $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_newtbgoods') . " WHERE id = :id", array(':id' => $id));
                        if (empty($row)){
                            continue;
                        }
                        pdo_update($this->modulename."_newtbgoods",array('qf'=>1), array('id' => $id));
                    }
                message('批量设置入库成功', referer(), 'success');  
            }

            if(checksubmit('scqf')){
                if(!$_GPC['id']){
                    message('请选择取消入库商品', referer(), 'error');
                  }
                  foreach ($_GPC['id'] as $id){
                        $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_newtbgoods') . " WHERE id = :id", array(':id' => $id));
                        if (empty($row)){
                            continue;
                        }
                        $a=pdo_update($this->modulename."_newtbgoods",array('qf'=>0), array('id' => $id));
                    }
                message('批量取消入库成功', referer(), 'success');  
            }

            $condition = '';
            $pindex = max(1, intval($_GPC['page']));
		    $psize = 20;  

            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['weid']}'  ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_newtbgoods')." where weid='{$_W['uniacid']}'");
		    $pager = pagination($total, $pindex, $psize);           
        }else if($operation == 'seach'){
            $key=$_GPC['key'];
            
            $yjtype=$_GPC['yjtype'];
            $type=$_GPC['type'];
            //$event_end_time=strtotime($_GPC['event_end_time']);//活动结束时间
            //$coupons_end=strtotime($_GPC['coupons_end']);//优惠券结束时间
            $tj=$_GPC['tj'];
            $istmall=$_GPC['istmall'];
            $tk_rate=$_GPC['tk_rate'];
            $px=$_GPC['px'];
            $zd=$_GPC['zd'];
            $zttype=$_GPC['zttype'];//专题分类ID
            $limit=$_GPC['limit'];
            if(empty($limit)){
               $limit=20;
            }

            if(!empty($yjtype)){
              $where.=" and activity_type='{$yjtype}'";
            }
            if(!empty($zd)){
              $where.=" and zd=1";
            }
            if(!empty($type)){
              $where.=" and fqcat='{$type}'";
            }
            if(!empty($zttype)){
            	$where.=" and zt='{$zttype}'";
            }

            if(!empty($_GPC['key'])){
                include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
                $arr=getfc($_GPC['key'],$_W);
                 foreach($arr as $v){
                     if (empty($v)) continue;
                    $where.=" and itemtitle like '%{$v}%'";
                 }
            }
            $num_iid=$_GPC['num_iid'];
            if(!empty($num_iid)){
              $where.=" and itemid={$num_iid}";
            }
            if(!empty($tj)){
            	if($tj==1){
            		$where.=" and tj=1";  
            	}elseif($tj==2){
            		$where.=" and activity_type='聚划算'";  
            	}elseif($tj==3){
            		$where.=" and activity_type='淘抢购'";  
            	}
                       
            }
            if(!empty($istmall)){
              if($istmall==1){
                   $where.=" and shoptype='C'";
                }elseif($istmall==2){
                   $where.=" and shoptype='B'";
                }   
            }
            if(!empty($tk_rate)){
               $where.=" and tkrates>{$tk_rate}";
            }
            if($px==1){
              $px=" tkrates desc";
            }elseif($px==2){
              $px=" tkrates asc";
            }elseif($px==3){
              $px=" tkmoney desc";
            }elseif($px==4){
              $px=" tkmoney asc";
            }elseif($px==5){
              $px=" itemendprice desc";
            }elseif($px==6){
              $px=" itemendprice asc";            
            }elseif($px==7){
              $px=" couponnum desc";
            }elseif($px==8){
              $px=" couponnum asc";            
            }elseif($px==12){
              $px=" couponmoney desc";            
            }elseif($px==13){
              $px=" couponmoney asc";            
            }else{
              $px=" id desc";
            }
           //echo $where;

            $pindex = max(1, intval($_GPC['page']));
		    $psize = $limit;  
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_newtbgoods") . " s WHERE weid = '{$_W['uniacid']}' {$where} ORDER BY {$px} LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_newtbgoods')." where weid='{$_W['uniacid']}' {$where}");
		    $pager = pagination($total, $pindex, $psize);    
            //echo '<pre>';
            //print_r($list);
            //exit;
            
        }else if($operation == 'qf'){//群发库
            $pindex = max(1, intval($_GPC['page']));
		    $psize = 20;  

            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and qf=1  ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_newtbgoods')." where weid='{$_W['uniacid']}' and qf=1");
            $pager = pagination($total, $pindex, $psize);    
        }
        

        include $this -> template('tbgoods');