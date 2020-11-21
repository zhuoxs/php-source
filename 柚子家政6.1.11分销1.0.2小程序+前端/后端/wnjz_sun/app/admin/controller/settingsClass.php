<?php
// +----------------------------------------------------------------------
// | 微擎模块
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------

namespace app\admin\controller;


class settingsClass extends BaseClass {
    private $urlarray = array("ctrl"=>"settings");

    public function __construct(){
        parent::__construct();
        global $_W, $_GPC;
        $GLOBALS['frames'] = $this->getMainMenu();
    }

    /*奇推设置*/
    public function qituisetting(){
        global $_W, $_GPC;
        $item = pdo_get('wnjz_sun_sms',array('uniacid'=>$_W['uniacid']));
        if($item["qitui"]){
            $qitui = unserialize($item["qitui"]);
        }
        if(checksubmit('submit')){
            $indata=$_GPC['indata'];
            $data["qitui"] = serialize($indata);

            if($_GPC['id']==''){
                $data['uniacid']=trim($_W['uniacid']);
                $res=pdo_insert('wnjz_sun_sms',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('qituisetting',$this->urlarray),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('wnjz_sun_sms', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('qituisetting',$this->urlarray),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
        include $this->template('web/setting/qituisetting');

    }

}