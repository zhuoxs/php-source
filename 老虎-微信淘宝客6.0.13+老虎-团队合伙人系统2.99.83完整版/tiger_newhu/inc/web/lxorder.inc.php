<?php
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
		$psize = 20;
        $order=$_GPC['order'];
        $zt=$_GPC['zt'];
        $op=$_GPC['op'];
        $dd=$_GPC['dd'];
        $ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
        


       if($op=='seach'){
           if (!empty($order)){
              $where .= " and (orderid='{$order}' or tgwid='{$order}')  ";
            }
//            if (!empty($zt)){
//              $where .= " and orderzt='{$zt}'";
//            }
           $day=date('Y-m-d');
           $day=strtotime($day);//今天0点时间戳  


            if($zt==1){//已激活
              $where.=" and xrzt='已激活'";
            }
            if($zt==2){//结算
              $where.=" and xrzt='已首购'";
            }
       }

        

		$list = pdo_fetchall("select * from ".tablename($this->modulename."_lxorder")." where weid='{$_W['uniacid']}' {$where} order by addtime desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_lxorder')." where weid='{$_W['uniacid']}'  {$where}");
		$pager = pagination($total, $pindex, $psize);
        $totalsum = pdo_fetchcolumn("SELECT sum(xgyg) FROM " . tablename($this->modulename.'_lxorder')." where weid='{$_W['uniacid']}'  {$where}");
        
        foreach($list as $k=>$v){
            $list1[$k]['addtime']=date('Y-m-d H:i:s',$v['addtime']);
            $list1[$k]['jhtime']=date('Y-m-d H:i:s',$v['jhtime']);
            $list1[$k]['sgtime']=date('Y-m-d H:i:s',$v['sgtime']);
            $list1[$k]['qrshtime']=date('Y-m-d H:i:s',$v['qrshtime']);
            $list1[$k]['newtel']=$v['newtel'];
            $list1[$k]['xrzt']=$v['xrzt'];
            $list1[$k]['ddlx']=$v['ddlx'];
            $list1[$k]['fxyh']=$v['fxyh'];
            $list1[$k]['mtid']=$v['mtid'];
            $list1[$k]['mtname']=$v['mtname'];
            $list1[$k]['tgwid']=$v['tgwid'];
            $list1[$k]['tgwname']=$v['tgwname'];
            $list1[$k]['orderid']=$v['orderid'];
            $list1[$k]['createtime']=date('Y-m-d H:i:s',$v['createtime']);
        }


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
//                echo '<pre>';
//            print_r($highestRow);
//          exit;

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
           

            if(!empty($import)){
////          	
//          	echo "<pre>";
//          	print_r($import);
//          	exit;
////          	
//          	
//          	
                foreach($import as $k=>$v){               
                   //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[2]),FILE_APPEND);
                   //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[0]),FILE_APPEND);
                   if(empty($v[0])){
                   	 $addtime='';
                   }else{
                   	 $addtime=strtotime($v[0]);
                   }
                   if(empty($v[1])){
                   	 $jhtime='';
                   }else{
                   	 $jhtime=strtotime($v[1]);
                   }
                   if(empty($v[2])){
                   	 $sgtime='';
                   }else{
                   	 $sgtime=strtotime($v[2]);
                   }
                   if(empty($v[3])){
                   	 $qrshtime='';
                   }else{
                   	 $qrshtime=strtotime($v[3]);
                   }
                   $data=array(
                       'weid'=>$_W['uniacid'],
                       'addtime'=>$addtime,
                       'jhtime'=>$jhtime,
                       'sgtime'=>$sgtime,
                       'qrshtime'=>$qrshtime,
                       'newtel'=>$v[4],
                       'xrzt'=>$v[5],
                       'ddlx'=>$v[6],
                       'fxyh'=>$v[7],
                       'mtid'=>$v[8],
                       //'mtname'=>$v[8],
                       'tgwid'=>$v[10],
                       'tgwname'=>$v[11],
                       'orderid'=>$v[12],                     
                       'createtime'=>TIMESTAMP,
                   );
                   $ord=pdo_fetch ( 'select * from ' . tablename ( $this->modulename . "_lxorder" ) . " where weid='{$_W['uniacid']}' and newtel='{$v[4]}'" );
                   if(empty($ord)){
                     pdo_insert ($this->modulename . "_lxorder", $data );
                   }else{
                     pdo_update($this->modulename . "_lxorder",$data, array ('newtel' =>$data['newtel'],'weid'=>$_W['uniacid']));
                   }
                                 
                }
            }
            message('导入成功', referer(), 'success');
        }


        include $this->template ( 'lxorder' );

