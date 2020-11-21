<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/10/11
 * Time: 11:53
 */
defined("IN_IA")or exit("Access Denied");
class Live_KundianFarmModel{
    public $tableName='cqkundian_farm_live';
    public $live_type='cqkundian_farm_live_type';
    public function __construct($tableName=''){
        if($tableName){
            $this->tableName=$tableName;
        }
    }

    public function addLive($data){
        global $_W;
        $updateData=array(
            'cover'=>tomedia($data['cover']),
            'title'=>$data['title'],
            'rank'=>$data['rank'],
            'type_id'=>$data['type_id'],
            'status'=>$data['status'],
            'live_uid'=>$data['live_uid'],
            'play_type'=>$data['play_type'],
            'uniacid'=>$_W['uniacid'],
        );
        if(!empty($data['src'])){
            $updateData['src']=$data['src'];
            $head=explode(":",$data['src']);
            if($head[0]=='http'){
                $rtmp=str_replace("http","rtmp",$data['src']);
                $rtmp=str_replace(".m3u8","",$rtmp);
                $updateData['rtmp_src']=$rtmp;
            }
            if($head[0]=='https'){
                $rtmp=str_replace("https","rtmp",$data['src']);
                $rtmp=str_replace(".m3u8","",$rtmp);
                $updateData['rtmp_src']=$rtmp;
            }

            if($head[0]=='rtmp'){
                $rtmp=str_replace("rtmp","http",$data['src']);
                $rtmp.='.m3u8';
                $updateData['rtmp_src']=$data['src'];
                $updateData['src']=$rtmp;
            }
        }
        if(empty($data['id'])){  //新增
            return pdo_insert($this->tableName,$updateData);
        }
        $condition=array(
            'id'=>$data['id'],
            'uniacid'=>$_W['uniacid'],
        );
        return pdo_update($this->tableName,$updateData,$condition);
    }

    public function addLiveType($data){
        global $_W;
        $updateData=array(
            'name'=>$data['name'],
            'status'=>$data['status'],
            'rank'=>$data['rank'],
            'uniacid'=>$_W['uniacid'],
        );
        if(empty($data['id'])){  //新增
            return pdo_insert($this->live_type,$updateData);
        }
        $condition=array(
            'id'=>$data['id'],
            'uniacid'=>$_W['uniacid'],
        );
        return pdo_update($this->live_type,$updateData,$condition);
    }
}