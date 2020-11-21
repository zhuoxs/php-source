<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}
class Api_Home extends WeModuleWxapp
{
    // 获取首页信息
    public function index(){
        global $_GPC, $_W;
        $info = pdo_get('ox_reclaim_info',['uniacid'=>$_W['uniacid']]);
        $banner =pdo_fetchall("select * from ".tablename('ox_reclaim_banner')." where `uniacid`={$_W['uniacid']}   order by sort desc limit 4");
        foreach ($banner as $k => $v){
            $banner[$k]['img'] = tomedia($v['img']);
        }
        $type =pdo_fetchall("select * from ".tablename('ox_reclaim_type')." where `uniacid`={$_W['uniacid']}   order by sort desc limit 4");
        foreach ($type as $k => $v){
            $type[$k]['img'] = tomedia($v['img']);
        }
        $rule =pdo_fetchall("select * from ".tablename('ox_reclaim_rule')." where `uniacid`={$_W['uniacid']}   order by sort desc limit 3");
        foreach ($rule as $k => $v){
            $rule[$k]['img'] = tomedia($v['img']);
        }
        $tiaozhuan=pdo_fetchall("select * from ".tablename('ox_reclaim_pages')." where `uniacid`={$_W['uniacid']}   order by sort desc ");
        foreach ($tiaozhuan as $k => $v){
            $tiaozhuan[$k]['img'] = tomedia($v['img']);
        }
        $result = [
           'info' => $info,
            'banner' => $banner,
            'type' => $type,
            'rule' => $rule,
            'tiaozhuan'=>$tiaozhuan,
        ];
        return $this->result(0, '', $result);
    }
 	//获取用户手机号
    public function userphone()
    {
        global $_GPC, $_W;
        $account_api = WeAccount::create();
        $encrypt_data = $_GPC['encryptedData'];
        $iv = $_GPC['iv'];

        if (empty($_SESSION['session_key']) || empty($encrypt_data) || empty($iv)) {
            $account_api->result(1, '请先登录');
        }
        $phone = $account_api->pkcs7Encode($encrypt_data, $iv);
        if($phone && $phone['phoneNumber']){
            return $this->result(0, '',$phone['phoneNumber']);
        }
        return $this->result(500, '手机号码获取失败！请手动输入',$phone);
    }


}