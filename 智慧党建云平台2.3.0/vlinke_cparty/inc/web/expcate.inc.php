<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_expcate).' WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_expcate).' WHERE uniacid=:uniacid', array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);

}elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $status = intval($_GPC['status']);
        $catemoney = floatval($_GPC['catemoney']);
        if ($status==2 && $catemoney<=0) {
            message('固定支付金额要大于0.00元！', referer(), 'error');
        }elseif ($status!=2) {
            $catemoney = 0.00;
        }
        $data = array(
            'uniacid'   => $_W['uniacid'],
            'name'      => trim($_GPC['name']),
            'status'    => $status,
            'catemoney' => $catemoney,
            'endtime'   => strtotime($_GPC['endtime']),
            'details'   => trim($_GPC['details']),
            'priority'  => intval($_GPC['priority']),
        );
        if (!empty($id)) {
            pdo_update($this->table_expcate, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_expcate, $data);
        }
        message('信息更新成功！', $this->createWebUrl('expcate'), 'success');
    }
    $expcate = pdo_get($this->table_expcate, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($expcate)) {
        $expcate = array(
            'status'    => 1,
            'catemoney' => "0.00",
            'endtime'   => time() + 86400*7,
            'priority'  => 0,
        );
    }

} elseif ($op == 'import') {
    $id = intval($_GPC['id']);
    $expcate = pdo_get($this->table_expcate, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($expcate)) {
        message('党费类目不存在！', referer(), 'error');
    }
    if ($expcate['status']!=3) {
        message('党费类目非指定党员类型。无须导入缴费名单！', referer(), 'error');
    }
    if (checksubmit('submit')) {
        load()->func('file');
        $type = intval($_GPC['type']);
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
        $file_name = ATTACHMENT_ROOT."/images/vlinkecparty/".$_W['uniacid']."/expense".time().".xls";
        if (file_move($tmp, $file_name)) {
            $xls = new Spreadsheet_Excel_Reader();
            $xls->setOutputEncoding('utf-8');
            $xls->read($file_name);
            $i=2;$j=0;$k=0;$l=0;
            $len = $xls->sheets[0]['numRows'];
            while($i<=$len){
                $idnumber = trim($xls->sheets[0]['cells'][$i][3]);
                $paymoney = round(floatval($xls->sheets[0]['cells'][$i][4]),2);
                $remark   = trim($xls->sheets[0]['cells'][$i][5]);
                $i++;
                if ($paymoney<=0) {
                    $l++;
                    continue;
                }
                $user = pdo_get($this->table_user, array('recycle'=>0,'idnumber'=>$idnumber,'uniacid'=>$_W['uniacid']));
                if (empty($user)) {
                    $l++;
                    continue;
                }
                $expense = pdo_get($this->table_expense, array('userid'=>$user['id'],'cateid'=>$expcate['id'],'uniacid'=>$_W['uniacid']));
                if (empty($expense)) {
                    $data = array(
                        'uniacid'    => $_W['uniacid'],
                        'cateid'     => $expcate['id'],
                        'userid'     => $user['id'],
                        'paynumber'  => date("YmdHis").rand_str(6,1),
                        'paymoney'   => $paymoney,
                        'paytime'    => 0,
                        'remark'     => $remark,
                        'status'     => 1,
                        'createtime' => time()
                        );
                    pdo_insert($this->table_expense, $data);
                    $j++;
                }elseif (!empty($expense) && $expense['status']==1) {
                    pdo_update($this->table_expense, array('paymoney'=>$paymoney,'remark'=>$remark), array('id'=>$expense['id']));
                    $k++;
                }else{
                    $l++;
                }
            }
            message('新增数据'.$j.'条，更新数据'.$k.'条，无效数据'.$l.'条！', referer(), 'success');
        }
    }

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $expcate = pdo_get($this->table_expcate,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($expcate)) {
        message('要删除的费用类目不存在或是已经被删除！', referer(), 'error');
    }
    $expense = pdo_getall($this->table_expense, array('cateid'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($expense)) {
        message('要删除的费用类目下有支付记录，请先处理类目下记录再做删除操作！', referer(), 'error');
    }
    pdo_delete($this->table_expcate, array('id' => $id));
    message('费用类目信息删除成功！', referer(), 'success');


}
include $this->template('expcate');
?>