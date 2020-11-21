<?php
/**
 * User: 坤典科技
 * url:www.cqkundian.com
 */
defined("IN_IA") or exit("Access Denied");
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/user.php';
require_once ROOT_PATH.'model/public.php';
require_once ROOT_PATH_PLAY.'model/animal.php';
class Play_Animal{
    protected $that='';
    protected $uniacid='';
    static $common='';
    static $animal_play='';
    public function __construct($that){
        global $_W;
        checklogin();
        $this->that=$that;
        $this->uniacid=$_W['uniacid'];
        self::$common=new Common_KundianFarmModel('cqkundian_farm_plugin_play_set');
        self::$animal_play=new Animal_Model($this->uniacid);
    }

    /** 棚升级订单列表 */
    public function shed_upgrade_order($get){
        $pageIndex=$get['page'] ? $get['page'] : 1;
        $public=new Public_KundianFarmModel(self::$animal_play->shedTable,$this->uniacid);
        $data=$public->getTableList([],$pageIndex,10,'create_time desc',true);
        for ($i=0;$i<count($data['list']);$i++){
            $user=pdo_get('cqkundian_farm_user',['uid'=>$data['list'][$i]['uid'],'uniacid'=>$this->uniacid]);
            $data['list'][$i]['nickname']=$user['nickname'];
            $data['list'][$i]['create_time']=date("Y-m-d H:i:s",$data['list'][$i]['create_time']);
        }
        $this->that->doWebCommon("web/animal/shed_upgrade_order",$data);
    }

    /** 删除棚升级订单 */
    public function deleteShedOrder($get){
        $res=pdo_delete(self::$animal_play->shedTable,['id'=>$get['id'],'uniacid'=>$this->uniacid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'删除成功']):json_encode(['code'=>-1,'msg'=>'删除失败']);die;
    }
}