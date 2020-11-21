<?php

namespace app\common\model;

use think\Model;
use think\Request;

/**
 * 模型基类
 * Class BaseModel
 * @package app\common\model
 */
class BaseModel extends Model
{
    public $error;

    /**
     * 模型基类初始化
     */
    public function initialize()
    {
        parent::initialize();

        // 设置mysql sql_mode
//        $this->setSqlMode();
    }

    /**
     * 当前url
     * @return string
     */
    protected function rootUrl()
    {
        $request = Request::instance();
        return 'http://' . $request->host() . dirname($request->baseUrl());
    }

    /**
     * 设置mysql sql_mode
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    private function setSqlMode()
    {
        $this->execute("SET SESSION sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
    }

    /**
     * 返回操作信息
     * @param $msg
     * @return bool
     */
    protected function error($msg)
    {
        $this->error = $msg;
        return false;
    }
}