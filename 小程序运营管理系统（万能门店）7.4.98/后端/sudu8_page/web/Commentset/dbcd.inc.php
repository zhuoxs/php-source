<?php 

load()->func('tpl');
define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page/');
global $_GPC, $_W;
        $opt = $_GPC['opt'];
        $ops = array('index', 'list','post','listpost','delete','listdelete');
        $opt = in_array($opt, $ops) ? $opt : 'index';
        $uniacid = $_W['uniacid'];
        if ($opt == 'index'){
            $list = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_art_nav') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
        }
        if ($opt == 'post'){
            $id = $_GPC['id'];
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_art_nav') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $id));
            if (checksubmit('submit')) {
                if(is_null($_GPC['flag'])){
                    $_GPC['flag'] = 1;
                }
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'num' => intval($_GPC['num']),
                    'flag' => intval($_GPC['flag']),
                    'title' => $_GPC['title']
                );
                if (empty($item['id'])) {
                    pdo_insert('sudu8_page_art_nav', $data);
                } else {
                    pdo_update('sudu8_page_art_nav', $data ,array('uniacid' => $uniacid,'id' => $id));
                }
                message('导航组添加/修改成功!', $this->createWebUrl('Commentset', array('op'=>'dbcd','opt'=>"post",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'],"id"=>$id)), 'success');
            }
        }
        if ($opt == 'list'){
            $list = pdo_fetchAll("SELECT a.*,b.title as name FROM ".tablename('sudu8_page_art_navlist') ." as a LEFT JOIN ".tablename('sudu8_page_art_nav')." as b on a.cid = b.id WHERE a.uniacid = :uniacid ORDER BY a.num desc", array(':uniacid' => $uniacid));
        }
        if ($opt == 'listpost'){
            $id = $_GPC['id'];
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_art_navlist') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $id));
            include ROOT_PATH.'inc/RGBToHex.php';
            $item['bgcolor'] =  RGBToHex($item['bgcolor']);
            $item['textcolor'] = RGBToHex($item['textcolor']);

            $cate = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_art_nav') ." WHERE flag=1 and uniacid = :uniacid ORDER BY num desc", array(':uniacid' => $uniacid));
            if (checksubmit('submit')) {
                if(is_null($_GPC['flag'])){
                    $_GPC['flag'] = 1;
                }
               
       include ROOT_PATH.'inc/hex2rgb.php';
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'title' => $_GPC['title'],
                    'cid' => $_GPC['cid'],
                    'type' => intval($_GPC['type']),
                    'url' => $_GPC['url'],
                    'flag' => intval($_GPC['flag']),
                    'num' => intval($_GPC['num']),
                    'bgcolor' => hex2rgb($_GPC['bgcolor']),
                    'textcolor' => hex2rgb($_GPC['textcolor'])
                );
                if (empty($item['id'])) {
                    pdo_insert('sudu8_page_art_navlist', $data);
                } else {
                    pdo_update('sudu8_page_art_navlist', $data ,array('uniacid' => $uniacid,'id' => $id));
                }

                message('导航添加/修改成功!', $this->createWebUrl('Commentset', array('op'=>'dbcd','opt'=>"listpost",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'],"id"=>$id)), 'success');
            }
        }
        //删除
        if ($opt == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_art_nav')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('导航组不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_art_nav', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功', $this->createWebUrl('Commentset', array('op'=>'dbcd','opt'=>"index",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }
        if ($opt == 'listdelete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_art_navlist')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('导航不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_art_navlist', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功', $this->createWebUrl('Commentset', array('op'=>'dbcd','opt'=>"list",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }
return include self::template('web/Commentset/dbcd');
