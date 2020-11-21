<?php
defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$dos = array('display', 'visible');
$do = $_GPC['op'];
$do = in_array($do, $dos) ? $do : 'display';
if ($do == 'display') {
    $_W['page']['title'] = '地区列表 - 地区管理';
    if (checksubmit('submit')) {
        foreach ($_GPC['displayorder'] as $key => $value) {
           
            pdo_update('hyb_yl_address', array('displayorder' => $value), array('id' => $key));
        }
        message('更新成功', 'refresh', 'success');
    }
    $pid = intval($_GPC['pid']);
    $parent_address = pdo_fetch("select * from ".tablename('hyb_yl_address')." where id = ".$pid);
    if (empty($parent_address)) {
        $parent_address = array('id' => 0, 'level' => 0);
    }
    switch (intval($parent_address['level'])){
        case 0: $title = '全国各省市自治区'; break;
        case 1: $title = $parent_address['name'].'所属市'; break;
        case 2: $title = $parent_address['name'].'所属区/县'; break;
    }
    $keywords =$_GPC['keywords'];

    if(empty($keywords)){
        $where = ' WHERE pid = :pid';
        $params = array(':pid' => $pid);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 15;
        $addresses = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_address') . $where ."  ORDER BY level ASC, displayorder DESC , id ASC LIMIT ". ($pindex - 1) * $psize . ',' . $psize, $params);
        // pt($list);
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('hyb_yl_address') . $where, $params);
        $pager = pagination($total, $pindex, $psize);
        
        $title .= ": $total 个记录.";
    }else{
        $where = "WHERE pid = 0 and (name like '%{$keywords}%' or id like '%{$keywords}%') " ;
        $addresses = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_address') . $where,array(':pid' => $pid));
    }
      

}
if ($do == 'visible') {
    $_W['page']['title'] = '地区编辑 - 地区管理';       
    $id = $_GPC['id'];
    $visible = $_GPC['visible'];

    $province = pdo_fetch("select * from ".tablename('hyb_yl_address')." where id = ".$id);
    if (!empty($province)) {
        pdo_update('hyb_yl_address', array('visible' => $visible), array('id' => $id));
        message(error(0, '操作成功'));  
    }
    $result['errno'] = 1;
    $result['message'] = '操作失败 : 没有找到指定ID';
    message($result, '', 'ajax');
}
//include $this->template('address/address');