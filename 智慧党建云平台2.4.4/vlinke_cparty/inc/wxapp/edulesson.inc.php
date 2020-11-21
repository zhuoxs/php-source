<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {
    $id = intval($_GPC['id']);
    $edulesson = pdo_get($this->table_edulesson, array('id'=>$id,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($edulesson)) {
        $this->result(1, '课程信息不存在！');
    }
    $educate = pdo_get($this->table_educate, array('id'=>$edulesson['cateid'],'uniacid'=>$_W['uniacid']));

    $userid = intval($_GPC['userid']);
    $edustudy = pdo_get($this->table_edustudy, array('lessonid'=>$id,'userid'=>$userid,'uniacid'=>$_W['uniacid']));
    if (empty($edustudy)) {
        $edustudy = array(
            'uniacid'    => $_W['uniacid'],
            'userid'     => $userid,
            'lessonid'   => $id,
            'getval'     => 0,
            'status'     => 1,
            'createtime' => time(),
            );
        pdo_insert($this->table_edustudy, $edustudy);
        $edustudy['id'] = pdo_insertid();
    }


    $edustudytol = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_edustudy)." WHERE status=2 AND lessonid=:lessonid AND uniacid=:uniacid ", array(':lessonid'=>$id,':uniacid'=>$_W['uniacid']));

    $educhapterall = pdo_fetchall("SELECT id,uniacid,title,lessonid,status,priority,needtime FROM ".tablename($this->table_educhapter)." WHERE status=2 AND lessonid=:lessonid AND uniacid=:uniacid ORDER BY priority DESC , id ASC ", array(':lessonid'=>$id,':uniacid'=>$_W['uniacid']));
    $edulogall = pdo_fetchall("SELECT * FROM ".tablename($this->table_edulog)." WHERE status=2 AND lessonid=:lessonid AND userid=:userid AND uniacid=:uniacid ", array(':lessonid'=>$id,':userid'=>$userid,':uniacid'=>$_W['uniacid']),"chapterid");
    foreach ($educhapterall as $k => $v) {
        $educhapterall[$k]['logstatus'] = empty($edulogall[$v['id']]) ? 0 : 1 ;
    }


    if ( $edulesson['status']==2 && $edustudy['status']==1 && count($educhapterall)==count($edulogall) ) {
        pdo_update($this->table_edustudy,array('status'=>2,'getval'=>$edulesson['integral']),array('id'=>$edustudy['id']));

        $integral = pdo_get($this->table_integral,array('userid'=>$userid,'channel'=>'edustudy','foreignid'=>$edustudy['id'],'uniacid'=>$_W['uniacid']));
        if (empty($integral) && $edulesson['integral']>0) {
            $data = array(
                'userid'    => $userid,
                'channel'   => "edustudy",
                'foreignid' => $edustudy['id'],
                'integral'  => $edulesson['integral'],
                'remark'    => "学习《".$edulesson['title']."》课程奖励",
                );
            $this->setIntegral($data);
        }
        $edustudy['status'] = 2;
    }


    $edulesson['tilpic'] = tomedia($edulesson['tilpic']);
    $edulesson['apath'] = tomedia($edulesson['apath']);
    $edulesson['vpath'] = tomedia($edulesson['vpath']);
    $edulesson['details'] = str_replace('<img', '<img style="max-width:100%;height:auto" ', htmlspecialchars_decode($edulesson['details']));
    $edulesson['createtime'] = date("Y-m-d H:i", $edulesson['createtime']);

    $this->result(0, '', array(
        'edulesson'     => $edulesson,
        'educate'       => $educate,
        'edustudy'      => $edustudy,
        'edustudytol'   => intval($edustudytol),
        'educhapterall' => $educhapterall
        ));

}
?>