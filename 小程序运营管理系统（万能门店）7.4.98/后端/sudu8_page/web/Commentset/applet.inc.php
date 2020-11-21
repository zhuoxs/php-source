<?php


load()->func('tpl');
 global $_GPC, $_W;
        $opt = $_GPC['opt'];
        $ops = array('display', 'post', 'delete');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        $uniacid = $_W['uniacid'];
        //文章列表
        if ($opt == 'display'){
            $_W['page']['title'] = '小程序管理';
            $where = "";
            if(!empty($_GPC['sid']) || !empty($_GPC['skey'])){
                if(!empty($_GPC['sid']) && $_GPC['sid'] > 0){
                    $sid = $_GPC['sid'];
                    $where .= " and i.cid = ".$sid;
                }
                if(!empty($_GPC['skey'])){
                    $skey = $_GPC['skey'];
                    $where .= " and i.title like '%".$skey."%'";
                }
            }
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_wxapps')."as i left join" .tablename('sudu8_page_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." and i.type ='showWxapps'".$where);
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);
            $wxapps = pdo_fetchall("SELECT i.num,i.thumb,i.title,i.id,c.name,i.type FROM ".tablename('sudu8_page_wxapps')."as i left join" .tablename('sudu8_page_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." and i.type ='showWxapps'".$where." ORDER BY i.num DESC,i.id DESC LIMIT ".$start.",".$pagesize);
            // 获取文章分类
            $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showWxapps' and cid = 0", array(':uniacid' => $uniacid));
            foreach ($cates as $key => &$res) {
                $res['ziji'] = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showWxapps' and cid = :cid", array(':uniacid' => $uniacid,':cid' => $res['id']));
            }
        }
        //文章添加、修改
        if ($opt == 'post'){
            $id = intval($_GPC['id']);
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_wxapps')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            //var_dump($item);
            $listV = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE cid = :cid and uniacid = :uniacid and type='showWxapps' ORDER BY num DESC,id DESC", array(':cid' => 0 ,':uniacid' => $uniacid));
            $listAll = array();
            foreach($listV as $key=>$val) {
                $cid = intval($val['id']);
                $listP = pdo_fetch("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and id = :id and type='showWxapps' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
                $listS = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and cid = :id and type='showWxapps' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
                $listP['data'] = $listS;
                array_push($listAll,$listP);
            }
            if (!empty($id)) {
                if (empty($item)) {
                    message('抱歉，小程序不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')) {
                if (empty($_GPC['title'])) {
                    message('小程序名字不能为空，请输入！');
                }
                $cid = intval($_GPC['cid']);
                $pcid = pdo_fetch("SELECT cid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id =:id ", array(':uniacid' => $uniacid,':id'=>$cid));
                $pcid=implode('',$pcid);
                if($pcid == 0){
                    $pcid = $cid;
                }else{
                    $pcid = intval($pcid);
                }
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'cid' => intval($_GPC['cid']),
                    'pcid' => $pcid,
                    'type' => 'showWxapps',
                    'num' => intval($_GPC['num']),
                    'type_i' => intval($_GPC['type_i']),
                    'title' => addslashes($_GPC['title']),
                    'thumb'=>$_GPC['thumb'],
                    'appId'=>$_GPC['appId'],
                    'path'=>$_GPC['path'],
                    'desc'=>$_GPC['desc'],
                );
                if (!empty($_GPC['thumb'])) {
                    $data['thumb'] = parse_path($_GPC['thumb']);
                }
                if (empty($id)) {
                    pdo_insert('sudu8_page_wxapps', $data);
                } else {
                    pdo_update('sudu8_page_wxapps', $data, array('id' => $id ,'uniacid' => $uniacid));
                }
                message('小程序 添加/修改 成功!', $this->createWebUrl('Commentset', array('op'=>'applet','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'],'id'=>$id)), 'success');

            }
        }
        //删除文章
        if ($opt == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_wxapps')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('小程序不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_wxapps', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('Commentset', array('op'=>'applet','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }




return include self::template('web/Commentset/applet');
