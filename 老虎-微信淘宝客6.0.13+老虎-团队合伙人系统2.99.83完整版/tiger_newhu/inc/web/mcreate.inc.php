<?php
// 这个操作被定义用来呈现 管理中心导航菜单
		global $_W, $_GPC;
		$do = 'mcreate';
		$op = $_GPC ['op'];
		$id = $_GPC ['id'];
		$item = pdo_fetch ( 'select * from ' . tablename ( $this->modulename . "_poster" ) . " where id='{$id}'" );
        
		if (checksubmit ()) {
			$ques = $_GPC['ques'];
			$answer = $_GPC['answer'];
			$questions = '';
			foreach ($ques as $key => $value) {
				if (empty($value)) continue;
				$questions[] = array('question'=>$value,'answer'=>$answer[$key]);
			}
            //echo '<pre>';
        //print_r($_GPC);
        //exit;
			
			$data = array (
			'weid'=> $_W['uniacid'],
            'rtype'=> $_GPC ['rtype'],
            'title' => $_GPC ['title'],
            'type' => $_GPC ['type'],
            'bg' => $_GPC ['bg'],
            'data' => htmlspecialchars_decode($_GPC ['data']),
            'weid' => $_W ['uniacid'],
            'score' => $_GPC ['score'],
            'cscore' => $_GPC ['cscore'],
            'pscore' => $_GPC ['pscore'],
            'scorehb' => $_GPC ['scorehb'],
            'cscorehb' => $_GPC ['cscorehb'],
            'pscorehb' => $_GPC ['pscorehb'],
            'rscore' => $_GPC ['rscore'],
            'gid' => $_GPC ['gid'],
            'kdtype' => $_GPC ['kdtype'],
            'winfo1' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['winfo1']),ENT_QUOTES),
            'winfo2' =>htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['winfo2']),ENT_QUOTES),
            'winfo3' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['winfo3']),ENT_QUOTES),
            'stitle' => serialize($_GPC ['stitle']),
            'sthumb' => serialize($_GPC ['sthumb']),
            'sdesc' => serialize($_GPC ['sdesc']),
            'rtips' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['rtips']),ENT_QUOTES),
            'ftips' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['ftips']),ENT_QUOTES),
            'utips' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['utips']),ENT_QUOTES),
            'utips2' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['utips2']),ENT_QUOTES),
            'wtips' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['wtips']),ENT_QUOTES),
            'nostarttips' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['nostarttips']),ENT_QUOTES),
            'endtips' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC ['endtips']),ENT_QUOTES),
            'starttime' => strtotime($_GPC['starttime']),
            'endtime' => strtotime($_GPC['endtime']),
            'surl' => serialize($_GPC ['surl']),
            'kword' => $_GPC ['kword'],
            'credit' => $_GPC ['credit'],
            'doneurl' => $_GPC ['doneurl'],
            'tztype' => $_GPC ['tztype'],            
            'slideH' => $_GPC ['slideH'],
            'mbcolor' => $_GPC ['mbcolor'],

            

            'mbstyle' => $_GPC ['mbstyle'],
            'mbfont' => $_GPC ['mbfont'],
            'sliders' => $_GPC ['sliders'],
            'mtips' => $_GPC ['mtips'],            
            'sharetitle' => $_GPC ['sharetitle'],
            'sharethumb' => $_GPC ['sharethumb'],
            'sharedesc' => $_GPC ['sharedesc'],
            'sharegzurl' => $_GPC ['sharegzurl'],
            'tzurl' => $_GPC ['tzurl'],
            'questions' => serialize($questions),
            'createtime' =>time(),
			);
			if ($id) {
				if (pdo_update ( $this->modulename . "_poster", $data, array (
						'id' => $id
				) ) === false) {
					message ( '更新海报失败！1' );
				} else{
					if (empty($item['rid'])){
						$this->createRule($_GPC['kword'],$id);
					}elseif ($item['kword'] != $data['kword']){
						//修改生成二维码和扫码的关键字
						pdo_update('rule_keyword',array('content'=>$data['kword']),array('rid'=>$item['rid']));
						pdo_update('qrcode',array('keyword'=>$data['kword']),array('name'=>$this->modulename,'keyword'=>$item['kword']));
					}
					message ( '更新海报成功！2', $this->createWebUrl ( 'mposter' ) );
				}
			} else {
				$data['rtype'] = $_GPC['rtype'];
				$data ['createtime'] = time ();
				if (pdo_insert ( $this->modulename . "_poster", $data ) === false) {
					message ( '生成海报失败！3' );
				} else{
					$this->createRule($_GPC['kword'],pdo_insertid());
					message ( '生成海报成功！4', $this->createWebUrl ( 'mposter' ) );
				}
					
			}
		}
		load ()->func ( 'tpl' );
		if ($item){
			$data = json_decode(str_replace('&quot;', "'", $item['data']), true);
			$size = getimagesize(toimage($item['bg']));
			$size = array($size[0]/2,$size[1]/2);
			$date = array('start'=>date('Y-m-d H:i:s',$item['starttime']),'end'=>date('Y-m-d H:i:s',$item['endtime']));
			$titles = unserialize($item['stitle']);
			$thumbs = unserialize($item['sthumb']);
			$sdesc = unserialize($item['sdesc']);
			$surl = unserialize($item['surl']);
			foreach ($titles as $key => $value) {
				if (empty($value)) continue;
				$slist[] = array('stitle'=>$value,'sdesc'=>$sdesc[$key],'sthumb'=>$thumbs[$key],'surl'=>$surl[$key]);
			}
		}else $date = array('start'=>date('Y-m-d H:i:s',time()),'end'=>date('Y-m-d H:i:s',time()+7*24*3600));
		//$groups = pdo_fetchall('select * from '.tablename('mc_groups')." where uniacid='{$_W['uniacid']}' order by isdefault desc");
		include $this->template ( 'mcreate' );
?>