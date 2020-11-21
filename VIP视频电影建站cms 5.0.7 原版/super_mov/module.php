<?php
/**
 * 全网VIP视频在线免费看模块定义
 *
 * @author cyl
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
class Super_movModule extends WeModule {
	
	public function settingsDisplay($settings) {
		global $_W, $_GPC;
        $content = '【短信签名】您的验证码是：{code}，请在5分钟内使用。请勿泄露。';    
        $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
        $setting = uni_setting_load('payment', $_W['uniacid']);
        $modules_bindings = pdo_get('modules_bindings', array('do' => 'index','module'=>'super_mov'));        
		if(checksubmit()) {
			//字段验证, 并获得正确的数据$dat
			$data = $_GPC['data'];	
            $data['shuoming'] = htmlspecialchars_decode($data['shuoming']); 
			$data['tongji'] = htmlspecialchars_decode($data['tongji']);	
			foreach($_GPC['member_title'] as $k => $v) {
                $v = trim($v);
                if(empty($v)) continue;
                $member[] = array(                    
                    'member_title' => $v,
                    'member_link' => $_GPC['member_link'][$k],
                    'member_vip' => $_GPC['member_vip'][$k],
                );                
            }

            $data['member'] = iserializer($member);   
            foreach($_GPC['card_title'] as $k => $v) {
                $v = trim($v);
                if(empty($v)) continue;
                $card[] = array(                    
                    'card_title' => $v,
                    'card_day' => $_GPC['card_day'][$k],
                    'card_fee' => $_GPC['card_fee'][$k],
                    'card_credit' => $_GPC['card_credit'][$k],
                );                
            }
            $data['card'] = iserializer($card);      			
			if (!$this->saveSettings($data)) {
				message('保存信息失败','','error');   // 保存失败
			} else {
				message('保存信息成功','','success'); // 保存成功
			}
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}

}