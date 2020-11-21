<?php 

global $_GPC, $_W;
$opt = $_GPC['opt'];
$uniacid = $_W['uniacid'];
$all = pdo_fetchall("SELECT id FROM ".tablename('sudu8_page_video_pay')." WHERE uniacid = :uniacid  ORDER BY `creattime` DESC ", array(':uniacid' => $uniacid));
$total = count($all);
$pageindex = max(1, intval($_GPC['page']));
$pagesize = 10;  
$p = ($pageindex-1) * $pagesize;
$pager = pagination($total, $pageindex, $pagesize);  
$orders = pdo_fetchall("SELECT a.orderid,a.paymoney,a.creattime,b.title,c.nickname,c.avatar FROM ".tablename('sudu8_page_video_pay')." as a LEFT JOIN ".tablename('sudu8_page_products')." as b on a.pid = b.id LEFT JOIN ".tablename('sudu8_page_user')." as c on a.openid = c.openid WHERE a.uniacid = :uniacid and c.uniacid = :uniacid ORDER BY a.creattime DESC LIMIT " . $p . "," . $pagesize, array(':uniacid' => $uniacid));
// var_dump($orders);exit;

foreach ($orders as &$res) {
    $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
    $res['nickname'] = rawurldecode($res['nickname']);
}

if($opt == "excel"){
	$orders1 = pdo_fetchall("SELECT a.orderid,a.paymoney,a.creattime,b.title,c.nickname,c.avatar FROM ".tablename('sudu8_page_video_pay')." as a LEFT JOIN ".tablename('sudu8_page_products')." as b on a.pid = b.id LEFT JOIN ".tablename('sudu8_page_user')." as c on a.openid = c.openid WHERE a.uniacid = :uniacid and c.uniacid = :uniacid ORDER BY a.creattime DESC ", array(':uniacid' => $uniacid));
	include MODULE_ROOT.'/plugin/phpexcel/Classes/PHPExcel.php';
	$objPHPExcel = new \PHPExcel();

	/*以下是一些设置*/
	$objPHPExcel->getProperties()->setCreator("付费视频订单记录")
	    ->setLastModifiedBy("付费视频订单记录")
	    ->setTitle("付费视频订单记录")
	    ->setSubject("付费视频订单记录")
	    ->setDescription("付费视频订单记录")
	    ->setKeywords("付费视频订单记录")
	    ->setCategory("付费视频订单记录");
	$objPHPExcel->getActiveSheet()->setCellValue('A1', '下单时间');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', '订单号');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', '文章标题');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', '价格');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', '用户姓名');

	foreach($orders1 as $k => $v){
	    $num=$k+2;

	  $v['creattime'] = date("Y-m-d H:i:s",$v['creattime']);
	    // var_dump($v['flag']);exit;
	    $objPHPExcel->setActiveSheetIndex(0)
	                ->setCellValueExplicit('A'.$num, $v['creattime'],'s')
	                ->setCellValueExplicit('B'.$num, $v['orderid'],'s')
	                ->setCellValueExplicit('C'.$num, $v['title'],'s') 
	                ->setCellValueExplicit('D'.$num, $v['paymoney'],'s')
	                ->setCellValueExplicit('E'.$num, $v['nickname'], 's');
	      
	}

	// var_dump($cc);exit;

	$objPHPExcel->getActiveSheet()->setTitle('导出付费视频订单');
	$objPHPExcel->setActiveSheetIndex(0);
	$excelname="付费视频订单记录表";
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
	header('Cache-Control: max-age=0');
	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
}


return include self::template('web/Orderset/videoorder');