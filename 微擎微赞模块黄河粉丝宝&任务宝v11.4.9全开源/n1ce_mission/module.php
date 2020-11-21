<?php
/**
 * 黄河·任务宝模块定义
 *
 * @author 
 * @url
 */
defined('IN_IA') or exit('Access Denied');
require IA_ROOT . '/addons/n1ce_mission/loader.php';
include 'youzan_function.php';
class N1ce_missionModule extends WeModule {
	public $tablename = 'n1ce_mission_reply';
	
    public function fieldsFormDisplay($rid = 0) {
        global $_W;
        load()->func('tpl');
		load()->model('mc');
		
		$account_api = WeAccount::create();
		$result = $account_api->fansTagFetchAll();
		$tags = $result['tags'];
		$borrow = $this->module['config']['borrow'];
        if (!empty($rid)) {
            $reply = pdo_fetch("SELECT * FROM " . tablename($this->tablename) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
        }
        if ($reply) {
            $now = TIMESTAMP;
			$data = json_decode(str_replace('&quot;', "'", $reply['data']), true);
			
            $reply['more_bg'] = iunserializer($reply['more_bg']);
        }else{
			$now = TIMESTAMP;
            $reply = array(
                "starttime" => $now,
                "isred" => 1,
                "isall" => 1,
                "temp_join" => $this->module['config']['alltemp'],
                "quality" => 75,
                "rank_num" => 50,
                "endtime" => strtotime(date("Y-m-d H:i", $now + 7 * 24 * 3600)),
			);
		}

        include $this->template('form');
    }

    public function fieldsFormValidate($rid = 0) {
        //规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
        return '';
    }

    public function fieldsFormSubmit($rid) {
        global $_GPC, $_W;
        load()->func('tpl');
        $id = intval($_GPC['reply_id']);
        if($_GPC['more_bg']){
        	$num = count($_GPC['more_bg']);
        	if($num>12){
        		message('最多上传12张背景图','','error');
        	}
        }
        $insert = array(
            'rid' => $rid,
			'uniacid'=> $_W['uniacid'],
            
            'bg' => $_GPC ['bg'],
            'img_type' => $_GPC['img_type'],
            'quality' => $_GPC['quality'],
            'more_bg' => iserializer($_GPC['more_bg']),
            'data' => htmlspecialchars_decode($_GPC ['data']),
            'first_info' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['first_info']),ENT_QUOTES),
            'miss_wait' =>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['miss_wait']),ENT_QUOTES),
            
            'miss_start' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['miss_start']),ENT_QUOTES),
            'next_step' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['next_step']),ENT_QUOTES),
            'miss_cut' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['miss_cut']),ENT_QUOTES),
            'miss_end' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['miss_end']),ENT_QUOTES),
            'miss_sub' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['miss_sub']),ENT_QUOTES),
            'miss_back' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['miss_back']),ENT_QUOTES),
			'miss_resub' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['miss_resub']),ENT_QUOTES),
			'miss_finish' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['miss_finish']),ENT_QUOTES),
			'miss_youzan' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['miss_youzan']),ENT_QUOTES),
			'miss_lucky' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['miss_cj']),ENT_QUOTES),
			'temp_code' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['temp_code']),ENT_QUOTES),
			'first_action' => $_GPC['first_action'],
            'starttime' => strtotime($_GPC['datelimit']['start']),
            'endtime' => strtotime($_GPC['datelimit']['end']),
            'expire' => $_GPC['expire'],
			'xzlx' => $_GPC['xzlx'],
			'again' => $_GPC['again'],
			'sub_post' => $_GPC['sub_post'],
			'limit_sex' => $_GPC['limit_sex'],
			'fans_limit' => $_GPC['fans_limit'],
			'tips' => $_GPC['tips'],
			'copyright' => $_GPC['copyright'],
			'rank_num' => $_GPC['rank_num'],
			'msgtype' => $_GPC['msgtype'],
			'next_scan' => $_GPC['next_scan'],
			'area' => $_GPC['area'],
			'sex' => $_GPC['sex'],
			'isred' => $_GPC['isred'],
			'isall' => $_GPC['isall'],
			'temp_join' => $_GPC['temp_join'],
			'limit_join' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['limit_join']),ENT_QUOTES),
			'limit_scan' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['limit_scan']),ENT_QUOTES),
			'limit_error' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['limit_error']),ENT_QUOTES),
			'get_fans' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['get_fans']),ENT_QUOTES),
			'remark_on' => $_GPC['remark_on'],
			'remark_end' => $_GPC['remark_end'],
			'posttype' => $_GPC['posttype'],
			'tagid' => $_GPC['tagid'],
            'createtime' =>TIMESTAMP,
        );
		// var_dump($insert);die();
        if (empty($id)) {
            $id = pdo_insert($this->tablename, $insert);
        } else {
            unset($insert['createtime']);
            pdo_update($this->tablename, $insert, array('id' => $id));
        }
        message('提交成功！',$this->createWebUrl('manage'),'success');
    }

    public function ruleDeleted($rid) {
        pdo_delete('stat_rule', array('rid' => $rid));
        pdo_delete('stat_keyword', array('rid' => $rid));
		pdo_delete('n1ce_mission_reply', array('rid' => $rid));
		pdo_delete('n1ce_mission_member',array('rid' => $rid));
		pdo_delete('n1ce_mission_follow',array('rid' => $rid));
		pdo_delete('n1ce_mission_user', array('rid' => $rid));
		pdo_delete('n1ce_mission_allnumber',array('rid' => $rid));
		pdo_delete('n1ce_mission_prize', array('rid' => $rid));
		pdo_delete('n1ce_mission_msgid',array('rid' => $rid));
    }

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		load()->func('file');
		yload()->classs('n1ce_mission','wechatutil');
		$_wechatutil = new WechatUtil();
		$severce = "../addons/n1ce_redcode_plugin_affiliate";
		if (file_exists($severce)){
			$no_exists = "101";
		}
		$youzan_token = pdo_fetch("select * from " .tablename('n1ce_mission_token'). " where uniacid = :uniacid limit 1",array(':uniacid' => $_W['uniacid']));
		if($youzan_token['access_token']){
			$shopinfo = he_youzan_shopget($_wechatutil->youzan_access_token());
			$shopinfo = $shopinfo['response'];
		}
		// var_dump($yozuan_token);die();
		if(checksubmit()) {
			//字段验证, 并获得正确的数据$dat
			$cfg = array(
				'borrow' => $_GPC['borrow'],
				'again' => $_GPC['again'],
				'tips' => $_GPC['tips'],
				'copyright' => $_GPC['copyright'],
				'affiliate' => $_GPC['affiliate'],
				'scene_id' => $_GPC['scene_id'],
				'appid' => trim($_GPC['appid']),
				'appsecret' => trim($_GPC['appsecret']),
				'pay_mchid' => $_GPC['pay_mchid'],
				'pay_signkey' => $_GPC['pay_signkey'],
				'act_name' => $_GPC['act_name'],
				'wishing' => $_GPC['wishing'],
				'remark' => $_GPC['remark'],
				'limittime' => $_GPC['limittime'],
				'suburl' => $_GPC['suburl'],
				'mopenid' => $_GPC['mopenid'],
				'send_name' => $_GPC['send_name'],
				'tempid' => $_GPC['tempid'],
				'yzappId' => $_GPC['yzappId'],
				'yzappSecret' => $_GPC['yzappSecret'],
				'brrow_title' => $_GPC['brrow_title'],
				'brrow_desc' => $_GPC['brrow_desc'],
				'brrow_img' => $_GPC['brrow_img'],
				'loc_title' => $_GPC['loc_title'],
				'loc_desc' => $_GPC['loc_desc'],
				'loc_img' => $_GPC['loc_img'],
				'sub_post' => $_GPC['sub_post'],
				'limit_sex' => $_GPC['limit_sex'],
				'fans_title' => $_GPC['fans_title'],
				'fans_desc' => $_GPC['fans_desc'],
				'fans_img' => $_GPC['fans_img'],
				'miss_image' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['miss_image']),ENT_QUOTES),
				'miss_image1' => $_GPC['miss_image1'],
				'alltemp' => $_GPC['alltemp'],
				'antispam_enable' => $_GPC['antispam_enable'],
				'antispam_time_threshold' => $_GPC['antispam_time_threshold'],
				'antispam_user_threshold' => $_GPC['antispam_user_threshold'],
				'antispam_word' => $_GPC['antispam_word'],
				'antispam_follow' => $_GPC['antispam_follow'],
				'antispam_join' => $_GPC['antispam_join'],
            );
			$dir_url='../attachment/n1ce_mission/cert_2/'.$_W['uniacid']."/";
			mkdirs($dir_url);
			$cfg['rootca']=$_GPC['rootca2'];
			$cfg['apiclient_cert']=$_GPC['apiclient_cert2'];
			$cfg['apiclient_key']=$_GPC['apiclient_key2'];
			if ($_FILES["rootca"]["name"]){
				if(file_exists($dir_url.$settings["rootca"]))@unlink ($dir_url.$settings["rootca"]);
				$cfg['rootca']=TIMESTAMP.".pem";
				move_uploaded_file($_FILES["rootca"]["tmp_name"],$dir_url.$cfg['rootca']);
			}
			if ($_FILES["apiclient_cert"]["name"]){
				if(file_exists($dir_url.$settings["apiclient_cert"]))@unlink ($dir_url.$settings["apiclient_cert"]);
				$cfg['apiclient_cert']="cert".TIMESTAMP.".pem";
				move_uploaded_file($_FILES["apiclient_cert"]["tmp_name"],$dir_url.$cfg['apiclient_cert']);
			}
			if ($_FILES["apiclient_key"]["name"]){
				if(file_exists($dir_url.$settings["apiclient_key"]))@unlink ($dir_url.$settings["apiclient_key"]);
				$cfg['apiclient_key']="key".TIMESTAMP.".pem";
				move_uploaded_file($_FILES["apiclient_key"]["tmp_name"],$dir_url.$cfg['apiclient_key']);
			}
            if ($this->saveSettings($cfg))message('保存成功', 'refresh');
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}
	
}
?>