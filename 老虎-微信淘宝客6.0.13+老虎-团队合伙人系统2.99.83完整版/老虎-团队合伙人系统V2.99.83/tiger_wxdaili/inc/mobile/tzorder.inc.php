 <?php
 global $_W, $_GPC;
               
         $id=$_GPC['id'];//share id
         $dd=$_GPC['dd'];
         $zt=$_GPC['zt'];
         $cfg = $this->module['config'];
         load()->model('mc');
//         $fans=mc_oauth_userinfo();
//         $openid=$fans['openid'];
//         if(empty($fans['openid'])){
//            echo '请从微信客户端打开！';
//            exit;
//         }
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
         if(!empty($id)){
           $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$id}'");
         }else{           
           $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
         }

				 $dd=$_GPC['dd'];
				 $page=$_GPC['page'];	

				 if($_W['isajax']){										 
						 if(empty($page)){
							$page=0;					 
						 }
						 $where="";
						 if($dd==1){
								$where=" and orderzt='订单付款'";
						 }elseif($dd==2){
							  $where=" and orderzt='订单结算'";
						 }elseif($dd==3){
							  $where=" and orderzt='订单失效'";
						 }
						 //echo $where;
						 //exit;
						 
						 
						 $pindex = max(1, intval($page));
						 $psize = 20;
						 $list = pdo_fetchall("select * from ".tablename("tiger_newhu_tkorder")."  where tgwid in (select tgwid from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and addtime>'{$share['tztime']}' and dltype=1 and helpid='{$share['id']}') and weid='{$_W['uniacid']}' {$where}  limit ".($pindex - 1) * $psize . ",{$psize}");
//               echo "<pre>";
// 							print_r($list);
// 							exit;
// 						 
						 $total = pdo_fetchcolumn("select COUNT(id) from ".tablename("tiger_newhu_tkorder")."  where tgwid in (select tgwid from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and addtime>'{$share['tztime']}' and dltype=1 and helpid='{$share['id']}')  {$where}  and weid='{$_W['uniacid']}'");
						 
						 $pages=$total/20;
						 $appset= pdo_fetch("SELECT * FROM " . tablename("tiger_app_tuanzhangset") . " WHERE weid='{$_W['uniacid']}' order by px desc ");//团长设置
						 foreach($list as $k=>$v){
							  $pic=$this->gettaopic($v['numid']);
							  $fhyg=$v['xgyg']*$appset['jl']/100;
							  $list1[$k]['id']=$v['id'];
								$list1[$k]['numid']=$v['numid'];
								$list1[$k]['shopname']=$v['shopname'];
								$list1[$k]['title']=$v['title'];
								$list1[$k]['orderzt']=$v['orderzt'];
								$list1[$k]['fkprice']=number_format($v['fkprice'], 2, '.', '');
								$list1[$k]['xgyg']=$v['xgyg'];
								$list1[$k]['fhyg']=number_format($fhyg, 2, '.', '');
								$list1[$k]['addtime']=date('Y-m-d',$v['addtime']);
								if($v['jstime']){
									$list1[$k]['jstime']=date('Y-m-d',$v['jstime']);
								}else{
									$list1[$k]['jstime']=$v['jstime'];
								}
								
								$list1[$k]['mttitle']=$v['mttitle'];
								$list1[$k]['tgwid']=$v['tgwid'];
								$list1[$k]['orderid']=$v['orderid'];
								$list1[$k]['createtime']=date('Y-m-d H:i:s',$v['createtime']);
								$list1[$k]['pic']=$pic;
						 }
						 
						 
						 exit(json_encode(array('status' =>0,'data'=>$list1,'pages'=>$pages)));
						 
			 }
				 
				 
				
				 
// 				 echo "<pre>";
// 				 print_r($list);
// 				 exit;
				 
				 // $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_newtbgoods')." where couponendtime>={$dtime} and  weid='{$weid}' {$where}");
				 
				 
         
        // {"error":0,"message":""}
         include $this->template ( 'tz/tzorder' );    
         ?>