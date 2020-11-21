<?php
//置顶方法
global $_GPC, $_W;
$id = $_GPC['id'];
if($_GPC['op'] == 'top'){
if($id){
    $top = pdo_getcolumn('byjs_sun_course',array('id'=>$id),top);
    if($top == 1){
        $top = 2;    //改为置顶编号
        $top_time = Date('Y-m-d H:i:s');
        $res = pdo_update('byjs_sun_course',array('top'=>$top,'top_time'=>$top_time),array('id'=>$id,'uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('course',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }else if($top == 2){
        $top_time = Date('Y-m-d H:i:s');
        $res = pdo_update('byjs_sun_course',array('top_time'=>$top_time),array('id'=>$id,'uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('course',array()),'success');
        }else{
            message('编辑失败s','','error');
        }
    }
}
}
if($_GPC['op'] == 'topArticle'){
    if($id){
        $top = pdo_getcolumn('byjs_sun_goodsarticle',array('id'=>$id),top);
        if($top == 1){
            $top = 2;    //改为置顶编号
            $top_time = Date('Y-m-d H:i:s');
            $res = pdo_update('byjs_sun_goodsarticle',array('top'=>$top,'top_time'=>$top_time),array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if($res){
                message('编辑成功',$this->createWebUrl('goodsarticle',array()),'success');
            }else{
                message('编辑失败','','error');
            }
        }else if($top == 2){
            $top_time = Date('Y-m-d H:i:s');
            $res = pdo_update('byjs_sun_goodsarticle',array('top_time'=>$top_time),array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if($res){
                message('编辑成功',$this->createWebUrl('goodsarticle',array()),'success');
            }else{
                message('编辑失败','','error');
            }
        }
    }
}
if($_GPC['op'] == 'canceltop'){
    if($id){
        $top = pdo_getcolumn('byjs_sun_goodsarticle',array('id'=>$id),top);
        if($top == 1){
            $top = 1;    //改为置顶编号
            $top_time = Date('Y-m-d H:i:s');
            $res = pdo_update('byjs_sun_goodsarticle',array('top'=>$top,'top_time'=>$top_time),array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if($res){
                message('状态未置顶',$this->createWebUrl('goodsarticle',array()),'success');
            }else{
                message('取消失败','','error');
            }
        }else if($top == 2){
          	$top = 1;
            $top_time = Date('Y-m-d H:i:s');
            $res = pdo_update('byjs_sun_goodsarticle',array('top_time'=>$top_time,'top'=>$top),array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if($res){
                message('取消成功',$this->createWebUrl('goodsarticle',array()),'success');
            }else{
                message('取消失败','','error');
            }
        }
    }
}
if($_GPC['op'] == 'deletetop'){
    if($id){
        $top = pdo_getcolumn('byjs_sun_course',array('id'=>$id),top);
        if($top == 1){
            $top = 1;    //改为置顶编号
            $top_time = Date('Y-m-d H:i:s');
            $res = pdo_update('byjs_sun_course',array('top'=>$top,'top_time'=>$top_time),array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if($res){
                message('状态未置顶',$this->createWebUrl('course',array()),'success');
            }else{
                message('取消失败','','error');
            }
        }else if($top == 2){
          	$top = 1;
            $top_time = Date('Y-m-d H:i:s');
            $res = pdo_update('byjs_sun_course',array('top_time'=>$top_time,'top'=>$top),array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if($res){
                message('取消成功',$this->createWebUrl('course',array()),'success');
            }else{
                message('取消失败','','error');
            }
        }
    }
}