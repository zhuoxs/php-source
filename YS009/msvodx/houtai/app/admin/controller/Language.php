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
use app\common\model\AdminLanguage as LanguageModel;
/**
 * 语言包管理控制器
 * @package app\admin\controller
 */

class Language extends Admin
{
    /**
     * 语言包管理首页
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function index()
    {
        $data_list = LanguageModel::order('sort asc')->column('id,code,name,icon,sort,status');
        $this->assign('data_list', $data_list);
        return $this->fetch();
    }

    /**
     * 添加语言包
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $model = new LanguageModel();
            if (!$model->storage()) {
                return $this->error($model->getError());
            }
            return $this->success('保存成功。');
        }

        return $this->fetch('form');
    }

    /**
     * 修改语言包
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function edit()
    {
        $id = get_num();
        if ($this->request->isPost()) {
            $model = new LanguageModel();
            if (!$model->storage()) {
                return $this->error($model->getError());
            }
            return $this->success('保存成功。');
        }
        $data_info = LanguageModel::get($id);
        $this->assign('data_info', $data_info);
        return $this->fetch('form');
    }

    /**
     * 删除语言包
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function del()
    {
        $id = get_num();
        $model = new LanguageModel(); 
        if ($model->del($id) === false) {
            return $this->error('删除失败！');
        }
        return $this->success('删除成功');
    }
}
