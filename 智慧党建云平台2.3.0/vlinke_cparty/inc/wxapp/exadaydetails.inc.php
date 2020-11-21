<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
if ($op=="display") {
    $userid = intval($_GPC['userid']);
    $id = intval($_GPC['id']);

    if ($id==0) {
        $stoday = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $etoday = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        $exaday = pdo_get($this->table_exaday, array('uniacid'=>$_W['uniacid'],'userid'=>$userid,'createtime >'=>$stoday,'createtime <'=>$etoday));
        if (empty($exaday)) {
            $param = pdo_get($this->table_param,array('uniacid'=>$_W['uniacid']));
            if ($param['exadaystatus']==2) {
                $this->result(1, '每日测试已关闭！');
            }
            $exadeveryall = pdo_fetchall("SELECT * FROM ".tablename($this->table_exadevery)." WHERE uniacid=:uniacid ORDER BY rand() LIMIT ".$param['exaeverynum'], array(':uniacid'=>$_W['uniacid']));
            if ($param['exaeverynum']<=0) {
                $this->result(1, '每日测试题数不能小于等于0道，请管理员设置每日测试题数目！');
            }
            if ($param['exaeverynum']>count($exadeveryall)) {
                $this->result(1, '每日测试至少回答'.$param['exaeverynum'].'道题，请管理员追加测试题库题量！');
            }
            $exaday = array(
                'uniacid'    => $_W['uniacid'],
                'title'      => date('Y')."年".date('m')."月".date('d')."日测试",
                'userid'     => $userid,
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
                'userid'     => $userid,
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
    }else{
        $exaday = pdo_get($this->table_exaday, array('id'=>$id,'uniacid'=>$_W['uniacid'],'userid'=>$userid));
    }

    if (empty($exaday)) {
        $this->result(1, '测试记录不存在！');
    }
    $exaday['finishtime'] = date("Y-m-d H:i",$exaday['finishtime']);

    $exaitemall = pdo_fetchall("SELECT i.*,b.title,b.tilpic,b.qtype,b.itema,b.itemb,b.itemc,b.itemd,b.iteme,b.itemf,b.answer,b.aright,b.awrong FROM ".tablename($this->table_exaitem)." i LEFT JOIN ".tablename($this->table_exabank)." b ON i.bankid=b.id WHERE i.foreignid=:foreignid AND i.userid=:userid AND i.uniacid=:uniacid AND i.itype=1 ORDER BY i.id ASC", array(':foreignid'=>$exaday['id'],':userid'=>$userid,':uniacid'=>$_W['uniacid']));

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

    $this->result(0, '', array(
        'exaday'       => $exaday,
        'exaitemall'   => $exaitemall,
        'maxitemindex' => count($exaitemall)-1
        ));

}elseif ($op=="setitem") {
    $exaitemid = intval($_GPC['exaitemid']);
    $exaitem = pdo_get($this->table_exaitem, array('id'=>$exaitemid));
    $exaday = pdo_get($this->table_exaday, array('id'=>$exaitem['foreignid']));
    $exabank = pdo_get($this->table_exabank, array('id'=>$exaitem['bankid']));
    if (empty($exaitem) || empty($exaday) || empty($exabank)) {
        $this->result(1, '测试记录不存在，请重新进入！');
    }
    if ($exaday['status']==2) {
        $this->result(1, '测试已完成！');
    }
    $myanswer = trim($_GPC['myanswer']);
    $data = array(
        'myanswer' => $myanswer,
        'isright'  => $myanswer==$exabank['answer'] ? 2 : 1 ,
        );
    pdo_update($this->table_exaitem, $data, array('id'=>$exaitemid));
    $this->result(0, '');

}elseif ($op=="setday") {
    $id = intval($_GPC['id']);
    $userid = intval($_GPC['userid']);
    $exaday = pdo_get($this->table_exaday, array('id'=>$id,'uniacid'=>$_W['uniacid'],'userid'=>$userid));
    if (empty($exaday)) {
        $this->result(1, '测试记录不存在！');
    }
    $exaitemall = pdo_fetchall("SELECT * FROM ".tablename($this->table_exaitem)." WHERE foreignid=:foreignid AND userid=:userid AND uniacid=:uniacid AND itype=1 ORDER BY id ASC", array(':foreignid'=>$id,':userid'=>$userid,':uniacid'=>$_W['uniacid']));
    $idwrongarr = array();
    $idrightarr = array();
    foreach ($exaitemall as $k => $v) {
        if ($v['isright']==0) {
            $this->result(1, '还有题目未作答！');
        }elseif ($v['isright']==1) {
            $idwrongarr[] = $v['bankid'];
        }elseif ($v['isright']==2) {
            $idrightarr[] = $v['bankid'];
        }
    }
    $param = pdo_get($this->table_param,array('uniacid'=>$_W['uniacid']));
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
            'userid'    => $userid,
            'channel'   => "exaday",
            'foreignid' => $id,
            'integral'  => $integral,
            'remark'    => $exaday['title']."得分",
            );
        $this->setIntegral($intdata);
    }
    pdo_update($this->table_exaday, $data, array('id'=>$id));
    if (!empty($idwrongarr)) {
        pdo_update($this->table_exadevery, array('awrong +='=>1), array('bankid'=>$idwrongarr));
        pdo_update($this->table_exabank, array('awrong +='=>1), array('id'=>$idwrongarr));
    }
    if (!empty($idrightarr)) {
        pdo_update($this->table_exadevery, array('aright +='=>1), array('bankid'=>$idrightarr));
        pdo_update($this->table_exabank, array('aright +='=>1), array('id'=>$idrightarr));
    }
    $this->result(0, '');

}
?>