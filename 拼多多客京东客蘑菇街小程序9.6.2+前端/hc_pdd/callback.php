<?php
require '../../framework/bootstrap.inc.php';
global $_W,$_GPC;

/*echo $_GPC['code'];
echo "</br>";
echo $_GPC['app_key'];
echo "</br>";
echo $_GPC['app_secret'];*/

print_r('<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1" style="display: block">');
print_r('<span>请输入你的app_key</span>');
print_r('<input type="text" name="app_key" lay-verify="text" value="" class="layui-input">');
print_r('<span>请输入你的app_secret</span>');
print_r('<input type="text" name="app_secret" lay-verify="text" value="" class="layui-input">');
print_r('<input name="submit" type="submit" value="提交">');
print_r('<input type="hidden" name="code" value='.$_GPC['code'].'>');
print_r('</form>');

$data = array (
'code' => $_GPC['code'],
'grant_type' => 'authorization_code',
'app_key' => $_GPC['app_key'],
'app_secret' => $_GPC['app_secret'],
'redirect_uri' => 'http://we10.66bbn.com/addons/hc_pdd/callback.php'
);
$url = 'https://oauth.mogujie.com/token';
load()->func('communication');
$response = ihttp_post($url,$data);
$result  = json_decode($response['content'],true);

if(!empty($result['access_token'])){
    echo "</br>";
    echo "你的access_token是";
    echo $result['access_token'];
    echo ",请填写到模块后台并保存！";
}