<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('yzcj_sun_gifts',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

if($info['pic']){
    if(strpos($info['pic'],',')){
        $pic= explode(',',$info['pic']);
    }else{
        $pic=array(
            0=>$info['pic']
        );
    }
}
//赞助商
$sponsor=pdo_getall('yzcj_sun_sponsorship',array('uniacid'=>$_W['uniacid'],'status'=>2));
// if(strpos($info['pic'],'_')){
//     $info['pic']= str_replace('_', '/', $info['pic']);
// }
//类型
$type=pdo_getall('yzcj_sun_type',array('uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){
        $data['type']=$_GPC['type'];
        $data['gname']=$_GPC['gname'];
        $data['price']=$_GPC['price'];
        $data['count']=$_GPC['count'];
        $data['lottery']=$_GPC['lottery'];
        $data['sid']=$_GPC['sid'];
        $data['status']=1;
        $data['uniacid']=$_W['uniacid'];
        $data['content']=html_entity_decode($_GPC['content']);
        if($_GPC['pic']){
            $data['pic']=implode(",",$_GPC['pic']);//首页轮播图添加没问题但是图片数据处理还有问题
        }else{
            $data['pic']='';
        }
        
        // var_dump($data);
    if($_GPC['id']==''){

            $res=pdo_insert('yzcj_sun_gifts',$data);

            if($res){
                 message('添加成功！', $this->createWebUrl('gifts'), 'success');
            }else{
                 message('添加失败！','','error');
            }
    }else{  

            $res=pdo_update('yzcj_sun_gifts',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
            if($res){
                 message('编辑成功！', $this->createWebUrl('gifts'), 'success');
            }else{
                 message('编辑失败！','','error');
            }
    }
}
include $this->template('web/addgifts');