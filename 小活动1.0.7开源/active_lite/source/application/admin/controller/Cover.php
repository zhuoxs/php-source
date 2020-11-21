<?php

namespace app\admin\controller;

use app\common\model\Cover as CoverModel;
use app\common\model\CoverClass as CoverClassModel;
use think\Request;

/**
 * 封面管理
 * Class Cover
 * @package app\admin\controller
 */
class Cover extends BaseController
{
    /**
     * 封面列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 当前小程序id
        $wxapp_id = $this->getWxAppId();
        // 封面列表
        $list = (new CoverModel)->getList($wxapp_id);
        // 封面分类列表
        $class_list = (new CoverClassModel)->getClassList($wxapp_id);
        return $this->fetch('index', compact('list', 'class_list'));
    }

    /**
     * 添加封面
     * @param Request $request
     * @return array|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add(Request $request)
    {
        // 当前小程序id
        $wxapp_id = $this->getWxAppId();
        $CoverModel = new CoverModel;
        if ($request->isPost()) {
            if (!$CoverModel->add($wxapp_id)) {
                $error = $CoverModel->error ?: '添加失败';
                return $this->renderError($error);
            }
            return $this->renderSuccess('添加成功', url('cover/index'));
        }
        // 封面分类列表
        $class_list = (new CoverClassModel)->getClassList($wxapp_id);
        return $this->fetch('add', compact('class_list'));
    }

    /**
     * 编辑封面
     * @param Request $request
     * @param $cover_id
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit(Request $request, $cover_id)
    {
        // 当前小程序id
        $wxapp_id = $this->getWxAppId();
        // 封面信息
        if (!$model = CoverModel::get(compact('cover_id', 'wxapp_id'))) {
            $this->error('没有该封面信息');
        }
        // 编辑页面
        if (!$request->isPost()) {
            // 封面分类列表
            $class_list = (new CoverClassModel)->getClassList($wxapp_id);
            return $this->fetch('edit', compact('model', 'class_list'));
        }
        // 更新封面
        if (!$model->edit($wxapp_id)) {
            $error = $model->error ?: '更新失败';
            return $this->renderError($error);
        }
        return $this->renderSuccess('更新成功', url('cover/index'));
    }

    /**
     * @param Request $request
     * @param $cover_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete(Request $request, $cover_id)
    {
        !$request->isAjax() && $this->error('非法请求');
        // 当前小程序id
        $wxapp_id = $this->getWxAppId();
        // 封面信息
        if (!$model = CoverModel::get(compact('cover_id', 'wxapp_id'))) {
            $this->error('没有该封面信息');
        }
        // 删除封面
        if (!$model->remove()) {
            $error = $model->error ?: '删除失败';
            return $this->renderError($error);
        }
        return $this->renderSuccess('删除成功');
    }

}
