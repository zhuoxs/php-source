<?php
global $_W, $_GPC;
         $cfg = $this->module['config'];
         include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
         $str=urldecode($_GPC['str']);
         $pid=$_GPC['pid'];
         
         if(!empty($pid)){
           $pidSplit=explode('_',$pid);
           $cfg['siteid']=$pidSplit[2];
           $cfg['adzoneid']=$pidSplit[3];
           $cfg['ptpid']=$pid;
           $cfg['qqpid']=$pid;
         }
         function fun2($str,$z){
            if (preg_match('/^'.$z.'(\S+)/sim', trim($str), $regs)) {
                $result = $regs[1];
            } 
            return $result;
         }

         

         $ftype=$_GPC['type'];//  1 群   2个人机器人

         $str=str_replace("[emoji=EFBFA5]", "￥", $str);
         //$url="二维码网址";
        // $arr=strstr($str,"找");
         $arr=fun2($str,'找');

          //if($arr!==false){
            if(!empty($arr)){
                //$str=str_replace("找","",$str);
                $str=fun2($str,'找');
                $str=trim($str);
                //关键词查询
                 $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('key'=>$str,'lm'=>1,'pid'=>$pid,'pic_url'=>'')));
                 $ddwz=$this->dwzw($tturl);
                 $newmsg=str_replace('#昵称#',$fans['nickname'], $cfg['newflmsgjqr']);
                 $newmsg=str_replace('#名称#',$str, $newmsg);
                 $newmsg=str_replace('#短网址#',$ddwz, $newmsg);
                 //$newmsg=str_replace('#二维码图片#',$url, $newmsg);
                 exit($newmsg);
                 //关键词查询结束
          }
    
          $arr=fun2($str,'搜索');
           if(!empty($arr)){
                $str=fun2($str,'搜索');
                $str=trim($str);
                //关键词查询
                 $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('key'=>$str,'lm'=>1,'pid'=>$pid,'pic_url'=>'')));
                 $ddwz=$this->dwzw($tturl);
                 $newmsg=str_replace('#昵称#',$fans['nickname'], $cfg['newflmsgjqr']);
                 $newmsg=str_replace('#名称#',$str, $newmsg);
                 $newmsg=str_replace('#短网址#',$ddwz, $newmsg);
                 exit($newmsg);
                 //关键词查询结束
          }

      


         //处理信息
         $ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
         $myck=$ck['data'];
         $tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
         
         
         $geturl=$this->geturl($str);
         //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".$geturl,FILE_APPEND);         
         if(!empty($geturl)){
             $istao=$this->myisexists($geturl);
             if($istao==1){
                $goodid=$this->hqgoodsid($geturl);
                $turl="https://item.taobao.com/item.htm?id=".$goodid;
             }elseif($istao==2){
               $goodid=$this->mygetID($geturl);
               $turl="https://item.taobao.com/item.htm?id=".$goodid;
             }
             
            
             //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".$turl,FILE_APPEND);
             //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".$goodid,FILE_APPEND);
             if(!empty($goodid)){
               //$res=hqyongjin($turl,$myck,$cfg,$this->modulename);//链接  
               $res=hqyongjin($turl,$ck,$cfg,'tiger_newhu','','',$tksign['sign'],$tksign['tbuid'],$_W,2);  
             }    
         }

         function getyouhui2($str){
            preg_match_all('|(￥[^￥]+￥)|ism', $str, $matches);
            return $matches[1][0];
         }
         file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".$str,FILE_APPEND);      

         if(empty($goodid)){//淘口令
           $tkl=getyouhui2($str);
           file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".$tkl,FILE_APPEND);
           if(!empty($tkl)){
             //$res=hqyongjin($turl,$myck,$cfg,$this->modulename,$tkl,1); //淘口令
              $res=hqyongjin($turl,$ck,$cfg,'tiger_newhu',$tkl,1,$tksign['sign'],$tksign['tbuid'],$_W,2); 
           }
         }
         //处理信息结束

        

       if(!empty($res['title'])){
        $str=trim($res['title']);
        //关键词查询
         $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('key'=>$str,'lm'=>1,'pid'=>$pid,'pic_url'=>'')));
         $ddwz=$this->dwzw($tturl);
         $newmsg=str_replace('#昵称#',$fans['nickname'], $cfg['newflmsgjqr']);
         $newmsg=str_replace('#名称#',$str, $newmsg);
         $newmsg=str_replace('#短网址#',$ddwz, $newmsg);
         exit($newmsg);
         //关键词查询结束
       }

        //入库
             if(!empty($res['couponid'])){
                 $data=array(
                         'weid' => $_W['uniacid'],
                         'itemid'=>$res['num_iid'],//商品ID
                         'itemtitle'=>$res['title'],//商品名称
                         'itempic'=>$res['pictUrl'],//主图地址
                         'itemprice'=>$res['price'],//'商品原价', 
                         'itemendprice'=>$res['qhjpric'],//商品价格,券后价
                         'tkrates'=>$res['commissionRate'],//通用佣金
                         'quan_id'=>$res['couponid'],//'优惠券ID',  
                         'couponmoney'=>$res['couponAmount'],//优惠券面额
                         'itemsale'=>$res['biz30day'],//月销售
                         //'taokouling'=>$res['taokouling'],//淘口令
                         //'lxtype'=>$res['qq'],
                         'couponendtime'=>strtotime($res['couponendtime']),//优惠券结束
                         'createtime'=>TIMESTAMP,
                     );
                 //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n123".json_encode($data),FILE_APPEND);
                $this->addtbgoods($data);
             }                     
             //入库结束
         





         

         
         
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
         
          $rhyurl=str_replace("http:","https:",$rhyurl);
          $taokouling=$this->tkl($rhyurl,$res['pictUrl'],$res['title']);
          
          //$taokou=$taokouling->model;
          //settype($taokou, 'string');
          //$taokouling=$taokou;   
           if(!empty($res['dtkl'])){
              if(empty($res['couponAmount'])){
                $erylj=$res['dshortLinkUrl'];
                $res['taokouling']=$res['dtkl'];
              }
            }
            $durl=$this->dwz($rhyurl);//短网址
         
          
          
             $content=array(
                'title'=>$res['title'],//名称
                'price'=>$res['price'],//商品折扣价格
                'zyhhprice'=>$res['zyhhprice'],//优惠后价格
                'zyh'=>$res['zyh'],//优惠金额
                'ehyurl'=>$rhyurl,//二合一链接
                'couponAmount'=>$res['couponAmount'],//优惠券金额
                'flyj'=>number_format($res['flyj'],2),//自购佣金
                'taokouling'=>$taokouling,//淘口令
                'couponid'=>$res['couponid'],//优惠券ID
                'couponendtime'=>$res['couponendtime'],//优惠券到期时间
                'numid'=>$res['numid'],//商品ID
                'pictUrl'=>$res['pictUrl'],
                'qq'=>$res['qq'], //1鹊桥 0定向普通
            );

            if($cfg['fxtype']==1){
              $fxje=round($content['flyj']);
            }else{
              $fxje=$content['flyj'];
            }

            $picurl="http:".$res['pictUrl'];
            $msg=str_replace('#名称#',$content['title'],  $cfg['jqrflmsg']);
            $msg=str_replace('#原价#',$content['price'], $msg);
            $msg=str_replace('#图片#',$picurl, $msg);
            $msg=str_replace('#惠后价#',$content['zyhhprice'], $msg);
            $msg=str_replace('#券后价#',$res['qhjpric'], $msg);

            $msg=str_replace('#总优惠#',$content['zyh'], $msg);
            if(empty($content['couponAmount'])){
              $content['couponAmount']='该商品暂无优惠券';
            }
            $msg=str_replace('#优惠券#',$content['couponAmount'], $msg);
            $msg=str_replace('#返现金额#',$fxje, $msg);
            if($ftype==1){
              $msg.="[lj1]".$rhyurl."[lj2]";
              $msg.="[bt1]".$content['title']."[bt2]";
            }else{
               $msg=str_replace('#淘口令#',$content['taokouling'], $msg);//这里放到软件上面执行
               $msg=str_replace('#短网址#',$durl, $msg);
            }
            
            

            //exit('aaa');
            if(empty($taokouling)){
               //exit(urldecode(json_encode(array('error' =>1, 'content' =>urlencode($res['error'])))));
               exit($res['error']);
            }else{
            //上报日志
            $arr=array(
               'pid'=>$cfg['ptpid'],
               'account'=>"无",
               'mediumType'=>"微信群",
               'mediumName'=>"老虎内部券".rand(10,100),
               'itemId'=>$res['numid'],
               'originUrl'=>"https://item.taobao.com/item.htm?id=".$res['numid'],
               'tbkUrl'=>$rhyurl,
               'itemTitle'=>$content['title'],
               'itemDescription'=>$content['title'],
               'tbCommand'=>$content['taokouling'],
               'extraInfo'=>"无",
            );
            include IA_ROOT . "/addons/tiger_newhu/inc/sdk/taoapi.php"; 
            $resp=getapi($arr);
            //日志结束
               //exit(urldecode(json_encode(array('error' =>0, 'content' => urlencode($msg)))));
               exit($msg);
            }
?>