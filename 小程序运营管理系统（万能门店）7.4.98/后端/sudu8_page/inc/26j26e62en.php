<?php

//base

       global $_GPC, $_W;

        $uniacid = $_W['uniacid'];

        $op = $_GPC['op'];

        $ops = array('base','display', 'post', 'delete');

        $op = in_array($op, $ops) ? $op : 'base';

        //多门店设置
        if ($op == 'base'){

            $_W['page']['title'] = '多门店基础设置';

            $item =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_storeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));

            if (checksubmit('submit')) {

                $data = array(

                        'uniacid'=> $uniacid,

                        'mapkey' => $_GPC['mapkey'],

                        'flag' => $_GPC['flag'],

                    );

                if (empty($item['uniacid'])) {

                    pdo_insert('sudu8_page_storeconf', $data);

                } else {

                    pdo_update('sudu8_page_storeconf', $data ,array('uniacid' => $uniacid));

                }

                message('多门店基础设置成功!', $this->createWebUrl('store', array('op'=>'base')), 'success');

            }

        }

        //多门店列表

        if ($op == 'display'){

            $_W['page']['title'] = '多门店列表';

            $store =  pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid ORDER BY id DESC" , array(':uniacid' => $uniacid));

        }

        if ($op == 'post'){

            $id = intval($_GPC['id']);

            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_store')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));



            $item['thumb'] =  $item['thumb'];



            $item['text'] = unserialize($item['text']);

            if (checksubmit('submit')) {



                if(!$_GPC['title']){

                    message('多门店不能为空！');

                }

                if(!$_GPC['cit']){

                    message('多门店地区不能为空！');

                }

                if($_GPC['score']){

                    if($_GPC['score']<=0){

                        $_GPC['score']=1;

                    }

                    if($_GPC['score']>5){

                        $_GPC['score']=5;

                    }

                }

                $data = array(

                    "uniacid" => $uniacid,

                    "thumb" => $_GPC['thumb'],

                    "logo" => $_GPC['logo'],

                    "title" => $_GPC['title'],

                    "lat" => $_GPC['lat'],

                    "lon" => $_GPC['lon'],  

                    "tel" => $_GPC['tel'], 

                    "times" => $_GPC['times'], 

                    "title1" => $_GPC['title1'],

                    "title2" => $_GPC['title2'],

                    "descp" => $_GPC['descp'],

                    "country" => $_GPC['country'],

                    "text" => serialize($_GPC['text']),

                    "dateline" => time(),

                    "province" => $_GPC['pro'],

                    "city" => $_GPC['cit'],

                    "proid" => $_GPC['province'],

                    "cityid" => $_GPC['city'],
                    "desc2" => $_GPC['desc2'],

                );

                // echo "<pre>";
                // var_dump($data);
                // echo "</pre>";
                // die();

                if(empty($id)){

                    pdo_insert('sudu8_page_store', $data);

                }else{

                    pdo_update('sudu8_page_store', $data, array('id' => $id ,'uniacid' => $uniacid));

                }   

                message('多门店 添加/修改 成功!', $this->createWebUrl('store', array('op'=>'display')), 'success');

            }

        }

        //删除

        if ($op == 'delete') {

            $id = intval($_GPC['id']);

            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_store')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));

            if (empty($row)) {

                message('门店不存在或是已经被删除！');

            }

            pdo_delete('sudu8_page_store', array('id' => $id ,'uniacid' => $uniacid));

            message('删除成功!', $this->createWebUrl('store', array('op'=>'display')), 'success');

        }

        if(1==2){

                $tabbar = array();

                $tabbar1 = array(  

                    'tabbar_l' => $_GPC['tabbar1_l'],

                    'tabbar_t' => $_GPC['tabbar1_t'],

                    'tabbar_p1' => $_GPC['tabbar1_p1'],

                    'tabbar_p2' => $_GPC['tabbar1_p2'],

                    'tabbar_url' => $_GPC['tabbar1_url'],

                );

                $tabbar2 = array(  

                    'tabbar_l' => $_GPC['tabbar2_l'],

                    'tabbar_t' => $_GPC['tabbar2_t'],

                    'tabbar_p1' => $_GPC['tabbar2_p1'],

                    'tabbar_p2' => $_GPC['tabbar2_p2'],

                    'tabbar_url' => $_GPC['tabbar2_url'],

                );

                $tabbar3 = array(  

                    'tabbar_l' => $_GPC['tabbar3_l'],

                    'tabbar_t' => $_GPC['tabbar3_t'],

                    'tabbar_p1' => $_GPC['tabbar3_p1'],

                    'tabbar_p2' => $_GPC['tabbar3_p2'],

                    'tabbar_url' => $_GPC['tabbar3_url'],

                );

                $tabbar4 = array(  

                    'tabbar_l' => $_GPC['tabbar4_l'],

                    'tabbar_t' => $_GPC['tabbar4_t'],

                    'tabbar_p1' => $_GPC['tabbar4_p1'],

                    'tabbar_p2' => $_GPC['tabbar4_p2'],

                    'tabbar_url' => $_GPC['tabbar4_url'],

                );

                $tabbar5 = array(  

                    'tabbar_l' => $_GPC['tabbar5_l'],

                    'tabbar_t' => $_GPC['tabbar5_t'],

                    'tabbar_p1' => $_GPC['tabbar5_p1'],

                    'tabbar_p2' => $_GPC['tabbar5_p2'],

                    'tabbar_url' => $_GPC['tabbar5_url'],

                );

                for($i = 1; $i < 6; $i++){

                    $id = $_GPC['tabbar'.$i.'_l'];

                    if(is_numeric($id)){

                        $cate_type = pdo_fetch("SELECT id,type,list_type FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $id));

                        $v = "tabbar".$i;

                        if($cate_type['type'] != 'page'){

                            ${$v}['type']= $cate_type['id'];

                        }else{

                            ${$v}['type']= $cate_type['type'];

                        }

                    }

                }

                $tabbar1 = serialize($tabbar1);

                $tabbar2 = serialize($tabbar2);

                $tabbar3 = serialize($tabbar3);

                $tabbar4 = serialize($tabbar4);

                $tabbar5 = serialize($tabbar5);

                if($_GPC['tabbar1_l'] != 'none'){

                    $tabbar[0]=$tabbar1;

                }

                if($_GPC['tabbar2_l'] != 'none'){

                    $tabbar[1]=$tabbar2;

                }

                if($_GPC['tabbar3_l'] != 'none'){

                    $tabbar[2]=$tabbar3;

                }

                if($_GPC['tabbar4_l'] != 'none'){

                    $tabbar[3]=$tabbar4;

                }

                if($_GPC['tabbar5_l'] != 'none'){

                    $tabbar[4]=$tabbar5;

                }

                $tabnum = count($tabbar);

                $tabbar = serialize($tabbar);

                $data = array(

                    'uniacid' => $_W['uniacid'],

                    'tabbar_bg' => $_GPC['tabbar_bg'],

                    'color_bar' => $_GPC['color_bar'],

                    'tabbar_tc' => $_GPC['tabbar_tc'],

                    'tabbar_tca'=>$_GPC['tabbar_tca'],

                    'tabbar_time'=>$_GPC['tabbar_time'],

                    'tabnum' => intval($tabnum),

                    'tabbar' => $tabbar,

                );

                $tabbar = array();

                $tabbar1 = array(  

                    'tabbar_l' => $_GPC['tabbar1_l'],

                    'tabbar_t' => $_GPC['tabbar1_t'],

                    'tabbar_p1' => $_GPC['tabbar1_p1'],

                    'tabbar_p2' => $_GPC['tabbar1_p2'],

                    'tabbar_url' => $_GPC['tabbar1_url'],

                );

                $tabbar2 = array(  

                    'tabbar_l' => $_GPC['tabbar2_l'],

                    'tabbar_t' => $_GPC['tabbar2_t'],

                    'tabbar_p1' => $_GPC['tabbar2_p1'],

                    'tabbar_p2' => $_GPC['tabbar2_p2'],

                    'tabbar_url' => $_GPC['tabbar2_url'],

                );

                $tabbar3 = array(  

                    'tabbar_l' => $_GPC['tabbar3_l'],

                    'tabbar_t' => $_GPC['tabbar3_t'],

                    'tabbar_p1' => $_GPC['tabbar3_p1'],

                    'tabbar_p2' => $_GPC['tabbar3_p2'],

                    'tabbar_url' => $_GPC['tabbar3_url'],

                );

                $tabbar4 = array(  

                    'tabbar_l' => $_GPC['tabbar4_l'],

                    'tabbar_t' => $_GPC['tabbar4_t'],

                    'tabbar_p1' => $_GPC['tabbar4_p1'],

                    'tabbar_p2' => $_GPC['tabbar4_p2'],

                    'tabbar_url' => $_GPC['tabbar4_url'],

                );

                $tabbar5 = array(  

                    'tabbar_l' => $_GPC['tabbar5_l'],

                    'tabbar_t' => $_GPC['tabbar5_t'],

                    'tabbar_p1' => $_GPC['tabbar5_p1'],

                    'tabbar_p2' => $_GPC['tabbar5_p2'],

                    'tabbar_url' => $_GPC['tabbar5_url'],

                );

                for($i = 1; $i < 6; $i++){

                    $id = $_GPC['tabbar'.$i.'_l'];

                    if(is_numeric($id)){

                        $cate_type = pdo_fetch("SELECT id,type,list_type FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $id));

                        $v = "tabbar".$i;

                        if($cate_type['type'] != 'page'){

                            ${$v}['type']= $cate_type['id'];

                        }else{

                            ${$v}['type']= $cate_type['type'];

                        }

                    }

                }

                $tabbar1 = serialize($tabbar1);

                $tabbar2 = serialize($tabbar2);

                $tabbar3 = serialize($tabbar3);

                $tabbar4 = serialize($tabbar4);

                $tabbar5 = serialize($tabbar5);

                if($_GPC['tabbar1_l'] != 'none'){

                    $tabbar[0]=$tabbar1;

                }

                if($_GPC['tabbar2_l'] != 'none'){

                    $tabbar[1]=$tabbar2;

                }

                if($_GPC['tabbar3_l'] != 'none'){

                    $tabbar[2]=$tabbar3;

                }

                if($_GPC['tabbar4_l'] != 'none'){

                    $tabbar[3]=$tabbar4;

                }

                if($_GPC['tabbar5_l'] != 'none'){

                    $tabbar[4]=$tabbar5;

                }

                $tabnum = count($tabbar);

                $tabbar = serialize($tabbar);

                $data = array(

                    'uniacid' => $_W['uniacid'],

                    'tabbar_bg' => $_GPC['tabbar_bg'],

                    'color_bar' => $_GPC['color_bar'],

                    'tabbar_tc' => $_GPC['tabbar_tc'],

                    'tabbar_tca'=>$_GPC['tabbar_tca'],

                    'tabbar_time'=>$_GPC['tabbar_time'],

                    'tabnum' => intval($tabnum),

                    'tabbar' => $tabbar,

                );

            }

        include $this->template('store');