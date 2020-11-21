<?php
     global $_W, $_GPC;
             $weid=$_W['uniacid'];
             $set = pdo_fetch ( 'select * from ' . tablename ( $this->modulename . "_appset" ) . " where weid='{$weid}'" );
             
     
             
             
             if(empty($set)){
                if (checksubmit('submit')){  
                	 $arr=$this->getsq($_GPC['tbuid']);
                	 if($arr['sq']==1){
                	 	message($arr['error'], referer(), 'error');
                	 }        	
                	
                     $indata=array(
                         'weid'=>$_W['uniacid'],
                         'appid'=>$_GPC['appid'],
                         'mchid'=>$_GPC['mchid'],   
												 'appzfip'=>$_GPC['appzfip'],   
												 'appfximg'=>$_GPC['appfximg'], 
												 'appfxtitle'=>$_GPC['appfxtitle'], 
												 'appfxcontent'=>$_GPC['appfxcontent'], 
												 'appkey'=>$_GPC['appkey'], 
												 'smskeyid'=>$_GPC['smskeyid'], 
												 'smssecret'=>$_GPC['smssecret'], 
												 'smsname'=>$_GPC['smsname'], 
												 'smscode'=>$_GPC['smscode'], 
												 'iossh'=>$_GPC['iossh'], 
												 'sjztype'=>$_GPC['sjztype'], 
												 'tanchuangurl'=>$_GPC['tanchuangurl'], 
												 'tanchuangpic'=>$_GPC['tanchuangpic'], 
												 'tanchuangtitle'=>$_GPC['tanchuangtitle'], 
												 'tanchuangjgtime'=>$_GPC['tanchuangjgtime'], 
												 'tanchuangtype'=>$_GPC['tanchuangtype'], 
                       
                     );
                 //echo '<pre>';
                 //print_r($indata);
                 //exit;
                     $result=pdo_insert($this->modulename."_appset",$indata);
                     if(empty($result)){
                       message('添加失败', referer(), 'error');
                     }else{
                       message ( '添加成功!' );
                     }    
                }
             }else{
              if (checksubmit('submit')){
                $id = intval($_GPC['id']);
                $updata=array(              
                        'appid'=>$_GPC['appid'],
                        'mchid'=>$_GPC['mchid'], 
												'appzfip'=>$_GPC['appzfip'], 
												'appfximg'=>$_GPC['appfximg'], 
												'appfxtitle'=>$_GPC['appfxtitle'], 
												'appkey'=>$_GPC['appkey'], 
												'appfxcontent'=>$_GPC['appfxcontent'], 
												'smskeyid'=>$_GPC['smskeyid'], 
												'smssecret'=>$_GPC['smssecret'], 
												'smsname'=>$_GPC['smsname'], 
												'smscode'=>$_GPC['smscode'], 
												'iossh'=>$_GPC['iossh'], 
												'sjztype'=>$_GPC['sjztype'],
												'tanchuangurl'=>$_GPC['tanchuangurl'], 
												'tanchuangpic'=>$_GPC['tanchuangpic'], 
												'tanchuangtitle'=>$_GPC['tanchuangtitle'], 
												'tanchuangjgtime'=>$_GPC['tanchuangjgtime'], 
												'tanchuangtype'=>$_GPC['tanchuangtype'], 
                        
                     );
                if(pdo_update($this->modulename."_appset",$updata,array('id'=>$id)) === false){
                       message ( '更新失败' );
                     }else{
                       message ( '更新成功!' );
                     }
               }
             }
     
     		include $this->template ( 'appset' );