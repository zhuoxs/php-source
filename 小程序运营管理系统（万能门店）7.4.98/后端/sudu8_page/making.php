<?php
    class Making {  
        protected $uniacid; 
        protected $making_tmp; 
        public function making_do($uniacid,$making_tmp){
            $_W['page']['title'] = '一键制作模板';
            $item = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_base') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
            //清除信息
            // $delcate = pdo_fetch("DELETE FROM `ims_sudu8_page_base` WHERE `uniacid` =  :uniacid", array(':uniacid' => $uniacid));
            // $delcate = pdo_fetch("DELETE FROM `ims_sudu8_page_cate` WHERE `uniacid` =  :uniacid", array(':uniacid' => $uniacid));
            // $delpro = pdo_fetch("DELETE FROM `ims_sudu8_page_products` WHERE `uniacid` =  :uniacid", array(':uniacid' => $uniacid));
            // $delnavlist = pdo_fetch("DELETE FROM `ims_sudu8_page_navlist` WHERE `uniacid` =  :uniacid", array(':uniacid' => $uniacid));
            // $delbanner = pdo_fetch("DELETE FROM `ims_sudu8_page_banner` WHERE `uniacid` =  :uniacid", array(':uniacid' => $uniacid));
                if($making_tmp == 0){
                //建立顶级图片栏目
                $cateTopPic = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid=0 ", array(':uniacid' => $uniacid));
                $dataCateTopPic = array(
                'uniacid' => $uniacid,
                'num' => 9,
                'type' => 'showPic',
                'statue' => 1,
                'cid' => 0,
                'name' => '客照欣赏',
                'ename' => 'Photo Cases',
                'name_n' => '客照欣赏',
                'show_i' => 1,
                'list_tstyle' => 2,
                'list_tstylel' => 0,
                'list_type' => 1,
                'list_style' => 2,
                'list_stylet' => 'tcb',
                'pic_page_btn'=>0,
                );
                if (empty($cateTopPic['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPic);
                } else {
                    pdo_update('sudu8_page_cate', $dataCateTopPic ,array('uniacid' => $uniacid,'id'=>$cateTopPic['id']));
                }
                $dataCateTopPic = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopPicId = $dataCateTopPic['id'];
                $catePicSon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type='showPic' and cid = :cid ", array(':uniacid' => $uniacid,':cid' => $cateTopPic['id']));
                $catePicSonNum = count($catePicSon);
                //建立子级图片栏目
                if($catePicSonNum == 0){
                    $dataCatePicS1 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showPic',
                        'statue' => 1,
                        'cid' => $dataCateTopPicId,
                        'name' => '婚纱摄影',
                        'ename' => 'Wedding photography',
                        'name_n' => '婚纱摄影',
                        'show_i' => 1,
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/nav1.png',
                        'list_tstyle' => 2,
                        'list_tstylel' => 0,
                        'list_type' => 1,
                        'list_style' => 2,
                        'list_stylet' => 'tcb',
                        'pic_page_btn'=>0,
                    );
                    $dataCatePicS2 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showPic',
                        'statue' => 1,
                        'cid' => $dataCateTopPicId,
                        'name' => '全球旅拍',
                        'ename' => 'Global tour',
                        'name_n' => '全球旅拍',
                        'show_i' => 1,
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/nav2.png',
                        'list_tstyle' => 2,
                        'list_tstylel' => 0,
                        'list_type' => 1,
                        'list_style' => 2,
                        'list_stylet' => 'tcb',
                        'pic_page_btn'=>0,
                    );
                    $dataCatePicS3 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showPic',
                        'statue' => 1,
                        'cid' => $dataCateTopPicId,
                        'name' => '个人写真',
                        'ename' => 'Personal photo',
                        'name_n' => '个人写真',
                        'show_i' => 1,
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/nav3.png',
                        'list_tstyle' => 2,
                        'list_tstylel' => 0,
                        'list_type' => 1,
                        'list_style' => 2,
                        'list_stylet' => 'tcb',
                        'pic_page_btn'=>0,
                    );
                    $dataCatePicS4 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showPic',
                        'statue' => 1,
                        'cid' => $dataCateTopPicId,
                        'name' => '情侣闺蜜',
                        'ename' => 'Lovers & girlfriends',
                        'name_n' => '情侣闺蜜',
                        'show_i' => 1,
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/nav4.png',
                        'list_tstyle' => 2,
                        'list_tstylel' => 0,
                        'list_type' => 1,
                        'list_style' => 2,
                        'list_stylet' => 'tcb',
                        'pic_page_btn'=>0,
                    );
                    pdo_insert('sudu8_page_cate', $dataCatePicS1);
                    pdo_insert('sudu8_page_cate', $dataCatePicS2);
                    pdo_insert('sudu8_page_cate', $dataCatePicS3);
                    pdo_insert('sudu8_page_cate', $dataCatePicS4);
                    $dataCatePicSAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid!=0", array(':uniacid' => $uniacid));
                    $dataCatePicS1Id = $dataCatePicSAll[0]['id'];
                    $dataCatePicS2Id = $dataCatePicSAll[1]['id'];
                    $dataCatePicS3Id = $dataCatePicSAll[2]['id'];
                    $dataCatePicS4Id = $dataCatePicSAll[3]['id'];
                }else{
                    $dataCatePicSAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid!=0", array(':uniacid' => $uniacid));
                    $dataCatePicS1Id = $dataCatePicSAll[0]['id'];
                    $dataCatePicS2Id = $dataCatePicSAll[1]['id'];
                    $dataCatePicS3Id = $dataCatePicSAll[2]['id'];
                    $dataCatePicS4Id = $dataCatePicSAll[3]['id'];
                }
                //建立导航
                $dataNavCon = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_nav') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                $dataNav = array(
                    'url'=>$dataCatePicS1Id.",".$dataCatePicS2Id.",".$dataCatePicS3Id.",".$dataCatePicS4Id,
                    'uniacid' => $uniacid,
                    'statue'=>1,
                    'name_s'=>1,
                    'box_p_tb'=>3,
                    'box_p_lr'=>1,
                    'number'=>4,
                    'img_size'=>60,
                    'title_position'=>1,
                    'title_color'=>'#222',
                );
                if (empty($dataNavCon['uniacid'])) {
                    pdo_insert('sudu8_page_nav', $dataNav);
                } else {
                    pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                }
                //建立顶级文章栏目
                $cateTopArt = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArt = array(
                'uniacid' => $uniacid,
                'num' => 8,
                'type' => 'showArt',
                'statue' => 1,
                'cid' => 0,
                'name' => '优惠活动',
                'ename' => 'Activities',
                'name_n' => '优惠活动',
                'show_i' => 1,
                'list_tstyle' => 2,
                'list_tstylel' => 0,
                'list_type' => 1,
                'list_style' => 1,
                'list_stylet' => 'tlb',
                );
                if (empty($cateTopArt['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopArt);
                } else {
                    pdo_update('sudu8_page_cate', $dataCateTopArt ,array('uniacid' => $uniacid,'id'=>$cateTopArt['id']));
                }
                $dataCateTopArt = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArtId = $dataCateTopArt['id'];
                //建立顶级商品栏目
                $cateTopPro = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopPro = array(
                'uniacid' => $uniacid,
                'num' => 5,
                'type' => 'showPro',
                'statue' => 1,
                'cid' => 0,
                'name' => '服务展示',
                'ename' => 'Service display',
                'name_n' => '服务展示',
                'show_i' => 1,
                'list_tstyle' => 2,
                'list_tstylel' => 0,
                'list_type' => 1,
                'list_style' => 12,
                'list_stylet' => 'none',
                );
                if (empty($cateTopPro['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPro);
                } else {
                    pdo_update('sudu8_page_cate', $dataCateTopPro ,array('uniacid' => $uniacid,'id'=>$cateTopPro['id']));
                }
                $dataCateTopPro = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopProId = $dataCateTopPro['id']; //顶级商品栏目的ID
                //添加组图
                $catePicCon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPic' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $cateTopPic['id']));
                $catePicConNum = count($catePicCon);
                if($catePicConNum == 0){
                    $dataPicCon1 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCatePicS1Id,
                        'pcid'=> $cateTopPic['id'],
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '婚纱摄影欣赏',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/case3.jpg',
                        'text'=> 'a:4:{i:0;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con1.jpg";i:1;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con2.jpg";i:2;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con3.jpg";i:3;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con4.jpg";}',
                    );
                    $dataPicCon2 = array(
                        'uniacid' => $uniacid,
                        'cid'=>$dataCatePicS1Id,
                        'pcid'=> $cateTopPic['id'],
                        'type_x'=>1,
                        'type'=> 'showPic',
                        'type_i'=>1,
                        'title'=>'海南岛之旅',
                        'thumb'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/case4.jpg',
                        'text'=>'a:4:{i:0;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con1.jpg";i:1;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con2.jpg";i:2;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con3.jpg";i:3;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con4.jpg";}',
                    );
                    $dataPicCon3 = array(
                        'uniacid' => $uniacid,
                        'cid'=>$dataCatePicS1Id,
                        'pcid'=> $cateTopPic['id'],
                        'type_x'=>1,
                        'type'=> 'showPic',
                        'type_i'=>1,
                        'title'=>'梦幻仙境',
                        'thumb'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/case8.jpg',
                        'text'=>'a:4:{i:0;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con1.jpg";i:1;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con2.jpg";i:2;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con3.jpg";i:3;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con4.jpg";}',
                    );
                    $dataPicCon4 = array(
                        'uniacid' => $uniacid,
                        'cid'=>$dataCatePicS1Id,
                        'pcid'=> $cateTopPic['id'],
                        'type_x'=>1,
                        'type'=> 'showPic',
                        'type_i'=>1,
                        'title'=>'夕阳的艳丽',
                        'thumb'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/case7.jpg',
                        'text'=>'a:4:{i:0;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con1.jpg";i:1;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con2.jpg";i:2;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con3.jpg";i:3;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con4.jpg";}',
                    );
                    pdo_insert('sudu8_page_products', $dataPicCon1);
                    pdo_insert('sudu8_page_products', $dataPicCon2);
                    pdo_insert('sudu8_page_products', $dataPicCon3);
                    pdo_insert('sudu8_page_products', $dataPicCon4);
                }
                //添加文章
                $cateArtCon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showArt' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopArtId));
                $cateArtConNum = count($cateArtCon);
                if($cateArtConNum == 0){
                    $dataArtCon1 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId,
                        'pcid'=> $dataCateTopArtId,
                        'type'=> 'showArt',
                        'type_i'=> 1,
                        'title'=> '为爱再造一座城',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/a1.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon2 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId,
                        'pcid'=> $dataCateTopArtId,
                        'type'=> 'showArt',
                        'type_i'=> 1,
                        'title'=> '恰好遇见你',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/a2.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon3 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId,
                        'pcid'=> $dataCateTopArtId,
                        'type'=> 'showArt',
                        'type_i'=> 0,
                        'title'=> '月夜香奈儿活动',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/a3.jpg',
                        'text'=> '这里是文章内容',
                    );
                    pdo_insert('sudu8_page_products', $dataArtCon1);
                    pdo_insert('sudu8_page_products', $dataArtCon2);
                    pdo_insert('sudu8_page_products', $dataArtCon3);
                }
                //添加商品
                $cateProCon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopProId));
                $cateProConNum = count($cateProCon);
                if($cateProConNum == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopProId,
                        'pcid'=> $dataCateTopProId,
                        'type'=> 'showPro',
                        'type_i'=> 1,
                        'labels'=>'',
                        'title'=> '情侣写真',
                        'price'=>199,
                        'market_price'=>999,
                        'sale_num'=>18,
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/c6.jpg',
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/hunsha/c6.jpg";}',
                        'product_txt'=>'这里是商品的详细介绍，可放图文',
                    );
                    $dataProCon2 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopProId,
                        'pcid'=> $dataCateTopProId,
                        'type'=> 'showPro',
                        'type_i'=> 1,
                        'labels'=>'',
                        'title'=> '婚纱套系',
                        'price'=>2999,
                        'market_price'=>5999,
                        'sale_num'=>22,
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/c1.jpg',
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/hunsha/c1.jpg";}',
                        'product_txt'=>'这里是商品的详细介绍，可放图文',
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                    pdo_insert('sudu8_page_products', $dataProCon2);
                }
                $dataAbout = array(
                    'uniacid' => $uniacid,
                    'header'=>1,
                    'tel_box'=>1,
                    'serv_box'=>1,
                    'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',
                );
                $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($about['uniacid'])) {
                    pdo_insert('sudu8_page_about', $dataAbout);
                } else {
                    pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
                }
                $dataForms = array(
                    'uniacid' => $uniacid,
                    'forms_style'=> 2,
                    'forms_inps'=> 0,
                    'forms_head'=> 'none',
                    'forms_name'=> '自助预约',
                    'forms_ename'=> 'Self Booking',
                    'forms_title_s'=> 'title1',
                    'subtime'=> 0,
                    'forms_btn'=> '立即预约',
                    'success'=> '您已预约成功！',
                    'name'=> '姓名',
                    'name_must'=> 1,
                    'tel'=> '电话',
                    'tel_use'=> 1,
                    'tel_must'=> 1,
                    'date'=> '预约时间',
                    'date_use'=> 1,
                    'checkbox_n'=> '拍摄类型',
                    'checkbox_num'=> 2,
                    'checkbox_use'=> 1,
                    'checkbox_v'=> '婚纱摄影,亲子儿童,个人写真,情侣闺蜜',
                    'content_n'=> '备注',
                    'content_use'=> 1,
                    'wechat_use'=> 0,
                    'address_use'=> 0,
                    'date_must'=> 0,
                    'single_use'=> 0,
                    'checkbox_must'=> 0,
                    'content_must'=> 0,
                );
                $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($froms['uniacid'])) {
                    pdo_insert('sudu8_page_forms_config', $dataForms);
                } else {
                    pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                }
                    //建立基础信息
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:3:{i:0;s:50:"http://p2bwp6sww.bkt.clouddn.com/hunsha/slide1.jpg";i:1;s:50:"http://p2bwp6sww.bkt.clouddn.com/hunsha/slide2.jpg";i:2;s:50:"http://p2bwp6sww.bkt.clouddn.com/hunsha/slide3.jpg";}',
                        'name' => '通用门店模版',
                        'desc'=>'捷安特GCW、禧玛诺高级维修中心',
                        'about' => '捷安特，全称台湾巨大机械工业股份有限公司，是全球自行车生产及行销最具规模的公司之一，其网络横跨五大洲，五十余个国家，公司遍布中国大陆、美国、英国、德国、法国、日本、加拿大、荷兰等地，掌握着超过1万个销售通路。',
                        'address' => '北京市东城区三环路888号',
                        'time' => '9:00 - 18:00',
                        'tel' => '18669868123',
                        'longitude' => '116.321697',
                        'latitude' => '39.894197',
                        'aboutCN' => '公司介绍',
                        'aboutCNen' => 'About Company',
                        'index_about_title' => 'title1',
                        'banner'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/bg.jpg',
                        'logo'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/logo.jpg',
                        'base_color'=> '#389bde',
                        'base_tcolor'=> '#ffffff',
                        'base_color2'=> '#ffcf3d',
                        'base_color_t'=> '#ffcf3d',
                        'index_style'=> 'header',
                        'tel_box'=> '1',
                        'index_about_title'=> 'title2',
                        'catename_x'=> '最新客照',
                        'catenameen_x'=> 'New Photos',
                        'i_b_x_ts'=>'9',
                        'i_b_x_iw'=> '560',
                        'i_b_y_ts'=> '9',
                        'c_b_bg'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/bg_s.jpg',
                        'c_b_btn'=> '0',
                        'form_index'=> '0',
                        'c_title'=> '1',
                        'tabbar'=>'a:4:{i:0;s:211:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar1.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar1.png";}";i:1;s:218:"a:4:{s:8:"tabbar_l";s:5:"about";s:8:"tabbar_t";s:12:"关于我们";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar2.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar2.png";}";i:2;s:216:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:12:"联系商家";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar3.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar3.png";}";i:3;s:224:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"一键导航";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar4.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar4.png";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
                    $dataNav = array(
                        'uniacid' => $uniacid,
                        'statue'=>0,
                    );
                    pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                }elseif ($making_tmp == 1){
                    //建立顶级图片栏目
                $cateTopPic = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid=0 ", array(':uniacid' => $uniacid));
                $dataCateTopPic = array(
                'uniacid' => $uniacid,
                'num' => 9,
                'type' => 'showPic',
                'statue' => 1,
                'cid' => 0,
                'name' => '客照欣赏',
                'ename' => 'Photo Cases',
                'name_n' => '客照欣赏',
                'show_i' => 1,
                'list_tstyle' => 2,
                'list_tstylel' => 0,
                'list_type' => 1,
                'list_style' => 2,
                'list_stylet' => 'tcb',
                'pic_page_btn'=>0,
                );
                if (empty($cateTopPic['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPic);
                } else {
                    pdo_update('sudu8_page_cate', $dataCateTopPic ,array('uniacid' => $uniacid,'id'=>$cateTopPic['id']));
                }
                $dataCateTopPic = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopPicId = $dataCateTopPic['id'];
                $catePicSon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type='showPic' and cid = :cid ", array(':uniacid' => $uniacid,':cid' => $cateTopPic['id']));
                $catePicSonNum = count($catePicSon);
                //建立子级图片栏目
                if($catePicSonNum == 0){
                    $dataCatePicS1 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showPic',
                        'statue' => 1,
                        'cid' => $dataCateTopPicId,
                        'name' => '婚纱摄影',
                        'ename' => 'Wedding photography',
                        'name_n' => '婚纱摄影',
                        'show_i' => 1,
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/nav1.png',
                        'list_tstyle' => 2,
                        'list_tstylel' => 0,
                        'list_type' => 1,
                        'list_style' => 2,
                        'list_stylet' => 'tcb',
                        'pic_page_btn'=>0,
                    );
                    $dataCatePicS2 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showPic',
                        'statue' => 1,
                        'cid' => $dataCateTopPicId,
                        'name' => '全球旅拍',
                        'ename' => 'Global tour',
                        'name_n' => '全球旅拍',
                        'show_i' => 1,
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/nav2.png',
                        'list_tstyle' => 2,
                        'list_tstylel' => 0,
                        'list_type' => 1,
                        'list_style' => 2,
                        'list_stylet' => 'tcb',
                        'pic_page_btn'=>0,
                    );
                    $dataCatePicS3 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showPic',
                        'statue' => 1,
                        'cid' => $dataCateTopPicId,
                        'name' => '个人写真',
                        'ename' => 'Personal photo',
                        'name_n' => '个人写真',
                        'show_i' => 1,
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/nav3.png',
                        'list_tstyle' => 2,
                        'list_tstylel' => 0,
                        'list_type' => 1,
                        'list_style' => 2,
                        'list_stylet' => 'tcb',
                        'pic_page_btn'=>0,
                    );
                    $dataCatePicS4 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showPic',
                        'statue' => 1,
                        'cid' => $dataCateTopPicId,
                        'name' => '情侣闺蜜',
                        'ename' => 'Lovers & girlfriends',
                        'name_n' => '情侣闺蜜',
                        'show_i' => 1,
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/nav4.png',
                        'list_tstyle' => 2,
                        'list_tstylel' => 0,
                        'list_type' => 1,
                        'list_style' => 2,
                        'list_stylet' => 'tcb',
                        'pic_page_btn'=>0,
                    );
                    pdo_insert('sudu8_page_cate', $dataCatePicS1);
                    pdo_insert('sudu8_page_cate', $dataCatePicS2);
                    pdo_insert('sudu8_page_cate', $dataCatePicS3);
                    pdo_insert('sudu8_page_cate', $dataCatePicS4);
                    $dataCatePicSAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid!=0", array(':uniacid' => $uniacid));
                    $dataCatePicS1Id = $dataCatePicSAll[0]['id'];
                    $dataCatePicS2Id = $dataCatePicSAll[1]['id'];
                    $dataCatePicS3Id = $dataCatePicSAll[2]['id'];
                    $dataCatePicS4Id = $dataCatePicSAll[3]['id'];
                }else{
                    $dataCatePicSAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid!=0", array(':uniacid' => $uniacid));
                    $dataCatePicS1Id = $dataCatePicSAll[0]['id'];
                    $dataCatePicS2Id = $dataCatePicSAll[1]['id'];
                    $dataCatePicS3Id = $dataCatePicSAll[2]['id'];
                    $dataCatePicS4Id = $dataCatePicSAll[3]['id'];
                }
                //建立导航
                $dataNavCon = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_nav') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                $dataNav = array(
                    'url'=>$dataCatePicS1Id.",".$dataCatePicS2Id.",".$dataCatePicS3Id.",".$dataCatePicS4Id,
                    'uniacid' => $uniacid,
                    'statue'=>1,
                    'name_s'=>1,
                    'box_p_tb'=>3,
                    'box_p_lr'=>1,
                    'number'=>4,
                    'img_size'=>60,
                    'title_position'=>1,
                    'title_color'=>'#222',
                );
                if (empty($dataNavCon['uniacid'])) {
                    pdo_insert('sudu8_page_nav', $dataNav);
                } else {
                    pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                }
                //建立顶级文章栏目
                $cateTopArt = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArt = array(
                'uniacid' => $uniacid,
                'num' => 8,
                'type' => 'showArt',
                'statue' => 1,
                'cid' => 0,
                'name' => '优惠活动',
                'ename' => 'Activities',
                'name_n' => '优惠活动',
                'show_i' => 1,
                'list_tstyle' => 2,
                'list_tstylel' => 0,
                'list_type' => 1,
                'list_style' => 1,
                'list_stylet' => 'tlb',
                );
                if (empty($cateTopArt['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopArt);
                } else {
                    pdo_update('sudu8_page_cate', $dataCateTopArt ,array('uniacid' => $uniacid,'id'=>$cateTopArt['id']));
                }
                $dataCateTopArt = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArtId = $dataCateTopArt['id'];
                //建立顶级商品栏目
                $cateTopPro = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopPro = array(
                'uniacid' => $uniacid,
                'num' => 5,
                'type' => 'showPro',
                'statue' => 1,
                'cid' => 0,
                'name' => '服务展示',
                'ename' => 'Service display',
                'name_n' => '服务展示',
                'show_i' => 1,
                'list_tstyle' => 2,
                'list_tstylel' => 0,
                'list_type' => 1,
                'list_style' => 12,
                'list_stylet' => 'none',
                );
                if (empty($cateTopPro['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPro);
                } else {
                    pdo_update('sudu8_page_cate', $dataCateTopPro ,array('uniacid' => $uniacid,'id'=>$cateTopPro['id']));
                }
                $dataCateTopPro = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopProId = $dataCateTopPro['id']; //顶级商品栏目的ID
                //添加组图
                $catePicCon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPic' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $cateTopPic['id']));
                $catePicConNum = count($catePicCon);
                if($catePicConNum == 0){
                    $dataPicCon1 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCatePicS1Id,
                        'pcid'=> $cateTopPic['id'],
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '婚纱摄影欣赏',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/case3.jpg',
                        'text'=> 'a:4:{i:0;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con1.jpg";i:1;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con2.jpg";i:2;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con3.jpg";i:3;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con4.jpg";}',
                    );
                    $dataPicCon2 = array(
                        'uniacid' => $uniacid,
                        'cid'=>$dataCatePicS1Id,
                        'pcid'=> $cateTopPic['id'],
                        'type_x'=>1,
                        'type'=> 'showPic',
                        'type_i'=>1,
                        'title'=>'海南岛之旅',
                        'thumb'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/case4.jpg',
                        'text'=>'a:4:{i:0;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con1.jpg";i:1;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con2.jpg";i:2;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con3.jpg";i:3;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con4.jpg";}',
                    );
                    $dataPicCon3 = array(
                        'uniacid' => $uniacid,
                        'cid'=>$dataCatePicS1Id,
                        'pcid'=> $cateTopPic['id'],
                        'type_x'=>1,
                        'type'=> 'showPic',
                        'type_i'=>1,
                        'title'=>'梦幻仙境',
                        'thumb'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/case8.jpg',
                        'text'=>'a:4:{i:0;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con1.jpg";i:1;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con2.jpg";i:2;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con3.jpg";i:3;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con4.jpg";}',
                    );
                    $dataPicCon4 = array(
                        'uniacid' => $uniacid,
                        'cid'=>$dataCatePicS1Id,
                        'pcid'=> $cateTopPic['id'],
                        'type_x'=>1,
                        'type'=> 'showPic',
                        'type_i'=>1,
                        'title'=>'夕阳的艳丽',
                        'thumb'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/case7.jpg',
                        'text'=>'a:4:{i:0;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con1.jpg";i:1;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con2.jpg";i:2;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con3.jpg";i:3;s:53:"http://p2bwp6sww.bkt.clouddn.com/hunsha/case_con4.jpg";}',
                    );
                    pdo_insert('sudu8_page_products', $dataPicCon1);
                    pdo_insert('sudu8_page_products', $dataPicCon2);
                    pdo_insert('sudu8_page_products', $dataPicCon3);
                    pdo_insert('sudu8_page_products', $dataPicCon4);
                }
                //添加文章
                $cateArtCon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showArt' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopArtId));
                $cateArtConNum = count($cateArtCon);
                if($cateArtConNum == 0){
                    $dataArtCon1 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId,
                        'pcid'=> $dataCateTopArtId,
                        'type'=> 'showArt',
                        'type_i'=> 1,
                        'title'=> '为爱再造一座城',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/a1.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon2 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId,
                        'pcid'=> $dataCateTopArtId,
                        'type'=> 'showArt',
                        'type_i'=> 1,
                        'title'=> '恰好遇见你',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/a2.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon3 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId,
                        'pcid'=> $dataCateTopArtId,
                        'type'=> 'showArt',
                        'type_i'=> 0,
                        'title'=> '月夜香奈儿活动',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/a3.jpg',
                        'text'=> '这里是文章内容',
                    );
                    pdo_insert('sudu8_page_products', $dataArtCon1);
                    pdo_insert('sudu8_page_products', $dataArtCon2);
                    pdo_insert('sudu8_page_products', $dataArtCon3);
                }
                //添加商品
                $cateProCon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopProId));
                $cateProConNum = count($cateProCon);
                if($cateProConNum == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopProId,
                        'pcid'=> $dataCateTopProId,
                        'type'=> 'showPro',
                        'type_i'=> 1,
                        'labels'=>'',
                        'title'=> '情侣写真',
                        'price'=>199,
                        'market_price'=>999,
                        'sale_num'=>18,
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/c6.jpg',
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/hunsha/c6.jpg";}',
                        'product_txt'=>'这里是商品的详细介绍，可放图文',
                    );
                    $dataProCon2 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopProId,
                        'pcid'=> $dataCateTopProId,
                        'type'=> 'showPro',
                        'type_i'=> 1,
                        'labels'=>'',
                        'title'=> '婚纱套系',
                        'price'=>2999,
                        'market_price'=>5999,
                        'sale_num'=>22,
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/c1.jpg',
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/hunsha/c1.jpg";}',
                        'product_txt'=>'这里是商品的详细介绍，可放图文',
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                    pdo_insert('sudu8_page_products', $dataProCon2);
                }
                $dataAbout = array(
                    'uniacid' => $uniacid,
                    'header'=>1,
                    'tel_box'=>1,
                    'serv_box'=>1,
                    'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',
                );
                $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($about['uniacid'])) {
                    pdo_insert('sudu8_page_about', $dataAbout);
                } else {
                    pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
                }
                $dataForms = array(
                    'uniacid' => $uniacid,
                    'forms_style'=> 2,
                    'forms_inps'=> 0,
                    'forms_head'=> 'none',
                    'forms_name'=> '自助预约',
                    'forms_ename'=> 'Self Booking',
                    'forms_title_s'=> 'title1',
                    'subtime'=> 0,
                    'forms_btn'=> '立即预约',
                    'success'=> '您已预约成功！',
                    'name'=> '姓名',
                    'name_must'=> 1,
                    'tel'=> '电话',
                    'tel_use'=> 1,
                    'tel_must'=> 1,
                    'date'=> '预约时间',
                    'date_use'=> 1,
                    'checkbox_n'=> '拍摄类型',
                    'checkbox_num'=> 2,
                    'checkbox_use'=> 1,
                    'checkbox_v'=> '婚纱摄影,亲子儿童,个人写真,情侣闺蜜',
                    'content_n'=> '备注',
                    'content_use'=> 1,
                    'wechat_use'=> 0,
                    'address_use'=> 0,
                    'date_must'=> 0,
                    'single_use'=> 0,
                    'checkbox_must'=> 0,
                    'content_must'=> 0,
                );
                $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($froms['uniacid'])) {
                    pdo_insert('sudu8_page_forms_config', $dataForms);
                } else {
                    pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                }
                    //婚纱摄影版
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:3:{i:0;s:50:"http://p2bwp6sww.bkt.clouddn.com/hunsha/slide1.jpg";i:1;s:50:"http://p2bwp6sww.bkt.clouddn.com/hunsha/slide2.jpg";i:2;s:50:"http://p2bwp6sww.bkt.clouddn.com/hunsha/slide3.jpg";}',
                        'name' => '婚纱摄影演示版',
                        'desc'=>'中国新派婚纱摄影典范',
                        'about' => '婚纱摄影是为客户量身打造，服务，品质，销售于一体的婚纱摄影。摄影为讲究品牌、注重品质的顾客，精心打造世界一流的婚纱照，使顾客充分享受时尚、专业、舒适的拍摄过程。',
                        'address' => '北京市东城区三环路888号',
                        'time' => '9:00 - 18:00',
                        'tel' => '18669868123',
                        'longitude' => '116.321697',
                        'latitude' => '39.894197',
                        'aboutCN' => '公司介绍',
                        'aboutCNen' => 'About Company',
                        'index_about_title' => '9',
                        'banner'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/bg.jpg',
                        'logo'=>'http://p2bwp6sww.bkt.clouddn.com/hunsha/logo.jpg',
                        'base_color'=> '#eb75cc',
                        'base_tcolor'=> '#ffffff',
                        'base_color2'=> '#ff007b',
                        'base_color_t'=> '#ffcf3d',
                        'index_style'=> 'slide',
                        'tel_box'=> '0',
                        'index_about_title'=> 'title2',
                        'catename_x'=> '最新客照',
                        'catenameen_x'=> 'New Photos',
                        'i_b_x_ts'=>'2',
                        'i_b_x_iw'=> '560',
                        'i_b_y_ts'=> '9',
                        'c_b_bg'=> 'http://p2bwp6sww.bkt.clouddn.com/hunsha/bg_s.jpg',
                        'c_b_btn'=> '1',
                        'form_index'=> '0',
                        'c_title'=> '1',
                        'tabbar'=>'a:5:{i:0;s:211:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar1.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar1.png";}";i:1;s:218:"a:4:{s:8:"tabbar_l";s:5:"about";s:8:"tabbar_t";s:12:"公司介绍";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar2.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar2.png";}";i:2;s:233:"a:5:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:12:"产品中心";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar3.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar3.png";s:4:"type";s:1:"7";}";i:3;s:233:"a:5:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:12:"最新活动";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar4.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar4.png";s:4:"type";s:1:"7";}";i:4;s:224:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar5.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/hunsha/tabbar5.png";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
                }elseif($making_tmp == 2){
                //建立顶级文章栏目
                $cateTopArt = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArt1 = array(
                'uniacid' => $uniacid,
                'num' => 98,
                'type' => 'showArt',
                'statue' => 1,
                'cid' => 0,
                'name' => '服务项目',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/nav2.png', 
                'ename' => 'Service',
                'name_n' => '',
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 1,         //
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopArt2 = array(
                'uniacid' => $uniacid,
                'num' => 8,
                'type' => 'showArt',
                'statue' => 1,
                'cid' => 0,
                'name' => '客户案例',
                'ename' => 'case',
                'name_n' => '',
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 3,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopArt3 = array(
                'uniacid' => $uniacid,
                'num' => 99,
                'type' => 'showArt',
                'statue' => 1,
                'cid' => 0,
                'name' => '加盟优势',
                'ename' => 'Advantage',
                'name_n' => '',
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 2,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                if (empty($cateTopArt['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopArt1);
                    pdo_insert('sudu8_page_cate', $dataCateTopArt2);
                    pdo_insert('sudu8_page_cate', $dataCateTopArt3);
                    $dataCateTopArtAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopArtId1 = $dataCateTopArtAll[0]['id'];
                    $dataCateTopArtId2 = $dataCateTopArtAll[1]['id'];
                    $dataCateTopArtId3 = $dataCateTopArtAll[2]['id'];
                } else {
                    $dataCateTopArtAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopArtId1 = $dataCateTopArtAll[0]['id'];
                    $dataCateTopArtId2 = $dataCateTopArtAll[1]['id'];
                    $dataCateTopArtId3 = $dataCateTopArtAll[2]['id'];
                    pdo_update('sudu8_page_cate', $dataCateTopArt1 ,array('uniacid' => $uniacid,'id'=>$dataCateTopArtId1));
                    pdo_update('sudu8_page_cate', $dataCateTopArt2 ,array('uniacid' => $uniacid,'id'=>$dataCateTopArtId2));
                    pdo_update('sudu8_page_cate', $dataCateTopArt3 ,array('uniacid' => $uniacid,'id'=>$dataCateTopArtId3));
                }
                //建立顶级商品栏目
                $cateTopPro = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopPro = array(
                'uniacid' => $uniacid,
                'num' => 98,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '材料销售',
                'ename' => 'store',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/nav3.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                if (empty($cateTopPro['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPro);
                } else {
                    pdo_update('sudu8_page_cate', $dataCateTopPro ,array('uniacid' => $uniacid,'id'=>$cateTopPro['id']));
                }
                $dataCateTopPro = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopProId = $dataCateTopPro['id']; //顶级商品栏目材料销售的ID
                $cateProSon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type='showPro' and cid = :cid ", array(':uniacid' => $uniacid,':cid' => $cateTopPro['id']));
                $cateProNum = count($cateProSon);
                //建立子级商品栏目
                if($cateProNum == 0){
                    $dataCateProS1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,     //排序
                        'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                        'statue' => 1,//启用 1启用 0不启用
                        'cid' => $dataCateTopProId,               //所属栏目 0顶级分类 
                        'name' => '维修套装',
                        'ename' => '',
                        'name_n' => '',
                        'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/column1.jpg',              //栏目缩略图
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                        'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                    );
                    $dataCateProS2 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,     //排序
                        'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                        'statue' => 1,//启用 1启用 0不启用
                        'cid' => $dataCateTopProId,               //所属栏目 0顶级分类 
                        'name' => '维修工具',
                        'ename' => '',
                        'name_n' => '',
                        'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/column2.jpg',              //栏目缩略图
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                        'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                    );
                    $dataCateProS3 = array(
                        'uniacid' => $uniacid,
                        'num' => 97,     //排序
                        'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                        'statue' => 1,//启用 1启用 0不启用
                        'cid' => $dataCateTopProId,               //所属栏目 0顶级分类 
                        'name' => '家具维修材料',
                        'ename' => '',
                        'name_n' => '',
                        'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/column3.jpg',              //栏目缩略图
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                        'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                    );
                    $dataCateProS4 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,     //排序
                        'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                        'statue' => 1,//启用 1启用 0不启用
                        'cid' => $dataCateTopProId,               //所属栏目 0顶级分类 
                        'name' => '沙发维修材料',
                        'ename' => '',
                        'name_n' => '',
                        'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/column4.jpg',              //栏目缩略图
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                        'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                    );
                    pdo_insert('sudu8_page_cate', $dataCateProS1);
                    pdo_insert('sudu8_page_cate', $dataCateProS2);
                    pdo_insert('sudu8_page_cate', $dataCateProS3);
                    pdo_insert('sudu8_page_cate', $dataCateProS4);
                    $dataCateProSAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid!=0", array(':uniacid' => $uniacid));
                    $dataCateProS1Id = $dataCateProSAll[0]['id'];  
                    $dataCateProS2Id = $dataCateProSAll[1]['id'];
                    $dataCateProS3Id = $dataCateProSAll[2]['id'];
                    $dataCateProS4Id = $dataCateProSAll[3]['id'];
                }else{
                    $dataCateProSAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid!=0", array(':uniacid' => $uniacid));
                    $dataCateProS1Id = $dataCateProSAll[0]['id'];
                    $dataCateProS2Id = $dataCateProSAll[1]['id'];
                    $dataCateProS3Id = $dataCateProSAll[2]['id'];
                    $dataCateProS4Id = $dataCateProSAll[3]['id'];
                }
                //建立顶级单页面栏目
                $CatePage = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='page' AND cid=0", array(':uniacid' => $uniacid));
                $dataCatePage1 = array(
                'uniacid' => $uniacid,
                'num' => 99,     //排序
                'type' => 'page',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '关于我们',
                'ename' => 'About',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/nav1.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 2,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'content' => "此处是栏目内容",         //栏目内容
                );
                $dataCatePage2 = array(
                'uniacid' => $uniacid,
                'num' => 97,     //排序
                'type' => 'page',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '加盟培训',
                'ename' => 'Join',
                'name_n' => '',        //导航栏标题
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/nav4.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 2,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'content' => "此处是栏目内容",         //栏目内容
                );
                if (empty($CatePage['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCatePage1);     
                    pdo_insert('sudu8_page_cate', $dataCatePage2);      
                }
                    $CatePageAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='page' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCatePageId1 = $CatePageAll[0]['id'];//关于我们
                    $dataCatePageId2 = $CatePageAll[1]['id'];//加盟培训 
                 //建立导航
                $dataNav = array(
                    'url'=>$dataCatePageId1.",".$dataCateTopArtId1.",".$dataCateTopProId.",".$dataCatePageId2,  //导航栏目
                    'uniacid' => $uniacid,
                    'statue'=>1,  //首页导航模块  0不启用 1启用栏目导航 2启用自定义导航
                    'name_s'=>1,    //名称板块是否显示  0显示 1不显示
                    'box_p_tb'=>4,  //导航上下边距
                    'box_p_lr'=>1,  //导航左右边距
                    'number'=>4,    //每排显示数量
                    'img_size'=>60, //图标占比
                    'title_position'=>1, //1文字在下方,无背景 2文字在底部，半透明背景  3文字左上角，半透明背景  0文字不显示
                );
                if (empty($dataNavCon['uniacid'])) {
                    pdo_insert('sudu8_page_nav', $dataNav);
                } else {
                    pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                }
                  //服务项目栏目id   $dataCateTopArtId1
                  //客服案例栏目id   $dataCateTopArtId2
                //添加文章
                $cateArtCon1 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showArt' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopArtId1));
                $cateArtCon2 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showArt' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopArtId2));
                $cateArtCon3 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showArt' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopArtId2));
                $cateArtConNum1 = count($cateArtCon1);
                $cateArtConNum2 = count($cateArtCon2);
                $cateArtConNum3 = count($cateArtCon3);
                if($cateArtConNum1 == 0){
                    $dataArtCon1 = array(
                        'num' => 99,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId1,  
                        'pcid'=> $dataCateTopArtId1,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '沙发维修',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art1.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon2 = array(
                        'num' => 93,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId1,  
                        'pcid'=> $dataCateTopArtId1,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '汽车内饰维修',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art2.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon3 = array(
                        'num' => 98,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId1,  
                        'pcid'=> $dataCateTopArtId1,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '沙发翻新',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art3.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon4 = array(
                        'num' => 98,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId1,  
                        'pcid'=> $dataCateTopArtId1,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '办公家具维修',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art4.jpg',
                        'text'=> '这里是文章内容',
                    );
                    pdo_insert('sudu8_page_products', $dataArtCon1);
                    pdo_insert('sudu8_page_products', $dataArtCon2);
                    pdo_insert('sudu8_page_products', $dataArtCon3);
                    pdo_insert('sudu8_page_products', $dataArtCon4);
                }
                if($cateArtConNum2 == 0){
                    $dataArtCon1 = array(
                        'num' => 99,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId2,  
                        'pcid'=> $dataCateTopArtId2,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '亢龙太子酒店-----沙发维修',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art10.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon2 = array(
                        'num' => 93,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId2,  
                        'pcid'=> $dataCateTopArtId2,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '豪宅------家具贴膜',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art11.jpg',
                        'text'=> '这里是文章内容',
                    );
                    pdo_insert('sudu8_page_products', $dataArtCon1);
                    pdo_insert('sudu8_page_products', $dataArtCon2);
                }
                if($cateArtConNum3 == 0){
                    $dataArtCon1 = array(
                        'num' => 99,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId3,  
                        'pcid'=> $dataCateTopArtId3,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '产品特点',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art12.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon2 = array(
                        'num' => 98,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId3,  
                        'pcid'=> $dataCateTopArtId3,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '多种营养',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art13.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon3 = array(
                        'num' => 98,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId3,  
                        'pcid'=> $dataCateTopArtId3,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '六大优势',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art14.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon4 = array(
                        'num' => 97,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId3,  
                        'pcid'=> $dataCateTopArtId3,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '品牌支持',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art15.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon5 = array(
                        'num' => 96,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId3,  
                        'pcid'=> $dataCateTopArtId3,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '市场分析',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art16.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon6 = array(
                        'num' => 95,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId3,  
                        'pcid'=> $dataCateTopArtId3,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '利润分析',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art17.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon7 = array(
                        'num' => 94,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId3,  
                        'pcid'=> $dataCateTopArtId3,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '如何开店',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art18.jpg',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon8 = array(
                        'num' => 93,//序号
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopArtId3,  
                        'pcid'=> $dataCateTopArtId3,  
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'type'=> 'showArt', 
                        'title'=> '代理加盟',  //标题
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/art19.jpg',
                        'text'=> '这里是文章内容',
                    );
                    pdo_insert('sudu8_page_products', $dataArtCon1);
                    pdo_insert('sudu8_page_products', $dataArtCon2);
                    pdo_insert('sudu8_page_products', $dataArtCon3);
                    pdo_insert('sudu8_page_products', $dataArtCon4);
                    pdo_insert('sudu8_page_products', $dataArtCon5);
                    pdo_insert('sudu8_page_products', $dataArtCon6);
                    pdo_insert('sudu8_page_products', $dataArtCon7);
                    pdo_insert('sudu8_page_products', $dataArtCon8);
                }
                //添加商品
                $cateProCon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopProId));
                $cateProConNum = count($cateProCon);
                if($cateProConNum == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateProS1Id,   //父级栏目
                        'pcid'=> $dataCateTopProId, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'购买',//购买方式 
                        'price'=>350,      //门店价
                        'market_price'=>400, //市场价
                        'pro_kc'=>100,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/pro1.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:57:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/pro_a1_z1.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '修皮小套装', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                }
                //基础信息》公司介绍页
                $dataAbout = array(
                    'uniacid' => $uniacid,
                    'header'=>1,  //页顶部样式  1背景、标题、logo 2幻灯片[纯图]  3幻灯片[带链接]  0不行=显示
                    'tel_box'=>1, //电话、时间区块  1显示 0隐藏
                    'serv_box'=>1, //服务中心板块 1彩色实心  2白色边框  0本版块隐藏
                    'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',  //内容
                );
                $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($about['uniacid'])) {
                    pdo_insert('sudu8_page_about', $dataAbout);
                } else {
                    pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
                }
                $dataForms = array(
                    'uniacid' => $uniacid,
                    'forms_style'=> 1,   //表单样式 1上线结构 2横排紧凑
                    'forms_title_s'=> 'title1',  //表单版本标题样式 title1上下结构  title2左右结构
                    'forms_head'=> 'header',  //表单页面顶部样式 header默认样式 slide幻灯片[纯图] newslide幻灯片[带链接] pic自定义内容 none不显示
                    'forms_name'=> '服务预约', //表单名称
                    'forms_ename'=> 'Order & Date', //表单英文名称
                    'forms_inps'=> 0,    //输入框提示语 1显示 0隐藏
                    'subtime'=> 2,      //提交间隔时间
                    'forms_btn'=> '预约',  //按钮文字
                    'success'=> '您已预约成功！',  //提交成功提示
                    'name'=> '姓名',  //文本输入框1
                    'name_must'=> 1,  //文本输入框1 1必填
                    'tel'=> '电话',   //文本输入框2
                    'tel_use'=> 1,  //文本输入框2 1启用
                    'tel_must'=> 1, //文本输入框2 1必填
                    'wechat'=>'地址', //文本输入框3 
                    'wechat_use'=> 1,//文本输入框3 1启用
                    'wechat_must'=>1,//文本输入框3 1必填
                    'content_n'=> '需求描述', //多行文本
                    'content_use'=> 1, //多行文本 1启用
                    'content_must'=> 1, //多行文本 1必填
                );
                $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($froms['uniacid'])) {
                    pdo_insert('sudu8_page_forms_config', $dataForms);
                } else {
                    pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                }
                //基础信息
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:1:{i:0;s:53:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/slide.jpg";}',  //幻灯片
                        'banner'=>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/logo_bg.jpg',  //门店背景
                        'logo'=>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/logo.jpg',  //logo
                        'name' => '招商代理',
                        'desc'=>'招商代理',
                        'address' => '南通世纪大道8888号',
                        'time' => '8:30 - 18:00',
                        'tel' => '15111111111',
                        'latitude' => '31.983310',
                        'longitude' => '120.946330',
                        'about' => '皮新彩，从事沙发家具维修翻新上门服务，维修材料的研发和销售，沙发家具维修技术培训！经过多年的发展，目前在上海、北京、长沙、成都、合肥等等国内80%的大城市有分部。是国内国际品牌家具售后维修的首选提供商.本公司一贯坚持专业、专心、细致、真诚的经营理念，全心全意为客户提供优质的家具维修美容服务让家具座椅日久长新完美无缺。',
                        //样式DIY
                        'base_color'=> '#d40f33',  //小程序头底主色
                        'base_tcolor'=> '#ffffff', //小程序头底文字色
                        'base_color2'=> '#d40f33',  //小程序突出颜色
                        'base_color_t'=> '#ffcf3d', //默认样式标题颜色 公司介绍页
                        'config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"1";s:8:"bigadCTC";s:1:"8";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"优惠活动";s:7:"miniadB";s:12:"查看详情";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}',
                        'index_style'=> 'slide',//header背景、标题、logo  slide纯幻灯片[基础设置]  newslide新幻灯片[带连接]
                        'tel_box'=> 1,//1显示 0不显示
                        'aboutCN' => '公司介绍',   //首页介绍板块栏目名
                        'aboutCNen' => 'About Company',//首页介绍板块栏目英文名
                        'index_about_title' => 9, //介绍板块标题样式 title1上下结构 title2左右结构  no不显示标题 9本版块隐藏
                        'catename_x'=> '最新客照', //竖排推荐区中文名
                        'catenameen_x'=> 'New Photos',//竖排推荐区英文名
                        'i_b_x_ts'=>9,//横排推荐去标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'i_b_x_iw'=> 560,//图片宽度
                        'catename'=>'服务项目', //竖排推荐区中文名
                        'catenameen'=>'Services', //竖排推荐区英文名
                        'i_b_y_ts'=> 9,//介绍板块标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'index_pro_lstyle'=> 1,//竖排推荐区列表样式 1单行大图 2两列图片  3三列图片 8单行图文、带简介  3单行图文、带简介、时间、阅读量  4 纯标题样式   list_pic2 老版本修复【小程序版本低于6.0.8】
                        'index_pro_ts_al'=>'t1', //竖排推荐区列表标题 t1【无背景】标题左对齐  tc【无背景】标题居中下方 tlb【透明背景】标题左对齐底部  tcb【透明背景】标题居中底部  none不显示标题
                        'c_b_bg'=> '', //服务中心背景图
                        'c_b_btn'=> 0,//服务中心按钮样式 1彩色实心 2白色边框 0首页隐藏
                        'form_index'=> 0,//首页表单  1开启 0不
                        'c_title'=> 1,//内页样式DIY 1带时间标题 2纯标题 0隐藏
                        // 'footer_style'=>'none',//老版本修复  底部导航 footer1首页-电话-客服-导航 footer1首页-电话-预约-导航 footer3首页-介绍-服务-预约  none不显示
                        'tabbar_t'=>1, //启用底部菜单tabbar 1启用 0不
                        'tabbar_bg'=>'#d40f33', //tabbar背景颜色
                        //'color_bar'=>'',tabbar顶部横线颜色
                        'tabbar_tc'=>'#ffffff',//tabbar文字颜色
                        //'tabbar_tca'=>'',选中颜色
                        'tabbar'=>'a:5:{i:0;s:219:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:55:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/tabbar1.png";s:9:"tabbar_p2";s:55:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/tabbar1.png";}";i:1;s:234:"a:5:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:6:"项目";s:9:"tabbar_p1";s:55:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/tabbar2.png";s:9:"tabbar_p2";s:55:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/tabbar2.png";s:4:"type";s:1:"7";}";i:2;s:234:"a:5:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:6:"材料";s:9:"tabbar_p1";s:55:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/tabbar3.png";s:9:"tabbar_p2";s:55:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/tabbar3.png";s:4:"type";s:1:"7";}";i:3;s:218:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:6:"预约";s:9:"tabbar_p1";s:55:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/tabbar4.png";s:9:"tabbar_p2";s:55:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/tabbar4.png";}";i:4;s:225:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:6:"我的";s:9:"tabbar_p1";s:55:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/tabbar5.png";s:9:"tabbar_p2";s:55:"http://p2bwp6sww.bkt.clouddn.com/pigefanxin/tabbar5.png";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
            }elseif($making_tmp == 3){
                //建立顶级商品栏目
                $cateTopPro = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $cateTopProNum = count($cateTopPro);
                $dataCateTopPro1 = array(
                'uniacid' => $uniacid,
                'num' => 999,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '所有产品',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/jiaju/nav1.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro2 = array(
                'uniacid' => $uniacid,
                'num' => 98,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '卧室系列',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/jiaju/nav2.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro3 = array(
                'uniacid' => $uniacid,
                'num' => 97,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '书房系列',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/jiaju/nav3.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro4 = array(
                'uniacid' => $uniacid,
                'num' => 96,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '阳台系列',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/jiaju/nav4.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro5 = array(
                'uniacid' => $uniacid,
                'num' => 95,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '客厅系列',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/jiaju/nav5.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro6 = array(
                'uniacid' => $uniacid,
                'num' => 94,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '商务办公',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/jiaju/nav6.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro7 = array(
                'uniacid' => $uniacid,
                'num' => 93,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '儿童系列',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/jiaju/nav7.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro8 = array(
                'uniacid' => $uniacid,
                'num' => 92,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '储物系列',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/jiaju/nav8.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                if ($cateTopProNum == 0) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPro1);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro2);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro3);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro4);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro5);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro6);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro7);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro8);
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    $dataCateTopPro2Id = $dataCateTopProAll[1]['id'];
                    $dataCateTopPro3Id = $dataCateTopProAll[2]['id'];
                    $dataCateTopPro4Id = $dataCateTopProAll[3]['id'];
                    $dataCateTopPro5Id = $dataCateTopProAll[4]['id'];
                    $dataCateTopPro6Id = $dataCateTopProAll[5]['id'];
                    $dataCateTopPro7Id = $dataCateTopProAll[6]['id'];
                    $dataCateTopPro8Id = $dataCateTopProAll[7]['id'];
                } else {
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    $dataCateTopPro2Id = $dataCateTopProAll[1]['id'];
                    $dataCateTopPro3Id = $dataCateTopProAll[2]['id'];
                    $dataCateTopPro4Id = $dataCateTopProAll[3]['id'];
                    $dataCateTopPro5Id = $dataCateTopProAll[4]['id'];
                    $dataCateTopPro6Id = $dataCateTopProAll[5]['id'];
                    $dataCateTopPro7Id = $dataCateTopProAll[6]['id'];
                    $dataCateTopPro8Id = $dataCateTopProAll[7]['id'];
                    pdo_update('sudu8_page_cate', $dataCateTopPro1 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro1Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro2 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro2Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro3 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro3Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro4 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro4Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro5 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro5Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro6 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro6Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro7 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro7Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro8 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro8Id));
                }
                 //建立导航（首页导航栏）
                $dataNav = array(
                    'url'=>$dataCateTopPro1Id.",".$dataCateTopPro2Id.",".$dataCateTopPro3Id.",".$dataCateTopPro4Id.",".$dataCateTopPro5Id.",".$dataCateTopPro6Id.",".$dataCateTopPro7Id.",".$dataCateTopPro8Id,  //导航栏目
                    'uniacid' => $uniacid,
                    'statue'=>1,  //首页导航模块  0不启用 1启用栏目导航 2启用自定义导航
                    'name_s'=>1,    //名称板块是否显示  0显示 1不显示
                    'box_p_tb'=>2,  //导航上下边距
                    'box_p_lr'=>1,  //导航左右边距
                    'number'=>4,    //每排显示数量
                    'img_size'=>80, //图标占比
                    'title_position'=>0, //1文字在下方,无背景 2文字在底部，半透明背景  3文字左上角，半透明背景  0文字不显示
                );
                if (empty($dataNavCon['uniacid'])) {
                    pdo_insert('sudu8_page_nav', $dataNav);
                } else {
                    pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                }
                //添加商品
                $cateProCon1 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro1Id));  //所有产品
                $cateProCon1Num = count($cateProCon1);
                if($cateProCon1Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>1,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 0,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'购买',//购买方式 
                        'price'=>568,      //门店价
                        'market_price'=>589, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jiaju/pro1.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jiaju/pro1.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '床垫', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon2 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>1,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 0,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'购买',//购买方式 
                        'price'=>158,      //门店价
                        'market_price'=>189, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>1,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jiaju/pro5.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jiaju/pro5.jpg";}',   //商品主图
                        'labels'=> '床垫全棉床垫床褥1.8m双人垫被褥子1.2单人防滑0.9',   //商品标签
                        'title'=> '床垫全棉床垫床褥1.8m双人垫被褥子1.2单人防滑0.9', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon3 = array(
                        'uniacid' => $uniacid,
                        'num' => 97,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>1,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 0,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'购买',//购买方式 
                        'price'=>568,      //门店价
                        'market_price'=>589, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jiaju/pro1.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jiaju/pro1.jpg";}',   //商品主图
                        'labels'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子',   //商品标签
                        'title'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                    pdo_insert('sudu8_page_products', $dataProCon2);
                    pdo_insert('sudu8_page_products', $dataProCon3);
                }
                $cateProCon2 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro2Id));  //卧室系列
                $cateProCon2Num = count($cateProCon2);
                if($cateProCon2Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 97,
                        'cid'=> $dataCateTopPro2Id,   //父级栏目
                        'pcid'=> $dataCateTopPro2Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>1,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 0,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'购买',//购买方式 
                        'price'=>568,      //门店价
                        'market_price'=>589, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jiaju/pro2.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jiaju/pro2.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '床垫', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                }
                $cateProCon4 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro4Id));  //阳台系列
                $cateProCon4Num = count($cateProCon4);
                if($cateProCon4Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,
                        'cid'=> $dataCateTopPro4Id,   //父级栏目
                        'pcid'=> $dataCateTopPro4Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>1,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 0,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'购买',//购买方式 
                        'price'=>568,      //门店价
                        'market_price'=>589, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jiaju/pro3.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jiaju/pro3.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '床垫', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                }
                $cateProCon5 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro5Id));  //阳台系列
                $cateProCon5Num = count($cateProCon5);
                if($cateProCon5Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,
                        'cid'=> $dataCateTopPro5Id,   //父级栏目
                        'pcid'=> $dataCateTopPro5Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>1,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=>0,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'购买',//购买方式 
                        'price'=>568,      //门店价
                        'market_price'=>589, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jiaju/pro3.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jiaju/pro3.jpg";}',   //商品主图
                        'labels'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子',   //商品标签
                        'title'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                }
                $cateProCon8 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro8Id));  //阳台系列
                $cateProCon8Num = count($cateProCon8);
                if($cateProCon8Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,
                        'cid'=> $dataCateTopPro8Id,   //父级栏目
                        'pcid'=> $dataCateTopPro8Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>1,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=>0,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'购买',//购买方式 
                        'price'=>568,      //门店价
                        'market_price'=>589, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jiaju/pro4.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jiaju/pro4.jpg";}',   //商品主图
                        'labels'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子',   //商品标签
                        'title'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                }
                //基础信息》公司介绍页
                // $dataAbout = array(
                //     'uniacid' => $uniacid,
                //     'header'=>1,  //页顶部样式  1背景、标题、logo 2幻灯片[纯图]  3幻灯片[带链接]  0不行=显示
                //     'tel_box'=>1, //电话、时间区块  1显示 0隐藏
                //     'serv_box'=>1, //服务中心板块 1彩色实心  2白色边框  0本版块隐藏
                //     'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',  //内容
                // );
                // $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                // if (empty($about['uniacid'])) {
                //     pdo_insert('sudu8_page_about', $dataAbout);
                // } else {
                //     pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
                // }
                // $dataForms = array(
                //     'uniacid' => $uniacid,
                //     'forms_style'=> 1,   //表单样式 1上线结构 2横排紧凑
                //     'forms_title_s'=> 'title1',  //表单版本标题样式 title1上下结构  title2左右结构
                //     'forms_head'=> 'header',  //表单页面顶部样式 header默认样式 slide幻灯片[纯图] newslide幻灯片[带链接] pic自定义内容 none不显示
                //     'forms_name'=> '服务预约', //表单名称
                //     'forms_ename'=> 'Order & Date', //表单英文名称
                //     'forms_inps'=> 0,    //输入框提示语 1显示 0隐藏
                //     'subtime'=> 2,      //提交间隔时间
                //     'forms_btn'=> '预约',  //按钮文字
                //     'success'=> '您已预约成功！',  //提交成功提示
                //     'name'=> '姓名',  //文本输入框1
                //     'name_must'=> 1,  //文本输入框1 1必填
                //     'tel'=> '电话',   //文本输入框2
                //     'tel_use'=> 1,  //文本输入框2 1启用
                //     'tel_must'=> 1, //文本输入框2 1必填
                //     'wechat'=>'地址', //文本输入框3 
                //     'wechat_use'=> 1,//文本输入框3 1启用
                //     'wechat_must'=>1,//文本输入框3 1必填
                //     'content_n'=> '需求描述', //多行文本
                //     'content_use'=> 1, //多行文本 1启用
                //     'content_must'=> 1, //多行文本 1必填
                // );
                // $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                // if (empty($froms['uniacid'])) {
                //     pdo_insert('sudu8_page_forms_config', $dataForms);
                // } else {
                //     pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                // }
                //基础信息
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:2:{i:0;s:49:"http://p2bwp6sww.bkt.clouddn.com/jiaju/slide1.jpg";i:1;s:49:"http://p2bwp6sww.bkt.clouddn.com/jiaju/slide2.jpg";}',  //幻灯片
                        // 'banner'=>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/logo_bg.jpg',  //门店背景
                        // 'logo'=>'http://p2bwp6sww.bkt.clouddn.com/pigefanxin/logo.jpg',  //logo
                        'name' => '家居馆',
                        'desc'=>'家居销售',
                        'address' => '南通世纪大道8888号',
                        'time' => '8:30 - 18:00',
                        'tel' => '15111111111',
                        'latitude' => '31.983310',
                        'longitude' => '120.946330',
                        'about' => '家居销售',
                        //样式DIY
                        'base_color'=> '#ad9f98',  //小程序头底主色
                        'base_tcolor'=> '#ffffff', //小程序头底文字色
                        'base_color2'=> '#ad9f98',  //小程序突出颜色
                        'base_color_t'=> '#ffcf3d', //默认样式标题颜色 公司介绍页
                        'config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"1";s:6:"bigadC";s:1:"1";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"1";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}',
                        'index_style'=> 'slide',//header背景、标题、logo  slide纯幻灯片[基础设置]  newslide新幻灯片[带连接]
                        'tel_box'=> 0,//首页电话、时间区块 1显示 0不显示
                        'aboutCN' => '公司介绍',   //首页介绍板块栏目名
                        'aboutCNen' => 'About Company',//首页介绍板块栏目英文名
                        'index_about_title' => 'title1', //介绍板块标题样式 title1上下结构 title2左右结构  no不显示标题 9本版块隐藏
                        'catename_x'=> '推荐专区', //横排推荐区中文名
                        'catenameen_x'=> '',//横排推荐区英文名
                        'i_b_x_ts'=>2,//横排推荐去标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'i_b_x_iw'=> 600,//图片宽度
                        'catename'=>'热销产品', //竖排推荐区中文名
                        'catenameen'=>'', //竖排推荐区英文名
                        'i_b_y_ts'=> 2,//介绍板块标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'index_pro_lstyle'=> 2,//竖排推荐区列表样式 1单行大图 2两列图片  3三列图片 8单行图文、带简介  3单行图文、带简介、时间、阅读量  4 纯标题样式   list_pic2 老版本修复【小程序版本低于6.0.8】
                        'index_pro_ts_al'=>'t1', //竖排推荐区列表标题 t1【无背景】标题左对齐  tc【无背景】标题居中下方 tlb【透明背景】标题左对齐底部  tcb【透明背景】标题居中底部  none不显示标题
                        'c_b_bg'=> '', //服务中心背景图
                        'c_b_btn'=> 0,//服务中心按钮样式 1彩色实心 2白色边框 0首页隐藏
                        'form_index'=> 0,//首页表单  1开启 0不
                        'c_title'=> 0,//内页样式DIY 1带时间标题 2纯标题 0隐藏
                        // 'footer_style'=>'footer1',//老版本修复  底部导航 footer1首页-电话-客服-导航 footer1首页-电话-预约-导航 footer3首页-介绍-服务-预约  none不显示
                        'tabbar_t'=>1, //启用底部菜单tabbar 1启用 0不
                        // 'tabbar_bg'=>'#d40f33', //tabbar背景颜色
                        //'color_bar'=>'',tabbar顶部横线颜色
                        // 'tabbar_tc'=>'#ffffff',//tabbar文字颜色
                        //'tabbar_tca'=>'',选中颜色
                        'tabbar'=>'a:4:{i:0;s:209:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/jiaju/tabbar1.png";s:9:"tabbar_p2";s:50:"http://p2bwp6sww.bkt.clouddn.com/jiaju/tabbar1.png";}";i:1;s:207:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:6:"电话";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/jiaju/tabbar2.png";s:9:"tabbar_p2";s:50:"http://p2bwp6sww.bkt.clouddn.com/jiaju/tabbar2.png";}";i:2;s:207:"a:4:{s:8:"tabbar_l";s:3:"map";s:8:"tabbar_t";s:6:"导航";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/jiaju/tabbar3.png";s:9:"tabbar_p2";s:50:"http://p2bwp6sww.bkt.clouddn.com/jiaju/tabbar3.png";}";i:3;s:222:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/jiaju/tabbar4.png";s:9:"tabbar_p2";s:50:"http://p2bwp6sww.bkt.clouddn.com/jiaju/tabbar4.png";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
                    //基础信息》开屏广告  type=bigad
                    $cateBanner1 = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type='bigad'", array(':uniacid' => $uniacid));  //阳台系列
                    if(empty($cateBanner1)){
                        $dataCateBanner1 = array(
                            'uniacid' => $uniacid,
                            'num'=>99,          //序号
                            'type'=> 'bigad',   //类型  banner幻灯片 bigad开屏广告  miniad谈窗广告  indexad首页广告
                            'pic'=>'http://p2bwp6sww.bkt.clouddn.com/jiaju/kaipin.png',//开屏图片
                            'url'=>'',  //链接地址
                            'flag'=>1,  //flag  1启用 0不
                            'descp'=>'',//简介  
                        );
                        pdo_insert('sudu8_page_banner', $dataCateBanner1);
                    }
                    $cateBanner2 = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type='miniad'", array(':uniacid' => $uniacid));  
                    if(empty($cateBanner2)){
                        $dataCateBanner1 = array(
                            'uniacid' => $uniacid,
                            'num'=>99,          //序号
                            'type'=> 'miniad',   //类型  banner幻灯片 bigad开屏广告  miniad谈窗广告  indexad首页广告
                            'flag'=>1,  //flag  1启用 0不
                            'pic'=>'http://p2bwp6sww.bkt.clouddn.com/jiaju/tanchuang.jpg',//开屏图片
                            'url'=>'/sudu8_page/listPro/listPro?cid='.$dataCateTopPro1Id,  //链接地址
                            'descp'=>'全部产品',//简介  
                        );
                        pdo_insert('sudu8_page_banner', $dataCateBanner1);
                    }
            }elseif($making_tmp == 4){
                //建立顶级商品栏目
                $cateTopPro = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $cateTopProNum = count($cateTopPro);
                $dataCateTopPro1 = array(
                'uniacid' => $uniacid,
                'num' => 999,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '东方风神系列',
                'ename' => 'FengShen',
                'name_n' => '',
                'catepic' =>'',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro2 = array(
                'uniacid' => $uniacid,
                'num' => 98,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '奇瑞汽车',
                'ename' => 'CHERY',
                'name_n' => '',
                'catepic' =>'',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                if ($cateTopProNum == 0) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPro1);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro2);
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    $dataCateTopPro2Id = $dataCateTopProAll[1]['id'];
                } else {
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    $dataCateTopPro2Id = $dataCateTopProAll[1]['id'];
                    pdo_update('sudu8_page_cate', $dataCateTopPro1 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro1Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro2 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro2Id));
                }
                 //建立导航（首页导航栏）
                // $dataNav = array(
                //     'url'=>$dataCateTopPro1Id.",".$dataCateTopPro2Id.",".$dataCateTopPro3Id.",".$dataCateTopPro4Id.",".$dataCateTopPro5Id.",".$dataCateTopPro6Id.",".$dataCateTopPro7Id.",".$dataCateTopPro8Id,  //导航栏目
                //     'uniacid' => $uniacid,
                //     'statue'=>1,  //首页导航模块  0不启用 1启用栏目导航 2启用自定义导航
                //     'name_s'=>1,    //名称板块是否显示  0显示 1不显示
                //     'box_p_tb'=>2,  //导航上下边距
                //     'box_p_lr'=>1,  //导航左右边距
                //     'number'=>4,    //每排显示数量
                //     'img_size'=>80, //图标占比
                //     'title_position'=>0, //1文字在下方,无背景 2文字在底部，半透明背景  3文字左上角，半透明背景  0文字不显示
                // );
                // if (empty($dataNavCon['uniacid'])) {
                //     pdo_insert('sudu8_page_nav', $dataNav);
                // } else {
                //     pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                // }
                //建立顶级单页面栏目
                $CatePage = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='page' AND cid=0", array(':uniacid' => $uniacid));
                $dataCatePage1 = array(
                'uniacid' => $uniacid,
                'num' => 96,     //排序
                'type' => 'page',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '汽车维修',
                'ename' => 'Car Maintenance',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/qiche/page1.jpg',             //栏目缩略图
                'cdesc' => "维修项目：故障检测 机修 电器 钣金油漆。各类车型配件齐全，原厂正品，高效便捷，精益求精！",              //栏目简介
                'show_i' => 1,    
                'list_style' => 3,           //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 2,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'content' => "此处是栏目内容",         //栏目内容
                );
                $dataCatePage2 = array(
                'uniacid' => $uniacid,
                'num' => 95,     //排序
                'type' => 'page',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '汽车美容',
                'ename' => 'Car Cosmetology',
                'name_n' => '',        //导航栏标题
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/qiche/page2.jpg',             //栏目缩略图
                'cdesc' => "美容项目：封釉 打蜡 抛光 贴膜 清洗 ",              //栏目简介
                'show_i' => 1,    
                'list_style' => 3,                 //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 2,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'content' => "此处是栏目内容",         //栏目内容
                );
                if (empty($CatePage['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCatePage1);     
                    pdo_insert('sudu8_page_cate', $dataCatePage2);      
                }
                //添加商品
                $cateProCon1 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro1Id));  //东方风神系列
                $cateProCon1Num = count($cateProCon1);
                if($cateProCon1Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>99700,      //门店价
                        'market_price'=>99700, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/qiche/pro1.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/qiche/pro1.jpg";}',   //商品主图
                        'labels'=> '风神AX7',   //商品标签
                        'title'=> '东风风神AX7', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon2 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>99700,      //门店价
                        'market_price'=>99700, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/qiche/pro2.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/qiche/pro2.jpg";}',   //商品主图
                        'labels'=> '风神AX5',   //商品标签
                        'title'=> '东风风神AX5 新车', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                    pdo_insert('sudu8_page_products', $dataProCon2);
                }
                $cateProCon2 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro2Id));  //奇瑞汽车
                $cateProCon2Num = count($cateProCon2);
                if($cateProCon2Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro2Id,   //父级栏目
                        'pcid'=> $dataCateTopPro2Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>99700,      //门店价
                        'market_price'=>99700, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/qiche/pro3.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/qiche/pro3.jpg";}',   //商品主图
                        'labels'=> '瑞虎5x',   //商品标签
                        'title'=> '奇瑞汽车瑞虎5x ', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon2 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,
                        'cid'=> $dataCateTopPro2Id,   //父级栏目
                        'pcid'=> $dataCateTopPro2Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>99700,      //门店价
                        'market_price'=>99700, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/qiche/pro4.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/qiche/pro4.jpg";}',   //商品主图
                        'labels'=> '瑞虎7,2018款',   //商品标签
                        'title'=> '奇瑞汽车 瑞虎7 2018款', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                    pdo_insert('sudu8_page_products', $dataProCon2);
                }
                //基础信息》公司介绍页
                $dataAbout = array(
                    'uniacid' => $uniacid,
                    'header'=>1,  //页顶部样式  1背景、标题、logo 2幻灯片[纯图]  3幻灯片[带链接]  0不行=显示
                    'tel_box'=>1, //电话、时间区块  1显示 0隐藏
                    'serv_box'=>1, //服务中心板块 1彩色实心  2白色边框  0本版块隐藏
                    'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',  //内容
                );
                $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($about['uniacid'])) {
                    pdo_insert('sudu8_page_about', $dataAbout);
                } else {
                    pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
                }
                $dataForms = array(
                    'uniacid' => $uniacid,
                    'forms_style'=> 1,   //表单样式 1上线结构 2横排紧凑
                    'forms_title_s'=> 'title1',  //表单版本标题样式 title1上下结构  title2左右结构
                    'forms_head'=> 'header',  //表单页面顶部样式 header默认样式 slide幻灯片[纯图] newslide幻灯片[带链接] pic自定义内容 none不显示
                    'forms_name'=> '看车预约', //表单名称
                    'forms_ename'=> '', //表单英文名称
                    'forms_inps'=> 0,    //输入框提示语 1显示 0隐藏
                    'subtime'=> 2,      //提交间隔时间
                    'forms_btn'=> '预约',  //按钮文字
                    'success'=> '您已预约成功！',  //提交成功提示
                    'name'=> '姓名',  //文本输入框1
                    'name_must'=> 1,  //文本输入框1 1必填
                    'tel'=> '电话',   //文本输入框2
                    'tel_use'=> 1,  //文本输入框2 1启用
                    'tel_must'=> 1, //文本输入框2 1必填
                    'wechat'=>'预算', //文本输入框3 
                    'wechat_use'=> 1,//文本输入框3 1启用
                    'wechat_must'=>1,//文本输入框3 1必填
                    'single_n'=>'意向品牌',  //单选1 文本
                    'single_num'=>3,   //单选1  每排数量
                    'single_use'=>1,   //单选1启用  
                    'single_must'=>1,   //单选1必填  
                    'single_v'=>'东方汽车,奇瑞汽车',
                    'content_n'=> '需求描述', //多行文本
                    'content_use'=> 1, //多行文本 1启用
                    'content_must'=> 1, //多行文本 1必填
                );
                $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($froms['uniacid'])) {
                    pdo_insert('sudu8_page_forms_config', $dataForms);
                } else {
                    pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                }
                //基础信息
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:2:{i:0;s:49:"http://p2bwp6sww.bkt.clouddn.com/qiche/slide1.jpg";i:1;s:49:"http://p2bwp6sww.bkt.clouddn.com/qiche/slide3.jpg";}',  //幻灯片
                        'banner'=>'http://p2bwp6sww.bkt.clouddn.com/qiche/logo_bg.jpg',  //门店背景
                        'logo'=>'http://p2bwp6sww.bkt.clouddn.com/qiche/logo.jpg',  //logo
                        'video'=>'1.mp4', //视频地址
                        'v_img'=>'http://p2bwp6sww.bkt.clouddn.com/qiche/video.jpg', //视频图片
                        'name' => '某某汽车', 
                        'desc'=>'东风风神汽车 奇瑞汽车 汽车维修美容',
                        'address' => '南通世纪大道8888号',
                        'time' => '8:30 - 18:00',
                        'tel' => '15111111111',
                        'latitude' => '31.983310',
                        'longitude' => '120.946330',
                        'about' => '某某汽车销售服务有限公司，是汽车维护服务专业机构，创办于2014年4月， 经营场所：南通世纪大道8888号。主要经营东风风神汽车销售及各类车辆维修服务。各类车型配件齐全，原厂正品，高效便捷，精益求精！ ',
                        //样式DIY
                        'base_color'=> '#4e73f6',  //小程序头底主色
                        'base_tcolor'=> '#ffffff', //小程序头底文字色
                        'base_color2'=> '#4e73f6',  //小程序突出颜色
                        'base_color_t'=> '#ffcf3d', //默认样式标题颜色 公司介绍页
                        'config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}',
                        'index_style'=> 'slide',//header背景、标题、logo  slide纯幻灯片[基础设置]  newslide新幻灯片[带连接]
                        'tel_box'=> 1,//首页电话、时间区块 1显示 0不显示
                        'aboutCN' => '门店介绍',   //首页介绍板块栏目名
                        'aboutCNen' => 'About Us',//首页介绍板块栏目英文名
                        'index_about_title' => 'title1', //介绍板块标题样式 title1上下结构 title2左右结构  no不显示标题 9本版块隐藏
                        'catename_x'=> '推荐专区', //横排推荐区中文名
                        'catenameen_x'=> '',//横排推荐区英文名
                        'i_b_x_ts'=>9,//横排推荐去标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'i_b_x_iw'=> 600,//图片宽度
                        'catename'=>'热销产品', //竖排推荐区中文名
                        'catenameen'=>'', //竖排推荐区英文名
                        'i_b_y_ts'=> 9,//介绍板块标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'index_pro_lstyle'=> 2,//竖排推荐区列表样式 1单行大图 2两列图片  3三列图片 8单行图文、带简介  3单行图文、带简介、时间、阅读量  4 纯标题样式   list_pic2 老版本修复【小程序版本低于6.0.8】
                        'index_pro_ts_al'=>'t1', //竖排推荐区列表标题 t1【无背景】标题左对齐  tc【无背景】标题居中下方 tlb【透明背景】标题左对齐底部  tcb【透明背景】标题居中底部  none不显示标题
                        'c_b_bg'=> 'http://p2bwp6sww.bkt.clouddn.com/qiche/server.jpg', //服务中心背景图
                        'c_b_btn'=> 1,//服务中心按钮样式 1彩色实心 2白色边框 0首页隐藏
                        'form_index'=> 0,//首页表单  1开启 0不
                        'c_title'=> 0,//内页样式DIY 1带时间标题 2纯标题 0隐藏
                        // 'footer_style'=>'footer1',//老版本修复  底部导航 footer1首页-电话-客服-导航 footer1首页-电话-预约-导航 footer3首页-介绍-服务-预约  none不显示
                        'tabbar_t'=>1, //启用底部菜单tabbar 1启用 0不
                        'tabbar_bg'=>'#4e73f6', //tabbar背景颜色
                        'color_bar'=>'#4e73f6',//tabbar顶部横线颜色
                        'tabbar_tc'=>'#ffffff',//tabbar文字颜色
                        'tabbar_tca'=>'#ffffff',//选中颜色
                        'tabbar'=>'a:4:{i:0;s:209:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/qiche/tabbar1.png";s:9:"tabbar_p2";s:50:"http://p2bwp6sww.bkt.clouddn.com/qiche/tabbar1.png";}";i:1;s:215:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:12:"看车预约";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/qiche/tabbar2.png";s:9:"tabbar_p2";s:50:"http://p2bwp6sww.bkt.clouddn.com/qiche/tabbar2.png";}";i:2;s:214:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:12:"联系电话";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/qiche/tabbar3.png";s:9:"tabbar_p2";s:50:"http://p2bwp6sww.bkt.clouddn.com/qiche/tabbar3.png";}";i:3;s:214:"a:4:{s:8:"tabbar_l";s:3:"map";s:8:"tabbar_t";s:12:"一键导航";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/qiche/tabbar4.png";s:9:"tabbar_p2";s:50:"http://p2bwp6sww.bkt.clouddn.com/qiche/tabbar4.png";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
                    //基础信息》开屏广告  type=bigad
                    // $cateBanner1 = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type='bigad'", array(':uniacid' => $uniacid));  //阳台系列
                    // if(empty($cateBanner1)){
                    //     $dataCateBanner1 = array(
                    //         'uniacid' => $uniacid,
                    //         'num'=>99,          //序号
                    //         'type'=> 'bigad',   //类型  banner幻灯片 bigad开屏广告  miniad谈窗广告  indexad首页广告
                    //         'pic'=>'http://p2bwp6sww.bkt.clouddn.com/jiaju/kaipin.png',//开屏图片
                    //         'url'=>'',  //链接地址
                    //         'flag'=>1,  //flag  1启用 0不
                    //         'descp'=>'',//简介  
                    //     );
                    //     pdo_insert('sudu8_page_banner', $dataCateBanner1);
                    // }
                    // $cateBanner2 = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type='miniad'", array(':uniacid' => $uniacid));  
                    // if(empty($cateBanner2)){
                    //     $dataCateBanner1 = array(
                    //         'uniacid' => $uniacid,
                    //         'num'=>99,          //序号
                    //         'type'=> 'miniad',   //类型  banner幻灯片 bigad开屏广告  miniad谈窗广告  indexad首页广告
                    //         'flag'=>1,  //flag  1启用 0不
                    //         'pic'=>'http://p2bwp6sww.bkt.clouddn.com/jiaju/tanchuang.jpg',//开屏图片
                    //         'url'=>'/sudu8_page/listPro/listPro?cid='.$dataCateTopPro1Id,  //链接地址
                    //         'descp'=>'全部产品',//简介  
                    //     );
                    //     pdo_insert('sudu8_page_banner', $dataCateBanner1);
                    // }
            }elseif($making_tmp == 5){
                //建立顶级文章栏目
                $cateTopArt = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArt = array(
                'uniacid' => $uniacid,
                'num' => 999,               //排序
                'type' => 'showArt',      //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,            //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '导航',     //栏目名称
                'ename' => '', //栏目英文名称
                'name_n' => '',   //首页导航栏标题
                'catepic' =>'',             //栏目缩略图链接
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 6,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                );
                if (empty($CateTopArt['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopArt);
                }else{
                    pdo_update('sudu8_page_cate', $dataCateTopArt ,array('uniacid' => $uniacid,'id'=>$CateTopArt[0]['id']));
                }
                $dataCateTopArt = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArtId = $dataCateTopArt['id']; //顶级栏目服务项目栏目id
                $cateArtSon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type='showArt' and cid = :cid ", array(':uniacid' => $uniacid,':cid' => $dataCateTopArtId));
                $cateArtSonNum = count($cateArtSon);
                //建立子级文章栏目
                if($cateArtSonNum == 0){
                    $datacateArtS1 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArtId,
                        'name' => '楼盘点评',
                        'ename' => '',
                        'name_n' => '楼盘点评',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/fangchan/nav1.png',
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 3,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS2 = array(
                        'uniacid' => $uniacid,
                        'num' => 97,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArtId,
                        'name' => '买房攻略',
                        'ename' => '',
                        'name_n' => '买房攻略',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/fangchan/nav2.png',
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 3,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS3 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArtId,
                        'name' => '玩转威海',
                        'ename' => '',
                        'name_n' => '玩转威海',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/fangchan/nav3.png',
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 3,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS4 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArtId,
                        'name' => '装修推荐',
                        'ename' => '',
                        'name_n' => '装修推荐',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/fangchan/nav4.png',
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 3,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS5 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArtId,
                        'name' => '新盘介绍',
                        'ename' => '',
                        'name_n' => '新盘介绍',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/fangchan/nav5.png',
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 3,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS6 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArtId,
                        'name' => '租房房源',
                        'ename' => '',
                        'name_n' => '租房房源',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/fangchan/nav6.png',
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 3,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS7 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArtId,
                        'name' => '二手房源',
                        'ename' => '',
                        'name_n' => '二手房源',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/fangchan/nav7.png',
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 3,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS8 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArtId,
                        'name' => '关于我们',
                        'ename' => '',
                        'name_n' => '关于我们',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/fangchan/nav8.png',
                        'cdesc' => "",              //栏目简介
                        'show_i' => 0,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 3,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    pdo_insert('sudu8_page_cate', $datacateArtS1);
                    pdo_insert('sudu8_page_cate', $datacateArtS2);
                    pdo_insert('sudu8_page_cate', $datacateArtS3);
                    pdo_insert('sudu8_page_cate', $datacateArtS4);
                    pdo_insert('sudu8_page_cate', $datacateArtS5);
                    pdo_insert('sudu8_page_cate', $datacateArtS6);
                    pdo_insert('sudu8_page_cate', $datacateArtS7);
                    pdo_insert('sudu8_page_cate', $datacateArtS8);
                    $datacateArtSAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid!=0", array(':uniacid' => $uniacid));
                    $datacateArtS1Id = $datacateArtSAll[0]['id'];
                    $datacateArtS2Id = $datacateArtSAll[1]['id'];
                    $datacateArtS3Id = $datacateArtSAll[2]['id'];
                    $datacateArtS4Id = $datacateArtSAll[3]['id'];
                    $datacateArtS5Id = $datacateArtSAll[4]['id'];
                    $datacateArtS6Id = $datacateArtSAll[5]['id'];
                    $datacateArtS7Id = $datacateArtSAll[6]['id'];
                    $datacateArtS8Id = $datacateArtSAll[7]['id'];
                }else{
                    $datacateArtSAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid!=0", array(':uniacid' => $uniacid));
                    $datacateArtS1Id = $datacateArtSAll[0]['id'];
                    $datacateArtS2Id = $datacateArtSAll[1]['id'];
                    $datacateArtS3Id = $datacateArtSAll[2]['id'];
                    $datacateArtS4Id = $datacateArtSAll[3]['id'];
                    $datacateArtS5Id = $datacateArtSAll[4]['id'];
                    $datacateArtS6Id = $datacateArtSAll[5]['id'];
                    $datacateArtS7Id = $datacateArtSAll[6]['id'];
                    $datacateArtS8Id = $datacateArtSAll[7]['id'];
                }
                 //添加文章
                $cateArtCon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showArt' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopArtId));
                $cateArtConNum = count($cateArtCon);
                if($cateArtConNum == 0){
                    $dataArtCon1 = array(
                        'uniacid' => $uniacid,
                        'num'=>999,
                        'cid'=> $datacateArtS1Id,
                        'pcid'=> $dataCateTopArtId,
                        'type'=> 'showArt',
                        'type_y'=> 1,
                        'title'=> '威海天恒龙泽府',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/fangchan/art1.jpg',
                        'desc'=> '这里是文章内容文章简介',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon2 = array(
                        'uniacid' => $uniacid,
                        'num'=>99,
                        'cid'=> $datacateArtS1Id,
                        'pcid'=> $dataCateTopArtId,
                        'type'=> 'showArt',
                        'type_y'=> 1,
                        'title'=> '威海华夏山海城',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/fangchan/art2.jpg',
                        'desc'=> '这里是文章内容文章简介',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon3 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $datacateArtS1Id,
                        'pcid'=> $dataCateTopArtId,
                        'type'=> 'showArt',
                        'type_y'=> 1,
                        'title'=> '威海保利·红叶谷',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/fangchan/art3.jpg',
                        'desc'=> '这里是文章内容文章简介',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon4 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $datacateArtS1Id,
                        'pcid'=> $dataCateTopArtId,
                        'type'=> 'showArt',
                        'type_y'=> 1,
                        'title'=> ' 威海荣成凤凰湖',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/fangchan/art4.jpg',
                        'desc'=> '这里是文章内容文章简介',
                        'text'=> '这里是文章内容',
                    );
                    pdo_insert('sudu8_page_products', $dataArtCon1);
                    pdo_insert('sudu8_page_products', $dataArtCon2);
                    pdo_insert('sudu8_page_products', $dataArtCon3);
                    pdo_insert('sudu8_page_products', $dataArtCon4);
                }
                 //建立导航（首页导航栏）
                $dataNav = array(
                    'url'=>$datacateArtS1Id.",".$datacateArtS2Id.",".$datacateArtS3Id.",".$datacateArtS4Id.",".$datacateArtS5Id.",".$datacateArtS6Id.",".$datacateArtS7Id.",".$datacateArtS8Id,  //导航栏目
                    'uniacid' => $uniacid,
                    'statue'=>1,  //首页导航模块  0不启用 1启用栏目导航 2启用自定义导航
                    'name_s'=>1,    //名称板块是否显示  0显示 1不显示
                    'box_p_tb'=>2,  //导航上下边距
                    'box_p_lr'=>1,  //导航左右边距
                    'number'=>4,    //每排显示数量
                    'img_size'=>100, //图标占比
                    'title_position'=>1, //1文字在下方,无背景 2文字在底部，半透明背景  3文字左上角，半透明背景  0文字不显示
                );
                if (empty($dataNavCon['uniacid'])) {
                    pdo_insert('sudu8_page_nav', $dataNav);
                } else {
                    pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                }
                //基础信息》公司介绍页
                // $dataAbout = array(
                //     'uniacid' => $uniacid,
                //     'header'=>1,  //页顶部样式  1背景、标题、logo 2幻灯片[纯图]  3幻灯片[带链接]  0不行=显示
                //     'tel_box'=>1, //电话、时间区块  1显示 0隐藏
                //     'serv_box'=>1, //服务中心板块 1彩色实心  2白色边框  0本版块隐藏
                //     'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',  //内容
                // );
                // $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                // if (empty($about['uniacid'])) {
                //     pdo_insert('sudu8_page_about', $dataAbout);
                // } else {
                //     pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
                // }
                $dataForms = array(
                    'uniacid' => $uniacid,
                    'forms_style'=> 1,   //表单样式 1上线结构 2横排紧凑
                    'forms_title_s'=> 'title1',  //表单版本标题样式 title1上下结构  title2左右结构
                    'forms_head'=> 'slide',  //表单页面顶部样式 header默认样式 slide幻灯片[纯图] newslide幻灯片[带链接] pic自定义内容 none不显示
                    'forms_name'=> '预约看房', //表单名称
                    'forms_ename'=> '', //表单英文名称
                    'forms_inps'=> 0,    //输入框提示语 1显示 0隐藏
                    'subtime'=> 2,      //提交间隔时间
                    'forms_btn'=> '提交',  //按钮文字
                    'success'=> '您已预约成功！',  //提交成功提示
                    'name'=> '姓名',  //文本输入框1
                    'name_must'=> 1,  //文本输入框1 1必填
                    'tel'=> '电话',   //文本输入框2
                    'tel_use'=> 1,  //文本输入框2 1启用
                    'tel_must'=> 1, //文本输入框2 1必填
                    'tel_i'=> 1, //文本输入框2 1必填
                    'single_n'=>'预算',  //单选1 文本
                    'single_num'=>2,   //单选1  每排数量
                    'single_use'=>1,   //单选1启用  
                    'single_use'=>1,   //单选1启用  
                    'single_i'=>1,   //单选1必填  
                    'single_v'=>'5000以下/平,5000-8000/平,8000-10000/平,10000以上/平',
                    'content_n'=> '其他需求', //多行文本
                    'content_use'=> 1, //多行文本 1启用
                    // 'content_must'=> 1, //多行文本 1必填
                    'content_i'=> 1, //多行文本 1必填
                );
                $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($froms['uniacid'])) {
                    pdo_insert('sudu8_page_forms_config', $dataForms);
                } else {
                    pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                }
                //基础信息
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:2:{i:0;s:52:"http://p2bwp6sww.bkt.clouddn.com/fangchan/slide1.jpg";i:1;s:52:"http://p2bwp6sww.bkt.clouddn.com/fangchan/slide2.jpg";}',  //幻灯片
                        'banner'=>'',  //门店背景
                        'logo'=>'',  //logo
                        'video'=>'', //视频地址
                        'v_img'=>'', //视频图片
                        'name' => '房产在线', 
                        'desc'=>'房产在线',
                        'address' => '南通世纪大道8888号',
                        'time' => '8:30 - 18:00',
                        'tel' => '15111111111',
                        'latitude' => '31.983310',
                        'longitude' => '120.946330',
                        'about' => '房产在线 ',
                        //样式DIY
                        'base_color'=> '#007dd1',  //小程序头底主色
                        'base_tcolor'=> '#ffffff', //小程序头底文字色
                        'base_color2'=> '#007dd1',  //小程序突出颜色
                        'base_color_t'=> '', //默认样式标题颜色 公司介绍页
                        'config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}',
                        'index_style'=> 'slide',//header背景、标题、logo  slide纯幻灯片[基础设置]  newslide新幻灯片[带连接]
                        'tel_box'=> 0,//首页电话、时间区块 1显示 0不显示
                        'aboutCN' => '门店介绍',   //首页介绍板块栏目名
                        'aboutCNen' => 'About Us',//首页介绍板块栏目英文名
                        'index_about_title' => '9', //介绍板块标题样式 title1上下结构 title2左右结构  no不显示标题 9本版块隐藏
                        'catename_x'=> '推荐专区', //横排推荐区中文名
                        'catenameen_x'=> '',//横排推荐区英文名
                        'i_b_x_ts'=>9,//横排推荐去标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'i_b_x_iw'=> 600,//图片宽度
                        'catename'=>'推荐楼盘', //竖排推荐区中文名
                        'catenameen'=>'', //竖排推荐区英文名
                        'i_b_y_ts'=> 9,//介绍板块标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'index_pro_lstyle'=> 2,//竖排推荐区列表样式 1单行大图 2两列图片  3三列图片 8单行图文、带简介  3单行图文、带简介、时间、阅读量  4 纯标题样式   list_pic2 老版本修复【小程序版本低于6.0.8】
                        'index_pro_ts_al'=>'tc', //竖排推荐区列表标题 t1【无背景】标题左对齐  tc【无背景】标题居中下方 tlb【透明背景】标题左对齐底部  tcb【透明背景】标题居中底部  none不显示标题
                        'c_b_bg'=> 'http://p2bwp6sww.bkt.clouddn.com/fangchan/server.jpg', //服务中心背景图
                        'c_b_btn'=> 0,//服务中心按钮样式 1彩色实心 2白色边框 0首页隐藏
                        'form_index'=> 1,//首页表单  1开启 0不
                        'c_title'=> 0,//内页样式DIY 1带时间标题 2纯标题 0隐藏
                        // 'footer_style'=>'footer1',//老版本修复  底部导航 footer1首页-电话-客服-导航 footer1首页-电话-预约-导航 footer3首页-介绍-服务-预约  none不显示
                        'tabbar_t'=>1, //启用底部菜单tabbar 1启用 0不
                        'tabbar_bg'=>'#fff', //tabbar背景颜色
                        'color_bar'=>'#ccc',//tabbar顶部横线颜色
                        'tabbar_tc'=>'',//tabbar文字颜色
                        'tabbar_tca'=>'#1c87d8',//选中颜色
                        'tabbar'=>'a:3:{i:0;s:215:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:53:"http://p2bwp6sww.bkt.clouddn.com/fangchan/tabbar1.png";s:9:"tabbar_p2";s:53:"http://p2bwp6sww.bkt.clouddn.com/fangchan/tabbar1.png";}";i:1;s:221:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:12:"预约看房";s:9:"tabbar_p1";s:53:"http://p2bwp6sww.bkt.clouddn.com/fangchan/tabbar2.png";s:9:"tabbar_p2";s:53:"http://p2bwp6sww.bkt.clouddn.com/fangchan/tabbar2.png";}";i:2;s:220:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:12:"联系我们";s:9:"tabbar_p1";s:53:"http://p2bwp6sww.bkt.clouddn.com/fangchan/tabbar3.png";s:9:"tabbar_p2";s:53:"http://p2bwp6sww.bkt.clouddn.com/fangchan/tabbar3.png";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
                    //基础信息》开屏广告  type=bigad
                    // $cateBanner1 = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type='bigad'", array(':uniacid' => $uniacid));  //阳台系列
                    // if(empty($cateBanner1)){
                    //     $dataCateBanner1 = array(
                    //         'uniacid' => $uniacid,
                    //         'num'=>99,          //序号
                    //         'type'=> 'bigad',   //类型  banner幻灯片 bigad开屏广告  miniad谈窗广告  indexad首页广告
                    //         'pic'=>'http://p2bwp6sww.bkt.clouddn.com/jiaju/kaipin.png',//开屏图片
                    //         'url'=>'',  //链接地址
                    //         'flag'=>1,  //flag  1启用 0不
                    //         'descp'=>'',//简介  
                    //     );
                    //     pdo_insert('sudu8_page_banner', $dataCateBanner1);
                    // }
                    // $cateBanner2 = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type='miniad'", array(':uniacid' => $uniacid));  
                    // if(empty($cateBanner2)){
                    //     $dataCateBanner1 = array(
                    //         'uniacid' => $uniacid,
                    //         'num'=>99,          //序号
                    //         'type'=> 'miniad',   //类型  banner幻灯片 bigad开屏广告  miniad谈窗广告  indexad首页广告
                    //         'flag'=>1,  //flag  1启用 0不
                    //         'pic'=>'http://p2bwp6sww.bkt.clouddn.com/jiaju/tanchuang.jpg',//开屏图片
                    //         'url'=>'/sudu8_page/listPro/listPro?cid='.$dataCateTopPro1Id,  //链接地址
                    //         'descp'=>'全部产品',//简介  
                    //     );
                    //     pdo_insert('sudu8_page_banner', $dataCateBanner1);
                    // }
            }elseif($making_tmp == 6){
                //建立顶级商品栏目
                $cateTopPro = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $cateTopProNum = count($cateTopPro);
                $dataCateTopPro1 = array(
                'uniacid' => $uniacid,
                'num' => 999,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '洛阳线路',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/nav1.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro2 = array(
                'uniacid' => $uniacid,
                'num' => 99,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '国内线路',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/nav2.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro3 = array(
                'uniacid' => $uniacid,
                'num' => 98,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '出境线路',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/nav3.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro4 = array(
                'uniacid' => $uniacid,
                'num' => 97,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '研学线路',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/nav4.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro5 = array(
                'uniacid' => $uniacid,
                'num' => 96,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '出国签证',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/nav5.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro6 = array(
                'uniacid' => $uniacid,
                'num' => 95,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '积分兑换区',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                if ($cateTopProNum == 0) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPro1);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro2);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro3);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro4);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro5);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro6);
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    $dataCateTopPro2Id = $dataCateTopProAll[1]['id'];
                    $dataCateTopPro3Id = $dataCateTopProAll[2]['id'];
                    $dataCateTopPro4Id = $dataCateTopProAll[3]['id'];
                    $dataCateTopPro5Id = $dataCateTopProAll[4]['id'];
                    $dataCateTopPro6Id = $dataCateTopProAll[5]['id'];
                } else {
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    $dataCateTopPro2Id = $dataCateTopProAll[1]['id'];
                    $dataCateTopPro3Id = $dataCateTopProAll[2]['id'];
                    $dataCateTopPro4Id = $dataCateTopProAll[3]['id'];
                    $dataCateTopPro5Id = $dataCateTopProAll[4]['id'];
                    $dataCateTopPro6Id = $dataCateTopProAll[5]['id'];
                    pdo_update('sudu8_page_cate', $dataCateTopPro1 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro1Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro2 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro2Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro3 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro3Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro4 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro4Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro5 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro5Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro6 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro6Id));
                }
                //建立导航（首页导航栏）
                $dataNav = array(
                    'url'=>$dataCateTopPro1Id.",".$dataCateTopPro2Id.",".$dataCateTopPro3Id.",".$dataCateTopPro4Id.",".$dataCateTopPro5Id,  //导航栏目
                    'uniacid' => $uniacid,
                    'statue'=>1,  //首页导航模块  0不启用 1启用栏目导航 2启用自定义导航
                    'name_s'=>0,    //图标名称板块是否显示  0显示 1不显示
                    'box_p_tb'=>2,  //导航上下边距
                    'box_p_lr'=>1,  //导航左右边距
                    'number'=>5,    //每排显示数量
                    'img_size'=>80, //图标占比
                    'title_position'=>0, //1文字在下方,无背景 2文字在底部，半透明背景  3文字左上角，半透明背景  0文字不显示
                );
                if (empty($dataNavCon['uniacid'])) {
                    pdo_insert('sudu8_page_nav', $dataNav);
                } else {
                    pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                }
                //添加商品
                $cateProCon1 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro1Id));  //所有产品
                $cateProCon1Num = count($cateProCon1);
                if($cateProCon1Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro1.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:51:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro1.jpg";}',   //商品主图
                        'labels'=> '洛阳',   //商品标签
                        'title'=> '云台山两日游', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon2 = array(
                        'uniacid' => $uniacid,
                        'num' => 94,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>1,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>388,      //门店价
                        'market_price'=>388, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro2.jpg',  //缩略图
                        'text'=> 'a:2:{i:0;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro2_slide1.jpg";i:1;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro2_slide2.jpg";}',   //商品主图
                        'labels'=> '洛阳',   //商品标签
                        'title'=> '龙门石窟少林寺一日游', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon3 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro2Id,   //父级栏目
                        'pcid'=> $dataCateTopPro2Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>1,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>5880,      //门店价
                        'market_price'=>5880, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro3.jpg',  //缩略图
                        'text'=> 'a:2:{i:0;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro3_slide1.jpg";i:1;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro3_slide2.jpg";}',   //商品主图
                        'labels'=> '海口',   //商品标签
                        'title'=> '【春节】洛阳直飞海口【五星盛宴】双飞5天/6天', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon4 = array(
                        'uniacid' => $uniacid,
                        'num' => 92,
                        'cid'=> $dataCateTopPro2Id,   //父级栏目
                        'pcid'=> $dataCateTopPro2Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>1,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>1780,      //门店价
                        'market_price'=>1780, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro4.jpg',  //缩略图
                        'text'=> 'a:3:{i:0;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro4_slide1.jpg";i:1;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro4_slide2.jpg";i:2;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro4_slide3.jpg";}',   //商品主图
                        'labels'=> '东北',   //商品标签
                        'title'=> '【东北】初遇雪乡双卧八日游', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon5 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro3Id,   //父级栏目
                        'pcid'=>$dataCateTopPro3Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>1,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>1,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=>1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>15800,      //门店价
                        'market_price'=>15800, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro5.jpg',  //缩略图
                        'text'=> 'a:3:{i:0;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro5_slide1.jpg";i:1;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro5_slide2.jpg";i:2;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro5_slide3.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '美国东西海岸+大瀑布+夏威夷14天', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon6 = array(
                        'uniacid' => $uniacid,
                        'num' => 95,
                        'cid'=> $dataCateTopPro3Id,   //父级栏目
                        'pcid'=>$dataCateTopPro3Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=>1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>4080,      //门店价
                        'market_price'=>4080, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro6.jpg',  //缩略图
                        'text'=> 'a:3:{i:0;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro6_slide1.jpg";i:1;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro6_slide2.jpg";i:2;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro6_slide3.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> ' 泰新马三飞11天', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon7 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro4Id,   //父级栏目
                        'pcid'=>$dataCateTopPro4Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>1,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>1,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=>1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>1480,      //门店价
                        'market_price'=>1480, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro7.jpg',  //缩略图
                        'text'=> 'a:2:{i:0;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro7_slide1.jpg";i:1;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro7_slide2.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '洛阳 登封 开封中原文化研学五日游', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon8 = array(
                        'uniacid' => $uniacid,
                        'num' => 95,
                        'cid'=> $dataCateTopPro4Id,   //父级栏目
                        'pcid'=>$dataCateTopPro4Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=>1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>1060,      //门店价
                        'market_price'=>1060, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro8.jpg',  //缩略图
                        'text'=> 'a:3:{i:0;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro8_slide1.jpg";i:1;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro8_slide2.jpg";i:2;s:58:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro8_slide3.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '魅力古都西安文化研学三日游', //产品标题
                        'desc'=> '概述：西安国家历史文化名城，历史上有周、秦、汉、隋、唐等在内的13个朝代在此建都，曾经作为中国首都和政治、经济、文化中心长达1100多年，7000年前的仰韶文化。', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon9 = array(
                        'uniacid' => $uniacid,
                        'num' => 95,
                        'cid'=> $dataCateTopPro6Id,   //父级栏目
                        'pcid'=>$dataCateTopPro6Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=>1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>15,      //门店价
                        'market_price'=>15, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro9.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:51:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro9.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '小草莓变色唇膏', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon10 = array(
                        'uniacid' => $uniacid,
                        'num' => 95,
                        'cid'=> $dataCateTopPro6Id,   //父级栏目
                        'pcid'=>$dataCateTopPro6Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=>1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro10.jpg',  //缩略图
                        'text'=> 'a:2:{i:0;s:59:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro10_slide1.jpg";i:1;s:59:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/pro10_slide2.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '美容乳胶枕', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                    pdo_insert('sudu8_page_products', $dataProCon2);
                    pdo_insert('sudu8_page_products', $dataProCon3);
                    pdo_insert('sudu8_page_products', $dataProCon4);
                    pdo_insert('sudu8_page_products', $dataProCon5);
                    pdo_insert('sudu8_page_products', $dataProCon6);
                    pdo_insert('sudu8_page_products', $dataProCon7);
                    pdo_insert('sudu8_page_products', $dataProCon8);
                    pdo_insert('sudu8_page_products', $dataProCon9);
                    pdo_insert('sudu8_page_products', $dataProCon10);
                }
                //基础信息》公司介绍页
                // $dataAbout = array(
                //     'uniacid' => $uniacid,
                //     'header'=>1,  //页顶部样式  1背景、标题、logo 2幻灯片[纯图]  3幻灯片[带链接]  0不行=显示
                //     'tel_box'=>1, //电话、时间区块  1显示 0隐藏
                //     'serv_box'=>1, //服务中心板块 1彩色实心  2白色边框  0本版块隐藏
                //     'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',  //内容
                // );
                // $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                // if (empty($about['uniacid'])) {
                //     pdo_insert('sudu8_page_about', $dataAbout);
                // } else {
                //     pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
                // }
                $dataForms = array(
                    'uniacid' => $uniacid,
                    'forms_style'=> 1,   //表单样式 1上线结构 2横排紧凑
                    'forms_title_s'=> 'title1',  //表单版本标题样式 title1上下结构  title2左右结构
                    'forms_head'=> 'header',  //表单页面顶部样式 header默认样式 slide幻灯片[纯图] newslide幻灯片[带链接] pic自定义内容 none不显示
                    'forms_name'=> '预约', //表单名称
                    'forms_ename'=> '', //表单英文名称
                    'forms_inps'=> 1,    //输入框提示语 1显示 0隐藏
                    'subtime'=> 2,      //提交间隔时间
                    'forms_btn'=> '提交',  //按钮文字
                    'success'=> '您已预约成功！',  //提交成功提示
                    'name'=> '姓名',  //文本输入框1
                    'name_must'=> 1,  //文本输入框1 1必填
                    'tel'=> '电话',   //文本输入框2
                    'tel_use'=> 1,  //文本输入框2 1启用
                    'tel_must'=> 1, //文本输入框2 1必填
                    'wechat'=>'成年人数', //文本输入框3 
                    'wechat_use'=> 1,//文本输入框3 1启用
                    'address'=>"1.2米以下儿童人数",//文本输入框3 1必填
                    'address_use'=>1,//文本输入框3 1必填
                    'date'=>"出行日期",//文本输入框3 1必填
                    'date_use'=>1,//文本输入框3 1必填
                    'single_n'=>"信息咨询",//文本输入框3 1必填
                    'single_num'=>3,//文本输入框3 1必填
                    'single_use'=>3,//文本输入框3 1必填
                    'single_v'=>"洛阳线路,出境线路,国内线路,研学线路,旅游签证",//文本输入框3 1必填
                    'content_n'=> '备注', //多行文本
                    'content_use'=> 1, //多行文本 1启用
                    // 'content_must'=> 1, //多行文本 1必填
                );
                $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($froms['uniacid'])) {
                    pdo_insert('sudu8_page_forms_config', $dataForms);
                } else {
                    pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                }
                //基础信息
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:1:{i:0;s:53:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/slide1.jpg";}',  //幻灯片
                        'banner'=>'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/logo_bg.jpg',  //门店背景
                        'logo'=>'http://p2bwp6sww.bkt.clouddn.com/lvxingshe/logo.jpg',  //logo
                        'name' => '旅行社',
                        'desc'=>'旅行社',   //门店特色
                        'address' => '南通世纪大道8888号',
                        'time' => '8:30 - 18:00',
                        'tel' => '15111111111',
                        'latitude' => '31.983310',
                        'longitude' => '120.946330',
                        'about' => '你身边的旅游管家，个性化私人定制！平民化消费线路！',
                        //样式DIY
                        'base_color'=> '#4aa500',  //小程序头底主色
                        'base_tcolor'=> '#ffffff', //小程序头底文字色
                        'base_color2'=> '#4aa500',  //小程序突出颜色
                        'base_color_t'=> '#ffcf3d', //默认样式标题颜色 公司介绍页
                        'config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}',
                        'index_style'=> 'slide',//header背景、标题、logo  slide纯幻灯片[基础设置]  newslide新幻灯片[带连接]
                        'tel_box'=> 0,//首页电话、时间区块 1显示 0不显示
                        'aboutCN' => '公司介绍',   //首页介绍板块栏目名
                        'aboutCNen' => 'About Company',//首页介绍板块栏目英文名
                        'index_about_title' => '9', //介绍板块标题样式 title1上下结构 title2左右结构  no不显示标题 9本版块隐藏
                        'catename_x'=> '特价线路', //横排推荐区中文名
                        'catenameen_x'=> 'Special line',//横排推荐区英文名
                        'i_b_x_ts'=>1,//横排推荐去标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'i_b_x_iw'=> 235,//图片宽度
                        'catename'=>'春节热门线路', //竖排推荐区中文名
                        'catenameen'=>'', //竖排推荐区英文名
                        'i_b_y_ts'=> 1,//介绍板块标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'index_pro_lstyle'=> 2,//竖排推荐区列表样式 1单行大图 2两列图片  3三列图片 8单行图文、带简介  3单行图文、带简介、时间、阅读量  4 纯标题样式   list_pic2 老版本修复【小程序版本低于6.0.8】
                        'index_pro_ts_al'=>'tc', //竖排推荐区列表标题 t1【无背景】标题左对齐  tc【无背景】标题居中下方 tlb【透明背景】标题左对齐底部  tcb【透明背景】标题居中底部  none不显示标题
                        'c_b_bg'=> '', //服务中心背景图
                        'c_b_btn'=> 0,//服务中心按钮样式 1彩色实心 2白色边框 0首页隐藏
                        'form_index'=> 0,//首页表单  1开启 0不
                        'c_title'=> 2,//内页样式DIY 1带时间标题 2纯标题 0隐藏
                        // 'footer_style'=>'footer1',//老版本修复  底部导航 footer1首页-电话-客服-导航 footer1首页-电话-预约-导航 footer3首页-介绍-服务-预约  none不显示
                        //底部菜单栏
                        'tabbar_t'=>1, //启用底部菜单tabbar 1启用 0不
                        // 'tabbar_bg'=>'#d40f33', //tabbar背景颜色
                        'color_bar'=>'#cccccc',//tabbar顶部横线颜色
                        'tabbar_tc'=>'#222222',//tabbar文字颜色
                        'tabbar_tca'=>'#4aa500',//选中颜色
                        'tabbar'=>'a:5:{i:0;s:219:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:54:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/tabbar1.png";s:9:"tabbar_p2";s:56:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/tabbar1_h.png";}";i:1;s:218:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:6:"预约";s:9:"tabbar_p1";s:54:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/tabbar2.png";s:9:"tabbar_p2";s:56:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/tabbar2_h.png";}";i:2;s:222:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:12:"电话预订";s:9:"tabbar_p1";s:54:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/tabbar3.png";s:9:"tabbar_p2";s:54:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/tabbar4.png";}";i:3;s:215:"a:4:{s:8:"tabbar_l";s:3:"map";s:8:"tabbar_t";s:6:"导航";s:9:"tabbar_p1";s:54:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/tabbar4.png";s:9:"tabbar_p2";s:54:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/tabbar4.png";}";i:4;s:232:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:54:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/tabbar5.png";s:9:"tabbar_p2";s:56:"http://p2bwp6sww.bkt.clouddn.com/lvxingshe/tabbar5_h.png";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
            }elseif($making_tmp == 7){
                  //建立顶级图片栏目
                $cateTopPic = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid=0 ", array(':uniacid' => $uniacid));
                $dataCateTopPic = array(
                'uniacid' => $uniacid,
                'num' => 97,
                'type' => 'showPic',
                'statue' => 1,
                'cid' => 0,
                'name' => '榜样学员',
                'ename' => 'Successful students',
                'name_n' => '',
                'show_i' => 1,
                'list_tstyle' => 2,
                'list_tstylel' => 0,
                'list_type' => 1,
                'list_style' => 5,
                'list_stylet' => 'tc',
                'pic_page_btn'=>0,
                );
                if (empty($cateTopPic['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPic);
                } else {
                    pdo_update('sudu8_page_cate', $dataCateTopPic ,array('uniacid' => $uniacid,'id'=>$cateTopPic['id']));
                }
                $dataCateTopPic = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopPicId = $dataCateTopPic['id'];  //组图顶级栏目id
                //建立顶级商品栏目
                $cateTopPro = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $cateTopProNum = count($cateTopPro);
                $dataCateTopPro = array(
                'uniacid' => $uniacid,
                'num' => 999,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '精品课程',
                'ename' => 'Excellent course',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/peixun/nav1.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 11,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                if ($cateTopProNum == 0) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPro);
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                } else {
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    pdo_update('sudu8_page_cate', $dataCateTopPro ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro1Id));
                }
                 //建立顶级文章栏目
                $cateTopArt = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArt1 = array(
                'uniacid' => $uniacid,
                'num' => 999,               //排序
                'type' => 'showArt',      //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,            //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '名师风采',     //栏目名称
                'ename' => 'Famous teachers', //栏目英文名称
                'name_n' => '',   //首页导航栏标题
                'catepic' =>'',             //栏目缩略图链接
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 5,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"1";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                );
                $dataCateTopArt2 = array(
                'uniacid' => $uniacid,
                'num' => 99,               //排序
                'type' => 'showArt',      //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,            //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '公司动态',     //栏目名称
                'ename' => 'News feed', //栏目英文名称
                'name_n' => '',   //首页导航栏标题
                'catepic' =>'',             //栏目缩略图链接
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 3,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介  3单行图文、带简介、时间、阅读量  4纯标题样式
                'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"1";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                );
                if (empty($CateTopArt['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopArt1);
                    pdo_insert('sudu8_page_cate', $dataCateTopArt2);
                }else{
                    pdo_update('sudu8_page_cate', $dataCateTopArt1 ,array('uniacid' => $uniacid,'id'=>$CateTopArt[0]['id']));
                    pdo_update('sudu8_page_cate', $dataCateTopArt2 ,array('uniacid' => $uniacid,'id'=>$CateTopArt[1]['id']));
                }
                $dataCateTopArt = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArt1Id = $dataCateTopArt[0]['id']; //顶级栏目名师风采栏目id
                $dataCateTopArt2Id = $dataCateTopArt[1]['id']; //顶级栏目公司动态栏目id
                //建立顶级单页面栏目
                $CatePage = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='page' AND cid=0", array(':uniacid' => $uniacid));
                $dataCatePage1 = array(
                'uniacid' => $uniacid,
                'num' => 99,     //排序
                'type' => 'page',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '公司简介',
                'ename' => '',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/peixun/nav1.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,    //1首页显示  0不显示
                // 'list_style' => 2,           
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'content' => "此处是栏目内容",         //栏目内容
                );
                if (empty($CatePage['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCatePage1);     
                }
                //建立自定义导航
                $navList = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_navlist')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if(empty($navList)){
                    $dataNavList1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/peixun/nav1.png',  //导航图标
                        'title' => '关于我们',  //导航标题
                        'url' => '/sudu8_page/about/about', //导航链接
                    );
                    $dataNavList2 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/peixun/nav2.png',
                        'title' => '课程挑选',
                        'url' => '/sudu8_page/listPro/listPro?cid='.$dataCateTopPro1Id,
                    );
                    $dataNavList3 = array(
                        'uniacid' => $uniacid,
                        'num' => 97,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/peixun/nav3.png',
                        'title' => '优惠券',
                        'url' => '/sudu8_page/coupon/coupon',
                    );
                    $dataNavList4 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 1,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/peixun/nav4.png',
                        'title' => '联系我们',
                        'url' => '',
                    );
                    pdo_insert('sudu8_page_navlist', $dataNavList1);  
                    pdo_insert('sudu8_page_navlist', $dataNavList2);  
                    pdo_insert('sudu8_page_navlist', $dataNavList3);  
                    pdo_insert('sudu8_page_navlist', $dataNavList4);  
                }
                //建立导航（首页导航栏）
                $dataNav = array(
                    'url'=>'',  //导航栏目
                    'uniacid' => $uniacid,
                    'statue'=>2,  //首页导航模块  0不启用 1启用栏目导航 2启用自定义导航
                    'name_s'=>1,    //图标名称板块是否显示  0显示 1不显示
                    'box_p_tb'=>4,  //导航上下边距
                    'box_p_lr'=>1,  //导航左右边距
                    'number'=>4,    //每排显示数量
                    'img_size'=>60, //图标占比
                    'title_position'=>1, //1文字在下方,无背景 2文字在底部，半透明背景  3文字左上角，半透明背景  0文字不显示
                    'title_color' => '#222222', //标题颜色
                );
                if (empty($dataNavCon['uniacid'])) {
                    pdo_insert('sudu8_page_nav', $dataNav);
                } else {
                    pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                }
                //添加商品
                $cateProCon1 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro1Id));  //所有产品
                $cateProCon1Num = count($cateProCon1);
                if($cateProCon1Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/pro1.png',  //缩略图
                        'text'=> 'a:1:{i:0;s:48:"http://p2bwp6sww.bkt.clouddn.com/peixun/pro1.png";}',   //商品主图
                        'labels'=> '期末,小学,名师',   //商品标签
                        'title'=> '期末数学冲刺课', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon2 = array(
                        'uniacid' => $uniacid,
                        'num' => 94,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>1,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>388,      //门店价
                        'market_price'=>388, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/pro2.jpg',  //缩略图
                        'text'=> 'a:2:{i:0;s:55:"http://p2bwp6sww.bkt.clouddn.com/peixun/pro2_slide1.jpg";i:1;s:55:"http://p2bwp6sww.bkt.clouddn.com/peixun/pro2_slide2.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '6人团包半价', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                    pdo_insert('sudu8_page_products', $dataProCon2);
                }
                 //添加组图
                $catePicCon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPic' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPicId));
                $catePicConNum = count($catePicCon);
                if($catePicConNum == 0){
                    $dataPicCon1 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPicId,
                        'pcid'=> $dataCateTopPicId,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '高考案例：谢轩考入中山大学',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/pic1.png',
                        'text'=> 'a:1:{i:0;s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/pic1_p1.png";}',
                    );
                    $dataPicCon2 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPicId,
                        'pcid'=> $dataCateTopPicId,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '高考案例：吴恩培考入中山大学',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/pic2.png',
                        'text'=> 'a:1:{i:0;s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/pic1_p1.png";}',
                    );
                    $dataPicCon3 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPicId,
                        'pcid'=> $dataCateTopPicId,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '高考案例：谢虹考入中山大学',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/pic3.png',
                        'text'=> 'a:1:{i:0;s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/pic1_p1.png";}',
                    );
                    pdo_insert('sudu8_page_products', $dataPicCon1);
                    pdo_insert('sudu8_page_products', $dataPicCon2);
                    pdo_insert('sudu8_page_products', $dataPicCon3);
                }
                  //添加文章
                $cateArt1Con = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showArt' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopArt1Id));
                $cateArtCon1Num = count($cateArt1Con);
                if($cateArtCon1Num == 0){
                    $dataArtCon1 = array(
                        'uniacid' => $uniacid,
                        'num'=>999,
                        'cid'=> $dataCateTopArt1Id,
                        'pcid'=> $dataCateTopArt1Id,
                        'type'=> 'showArt',
                        'type_i'=> 1,
                        'title'=> '白老师',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/art1.jpg',
                        'desc'=> '',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon2 = array(
                        'uniacid' => $uniacid,
                        'num'=>99,
                        'cid'=> $dataCateTopArt1Id,
                        'pcid'=> $dataCateTopArt1Id,
                        'type'=> 'showArt',
                        'type_i'=> 1,
                        'title'=> '封老师',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/art2.jpg',
                        'desc'=> '',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon3 = array(
                        'uniacid' => $uniacid,
                        'num'=>98,
                        'cid'=> $dataCateTopArt1Id,
                        'pcid'=> $dataCateTopArt1Id,
                        'type'=> 'showArt',
                        'type_i'=> 1,
                        'title'=> '秋老师',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/art3.jpg',
                        'desc'=> '',
                        'text'=> '这里是文章内容',
                    );
                    pdo_insert('sudu8_page_products', $dataArtCon1);
                    pdo_insert('sudu8_page_products', $dataArtCon2);
                    pdo_insert('sudu8_page_products', $dataArtCon3);
                }
               $cateArt2Con = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showArt' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopArt2Id));
                $cateArtCon2Num = count($cateArt2Con);
                if($cateArtCon2Num == 0){
                    $dataArtCon1 = array(
                        'uniacid' => $uniacid,
                        'num'=>999,
                        'cid'=> $dataCateTopArt2Id,
                        'pcid'=> $dataCateTopArt2Id,
                        'type'=> 'showArt',
                        'type_i'=> 1,
                        'title'=> '品牌数学寒假班课接受报名啦！',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/art4.jpg',
                        'desc'=> '品牌数学寒假课程 ，倾注全部人力物力打造的名师课程，全体骨干老师整合全年级常年教育资源和成果，并采取连续紧凑的教学模式，通过科学教学于帮助孩子提前预习课本知识和提升学习主动性，为新学期打下坚实基础。',
                        'text'=> '这里是文章内容',
                    );
                    pdo_insert('sudu8_page_products', $dataArtCon1);
                }
               // 基础信息》公司介绍页
                $dataAbout = array(
                    'uniacid' => $uniacid,
                    'header'=>1,  //页顶部样式  1背景、标题、logo 2幻灯片[纯图]  3幻灯片[带链接]  0不行=显示
                    'tel_box'=>1, //电话、时间区块  1显示 0隐藏
                    'serv_box'=>1, //服务中心板块 1彩色实心  2白色边框  0本版块隐藏
                    'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',  //内容
                );
                $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($about['uniacid'])) {
                    pdo_insert('sudu8_page_about', $dataAbout);
                } else {
                    pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
                }
                //表单
                $dataForms = array(
                    'uniacid' => $uniacid,
                    'forms_style'=> 2,   //表单样式 1上线结构 2横排紧凑
                    'forms_title_s'=> 'title1',  //表单版本标题样式 title1上下结构  title2左右结构
                    'forms_head'=> 'none',  //表单页面顶部样式 header默认样式 slide幻灯片[纯图] newslide幻灯片[带链接] pic自定义内容 none不显示
                    'forms_name'=> '自助预约', //表单名称
                    'forms_ename'=> 'Self Booking', //表单英文名称
                    'forms_inps'=> 0,    //输入框提示语 1显示 0隐藏
                    'subtime'=> 2,      //提交间隔时间
                    'forms_btn'=> '立即预约',  //按钮文字
                    'success'=> '您已预约成功！',  //提交成功提示
                    'name'=> '姓名',  //文本输入框1
                    'name_must'=> 1,  //文本输入框1 1必填
                    'tel'=> '联系电话',   //文本输入框2
                    'tel_use'=> 1,  //文本输入框2 1启用
                    'tel_must'=> 1, //文本输入框2 1必填
                    'wechat'=>'年纪', //文本输入框3 
                    'wechat_use'=> 1,//文本输入框3 1启用
                    'date'=>"预约日期",//文本输入框3 1必填
                    'date_use'=>1,//文本输入框3 1必填
                    'time'=>'预约时间',//时间
                    'time_use'=>1,//时间
                    'checkbox_n'=>"课程选择",//文本输入框3 1必填
                    'checkbox_num'=>2,
                    'checkbox_use'=>1,
                    'checkbox_v'=>"小学奥数,初中理科,高中理科,免费试听",//文本输入框3 1必填
                    'content_n'=> '备注', //多行文本
                    'content_use'=> 1, //多行文本 1启用
                    // 'content_must'=> 1, //多行文本 1必填
                );
                $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($froms['uniacid'])) {
                    pdo_insert('sudu8_page_forms_config', $dataForms);
                } else {
                    pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                }
                //基础信息
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:2:{i:0;s:50:"http://p2bwp6sww.bkt.clouddn.com/peixun/slide1.jpg";i:1;s:50:"http://p2bwp6sww.bkt.clouddn.com/peixun/slide2.jpg";}',  //幻灯片
                        'banner'=>'http://p2bwp6sww.bkt.clouddn.com/peixun/logo_bg.jpg',  //门店背景
                        'logo'=>'http://p2bwp6sww.bkt.clouddn.com/peixun/logo.png',  //logo
                        'name' => '教育培训',
                        'desc'=>'教育培训',   //门店特色
                        'address' => '南通世纪大道8888号',
                        'time' => '8:30 - 18:00',
                        'tel' => '15111111111',
                        'latitude' => '31.983310',
                        'longitude' => '120.946330',
                        'about' => '教育培训教育培训',
                        //样式DIY
                        'base_color'=> '#007deb',  //小程序头底主色
                        'base_tcolor'=> '#ffffff', //小程序头底文字色
                        'base_color2'=> '#007deb',  //小程序突出颜色
                        'base_color_t'=> '#ffcf3d', //默认样式标题颜色 公司介绍页
                        'config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}',
                        'index_style'=> 'slide',//header背景、标题、logo  slide纯幻灯片[基础设置]  newslide新幻灯片[带连接]
                        'tel_box'=> 0,//首页电话、时间区块 1显示 0不显示
                        'aboutCN' => '教育简介',   //首页介绍板块栏目名
                        'aboutCNen' => 'About Company',//首页介绍板块栏目英文名
                        'index_about_title' => 'title2', //介绍板块标题样式 title1上下结构 title2左右结构  no不显示标题 9本版块隐藏
                        'catename_x'=> '特价线路', //横排推荐区中文名
                        'catenameen_x'=> 'Special line',//横排推荐区英文名
                        'i_b_x_ts'=>9,//横排推荐去标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'i_b_x_iw'=> 235,//图片宽度
                        'catename'=>'春节热门线路', //竖排推荐区中文名
                        'catenameen'=>'', //竖排推荐区英文名
                        'i_b_y_ts'=> 9,//竖排
                        'index_pro_lstyle'=> 2,//竖排推荐区列表样式 1单行大图 2两列图片  3三列图片 8单行图文、带简介  3单行图文、带简介、时间、阅读量  4 纯标题样式   list_pic2 老版本修复【小程序版本低于6.0.8】
                        'index_pro_ts_al'=>'tc', //竖排推荐区列表标题 t1【无背景】标题左对齐  tc【无背景】标题居中下方 tlb【透明背景】标题左对齐底部  tcb【透明背景】标题居中底部  none不显示标题
                        'c_b_bg'=> '', //服务中心背景图
                        'c_b_btn'=> 0,//服务中心按钮样式 1彩色实心 2白色边框 0首页隐藏
                        'form_index'=> 0,//首页表单  1开启 0不
                        'c_title'=> 1,//内页样式DIY 1带时间标题 2纯标题 0隐藏
                        // 'footer_style'=>'footer1',//老版本修复  底部导航 footer1首页-电话-客服-导航 footer1首页-电话-预约-导航 footer3首页-介绍-服务-预约  none不显示
                        //底部菜单栏
                        'tabbar_t'=>1, //启用底部菜单tabbar 1启用 0不
                        // 'tabbar_bg'=>'#d40f33', //tabbar背景颜色
                        'color_bar'=>'#ffffff',//tabbar顶部横线颜色
                        'tabbar_tc'=>'#000000',//tabbar文字颜色
                        'tabbar_tca'=>'#ff0a0a',//选中颜色
                        'tabbar'=>'a:5:{i:0;s:211:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/tabbar1.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/tabbar1.png";}";i:1;s:207:"a:4:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:6:"课程";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/tabbar2.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/tabbar2.png";}";i:2;s:210:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:6:"预约";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/tabbar3.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/tabbar3.png";}";i:3;s:209:"a:4:{s:8:"tabbar_l";s:3:"map";s:8:"tabbar_t";s:6:"校区";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/tabbar4.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/tabbar4.png";}";i:4;s:224:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/tabbar5.png";s:9:"tabbar_p2";s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/tabbar5.png";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
            }elseif($making_tmp == 8){
                //建立顶级文章栏目
                $cateTopArt = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArt1 = array(
                'uniacid' => $uniacid,
                'num' => 999,               //排序
                'type' => 'showArt',      //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,            //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '花艺',     //栏目名称
                'ename' => 'Famous teachers', //栏目英文名称
                'name_n' => '',   //首页导航栏标题
                'catepic' =>'',             //栏目缩略图链接
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                'list_style' => 6,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                );
                $dataCateTopArt2 = array(
                'uniacid' => $uniacid,
                'num' => 99,               //排序
                'type' => 'showArt',      //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,            //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '花艺展示',     //栏目名称
                'ename' => '', //栏目英文名称
                'name_n' => '',   //首页导航栏标题
                'catepic' =>'',             //栏目缩略图链接
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"3";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                );
                $dataCateTopArt3 = array(
                'uniacid' => $uniacid,
                'num' => 98,               //排序
                'type' => 'showArt',      //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,            //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '花束欣赏',     //栏目名称
                'ename' => '', //栏目英文名称
                'name_n' => '',   //首页导航栏标题
                'catepic' =>'',             //栏目缩略图链接
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"3";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                );
                $dataCateTopArt4 = array(
                'uniacid' => $uniacid,
                'num' => 97,               //排序
                'type' => 'showArt',      //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,            //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '新品推荐',     //栏目名称
                'ename' => '', //栏目英文名称
                'name_n' => '',   //首页导航栏标题
                'catepic' =>'',             //栏目缩略图链接
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"0";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                );
                if (empty($CateTopArt['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopArt1);
                    pdo_insert('sudu8_page_cate', $dataCateTopArt2);
                    pdo_insert('sudu8_page_cate', $dataCateTopArt3);
                    pdo_insert('sudu8_page_cate', $dataCateTopArt4);
                }else{
                    pdo_update('sudu8_page_cate', $dataCateTopArt1 ,array('uniacid' => $uniacid,'id'=>$CateTopArt[0]['id']));
                    pdo_update('sudu8_page_cate', $dataCateTopArt2 ,array('uniacid' => $uniacid,'id'=>$CateTopArt[1]['id']));
                    pdo_update('sudu8_page_cate', $dataCateTopArt3 ,array('uniacid' => $uniacid,'id'=>$CateTopArt[2]['id']));
                    pdo_update('sudu8_page_cate', $dataCateTopArt4 ,array('uniacid' => $uniacid,'id'=>$CateTopArt[3]['id']));
                }
                $dataCateTopArt = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArt1Id = $dataCateTopArt[0]['id']; //顶级栏目名师风采栏目id
                $dataCateTopArt2Id = $dataCateTopArt[1]['id']; //顶级栏目公司动态栏目id
                $dataCateTopArt3Id = $dataCateTopArt[2]['id']; //顶级栏目公司动态栏目id
                $dataCateTopArt4Id = $dataCateTopArt[3]['id']; //顶级栏目公司动态栏目id
                $cateArt1Son = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type='showArt' and cid = :cid ", array(':uniacid' => $uniacid,':cid' => $dataCateTopArt1Id));
                $cateArt1SonNum = count($cateArt1Son);
                //建立子级文章栏目
                if($cateArt1SonNum == 0){
                    $datacateArtS1 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt1Id,
                        'name' => '栏目1',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat1.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS2 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt1Id,
                        'name' => '栏目2',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat2.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS3 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt1Id,
                        'name' => '栏目3',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat3.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS4 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt1Id,
                        'name' => '栏目4',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat4.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    pdo_insert('sudu8_page_cate', $datacateArtS1);
                    pdo_insert('sudu8_page_cate', $datacateArtS2);
                    pdo_insert('sudu8_page_cate', $datacateArtS3);
                    pdo_insert('sudu8_page_cate', $datacateArtS4);
                }
                $cateArt2Son = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type='showArt' and cid = :cid ", array(':uniacid' => $uniacid,':cid' => $dataCateTopArt2Id));
                $cateArt2SonNum = count($cateArt2Son);
                //建立子级文章栏目
                if($cateArt2SonNum == 0){
                    $datacateArtS1 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt2Id,
                        'name' => '百合花',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat5.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS2 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt2Id,
                        'name' => '红玫瑰',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat6.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    pdo_insert('sudu8_page_cate', $datacateArtS1);
                    pdo_insert('sudu8_page_cate', $datacateArtS2);
                }
                $cateArt3Son = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type='showArt' and cid = :cid ", array(':uniacid' => $uniacid,':cid' => $dataCateTopArt3Id));
                $cateArt3SonNum = count($cateArt3Son);
                //建立子级文章栏目
                if($cateArt3SonNum == 0){
                    $datacateArtS1 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt3Id,
                        'name' => '香槟玫瑰',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat7.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS2 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt3Id,
                        'name' => '玫瑰百合',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat8.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    pdo_insert('sudu8_page_cate', $datacateArtS1);
                    pdo_insert('sudu8_page_cate', $datacateArtS2);
                }
                $cateArt4Son = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type='showArt' and cid = :cid ", array(':uniacid' => $uniacid,':cid' => $dataCateTopArt4Id));
                $cateArt4SonNum = count($cateArt4Son);
                //建立子级文章栏目
                if($cateArt4SonNum == 0){
                    $datacateArtS1 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt4Id,
                        'name' => '红玫瑰',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat9.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS2 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt4Id,
                        'name' => '雏菊',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat10.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS3 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt4Id,
                        'name' => '蓝玫瑰',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat11.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    $datacateArtS4 = array(
                        'uniacid' => $uniacid,
                        'num' => 9,
                        'type' => 'showArt',
                        'statue' => 1,
                        'cid' => $dataCateTopArt4Id,
                        'name' => '康乃馨',
                        'ename' => '',
                        'name_n' => '',
                        'catepic'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/cat12.jpg',
                        'show_i' => 1,              //1首页显示  0不显示
                        'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                        'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                        'list_type' => 0,           //列表类型 0显示子分类  1显示内容
                        'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                        'list_stylet' => 'tc',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                        'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                        'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                    );
                    pdo_insert('sudu8_page_cate', $datacateArtS1);
                    pdo_insert('sudu8_page_cate', $datacateArtS2);
                    pdo_insert('sudu8_page_cate', $datacateArtS3);
                    pdo_insert('sudu8_page_cate', $datacateArtS4);
                }
                //建立自定义导航
                // $navList = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_navlist')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                // if(empty($navList)){
                //     $dataNavList1 = array(
                //         'uniacid' => $uniacid,
                //         'num' => 99,  //排序
                //         'flag' => 1,  //启用 1启用 0不
                //         'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                //         'pic' => 'http://p2bwp6sww.bkt.clouddn.com/peixun/nav1.png',  //导航图标
                //         'title' => '关于我们',  //导航标题
                //         'url' => '/sudu8_page/about/about', //导航链接
                //     );
                //     $dataNavList2 = array(
                //         'uniacid' => $uniacid,
                //         'num' => 98,  //排序
                //         'flag' => 1,  //启用 1启用 0不
                //         'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                //         'pic' => 'http://p2bwp6sww.bkt.clouddn.com/peixun/nav2.png',
                //         'title' => '课程挑选',
                //         'url' => '/sudu8_page/listPro/listPro?cid='.$dataCateTopPro1Id,
                //     );
                //     $dataNavList3 = array(
                //         'uniacid' => $uniacid,
                //         'num' => 97,  //排序
                //         'flag' => 1,  //启用 1启用 0不
                //         'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                //         'pic' => 'http://p2bwp6sww.bkt.clouddn.com/peixun/nav3.png',
                //         'title' => '优惠券',
                //         'url' => '/sudu8_page/coupon/coupon',
                //     );
                //     $dataNavList4 = array(
                //         'uniacid' => $uniacid,
                //         'num' => 96,  //排序
                //         'flag' => 1,  //启用 1启用 0不
                //         'type' => 1,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                //         'pic' => 'http://p2bwp6sww.bkt.clouddn.com/peixun/nav4.png',
                //         'title' => '联系我们',
                //         'url' => '',
                //     );
                //     pdo_insert('sudu8_page_navlist', $dataNavList1);  
                //     pdo_insert('sudu8_page_navlist', $dataNavList2);  
                //     pdo_insert('sudu8_page_navlist', $dataNavList3);  
                //     pdo_insert('sudu8_page_navlist', $dataNavList4);  
                // }
                // //建立导航（首页导航栏）
                // $dataNav = array(
                //     'url'=>'',  //导航栏目
                //     'uniacid' => $uniacid,
                //     'statue'=>2,  //首页导航模块  0不启用 1启用栏目导航 2启用自定义导航
                //     'name_s'=>1,    //图标名称板块是否显示  0显示 1不显示
                //     'box_p_tb'=>4,  //导航上下边距
                //     'box_p_lr'=>1,  //导航左右边距
                //     'number'=>4,    //每排显示数量
                //     'img_size'=>60, //图标占比
                //     'title_position'=>1, //1文字在下方,无背景 2文字在底部，半透明背景  3文字左上角，半透明背景  0文字不显示
                //     'title_color' => '#222222', //标题颜色
                // );
                // if (empty($dataNavCon['uniacid'])) {
                //     pdo_insert('sudu8_page_nav', $dataNav);
                // } else {
                //     pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                // }
               //  //添加商品
               //  $cateProCon1 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro1Id));  //所有产品
               //  $cateProCon1Num = count($cateProCon1);
               //  if($cateProCon1Num == 0){
               //      $dataProCon1 = array(
               //          'uniacid' => $uniacid,
               //          'num' => 99,
               //          'cid'=> $dataCateTopPro1Id,   //父级栏目
               //          'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
               //          'type'=> 'showPro',
               //          'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
               //          'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
               //          'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
               //          'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
               //          'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
               //          'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
               //          'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
               //          'buy_type'=>'预约',//购买方式 
               //          'price'=>360,      //门店价
               //          'market_price'=>360, //市场价
               //          'pro_kc'=>500,  //库存
               //          'pro_xz'=>0,    //每人最多买几份
               //          'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/pro1.png',  //缩略图
               //          'text'=> 'a:1:{i:0;s:48:"http://p2bwp6sww.bkt.clouddn.com/peixun/pro1.png";}',   //商品主图
               //          'labels'=> '期末,小学,名师',   //商品标签
               //          'title'=> '期末数学冲刺课', //产品标题
               //          'desc'=> '', //商品简介
               //          'product_txt'=>'这里是商品的详细介绍，可放图文', 
               //      );
               //      $dataProCon2 = array(
               //          'uniacid' => $uniacid,
               //          'num' => 94,
               //          'cid'=> $dataCateTopPro1Id,   //父级栏目
               //          'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
               //          'type'=> 'showPro',
               //          'type_x'=>1,//0不推荐  1推荐  推荐到首页横排
               //          'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
               //          'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
               //          'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
               //          'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
               //          'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
               //          'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
               //          'buy_type'=>'预约',//购买方式 
               //          'price'=>388,      //门店价
               //          'market_price'=>388, //市场价
               //          'pro_kc'=>500,  //库存
               //          'pro_xz'=>0,    //每人最多买几份
               //          'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/pro2.jpg',  //缩略图
               //          'text'=> 'a:2:{i:0;s:55:"http://p2bwp6sww.bkt.clouddn.com/peixun/pro2_slide1.jpg";i:1;s:55:"http://p2bwp6sww.bkt.clouddn.com/peixun/pro2_slide2.jpg";}',   //商品主图
               //          'labels'=> '',   //商品标签
               //          'title'=> '6人团包半价', //产品标题
               //          'desc'=> '', //商品简介
               //          'product_txt'=>'这里是商品的详细介绍，可放图文', 
               //      );
               //      pdo_insert('sudu8_page_products', $dataProCon1);
               //      pdo_insert('sudu8_page_products', $dataProCon2);
               //  }
               //   //添加组图
               //  $catePicCon = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPic' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPicId));
               //  $catePicConNum = count($catePicCon);
               //  if($catePicConNum == 0){
               //      $dataPicCon1 = array(
               //          'uniacid' => $uniacid,
               //          'cid'=> $dataCateTopPicId,
               //          'pcid'=> $dataCateTopPicId,
               //          'type_x'=> 1,
               //          'type'=> 'showPic',
               //          'type_i'=> 1,
               //          'title'=> '高考案例：谢轩考入中山大学',
               //          'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/pic1.png',
               //          'text'=> 'a:1:{i:0;s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/pic1_p1.png";}',
               //      );
               //      $dataPicCon2 = array(
               //          'uniacid' => $uniacid,
               //          'cid'=> $dataCateTopPicId,
               //          'pcid'=> $dataCateTopPicId,
               //          'type_x'=> 1,
               //          'type'=> 'showPic',
               //          'type_i'=> 1,
               //          'title'=> '高考案例：吴恩培考入中山大学',
               //          'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/pic2.png',
               //          'text'=> 'a:1:{i:0;s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/pic1_p1.png";}',
               //      );
               //      $dataPicCon3 = array(
               //          'uniacid' => $uniacid,
               //          'cid'=> $dataCateTopPicId,
               //          'pcid'=> $dataCateTopPicId,
               //          'type_x'=> 1,
               //          'type'=> 'showPic',
               //          'type_i'=> 1,
               //          'title'=> '高考案例：谢虹考入中山大学',
               //          'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/pic3.png',
               //          'text'=> 'a:1:{i:0;s:51:"http://p2bwp6sww.bkt.clouddn.com/peixun/pic1_p1.png";}',
               //      );
               //      pdo_insert('sudu8_page_products', $dataPicCon1);
               //      pdo_insert('sudu8_page_products', $dataPicCon2);
               //      pdo_insert('sudu8_page_products', $dataPicCon3);
               //  }
               //    //添加文章
               //  $cateArt1Con = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showArt' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopArt1Id));
               //  $cateArtCon1Num = count($cateArt1Con);
               //  if($cateArtCon1Num == 0){
               //      $dataArtCon1 = array(
               //          'uniacid' => $uniacid,
               //          'num'=>999,
               //          'cid'=> $dataCateTopArt1Id,
               //          'pcid'=> $dataCateTopArt1Id,
               //          'type'=> 'showArt',
               //          'type_i'=> 1,
               //          'title'=> '白老师',
               //          'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/art1.jpg',
               //          'desc'=> '',
               //          'text'=> '这里是文章内容',
               //      );
               //      $dataArtCon2 = array(
               //          'uniacid' => $uniacid,
               //          'num'=>99,
               //          'cid'=> $dataCateTopArt1Id,
               //          'pcid'=> $dataCateTopArt1Id,
               //          'type'=> 'showArt',
               //          'type_i'=> 1,
               //          'title'=> '封老师',
               //          'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/art2.jpg',
               //          'desc'=> '',
               //          'text'=> '这里是文章内容',
               //      );
               //      $dataArtCon3 = array(
               //          'uniacid' => $uniacid,
               //          'num'=>98,
               //          'cid'=> $dataCateTopArt1Id,
               //          'pcid'=> $dataCateTopArt1Id,
               //          'type'=> 'showArt',
               //          'type_i'=> 1,
               //          'title'=> '秋老师',
               //          'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/art3.jpg',
               //          'desc'=> '',
               //          'text'=> '这里是文章内容',
               //      );
               //      pdo_insert('sudu8_page_products', $dataArtCon1);
               //      pdo_insert('sudu8_page_products', $dataArtCon2);
               //      pdo_insert('sudu8_page_products', $dataArtCon3);
               //  }
               // $cateArt2Con = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showArt' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopArt2Id));
               //  $cateArtCon2Num = count($cateArt2Con);
               //  if($cateArtCon2Num == 0){
               //      $dataArtCon1 = array(
               //          'uniacid' => $uniacid,
               //          'num'=>999,
               //          'cid'=> $dataCateTopArt2Id,
               //          'pcid'=> $dataCateTopArt2Id,
               //          'type'=> 'showArt',
               //          'type_i'=> 1,
               //          'title'=> '品牌数学寒假班课接受报名啦！',
               //          'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/peixun/art4.jpg',
               //          'desc'=> '品牌数学寒假课程 ，倾注全部人力物力打造的名师课程，全体骨干老师整合全年级常年教育资源和成果，并采取连续紧凑的教学模式，通过科学教学于帮助孩子提前预习课本知识和提升学习主动性，为新学期打下坚实基础。',
               //          'text'=> '这里是文章内容',
               //      );
               //      pdo_insert('sudu8_page_products', $dataArtCon1);
               //  }
               // 基础信息》公司介绍页
                $dataAbout = array(
                    'uniacid' => $uniacid,
                    'header'=>1,  //页顶部样式  1背景、标题、logo 2幻灯片[纯图]  3幻灯片[带链接]  0不行=显示
                    'tel_box'=>1, //电话、时间区块  1显示 0隐藏
                    'serv_box'=>0, //服务中心板块 1彩色实心  2白色边框  0本版块隐藏
                    'content'=>'<p>花艺鲜花店鲜花是江苏地区较早专业开展网上订花送花的实体花店，是一家以鲜花批发、零售为一体的专业实体花店，提供精美潮流花束，生日用花，婚庆花艺，全国县级以上城市和地区均可送达。</p><p><br/></p><p>我们拥有专业的花艺师团队，特别在婚礼花艺和艺术花艺上有特别的研究和创新，为客户提供完美的花艺艺术，始终走在前端引领着市场的潮流！</p>',  //内容
                );
                $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($about['uniacid'])) {
                    pdo_insert('sudu8_page_about', $dataAbout);
                } else {
                    pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
                }
                //表单
                // $dataForms = array(
                //     'uniacid' => $uniacid,
                //     'forms_style'=> 2,   //表单样式 1上线结构 2横排紧凑
                //     'forms_title_s'=> 'title1',  //表单版本标题样式 title1上下结构  title2左右结构
                //     'forms_head'=> 'none',  //表单页面顶部样式 header默认样式 slide幻灯片[纯图] newslide幻灯片[带链接] pic自定义内容 none不显示
                //     'forms_name'=> '自助预约', //表单名称
                //     'forms_ename'=> 'Self Booking', //表单英文名称
                //     'forms_inps'=> 0,    //输入框提示语 1显示 0隐藏
                //     'subtime'=> 2,      //提交间隔时间
                //     'forms_btn'=> '立即预约',  //按钮文字
                //     'success'=> '您已预约成功！',  //提交成功提示
                //     'name'=> '姓名',  //文本输入框1
                //     'name_must'=> 1,  //文本输入框1 1必填
                //     'tel'=> '联系电话',   //文本输入框2
                //     'tel_use'=> 1,  //文本输入框2 1启用
                //     'tel_must'=> 1, //文本输入框2 1必填
                //     'wechat'=>'年纪', //文本输入框3 
                //     'wechat_use'=> 1,//文本输入框3 1启用
                //     'date'=>"预约日期",//文本输入框3 1必填
                //     'date_use'=>1,//文本输入框3 1必填
                //     'time'=>'预约时间',//时间
                //     'time_use'=>1,//时间
                //     'checkbox_n'=>"课程选择",//文本输入框3 1必填
                //     'checkbox_num'=>2,
                //     'checkbox_use'=>1,
                //     'checkbox_v'=>"小学奥数,初中理科,高中理科,免费试听",//文本输入框3 1必填
                //     'content_n'=> '备注', //多行文本
                //     'content_use'=> 1, //多行文本 1启用
                //     // 'content_must'=> 1, //多行文本 1必填
                // );
                // $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                // if (empty($froms['uniacid'])) {
                //     pdo_insert('sudu8_page_forms_config', $dataForms);
                // } else {
                //     pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                // }
                //基础信息
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:3:{i:0;s:51:"http://p2bwp6sww.bkt.clouddn.com/huadian/slide1.jpg";i:1;s:51:"http://p2bwp6sww.bkt.clouddn.com/huadian/slide2.jpg";i:2;s:51:"http://p2bwp6sww.bkt.clouddn.com/huadian/slide3.jpg";}',  //幻灯片
                        'banner'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/logo_bg.jpg',  //门店背景
                        'logo'=>'http://p2bwp6sww.bkt.clouddn.com/huadian/logo.jpg',  //logo
                        'name' => '花艺行业',
                        'desc'=>'花束出售',   //门店特色
                        'address' => '南通世纪大道8888号',
                        'time' => '8:30 - 18:00',
                        'tel' => '15111111111',
                        'latitude' => '31.983310',
                        'longitude' => '120.946330',
                        'about' => '花束出售',
                        //样式DIY
                        'base_color'=> '#ffffff',  //小程序头底主色
                        'base_tcolor'=> '#000000', //小程序头底文字色
                        'base_color2'=> '#8787f0',  //小程序突出颜色
                        'base_color_t'=> '#8787f0', //默认样式标题颜色 公司介绍页
                        'config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}',
                        'index_style'=> 'slide',//header背景、标题、logo  slide纯幻灯片[基础设置]  newslide新幻灯片[带连接]
                        'tel_box'=> 0,//首页电话、时间区块 1显示 0不显示
                        'aboutCN' => '教育简介',   //首页介绍板块栏目名
                        'aboutCNen' => 'About Company',//首页介绍板块栏目英文名
                        'index_about_title' => '9', //介绍板块标题样式 title1上下结构 title2左右结构  no不显示标题 9本版块隐藏
                        'catename_x'=> '特价线路', //横排推荐区中文名
                        'catenameen_x'=> 'Special line',//横排推荐区英文名
                        'i_b_x_ts'=>9,//横排推荐去标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'i_b_x_iw'=> 235,//图片宽度
                        'catename'=>'春节热门线路', //竖排推荐区中文名
                        'catenameen'=>'', //竖排推荐区英文名
                        'i_b_y_ts'=> 9,//竖排
                        'index_pro_lstyle'=> 2,//竖排推荐区列表样式 1单行大图 2两列图片  3三列图片 8单行图文、带简介  3单行图文、带简介、时间、阅读量  4 纯标题样式   list_pic2 老版本修复【小程序版本低于6.0.8】
                        'index_pro_ts_al'=>'tc', //竖排推荐区列表标题 t1【无背景】标题左对齐  tc【无背景】标题居中下方 tlb【透明背景】标题左对齐底部  tcb【透明背景】标题居中底部  none不显示标题
                        'c_b_bg'=> '', //服务中心背景图
                        'c_b_btn'=> 0,//服务中心按钮样式 1彩色实心 2白色边框 0首页隐藏
                        'form_index'=> 0,//首页表单  1开启 0不
                        'c_title'=> 2,//内页样式DIY 1带时间标题 2纯标题 0隐藏
                        // 'footer_style'=>'footer1',//老版本修复  底部导航 footer1首页-电话-客服-导航 footer1首页-电话-预约-导航 footer3首页-介绍-服务-预约  none不显示
                        //底部菜单栏
                        'tabbar_t'=>1, //启用底部菜单tabbar 1启用 0不
                        // 'tabbar_bg'=>'#d40f33', //tabbar背景颜色
                        'color_bar'=>'#cccccc',//tabbar顶部横线颜色
                        'tabbar_tc'=>'#222222',//tabbar文字颜色
                        'tabbar_tca'=>'#cccccc',//选中颜色
                        'tabbar'=>'a:3:{i:0;s:213:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:52:"http://p2bwp6sww.bkt.clouddn.com/huadian/tabbar1.jpg";s:9:"tabbar_p2";s:52:"http://p2bwp6sww.bkt.clouddn.com/huadian/tabbar1.jpg";}";i:1;s:209:"a:4:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:6:"简介";s:9:"tabbar_p1";s:52:"http://p2bwp6sww.bkt.clouddn.com/huadian/tabbar2.jpg";s:9:"tabbar_p2";s:52:"http://p2bwp6sww.bkt.clouddn.com/huadian/tabbar2.jpg";}";i:2;s:226:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:52:"http://p2bwp6sww.bkt.clouddn.com/huadian/tabbar3.jpg";s:9:"tabbar_p2";s:52:"http://p2bwp6sww.bkt.clouddn.com/huadian/tabbar3.jpg";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
            }elseif($making_tmp == 9){
                //建立顶级文章栏目
                $cateTopArt = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArt1 = array(
                'uniacid' => $uniacid,
                'num' => 999,               //排序
                'type' => 'showArt',      //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,            //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '检车环境',     //栏目名称
                'ename' => '', //栏目英文名称
                'name_n' => '',   //首页导航栏标题
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/qixiu/nav2.png',             //栏目缩略图链接
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 1,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"1";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                );
                $dataCateTopArt2 = array(
                'uniacid' => $uniacid,
                'num' => 98,               //排序
                'type' => 'showArt',      //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,            //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '检车准备',     //栏目名称
                'ename' => '', //栏目英文名称
                'name_n' => '',   //首页导航栏标题
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/qixiu/nav3.png',             //栏目缩略图链接
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 1,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"1";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                );
                $dataCateTopArt3 = array(
                'uniacid' => $uniacid,
                'num' => 97,               //排序
                'type' => 'showArt',      //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,            //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '关于我们',     //栏目名称
                'ename' => '', //栏目英文名称
                'name_n' => '',   //首页导航栏标题
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/qixiu/nav4.png',             //栏目缩略图链接
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 1,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 1,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"1";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                );
                $dataCateTopArt4 = array(
                'uniacid' => $uniacid,
                'num' => 96,               //排序
                'type' => 'showArt',      //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,            //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '行业资讯',     //栏目名称
                'ename' => 'Industry information', //栏目英文名称
                'name_n' => '',   //首页导航栏标题
                'catepic' =>'',             //栏目缩略图链接
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 2,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 2,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 2,          //列表板块样式  1单行大图 2两列图片 5三列图片 6四列图片 7五列图片 8单行图文、带简介 3单行图文、带简介、时间、阅读量 4纯标题样式
                'list_stylet' => 'tlb',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,         //文章页面两侧 0左右留白  1左右不留白
                'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"1";}',       //一、内容图片下方留白pmarb 1留白1px 10留白10px 0不留白   二、文章页面标题ptit 1带时间标题 2纯标题 3标题隐藏
                );
                if (empty($CateTopArt['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopArt1);
                    pdo_insert('sudu8_page_cate', $dataCateTopArt2);
                    pdo_insert('sudu8_page_cate', $dataCateTopArt3);
                    pdo_insert('sudu8_page_cate', $dataCateTopArt4);
                }else{
                    pdo_update('sudu8_page_cate', $dataCateTopArt1 ,array('uniacid' => $uniacid,'id'=>$CateTopArt[0]['id']));
                    pdo_update('sudu8_page_cate', $dataCateTopArt2 ,array('uniacid' => $uniacid,'id'=>$CateTopArt[1]['id']));
                    pdo_update('sudu8_page_cate', $dataCateTopArt3 ,array('uniacid' => $uniacid,'id'=>$CateTopArt[2]['id']));
                    pdo_update('sudu8_page_cate', $dataCateTopArt4 ,array('uniacid' => $uniacid,'id'=>$CateTopArt[3]['id']));
                }
                $dataCateTopArt = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showArt' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopArt1Id = $dataCateTopArt[0]['id']; //顶级栏目名师风采栏目id
                $dataCateTopArt2Id = $dataCateTopArt[1]['id']; //顶级栏目公司动态栏目id
                $dataCateTopArt3Id = $dataCateTopArt[2]['id']; //顶级栏目公司动态栏目id
                $dataCateTopArt4Id = $dataCateTopArt[3]['id']; //顶级栏目公司动态栏目id
                //建立顶级商品栏目
                $cateTopPro = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $cateTopProNum = count($cateTopPro);
                $dataCateTopPro1 = array(
                'uniacid' => $uniacid,
                'num' => 999,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '所有项目',
                'ename' => '',
                'name_n' => '所有项目',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/qixiu/nav1.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 0,              //1首页显示  0不显示
                'list_tstyle' => 0,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 2,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTopPro2 = array(
                'uniacid' => $uniacid,
                'num' => 98,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '产品&服务',
                'ename' => 'Products and Services',
                'name_n' => '',
                'catepic' =>'',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tl',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                if ($cateTopProNum == 0) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPro1);
                    pdo_insert('sudu8_page_cate', $dataCateTopPro2);
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    $dataCateTopPro2Id = $dataCateTopProAll[1]['id'];  
                } else {
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    $dataCateTopPro2Id = $dataCateTopProAll[1]['id'];  
                    pdo_update('sudu8_page_cate', $dataCateTopPro1 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro1Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPro2 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro2Id));
                }
                //建立导航（首页导航栏）
                $dataNav = array(
                    'url'=>$dataCateTopPro1Id.",".$dataCateTopArt1Id.",".$dataCateTopArt2Id.",".$dataCateTopArt3Id,  //导航栏目
                    'uniacid' => $uniacid,
                    'statue'=>1,  //首页导航模块  0不启用 1启用栏目导航 2启用自定义导航
                    'name_s'=>1,    //图标名称板块是否显示  0显示 1不显示
                    'box_p_tb'=>2,  //导航上下边距
                    'box_p_lr'=>1,  //导航左右边距
                    'number'=>4,    //每排显示数量
                    'img_size'=>80, //图标占比
                    'title_position'=>0, //1文字在下方,无背景 2文字在底部，半透明背景  3文字左上角，半透明背景  0文字不显示
                    // 'title_color' => '#222222', //标题颜色
                );
                if (empty($dataNavCon['uniacid'])) {
                    pdo_insert('sudu8_page_nav', $dataNav);
                } else {
                    pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                }
                //添加商品
                $cateProCon1 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro1Id));  //所有产品
                $cateProCon1Num = count($cateProCon1);
                if($cateProCon1Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 0,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'购买',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/qixiu/pro1.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/qixiu/pro1.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '家庭轿车', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                }
                $cateProCon2 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro2Id));  //所有产品
                $cateProCon2Num = count($cateProCon2);
                if($cateProCon2Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro2Id,   //父级栏目
                        'pcid'=> $dataCateTopPro2Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'购买',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/qixiu/pro1.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/qixiu/pro1.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '家庭轿车', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    $dataProCon2 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,
                        'cid'=> $dataCateTopPro2Id,   //父级栏目
                        'pcid'=> $dataCateTopPro2Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>1, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>1, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>0, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'购买',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/qixiu/pro2.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/qixiu/pro2.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '货车（营运）', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是商品的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                    pdo_insert('sudu8_page_products', $dataProCon2);
                }
                  //添加文章
                $cateArt4Con = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showArt' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopArt4Id));
                $cateArtCon4Num = count($cateArt4Con);
                if($cateArtCon4Num == 0){
                    $dataArtCon1 = array(
                        'uniacid' => $uniacid,
                        'num'=>999,
                        'cid'=> $dataCateTopArt4Id,
                        'pcid'=> $dataCateTopArt4Id,
                        'type'=> 'showArt',
                        'type_x' => 1,
                        'type_i'=> 1,
                        'title'=> '检车注意事项',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/qixiu/art1.jpg',
                        'desc'=> '',
                        'text'=> '这里是文章内容',
                    );
                    $dataArtCon2 = array(
                        'uniacid' => $uniacid,
                        'num'=>99,
                        'cid'=> $dataCateTopArt4Id,
                        'pcid'=> $dataCateTopArt4Id,
                        'type'=> 'showArt',
                        'type_x' => 1,
                        'type_i'=> 1,
                        'title'=> '检车环境',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/qixiu/art2.jpg',
                        'desc'=> '',
                        'text'=> '这里是文章内容',
                    );
                    pdo_insert('sudu8_page_products', $dataArtCon1);
                    pdo_insert('sudu8_page_products', $dataArtCon2);
                }
               // // 基础信息》公司介绍页
               //  $dataAbout = array(
               //      'uniacid' => $uniacid,
               //      'header'=>1,  //页顶部样式  1背景、标题、logo 2幻灯片[纯图]  3幻灯片[带链接]  0不行=显示
               //      'tel_box'=>1, //电话、时间区块  1显示 0隐藏
               //      'serv_box'=>0, //服务中心板块 1彩色实心  2白色边框  0本版块隐藏
               //      'content'=>'<p>花艺鲜花店鲜花是江苏地区较早专业开展网上订花送花的实体花店，是一家以鲜花批发、零售为一体的专业实体花店，提供精美潮流花束，生日用花，婚庆花艺，全国县级以上城市和地区均可送达。</p><p><br/></p><p>我们拥有专业的花艺师团队，特别在婚礼花艺和艺术花艺上有特别的研究和创新，为客户提供完美的花艺艺术，始终走在前端引领着市场的潮流！</p>',  //内容
               //  );
               //  $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
               //  if (empty($about['uniacid'])) {
               //      pdo_insert('sudu8_page_about', $dataAbout);
               //  } else {
               //      pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
               //  }
                // 表单
                $dataForms = array(
                    'uniacid' => $uniacid,
                    'forms_style'=> 2,   //表单样式 1上线结构 2横排紧凑
                    'forms_title_s'=> 'title1',  //表单版本标题样式 title1上下结构  title2左右结构
                    'forms_head'=> 'header',  //表单页面顶部样式 header默认样式 slide幻灯片[纯图] newslide幻灯片[带链接] pic自定义内容 none不显示
                    'forms_name'=> '在线预约', //表单名称
                    'forms_ename'=> '', //表单英文名称
                    'forms_inps'=> 1,    //输入框提示语 1显示 0隐藏
                    'subtime'=> 2,      //提交间隔时间
                    'forms_btn'=> '立即预约',  //按钮文字
                    'success'=> '您已预约成功！',  //提交成功提示
                    'name'=> '姓名',  //文本输入框1
                    'name_must'=> 1,  //文本输入框1 1必填
                    'tel'=> '电话',   //文本输入框2
                    'tel_use'=> 1,  //文本输入框2 1启用
                    'tel_must'=> 1, //文本输入框2 1必填
                    'tel_i'=> 1, //文本输入框2 1必填
                    'date'=>"预约日期",//文本输入框3 1必填
                    'date_use'=>1,//文本输入框3 1必填
                    'date_i'=>1,//文本输入框3 1必填
                    'time'=>'预约时间',//时间
                    'time_use'=>1,//时间
                    'time_i'=>1,//时间
                    'checkbox_n'=>"项目",//文本输入框3 1必填
                    'checkbox_num'=>2,
                    'checkbox_use'=>1,
                    'checkbox_i'=>1,
                    'checkbox_v'=>"上门取车,自驾检车,家庭轿车,货车,三轮货车,正三轮,两轮",//文本输入框3 1必填
                    // 'content_n'=> '备注', //多行文本
                    // 'content_use'=> 1, //多行文本 1启用
                    // 'content_must'=> 1, //多行文本 1必填
                );
                $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($froms['uniacid'])) {
                    pdo_insert('sudu8_page_forms_config', $dataForms);
                } else {
                    pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                }
//                 //基础信息
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:1:{i:0;s:49:"http://p2bwp6sww.bkt.clouddn.com/qixiu/slide1.jpg";}',  //幻灯片
                        'banner'=>'http://p2bwp6sww.bkt.clouddn.com/qixiu/logo_bg.jpg',  //门店背景
                        'logo'=>'',  //logo
                        'name' => '汽修行业',
                        'desc'=>'汽修',   //门店特色
                        'address' => '南通世纪大道8888号',
                        'time' => '8:30 - 18:00',
                        'tel' => '15111111111',
                        'latitude' => '31.983310',
                        'longitude' => '120.946330',
                        'about' => '汽修',
                        //样式DIY
                        'base_color'=> '#3f7bc4',  //小程序头底主色
                        'base_tcolor'=> '#ffffff', //小程序头底文字色
                        'base_color2'=> '#3f7bc4',  //小程序突出颜色
                        'base_color_t'=> '#ffcf3d', //默认样式标题颜色 公司介绍页
                        'config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"1";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}',
                        'index_style'=> 'slide',//header背景、标题、logo  slide纯幻灯片[基础设置]  newslide新幻灯片[带连接]
                        'tel_box'=> 0,//首页电话、时间区块 1显示 0不显示
                        'aboutCN' => '教育简介2',   //首页介绍板块栏目名
                        'aboutCNen' => 'About Company',//首页介绍板块栏目英文名
                        'index_about_title' => '9', //介绍板块标题样式 title1上下结构 title2左右结构  no不显示标题 9本版块隐藏
                        'catename_x'=> '行业资讯', //横排推荐区中文名
                        'catenameen_x'=> 'Industry information',//横排推荐区英文名
                        'i_b_x_ts'=>2,//横排推荐去标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'i_b_x_iw'=> 500,//图片宽度
                        'catename'=>'春节热门线路', //竖排推荐区中文名
                        'catenameen'=>'', //竖排推荐区英文名
                        'i_b_y_ts'=> 9,//竖排
                        'index_pro_lstyle'=> 2,//竖排推荐区列表样式 1单行大图 2两列图片  3三列图片 8单行图文、带简介  3单行图文、带简介、时间、阅读量  4 纯标题样式   list_pic2 老版本修复【小程序版本低于6.0.8】
                        'index_pro_ts_al'=>'tc', //竖排推荐区列表标题 t1【无背景】标题左对齐  tc【无背景】标题居中下方 tlb【透明背景】标题左对齐底部  tcb【透明背景】标题居中底部  none不显示标题
                        'c_b_bg'=> '', //服务中心背景图
                        'c_b_btn'=> 0,//服务中心按钮样式 1彩色实心 2白色边框 0首页隐藏
                        'form_index'=> 1,//首页表单  1开启 0不
                        'c_title'=> 2,//内页样式DIY 1带时间标题 2纯标题 0隐藏
                        // 'footer_style'=>'none',//老版本修复  底部导航 footer1首页-电话-客服-导航 footer1首页-电话-预约-导航 footer3首页-介绍-服务-预约  none不显示
                        //底部菜单栏
                        'tabbar_t'=>1, //启用底部菜单tabbar 1启用 0不
                        // 'tabbar_bg'=>'#d40f33', //tabbar背景颜色
                        // 'color_bar'=>'#cccccc',//tabbar顶部横线颜色
                        'tabbar_tc'=>'#595959',//tabbar文字颜色
                        'tabbar_tca'=>'#3f7bc4',//选中颜色
                        'tabbar'=>'a:5:{i:0;s:211:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/qixiu/tabbar1.png";s:9:"tabbar_p2";s:52:"http://p2bwp6sww.bkt.clouddn.com/qixiu/tabbar1_h.png";}";i:1;s:217:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:12:"自助预约";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/qixiu/tabbar2.png";s:9:"tabbar_p2";s:52:"http://p2bwp6sww.bkt.clouddn.com/qixiu/tabbar2_h.png";}";i:2;s:207:"a:4:{s:8:"tabbar_l";s:3:"map";s:8:"tabbar_t";s:6:"导航";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/qixiu/tabbar3.png";s:9:"tabbar_p2";s:50:"http://p2bwp6sww.bkt.clouddn.com/qixiu/tabbar3.png";}";i:3;s:207:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:6:"电话";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/qixiu/tabbar4.png";s:9:"tabbar_p2";s:50:"http://p2bwp6sww.bkt.clouddn.com/qixiu/tabbar4.png";}";i:4;s:210:"a:4:{s:8:"tabbar_l";s:6:"wechat";s:8:"tabbar_t";s:6:"客服";s:9:"tabbar_p1";s:50:"http://p2bwp6sww.bkt.clouddn.com/qixiu/tabbar5.png";s:9:"tabbar_p2";s:50:"http://p2bwp6sww.bkt.clouddn.com/qixiu/tabbar5.png";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
            }elseif($making_tmp == 10){
                //建立顶级商品栏目
                $cateTopPro = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $cateTopProNum = count($cateTopPro);
                $dataCateTopPro = array(
                'uniacid' => $uniacid,
                'num' => 99,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '高级设计师',
                'ename' => 'Designer',
                'name_n' => '',
                'catepic' =>'http://p2bwp6sww.bkt.clouddn.com/zxzs/nav1.png',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                if ($cateTopProNum == 0) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPro);
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                } else {
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    pdo_update('sudu8_page_cate', $dataCateTopPro ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro1Id));
                }
                //建立顶级图片栏目
                $cateTopPic = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid=0 ", array(':uniacid' => $uniacid));
                $dataCateTopPic1 = array(
                'uniacid' => $uniacid,
                'num' => 99,
                'type' => 'showPic',
                'statue' => 1,
                'cid' => 0,
                'name' => '产品&服务',
                'ename' => 'Products and Services',
                'name_n' => '',
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 2,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tcb',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,
                );
                $dataCateTopPic2 = array(
                'uniacid' => $uniacid,
                'num' => 97,
                'type' => 'showPic',
                'statue' => 1,
                'cid' => 0,
                'name' => '样板风格',
                'ename' => 'style',
                'name_n' => '',
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 2,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'tcb',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,
                );
                if (empty($cateTopPic['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPic1);
                    pdo_insert('sudu8_page_cate', $dataCateTopPic2);
                    $dataCateTopPic = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPic1Id = $dataCateTopPic[0]['id'];  //组图顶级栏目id
                    $dataCateTopPic2Id = $dataCateTopPic[1]['id'];  //组图顶级栏目id
                } else {
                    $dataCateTopPic = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPic1Id = $dataCateTopPic[0]['id'];  //组图顶级栏目id
                    $dataCateTopPic2Id = $dataCateTopPic[1]['id'];  //组图顶级栏目id
                    pdo_update('sudu8_page_cate', $dataCateTopPic1 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPic1Id));
                    pdo_update('sudu8_page_cate', $dataCateTopPic2 ,array('uniacid' => $uniacid,'id'=>$dataCateTopPic2Id));
                }
               // 建立自定义导航
                $navList = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_navlist')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if(empty($navList)){
                    $dataNavList1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/zxzs/nav1.png',  //导航图标
                        'title' => '全国分店',  //导航标题
                        'url' => '/sudu8_page/store/store', //导航链接
                    );
                    $dataNavList2 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/zxzs/nav2.png',
                        'title' => '优惠券',
                        'url' => '/sudu8_page/coupon/coupon',
                    );
                    $dataNavList3 = array(
                        'uniacid' => $uniacid,
                        'num' => 97,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/zxzs/nav3.png',
                        'title' => '品牌保障',
                        'url' => '/sudu8_page/about/about',
                    );
                    $dataNavList4 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/zxzs/nav4.png',
                        'title' => '预约',
                        'url' => '/sudu8_page/book/book',
                    );
                    $dataNavList5 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 3,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/zxzs/nav5.png',
                        'title' => '客服经理',
                    );
                    pdo_insert('sudu8_page_navlist', $dataNavList1);  
                    pdo_insert('sudu8_page_navlist', $dataNavList2);  
                    pdo_insert('sudu8_page_navlist', $dataNavList3);  
                    pdo_insert('sudu8_page_navlist', $dataNavList4);  
                    pdo_insert('sudu8_page_navlist', $dataNavList5);  
                }
                //建立导航（首页导航栏）
                $dataNav = array(
                    'url'=>'',  //导航栏目
                    'uniacid' => $uniacid,
                    'statue'=>2,  //首页导航模块  0不启用 1启用栏目导航 2启用自定义导航
                    'name_s'=>1,    //图标模块名称板块是否显示  0显示 1不显示
                    'box_p_tb'=>2,  //导航上下边距
                    'box_p_lr'=>1,  //导航左右边距
                    'number'=>5,    //每排显示数量
                    'img_size'=>60, //图标占比
                    'title_position'=>1, //1文字在下方,无背景 2文字在底部，半透明背景  3文字左上角，半透明背景  0文字不显示
                    'title_color' => '#000000', //标题颜色
                );
                if (empty($dataNavCon['uniacid'])) {
                    pdo_insert('sudu8_page_nav', $dataNav);
                } else {
                    pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                }
                //添加商品
                $cateProCon1 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro1Id));  //所有产品
                $cateProCon1Num = count($cateProCon1);
                if($cateProCon1Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pro1.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pro1.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '周晓安', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是设计师的详细介绍，可放图文', 
                    );
                    $dataProCon2 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pro2.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pro2.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '何育红', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是设计师的详细介绍，可放图文', 
                    );
                    $dataProCon3 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pro3.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pro3.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '张咚冬', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是设计师的详细介绍，可放图文', 
                    );
                    $dataProCon4 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pro4.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pro4.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '杨萍', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是设计师的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                    pdo_insert('sudu8_page_products', $dataProCon2);
                    pdo_insert('sudu8_page_products', $dataProCon3);
                    pdo_insert('sudu8_page_products', $dataProCon4);
                }
                //添加组图
                $catePic1Con = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPic' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPic1Id));
                $catePicCon1Num = count($catePic1Con);
                if($catePicCon1Num == 0){
                    $dataPicCon1 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic1Id,
                        'pcid'=> $dataCateTopPic1Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '南亚风格',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pic1.jpg',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pic1.jpg";}',
                    );
                    $dataPicCon2 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic1Id,
                        'pcid'=> $dataCateTopPic1Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '地中海风格',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pic2.jpg',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pic2.jpg";}',
                    );
                    $dataPicCon3 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic1Id,
                        'pcid'=> $dataCateTopPic1Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '欧美风格',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pic3.jpg',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pic3.jpg";}',
                    );
                    $dataPicCon4 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic1Id,
                        'pcid'=> $dataCateTopPic1Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '传统风格',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pic4.jpg',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pic4.jpg";}',
                    );
                    pdo_insert('sudu8_page_products', $dataPicCon4);
                    pdo_insert('sudu8_page_products', $dataPicCon3);
                    pdo_insert('sudu8_page_products', $dataPicCon2);
                    pdo_insert('sudu8_page_products', $dataPicCon1);
                }
                $catePic2Con = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPic' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPic2Id));
                $catePicCon2Num = count($catePic2Con);
                if($catePicCon2Num == 0){
                    $dataPicCon1 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic2Id,
                        'pcid'=> $dataCateTopPic2Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '样板间1',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pic5.jpg',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pic5.jpg";}',
                    );
                    $dataPicCon2 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic2Id,
                        'pcid'=> $dataCateTopPic2Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '样板间2',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pic6.jpg',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pic6.jpg";}',
                    );
                    $dataPicCon3 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic2Id,
                        'pcid'=> $dataCateTopPic2Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '样板间3',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pic7.jpg',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pic7.jpg";}',
                    );
                    $dataPicCon4 = array(
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic2Id,
                        'pcid'=> $dataCateTopPic2Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '样板间4',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/pic8.jpg',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/zxzs/pic8.jpg";}',
                    );
                    pdo_insert('sudu8_page_products', $dataPicCon1);
                    pdo_insert('sudu8_page_products', $dataPicCon2);
                    pdo_insert('sudu8_page_products', $dataPicCon3);
                    pdo_insert('sudu8_page_products', $dataPicCon4);
                }
               // 基础信息》公司介绍页
                $dataAbout = array(
                    'uniacid' => $uniacid,
                    'header'=>1,  //页顶部样式  1背景、标题、logo 2幻灯片[纯图]  3幻灯片[带链接]  0不行=显示
                    'tel_box'=>1, //电话、时间区块  1显示 0隐藏
                    'serv_box'=>2, //服务中心板块 1彩色实心  2白色边框  0本版块隐藏
                    'content'=>'<p>十五年装修装饰经验</p>',  //内容
                );
                $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($about['uniacid'])) {
                    pdo_insert('sudu8_page_about', $dataAbout);
                } else {
                    pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
                }
                // 表单
                $dataForms = array(
                    'uniacid' => $uniacid,
                    'forms_style'=> 1,   //表单样式 1上下结构 2横排紧凑
                    'forms_title_s'=> 'title1',  //表单版本标题样式 title1上下结构  title2左右结构
                    'forms_head'=> 'slide',  //表单页面顶部样式 header默认样式 slide幻灯片[纯图] newslide幻灯片[带链接] pic自定义内容 none不显示
                    'forms_name'=> '预约设计师', //表单名称
                    'forms_ename'=> '', //表单英文名称
                    'forms_inps'=> 1,    //输入框提示语 1显示 0隐藏
                    'subtime'=> 2,      //提交间隔时间
                    'forms_btn'=> '提交',  //按钮文字
                    'success'=> '您已预约成功！',  //提交成功提示
                    'name'=> '您的名称',  //文本输入框1
                    'name_must'=> 1,  //文本输入框1 1必填
                    'tel'=> '手机号码',   //文本输入框2
                    'tel_use'=> 1,  //文本输入框2 1启用
                    'tel_must'=> 1, //文本输入框2 1必填
                    'tel_i'=> 1, //文本输入框2 1必填
                    'wechat'=> '房子面积',   //文本输入框2
                    'wechat_use'=> 1,  //文本输入框2 1启用
                    'wechat_must'=> 1, //文本输入框2 1必填
                    'wechat_i'=> 1, //文本输入框2 1必填
                    'date'=>"预约日期",//文本输入框3 1必填
                    'date_use'=>1,//文本输入框3 1必填
                    'date_must'=> 1, //文本输入框2 1必填
                    'date_i'=>1,//文本输入框3 1必填
                );
                $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($froms['uniacid'])) {
                    pdo_insert('sudu8_page_forms_config', $dataForms);
                } else {
                    pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                }
                //添加优惠券
                $dataCoupon = array(
                    'uniacid' => $uniacid,
                    'num' => 9,
                    'title' => '满50000立减1000',
                    'color' => '#f57082',
                    'price' => 1000,
                    'pay_money' => '50000',
                    'counts' => 999,
                    'xz_count' => 1,
                    'btime' => '1512486016',
                    'etime' => '1534559624',
                    'flag' => 1,
                    );
                if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_coupon', $dataCoupon);
                    } else {
                        pdo_update('sudu8_page_coupon', $dataCoupon ,array('uniacid' => $uniacid));
                    }
                 //基础信息
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:2:{i:0;s:48:"http://p2bwp6sww.bkt.clouddn.com/zxzs/slide1.png";i:1;s:48:"http://p2bwp6sww.bkt.clouddn.com/zxzs/slide2.png";}',  //幻灯片
                        'banner'=>'http://p2bwp6sww.bkt.clouddn.com/zxzs/logo_bg.png',  //门店背景
                        'logo'=>'http://p2bwp6sww.bkt.clouddn.com/zxzs/logo.png',  //logo
                        'name' => '装修装饰门店',
                        'desc'=>'十五年装修装饰经验',   //门店特色
                        'address' => '南通世纪大道8888号',
                        'time' => '8:30 - 18:00',
                        'tel' => '15111111111',
                        'latitude' => '31.983310',
                        'longitude' => '120.946330',
                        'about' => '十五年装修装饰经验',
                        //样式DIY
                        'base_color'=> '#f57082',  //小程序头底主色
                        'base_tcolor'=> '#ffffff', //小程序头底文字色
                        'base_color2'=> '#f57082',  //小程序突出颜色
                        'base_color_t'=> '#f57082', //默认样式标题颜色 公司介绍页
                        'config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"1";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"0";s:8:"userFood";s:1:"0";}',
                        'index_style'=> 'slide',//header背景、标题、logo  slide纯幻灯片[基础设置]  newslide新幻灯片[带连接]
                        'tel_box'=> 1,//首页电话、时间区块 1显示 0不显示
                        'aboutCN' => '教育简介2',   //首页介绍板块栏目名
                        'aboutCNen' => 'About Company',//首页介绍板块栏目英文名
                        'index_about_title' => '9', //介绍板块标题样式 title1上下结构 title2左右结构  no不显示标题 9本版块隐藏
                        'catename_x'=> '行业资讯', //横排推荐区中文名
                        'catenameen_x'=> 'Industry information',//横排推荐区英文名
                        'i_b_x_ts'=>9,//横排推荐去标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'i_b_x_iw'=> 500,//图片宽度
                        'catename'=>'春节热门线路', //竖排推荐区中文名
                        'catenameen'=>'', //竖排推荐区英文名
                        'i_b_y_ts'=> 9,//竖排
                        'index_pro_lstyle'=> 2,//竖排推荐区列表样式 1单行大图 2两列图片  3三列图片 8单行图文、带简介  3单行图文、带简介、时间、阅读量  4 纯标题样式   list_pic2 老版本修复【小程序版本低于6.0.8】
                        'index_pro_ts_al'=>'tc', //竖排推荐区列表标题 t1【无背景】标题左对齐  tc【无背景】标题居中下方 tlb【透明背景】标题左对齐底部  tcb【透明背景】标题居中底部  none不显示标题
                        'c_b_bg'=> 'http://p2bwp6sww.bkt.clouddn.com/zxzs/server_bg.png', //服务中心背景图
                        'c_b_btn'=> 2,//服务中心按钮样式 1彩色实心 2白色边框 0首页隐藏
                        'form_index'=> 1,//首页表单  1开启 0不
                        'c_title'=> 2,//内页样式DIY 1带时间标题 2纯标题 0隐藏
                        // 'footer_style'=>'none',//老版本修复  底部导航 footer1首页-电话-客服-导航 footer1首页-电话-预约-导航 footer3首页-介绍-服务-预约  none不显示
                        //底部菜单栏
                        'tabbar_t'=>1, //启用底部菜单tabbar 1启用 0不
                        // 'tabbar_bg'=>'#d40f33', //tabbar背景颜色
                        // 'color_bar'=>'#cccccc',//tabbar顶部横线颜色
                        // 'tabbar_tc'=>'',//tabbar文字颜色
                        'tabbar_tca'=>'#f57082',//选中颜色
                        'tabbar'=>'a:3:{i:0;s:207:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:49:"http://p2bwp6sww.bkt.clouddn.com/zxzs/tabbar1.png";s:9:"tabbar_p2";s:49:"http://p2bwp6sww.bkt.clouddn.com/zxzs/tabbar1.png";}";i:1;s:214:"a:4:{s:8:"tabbar_l";s:5:"about";s:8:"tabbar_t";s:12:"公司介绍";s:9:"tabbar_p1";s:49:"http://p2bwp6sww.bkt.clouddn.com/zxzs/tabbar2.png";s:9:"tabbar_p2";s:49:"http://p2bwp6sww.bkt.clouddn.com/zxzs/tabbar2.png";}";i:2;s:220:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:49:"http://p2bwp6sww.bkt.clouddn.com/zxzs/tabbar3.png";s:9:"tabbar_p2";s:49:"http://p2bwp6sww.bkt.clouddn.com/zxzs/tabbar3.png";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
            }elseif($making_tmp == 11){
                //建立顶级商品栏目
                $cateTopPro = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                $cateTopProNum = count($cateTopPro);
                $dataCateTop1Pro = array(
                'uniacid' => $uniacid,
                'num' => 99,     //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '教练预约',
                'ename' => 'subscribe/trainer',
                'name_n' => '',
                'catepic' =>'',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                $dataCateTop2Pro = array(
                'uniacid' => $uniacid,
                'num' => 98,    //排序
                'type' => 'showPro',  //内容模型  showArt(文章) showPic(组图) showPro(商品) showWxapps(小程序) page(单页面)
                'statue' => 1,      //启用 1启用 0不启用
                'cid' => 0,               //所属栏目 0顶级分类 
                'name' => '会员卡办理',
                'ename' => 'power',
                'name_n' => '',
                'catepic' =>'',             //栏目缩略图
                'cdesc' => "",              //栏目简介
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 12,         //产品列表板块样式  11单列产品 12两列产品 13三列产品 14四列产品 15五列产品 19产品带介绍
                'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                );
                if ($cateTopProNum == 0) {
                    pdo_insert('sudu8_page_cate', $dataCateTop1Pro);
                    pdo_insert('sudu8_page_cate', $dataCateTop2Pro);
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    $dataCateTopPro2Id = $dataCateTopProAll[1]['id'];  
                } else {
                    $dataCateTopProAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPro' AND cid=0", array(':uniacid' => $uniacid));
                    $dataCateTopPro1Id = $dataCateTopProAll[0]['id'];  
                    $dataCateTopPro2Id = $dataCateTopProAll[1]['id'];  
                    pdo_update('sudu8_page_cate', $dataCateTop1Pro ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro1Id));
                    pdo_update('sudu8_page_cate', $dataCateTop2Pro ,array('uniacid' => $uniacid,'id'=>$dataCateTopPro2Id));
                }
                //建立顶级图片栏目
                $cateTopPic = pdo_fetch("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid=0 ", array(':uniacid' => $uniacid));
                $dataCateTopPic1 = array(
                'uniacid' => $uniacid,
                'num' => 99,
                'type' => 'showPic',
                'statue' => 1,
                'cid' => 0,
                'name' => '俱乐部器材',
                'ename' => 'equipment',
                'name_n' => '',
                'show_i' => 1,              //1首页显示  0不显示
                'list_tstyle' => 1,         //首页标题样式  1上下结构  2左右结构  0不显示
                'list_tstylel' => 0,        //列表标题样式    1上下结构  2左右结构  0不显示
                'list_type' => 1,           //列表类型 0显示子分类  1显示内容
                'list_style' => 2,         
                'list_stylet' => 'none',     //板块标题样式 tl【无背景】标题左对齐  tc【无背景】标题居中下方 tlb 【透明背景】标题左对齐底部 tcb【透明背景】标题居中底部  none不显示标题
                'pic_page_btn'=>0,
                );
                if (empty($cateTopPic['uniacid'])) {
                    pdo_insert('sudu8_page_cate', $dataCateTopPic1);
                } else {
                    pdo_update('sudu8_page_cate', $dataCateTopPic1 ,array('uniacid' => $uniacid,'id'=>$cateTopPic['id']));
                }
                $CateTopPicAll = pdo_fetchAll("SELECT uniacid,id FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid AND type='showPic' AND cid=0", array(':uniacid' => $uniacid));
                $dataCateTopPic1Id = $CateTopPicAll[0]['id'];  //组图顶级栏目id
               // 建立自定义导航
                $navList = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_navlist')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if(empty($navList)){
                    $dataNavList1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/jshs/nav1.png',  //导航图标
                        'title' => '会员卡开通',  //导航标题
                        'url' => '', //导航链接
                    );
                    $dataNavList2 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/jshs/nav2.png',
                        'title' => '美体瘦身',
                        'url' => '',
                    );
                    $dataNavList3 = array(
                        'uniacid' => $uniacid,
                        'num' => 97,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/jshs/nav3.png',
                        'title' => '跑步训练',
                        'url' => '',
                    );
                    $dataNavList4 = array(
                        'uniacid' => $uniacid,
                        'num' => 96,  //排序
                        'flag' => 1,  //启用 1启用 0不
                        'type' => 0,  //导航类型  0小程序页面  1拨打电话  2打开导航  3微信客服  4打开小程序  5打开网页
                        'pic' => 'http://p2bwp6sww.bkt.clouddn.com/jshs/nav4.png',
                        'title' => '力量训练',
                        'url' => '',
                    );
                    pdo_insert('sudu8_page_navlist', $dataNavList1);  
                    pdo_insert('sudu8_page_navlist', $dataNavList2);  
                    pdo_insert('sudu8_page_navlist', $dataNavList3);  
                    pdo_insert('sudu8_page_navlist', $dataNavList4);  
                }
                //建立导航（首页导航栏）
                $dataNav = array(
                    'url'=>'',  //导航栏目
                    'uniacid' => $uniacid,
                    'statue'=>2,  //首页导航模块  0不启用 1启用栏目导航 2启用自定义导航
                    'name_s'=>1,    //图标模块名称板块是否显示  0显示 1不显示
                    'box_p_tb'=>2,  //导航上下边距
                    'box_p_lr'=>1,  //导航左右边距
                    'number'=>4,    //每排显示数量
                    'img_size'=>60, //图标占比
                    'title_position'=>1, //1文字在下方,无背景 2文字在底部，半透明背景  3文字左上角，半透明背景  0文字不显示
                    'title_color' => '#000000', //标题颜色
                );
                if (empty($dataNavCon['uniacid'])) {
                    pdo_insert('sudu8_page_nav', $dataNav);
                } else {
                    pdo_update('sudu8_page_nav', $dataNav ,array('uniacid' => $uniacid));
                }
                //添加商品
                $cateProCon1 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro1Id));  //所有产品
                $cateProCon1Num = count($cateProCon1);
                if($cateProCon1Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pro1.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/jshs/pro1.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '张甜瑜伽教练', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是训练教练的详细介绍，可放图文', 
                    );
                    $dataProCon2 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pro2.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/jshs/pro2.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '李飞力量训练教练', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是设计师的详细介绍，可放图文', 
                    );
                    $dataProCon3 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pro3.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/jshs/pro3.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '张笛教练', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是设计师的详细介绍，可放图文', 
                    );
                    $dataProCon4 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro1Id,   //父级栏目
                        'pcid'=> $dataCateTopPro1Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'预约',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pro4.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/jshs/pro4.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '郝梅教练', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是设计师的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                    pdo_insert('sudu8_page_products', $dataProCon2);
                    pdo_insert('sudu8_page_products', $dataProCon3);
                    pdo_insert('sudu8_page_products', $dataProCon4);
                }
                $cateProCon2 = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPro' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPro2Id));  //所有产品
                $cateProCon2Num = count($cateProCon2);
                if($cateProCon2Num == 0){
                    $dataProCon1 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro2Id,   //父级栏目
                        'pcid'=> $dataCateTopPro2Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'办卡',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pro5.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/jshs/pro5.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '会员月卡', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是训练教练的详细介绍，可放图文', 
                    );
                    $dataProCon2 = array(
                        'uniacid' => $uniacid,
                        'num' => 98,
                        'cid'=> $dataCateTopPro2Id,   //父级栏目
                        'pcid'=> $dataCateTopPro2Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'办卡',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pro5.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/jshs/pro5.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '全年1对1专属教练', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是设计师的详细介绍，可放图文', 
                    );
                    $dataProCon3 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro2Id,   //父级栏目
                        'pcid'=> $dataCateTopPro2Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'办卡',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pro5.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/jshs/pro5.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '2年会员卡', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是设计师的详细介绍，可放图文', 
                    );
                    $dataProCon4 = array(
                        'uniacid' => $uniacid,
                        'num' => 99,
                        'cid'=> $dataCateTopPro2Id,   //父级栏目
                        'pcid'=> $dataCateTopPro2Id, //父级栏目所属顶级栏目
                        'type'=> 'showPro',
                        'type_x'=>0,//0不推荐  1推荐  推荐到首页横排
                        'type_y'=>0,//0不推荐  1推荐  推荐到首页竖排
                        'type_i'=> 1,//0不推荐  1推荐  推荐到首页栏目
                        'pro_flag' =>2, //下单是否填写姓名 0不启用 1启用 2启用并必填
                        'pro_flag_tel' =>2, //下单是否填写电话 0不启用 1启用 2启用并必填
                        'pro_flag_add' =>2, //下单是否填写地址 0不启用 1启用 2启用并必填
                        'pro_flag_ding'=>1, //是否确认订单 0不确认 1确认
                        'buy_type'=>'办卡',//购买方式 
                        'price'=>360,      //门店价
                        'market_price'=>360, //市场价
                        'pro_kc'=>500,  //库存
                        'pro_xz'=>0,    //每人最多买几份
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pro5.jpg',  //缩略图
                        'text'=> 'a:1:{i:0;s:46:"http://p2bwp6sww.bkt.clouddn.com/jshs/pro5.jpg";}',   //商品主图
                        'labels'=> '',   //商品标签
                        'title'=> '会员年卡', //产品标题
                        'desc'=> '', //商品简介
                        'product_txt'=>'这里是设计师的详细介绍，可放图文', 
                    );
                    pdo_insert('sudu8_page_products', $dataProCon1);
                    pdo_insert('sudu8_page_products', $dataProCon2);
                    pdo_insert('sudu8_page_products', $dataProCon3);
                    pdo_insert('sudu8_page_products', $dataProCon4);
                }
                //添加组图
                $catePic1Con = pdo_fetchall("SELECT uniacid FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type='showPic' and pcid = :pcid ", array(':uniacid' => $uniacid,':pcid' => $dataCateTopPic1Id));
                $catePicCon1Num = count($catePic1Con);
                if($catePicCon1Num == 0){
                    $dataPicCon1 = array(
                        'num' => 99,
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic1Id,
                        'pcid'=> $dataCateTopPic1Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '杠铃',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pic1.png',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jshs/pic1.png";}',
                    );
                    $dataPicCon2 = array(
                        'num' => 98,
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic1Id,
                        'pcid'=> $dataCateTopPic1Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '弹力绳',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pic2.png',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jshs/pic2.png";}',
                    );
                    $dataPicCon3 = array(
                        'num' => 97,
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic1Id,
                        'pcid'=> $dataCateTopPic1Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '哑铃',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pic3.png',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jshs/pic3.png";}',
                    );
                    $dataPicCon4 = array(
                        'num' => 96,
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic1Id,
                        'pcid'=> $dataCateTopPic1Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '瑞士球',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pic4.png',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jshs/pic4.png";}',
                    );
                    $dataPicCon5 = array(
                        'num' => 95,
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic1Id,
                        'pcid'=> $dataCateTopPic1Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '夹胸器',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pic5.png',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jshs/pic5.png";}',
                    );
                    $dataPicCon6 = array(
                        'num' => 94,
                        'uniacid' => $uniacid,
                        'cid'=> $dataCateTopPic1Id,
                        'pcid'=> $dataCateTopPic1Id,
                        'type_x'=> 1,
                        'type'=> 'showPic',
                        'type_i'=> 1,
                        'title'=> '龙门架',
                        'thumb'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/pic6.png',
                        'text'=> 'a:1:{i:0;s:47:"http://p2bwp6sww.bkt.clouddn.com/jshs/pic6.png";}',
                    );
                    pdo_insert('sudu8_page_products', $dataPicCon1);
                    pdo_insert('sudu8_page_products', $dataPicCon2);
                    pdo_insert('sudu8_page_products', $dataPicCon3);
                    pdo_insert('sudu8_page_products', $dataPicCon4);
                    pdo_insert('sudu8_page_products', $dataPicCon5);
                    pdo_insert('sudu8_page_products', $dataPicCon6);
                }
               // 基础信息》公司介绍页
                // $dataAbout = array(
                //     'uniacid' => $uniacid,
                //     'header'=>1,  //页顶部样式  1背景、标题、logo 2幻灯片[纯图]  3幻灯片[带链接]  0不行=显示
                //     'tel_box'=>1, //电话、时间区块  1显示 0隐藏
                //     'serv_box'=>2, //服务中心板块 1彩色实心  2白色边框  0本版块隐藏
                //     'content'=>'<p>十五年装修装饰经验</p>',  //内容
                // );
                // $about = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                // if (empty($about['uniacid'])) {
                //     pdo_insert('sudu8_page_about', $dataAbout);
                // } else {
                //     pdo_update('sudu8_page_about', $dataAbout ,array('uniacid' => $uniacid));
                // }
                // 表单
                $dataForms = array(
                    'uniacid' => $uniacid,
                    'forms_style'=> 1,   //表单样式 1上下结构 2横排紧凑
                    'forms_title_s'=> 'title1',  //表单版本标题样式 title1上下结构  title2左右结构
                    'forms_head'=> 'slide',  //表单页面顶部样式 header默认样式 slide幻灯片[纯图] newslide幻灯片[带链接] pic自定义内容 none不显示
                    'forms_name'=> '预约设体验', //表单名称
                    'forms_ename'=> '', //表单英文名称
                    'forms_inps'=> 1,    //输入框提示语 1显示 0隐藏
                    'subtime'=> 2,      //提交间隔时间
                    'forms_btn'=> '提交预约',  //按钮文字
                    'success'=> '您已预约成功！',  //提交成功提示
                    'name'=> '您的姓名',  //文本输入框1
                    'name_must'=> 1,  //文本输入框1 1必填
                    'tel'=> '您的手机号码',   //文本输入框2
                    'tel_use'=> 1,  //文本输入框2 1启用
                    'tel_must'=> 1, //文本输入框2 1必填
                    'date'=>"预约日期",//文本输入框3 1必填
                    'date_use'=>1,//文本输入框3 1必填
                    'date_must'=> 1, //文本输入框2 1必填
                    'time'=>"时间",//文本输入框3 1必填
                    'time_use'=>1,//文本输入框3 1必填
                    'time_must'=> 1, //文本输入框2 1必填
                    'single_n'=>'健身项目',
                    'single_num'=>3,
                    'single_use'=>1,
                    'single_must'=>1,
                    'single_v'=>'力量训练,瑜伽,瘦身美体,自助健身,办会员',
                );
                $froms = pdo_fetch("SELECT uniacid FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
                if (empty($froms['uniacid'])) {
                    pdo_insert('sudu8_page_forms_config', $dataForms);
                } else {
                    pdo_update('sudu8_page_forms_config', $dataForms ,array('uniacid' => $uniacid));
                }
                //添加优惠券
                $dataCoupon = array(
                    'uniacid' => $uniacid,
                    'num' => 9,
                    'title' => '满1000立减100',
                    'color' => '#737373',
                    'price' => 100,
                    'pay_money' => '1000',
                    'counts' => 999,
                    'xz_count' => 1,
                    'btime' => '1512486016',
                    'etime' => '1534559624',
                    'flag' => 1,
                    );
                if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_coupon', $dataCoupon);
                    } else {
                        pdo_update('sudu8_page_coupon', $dataCoupon ,array('uniacid' => $uniacid));
                    }
                 //基础信息
                    $dataBase = array(
                        'uniacid' => $uniacid,
                        'index_style' => 'slide',
                        'slide' =>'a:2:{i:0;s:48:"http://p2bwp6sww.bkt.clouddn.com/jshs/slide1.jpg";i:1;s:48:"http://p2bwp6sww.bkt.clouddn.com/jshs/slide2.jpg";}',  //幻灯片
                        'banner'=>'http://p2bwp6sww.bkt.clouddn.com/jshs/logo_bg.jpg',  //门店背景
                        'logo'=>'',  //logo
                        'name' => '健身会所',
                        'desc'=>'健身会所',   //门店特色
                        'address' => '南通世纪大道8888号',
                        'time' => '8:30 - 18:00',
                        'tel' => '15111111111',
                        'latitude' => '31.983310',
                        'longitude' => '120.946330',
                        'about' => '健身会所',
                        //样式DIY
                        'base_color'=> '#4d4d4d',  //小程序头底主色
                        'base_tcolor'=> '#ffffff', //小程序头底文字色
                        'base_color2'=> '#414147',  //小程序突出颜色
                        'base_color_t'=> '#ffffff', //默认样式标题颜色 公司介绍页
                        'config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"0";s:8:"userFood";s:1:"0";}',
                        'index_style'=> 'slide',//header背景、标题、logo  slide纯幻灯片[基础设置]  newslide新幻灯片[带连接]
                        'tel_box'=> 1,//首页电话、时间区块 1显示 0不显示
                        'aboutCN' => '教育简介2',   //首页介绍板块栏目名
                        'aboutCNen' => 'About Company',//首页介绍板块栏目英文名
                        'index_about_title' => '9', //介绍板块标题样式 title1上下结构 title2左右结构  no不显示标题 9本版块隐藏
                        'catename_x'=> '行业资讯', //横排推荐区中文名
                        'catenameen_x'=> 'Industry information',//横排推荐区英文名
                        'i_b_x_ts'=>9,//横排推荐去标题样式 1上下结构 2左右结构  0不显示标题 9本版块隐藏
                        'i_b_x_iw'=> 500,//图片宽度
                        'catename'=>'春节热门线路', //竖排推荐区中文名
                        'catenameen'=>'', //竖排推荐区英文名
                        'i_b_y_ts'=> 9,//竖排
                        'index_pro_lstyle'=> 2,//竖排推荐区列表样式 1单行大图 2两列图片  3三列图片 8单行图文、带简介  3单行图文、带简介、时间、阅读量  4 纯标题样式   list_pic2 老版本修复【小程序版本低于6.0.8】
                        'index_pro_ts_al'=>'tc', //竖排推荐区列表标题 t1【无背景】标题左对齐  tc【无背景】标题居中下方 tlb【透明背景】标题左对齐底部  tcb【透明背景】标题居中底部  none不显示标题
                        'c_b_bg'=> 'http://p2bwp6sww.bkt.clouddn.com/jshs/server_bg.jpg', //服务中心背景图
                        'c_b_btn'=> 2,//服务中心按钮样式 1彩色实心 2白色边框 0首页隐藏
                        'form_index'=> 0,//首页表单  1开启 0不
                        'c_title'=> 2,//内页样式DIY 1带时间标题 2纯标题 0隐藏
                        // 'footer_style'=>'none',//老版本修复  底部导航 footer1首页-电话-客服-导航 footer1首页-电话-预约-导航 footer3首页-介绍-服务-预约  none不显示
                        //底部菜单栏
                        'tabbar_t'=>1, //启用底部菜单tabbar 1启用 0不
                        'tabbar_bg'=>'#4d4d4d', //tabbar背景颜色
                        'color_bar'=>'#000000',//tabbar顶部横线颜色
                        'tabbar_tc'=>'#ffffff',//tabbar文字颜色
                        'tabbar_tca'=>'#ffffff',//选中颜色
                        'tabbar'=>'a:3:{i:0;s:207:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:49:"http://p2bwp6sww.bkt.clouddn.com/jshs/tabbar1.png";s:9:"tabbar_p2";s:49:"http://p2bwp6sww.bkt.clouddn.com/jshs/tabbar1.png";}";i:1;s:213:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:12:"项目预约";s:9:"tabbar_p1";s:49:"http://p2bwp6sww.bkt.clouddn.com/jshs/tabbar2.png";s:9:"tabbar_p2";s:49:"http://p2bwp6sww.bkt.clouddn.com/jshs/tabbar2.png";}";i:2;s:220:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:49:"http://p2bwp6sww.bkt.clouddn.com/jshs/tabbar3.png";s:9:"tabbar_p2";s:49:"http://p2bwp6sww.bkt.clouddn.com/jshs/tabbar3.png";}";}',
                        'hxmm'=> 'hx123456',
                        'logo2'=> '',
                    );
                    if (empty($item['uniacid'])) {
                        pdo_insert('sudu8_page_base', $dataBase);
                    } else {
                        pdo_update('sudu8_page_base', $dataBase ,array('uniacid' => $uniacid));
                    }
            }
        return 1;
        //message('一键制作成功!', $this->createWebUrl('copyright', array('op'=>'making')), 'success');
    }   
}