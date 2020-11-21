<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('byjs_sun_meal',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

// $spec=pdo_getall('byjs_sun_meal_spec');
$type=pdo_getall('byjs_sun_mealtype',array('uniacid'=>$_W['uniacid'],'status'=>1));



// if($info['imgs']){
// 		if(strpos($info['imgs'],',')){
// 			$imgs= explode(',',$info['imgs']);
// 		}else{
// 			$imgs=array(
// 				0=>$info['imgs']
// 			);
// 		}
// }
// if($info['lb_imgs']){
// 	if(strpos($info['lb_imgs'],',')){
// 		$lb_imgs= explode(',',$info['lb_imgs']);
// 	}else{
// 		$lb_imgs=array(
// 			0=>$info['lb_imgs']
// 		);
// 	}
// }

if(checksubmit('submit')){
    // if(empty($_GPC['meal_name'])){
    //     message('请填写商品名称');
    // }

		
			
		
		// if($_GPC['lb_imgs']){
		// 	$data['lb_imgs']=implode(",",$_GPC['lb_imgs']);
		// }else{
		// 	$data['lb_imgs']='';
		// }
			$data['typeid']=$_GPC['typeid'];
  			$data['imgs']=$_GPC['imgs'];
  			$data['lb_imgs']=$_GPC['lb_imgs'];
  			$data['name']=$_GPC['name'];
  			$data['count']=$_GPC['count'];
  			$data['price']=$_GPC['price'];
  			$data['details']=htmlspecialchars_decode($_GPC['details']);
            $data['uniacid']=$_W['uniacid'];
            

			// $data['meal_name']=$_GPC['meal_name'];
			// $data['meal_cost']=$_GPC['meal_cost'];
			// $data['meal_price']=$_GPC['meal_price'];
   //          $data['meal_volume']=$_GPC['meal_volume'];
   //          $data['spec_name']=$_GPC['spec_name'];
   //          $data['spec_value']=$_GPC['spec_value'];
   //          $data['spec_names']=$_GPC['spec_names'];
   //          $data['spec_values']=$_GPC['spec_values'];
   //          
			// $data['freight']=$_GPC['freight'];
			// $data['delivery']=$_GPC['delivery'];
			// $data['quality']=$_GPC['quality'];
   //          
			// $data['free']=$_GPC['free'];
			// $data['all_day']=$_GPC['all_day'];
			// $data['service']=$_GPC['service'];
			// $data['refund']=$_GPC['refund'];
			// $data['weeks']=$_GPC['weeks'];
            $data['time']= time();
			if(empty($_GPC['id'])){
				$data['status']=1;
                $res = pdo_insert('byjs_sun_meal', $data);
            }else{

                $res = pdo_update('byjs_sun_meal', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
            }
				if($res){
					message('编辑成功',$this->createWebUrl('meal',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/mealinfo');