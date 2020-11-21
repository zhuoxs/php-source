<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$dos = array('display', 'visible','post');
$do = $_GPC['op'];

$do = in_array($do, $dos) ? $do : 'display';
if ($do == 'display') {
    $keywords =$_GPC['keywords'];
    if(empty($keywords)){
        $where = "as a left join".tablename('hyb_yl_goodsarr')."as b on b.sid=a.sid left join ".tablename('hyb_yl_userinfo')."as d on d.openid = a.openid WHERE a.uniacid = :uniacid";
        $params = array(':uniacid' => $uniacid);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 15;
        $res = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_shopgoods') . $where ."  ORDER BY time ASC LIMIT ". ($pindex - 1) * $psize . ',' . $psize, $params);
        // pt($list);
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('hyb_yl_shopgoods') . $where, $params);
        $pager = pagination($total, $pindex, $psize);
        $title .= ": $total 个记录.";
    }else{
        $where = "as a left join".tablename('hyb_yl_goodsarr')."as b on b.sid=a.sid left join ".tablename('hyb_yl_userinfo')."as d on d.openid = a.openid WHERE a.uniacid = :uniacid and (a.shphone like '%{$keywords}%' or a.orders like '%{$keywords}%') " ;
        $res = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_shopgoods') . $where,array(':uniacid' => $uniacid));

    }
}
if($do == 'post'){
    $spid =$_GPC['spid'];

    $onedrder =pdo_fetch("SELECT * FROM".tablename('hyb_yl_shopgoods')."as a left join".tablename('hyb_yl_goodsarr')."as b on b.sid=a.sid left join".tablename('hyb_yl_peisong')."as c on c.p_id=a.p_id left join ".tablename('hyb_yl_userinfo')."as d on d.openid = a.openid WHERE a.uniacid='{$uniacid}' and a.spid='{$spid}'");

    $onedrder['time']=date('Y-m-d H:i:s',$onedrder['time']);
    $data = array(
    'shname'=>$_GPC['shname'],
    'shphone'=>$_GPC['shphone'],
    'shaddress'=>$_GPC['shaddress'],
    'num' =>$_GPC['num'],
    'com' =>$_GPC['com'],
    'paystate'=>2
    );
    if(checksubmit()){
      pdo_update('hyb_yl_shopgoods',$data,array('spid'=>$spid));
      message("更新成功!",$this->createWebUrl("shangporder",array("op"=>"display")),"success");
    }
}
if ($do == 'visible') {     
    $id = $_GPC['id'];
    $visible = $_GPC['visible'];
    $province = pdo_fetch("select * from ".tablename('hyb_yl_shopgoods')." where id = ".$id);
    if (!empty($province)) {
        pdo_update('hyb_yl_shopgoods', array('visible' => $visible), array('id' => $id));
        message(error(0, '操作成功'));  
    }
    $result['errno'] = 1;
    $result['message'] = '操作失败 : 没有找到指定ID';
    message($result, '', 'ajax');
}
include $this->template('shangporder');