 <?php global $_W, $_GPC;
        $cfg = $this->module['config'];
        $cfg['tkzs']=1;
        $name=urldecode($_GPC['name']);

//        $fans=$_W['fans'];
//        if(empty($fans)){
//          $fans=mc_oauth_userinfo();
//        }
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }	        
        }
        $openid=$fans['openid'];
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        if(empty($share['cqtype'])){                         
           message('功能已关闭！', "../app/index.php?i={$_W['uniacid']}&c=entry&do=index&m=tiger_newhu", 'error');
        }




        $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
        //print_r($share);
        if($share['dlptpid']){
          $cfg['ptpid']=$share['dlptpid'];
          $cfg['qqpid']=$share['dlqqpid'];
        }
        $pidSplit=explode('_',$cfg['ptpid']);
         $cfg['siteid']=$pidSplit[2];
         $cfg['adzoneid']=$pidSplit[3];
//        echo '<pre>';
//        print_r($cfg);
//        exit;
        $tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
        
       
        if(!empty($name)){          
              include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
              include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/notb.php"; 
              //处理信息
             $ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
             $myck=$ck['data'];
             $geturl=$this->geturl($name);
            
             
             if(!empty($geturl)){
                 $istao=$this->myisexists($geturl);
                
                 
                
                 if($istao==1){
                    $goodid=$this->hqgoodsid($geturl);
                      //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n".json_encode($goodid),FILE_APPEND);
                    $turl="https://item.taobao.com/item.htm?id=".$goodid;
                 }elseif($istao==2){
                   $goodid=$this->mygetID($geturl);
                   $turl="https://item.taobao.com/item.htm?id=".$goodid;
                 }
                  
                 if(!empty($goodid)){
                   $res=hqyongjin($turl,$myck,$cfg,'tiger_newhu','','',$tksign['sign'],$tksign['tbuid'],$_W); 
                       if($cfg['yktype']==1){
                            $rhyurl=$res['dcouponLink'];
                            if(empty($rhyurl)){
                               if($res['qq']==1){
                                  $rhyurl=$this->rhy($res['couponid'],$res['numid'],$cfg['qqpid']);
                                }else{
                                  $rhyurl=$this->rhydx($res['couponid'],$res['numid'],$cfg['ptpid']);
                                }
                            }
                         }else{
                              if($res['qq']==1){
                                  $rhyurl=$this->rhy($res['couponid'],$res['numid'],$cfg['qqpid']);
                                }else{
                                  $rhyurl=$this->rhydx($res['couponid'],$res['numid'],$cfg['ptpid']);
                                }
                         }
                 }
                 //echo '1';
             }

            
                  //echo $erylj;
                 // echo '<pre>';
                  //print_r($res);
                 // exit;

                if(empty($goodid)){//淘口令
                   $tkl=$this->getyouhui2($name);
                  // echo $tkl;
                   if(!empty($tkl)){
                     //$res=hqyongjin($turl,$myck,$cfg,'tiger_newhu',$tkl,1); //淘口令
                     $res=hqyongjin($turl,$myck,$cfg,'tiger_newhu',$tkl,1,$tksign['sign'],$tksign['tbuid'],$_W); 
                     if($cfg['yktype']==1){
                        $rhyurl=$res['dcouponLink'];
                        if(empty($rhyurl)){
                           if($res['qq']==1){
                              $rhyurl=$this->rhy($res['couponid'],$res['numid'],$cfg['qqpid']);
                            }else{
                              $rhyurl=$this->rhydx($res['couponid'],$res['numid'],$cfg['ptpid']);
                            }
                        }
                     }else{
                          if($res['qq']==1){
                              $rhyurl=$this->rhy($res['couponid'],$res['numid'],$cfg['qqpid']);
                            }else{
                              $rhyurl=$this->rhydx($res['couponid'],$res['numid'],$cfg['ptpid']);
                            }
                     }
                   }
                 }
                                  
                 
                 //没有开软件
                 if(!empty($res['error'])){
                      //echo '3';
                       $error=$res['error'];
                       $tkl=$this->getyouhui2($name);
                       $res=notiger($turl,$cfg,'tiger_newhu',$tkl,$type);  
                       //echo $geturl;
                       //print_r($res);
                        
                       if(empty($res['num_iid'])){
                          $msg=$res['error'];
                       }else{                              
                            
                             if($res['qq']==1){
                                      $rhyurl=$this->rhy($res['couponid'],$res['numid'],$cfg['qqpid']);
                                    }else{
                                      $rhyurl=$this->rhydx($res['couponid'],$res['numid'],$cfg['ptpid']);
                                    }
                            //t.cn短网址
                            $tcn=$this->dwz($erylj);
                       }
                   
                 }else{
                    
                     if($cfg['yktype']==1){
                        $rhyurl=$res['dcouponLink'];
                        if(empty($rhyurl)){
                             if($res['qq']==1){
                               $rhyurl=$this->rhy($res['couponid'],$res['numid'],$cfg['qqpid']);
                             }else{
                               $rhyurl=$this->rhydx($res['couponid'],$res['numid'],$cfg['ptpid']);
                             } 
                        }
                     }else{
                         if($res['qq']==1){
                           $rhyurl=$this->rhy($res['couponid'],$res['numid'],$cfg['qqpid']);
                         }else{
                           $rhyurl=$this->rhydx($res['couponid'],$res['numid'],$cfg['ptpid']);
                         } 
                     }
                 }
                 //结束

                              
                 
                 
                 
                  $durl=$this->dwz($rhyurl);//短网址
                  $taokouling=$this->tkl($rhyurl,$res['pictUrl'],$res['title']);
                  $taokou=$taokouling->model;
                  settype($taokou, 'string');
                  $taokouling=$taokou;  

                   if(empty($share['dlbl'])){
                      $dlbl=$bl['dlbl1'];
                    }else{
                      $dlbl=$share['dlbl'];
                    }
                  
                  if(!empty($res['pictUrl'])){
                    $picurl="<img src='".$res['pictUrl']."' style='width:150px;height:150px;margin:10px;'>";
                  }
                   if($share['dltype']==1){
                      $dlyj=number_format(($res['commissionRate']*$res['qhjpric']/100)*$dlbl/100,2);//代理佣金
                      if(empty($dlyj)){
                        $dlyj="0";
                      }
                    }else{
                      $dlyj=$res['flyj'];
                      if(empty($dlyj)){
                        $dlyj="0";
                      }
                    }

                   


                                     

                    $msg=str_replace('#名称#',$res['title'],  $cfg['flmsg']);
                    $msg=str_replace('#原价#',$res['price'], $msg);                    
                    //$msg=str_replace('#惠后价#',$res['zyhhprice'], $msg);
                    $msg=str_replace('#券后价#',$res['qhjpric'], $msg);
                    $msg=str_replace('#代理佣金#',$dlyj, $msg);

                    $msg=str_replace('#总优惠#',$res['zyh'], $msg);
                    if(empty($res['couponAmount'])){
                      $res['couponAmount']='0';
                    }
                    $msg=str_replace('#优惠券#',$res['couponAmount'], $msg);
                                       
                    //$msg=str_replace('#返现金额#',$res['flyj'], $msg);
                    $msg=str_replace('#淘口令#',$taokouling, $msg);
                    $msg=str_replace('#短网址#',$durl, $msg);
                    //echo $msg;

                if(!empty($res['error'])){
                   $msg=$res['error'];
                }else{
                   $msg=$msg;
                }

        }



        include $this->template ( 'search' );      
        ?> 