<?php 


class model_help
{	



	// 查询prizelist表
	static function getHelpLog($where,$page,$num,$order,$iscache,$pager,$select,$str=''){
		global $_W;
		
		$data = Util::structWhereStringOfAnd($where,'a');
		$commonstr = tablename('zofui_posterhelp_helplist') ."  AS a LEFT JOIN ".tablename('mc_mapping_fans')." AS b ON a.`helped` = b.`openid` AND a.uniacid = b.uniacid LEFT JOIN ".tablename('mc_mapping_fans')." AS c ON a.`helper` = c.`openid` AND a.uniacid = c.uniacid WHERE ".$data[0];
		
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$res = Util::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$iscache,$pager,$str);
		return $res;
	}	
	
	// 验证帮助
	static function checkHelp($act,$user,$from,$set){
		global $_W;

        if( empty( $user ) ) return '没有找到您要帮助的好友';
        if( empty( $act ) ) return '活动不存在';

        if( $act['status'] == 1 ) return '活动已下架，不能再参与';
        if( $act['start'] > TIMESTAMP ) return '活动还没开始';
        if( $act['end'] < TIMESTAMP ) return '来晚了，活动已经结束了';
 		
        if( $user['openid'] == $from ) {
        	
        	return '不能为自己赠'.$act['creditname'].'，把海报发给朋友邀请朋友赠送吧。';
        }
      	if( $user['status'] == 1 ) return '不能为对方助力';

		if( $act['gametime'] == 0){ //1天
			$time = strtotime( date('Y-m-d',TIMESTAMP) );
			$wherea = array('uniacid'=>$_W['uniacid'],'actid'=>$act['id'],'helper'=>$from,'helped'=>$user['openid'],'time>'=>$time);
			$nstra = '今天你已经为'.$user['nickname'].'赠送了'.$act['creditname'].'，明天再赠他'.$act['creditname'].'吧';

			$whereb = array('uniacid'=>$_W['uniacid'],'actid'=>$act['id'],'helper'=>$from,'time>'=>$time);
			$nstrb = '今天你已经赠送很多人了，不能再赠送了，明天再来吧';

			if( empty($act['helparr']) ){
				unset($wherea['actid'],$whereb['actid']);
			}

		}else{ // 永久
			$wherea = array('uniacid'=>$_W['uniacid'],'actid'=>$act['id'],'helper'=>$from,'helped'=>$user['openid']);
			$nstra = '你已经为'.$user['nickname'].'赠送了'.$act['creditname'].'，不能再赠他'.$act['creditname'];

			$whereb = array('uniacid'=>$_W['uniacid'],'actid'=>$act['id'],'helper'=>$from);
			$nstrb = '您最多能为'.$act['maxtimes'].'人赠'.$act['creditname'].'，你已经赠送很多人了，不能再赠送了。';

			if( empty($act['helparr']) ){
				unset($wherea['actid'],$whereb['actid']);
			}
			
		}

		$ishelp = Util::getSingelDataInSingleTable('zofui_posterhelp_helplist',$wherea);
		if( !empty( $ishelp ) ) return $nstra;

//file_put_contents(POSETERH_ROOT."/params.log", var_export(array($ishelp,$wherea), true).PHP_EOL, FILE_APPEND);

		$helpnum = Util::countDataNumber('zofui_posterhelp_helplist',$whereb);
		if( $helpnum >= $act['maxtimes'] ) return $nstrb;

		// 防刷
		if( $set['shuatime'] > 0 && $set['shuatimes'] > 0 ){
			$shuatime = TIMESTAMP - $set['shuatime'];
			$wherec = array('uniacid'=>$_W['uniacid'],'actid'=>$act['id'],'helped'=>$user['openid'],'time>'=>$shuatime);
			$shuanum = Util::countDataNumber('zofui_posterhelp_helplist',$wherec);
			if( $shuanum >= $set['shuatimes'] ) {
				pdo_update('zofui_posterhelp_user',array('status'=>1),array('id'=>$user['id']));
				return '不能为对方助力';
			}
		}

		return '200';
	}


	static function helpSuccess($act,$user,$from){
		global $_W;
		if( empty( $act ) || empty( $user ) || empty( $from ) ) return false;
        $fee = rand($act['min'],$act['max']);
		
		if( empty($act['jftype']) ){
			$res = Util::addOrMinusOrUpdateData('zofui_posterhelp_user',array('credit'=>$fee),$user['id']);
			$credit = $user['credit'];
		}elseif( $act['jftype'] == 1 ){
			$res = model_user::updateUserCredit($user['openid'],$fee,1,'助力海报');
			$carr = model_user::getUserCredit($user['openid']);
			$credit = $carr['credit1'];
		}
        

        if( $res ) {

        	if( $act['islink'] == 1 && empty($user['issendlink']) && $act['linkleast'] <= ( $credit + $fee ) ) {
        		$sendres = Message::linkmess($user['openid'],$act['linkmess'],$act['linklink']);
        		if( $sendres['res'] ) {
        			pdo_update('zofui_posterhelp_user',array('issendlink'=>1),array('id'=>$user['id']));
        		}
        	}

            $indata['uniacid'] = $_W['uniacid'];
            $indata['helper'] = $from;
            $indata['helped'] = $user['openid'];
            $indata['time'] = TIMESTAMP;
            $indata['actid'] = $act['id'];
            $indata['credit'] = $fee;

            $inres = pdo_insert('zofui_posterhelp_helplist',$indata);
            Util::deleteCache('u',$user['openid'],$user['actid']);

            $settings = Util::getModuleConfig();
            if( $settings['font1'] == 0 || $settings['font1'] == 1 ){
            	//$restra = '您成功帮'.$user['nickname'].'赠送'.$fee.$act['creditname'].'，您也可点击下方蓝字参与活动，赢取大奖。';
            	if( $settings['font1'] == 0 ){
            		$restra = '您成功帮{nickname}赠送{fee}{creditname}，您也可点击下方蓝字参与活动，赢取大奖。';
            		if( !empty( $settings['font1font'] ) ){
            			$restra = htmlspecialchars_decode( $settings['font1font'] );
            		}
            		$restra = str_replace(array('{nickname}','{fee}','{creditname}'),array($user['nickname'],$fee,$act['creditname']), $restra);
            		Message::sendText( $from,$restra );
            	}else{
            		$file = IA_ROOT.'/attachment/'.$settings['font1voice'];
            		if( file_exists( $file ) ){
            			
						$media = Message::uploadVoice( $file );
						Message::sendVoice($from, $media);
            		}
            	}
            }
            
            // 帮助成功提示 没有发链接或者已发但是开启的
            if( ($user['issendlink'] == 1 && $act['islinkmess'] == 1 ) || $user['issendlink'] == 0 ) {
            	$helper = pdo_get('mc_mapping_fans',array('openid'=>$from),array('nickname'));
            	Message::helpMessage($user['openid'],$act['creditname'],$helper['nickname'],$fee,$act['id']);
            }
            return true;
        }
        return false;
	}


	// 查询帮助我的记录
	static function getMyHelpLog($where,$page,$num,$order,$iscache,$pager,$select,$str=''){
		global $_W;
		
		$data = Util::structWhereStringOfAnd($where,'a');
		$commonstr = tablename('zofui_posterhelp_helplist') ."  AS a LEFT JOIN ".tablename('mc_mapping_fans')." AS b ON a.`helper` = b.`openid` AND a.uniacid = b.uniacid WHERE ".$data[0];
		
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$res = Util::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$iscache,$pager,$str);
		return $res;
	}	
	

	static function getRanK($actid,$openid,$type){
		global $_W;
		
		if( empty($type) ){
			$sql = "SELECT count(1) AS rank FROM ".tablename('zofui_posterhelp_user')." WHERE uniacid = :uniacid AND actid = :actid AND  openid != :openid AND `credit` > 0 AND  `credit` >= (SELECT `credit` FROM ".tablename('zofui_posterhelp_user')." WHERE actid = :actidi AND uniacid = :uniacidi AND openid = :openidi AND `status` = 0 ) ORDER BY `id` ASC ";
			$params = array(':openid'=>$openid,':uniacid'=>$_W['uniacid'],':actid'=>$actid,':actidi'=>$actid,':uniacidi'=>$_W['uniacid'],':openidi'=>$openid);
			
			return pdo_fetch($sql,$params);
		}elseif($type == 1){
			
			$list = model_user::rank($actid,1111);
			
			$res = array('rank'=>-99);
			if( !empty($list) ){
				foreach ($list as $k => $v) {
					if( $v['openid'] == $openid ){
						$res = array('rank'=>$k);
						break;
					}
				}
			}
			return $res;
		}
	}

}