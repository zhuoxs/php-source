<?php

//base

        load()->func('tpl');

        global $_GPC, $_W;

        $op = $_GPC['op'];

        $ops = array('base', 'about','banner','bigad','miniad','indexad','post','delete');

        $op = in_array($op, $ops) ? $op : 'base';

        $uniacid = $_W['uniacid'];



        if ($op == 'base'){



            $_W['page']['title'] = '产品基础信息添加';

            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_base') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

            $item['slide'] = unserialize($item['slide']);

            if (checksubmit('submit')) {


                if (empty($_GPC['name'])) {

                    message('请输入门店名称！');

                }
              

                $data = array(

                    'uniacid' => $_W['uniacid'],

                    'banner' => $_GPC['banner'],

                    'slide' => serialize($_GPC['slide']),

                    'name' => $_GPC['name'],

                    'logo' => $_GPC['logo'],

                    'logo2' => $_GPC['logo2'],
                    
                    'video' => $_GPC['video'],

                    'v_img' => $_GPC['v_img'],

                    'desc' => $_GPC['desc'],

                    'address' => $_GPC['address'],

                    'time' => $_GPC['time'],

                    'tel' => $_GPC['tel'],

                    'longitude' => $_GPC['longitude'],

                    'latitude' => $_GPC['latitude'],

                    'about' => $_GPC['about'],

                );




                if (empty($item['name'])) {

                    pdo_insert('sudu8_page_base', $data);

                } else {

                    pdo_update('sudu8_page_base', $data ,array('uniacid' => $uniacid));

                }

                message('基础信息更新成功!', $this->createWebUrl('base', array('op'=>'display')), 'success');

            }

        }



        //关于我们

        if ($op == 'about'){



            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

            //var_dump($item);

            if (checksubmit('submit')) {

                $data = array(

                    'uniacid' => $_W['uniacid'],

                    'header' => intval($_GPC['header']),

                    'tel_box' => intval($_GPC['tel_box']),

                    'serv_box' => intval($_GPC['serv_box']),

                    'content' => htmlspecialchars_decode($_GPC['content'], ENT_QUOTES),

                );

                if(empty($item)){

                    pdo_insert('sudu8_page_about', $data);

                }

                else{

                    pdo_update('sudu8_page_about', $data ,array('uniacid' => $uniacid));

                }

                //var_dump($data);

                message('公司介绍信息更新成功!', $this->createWebUrl('base', array('op'=>'about')), 'success');

            }

        }

        //幻灯片列表

        if ($op == 'banner'){

            $list = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type ='banner' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));

        }

        //开屏广告列表

        if ($op == 'bigad'){

            $list = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type ='bigad' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));

        }

        //弹窗广告列表

        if ($op == 'miniad'){

            $list = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type ='miniad' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));

        }

        //首页广告列表

        if ($op == 'indexad'){

            $list = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type ='indexad' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));

        }

        if ($op == 'post'){

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

                message('图片添加成功!', $this->createWebUrl('base', array('op'=>$_GPC['type'])), 'success');

            }

        }

        //删除

        if ($op == 'delete') {

            $id = intval($_GPC['id']);

            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));

            if (empty($row)) {

                message('项目不存在或是已经被删除！');

            }

            pdo_delete('sudu8_page_banner', array('id' => $id ,'uniacid' => $uniacid));

            message('删除成功!', $this->createWebUrl('base', array('op'=>$_GPC['type'])), 'success');



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

        include $this->template('base');