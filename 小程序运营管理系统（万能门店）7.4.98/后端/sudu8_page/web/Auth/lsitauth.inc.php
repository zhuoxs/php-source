<?php

$act = isset(self::$_GPC["act"])?self::$_GPC["act"]:"display";
global $_W,$_GPC;
$uniacid = $_W['uniacid'];

if($act == 'display'){

    $sql = "SELECT * FROM ".tablename('sudu8_page_mcategory')." ORDER BY sort DESC";

    $list = pdo_fetchall($sql);



    $list = \Core\vender\Factory::array_to_tree($list,0);



    return include self::template('web/Auth/index');

}

if($act == 'adduser'){

    load()->model('user');

    $group = user_group();

    return include self::template('web/Auth/adduser');

}

if($act == 'saveadduser'){

    load()->model('user');

    global $_W,$_GPC;

    $id = $_GPC['uid'];

    if(!empty($id)){  //修改密码
        $user = user_single($id);
        if (empty($user)) {

            iajax(-1, '用户不存在或已经被删除！', '');

        }

        $check_safe = safe_check_password($_GPC['newpwd']);
        if (is_error($check_safe)) {
            echo json_encode(['code' => 0,'message' => '密码格式不对']);exit;
        }

        $newpwd = user_hash($_GPC['newpwd'], $user['salt']);



        if ($newpwd == $user['password']) {
            echo json_encode(['code' => 0,'message' => '未做修改']);exit;
        }

        $result = pdo_update('users', array('password' => $newpwd), array('uid' => $id));
        if($result){
            echo json_encode(['code' => 0,'message' => '修改成功']);exit;
        }
    }

    $insert_user = array(

        'gid' => trim($_GPC['gid']),

        'username' => trim($_GPC['username']),

        'remark' => trim($_GPC['remark']),

        'password' => trim($_GPC['password']),

        'repassword' => trim($_GPC['repassword']),

        'type' => ACCOUNT_OPERATE_CLERK

    );
    if (empty($insert_user['username'])) {

        echo json_encode(['code' => 0,'message' => '必须输入用户名，格式为 1-15 位字符，可以包括汉字、字母（不区分大小写）、数字。']);exit;

    }


    $operator = array();

    if (user_check(array('username' => $insert_user['username']))) {

        echo json_encode(['code' => 0,'message' => '非常抱歉，此用户名已经被注册，你需要更换注册名称！']);exit;

    }

    if (empty($insert_user['password']) || istrlen($insert_user['password']) < 8) {

        echo json_encode(['code' => 0,'message' => '必须输入密码，且密码长度不得低于8位。']);exit;

    }

    if ($insert_user['repassword'] != $insert_user['password']) {

        echo json_encode(['code' => 0,'message' => '两次输入密码不一致']);exit;

    }
    if ($insert_user['gid'] == 0) {

        echo json_encode(['code' => 0,'message' => '请选择用户组']);exit;

    }
    unset($insert_user['repassword']);


    $uid = user_register($insert_user);

    if (!$uid) {

        echo json_encode(['code' => 0,'message' => '注册账号失败']);exit;

    }

    $permission = $_GPC['module_permission'];

    foreach ($permission as $k => $v){

        $td = [

            'uniacid' => $_W['uniacid'],'uid' => $uid,

            'type' => $k,

            'permission' => implode('|',$v),

            'url' => ''

        ];



        pdo_insert("users_permission",$td);

    }
    pdo_insert('uni_account_users', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'role' => 'clerk'));
    pdo_insert("sudu8_page_muser",['uid' => $uid,'uniacid' => self::$_W['uniacid']]);
    return $this->returnResult(1,'注册成功');

}

if($act == 'changeuser'){

    load()->model('user');

    global $_W,$_GPC;

    $id = $_GPC['uid'];
    $gid = $_GPC['gid'];

    if(!empty($id)){  
        $user = user_single($id);
        if (empty($user)) {
            echo json_encode(['code' => 0,'message' => '用户不存在或已经被删除！']);exit;
        }
    }
    if($gid == 0){  
        $user = user_single($id);
        if (empty($user)) {
            echo json_encode(['code' => 0,'message' => '请先选择权限组']);exit;
        }
    }

    $res = pdo_update("users", array("gid" => $gid), array("uid" => $id));
    if($res){
        echo json_encode(['code' => 1,'message' => '修改成功！']);exit;
    }else{
        echo json_encode(['code' => 0,'message' => '修改失败，无修改']);exit;
    }
}
if($act == 'getgroup'){
    global $_W,$_GPC;
    $gid = $_GPC['gid'];
    $group = pdo_fetchall("SELECT id,name FROM ".tablename('sudu8_page_usergroup')." ORDER BY id DESC");
    foreach($group as &$v){
        if($v['id'] == $gid){
            $v['checked'] = 1;
        }else{
            $v['checked'] = 0;
        }
    }
    echo json_encode($group);
}
if($act == 'setauth'){

    $catelists = pdo_fetchall("SELECT id,cate_name,pid FROM ".tablename('sudu8_page_mcategory')." WHERE stat = 1 ORDER BY sort DESC");

    $list = \Core\vender\Factory::array_to_trees($catelists,0);

    $gid = self::$_GPC['gid'];

    /*获取用户的默认权限*/

    $auth = pdo_get("sudu8_page_mauth",array('gid' => $gid));

    if(!empty($auth['parent'])) $auth['parent'] = explode(',',$auth['parent']);

    if(!empty($auth['child'])) $auth['child'] = explode(',',$auth['child']);

    if(!empty($auth['mini'])) $auth['mini'] = explode(',',$auth['mini']);

    return include self::template('web/Auth/setauth');

}



if($act == 'savesetauth'){
    $data = $_POST;

    if(count($data['parent']) > 0){

        $data['parent'] = implode(',',$data['parent']);

    }



    if(count($data['child']) > 0){

        $data['child'] = implode(',',$data['child']);

    }



    if(count($data['mini']) > 0){

        $data['mini'] = implode(',',$data['mini']);

    }


    $data['gid'] = isset($data['gid'])?$data['gid']:0;

    if($data['gid'] == 0){

        return $this->returnResult(0,'参数错误');

    }

    $idata = pdo_get("sudu8_page_mauth",array('gid' => $data['gid']));

    if($idata && $idata['gid'] == $data['gid']){

        $gid = $data['gid'];unset($data['gid']);

        pdo_update("sudu8_page_mauth",$data,array('gid' => $gid));

        cache_clean();


        return $this->returnResult(1,'更新成功');

    }else{

        $data['uniacid'] = self::$_W['uniacid'];


        $result = pdo_insert("sudu8_page_mauth",$data);

        cache_clean();

        // $sql = "SELECT * FROM ".tablename('sudu8_page_muser')." WHERE `uid` = ".$data['userid']." AND `uniacid` = ".self::$_W['uniacid'];

        // if(!pdo_fetch($sql)){

        //     pdo_insert("sudu8_page_muser",['uid' => $data['userid'],'uniacid' => self::$_W['uniacid']]);

        // }

        return $this->returnResult($result?1:0,$result?'操作成功':'操作失败');

    }



}



