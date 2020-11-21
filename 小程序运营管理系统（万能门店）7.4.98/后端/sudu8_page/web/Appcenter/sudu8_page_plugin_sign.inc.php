<?php $act = isset(self::$_GPC["act"])?self::$_GPC["act"]:"display";
$children = [];

$plugin = self::$_GPC['plugin'];

/*默认超级权限*/
$sql = "SELECT name,title AS cate_name FROM ".tablename('modules')." WHERE `name` = '{$plugin}'";

$children = pdo_fetchall($sql);

$cname = $children[0]['cate_name'];

foreach ($children as $k => $v){
    $children[$k]['type'] = 1;
    $sql = "SELECT title as cate_name,do as opt FROM ".tablename('modules_bindings')." WHERE `entry` = 'menu' AND `module` = '{$v['name']}'";
    $children[$k]['child'] = pdo_fetchall($sql);
}

if($act == 'base'){
    global $_GPC, $_W;
    $uniacid = $_W['uniacid'];
    $_W['page']['title'] = '签到设置';
    $jfgz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_sign_con')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));

    if(self::$_W['ispost']){
        if(!$_GPC['score']){
            message('随机积分区间不能为空！');
        }
        if(!$_GPC['max_score']){
            message('最大积分不能为空！');
        }
        $data = array(
            "score" => $_GPC['score'],
            "max_score" => $_GPC['max_score']
        );
        if(empty($jfgz)){
            $data['uniacid'] = $uniacid;
            pdo_insert('sudu8_page_sign_con', $data);
        }else{
            pdo_update('sudu8_page_sign_con', $data, array('uniacid' => $uniacid));
        }
        message('签到积分 添加/修改 成功!', '', 'success');
    }else{
        return include self::template("web/Appcenter/".$plugin."/".$act);
    }
}

if($act == 'list'){
    $_W['page']['title'] = '签到列表';
    global $_GPC, $_W;
    $uniacid = $_W['uniacid'];
    $all = pdo_fetchall("SELECT id FROM ".tablename('sudu8_page_sign')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
    $total = count($all);
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize = 15;
    $p = ($pageindex-1) * $pagesize;
    $pager = pagination($total, $pageindex, $pagesize);
    $list =  pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_sign')." WHERE uniacid = :uniacid ORDER BY `id` desc  LIMIT " . $p . "," . $pagesize, array(':uniacid' => $uniacid));
    foreach ($list as &$row) {
        $row['u'] = pdo_fetch("SELECT nickname,avatar from ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid" , array(':uniacid' => $uniacid,":openid" => $row['openid']));
    }
    return include self::template('web/Appcenter/'.$plugin."/".$act);
}