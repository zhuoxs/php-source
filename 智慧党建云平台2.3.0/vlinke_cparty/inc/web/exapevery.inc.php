<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $paperid = intval($_GPC['paperid']);
    if (empty($paperid)) {
        message('考试项目信息不存在或是已经被删除！', referer(), 'error');
    }
    $con = " WHERE p.uniacid=:uniacid AND paperid=:paperid ";
    $par = array(':uniacid'=>$_W['uniacid'],':paperid'=>$paperid);
    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND b.title LIKE :keywords ";
        $par[':keywords'] = '%'.$keywords.'%';
    }
    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND b.cateid=:cateid ";
        $par['cateid'] = $cateid;
    }
    $qtype = intval($_GPC['qtype']);
    if ($qtype!=0) {
        $con .= " AND b.qtype=:qtype ";
        $par['qtype'] = $qtype;
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT p.*,b.title,b.cateid,b.qtype,b.answer FROM '.tablename($this->table_exapevery).' p LEFT JOIN '.tablename($this->table_exabank).' b ON p.bankid=b.id '.$con.' ORDER BY p.id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par, "id");
    $total = pdo_fetchcolumn('SELECT count(p.id) FROM '.tablename($this->table_exapevery).' p LEFT JOIN '.tablename($this->table_exabank).' b ON p.bankid=b.id '.$con, $par);
    $pager = pagination($total, $pindex, $psize);
    $exacateall = pdo_fetchall('SELECT * FROM '.tablename($this->table_exacate).' WHERE uniacid=:uniacid', array(':uniacid'=>$_W['uniacid']), "id");

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall('SELECT p.*,b.title,b.cateid,b.qtype,b.answer,b.itema,b.itemb,b.itemc,b.itemd,b.iteme,b.itemf FROM '.tablename($this->table_exapevery).' p LEFT JOIN '.tablename($this->table_exabank).' b ON p.bankid=b.id '.$con.' ORDER BY p.id DESC ', $par);
        foreach($list_out as $k=>$v){
            $data[$k]['id']        = $v['id'];
            $data[$k]['title']     = $v['title'];
            $data[$k]['catename']  = $exacateall[$v['cateid']]['name'];
            $data[$k]['qtype']     = $v['qtype']==1?"单选题":"多选题";
            $data[$k]['answer']    = $v['answer'];
            $data[$k]['itema']     = $v['itema'];
            $data[$k]['itemb']     = $v['itemb'];
            $data[$k]['itemc']     = $v['itemc'];
            $data[$k]['itemd']     = $v['itemd'];
            $data[$k]['iteme']     = $v['iteme'];
            $data[$k]['itemf']     = $v['itemf'];
            $data[$k]['aright']    = $v['aright'];
            $data[$k]['awrong']    = $v['awrong'];
            $atotal = $v['awrong']+$v['aright'];
            $data[$k]['rightrate']  = $atotal==0?"0%":round(($v['aright']*100)/$atotal)."%";
        }
        $arrhead = array("ID","题目","分类","题型","答案","选择项A","选择项B","选择项C","选择项D","选择项E","选择项F","答对次数","答错次数","正确率");
        export_excel($data,$arrhead,time());
        exit();
    }

}elseif ($op == 'add') {
    $paperid = intval($_GPC['paperid']);
    if (empty($paperid)) {
        message('考试项目信息不存在或是已经被删除！', referer(), 'error');
    }
    $con = " WHERE b.uniacid=:uniacid AND p.paperid is null ";
    $par = array(':uniacid'=>$_W['uniacid']);
    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND b.title LIKE :keywords ";
        $par[':keywords'] = '%'.$keywords.'%';
    }
    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND b.cateid=:cateid ";
        $par[':cateid'] = $cateid;
    }
    $qtype = intval($_GPC['qtype']);
    if ($qtype!=0) {
        $con .= " AND b.qtype=:qtype ";
        $par[':qtype'] = $qtype;
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT b.*,p.bankid,p.paperid FROM '.tablename($this->table_exabank).' b LEFT JOIN '.tablename($this->table_exapevery).' p ON b.id=p.bankid '.$con.' ORDER BY b.id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par, "id");
    $total = pdo_fetchcolumn('SELECT count(b.id) FROM '.tablename($this->table_exabank).' b LEFT JOIN '.tablename($this->table_exapevery).' p ON b.id=p.bankid '.$con.' ORDER BY b.id DESC ', $par);
    $pager = pagination($total, $pindex, $psize);

    $exacateall = pdo_fetchall('SELECT * FROM '.tablename($this->table_exacate).' WHERE uniacid=:uniacid', array(':uniacid'=>$_W['uniacid']), "id");


} elseif ($op=='addpost') {
    $paperid = intval($_GPC['paperid']);
    $idarr = $_GPC['idArr'];
    if (!empty($idarr)) {
        $data = array(
            'uniacid'    => $_W['uniacid'],
            'paperid'    => $paperid,
            'aright'     => 0,
            'awrong'     => 0
            );
        foreach ($idarr as $k => $v) {
            $data['bankid'] = $v;
            pdo_insert($this->table_exapevery, $data);
        }
    }
    exit(json_encode($idarr));

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $exapevery = pdo_get($this->table_exapevery,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($exapevery)) {
        message('要删除的题库试题不存在或是已经被删除！', referer(), 'error');
    }
    pdo_delete($this->table_exapevery, array('id' => $id));
    message('题库类目信息删除成功！', referer(), 'success');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_exapevery)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");
}
include $this->template('exapevery');
?>