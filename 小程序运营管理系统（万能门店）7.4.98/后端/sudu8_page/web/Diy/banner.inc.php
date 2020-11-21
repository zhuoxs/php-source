<?php
		global $_GPC, $_W;
    	$uniacid = $_W['uniacid'];
    	
    	$opt = $_GPC['opt'];


        $ops = array('banner','post','delete');

        $opt = in_array($opt, $ops) ? $opt : 'banner';

        if($opt =="banner"){
			$list = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type ='banner' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));
        }

        if ($opt == 'post'){

            $id = intval($_GPC['id']);

            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));

            if (checksubmit('submit')) {

                if(is_null($_GPC['flag'])){

                    $_GPC['flag'] = 1;

                }

                $data = array(

                    'uniacid' => $_W['uniacid'],

                    'num' => intval($_GPC['num']),

                    'type' =>$_GPC['type'],

                    'flag' => $_GPC['flag'],

                    'pic' => $_GPC['pic'],

                    'url' => trim($_GPC['url']),

                    'descp' => $_GPC['descp'],

                );

                if (empty($item['id'])) {

                    pdo_insert('sudu8_page_banner', $data);

                } else {

                    pdo_update('sudu8_page_banner', $data ,array('id' => $item['id']));

                }
                message('图片添加成功!', $this->createWeburl('Diy', array('id' => $id, 'opt' =>'banner','op' => 'banner','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'],'id' => $item['id'])), 'success');

            }

        }
        //删除

        if ($opt == 'delete') {

            $id = intval($_GPC['id']);

            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));

            if (empty($row)) {

                message('图片不存在或是已经被删除！');

            }

            pdo_delete('sudu8_page_banner', array('id' => $id ,'uniacid' => $uniacid));

            message('删除成功!', $this->createWeburl('Diy', array('id' => $id, 'opt' =>'banner','op' => 'banner','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

        }
return include self::template('web/Diy/banner');
