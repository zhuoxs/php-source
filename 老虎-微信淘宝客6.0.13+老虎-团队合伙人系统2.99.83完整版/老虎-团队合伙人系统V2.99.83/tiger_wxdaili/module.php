<?php
/**
 * 微信淘宝客群代理
 *
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');

class Tiger_wxdailiModule extends WeModule {
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

    public function addrulejq() {//添加规则
        global $_GPC, $_W;
        $rule = array(
				'uniacid' => $_W['uniacid'],
                'name' => '淘客加群规则',
				'module' => $this->modulename,
				'status' => 1,
				'displayorder' => 250,
		    );
         pdo_insert('rule',$rule);
            unset($rule['name']);
            $rule['type'] = 1;
		    $rule['rid'] = pdo_insertid();
		    $rule['content'] = '加群助手';
		    pdo_insert('rule_keyword',$rule);        
    }

	public function settingsDisplay($settings) {
		global $_W, $_GPC;

         $mblist=pdo_fetchall("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' order by id desc");

		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			//字段验证, 并获得正确的数据$dat
//            $jqzs=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='加群助手'");//
//            if($_GPC['jqzs']==1){//加群助手
//                if(empty($jqzs)){
//                  $this->addrulejq();
//                }
//            }else{
//               $name=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='加群助手'");
//                if(!empty($name)){
//                    pdo_delete('rule_keyword', array('content' => '加群助手','uniacid'=>$_W['uniacid']));
//                    pdo_delete('rule', array('name' => '淘客加群规则','uniacid'=>$_W['uniacid']));                    
//                } 
//            }
            $payment = pdo_fetch("SELECT payment FROM " . tablename('uni_settings') . " WHERE uniacid= '{$_W['uniacid']}'");
			$payment = unserialize($payment['payment']);
            $appid = $_W['account']['key'];
		    $secret = $_W['account']['secret'];
            $dat = array(
                 'appid'=>$appid,
                'secret'=>$secret,
                'mchid'=>$payment['wechat']['mchid'],
                'apikey'=>$payment['wechat']['apikey'],
                'ip'=>$_GPC['ip'],

                'fytype'=>$_GPC['fytype'],
				'zdshtype'=>$_GPC['zdshtype'],
				
                'yjtype'=>$_GPC['yjtype'],
                'adzoneid'=>$_GPC['adzoneid'],
                'siteid'=>$_GPC['siteid'],
                'flmsg'=>$_GPC['flmsg'],
                'tkAppKey'=>$_GPC['tkAppKey'],
                'tksecretKey'=>$_GPC['tksecretKey'],
                'tbid'=>$_GPC['tbid'],
                'jqzs'=>$_GPC['jqzs'],
                'jqmsg'=>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['jqmsg']),ENT_QUOTES),
                'jlqmsg'=>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['jlqmsg']),ENT_QUOTES),
                'ptpid'=>trim($_GPC ['ptpid']),
                'qqpid'=>trim($_GPC ['qqpid']),
                'zgf'=>trim($_GPC ['zgf']),
                'dlpicurl'=>$_GPC['dlpicurl'],
                    'dlmmtype'=>$_GPC['dlmmtype'],
                    'tknewurl'=>$_GPC['tknewurl'],
                    'orderys'=>$_GPC['orderys'],
					'dlnum'=>$_GPC['dlnum'],
					'fsnum'=>$_GPC['fsnum'],
					'dlsqtype'=>$_GPC['dlsqtype'],

                    'dlsqtx'=>$_GPC['dlsqtx'],
                        'glyopenid'=>$_GPC['glyopenid'],
                        'dlshtgtx'=>$_GPC['dlshtgtx'],
                        'yktype'=>$_GPC['yktype'],
                        'tbuid'=>$_GPC['tbuid'],
                        'ggcontent'=>$_GPC['ggcontent'],
                        'gglink'=>$_GPC['gglink'],
                        'jsms'=>$_GPC['jsms'],
                        'sylmkey'=>$_GPC['sylmkey'],
                        'gyspsj'=>$_GPC['gyspsj'],
                        'txxzprice'=>$_GPC['txxzprice'],
                        'kqbdsj'=>$_GPC['kqbdsj'],
                        'bdteljl'=>$_GPC['bdteljl'],
                        'tklnewtype'=>$_GPC['tklnewtype'],
                        'khgettx'=>$_GPC['khgettx'],
                        'pdddlxs'=>$_GPC['pdddlxs'],
                        'qdtype'=>$_GPC['qdtype'],
                        'qdpid'=>$_GPC['qdpid'],
                        'qdcode'=>$_GPC['qdcode'],
                        'qdtgurl'=>trim($_GPC['qdtgurl']),
                        
                        'zydwz'=>$_GPC['zydwz'],
                        'sinkey'=>$_GPC['sinkey'],
                        'dwzlj'=>$_GPC['dwzlj'],
                        'xqdwzxs'=>$_GPC['xqdwzxs'],
                        'logintype'=>$_GPC['logintype'],
                        'lxddtype'=>$_GPC['lxddtype'],
                        'lxjlrmb'=>$_GPC['lxjlrmb'],
                        'kfpicurl'=>$_GPC['kfpicurl'],
                        'newdltype'=>$_GPC['newdltype'],
                        'dbcdtype'=>$_GPC['dbcdtype'],
                       'newdlxjtype'=>$_GPC['newdlxjtype'],
                       'jddlxs'=>$_GPC['jddlxs'],
                );
			
            if ($this->saveSettings($dat)) {
				message('保存成功', 'refresh');
			}
		}
//        print_r($settings);
//        exit;
		//这里来展示设置项表单
		include $this->template('setting');
	}

}