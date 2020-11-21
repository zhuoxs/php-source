<?php 
	defined('IN_IA') or exit('Access Denied');
	global $_W,$_GPC;
	$_GPC['do'] = 'data';
	$_GPC['op'] = !isset($_GPC['op']) ? 'helplog' : $_GPC['op'];

//pdo_delete('zofui_posterhelp_user',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['actid'],'credit <='=>0));


	//导入发货
	if(checksubmit('import')) {
		
		$uploadfile = returntemp( $_FILES );
		
		if (empty($uploadfile)) message('请选择要导入的CSV文件！');
		
		$handle = fopen($uploadfile, 'r'); 
		
		$result = input_csv($handle); //解析csv 
		
		if(count($result) <= 1) message('没有数据,文件内顶部的标题栏不能删除！',referer(),'error');
		if(count($result[1]) <= 1) message('文件数据不对，文件编辑好快递后另存为:CSV(逗号分隔).*csv 文件格式',referer(),'error');
		
		$success = 0;
		foreach($result as $k => $v){

			if($k >= 1){ //第0个是上面的标题栏

				$logid = iconv('gb2312', 'utf-8', trim($v[0])); //中文转码 
				$data['expressname'] = iconv('gb2312', 'utf-8', trim($v[6]));  
				$data['expressnumber'] = iconv('gb2312', 'utf-8', trim($v[7])); 
				$data['status'] = 1;

				if( empty( $data['expressname'] )  || empty( $data['expressnumber'] ) ) continue;

				$loginfo = pdo_get('zofui_posterhelp_geted',array('uniacid'=>$_W['uniacid'],'id'=>$logid));
				$prize = pdo_get('zofui_posterhelp_prize',array('uniacid'=>$_W['uniacid'],'id'=>$loginfo['prizeid']));
				if( $prize['type'] != 3 ) continue;
				$act = model_act::getAct( $prize['actid'] );
				if( $act['sendtype'] != 0 ) continue;

				$res = pdo_update('zofui_posterhelp_geted',$data,array('id'=>$logid,'uniacid'=>$_W['uniacid'],'actid'=>$prize['actid']));
				if($res){
					Message::sendPrize($loginfo['openid'],$prize['name'],$data['expressname'],$data['expressnumber'],$prize['actid']);
					$success ++;
				} 
			}
		}
		
		fclose($handle); //关闭指针 
		message('操作完成,成功发货'.$success.'项',referer(),'success');
		
	}

	
	if( checkSubmit('deleteuser') ){
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_posterhelp_user');
		if($res){
			message('删除成功','referer','success');
		}else{
			message('删除失败','referer','error');
		}
	}		

	if( checkSubmit('deleteget') ){
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_posterhelp_geted');
		if($res){
			message('删除成功','referer','success');
		}else{
			message('删除失败','referer','error');
		}
	}

	if( checkSubmit('deletetel') ){
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_posterhelp_form');
		if($res){
			message('删除成功','referer','success');
		}else{
			message('删除失败','referer','error');
		}
	}	
	if( checkSubmit('deletehelp') ){
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_posterhelp_helplist');
		if($res){
			message('删除成功','referer','success');
		}else{
			message('删除失败','referer','error');
		}
	}

	// payall
	if( checkSubmit('payall') ){
		
		if( empty( $_GPC['checkall'] ) ) message('先勾选需要支付的领取奖励');
		$success = 0;

		foreach ($_GPC['checkall'] as  $v) {
			$geted = pdo_get('zofui_posterhelp_geted',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['actid'],'id'=>$v));
			
			if( $geted['waitpay'] == 0 ) continue;

	       	$arr['openid'] = $geted['openid'];
	        if ( $_W['account']['level'] == 3 || $_W['account']['key'] != $this->module['config']['appid'] ) {

	        	$auth = pdo_get('zofui_posterhelp_auth',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['actid'],'openid'=>$geted['openid']));
	        	if( !empty( $auth['authopenid'] ) ){
	        		$arr['openid'] = $auth['authopenid'];
	        	}
	        }
	        $arr['fee'] = $geted['fee'];
	        $pay = new WeixinPay;
	                
	        if($this->module['config']['paytype'] == 0){ // 红包发放
	            $arr['hbname'] = '活动红包';
	            $arr['body'] = '活动红包';
	            $cres = $pay -> sendhongbaoto($arr,$this);

	        }else{
	            $cres = $pay -> sendMoneyToUser($arr,$this);
	        }
	                
	        if($cres['result_code'] != 'SUCCESS'){
	           	
	            $resstr = '遇到错误:'.$cres['err_code_des'];
	        }else{
	        	$success ++ ;
	        	pdo_update('zofui_posterhelp_geted',array('status'=>1,'waitpay'=>0),array('id'=>$geted['id']));
	        }
	        
		}
		
		
		message('操作完成,成功支付'.$success.'项'.$resstr,referer(),'success');
	}

	if($_GPC['op'] == 'user'){

		$topbar = topbal::userList();

		$act = pdo_get('zofui_posterhelp_act',array('id'=>$_GPC['actid']));

		$page = intval($_GPC['page']);
		$num =  10;
		$where['uniacid'] = $_W['uniacid'];
		$where['actid'] = $_GPC['actid'];		
		$order = ' `id` ';
		$by = ' DESC ';

		if( !empty( $_GPC['status'] ) ) $where['status'] = intval( $_GPC['status'] ) - 1;
		if( $_GPC['order'] == 1 ) $order = ' credit ';

		if( $_GPC['by'] == 1 ) $by = ' ASC ';

		if( isset($_GPC['for']) && $_GPC['for'] != '' ) $where['nickname@'] = $_GPC['for'];
		

		$data = Util::getAllDataInSingleTable('zofui_posterhelp_user',$where,$page,$num,$order.$by);
		$list = $data[0];
		$pager = $data[1];

		foreach ($list as &$v) {
			$v['form'] = pdo_get('zofui_posterhelp_form',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid'],'actid'=>$v['actid']));
			$v['helptimes'] = pdo_count('zofui_posterhelp_helplist',array('actid'=>$_GPC['actid'],'helped'=>$v['openid']));
			
			if( $act['jftype'] == 1 ){
				$carr = model_user::getUserCredit($v['openid']);
				$v['credit'] = $carr['credit1'];
			}

		}
		unset($v);
	}

	if($_GPC['op'] == 'getlog'){
		$act = model_act::getAct( $_GPC['actid'] );
		$topbar = topbal::getlogList();

		$page = intval($_GPC['page']);
		$num =  $_GPC['down'] == 1 ? 9999999 : 10;
		$where['uniacid'] = $_W['uniacid'];
		$where['actid'] = $_GPC['actid'];
		$where['waitpay'] = 0;
		$order = ' `id` ';
		$by = ' DESC ';

		if( $_GPC['down'] == 1){ // 下载
			if( $act['sendtype'] != 0 ) message('此活动选择的是上店自提，不能快递发奖');
			$str = " AND c.type = '3' ";
		}

		if( !empty( $_GPC['status'] ) ) $where['status'] = intval( $_GPC['status'] ) - 1;

		if( $_GPC['search'] == 'nick' && $_GPC['for'] != '' ) $str = " AND b.nickname LIKE '%".$_GPC['for']."%' ";
		if(  $_GPC['search'] == 'code' && $_GPC['for'] != '' ) $where['code'] = $_GPC['for'];

		$select = ' a.*,b.nickname,b.credit,c.type,c.name,c.pic ';
		$data = model_prize::getGetedList($where,$page,$num,$order.$by,false,true,$select,$str);
		$list = $data[0];
		$pager = $data[1];

		if( $_GPC['down'] == 1){ // 下载
			downLoadDrawLog($list);
		}

		
	}

	// 待发红包的
	if($_GPC['op'] == 'waitpay'){
		$act = model_act::getAct( $_GPC['actid'] );

		$page = intval($_GPC['page']);
		$num =  10;
		$where['uniacid'] = $_W['uniacid'];
		$where['actid'] = $_GPC['actid'];	
		$where['waitpay'] = 1;
		$order = ' `id` ';
		$by = ' DESC ';
		
		$select = ' a.*,b.nickname,b.credit,c.type,c.name,c.pic ';
		$data = model_prize::getGetedList($where,$page,$num,$order.$by,false,true,$select,$str);
		$list = $data[0];
		$pager = $data[1];
		
	}


	if($_GPC['op'] == 'helplog'){

		$topbar = topbal::helplogList();

		$page = intval($_GPC['page']);
		$num =  10;

		$where['uniacid'] = $_W['uniacid'];
		$where['actid'] = $_GPC['actid'];
		$order = ' `id` ';
		$by = ' DESC ';

		if( $_GPC['order'] == 1 ) $order = ' credit ';

		if( !empty($_GPC['uid']) ) $where['helped'] = $_GPC['uid'];

		if( $_GPC['by'] == 1 ) $by = ' ASC ';

		if( isset($_GPC['for']) && $_GPC['for'] != '' ) $str = " AND b.nickname LIKE '%".$_GPC['for']."%' ";
		$select = ' a.*,b.nickname,c.nickname AS helpernick ';

		$data = model_help::getHelpLog($where,$page,$num,$order.$by,false,true,$select,$str);
		$list = $data[0];
		$pager = $data[1];
		$total = $data[2];

	}

	if($_GPC['op'] == 'tel'){

		$page = intval($_GPC['page']);
		$num =  $_GPC['down'] == 1 ? 9999999 : 10;

		$where['uniacid'] = $_W['uniacid'];
		$where['actid'] = $_GPC['actid'];
		$order = ' `id` ';
		$by = ' DESC ';

		$data = Util::getAllDataInSingleTable('zofui_posterhelp_form',$where,$page,$num,' `id` DESC ');
		$list = $data[0];
		$pager = $data[1];

		if( !empty( $list ) ){
			foreach ( $list as  &$v ) {
				$v['user'] = pdo_get('zofui_posterhelp_user',array('openid'=>$v['openid'],'uniacid'=>$_W['uniacid']));
			}
		}

		if( $_GPC['down'] == 1){ // 下载
			downLoadForm($list);
		}
	}

	if($_GPC['op'] == 'deleteget'){

		$res = WebCommon::deleteSingleData($_GPC['id'],'zofui_posterhelp_geted');
		if($res) message('删除成功',referer(),'success');
	}
	if($_GPC['op'] == 'deletetel'){

		$res = WebCommon::deleteSingleData($_GPC['id'],'zofui_posterhelp_form');
		if($res) message('删除成功',referer(),'success');
	}
	if($_GPC['op'] == 'deletehelp'){

		$res = WebCommon::deleteSingleData($_GPC['id'],'zofui_posterhelp_helplist');
		if($res) message('删除成功',referer(),'success');
	}


	if($_GPC['op'] == 'info'){

		$act = model_act::getAct( $_GPC['actid'] );

		if( $act['sendtype'] != 0 ) message('此活动对应的兑换奖品无详情信息');

		$geted = pdo_get('zofui_posterhelp_geted',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
		$prize = pdo_get('zofui_posterhelp_prize',array('uniacid'=>$_W['uniacid'],'id'=>$geted['prizeid']));
		if( $prize['type'] != 3 ) message('此兑奖无详情信息');		



	}
	if($_GPC['op'] == 'togeted'){

		$res = pdo_update('zofui_posterhelp_geted',array('status'=>1),array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
		if( $res ){
			message('操作成功',referer(),'success');
		}
		message('操作失败',referer(),'success');
	}



	//下载表格
	function downLoadDrawLog($list){
		set_time_limit(0);

		/* 输入到CSV文件 */
		$html = "\xEF\xBB\xBF".$html; //添加BOM
		/* 输出表头 */		
		$html .= '编号' . "\t,";		
		$html .= '微信昵称' . "\t,";
		$html .= '奖品名称' . "\t,";		
		$html .= '姓名' . "\t,";
		$html .= '电话' . "\t,";
		$html .= '地址' . "\t,";
		$html .= '快递名称' . "\t,";
		$html .= '快递编号' . "\t,";
		$html .= "\n";
		$num = 0;
 		foreach((array)$list as $k => $v){	

 			$v['address'] = str_replace(',', '，', $v['address']);

 			$html .= $v['id'] . "\t,";
			$html .= $v['nickname'] . "\t,";
			$html .= $v['name'] . "\t,";
			$html .= $v['getname'] . "\t,";
			$html .= $v['gettel'] . "\t,";
			$html .= $v['address'] . "\t,";
			$html .= $v['expressname'] . "\t,";
			$html .= $v['expressnumber'] . "\t,";			
			$html .= "\n"; 
			
		}
		/* 输出CSV文件 */
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=发奖.csv");
		echo $html;
		exit;
		
	}

	//下载表格
	function downLoadForm($list){
		set_time_limit(0);

		/* 输入到CSV文件 */
		$html = "\xEF\xBB\xBF".$html; //添加BOM
		/* 输出表头 */				
		$html .= '微信昵称' . "\t,";
		$html .= '姓名' . "\t,";		
		$html .= '电话' . "\t,";
		$html .= "\n";
		$num = 0;
 		foreach((array)$list as $k => $v){	

			$html .= $v['user']['nickname'] . "\t,";
			$html .= $v['name'] . "\t,";
			$html .= $v['tel'] . "\t,";			
			$html .= "\n"; 
			
		}
		/* 输出CSV文件 */
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=姓名电话.csv");
		echo $html;
		exit;
		
	}

	function input_csv($handle) { 
		$out = array (); 
		$n = 0; 
		while ($data = fgetcsv($handle, 10000)) { 
			$num = count($data); 
			for ($i = 0; $i < $num; $i++) { 
				$out[$n][$i] = $data[$i]; 
			} 
			$n++; 
		} 
		return $out; 
	} 

	function returntemp( $file ){
		return 	$file['inputfile']['tmp_name'];
	}

	include $this->template('web/data');