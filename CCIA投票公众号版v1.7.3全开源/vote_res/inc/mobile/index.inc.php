<?php

global $_W, $_GPC;
$do = trim($_GPC['do']);
$cmd = trim($_GPC['cmd']);
$this->shopShare();
$_W['vote_res_title'] = $_W['vote_res']['vote_res_title']?:'CCIA投票';
if ($do == 'index') {
    if (empty($cmd) || $cmd == 'index') {
        $actinfo = pdo_fetch('SELECT * FROM ' . tablename('vote_res_activity') . ' WHERE uniacid = :uniacid AND enabled = 1 ',array(':uniacid'=>$_W['uniacid']));
        $membertype = pdo_fetchall('SELECT id,typename FROM ' . tablename('vote_res_member_type') . ' WHERE uniacid = :uniacid AND enabled = 1 ORDER BY sort DESC ',array(':uniacid'=>$_W['uniacid']));
        if (!empty($actinfo)){
            $starttime = date('Y-m-d',$actinfo['starttime']);
            $endtime = date('Y-m-d',$actinfo['endtime']);
        }
        $daystart=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $dayend=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        $list = pdo_fetchall('SELECT ac.*,rl1.id rl1id,count(rl2.id) `number` FROM ' . tablename('vote_res_activity_content') . ' ac left join ' . tablename('vote_res_log') . ' rl1 on ac.id = rl1.contentid AND rl1.mid = :mid AND rl1.uniacid = :uniacid AND rl1.createtime BETWEEN :starttime AND :endtime  left join '.tablename('vote_res_log').' rl2 on rl2.contentid = ac.id AND rl2.uniacid = :uniacid  WHERE ac.uniacid = :uniacid AND ac.enabled = 1 AND ac.aid = :aid GROUP BY ac.id ORDER BY ac.sort DESC ',array(':uniacid'=>$_W['uniacid'],':starttime'=>$daystart,':endtime'=>$dayend,':mid'=>$_W['mid'],':aid'=>$actinfo['id']));
        if (!empty($list)){
            foreach ($list as &$v){
                $v['thumb'] = tomedia($v['thumb']);
            }
            unset($v);
        }
        include $this->template('index');
    }else if ($cmd == 'vote'){
        $id = intval($_GPC['id']);
        $checkid = pdo_getcolumn('vote_res_activity_content',array('id'=>$id),'id');
        if (empty($checkid)){
            show_json(0,'参数错误');
        }
        $daystart=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $dayend=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        $checkvote = pdo_fetchcolumn('SELECT id FROM ' . tablename('vote_res_log') . ' WHERE uniacid = :uniacid AND mid = :mid AND createtime BETWEEN :daystart AND :dayend ',array(':uniacid'=>$_W['uniacid'],':mid'=>$_W['mid'],':daystart'=>$daystart,':dayend'=>$dayend));
        if (!empty($checkvote)){
            show_json(0,'今天已经投过票了');
        }
        $data = array(
            'uniacid'=>$_W['uniacid'],
            'mid'=>$_W['mid'],
            'contentid'=>$id,
            'createtime'=>time()
        );
        pdo_insert('vote_res_log',$data);
        $number = pdo_fetchcolumn('SELECT count(id) FROM ' . tablename('vote_res_log') . ' WHERE uniacid = :uniacid AND contentid = :contentid ',array(':uniacid'=>$_W['uniacid'],':contentid'=>$id));
        show_json(1,array('message'=>'投票成功','number'=>$number));
    }else if ($cmd == 'update'){
        $realname = trim($_GPC['realname']);
        $mobile = trim($_GPC['mobile']);
        $type = trim($_GPC['type']);
        if (empty($realname)){
            show_json(0,'请填写用户名');
        }
        if (empty($mobile)){
            show_json(0,'请填写手机号');
        }
        if (!preg_match("/^1[3456789]\d{9}$/", $mobile)) {
            show_json(0,'手机号格式错误');
        }
        if (empty($type)){
            show_json(0,'请选择用户职业');
        }
        $checkid = pdo_getcolumn('vote_res_member',array('mobile'=>$mobile,'mid <>'=>$_W['mid']),'id');
        if (!empty($checkid)){
            show_json(0,'手机号已使用,请勿重复绑定');
        }
        $info = pdo_get('vote_res_member',array('mid'=>$_W['mid']));
        if (empty($info)){
            show_json(0,'参数错误');
        }
        if (!empty($info['realname'])){
            show_json(0,'信息已完善,请勿重复提交');
        }
        $data = array(
            'realname'=>$realname,
            'mobile'=>$mobile,
            'type'=>$type,
        );
        pdo_update('vote_res_member',$data,array('mid'=>$_W['mid']));
        show_json(1,'信息完善成功');
    }
}

    