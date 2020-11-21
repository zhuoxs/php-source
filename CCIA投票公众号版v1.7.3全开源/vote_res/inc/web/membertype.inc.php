<?php
/**************
 * 用户类型
 */

global $_W, $_GPC;
$do = trim($_GPC['do']);
$cmd = trim($_GPC['cmd']);

if ($do == 'membertype') {
    if (empty($cmd) || $cmd == 'index'){
        $list = pdo_fetchall('SELECT * FROM ' . tablename('vote_res_member_type') . ' WHERE uniacid = :uniacid ORDER BY sort DESC ',array(':uniacid'=>$_W['uniacid']));
        include $this->template('web/membertype/index');
    }else if ($cmd == 'add'){
        if ($_W['ispost']){
            $id = intval($_GPC['id']);
            $typename = trim($_GPC['typename']);
            if (empty($typename)){
                show_json(0,'用户类型名称不能为空');
            }
            $data = array(
                'uniacid'=>$_W['uniacid'],
                'typename'=>$typename,
                'sort'=>intval($_GPC['sort']),
                'enabled'=>intval($_GPC['enabled'])
            );
            if (empty($id)){
                $data['createtime'] = time();
                pdo_insert('vote_res_member_type',$data);
            }else{
                pdo_update('vote_res_member_type',$data,array('id'=>$id));
            }
            show_json(1,'操作成功');
        }
        $id = intval($_GPC['id']);
        if (!empty($id)){
            $info = pdo_fetch('SELECT * FROM ' . tablename('vote_res_member_type') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$id));
        }
        include $this->template('web/membertype/add');
    }else if ($cmd == 'success'){
        //类型开启
        $id = intval($_GPC['id']);
        if (empty($id)){
            show_json(0,'参数错误');
        }
        $info = pdo_fetch('SELECT id FROM ' . tablename('vote_res_member_type') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$id));
        if (empty($info)){
            show_json(0,'参数错误');
        }
        pdo_update('vote_res_member_type',array('enabled'=>1),array('id'=>$info['id']));
        show_json(1,'操作成功');
    }else if ($cmd == 'fail'){
        //活动关闭
        $id = intval($_GPC['id']);
        if (empty($id)){
            show_json(0,'参数错误');
        }
        $info = pdo_fetch('SELECT id FROM ' . tablename('vote_res_member_type') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$id));
        if (empty($info)){
            show_json(0,'参数错误');
        }
        pdo_update('vote_res_member_type',array('enabled'=>0),array('id'=>$info['id']));
        show_json(1,'操作成功');
    }else if ($cmd == 'del'){
        //活动删除
        $id = intval($_GPC['id']);
        if (empty($id)){
            show_json(0,'参数错误');
        }
        $info = pdo_fetch('SELECT id FROM ' . tablename('vote_res_member_type') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$id));
        if (empty($info)){
            show_json(0,'参数错误');
        }
        pdo_delete('vote_res_member_type',array('id'=>$info['id']));
        show_json(1,'操作成功');
    }
}