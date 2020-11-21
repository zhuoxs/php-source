<?php
/**
     * 发送短信验证(业务逻辑)
     * @param string $tel 手机号
     * @param int $type 当前发送短信的行为,0:绑定手机;1:找回密码;2:注册用户
     * @param string $validate 验证码
		 http://cs.tigertaoke.com/app/index.php?i=14&c=entry&do=sms&m=tiger_newhu&tel=13867986973&uid=3521&type=2
     */
global $_W, $_GPC;
        global $_W, $_GPC;
                $uid=$_GPC['uid'];
                $type=$_GPC['type'];
								$tel=$_GPC['tel']; 
        		    if(!empty($uid)){
                   $share = pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and id='{$uid}'");
                }
        
        		//验证会员
                       
                if(!$tel){
                    die(json_encode(array('error'=>0,'data'=>'请填写手机号码')));//返回JSON数据
                }
                if($type == 0 && empty($share)){
                    die(json_encode(array('error'=>0,'data'=>'用户ID不存在')));//返回JSON数据
                }
               //生成随机验证码
               $value = mt_rand(100000,999999);
               $date_time = strtotime(date('Y-m-d'));
               $mobile = pdo_fetch("select * from ".tablename("tiger_app_mobsend")." where weid='{$_W['uniacid']}' and tel='{$tel}'");
               //echo $tel;
               //
               //print_r($mobile);
              // exit;
        
               if($type == 0){             //绑定手机
                    //if(!empty($mobile)){            
                   //     die(json_encode(array('error'=>0,'data'=>'手机号已被绑定')));//返回JSON数据
                   // }
                    if(!empty($share['pcuser'])){
                        die(json_encode(array('error'=>0,'data'=>'您已经绑定了手机号')));//返回JSON数据
                    }
                }elseif($type == 1){        //找回密码
                    $share = pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and pcuser='{$tel}'");
                    if(empty($share)){
                        die(json_encode(array('error'=>0,'data'=>'查询不到手机相关记录')));//返回JSON数据
                    }
                }else{//注册用户
                    if($tel==$share['pcuser']){
                        die(json_encode(array('error'=>0,'data'=>'手机号已被注册')));//返回JSON数据
                    }
                }
                if(!empty($mobile)){
                    //数据更新操作
                    $save = array();
                    //判断时间内的有效性(60秒)
                    if($mobile['add_time'] + 60 > TIMESTAMP){
                        die(json_encode(array('error'=>0,'data'=>'60秒内短信只能发送一次')));//返回JSON数据
                    }
                    if($mobile['add_time'] >= $date_time && $mobile['total'] > '5'){  //针对手机号 一天 最多发送三次
                        die(json_encode(array('error'=>0,'data'=>'短信的发送次数超过了限制')));//返回JSON数据
                    }elseif($mobile['add_time'] < $date_time){
                        $save['total'] = '1';
                    }else{
                        $save['total'] =1+$mobile['total'];
                    }
                    //如果两次的发送内容一致的话
                    if($value == $mobile['value']){
                        while($value == $mobile['value']){
                            $value = mt_rand(100000,999999);
                        }
                    }
                    $save['value'] = $value;
                    $save['add_time'] = TIMESTAMP;
                    $up=pdo_update("tiger_app_mobsend", $save, array('tel' =>$tel));
                    if($up=== false){
                        die(json_encode(array('error'=>0,'data'=>'数据执行失败1')));//返回JSON数据
                    }
                
                }else{ //不存在记录,需要记录
                    $insert = array('tel'=>$tel,'value'=>$value,'weid'=>$_W['uniacid'],'add_time'=>TIMESTAMP);
                    $ins=pdo_insert ("tiger_app_mobsend", $insert );
                    if($ins === false){
                        //die(json_encode(array('error'=>0,'data'=>'手机号码已经存在！')));//返回JSON数据
                    }
                }
        
        
               
               //$res=$this->Sms($tel,$value);
							 $appset=pdo_fetch("select * from ".tablename('tiger_newhu_appset')." where weid='{$_W['uniacid']}'");
							 $res=$this->sms($tel,$appset['smskeyid'],$appset['smssecret'],$appset['smsname'],$appset['smscode'],$value);
							 
               if($res=='OK'){
                  die(json_encode(array('error'=>1,'data'=>'短信发送成功!')));//返回JSON数据
               }else{
                  die(json_encode(array('error'=>0,'data'=>'短信发送失败!')));//返回JSON数据
               }