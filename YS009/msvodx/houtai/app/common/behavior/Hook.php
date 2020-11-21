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
use app\admin\model\AdminHook as HookModel;
use app\admin\model\AdminHookPlugins as HookPluginsModel;
use app\admin\model\AdminPlugins as PluginsModel;
/**
 * 注册钩子
 * @package app\common\behavior
 */
class Hook
{
    public function run(&$params)
    {
        // 安装操作直接return
        if(defined('BIND_MODULE') && BIND_MODULE == 'install') return;
        $hook_plugins = cache('hook_plugins');
        $hooks        = cache('hooks');
        $plugins      = cache('plugins');

        if (!$hook_plugins) {
            $hooks = HookModel::where('status', 1)->column('status', 'name');
            $plugins = PluginsModel::where('status', 2)->column('status', 'name');
            $hook_plugins = HookPluginsModel::where('status', 1)->field('hook,plugins')->order('sort')->select();
            // 非开发模式，缓存数据
            if (config('develop.app_debug') === 0) {
                cache('hook_plugins', $hook_plugins);
                cache('hooks', $hooks);
                cache('plugins', $plugins);
            }
        }
        // 全局插件
        if ($hook_plugins) {
            foreach ($hook_plugins as $value) {
                if (isset($hooks[$value->hook]) && isset($plugins[$value->plugins])) {
                    \think\Hook::add($value->hook, get_plugins_class($value->plugins));
                }
            }
        }
    }
}
