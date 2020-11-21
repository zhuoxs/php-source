<?php
global $_W, $_GPC;
        $page=$_GPC['page'];
        $cfg = $this->module['config'];
        $dtkAppKey=$cfg['dtkAppKey'];
        if(empty($page)){
          $page=1;
        }


        if(!empty($cfg['gyspsj'])){
          echo "使用共用库不能采集";
          exit;
        }

        $op=$_GPC['op'];
        if($op=='dtkcj'){//软件采集
            $url = "http://api.dataoke.com/index.php?r=Port/index&type=total&appkey={$dtkAppKey}&v=2&page={$page}";
            $content=$this->curl_request($url);     
            $userInfo = @json_decode($content, true);
            $dtklist=$userInfo['result'];

            //print_r($dtklist);
            if($userInfo['data']['total_num']==0){
               //message ( '本页暂无商品可同步', $this->createWebUrl ( 'dtkcaiji' ),'error');
               echo "本页暂无商品可同步";
            }
            
            foreach($dtklist as $k=>$v){
                $fztype=pdo_fetch("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}' and dtkcid='{$v['Cid']}' order by id desc");

                if($v['Commission_queqiao']!='0.00'){//鹊桥
                   $lxtype='鹊桥活动';
                   $yjbl=$v['Commission_queqiao'];
                }elseif($v['Commission_jihua']!='0.00'){//定向
                  $lxtype='营销计划';
                  $yjbl=$v['Commission_jihua'];
                }else{
                  $lxtype='通用计划';
                  $yjbl=$v['Commission_jihua'];
                }
                if($v['IsTmall']==1){
                	$shoptype='B';
                }else{
                	$shoptype='C';
                }
                
                // var_dump($taokou);
                // exit;

                 $item = array(
                         'weid' => $_W['uniacid'],
                         'fqcat'=>$fztype['id'],
                         'zy'=>1,
                         'tktype'=>$lxtype,
                         'itemid'=>$v['GoodsID'],//商品ID
                         'itemtitle'=>$v['Title'],//商品名称
                         'itemdesc'=>$v['Introduce'],//推荐内容
                         'itempic'=>$v['Pic'],//主图地址
                         'itemendprice'=>$v['Price'],//商品价格,券后价
                         'itemsale'=>$v['Sales_num'],//月销售
                         'tkrates'=>$yjbl,//通用佣金比例
                          'couponreceive'=>$v['Quan_receive'],//优惠券总量已领取数量
                          'couponsurplus'=>$v['Quan_surplus'],//优惠券剩余
                          'couponmoney'=>$v['Quan_price'],//优惠券面额
                          'couponendtime'=>strtotime($v['Quan_time']),//优惠券结束
                          'couponurl'=>$v['Quan_link'],//优惠券链接
                          'shoptype'=>$shoptype,//'0不是  1是天猫',
                          'quan_id'=>$v['Quan_id'],//'优惠券ID',  
                          'couponexplain'=>$v['Quan_condition'],//'优惠券使用条件',  
                          'itemprice'=>$v['Org_Price'],//'商品原价', 
                          'tkurl'=>$v['Jihua_link'],
                          'createtime'=>TIMESTAMP,
                        );
                          
                       $go = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and  itemid='{$v['GoodsID']}' ORDER BY id desc");
                        if(empty($go)){
                          pdo_insert($this->modulename."_newtbgoods",$item);
                        }else{
                          pdo_update($this->modulename."_newtbgoods", $item, array('weid'=>$_W['uniacid'],'itemid' => $v['GoodsID']));
                        }  
                         echo "大淘客--第".++$k."条数据采集成功<br>";
                       
            }
            echo "采集成功";
        
        }