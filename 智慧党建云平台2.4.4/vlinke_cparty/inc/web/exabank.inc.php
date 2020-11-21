<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $con = " WHERE uniacid=:uniacid ";
    $par = array(':uniacid'=>$_W['uniacid']);
    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND title LIKE :keywords ";
        $par[':keywords'] = '%'.$keywords.'%';
    }
    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND cateid=:cateid ";
        $par[':cateid'] = $cateid;
    }
    $qtype = intval($_GPC['qtype']);
    if ($qtype!=0) {
        $con .= " AND qtype=:qtype ";
        $par[':qtype'] = $qtype;
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_exabank).$con.' ORDER BY id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par, "id");
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_exabank).$con, $par);
    $pager = pagination($total, $pindex, $psize);
    $exacateall = pdo_fetchall('SELECT * FROM '.tablename($this->table_exacate).' WHERE uniacid=:uniacid', array(':uniacid'=>$_W['uniacid']), "id");

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall('SELECT * FROM '.tablename($this->table_exabank).$con.' ORDER BY id DESC ', $par);
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
            $data[$k]['rightrate'] = $atotal==0?"0%":round(($v['aright']*100)/$atotal)."%";
        }
        $arrhead = array("ID","题目","分类","题型","答案","选择项A","选择项B","选择项C","选择项D","选择项E","选择项F","答对次数","答错次数","正确率");
        export_excel($data,$arrhead,time());
        exit();
    }
    

}elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {

        $qtype = intval($_GPC['qtype']);
        if ($qtype==1) {
            $answer = trim($_GPC['answerradio']);
        }else{
            $answer = implode("",$_GPC['answercheckbox']);
        }
        if (empty($answer)) {
            message('请选择试题正确答案。', referer(), 'error');
        }
        $data = array(
            'uniacid' => $_W['uniacid'],
            'cateid'  => intval($_GPC['cateid']),
            'title'   => trim($_GPC['title']),
            'tilpic'  => trim($_GPC['tilpic']),
            'qtype'   => intval($_GPC['qtype']),
            'itema'   => trim($_GPC['itema']),
            'itemb'   => trim($_GPC['itemb']),
            'itemc'   => trim($_GPC['itemc']),
            'itemd'   => trim($_GPC['itemd']),
            'iteme'   => trim($_GPC['iteme']),
            'itemf'   => trim($_GPC['itemf']),
            'answer'  => $answer,
            'aright'  => intval($_GPC['aright']),
            'awrong'  => intval($_GPC['awrong']),
        );
        if (!empty($id)) {
            pdo_update($this->table_exabank, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_exabank, $data);
        }
        message('信息更新成功！', $this->createWebUrl('exabank'), 'success');
    }
    $exabank = pdo_get($this->table_exabank, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($exabank)) {
        $exabank = array(
            'qtype'  => 1,
            'aright' => 0,
            'awrong' => 0,
        );
    }
    $exacateall = pdo_fetchall('SELECT * FROM '.tablename($this->table_exacate).' WHERE uniacid=:uniacid', array(':uniacid'=>$_W['uniacid']), "id");

} elseif ($op=='import') {
    if ($_GPC['import']==1) {
        $cateid = intval($_GPC['cateid']);
        if (empty ($cateid)) {
            message('请选择要导入的试题所在的分类！', referer(), 'error');   
        }
        load()->func('file');
        $tmp = $_FILES['upload_file']['tmp_name'];
        if (empty ($tmp)) {
            message('请选择要导入的EXCEL(.xls)文件！', referer(), 'error');   
        }
        switch ($_FILES['upload_file']['type']){
            case "application/kset" :
                break;
            case "application/excel" :
                break;
            case "application/vnd.ms-excel" :
                break;
            case "application/msexcel" :
                break;
            case "application/octet-stream" :
                break;
            default:
                $flag = 1;
        }
        if($flag ==1){
            message('目前只支持EXCEL(.xls)格式文件！！！', referer(), 'error');   
        }
        $file_name = ATTACHMENT_ROOT."/images/vlinkecparty/".$_W['uniacid']."/exabank".time().".xls";
        if (file_move($tmp, $file_name)) {
            $xls = new Spreadsheet_Excel_Reader();
            $xls->setOutputEncoding('utf-8');
            $xls->read($file_name);
            $i=2; $j=0;
            $len = $xls->sheets[0]['numRows'];
            while($i<=$len){
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'cateid'  => $cateid,
                    'title'   => trim($xls->sheets[0]['cells'][$i][2]),
                    'tilpic'  => "",
                    'qtype'   => intval($xls->sheets[0]['cells'][$i][3]),
                    'answer'  => trim($xls->sheets[0]['cells'][$i][4]),
                    'itema'   => trim($xls->sheets[0]['cells'][$i][5]),
                    'itemb'   => trim($xls->sheets[0]['cells'][$i][6]),
                    'itemc'   => trim($xls->sheets[0]['cells'][$i][7]),
                    'itemd'   => trim($xls->sheets[0]['cells'][$i][8]),
                    'iteme'   => trim($xls->sheets[0]['cells'][$i][9]),
                    'itemf'   => trim($xls->sheets[0]['cells'][$i][10]),
                    'aright'  => 0,
                    'awrong'  => 0,
                    );
                pdo_insert($this->table_exabank, $data);
                $i++;
                $j++;
            }
            message('成功导入数据'.$j.'条！', referer(), 'success');
        }
    }

    $exacateall = pdo_fetchall('SELECT * FROM '.tablename($this->table_exacate).' WHERE uniacid=:uniacid', array(':uniacid'=>$_W['uniacid']), "id");

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $exabank = pdo_get($this->table_exabank,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($exabank)) {
        message('要删除的信息不存在或是已经被删除！', referer(), 'error');
    }
    pdo_delete($this->table_exabank, array('id' => $id));
    message('信息删除成功！', referer(), 'success');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_exabank)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");
}
include $this->template('exabank');
?>