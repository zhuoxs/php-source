<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/11/22
 * Time: 17:27
 */

namespace app\modules\mch\models;


use app\models\AppNavbar;

class AppNavbarEditForm extends Model
{
    public $store_id;

    public $navbar;

    public function rules()
    {
        return [
            ['navbar', 'required'],
            ['navbar', 'each', 'rule' => ['required', 'message' => '请添加导航图标']],
        ];
    }

    public function save()
    {
        if (!$this->validate())
            return $this->getModelError();
        foreach ($this->navbar['navs'] as $i => $nav) {
            $this->navbar['navs'][$i]['active_icon'] = $nav['active_icon'] ? $nav['active_icon'] : $nav['icon'];
            $this->navbar['navs'][$i]['active_color'] = $nav['active_color'] ? $nav['active_color'] : $nav['color'];
        }
        if (AppNavbar::setNavbar($this->navbar, $this->store_id)) {
            return [
                'code' => 0,
                'msg' => '保存成功',
            ];
        } else {
            return [
                'code' => 0,
                'msg' => '保存失败',
            ];
        }

    }
}