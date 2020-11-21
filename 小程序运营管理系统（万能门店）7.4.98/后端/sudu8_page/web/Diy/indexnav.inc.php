<?php
        //这个操作被定义用来呈现 管理中心导航菜单
        global $_GPC, $_W;
        $opt = $_GPC['opt'];
        $ops = array('index', 'list','post','delete');
        $opt = in_array($opt, $ops) ? $opt : 'index';
        $uniacid = $_W['uniacid'];
        if ($opt == 'index'){
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_nav') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
            if($item['title_bg']){
                $item['title_bg'] =  $this->RGBToHex($item['title_bg']);
            }
            if (checksubmit('submit')) {
                if($_GPC['title_bg']){
                   $title_bg =  $this->hex2rgb($_GPC['title_bg']);
                }
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'statue' => intval($_GPC['statue']),
                    'type' => intval($_GPC['type']),
                    'name' => $_GPC['name'],
                    'ename' => $_GPC['ename'],
                    'name_s' => intval($_GPC['name_s']),
                    'style' => intval($_GPC['style']),
                    'url' => $_GPC['url'],
                    'box_p_tb' => floatval($_GPC['box_p_tb']),
                    'box_p_lr' => floatval($_GPC['box_p_lr']),
                    'number' => intval($_GPC['number']),
                    'img_size' => floatval($_GPC['img_size']),
                    'title_color' => $_GPC['title_color'],
                    'title_position' => intval($_GPC['title_position']),
                    'title_bg' => $title_bg,
                );
                //var_dump($tabbar);
                if (empty($item['uniacid'])) {
                    pdo_insert('sudu8_page_nav', $data);
                } else {
                    pdo_update('sudu8_page_nav', $data ,array('uniacid' => $uniacid));
                }
                message('导航添加/修改成功!', $this->createWebUrl('Diy', array('opt' => 'index','op' => 'indexnav', 'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
            }
        }
        if ($opt == 'list'){
            $list = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_navlist') ." WHERE uniacid = :uniacid ORDER BY num desc", array(':uniacid' => $uniacid));
        }
        if ($opt == 'post'){
            $id = $_GPC['id'];
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_navlist') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $id));
            if (checksubmit('submit')) {
                if(is_null($_GPC['flag'])){
                    $_GPC['flag'] = 1;
                }
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'num' => intval($_GPC['num']),
                    'flag' => intval($_GPC['flag']),
                    'type' => intval($_GPC['type']),
                    'title' => $_GPC['title'],
                    'pic' => $_GPC['pic'],
                    'url' => $_GPC['url'],
                    'url2' => $_GPC['url2'],
                );
                if (empty($item['id'])) {
                    pdo_insert('sudu8_page_navlist', $data);
                } else {
                    pdo_update('sudu8_page_navlist', $data ,array('uniacid' => $uniacid,'id' => $id));
                }
                message('导航添加/修改成功!', $this->createWebUrl('Diy', array('opt' => 'post','op' => 'indexnav', 'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'],'id'=>$id)), 'success');
            }
        }
        //删除
        if ($opt == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_navlist')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('导航不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_navlist', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('Diy', array('opt' => 'list','op' => 'indexnav', 'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }
return include self::template('web/Diy/indexnav');