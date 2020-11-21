<?php
if ($op == 'display') { 
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_expcate).' WHERE uniacid=:uniacid ORDER BY id DESC LIMIT '.($pindex-1) * $psize.','.$psize, array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_expcate).' WHERE uniacid=:uniacid', array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);


} elseif ($op == 'import') {
    $id = intval($_GPC['id']);
    $expcate = pdo_get($this->table_expcate, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($expcate)) {
        message_tip('党费类目不存在！', referer(), 'error');
    }
    if ($expcate['status']!=3) {
        message_tip('党费类目非指定党员类型。无须导入缴费名单！', referer(), 'error');
    }
    if (checksubmit('submit')) {
        load()->func('file');
        $type = intval($_GPC['type']);
        $tmp = $_FILES['upload_file']['tmp_name'];
        if (empty ($tmp)) {
            message_tip('请选择要导入的EXCEL(.xls)文件！', referer(), 'error');   
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
            message_tip('目前只支持EXCEL(.xls)格式文件！！！', referer(), 'error');   
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
                $user = pdo_fetch("SELECT * FROM ".tablename($this->table_user)." WHERE idnumber=:idnumber AND uniacid=:uniacid AND branchid IN (".$lbrancharrid.") AND recycle=0", array(':idnumber'=>$idnumber,':uniacid'=>$_W['uniacid']));
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
            message_tip('新增数据'.$j.'条，更新数据'.$k.'条，无效数据'.$l.'条！', referer(), 'success');
        }
    }


}
include $this->template('admin/expcate');
?>