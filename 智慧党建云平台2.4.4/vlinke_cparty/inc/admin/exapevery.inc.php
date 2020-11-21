<?php
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
    $list = pdo_fetchall('SELECT p.*,b.title,b.cateid,b.qtype,b.answer,b.itema,b.itemb,b.itemc,b.itemd,b.iteme,b.itemf FROM '.tablename($this->table_exapevery).' p LEFT JOIN '.tablename($this->table_exabank).' b ON p.bankid=b.id '.$con.' ORDER BY p.id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par, "id");
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

}
include $this->template('admin/exapevery');
?>