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
namespace app\admin\validate;

use think\Validate;

/**
 * 钩子验证器
 * @package app\admin\validate
 */
class RechargePackage extends Validate
{
    //定义验证规则
    protected $rule = [
        'name|套餐名称' => 'require',
        'permanent|是否是永久套餐' => 'checkPermanent:thinkphp',
        'price|套餐价格' => 'require',
    ];
    //定义验证提示
    protected $message = [
        'name.require' => '套餐名称不能为空',

    ];

    //定义验证场景
    protected $scene = [
        //更新


    ];

    /**
     * 检查是否已经存在永久套餐
     * @author frs
     * @return stirng|array
     */
    protected function checkPermanent($value, $rule, $data)
    {
        if($data['permanent'] == 1){
            $myDb=x_connect_webdatabase();
            $info  = $myDb->name('recharge_package')->where(array('permanent'=>1))->field('id')->find();
            if(!empty($info)){
                if($data['id'] != $info['id']){
                    return '只能存在一个永久套餐';
                }
            }else{
                return true;
            }
        }else{
            if(empty($data['days'])){
                return '套餐天数不能为空';
            }
        }
        return true;
    }
}
