<?php
defined('IN_IA') or exit ('Access Denied');

function tocurl($url="",$data="",$timeout=0){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    if($timeout>0){
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    $httpcode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
    curl_close($curl);
    if($httpcode==200){
        return $output;
    }else{
        return false;
    }
}

function getaccess_token(){
    global $_W;
    $system=pdo_get('yzqzk_sun_system',array('uniacid'=>$_W['uniacid']),array('appid','appsecret'));
    $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$system['appid'].'&secret='.$system['appsecret'];
    $output = tocurl($url,"",0);
    $info=json_decode($output,true);
    $token=$info['access_token'];
    return $token;
}

//其他小程序需要修改
function sendtelmessage($openid='',$tpltype='',$haveformid='',$data=''){
    global $_W;
    if(empty($openid)){
        return false;
    }
    if(empty($haveformid)){
        //删除无效formid
        $delres=pdo_delete('yzqzk_sun_userformid',array('time <='=>date('Y-m-d', strtotime('-7 days')),'uniacid'=>$_W['uniacid']));
        $delres=pdo_delete('yzqzk_sun_userformid',array('form_id like'=>"mock",'uniacid'=>$_W['uniacid']));
        $now = date('Y-m-d', strtotime('-7 days'));
        $sql="select form_id from " . tablename("yzqzk_sun_userformid") . " where openid='".$openid."' and time>='".$now."' order by id asc";
        $form_id=pdo_fetchcolumn($sql);
        //删除使用过的formid
        $delres=pdo_delete('yzqzk_sun_userformid',array('form_id'=>$form_id,'uniacid'=>$_W['uniacid']));
    }else{
        $form_id = $haveformid;
    }
    
    //发送模板消息
    $d_set=pdo_get('yzqzk_sun_distribution_set',array('uniacid'=>$_W['uniacid']),array("tpl_wd_arrival","tpl_wd_fail","tpl_share_check"));
    if(!empty($form_id)){
        $tpl = $d_set[$tpltype];
        if(empty($tpl)){
            return false;
        }
        switch ($tpltype) {
            case 'tpl_wd_arrival'://提现到账
                $formwork ='{
                    "touser": "'.$openid.'",
                    "template_id": "'.$tpl.'",
                    "page":"yzqzk_sun/pages/index/index",
                    "form_id":"'.$form_id.'",
                    "data": {
                        "keyword1": {
                            "value": "'.$data["price"].'",
                            "color": "#173177"
                        },
                        "keyword2": {
                            "value":"'.$data["ratesmoney"].'",
                            "color": "#173177"
                        },
                        "keyword3": {
                            "value": "'.$data["realmoney"].'",
                            "color": "#173177"
                        },
                        "keyword4": {
                            "value":"已到账",
                            "color": "#173177"
                        },
                        "keyword5": {
                            "value": "'.$data["wd_type"].'",
                            "color": "#173177"
                        }
                    }   
                }';

                break;
            case 'tpl_wd_fail'://提现失败
                $formwork ='{
                    "touser": "'.$openid.'",
                    "template_id": "'.$tpl.'",
                    "page":"yzqzk_sun/pages/index/index",
                    "form_id":"'.$form_id.'",
                    "data": {
                        "keyword1": {
                            "value": "'.$data["price"].'",
                            "color": "#173177"
                        },
                        "keyword2": {
                            "value":"提现失败，请联系小程序运营商",
                            "color": "#173177"
                        }
                    }   
                }';

                break;
            case 'tpl_share_check'://审核
                $formwork ='{
                    "touser": "'.$openid.'",
                    "template_id": "'.$tpl.'",
                    "page":"yzqzk_sun/pages/index/index",
                    "form_id":"'.$form_id.'",
                    "data": {
                        "keyword1": {
                            "value": "'.$data["status"].'",
                            "color": "#173177"
                        },
                        "keyword2": {
                            "value":"'.date("Y-m-d H:i:s").'",
                            "color": "#173177"
                        },
                         "keyword3": {
                            "value":"分销商审核",
                            "color": "#173177"
                        }
                    }   
                }';

                break;
            default:
                
                break;
        }
        //echo json_encode($formwork);exit;
        // $formwork=$data;
        $access_token = getaccess_token();
        if(!empty($formwork) && !empty($access_token)){
            $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token."";
            tocurl($url,$formwork,0);
        }
    }
}