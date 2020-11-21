<?php
global $_W, $_GPC;
        $typeid=$_GPC['typeid'];
        $dluid=$_GPC['dluid'];//share id
        $cfg = $this->module['config'];
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
            $arr=explode(" ",$_GPC['key']);
             foreach($arr as $v){
                 if (empty($v)) continue;
                $where.=" and title like '%{$v}%'";
             }
            //$where .=" and title like '%{$_GPC['key']}%'";
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

        $fzlist = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}'  order by px desc");

        //$pindex = max(1, intval($_GPC['limit']));
	    //$psize = 200;
		//$list = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' {$where} order by px desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		//$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_tbgoods')." where weid='{$_W['uniacid']}' {$where}");
		//$pager = pagination($total, $pindex, $psize);
        //echo $where;
        //exit;
        if(!empty($cfg['hpx'])){
              $rand=" rand(),";
            }
        $list = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where coupons_end>={$dtime} and weid='{$_W['uniacid']}' {$where} order by {$rand} id desc");

        die(json_encode(array("lists"=>$list)));