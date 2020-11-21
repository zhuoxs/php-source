<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    $cateid = intval($_GPC['cateid']);
    $cate = pdo_get($this->table_artcate, array('id'=>$cateid));
    if (empty($cate)) {
        $this->result(1, '分类不存在');
    }
    $slide = pdo_fetchall("SELECT * FROM ".tablename($this->table_article)." WHERE status=2 AND isslide=1 AND cateid=:cateid AND uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT 9 ", array(':cateid'=>$cateid,':uniacid'=>$_W['uniacid']));
    if (!empty($slide)) {
        foreach ($slide as $k => $v) {
            $slide[$k]['slidepic'] = tomedia($v['slidepic']);
        }
    }
    $this->result(0, '', array(
        'cate' => $cate,
        'slide' => $slide
        ));

}elseif ($op=="getmore") {

    $cateid = intval($_GPC['cateid']);
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize'])); 
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_article)." WHERE status=2 AND cateid=:cateid AND uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':cateid'=>$cateid,':uniacid'=>$_W['uniacid']));
    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $list[$k]['tilpic'] = tomedia($v['tilpic']);
            $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
        }
    }
    $this->result(0, '', $list);

}
?>






