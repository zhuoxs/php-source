<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    
}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT a.*,p.title FROM ".tablename($this->table_exaanswer)." a LEFT JOIN ".tablename($this->table_exapaper)." p ON a.paperid=p.id WHERE a.status=2 AND a.userid=:userid AND a.uniacid=:uniacid ORDER BY a.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']), "id");
    if (empty($list)) {
        exit("NOTHAVE");
    }

}elseif ($op=="answer") {
	$exapaperid = intval($_GPC['exapaperid']);
    $exapaper = pdo_get($this->table_exapaper, array('id'=>$exapaperid,'uniacid'=>$_W['uniacid']));
    if (empty($exapaper)) {
        message("考试项目不存在！",$this->createMobileUrl('exapaper'),'error');
    }
    $exaanswer = pdo_get($this->table_exaanswer, array('userid'=>$user['id'],'paperid'=>$exapaperid,'uniacid'=>$_W['uniacid']));
    if (empty($exaanswer)) {
        message("考试记录不存在！",$this->createMobileUrl('exapaper'),'error');
    }
    $usertime = $exaanswer['finishtime']-$exaanswer['stime'];
    if ($usertime<=0) {
        $exaanswer['usertime'] = "未完成";
    }else{
        $exaanswer['usertime'] = floor($usertime/60)."分". $usertime%60 ."秒";
    }
    $exaitemall = pdo_fetchall("SELECT i.*,b.title,b.tilpic,b.qtype,b.itema,b.itemb,b.itemc,b.itemd,b.iteme,b.itemf,b.answer,b.aright,b.awrong FROM ".tablename($this->table_exaitem)." i LEFT JOIN ".tablename($this->table_exabank)." b ON i.bankid=b.id WHERE i.foreignid=:foreignid AND i.userid=:userid AND i.uniacid=:uniacid AND i.itype=2 ORDER BY i.id ASC", array(':foreignid'=>$exaanswer['id'],':userid'=>$user['id'],':uniacid'=>$_W['uniacid']));
    if ($exaanswer['status']==1) {
        $timelimit = $exaanswer['etime']-time();
    }


}elseif ($op=="startanswer") {
	$exapaperid = intval($_GPC['exapaperid']);
    $exapaper = pdo_get($this->table_exapaper, array('id'=>$exapaperid,'uniacid'=>$_W['uniacid']));
    if (empty($exapaper)) {
        message("考试项目不存在！",referer(),'error');
    }
    $exaanswer = pdo_get($this->table_exaanswer, array('userid'=>$user['id'],'paperid'=>$exapaperid,'uniacid'=>$_W['uniacid']));
    if (empty($exaanswer)) {
        message("考试记录不存在！",referer(),'error');
    }
    if ($exaanswer['status']!=0) {
    	message("考试已开始答卷或已答卷完成！",$this->createMobileUrl('exaanswer',array('op'=>'answer','paperid'=>$exapaperid)),'error');
    }
    $data = array(
		'status' => 1,
		'stime'  => time(),
		'etime'  => time() + 60*$exapaper['timelimit']
    	);
    pdo_update($this->table_exaanswer, $data, array('id'=>$exaanswer['id']));
    $url = $this->createMobileUrl('exaanswer',array('op'=>'answer','exapaperid'=>$exapaperid));
    header("location:".$url);

}elseif ($op=="setitem") {
    $ret = array('status'=>"error",'msg'=>"error");
    $exaitemid = intval($_GPC['exaitemid']);
    $exaitem = pdo_get($this->table_exaitem, array('id'=>$exaitemid));
    $exaanswer = pdo_get($this->table_exaanswer, array('id'=>$exaitem['foreignid']));
    $exabank = pdo_get($this->table_exabank, array('id'=>$exaitem['bankid']));
    if (empty($exaitem) || empty($exaanswer) || empty($exabank)) {
        $ret['msg'] = "考试记录不存在，请重新进入！";
        exit(json_encode($ret));
    }
    if ($exaanswer['status']==2) {
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
    $exapaperid = intval($_GPC['exapaperid']);
    $exapaper = pdo_get($this->table_exapaper, array('id'=>$exapaperid,'uniacid'=>$_W['uniacid']));
    $exaanswer = pdo_get($this->table_exaanswer, array('paperid'=>$exapaperid,'uniacid'=>$_W['uniacid'],'userid'=>$user['id']));
    if (empty($exapaper) || empty($exaanswer)) {
        $ret['msg'] = "考试记录不存在！";
        exit(json_encode($ret));
    }
    if ($exaanswer['status']!=1) {
        $ret['msg'] = "考试记录不在答卷状态！";
        exit(json_encode($ret));
    }
    $exaitemall = pdo_fetchall("SELECT i.*,b.title,b.tilpic,b.qtype,b.answer,b.aright,b.awrong FROM ".tablename($this->table_exaitem)." i LEFT JOIN ".tablename($this->table_exabank)." b ON i.bankid=b.id WHERE i.foreignid=:foreignid AND i.userid=:userid AND i.uniacid=:uniacid AND i.itype=2 ORDER BY i.id ASC", array(':foreignid'=>$exaanswer['id'],':userid'=>$user['id'],':uniacid'=>$_W['uniacid']));
    $idwrongarr = array();
    $idrightarr = array();
    $singlenumr = 0;
    $multinumr = 0;
    foreach ($exaitemall as $k => $v) {
        if ($v['isright']==0 && $exaanswer['etime']>time()) {
            $ret['msg'] = "还有题目未作答！";
            $ret['index'] = $k;
            exit(json_encode($ret));
        }elseif ($v['isright']==1) {
            $idwrongarr[] = $v['bankid'];
        }elseif ($v['isright']==2) {
            $idrightarr[] = $v['bankid'];
            if ($v['qtype']==1) {
                $singlenumr++;
            }elseif ($v['qtype']==2) {
                $multinumr++;
            }
        }
    }
    $getval = $singlenumr * $exapaper['singleval'] + $multinumr * $exapaper['multival'];
    $integral = floor(($getval/$exaanswer['setval'])*$exapaper['integral']);
    $data = array(
        'status'     => 2,
        'aright'     => count($idrightarr),
        'awrong'     => count($idwrongarr),
        'getval'     => $getval,
        'integral'   => $integral,
        'finishtime' => time()
        );
    if ($integral>0) {
        $intdata = array(
            'userid'    => $user['id'],
            'channel'   => "exaanswer",
            'foreignid' => $exaanswer['id'],
            'integral'  => $integral,
            'remark'    => $exapaper['title']." 考试得分",
            );
        $this->setIntegral($intdata);
    }
    pdo_update($this->table_exaanswer, $data, array('id'=>$exaanswer['id']));
    if (!empty($idwrongarr)) {
        pdo_update($this->table_exapevery, array('awrong +='=>1), array('bankid'=>$idwrongarr,'paperid'=>$exapaperid));
        pdo_update($this->table_exabank, array('awrong +='=>1), array('id'=>$idwrongarr));
    }
    if (!empty($idrightarr)) {
        pdo_update($this->table_exapevery, array('aright +='=>1), array('bankid'=>$idrightarr,'paperid'=>$exapaperid));
        pdo_update($this->table_exabank, array('aright +='=>1), array('id'=>$idrightarr));
    }
    $ret['status'] = "success";
    $ret['msg'] = "success";
    exit(json_encode($ret));

}
include $this->template('exaanswer');
?>