<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$item=pdo_get('mzhk_sun_sms',array('uniacid'=>$_W['uniacid']));

if($_GPC['op']=='setting'){
    $sms=pdo_get('mzhk_sun_sms',array('uniacid'=>$_W['uniacid']));
    $tid = $_GPC["tid"];
    $tid1=$sms['tid1'];
    $tid2=$sms['tid2'];
    $tid3=$sms['tid3'];

    $system=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']),array('appid','appsecret'));

    $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$system['appid'].'&secret='.$system['appsecret'];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);

    $info=json_decode($output,true);
    $token=$info['access_token'];
    
    $url="https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token=".$token;
    if($tid=="tid1"){
        $data['id']='AT0856';
        $data['keyword_id_list']=[20,7,6,9,15];
    }elseif($tid=="tid2"){
        $data['id']='AT0002';
        $data['keyword_id_list']=[5,4,26,70,51,40];
    }elseif($tid=="tid3"){
        $data['id']='AT0444';
        $data['keyword_id_list']=[1,2,3,4,8];
    }elseif($tid=="tid4"){
        $data['id']='AT0705';
        $data['keyword_id_list']=[13,5,3,7];
    }else{
        message('设置失败,参数错误','','error');
    }
        

    $data=json_encode($data);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);

    $info=$output;

    $add=json_decode($info,true);
    var_dump($add);

    if($add['errcode']==0&&$add['errmsg']=='ok'){
        if($_GPC['id']==''){
            $datas['uniacid']=trim($_W['uniacid']);
            $datas[$tid] = $add['template_id'];
            $res=pdo_insert('mzhk_sun_sms',$datas);
        }else{
            $res=pdo_update('mzhk_sun_sms',array($tid=>$add['template_id']),array('uniacid'=>$_W['uniacid']));
        }
        if($res){
            message('模板消息设置成功',$this->createWebUrl('template',array()),'success');
        }else{
            message('设置失败!','','error');
        }
    }else{
        message('设置失败!!'.$add['errmsg'],'','error');
    }
}
if(checksubmit('submit')){
    $data['tid1']=trim($_GPC['tid1']);
    $data['tid2']=trim($_GPC['tid2']);
    $data['tid3']=trim($_GPC['tid3']);
    $data['tid4']=trim($_GPC['tid4']);
    $data['uniacid']=trim($_W['uniacid']);
    if($_GPC['id']==''){                
        $res=pdo_insert('mzhk_sun_sms',$data);
        if($res){
            message('添加成功',$this->createWebUrl('template',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_sms', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('template',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}



include $this->template('web/template');