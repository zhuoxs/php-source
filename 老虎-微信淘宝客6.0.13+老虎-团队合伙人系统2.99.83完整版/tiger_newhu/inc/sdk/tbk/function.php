<?php

function putSharePidIntoConfig(&$cfg,$openid){
    global $_W;
    //$openid=$_W['openid'];
    $share=getShareInfo($openid);
    if($share['dlptpid']){
        $dlptpid=$share['dlptpid'];
        $cfg['ptpid']=$dlptpid;
        $pidSplit=explode('_',$dlptpid);
        $cfg['siteid']=$pidSplit[2];
        $cfg['adzoneid']=$pidSplit[3];
    }
    if($share['dlqqpid']){
        $cfg['qqpid']=$share['dlqqpid'];
    }
}
function getShareInfo($fromOpenid){
    global $_W;
    $sqlForSet="select * from ".tablename("tiger_wxdaili_set")." where  weid='{$_W['uniacid']}' ";
    $dailiSet=pdo_fetch($sqlForSet);
    if(!$dailiSet){
        exit("无代理设置，请检查是否已安装代理系统并设置好基础设置。");
    }
    $level=$dailiSet['dltype'];
    for($i=0;$i<$level;$i++){
        //查询代理信息
        $sqlForShare="select * from ".tablename("tiger_taoke_share")." where  weid='{$_W['uniacid']}' and  from_user = '{$fromOpenid}'";
        $share=pdo_fetch($sqlForShare);
        if(!$share['dlptpid']){
         //不是代理，就查询上级是不是代理
            $helpid=$share['helpid'];
            if(!$helpid)return false;
            $sqlForUpperShare="select * from ".tablename("tiger_taoke_share")." where  weid='{$_W['uniacid']}' and  openid = ".$helpid;
            $share=pdo_fetch($sqlForUpperShare);
            if($share['dlptpid']){
                break;
            }
            $fromOpenid=$share['from_user'];
        }else{
            break;
        }
    }
    return $share;
}