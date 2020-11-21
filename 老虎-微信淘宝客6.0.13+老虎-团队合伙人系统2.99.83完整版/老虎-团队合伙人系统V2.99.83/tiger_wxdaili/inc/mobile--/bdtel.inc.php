 <?php     global $_W, $_GPC;
         $cfg = $this->module['config'];
         load()->model('mc');
         $id=$_GPC['id'];
         $tname=$_GPC['tname'];
         $tel=$_GPC['tel'];
         $openid=$_GPC['openid'];
         $pcpasswords=$_GPC['pcpasswords'];
          
         if(empty($id)){
         	exit(json_encode(array('code' =>222,'message'=>'请用正确的方式绑定！')));
         }
         if(empty($tname)){
         	exit(json_encode(array('code' =>222,'message'=>'姓名必须填写！')));
         }
         if(empty($tel)){
         	exit(json_encode(array('code' =>222,'message'=>'手机号必须填写！')));
         }
         
         $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$id}'");
         //echo '<pre>';
         //print_r($mc);
         $uid=mc_openid2uid($openid);
         if(empty($uid)){
         	exit(json_encode(array('code' =>222,'message'=>'会员不存在！')));
         }
         if($_W['isajax']){
            if(empty($share['pcuser'])){
            	   $id = intval($_GPC['id']);
		           $updata=array(                    
		                    'tname'=>$tname,
		                    'tel'=>$tel,
		                    'pcuser'=>$tel,
		                    'pcpasswords'=>$pcpasswords,
		                );
		           if(pdo_update("tiger_newhu_share",$updata,array('id'=>$id)) === false){		                  
		                  exit(json_encode(array('code' =>222,'message'=>'绑定失败！')));
	                }else{
	                  mc_credit_update($uid,'credit2',$cfg['bdteljl'],array($uid,'绑定手机号奖励'));
	                  exit(json_encode(array('code' =>0,'message'=>'绑定成功,奖励已发放,请在余额查看!')));
	                }
            }else{
            	exit(json_encode(array('code' =>222,'message'=>'您已经绑定过！')));
            }
         }

        ?>