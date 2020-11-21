<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {
    $id = intval($_GPC['id']);
    $educhapter = pdo_get($this->table_educhapter, array('id'=>$id,'status'=>2,'uniacid'=>$_W['uniacid']));
    if (empty($educhapter)) {
        $this->result(1, '章节信息不存在！');
    }
    $edulesson = pdo_get($this->table_edulesson, array('id'=>$educhapter['lessonid'],'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    $educate = pdo_get($this->table_educate, array('id'=>$edulesson['cateid'],'uniacid'=>$_W['uniacid']));

    $userid = intval($_GPC['userid']);
    $edulog = pdo_get($this->table_edulog, array('chapterid'=>$id,'lessonid'=>$educhapter['lessonid'],'userid'=>$userid,'uniacid'=>$_W['uniacid']));
    if (empty($edulog)) {
        $edulog = array(
            'uniacid'    => $_W['uniacid'],
            'userid'     => $userid,
            'lessonid'   => $educhapter['lessonid'],
            'chapterid'  => $id,
            'stutime'    => 0,
            'status'     => 1,
            'createtime' => time(),
            );
        pdo_insert($this->table_edulog, $edulog);
        $edulog['id'] = pdo_insertid();
    }

    $educhapterall = pdo_fetchall("SELECT id,uniacid,title,lessonid,status,priority,needtime FROM ".tablename($this->table_educhapter)." WHERE status=2 AND lessonid=:lessonid AND uniacid=:uniacid ORDER BY priority DESC , id ASC ", array(':lessonid'=>$edulesson['id'],':uniacid'=>$_W['uniacid']),'id');
    $edulogall = pdo_fetchall("SELECT * FROM ".tablename($this->table_edulog)." WHERE status=2 AND lessonid=:lessonid AND userid=:userid AND uniacid=:uniacid ", array(':lessonid'=>$edulesson['id'],':userid'=>$userid,':uniacid'=>$_W['uniacid']),"chapterid");
    foreach ($educhapterall as $k => $v) {
        $educhapterall[$k]['logstatus'] = empty($edulogall[$v['id']]) ? 0 : 1 ;
    }

    $educhapter['tilpic'] = tomedia($educhapter['tilpic']);
    $educhapter['apath'] = tomedia($educhapter['apath']);
    $educhapter['vpath'] = tomedia($educhapter['vpath']);
    $educhapter['details'] = str_replace('<img', '<img style="max-width:100%;height:auto" ', htmlspecialchars_decode($educhapter['details']));
    $educhapter['createtime'] = date("Y-m-d H:i", $educhapter['createtime']);

    $prev = get_element($id, $educhapterall, 'prev');
    $next = get_element($id, $educhapterall, 'next');

    if (!empty($educhapter['link']) && $edulog['status']==1) {
        pdo_update($this->table_edulog, array('status'=>2), array('id'=>$edulog['id']));
    }

    $this->result(0, '', array(
        'educhapter'    => $educhapter,
        'edulesson'     => $edulesson,
        'educate'       => $educate,
        'edulog'        => $edulog,
        'educhapterall' => $educhapterall,
        'prev'          => empty($prev)?"":$prev,
        'next'          => empty($next)?"":$next
        ));


} elseif ($op=="stutime") {
    $chapterid = intval($_GPC['chapterid']);
    $logid = intval($_GPC['logid']);
    $needtime = intval($_GPC['needtime']);
    $stutime = intval($_GPC['stutime']);
    if ($stutime<$needtime) {
        pdo_update($this->table_edulog,array('stutime'=>$stutime),array('id'=>$logid));
    } else {
        pdo_update($this->table_edulog,array('stutime'=>$needtime,'status'=>2),array('id'=>$logid));
    }
    $this->result(0, '', array());

}
?>