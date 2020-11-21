<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();


$item=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
        $apiclient_cert=$_FILES['apiclient_cert'];
        $apiclient_key=$_FILES['apiclient_key'];
        $apiclient_cert_size=$_FILES['apiclient_cert']['size'];
        $apiclient_key_size=$_FILES['apiclient_key']['size'];
        if($apiclient_cert['name'] || $apiclient_key['name']){
            if($apiclient_cert['type']!='application/octet-stream' ||$apiclient_key['type']!='application/octet-stream'){
                message('文件类型只能为pem格式');
            }
        }
        if($apiclient_cert_size>2*1024*1024 || $apiclient_key_size>2*1024*1024) {
           message('上传文件过大，不得超过2M');
        }
        //判断是否上传成功（是否使用post方式上传）
        if(is_uploaded_file($_FILES['apiclient_cert']['tmp_name'])) {
            //把文件转存到你希望的目录（不要使用copy函数）
            $uploaded_file=$_FILES['apiclient_cert']['tmp_name'];
            //我们给每个用户动态的创建一个文件夹
            $user_path=IA_ROOT."/addons/zhls_sun/cert/";

            //判断该用户文件夹是否已经有这个文件夹
            if(!file_exists($user_path)) {
                mkdir($user_path);
            }
            $file_true_name=$_FILES['apiclient_cert']['name'];
            $file_true_name = rtrim($file_true_name,'.pem');
            $file_true_name = $file_true_name . '_' . $_W['uniacid'] . '.pem';
            $move_to_file=$user_path.$file_true_name;
            //echo "$uploaded_file   $move_to_file";
            if(move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file))) {
                echo $_FILES['apiclient_cert']['name']."上传成功";
            } else {
                echo "上传失败";
            }
        } else {
            echo "上传失败";
        }
        //判断是否上传成功（是否使用post方式上传）
        if(is_uploaded_file($_FILES['apiclient_key']['tmp_name'])) {
            //把文件转存到你希望的目录（不要使用copy函数）
            $uploaded_file=$_FILES['apiclient_key']['tmp_name'];
            //我们给每个用户动态的创建一个文件夹
            $user_path=IA_ROOT."/addons/zhls_sun/cert/";

            //判断该用户文件夹是否已经有这个文件夹
            if(!file_exists($user_path)) {
                mkdir($user_path);
            }
            $file_true_name=$_FILES['apiclient_key']['name'];
            $file_true_name = rtrim($file_true_name,'.pem');
            $file_true_name = $file_true_name . '_' . $_W['uniacid'] . '.pem';
            $move_to_file=$user_path.$file_true_name;
            //echo "$uploaded_file   $move_to_file";
            if(move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file))) {
                echo $_FILES['apiclient_key']['name']."上传成功";
            } else {
                echo "上传失败";
            }
        } else {
            echo "上传失败";
        }
//            $data['apiclient_cert']=trim($_GPC['apiclient_cert']);
            $data['apiclient_cert']=$apiclient_cert['name'];
            $data['apiclient_key']=$apiclient_key['name'];
            $data['appid']=trim($_GPC['appid']);
            $data['appsecret']=trim($_GPC['appsecret']);
            $data['mapkey']=trim($_GPC['mapkey']);
            $data['gd_key']=trim($_GPC['gd_key']);
            $data['mchid']=trim($_GPC['mchid']);
            $data['wxkey']=trim($_GPC['wxkey']);
            $data['rand_apic']= rand(1,99);
            if($_GPC['appid']==''){
                message('小程序appid不能为空!','','error'); 
            }
            if($_GPC['appsecret']==''){
                message('小程序appsecret不能为空!','','error'); 
            }
            $data['uniacid']=trim($_W['uniacid']);
            if($_GPC['id']==''){                
                $res=pdo_insert('zhls_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('peiz',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhls_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('peiz',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
    include $this->template('web/peiz');