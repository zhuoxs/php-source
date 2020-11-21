<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/11/3
 * Time: 11:53
 */
defined("IN_IA") or exit("Access Denied");
require_once ROOT_PATH.'model/common.php';
class Play_System{
    protected $that='';
    protected $uniacid='';
    static $common='';
    public function __construct($that){
        global $_W;
        checklogin();
        $this->that=$that;
        $this->uniacid=$_W['uniacid'];
        self::$common=new Common_KundianFarmModel('cqkundian_farm_plugin_play_set');
    }

    public function system_set($get){
        if($_SERVER['REQUEST_METHOD'] && !strcasecmp($_SERVER['REQUEST_METHOD'],'POST')){
            $updateData=$get['formData'];
            $res=self::$common->insertSetData($updateData,$this->uniacid);
            echo $res ? json_encode(['code'=>0,'msg'=>'保存成功']) : json_encode(['code'=>-1,'msg'=>'保存失败']);die;
        }
        $field=['first_time_gold_count','visit_friend_gold_count','farm_explain','task_template_id',
            'animal_explain','is_open_recovery','farm_name','animal_name','farm_share_title','gold_scale_money','land_shifei','land_chucao','land_zhuochong','steal_friend_get_gold'];
        $data['list']=self::$common->getSetData($field,$this->uniacid);
        $this->that->doWebCommon("web/system/system_set",$data);
    }

    public function animal_set($get){
        if($_SERVER['REQUEST_METHOD'] && !strcasecmp($_SERVER['REQUEST_METHOD'],'POST')){
            $updateData=$get['formData'];
            $res=self::$common->insertSetData($updateData,$this->uniacid);
            echo $res?json_encode(['code'=>0,'msg'=>'保存成功']) : json_encode(['code'=>-1,'msg'=>'保存失败']);die;
        }
        $field=['shed_adopt_count','shed_price','once_upgrade_area','shed_begin_area'];
        $data['list']=self::$common->getSetData($field,$this->uniacid);
        $this->that->doWebCommon("web/system/animal_set",$data);
    }

    public function navbar_set($get){
        $data['list']=self::$common->getSetData(['is_open_animal','is_open_look_friend','is_open_share_friend','is_open_ground'],$this->uniacid);
        if(empty($data['list'])){
            $data['list']=array(
                'is_open_animal'=>1,
                'is_open_look_friend'=>1,
                'is_open_share_friend'=>1,
                'is_open_ground'=>1,
            );
            $res=self::$common->insertSetData($data['list'],$this->uniacid);
        }
        $this->that->doWebCommon("web/system/navbar_set",$data);
    }

    /** 开启/关闭 小程序右侧导航 */
    public function closeNavBar($get){
        $type=$get['type'];  //1牧场 2 查看好友 3 邀请好友
        if($type==1){
            $data['is_open_animal']=$get['status'] ? $get['status'] : 0;
        }elseif ($type==2){
            $data['is_open_look_friend']=$get['status'] ? $get['status'] : 0;
        }elseif ($type==3){
            $data['is_open_share_friend']=$get['status'] ? $get['status'] : 0;
        }elseif ($type==4){
            $data['is_open_ground']=$get['status'] ? $get['status'] : 0;
        }
        $res=self::$common->insertSetData($data,$this->uniacid);
        if($res){
            echo json_encode(['code'=>1,'msg'=>'操作成功']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'操作失败']);die;
    }

}