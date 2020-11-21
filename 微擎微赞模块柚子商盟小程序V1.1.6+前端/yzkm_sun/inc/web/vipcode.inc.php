<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
global $_W, $_GPC;
$template = "web/vipcode";

if($_GPC['op']=='create'){
    //获取VIP列表
    $viplist=pdo_getall('yzkm_sun_vip',array('uniacid'=>$_W['uniacid'],'status'=>1));

    $template = "web/vipcodeadd";
}elseif($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('yzkm_sun_vipcode',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('vipcode',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}elseif($_GPC['op']=='creatcode'){
    if($_GPC['num']>50){
        message('激活码一次性最多只能生成50个！如需更多，请分批生成！');
    }
    $vipid = $_GPC["vipid"];
    $viplist=pdo_get('yzkm_sun_vip',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['vipid']),array("prefix"));
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
        for($i=0;$i<$thatnum;$i++){
            $data = array();
            $data["vipid"] = $vipid;
            $data["vc_starttime"] = $vc_starttime;
            $data["vc_endtime"] = $vc_endtime;
            $data["uniacid"] = $_W['uniacid'];
            $data["vc_code"] = $viplist['prefix'].time().rand(10000,99999);
            $vcarr=pdo_get('yzkm_sun_vipcode',array('uniacid'=>$_W['uniacid'],'vc_code'=>$data["vc_code"]),array("id"));
            if(!$vcarr){
                $res=pdo_insert('yzkm_sun_vipcode',$data);
            }
            unset($data);
        }
        if($thatnum<10){
            message('操作成功',$this->createWebUrl('vipcodelist',array("status"=>1)),'success');
        }else{
            header('Location:'.$this->createWebUrl('vipcode',array("op"=>"creatcode","num"=>$allnum,"page"=>$nextpage,"vipid"=>$vipid,"vc_starttime"=>$vc_starttime,"vc_endtime"=>$vc_endtime)));
        }
    }else{
        message('操作成功',$this->createWebUrl('vipcodelist',array("status"=>1)),'success');
    }
    exit;
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
    $data[':uniacid']=$_W['uniacid'];
    $sql="select c.id,v.title,v.price,c.vc_starttime,c.vc_endtime,c.vc_code,c.vc_isuse,c.uid,u.name from " . tablename("yzkm_sun_vipcode") ." as c left join " . tablename("yzkm_sun_vip") ." as v on c.vipid=v.id left join " . tablename("yzkm_sun_user") ." as u on u.openid=c.uid {$where} order by c.id desc ";
    $total=pdo_fetchcolumn("select count(c.id) as wname from " . tablename("yzkm_sun_vipcode") . " as c left join " . tablename("yzkm_sun_vip") ." as v on c.vipid=v.id {$where} order by c.id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);

}

include $this->template('web/vipcode');