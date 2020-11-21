<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/tabbar/list";
$typearr = GetPositon();
$typearr_input = GetShowinput();
$position = 2;

//ini_set(‘display_errors’,1); //错误信息
//ini_set(‘display_startup_errors’,1); //php启动错误信息
//error_reporting(E_ALL & ~E_NOTICE); //打印出所有的 错误信息

$op = $_GPC['op'];
if($op=="add" || $op=="edit"){
    $id = intval($_GPC['id']);
    if($id>0){
        $info=pdo_get('ymktv_sun_nav',array('id'=>$id));
    }
    $template = "web/tabbar/add";
}elseif($op=="save"){
    $id = intval($_GPC['id']);
    if(checksubmit('submit')){
        $data = array();
        $data = $_GPC['gdata'];
        $url_id = intval($_GPC['url_id']);
        $data["url"] = all_url($data['url_type'],$url_id);
        $data["position"] = $position;
//        print_r($data);
//        echo $id;exit;

        if($id==0){
            $data['uniacid']=$_W['uniacid'];
            $res=pdo_insert('ymktv_sun_nav',$data);

            if($res){
                message('添加成功！', $this->createWebUrl('tabbar'), 'success');
            }else{
                message('添加失败！','','error');
            }
        }else{
            $res=pdo_update('ymktv_sun_nav',$data,array('id'=>$id));
//            pdo_debug();
            if($res){
                message('编辑成功！', $this->createWebUrl('tabbar'), 'success');
            }else{
                message('编辑失败！','','error');
            }
        }
    }
}elseif($_GPC['op']=='del'){
    $res=pdo_delete('ymktv_sun_nav',array('id'=>intval($_GPC['id'])));
    if($res){
        message('删除成功！', $this->createWebUrl('tabbar'), 'success');
    }else{
        message('删除失败！','','error');
    }
}elseif($_GPC['op']=='change'){
    $uptype = $_GPC["uptype"];
    $isshow = intval($_GPC["isshow"]);
    $id = intval($_GPC["id"]);
    $data['isshow']=$isshow;
    $res = pdo_update('ymktv_sun_nav', $data, array('id' => $id));
    if($res){
        message('修改成功',$this->createWebUrl('tabbar'),'success');
    }else{
        message('修改失败','','error');
    }
}elseif($_GPC['op']=='search'){
    $tid=$_GPC['tid'];
    $name=$_GPC['name'];
    $list = SearchProductLikename($name,$tid);
    echo json_encode($list);
    exit();
}else{
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from".tablename('ymktv_sun_nav')." where uniacid={$_W['uniacid']} and position=".$position." ORDER BY id desc";
    $total=pdo_fetchcolumn("select count(*) from".tablename('ymktv_sun_nav')." where uniacid={$_W['uniacid']} and position=".$position." ");
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql);
    $pager = pagination($total, $pageindex, $pagesize);
}
include $this->template($template);