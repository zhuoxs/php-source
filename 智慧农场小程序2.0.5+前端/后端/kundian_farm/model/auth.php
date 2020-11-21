<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/7/10 0010
 * Time: 下午 1:53
 */

defined('IN_IA') or exit('Access Denied');
require_once ROOT_PATH.'model/common.php';
class Auth_KundianFarmModel{
    public function checkAuth(){
        global $_W;
        if($_W['isfounder']){
            $perm = cache_load('prem'.$_W['username'].$_W['uniacid']);
            if(empty($perm)){
                $perm=$this->getAuth();
                cache_write('prem'.$_W['username'].$_W['uniacid'],$perm);
            }
        }else{
            $user=pdo_get(TABLE_PRE.'perm_user',['username'=>$_W['username'],'uniacid'=>$_W['uniacid']]);
            if(empty($user)){
                $perm = cache_load('prem'.$_W['username'].$_W['uniacid']);
                if(empty($perm)){
                    $perm=$this->getAuth();
                    cache_write('prem'.$_W['username'].$_W['uniacid'],$perm);
                }
            }else{
                $role=pdo_get(TABLE_PRE.'perm_role',['id'=>$user['role_id'],'uniacid'=>$_W['uniacid']]);
                $perm=explode(',',$role['perms']);
            }
        }
        return $perm;
    }

    public function getAuth(){
        $c=new Common_KundianFarmModel();
        $result=file_get_contents(ROOT_PATH.'inc/web/perm.json');
        $res=$c->objectToArray(json_decode($result));
        $perms=$res['data'];
        $perm=[];
        foreach ($perms as $k => $v ){
            $perm[]=$v['auth_name'];
            foreach ($v['auth'] as $a => $av){
                $perm[]=$av['value'];
                foreach ($av['action'] as $t => $tv ){
                    $perm[]=$tv['ac_auth'];
                }
            }
        }
        return $perm;
    }
}