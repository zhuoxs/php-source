<?php 
        load()->func('tpl');
        //这个操作被定义用来呈现 管理中心导航菜单
        global $_GPC, $_W;
        $opt = $_GPC['opt'];
        $ops = array('display', 'post');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        $uniacid = $_W['uniacid'];

        if ($opt == 'display'){
            $_W['page']['title'] = '样式DIY';
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_base') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
            $config = unserialize($item['config']);
            $item['newhead'] = $config['newhead'];
            $item['search'] = $config['search'];
            $item['bigadT'] = $config['bigadT'];
            $item['bigadC'] = $config['bigadC'];
            $item['bigadCTC'] = $config['bigadCTC'];
            $item['bigadCNN'] = $config['bigadCNN'];
            $item['miniadT'] = $config['miniadT'];
            $item['miniadC'] = $config['miniadC'];
            $item['miniadN'] = $config['miniadN'];
            $item['miniadB'] = $config['miniadB'];
            $item['copT'] = $config['copT'];
            $item['userFood'] = $config['userFood'];
            $item['duomerchants'] = $config['duomerchants'];
            // $item['commA'] = $config['commA'];
            // $item['commAs'] = $config['commAs'];
            // $item['commP'] = $config['commP'];
            // $item['commPs'] = $config['commPs'];
            if (checksubmit('submit')) {
                //搜索
                if(is_null($_GPC['newhead'])){
                    $_GPC['newhead'] = 0;
                }
                //搜索
                if(is_null($_GPC['search'])){
                    $_GPC['search'] = 1;
                }
                //默认广告
                if(is_null($_GPC['bigadT'])){
                    $_GPC['bigadT'] = 0;
                }
                if(is_null($_GPC['miniadT'])){
                    $_GPC['miniadT'] = 0;
                }
                //餐饮
                if(is_null($_GPC['userFood'])){
                    $_GPC['userFood'] = 0;
                }
                //评论
                // if(is_null($_GPC['commA'])){
                //     $_GPC['commA'] = 0;
                // }
                // if(is_null($_GPC['commAs'])){
                //     $_GPC['commAs'] = 1;
                // }
                // if(is_null($_GPC['commP'])){
                //     $_GPC['commP'] = 0;
                // }
                // if(is_null($_GPC['commPs'])){
                //     $_GPC['commPs'] = 1;
                // }
                // if(is_null($_GPC['shop_num'])){
                //     $_GPC['shop_num'] = 6;
                // }
                    $config['newhead'] = $_GPC['newhead'];
                    $config['search'] = $_GPC['search'];
                    $config['bigadT'] = $_GPC['bigadT'];
                    $config['bigadC'] = $_GPC['bigadC'];
                    $config['bigadCTC'] = $_GPC['bigadCTC'];
                    $config['bigadCNN'] = $_GPC['bigadCNN'];
                    $config['miniadT'] = $_GPC['miniadT'];
                    $config['miniadC'] = $_GPC['miniadC'];
                    $config['miniadN'] = $_GPC['miniadN'];
                    $config['miniadB'] = $_GPC['miniadB'];
                    $config['copT'] = $_GPC['copT'];
                    $config['userFood'] = $_GPC['userFood'];
                    $config['duomerchants'] = $_GPC['duomerchants'];
                    // 'search' => $_GPC['search'],
                    // 'bigadT' => $_GPC['bigadT'],
                    // 'bigadC' => $_GPC['bigadC'],
                    // 'bigadCTC' => $_GPC['bigadCTC'],
                    // 'bigadCNN' => $_GPC['bigadCNN'],
                    // 'miniadT' => $_GPC['miniadT'],
                    // 'miniadC' => $_GPC['miniadC'],
                    // 'miniadN' => $_GPC['miniadN'],
                    // 'miniadB' => $_GPC['miniadB'],
                    // 'copT' => $_GPC['copT'],
                    // 'userFood' => $_GPC['userFood'],
                    // 'commA' => $_GPC['commA'],
                    // 'commAs' => $_GPC['commAs'],
                    // 'commP' => $_GPC['commP'],
                    // 'commPs' => $_GPC['commPs'],
                // );
                $config = serialize($config);
                $data = array(
                    'index_style' => $_GPC['index_style'],
                    'about_style' => $_GPC['about_style'],
                    'prolist_style' => $_GPC['prolist_style'],
                    'footer_style' => $_GPC['footer_style'],
                    'index_about_title' => $_GPC['index_about_title'],
                    'index_pro_btn' => $_GPC['index_pro_btn'],
                    'index_pro_lstyle' => $_GPC['index_pro_lstyle'],
                    'index_pro_tstyle' => $_GPC['index_pro_tstyle'],
                    'index_pro_ts_al' => $_GPC['index_pro_ts_al'],
                    'c_title' => $_GPC['c_title'],
                    'i_b_x_ts' => $_GPC['i_b_x_ts'],
                    'i_b_y_ts' => $_GPC['i_b_y_ts'],
                    'tel_box' => $_GPC['tel_box'],
                    'aboutCN' => $_GPC['aboutCN'],
                    'aboutCNen' => $_GPC['aboutCNen'],
                    'catename' => $_GPC['catename'],
                    'catenameen' => $_GPC['catenameen'],
                    'catename_x' => $_GPC['catename_x'],
                    'catenameen_x' => $_GPC['catenameen_x'],
                    'c_b_bg' => $_GPC['c_b_bg'],
                    'c_b_btn' => intval($_GPC['c_b_btn']),
                    'i_b_x_iw' => intval($_GPC['i_b_x_iw']),
                    'form_index' => intval($_GPC['form_index']),
                    'config' => $config,

                    'sptj_max' => $_GPC['sptj_max'],
                    'sptj_max_sp' => $_GPC['sptj_max_sp'],

                    'spcatename' => $_GPC['spcatename'],
                    'spcatenameen' => $_GPC['spcatenameen'],
                    'sp_i_b_y_ts' => $_GPC['sp_i_b_y_ts'],

                    // 'shop_num' => $_GPC['shop_num'],
                    'bookname' => $_GPC['bookname'],
                    'bookurl' => trim($_GPC['bookurl']),
                    'about' => $_GPC['about'],
                    'gonggao' => $_GPC['gonggao'],
                    'gonggaoUrl' => trim($_GPC['gonggaoUrl']),
                );
                foreach ($data as $k => $v){
                    if(is_null($v)){
                        $data[$k] = '';
                    }
                }
                if (empty($item['uniacid'])) {
                    message('请先填写基础信息', $this->createWebUrl('diy', array('op'=>'homeset','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
                } else {
                    // $sql = "SELECT * FROM `ims_sudu8_page_base` WHERE `uniacid` = {$uniacid}";
                    // $ddata = pdo_fetch($sql);
                    // foreach ($ddata as $k => $v){
                    //     if(isset($data[$k]) && $data[$k] != $v){
                    //         $ddata[$k] = $data[$k];
                    //     }
                    // }
                    // unset($ddata['uniacid']);
                    $result=pdo_update('sudu8_page_base', $data ,array('uniacid' => $uniacid));
                }
                message('DIY样式更新成功', $this->createWebUrl('diy', array('op'=>'homeset','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
            }
        }

return include self::template('web/Diy/homeset');
