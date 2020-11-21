<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $where =" WHERE  a.uniacid=".$_W['uniacid']  .  " and "   .  "a.id=".$_GPC['id'];
 $sql = "select a.*,b.name as user_name11 from " . tablename("yzkm_sun_store")."a ". "left join".tablename("yzkm_sun_user")."b on a.user_id=b.id".$where; 
 $info=pdo_fetch($sql);
 $info['coordinate']=explode(',',$info['coordinate']);
 // p($info['coordinate']);
 // p($_GPC);
 // p($info);die;
$area=pdo_getall('yzkm_sun_area',array('uniacid'=>$_W['uniacid']));

// p($type);die;

//  $where2 =" WHERE  a.uniacid=".$_W['uniacid']  .  " and "   .  "a.id=".$_GPC['id'];
//  $sql2 = "select b.tname as claxx from " . tablename("yzkm_sun_store")."a ". "left join".tablename("yzkm_sun_selectedtype")."b on a.storetype_id=b.tid".$where2; 
//  $info2=pdo_fetch($sql2);
// // p($_GPC);die;
//   $where3 =" WHERE  a.uniacid=".$_W['uniacid']  .  " and "   .  "a.id=".$_GPC['id'];
//  $sql3 = "select b.duration  from " . tablename("yzkm_sun_store")."a ". "left join".tablename("yzkm_sun_duration")."b on a.day_rz=b.id".$where3; 
//  $info3=pdo_fetch($sql3);
 
 // p($info3);die;
// $info=pdo_get('yzkm_sun_store',array('id'=>$_GPC['id']));

// $type1=pdo_getall('yzkm_sun_selectedtype',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']),array(),'','tname');
 // p($info2);die;


// p($type);die;
// $type2=pdo_get('yzkm_sun_storetype2',array('id'=>$info['storetype2_id']));
//查出已是商家用户
// $sjuser=pdo_getall('yzkm_sun_store',array('uniacid'=>$_W['uniacid']),'user_id');
// p($sjuser);die;
// //二维数组转一维
// $yuser=array_column($sjuser, 'user_id');
// foreach( $yuser as $k=>$v) {
// 	if($info['user_id'] == $v) unset($yuser[$k]);
// }

// //用户
// $user=pdo_getall('yzkm_sun_user',array('uniacid'=>$_W['uniacid'],'id !='=>$yuser));
//入住类型
//$typein=pdo_getall('yzkm_sun_in',array('uniacid'=>$_W['uniacid']));
// 查找编辑前的行业类别
// 根据gid查找商家id并根据商家的行业id查找对应的行业列表的行业名称
$type=pdo_getall('yzkm_sun_selectedtype',array('uniacid'=>$_W['uniacid']));//行业分类下拉框数据

 $where3 =" WHERE  a.uniacid=".$_W['uniacid']  .  " and "   .  "a.id=".$_GPC['id'];//默认值
 $sql3 ="select b.tname from " . tablename("yzkm_sun_store")."a ". "left join".tablename("yzkm_sun_selectedtype")."b on a.storetype_id=b.tid ".$where3;          
  $list3=pdo_fetch($sql3);
// 查找编辑前的入驻期限
// 根据id查找商家id并根据商家的行业id查找对应的入驻期限
$da_time=pdo_getall('yzkm_sun_duration',array('uniacid'=>$_W['uniacid']));//入驻期限下拉框数据

  $where4 =" WHERE  a.uniacid=".$_W['uniacid']  .  " and "   .  "a.id=".$_GPC['id'];//默认值
 $sql4 ="select b.duration from " . tablename("yzkm_sun_store")."a ". "left join".tablename("yzkm_sun_duration")."b on b.id=a.day_rz".$where4;          
  $list4=pdo_fetch($sql4);  

