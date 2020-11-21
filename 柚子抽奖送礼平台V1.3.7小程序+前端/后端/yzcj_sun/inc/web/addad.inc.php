<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzcj_sun_ad',array('id'=>$_GPC['id'],'uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
        $data['logo']=$_GPC['logo'];
        $data['status']=$_GPC['status'];
        // $data['title']=$_GPC['title'];
        $data['type']=1;
        // $data['state']=$_GPC['state'];
        $data['uniacid']=$_W['uniacid'];
        $data['xcx_name']=$_GPC['xcx_name'];
        $data['appid']=$_GPC['appid'];
        // if($_GPC['state']=='1'){
        //     $data['src']=$_GPC['src'];
            $data['url']=$_GPC['url'];
        //     $data['xcx_name']='';
        //     $data['appid']='';
        // }else if($_GPC['state']=='2'){
        //     $data['src']='';
        //     $data['url']=$_GPC['url'];
        //     $data['xcx_name']='';
        //     $data['appid']='';
        // }
        // else if($_GPC['state']=='3'){
        //     $data['src']='';
        //     $data['url']='';
            
        // }
    if($_GPC['id']==''){
        $count=pdo_fetchcolumn("select count(id) from".tablename('yzcj_sun_ad')." where uniacid={$_W['uniacid']} and status=1");

        if($count>=10&&$data['status']==1){
            message('添加失败！广告启用数量最多为10！','','error');
        }else{
            $res=pdo_insert('yzcj_sun_ad',$data);
            if($res){
                 message('添加成功！', $this->createWebUrl('ad'), 'success');
            }else{
                 message('添加失败！','','error');
            }
        }
        
    }else{
        $count=pdo_fetchcolumn("select count(id) from".tablename('yzcj_sun_ad')." where uniacid={$_W['uniacid']} and status=1");
        if($count>=10&&$data['status']==1){
            message('编辑失败！广告启用数量最多为10！','','error');
        }else{
            $res=pdo_update('yzcj_sun_ad',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
            if($res){
                 message('编辑成功！', $this->createWebUrl('ad'), 'success');
            }else{
                 message('编辑失败！','','error');
            }
        }
    }
}
include $this->template('web/addad');