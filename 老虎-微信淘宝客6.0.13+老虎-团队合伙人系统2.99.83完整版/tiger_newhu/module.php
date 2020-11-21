<?php
/**
 * 积分宝模块微站定义
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
define('OB_ROOT', IA_ROOT . '/attachment/tiger_newhu');
class tiger_newhuModule extends WeModule {
    public function fieldsFormDisplay($rid = 0) {

	}

    public function fieldsFormSubmit($rid) {
		global $_GPC, $_W;
        $key=str_replace('[', "", $_GPC['keywords']);
        $key=str_replace(']', "",$key);
        $key=str_replace('&quot;', '"',$key);
        $keywords=json_decode($key, true);   
        //print_r($keywords);
       // exit;

        $id = intval($_GPC['reply_id']);
        $ques = $_GPC['ques'];
			$answer = $_GPC['answer'];
			$questions = '';
			foreach ($ques as $key => $value) {
				if (empty($value)) continue;
				$questions[] = array('question'=>$value,'answer'=>$answer[$key]);
			}
        $insert = array(
            
        );
//         if (empty($id)) {
//             $id = pdo_insert($this->reply, $insert);
//             //肯定好友
//             $rule = array(
// 				'uniacid' => $_W['uniacid'],
//                 'name' => '肯定好友(这是设置好的，不要去修改)',
// 				'module' => $this->modulename,
// 				'status' => 1,
// 				'displayorder' => 253,
// 		    );
// 		    pdo_insert('rule',$rule);
//             unset($rule['name']);
//             $rule['type'] = 1;
// 		    $rule['rid'] = pdo_insertid();
// 		    $rule['content'] = '肯定好友';
// 		    pdo_insert('rule_keyword',$rule);
//             //肯定好友结束
//             //message('保存成功', 'refresh');
//         } else {
//             unset($insert['createtime']);
//             pdo_update($this->reply, $insert, array('id' => $id));
//             pdo_update('qrcode',array('keyword'=>$keywords['content'],'name'=>$_GPC ['title']),array('uniacid'=>$_W['uniacid']));
//             //message('修改成功', 'refresh');
//         }
	}

    public function addrule() {//添加规则
        global $_GPC, $_W;
        $rule = array(
				'uniacid' => $_W['uniacid'],
                'name' => '老虎淘客规则说明',
				'module' => $this->modulename,
				'status' => 1,
				'displayorder' => 0,
		    );
         pdo_insert('rule',$rule);
            unset($rule['name']);
            $rule['type'] = 3;
		    $rule['rid'] = pdo_insertid();
		    $rule['content'] = 'http';
		    pdo_insert('rule_keyword',$rule);        
    }
    
    public function addrulepdd() {//添加规则拼多多规则 
        global $_GPC, $_W;
        $rule = array(
				'uniacid' => $_W['uniacid'],
                'name' => '推客拼多多规则',
				'module' => $this->modulename,
				'status' => 1,
				'displayorder' => 0,
		    );
         pdo_insert('rule',$rule);
            unset($rule['name']);
            $rule['type'] = 3;
		    $rule['rid'] = pdo_insertid();
		    $rule['content'] = 'yangkeduo.com';
		    pdo_insert('rule_keyword',$rule);        
    }
    
    public function addrulejd() {//添加规则拼多多规则 
        global $_GPC, $_W;
        $rule = array(
				'uniacid' => $_W['uniacid'],
                'name' => '推客京东规则',
				'module' => $this->modulename,
				'status' => 1,
				'displayorder' => 0,
		    );
         pdo_insert('rule',$rule);
            unset($rule['name']);
            $rule['type'] = 3;
		    $rule['rid'] = pdo_insertid();
		    $rule['content'] = 'jd.com';
		    pdo_insert('rule_keyword',$rule);        
    }

    

    public function addrulekl() {//添加规则
        global $_GPC, $_W;
        $rule = array(
				'uniacid' => $_W['uniacid'],
                'name' => '老虎淘客口令说明',
				'module' => $this->modulename,
				'status' => 1,
				'displayorder' => 0,
		    );
         pdo_insert('rule',$rule);
            unset($rule['name']);
            $rule['type'] = 3;
		    $rule['rid'] = pdo_insertid();
		    $rule['content'] = '￥';
		    pdo_insert('rule_keyword',$rule);        
    }
    public function addrulekl2() {//添加规则
        global $_GPC, $_W;
        $rule = array(
				'uniacid' => $_W['uniacid'],
                'name' => '老虎淘客口令说明2',
				'module' => $this->modulename,
				'status' => 1,
				'displayorder' => 0,
		    );
         pdo_insert('rule',$rule);
            unset($rule['name']);
            $rule['type'] = 3;
		    $rule['rid'] = pdo_insertid();
		    $rule['content'] = '《';
		    pdo_insert('rule_keyword',$rule);        
    }

    public function addrule1() {//添加规则 ^([\u4e00-\u9fa5]).+$  任意字符
        global $_GPC, $_W;
        $rule = array(
				'uniacid' => $_W['uniacid'],
                'name' => '老虎公众号找产品',
				'module' => $this->modulename,
				'status' => 1,
				'displayorder' => 0,
		    );
         pdo_insert('rule',$rule);
            unset($rule['name']);
            $rule['type'] = 3;
		    $rule['rid'] = pdo_insertid();
		    $rule['content'] = "找";
		    pdo_insert('rule_keyword',$rule);        
    }

    public function ruleDeleted($rid) {
        global $_W;
		//删除规则时调用，这里 $rid 为对应的规则编号
		pdo_delete($this->reply, array('rid' => $rid));
        $name=pdo_fetch('select title from '.tablename($this->modulename."_poster")." where rid='{$rid}'");
        pdo_delete('qrcode',array('name'=>$name['title'],'uniacid'=>$_W['uniacid']));
	}


	
	public function settingsDisplay($settings) {
		global $_GPC,$_W;
        //$this->addrule1();
        $cfg = $this->module['config'];
        $ddcjxz = unserialize($cfg['ddcjxz']);
        $ddcjjl = unserialize($cfg['ddcjjl']);
        foreach ($ddcjxz as $key => $value) {
            if (empty($value)) continue;
            $tplist[] = array('ddcjxz'=>$value,'ddcjjl'=>$ddcjjl[$key]);
        }
//      echo "<pre>";
//      print_r($tplist);



        $tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
       // print_r($tksign);
        //exit;
        $mblist=pdo_fetchall("select * from ".tablename($this->modulename."_mobanmsg")." where weid='{$_W['uniacid']}' order by id desc");//
				$tksignlist = pdo_fetchall ( 'select * from ' . tablename ($this->modulename . "_tksign" ) . " where weid='{$_W['uniacid']}' order by id desc" );
  				
				
				
				
        load ()->func ( 'tpl' );       
		if (checksubmit()) {
            $name=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='http'");//
            $zhao=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='找'");//找产品
            $kl=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='￥'");//
            $kl2=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='《'");//
            $pddrul=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='yangkeduo.com'");//
            $jdrul=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='jd.com'");//
            if($_GPC['gzhfl']==1){
                if(empty($name)){
                  $this->addrule();
                }
                if(empty($kl)){
                  $this->addrulekl();
                  $this->addrulekl2();
                }
            }else{
                $name=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='http'");
                if(!empty($name)){
                    pdo_delete('rule_keyword', array('content' => 'http','uniacid'=>$_W['uniacid']));
                    pdo_delete('rule', array('name' => '老虎淘客规则说明','uniacid'=>$_W['uniacid']));     
                    
                    pdo_delete('rule_keyword', array('content' => '￥','uniacid'=>$_W['uniacid']));
                    pdo_delete('rule', array('name' => '老虎淘客口令说明','uniacid'=>$_W['uniacid']));  
                    pdo_delete('rule_keyword', array('content' => '《','uniacid'=>$_W['uniacid']));
                    pdo_delete('rule', array('name' => '老虎淘客口令说明2','uniacid'=>$_W['uniacid']));  
                }              
            }

            if($_GPC['tttype']==1){
                if(empty($zhao)){
                  $this->addrule1();
                }
            }else{
               $name=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='找'");
                if(!empty($name)){
                    pdo_delete('rule_keyword', array('content' => '找','uniacid'=>$_W['uniacid']));
                    pdo_delete('rule', array('name' => '老虎公众号找产品','uniacid'=>$_W['uniacid']));                    
                } 
            }
            
            if($_GPC['pddcq']==1){
                if(empty($pddrul)){
                  $this->addrulepdd();
                }
            }else{
               $name=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='yangkeduo.com'");
                if(!empty($name)){
                    pdo_delete('rule_keyword', array('content' => 'yangkeduo.com','uniacid'=>$_W['uniacid']));
                    pdo_delete('rule', array('name' => '推客拼多多规则','uniacid'=>$_W['uniacid']));                    
                } 
            }
            
            if($_GPC['jdcq']==1){
                if(empty($jdrul)){
                  $this->addrulejd();
                }
            }else{
               $name=pdo_fetch("select * from ".tablename("rule_keyword")." where uniacid='{$_W['uniacid']}' and content='jd.com'");
                if(!empty($name)){
                    pdo_delete('rule_keyword', array('content' => 'jd.com','uniacid'=>$_W['uniacid']));
                    pdo_delete('rule', array('name' => '推客京东规则','uniacid'=>$_W['uniacid']));                    
                } 
            }


            //


			 load()->func('file');
             mkdirs(OB_ROOT . '/cert/'.$_W['uniacid']);
             $r=true;    
            if(!empty($_GPC['cert'])) { 
                $ret = file_put_contents(OB_ROOT.'/cert/'.$_W['uniacid'].'/apiclient_cert.pem', trim($_GPC['cert']));
                $r = $r && $ret;               
            }
            if(!empty($_GPC['key'])) {
                $ret = file_put_contents(OB_ROOT.'/cert/'.$_W['uniacid'].'/apiclient_key.pem', trim($_GPC['key']));
                $r = $r && $ret;
            }
            if(!empty($_GPC['ca'])) {
                $ret = file_put_contents(OB_ROOT.'/cert/'.$_W['uniacid'].'/rootca.pem', trim($_GPC['ca']));
                $r = $r && $ret;
            }
            if(!$r) {
                message('证书保存失败, 请保证 /attachment/tiger_newhu/cert/ 目录可写');
            }

            load()->classs('cloudapi');
            $api = new CloudApi();
            $result = $api->get('site', 'module');
            if($result['trade']==1){
              $cxsqtype=1;
            }else{
              $cxsqtype=2;
            }

			$cfg = array(
			    'ddcjxz'=>serialize($_GPC['ddcjxz']),
                'ddcjjl'=>serialize($_GPC['ddcjjl']),
				'dlgzsdtype'=>$_GPC['dlgzsdtype'],
                'cjlxtype'=>$_GPC['cjlxtype'],
                'dztypelx'=>$_GPC['dztypelx'],
                'tiger_newhu_fansnum'=>$_GPC['tiger_newhu_fansnum'],
				'tiger_newhu_usr' =>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['tiger_newhu_usr']),ENT_QUOTES),
                'nbfchangemoney' => $_GPC['nbfchangemoney'],
				'nbfhelpgeturl'=>$_GPC['nbfhelpgeturl'],
				'nbfwxpaypath'=>$arr_json,
                'mchid'=>trim($_GPC['mchid']),
                'apikey'=>trim($_GPC['apikey']),
                'appid'=>trim($_GPC['appid']),
                'secret'=>trim($_GPC['secret']),
                'txtype'=>$_GPC['txtype'],
								'jdppddtype'=>$_GPC['jdppddtype'],
                'szurl' => $_GPC ['szurl'],
                'client_ip'=>trim($_GPC['client_ip']),
                'szcolor' => $_GPC ['szcolor'],
                'rmb_num' => $_GPC ['rmb_num'],
                'day_num' => $_GPC ['day_num'],
                'tx_num' => $_GPC ['tx_num'],     
                'tklleft' => $_GPC ['tklleft'],     
                'tklright' => $_GPC ['tklright'],                
                'hztype' => $_GPC ['hztype'],
                'qdcode'=>$_GPC ['qdcode'],
								'regurlxy'=>$_GPC['regurlxy'],
								'qdpid'=>$_GPC['qdpid'],
                'copyright' => $_GPC ['copyright'],
                'txinfo' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['txinfo']),ENT_QUOTES),
                'locationtype'=>$_GPC['locationtype'],
                'jiequan'=>$_GPC['jiequan'],
                'paihang'=>$_GPC['paihang'],
                'style'=>$_GPC['style'],
                'head'=>$_GPC['head'],
                'txon' => $_GPC ['txon'],
                'gztitle'=>$_GPC['gztitle'],
                'gzpicurl'=>$_GPC['gzpicurl'],
                'gzdescription'=>$_GPC['gzdescription'],
                'gzurl'=>$_GPC['gzurl'],
                'towurl'=>$_GPC['towurl'],
                'cjss'=>$_GPC['cjss'],
                'serackkey'=>$_GPC['serackkey'],
                'logintype'=>$_GPC['logintype'],
                'hlAppKey'=>$_GPC['hlAppKey'],
                'cjddgz'=>$_GPC['cjddgz'],
                'gdfxtype'=>$_GPC['gdfxtype'],
                'choujiangtype'=>$_GPC['choujiangtype'],
                'pddtjdd'=>$_GPC['pddtjdd'],
                'pddwenan'=>$_GPC['pddwenan'],
								'jdviewwenan'=>$_GPC['jdviewwenan'],
								'pddviewwenan'=>$_GPC['pddviewwenan'],
								'yqycjiangli'=>$_GPC['yqycjiangli'],
								'kuaizhanurl'=>$_GPC['kuaizhanurl'],
								'tljfl'=>$_GPC['tljfl'],
								'qdtype'=>$_GPC['qdtype'],
								'qdtgurl'=>$_GPC['qdtgurl'],

                'dxtype' => $_GPC ['dxtype'],
                'smstype' => $_GPC ['smstype'],
                'juhesj' => $_GPC ['juhesj'],
                    'cxsqtype' => $cxsqtype,
                'dyAppKey' => trim($_GPC ['dyAppKey']),
                'dyAppSecret' => trim($_GPC ['dyAppSecret']),
                'dysms_free_sign_name' => $_GPC ['dysms_free_sign_name'],
                'dysms_template_code' => $_GPC ['dysms_template_code'],
                'jhappkey' => trim($_GPC['jhappkey']),
                'jhcode' => trim($_GPC['jhcode']),
                'gzljcj'=>$_GPC ['gzljcj'],
                'qiandaormb'=>$_GPC ['qiandaormb'],
                'hmyxtp'=>$_GPC ['hmyxtp'],
                'pddcq'=>$_GPC ['pddcq'],
                'jdcq'=>$_GPC ['jdcq'],
								
								'appfxtltle'=>$_GPC ['appfxtltle'],
								'appfxcontent'=>$_GPC ['appfxcontent'],
								'ygzhf'=>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['ygzhf']),ENT_QUOTES),
								'tbviewwenan'=>$_GPC ['tbviewwenan'],

                    'gzewm' => $_GPC ['gzewm'],
                    'kfewm' => $_GPC ['kfewm'],
                        'hdtitle' => $_GPC ['hdtitle'],
                        'hdcontent' => $_GPC ['hdcontent'],
                        'qtstyle'=>$_GPC ['qtstyle'],
                        'dhcontent'=>$_GPC ['dhcontent'],
                        'dtkAppKey'=>trim($_GPC ['dtkAppKey']),
                        'ptpid'=>trim($_GPC ['ptpid']),
                        'qqpid'=>trim($_GPC ['qqpid']),
                        'tkAppKey'=>trim($_GPC ['tkAppKey']),
                        'tksecretKey'=>trim($_GPC ['tksecretKey']),
												'jqtkAppKey'=>trim($_GPC ['jqtkAppKey']),
												'jqtksecretKey'=>trim($_GPC ['jqtksecretKey']),
                        'sdjltx'=>$_GPC ['sdjltx'],
                        'sjjltx'=>$_GPC ['sjjltx'],
                        'miyao'=>$_GPC ['miyao'],
                        'qiandaourl'=>$_GPC ['qiandaourl'],
                        'jfscurl'=>$_GPC ['jfscurl'],
                         'fxtype'=>$_GPC ['fxtype'],
                        'zgf'=>$_GPC ['zgf'],
                        'yjf'=>$_GPC ['yjf'],
                        'ejf'=>$_GPC ['ejf'],
                        'fxkg'=>$_GPC ['fxkg'],
                        'yjtype' => $_GPC ['yjtype'],
                        'cjssclass'=>$_GPC ['cjssclass'],

                        'fxtitle' => $_GPC ['fxtitle'],
                        'fxcontent' => $_GPC ['fxcontent'],
                        'fxpicurl' => $_GPC ['fxpicurl'],
                         'lbtx'=>$_GPC['lbtx'],
                            'gzhfl'=>$_GPC['gzhfl'],
                            'flmsg'=>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['flmsg']),ENT_QUOTES),//$_GPC['flmsg'],
							'flmsg1'=>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['flmsg1']),ENT_QUOTES),//$_GPC['flmsg1'],
							'jzcjq'=>$_GPC['jzcjq'],
                            'newflmsg'=>$_GPC['newflmsg'],
                            'adzoneid'=>trim($_GPC['adzoneid']),
                            'siteid'=>trim($_GPC['siteid']),
                           // 'ermsg'=>$_GPC['ermsg'],
														'ermsg' =>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['ermsg']),ENT_QUOTES),
														'zgtxmsg' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['zgtxmsg']),ENT_QUOTES),
														'yjtxmsg' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['yjtxmsg']),ENT_QUOTES),
														'ejtxmsg' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['ejtxmsg']),ENT_QUOTES),
														
                            'jfbl'=>$_GPC['jfbl'],
                            'tttype'=>$_GPC['tttype'],
                            'tttitle'=>$_GPC['tttitle'],
                            'ttpicurl'=>$_GPC['ttpicurl'],
                            'tturl'=>$_GPC['tturl'],
                            'ttsum'=>$_GPC['ttsum'],
                            'yongjinjs'=>$_GPC['yongjinjs'],
                            'tkzs'=>$_GPC['tkzs'],
                            'jqrflmsg'=>$_GPC['jqrflmsg'],
                            'wzcj'=>$_GPC['wzcj'],
                            'yetype'=>$_GPC['yetype'],
                            'phbtype'=>$_GPC['phbtype'],
                            'tbid'=>$_GPC['tbid'],
                            'huiyuanurl'=>$_GPC['huiyuanurl'],
                            'hpx'=>$_GPC['hpx'],
                            'hongbaourl'=>$_GPC['hongbaourl'],
                            'yhlist'=>$_GPC['yhlist'],
                            'cjpicurl'=>$_GPC['cjpicurl'],
                            'rxyjxs'=>$_GPC['rxyjxs'],
                            'hongbaoykg'=>$_GPC['hongbaoykg'],
                            'cjsstypesy'=>$_GPC['cjsstypesy'],
                            'cjsswzxsgs'=>$_GPC['cjsswzxsgs'],

                            'glyopenid'=>trim($_GPC['glyopenid']),
                            'khgetorder'=>trim($_GPC['khgetorder']),
                            'khgettx'=>trim($_GPC['khgettx']),
                            'ljcjk'=>$_GPC['ljcjk'],
                                'sdtype'=>$_GPC['sdtype'],
                                'fsjldsz'=>$_GPC['fsjldsz'],
                                'llqtype'=>$_GPC['llqtype'],
                                'sdguangc'=>$_GPC['sdguangc'],
                                'qfmbid'=>$_GPC['qfmbid'],
                                'fcss'=>$_GPC['fcss'],
                                'tkltype'=>$_GPC['tkltype'],
                                'cxrk'=>$_GPC['cxrk'],
                                'gzhtp'=>$_GPC['gzhtp'],
                                'mmtype'=>$_GPC['mmtype'],
								'dtkapp_secret'=>$_GPC['dtkapp_secret'],
								'dtkapp_key'=>$_GPC['dtkapp_key'],
																'error1' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['error1']),ENT_QUOTES),
																'error2' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['error2']),ENT_QUOTES),
																'error3' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['error3']),ENT_QUOTES),
																'error4' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['error4']),ENT_QUOTES),
																
                                'zbjgtime'=>$_GPC['zbjgtime'],
                                'zbtouxiang'=>$_GPC['zbtouxiang'],
                                'wsurl'=>$_GPC['wsurl'],
                                'zblive'=>$_GPC['zblive'],
                                'yktype'=>$_GPC['yktype'],
                                'tbuid'=>$_GPC['tbuid'],
                                'sylmkey'=>$_GPC['sylmkey'],
                                'cjsszn'=>$_GPC['cjsszn'],
                                'jqrss'=>$_GPC['jqrss'],
                                'gyspsj'=>$_GPC['gyspsj'],
                                'newflmsgjqr'=>$_GPC['newflmsgjqr'],
                                'lbratetype'=>$_GPC['lbratetype'],
                                'ldgzurl'=>$_GPC['ldgzurl'],
                                'gzhcjtype'=>$_GPC['gzhcjtype'],
																'kfqq'=>$_GPC['kfqq'],
																'kftime'=>$_GPC['kftime'],
                                'mspicurl'=>$_GPC['mspicurl'],
                                'mstime'=>$_GPC['mstime'],
                                'cqmsg' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['cqmsg']),ENT_QUOTES),
'topcolor'=>$_GPC['topcolor'],
'sy99'=>$_GPC['sy99'],
'syjhs'=>$_GPC['syjhs'],
'syms'=>$_GPC['syms'],
'sybmmk'=>$_GPC['sybmmk'],
'syddq'=>$_GPC['syddq'],
'newsstyle'=>$_GPC['newsstyle'],
'tklmb'=>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['tklmb']),ENT_QUOTES),

'sinkey'=>$_GPC['sinkey'],
'dwzlj'=>$_GPC['dwzlj'],
'zdgdtype'=>$_GPC['zdgdtype'],

'appname'=>$_GPC['appname'],
'appico'=>$_GPC['appico'],
'azurl'=>$_GPC['azurl'],
'iosurl'=>$_GPC['iosurl'],
'apptxt'=>$_GPC['apptxt'],
    'qqtongji'=>$_GPC['qqtongji'],
    
    'mftype'=>$_GPC['mftype'],
    'mfhhtype'=>$_GPC['mfhhtype'],
    'unionidtype'=>$_GPC['unionidtype'],
		'logo'=>$_GPC['logo'],
		
		'tljtype'=>$_GPC['tljtype'],
		'tljyj'=>$_GPC['tljyj'],
		'tljsum'=>$_GPC['tljsum'],
		'tljsx'=>$_GPC['tljsx'],
		'tljtitle'=>$_GPC['tljtitle'],
		'tljendtime'=>$_GPC['tljendtime'],
		'tljadzone_id'=>$_GPC['tljadzone_id'],
		'smskgtype'=>$_GPC['smskgtype'],
    

'xqdwzxs'=>$_GPC['xqdwzxs'],

'jhspicurl'=>$_GPC['jhspicurl'],
'tqgpicurl'=>$_GPC['tqgpicurl'],
'dlhead'=>$_GPC['dlhead'],
'rjqqq'=>$_GPC['rjqqq'],
    'viewtk'=>$_GPC['viewtk'],
    'zhaotype'=>$_GPC['zhaotype'],
    'dlddfx'=>$_GPC['dlddfx'],
    'itemewm'=>$_GPC['itemewm'],
    'ljqtzapp'=>$_GPC['ljqtzapp'],
    'tklnewtype'=>$_GPC['tklnewtype'],
    'tknewurl'=>trim($_GPC['tknewurl']),
    'zydwz'=>trim($_GPC['zydwz']),
    'zhaoxs'=>$_GPC['zhaoxs'],
    'ewmlj'=>$_GPC['ewmlj'],
    'hongbaoytype'=>$_GPC['hongbaoytype'],
    'mypy'=>$_GPC['mypy'],
    'cjsstype'=>$_GPC['cjsstype'],
                'hbsctime'=>$_GPC['hbsctime'],
                'hbcsmsg'=>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['hbcsmsg']),ENT_QUOTES),
                'rwurl'=>$_GPC['rwurl'],
                'gzurl'=>$_GPC['gzurl'],
                'AppKey'=>$_GPC['AppKey'],
                'appSecret'=>$_GPC['appSecret'],          
                'jdtjdd'=>  $_GPC['jdtjdd'],        
                'city'=>$_GPC['city']
			);
			if ($this->saveSettings($cfg)) {
				message('保存成功', 'refresh');
			}
		}
		include $this->template('settings');
	}
}