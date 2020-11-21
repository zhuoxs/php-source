<?php
//base
        //tabbar
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $_W['page']['title'] = '菜单栏管理';
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_base') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
            $item['tabbar'] = unserialize($item['tabbar']);
            $item['tabbar'][0] = unserialize($item['tabbar'][0]);
            $item['tabbar'][1] = unserialize($item['tabbar'][1]);
            $item['tabbar'][2] = unserialize($item['tabbar'][2]);
            $item['tabbar'][3] = unserialize($item['tabbar'][3]);
            $item['tabbar'][4] = unserialize($item['tabbar'][4]);
            $item1 = $item['tabbar'][0];
            $item2 = $item['tabbar'][1];
            $item3 = $item['tabbar'][2];
            $item4 = $item['tabbar'][3];
            $item5 = $item['tabbar'][4];
            $catelist = pdo_fetchAll("SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and statue != 0", array(':uniacid' => $uniacid));
            //var_dump($catelist);
            //var_dump($item);
            if (checksubmit('submit')) {
                //先这样写 以后优化
                $tabbar1_p1 = stristr($_GPC['tabbar1_p1'], 'http');
                if(empty($tabbar1_p1)){
                    $_GPC['tabbar1_p1'] = $_W['attachurl'].$_GPC['tabbar1_p1'];
                }
                $tabbar1_p2 = stristr($_GPC['tabbar1_p2'], 'http');
                if(empty($tabbar1_p2)){
                    $_GPC['tabbar1_p2'] = $_W['attachurl'].$_GPC['tabbar1_p2'];
                }
                $tabbar2_p1 = stristr($_GPC['tabbar2_p1'], 'http');
                if(empty($tabbar2_p1)){
                    $_GPC['tabbar2_p1'] = $_W['attachurl'].$_GPC['tabbar2_p1'];
                }
                $tabbar2_p2 = stristr($_GPC['tabbar2_p2'], 'http');
                if(empty($tabbar2_p2)){
                    $_GPC['tabbar2_p2'] = $_W['attachurl'].$_GPC['tabbar2_p2'];
                }
                $tabbar3_p1 = stristr($_GPC['tabbar3_p1'], 'http');
                if(empty($tabbar3_p1)){
                    $_GPC['tabbar3_p1'] = $_W['attachurl'].$_GPC['tabbar3_p1'];
                }
                $tabbar3_p2 = stristr($_GPC['tabbar3_p2'], 'http');
                if(empty($tabbar3_p2)){
                    $_GPC['tabbar3_p2'] = $_W['attachurl'].$_GPC['tabbar3_p2'];
                }
                $tabbar4_p1 = stristr($_GPC['tabbar4_p1'], 'http');
                if(empty($tabbar4_p1)){
                    $_GPC['tabbar4_p1'] = $_W['attachurl'].$_GPC['tabbar4_p1'];
                }
                $tabbar4_p2 = stristr($_GPC['tabbar4_p2'], 'http');
                if(empty($tabbar4_p2)){
                    $_GPC['tabbar4_p2'] = $_W['attachurl'].$_GPC['tabbar4_p2'];
                }
                $tabbar5_p1 = stristr($_GPC['tabbar5_p1'], 'http');
                if(empty($tabbar5_p1)){
                    $_GPC['tabbar5_p1'] = $_W['attachurl'].$_GPC['tabbar5_p1'];
                }
                $tabbar5_p2 = stristr($_GPC['tabbar5_p2'], 'http');
                if(empty($tabbar5_p2)){
                    $_GPC['tabbar5_p2'] = $_W['attachurl'].$_GPC['tabbar5_p2'];
                }
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
                    'uniacid' => $uniacid,
                    'tabbar_t' => $_GPC['tabbar_t'],
                    'tabbar_bg' => $_GPC['tabbar_bg'],
                    'color_bar' => $_GPC['color_bar'],
                    'tabbar_tc' => $_GPC['tabbar_tc'],
                    'tabbar_tca'=>$_GPC['tabbar_tca'],
                    'tabbar_time'=>$_GPC['tabbar_time'],
                    'tabnum' => intval($tabnum),
                    'tabbar' => $tabbar,
                );
                
                if (empty($item['uniacid'])) {
                    message('请先填写基础信息!', $this->createWebUrl('base', array('op'=>'display')), 'error');
                } else {
                    pdo_update('sudu8_page_base', $data ,array('uniacid' => $uniacid));
                }
                
                message('菜单栏更新成功!', $this->createWebUrl('tabbar', array('op'=>'display')), 'success');
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
        include $this->template('tabbar');