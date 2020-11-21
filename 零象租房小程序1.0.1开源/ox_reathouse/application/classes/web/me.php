<?php
/**

 * Created by PhpStorm.

 * User: Administrator

 * Date: 2018/5/7

 * Time: 15:07

 */

if (!(defined('IN_IA')))
{
    exit('Access Denied');
}
class Web_Me extends Web_Base
{
    /**
     * 个人中心
     */
    public function detail()
    {
        /**
         * /app/index.php?i=3&t=0&v=v1.0&from=wxapp&c=entry&a=wxapp&do=Api&m=musen_market&r=me.detail
         */

        global $_W;

        $detail =pdo_get("ox_reathouse_info",['uniacid' => $_W['uniacid']]);
        $logo = tomedia($detail['logo']);
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        $result = [
            'roles' => ['admin'],
            'token' => 'admin',
            'introduction' => '我是超级管理员',
            'avatar' => $logo ?: $http_type .$_SERVER['SERVER_NAME'].'/addons/'.MODEL_NAME.'/icon.jpg',
            'name' => $detail['title'] ?: '零象租房',
            'isfounder' => intval($_W["isfounder"]),
            'version' => IMS_VERSION,
            'footerleft' => $_W['setting']['copyright']['footerleft'] ?: false,
            'icp' => $_W['setting']['copyright']['icp'] ?: false
        ];
        exit(json_encode($result));
    }

}