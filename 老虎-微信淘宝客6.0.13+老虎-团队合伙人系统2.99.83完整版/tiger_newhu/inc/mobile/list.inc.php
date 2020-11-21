<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
        $typeid=$_GPC['typeid'];
        $dluid=$_GPC['dluid'];//share id
        //var_dump($typeid);
        //exit;
        $day=date("Y/m/d",time());
        $dtime=strtotime($day);
        $id=$_GPC['id'];
        $tj=$_GPC['tj'];
        $key=$_GPC['key'];
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


        if(!empty($typeid)){
           $where =" and type='{$typeid}'";
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
        if(!empty($id)){
          $views=pdo_fetch("select * from".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' and id='{$id}'");
        }
        $ad = pdo_fetchall("SELECT * FROM " . tablename($this -> table_ad) . " WHERE weid = '{$_W['weid']}' order by id desc");

        $fzview = pdo_fetch("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}' and id='{$_GPC['typeid']}' order by px desc");
        $fzlist = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}'  order by px desc");
        $fzlist7 = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}'  order by px desc limit 7");
        if($cfg['qtstyle']<>'style4'){//模版4的时候不显示
            $pindex = max(1, intval($_GPC['page']));
            $psize = 20;
           if(!empty($cfg['hpx'])){
              $rand=" rand(),";
            }
            
            $list = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' and coupons_end>={$dtime} {$where} order by {$rand} {$sort} LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_tbgoods')." where coupons_end>={$dtime} and  weid='{$_W['uniacid']}' {$where}");
            $pager = pagination($total, $pindex, $psize);
            $totalpage=floor($total/$psize);
            $page=$_GPC['page'];
            $nextpage=$_GPC['page']+1;
            $prevpage=$_GPC['page']-1;
        }
        $msg = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_msg") . " WHERE weid = '{$_W['uniacid']}' order by rand() desc limit 100");
        

        $style=$cfg['qtstyle'];
        if(empty($style)){
            $style='style1';        
        }

       include $this->template ( 'tbgoods/'.$style.'/list' );