 <?php
global $_W, $_GPC;
         $helpid=$_GPC['id'];
         $cfg = $this->module['config'];
         $fans=$this->islogin();
		    if(empty($fans['tkuid'])){
		        	$fans = mc_oauth_userinfo();
			        if(empty($fans)){
						$tktzurl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
						 $loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
						 header("Location: ".$loginurl); 
						 exit;
			        }
			        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");   
			        $fans['tkuid']=$share['id'];  	        
			}
		    
		    $wquid=mc_openid2uid($fans['openid']);
		    $helpid=$_GPC['helpid'];
		    $share=$this->getmember($fans,$wquid,$helpid);
		    
         $member=pdo_fetchall("select id,nickname,tgwid,avatar,helpid,createtime from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1");
         
		$sharelist=GetTeamMember($member,$share['id']);
         

         $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
         
         
         
				 
         if($hshare['dltype']<>1){
//               $url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl("dlreg",array('dluid'=>$dluid)));
//               header("location:".$url);
//               exit;
         }
          // 本月起始时间:
					
		$appset= pdo_fetch("SELECT * FROM " . tablename("tiger_app_tuanzhangset") . " WHERE weid='{$_W['uniacid']}' order by px desc ");//团长设置
          foreach($sharelist as $k=>$v){       
				 $ddorder = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and tgwid='{$v['tgwid']}' and addtime>'{$share['tztime']}'");
// 								 echo $_W['uniacid']."<br>";
// 								 echo $v['tgwid']."<br>";
// 								 print_r($ddorder);
// 								 exit;
				 //print_r($ddorder);
				 
				 $yjorder = pdo_fetchcolumn("SELECT sum(xgyg) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and tgwid='{$v['tgwid']}' and addtime>'{$share['tztime']}'");
				 $yjorder=$yjorder*$appset['jl']/100;
				 $list[$k]['avatar']=$v['avatar'];  
                 $list[$k]['createtime']=$v['createtime'];  
								 $list[$k]['nickname']=$v['nickname']; 
                 $list[$k]['ddorder']=$ddorder;
                 $list[$k]['fkyj']=number_format($yjorder, 2, '.', '');
                 $list[$k]['id']=$v['id'];
          }
					
					// $tdcount = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and helpid='{$helpid}'");
// 					echo "<pre>";
// 					print_r($list);
					//exit;
					
		/*
		*2.获取某个会员的无限下级方法
		*$members是所有会员数据表,$mid是用户的id
		*/
		function GetTeamMember($members, $mid) {
			$Teams=array();//最终结果
			$shareteam=array();
			$mids=array($mid);//第一次执行时候的用户id
			do {
				$othermids=array(); 
				$state=false;
				foreach ($mids as $valueone) {
					foreach ($members as $key => $valuetwo) {
						if($valuetwo['helpid']==$valueone){
							$shareteam['id']=$valuetwo[id];
							$shareteam['nickname']=$valuetwo['nickname'];
							$shareteam['createtime']=$valuetwo['createtime'];
							$shareteam['tgwid']=$valuetwo['tgwid'];
							$shareteam['avatar']=$valuetwo['avatar'];
							$Teams[]=$shareteam;//$valuetwo[id];//找到我的下级立即添加到最终结果中
							$othermids[]=$valuetwo['id'];//将我的下级id保存起来用来下轮循环他的下级
							array_splice($members,$key,1);//从所有会员中删除他
							$state=true;	
						}
					}			
				}
				$mids=$othermids;//foreach中找到的我的下级集合,用来下次循环
			} while ($state==true);
		 
			return $Teams;
		}

        include $this->template ( 'tz/tzfans' );  
        ?>