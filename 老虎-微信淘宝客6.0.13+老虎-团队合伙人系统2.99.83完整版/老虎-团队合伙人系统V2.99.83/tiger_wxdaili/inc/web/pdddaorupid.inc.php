<?php
 global $_W,$_GPC;
		load()->func('tpl');
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

// 
//        echo "<pre>";
//    	print_r($import);
//    	exit;
		
		
		foreach($import as $k=>$v){
			 $arr=array(
					'weid'=>$_W['uniacid'],
					'type'=>0,
					'pid'=>$v[1],
					'createtime'=>time(),
			 );
			 $go = pdo_fetch("SELECT * FROM " . tablename("tiger_wxdaili_pddpid") . " WHERE weid = '{$_W['uniacid']}' and  pid='{$v[1]}'");
			 if(empty($go)){
			 	 pdo_insert("tiger_wxdaili_pddpid",$arr);
			 }		 
		}
		message('导入成功', $this -> createWebUrl('pddpidlist', array('op' => 'display')), 'success');
		
		
		
	}
         include $this->template('pdddaorupid');