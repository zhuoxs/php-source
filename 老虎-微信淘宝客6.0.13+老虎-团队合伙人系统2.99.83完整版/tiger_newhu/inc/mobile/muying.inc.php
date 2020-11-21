<?php
global $_W, $_GPC;
       include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php";
       include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
       $cfg = $this->module['config'];
       $key=trim($_GPC['key']);
       $dluid=$_GPC['dluid'];
       $lx=$_GPC['lx'];
       $lm=$_GPC['lm'];
       $tm=$_GPC['tm'];
       $pid=trim($_GPC['pid']);
       $weid=$_W['uniacid'];
			 $MaterialId=trim($_GPC['MaterialId']);
			 if(empty($MaterialId)){
				 $MaterialId=4040;
			 }
			
				if(empty($_GPC['page'])){
					$page=1;
				}else{
					$page=$_GPC['page'];
				}
				
		
		
		 $fans=$this->islogin();
		 $openid=$fans['openid'];   
			if(empty($fans['tkuid'])){
				$fans = mc_oauth_userinfo();  
					$openid=$fans['openid'];     
			}
		 if(!empty($dluid)){
				$share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
			}else{
				
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
			}else{
				 if($share['dlptpid']){
						 if(!empty($share['dlptpid'])){
							 $cfg['ptpid']=$share['dlptpid'];
							 $cfg['qqpid']=$share['dlqqpid'];
						 }
					}
			}
		if(empty($pid)){
				$pid=$cfg['ptpid'];
		}else{
			$cfg['ptpid']=$pid;
		}
		
// 		$url="https://mos.m.taobao.com/taokeapp/20181111yslmappppcjbkgy?pid=".$pid."&cpsrc=tiger_tiger";
// 		$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/qtz/images/dej.jpg";
// 		$title="母婴备孕";
// 		$tkl=$this->tkl($url,$pic,$title);
// 		$tkl=$title.$tkl;


		if ($_W['isajax']){
			$pidSplit=explode('_',$cfg['ptpid']);
			$memberid=$pidSplit[1];
			if(empty($memberid)){
				$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
			}else{
				$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  memberid='{$memberid}'");
			}
			              // $tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
							$goods=qtz($tksign['sign'],$pid,$MaterialId,$page);
//							echo "<pre>";
//   							print_r($goods);
//   							exit;

							foreach($goods['result_list']['map_data'] as $k=>$v){
										$goods=$v;
										if(!empty($goods['coupon_amount'])){
											$conmany=$goods['coupon_amount'];    
										}else{
											$conmany=0;
										}
																	
										 $itemendprice=$goods['zk_final_price']-$conmany;   		
									 $status=1;
									 $list[$k]['itemtitle']=$goods['title'];  //标题
									 		$list[$k]['bfb']=  intval($goods['coupon_remain_count']/$goods['coupon_total_count']*100);
											 $list[$k]['shoptype']=$goods['user_type'];  //1天猫
											 $list[$k]['itemid']=$goods['item_id'];//商品ID
											 $list[$k]['itemprice']=$goods['zk_final_price'];//原价
											 $list[$k]['itemendprice']=$itemendprice;//折扣价-优惠券金额
											 $list[$k]['couponmoney']=$conmany;//优惠券金额
											 $list[$k]['itemsale']=$goods['volume'];//月销量
											 $list[$k]['click_url']=$goods['click_url'];//商品链接转链过的
											 $list[$k]['coupon_click_url']=$goods['coupon_click_url'];//商品链接转链过的
											 $list[$k]['shopTitle']=$goods['shop_title'];//店铺名称                 
											 $list[$k]['itempic']=$goods['pict_url'];//图片
											 $list[$k]['pid']=$pid;
											 $list[$k]['lm']=1;
											 $list[$k]['commission_rate']=$goods['commission_rate'];
					//			                 $ratea=$this->sharejl($itemendprice,$goods['commission_rate']/100,$bl,$share,$cfg);
											 if($cfg['lbratetype']==3){
												$ratea=$this->ptyjjl($itemendprice,$goods['commission_rate']/100,$cfg);
											 }else{
												$ratea=$this->sharejl($itemendprice,$goods['commission_rate']/100,$bl,$share,$cfg);
											 } 
											 $list[$k]['rate']=$ratea;
											 $list[$k]['couponnum']=$goods['coupon_remain_count'];//剩余优惠券数量//用的是总量     
								}
							
								if(empty($list)){
									$pages=0;
								}else{
									$pages=ceil(1000/20);
								}
							
							exit(json_encode(array('pages' =>$pages, 'data' =>$list,'lm'=>1)));
							echo "<pre>";
							print_r($list);
							exit;
		}

 

       include $this->template ( 'zt/muying' );
?>
