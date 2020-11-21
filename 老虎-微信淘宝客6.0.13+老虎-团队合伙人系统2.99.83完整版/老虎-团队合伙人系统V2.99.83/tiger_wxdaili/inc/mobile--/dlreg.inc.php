 <?php
  global $_W, $_GPC;
         $cfg = $this->module['config'];
//         echo "<pre>";
//         print_r($cfg);
//         exit;
         load()->model('mc');         
         $fans=mc_oauth_userinfo();
         if(empty($fans['openid'])){
            echo '请从微信客户端打开！';
            exit;
         }
         $uid=mc_openid2uid($fans['openid']);
         $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
         $member=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");  



          if($_W['isajax']){
              if($bl['dlfftype']==1){
                 exit(json_encode(array('statusCode' =>1100,'msg'=>'代理申请已开通付费模式，请使用付费模式申请')));
              }
              if(empty($member)){
                     $data = array(
                           'weid'=>$_W['uniacid'],
                           'openid'=>$uid,
                           'from_user'=>$fans['openid'],
                           'nickname'=>$fans['nickname'],
                           'avatar'=>$fans['avatar'],
                           'createtime'=>$fans['followtime'],
                           'updatetime'=>$fans['updatetime'],
                           'province'=>$fans['resideprovince'],
                           'city'=>$fans['residecity'],
                           'weixin'=>$_GPC['weixin'],
                           'tel'=>$_GPC['tel'],
                            'tname'=>$_GPC['tname'],
                           'dlmsg'=>$_GPC['dlmsg'],
                         'zfbuid'=>$_GPC['zfbuid'],
                           'dltype' =>2
                           
                       );
                       if(!empty($uid)){
                          $arr=pdo_insert("tiger_newhu_share",$data);
                           if($arr=== false){
                              exit(json_encode(array('statusCode' =>1100,'msg'=>'申请代理失败，请联系管理员1')));
                           }else{
                               //模版消息
                              if(!empty($cfg['dlsqtx'])){//管理员订单提交提醒
                                    $mbid=$cfg['dlsqtx'];
                                    $mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
                                    
                                    $msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,'');                  
                               }
                               //结束
                              exit(json_encode(array('statusCode' => 200,'msg'=>'申请成功，等待审核！')));
                           }
                       }else{
                           exit(json_encode(array('statusCode' =>1100,'msg'=>'会员不存在，代理申请先生成海报')));
                       }
                       
                       
                 }else{
                     $data=array(
                           'weixin'=>$_GPC['weixin'],
                           'tel'=>$_GPC['tel'],
                           'dlmsg'=>$_GPC['dlmsg'],
                         'tname'=>$_GPC['tname'],
                           'dltype' =>2,
                         'zfbuid'=>$_GPC['zfbuid'],
                       );
                      $arr=pdo_update("tiger_newhu_share", $data, array('id' =>$member['id']));
                      if($arr=== false){
                          exit(json_encode(array('statusCode' =>1100,'msg'=>'申请代理失败，请联系管理员1')));
                       }else{
                           //模版消息
                              if(!empty($cfg['dlsqtx'])){//管理员订单提交提醒
                                    $mbid=$cfg['dlsqtx'];
                                    $mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
                                    //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n 1old:".json_encode($cfg['dlsqtx']),FILE_APPEND);
                                    $msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,'');                  
                               }
                               //结束
                          exit(json_encode(array('statusCode' => 200,'msg'=>'申请成功，等待审核！')));
                       }
                 }
                
         }
         
        include $this->template ( 'dlreg' ); 
        ?>