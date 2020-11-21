<?php
     global $_W, $_GPC;
             $weid=$_W['uniacid'];
             $set = pdo_fetch ( 'select * from ' . tablename ( $this->modulename . "_miandanset" ) . " where weid='{$weid}'" );
						 $set['content'] = str_replace("<br>","\r\n",$set['content']);
             
     
             
             
             if(empty($set)){
                if (checksubmit('submit')){     
									$str1 = str_replace("\r\n","<br>",$_GPC['content']);

                     $indata=array(
                         'weid'=>$_W['uniacid'],
                         'mdtype'=>$_GPC['mdtype'],
                         'mdrensum'=>$_GPC['mdrensum'],   
												 'starttime' => strtotime($_GPC['starttime']),
												 'endtime' => strtotime($_GPC['endtime']),
												 'miandanpid'=>$_GPC['miandanpid'], 
												 'mdyaoqingcount'=>$_GPC['mdyaoqingcount'], 
												 'mdyaoqingsum'=>$_GPC['mdyaoqingsum'], 
												 'mdzgcount'=>$_GPC['mdzgcount'], 
												 'content'=>$str1, 
												 'mdzgsum'=>$_GPC['mdzgsum'], 
												 'createtime'=>time(), 
												
                     );
                 //echo '<pre>';
                 //print_r($indata);
                 //exit;
                     $result=pdo_insert($this->modulename."_miandanset",$indata);
                     if(empty($result)){
                       message('添加失败', referer(), 'error');
                     }else{
                       message ( '添加成功!' );
                     }    
                }
             }else{
              if (checksubmit('submit')){
                $id = intval($_GPC['id']);
								$str1 = str_replace("\r\n","<br>",$_GPC['content']);
                $updata=array(              
                       'weid'=>$_W['uniacid'],
                       'mdtype'=>$_GPC['mdtype'],
                       'mdrensum'=>$_GPC['mdrensum'],   
                       'starttime' => strtotime($_GPC['starttime']),
                       'endtime' => strtotime($_GPC['endtime']),
                       'miandanpid'=>$_GPC['miandanpid'], 
                       'mdyaoqingcount'=>$_GPC['mdyaoqingcount'], 
                       'mdyaoqingsum'=>$_GPC['mdyaoqingsum'], 
                       'mdzgcount'=>$_GPC['mdzgcount'], 
											 'content'=>$str1, 
                       'mdzgsum'=>$_GPC['mdzgsum'], 
                       'createtime'=>time(), 
                        
                     );
                if(pdo_update($this->modulename."_miandanset",$updata,array('id'=>$id)) === false){
                       message ( '更新失败' );
                     }else{
                       message ( '更新成功!' );
                     }
               }
             }
     
     		include $this->template ( 'miandanset' );