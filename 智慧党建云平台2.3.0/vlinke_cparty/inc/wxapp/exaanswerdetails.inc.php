<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
if ($op=="display") {
    $userid = intval($_GPC['userid']);
    $id = intval($_GPC['id']);
    $exaanswer = pdo_get($this->table_exaanswer, array('uniacid'=>$_W['uniacid'],'userid'=>$userid,'id'=>$id));
    if (empty($exaanswer)) {
        $this->result(1, '考试记录不存在！');
    }
    $usertime = $exaanswer['finishtime']-$exaanswer['stime'];
    if ($usertime<=0) {
        $exaanswer['usertime'] = "未完成";
    }else{
        $exaanswer['usertime'] = floor($usertime/60)."分". $usertime%60 ."秒";
    }
    $exaanswer['stime'] = date("Y-m-d H:i",$exaanswer['stime']);
    $exaanswer['etime'] = date("Y-m-d H:i",$exaanswer['etime']);
    $exaanswer['finishtime'] = date("Y-m-d H:i",$exaanswer['finishtime']);

    $exapaper = pdo_get($this->table_exapaper, array('id'=>$exaanswer['paperid'],'uniacid'=>$_W['uniacid']));
    if (empty($exapaper)) {
        $this->result(1, '考试项目不存在！');
    }
    $exapaper['starttime'] = date("Y-m-d H:i",$exapaper['starttime']);
    $exapaper['endtime'] = date("Y-m-d H:i",$exapaper['endtime']);
    $exaitemall = pdo_fetchall("SELECT i.*,b.title,b.tilpic,b.qtype,b.itema,b.itemb,b.itemc,b.itemd,b.iteme,b.itemf,b.answer,b.aright,b.awrong FROM ".tablename($this->table_exaitem)." i LEFT JOIN ".tablename($this->table_exabank)." b ON i.bankid=b.id WHERE i.foreignid=:foreignid AND i.userid=:userid AND i.uniacid=:uniacid AND i.itype=2 ORDER BY i.id ASC", array(':foreignid'=>$exaanswer['id'],':userid'=>$userid,':uniacid'=>$_W['uniacid']));
    foreach ($exaitemall as $k => $v) {
        $exaitemall[$k]['itemachecked'] = strpos($v['myanswer'],'A')!==false ? true : false;
        $exaitemall[$k]['itembchecked'] = strpos($v['myanswer'],'B')!==false ? true : false;
        $exaitemall[$k]['itemcchecked'] = strpos($v['myanswer'],'C')!==false ? true : false;
        $exaitemall[$k]['itemdchecked'] = strpos($v['myanswer'],'D')!==false ? true : false;
        $exaitemall[$k]['itemechecked'] = strpos($v['myanswer'],'E')!==false ? true : false;
        $exaitemall[$k]['itemfchecked'] = strpos($v['myanswer'],'F')!==false ? true : false;

        $exaitemall[$k]['ischange'] = false;

        $atotal = $v['aright'] + $v['awrong'];
        $exaitemall[$k]['atotal'] = $atotal;
        $exaitemall[$k]['arprob'] = $atotal==0 ? "--" : round($v['aright']*100/$atotal)."%";
    }

    $timelimit = $exaanswer['status']==1 ? $exaanswer['etime']-time() : 0 ;

    $this->result(0, '', array(
        'exaanswer'    => $exaanswer,
        'exapaper'     => $exapaper,
        'exaitemall'   => $exaitemall,
        'timelimit'    => $timelimit,
        'maxitemindex' => count($exaitemall)-1
        ));


}elseif ($op=="startanswer") {
    $userid = intval($_GPC['userid']);
    $id = intval($_GPC['id']);
    $exaanswer = pdo_get($this->table_exaanswer, array('uniacid'=>$_W['uniacid'],'userid'=>$userid,'id'=>$id));
    if (empty($exaanswer)) {
        $this->result(1, '考试记录不存在！');
    }elseif ($exaanswer['status']!=0) {
        $this->result(1, '考试已开始答卷或已答卷完成！');
    }
    $exapaper = pdo_get($this->table_exapaper, array('id'=>$exaanswer['paperid'],'uniacid'=>$_W['uniacid']));
    if (empty($exapaper)) {
        $this->result(1, '考试项目不存在！');
    }
    $data = array(
        'status' => 1,
        'stime'  => time(),
        'etime'  => time() + 60*$exapaper['timelimit']
        );
    pdo_update($this->table_exaanswer, $data, array('id'=>$id));
    $this->result(0, '');


}elseif ($op=="setitem") {
    $exaitemid = intval($_GPC['exaitemid']);
    $exaitem = pdo_get($this->table_exaitem, array('id'=>$exaitemid));
    $exaanswer = pdo_get($this->table_exaanswer, array('id'=>$exaitem['foreignid']));
    $exabank = pdo_get($this->table_exabank, array('id'=>$exaitem['bankid']));
    if (empty($exaitem) || empty($exaanswer) || empty($exabank)) {
        $this->result(1, '记录不存在，请重新进入！');
    }
    if ($exaanswer['status']==2) {
        $this->result(1, '考试已完成！');
    }
    $myanswer = trim($_GPC['myanswer']);
    $data = array(
        'myanswer' => $myanswer,
        'isright'  => $myanswer==$exabank['answer'] ? 2 : 1 ,
        );
    pdo_update($this->table_exaitem, $data, array('id'=>$exaitemid));
    $this->result(0, '');

}elseif ($op=="setanswer") {

    $userid = intval($_GPC['userid']);
    $id = intval($_GPC['id']);
    $exaanswer = pdo_get($this->table_exaanswer, array('uniacid'=>$_W['uniacid'],'userid'=>$userid,'id'=>$id));
    if (empty($exaanswer)) {
        $this->result(1, '考试记录不存在！');
    }elseif ($exaanswer['status']!=1) {
        $this->result(1, '考试记录不在答卷状态！');
    }
    $exapaper = pdo_get($this->table_exapaper, array('id'=>$exaanswer['paperid'],'uniacid'=>$_W['uniacid']));
    if (empty($exapaper)) {
        $this->result(1, '考试项目不存在！');
    }

    $exaitemall = pdo_fetchall("SELECT i.*,b.title,b.tilpic,b.qtype,b.answer,b.aright,b.awrong FROM ".tablename($this->table_exaitem)." i LEFT JOIN ".tablename($this->table_exabank)." b ON i.bankid=b.id WHERE i.foreignid=:foreignid AND i.userid=:userid AND i.uniacid=:uniacid AND i.itype=2 ORDER BY i.id ASC", array(':foreignid'=>$exaanswer['id'],':userid'=>$userid,':uniacid'=>$_W['uniacid']));
    $idwrongarr = array();
    $idrightarr = array();
    $singlenumr = 0;
    $multinumr = 0;
    foreach ($exaitemall as $k => $v) {
        if ($v['isright']==0 && $exaanswer['etime']>time()) {
            $this->result(1, '还有题目未作答！');
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
            'userid'    => $userid,
            'channel'   => "exaanswer",
            'foreignid' => $exaanswer['id'],
            'integral'  => $integral,
            'remark'    => $exapaper['title']." 考试得分",
            );
        $this->setIntegral($intdata);
    }
    pdo_update($this->table_exaanswer, $data, array('id'=>$exaanswer['id']));
    if (!empty($idwrongarr)) {
        pdo_update($this->table_exapevery, array('awrong +='=>1), array('bankid'=>$idwrongarr,'paperid'=>$exapaper['id']));
        pdo_update($this->table_exabank, array('awrong +='=>1), array('id'=>$idwrongarr));
    }
    if (!empty($idrightarr)) {
        pdo_update($this->table_exapevery, array('aright +='=>1), array('bankid'=>$idrightarr,'paperid'=>$exapaper['id']));
        pdo_update($this->table_exabank, array('aright +='=>1), array('id'=>$idrightarr));
    }
    $this->result(0, '');

}
?>

