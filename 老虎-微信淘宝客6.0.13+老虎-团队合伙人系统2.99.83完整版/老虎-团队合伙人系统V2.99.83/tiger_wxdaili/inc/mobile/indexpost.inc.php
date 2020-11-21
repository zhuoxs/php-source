 <?php
 global $_W, $_GPC;
       $cfg = $this->module['config'];

        $openid=$_GPC['openid'];
        $dd=$_GPC['dd'];
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        $tgwarr=explode('|',$share['tgwid']);
        
        $where='';
        if(!empty($share['tgwid'])){
           $where .="and (";
           foreach($tgwarr as $k=>$v){
               $where .=" tgwid=".$v." or ";
           }
           $where .="tgwid=".$tgwarr[0].")";
        }else{
          $where .=" and tgwid=111111";
        }

        $day=date('Y-m-d');
        $day=strtotime($day);//今天0点时间戳    
        
        if($dd==1){
            $dlwhere.=" and addtime>{$day}";        
        }
        if($dd==3){
            $day3=strtotime(date("Y-m-d",strtotime("-2 day")));//3天时间
            $dlwhere.=" and addtime>{$day3}";        
        }
        if($dd==7){
            $day7=strtotime(date("Y-m-d",strtotime("-6 day")));//7天时间
            $dlwhere.=" and addtime>{$day7}";        
        }

        


        $pindex = max(1, intval($_GPC['limit']));
		$psize = 20;
        $list1 = pdo_fetchall("select * from ".tablename("tiger_newhu_tkorder")." where weid='{$_W['uniacid']}' {$dlwhere} {$where}   order by addtime desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' {$dlwhere} {$where} ");
		$pager = pagination($total, $pindex, $psize);


         foreach ($list1 as $key => $value) {
               if($cfg['fytype']==1){
                  $dlyj=number_format($value['fkprice']*$share['dlbl']/100,2);  
                }else{
                  $dlyj=number_format($value['xgyg']*$share['dlbl']/100,2);  
                }
           $list[$key]['title'] = $value['title'];
           $list[$key]['numid'] = $value['numid'];
           $list[$key]['xgyg'] = $value['xgyg'];
           $list[$key]['orderzt'] = $value['orderzt'];
           $list[$key]['tgwid'] = $value['tgwid'];
           $list[$key]['fkprice'] = $value['fkprice'];
           $list[$key]['createtime'] = date('Y-m-d H:i:s',$value['createtime']);
           $list[$key]['addtime'] =date('Y-m-d H:i:s',$value['addtime']);
           $list[$key]['dlyj'] =$dlyj;       
         }

        if (!empty($list)){
            $status=1;
        }else{
            $status=2;
        }

        exit(json_encode(array('status' => $status, 'content' => $list)));
        ?>
