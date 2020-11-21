<?php
defined('IN_IA') or exit('Access Denied');

class Signapp_WeliamController{
    /**
     * Comment: 进入首页 获取用户信息
     * Author: zzw
     */
	public function signindex(){
		global $_W,$_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name']) ? $_W['wlsetting']['trade']['credittext'] . '签到 - '.$_W['wlsetting']['base']['name'] : $_W['wlsetting']['trade']['credittext'] . '签到';
		$settings = $_W['wlsetting']['wlsign'];
		if($settings['signstatus']){
		    //获取用户信息
            $member = Wlsign::querySignmember('*');
			$member['avatar'] = tomedia($member['avatar']);
			//查看今天是否签到
            $dates = date("Ymd");
            $daySign = Wlsign::queryRecord('*',$dates);
			if (!empty($settings['adv'])) {
				$data = array();
				foreach ($settings['adv'] as $value) {
					$data['adv'][] = array('link' => $value['data_url'], 'thumb' => $value['data_img']);
				}
			}
			//获取今日签到总数
            $todayTime = date("Ymd");
            $today = pdo_fetchcolumn("SELECT count(*) FROM ".tablename(PDO_NAME."signrecord") ." WHERE date = '{$todayTime}'");
            //获取昨天签到总数
            $yesterdayTime = date("Ymd",strtotime("-1 Day"));
            $yesterday = pdo_fetchcolumn("SELECT count(*) FROM ".tablename(PDO_NAME."signrecord") ." WHERE date = '{$yesterdayTime}'");
            //获取虚拟签到人数
            $signnum = unserialize(implode(pdo_get(PDO_NAME."setting",array("key"=>'wlsign','uniacid'=>$_W['uniacid']),array('value'))))['signnum'];
            //重新计算签到人数
            $today     = intval($today)+$signnum;
            $yesterday = intval($yesterday)+$signnum;
			
			//分享
			$nickname = $_W['wlmember']['nickname'];
			$time = date("Y-m-d H:i:s",time());
			$sysname = $_W['wlsetting']['base']['name'];
			if($settings['share_title']){
				$title = $settings['share_title'];
				$title = str_replace('[昵称]',$nickname,$title);
				$title = str_replace('[时间]',$time,$title);
				$title = str_replace('[系统名称]',$sysname,$title);
				$_W['wlsetting']['share']['share_title'] = $title;
			}
			if($settings['share_desc']){
				$desc = $settings['share_desc'];
				$desc = str_replace('[昵称]',$nickname,$desc);
				$desc = str_replace('[时间]',$time,$desc);
				$desc = str_replace('[系统名称]',$sysname,$desc);
				$_W['wlsetting']['share']['share_desc'] = $desc;
			}
			if(!empty($settings['share_image'])){
				$_W['wlsetting']['share']['share_image'] = $settings['share_image'];
			}

            include wl_template('signhtml/index');
		}else{
			header('location:' . app_url('member/user/index'));
		}
	}
    /**
     * Comment: 进入签到页面 获取签到记录
     * Author: zzw
     */
	public function signrecord(){
		global $_W,$_GPC;
        $settings = $_W['wlsetting']['wlsign'];
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '签到记录 - '.$_W['wlsetting']['base']['name'] : '签到记录';
        //获取签到记录列表
        $signRecord = pdo_fetchall("SELECT * FROM " .tablename(PDO_NAME.'signrecord') ."WHERE uniacid = :uniacid AND mid = :mid ORDER BY createtime DESC LIMIT 10"
            , array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid']));
        //获取积分总数
        $signReward = pdo_fetch("SELECT sum(reward) as reward,count(id) as number FROM " .tablename(PDO_NAME.'signrecord') ."WHERE uniacid = :uniacid AND mid = :mid LIMIT 10"
            , array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid']));
		include wl_template('signhtml/record');
	}
    /**
     * Comment: 进入签到排行榜 获取排行榜信息
     * Author: zzw
     */
	public function signrank(){
		global $_W,$_GPC;
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '排行榜 - '.$_W['wlsetting']['base']['name'] : '排行榜';
        $settings = $_W['wlsetting']['wlsign'];
        $myRecord = '';
        $myTotalRecord = '';
        $myTntegral = '';
        //签到周期为自然月时 只查询当月总签到情况
        if($settings['cycletype'] == 2){
            $startTime =  strtotime(date('Y-m-01'));
            $where = " AND b.createtime > {$startTime} ";
        }
		//获取连续签到排行
        $signRecord = pdo_fetchall("SELECT mid,nickname,avatar,times FROM "
            .tablename(PDO_NAME.'signmember')
            ."WHERE uniacid = {$_W['uniacid']} AND times > 0 ORDER BY times DESC LIMIT 10");
        foreach ($signRecord as $k => $v){
            if($v['mid'] == $_W['mid']){
                $myRecord = $v;
                $myRecord['orders'] = $k+1;
                if($k == 0){
                    $myRecord['distance'] = '第一名';
                }else{
                    $myRecord['distance'] = '距离前一名'.($signRecord[$k-1]['times'] - $v['times']).'天';
                }
                continue;
            }
        }
        if(!$myRecord){
            //没有进入连续签到排行榜
            $myRecord = pdo_fetch("SELECT nickname,avatar,times FROM " .tablename(PDO_NAME.'signmember') ."WHERE uniacid = :uniacid AND mid = :mid"
                , array('uniacid' => $_W['uniacid'],'mid'=> $_W['mid']));
            $myRecord['distance'] =  '没有进入排行榜';
            $myRecord['orders'] = '0';
        }
        //获取总签到排行
        $signTotalRecord = pdo_fetchall("SELECT a.mid,a.nickname,a.avatar,count(b.mid) as totaltimes FROM ".tablename(PDO_NAME."signmember")
            ." a LEFT JOIN "
            .tablename(PDO_NAME."signrecord")
            ." b ON a.mid = b.mid WHERE a.uniacid = {$_W['uniacid']} {$where} GROUP BY b.mid ORDER BY totaltimes DESC LIMIT 10");
        foreach ($signTotalRecord as $k => &$v){
            if($v['mid'] == $_W['mid']){
                $myTotalRecord = $v;
                $myTotalRecord['orders'] = $k+1;
                if($k == 0){
                    $myTotalRecord['distance'] = '第一名';
                }else{
                    $myTotalRecord['distance'] = '距离前一名'.($signTotalRecord[$k-1]['times'] - $v['times']).'天';
                }
            }
        }
        if(!$myTotalRecord){
            //没有进入总签到排行
            $myTotalRecord = pdo_fetch("SELECT nickname,avatar,totaltimes FROM " .tablename(PDO_NAME.'signmember') ."WHERE uniacid = :uniacid AND mid = :mid", array('uniacid' => $_W['uniacid'],'mid'=> $_W['mid']));
            $myTotalRecord['distance'] =  '没有进入排行榜';
            $myTotalRecord['orders'] = 0;
        }
        //获取积分排行
        //a.id,a.uid,a.nickname,a.avatar,sum(b.reward) as integral
        $integralList = pdo_fetchall("SELECT uid,nickname,avatar,credit1 as integral FROM ".tablename("mc_members")
            ." WHERE uniacid = {$_W['uniacid']} ORDER BY credit1 DESC LIMIT 10");
        foreach ($integralList as $k => &$v){
            if($v['uid'] == $_W['wlmember']['uid']){
                $myTntegral = $v;
                $myTntegral['orders'] = $k+1;
                if($k == 0){
                    $myTntegral['distance'] = '第一名';
                }else{
                    $myTntegral['distance'] = '距离前一名'.($integralList[$k-1]['integral'] - $v['integral']).'金币';
                }
            }
        }
        if(!$myTntegral){
            //没有进入积分排行
            $myTntegral = pdo_fetch("SELECT uid,nickname,avatar,credit1 as integral FROM "
                .tablename("mc_members")
                ." WHERE uniacid = {$_W['uniacid']} AND uid = {$_W['wlmember']['uid']}");
            $myTntegral['distance'] =  '没有进入排行榜';
            $myTntegral['orders'] = 0;
        }
		include wl_template('signhtml/rank');
	}
    /**
     * Comment: 获取某月签到记录
     * Author: zzw
     */
    public function signRecords(){
        global $_W,$_GPC;
        $begin=mktime(0,0,0,$_GPC['month'],1,$_GPC['year']);
        $end=mktime(23,59,59,$_GPC['month'],date('d'),$_GPC['year']);
        $signRecord = array_column(pdo_fetchall("SELECT createtime FROM " .tablename(PDO_NAME.'signrecord') ."WHERE uniacid = :uniacid AND mid = :mid AND createtime > :begins AND createtime < :endtime"
            , array(
                'uniacid' => $_W['uniacid'],
                'mid'     => $_W['mid'],
                'begins'  => $begin,
                'endtime' => $end
            )),'createtime');
        wl_json(1,'获取成功',$signRecord);
    }
    /**
     * Comment: 签到进行中
     * Author: zzw
     */
    public function signIn(){
        global $_W,$_GPC;
        //判断今天是否已经签到
        $date = date("Ymd");
        $have = Wlsign::queryRecord('*',$date);
        if(!$have){
            //今天未签到  获取签到积分规则
            $signRule = unserialize(implode(pdo_fetch("SELECT `value` FROM ".tablename(PDO_NAME.'setting')."WHERE uniacid = :uniacid AND `key` = :keys"
                ,array('uniacid'=>$_W['uniacid'],'keys' => 'wlsign'))));
            $sign_class     = '日常奖励';
            $bonusPoints    = $signRule['daily'];//日常奖励，默认获得日常奖励积分
            $first          = $signRule['first'];//首次奖励积分
            $specialreward  = $signRule['specialreward'];//特殊奖励积分
            $totalreward    = $signRule['totalreward'];//累计奖励积分
            //获取用户信息数据
            $member = Wlsign::querySignmember('*');
            $cumulativeDays = $member['times'] + 1;//累计天数  默认当前累计天数+1
            //获取应得的积分奖励   判断是否为第一次签到
            $signNum = pdo_fetchall("SELECT * FROM " .tablename(PDO_NAME.'signrecord') ."WHERE uniacid = :uniacid AND mid = :mid "
                , array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid']));
            if(!$signNum){
                //第一次签到奖励
                $bonusPoints = $first;
                $sign_class  = '首次奖励';
            }else{
                //判断是否为特殊日期
                $totalrewardTime = array_column($specialreward,'signtime');
                $todayTime =  mktime(0,0,0,date("m"),date("d"),date("Y"));//获取今天0点的时间戳
                if(in_array($todayTime,$totalrewardTime)){
                    //今天是特殊日期获取特殊奖励
                    $sign_class   = array_column($specialreward,'signtitle','signtime')[$todayTime];
                    $bonusPoints = array_column($specialreward,'special','signtime')[$todayTime];
                }
            }
            //查看昨天是否签到，昨天签到判断是否有累计奖励
            $signDayNum = array_column($signNum,'date');
            $Yesterday  = date("Ymd",strtotime("-1 Day"));
            if(in_array($Yesterday,$signDayNum)){
                //昨天正常签到,并且奖励为日常奖励 判断是否有连续奖励
                if($sign_class == '日常奖励'){
                    $signTotalDay  = array_column($totalreward,'reward','total');
                    if($signTotalDay[$cumulativeDays]){
                        //连续签到
                        $sign_class     = '累计签到'.$cumulativeDays.'天';
                        $bonusPoints    = $signTotalDay[$cumulativeDays];//日常奖励，默认获得日常奖励
                    }
                }
            }else{
                $cumulativeDays = 1;//昨天没有正常签到 累计天数归1
            }
            //拼装签到记录表数据数组
            $recordData['uniacid']    = $_W['uniacid'];
            $recordData['mid']        = $_W['mid'];
            $recordData['date']       = $date;//日期
            $recordData['createtime'] = time();//时间
            $recordData['reward']     = $bonusPoints;//获取的积分
            $recordData['sign_class'] = $sign_class;//获取积分类型
            //拼装用户信息修改记录数据数组
            $updateData['times']        = $cumulativeDays;//累计(连续)签到天数
            $updateData['integral']     = $member['integral'] + $bonusPoints;//积分总数
            $updateData['totaltimes']   = $member['totaltimes'] + 1;//总共签到天数
            $where['uniacid'] = $_W['uniacid'];
            //修改/添加数据
            $yesORon = pdo_insert(PDO_NAME.'signrecord',$recordData);
            $yesORon1 = Wlsign::updateSignmember($updateData,$where);
            Member::credit_update_credit1($_W['mid'],$bonusPoints,'签到:'.$sign_class);
            //获取返回数据
            $todayTime = date("Ymd");
            $today = pdo_fetch("SELECT count(*) FROM ".tablename(PDO_NAME."signrecord") ." WHERE uniacid = {$_W['uniacid']} AND  date = '{$todayTime}'");
            $signnum = unserialize(implode(pdo_get(PDO_NAME."setting",array("key"=>'wlsign','uniacid'=>$_W['uniacid']),array('value'))))['signnum'];
            $data['orders'] = implode($today)+$signnum;
            $data['reward'] = $bonusPoints;
            //积分签到模板消息通知
            $url = app_url('wlsign/signapp/signindex');
			$openid = pdo_getcolumn(PDO_NAME.'member',array('id'=>$member['mid']),'openid');
            Message::signNotice($openid,$member['nickname'],$cumulativeDays, $url);
            if($yesORon1 && $yesORon){
                wl_json(1,'签到成功',$data);
            }else{
                wl_json(0,'签到失败');
            }
        }else{
            wl_json(0,'今天已经签到了');
        }
    }
    /**
     * Comment: 获取特殊奖励   获取连续签到奖励
     * Author: zzw
     */
    public function specialReward(){
        global $_W,$_GPC;
        $ysar  = $_GPC['year'];
        $month = $_GPC['month'];
        $cumulativeDays = $_GPC['cumulativeDays'];//已经连续签到的天数
        $sign  = $_W['wlsetting']['wlsign'];//签到规则
        $info  = [];//特殊奖励信息
        $begin = mktime(0,0,0,$month,1,$ysar);//当月开始时间
        $end   = mktime(23,59,59,$month,date("t"),$ysar);//当月结束时间
        //获取当月的特殊奖励
        foreach ($sign['specialreward'] as $k => $v){
            if($v['signtime'] > $begin && $v['signtime'] < $end){
                $infoKey = count($info);
                $info[$infoKey]['time']  = date("Ynj",$v['signtime']);
                $info[$infoKey]['title'] = $v['signtitle']."特别奖励".$v['special']."积分";
            }
        }
        //获取连续签到奖励
        $times = '';//最近的累计奖励
        foreach($sign['totalreward'] as $k => $v){
            if($v['total'] > $cumulativeDays){
                if($times == ''){
                    $times = $v;
                }else if($v['total'] < $times['total']){
                    $times = $v;
                }
            }
        }
        //判断当天是否存在特殊奖励  存在特殊奖励不显示累计奖励
        if($times != '' && !in_array(date("Ynj",strtotime("+".$times['total'] - $cumulativeDays." Day")),array_column($info,'time'))){
            $infoKey = count($info);
            #1、判断今天是否签到  已签到补充时间 +1
            $distance = 0;//补充时间
            $dates = date("Ymd");
            $daySign = Wlsign::queryRecord('*',$dates);
            if($daySign){
                $distance = $distance+1;
            }
            #2、判断昨天是否签到 签到从累计签到第一天开始计算  否则从今天开始计算
            $Yesterdays = date("Ymd",strtotime("-1 Day"));
            $Yesterday  = pdo_fetch("SELECT * FROM ".tablename(PDO_NAME."signrecord")."WHERE mid = ".$_W['mid']." AND `date` = ".$Yesterdays);
            #3、获取第一天签到的时间
            if($Yesterday){
                //昨天签到  从累计签到第一天开始计算
                $oneTime = strtotime("-".($cumulativeDays - $distance)." Day");
                $oneTime = $oneTime + (($times['total'] - 1) * 3600 * 24 );
                $info[$infoKey]['time']  =  date("Ynj",$oneTime);
            }else{
                //昨天没有签到 从今天开始计算
                $info[$infoKey]['time']  = date("Ynj",strtotime("+".($times['total'] - 1)." Day"));
            }
            $info[$infoKey]['title'] = '连续签到'.$times['total'].'天,特别奖励'.$times['reward']."积分";
        }
        $data['info'] = $info;
        $data['time'] = date("Ynj",time());
        wl_json('1','获取成功',$data);
    }
}
