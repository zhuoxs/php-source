<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();

if ($op=="display") {

    $fan = mc_oauth_userinfo();
    $user = pdo_get($this->table_user, array('openid'=>$fan['openid'],'uniacid'=>$_W['uniacid'],'recycle'=>0));
    if ($param['openhome']==0 && empty($user)) {
        $url = $this->createMobileUrl("login");
        Header("Location:".$url); 
        die;
    }

    $id = intval($_GPC['id']);
    $article = pdo_get($this->table_article, array('id'=>$id,'status'=>2,'uniacid'=>$_W['uniacid']));
    if (empty($article)) {
        message("文章信息不存在！",referer(),'error');
    }
    $artcatelist = pdo_fetchall("SELECT * FROM ".tablename($this->table_artcate)." WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']),'id');
    $artcate = $artcatelist[$article['cateid']];
    $branch = pdo_get($this->table_branch, array('id'=>$article['branchid'],'uniacid'=>$_W['uniacid']));

    if (!empty($user)) {
        $integral = pdo_get($this->table_integral, array('userid'=>$user['id'],'channel'=>'article','foreignid'=>$id,'uniacid'=>$_W['uniacid']));
        if ($article['integral']>0 && empty($integral)) {
            $data = array(
                'userid'    => $user['id'],
                'channel'   => "article",
                'foreignid' => $id,
                'integral'  => $article['integral'],
                'remark'    => "阅读《".$article['title']."》奖励",
                );
            $integralid = $this->setIntegral($data);
        }else{
            $integralid = intval($integral['id']);
        }
    }

    if (!empty($article['link'])) {
    	header("location:".urldecode($article['link']));
    }

    $artmessage = pdo_fetchall("SELECT m.*, u.realname, u.headpic FROM ".tablename($this->table_artmessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.articleid=:articleid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT 6 ", array(':articleid'=>$id,':uniacid'=>$_W['uniacid']));
    if (!empty($artmessage)) {
        foreach ($artmessage as $k => $v) {
            $artmessage[$k]['picall'] = iunserializer($v['picall']);
        }
    }
    $artmessagetol = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_artmessage)." WHERE articleid=:articleid AND uniacid=:uniacid ", array(':articleid'=>$id,':uniacid'=>$_W['uniacid']));
    $artmessagetol = intval($artmessagetol);
}
include $this->template('article');
?>