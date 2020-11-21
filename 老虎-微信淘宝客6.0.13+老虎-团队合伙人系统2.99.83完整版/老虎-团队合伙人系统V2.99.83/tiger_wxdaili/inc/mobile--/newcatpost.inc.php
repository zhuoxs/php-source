<?php
global $_GPC,$_W;
		$cfg = $this->module['config'];
		$weid=$_W['uniacid'];
		$px=$_GPC['px'];
		$zt=$_GPC['zt'];//专题
		$type=$_GPC['type'];
		$tm=$_GPC['tm'];
		$price1=$_GPC['price1'];
		$price2=$_GPC['price2'];
		$hd=$_GPC['hd'];
		$page=$_GPC['page'];
		$key=$_GPC['key'];
		$dlyj=$_GPC['dlyj'];
		$pid=$_GPC['pid'];
		$dluid=$_GPC['dluid'];
		
		
		
		$openid=$_GPC['openid'];
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
        
        $fs=$this->jcbl($share,$bl);
        if(empty($share['dlbl'])){
          $dlbl=$bl['dlbl1'];
        }else{
          $dlbl=$fs['bl'];
        }

        if(empty($share['dlptpid'])){
          $pid=$cfg['ptpid'];
        }else{
          $pid=$share['dlptpid'];
        }
		
		
		
		
		if($cfg['dlmmtype']==2){//云商品库
			include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
		    $list=getcatlist($type,$px,$tm,$price1,$price2,$hd,$page,$key,$dlyj,$pid,$cfg);
            foreach($list['data'] as $k=>$v){
	            	$dlyj=($v['tkrates']*$v['itemendprice']/100);
	                if(!empty($bl['dlkcbl'])){
	                  $dlyj=$dlyj*(100-$bl['dlkcbl'])/100;
	                }
                    $yj=number_format($dlyj*$dlbl/100,2);//代理佣金
                    $list1[$k]['dlyj']=$yj;	 
                    $list1[$k]['itemid']=$v['itemid'];
	                $list1[$k]['itemtitle']=$v['itemtitle'];
	                $list1[$k]['itempic']=$v['itempic'];
	                $list1[$k]['itemendprice']=$v['itemendprice'];
	                $list1[$k]['couponmoney']=$v['couponmoney'];
	                $list1[$k]['itemsale']=$v['itemsale'];
	                $list1[$k]['tkrates']=$v['tkrates'];	                          
            }
		    if(empty($list['data'])){
				$status=2;
			}else{
				$status=1;//有数据
			}
			exit(json_encode(array('status' => $status, 'content' =>$list1,'lm'=>2)));
		}else{//自己采集
			//分词搜索
			if(!empty($_GPC['key'])){
	             include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
	             $arr=getfc($_GPC['key'],$_W);
	            	foreach($arr as $v){
		                 if (empty($v)) continue;
		                $where.=" and itemtitle like '%{$v}%'";
		            }
	        }
	        
	        if(empty($_GPC['px'])){
	          $orde='id desc';
	        }elseif($_GPC['px']==1){
	          $orde='itemsale desc';
	        }elseif($_GPC['px']==2){
	          $orde='itemendprice asc';
	        }elseif($_GPC['px']==3){
	          $orde='tkrates desc';
	        }elseif($_GPC['px']==4){
	          $orde='couponmoney desc';
	        }
	        if(!empty($_GPC['tm'])){
	          $where.=" and shoptype='B'";
	        }
	        if(!empty($_GPC['hd'])){//1聚划算  2淘抢购
	           if($_GPC['hd']==1){
	             $where.=" and activity_type='聚划算'";
	           }elseif($_GPC['hd']==2){
	             $where.=" and activity_type='淘抢购'";
	           }
	        }
	        if(!empty($_GPC['price1'])){
	           $where.=" and itemendprice>".$_GPC['price1'];
	        }
	        if(!empty($_GPC['price2']) and !empty($_GPC['price1'])){
	           $where.=" and itemendprice<".$_GPC['price2'];
	        }
	        if(!empty($_GPC['price2']) and empty($_GPC['price1'])){
	           	$where.=" and itemendprice<".$_GPC['price2'];
	        }
	        if(!empty($zt)){
	        	$where.=" and zt='{$zt}'";
	        }
	        if(!empty($type)){
	        	$where.=" and fqcat='{$type}'";
	        }
	        
	        $day=date("Y/m/d",time());
            $dtime=strtotime($day);
	        
	        $page=$page;
            $pindex = max(1, intval($page));
		    $psize = 30;

            if(!empty($cfg['gyspsj'])){
               $weid=$cfg['gyspsj'];
            }

            $list = pdo_fetchall("select * from ".tablename("tiger_newhu_newtbgoods")." where weid='{$weid}' and couponendtime>={$dtime} {$where} order by {$orde} LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_newtbgoods')." where couponendtime>={$dtime} and  weid='{$weid}' {$where}");
            if(!empty($cfg['gyspsj'])){
               $weid=$cfg['gyspsj'];
            }
            foreach($list as $k=>$v){
	            	$dlyj=($v['tkrates']*$v['itemendprice']/100);
	                if(!empty($bl['dlkcbl'])){
	                  $dlyj=$dlyj*(100-$bl['dlkcbl'])/100;
	                }
                    $yj=number_format($dlyj*$dlbl/100,2);//代理佣金
                    $list1[$k]['dlyj']=$yj;	
                    //$list1[$k]['cs']='测试'.$v['tkrates'].'-2-'.$v['itemendprice'].'3--'.$bl['dlkcbl'].'-4-'.$dlbl;	
                    $list1[$k]['itemid']=$v['itemid'];
	                $list1[$k]['itemtitle']=$v['itemtitle'];
	                $list1[$k]['itempic']=$v['itempic'];
	                $list1[$k]['itemendprice']=$v['itemendprice'];
	                $list1[$k]['couponmoney']=$v['couponmoney'];
	                $list1[$k]['itemsale']=$v['itemsale'];
	                $list1[$k]['tkrates']=$v['tkrates'];
            }
            
            
            
            if(empty($list)){
				$status=2;
			}else{
				$status=1;//有数据
			}
			exit(json_encode(array('status' => $status, 'content' => $list1,'lm'=>0)));
		}
		
?>