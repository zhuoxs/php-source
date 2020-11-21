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
use app\admin\model\AdminConfig as ConfigModel;
/**
 * 配置管理控制器
 * @package app\admin\controller
 */

class Config extends Admin
{
    public function index($group = 'base')
    {
        $tab_data = [];
        foreach (config('sys.config_group') as $key => $value) {
            $arr = [];
            $arr['title'] = $value;
            $arr['url'] = '?group='.$key;
            $tab_data['menu'][] = $arr;
        }
        $tab_data['current'] = url('?group='.$group);

        $map = [];
        $map['group'] = $group;
        $data_list = ConfigModel::where($map)->order('sort,id')->paginate();
        $pages = $data_list->render();
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        $this->assign('tab_data', $tab_data);
        $this->assign('tab_type', 1);
        return $this->fetch();
    }
    /**
     * 客户数据库通用状态设置 审核
     * 禁用、启用都是调用这个内部方法
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function khcheck() {
        $val   = input('param.val');
        $ids   = input('param.ids/a') ? input('param.ids/a') : input('param.id/a');
        $table = input('param.table');
        $field = input('param.field', 'is_check');
        if (empty($ids)) {
            return $this->error('参数传递错误[1]！');
        }
        if (empty($table)) {
            return $this->error('参数传递错误[2]！');
        }
        // 以下表操作需排除值为1的数据
        if ($table == 'admin_menu' || $table == 'admin_user' || $table == 'admin_role' || $table == 'admin_module') {
            if (in_array('1', $ids) || ($table == 'admin_menu' && in_array('2', $ids))) {
                return $this->error('系统限制操作');
            }
        }
        // 获取主键
        $pk = $this->myDb->name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $ids];

        $res = $this->myDb->name($table)->where($map)->setField($field, $val);
        if ($res === false) {
            return $this->error('状态设置失败');
        }
        return $this->success('状态设置成功');
    }
    /**
     * 添加配置
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            switch ($data['type']) {
                case 'switch':
                case 'radio':
                case 'checkbox':
                case 'select':
                    if (!$data['options']) {
                        return $this->error('请填写配置选项！');
                    }
                    break;
                default:
                    break;
            }
            // 验证
            $result = $this->validate($data, 'AdminConfig');
            if($result !== true) {
                return $this->error($result);
            }
            if (!ConfigModel::create($data)) {
                return $this->error('添加失败！');
            }
            // 更新配置缓存
            ConfigModel::getConfig('', true);
            return $this->success('添加成功。');
        }
        return $this->fetch('form');
    }

    /**
     * 修改配置
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function edit($id = 0)
    {
        $row = ConfigModel::where('id', $id)->field('id,group,title,name,value,type,options,tips,status,system')->find();
        if ($row['system'] == 1) {
            return $this->error('禁止编辑此配置！');
        }
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'AdminConfig');
            if($result !== true) {
                return $this->error($result);
            }
            if (!ConfigModel::update($data)) {
                return $this->error('保存失败！');
            }
            // 更新配置缓存
            ConfigModel::getConfig('', true);
            return $this->success('保存成功。');
        }
        $row['tips'] = htmlspecialchars_decode($row['tips']);
        $row['value'] = htmlspecialchars_decode($row['value']);
        $this->assign('data_info', $row);
        return $this->fetch('form');
    }

    /**
     * 删除配置
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function del()
    {
        $id = input('param.ids/a');
        $model = new ConfigModel();
        if ($model->del($id)) {
            return $this->success('删除成功。');
        }
        // 更新配置缓存
        ConfigModel::getConfig('', true);
        return $this->error($model->getError());
    }
}
