<?php
global $_W,$_GPC;
$op = $operation = $_GPC['op']?$_GPC['op']:'display';
load()->func('tpl');
if ($op=='display') {
	
	$con = ' WHERE u.uniacid=:uniacid AND u.recycle=0 ';
    $par[':uniacid'] = $_W['uniacid'];
	$keyword = $_GPC['keyword'];
    if (!empty($keyword)) {
        $con .= " AND ( u.realname LIKE :keyword OR u.mobile LIKE :keyword ) ";
        $par[':keyword'] = "%".$keyword."%";
    }
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND u.status=:status ";
        $par[':status'] = $status;
    }
    $ulevel = intval($_GPC['ulevel']);
    if ($ulevel!=0) {
        $con .= " AND u.ulevel=:ulevel ";
        $par[':ulevel'] = $ulevel;
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
	$list = pdo_fetchall("SELECT u.*,b.name FROM ".tablename($this->table_user)." u LEFT JOIN ".tablename($this->table_branch)." b ON u.branchid=b.id ".$con." ORDER BY u.priority DESC, u.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
	$total = pdo_fetchcolumn('SELECT count(u.id) FROM '.tablename($this->table_user)." u ".$con ,$par);
	$pager = pagination($total, $pindex, $psize);

	if ($_GPC['output']==1) {
        $list_out = pdo_fetchall("SELECT u.*,b.name FROM ".tablename($this->table_user)." u LEFT JOIN ".tablename($this->table_branch)." b ON u.branchid=b.id ".$con." ORDER BY u.priority DESC, u.id DESC",$par);
        $ulevelarr = array(1=>"正式党员",2=>"预备党员",3=>"观察对象",4=>"入党积极分子");
        $statusarr = array(1=>"审核",2=>"正常",3=>"禁用");
        foreach($list_out as $k=>$v){
            $data[$k] = array(
                'id'            => $v['id'],
                'branch'        => $v['name'],
                'openid'        => $v['openid'],
                'nickname'      => $v['nickname'],
                'wxappopenid'   => $v['wxappopenid'],
                'wxappnickname' => $v['wxappnickname'],
                'realname'      => $v['realname'],
                'idnumber'      => $v['idnumber']."\t",
                'mobile'        => $v['mobile']."\t",
                'status'        => $statusarr[$v['status']],
                'integral'      => $v['integral'],
                'ulevel'        => $ulevelarr[$v['ulevel']],
                'partyday'      => $v['partyday']."\t",
                'birthday'      => $v['birthday']."\t",
                'sex'           => $v['sex']==1?"男":"女",
                'origin'        => $v['origin'],
                'nation'        => $v['nation'],
                'education'     => $v['education'],
                'createtime'    => date('Y-m-d H:i:s',$v['createtime'])."\t",
                'priority'      => $v['priority'],
                'loginname'     => $v['loginname'],
                );
        }
        $arrhead = array("ID","组织关系","OpenID","昵称","OpenID(小程序)","昵称(小程序)","姓名","身份证号","手机号","状态","积分","政治身份","入党日期","出生日期","性别","籍贯","民族","文化程度","创建时间","排序ID","登录用户名");
        export_excel($data,$arrhead,time());
        exit();
	}

} elseif ($op=='post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $branchid = intval($_GPC['branchid']);
        $realname = trim($_GPC['realname']);
        $idnumber = strtoupper(trim($_GPC['idnumber']));
        $mobile = trim($_GPC['mobile']);
        if ($branchid==0) {
            message('请先选择所属组织！', referer(), 'error');
        }
        if (empty($realname) || empty($mobile) || empty($idnumber)) {
            message('姓名、身份证号和手机号均不能为空！', referer(), 'error');
        }
        $haveuser = pdo_fetch("SELECT * FROM ".tablename($this->table_user)." WHERE (idnumber=:idnumber OR mobile=:mobile) AND uniacid=:uniacid AND id<>:id AND recycle=0 ", array(':idnumber'=>$idnumber,':mobile'=>$mobile,':uniacid'=>$_W['uniacid'],':id'=>$id));
        if (!empty($haveuser)) {
            message('身份证号或手机号已存在，请换个用户名或手机号！', referer(), 'error');
        }
        $ulevel = intval($_GPC['ulevel']);
        if ($ulevel==1 || $ulevel==2) {
            $partyday = trim($_GPC['partyday']);
        }else{
            $partyday = "";
        }
        $data = array(
            'uniacid'         => $_W['uniacid'],
            'branchid'        => $branchid,
            'openid'          => trim($_GPC['openid']),
            'nickname'        => trim($_GPC['nickname']),
            'headimgurl'      => trim($_GPC['headimgurl']),
            'wxappopenid'     => trim($_GPC['wxappopenid']),
            'wxappnickname'   => trim($_GPC['wxappnickname']),
            'wxappheadimgurl' => trim($_GPC['wxappheadimgurl']),
            'realname'        => $realname,
            'idnumber'        => $idnumber,
            'mobile'          => $mobile,
            'headpic'         => trim($_GPC['headpic']),
            'status'          => intval($_GPC['status']),
            'ulevel'          => $ulevel,
            'partyday'        => $partyday,
            'birthday'        => trim($_GPC['birthday']),
            'sex'             => intval($_GPC['sex']),
            'origin'          => trim($_GPC['origin']),
            'nation'          => trim($_GPC['nation']),
            'education'       => trim($_GPC['education']),
            'priority'        => intval($_GPC['priority']),
            'recycle'         => 0,
            );
        if ($id==0) {
            $data['integral'] = 0;
            $data['createtime'] = time();
            $data['loginname'] = "";
            $data['loginpass'] = "";
            pdo_insert($this->table_user, $data);
        }else{
            pdo_update($this->table_user, $data, array('id'=>$id));
        }
        message('数据更新成功', $this->createWebUrl('user'), 'success');
    }
    $user = pdo_get($this->table_user,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($user)) {
        $user = array(
            'status'   => 2,
            'integral' => 0,
            'ulevel'   => 1,
            'partyday' => date('Y-m-d'),
            'birthday' => date('Y-m-d'),
            'sex'      => 1,
            'priority' => 0,
            );
    }else{
        $branch = pdo_get($this->table_branch,array('id'=>$user['branchid'],'uniacid'=>$_W['uniacid']));
    }


} elseif ($op=='import') {
    if ($_GPC['import']==1) {
        $branchid = intval($_GPC['branchid']);
        if (empty ($branchid)) {
            message('请选择要导入的党员信息所在的组织！', referer(), 'error');   
        }
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
        $file_name = ATTACHMENT_ROOT."/images/vlinkecparty/".$_W['uniacid']."/user".time().".xls";
        if (file_move($tmp, $file_name)) {
            $xls = new Spreadsheet_Excel_Reader();
            $xls->setOutputEncoding('utf-8');
            $xls->read($file_name);
            $i=2;$j=0;$k=0;
            $len = $xls->sheets[0]['numRows'];
            while($i<=$len){
                $realname  = trim($xls->sheets[0]['cells'][$i][2]);
                $idnumber  = trim($xls->sheets[0]['cells'][$i][3]);
                $mobile    = trim($xls->sheets[0]['cells'][$i][4]);
                $ulevel    = intval($xls->sheets[0]['cells'][$i][5]);
                $partyday  = trim($xls->sheets[0]['cells'][$i][6]);
                $birthday  = trim($xls->sheets[0]['cells'][$i][7]);
                $sex       = intval($xls->sheets[0]['cells'][$i][8]);
                $origin    = trim($xls->sheets[0]['cells'][$i][9]);
                $nation    = trim($xls->sheets[0]['cells'][$i][10]);
                $education = trim($xls->sheets[0]['cells'][$i][11]);
                $user = pdo_fetch("SELECT * FROM ".tablename($this->table_user)." WHERE recycle=0 AND ( idnumber=:idnumber OR mobile=:mobile ) AND uniacid=:uniacid ",array(':idnumber'=>$idnumber,':mobile'=>$mobile,':uniacid'=>$_W['uniacid']));
                if (empty($user)) {
                    $data = array(
                        'uniacid'         => $_W['uniacid'],
                        'branchid'        => $branchid,
                        'openid'          => "",
                        'nickname'        => "",
                        'headimgurl'      => "",
                        'wxappopenid'     => "",
                        'wxappnickname'   => "",
                        'wxappheadimgurl' => "",
                        'realname'        => $realname,
                        'idnumber'        => $idnumber,
                        'mobile'          => $mobile,
                        'headpic'         => "",
                        'status'          => 2,
                        'integral'        => 0,
                        'ulevel'          => $ulevel,
                        'partyday'        => $partyday,
                        'birthday'        => $birthday,
                        'sex'             => $sex,
                        'origin'          => $origin,
                        'nation'          => $nation,
                        'education'       => $education,
                        'createtime'      => time(),
                        'priority'        => 0,
                        'recycle'         => 0,
                        'loginname'       => "",
                        'loginpass'       => "",
                        );
                    pdo_insert($this->table_user, $data);
                    $j++;
                }else{
                    $k++;
                }
                $i++;
            }
            message('成功导入数据'.$j.'条！剔除重复数据'.$k.'条！', referer(), 'success');
        }
    }

} elseif ($op=='setintegral') {
    $ret = array('state'=>'error','msg'=>'error');
    $userid = intval($_GPC['userid']);
    $integral = intval($_GPC['integral']);
    $remark = trim($_GPC['remark']);
    $user = pdo_get($this->table_user, array("uniacid"=>$_W['uniacid'],"id"=>$userid,"recycle"=>0));
    if (empty($user)) {
        $ret['msg'] = "党员信息不存在！";
        exit(json_encode($ret));
    }
    if ($integral==0) {
        $ret['msg'] = "积分变动值不能为零！";
        exit(json_encode($ret));
    }
    $userintegral = $integral + $user['integral'];
    if ($userintegral<0) {
        $ret['msg'] = "党员修改后的积分总值不能为负！";
        exit(json_encode($ret));
    }
    $integraldata = array(
        'uniacid'    => $_W['uniacid'],
        'userid'     => $userid,
        'channel'    => "system",
        'foreignid'  => 0,
        'integral'   => $integral,
        'remark'     => empty($remark)?"系统设置":$remark,
        'isrank'     => 1,
        'iyear'      => date("Y"),
        'iseason'    => date("Y").ceil((date('n'))/3),
        'imonth'     => date("Ym"),
        'createtime' => time()
        );
    pdo_insert($this->table_integral, $integraldata);
    pdo_update($this->table_user, array('integral'=>$userintegral), array('id'=>$userid));

    $ret['state'] = 'success';
    $ret['msg'] = 'success';
    exit(json_encode($ret));

} elseif ($op=='recycle') {
    $con = ' WHERE u.uniacid=:uniacid AND u.recycle=1 ';
    $par[':uniacid'] = $_W['uniacid'];
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $list = pdo_fetchall("SELECT u.*,b.name FROM ".tablename($this->table_user)." u LEFT JOIN ".tablename($this->table_branch)." b ON u.branchid=b.id ".$con." ORDER BY u.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
    $total = pdo_fetchcolumn('SELECT count(u.id) FROM '.tablename($this->table_user)." u ".$con ,$par);
    $pager = pagination($total, $pindex, $psize);

} elseif ($op=='setrecycle1') {
	$id = intval($_GPC['id']);
    $user = pdo_get($this->table_user,array('id'=>$id,'uniacid'=>$_W['uniacid'],"recycle"=>0));
    if (empty($user)) {
        message('要回收的党员信息不存在！', referer(), 'error');
    }
    pdo_update($this->table_user, array('openid'=>"",'recycle'=>1), array('id'=>$id));
    message('党员信息成功拉入回收站！', referer(), 'success');

} elseif ($op=='setrecycle0') {
    $id = intval($_GPC['id']);
    $user = pdo_get($this->table_user,array('id'=>$id,'uniacid'=>$_W['uniacid'],"recycle"=>1));
    if (empty($user)) {
        message('要恢复的党员信息不存在！', referer(), 'error');
    }
    $haveuser = pdo_fetch("SELECT * FROM ".tablename($this->table_user)." WHERE (idnumber=:idnumber OR mobile=:mobile) AND uniacid=:uniacid AND recycle=0 ", array(':idnumber'=>$user['idnumber'],':mobile'=>$user['mobile'],':uniacid'=>$_W['uniacid']));
    if (!empty($haveuser)) {
        message('你要恢复的党员信息对应的身份证号“'.$user['idnumber'].'”或手机号“'.$user['mobile'].'”已存在，请检查目前已有党员信息！', '', 'error');
    }
    pdo_update($this->table_user, array('recycle'=>0), array('id'=>$id));
    message('党员信息恢复成功！', referer(), 'success');

} elseif ($op=='delete') {
    $id = intval($_GPC['id']);
    $user = pdo_get($this->table_user,array('id'=>$id,'uniacid'=>$_W['uniacid'],"recycle"=>1));
    if (empty($user)) {
        message('要彻底删除的记录信息在回收站中不存在！', referer(), 'error');
    }
    pdo_delete($this->table_integral, array('userid' => $id));
    pdo_delete($this->table_user, array('id' => $id));
    message('用户信息彻底删除成功！', referer(), 'success');
}
include $this->template('user');

?>











