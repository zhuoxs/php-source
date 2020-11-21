<?php
 global $_W,$_GPC;
		load()->func('tpl');
        $fzlist = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_fztype") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY px desc");
        $ztlist = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_zttype") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY px desc");
		if(checksubmit('submit')){
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
	    
//		$insert = array(
//				'uniacid' => $_W['uniacid'],
//				'title' => $_GPC['title'],
//				'header' => $header,
//				'createtime'=>$day,
//			);
//		 if($insert){
//		 	pdo_insert($this->table_reply, $insert);
//		 }else{
//		 	message('提交失败','','error');
//		 }
//		$time=date('y-m-d',time());


//        echo "<pre>";
//    	print_r($import);
//    	exit;
    	
        $type=$_GPC['type'];
        $yjtype=$_GPC['yjtype'];
        $zt=$_GPC['zt'];
        if(empty($yjtype) || $yjtype==1){
            if($import){
			foreach($import as $data){
                if(empty($data[0])){
                    continue;
                }
               	    preg_match_all('|满([\d\.]+).*元减([\d\.]+).*元|ism', $data[17], $matches);
                	//echo "<pre>";
                	//	echo $data[15];
                	//print_r($matches);
                	$Quan_id=$this->strurl($data[18]);
                	
                	if($data[13]=='天猫'){
                		$shoptype='B';
                	}else{
                		$shoptype='C';
                	}
                	
                	
				      $item = array(
				      	'weid' => $_W['uniacid'],
				      	'fqcat'=>$type,//分类
								'zt'=>$zt,
                        //'yjtype'=>1,
                        'shoptype'=>$shoptype,
				      	 'itemid'=>$data[0],//商品ID
				      	 'itemtitle'=>$data[1],//商品名称
                         'itemdesc'=>$data[1],//推荐内容
				      	 'itempic'=>$data[2],//主图地址
				      	 //'item_url'=>$data[3],//详情页地址
				      	 'sellernick'=>$data[12],//店铺名称
				      	 'itemendprice'=>$data[6]-$matches[2][0],//商品价格
                         'itemsale'=>$data[7],//月销售
				      	 'tkrates'=>$data[8],//通用佣金比例
				      	 'quan_id'=>$data[14],
				      	 //'yongjin'=>$data[8],//通用佣金
                         //活动状态event_zt
                         //活动收入比event_yjbl
                         //活动佣金event_yj
                         //活动开始event_start_time
                         //活动结束event_end_time
                         // 'userid'=>$data[9],//卖家旺旺
                          //'tk_durl'=>$data[10],//淘客短链接
                          //'click_url'=>$data[11],//淘客长链接
                          //'taokouling'=>$data[12],//淘口令
                          'couponnum'=>$data[15],//优惠券总量
                          'couponsurplus'=>$data[16],//优惠券剩余
                          
                          'couponmoney'=>$matches[2][0],//优惠券面额
                          'couponexplain'=>$data[17],//'优惠券使用条件',  
                          'couponstarttime'=>strtotime($data[18]),//优惠券开始
                          'couponendtime'=>strtotime($data[19]),//优惠券结束
                          //'couponurl'=>$data[18],//优惠券链接
                          //'quan_id'=>$Quan_id,//优惠券ID
                          'itemprice'=>$data[6],
                          //'coupons_tkl'=>$data[19],//优惠淘口令
                          'createtime'=>TIMESTAMP,
				      	);
                    $go = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and  itemid='{$data[0]}' ORDER BY id desc");
                    if(empty($go)){
                      pdo_insert($this->modulename."_newtbgoods",$item);
                    }else{
                      pdo_update($this->modulename."_newtbgoods", $item, array('itemid' => $data[0]));
                    }
					
				}
                 message('导入成功', $this -> createWebUrl('tbgoods', array('op' => 'display')), 'success');
			}
        
        }elseif($yjtype==2){//高佣金
          if($import){
			foreach($import as $data){
                if(empty($data[0])){
                    continue;
                }
               	    if($data[13]=='天猫'){
                		$shoptype='B';
                	}else{
                		$shoptype='C';
                	}
                
                preg_match_all('|满([\d\.]+).*元减([\d\.]+).*元|ism', $data[17], $matches);
                $Quan_id=$this->strurl($data[23]);
				      $item = array(
				      	'weid' => $_W['uniacid'],
				      	'fqcat'=>$type,//分类
								'zt'=>$zt,
				      	'shoptype'=>$shoptype,
                        //'yjtype'=>1,
				      	 'itemid'=>$data[0],//商品ID
				      	 'itemtitle'=>$data[1],//商品名称
                         'itemdesc'=>$data[1],//推荐内容
				      	 'itempic'=>$data[2],//主图地址
				      	 //'item_url'=>$data[3],//详情页地址
				      	 'sellernick'=>$data[12],//店铺名称
				      	 'itemendprice'=>$data[6]-$matches[2][0],//商品价格
                         'itemsale'=>$data[7],//月销售
				      	 'tkrates'=>$data[8],//通用佣金比例
				      	 'quan_id'=>$data[14],
				      	 //'yongjin'=>$data[8],//通用佣金
                         //活动状态event_zt
                         //活动收入比event_yjbl
                         //活动佣金event_yj
                         //活动开始event_start_time
                         //活动结束event_end_time
                         // 'userid'=>$data[9],//卖家旺旺
                          //'tk_durl'=>$data[10],//淘客短链接
                          //'click_url'=>$data[11],//淘客长链接
                          //'taokouling'=>$data[12],//淘口令
                          'couponnum'=>$data[15],//优惠券总量
                          'couponsurplus'=>$data[16],//优惠券剩余
                          
                          'couponmoney'=>$matches[2][0],//优惠券面额
                          'couponexplain'=>$data[17],//'优惠券使用条件',  
                          'couponstarttime'=>strtotime($data[18]),//优惠券开始
                          'couponendtime'=>strtotime($data[19]),//优惠券结束
                          //'couponurl'=>$data[18],//优惠券链接
                          //'quan_id'=>$Quan_id,//优惠券ID
                          'itemprice'=>$data[6],
                          //'coupons_tkl'=>$data[19],//优惠淘口令
                          'createtime'=>TIMESTAMP,
				      	);
					$go = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and  itemid='{$data[0]}' ORDER BY id desc");
                    if(empty($go)){
                      pdo_insert($this->modulename."_newtbgoods",$item);
                    }else{
                      pdo_update($this->modulename."_newtbgoods", $item, array('itemid' => $data[0]));
                    }
				}
                 message('导入成功', $this -> createWebUrl('tbgoods', array('op' => 'display')), 'success');
			}
        }elseif($yjtype==3){//618清单
          if($import){
             // echo "<pre>";
             // print_r($import);
            //      exit;
			foreach($import as $data){
                if(empty($data[0])){
                    continue;
                }
                $yongjin=$data[11]*$data[8]/100;//佣金
                $youhuiq=$data[7]-$data[11];//优惠券面额
				      $item = array(
				      	'weid' => $_W['uniacid'],
				      	 'type'=>0,
								 'zt'=>$zt,
                         //'yjtype'=>0,
				      	 'num_iid'=>$data[3],//商品ID
				      	 'title'=>$data[4],//商品名称
                         'tjcontent'=>$data[4],//推荐内容
				      	 'pic_url'=>$data[6],//主图地址
				      	 'item_url'=>$data[5],//详情页地址
				      	 'shop_title'=>$data[1],//店铺名称
                         'org_price'=>$data[7],//原价
				      	 'price'=>$data[11],//商品价格
                         'goods_sale'=>rand(2330,10000),//月销售
				      	 'tk_rate'=>$data[8],//通用佣金比例
				      	 'yongjin'=>$yongjin,//通用佣金
                         'event_zt'=>'',//活动状态event_zt
                         'event_yjbl'=>'',//活动收入比event_yjbl
                         'event_yj'=>'',//活动佣金event_yj
                         'event_start_time'=>strtotime($data[14]),//活动开始event_start_time
                         'event_end_time'=>strtotime($data[15]),//活动结束event_end_time
                          'nick'=>$data[1],//卖家旺旺
                          'tk_durl'=>'',//淘客短链接
                          'click_url'=>'',//淘客长链接
                          'taokouling'=>'',//淘口令
                          'coupons_total'=>$data[12],//优惠券总量
                          'coupons_take'=>$data[13],//优惠券剩余
                          'coupons_price'=>$youhuiq,//优惠券面额
                          'quan_condition'=>$data[10],//'优惠券使用条件',  
                          'coupons_start'=>strtotime($data[14]),//优惠券开始
                          'coupons_end'=>strtotime($data[15]),//优惠券结束
                          'coupons_url'=>'',//优惠券链接
                          'coupons_tkl'=>'',//优惠淘口令
                          
                          'zt'=>$zt,//专题ID
                          'createtime'=>TIMESTAMP,
				      	);
					$go = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tbgoods") . " WHERE weid = '{$_W['uniacid']}' and  num_iid='{$data[3]}' ORDER BY id desc");
                    if(empty($go)){
                      pdo_insert($this->modulename."_newtbgoods",$item);
                    }else{
                      pdo_update($this->modulename."_newtbgoods", $item, array('num_iid' => $data[3]));
                    }
				}
                 message('导入成功', $this -> createWebUrl('tbgoods', array('op' => 'display')), 'success');
			}
        }
        //echo '<pre>';
       // print_r($import);
        //exit;
		
		}
         include $this->template('tbgoodform');