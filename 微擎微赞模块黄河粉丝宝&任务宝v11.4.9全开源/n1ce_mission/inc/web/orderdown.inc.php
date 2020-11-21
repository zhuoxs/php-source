<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel.php';
global $_W,$_GPC;
$rid = $_GPC['rid'];
$gid = $_GPC['gid'];
$goods_title = $this->goodstitle($gid);
if($_GPC['status'] == 'new'){
	$sql = 'select * from ' . tablename('n1ce_mission_order') . 'where uniacid = :uniacid and rid = :rid and gid = :gid and status=2 order by id DESC' ;
	$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid,':gid' => $gid);
	$list = pdo_fetchall($sql, $prarm);
}elseif ($_GPC['status'] == 'done') {
	$sql = 'select * from ' . tablename('n1ce_mission_order') . 'where uniacid = :uniacid and rid = :rid and gid = :gid and status=1 order by id DESC' ;
	$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid,':gid' => $gid);
	$list = pdo_fetchall($sql, $prarm);
}else{
	$sql = 'select * from ' . tablename('n1ce_mission_order') . 'where uniacid = :uniacid and rid = :rid and gid = :gid order by id DESC' ;
	$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid,':gid' => $gid);
	$list = pdo_fetchall($sql, $prarm);
}
if (!isset($_GPC['status'])) {
  $title_prefix = '所有兑换和未兑换请求';
} else if ($_GPC['status'] == 'new') {
  $title_prefix = '未兑换请求';
} else if ($_GPC['status'] == 'done') {
  $title_prefix = '已兑换请求';
}
$sheet_title = $_W['account']['name'] . '-' . $title_prefix;

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("huanghe")
							 ->setLastModifiedBy("huanghe")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Order File");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '粉丝昵称')
            ->setCellValue('C1', 'OPENID')
            ->setCellValue('D1', '姓名')
            ->setCellValue('E1', '手机')
            ->setCellValue('F1', '地址')
            ->setCellValue('G1', '商品名')
            ->setCellValue('H1', '日期')
            ;

$i = 2;
foreach ($list as $row) {
  $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, $row['id'])
    ->setCellValue('B'.$i, $row['nickname'])
    ->setCellValue('C'.$i, $row['from_user'])
    ->setCellValue('D'.$i, $row['realname'])
    ->setCellValueExplicit('E'.$i, $row['mobile'], PHPExcel_Cell_DataType::TYPE_STRING)
    ->setCellValue('F'.$i, $row['residedist'])
    ->setCellValue('G'.$i, $goods_title)
    ->setCellValue('H'.$i, date('Y-m-d H:i', $row['time']))
    ;
  $i++;
  unset($row);
}

$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(22);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle($sheet_title);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$sheet_title.'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_clean(); // 必须加这一句，否则生成的文件可能打不开。因为有额外的输出。
$objWriter->save('php://output');
exit;