<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
//    小程序设置
    case "smallapp":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        include $this->template('web/system/smallapp');
        break;
    case "smallappsave":
        $data['appid']=trim($_GPC['appid']);
        $data['appsecret']=trim($_GPC['appsecret']);
        $data['wxkey']=trim($_GPC['wxkey']);
        $data['mchid']=trim($_GPC['mchid']);
        $data['apiclient_cert']=trim($_GPC['apiclient_cert']);
        $data['apiclient_key']=trim($_GPC['apiclient_key']);

        $data['phone_switch']=trim($_GPC['phone_switch']);
        $data['app_fcolor']=trim($_GPC['app_fcolor']);
        $data['app_bcolor']=trim($_GPC['app_bcolor']);
        $data['app_tbcolor'] = trim($_GPC['app_tbcolor']);
        $data['app_tfcolor'] = trim($_GPC['app_tfcolor']);
        $data['app_tsfcolor'] = trim($_GPC['app_tsfcolor']);
        $data['bghead'] = $_GPC['bghead'];
        if($_GPC['appid']==''){
            message('小程序appid不能为空!','','error');
        }
        if($_GPC['appsecret']==''){
            message('小程序appsecret不能为空!','','error');
        }
        $data['uniacid']=$uniacid;

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data,array('uniacid'=>$uniacid));
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'smallapp')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$uniacid));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'smallapp')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;

