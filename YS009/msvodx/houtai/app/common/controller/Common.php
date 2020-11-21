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
namespace app\common\controller;

use think\View;
use think\Controller;
use think\db;

/**
 * 项目公共控制器
 * @package app\common\controller
 */
class Common extends Controller
{
    public $myDb = '';

    protected function _initialize()
    {
        // if(!check_admin_auth()){
        //     if(request()->isAjax()) $this->error('此功能需要更高权限版本才可以解锁,请联系服务商升级版本后解锁！');
        //     $this->redirect('/error/index.html');
        // }

        if(!in_array(strtolower(request()->controller()),['publics'])){
            $this->dbConfig();
        }
    }

    /**
     * 渲染后台模板
     * 模块区分前后台时需用此方法
     * @param string $template 模板路径
     * @author frs whs tcl dreamer ©2016
     * @return string
     */
    protected function afetch($template = '')
    {
        if ($template) {
            return $this->fetch($template);
        }
        $dispatch = request()->dispatch();
        if (!$dispatch['module'][2]) {
            $dispatch['module'][2] = 'index';
        }
        return $this->fetch($dispatch['module'][1] . DS . $dispatch['module'][2]);
    }

    /**
     * 渲染插件模板
     * @param string $template 模板名称
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    final protected function pfetch($template = '', $vars = [], $replace = [], $config = [])
    {
        $plugin = $_GET['_p'];
        $controller = $_GET['_c'];
        $action = $_GET['_a'];
        $template = $template ? $template : $controller . '/' . $action;
        if (defined('ENTRANCE') && ENTRANCE == 'admin') {
            $template = 'admin/' . $template;
        }
        $template_path = strtolower("plugins/{$plugin}/view/{$template}." . config('template.view_suffix'));
        return parent::fetch($template_path, $vars, $replace, $config);
    }

    protected function dbConfig()
    {
        if ($this->request->controller() != 'Dbconfig') {
            $user = session('admin_user');
            $where['id'] = $user['uid'];
            if (!empty($user['uid'])) {
                $db_config = Db::name('admin_user')->where($where)->field('db_config')->find();
                if (empty($db_config['db_config'])) {
                    $this->error('请先配置数据库！', url('admin/Dbconfig/index'));
                } else {
                    $config = json_decode($db_config['db_config'], true);
                    $db2 = [
                        // 数据库类型
                        'type' => 'mysql',
                        // 服务器地址
                        'hostname' => $config ['hostname'],
                        // 数据库名
                        'database' => $config ['database'],
                        // 数据库用户名
                        'username' => $config ['username'],
                        // 数据库密码
                        'password' => $config ['password'],
                        'hostport' => $config ['hostport'],
                        // 数据库编码默认采用utf8
                        'charset' => 'utf8',
                        // 数据库表前缀
                        'prefix' => $config ['prefix'],
                    ];
                    $this->myDb = Db::connect($db2);
                    try {
                        $this->myDb->execute('select version()');
                    } catch (\Exception $e) {
                        $this->error('数据库连接失败，请检查数据库配置！', url('admin/Dbconfig/index'));
                    }
                }
            }
        }

    }


}