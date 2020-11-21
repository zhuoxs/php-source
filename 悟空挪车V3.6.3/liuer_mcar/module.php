<?php
/**
 * liuer_mcar模块定义
 *
 * @author 模块终结者
 * @url 
 */
defined('IN_IA') or exit('Access Denied');
require_once 'common/Table.php';

class Liuer_mcarModule extends WeModule {
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
	}

    public function settingsDisplay($settings){
        global $_W,$_GPC;

        $moduleName = $_W['current_module']['name'];
        $imageUrl = $_W['siteroot'].'addons/'.$moduleName.'/';

        //初始化

        if(checksubmit()){
            $data = [
                'theme' => $_GPC['theme'],
                'sitename' => $_GPC['sitename'],
                'title_isshow' => $_GPC['title_isshow'],
                'area' => $_GPC['area'],
                'area_prefix' => $_GPC['area_prefix'],
                'postage' => $_GPC['postage'],
                'postage_plus' => $_GPC['postage_plus'],
                'success_text' => $_GPC['success_text'],
                'address_isshow' => $_GPC['address_isshow'],
                'quick_text' => $_GPC['quick_text'],
                'log_during' => $_GPC['log_during'],
                'btn_color' => $_GPC['btn_color'],
                'btn_border' => $_GPC['btn_border'],
                'want' => $_GPC['want'],
                'want_text' => $_GPC['want_text'],
                'want_tips' => $_GPC['want_tips'],
                'want_url' => $_GPC['want_url'],
                'banner' => $_GPC['banner'],
                'che_banner' => $_GPC['che_banner'],
                'nuo_banner' => $_GPC['nuo_banner'],
                'gonggao' => $_GPC['gonggao'],
                'gonggao_url' => $_GPC['gonggao_url'],
                'fontsize' => $_GPC['fontsize'],
                'jianju' => $_GPC['jianju'],
                'member_jianju' => $_GPC['member_jianju'],
                'saorao_jianju' => $_GPC['saorao_jianju'],
                'header_isshow' => $_GPC['header_isshow'],

                'diy_content' => $_GPC['diy_content'],
                'map_url' => $_GPC['map_url'],
                'map_key' => $_GPC['map_key'],

                //shop
                'category' => $_GPC['category'],
                'fill_banner' => $_GPC['fill_banner'],
                'fx_level' => $_GPC['fx_level'],
               /* 'apiclient_cert' => $_GPC['apiclient_cert'],
                'apiclient_key' => $_GPC['apiclient_key'],*/
                'yongjin_tpl' => $_GPC['yongjin_tpl'],
                'yongjin_title' => $_GPC['yongjin_title'],
                'yongjin_remark' => $_GPC['yongjin_remark'],
                'fenxiao_help' => $_GPC['fenxiao_help'],
                'shop_banner' => $_GPC['shop_banner'],

                'is_access' => $_GPC['is_access'],
                'cishu' => $_GPC['cishu'],
                'platform' => $_GPC['platform'],
                'tel_accessKeyId' => $_GPC['tel_accessKeyId'],
                'tel_accessKeySecret' => $_GPC['tel_accessKeySecret'],
                'tel_chizi' => $_GPC['tel_chizi'],
                'tel_during' => $_GPC['tel_during'],
                'tel_url' => $_GPC['tel_url'],

                'app_key' => $_GPC['app_key'],
                'app_secret' => $_GPC['app_secret'],
                'app_area' => $_GPC['app_area'],
                'app_during' => $_GPC['app_during'],
                'app_url' => $_GPC['app_url'],

                'qq_access' => $_GPC['qq_access'],
                'qq_appid' => $_GPC['qq_appid'],
                'qq_appkey' => $_GPC['qq_appkey'],
                'qq_id' => $_GPC['qq_id'],

                'is_sms' => $_GPC['is_sms'],
                'sms_length' => $_GPC['sms_length'],
                'sms_server' => $_GPC['sms_server'],
                'send_limit_time' => $_GPC['send_limit_time'],
                'send_limit_offset' => $_GPC['send_limit_offset'],
                'send_limit_count' => $_GPC['send_limit_count'],
                'sms_accessKeyId' => $_GPC['sms_accessKeyId'],
                'sms_accessKeySecret' => $_GPC['sms_accessKeySecret'],
                'sms_mark' => $_GPC['sms_mark'],
                'sms_templateid' => $_GPC['sms_templateid'],
                'sms_account' => $_GPC['sms_account'],
                'sms_password' => $_GPC['sms_password'],

                'bindtpl' => $_GPC['bindtpl'],
                'bind_first' => $_GPC['bind_first'],
                'bind_remark' => $_GPC['bind_remark'],
                'noticetpl' => $_GPC['noticetpl'],
                'adminid' => $_GPC['adminid'],
                'notice_source' => $_GPC['notice_source'],
                'notice_limit' => $_GPC['notice_limit'],
                'notice_from' => $_GPC['notice_from'],
                'detail_notice' => $_GPC['detail_notice'],
                'done_notice' => $_GPC['done_notice'],
                'notice_mark' => $_GPC['notice_mark'],
                'done_from' => $_GPC['done_from'],
                'done_mark' => $_GPC['done_mark'],
                'noticeorder' => $_GPC['noticeorder'],
                'notice_admin' => $_GPC['notice_admin'],

                'sharetitle' => $_GPC['sharetitle'],
                'sharedesc' => $_GPC['sharedesc'],
                'shareimg' => $_GPC['shareimg'],
                'need_guanzhu' => $_GPC['need_guanzhu'],
                'hu_need_guanzhu' => $_GPC['hu_need_guanzhu'],
                'hu_wenan' => $_GPC['hu_wenan'],
                'show_need_guanzhu' => $_GPC['show_need_guanzhu'],
                'show_wenan' => $_GPC['show_wenan'],
                'guanzhu_img' => $_GPC['guanzhu_img'],

                //vip
                'is_auto' => $_GPC['is_auto'],
                'is_auto_level' => $_GPC['is_auto_level'],
                'make_auto_level' => $_GPC['make_auto_level'],
                'vip_tpl' => $_GPC['vip_tpl'],
                'member_banner' => $_GPC['member_banner'],
                'vip_banner' => $_GPC['vip_banner'],
                'fenxiao_banner' => $_GPC['fenxiao_banner'],
                'spread_banner' => $_GPC['spread_banner'],
                'qr_url' => $_GPC['qr_url'],
                'qr_x' => $_GPC['qr_x'],
                'qr_y' => $_GPC['qr_y'],
                'qr_size' => $_GPC['qr_size'],
                'qr_margin' => $_GPC['qr_margin'],
                'vip_text' => $_GPC['vip_text'],
                'is_saorao' => $_GPC['is_saorao'],
                'print_bg' => $_GPC['print_bg'],
                'is_print' => $_GPC['is_print'],
                'def_private' => $_GPC['def_private'],
                'saorao_banner' => $_GPC['saorao_banner'],
                'vip_access' => $_GPC['vip_access'] ? implode(',',$_GPC['vip_access']) : '',

                'agent_category' => $_GPC['agent_category'],
                'agent_setting' => $_GPC['agent_setting'],
                'agent_content' => $_GPC['agent_content']
            ];

            if($this->saveSettings($data)){
                message('保存成功','referer');
            }else{
                message('保存失败');
            }
        }else{
            //初始化
            $settings['theme'] = isset($settings['theme']) ? $settings['theme'] :'1';
            $settings['sitename'] = isset($settings['sitename']) ? $settings['sitename'] :'悟空挪车';
            $settings['title_isshow'] = isset($settings['title_isshow']) ? $settings['title_isshow'] :1;
            $settings['area'] = isset($settings['area']) ? $settings['area'] :'京';
            $settings['area_prefix'] = isset($settings['area_prefix']) ? $settings['area_prefix'] :'A';
            $settings['postage'] = isset($settings['postage']) ? $settings['postage'] :'0';
            $settings['postage_plus'] = isset($settings['postage_plus']) ? $settings['postage_plus'] :'0';
            $settings['success_text'] = isset($settings['success_text']) ? $settings['success_text'] :'啦啦啦，请您耐心等候一下';
            $settings['address_isshow'] = isset($settings['address_isshow']) ? $settings['address_isshow'] :1;
            $settings['quick_text'] = isset($settings['quick_text']) ? $settings['quick_text'] :'挡住车了,挡住路了,没关车灯,后备箱没关,车辆被损坏,手工填写';
            $settings['log_during'] = isset($settings['log_during']) ? $settings['log_during'] :3;
            $settings['btn_color'] = isset($settings['btn_color']) ? $settings['btn_color'] :'#ffb400';
            $settings['btn_border'] = isset($settings['btn_border']) ? $settings['btn_border'] :'5px';
            $settings['want'] = isset($settings['want']) ? $settings['want'] :1;
            $settings['want_text'] = isset($settings['want_text']) && !empty($settings['want_text']) ? $settings['want_text'] :'我也要挪车码';
            $settings['want_tips'] = isset($settings['want_tips']) && !empty($settings['want_tips']) ? $settings['want_tips'] :'拨打电话不会显示您和车主手机号码，不收取任何费用';
            $settings['want_url'] = isset($settings['want_url']) ? $settings['want_url'] :'';

            $settings['banner'] = isset($settings['banner']) ? $settings['banner'] :[$imageUrl . 'assets/images/slogan1.jpg',$imageUrl . 'assets/images/slogan2.jpg'];
            $settings['che_banner'] = isset($settings['che_banner']) ? $settings['che_banner'] :[$imageUrl . 'assets/images/bg.jpg'];
            $settings['nuo_banner'] = isset($settings['nuo_banner']) ? $settings['nuo_banner'] :[$imageUrl . 'assets/images/bg_top.jpg'];

            $settings['gonggao'] = isset($settings['gonggao']) ? $settings['gonggao'] :'悟空挪车是一款界面ui非常nice的小应用';
            $settings['gonggao_url'] = isset($settings['gonggao_url']) && !empty($settings['gonggao_url']) ? $settings['gonggao_url'] :'javascript:;';
            $settings['fontsize'] = isset($settings['fontsize']) ? $settings['fontsize'] :'0.68';
            $settings['jianju'] = isset($settings['jianju']) ? $settings['jianju'] :'15px';
            $settings['member_jianju'] = isset($settings['member_jianju']) ? $settings['member_jianju'] :'10px';
            $settings['saorao_jianju'] = isset($settings['saorao_jianju']) ? $settings['saorao_jianju'] :'10px';
            $settings['header_isshow'] = isset($settings['header_isshow']) ? $settings['header_isshow'] : 1;
            $settings['need_guanzhu'] = isset($settings['need_guanzhu']) ? $settings['need_guanzhu'] : 1;
            $settings['hu_need_guanzhu'] = isset($settings['hu_need_guanzhu']) ? $settings['hu_need_guanzhu'] : 1;
            $settings['hu_wenan'] = isset($settings['hu_wenan']) ? $settings['hu_wenan'] : '发起挪车请先关注公共号';

            $settings['show_wenan'] = isset($settings['show_wenan']) ? $settings['show_wenan'] : '关注之后，及时收到通知～';
            $settings['show_need_guanzhu'] = isset($settings['show_need_guanzhu']) ? $settings['show_need_guanzhu'] : 1;
            $settings['diy_content'] = isset($settings['diy_content']) ? $settings['diy_content'] : '这里可以自定义内容了';
            $settings['map_url'] = isset($settings['map_url']) ? $settings['map_url'] : 'https://apis.map.qq.com/ws/geocoder/v1/?';
            $settings['map_key'] = isset($settings['map_key']) ? $settings['map_key'] : 'FMXBZ-OTLW4-TKJU4-XZCEY-VEZHE-CKBJU';
            $settings['is_access'] = isset($settings['is_access']) ? $settings['is_access'] : 0;
            $settings['cishu'] = isset($settings['cishu']) ? $settings['cishu'] : 0;
            $settings['platform'] = isset($settings['platform']) ? $settings['platform'] : 1;
            $settings['qq_access'] = isset($settings['qq_access']) ? $settings['qq_access'] : 0;
            $settings['fenxiao_help'] = isset($settings['fenxiao_help']) ? $settings['fenxiao_help'] : '使用说明';
            $settings['is_sms'] = isset($settings['is_sms']) ? $settings['is_sms'] : 1;
            $settings['sms_length'] = isset($settings['sms_length']) ? $settings['sms_length'] : 6;
            $settings['sms_server'] = isset($settings['sms_server']) ? $settings['sms_server'] : 11;
            $settings['send_limit_time'] = isset($settings['send_limit_time']) ? $settings['send_limit_time'] : 60;
            $settings['send_limit_offset'] = isset($settings['send_limit_offset']) ? $settings['send_limit_offset'] : 10;
            $settings['send_limit_count'] = isset($settings['send_limit_count']) ? $settings['send_limit_count'] : 5;
            $settings['notice_source'] = isset($settings['notice_source']) ? $settings['notice_source'] : '悟空挪车';
            $settings['detail_notice'] = isset($settings['detail_notice']) ? $settings['detail_notice'] : 1;
            $settings['done_notice'] = isset($settings['done_notice']) ? $settings['done_notice'] : 1;
            $settings['notice_from'] = isset($settings['notice_from']) ? $settings['notice_from'] : '车主已收到挪车通知';
            $settings['notice_mark'] = isset($settings['notice_mark']) ? $settings['notice_mark'] : '我也要申请挪车码';
            $settings['done_from'] = isset($settings['done_from']) ? $settings['done_from'] : '恭喜您，挪车完成';
            $settings['done_mark'] = isset($settings['done_mark']) ? $settings['done_mark'] : '我也要申请挪车码';
            $settings['notice_limit'] = isset($settings['notice_limit']) ? $settings['notice_limit'] : 60;
            $settings['tel_url'] = isset($settings['tel_url']) ? $settings['tel_url'] : murl('entry',['m'=>'liuer_mcar','do'=>'return'],true,true);
            $settings['app_url'] = isset($settings['app_url']) ? $settings['app_url'] : murl('entry',['m'=>'liuer_mcar','do'=>'huawei'],true,true);
            $settings['qr_url'] = isset($settings['qr_url']) ? $settings['qr_url'] : murl('entry',['m'=>'liuer_mcar','do'=>'fenxiao'],true,true);



            //shop
            $settings['fill_banner'] = isset($settings['fill_banner']) ? $settings['fill_banner'] :$imageUrl . 'assets/images/fill.gif';
            $settings['shop_banner'] = isset($settings['shop_banner']) ? $settings['shop_banner'] :$imageUrl . 'assets/images/shop_banner.jpg';

            $settings['banner'] = isset($settings['banner']) ? $settings['banner'] :[$imageUrl . 'assets/images/slogan1.jpg',$imageUrl . 'assets/images/slogan2.jpg'];
            $settings['is_print'] = isset($settings['is_print']) ? $settings['is_print'] : 1;
            $settings['print_bg'] = isset($settings['print_bg']) && !empty($settings['print_bg']) ? $settings['print_bg'] :[$imageUrl . 'assets/bg/1.png',$imageUrl . 'assets/bg/2.png',$imageUrl . 'assets/bg/3.png',$imageUrl . 'assets/bg/4.png',$imageUrl . 'assets/bg/5.png',$imageUrl . 'assets/bg/6.png',$imageUrl . 'assets/bg/7.png',$imageUrl . 'assets/bg/8.png'];

            //vip
            $settings['member_banner'] = isset($settings['member_banner']) ? $settings['member_banner'] :'';
            $settings['is_auto'] = isset($settings['is_auto']) ? $settings['is_auto'] :0;
            $settings['is_auto_level'] = isset($settings['is_auto_level']) ? $settings['is_auto_level'] :0;
            $settings['make_auto_level'] = isset($settings['make_auto_level']) ? $settings['make_auto_level'] :0;
            $settings['vip_tpl'] = isset($settings['vip_tpl']) ? $settings['vip_tpl'] :1;
            $settings['vip_banner'] = isset($settings['vip_banner']) ? $settings['vip_banner'] :$imageUrl . 'assets/images/vip.png';
            $settings['fenxiao_banner'] = isset($settings['fenxiao_banner']) ? $settings['fenxiao_banner'] :$imageUrl . 'assets/images/vip.png';
            $settings['spread_banner'] = isset($settings['spread_banner']) && !empty($settings['spread_banner']) ? $settings['spread_banner'] :$imageUrl . 'assets/images/wxbg.jpg';
            $settings['qr_x'] = isset($settings['qr_x']) && !empty($settings['qr_x']) ? $settings['qr_x'] :'65';
            $settings['qr_y'] = isset($settings['qr_y']) && !empty($settings['qr_y']) ? $settings['qr_y'] :'418';
            $settings['qr_size'] = isset($settings['qr_size']) && !empty($settings['qr_size']) ? $settings['qr_size'] :'7';
            $settings['qr_margin'] = isset($settings['qr_margin']) && !empty($settings['qr_margin']) ? $settings['qr_margin'] :'5';
            $settings['vip_text'] = isset($settings['vip_text']) ? $settings['vip_text'] : '';
            $settings['is_saorao'] = isset($settings['is_saorao']) ? $settings['is_saorao'] : 0;

            $settings['def_private'] = isset($settings['def_private']) ? $settings['def_private'] : 0;
            $settings['saorao_banner'] = isset($settings['saorao_banner']) ? $settings['saorao_banner'] :$imageUrl . 'assets/images/saorao.jpg';

            //saorao_banner
//            $settings['vip_no_text'] = isset($settings['vip_no_text']) ? $settings['vip_no_text'] : 'private';
            $settings['vip_access'] = isset($settings['vip_access']) ? $settings['vip_access'] : 'private';
            $settings['agent_category'] = isset($settings['agent_category']) ? $settings['agent_category'] : 0;
            $settings['agent_setting'] = isset($settings['agent_setting']) ? $settings['agent_setting'] : 0;
            $settings['agent_content'] = isset($settings['agent_content']) ? $settings['agent_content'] : 0;

            //获取所有的等级级别
            $vip_groups = pdo_getall(Table::GROUP,['weid'=>$_W['uniacid']],'','',['sort asc']);

            include $this->template('settings');
        }
    }

	public function welcomeDisplay($menus = array()) {
        global  $_W,$_GPC;
		//这里来展示DIY管理界面
        $this->__accounts();

        $entries = module_entries('liuer_mcar');
        //获取代理商个数
        $agentCount = pdo_fetchcolumn("select count(*) from " . tablename(Table::AGENT) ." where status = ".Table::STATUS_NORMAL . " and weid = ".$_W['uniacid']);
        $userCount = pdo_fetchcolumn("select count(*) from " . tablename(Table::USER) ." where status = ".Table::STATUS_NORMAL . " and weid = ".$_W['uniacid']);
        $orderCount = pdo_fetchcolumn("select count(*) from " . tablename(Table::ORDER) ." where weid = ".$_W['uniacid']);
        $goodCount = pdo_fetchcolumn("select count(*) from " . tablename(Table::GOODS) ." where weid = ".$_W['uniacid']);

        //七天的统计
        $maxDate = date("Y-m-d");
        $res = [];
        for($i = 0 ; $i < 7 ; $i ++){
            $curDate = date("Y-m-d",strtotime("-{$i} day"));

            //1.挪车次数
            //2.订单数
            //3.新增车辆
            //4.车辆总数
            $start = strtotime($curDate);
            $end = $start + 24*3600 - 1;
            $nccs = pdo_fetchcolumn("select count(*) from ". tablename(Table::MOVELOG) . " where created_at between :start and :end and weid = :weid",[':start'=>$start,':end'=>$end,':weid'=>$_W['uniacid']]);
            $dingdan = pdo_fetchcolumn("select count(*) from ". tablename(Table::ORDER) . " where created_at between :start and :end and weid = :weid",[':start'=>$start,':end'=>$end,':weid'=>$_W['uniacid']]);
            $cheliang = pdo_fetchcolumn("select count(*) from ". tablename(Table::USER) . " where created_at between :start and :end and weid = :weid",[':start'=>$start,':end'=>$end,':weid'=>$_W['uniacid']]);
            $clzs = pdo_fetchcolumn("select count(*) from ". tablename(Table::USER) . " where weid = :weid",[':weid'=>$_W['uniacid']]);

            $res['date'][] = $curDate;
            $res['nccs'][] = $nccs;
            $res['dingdan'][] = $dingdan;
            $res['cheliang'][] = $cheliang;
            $res['clzs'][] = $clzs;
        }

        $res['date'] = "'".implode("','",array_reverse($res['date']))."'";
        $res['nccs'] = implode(",",array_reverse($res['nccs']));
        $res['dingdan'] = implode(",",array_reverse($res['dingdan']));
        $res['cheliang'] = implode(",",array_reverse($res['cheliang']));
        $res['clzs'] = implode(",",array_reverse($res['clzs']));


//        echo '<pre>';
//        print_r($entries);
		include $this->template('welcome');
	}

    private function __accounts(){
        global $_W,$_GPC;

        $module_name = $_W['current_module']['name'];
        if (empty($module_name)) {
            exit();
        }
        $accounts_list = module_link_uniacid_fetch($_W['uid'], $module_name);
        if (empty($accounts_list)) {
            exit();
        }
        $selected_account = array();
        foreach ($accounts_list as $account) {
            if (empty($account['uniacid']) || $account['uniacid'] != $_W['uniacid']) {
                continue;
            }
            if (in_array($_W['account']['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) {
                if (!empty($account['version_id'])) {
                    $version_info = miniapp_version($account['version_id']);
                    $account['version_info'] = $version_info;
                }
                $selected_account = $account;
                break;
            } elseif (in_array($_W['account']['type'], array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_ALIAPP_NORMAL))) {
                $version_info = miniapp_version($account['version_id']);
                $account['version_info'] = $version_info;
                $selected_account = $account;
                break;
            }
        }

        foreach ($accounts_list as $key => $account) {
            $url = url('module/display/switch', array('uniacid' => $account['uniacid'], 'module_name' => $module_name));
            if (!empty($account['version_id'])) {
                $url .= '&version_id=' . $account['version_id'];
            }
            $accounts_list[$key]['url'] = $url;
        }

        $_W['accounts'] = $accounts_list;
    }

}