<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('zhls_sun_store',array('id'=>$_GPC['id']));
$area=pdo_getall('zhls_sun_area',array('uniacid'=>$_W['uniacid']));
$type=pdo_getall('zhls_sun_storetype',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
$type2=pdo_get('zhls_sun_storetype2',array('id'=>$info['storetype2_id']));
//查出已是商家用户
$sjuser=pdo_getall('zhls_sun_store',array('uniacid'=>$_W['uniacid']),'user_id');
//二维数组转一维
$yuser=array_column($sjuser, 'user_id');
foreach( $yuser as $k=>$v) {
	if($info['user_id'] == $v) unset($yuser[$k]);
}

//用户
$user=pdo_getall('zhls_sun_user',array('uniacid'=>$_W['uniacid'],'id !='=>$yuser));
//入住类型
//$typein=pdo_getall('zhls_sun_in',array('uniacid'=>$_W['uniacid']));
   $time=24*60*60*7;//一周
   $time2=24*182*60*60;//半年
   $time3=24*365*60*60;//一年
if($info['ad']){
			if(strpos($info['ad'],',')){
			$ad= explode(',',$info['ad']);
		}else{
			$ad=array(
				0=>$info['ad']
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
		if($_GPC['ad']){
			$data['ad']=implode(",",$_GPC['ad']);
		}else{
			$data['ad']='';
		}
			if($_GPC['img']){
			$data['img']=implode(",",$_GPC['img']);
		}else{
			$data['img']='';
		}
		if($_GPC['user_name']){
			$rst=pdo_get('zhls_sun_store',array('user_name'=>$_GPC['user_name'],'uniacid'=>$_W['uniacid'],'id !='=>$_GPC['id']));
			if($rst){
				message('用户名已存在,请更换用户名','','error');
			}
		}

			$data['store_name']=$_GPC['store_name'];
			$data['tel']=$_GPC['tel'];
			$data['address']=$_GPC['address'];
			$data['logo']=$_GPC['logo'];
			$data['ewm_logo']=$_GPC['ewm_logo'];
			$data['weixin_logo']=$_GPC['weixin_logo'];
			$data['announcement']=$_GPC['announcement'];
			$data['coordinates']=$_GPC['coordinates'];
			//$data['yy_time']=$_GPC['yy_time'];
			$data['start_time']=$_GPC['start_time'];
			$data['end_time']=$_GPC['end_time'];
			$data['keyword']=$_GPC['keyword'];
			$data['skzf']=$_GPC['skzf'];
			$data['wifi']=$_GPC['wifi'];
			$data['mftc']=$_GPC['mftc'];
			$data['jzxy']=$_GPC['jzxy'];
			$data['tgbj']=$_GPC['tgbj'];
			$data['sfxx']=$_GPC['sfxx'];
			$data['area_id']=$_GPC['area_id'];
			$data['user_id']=$_GPC['user_id'];
			$data['details']=$_GPC['details'];
			$data['vr_link']=$_GPC['vr_link'];
			$data['num']=$_GPC['num'];
			$data['user_name']=$_GPC['user_name'];
			$data['cityname']=$_GPC['cityname'];
			$data['views']=$_GPC['views'];
			$data['storetype_id']=$_GPC['storetype_id'];
			$data['pwd']=md5($_GPC['pwd']);
			$data['is_top']=$_GPC['is_top'];
			if($_GPC['type']){
				$data['type']=$_GPC['type'];
				if($_GPC['type']==1){
					$data['dq_time']=$info['sh_time']+$time;
				}
				if($_GPC['type']==2){
					$data['dq_time']=$info['sh_time']+$time2;
				}
				if($_GPC['type']==3){
					$data['dq_time']=$info['sh_time']+$time3;
				}

				$data['time_over']=2;
			}
				$res = pdo_update('zhls_sun_store', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('store',array()),'success');
				}else{
					message('编辑失败','','error');
				}
				
		}
		 function  getCoade($md_id){
          function getaccess_token(){
            global $_W, $_GPC;
           $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
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
            "page"=>"zhls_sun/pages/sellerinfo/sellerinfo",
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