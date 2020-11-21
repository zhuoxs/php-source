<?php
/**************
 * 中奖纪录审核页面
 */

global $_W, $_GPC;
$do = trim($_GPC['do']);
$cmd = trim($_GPC['cmd']);
require_once '../addons/vote_res/inc/web/dbhelp3.php';
$dbobj=new dbhelp3();

if ($do == 'lottery') {
    if (empty($cmd) || $cmd == 'index'){
    	$activearr=$dbobj->table('VoteResActivity')->pdo_select();
//     	print_r($activearr);exit(); 
    	$pindex = max(1,intval($_GPC['page']));
    	$psize = !empty($_GPC['psize'])?$_GPC['psize']:10;
    	$where=array('a.uniacid'=>$_W['uniacid']);
		(!empty($_GPC['keyword']))?$where['b.realname|b.mobile like']=$_GPC['keyword']:'';
		(!empty($_GPC['type']))?$where['b.type']=$_GPC['type']:'';
		(!empty($_GPC['activid']))?$where['a.activid']=$_GPC['activid']:'';
		(isset($_GPC['enabled']) && is_numeric($_GPC['enabled']))?$where['a.enabled']=$_GPC['enabled']:'';
		$listall=$dbobj->table('VoteResLottery a')
			->field('a.id,a.mid,a.enabled,a.createtime zjtime,a.beizhu,b.realname,b.nickname,b.mobile,b.type,c.title,d.typename')
			->join('VoteResMember b', 'a.mid=b.mid','left')
			->join('VoteResActivity c','a.activid=c.id','left')
			->join('VoteResMemberType d','b.type=d.id','left')
			->where($where)
			->order('a.createtime desc')
			->page($psize,$pindex)
			->pdo_select();
        $membertype = $dbobj->table('VoteResMemberType')->where(array('uniacid'=>$_W['uniacid']))->pdo_select();
		$pager=($listall && $listall['count'] && $listall['count']>0)?pagination($listall['count'],$pindex,$psize):'';
		
    	include $this->template('web/lottery/index');
    	
    }elseif($cmd=='add'){
    	//活动添加及详情
    	if ($_W['ispost']){
    		$id = intval($_GPC['id']);	
    		$enabled = intval($_GPC['enabled']);
    		$beizhu = trim($_GPC['beizhu']);
    		$createtime = trim($_GPC['zjtime']);
    		if (empty($createtime)){
    			show_json(0,'请选择中奖时间');
    		}
    		if(!strtotime($createtime)){
    			show_json(0,'请选择有效的中奖时间');
    		}
    		if (!isset($enabled) || !is_numeric($enabled)){
    			show_json(0,'请选择中奖状态');
    		}
    		$oldenabled=$dbobj->table('VoteResLottery')->where('id',$id)->order('createtime desc')->pdo_value('enabled');
    		if($oldenabled===false){
    			show_json(0,'中奖纪录不存在');
    		}
    		if($oldenabled=='2'){
    			show_json(0,'已发放奖品的状态无法更改');
    		}
    		$data = array(
    			'enabled'=>$enabled,
    			'createtime'=>strtotime($createtime),
    			'beizhu'=>$beizhu
    		);
    		$result=$dbobj->table('VoteResLottery')->where('id',$id)->pdo_save($data);
			if($result===false){
				show_json(1,'操作失败');
			}
    		show_json(1,'操作成功');
    	}
    	
    	$id = intval($_GPC['id']);
    	if (!empty($id)){
    		$info=$dbobj->table('VoteResLottery a')
    			->field('a.id,a.mid,a.enabled,a.createtime zjtime,a.beizhu,b.realname,b.nickname,b.mobile,b.type,c.title')
				->join('VoteResMember b', 'a.mid=b.mid','left')
				->join('VoteResActivity c','a.activid=c.id','left')
				->where(array('a.id'=>$id,'a.uniacid'=>$_W['uniacid']))
				->order('a.createtime desc')
    			->pdo_find();
    	}
    	
    	include $this->template('web/lottery/add');
    }
}
