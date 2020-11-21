<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {


}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_exapaper)." WHERE uniacid=:uniacid AND starttime<=:starttime ORDER BY endtime DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':uniacid'=>$_W['uniacid'],':starttime'=>time()), "id");
    if (empty($list)) {
        exit("NOTHAVE");
    }
    $idarr = array_keys($list);
    $exaanswer = pdo_getall($this->table_exaanswer, array('paperid'=>$idarr,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']), "", "paperid");

}elseif ($op=="create") {
    $exapaperid = intval($_GPC['exapaperid']);
    $exaanswer = pdo_get($this->table_exaanswer, array('uniacid'=>$_W['uniacid'],'userid'=>$user['id'],'paperid'=>$exapaperid));
    if (empty($exaanswer)) {
        $exapaper = pdo_get($this->table_exapaper, array('uniacid'=>$_W['uniacid'],'id'=>$exapaperid));
        if ($exapaper['starttime']>time()) {
            message("还未到考试开始时间！",referer(),'error');
        }
        if ($exapaper['endtime']<time()) {
            message("考试已结束！",referer(),'error');
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
            message("请告知管理员：试卷试题库单选题或多选题数量不足于组卷！",referer(),'error');
        }
        shuffle($singlearr);
        shuffle($multiarr);
        $singlearr = array_slice($singlearr, 0, $exapaper['singlenum']);
        $multiarr = array_slice($multiarr, 0, $exapaper['multinum']);
        $arr = array_merge($singlearr , $multiarr);
        shuffle($arr);

        $exaanswer = array(
            'uniacid'    => $_W['uniacid'],
            'userid'     => $user['id'],
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
        $exaanswer['id'] = pdo_insertid();

        $data = array(
            'uniacid'    => $_W['uniacid'],
            'userid'     => $user['id'],
            'itype'      => 2,
            'foreignid'  => $exaanswer['id'],
            'myanswer'   => "",
            'isright'    => 0,
            'createtime' => time()
            );
        foreach ($arr as $k => $v) {
            $data['bankid'] = $v;
            pdo_insert($this->table_exaitem, $data);
        }
    }
    $url = $this->createMobileUrl('exaanswer',array('op'=>'answer','exapaperid'=>$exapaperid));
    header("location:".$url);

}
include $this->template('exapaper');
?>