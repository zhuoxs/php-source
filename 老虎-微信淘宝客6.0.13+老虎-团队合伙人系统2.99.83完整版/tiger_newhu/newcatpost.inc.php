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
        $rate=$_GPC['rate'];
		
		if($cfg['mmtype']==2){//云商品库
			include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
		    $list=getcatlist($type,$px,$tm,$price1,$price2,$hd,$page,$key,$dlyj,$pid,$cfg,$rate);
		    if(empty($list['data'])){
				$status=2;
			}else{
				$status=1;//有数据
			}
            $list1=array();
            foreach($list['data'] as $k=>$v){
                            $list1[$k]['itemtitle']=$v['itemtitle'];               			
                            $ratea=($v['itemendprice']*$v['tkrates']/100)*$rate/100;             			
                            $list1[$k]['rate']=number_format($ratea,2,".","");
                            $list1[$k]['weid']=$v['weid'];
                            $list1[$k]['fqcat']=$v['id'];
                            $list1[$k]['zy']=$v['zy'];
                            $list1[$k]['quan_id']=$v['quan_id'];
                            $list1[$k]['itemid']=$v['itemid'];
                            $list1[$k]['itemtitle']=$v['itemtitle'];
                            $list1[$k]['itemshorttitle']=$v['itemshorttitle'];
                            $list1[$k]['itemdesc']=$v['itemdesc'];
                            $list1[$k]['itemprice']=$v['itemprice'];
                            $list1[$k]['itemsale']=$v['itemsale'];
                            $list1[$k]['itemsale2']=$v['itemsale2'];
                            $list1[$k]['conversion_ratio']=$v['conversion_ratio'];
                            $list1[$k]['itempic']=$v['itempic'];
                            $list1[$k]['itemendprice']=$v['itemendprice'];
                            $list1[$k]['shoptype']=$v['shoptype'];
                            $list1[$k]['userid']=$v['userid'];
                            $list1[$k]['sellernick']=$v['sellernick'];
                            $list1[$k]['tktype']=$v['tktype'];
                            $list1[$k]['tkrates']=$v['tkrates'];
                            $list1[$k]['ctrates']=$v['ctrates'];
                            $list1[$k]['cuntao']=$v['cuntao'];
                            $list1[$k]['tkmoney']=$v['tkmoney'];
                            $list1[$k]['tkurl']=$v['tkurl'];
                            $list1[$k]['couponurl']=$v['couponurl'];
                            $list1[$k]['planlink']=$v['planlink'];
                            $list1[$k]['couponmoney']=$v['couponmoney'];
                            $list1[$k]['couponsurplus']=$v['couponsurplus'];
                            $list1[$k]['couponreceive']=$v['couponreceive'];
                            $list1[$k]['couponreceive2']=$v['couponreceive2'];
                            $list1[$k]['couponnum']=$v['couponnum'];
                            $list1[$k]['couponexplain']=$v['couponexplain'];
                            $list1[$k]['couponstarttime']=$v['couponstarttime'];
                            $list1[$k]['couponendtime']=$v['couponendtime'];
                            $list1[$k]['starttime']=$v['starttime'];
                            $list1[$k]['isquality']=$v['isquality']; 
                            $list1[$k]['item_status']=$v['item_status'];
                            $list1[$k]['report_status']=$v['report_status'];
                            $list1[$k]['is_brand']=$v['is_brand'];
                            $list1[$k]['is_live']=$v['is_live'];
                            $list1[$k]['videoid']=$v['videoid'];
                            $list1[$k]['activity_type']=$v['activity_type'];
                            $list1[$k]['createtime']=$v['createtime'];
                
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

            if(!empty($cfg['gyspsj'])){
               $weid=$cfg['gyspsj'];
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
	           }elseif($_GPC['hd']==3){//秒杀
	             $where.=" and tj=1";
	           }elseif($_GPC['hd']==4){//叮咚抢
	             $where.=" and tj=2";
	           }elseif($_GPC['hd']==5){//视频单
	             $where.=" and videoid <>0";
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

            $list = pdo_fetchall("select * from ".tablename($this->modulename."_newtbgoods")." where weid='{$weid}' and couponendtime>={$dtime} {$where} order by {$orde} LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_newtbgoods')." where couponendtime>={$dtime} and  weid='{$weid}' {$where}");
            if(empty($list)){
				$status=2;
			}else{
				$status=1;//有数据
			}
            $list1=array();
            foreach($list as $k=>$v){
                            $list1[$k]['itemtitle']=$v['itemtitle'];               			
                            $ratea=($v['itemendprice']*$v['tkrates']/100)*$rate/100;             			
                            $list1[$k]['rate']=number_format($ratea,2,".","");
                            $list1[$k]['weid']=$v['weid'];
                            $list1[$k]['fqcat']=$v['id'];
                            $list1[$k]['zy']=$v['zy'];
                            $list1[$k]['quan_id']=$v['quan_id'];
                            $list1[$k]['itemid']=$v['itemid'];
                            $list1[$k]['itemtitle']=$v['itemtitle'];
                            $list1[$k]['itemshorttitle']=$v['itemshorttitle'];
                            $list1[$k]['itemdesc']=$v['itemdesc'];
                            $list1[$k]['itemprice']=$v['itemprice'];
                            $list1[$k]['itemsale']=$v['itemsale'];
                            $list1[$k]['itemsale2']=$v['itemsale2'];
                            $list1[$k]['conversion_ratio']=$v['conversion_ratio'];
                            $list1[$k]['itempic']=$v['itempic'];
                            $list1[$k]['itemendprice']=$v['itemendprice'];
                            $list1[$k]['shoptype']=$v['shoptype'];
                            $list1[$k]['userid']=$v['userid'];
                            $list1[$k]['sellernick']=$v['sellernick'];
                            $list1[$k]['tktype']=$v['tktype'];
                            $list1[$k]['tkrates']=$v['tkrates'];
                            $list1[$k]['ctrates']=$v['ctrates'];
                            $list1[$k]['cuntao']=$v['cuntao'];
                            $list1[$k]['tkmoney']=$v['tkmoney'];
                            $list1[$k]['tkurl']=$v['tkurl'];
                            $list1[$k]['couponurl']=$v['couponurl'];
                            $list1[$k]['planlink']=$v['planlink'];
                            $list1[$k]['couponmoney']=$v['couponmoney'];
                            $list1[$k]['couponsurplus']=$v['couponsurplus'];
                            $list1[$k]['couponreceive']=$v['couponreceive'];
                            $list1[$k]['couponreceive2']=$v['couponreceive2'];
                            $list1[$k]['couponnum']=$v['couponnum'];
                            $list1[$k]['couponexplain']=$v['couponexplain'];
                            $list1[$k]['couponstarttime']=$v['couponstarttime'];
                            $list1[$k]['couponendtime']=$v['couponendtime'];
                            $list1[$k]['starttime']=$v['starttime'];
                            $list1[$k]['isquality']=$v['isquality']; 
                            $list1[$k]['item_status']=$v['item_status'];
                            $list1[$k]['report_status']=$v['report_status'];
                            $list1[$k]['is_brand']=$v['is_brand'];
                            $list1[$k]['is_live']=$v['is_live'];
                            $list1[$k]['videoid']=$v['videoid'];
                            $list1[$k]['activity_type']=$v['activity_type'];
                            $list1[$k]['createtime']=$v['createtime'];
                
           }
			exit(json_encode(array('status' => $status, 'content' => $list1,'lm'=>0)));
		}
		
?>