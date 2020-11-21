                 <?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('yzkm_sun_custom',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
            $data['db_name1']=$_GPC['db_name1'];
            $data['db_name2']=$_GPC['db_name2'];
            $data['db_name3']=$_GPC['db_name3'];
            $data['db_name4']=$_GPC['db_name4'];
            $data['db_name5']=$_GPC['db_name5'];

            $data['pic_one']=$_GPC['pic_one'];
            $data['pic_one1']=$_GPC['pic_one1'];
            $data['pic_tow']=$_GPC['pic_tow'];
            $data['pic_tow1']=$_GPC['pic_tow1'];
             $data['pic_three']=$_GPC['pic_three'];
             $data['pic_three1']=$_GPC['pic_three1'];
            $data['pic_four']=$_GPC['pic_four'];
            $data['pic_four1']=$_GPC['pic_four1'];
            $data['pic_five']=$_GPC['pic_five'];
            $data['pic_five1']=$_GPC['pic_five1'];
            // $data['color']=$_GPC['color'];
            // $data['fontcolor']=$_GPC['fontcolor'];
            $data['uniacid']=$_W['uniacid'];       
         // var_dump($data);
            // if($_GPC['color']){
            //     $data['color']=$_GPC['color'];
            // }else{
            //     $data['color']="#ED414A";
            // }

            if($_GPC['id']==''){                
                $res=pdo_insert('yzkm_sun_custom',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('custom',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzkm_sun_custom', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('custom',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/custom');