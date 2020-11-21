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
namespace app\admin\model;

use think\Model;
use app\admin\model\AdminMenu as MenuModel;
use app\admin\model\AdminRole as RoleModel;
use think\db;

/**
 * 卡密
 * @package app\admin\model
 */
class CardPassword extends Model
{
    //自定义初始化
    protected $connection = [];
    protected $table = 'fucks';
    protected function initialize()
    {
        $user = session('admin_user');
        $where['id'] = $user['uid'];
        $db_config = Db::name('admin_user')->where($where)->field('db_config')->find();
        $config = json_decode($db_config['db_config'], true);
        $this->table = 'fuck';
        return $this->table;
       /* $connections = [
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
            // 数据库编码默认采用utf8
            'charset'     => 'utf8',
            // 数据库表前缀
            'prefix'      => $config ['prefix'],
            // 数据库调试模式
            'debug'       => false,
        ];
        $this->$connection =$connections;*/
    }

}
