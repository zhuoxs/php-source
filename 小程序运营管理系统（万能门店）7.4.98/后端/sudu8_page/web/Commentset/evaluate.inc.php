<?php
load()->func('tpl');
global $_GPC, $_W;
$opt = $_GPC['opt'];
$ops = array('display','delete','content','hf');
$opt = in_array($opt, $ops) ? $opt : 'display';
$uniacid = $_W['uniacid'];
$pid = $_GPC['id'];
//评论列表
if ($opt == 'display'){
    $flag = $_GPC['flag']?$_GPC['flag']:0;
    $orderid = $_GPC['orderid']?$_GPC['orderid']:'';
    $where1 = "";
    $where = "";
    if($flag > 0){
      $where1 .= "and assess = ".$flag;
      $where .= " and a.assess = ".$flag;
    }
    if($orderid != ''){
      $where1 .= " and orderid = ".trim($orderid);
      $where .= " and a.orderid = ".trim($orderid);
    }

    $_W['page']['title'] = '评论管理';
    $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_evaluate')." WHERE pid = :pid and uniacid = :uniacid", array(':pid' => $pid, ':uniacid' => $uniacid));
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize = 10;
    $start = ($pageindex-1) * $pagesize;
    $pager = pagination($total, $pageindex, $pagesize);
    $list = pdo_fetchAll("SELECT a.*,b.avatar,b.nickname FROM ".tablename('sudu8_page_evaluate')." as a LEFT JOIN ".tablename('sudu8_page_user')." as b on a.openid = b.openid and a.uniacid = b.uniacid WHERE a.pid = :pid and a.uniacid = :uniacid {$where} order by a.id desc LIMIT ".$start.",".$pagesize, array(':pid' => $pid, ':uniacid' => $uniacid));
    foreach ($list as $key => &$value) {
        $value['nickname'] = rawurldecode($value['nickname']);
        if($value['imgs']){
            $value['imgs'] = unserialize($value['imgs']);
        }
    }
}

//删除评论
if ($opt == 'delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_evaluate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
    if (empty($row)) {
        message('评论不存在或是已经被删除！');
    }
    pdo_delete('sudu8_page_evaluate', array('id' => $id ,'uniacid' => $uniacid));
    message('删除成功', $this->createWebUrl('Commentset', array('op'=>'evaluate','id'=>$row['pid'],'opt'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
}

if ($opt == 'content') {
    $eid = $_GPC['evid'];
    $item = pdo_fetch("SELECT a.*,b.avatar,b.nickname FROM ".tablename('sudu8_page_evaluate')." as a LEFT JOIN ".tablename('sudu8_page_user')." as b on a.openid = b.openid and a.uniacid = b.uniacid WHERE a.id = :id and a.uniacid = :uniacid", array(':id' => $eid, ':uniacid' => $uniacid));
    if($item){
        $item['nickname'] = rawurldecode($item['nickname']);
        if($item['imgs']){
            $item['imgs'] = unserialize($item['imgs']);
        }
        if($item['append_imgs']){
            $item['append_imgs'] = unserialize($item['append_imgs']);
        }
    }
}
if($opt == 'hf'){
   $id = intval($_GPC['id']);
   $huifu = $_GPC['huifu'];
   $cishu = intval($_GPC['cishu']);
   $evaluate = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_evaluate')." WHERE id = :id and uniacid = :uniacid",array(':id' => $id, ':uniacid' => $uniacid));
   if($evaluate){
      if((!$evaluate['reply_first'])&&$cishu==1){
          $data=array(
              "reply_first"=>$huifu,
              "reply_first_time"=>date('Y-m-d H:i:s',time())
          );
          pdo_update('sudu8_page_evaluate', $data, array('id' => $id ,'uniacid' => $uniacid));
      }
       if((!$evaluate['reply_second'])&&$cishu==2){
           $data2=array(
               "reply_second"=>$huifu,
               "reply_second_time"=>date('Y-m-d H:i:s',time())
           );
           pdo_update('sudu8_page_evaluate', $data2, array('id' => $id ,'uniacid' => $uniacid));
       }
       message('回复成功', $this->createWebUrl('Commentset', array('op' => 'evaluate', 'opt' => 'content','evid' => $id)), 'success');

   }else{
       message('该评论已删除', $this->createWebUrl('Commentset', array('op'=>'evaluate','id'=>$row['pid'],'opt'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'error');
   }


}




return include self::template('web/Commentset/evaluate');
