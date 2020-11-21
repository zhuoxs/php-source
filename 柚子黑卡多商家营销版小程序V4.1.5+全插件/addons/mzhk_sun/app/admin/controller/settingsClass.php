<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------

namespace app\admin\controller;


class settingsClass extends BaseClass {
    private $urlarray = array("ctrl"=>"settings");

    public function __construct(){
        parent::__construct();
        global $_W, $_GPC;
        $GLOBALS['frames'] = $this->getMainMenu();
    }

    /*黑卡设置*/
    public function rankcardset(){
        global $_W, $_GPC;
        $item=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));

        if(checksubmit('submit')){

            $data['hk_tubiao']=$_GPC['hk_tubiao'];
			$data['subheading']=$_GPC['subheading'];
			$data['topbg']=$_GPC['topbg'];
            $data['uniacid']=$_W['uniacid'];
            $data['hk_logo']=$_GPC['hk_logo'];
            $data['hk_bgimg']=$_GPC['hk_bgimg'];
            $data['hk_namecolor']=$_GPC['hk_namecolor'];
            $data['hk_userrules']=html_entity_decode($_GPC['hk_userrules']);
            $data['hk_mytitle']=$_GPC['hk_mytitle'];
            $data['hk_mybgimg']=$_GPC['hk_mybgimg'];
            $data['openblackcard']=$_GPC['openblackcard'];
			$data['opennotice']=$_GPC['opennotice'];
			$data['opennotime']=$_GPC['opennotime'];
			$data['hk_mytopimg']=$_GPC['hk_mytopimg'];
			$data['opensearch']=$_GPC['opensearch'];
			$data['openrelease']=$_GPC['openrelease'];
			$data['openexamine']=$_GPC['openexamine'];
            $data['writeofftype']=$_GPC['writeofftype'];
			$data['is_delivery']=$_GPC['is_delivery'];
			$data['vip_bimg']=$_GPC['vip_bimg'];
			$data['opennavtype']=$_GPC['opennavtype'];

			$data['fontcolor']=$_GPC['fontcolor'];
			if($_GPC['color']){
				$data['color']=$_GPC['color'];
			}else{
				$data['color']="#ED414A";
			}

			if($_GPC['catetopbg']){
				$data['catetopbg']=$_GPC['catetopbg'];
			}else{
				$data['catetopbg']="#ffd842";
			}

			if($_GPC['vipbcolor']){
				$data['vipbcolor']=$_GPC['vipbcolor'];
			}else{
				$data['vipbcolor']="#ffbe5e";
			}

            if($_GPC['id']==''){
                $res=pdo_insert('mzhk_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('rankcardset',$this->urlarray),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('rankcardset',$this->urlarray),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }

        include $this->template('web/setting/rankcardset');
    }

    /*模板消息设置*/
    public function templates(){
        global $_W, $_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $item = pdo_get('mzhk_sun_sms',array('uniacid'=>$_W['uniacid']));
        if($item["xiaoshentui"]){
            $xiaoshentui = unserialize($item["xiaoshentui"]);
        }

        if(checksubmit('submit')){
            $data['tid1']=trim($_GPC['tid1']);
            $data['tid2']=trim($_GPC['tid2']);
            $data['tid3']=trim($_GPC['tid3']);
            $data['tid4']=trim($_GPC['tid4']);
			$data['tid5']=trim($_GPC['tid5']);
            $data['uniacid']=trim($_W['uniacid']);
            if($_GPC['id']==''){
                $res=pdo_insert('mzhk_sun_sms',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('templates',$this->urlarray),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_sms', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('templates',$this->urlarray),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }

        include $this->template('web/setting/template');
    }

    /*一键生成模板消息设置*/
    public function templateset(){
        global $_W, $_GPC;
        $sms=pdo_get('mzhk_sun_sms',array('uniacid'=>$_W['uniacid']));
        $tid = $_GPC["tid"];
        $tid1=$sms['tid1'];
        $tid2=$sms['tid2'];
        $tid3=$sms['tid3'];
        $tid4=$sms['tid4'];
		$tid5=$sms['tid5'];

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
            $data['id']='AT0002';
            $data['keyword_id_list']=[50,49,51,65,73];
        }elseif($tid=="tid2"){
            $data['id']='AT0002';
            $data['keyword_id_list']=[5,4,26,70,51,40];
        }elseif($tid=="tid3"){
            $data['id']='AT0444';
            $data['keyword_id_list']=[1,2,3,4,8];
        }elseif($tid=="tid4"){
            $data['id']='AT0705';
            // $data['keyword_id_list']=[13,5,3,7];
            $data['keyword_id_list']=[1,5,3];
        }elseif($tid=="tid5"){
            $data['id']='AT1835';
            $data['keyword_id_list']=[10,2,8,34];
        }else{
            message('设置失败,参数错误','','error');
        }
        // var_dump($data);die;

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
        // var_dump($add);die;


        if($add['errcode']==0&&$add['errmsg']=='ok'){
            if($_GPC['id']==''){
                $datas['uniacid']=trim($_W['uniacid']);
                $datas[$tid] = $add['template_id'];
                $res=pdo_insert('mzhk_sun_sms',$datas);
            }else{
                $res=pdo_update('mzhk_sun_sms',array($tid=>$add['template_id']),array('uniacid'=>$_W['uniacid']));
            }
            if($res){
                message('模板消息设置成功',$this->createWebUrl('templates',$this->urlarray),'success');
            }else{
                message('设置失败!','','error');
            }
        }else{
            message('设置失败!!'.$add['errmsg'],'','error');
        }

    }

    /*模板消息——设置*/
    public function xiaoshentui(){
        global $_W, $_GPC;
        if(checksubmit('submit')){
            $indata=$_GPC['indata'];
            $data["xiaoshentui"] = serialize($indata);

            if($_GPC['id']==''){
                $data['uniacid']=trim($_W['uniacid']);
                $res=pdo_insert('mzhk_sun_sms',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('templates',$this->urlarray),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_sms', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('templates',$this->urlarray),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
    }

    /*奇推设置*/
    public function qituisetting(){
        global $_W, $_GPC;
        $item = pdo_get('mzhk_sun_sms',array('uniacid'=>$_W['uniacid']));
        if($item["qitui"]){
            $qitui = unserialize($item["qitui"]);
        }
        if(checksubmit('submit')){
            $indata=$_GPC['indata'];
            $data["qitui"] = serialize($indata);

            if($_GPC['id']==''){
                $data['uniacid']=trim($_W['uniacid']);
                $res=pdo_insert('mzhk_sun_sms',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('qituisetting',$this->urlarray),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_sms', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('qituisetting',$this->urlarray),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
        include $this->template('web/setting/qituisetting');

    }

	/*我的页面自定义图标*/
    public function myicon(){
        global $_W, $_GPC;

		$item=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));

		//判断分销插件是否安装
		if(pdo_tableexists("mzhk_sun_distribution_set")){
			$distribution = 1;
		}

		//判断吃探插件是否安装
		if(pdo_tableexists("mzhk_sun_eatvisit_set")){
			$eatvisit = 1;
		}

		//判断积分插件是否安装
		if(pdo_tableexists("mzhk_sun_plugin_scoretask_system")){
			$scoretask = 1;
		}

		//判断服务商插件是否安装
		if(pdo_fieldexists('mzhk_sun_system',  'server_wxkey')){
			$service = 1;
		}

		//判断裂变券插件是否安装
		if(pdo_tableexists("mzhk_sun_distribution_fission_set")){
			$fission = 1;
		}

		//判断红包插件是否安装
		if(pdo_tableexists("mzhk_sun_redpacket_set")){
			$redpacket = 1;
		}

		//判断次卡插件是否安装
		if(pdo_tableexists("mzhk_sun_subcard_set")){
			$subcard = 1;
		}
        //判断权益插件是否安装
        if(pdo_tableexists("mzhk_sun_member_set")){
            $member = 1;
        }
        //判断套餐包插件是否安装
        if(pdo_tableexists("mzhk_sun_package_set")){
            $package = 1;
        }
        //判断抽奖插件是否安装
        if(pdo_tableexists("mzhk_sun_plugin_lottery_system")){
            $lottery = 1;
        }
		//判断云店插件是否安装
        if(pdo_tableexists("mzhk_sun_cloud_set")){
            $cloud = 1;
        }


		if(checksubmit('submit')){
            $data['uniacid']=trim($_W['uniacid']);
			$data['myicon']=trim($_GPC['myicon']);
            $data['mypticon']=trim($_GPC['mypticon']);
            $data['mykjicon']=trim($_GPC['mykjicon']);
            $data['myjkicon']=trim($_GPC['myjkicon']);
			$data['myqgicon']=trim($_GPC['myqgicon']);
			$data['mymdicon']=trim($_GPC['mymdicon']);
			$data['myyhqicon']=trim($_GPC['myyhqicon']);
			$data['mycticon']=trim($_GPC['mycticon']);
			$data['myfxicon']=trim($_GPC['myfxicon']);
			$data['myjficon']=trim($_GPC['myjficon']);
			$data['mylbqicon']=trim($_GPC['mylbqicon']);
			$data['myhbicon']=trim($_GPC['myhbicon']);
			$data['myckicon']=trim($_GPC['myckicon']);
			$data['myckicon2']=trim($_GPC['myckicon2']);
            $data['myqyicon']=trim($_GPC['myqyicon']);
            $data['myqyicon2']=trim($_GPC['myqyicon2']);
            $data['mytcicon']=trim($_GPC['mytcicon']);
            $data['mytcicon2']=trim($_GPC['mytcicon2']);
            $data['mycjicon']=trim($_GPC['mycjicon']);
            $data['mycjicon2']=trim($_GPC['mycjicon2']);
            $data['myzsicon']=trim($_GPC['myzsicon']);
			$data['mypsicon']=trim($_GPC['mypsicon']);
			$data['myrzicon']=trim($_GPC['myrzicon']);
			$data['myglicon']=trim($_GPC['myglicon']);
			$data['mycdicon']=trim($_GPC['mycdicon']);


			$data['mytext']=trim($_GPC['mytext']);
			$data['mypttext']=trim($_GPC['mypttext']);
			$data['mykjtext']=trim($_GPC['mykjtext']);
			$data['myjktext']=trim($_GPC['myjktext']);
			$data['myqgtext']=trim($_GPC['myqgtext']);
			$data['mymdtext']=trim($_GPC['mymdtext']);
			$data['myyhqtext']=trim($_GPC['myyhqtext']);
			$data['mycttext']=trim($_GPC['mycttext']);
			$data['myfxtext']=trim($_GPC['myfxtext']);
			$data['myjftext']=trim($_GPC['myjftext']);
			$data['mylbqtext']=trim($_GPC['mylbqtext']);
			$data['myhbtext']=trim($_GPC['myhbtext']);
			$data['myqytext']=trim($_GPC['myqytext']);
			$data['myqytext2']=trim($_GPC['myqytext2']);
            $data['mytctext']=trim($_GPC['mytctext']);
            $data['mytctext2']=trim($_GPC['mytctext2']);
            $data['mycjtext']=trim($_GPC['mycjtext']);
            $data['mycjtext2']=trim($_GPC['mycjtext2']);
            $data['myzstext']=trim($_GPC['myzstext']);
			$data['mypstext']=trim($_GPC['mypstext']);
			$data['myrztext']=trim($_GPC['myrztext']);
			$data['mygltext']=trim($_GPC['mygltext']);
			$data['mycdtext']=trim($_GPC['mycdtext']);

			if($_GPC['id']==''){
                $res=pdo_insert('mzhk_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('myicon',$this->urlarray),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('myicon',$this->urlarray),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }

        include $this->template('web/setting/myicon');
    }

}