<?php

namespace app\api\controller;

use app\api\model\Cover as CoverModel;
use think\Request;

/**
 * 封面图管理
 * Class Cover
 * @package app\api\controller
 */
class Cover extends BaseController
{
    /**
     * 封面图列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        $model = new CoverModel;
        $list = $model->getList($this->wxapp_id);
        return $this->renderSuccess(['list' => $list]);
    }

    /**
     * 添加封面
     * @param Request $request
     * @return array
     */
    public function add(Request $request)
    {
        $model = new CoverModel;
        if (!$model->add($request->post())) {
            $this->renderError($model->error ?: '添加失败');
        }
        return $this->renderSuccess();
    }

}