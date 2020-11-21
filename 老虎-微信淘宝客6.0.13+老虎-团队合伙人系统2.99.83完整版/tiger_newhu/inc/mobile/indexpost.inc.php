<?php
global $_W, $_GPC;
$cfg = $this->module['config'];
        $typeid=$_GPC['typeid'];
        $dluid=$_GPC['dluid'];//share id
        $id=$_GPC['id'];
        $tj=$_GPC['tj'];
        $key=$_GPC['key'];
        $day=date("Y/m/d",time());
        $dtime=strtotime($day);
       
        $where='';
        if(!empty($typeid)){
           $where .=" and type='{$typeid}'";
        }
        if(!empty($_GPC['key'])){
            if($cfg['fcss']==1){
               $arr=$this->getfc($_GPC['key']);
               //$arr=explode(" ",$arr);
            }else{
               $arr=explode(" ",$_GPC['key']);
            }
            
             foreach($arr as $v){
                 if (empty($v)) continue;
                $where.=" and title like '%{$v}%'";
             }
        }
        if($tj==1){
            $where .=" and price<10";
        }elseif($tj==2){
          $where .=" and price<20 and price>10";
        }
        $dtime=time();
        if(!empty($typeid)){
           $where =" and type='{$typeid}'";
        }       
        if(!empty($id)){
          $views=pdo_fetch("select * from".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' and id='{$id}'");
        }
        $sort=$_GPC['sort'];
        if(empty($sort)){
           $sort='id desc';
        }elseif($sort=='new'){
           $sort='id desc';
        }elseif($sort=='hot'){//月销售
           $sort='goods_sale desc';
        }elseif($sort=='price'){//价格
           $sort='price asc';
        }

        $fzlist = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}'  order by px desc");
         if($cfg['hpx']==1){
              $rand=" rand(),";
            }

        $pindex = max(1, intval($_GPC['limit']));
	    $psize = 20;
		$list = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' and coupons_end>={$dtime}  {$where} order by {$rand} {$sort} LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_tbgoods')." where weid='{$_W['uniacid']}' and coupons_end>={$dtime}  {$where}");
		$pager = pagination($total, $pindex, $psize);
        //echo $where;
        //exit;
        if (!empty($list)){
            $status=1;
        }else{
            $status=2;
        }

        exit(json_encode(array('status' => $status, 'content' => $list)));