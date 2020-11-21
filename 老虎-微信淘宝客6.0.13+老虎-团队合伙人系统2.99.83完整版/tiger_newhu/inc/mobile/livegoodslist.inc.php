<?php
        global $_W, $_GPC;
        $cfg = $this->module['config'];
        $typeid=$_GPC['typeid'];
        $dluid=$_GPC['dluid'];//share id
        $pid=$_GPC['pid'];
        $weid=$_W['uniacid'];
        $from_id=$_GPC['from_id'];
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/log.txt","\nfrom_id:".json_encode($from_id),FILE_APPEND);
        if($cfg['zblive']==1){
          $qf="and qf=1";
        }else{
          $qf='';
        }

        $weid=$_W['uniacid'];
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();	        
        }
        
        if(!empty($dluid)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
        }else{
         // $fans=mc_oauth_userinfo();
          
          $openid=$fans['openid'];
          $zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        }
        if($zxshare['dltype']==1){
            if(!empty($zxshare['dlptpid'])){
               $cfg['ptpid']=$zxshare['dlptpid'];
               $cfg['qqpid']=$zxshare['dlqqpid'];
            }
            
        }else{
           if(!empty($zxshare['helpid'])){//查询有没有上级
                 $sjshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and id='{$zxshare['helpid']}'");           
            }
        }
        

        if(!empty($sjshare['dlptpid'])){
            if(!empty($sjshare['dlptpid'])){
              $cfg['ptpid']=$sjshare['dlptpid'];
              $cfg['qqpid']=$sjshare['dlqqpid'];
            }   
            $dlewm="http://pan.baidu.com/share/qrcode?w=150&h=150&url=".$sjshare['url'];
        }else{
           if($share['dlptpid']){
               if(!empty($share['dlptpid'])){
                 $cfg['ptpid']=$share['dlptpid'];
                 $cfg['qqpid']=$share['dlqqpid'];
               }       
               $dlewm="http://pan.baidu.com/share/qrcode?w=150&h=150&url=".$share['url'];
            }
        }
        if(empty($pid)){
        	$pid=$cfg['ptpid'];
	    }else{
	    	$cfg['ptpid']=$pid;
	    }
        
        
		
        $goodsArr = pdo_fetchall("select * from ".tablename($this->modulename."_newtbgoods")." where id < {$from_id} and weid='{$weid}' {$qf} order by id desc LIMIT 1");

        $time = date('H:i');
        $goods = '';

        for ($i = 0; $i < count($goodsArr); $i++) {
            $goods.='<div class="goods-box">';
                $goods.='<div class="publishTime">'.$time.'</div>';
                $goods.='<div class="contentImg">';
                    if(!empty($cfg['zbtouxiang'])){
                        $goods.='<img class="headPic" src="'.tomedia($cfg['zbtouxiang']).'" />';    
                   }else{
                        $goods.='<img class="headPic" src="../addons/tiger_newhu/template/mobile/live/images/touxiang-1.jpg" />'; 
                    }
                    $goods.='<a href="'.$this->createMobileUrl("view",array("itemid"=>$goodsArr[$i]["itemid"],"dluid"=>$dluid,"lm"=>0)).'"><img class="conPic" src="'.$goodsArr[$i]["itempic"].'" /></a>';
                $goods.='</div>';
                $goods.='<div class="contents">';
                    $goods.='<img class="triangle" src="../addons/tiger_newhu/template/mobile/live/images/triangle.png" />';
                    if(!empty($cfg['zbtouxiang'])){
                        $goods.='<img class="headPic" src="'.tomedia($cfg['zbtouxiang']).'" />';    
                   }else{
                        $goods.='<img class="headPic" src="../addons/tiger_newhu/template/mobile/live/images/touxiang-1.jpg" />'; 
                    }
                    $goods.='<p>'.$goodsArr[$i]["itemtitle"].'原价：'.$goodsArr[$i]["itemprice"].'元<span style="text-decoration:underline">【券后仅需'.$goodsArr[$i]["itemendprice"].'元】</span><br/><span style="font-weight:bold">推荐理由：</span>'.$goodsArr[$i]["itemdesc"].'</p>';
                    $goods.='<div class="purchase">';
                        $goods.='<a href="'.$this->createMobileUrl("view",array("itemid"=>$goodsArr[$i]["itemid"],"dluid"=>$dluid,"lm"=>0)).'">';
                            $goods.='<div class="buy">领券购买</div>';
                        $goods.='</a>';
                        $goods.='<div class="num"><span style="display:none">'.$goodsArr[$i]["id"].'</span></div>';
                    $goods.='</div>';
                $goods.='</div>';
            $goods.='</div>';
            $arr[]=$goods;
            $goods='';
        }


        exit(json_encode($arr,JSON_UNESCAPED_UNICODE));

