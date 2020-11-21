<?php
/**************
 * 用户信息页面
 */

global $_W, $_GPC;
$do = trim($_GPC['do']);
$cmd = trim($_GPC['cmd']);
require_once '../addons/vote_res/inc/web/dbhelp3.php';
$dbobj=new dbhelp3();

if ($do == 'member') {
    if (empty($cmd) || $cmd == 'index'){
        $pindex = max(1,intval($_GPC['page']));
        $psize = !empty($_GPC['psize'])?$_GPC['psize']:10;
        $where=array('a.uniacid'=>$_W['uniacid']);
        (!empty($_GPC['keyword']))?$where['a.realname|a.mobile|a.nickname like']=$_GPC['keyword']:'';
        (!empty($_GPC['type']))?$where['a.type']=$_GPC['type']:'';
        $membertype = $dbobj->table('VoteResMemberType')->where(array('uniacid'=>$_W['uniacid']))->pdo_select();
        $listall=$dbobj->table('VoteResMember a')->field('a.*,b.openid,b.nickname,b.uid,c.typename')
            ->join('McMappingFans b', 'a.mid=b.fanid','left')
            ->join('VoteResMemberType c','a.type=c.id','left')
            ->where($where)
            ->order('a.createtime DESC ')
            ->page($psize,$pindex)
            ->pdo_select();
        
        if (!empty($listall['list'])){
            foreach ($listall['list'] as &$v){
                $v['realname'] = $v['realname']?:($v['nickname']?:'暂未获取');
                $v['mobile'] = $v['mobile']?:'暂未获取';
                $v['tpnum'] = pdo_fetchcolumn('SELECT count(id) tpnum FROM ' . tablename('vote_res_log') . ' WHERE mid = :mid AND uniacid = :uniacid ',array(':mid'=>$v['mid'],':uniacid'=>$_W['uniacid']));
				$v['zjnum'] = $dbobj->table('VoteResLottery')->where(array('uniacid'=>$_W['uniacid'],'enabled >'=>'0','mid'=>$v['mid']))->pdo_count();   
			}
            unset($v);
        }

        $pager=($listall && $listall['count'] && $listall['count']>0)?pagination($listall['count'],$pindex,$psize):'';

        include $this->template('web/member/index');
    }elseif($cmd=='add'){	//添加中奖
    	if ($_W['ispost']){
	        $mid=intval($_GPC['mid']);
			$acid=intval($_GPC['acid']);
			if(!$acid){
				show_json(0,'活动ID不能为空');
			}
			$isactive=$dbobj->table('VoteResActivity')->where('id',$acid)->pdo_find();
			if(!$isactive){
				show_json(0,'活动不存在');
			}
			if($isactive['enabled']=='0'){
				show_json(0,'活动已关闭');
			}

			
	        $isactive=$dbobj->table('VoteResLottery')->where(array('mid'=>$mid,'uniacid'=>$_W['uniacid'],'activid'=>$acid,'enabled >'=>'-1'))->pdo_count();
	        
			if($isactive>0){
	            show_json(0,'该活动用户已经中奖过');
	        }
			
	        $lottData=array(
	            'uniacid'=>$_W['uniacid'],
	            'mid'=>$mid,
	            'activid'=>$acid,
				'enabled'=>'0',
				'createtime'=>time(),
	            'beizhu'=>'',
	        );
	        $result=$dbobj->table('VoteResLottery')->pdo_save($lottData);
	        if(!$result){
	            show_json(0,'操作失败');
	        }
	        show_json(1,'操作成功');
    	}else{
			if($_GPC['mid']){
				$meminfo=$dbobj->table('VoteResMember a')->field('a.*,b.openid,b.nickname,b.uid')
						->join('McMappingFans b', 'a.mid=b.fanid','left')
						->where(array('a.mid'=>$_GPC['mid'],'a.uniacid'=>$_W['uniacid']))->pdo_find();
				if($meminfo){
					$meminfo['realname'] = $meminfo['realname']?$meminfo['realname']:($meminfo['nickname']?:'暂未获取');
				}		
				
				$activearr=$dbobj->table('VoteResActivity')->pdo_select();
			
				include $this->template('web/member/form');
			}
    	}
    }
}