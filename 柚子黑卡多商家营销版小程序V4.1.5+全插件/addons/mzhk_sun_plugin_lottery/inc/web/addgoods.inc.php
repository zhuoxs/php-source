<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('mzhk_sun_plugin_lottery_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
if($info['showbrand']){
    $info['showbrand'] = explode(',',$info['showbrand']);

    // $showbrand=pdo_fetchall('select * from '.tablename('mzhk_sun_plugin_lottery_showbrand')." where uniacid =".$_W['uniacid']." and gid = ".$_GPC['gid']." order by spec asc");

}
// if(strpos($info['pic'],'_')){
//     $info['pic']= str_replace('_', '/', $info['pic']);
// }
if($info['img']){
    if(strpos($info['img'],',')){
        $img= explode(',',$info['img']);
    }else{
        $img=array(
            0=>$info['img']
        );
    }
}
//赞助商 
// $brand=pdo_getall('mzhk_sun_brand',array('uniacid'=>$_W['uniacid']));
$brand=pdo_fetchall('select bid as value,bname as title from '.tablename('mzhk_sun_brand')." where uniacid =".$_W['uniacid']." order by bid asc");

$sponsor=pdo_getall('mzhk_sun_plugin_lottery_sponsorship',array('uniacid'=>$_W['uniacid'],'status'=>2));

$user=pdo_getall('mzhk_sun_user',array('uniacid'=>$_W['uniacid']));
if(!empty($info['sid'])){
    $name=pdo_get('mzhk_sun_plugin_lottery_sponsorship',array('sid'=>$info['sid'],'uniacid'=>$_W['uniacid']),'sname')['sname'];

}else{
    $name=pdo_get('mzhk_sun_user',array('id'=>$info['uid'],'uniacid'=>$_W['uniacid']),'name')['name'];
}
function object_array($array) {  
    if(is_object($array)) {  
        $array = (array)$array;  
     } if(is_array($array)) {  
         foreach($array as $key=>$value) {  
             $array[$key] = object_array($value);  
             }  
     }  
     return $array;  
}
if(checksubmit('submit')){

        $showbrand=$_GPC['showbrand'];
    
        $data['cid']=$_GPC['cid'];
        $data['gname']=$_GPC['gname'];
        $data['count']=$_GPC['count'];
        if($_GPC['isbuy']==111){
            $data['isbuy']=1;
        }else{
            $data['isbuy']=2;
        }
        if($_GPC['isshow']==333){
            $data['isshow']=1;
            $data['showbrand']=$showbrand;
        }else{
            $data['isshow']=0;
            $data['showbrand']='';

        }
        // var_dump($_GPC['sid']);die;
        
        
        $data['lottery']=html_entity_decode($_GPC['lottery']);

        if($_GPC['zuidd']==4){
            $data['zuid']=$_GPC['zuid'];
        }else{
            $data['zuid']='';
        }
        
        $data['condition']=$_GPC['condition'];
        if($_GPC['condition']==0){
            $data['accurate']=$_GPC['accurate0'];
        }else if($_GPC['condition']==1){
            $data['accurate']=$_GPC['accurate1'];
        }else{
            $data['accurate']='';
        }
        
        $data['uniacid']=$_W['uniacid'];
        
        $data['pic']=$_GPC['pic'];
        //高级抽奖
        $data['img']=implode(",",$_GPC['img']);
        if($_GPC['state']==5){
            $data['state']=1;
            $data['paidprice']=$_GPC['paidprice'];
        }else if($_GPC['state']==6){
            $data['state']=2;
            $data['password']=$_GPC['password'];
        }else if($_GPC['state']==7){
            $data['state']=3;
            $data['group']=$_GPC['group'];
        }else if($_GPC['state']==8){
            $data['state']=4;
            $data['codenum']=$_GPC['codenum'];
            $data['codemost']=$_GPC['codemost'];
            // $data['codecount']=$_GPC['codecount'];
            if($_GPC['codeway']==11){
                $data['codeway']=1;
            }else if($_GPC['codeway']==12){
                $data['codeway']=2;
            }
        }else if($_GPC['state']==13){
            $data['state']=5;
        }

        if($_GPC['one']==9){
            $data['one']=1;
            $data['onename']=$_GPC['onename'];
            $data['onenum']=$_GPC['onenum'];
            $data['twoname']=$_GPC['twoname'];
            $data['twonum']=$_GPC['twonum'];
            $data['threename']=$_GPC['threename'];
            $data['threenum']=$_GPC['threenum'];
        }elseif($_GPC['one']==10){
            $data['one']=2;
        }  
        // var_dump($_GPC);
    if($_GPC['gid']==''){
            $data['status']=2;
            $data['selftime']=date('Y-m-d H:i:s',time());
            $data['sid']=$_GPC['sid'];

            if($data['sid']==0){
                message('添加失败！，请选择赞助商！','','error');
            }
            $res=pdo_insert('mzhk_sun_plugin_lottery_goods',$data);
            $data1['gid']=pdo_insertid();
            $data2['gid']=$data1['gid'];
            if($_GPC['zuidd']==4){
                $data1['uid']=$_GPC['zuid'];
                //生成订单号
                $data1['orderNum']=date('Ymdhi',time()).rand(10000,99999);
                //查询所有订单号，一旦重复，就重新生成
                $allNum=pdo_getall('mzhk_sun_plugin_lottery_order',array('uniacid'=>$_W['uniacid']),'orderNum');
                foreach ($allNum as $key => $value) {
                    if($value['orderNum']==$orderNum){
                        $data1['orderNum']=date('Ymdhi',time()).rand(10000,99999);
                    }
                }
                $data1['time']=date('Y-m-d H:i:s',time());
                $data1['uniacid']=$_W['uniacid'];
                $result=pdo_insert('mzhk_sun_plugin_lottery_order',$data1);
                $data2['oid']=pdo_insertid();

                // if($_GPC['state']==8){
                //     $data2['uid']=$_GPC['zuid'];
                //     $data2['invuid']=$_GPC['zuid'];
                //     $data2['uniacid']=$_W['uniacid'];
                //     $result1=pdo_insert('mzhk_sun_plugin_lottery_code',$data2);
                // }
            }
            if($res){
                 message('添加成功！', $this->createWebUrl('goods'), 'success');
            }else{
                 message('添加失败！','','error');
            }
    }else{  
            $uid=$_GPC['zuid'];
            $gid=$_GPC['gid'];
            if(!$info['uid']){
                $data['sid']=$_GPC['sid'];

                if($data['sid']==0){
                    message('添加失败！，请选择赞助商！','','error');
                }
            }
            if($_GPC['zuidd']==3){
                
                $result=pdo_delete('mzhk_sun_plugin_lottery_order',array('gid'=>$gid,'uniacid'=>$_W['uniacid']));
                // $result1=pdo_delete('mzhk_sun_plugin_lottery_code',array('gid'=>$gid,'uniacid'=>$_W['uniacid']));
            }else{
                $zuid=pdo_get('mzhk_sun_plugin_lottery_goods',array('gid'=>$gid,'uniacid'=>$_W['uniacid']),'zuid')['zuid'];
                if(empty($zuid)){
                    $data1['uid']=$_GPC['zuid'];
                    $data1['gid']=$gid;
                    //生成订单号
                    $data1['orderNum']=date('Ymdhi',time()).rand(10000,99999);
                    //查询所有订单号，一旦重复，就重新生成
                    $allNum=pdo_getall('mzhk_sun_plugin_lottery_order',array('uniacid'=>$_W['uniacid']),'orderNum');
                    foreach ($allNum as $key => $value) {
                        if($value['orderNum']==$orderNum){
                            $data1['orderNum']=date('Ymdhi',time()).rand(10000,99999);
                        }
                    }
                    $data1['time']=date('Y-m-d H:i:s',time());
                    $data1['uniacid']=$_W['uniacid'];
                    $result=pdo_insert('mzhk_sun_plugin_lottery_order',$data1);
                    $data2['oid']=pdo_insertid();

                    // if($_GPC['state']==8){
                    //     $data2['gid']=$gid;
                    //     $data2['uid']=$_GPC['zuid'];
                    //     $data2['invuid']=$_GPC['zuid'];
                    //     $data2['uniacid']=$_W['uniacid'];
                    //     $result1=pdo_insert('mzhk_sun_plugin_lottery_code',$data2);
                    // }
                }
            }
            $res=pdo_update('mzhk_sun_plugin_lottery_goods',$data,array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
            if($res){
                 message('编辑成功！', $this->createWebUrl('goods'), 'success');
            }else{
                 message('编辑失败！','','error');
            }
    }
}
include $this->template('web/addgoods');