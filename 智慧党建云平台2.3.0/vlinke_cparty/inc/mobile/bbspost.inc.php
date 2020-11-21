<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $branch = $this->getBranch($user['branchid']);
    $cate = pdo_fetchall("SELECT * FROM ".tablename($this->table_bbscate)." WHERE isshow=1 AND branchid IN (".$branch['scort'].") AND uniacid=:uniacid ORDER BY ishot ASC, priority DESC, id DESC ", array(':uniacid'=>$_W['uniacid']));


}elseif ($op=="addpost") {
    $title = trim($_GPC['title']);
    $details = trim($_GPC['details']);
    if (empty($title) || empty($details)) {
        message("请输入标题及内容！",referer(),'error');
    }
    $cateid = intval($_GPC['cateid']);
    $cate = pdo_get($this->table_bbscate, array('id'=>$cateid,'uniacid'=>$_W['uniacid']));
    if (empty($cate)) {
        message("话题分类不存在！",referer(),'error');
    }
    $picall = empty($_GPC['picall'])?array():$_GPC['picall'];
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'cateid'     => $cateid,
        'userid'     => $user['id'],
        'title'      => $title,
        'details'    => $details,
        'picall'     => iserializer($picall),
        'vpath'      => "",
        'createtime' => time()
        );
    pdo_insert($this->table_bbstopic, $data);

    message("话题发表成功！", $this->createMobileUrl('bbsmy',array('op'=>'mytopic')),'success');
}

include $this->template('bbspost');

?>