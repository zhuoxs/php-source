<?php
 global $_W, $_GPC;
         $openid=$_GPC['openid'];
         $fans=pdo_fetch("select m.uid,m.nickname,m.avatar,f.openid,m.uid,f.followtime,f.follow,m.resideprovince,m.residecity,m.gender from ".tablename('mc_members')." m inner join ".tablename('mc_mapping_fans')." f on m.uid=f.uid and f.openid='{$openid}' and f.uniacid='{$_W['uniacid']}'");

         $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
				 
				 $tbuidlist=pdo_fetchall("select * from ".tablename('tiger_newhu_tksign')." where weid='{$_W['uniacid']}'");
// 				              echo '<pre>';
// 				              print_r($tbuidlist);
// 				              exit;


         if (checksubmit('submit')){
             $dltype=$_GPC['dltype'];
             if($dltype==3){
             	$dltype=0;
             }
             $tgwid=$_GPC['tgwid'];
             $dlbl=$_GPC['dlbl'];
             $dlqqpid=$_GPC['dlqqpid'];
             $dlptpid=$_GPC['dlptpid'];
             $dlpddpid=$_GPC['pddpid'];
             $dljdpid=$_GPC['jdpid'];
//             echo '<pre>';
//             print_r($share);
//             exit;
           
           if(empty($share)){
               $data = array(
                   'weid'=>$_W['uniacid'],
                   'tztype'=>$_GPC['tztype'],
									 'openid'=>$fans['uid'],
                   'from_user'=>$openid,
                   'nickname'=>$fans['nickname'],
                   'avatar'=>$fans['avatar'],
                   'createtime'=>$fans['followtime'],
                   'updatetime'=>$fans['updatetime'],
                   'province'=>$fans['resideprovince'],
                   'city'=>$fans['residecity'],
                   'tel'=>$_GPC['tel'],
                   'weixin'=>$_GPC['weixin'],
                   'helpid'=>$_GPC['helpid'],
                   'zfbuid'=>$_GPC['zfbuid'],
                   'qdid'=>$_GPC['qdid'],
                   'tname'=>$_GPC['tname'],
                   'qunname'=>$_GPC['qunname'],
                   'dlmsg'=>$_GPC['dlmsg'],
                   'cqtype'=>$_GPC['cqtype'],
                   'pddpid'=>trim($dlpddpid),
                   'jdpid'=>trim($dljdpid),


                   'dltype' =>$dltype,
                   'tgwid' =>trim($tgwid),
                   'dlbl'=>$dlbl,
                       'dlbl2'=>$_GPC['dlbl2'],
                   'dlqqpid'=>trim($dlqqpid),
                   'dlptpid'=>trim($dlptpid),
                   
                   'dlptpid'=>trim($dlptpid),
                   
                       'pctitle'=>$_GPC['pctitle'],
                       'pckeywords'=>$_GPC['pckeywords'],
                       'pcdescription'=>$_GPC['pcdescription'],
                       'pcewm1'=>$_GPC['pcewm1'],
                       'pcewm2'=>$_GPC['pcewm2'],
                       'pcbottom1'=>$_GPC['pcbottom1'],
                       'pcbottom2'=>$_GPC['pcbottom2'],
                       'pclogo'=>$_GPC['pclogo'],
                       'pcsearchkey'=>$_GPC['pcsearchkey'],
                       'pcuser'=>$_GPC['pcuser'],
                       'pcpasswords'=>$_GPC['pcpasswords'],
                       'pcurl'=>$_GPC['pcurl'],
                       'tztime'=>strtotime($_GPC['tztime']),
                       'tzendtime'=>strtotime($_GPC['tzendtime']),
                       

               );
               $arr=pdo_insert("tiger_newhu_share",$data);
               if($arr=== false){
                 message ("设置代理失败");
               }else{
                    //模版消息
                  if($_GPC['dltype']==1 || $_GPC['dltype']==3){
//                    if(empty($tgwid)){
//                       message ("推广位必须填写！");
//                    }
                     $cfg=$this->module['config'];
                      if(!empty($cfg['dlshtgtx'])){//管理员订单提交提醒
                            $mbid=$cfg['dlshtgtx'];
                            $mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
                            //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n 1old:".json_encode($cfg['dlsqtx']),FILE_APPEND);
                            $valuedata=array(
															 'rmb'=>'',
															 'txzhanghao'=>'',//提现支付帐帐号
															 'dlmsg'=>$share['dlmsg'],//申请理由
															 'tname'=>$share['tname'],//申请人姓名
															 'dlsqjj'=>$_GPC['glymsg'],//代理申请拒绝原因
															 'tel'=>$share['tel'],
															 'weixin'=>$share['weixin'],
															 'shenhe'=>'',//'审核通过|审核不通过|资料有误请重新提交审核',
															 'goodstitle'=>''//'积分商城，商品名称'
													 );
                            $msg=$this->mbmsg($openid,$mb,$mb['mbid'],$mb['turl'],$fans,'');                  
                       }
                  }                  
                   //结束
									
									//更新PID状态
									if(!empty($dlptpid)){
										$ispid = pdo_fetch("SELECT * FROM " . tablename("tiger_wxdaili_tkpid") . " WHERE pid='{$dlptpid}'");
										if(empty($ispid)){
											 $indata=array(
													'weid'=>$_W['uniacid'], 
													'type'=>1,//1已分配
													'nickname'=>$share['nickname'],
													'uid'=>$share['id'],
													'pid'=>$dlptpid,
													'tgwname'=>'',
													'fptime'=>time(),
													'tbuid'=>$_GPC['tbuid'],
													'createtime'=>time(),
											 );
											 $res=pdo_insert("tiger_wxdaili_tkpid", $indata);
											 if (!empty($res)) {												  
													pdo_update("tiger_newhu_share", array('tbkpidtype'=>1,'tbuid'=>$_GPC['tbuid']), array('id' =>$share['id']));
											 }
										}else{
											$res=pdo_update("tiger_wxdaili_tkpid", array('nickname'=>$share['nickname'],'uid'=>$share['id'],'type'=>1,'createtime'=>time(),'tbuid'=>$_GPC['tbuid']), array('pid' =>$dlptpid));
											pdo_update("tiger_newhu_share", array('tbkpidtype'=>1,'tbuid'=>$_GPC['tbuid']), array('id' =>$share['id']));
										}
									}
									//状态更新结束
									 
									 
                 message('代理设置成功！', $this -> createWebUrl('dlmember', array('op' => 'display','dl'=>$_GPC['dl'],'page'=>$_GPC['page'])), 'success');
               }
             
           }else{
               $data = array(
							     'tztype'=>$_GPC['tztype'],
                   'tel'=>$_GPC['tel'],
                   'weixin'=>$_GPC['weixin'],
                   'dltype' =>$dltype,
                   'tgwid' =>$tgwid,
                   'dlbl'=>$dlbl,
                   'dlbl2'=>$_GPC['dlbl2'],
                   'dlqqpid'=>$dlqqpid,
                   'dlptpid'=>$dlptpid,
                   'pctitle'=>$_GPC['pctitle'],
                   'helpid'=>$_GPC['helpid'],
                       'pctitle'=>$_GPC['pctitle'],
                       'pckeywords'=>$_GPC['pckeywords'],
                       'pcdescription'=>$_GPC['pcdescription'],
                       'pcewm1'=>$_GPC['pcewm1'],
                       'pcewm2'=>$_GPC['pcewm2'],
                       'pcbottom1'=>$_GPC['pcbottom1'],
                       'pcbottom2'=>$_GPC['pcbottom2'],
                       'pclogo'=>$_GPC['pclogo'],
                       'pcsearchkey'=>$_GPC['pcsearchkey'],
                       'pcuser'=>$_GPC['pcuser'],
                       'pcpasswords'=>$_GPC['pcpasswords'],
                       'pcurl'=>$_GPC['pcurl'],
                   'zfbuid'=>$_GPC['zfbuid'],
                   'tname'=>$_GPC['tname'],
                   'qunname'=>$_GPC['qunname'],
                   'dlmsg'=>$_GPC['dlmsg'],
                   'qdid'=>$_GPC['qdid'],
                   'pddpid'=>trim($dlpddpid),
                   'jdpid'=>trim($dljdpid),
                   'cqtype'=>$_GPC['cqtype'],
                   'tztime'=>strtotime($_GPC['tztime']),
                    'tzendtime'=>strtotime($_GPC['tzendtime']),
               );
               $arr=pdo_update("tiger_newhu_share", $data, array('from_user' => $openid,'weid'=>$_W['uniacid']));
                if($arr=== false){
                 message ("设置代理失败");
               }else{
                  //模版消息
                  if($dltype==1 || $_GPC['dltype']){
//                    if(empty($tgwid)){
//                       message ("推广位必须填写！");
//                    }
                     $cfg=$this->module['config'];
                      if(!empty($cfg['dlshtgtx'])){//管理员订单提交提醒
                            $mbid=$cfg['dlshtgtx'];
                            $mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
                            //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n 1old:".json_encode($cfg['dlsqtx']),FILE_APPEND);
                            $valuedata=array(
					             'rmb'=>'',
					             'txzhanghao'=>'',//提现支付帐帐号
					             'dlmsg'=>$share['dlmsg'],//申请理由
					             'tname'=>$share['tname'],//申请人姓名
					             'dlsqjj'=>$_GPC['glymsg'],//代理申请拒绝原因
					             'tel'=>$share['tel'],
					             'weixin'=>$share['weixin'],
					             'shenhe'=>'',//'审核通过|审核不通过|资料有误请重新提交审核',
					             'goodstitle'=>''//'积分商城，商品名称'
					         );
                            $msg=$this->mbmsg($openid,$mb,$mb['mbid'],$mb['turl'],$fans,'',$cfg,$valuedata);                  
                       }
                  }                  
                   //结束
									 
									 //更新PID状态
									 if(!empty($dlptpid)){
									 	$ispid = pdo_fetch("SELECT * FROM " . tablename("tiger_wxdaili_tkpid") . " WHERE pid='{$dlptpid}'");
									 	if(empty($ispid)){
									 		$indata=array(
									 				'weid'=>$_W['uniacid'], 
									 				'type'=>1,//1已分配
									 				'nickname'=>$share['nickname'],
									 				'uid'=>$share['id'],
									 				'pid'=>$dlptpid,
									 				'tgwname'=>'',
									 				'fptime'=>time(),
									 				'tbuid'=>$_GPC['tbuid'],
									 				'createtime'=>time(),
									 		);
									 		$res=pdo_insert("tiger_wxdaili_tkpid", $indata);
									 		if (!empty($res)) {												  
									 				pdo_update("tiger_newhu_share", array('tbkpidtype'=>1,'tbuid'=>$_GPC['tbuid']), array('id' =>$share['id']));
									 		}
									 	}else{
									 		$res=pdo_update("tiger_wxdaili_tkpid", array('nickname'=>$share['nickname'],'uid'=>$share['id'],'type'=>1,'createtime'=>time(),'tbuid'=>$_GPC['tbuid']), array('pid' =>$dlptpid));
									 		$res2=pdo_update("tiger_newhu_share", array('tbkpidtype'=>1,'tbuid'=>$_GPC['tbuid']), array('id' =>$share['id']));
// 											echo "<pre>";
// 											print_r($_GPC);
// 											print_r($share);
// 											echo $res2."----".$res."---".$_GPC['tbuid'];
// 											exit;
									 	}
									 }
									 //状态更新结束
                 message('代理设置成功！', $this -> createWebUrl('dlmember', array('op' => 'display','dl'=>$_GPC['dl'],'page'=>$_GPC['page'])), 'success');
               }
           }
       }        

         include $this->template ( 'memberedit' );    
?>