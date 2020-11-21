<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
if ($op=="display") {


}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize']));
    $userid = intval($_GPC['userid']);
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_exapaper)." WHERE uniacid=:uniacid AND starttime<=:starttime ORDER BY endtime DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':uniacid'=>$_W['uniacid'],':starttime'=>time()),"id");
    if (!empty($list)) {
        $idarr = array_keys($list);
        $exaanswer = pdo_getall($this->table_exaanswer, array('paperid'=>$idarr,'userid'=>$userid,'uniacid'=>$_W['uniacid']), "", "paperid");
        foreach ($list as $k => $v) {
            $list[$k]['endtime'] = date("Y-m-d H:i",$v['endtime']);
            $list[$k]['astatus'] = intval($exaanswer[$v['id']]['status']);
        }
    }
    $this->result(0, '', array_values($list));

}elseif ($op=="create") {

    $exapaperid = intval($_GPC['id']);
    $userid = intval($_GPC['userid']);
    $exaanswer = pdo_get($this->table_exaanswer, array('uniacid'=>$_W['uniacid'],'userid'=>$userid,'paperid'=>$exapaperid));

    if (empty($exaanswer)) {
        $exapaper = pdo_get($this->table_exapaper, array('uniacid'=>$_W['uniacid'],'id'=>$exapaperid));
        if (empty($exapaper)) {
            $this->result(1, '考试项目不存在！');
        }
        if ($exapaper['starttime']>time()) {
            $this->result(1, '还未到考试开始时间！');
        }
        if ($exapaper['endtime']<time()) {
            $this->result(1, '考试已结束！');
        }

        $exapeveryall = pdo_fetchall("SELECT p.paperid,p.aright as paright,p.awrong as pawrong,b.* FROM ".tablename($this->table_exapevery)." p LEFT JOIN ".tablename($this->table_exabank)." b ON p.bankid=b.id WHERE p.uniacid=:uniacid AND p.paperid=:paperid ", array(':uniacid'=>$_W['uniacid'],':paperid'=>$exapaperid),'id');
        $singletol = 0;
        $singlearr = array();
        $multitol = 0;
        $multiarr = array();
        if (!empty($exapeveryall)) {
            foreach ($exapeveryall as $k => $v) {
                if ($v['qtype']==1) {
                    $singletol++;
                    $singlearr[] = $v['id'];
                }elseif ($v['qtype']==2) {
                    $multitol++;
                    $multiarr[] = $v['id'];
                }
            }
        }
        if ($singletol<$exapaper['singlenum'] || $multitol<$exapaper['multinum']) {
            $this->result(1, '请告知管理员：试卷试题库单选题或多选题数量不足于组卷！');
        }
        shuffle($singlearr);
        shuffle($multiarr);
        $singlearr = array_slice($singlearr, 0, $exapaper['singlenum']);
        $multiarr = array_slice($multiarr, 0, $exapaper['multinum']);
        $arr = array_merge($singlearr , $multiarr);
        shuffle($arr);

        $exaanswer = array(
            'uniacid'    => $_W['uniacid'],
            'userid'     => $userid,
            'paperid'    => $exapaperid,
            'status'     => 0, 
            'aright'     => 0,
            'awrong'     => 0,
            'setval'     => $exapaper['singlenum']*$exapaper['singleval'] + $exapaper['multinum']*$exapaper['multival'] ,
            'getval'     => 0,
            'integral'   => 0,
            'stime'      => 0,
            'etime'      => 0,
            'finishtime' => 0,
            'createtime' => time()
            );
        pdo_insert($this->table_exaanswer, $exaanswer);
        $exaanswerid = pdo_insertid();

        $data = array(
            'uniacid'    => $_W['uniacid'],
            'userid'     => $userid,
            'itype'      => 2,
            'foreignid'  => $exaanswerid,
            'myanswer'   => "",
            'isright'    => 0,
            'createtime' => time()
            );
        foreach ($arr as $k => $v) {
            $data['bankid'] = $v;
            pdo_insert($this->table_exaitem, $data);
        }

    }else{
        $exaanswerid = $exaanswer['id'];
    }

    $this->result(0, '', array('exaanswerid'=>$exaanswerid));

}
?>