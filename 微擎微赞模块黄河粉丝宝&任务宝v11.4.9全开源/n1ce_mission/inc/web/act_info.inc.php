<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel.php';
global $_W,$_GPC;
$rid = $_GPC['rid'];
if ($_GPC['op'] == 'all') {
  $title_prefix = '参与情况数据';
} else{
  $title_prefix = '奖品发送成功数据';
}
$sheet_title = $_W['account']['name'] . '-活动编号' .$rid .$title_prefix;

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
if($_GPC['op'] == 'all'){
  $allnumber_sql = "SELECT a.id,a.createtime, c.nickname, c.avatar,a.from_user, a.allnumber,b.uid,b.follow,c.gender FROM " . tablename('n1ce_mission_allnumber') . " a LEFT JOIN "
      . tablename('mc_mapping_fans') . " b ON a.from_user = b.openid AND a.uniacid=b.uniacid LEFT JOIN "
      . tablename('mc_members') . " c ON b.uniacid = c.uniacid AND b.uid = c.uid  "
      . " WHERE rid=:rid AND a.uniacid=:uniacid ORDER BY allnumber DESC";
  $prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid);
  $list = pdo_fetchall($allnumber_sql, $prarm);
  // Add some data
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A1', '会员编号')
              ->setCellValue('B1', '粉丝昵称')
              ->setCellValue('C1', 'OPENID')
              ->setCellValue('D1', '引客数')
              ->setCellValue('E1', '关注状态')
              ->setCellValue('F1', '参加时间')
              ;

  $i = 2;
  foreach ($list as $row) {
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A'.$i, $row['uid'])
      ->setCellValue('B'.$i, $row['nickname'])
      ->setCellValue('C'.$i, $row['from_user'])
      ->setCellValue('D'.$i, $row['allnumber'])
      ->setCellValue('E'.$i, $row['follow']?'正在关注':'取消关注')
      ->setCellValue('F'.$i, date('Y-m-d H:i', $row['createtime']))
      ;
    $i++;
    unset($row);
  }

  $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
}else{
	$sql = 'select * from ' . tablename('n1ce_mission_user') . 'where uniacid = :uniacid and rid = :rid AND status = 1 ' . $con .' order by allnumber DESC';
  $prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid);
  $list = pdo_fetchall($sql, $prarm);
  // Add some data
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A1', 'ID')
              ->setCellValue('B1', '粉丝昵称')
              ->setCellValue('C1', 'OPENID')
              ->setCellValue('D1', '任务完成人数')
              ->setCellValue('E1', '奖品类型')
              ->setCellValue('F1', '奖品状态')
              ->setCellValue('G1', '完成时间')
              ;

  $i = 2;
  foreach ($list as $row) {
    if($row['type'] == 1){
      $p_name = "微信红包";
    }elseif ($row['type'] == 2) {
      $p_name = "微信卡券";
    }elseif ($row['type'] == 3) {
      $p_name = "有赞商品";
    }elseif ($row['type'] == 4) {
      $p_name = "系统积分";
    }elseif ($row['type'] == 5) {
      $p_name = "自定义链接";
    }elseif ($row['type'] == 6) {
      $p_name = "有赞抽奖";
    }elseif ($row['type'] == 7) {
      $p_name = "兑换码-".$row['code'];
    }elseif ($row['type'] == 8) {
      $p_name = "实物奖品";
    }
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A'.$i, $row['id'])
      ->setCellValue('B'.$i, $row['nickname'])
      ->setCellValue('C'.$i, $row['openid'])
      ->setCellValue('D'.$i, $row['allnumber'])
      ->setCellValue('E'.$i, $p_name)
      ->setCellValue('F'.$i, ($row['status']==1)?'发送成功':'发送失败')
      ->setCellValue('G'.$i, date('Y-m-d H:i', $row['time']))
      ;
    $i++;
    unset($row);
  }

  $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
}

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