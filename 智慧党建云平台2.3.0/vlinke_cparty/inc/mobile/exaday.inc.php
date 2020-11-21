<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {


}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_exaday)." WHERE userid=:userid AND uniacid=:uniacid ORDER BY id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']));
    if (empty($list)) {
        exit("NOTHAVE");
    }

}elseif ($op=="create") {
    $stoday = mktime(0,0,0,date('m'),date('d'),date('Y'));
    $etoday = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
    $exaday = pdo_get($this->table_exaday, array('uniacid'=>$_W['uniacid'],'userid'=>$user['id'],'createtime >'=>$stoday,'createtime <'=>$etoday));
    if (empty($exaday)) {
        if ($param['exadaystatus']==2) {
            message("每日测试已关闭！",referer(),'error');
        }
        $exadeveryall = pdo_fetchall("SELECT * FROM ".tablename($this->table_exadevery)." WHERE uniacid=:uniacid ORDER BY rand() LIMIT ".$param['exaeverynum'], array(':uniacid'=>$_W['uniacid']));
        if ($param['exaeverynum']<=0) {
            message("每日测试题数不能小于等于0道，请管理员设置每日测试题数目！",referer(),'error');
        }
        if ($param['exaeverynum']>count($exadeveryall)) {
            message("每日测试至少回答".$param['exaeverynum']."道题，请管理员追加测试题库题量！",referer(),'error');
        }
        $exaday = array(
            'uniacid'    => $_W['uniacid'],
            'title'      => date('Y')."年".date('m')."月".date('d')."日测试",
            'userid'     => $user['id'],
            'status'     => 1,
            'aright'     => 0,
            'awrong'     => 0,
            'integral'   => 0,
            'finishtime' => 0,
            'createtime' => time()
            );
        pdo_insert($this->table_exaday, $exaday);
        $exaday['id'] = pdo_insertid();
        $data = array(
            'uniacid'    => $_W['uniacid'],
            'userid'     => $user['id'],
            'itype'      => 1,
            'foreignid'  => $exaday['id'],
            'myanswer'   => "",
            'isright'    => 0,
            'createtime' => time()
            );
        foreach ($exadeveryall as $k => $v) {
            $data['bankid'] = $v['bankid'];
            pdo_insert($this->table_exaitem, $data);
        }
    }
    $url = $this->createMobileUrl('exaday',array('op'=>'answer','exadayid'=>$exaday['id']));
    header("location:".$url);

}elseif ($op=="answer") {
    $exadayid = intval($_GPC['exadayid']);
    $exaday = pdo_get($this->table_exaday, array('id'=>$exadayid,'uniacid'=>$_W['uniacid'],'userid'=>$user['id']));
    if (empty($exaday)) {
        message("测试记录不存在！",$this->createMobileUrl('exaday'),'error');
    }
    $exaitemall = pdo_fetchall("SELECT i.*,b.title,b.tilpic,b.qtype,b.itema,b.itemb,b.itemc,b.itemd,b.iteme,b.itemf,b.answer,b.aright,b.awrong FROM ".tablename($this->table_exaitem)." i LEFT JOIN ".tablename($this->table_exabank)." b ON i.bankid=b.id WHERE i.foreignid=:foreignid AND i.userid=:userid AND i.uniacid=:uniacid AND i.itype=1 ORDER BY i.id ASC", array(':foreignid'=>$exadayid,':userid'=>$user['id'],':uniacid'=>$_W['uniacid']));

}elseif ($op=="setitem") {
    $ret = array('status'=>"error",'msg'=>"error");
    $exaitemid = intval($_GPC['exaitemid']);
    $exaitem = pdo_get($this->table_exaitem, array('id'=>$exaitemid));
    $exaday = pdo_get($this->table_exaday, array('id'=>$exaitem['foreignid']));
    $exabank = pdo_get($this->table_exabank, array('id'=>$exaitem['bankid']));
    if (empty($exaitem) || empty($exaday) || empty($exabank)) {
        $ret['msg'] = "测试记录不存在，请重新进入！";
        exit(json_encode($ret));
    }
    if ($exaday['status']==2) {
        exit(json_encode($ret));
    }
    $myanswer = trim($_GPC['myanswer']);
    $data = array(
        'myanswer' => $myanswer,
        'isright'  => $myanswer==$exabank['answer'] ? 2 : 1 ,
        );
    pdo_update($this->table_exaitem, $data, array('id'=>$exaitemid));
    $ret['status'] = "success";
    $ret['msg'] = "success";
    exit(json_encode($ret));

}elseif ($op=="submit") {
    $ret = array('status'=>"error",'msg'=>"error",'index'=>-1);
    $exadayid = intval($_GPC['exadayid']);
    $exaday = pdo_get($this->table_exaday, array('id'=>$exadayid,'uniacid'=>$_W['uniacid'],'userid'=>$user['id']));
    if (empty($exaday)) {
        $ret['msg'] = "测试记录不存在！";
        exit(json_encode($ret));
    }
    $exaitemall = pdo_fetchall("SELECT * FROM ".tablename($this->table_exaitem)." WHERE foreignid=:foreignid AND userid=:userid AND uniacid=:uniacid AND itype=1 ORDER BY id ASC", array(':foreignid'=>$exadayid,':userid'=>$user['id'],':uniacid'=>$_W['uniacid']));
    $idwrongarr = array();
    $idrightarr = array();
    foreach ($exaitemall as $k => $v) {
        if ($v['isright']==0) {
            $ret['msg'] = "还有题目未作答！";
            $ret['index'] = $k;
            exit(json_encode($ret));
        }elseif ($v['isright']==1) {
            $idwrongarr[] = $v['bankid'];
        }elseif ($v['isright']==2) {
            $idrightarr[] = $v['bankid'];
        }
    }
    $integral = count($idrightarr) * intval($param['exaeveryint']);
    $data = array(
        'status'     => 2,
        'aright'     => count($idrightarr),
        'awrong'     => count($idwrongarr),
        'integral'   => $integral,
        'finishtime' => time()
        );
    if ($integral>0) {
        $intdata = array(
            'userid'    => $user['id'],
            'channel'   => "exaday",
            'foreignid' => $exadayid,
            'integral'  => $integral,
            'remark'    => $exaday['title']."得分",
            );
        $this->setIntegral($intdata);
    }
    pdo_update($this->table_exaday, $data, array('id'=>$exadayid));
    if (!empty($idwrongarr)) {
        pdo_update($this->table_exadevery, array('awrong +='=>1), array('bankid'=>$idwrongarr));
        pdo_update($this->table_exabank, array('awrong +='=>1), array('id'=>$idwrongarr));
    }
    if (!empty($idrightarr)) {
        pdo_update($this->table_exadevery, array('aright +='=>1), array('bankid'=>$idrightarr));
        pdo_update($this->table_exabank, array('aright +='=>1), array('id'=>$idrightarr));
    }
    $ret['status'] = "success";
    $ret['msg'] = "success";
    exit(json_encode($ret));
}
include $this->template('exaday');
?>