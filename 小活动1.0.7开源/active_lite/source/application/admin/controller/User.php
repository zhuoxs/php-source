<?php

namespace app\admin\controller;

use app\common\model\User as UserModel;

/**
 * 会员管理
 * Class User
 * @package app\admin\controller
 */
class User extends BaseController
{
    /**
     * 会员列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 当前小程序id
        $wxapp_id = $this->getWxAppId();
        // 会员列表
        $list = (new UserModel)->getList($wxapp_id);
        return $this->fetch('index', compact('list'));
    }

}
