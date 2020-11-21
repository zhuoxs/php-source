<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
//       $fans = mc_oauth_userinfo();
//	   $fans = $_W['fans'];
//       
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	echo "请在微信端打开!";
	        	exit;
	        }	        
        }
        $mc=mc_fetch($fans['openid']);
				
				$share =$this->getmember($fans,$mc['uid']);
        //$share = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");


       
       
       if($share['credit2']>=$cfg['yjtype']){
           $pice=intval($share['credit2']);
           if(empty($pice)){
						 $yjtype=$cfg['yjtype']?$cfg['yjtype']:1;
             die(json_encode(array("statusCode"=>2000,"message"=>"佣金提现最少".$yjtype."元起")));
           }
            
            //当前用户
						//一次奖励
						if(!empty($cfg['yqycjiangli'])){
							if(!empty($share['helpid'])){
								$sjshare = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");
								if(!empty($sjshare['id'])){
				$jltx = pdo_fetch("select * from ".tablename($this->modulename."_jl")." where weid='{$_W['uniacid']}' and uid='{$share['id']}' and typelx=7");
									
									//die(json_encode(array("statusCode"=>1000,"message"=>$jltx."aa".$cfg['yqycjiangli']."aa".$share['id'])));
									if(empty($jltx)){										
										$this->mc_jl($sjshare['id'],1,12,$cfg['yqycjiangli'],'邀请奖励','');
										//die(json_encode(array("statusCode"=>1000,"message"=>$jltx."aa".$cfg['yqycjiangli']."aa".$share['id'])));
									}									
								}
							}
						}						
						//一次奖励结束
						$this->mc_jl($share['id'],1,7,-$pice,'奖励提现','');
            

            $data=array(
                'weid'=>$_W['uniacid'],
                'uid'=>$share['id'],
                'nickname'=>$fans['nickname'],
                'openid'=>$fans['openid'],
                'avatar'=>$fans['avatar'],
                'createtime'=>TIMESTAMP,
                'credit2'=>$pice,
                'zfbuid'=>$share['zfbuid'],
                'sh'=>0,
                'dmch_billno'=>$fans['dmch_billno']          
            );
            if (pdo_insert ( $this->modulename . "_txlog", $data ) === false) {
                die(json_encode(array("statusCode"=>100,'message'=>'系统繁忙！')));  
            } else{
                if(!empty($cfg['khgettx'])){//管理员提现提醒
                    $mbid=$cfg['khgettx'];
                    $mb=pdo_fetch("select * from ".tablename($this->modulename."_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
                     $valuedata=array(
			             'rmb'=>$pice,
			             'txzhanghao'=>$share['zfbuid'],//提现支付帐帐号
			             'msg'=>'',
			             'tel'=>$share['tel'],
			             'weixin'=>$share['weixin'],
			             'shenhe'=>'',//'审核通过|审核不通过|资料有误请重新提交审核',
			             'goodstitle'=>''//'积分商城，商品名称'
			         );
                    $msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,'',$cfg,$valuedata);                  
                }             

                die(json_encode(array("statusCode"=>200,'message'=>'提现成功,客服会在24小时内审核发放！请耐心等待！')));  
            }
       }else{
          die(json_encode(array("statusCode"=>2000,"message"=>"佣金提现最少".$cfg['yjtype']."元起")));
       }
