<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
        $typeid=$_GPC['typeid'];
        $do=$_GPC['do'];
        $dluid=$_GPC['dluid'];//share id
        if(!empty($dluid)){
           $share=pdo_fetch("select * from ".tablename('tiger_taoke_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
        }
        //var_dump($typeid);
        //exit;
        $day=date("Y/m/d",time());
        $dtime=strtotime($day);

        $fans=$_W['fans'];
        if(empty($fans)){
          $fans=mc_oauth_userinfo();
        }
        $openid=$fans['openid'];



        $id=$_GPC['id'];
        $tj=$_GPC['tj'];
        $key=$_GPC['key'];
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
        $msg = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_msg") . " WHERE weid = '{$_W['uniacid']}' order by rand() desc limit 100");
        $zdgoods = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_tbgoods") . " WHERE weid = '{$_W['uniacid']}' and zd=1 order by px desc");


        $fzlist = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}'  order by px desc");
        $fzlist7 = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}'  order by px desc limit 7");
        $fzlist10 = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}'  order by px desc limit 10");
        if($cfg['qtstyle']<>'style4'){//模版4的时候不显示
            $pindex = max(1, intval($_GPC['page']));
            $psize = 20;
            if(!empty($cfg['hpx'])){
              $rand=" rand(),";
            }

            
            $list = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' and coupons_end>={$dtime} {$where} order by {$rand} id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_tbgoods')." where coupons_end>={$dtime} and  weid='{$_W['uniacid']}' {$where}");
            $pager = pagination($total, $pindex, $psize);
            $totalpage=floor($total/$psize);
            $page=$_GPC['page'];
            $nextpage=$_GPC['page']+1;
            $prevpage=$_GPC['page']-1;
        }
        if($cfg['qtstyle']=='style9'){
          $list10 = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' and coupons_end>={$dtime} {$where} order by {$rand} id desc LIMIT 10");
          $list99 = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' and coupons_end>={$dtime} and price<10 order by {$rand} id desc LIMIT 10");
        }

        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
        

        $style=$cfg['qtstyle'];
        if(empty($style)){
            $style='style1';        
        }

       include $this->template ( 'tbgoods/'.$style.'/index' );