<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $id = intval($_GPC['id']);
    $educhapter = pdo_get($this->table_educhapter, array('id'=>$id,'status'=>2,'uniacid'=>$_W['uniacid']), "", "id");
    if (empty($educhapter)) {
        message("章节信息不存在！",referer(),'error');
    }
    $educatelist = pdo_fetchall("SELECT * FROM ".tablename($this->table_educate)." WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']),'id');

    $edulog = pdo_get($this->table_edulog, array('chapterid'=>$id,'lessonid'=>$educhapter['lessonid'],'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    if (empty($edulog)) {
        $edulog = array(
            'uniacid'    => $_W['uniacid'],
            'userid'     => $user['id'],
            'lessonid'   => $educhapter['lessonid'],
            'chapterid'  => $id,
            'stutime'    => 0,
            'status'     => 1,
            'createtime' => time(),
            );
        pdo_insert($this->table_edulog, $edulog);
        $edulog['id'] = pdo_insertid();
    }
    if (!empty($educhapter['link'])) {
		if ($edulog['status']==1) {
			pdo_update($this->table_edulog, array('status'=>2), array('id'=>$edulog['id']));
		}
        header( "Location: ".urldecode($educhapter['link']) );
    }
    $edulesson = pdo_get($this->table_edulesson, array('id'=>$educhapter['lessonid'],'status'=>array(1,2),'uniacid'=>$_W['uniacid']));

    $educhapterall = pdo_fetchall("SELECT * FROM ".tablename($this->table_educhapter)." WHERE status=2 AND lessonid=:lessonid AND uniacid=:uniacid ORDER BY priority DESC , id ASC ", array(':lessonid'=>$educhapter['lessonid'],':uniacid'=>$_W['uniacid']),"id");
    $edulogall = pdo_fetchall("SELECT * FROM ".tablename($this->table_edulog)." WHERE status=2 AND lessonid=:lessonid AND userid=:userid AND uniacid=:uniacid ", array(':lessonid'=>$educhapter['lessonid'],':userid'=>$user['id'],':uniacid'=>$_W['uniacid']),"chapterid");

    $prev = get_element($id, $educhapterall, 'prev');
    $next = get_element($id, $educhapterall, 'next');


    // var_dump($next);die;

} elseif ($op=="stutime") {
    $chapterid = intval($_GPC['chapterid']);
    $logid = intval($_GPC['logid']);
    $needtime = intval($_GPC['needtime']);
    $stutime = intval($_GPC['stutime']);
    if ($stutime<$needtime) {
        pdo_update($this->table_edulog,array('stutime'=>$stutime),array('id'=>$logid));
        exit("success");
    } else {
        pdo_update($this->table_edulog,array('stutime'=>$needtime,'status'=>2),array('id'=>$logid));
        exit("success");
    }

}
include $this->template('educhapter');
?>