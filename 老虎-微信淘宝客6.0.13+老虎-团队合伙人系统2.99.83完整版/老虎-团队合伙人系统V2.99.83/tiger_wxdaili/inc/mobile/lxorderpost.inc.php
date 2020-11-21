<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];

        $openid=$_GPC['openid'];
        $dd=$_GPC['dd'];
        $zt=$_GPC['zt'];
        $id=$_GPC['id'];//share id
        if(!empty($id)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$id}'");
        }else{
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        }        
        $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
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

       
		
		$dlwhere='';
		if($zt==1){//已激活
          $dlwhere.=" and xrzt='已激活'";
        }
        if($zt==2){//结算
          $dlwhere.=" and xrzt='已首购'";
        }

        //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/inc/mobile/log.txt","\n".$dlwhere.'--订单付款--'.$where."select * from ".tablename("tiger_newhu_tkorder")." where weid='{$_W['uniacid']}' {$dlwhere}  {$where}   order by addtime desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}",FILE_APPEND);

        $pindex = max(1, intval($_GPC['limit']));
		$psize = 20;
        $list1 = pdo_fetchall("select * from ".tablename("tiger_newhu_lxorder")." where weid='{$_W['uniacid']}' {$dlwhere}  {$where}   order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_lxorder')." where weid='{$_W['uniacid']}'  {$dlwhere} {$where} ");
		$pager = pagination($total, $pindex, $psize);

        //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/inc/mobile/log.txt","\n".json_encode($list1),FILE_APPEND);
       


         foreach ($list1 as $k => $v) {
         		if(empty($v['addtime'])){
		        	$v['addtime']='';
		        }else{
		        	$v['addtime']=date('Y-m-d H:i:s',$v['addtime']);
		        }
		        if(empty($v['jhtime'])){
		        	$v['jhtime']='';
		        }else{
		        	$v['jhtime']=date('Y-m-d H:i:s',$v['jhtime']);
		        }
		        if(empty($v['sgtime'])){
		        	$v['sgtime']='';
		        }else{
		        	$v['sgtime']=date('Y-m-d H:i:s',$v['sgtime']);
		        }
                $list[$k]['addtime']=$v['addtime'];
	            $list[$k]['jhtime']=$v['jhtime'];
	            $list[$k]['sgtime']=$v['sgtime'];
	            $list[$k]['newtel']=$v['newtel'];
	            $list[$k]['xrzt']=$v['xrzt'];
	            $list[$k]['ddlx']=$v['ddlx'];
	            $list[$k]['fxyh']=$v['fxyh'];
	            $list[$k]['mtid']=$v['mtid'];
	            $list[$k]['mtname']=$v['mtname'];
	            $list[$k]['tgwid']=$v['tgwid'];
	            $list[$k]['tgwname']=$v['tgwname'];
	            $list[$k]['orderid']=$v['orderid'];
	            $list[$k]['createtime']=date('Y-m-d H:i:s',$v['createtime']);
        }


            if (!empty($list)){
                $status=1;
            }else{
                $status=2;
            }
            exit(json_encode(array('status' => $status, 'content' => $list)));
?>