//    模板消息设置
    case "template":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        include $this->template('web/system/template');
        break;
    case "templatesave":
        $data['template_id_buy']=trim($_GPC['template_id_buy']);
        $data['template_id_sale']=trim($_GPC['template_id_sale']);
        $data['uniacid']=trim($uniacid);

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data,array('uniacid'=>$uniacid));
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'template')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$uniacid));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'template')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
//    模板消息设置
    case "msg":
        $info =pdo_get('yzhyk_sun_sms',array('uniacid'=>$uniacid));
        // var_dump($info);
        include $this->template('web/system/msg');
        break;
    case "msgsave":
        $data['appkey']=trim($_GPC['appkey']);
        $data['is_open']=$_GPC['is_open'];
        $data['smstype']=$_GPC['smstype'];
        $data['ytx_apiaccount']=$_GPC['ytx_apiaccount'];
        $data['ytx_apipass']=$_GPC['ytx_apipass'];
        $data['ytx_order']=$_GPC['ytx_order'];
        $data['ytx_orderrefund']=$_GPC['ytx_orderrefund'];

        $data['aly_accesskeyid']=$_GPC['aly_accesskeyid'];
        $data['aly_accesskeysecret']=$_GPC['aly_accesskeysecret'];
        $data['aly_order']=$_GPC['aly_order'];
        $data['aly_orderrefund']=$_GPC['aly_orderrefund'];
        $data['aly_sign']=$_GPC['aly_sign'];
        $data['uniacid']=trim($_W['uniacid']);

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_sms',$data,array('uniacid'=>$uniacid));
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'msg')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_sms', $data, array('id' => $_GPC['id'],'uniacid'=>$uniacid));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'msg')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
//    小程序设置
    case "smallappstyle":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        include $this->template('web/system/smallappstyle');
        break;
    case "smallappstylesave":
        $data['app_fcolor']=trim($_GPC['app_fcolor']);
        $data['app_bcolor']=trim($_GPC['app_bcolor']);
        $data['app_tbcolor'] = trim($_GPC['app_tbcolor']);
        $data['app_tfcolor'] = trim($_GPC['app_tfcolor']);
        $data['app_tsfcolor'] = trim($_GPC['app_tsfcolor']);
        $data['bghead'] = $_GPC['bghead'];

        $data['uniacid']=trim($uniacid);

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data,array('uniacid'=>$uniacid));
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'smallappstyle')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$uniacid));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'smallappstyle')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
//    技术支持设置
    case "team":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        include $this->template('web/system/team');
        break;
    case "teamsave":
        $data['uniacid']=$uniacid;
        $data['team_show']=$_GPC['team_show'];
        $data['team_name']=$_GPC['team_name'];
        $data['team_tel']=$_GPC['team_tel'];
        $data['team_logo']=$_GPC['team_logo'];

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data);
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'team')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id']));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'team')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
//    基础信息设置
    case "baseinfo":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        $pic = json_decode($info['pic']);
        $info['pic'] = $pic?$pic:$info['pic'];
        include $this->template('web/system/baseinfo');
        break;
    case "baseinfosave":
        $data['uniacid']=$uniacid;
        $data['pt_name']=$_GPC['pt_name'];
        $data['tel']=$_GPC['tel'];
        $data['pic']=$_GPC['pic'];
        $data['card_pic']=$_GPC['card_pic'];

        $data['team_show']=$_GPC['team_show'];
        $data['team_name']=$_GPC['team_name'];
        $data['team_tel']=$_GPC['team_tel'];
        $data['team_logo']=$_GPC['team_logo'];
        $data['developkey']=$_GPC['developkey'];
        

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data);
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'baseinfo')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id']));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'baseinfo')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
//    配送费设置
    case "postage":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        include $this->template('web/system/postage');
        break;
    case "postagesave":
        $data['uniacid']=$uniacid;
        $data['min_amount']=$_GPC['min_amount'];
        $data['postage_base']=$_GPC['postage_base'];
        $data['postage_county']=$_GPC['postage_county'];
        $data['postage_city']=$_GPC['postage_city'];
        $data['postage_province']=$_GPC['postage_province'];

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data);
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'postage')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id']));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'postage')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
    //    小程序设置
    case "integral":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        include $this->template('web/system/integral');
        break;
    case "integralsave":
        $data['integral1']=trim($_GPC['integral1']);
        $data['integral2']=trim($_GPC['integral2']);
        $data['integral3']=trim($_GPC['integral3']);
        $data['is_start']=trim($_GPC['is_start']);

        $data['uniacid']=trim($uniacid);

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data,array('uniacid'=>$uniacid));
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'integral')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$uniacid));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'integral')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
    //    活动设置
    case "activity":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        include $this->template('web/system/activity');
        break;
    case "activitysave":
        $data['activity_memo']=trim($_GPC['activity_memo']);
        $data['activity_pic']=trim($_GPC['activity_pic']);
        $data['activity_pic2']=trim($_GPC['activity_pic2']);
        $data['group_pic']=trim($_GPC['group_pic']);
        $data['group_pic2']=trim($_GPC['group_pic2']);
        $data['cut_pic']=trim($_GPC['cut_pic']);
        $data['cut_pic2']=trim($_GPC['cut_pic2']);

        $data['uniacid']=trim($uniacid);

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data,array('uniacid'=>$uniacid));
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'activity')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$uniacid));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'activity')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
    //    广告设置
    case "ad":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        include $this->template('web/system/ad');
        break;
    case "adsave":
        $data['uniacid']=$uniacid;
        $data['ad_pic']=$_GPC['ad_pic'];
        $data['ad_link']=$_GPC['ad_link'];
        $data['ad_value']=$_GPC['ad_value'];
        $data['ad_name']=$_GPC['ad_name'];
        $data['ad_show']=$_GPC['ad_show'];

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data);
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'ad')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id']));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'ad')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
    //    广告设置
    case "member":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        include $this->template('web/system/member');
        break;
    case "membersave":
        $data['uniacid']=$uniacid;
        $data['member_charge']=$_GPC['member_charge'];
        $data['member_upgrade']=$_GPC['member_upgrade'];
        $data['member_memo']=$_GPC['member_memo'];

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data);
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'member')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id']));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'member')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
    //    区域设置
    case "qqmapset":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));

        include $this->template('web/system/qqmapset');
        break;
    case "qqmapsetsave":
    
        $data['uniacid']=$uniacid;
        $data['developkey']=$_GPC['developkey'];

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data);
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'qqmapset')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id']));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'qqmapset')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
    //    提现设置
    case "withdraw":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        include $this->template('web/system/withdraw');
        break;
    case "withdrawsave":
        $data['uniacid']=$uniacid;
        $data['withdraw_switch'] = $_GPC['withdraw_switch'];
        $data['withdraw_min'] = $_GPC['withdraw_min'];
        $data['withdraw_noapplymoney'] = $_GPC['withdraw_noapplymoney'];
        $data['withdraw_wechatrate'] = $_GPC['withdraw_wechatrate'];
        $data['withdraw_platformrate'] = $_GPC['withdraw_platformrate'];
        $data['withdraw_content'] = $_GPC['withdraw_content'];

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data);
            if($res){
                message('添加成功',$this->createWebUrl('system',array('op'=>'withdraw')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id']));
            if($res){
                message('编辑成功',$this->createWebUrl('system',array('op'=>'withdraw')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
    case 'upload':
        global $_W;
        $file = $_FILES['file'];
//        验证文件格式
        if($file['type']!='application/octet-stream'){
            throw new ZhyException('文件类型只能为pem格式');
        }
//        验证文件大小
        if($file['size']>2*1024*1024) {
            throw new ZhyException('上传文件过大，不得超过2M');
        }

        //判断是否上传成功
        if(!is_uploaded_file($file['tmp_name'])) {
            throw new ZhyException('上传失败');
        }

        //把文件转存到你希望的目录（不要使用copy函数）
        $uploaded_file=$file['tmp_name'];
        //我们给每个用户动态的创建一个文件夹
        $user_path=IA_ROOT."/addons/yzhyk_sun/cert/";

        //判断该用户文件夹是否已经有这个文件夹
        if(!file_exists($user_path)) {
            mkdir($user_path);
        }
        $file_true_name=$file['name'];
        $file_true_name = rtrim($file_true_name,'.pem');
        $file_true_name = $file_true_name . '_' . $_W['uniacid'] . '.pem';
        $move_to_file=$user_path.$file_true_name;
        //echo "$uploaded_file   $move_to_file";
        if(!move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file))) {
            throw new ZhyException('上传失败');
        }
        $data = [];
        $data['src'] = $file_true_name;
        echo json_encode($data);
        break;
//    列表页面展示
    default:
        include $this->template('web/system/smallapp');

}
