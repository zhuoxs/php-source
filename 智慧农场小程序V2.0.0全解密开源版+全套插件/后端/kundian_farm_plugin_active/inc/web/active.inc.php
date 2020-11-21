<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/9/28
 * Time: 17:03
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/public.php';
require_once ROOT_PATH_ACTIVE.'model/active.php';
class Active_Active{
    protected $that='';
    protected $uniacid='';
    static $active='';
    public function __construct($that){
        global $_W;
        checklogin();
        $this->that=$that;
        $this->uniacid=$_W['uniacid'];
        self::$active=new Active_KundianFarmPluginActive($this->uniacid);
    }
    /** 活动列表 */
    public function active_list($get){
        $pageIndex=$get['page'] ? $get['page'] : 1;
        $public=new Public_KundianFarmModel('cqkundian_farm_plugin_active',$this->uniacid);
        $data=$public->getTableList([],$pageIndex,10,'rank asc',true);
        $this->that->doWebCommon("web/active/active_list",$data);
    }

    /** 编辑活动信息 */
    public function active_edit($get){
        $addInfo=[['ikey'=>'姓名','check'=>false],['ikey'=>'联系电话','check'=>false],['ikey'=>'身份证号','check'=>false]];
        if($get['id']){
            $list=pdo_get('cqkundian_farm_plugin_active',['uniacid'=>$this->uniacid,'id'=>$get['id']]);
            $list['add_info']=unserialize($list['add_info']);
            for ($i=0;$i<count($addInfo);$i++){
                for ($j=0;$j<count($list['add_info']);$j++){
                    if($addInfo[$i]['ikey']==$list['add_info'][$j]){
                        $addInfo[$i]['check']=true;
                    }
                }
            }

            $actSpec=pdo_getall('cqkundian_farm_plugin_active_spec',['uniacid'=>$this->uniacid,'active_id'=>$get['id']]);
            $data=[
                'time'=>[
                    'start'=>date("Y-m-d",$list['begin_time']),
                    'end'=>date("Y-m-d",$list['end_time']),
                ],
                'addr'=>[
                    'lng'=>$list['longitude'],'lat'=>$list['latitude'],
                ],
                'start'=>date("Y-m-d H:i",$list['start_time']),
                'actSpec'=>$actSpec,
                'list'=>$list,
            ];
        }else{
            $data['start']=date("Y-m-d H:i",time());
        }

        if($_SERVER['REQUEST_METHOD']&& !strcasecmp($_SERVER['REQUEST_METHOD'],'post')){
            $active_id=self::$active->addActive($get['formData']);
            if($active_id){
                $redirect=url('site/entry/admin', array('m' => $get['m'],'op'=>'active_list','action'=>'active'));
                echo json_encode(['code'=>0,'msg'=>'保存成功','redirect'=>$redirect]);die;
            }
            echo json_encode(['code'=>-1,'msg'=>'保存失败']);die;
        }
        $data['add_info']=$addInfo;
        $this->that->doWebCommon("web/active/active_edit",$data);
    }

    /** 删除活动规格 */
    public function act_spec_del($get){
        $res=pdo_delete('cqkundian_farm_plugin_active_spec',['uniacid'=>$this->uniacid,'id'=>$get['id']]);
        echo $res ? json_encode(['code'=>0,'msg'=>'删除成功']) :json_encode(['code'=>-1,'msg'=>'删除失败']);die;
    }

    /** 删除活动*/
    public function active_del($get){
        $res=pdo_delete('cqkundian_farm_plugin_active',['uniacid'=>$this->uniacid,'id'=>$get['id']]);
        echo $res ? json_encode(['code'=>0,'msg'=>'删除成功']) :json_encode(['code'=>-1,'msg'=>'删除失败']);die;
    }
}