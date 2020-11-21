<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('mzhk_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');

global $_W, $_GPC;
$template = "web/vipcode";

if($_GPC['op']=='create'){
    //获取VIP列表
    $viplist=pdo_getall('mzhk_sun_vip',array('uniacid'=>$_W['uniacid']));
    
    $template = "web/vipcodeadd";
}elseif($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('mzhk_sun_vipcode',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('vipcode',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}elseif($_GPC['op']=='creatcode'){
    $vipid = $_GPC["vipid"];
    $viplist=pdo_get('mzhk_sun_vip',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['vipid']),array("prefix","price","title","day"));
    $allnum = intval($_GPC["num"])>0?intval($_GPC["num"]):10;//生成总数
    $page = intval($_GPC["page"])>0?intval($_GPC["page"]):0;//页数
    $nextpage = $page + 1;
    $othernum = $page*10;
    $lavenum = $allnum - $othernum;

    $vc_starttime = $_GPC["vc_starttime"];
    $vc_endtime = $_GPC["vc_endtime"];

    if($lavenum>0){
        $thatnum = $lavenum<=10?$lavenum:10;//每次10个
        $strdata = array();
        echo "VIP 激活码生成中：<br />";
        for($i=0;$i<$thatnum;$i++){
            $data = array();
            $data["vipid"] = $vipid;
            $data["vc_starttime"] = $vc_starttime;
            $data["vc_endtime"] = $vc_endtime;
            $data["uniacid"] = $_W['uniacid'];
            $data["vc_code"] = $viplist['prefix'].time().rand(10000,99999);
            $data["money"] = $viplist['price'];
            $data["viptitle"] = $viplist['title'];
            $data["vipday"] = $viplist['day'];
            $vcarr=pdo_get('mzhk_sun_vipcode',array('uniacid'=>$_W['uniacid'],'vc_code'=>$data["vc_code"]),array("id"));
            if(!$vcarr){
                echo "Creat VIP code ：".$data["vc_code"]." success !<br />";
                $res=pdo_insert('mzhk_sun_vipcode',$data);
            }
            unset($data);
        }
        if($thatnum<10){
            message('操作成功1',$this->createWebUrl('vipcode',array()),'success');
        }else{
            //header('Location:'.$this->createWebUrl('vipcode',array("op"=>"creatcode","num"=>$allnum,"page"=>$nextpage,"vipid"=>$vipid,"vc_starttime"=>$vc_starttime,"vc_endtime"=>$vc_endtime)));
            header('Refresh: 1;url='.$this->createWebUrl('vipcode',array("op"=>"creatcode","num"=>$allnum,"page"=>$nextpage,"vipid"=>$vipid,"vc_starttime"=>$vc_starttime,"vc_endtime"=>$vc_endtime)));
        }
    }else{
        message('操作成功2',$this->createWebUrl('vipcode',array()),'success');
    }    
    exit;
}elseif($_GPC['op']=='export_search'){
    //获取VIP列表
    $viplist=pdo_getall('mzhk_sun_vip',array('uniacid'=>$_W['uniacid']));
    
    $template = "web/vipcodeexport";
}elseif($_GPC['op']=='export'){
    //准备要导出的激活码数据
    $uniacid = $_W['uniacid'];
    $vipid = intval($_GPC["vipid"]);
    $vc_isuse = intval($_GPC["vc_isuse"]);
    $timetype = intval($_GPC["timetype"]);

    $where = " where vc.uniacid=:uniacid ";
    $data_vipcode[":uniacid"] = $uniacid;
    if($vipid!=''){
        $where .= " and vc.vipid=:vipid ";
        $data_vipcode[":vipid"] = $vipid;
    }
    if($vc_isuse!=999){
        $where .= " and vc.vc_isuse=:vc_isuse ";
        $data_vipcode[":vc_isuse"] = $vc_isuse;
    }
    $now = date("Y-m-d");
    if($timetype==1){//未开始
        $where .= " and vc.vc_starttime > :now ";
        $data_vipcode[":now"] = $now;
    }elseif($timetype==2){//正常
        $where .= " and vc.vc_starttime <= :now and vc.vc_endtime >= :now ";
        $data_vipcode[":now"] = $now;
    }elseif($timetype==3){//过期
        $where .= " and vc.vc_endtime < :now ";
        $data_vipcode[":now"] = $now;
    }
    $sql = "select vc.vc_code,v.title,v.day,vc.vc_starttime,vc.vc_endtime,vc.vc_isuse from " . tablename("mzhk_sun_vipcode") ." as vc left join " . tablename("mzhk_sun_vip") ." as v on vc.vipid=v.id ".$where;

    $vipcode = pdo_fetchall($sql,$data_vipcode);

    if(!$vipcode){
        message('没有你选择的数据',$this->createWebUrl('vipcode',array()),'error');
    }

    $export_title_str = "序号,激活码,VIP类别,会员天数,开始时间,结束时间,是否使用";
    $export_title = explode(',',$export_title_str);
    $export_list = array(); 
    $isuse = array("未使用","已使用");
    $i=1;
    foreach ($vipcode as $k => $v){
        $export_list[$k]["k"] = $i;
        $export_list[$k]["vc_code"] = $v["vc_code"];
        $export_list[$k]["title"] = $v["title"];
        $export_list[$k]["day"] = $v["day"]."天";
        $export_list[$k]["vc_starttime"] = $v["vc_starttime"];
        $export_list[$k]["vc_endtime"] = $v["vc_endtime"];
        $export_list[$k]["vc_isuse"] = $isuse[$v["vc_isuse"]];
        $i++;
    } 
    $viptype = $vipcode[0]["title"];

    exportToExcel($viptype.'_激活码_'.date("YmdHis").'.csv',$export_title,$export_list);  
    
    exit();  

}else{

    $where=" WHERE c.uniacid=:uniacid ";
    $data[':uniacid']=$_W['uniacid'];
    if($_GPC["vc_isuse"]==2){
        $where .= " and c.vc_isuse=0 ";
    }
    if($_GPC["vc_isuse"]==1){
        $where .= " and c.vc_isuse=1 ";
    }

    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $total=pdo_fetchcolumn("select count(c.id) as wname from " . tablename("mzhk_sun_vipcode") . " as c left join " . tablename("mzhk_sun_vip") ." as v on c.vipid=v.id {$where} order by c.id desc ",$data);
    //$sql="select c.id,v.title,v.price,c.vc_starttime,c.vc_endtime,c.vc_code,c.vc_isuse,c.openid,u.name,c.money,c.viptitle,c.vipday from " . tablename("mzhk_sun_vipcode") ." as c left join " . tablename("mzhk_sun_vip") ." as v on c.vipid=v.id left join " . tablename("mzhk_sun_user") ." as u on u.openid=c.openid {$where} order by c.id desc ";
    //$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

    $sql = "select c.id,c.vc_starttime,c.vc_endtime,c.vc_code,c.vc_isuse,c.openid,c.money,c.viptitle,c.vipday,(select a.name from " . tablename("mzhk_sun_user") ." as a where a.openid=c.openid ) as name,v.price,v.title from " . tablename("mzhk_sun_vipcode") ." as c inner join " . tablename("mzhk_sun_vip") ." as v on c.vipid=v.id ".$where." ";
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

    $list=pdo_fetchall($select_sql,$data);
    //print_r($list);
    $pager = pagination($total, $pageindex, $pagesize);

}

include $this->template($template);

