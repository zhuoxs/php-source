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
use app\admin\model\AdminLog as LogModel;
/**
 * 日志管理控制器
 * @package app\admin\controller
 */
class Log extends Admin
{
    /**
     * 日志首页
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function index()
    {
        $uid = input('param.uid/d');
        $map = [];
        if ($uid) {
            $map['uid'] = $uid;
        }
        $data_list = LogModel::where($map)->paginate();
        // 分页
        $pages = $data_list->render();
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        return $this->fetch();
    }
    /**
     * 清空日志
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function clear()
    {
        if (!LogModel::where('id > 0')->delete()) {
            return $this->error('日志清空失败');
        }
        return $this->success('日志清空成功');
    }
}
