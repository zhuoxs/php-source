<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/19
 * Time: 11:32
 */

defined('IN_IA') or exit('Access Denied');

class Public_KundianFarmModel{
    protected $table='';
    protected $uniacid='';
    public function __construct($table='',$uniacid=''){
        $this->table=$table;
        $this->uniacid=$uniacid;
    }

    public function getTableById($id){
        if(empty($id)){
            return false;
        }
        return pdo_get($this->table,['id'=>$id,'uniacid'=>$this->uniacid]);
    }

    public function getTableByCond($cond,$mutil=true){
        $cond['uniacid']=$this->uniacid;
        if($mutil){
            return pdo_getall($this->table,$cond);
        }
        return pdo_get($this->table,$cond);
    }

    public function updateTable($updateData,$cond){
        if(empty($cond) || empty($updateData)){
            return false;
        }
        $cond['uniacid']=$this->uniacid;
        return pdo_update($this->table,$updateData,$cond);
    }

    public function deleteTable($cond){
        if(empty($cond)){
            return false;
        }
        $cond['uniacid']=$this->uniacid;
        return pdo_delete($this->table,$cond);
    }

    public function getTableList($cond=[],$pageIndex='',$pageSize='',$order_by='id desc',$pager=false){
        if(empty($cond['uniacid'])){
            $cond['uniacid']=$this->uniacid;
        }
        if(!empty($pageIndex) && !empty($pageSize)){
            if($pager){
                $all=$this->getCount($cond);
                $data['pager'] = pagination($all, $pageIndex, $pageSize);
                $data['list'] = pdo_getall($this->table,$cond,'','',$order_by,[$pageIndex,$pageSize]);
                return $data;
            }
            return pdo_getall($this->table,$cond,'','',$order_by,[$pageIndex,$pageSize]);
        }
        return pdo_getall($this->table,$cond,'','',$order_by);
    }


    public function getCount($cond=[]){
        if(empty($cond['uniacid'])){
            $cond['uniacid']=$this->uniacid;
        }
        $query = load()->object('query');
        return $query->from($this->table)->where($cond)->count();
    }
}