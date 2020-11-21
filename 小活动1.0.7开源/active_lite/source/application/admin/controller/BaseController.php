<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;

class BaseController extends Controller
{
    const JSON_SUCCESS_STATUS = 1;
    const JSON_ERROR_STATUS = 0;

    protected $admin;

    /**
     * 后台初始化
     */
    public function _initialize()
    {
        // 验证登录
        $this->checkLoginStatus();
        // 全局layout
        $this->layout();
    }

    /**
     * 全局layout模板输出
     */
    private function layout()
    {
        // 当前url
        $request = Request::instance();
        $current_url = toUnderScore($request->controller()) . DS . $request->action();
        $this->assign('current_url', strtolower($current_url));
        // 后台菜单
        $this->assign('menus', $this->menus());
        // 当前小程序信息
        $this->assign('wx_app', $this->admin['wx_app']);
    }

    /**
     * 后台菜单配置
     * @return array
     */
    private function menus()
    {
        return [
            [
                'name' => '首页',
                'icon' => 'home',
                'url' => 'index/index',
            ],
            [
                'name' => '系统设置',
                'icon' => 'cog',
                'url' => 'system/setting'
            ],
            [
                'name' => '封面管理',
                'icon' => 'picture-o',
                'submenu' => [
                    [
                        'name' => '封面列表',
                        'url' => 'cover/index',
                        'sub_urls' => [
                            'cover/add',
                            'cover/edit'
                        ]
                    ],
                    [
                        'name' => '分类管理',
                        'url' => 'cover_class/index',
                        'sub_urls' => [
                            'cover_class/add',
                            'cover-class/edit',
                        ]
                    ]
                ],
            ],
            [
                'name' => '会员管理',
                'icon' => 'user',
                'submenu' => [
                    [
                        'name' => '会员列表',
                        'url' => 'user/index',
                    ]
                ],
            ],
            [
                'name' => '活动管理',
                'icon' => 'rocket',
                'submenu' => [
                    [
                        'name' => '活动列表',
                        'url' => 'active/index',
                    ]
                ],
            ],
            [
                'name' => '意见与反馈',
                'icon' => 'info-circle',
                'submenu' => [
                    [
                        'name' => '反馈列表',
                        'url' => 'feedback/index',
                    ]
                ],
            ],
        ];
    }

    /**
     * 验证登录状态
     */
    private function checkLoginStatus()
    {
        $this->admin = Session::get('_admin_active_lite');
        if (empty($this->admin)
            || (int)$this->admin['is_login'] !== 1
            || !isset($this->admin['wx_app'])
            || empty($this->admin['wx_app'])
        ) {
            $this->error('登录态无效');
        }
    }

    /**
     * 获取当前wxapp_id
     */
    protected function getWxAppId()
    {
        return $this->admin['wx_app']['wxapp_id'];
    }

    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = self::JSON_SUCCESS_STATUS, $msg = '', $url = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }

    /**
     * 返回操作成功json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($msg = 'success', $url = '', $data = [])
    {
        return $this->renderJson(self::JSON_SUCCESS_STATUS, $msg, $url, $data);
    }

    /**
     * 返回操作失败json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderError($msg = 'error', $url = '', $data = [])
    {
        return $this->renderJson(self::JSON_ERROR_STATUS, $msg, $url, $data);
    }
}
