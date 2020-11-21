<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

if(checksubmit('submit')){
       $cond['uniacid']=$_W['uniacid'];
       if($_GPC['is_use']==0){
           $cond['is_use']=$_GPC['is_use'];
       }else if($_GPC['is_use']==1){
           $cond['is_use']=$_GPC['is_use'];
       }
       $activationcode=pdo_getall('yzcyk_sun_activationcode',$cond);
       if(!$activationcode){
           message('没有你选择的数据',$this->createWebUrl('activationcode',array()),'error');
       }
       $export_title =array('序号','openid','激活码','激活天数','创建时间','使用时间','是否使用');
       $export_list=array();
       $i=1;
        foreach($activationcode as $k => $v){
            $export_list[$k]["id"] = $i;
            $export_list[$k]["openid"] = $v["openid"]?$v["openid"]:'';
            $export_list[$k]["code"] = $v["code"];
            $export_list[$k]["num"] = $v["num"]."天";
            $export_list[$k]["add_time_d"] = date('Y-m-d H:i',$v["add_time"]);
            $export_list[$k]["use_time_d"] =$v['use_time']?date('Y-m-d H:i',$v['use_time']):'';
            $export_list[$k]["is_use_z"] = $v['is_use']?'使用':'未使用';
            $i++;
        }
        exportToExcel('激活码_'.date("YmdHis").'.csv',$export_title,$export_list);
        exit;
}
include $this->template('web/exportactivationcode');

//导出方法
/**
 * @creator Jimmy
 * @data 2018/1/05
 * @desc 数据导出到excel(csv文件)
 * @param $filename 导出的csv文件名称 如'test-'.date("Y年m月j日").'.csv'
 * @param array $tileArray 所有列名称
 * @param array $dataArray 所有列数据
 */
function exportToExcel($filename, $tileArray=array(), $dataArray=array()){
    ini_set('memory_limit','512M');
    ini_set('max_execution_time',0);
    ob_end_clean();
    ob_start();
    header("Content-Type: text/csv");
    header("Content-Disposition:filename=".$filename);
    $fp=fopen('php://output','w');
    fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));//转码 防止乱码(比如微信昵称(乱七八糟的))
    fputcsv($fp,$tileArray);
    $index = 0;
    foreach ($dataArray as $item) {
        // if($index==5000){
        //     $index=0;
        //     ob_flush();
        //     flush();
        // }
        $index++;
        fputcsv($fp,$item);
    }

    ob_flush();
    flush();
    ob_end_clean();
}