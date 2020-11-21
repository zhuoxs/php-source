<?php

namespace app\admin\controller;

use app\common\model\CoverClass as CoverClassModel;
use think\Request;

/**
 * 封面分类
 * Class CoverClass
 * @package app\admin\controller
 */
class CoverClass extends BaseController
{
    /**
     * 封面分类列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 当前小程序id
        $wxapp_id = $this->getWxAppId();
        // 封面列表
        $list = (new CoverClassModel)->getClassList($wxapp_id);
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加封面分类
     * @param Request $request
     * @return array|mixed
     */
    public function add(Request $request)
    {
        // 当前小程序id
        $wxapp_id = $this->getWxAppId();
        $model = new CoverClassModel;
        if ($request->isPost()) {
            if ($model->add($wxapp_id))
                return $this->renderSuccess('添加成功', url('cover_class/index'));
            return $this->renderError('添加失败');
        }
        return $this->fetch('add', compact('class_list'));
    }

    /**
     * 编辑封面分类
     * @param Request $request
     * @param $class_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit(Request $request, $class_id)
    {
        // 当前小程序id
        $wxapp_id = $this->getWxAppId();
        // 封面分类信息
        if (!$model = CoverClassModel::get(compact('class_id', 'wxapp_id'))) {
            $this->error('没有该封面分类信息');
        }
        if ($request->isPost()) {
            if ($model->edit($wxapp_id))
                return $this->renderSuccess('更新成功', url('cover_class/index'));
            return $this->renderError('更新失败');
        }
        return $this->fetch('edit', compact('model'));
    }

    /**
     * 删除封面分类
     * @param Request $request
     * @param $class_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete(Request $request, $class_id)
    {
        !$request->isAjax() && $this->error('非法请求');
        // 当前小程序id
        $wxapp_id = $this->getWxAppId();
        // 封面分类信息
        if (!$model = CoverClassModel::get(compact('class_id','wxapp_id'))) {
          return $this->renderError('没有该封面分类信息');
        }
        if (!$model->remove()) {
            $error = $model->error ?: '删除失败';
            return $this->renderError($error);
        }
        return $this->renderSuccess('删除成功');
    }

}