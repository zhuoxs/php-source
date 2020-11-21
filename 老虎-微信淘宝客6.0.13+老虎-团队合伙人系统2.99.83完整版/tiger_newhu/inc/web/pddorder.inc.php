<?php
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
		$psize = 20;
        $order=$_GPC['order'];
        $zt=$_GPC['zt'];
        $op=$_GPC['op'];
        $dd=$_GPC['dd'];
        
        if($_GPC['tb']==1){//一键同步订单
	        	include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/pdd.php"; 
				$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$_W['uniacid']}'");
				$owner_name=$pddset['ddjbbuid'];				
				$start_time=strtotime($_GPC['starttime']);
				$end_time=strtotime($_GPC['endtime']);
				$page=$_GPC['page'];
				if(empty($page)){
					$page=1;
				}	
         // $page=2;
				//echo $end_time;
				$res=pddtgworder1($owner_name,$page,$start_time,$end_time,$p_id);	
               // echo $page;
               // echo "<pre>";
               // print_r($res);
         // exit;
				if(!empty($orderlist['error_response']['error_msg'])){
					message($orderlist['error_response']['error_msg'], referer(), 'success');
					//echo $orderlist['error_response']['error_msg'];
					//exit;
				}
				$orderlist=$res['order_list_get_response']['order_list'];				
				
				
				foreach($orderlist as $k=>$v){
					$row = pdo_fetch("SELECT * FROM " . tablename($this->modulename.'_pddorder') . " WHERE weid='{$_W['uniacid']}' and order_sn='{$v['order_sn']}'");
					$data=array(
						"weid"=>$_W['uniacid'],
						"order_sn" =>$v['order_sn'],
			            "goods_id" => $v['goods_id'],
			            "goods_name" => $v['goods_name'],
			            "goods_thumbnail_url" => $v['goods_thumbnail_url'],
			            "goods_quantity" => $v['goods_quantity'],
			            "goods_price" => $v['goods_price']/100,
			            "order_amount" => $v['order_amount']/100,
			            "order_create_time" => $v['order_create_time'],
			            "order_settle_time" => $v['order_settle_time'],
			            "order_verify_time" => $v['order_verify_time'],
			            "order_receive_time" => $v['order_receive_time'],
			            "order_pay_time" => $v['order_pay_time'],
			            "promotion_rate" => $v['promotion_rate']/10,
			            "promotion_amount" => $v['promotion_amount']/100,
			            "batch_no" => $v['batch_no'],
			            "order_status" =>$v['order_status'],
			            "order_status_desc" => $v['order_status_desc'],
			            "verify_time" => $v['verify_time'],
			            "order_group_success_time" => $v['order_group_success_time'],
			            "order_modify_at" => $v['order_modify_at'],
			            "status" => $v['status'],
			            "type" => $v['type'],
			            "group_id" => $v['group_id'],
			            "auth_duo_id" => $v['auth_duo_id'],
			            "custom_parameters" => $v['custom_parameters'],
			            "p_id" => $v['p_id'],
					);					
					if (!empty($row)){
	                    pdo_update($this->modulename."_pddorder", $data, array('order_sn' => $v['order_sn'],'weid'=>$_W['uniacid']));
	                    echo "更新订单：".$data['order_sn']."成功<br>";
	                }else{
	                    pdo_insert($this->modulename."_pddorder", $data);
	                    echo "新订单入库：".$data['order_sn']."成功<br>";
	                }
				}
				if(!empty($orderlist)){
					message('温馨提示：请不要关闭页面，采集任务正在进行中！', $this->createWebUrl('pddorder', array('tb' =>1,'page' => $page + 1,'starttime'=>$_GPC['starttime'],'endtime'=>$_GPC['endtime'])), 'success');
				}else{
                    message('更新订单成功', $this->createWebUrl('pddorder', array('page' => $page + 1,'starttime'=>$_GPC['starttime'],'endtime'=>$_GPC['endtime'])), 'success');
				}	
                        	
        }
        
        if(checksubmit('submitdel')){//删除
			if(!$_GPC['id']){
            	 message('请选择订单', referer(), 'error');
        	}
            foreach ($_GPC['id'] as $id){
                $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_pddorder') . " WHERE id = :id", array(':id' => $id));

                if (empty($row)){
                    continue;
                }
                pdo_delete($this->modulename."_pddorder",array('id'=>$id));
            }
            message('批量删除成功', referer(), 'success');        	
    }


       if($op=='seach'){
           if (!empty($order)){
              $where .= " and (order_sn='{$order}' or p_id='{$order}')  ";
            }
//            if (!empty($zt)){
//              $where .= " and orderzt='{$zt}'";
//            }
           $day=date('Y-m-d');
           $day=strtotime($day);//今天0点时间戳  

            if($dd==1){//当日
                $where.=" and order_modify_at>{$day}";        
            }
            if($dd==2){//昨天
                $day3=strtotime(date("Y-m-d",strtotime("-1 day")));//昨天时间
                $where.=" and order_modify_at>{$day3} and order_modify_at<{$day}";        
            }
            if($dd==3){//本月
                // 本月起始时间:
                $bbegin_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
                $where.=" and order_modify_at>{$bbegin_time}";        
            }
            if($dd==4){
                 // 上月起始时间:
                 //$sbegin_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
                 $sbegin_time = strtotime(date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))));//上个月开始时间
                 $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
                 if($zt==2){//按结算时间算
                   $where.="and order_modify_at>{$sbegin_time} and jstime<{$send_time}";
                 }else{
                   $where.="and order_modify_at>{$sbegin_time} and addtime<{$send_time}";
                 }
                 
            }
            if($zt==6){//已支付
              $where.=" and order_status=0";
            }
            if($zt==1){//已成团
              $where.=" and order_status=1";
            }
            if($zt==2){//确认收货
              $where.=" and order_status=2";
            }
            if($zt==5){//已经结算
            	$where.=" and order_status=5";
            }
       
       }
       
        echo $where ;

        

		$list = pdo_fetchall("select * from ".tablename($this->modulename."_pddorder")." where weid='{$_W['uniacid']}' {$where} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_pddorder')." where weid='{$_W['uniacid']}'  {$where}");
		$pager = pagination($total, $pindex, $psize);
//      $totalsum = pdo_fetchcolumn("SELECT sum(xgyg) FROM " . tablename($this->modulename.'_pddorder')." where weid='{$_W['uniacid']}'  {$where}");


		if(checksubmit('submitpdd')){
			
		    $header=$_GPC['header'];
		   
            
		    if($_FILES["excelfile"]["name"]){
                require_once  IA_ROOT.'/framework/library/phpexcel/PHPExcel.php';
                require_once  IA_ROOT.'/framework/library/phpexcel/PHPExcel/IOFactory.php';
                require_once  IA_ROOT.'/framework/library/phpexcel/PHPExcel/Reader/Excel5.php';
                require_once  IA_ROOT.'/framework/library/phpexcel/PHPExcel/Shared/Date.php';
                $path = IA_ROOT . "/addons/tiger_newhu/uploads/";
                if (!is_dir($path)) {
                    load()->func('file');
                    mkdirs($path, '0777');
                }
                $file     = time() . $_W['uniacid'] . ".xlsx";
                $filename = $_FILES["excelfile"]['name'];
                $tmpname  = $_FILES["excelfile"]['tmp_name'];
                if (empty($tmpname)) {
                    message('请选择要上传的Excel文件!', '', 'error');
                }
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                if ($ext != 'xlsx') {
                    message('请上传 xlsx 格式的Excel文件!', '', 'error');
                }
                $uploadfile = $path . $file;
                $result     = move_uploaded_file($tmpname, $uploadfile);
                if (!$result) {
                    message('上传Excel 文件失败, 请重新上传!', '', 'error');
                }
                $reader             = PHPExcel_IOFactory::createReader('Excel2007');
                $excel              = $reader->load($uploadfile);
                $sheet              = $excel->getActiveSheet();
                $highestRow         = $sheet->getHighestRow();
                $highestColumn      = $sheet->getHighestColumn();
                $highestColumnCount = PHPExcel_Cell::columnIndexFromString($highestColumn);
                $values             = array();
                  

                for ($row = 1; $row <= $highestRow; $row++) {
                        $rowValue = array();
                        for ($col = 0; $col < $highestColumnCount; $col++) {
                            $rowValue[] = $sheet->getCellByColumnAndRow($col, $row)->getValue();
                        }
                        if($row==1){
                            $header=implode("\r\n",$rowValue);
                        }else{
                            $import[]=$rowValue;
                        }
                }
            }
            
//           echo '<pre>';
//             print_r($import);
//           exit;
           

            if(!empty($import)){
                foreach($import as $k=>$v){               
                   //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[2]),FILE_APPEND);
                   //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[0]),FILE_APPEND);
                   if($v[3]=='转盘抽奖'){
                   	 continue;
                   }
                   $tgw=str_replace("推广位","",$v[3]);
                   $tgbl=str_replace("%","",$v[9]);
                   $data=array(
                       'weid'=>$_W['uniacid'],
                       'order_create_time'=>strtotime($v[0]),
                       'order_pay_time'=>strtotime($v[0]),
                       'order_group_success_time'=>strtotime($v[0]),
                       'order_verify_time'=>$v[1],
                       'order_sn'=>$v[2],
                       'goods_name'=>$v[4],
                       'goods_id'=>$v[5],
                       'order_status_desc'=>$v[6],
                       'order_amount'=>$v[8],
                       'promotion_amount'=>$v[10],
                       'promotion_rate'=>$tgbl,   
                       'p_id'=>$tgw,                
                       'createtime'=>TIMESTAMP,
                   );
                   $ord=pdo_fetch ( 'select order_sn from ' . tablename ( $this->modulename . "_pddorder" ) . " where weid='{$_W['uniacid']}' and goods_id='{$v[5]}'  and order_sn='{$v[2]}'" );
                   if(empty($ord)){
                      if(!empty($data['order_create_time'])){
                         pdo_insert ($this->modulename . "_pddorder", $data );
                      } 
                   }else{
                   echo 	$data['order_group_success_time'];
                     pdo_update($this->modulename . "_pddorder",$data, array ('order_sn' =>$data['order_sn'],'goods_id'=>$data['goods_id'],'weid'=>$_W['uniacid']));
                   }
                                 
                }
            }
            message('导入成功', referer(), 'success');
        }

        include $this->template ( 'pddorder' );

