<?php
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
		$psize = 20;
        $order=$_GPC['order'];
        $zt=$_GPC['zt'];
        $op=$_GPC['op'];
        $dd=$_GPC['dd'];
		
        $ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
        
        if(checksubmit('submitzdgd')){
				if(!$_GPC['id']){
                	 message('请选择订单', referer(), 'error');
            	}
                foreach ($_GPC['id'] as $id){
                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_tkorder') . " WHERE id = :id", array(':id' => $id));
//                  
//                  print_r($row);
//                  exit;
//                  
                    if (empty($row)){
                        continue;
                    }
                    pdo_update($this->modulename."_tkorder",array('zdgd'=>1), array('id' => $id));
                }
                message('批量设置【已跟单订单】成功', referer(), 'success');        	
        }
		if(checksubmit('submitwq')){
						if(!$_GPC['id']){
		                	 message('请选择订单', referer(), 'error');
		            	}
		                foreach ($_GPC['id'] as $id){
		                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_tkorder') . " WHERE id = :id", array(':id' => $id));
		//                  
		//                  print_r($row);
		//                  exit;
		//                  
		                    if (empty($row)){
		                        continue;
		                    }
		                    pdo_update($this->modulename."_tkorder",array('wq'=>1,'orderzt'=>'订单失效'), array('id' => $id));
		                }
		                message('批量设置【维权订单】成功', referer(), 'success');        	
		        }
        if(checksubmit('submitdel')){//删除
				if(!$_GPC['id']){
                	 message('请选择订单', referer(), 'error');
            	}
                foreach ($_GPC['id'] as $id){
                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_tkorder') . " WHERE id = :id", array(':id' => $id));

                    if (empty($row)){
                        continue;
                    }
                    pdo_delete($this->modulename."_tkorder",array('id'=>$id));
                }
                message('批量删除成功', referer(), 'success');        	
        }
        if($op=="gx"){//更新订单状态
        	    if(!$_GPC['id']){
                	 message('请选择订单', referer(), 'error');
            	}
                foreach ($_GPC['id'] as $id){
                    $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_tkorder') . " WHERE id = :id", array(':id' => $id));
//                  
//                  print_r($row);
//                  exit;
//                  
                    if (empty($row)){
                        continue;
                    }
                    pdo_update($this->modulename."_tkorder",array('orderzt'=>'订单失效'), array('id' => $id));
                }
                message('批量设置【订单失效】成功', referer(), 'success');
        }


       if($op=='seach'){
           if (!empty($order)){
              $where .= " and (orderid='{$order}' or tgwid='{$order}' or relation_id='{$order}')  ";
            }
//            if (!empty($zt)){
//              $where .= " and orderzt='{$zt}'";
//            }
           $day=date('Y-m-d');
           $day=strtotime($day);//今天0点时间戳  

            if($dd==1){//当日
                $where.=" and addtime>{$day}";        
            }
            if($dd==2){//昨天
                $day3=strtotime(date("Y-m-d",strtotime("-1 day")));//昨天时间
                $where.=" and addtime>{$day3} and addtime<{$day}";        
            }
            if($dd==3){//本月
                // 本月起始时间:
                $bbegin_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
                $where.=" and addtime>{$bbegin_time}";        
            }
            if($dd==4){
                 // 上月起始时间:
                 //$sbegin_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
                 $sbegin_time = strtotime(date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))));//上个月开始时间
                 $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
                 if($zt==2){//按结算时间算
                   $where.="and jstime>{$sbegin_time} and jstime<{$send_time}";
                 }else{
                   $where.="and addtime>{$sbegin_time} and addtime<{$send_time}";
                 }
                 
            }
            if($zt==1){//付款
              $where.=" and orderzt='订单付款'";
            }
            if($zt==2){//结算
              $where.=" and orderzt='订单结算'";
            }
            if($zt==3){//失效
              $where.=" and orderzt='订单失效'";
            }
       
       }

        

		$list = pdo_fetchall("select * from ".tablename($this->modulename."_tkorder")." where weid='{$_W['uniacid']}' {$where} order by addtime desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_tkorder')." where weid='{$_W['uniacid']}'  {$where}");
		$pager = pagination($total, $pindex, $psize);
        $totalsum = pdo_fetchcolumn("SELECT sum(xgyg) FROM " . tablename($this->modulename.'_tkorder')." where weid='{$_W['uniacid']}'  {$where}");


        if(checksubmit('submit')){
			$ddtype=$_GPC['ddtype'];
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
            
//               echo '<pre>';
//                 print_r($import);
//              exit;
//         

            if(!empty($import)){
                if($ddtype==0){
					ptorder($import,$_W['uniacid']);
				}elseif($ddtype==1){
					qdorder($import,$_W['uniacid']);
				}elseif($ddtype==2){
					dsforder($import,$_W['uniacid']);
				}
            }
            message('导入成功', referer(), 'success');
        }
		
		
		//渠道订单
		function qdorder($import,$weid){
			foreach($import as $k=>$v){               
			   //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[2]),FILE_APPEND);
			   //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[0]),FILE_APPEND);
			   $tbsbuid6=substr($v[23],-6);
			   $data=array(
			       'weid'=>$weid,
			       'addtime'=>strtotime($v[0]),
			       'orderid'=>$v[23],
			       'numid'=>$v[3],
			       'shopname'=>$v[4],
			       'title'=>$v[2],
			       'orderzt'=>$v[8],
			       'srbl'=>$v[10],
			       'fcbl'=>$v[11],
			       'fkprice'=>$v[12],
			       'xgyg'=>$v[13],
			       'mtid'=>'',
			       'mttitle'=>'',
			       'tgwid'=>'',
			       'tgwtitle'=>'',
			       'jstime'=>strtotime($v[16]),
			       'pt'=>$v[22],
				   'tbsbuid6'=>$tbsbuid6,
				   'relation_id'=>$v[26],
			       'createtime'=>TIMESTAMP,
			   );
			   $ord=pdo_fetch ( 'select orderid,orderzt from ' . tablename ("tiger_newhu_tkorder" ) . " where weid='{$weid}' and numid='{$v[3]}'  and orderid='{$v[23]}'" );
			   if(empty($ord)){
			      if(!empty($data['addtime'])){
			         pdo_insert ("tiger_newhu_tkorder", $data );
			      } 
			   }else{
				 if($ord['orderzt']!='订单失效'){
			       pdo_update("tiger_newhu_tkorder",$data, array ('orderid' =>$data['orderid'],'numid'=>$data['numid'],'weid'=>$weid));
				 }
			   }
			                 
			}
		}
		
		//普通订单
		function ptorder($import,$weid){
			foreach($import as $k=>$v){               
			   //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[2]),FILE_APPEND);
			   //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[0]),FILE_APPEND);
			   $tbsbuid6=substr($v[13],-6);
			   $data=array(
			       'weid'=>$weid,
			       'addtime'=>strtotime($v[2]),
			       'orderid'=>$v[13],
			       'numid'=>$v[5],
			       'shopname'=>$v[9],
			       'title'=>$v[7],
			       'orderzt'=>$v[15],
			       'srbl'=>$v[24],
			       'fcbl'=>$v[25],
			       'fkprice'=>$v[17],
			       'xgyg'=>$v[29],
			       'mtid'=>$v[33],
			       'mttitle'=>$v[34],
			       'tgwid'=>$v[35],
			       'tgwtitle'=>$v[36],
			       'jstime'=>strtotime($v[3]),
				   'tbsbuid6'=>$tbsbuid6,
			       'pt'=>$v[37],
			       'createtime'=>TIMESTAMP,
			   );
			   $ord=pdo_fetch ( 'select orderid,orderzt from ' . tablename ("tiger_newhu_tkorder" ) . " where weid='{$weid}' and numid='{$v[5]}'  and orderid='{$v[13]}'" );
			   if(empty($ord)){
			      if(!empty($data['addtime'])){
			         pdo_insert ("tiger_newhu_tkorder", $data );
			      } 
			   }else{
				  if($ord['orderzt']!='订单失效'){
					pdo_update("tiger_newhu_tkorder",$data, array ('orderid' =>$data['orderid'],'numid'=>$data['numid'],'weid'=>$weid));
				 }
			   }
			                 
			}
		}
		
		//第三方订单
		function dsforder($import,$weid){
			foreach($import as $k=>$v){               
			   //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[2]),FILE_APPEND);
			   //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[0]),FILE_APPEND);
			   $tbsbuid6=substr($v[24],-6);
			   $data=array(
			       'weid'=>$weid,
			       'addtime'=>strtotime($v[0]),
			       'orderid'=>$v[24],
			       'numid'=>$v[3],
			       'shopname'=>$v[5],
			       'title'=>$v[2],
			       'orderzt'=>$v[8],
			       'srbl'=>$v[10],
			       'fcbl'=>$v[11],
			       'fkprice'=>$v[14],
			       'xgyg'=>$v[13],
			       'mtid'=>$v[26],
			       'mttitle'=>$v[27],
			       'tgwid'=>$v[28],
			       'tgwtitle'=>$v[29],
			       'jstime'=>strtotime($v[16]),
				   'tbsbuid6'=>$tbsbuid6,
			       'pt'=>$v[22],
			       'createtime'=>TIMESTAMP,
			   );
			   $ord=pdo_fetch ( 'select orderid,orderzt from ' . tablename ("tiger_newhu_tkorder" ) . " where weid='{$weid}' and numid='{$v[3]}'  and orderid='{$v[24]}'" );
// 			   echo $ord['orderid']."-----".$ord['orderzt']."----".$v[8]."----";
// 			   echo "<pre>";
// 			   print_r($v);
// 			   exit;
			   if(empty($ord)){
			      if(!empty($data['addtime'])){
			         pdo_insert ("tiger_newhu_tkorder", $data );
			      } 
			   }else{
				   if($ord['orderzt']!='订单失效'){
					   pdo_update("tiger_newhu_tkorder",$data, array ('orderid' =>$data['orderid'],'numid'=>$data['numid'],'weid'=>$weid));
				   }
			     
			   }
			                 
			}
		}


        include $this->template ( 'tkorder' );

