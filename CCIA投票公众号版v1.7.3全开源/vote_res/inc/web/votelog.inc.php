<?php
/**************
 * 投票纪录页面
*/

global $_W, $_GPC;
$do = trim($_GPC['do']);
$cmd = trim($_GPC['cmd']);
require_once '../addons/vote_res/inc/web/dbhelp3.php';
$dbobj=new dbhelp3();

if ($do == 'votelog') {
	if (empty($cmd) || $cmd == 'index'){
		$pindex = max(1,intval($_GPC['page']));
		$psize = !empty($_GPC['psize'])?$_GPC['psize']:10;
		$where=array('a.uniacid'=>$_W['uniacid']);
		if(!empty($_GPC['keyword']) && !empty($_GPC['type'])){
			if($_GPC['type']=='1'){
				$where['d.realname|d.mobile like']=$_GPC['keyword'];
			}elseif($_GPC['type']=='2'){
				$where['b.name like']=$_GPC['keyword'];
			}else{
				$where['c.title like']=$_GPC['keyword'];
			}
		}
		$having=(isset($_GPC['enabled']) && is_numeric($_GPC['enabled']))?' and zjstatus='.$_GPC['enabled']:'';
		$listall=$dbobj->table('VoteResLog a')
			->field('a.*,b.aid,b.name,b.desc,b.thumb,b.url,b.enabled,c.title,c.desc,c.voting,c.starttime,c.endtime,c.enabled cenabled,d.realname,d.nickname,d.mobile')
			->join('VoteResActivityContent b', 'a.contentid=b.id','left')
			->join('VoteResActivity c', 'b.aid=c.id','left')
			->join('VoteResMember d', 'a.mid=d.mid','left')
			->where($where)
			->order('a.createtime asc')
			->page($psize,$pindex)
			->pdo_select();
        if (!empty($listall['list'])){
            foreach ($listall['list'] as &$v){
                $v['realname'] = $v['realname']?:($v['nickname']?:'暂未获取');
                $v['typename'] = $v['type'] == 1?'普通用户':($v['type'] == 2?'医生':'暂未获取');
                $v['mobile'] = $v['mobile']?:'暂未获取';
            }
            unset($v);
        }
		$pager=($listall && $listall['count'] && $listall['count']>0)?pagination($listall['count'],$pindex,$psize):'';
		
		include $this->template('web/votelog/index');
	}
}