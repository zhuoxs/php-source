<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
       $dluid=$_GPC['dluid'];//share id
       $fans=$_W['fans'];
       $fans['city']=$fans['tag']['city'];
       $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();        
        }
       $mc = mc_credit_fetch($fans['uid']);

         

       
        
       if(empty($fans['openid'])){
         echo '请从微信浏览器中打开！';
         exit;
       }
       
       if(!empty($dluid)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
        }else{
          $fans=mc_oauth_userinfo();
          
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
        $appid=$_W['uniaccount']['key'];
        setcookie('user_token', $appid);
        setcookie('user_nickname', urlencode($fans['nickname']));
        setcookie('user_openid', $fans['openid']);
       
       $fans['credit1']=$mc['credit1'];
       //$fans['avatar']=$fans['headimgurl'];
       //$fans['nickname'] =$fans['tag']['nickname'];
       
//     echo '<pre>';
//       print_r($fans);
//       exit;

       if($cfg['zblive']==1){
          $qf="and qf=1";
        }else{
          $qf='';
        }

        $weid=$_W['uniacid'];
        if(!empty($cfg['gyspsj'])){
          $weid=$cfg['gyspsj'];
        }


        $goodsArr = pdo_fetchall("select * from ".tablename($this->modulename."_newtbgoods")." where weid='{$weid}' {$qf} order by id desc LIMIT 6");
        $time = date('H:i');
        $goods = '';
        
//      echo "<pre>";
//      	print_r($goodsArr);
//      	exit;

        foreach($goodsArr as $k=>$v){
            $goods.='<div class="goods-box">';
                $goods.='<div class="publishTime">'.$time.'</div>';
                $goods.='<div class="contentImg">';
                   
                   if(!empty($cfg['zbtouxiang'])){
                        $goods.='<img class="headPic" src="'.tomedia($cfg['zbtouxiang']).'" />';    
                   }else{
                        $goods.='<img class="headPic" src="../addons/tiger_newhu/template/mobile/live/images/touxiang-1.jpg" />'; 
                    }
                    $goods.='<a href="'.$this->createMobileUrl('view',array('itemid'=>$v['itemid'],'dluid'=>$dluid)).'"><img class="conPic" src="'.$v["itempic"].'" /></a>';
                $goods.='</div>';
                $goods.='<div class="contents">';
                    $goods.='<img class="triangle" src="../addons/tiger_newhu/template/mobile/live/images/triangle.png" />';
                    if(!empty($cfg['zbtouxiang'])){
                        $goods.='<img class="headPic" src="'.tomedia($cfg['zbtouxiang']).'" />';    
                   }else{
                        $goods.='<img class="headPic" src="../addons/tiger_newhu/template/mobile/live/images/touxiang-1.jpg" />'; 
                    }
                    $goods.='<p>'.$v["itemtitle"].'原价：'.$v["itemprice"].'元<span style="text-decoration:underline">【券后仅需'.$v["itemendprice"].'元】</span><br/><span style="font-weight:bold">推荐理由：</span>'.$v["itemdesc"].'</p>';
                    $goods.='<div class="purchase">';
                        $goods.='<a href="'.$this->createMobileUrl('view',array('itemid'=>$v['itemid'],'dluid'=>$dluid)).'">';
                            $goods.='<div class="buy">领券购买</div>';
                        $goods.='</a>';
                        $goods.='<div class="num"><span style="display:none">'.$v["id"].'</span></div>';
                    $goods.='</div>';
                $goods.='</div>';
            $goods.='</div>';
        }
//        echo '<pre>';
//       print_r($fans);
//       exit;

       include $this->template ( 'live/index' );