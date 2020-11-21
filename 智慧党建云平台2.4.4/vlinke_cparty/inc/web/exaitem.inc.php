<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $con = " WHERE i.uniacid=:uniacid ";
    $par = array(':uniacid'=>$_W['uniacid']);
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
    $list = pdo_fetchall('SELECT i.*,b.title,b.cateid,b.qtype,b.answer FROM '.tablename($this->table_exaitem).' i LEFT JOIN '.tablename($this->table_exabank).' b ON i.bankid=b.id '.$con.' ORDER BY i.id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par, "id");
    $total = pdo_fetchcolumn('SELECT count(i.id) FROM '.tablename($this->table_exadevery).' i LEFT JOIN '.tablename($this->table_exabank).' b ON i.bankid=b.id '.$con, $par);
    $pager = pagination($total, $pindex, $psize);
    $exacateall = pdo_fetchall('SELECT * FROM '.tablename($this->table_exacate).' WHERE uniacid=:uniacid', array(':uniacid'=>$_W['uniacid']), "id");

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall('SELECT i.*,b.title,b.cateid,b.qtype,b.answer,b.itema,b.itemb,b.itemc,b.itemd,b.iteme,b.itemf FROM '.tablename($this->table_exaitem).' i LEFT JOIN '.tablename($this->table_exabank).' b ON i.bankid=b.id '.$con.' ORDER BY i.id DESC ', $par);
        foreach($list_out as $k=>$v){
            if ($v['isright']==0) {
                $isright = "未作答";
            }elseif ($v['isright']==1) {
                $isright = "错误";
            }elseif ($v['isright']==2) {
                $isright = "正确";
            }

            $data[$k]['id']         = $v['id'];
            $data[$k]['title']      = $v['title']."\t";
            $data[$k]['catename']   = $exacateall[$v['cateid']]['name'];
            $data[$k]['qtype']      = $v['qtype']==1?"单选题":"多选题";
            $data[$k]['isright']    = $isright;
            $data[$k]['myanswer']   = $v['myanswer'];
            $data[$k]['answer']     = $v['answer'];
            $data[$k]['itema']      = $v['itema'];
            $data[$k]['itemb']      = $v['itemb'];
            $data[$k]['itemc']      = $v['itemc'];
            $data[$k]['itemd']      = $v['itemd'];
            $data[$k]['iteme']      = $v['iteme'];
            $data[$k]['itemf']      = $v['itemf'];
            $data[$k]['createtime'] = date("Y-m-d H:i",$v['createtime'])."\t";
        }
        $arrhead = array("ID","题目","分类","题型","回答正误","应试选择","正确答案","选择项A","选择项B","选择项C","选择项D","选择项E","选择项F","创建时间");
        export_excel($data,$arrhead,time());
        exit();
    }
}
include $this->template('exaitem');
?>