<?php

namespace app\api\controller;

use think\Request;
use app\api\model\Active as ActiveModel;
use app\api\model\Cover as CoverModel;

/**
 * 活动管理
 * Class Active
 * @package app\api\controller
 */
class Active extends BaseController
{
    /**
     * 已报名活动列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function enlist()
    {
        // 用户信息
        $user = $this->getUser();
        // 活动列表
        $model = new ActiveModel;
        $list = $model->enlist($user->user_id);
        // 默认封面图
        $cover_default = (new CoverModel)->getCoverDefault();
        return $this->renderSuccess(compact('list', 'cover_default'));
    }

    /**
     * 我发布的活动列表
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function mylist()
    {
        // 用户信息
        $user = $this->getUser();
        // 活动列表
        $model = new ActiveModel;
        $list = $model->mylist($user->user_id);
        // 默认封面图
        $cover_default = (new CoverModel)->getCoverDefault();
        return $this->renderSuccess(compact('list', 'cover_default'));
    }

    /**
     * 活动详情
     * @param $active_id
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail($active_id)
    {
        // 用户信息
        $user = $this->getUser();
        // 获取活动基本信息
        $model = new ActiveModel;
        $result = $model->detail($this->wxapp_id, $active_id);
        if (empty($result)) {
            return $this->renderError('活动不存在或已取消~');
        }
        $detail = $model->format($result->toArray(), $user->user_id);
        // 默认封面图
        $cover_default = (new CoverModel)->getCoverDefault();
        return $this->renderSuccess(compact('detail', 'cover_default'));
    }

    /**
     * 活动报名
     * @param $active_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function join($active_id)
    {
        // 用户信息
        $user = $this->getUser();
        // 活动信息
        $model = new ActiveModel;
        if (!$model = $model->get(['active_id' => $active_id, 'wxapp_id' => $this->wxapp_id])) {
            return $this->renderError('没有该活动信息');
        }
        // 新增活动报名记录
        if ($model->joinIn($user->user_id)) {
            return $this->renderSuccess([], '报名成功');
        }
        return $this->renderError('报名失败');
    }

    /**
     * 取消活动报名
     * @param $active_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function joinOut($active_id)
    {
        // 用户信息
        $user = $this->getUser();
        // 活动信息
        $model = new ActiveModel;
        if (!$model = $model->get(['active_id' => $active_id, 'wxapp_id' => $this->wxapp_id])) {
            return $this->renderError('没有该活动信息');
        }
        // 取消活动报名
        if ($model->joinOut($active_id, $user->user_id)) {
            return $this->renderSuccess([], '取消报名成功');
        }
        return $this->renderError('取消报名失败');
    }

    /**
     * 添加活动
     * @param Request $request
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function add(Request $request)
    {
        // 用户信息
        $user = $this->getUser();
        // post数据
        $data = $request->post('active/a');
        $data['wxapp_id'] = $this->wxapp_id;
        $data['user_id'] = $user['user_id'];
        // 新增活动记录
        $model = new ActiveModel;
        if ($model->add($data)) {
            return $this->renderSuccess(['active_id' => $model->active_id], '创建成功');
        }
        return $this->renderError('创建失败');
    }

    /**
     * 编辑活动
     * @param Request $request
     * @param $active_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function edit(Request $request, $active_id)
    {
        // 用户信息
        $user = $this->getUser();
        // 活动信息
        if (!$model = ActiveModel::get(['active_id' => $active_id, 'user_id' => $user['user_id']])) {
            return $this->renderError('没有该活动信息');
        }
        // post数据
        $data = $request->post('active/a');
        // 新增活动记录
        if ($model->edit($data)) {
            return $this->renderSuccess([], '更新成功');
        }
        return $this->renderError('更新失败');
    }

    /**
     * 删除活动
     * @param $active_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function delete($active_id)
    {
        // 用户信息
        $user = $this->getUser();
        // 活动信息
        if (!$model = ActiveModel::get(['active_id' => $active_id, 'user_id' => $user['user_id']])) {
            return $this->renderError('没有该活动信息');
        }
        // 删除活动
        if (!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess([], '删除成功');
    }

    /**
     * 活动留言
     * @param int $active_id
     * @param string $message
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function message($active_id, $message)
    {
        // 用户信息
        $user = $this->getUser();
        // 活动信息
        if (!$model = ActiveModel::get(['active_id' => $active_id])) {
            return $this->renderError('没有该活动信息');
        }
        // 活动留言
        if (!$status = $model->message($active_id, $user->user_id, $message)) {
            return $this->renderError('留言失败');
        }
        return $this->renderSuccess([], '留言成功');
    }

}
