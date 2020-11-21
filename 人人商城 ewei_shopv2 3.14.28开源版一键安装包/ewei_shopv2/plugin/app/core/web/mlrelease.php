<?php
//haha
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class MlRelease_EweiShopV2Page extends PluginWebPage
{
    private $key = 'asdfzhongmuting';
    private function ujson_encode($array)
    {
        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            $str = json_encode($array);
            $str = preg_replace_callback("#\\\u([0-9a-f]{4})#i", function ($matchs) {
                return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
            }, $str);
            return $str;
        } else {
            return json_encode($array, JSON_UNESCAPED_UNICODE);
        }
    }
    public function main()
    {
        global $_W;
        $appset = m('common')->getSysset('app');

        $tabBar  = '';
        $app_set = m('common')->getSysset('app');
        if (!empty($app_set)) {
            if (!empty($app_set['tabbar'])) {
                $app_set['tabbar'] = iunserializer($app_set['tabbar']);

                if (!empty($app_set['tabbar'])) {
                    $tabBar = $app_set['tabbar'];
                }
            }
        }
        if (is_array($tabBar)) {
            if (is_array($tabBar['list'])) {
                foreach ($tabBar['list'] as $index => &$item) {
                    $item['pagePath'] = ltrim($item['pagePath'], '/');
                }
                unset($index);
                unset($item);
            }
            //print_r($tabBar);exit;
            $tabBar = $this->ujson_encode($tabBar);
        }

        $auth            = array();
        $auth['site_id'] = base64_decode(SITE_ID);
        $auth['uniacid'] = $_W['uniacid'];
        $auth['appid']   = $appset['appid'];
        $auth['modules'] = 'ewei_shopv2';
        $auth['tabBar']  = $tabBar;
        $query           = base64_encode(json_encode($auth));

        $auth_url = EWEI_SHOPV2_AUTH_WXAPP . '/smallapp.html?do=' . $query;

        include $this->template();
    }

}
