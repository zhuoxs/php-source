<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
       include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
       $page=$_GPC['page'];
       $lm=$_GPC['lm'];
       $lx=$_GPC['lx'];
       $tm=$_GPC['tm'];//1
       $pid=$_GPC['pid'];
       $zn=$_GPC['zn'];//1站内
       $weid=$_W['uniacid'];
       if(empty($pid)){
         $pid=$cfg['ptpid'];
       }

       $_GPC['key']=str_replace("[emoji=EFBFBC]","",$_GPC['key']);
       

      // echo "<pre>";
      // print_r($res);
      // exit;
      
      if($zn==1){//站内搜索
	        $key=$_GPC['key'];
	        if($lx==2){
	        	$px=1;//销量
	        }
	        if($lx==4){
	           $px=4;//优惠券
	        }
	        if($lx==3){
	           $px=2;//价格
	        }
	        
	        $page=$page;
	        
            include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
            
		    $list1=getcatlist($type,$px,$tm,$price1,$price2,$hd,$page,$key,$dlyj,$pid,$cfg,$rate);

		    
            foreach($list1['data'] as $k=>$v){
                 $list[$k]['itemtitle']=$v['itemtitle']; //标题
                 $list[$k]['shoptype']=$v['tm'];  //1天猫
                 $list[$k]['itemid']=$v['itemid'];//商品ID
                 $list[$k]['itemprice']=$v['itemprice'];//原价
                 $list[$k]['itemendprice']=$v['itemendprice'];//折扣价-优惠券金额
                 $list[$k]['couponmoney']=$v['couponmoney'];//优惠券金额
                 $list[$k]['itemsale']=$v['itemsale'];//月销量
                 //$list[$k]['url']=$v->auctionUrl;//商品链接
                 //$list[$k]['shopTitle']=$v->shopTitle;//店铺名称                 
                 $list[$k]['itempic']=$v['itempic'];;//图片
                 $list[$k]['pid']=$pid;
                 $list[$k]['lm']=2;
                 $list[$k]['rate']=0;
                 $list[$k]['couponnum']=$v['couponnum'];//剩余优惠券数量//用的是总量                 
            }
           if(empty($list)){
           	 $pages=0;
           }else{
           	$pages=ceil(1000/20);
           }           
           exit(json_encode(array('pages' =>$pages, 'data' =>$list,'lm'=>2)));
      	
      }else{
           	$goods=getgoodslist($_GPC['key'],'',$_W,$page,$cfg,$lx,$tm);
      }     

       $key=$_GPC['key'];
      if(empty($goods)){
         $status=2;
      }else{
            foreach($goods as $k=>$v){
                 $title=str_replace("<span class=H>","",$v->title);
                 $title=str_replace("</span>","",$title);
                 $list[$k]['itemtitle']=$title;  //标题
                 $list[$k]['shoptype']=$v->userType;  //1天猫
                 $list[$k]['itemid']=$v->auctionId;//商品ID
                 $list[$k]['itemprice']=$v->zkPrice;//原价
                 $list[$k]['itemendprice']=$v->zkPrice-$v->couponAmount;//折扣价-优惠券金额
                 $list[$k]['couponmoney']=$v->couponAmount;//优惠券金额
                 $list[$k]['itemsale']=$v->biz30day;//月销量
                 //$list[$k]['url']=$v->auctionUrl;//商品链接
                 //$list[$k]['shopTitle']=$v->shopTitle;//店铺名称                 
                 $list[$k]['itempic']='http:'.$v->pictUrl;//图片
                 $list[$k]['pid']=$pid;
                 $list[$k]['lm']=1;
                 $list[$k]['rate']=0;
                 $list[$k]['couponnum']=$v->couponLeftCount;//剩余优惠券数量//用的是总量                 
           }
           $status=1;
      }

       //file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/log--aaa.txt","\n".json_encode($list),FILE_APPEND);
       //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--aaa.txt","\n".json_encode($status),FILE_APPEND);


      // exit(json_encode(array('pages'=>ceil(100/20),status' => $status,'data' => $list,'lm'=>1)));
      if(empty($list)){
       	 $pages=0;
       }else{
       	$pages=ceil(1000/20);
       }
           
       exit(json_encode(array('pages' =>$pages, 'data' =>$list,'lm'=>1)));
?>