<?php
// +----------------------------------------------------------------------
// | msvodx[TP5内核]
// +----------------------------------------------------------------------
// | Copyright © 2019-QQ97250974
// +----------------------------------------------------------------------
// | 专业二开仿站定制修改,做最专业的视频点播系统
// +----------------------------------------------------------------------
// | Author: cherish ©2018
// +----------------------------------------------------------------------
namespace app\common\behavior;
use think\Request;
use app\admin\model\AdminModule as ModuleModel;
/**
 * 应用初始化行为
 */
class Init
{
    public function run(&$params)
    {
        define('IN_SYSTEM', true);
        $request = Request::instance();
        // 安装操作直接return
        if(defined('BIND_MODULE') && BIND_MODULE == 'install') return;
        $_path = $request->path();
        $default_module = false;
        if ($_path != '/') {
            $_path = explode('/', $_path);
            if (isset($_path[0]) && !empty($_path[0])) {
                if (is_dir('./app/'.$_path[0]) || $_path[0] == 'plugins') {
                    $default_module = true;
                    if ($_path[0] == 'plugins') {
                        define('BIND_MODULE', 'index');
                        define('PLUGIN_ENTRANCE', true);
                    }
                }
            }
        }
        
        // 设置路由
        config('route_config_file', ModuleModel::moduleRoute());
        if (!defined('PLUGIN_ENTRANCE') && !defined('CLOUD_ENTRANCE') && $default_module === false) {
            // 设置前台默认模块
            $map = [];
            $map['default'] = 1;
            $map['status'] = 2;
            $map['name'] =  ['neq', 'admin'];
            $def_mod = ModuleModel::where($map)->value('name');
            if ($def_mod && !defined('ENTRANCE')) {
                define('BIND_MODULE', $def_mod);
                config('url_controller_layer', 'home');
            }
        }
    }
}
