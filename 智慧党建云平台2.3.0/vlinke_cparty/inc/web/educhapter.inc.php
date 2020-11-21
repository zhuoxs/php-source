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
    $lessonid = intval($_GPC['lessonid']);
    if ($lessonid!=0) {
        $con .= " AND lessonid=:lessonid ";
        $par[':lessonid'] = $lessonid;
        $edulesson = pdo_get($this->table_edulesson,array('id'=>$lessonid,'uniacid'=>$_W['uniacid']));
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND status=:status ";
        $par[':status'] = $status;
    }
    
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_educhapter).$con.' ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par,'id');
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_educhapter).$con, $par);
    $pager = pagination($total, $pindex, $psize);

    if (!empty($list)) {
        $lessonids = implode(",", array_column($list,'lessonid'));
        $edulessonarr = pdo_fetchall("SELECT * FROM ".tablename($this->table_edulesson)." WHERE id IN (".$lessonids.") AND uniacid=:uniacid ", array(':uniacid'=>$_W['uniacid']), "id");
        $keys = implode(",", array_keys($list));
        $edulogtol = pdo_fetchall("SELECT count(*) as tol, chapterid FROM ".tablename($this->table_edulog)." WHERE chapterid IN (".$keys.") AND uniacid=:uniacid GROUP BY chapterid ", array(':uniacid'=>$_W['uniacid']), "chapterid");
    }else{
        $edulessonarr = array();
        $edulogtol = array();
    }

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall('SELECT * FROM '.tablename($this->table_educhapter).$con.' ORDER BY priority DESC, id DESC',$par);
        $statusarr = array(1=>"待审核",2=>"已归档",3=>"已隐藏");

        $edulessonarr = pdo_fetchall("SELECT id, title FROM ".tablename($this->table_edulesson)." WHERE uniacid=:uniacid ", array(':uniacid'=>$_W['uniacid']), "id");
        $edulogtol = pdo_fetchall("SELECT count(id) as tol, chapterid FROM ".tablename($this->table_edulog)." WHERE uniacid=:uniacid GROUP BY chapterid ", array(':uniacid'=>$_W['uniacid']), "chapterid");

        foreach($list_out as $k=>$v){
            $data[$k] = array(
                'id'         => $v['id'],
                'lesson'     => $edulessonarr[$v['lessonid']]['title'],
                'title'      => $v['title'],
                'needtime'   => $v['needtime'],
                'status'     => $statusarr[$v['status']],
                'edulogtol'  => intval($edulogtol[$v['id']]['tol']),
                'createtime' => date('Y-m-d H:i:s',$v['createtime'])."\t",
                'priority'   => $v['priority'],
                'link'       => $v['link'],
                );
        }
        $arrhead = array("ID","所属课程","章节标题","学习时长","状态","学习数","发布时间","排序ID","外链");
        export_excel($data,$arrhead,time());
        exit();
    }

}elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $lessonid = intval($_GPC['lessonid']);
        if (empty($lessonid)) {
            message('请选择章节所属课程！', referer(), 'success');
        }
        $data = array(
            'uniacid'  => $_W['uniacid'],
            'lessonid' => $lessonid,
            'title'    => trim($_GPC['title']),
            'link'     => urlencode(trim($_GPC['link'])),
            'apath'    => trim($_GPC['apath']),
            'vpath'    => trim($_GPC['vpath']),
            'details'  => trim($_GPC['details']),
            'needtime' => intval($_GPC['needtime']),
            'priority' => intval($_GPC['priority']),
            'status'   => intval($_GPC['status']),
        );
        if (!empty($id)) {
            pdo_update($this->table_educhapter, $data, array('id' => $id));
        } else {
            $data['createtime'] = time();
            pdo_insert($this->table_educhapter, $data);
        }
        message('信息更新成功！', $this->createWebUrl('educhapter'), 'success');
    }
    $educhapter = pdo_get($this->table_educhapter, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($educhapter)) {
        $educhapter = array(
            'needtime' => 30,
            'status'   => 2,
            'priority' => 0,
        );
    }else{
		$educhapter['link'] = urldecode($educhapter['link']);
        $edulesson = pdo_get($this->table_edulesson,array('id'=>$educhapter['lessonid'],'uniacid'=>$_W['uniacid']));
    }

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $educhapter = pdo_get($this->table_educhapter,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($educhapter)) {
        message('要删除的章节不存在或是已经被删除！', referer(), 'error');
    }
    $edulog = pdo_getall($this->table_edulog, array('chapterid'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($edulog)) {
        message('要删除的章节下有学习记录，请先删除章节下学习记录再做删除操作！', referer(), 'error');
    }
    pdo_delete($this->table_educhapter, array('id' => $id));
    message('章节信息删除成功！', referer(), 'success');


}
include $this->template('educhapter');
?>