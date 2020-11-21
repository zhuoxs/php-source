<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {
    $articleid = intval($_GPC['articleid']);
    $article = pdo_get($this->table_article, array('id'=>$articleid,'status'=>2,'uniacid'=>$_W['uniacid']));
    if (empty($article)) {
        $this->result(1, '文章信息不存在！');
    }
    $artcate = pdo_get($this->table_artcate, array('id'=>$article['cateid'],'uniacid'=>$_W['uniacid']));
    $branch = pdo_get($this->table_branch, array('id'=>$article['branchid'],'uniacid'=>$_W['uniacid']));

    $article['createtime'] = date("Y-m-d H:i", $article['createtime']);
    $this->result(0, '', array(
        'article' => $article,
        'artcate' => $artcate,
        'branch' => $branch,
        ));

}elseif ($op=="getmore") {
    $articleid = intval($_GPC['articleid']);
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize'])); 

    $list = pdo_fetchall("SELECT m.*, u.realname, u.headpic FROM ".tablename($this->table_artmessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.articleid=:articleid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':articleid'=>$articleid,':uniacid'=>$_W['uniacid']));

    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $list[$k]['headpic'] = tomedia($v['headpic']);
            $list[$k]['picall'] = iunserializer($v['picall']);
            if (!empty($list[$k]['picall'])) {
                foreach ($list[$k]['picall'] as $key => $value) {
                    $list[$k]['picall'][$key] = tomedia($value);
                }
            }
            $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
        }
    }
    $this->result(0, '', $list);

}elseif ($op=="addmessage") {
    $details = trim($_GPC['details']);
    if (empty($details)) {
        $this->result(1, '请输入评论内容！');
    }
    $articleid = intval($_GPC['articleid']);
    $article = pdo_get($this->table_article, array('id'=>$articleid,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($article)) {
        $this->result(1, '文章信息不存在！');
    }
    $picall = str_replace(array('[','"',']','&quot;'),"",$_GPC['picall']);
    $picallarr = trim($picall)=="" ? array() : explode(",", $picall);
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'articleid'  => $articleid,
        'userid'     => intval($_GPC['userid']),
        'details'    => $details,
        'picall'     => iserializer($picallarr),
        'createtime' => time()
        );
    pdo_insert($this->table_artmessage, $data);
    $this->result(0, '', array());

}elseif ($op=="delmessage") {
    $messageid = intval($_GPC['messageid']);
    $userid = intval($_GPC['userid']);
    $artmessage = pdo_get($this->table_artmessage, array('id'=>$messageid,'uniacid'=>$_W['uniacid']));
    if (empty($artmessage)) {
        $this->result(1, '留言评论记录不存在！');
    }
    if ($artmessage['userid']!=$userid) {
        $this->result(1, '该留言评论记录不是你所写，无权做删除操作！');
    }
    pdo_delete($this->table_artmessage, array('id'=>$messageid,'uniacid'=>$_W['uniacid']));
    $this->result(0, '', array());

}
?>