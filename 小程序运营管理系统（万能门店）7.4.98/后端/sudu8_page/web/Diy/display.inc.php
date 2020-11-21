<?php 
        load()->func('tpl');
        //这个操作被定义用来呈现 管理中心导航菜单
        global $_GPC, $_W;
        $opt = $_GPC['opt'];
        $ops = array('display', 'post');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        $uniacid = $_W['uniacid'];
        if ($opt == 'display'){
            $_W['page']['title'] = 'diy设置';
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_base') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
            if (checksubmit('submit')) {
                $data = array(
                    'uniacid' => $uniacid,
                    'base_color' => $_GPC['base_color'],
                    'base_tcolor' => $_GPC['base_tcolor'],
                    'base_color2' => $_GPC['base_color2'],
                    'base_color_t' => $_GPC['base_color_t'],
                    'tabbar_bg1' => $_GPC['tabbar_bg1'],
                    'tabbar_bg2' => $_GPC['tabbar_bg2'],
                    'tabbar_bg3' => $_GPC['tabbar_bg3'],
					'homepage' => $_GPC['homepage']==0?1:$_GPC['homepage']
                );
                if (empty($item['uniacid'])) {
                    $a2=array('name'=>'小程序名称');
                    $data = array_merge($data,$a2);
                    pdo_insert('sudu8_page_base', $data);
                } else {
                    pdo_update('sudu8_page_base', $data ,array('uniacid' => $uniacid));
                }
                if(!$item['tabbar_new'] && !$item['tabbar_bg']){
                    $fooferdata1 = array(
                        "tabbar_bg" => '#ffffff',
                        "color_bar" => '#cccccc',
                        "tabbar_tc" => '#222222',
                        "tabbar_tca" => '#336fe8',
                        "tabnum_new" => '2'
                    );
                    $fooferdata2 = array('tabbar_new'=>'a:2:{i:0;s:185:"a:5:{s:11:"tabbar_name";s:6:"首页";s:10:"tabbar_url";s:23:"/sudu8_page/index/index";s:15:"tabbar_linktype";s:4:"page";s:6:"tabbar";s:1:"2";s:13:"tabimginput_1";s:14:"icon-x-shouye6";}";i:1;s:201:"a:5:{s:11:"tabbar_name";s:12:"个人中心";s:10:"tabbar_url";s:33:"/sudu8_page/usercenter/usercenter";s:15:"tabbar_linktype";s:4:"page";s:6:"tabbar";s:1:"2";s:13:"tabimginput_1";s:13:"icon-x-geren2";}";}');
                    $footercon = array_merge($fooferdata1,$fooferdata2);
                    pdo_update('sudu8_page_base',$footercon,array('uniacid' => $uniacid));
                }
                message('DIY设置更新成功', $this->createWebUrl('diy', array('op'=>'display','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
            }
        }

return include self::template('web/Diy/display');
