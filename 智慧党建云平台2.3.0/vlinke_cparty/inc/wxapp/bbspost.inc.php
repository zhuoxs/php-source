<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    $userscort = trim($_GPC['userscort']);
    $cate = pdo_fetchall("SELECT * FROM ".tablename($this->table_bbscate)." WHERE isshow=1 AND branchid IN (".$userscort.") AND uniacid=:uniacid ORDER BY ishot ASC, priority DESC, id DESC ", array(':uniacid'=>$_W['uniacid']));
    if (!empty($cate)) {
        foreach ($cate as $k => $v) {
            $cate[$k]['cicon'] = tomedia($v['cicon']);
        }
    }
    $this->result(0, '', array(
        'cate' => $cate
        ));

}elseif ($op=="addpost") {

    $title = trim($_GPC['title']);
    $details = trim($_GPC['details']);
    if (empty($title) || empty($details)) {
        $this->result(1, '请输入标题及内容！');
    }

    $cateid = intval($_GPC['cateid']);
    $cate = pdo_get($this->table_bbscate, array('id'=>$cateid,'uniacid'=>$_W['uniacid']));
    if (empty($cate)) {
        $this->result(1, '话题分类不存在！');
    }
    $picall = str_replace(array('[','"',']','&quot;'),"",$_GPC['picall']);
    $picallarr = trim($picall)=="" ? array() : explode(",", $picall);
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'cateid'     => $cateid,
        'userid'     => intval($_GPC['userid']),
        'title'      => $title,
        'details'    => $details,
        'picall'     => iserializer($picallarr),
        'vpath'      => "",
        'createtime' => time()
        );
    pdo_insert($this->table_bbstopic, $data);
    $this->result(0, '', array());

}
?>