<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/9/28
 * Time: 16:05
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/common.php';
class Active_System{
    protected $that='';
    protected $uniacid='';
    static $common='';
    public function __construct($that){
        global $_W;
        checklogin();
        $this->that=$that;
        $this->uniacid=$_W['uniacid'];
        self::$common=new Common_KundianFarmModel('cqkundian_farm_plugin_active_set');
    }

    /** 基本设置 */
    public function system_set($get){
        $filed=['is_open_active','is_open_check','active_desc','active_template_id'];
        $data['setData']=self::$common->getSetData($filed,$this->uniacid);

        if($_SERVER['REQUEST_METHOD'] && !strcasecmp($_SERVER['REQUEST_METHOD'],'post')){
            $formData=$get['formData'];
            $res=self::$common->insertSetData($formData,$this->uniacid);
            echo $res ? json_encode(['code'=>0,'msg'=>'保存成功']): json_encode(['code'=>-1,'msg'=>'保存失败']);die;
        }
        $this->that->doWebCommon("web/system/system_set",$data);
    }
}