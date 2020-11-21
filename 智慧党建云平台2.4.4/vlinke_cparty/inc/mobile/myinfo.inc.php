<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {


}elseif ($op=="postinfo") {

    $mobile = trim($_GPC['mobile']);
    $haveuser = pdo_fetch("SELECT * FROM".tablename($this->table_user)." WHERE id<>:id AND mobile=:mobile AND uniacid=:uniacid LIMIT 1 ", array(':id'=>$user['id'],':mobile'=>$mobile,':uniacid'=>$_W['uniacid']));
    if (!empty($haveuser)) {
        message("该手机号已存在！", referer(), 'error');
    }
    $data = array(
        'mobile'    => $mobile,
        'sex'       => intval($_GPC['sex']),
        'nation'    => trim($_GPC['nation']),
        'birthday'  => trim($_GPC['birthday']),
        'origin'    => trim($_GPC['origin']),
        'education' => trim($_GPC['education']),
        );
    pdo_update($this->table_user, $data, array('id'=>$user['id']));
    message("个人信息修改成功！", referer(), 'success');

}elseif ($op=="headpic") {


}elseif ($op=="postheadpic") {
    $dataurl = trim($_GPC['dataurl']);
    $path = ATTACHMENT_ROOT."images/".$_W['uniacid']."/".date('Y',time())."/".date('m',time())."/";
    $url = base64_image_content($dataurl,$path);

    $headpic = str_replace(ATTACHMENT_ROOT,"",$url);
    $result = pdo_update($this->table_user, array('headpic'=>$headpic), array('id'=>$user['id']));
    if (!empty($result)) {
        exit(json_encode("success"));
    }else{
        exit(json_encode("error"));
    }
}
include $this->template('myinfo');
?>