                 <?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('yzkm_sun_system',array('uniacid'=>$_W['uniacid']));
 // $info=pdo_get('yzkm_sun_system',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
            $data['pt_name']=$_GPC['pt_name'];
             $data['support_tel']=$_GPC['support_tel'];
              $data['support_font']=$_GPC['support_font'];
               $data['support_logo']=$_GPC['support_logo'];
          
            $data['details']=html_entity_decode($_GPC['details']);
            $data['uniacid']=$_W['uniacid'];       
            // $data['address']=$_GPC['address'];
        $data['link_logo']=$_GPC['link_logo'];
         $data['link_name']=$_GPC['link_name'];
            // $data['mail']=$_GPC['mail'];
            $data['pic']=$_GPC['pic'];
            if(!$_GPC['fontcolor']){
                 $data['fontcolor']='#ffb62b';
            }else{
                $data['fontcolor']=$_GPC['fontcolor'];
            }
       
        // var_dump($data);
            if($_GPC['color']==1){
                $data['color']='#ffffff';
                $data['color_val']='1';
            }else{
                $data['color']="#000000";
                $data['color_val']=0;
            }

            if($_GPC['id']==''){                
                $res=pdo_insert('yzkm_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzkm_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/settings');