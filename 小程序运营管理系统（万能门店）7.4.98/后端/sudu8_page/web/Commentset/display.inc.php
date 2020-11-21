<?php
    load()->func('tpl');
    global $_GPC, $_W;
    $opt = $_GPC['opt'];
    $ops = array('index', 'post','delete');
    $opt = in_array($opt, $ops) ? $opt : 'index';
    $uniacid = $_W['uniacid'];

    //栏目列表
    if ($opt == 'index'){
        $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and cid = :cid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':cid' => 0));
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;  
        $start = ($pageindex-1) * $pagesize;
        $pager = pagination($total, $pageindex, $pagesize);

        $listV = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and cid = :cid ORDER BY num DESC,id DESC LIMIT ".$start.",".$pagesize, array(':uniacid' => $uniacid,':cid' => 0));
        $listAll = array();
        foreach($listV as $key=>$val) {
            $id = intval($val['id']);
            $listP = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and id = :id ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $id));
            //var_dump($listP);
            $listS = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and cid = :id ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $id));
            $listP['data'] = $listS;
            array_push($listAll,$listP);
        }
    }
    //添加栏目
    if ($opt == 'post'){
        $id = intval($_GPC['id']);
        $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_cate') ." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if($item){
                $item['cateslide'] = unserialize($item['cateslide']);
            }
        $cate_list = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate') ." WHERE cid = :cid and uniacid = :uniacid ", array(':cid' => 0 ,':uniacid' => $uniacid));
        $cateConf = unserialize($item['cateconf']);
        $item['pmarb'] = $cateConf['pmarb'];
        $item['ptit'] = $cateConf['ptit'];
        if (checksubmit('submit')) {
            if (empty($_GPC['name'])) {
                message('请输入栏目标题！');
            }
            $list_style = intval($_GPC['list_style']);
            if($_GPC['type'] == 'page'){
                if($_GPC['list_type'] == 1){
                    $list_style = 3;
                }
            }
            $pmarb = $_GPC['pmarb'];
            $ptit = $_GPC['ptit'];
            if(is_null($pmarb)){
                $pmarb = 10;
            }
            if(is_null($ptit)){
                $ptit = 1;
            }
                $slide_is = $_GPC['slide_is'];
                if(is_null($slide_is)){
                    $slide_is = 2;
                }
            $cateConf = array(
                'pmarb' => $pmarb,
                'ptit' => $ptit,
            );
            $cateConf = serialize($cateConf);

            $data = array(
                'uniacid' => $_W['uniacid'],
                'cid' => intval($_GPC['cid']),
                'name' => $_GPC['name'],
                'name_n' => $_GPC['name_n'],
                'ename' => $_GPC['ename'],
                'cdesc' => $_GPC['cdesc'],
                'catepic'=>$_GPC['catepic'],
                'type' => $_GPC['type'],
                'show_i' => intval($_GPC['show_i']),
                'statue' => intval($_GPC['statue']),
                'num' => intval($_GPC['num']),
                'list_type' => intval($_GPC['list_type']),
                'list_style' => $list_style,
                'list_tstyle' => intval($_GPC['list_tstyle']),
                'list_tstylel' => intval($_GPC['list_tstylel']),
                'list_stylet' => $_GPC['list_stylet'],
                'pic_page_btn' => intval($_GPC['pic_page_btn']),
                'pic_page_bg' => intval($_GPC['pic_page_bg']),
                'list_style_more'=>$_GPC['list_style_more'],
                'content' => $_GPC['content'],
                'pagenum' => $_GPC['pagenum']?$_GPC['pagenum']:10,
                'cateconf' => $cateConf,
                'slide_is' => $slide_is,
                'cateslide' => serialize($_GPC['cateslide'])
            );
            if (empty($id)) {
                pdo_insert('sudu8_page_cate', $data);
            } else {
                pdo_update('sudu8_page_cate', $data, array('id' => $id ,'uniacid' => $uniacid));
            }
            message('栏目 添加/修改 成功!', $this->createWebUrl('Commentset', array('op'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }
    }
    //删除栏目
    if ($opt == 'delete') {

        $id = intval($_GPC['id']);
 

        $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
        if (empty($row)) {
            message('栏目不存在或是已经被删除！');
        }
        $row2 = pdo_fetch("SELECT id FROM ".tablename('sudu8_page_cate')." WHERE cid = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
        if($row2 != ""){
            message('请先删除二级栏目!', $this->createWebUrl('cate', array('op'=>'display')), 'error');
        }
        $row3 = pdo_fetch("SELECT id FROM ".tablename('sudu8_page_products')." WHERE cid = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
        if($row3 != ""){
            message('该栏目存在内容，无法删除!', $this->createWebUrl('cate', array('op'=>'display')), 'error');
        }
        pdo_delete('sudu8_page_cate', array('id' => $id ,'uniacid' => $uniacid));
        message('栏目删除成功!', $this->createWebUrl('Commentset', array('op'=>'display','opt'=>'index','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    }
    
return include self::template('web/Commentset/display');
