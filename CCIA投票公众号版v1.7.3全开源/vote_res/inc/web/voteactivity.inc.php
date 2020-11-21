<?php

global $_W, $_GPC;
$do = trim($_GPC['do']);
$cmd = trim($_GPC['cmd']);
if ($do == 'voteactivity') {
    if (empty($cmd) || $cmd == 'index'){
        //活动列表
        $pindex = max(1,intval($_GPC['page']));
        $psize = 10;
        $where .= '';
        $params[':uniacid'] = $_W['uniacid'];
        if (!empty($_GPC['keyword'])){
            $where .= ' AND title like :keyword ';
            $params[':keyword'] = '%'.trim($_GPC['keyword']).'%';
        }
        $list = pdo_fetchall('SELECT * FROM ' . tablename('vote_res_activity') . ' WHERE uniacid = :uniacid '.$where.' ORDER BY createtime DESC limit '.($pindex - 1)*$psize.','.$psize,$params);
        $total = intval(pdo_fetchcolumn('SELECT count(id) FROM ' . tablename('vote_res_activity') . ' WHERE uniacid = :uniacid '.$where,$params));
        $pager = pagination($total, $pindex, $psize);
        include $this->template('web/voteactivity/index');
    }else if ($cmd == 'add'){
        //活动添加及详情
        if ($_W['ispost']){
            $aid = intval($_GPC['aid']);
            $title = trim($_GPC['title']);
            $desc = trim($_GPC['desc']);
            $voting = trim($_GPC['voting']);
            $enabled = intval($_GPC['enabled']);
            $starttime = trim($_GPC['starttime']);
            $endtime = trim($_GPC['endtime']);
            $explain = trim($_GPC['explain']);
            $thumb = trim($_GPC['thumb']);
            $votedesc = trim($_GPC['votedesc']);
            $fold = trim($_GPC['fold']);
            if (empty($title)){
                show_json(0,'请输入活动标题');
            }
            if (empty($desc)){
                show_json(0,'请输入活动描述');
            }
            if (empty($votedesc)){
                show_json(0,'请输入投票区描述');
            }
            if (empty($voting)){
                show_json(0,'请输入投票方式');
            }
            if (empty($starttime)){
                show_json(0,'请输入活动开始时间');
            }
            if (empty($endtime)){
                show_json(0,'请输入活动结束时间');
            }
            if (empty($explain)){
                show_json(0,'请填写中奖说明');
            }
            if (empty($thumb)){
                show_json(0,'请上传活动主图');
            }
            $starttime = strtotime($starttime);
            $endtime = strtotime($endtime);
            if ($starttime >= $endtime){
                show_json(0,'活动开始时间必须小于结束时间');
            }
            if ($endtime < time()){
                show_json(0,'活动结束时间必须大于当前时间');
            }
            if ($enabled == 1 && empty($aid)){
                $checkid = pdo_getcolumn('vote_res_activity',array('uniacid'=>$_W['uniacid'],'enabled'=>1),'id');
                if (!empty($checkid)){
                    show_json(0,'同时只能开启一个活动');
                }
            }else if ($enabled == 1 && !empty($aid)){
                $checkid = pdo_getcolumn('vote_res_activity',array('uniacid'=>$_W['uniacid'],'enabled'=>1,'id <>'=>$aid),'id');
                if (!empty($checkid)){
                    show_json(0,'同时只能开启一个活动');
                }
            }
            $data = array(
                'uniacid'=>$_W['uniacid'],
                'title'=>$title,
                'desc'=>$desc,
                'voting'=>$voting,
                'enabled'=>$enabled,
                'starttime'=>$starttime,
                'explain'=>$explain,
                'endtime'=>$endtime,
                'thumb'=>$thumb,
                'votedesc'=>$votedesc,
                'fold'=>$fold
            );
            if (empty($aid)){
                $data['createtime'] = time();
                pdo_insert('vote_res_activity',$data);
            }else{
                pdo_update('vote_res_activity',$data,array('id'=>$aid));
            }
            show_json(1,'操作成功');
        }
        $aid = intval($_GPC['aid']);
        if (!empty($aid)){
            $info = pdo_fetch('SELECT * FROM ' . tablename('vote_res_activity') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$aid));
            $starttime = $info['starttime'];
            $endtime = $info['endtime'];
        }else{
            $starttime = time();
            $endtime = strtotime("+1months",$starttime);
        }
        include $this->template('web/voteactivity/add');
    }else if ($cmd == 'success'){
        //活动开启
        $id = intval($_GPC['id']);
        if (empty($id)){
            show_json(0,'参数错误');
        }
        $info = pdo_fetch('SELECT id FROM ' . tablename('vote_res_activity') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$id));
        if (empty($info)){
            show_json(0,'参数错误');
        }
        $checkid = pdo_getcolumn('vote_res_activity',array('uniacid'=>$_W['uniacid'],'enabled'=>1,'id <>'=>$id),'id');
        if (!empty($checkid)){
            show_json(0,'同时只能开启一个活动');
        }
        pdo_update('vote_res_activity',array('enabled'=>1),array('id'=>$info['id']));
        show_json(1,'操作成功');
    }else if ($cmd == 'fail'){
        //活动关闭
        $id = intval($_GPC['id']);
        if (empty($id)){
            show_json(0,'参数错误');
        }
        $info = pdo_fetch('SELECT id FROM ' . tablename('vote_res_activity') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$id));
        if (empty($info)){
            show_json(0,'参数错误');
        }
        pdo_update('vote_res_activity',array('enabled'=>0),array('id'=>$info['id']));
        show_json(1,'操作成功');
    }else if ($cmd == 'del'){
        //活动删除
        $id = intval($_GPC['id']);
        if (empty($id)){
            show_json(0,'参数错误');
        }
        $info = pdo_fetch('SELECT id FROM ' . tablename('vote_res_activity') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$id));
        if (empty($info)){
            show_json(0,'参数错误');
        }
        pdo_delete('vote_res_activity',array('id'=>$info['id']));
        show_json(1,'操作成功');
    }else if ($cmd == 'content'){
        //活动内容列表
        $aid = intval($_GPC['aid']);
        $ainfo = pdo_fetch('SELECT * FROM ' . tablename('vote_res_activity') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$aid));
        $pindex = max(1,intval($_GPC['page']));
        $psize = 10;
        $where .= '';
        $params = array(
            ':uniacid'=>$_W['uniacid'],
            ':aid'=>$ainfo['id']
        );
        if (!empty($_GPC['keyword'])){
            $where .= ' AND ac.name like :keyword ';
            $params[':keyword'] = '%'.trim($_GPC['keyword']).'%';
        }
        $list = pdo_fetchall('SELECT ac.*,count(rl.id) `number` FROM ' . tablename('vote_res_activity_content') . ' ac left join ' . tablename('vote_res_log') . ' rl on ac.id = rl.contentid AND rl.uniacid = :uniacid WHERE ac.uniacid = :uniacid AND ac.aid = :aid  '.$where.'GROUP BY ac.id ORDER BY ac.sort DESC limit '.($pindex - 1)*$psize.','.$psize,$params);
        $total = intval(pdo_fetchcolumn('SELECT count(ac.id) FROM ' . tablename('vote_res_activity_content') . ' ac WHERE ac.uniacid = :uniacid AND ac.aid = :aid  '.$where,$params));
        $pager = pagination($total, $pindex, $psize);
        include $this->template('web/voteactivity/content');
    }else if ($cmd == 'contentadd'){
        //活动内容添加，修改，详情
        if ($_W['ispost']){
            $id = intval($_GPC['id']);
            $aid = intval($_GPC['aid']);
            $name = trim($_GPC['name']);
            $desc = trim($_GPC['desc']);
            $url = trim($_GPC['url']);
            $thumb = trim($_GPC['thumb']);
            $enabled = intval($_GPC['enabled']);
            $sort = intval($_GPC['sort']);
            if (empty($aid)){
                show_json(0,'参数错误');
            }
            if (empty($name)){
                show_json(0,'请填写内容标题');
            }
            if (empty($desc)){
                show_json(0,'请填写内容描述');
            }
            if (empty($url)){
                show_json(0,'请填写详情链接');
            }
            if (empty($thumb)){
                show_json(0,'请上传内容图片');
            }
            $data = array(
                'uniacid'=>$_W['uniacid'],
                'aid'=>$aid,
                'name'=>$name,
                'desc'=>$desc,
                'url'=>$url,
                'thumb'=>$thumb,
                'enabled'=>$enabled,
                'sort'=>$sort
            );
            if (empty($id)){
                $data['createtime'] = time();
                pdo_insert('vote_res_activity_content',$data);
            }else{
                pdo_update('vote_res_activity_content',$data,array('id'=>$id));
            }
            show_json(1,'操作成功');
        }
        $aid = intval($_GPC['aid']);
        $id = intval($_GPC['id']);
        $ainfo = pdo_fetch('SELECT * FROM ' . tablename('vote_res_activity') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$aid));
        if (!empty($id)){
            $info = pdo_fetch('SELECT * FROM ' . tablename('vote_res_activity_content') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$id));
        }
        include $this->template('web/voteactivity/contentadd');
    }else if ($cmd == 'contentsuccess'){
        //活动内容开启
        $id = intval($_GPC['id']);
        if (empty($id)){
            show_json(0,'参数错误');
        }
        $info = pdo_fetch('SELECT id FROM ' . tablename('vote_res_activity_content') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$id));
        if (empty($info)){
            show_json(0,'参数错误');
        }
        pdo_update('vote_res_activity_content',array('enabled'=>1),array('id'=>$info['id']));
        show_json(1,'操作成功');
    }else if ($cmd == 'contentfail'){
        //活动内容关闭
        $id = intval($_GPC['id']);
        if (empty($id)){
            show_json(0,'参数错误');
        }
        $info = pdo_fetch('SELECT id FROM ' . tablename('vote_res_activity_content') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$id));
        if (empty($info)){
            show_json(0,'参数错误');
        }
        pdo_update('vote_res_activity_content',array('enabled'=>0),array('id'=>$info['id']));
        show_json(1,'操作成功');
    }else if ($cmd == 'contentdel'){
        //活动内容删除
        $id = intval($_GPC['id']);
        if (empty($id)){
            show_json(0,'参数错误');
        }
        $info = pdo_fetch('SELECT id FROM ' . tablename('vote_res_activity_content') . ' WHERE uniacid = :uniacid AND id = :id ',array(':uniacid'=>$_W['uniacid'],':id'=>$id));
        if (empty($info)){
            show_json(0,'参数错误');
        }
        pdo_delete('vote_res_activity_content',array('id'=>$info['id']));
        show_json(1,'操作成功');
    }
}