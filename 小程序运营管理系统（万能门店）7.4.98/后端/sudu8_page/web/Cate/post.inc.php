<?php 

global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$cateid = $_GPC['cateid'];
$chid = $_GPC['chid'];

$id = intval($_GPC['id']);
$item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_cate') ." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
$cate_list = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate') ." WHERE cid = :cid and uniacid = :uniacid ", array(':cid' => 0 ,':uniacid' => $uniacid));
$cateConf = unserialize($item['cateconf']);
$item['pmarb'] = $cateConf['pmarb'];
$item['ptit'] = $cateConf['ptit'];
if (checksubmit('submit')) {
    if (empty($_GPC['name'])) {
        message('请输入栏目标题！');
    }
    $list_style = intval($_GPC['list_style']);
    if($_GPC['type'] == 'page'){
        if($_GPC['list_type'] == 1){
            $list_style = 3;
        }
    }
    $pmarb = $_GPC['pmarb'];
    $ptit = $_GPC['ptit'];
    if(is_null($pmarb)){
        $pmarb = 10;
    }
    if(is_null($ptit)){
        $ptit = 1;
    }
    $cateConf = array(
        'pmarb' => $pmarb,
        'ptit' => $ptit,
    );
    $cateConf = serialize($cateConf);
    $data = array(
        'uniacid' => $_W['uniacid'],
        'cid' => intval($_GPC['cid']),
        'name' => $_GPC['name'],
        'name_n' => $_GPC['name_n'],
        'ename' => $_GPC['ename'],
        'cdesc' => $_GPC['cdesc'],
        'catepic'=>$_GPC['catepic'],
        'type' => $_GPC['type'],
        'show_i' => intval($_GPC['show_i']),
        'statue' => intval($_GPC['statue']),
        'num' => intval($_GPC['num']),
        'list_type' => intval($_GPC['list_type']),
        'list_style' => $list_style,
        'list_tstyle' => intval($_GPC['list_tstyle']),
        'list_tstylel' => intval($_GPC['list_tstylel']),
        'list_stylet' => $_GPC['list_stylet'],
        'pic_page_btn' => intval($_GPC['pic_page_btn']),
        'pic_page_bg' => intval($_GPC['pic_page_bg']),
        'content' => $_GPC['content'],
        'cateconf' => $cateConf,
    );
    if (empty($id)) {
        pdo_insert('sudu8_page_cate', $data);
    } else {
        pdo_update('sudu8_page_cate', $data, array('id' => $id ,'uniacid' => $uniacid));
    }
    message('栏目 添加/修改 成功!', $this->createWebUrl('cate', array('op'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
}

return include self::template('web/Cate/post');
