<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    $id = intval($_GPC['id']);
    $article = pdo_get($this->table_article, array('id'=>$id,'status'=>2,'uniacid'=>$_W['uniacid']));
    if (empty($article)) {
        $this->result(1, '文章信息不存在！');
    }
    $artcate = pdo_get($this->table_artcate, array('id'=>$article['cateid'],'uniacid'=>$_W['uniacid']));
    $branch = pdo_get($this->table_branch, array('id'=>$article['branchid'],'uniacid'=>$_W['uniacid']));


    $userid = intval($_GPC['userid']);
    $integral = pdo_get($this->table_integral, array('userid'=>$userid,'channel'=>'article','foreignid'=>$id,'uniacid'=>$_W['uniacid']));
    if ($userid!=0 && $article['integral']>0 && empty($integral)) {
        $data = array(
            'userid'    => $userid,
            'channel'   => "article",
            'foreignid' => $id,
            'integral'  => $article['integral'],
            'remark'    => "阅读《".$article['title']."》奖励",
            );
        $integralid = $this->setIntegral($data);
    }else{
        $integralid = intval($integral['id']);
    }


    $article['details'] = str_replace('<img', '<img style="max-width:100%;height:auto" ', htmlspecialchars_decode($article['details']));
    $article['createtime'] = date("Y-m-d H:i", $article['createtime']);

    $this->result(0, '', array(
        'article' => $article,
        'artcate' => $artcate,
        'branch' => $branch,
        'integralid' => $integralid
        ));

}
?>