// p($list3);
// p($da_time);
// p($info);die;









	if($info['banner']){
				if(strpos($info['banner'],',')){
				$banner= explode(',',$info['banner']);
			}else{
				$banner=array(
					0=>$info['banner']
					);
			}
			}
	if($info['img']){
			if(strpos($info['img'],',')){
				$img= explode(',',$info['img']);
			}else{
				$img=array(
					0=>$info['img']
					);
			}
	}		
	if(checksubmit('submit')){



	if(empty($_GPC['store_name'] )){
		message('商家名称不能为空，请先添加商家名称','','error');
	}
	if(empty($_GPC['phone'] )){
		message('商家电话不能为空，请先添加商家电话','','error');
	}
	if(empty($_GPC['addr'] )){
		message('商家地址不能为空，请先添加商家地址','','error');
	}
	if(empty($_GPC['averagePrice'] )){
		message('人均价格不能为空，请先添加人均价格','','error');
	}
	if(empty($_GPC['lat'] )){
		message('地址坐标不能为空，请先添加地址坐标','','error');
	}

		
			if($_GPC['banner']){
				$data['banner']=implode(",",$_GPC['banner']);
			}else{
				$data['banner']='';
			}
			if($_GPC['img']){
				$data['img']=implode(",",$_GPC['img']);
				// p($data['img']);
				// p(11111);die;
			}else{
				$data['img']='';
				// p(2222);die;
			}
			if($_GPC['type']==''){

				message('入驻期限不能为空','','error');
			}	
			// if($_GPC['user_name']){
			// 	$rst=pdo_get('yzkm_sun_store',array('user_name'=>$_GPC['user_name'],'uniacid'=>$_W['uniacid'],'id !='=>$_GPC['id']));
			// 	if($rst){
			// 		message('用户名已存在,请更换用户名','','error');
			// 	}
			// }


			$tianshu=pdo_get('yzkm_sun_duration',array('id'=>$_GPC['type']),array(),'','duration');
			$tt=intval($tianshu['duration']);
			$time1=60*60*24*$tt;//一周
			$open_time1=date('Y:m:d',time());
			$over_time1=date("Y-m-d H:i:s",time()+$time1);

			// p($_GPC);die;
				
				if ($_GPC['type']==1) {
				  $over_time1=date("Y-m-d H:i:s",time()+$time1);
				}elseif ($_GPC['type']==2) {
				  $over_time1=date("Y-m-d H:i:s",time()+$time2);
				}elseif ($_GPC['type']==3) {
				  $over_time1=date("Y-m-d H:i:s",time()+$time3);
				}
				$data['store_name']=$_GPC['store_name'];
				$data['phone']=$_GPC['phone'];
				$data['addr']=$_GPC['addr'];
				$data['logo']=$_GPC['logo'];
				$data['score']=$_GPC['score'];//星级个数
				// $data['weixin_logo']=$_GPC['weixin_logo'];
				$data['coordinate']=$_GPC['lat'].",".$_GPC['lng'];
				// $data['coordinate']=$_GPC['coordinate'];
				$data['open_time']=$open_time1;
				$data['over_time']=$over_time1;
				$data['start_time']=$_GPC['start_time'];
				$data['end_time']=$_GPC['end_time'];
				// $data['keyword']=$_GPC['keyword'];
				$data['skzf']=$_GPC['skzf'];
				$data['wifi']=$_GPC['wifi'];
				$data['mftc']=$_GPC['mftc'];
				$data['jzxy']=$_GPC['jzxy'];
				$data['tgbj']=$_GPC['tgbj'];
				$data['sfxx']=$_GPC['sfxx'];
				// $data['user_id']=$_GPC['user_id'];
				$data['details']=$_GPC['details'];
				$data['averagePrice']=$_GPC['averagePrice'];
				// $data['num']=$_GPC['num'];
				$data['views']=$_GPC['views'];
				$data['storetype_id']=$_GPC['storetype_id'];
				// p($_GPC['storetype_id']);die;
				$data['is_top']=$_GPC['is_top'];
				$data['type']=$_GPC['type'];
				$data['day_rz']=$_GPC['type'];
				// $data['banner']=$_GPC['banner'];
				if ($data['store_name']!=''&& $data['phone']!=''&& $data['addr']!=''&& $data['coordinate']!=''&& $data['averagePrice']!='') {
					// p($data);die;
					$res = pdo_update('yzkm_sun_store', $data, array('id' => $_GPC['id']));
					if($res){
						message('编辑成功',$this->createWebUrl('store',array()),'success');
					}else{
						message('编辑失败','','error');
					}
				}else{
					message('请完善必填信息','','error');	
				}


			}


		 function  getCoade($md_id){
          function getaccess_token(){
            global $_W, $_GPC;
           $res=pdo_get('yzkm_sun_system',array('uniacid'=>$_W['uniacid']));
            $appid= $res['appid'];
            $secret=$res['appsecret'];
           /* $appid='wx648013d2ed95099f';
            $secret='7b072b70439afc58bc5531fc60aaa203';*/
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data,true);
            return $data['access_token'];
          }

          function set_msg($md_id){

           $access_token = getaccess_token();
           $data2=array(
            "scene"=>$md_id,
            "page"=>"yzkm_sun/pages/sellerinfo/sellerinfo",
            "width"=>100
            );
           $data2 = json_encode($data2);
           $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$access_token."";
           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL,$url);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
           curl_setopt($ch, CURLOPT_POST,1);
           curl_setopt($ch, CURLOPT_POSTFIELDS,$data2);
           $data = curl_exec($ch);
           curl_close($ch);
           return $data;
         }
         $img=set_msg($md_id);          
         $img=base64_encode($img);
        return $img;
       }
    
       if($_GPC['id']){
          $img2= getCoade($_GPC['id']);  


      }
include $this->template('web/storeinfo');