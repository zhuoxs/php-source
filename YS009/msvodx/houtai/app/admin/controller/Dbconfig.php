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
namespace app\admin\controller;

use app\common\util\Dir;
use app\common\util\Database as dbOper;
use think\Db;
/**
 * 数据库管理控制器
 * @package app\admin\controller
 */
class Dbconfig extends Admin
{
    /**
     * 初始化方法
     */
    protected function _initialize()
    {
        parent::_initialize();

        $tab_data['menu'] = [
            [
                'title' => '备份数据库',
                'url' => 'admin/database/index?group=export',
            ],
            [
                'title' => '恢复数据库',
                'url' => 'admin/database/index?group=import',
            ],
        ];

        $this->tab_data = $tab_data;
    }

    /**
     * 数据库配置
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function index()
    {
        $user = session('admin_user');
        $where['id'] = $user['uid'];
        if ($this->request->isPost()) {
            $config = $this->request->post();
            $db2 = [
                // 数据库类型
                'type'        => 'mysql',
                // 服务器地址
                'hostname'    => $config ['hostname'],
                // 数据库名
                'database'    => $config ['database'],
                // 数据库用户名
                'username'    => $config ['username'],
                // 数据库密码
                'password'    => $config ['password'],
                'hostport'        => $config ['hostport'],
                // 数据库编码默认采用utf8
                'charset'     => 'utf8',
                // 数据库表前缀
                'prefix'      => $config ['prefix'],
            ];
            $this->myDb=Db::connect($db2);
            try{
                $this->myDb->execute('select version()');
            }catch(\Exception $e){
                $this->error('数据库连接失败，请检查数据库配置！');
            }
            $updata['db_config'] = json_encode($db2);
            Db::name('admin_user')->where($where)->update($updata);
            return $this->success('配置成功');
        }else{

            $db_config = Db::name('admin_user')->where($where)->field('db_config')->find();
            $config = json_decode($db_config['db_config'],true);
            $this->assign('config', $config);
            return $this->fetch();
        }
    }


}
