<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/28 0028
 * Time: 上午 11:23
 */
defined("IN_IA")or exit("Access Denied");
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
include ROOT_PATH.'inc/web/function.inc.php';
checklogin();  //验证是否登录
checkKundianAuth();
global $_W,$_GPC;
$uniacid=$_W['uniacid'];
$op=$_GPC['op'] ? $_GPC['op'] : "sign_index";
if($op=='sign_index'){
    $condition=array();
    $condition['uniacid']=$uniacid;
    $condition['uid >']=0;
    $listCount=pdo_getall("cqkundian_farm_sign",$condition);
    $total=count($listCount);   //数据的总条数
    $pageSize=15; //每页显示的数据条数
    $pageIndex=intval($_GPC['page']) ? intval($_GPC['page']) :1;  //当前页
    $pager=pagination($total,$pageIndex,$pageSize);
    $list=pdo_getall("cqkundian_farm_sign",$condition,'','','sign_time desc',array($pageIndex,$pageSize));
    for($i=0;$i<count($list);$i++){
        $list[$i]['sign_time']=date('Y-m-d H:i:s',$list[$i]['sign_time']);
        $userData=pdo_get('cqkundian_farm_user',array('uniacid'=>$uniacid,'uid'=>$list[$i]['uid']));
        $list[$i]['continue_day']=$userData['continue_day'];
        $list[$i]['nickname']=$userData['nickname'];
    }
    include $this->template("web/sign/index");
}