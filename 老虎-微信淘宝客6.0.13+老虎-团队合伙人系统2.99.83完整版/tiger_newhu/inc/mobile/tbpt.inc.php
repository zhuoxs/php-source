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
				 $MaterialId=4071;
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
							//echo "<pre>";
  							//print_r($goods);
  							//exit;

									foreach($goods['result_list']['map_data'] as $k=>$v){
					
												  		
										    	$status=1;
													$list[$k]['itemtitle']=$v['title'];  //标题
													$list[$k]['shoptype']=$v['user_type'];  //1天猫
													$list[$k]['itemid']=$v['item_id'];//商品ID
													$list[$k]['itemsale']=$v['sell_num'];//销量
													$list[$k]['click_url']=base64_encode($v['click_url']);//拼团链接
													$list[$k]['itempic']=$v['pict_url'];//图片
													$list[$k]['pid']=$pid;
													$list[$k]['lm']=1;
													$list[$k]['commission_rate']=$v['commission_rate'];
													
													$list[$k]['jdd_num']=$v['jdd_num'];//几人拼团
													$list[$k]['jdd_price']=$v['jdd_price'];//拼成价
													$list[$k]['orig_price']=$v['orig_price'];//1人价
													
													$list[$k]['ostime']=$v['ostime'];//拼团开始时间
													$list[$k]['oetime']=$v['oetime'];//拼团结束时间
													
													$list[$k]['stock']=$v['stock'];//剩余库存
													$list[$k]['total_stock']=$v['total_stock'];//总库存
																
													
													if($cfg['lbratetype']==3){
														$ratea=$this->ptyjjl($itemendprice,$v['commission_rate']/100,$cfg);
													}else{
														$ratea=$this->sharejl($itemendprice,$v['commission_rate']/100,$bl,$share,$cfg);
													} 
													$list[$k]['rate']=$ratea;
										}
										if(empty($list)){
											$pages=0;
										}else{
											$pages=ceil(1000/20);
										}
									
									exit(json_encode(array('pages' =>$pages, 'data' =>$list,'lm'=>1)));
							
		}

 

       include $this->template ( 'zt/tbpt' );
?>
