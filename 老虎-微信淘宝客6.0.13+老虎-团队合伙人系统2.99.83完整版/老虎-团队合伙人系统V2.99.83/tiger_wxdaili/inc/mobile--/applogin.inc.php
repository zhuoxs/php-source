<?php
global $_W, $_GPC;

			//if(!$_W['isajax'])die(json_encode(array('error'=>0,'msg'=>'非法访问!')));
            $username=trim($_GPC['pcuser']);
            $password=trim($_GPC['pcpasswords']);
            if(empty($username)){
            	die(json_encode(array('error'=>0,'content'=>'用户名必须填写！')));//返回JSON数据
            }
            if(empty($password)){
            	die(json_encode(array('error'=>0,'content'=>'密码必须填写！')));//返回JSON数据
            }
            $set= pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_share") . " WHERE pcuser='{$username}' and weid='{$_W['uniacid']}' ");
            
            $content=array(
            		'id'=>$set['id'],
            		'weid'=>$set['weid'],
            		'tel'=>$set['tel'],
            		'from_user'=>$set['from_user'],
            		'nickname'=>$set['nickname'],
            		'avatar'=>$set['avatar'],
            		'helpid'=>$set['helpid'],
            		'dlptpid'=>$set['dlptpid'],
            		'zfbuid'=>$set['zfbuid'],
            		'tname'=>$set['tname'],
            		'createtime'=>$set['createtime'],
            		
            );
            
            echo 111;
            print_r($_SESSION);
            exit;
            
//          echo '<pre>';
//          print_r($content);
//          exit;

            if($username==$set['pcuser'] && $password==$set['pcpasswords']){
                //$_SESSION["pcuser"]=$set['pcuser'];
                //$url=$this->createMobileurl('main');
                 die(json_encode(array('error'=>1,'content'=>$content)));//返回JSON数据
              }else{
                 die(json_encode(array('error'=>0,'content'=>'帐号密码错误！')));//返回JSON数据
              }

?>