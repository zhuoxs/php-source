<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $con = ' WHERE uniacid=:uniacid ';
    $par[':uniacid'] = $_W['uniacid'];
    $keyword = $_GPC['keyword'];
    if (!empty($keyword)) {
        $con .= " AND title LIKE :keyword ";
        $par[':keyword'] = "%".$keyword."%";
    }
    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND cateid=:cateid ";
        $par[':cateid'] = $cateid;
    }
    $stustatus = intval($_GPC['stustatus']);
    if ($stustatus!=0) {
        $con .= " AND stustatus=:stustatus ";
        $par[':stustatus'] = $stustatus;
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND status=:status ";
        $par[':status'] = $status;
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;

    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_edulesson).$con.' ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par,'id');
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_edulesson).$con, $par);
    $pager = pagination($total, $pindex, $psize);

    if (!empty($list)) {
        $keys = implode(",", array_keys($list));
        $educhaptertol = pdo_fetchall("SELECT count(*) as tol, lessonid FROM ".tablename($this->table_educhapter)." WHERE lessonid IN (".$keys.") AND uniacid=:uniacid GROUP BY lessonid ", array(':uniacid'=>$_W['uniacid']), "lessonid");
        $edustudytol = pdo_fetchall("SELECT count(*) as tol, lessonid FROM ".tablename($this->table_edustudy)." WHERE lessonid IN (".$keys.") AND uniacid=:uniacid GROUP BY lessonid ", array(':uniacid'=>$_W['uniacid']), "lessonid");
    }else{
        $educhaptertol = array();
        $edustudytol = array();
    }
    $educate = pdo_getall($this->table_educate, array('uniacid'=>$_W['uniacid']), '', 'id');

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall('SELECT * FROM '.tablename($this->table_edulesson).$con.' ORDER BY priority DESC, id DESC',$par);
        $statusarr = array(1=>"更新中",2=>"已结课",3=>"已隐藏");
        $stustatusarr = array(1=>"必修",2=>"选修");
        $educhaptertol = pdo_fetchall("SELECT count(*) as tol, lessonid FROM ".tablename($this->table_educhapter)." WHERE uniacid=:uniacid GROUP BY lessonid ", array(':uniacid'=>$_W['uniacid']), "lessonid");
        $edustudytol = pdo_fetchall("SELECT count(*) as tol, lessonid FROM ".tablename($this->table_edustudy)." WHERE uniacid=:uniacid GROUP BY lessonid ", array(':uniacid'=>$_W['uniacid']), "lessonid");
        foreach($list_out as $k=>$v){
            $data[$k] = array(
                'id'            => $v['id'],
                'cateid'        => $educate[$v['cateid']]['name'],
                'title'         => $v['title'],
                'integral'      => $v['integral'],
                'stustatus'     => $stustatusarr[$v['stustatus']],
                'status'        => $statusarr[$v['status']],
                'educhaptertol' => intval($educhaptertol[$v['id']]['tol']),
                'edustudytol'   => intval($edustudytol[$v['id']]['tol']),
                'createtime'    => date('Y-m-d H:i:s',$v['createtime'])."\t",
                'priority'      => $v['priority'],
                );
        }
        $arrhead = array("ID","分类","标题","学习积分","必选修","状态","章节数","学习数","时间","排序ID");
        export_excel($data,$arrhead,time());
        exit();
    }

}elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $data = array(
            'uniacid'   => $_W['uniacid'],
            'cateid'    => intval($_GPC['cateid']),
            'title'     => trim($_GPC['title']),
            'tilpic'    => trim($_GPC['tilpic']),
            'apath'     => trim($_GPC['apath']),
            'vpath'     => trim($_GPC['vpath']),
            'details'   => trim($_GPC['details']),
            'integral'  => intval($_GPC['integral']),
            'stustatus' => intval($_GPC['stustatus']),
            'status'    => intval($_GPC['status']),
            'priority'  => intval($_GPC['priority']),
        );
        if (!empty($id)) {
            pdo_update($this->table_edulesson, $data, array('id' => $id));
        } else {
            $data['createtime'] = time();
            pdo_insert($this->table_edulesson, $data);
        }
        message('信息更新成功！', $this->createWebUrl('edulesson'), 'success');
    }
    $edulesson = pdo_get($this->table_edulesson, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($edulesson)) {
        $edulesson = array(
            'integral'  => 0,
            'stustatus' => 1,
            'status'    => 2,
            'priority'  => 0,
        );
    }
    $educate = pdo_getall($this->table_educate, array('uniacid'=>$_W['uniacid']), '', 'id');

} elseif ($op == 'checklesson') {
    $edulessontitle = trim($_GPC['edulessontitle']);
    $edulessonlist = pdo_fetchall("SELECT * FROM ".tablename($this->table_edulesson)." WHERE uniacid=:uniacid AND title LIKE :title ORDER BY id DESC ", array(':uniacid'=>$_W['uniacid'],':title'=>"%".$edulessontitle."%"), "id");

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $edulesson = pdo_get($this->table_edulesson,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($edulesson)) {
        message('要删除的学习知识不存在或是已经被删除！', referer(), 'error');
    }
    $educhapter = pdo_getall($this->table_educhapter, array('lessonid'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($educhapter)) {
        message('要删除的课程下有章节记录，请先处理课程下章节记录再做删除操作！', referer(), 'error');
    }
    pdo_delete($this->table_edustudy, array('lessonid'=>$id,'uniacid'=>$_W['uniacid']));
    pdo_delete($this->table_edumessage, array('lessonid'=>$id,'uniacid'=>$_W['uniacid']));
    $result = pdo_delete($this->table_edulesson, array('id' => $id));
    if (!empty($result)) {
        message("数据删除成功！",referer(),'success');
    }
    message("数据删除失败，请刷新页面重试！",referer(),'error');


}
include $this->template('edulesson');
?>