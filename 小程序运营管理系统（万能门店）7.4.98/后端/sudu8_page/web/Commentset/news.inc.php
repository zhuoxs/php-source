<?php

    load()->func('tpl');
        global $_GPC, $_W;
        $opt = $_GPC['opt'];
        $ops = array('display','post', 'delete','getcates','searchs','getnews');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        $uniacid = $_W['uniacid'];

        if($opt=='searchs'){
            $keys=$_GPC['keys'];
            $pros = pdo_fetchall("SELECT title,id FROM ".tablename('sudu8_page_products')." WHERE uniacid = ".$uniacid." and type ='showArt' and title like :keys ORDER BY num DESC,id DESC",array('keys'=>"%".$keys."%"));
            echo json_encode($pros);
            exit;
        }
        if($opt=='getnews'){
            $id=$_GPC['id'];
            $pros = pdo_fetch("SELECT title,id FROM ".tablename('sudu8_page_products')." WHERE uniacid = ".$uniacid." and type ='showArt' and id = :id ",array(":id"=>$id));
            echo json_encode($pros);
            exit;
        }
        //文章列表
        if ($opt == 'display'){
            $_W['page']['title'] = '文章管理';
            // 获取文章分类
            $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showArt' and cid = 0", array(':uniacid' => $uniacid));
            foreach ($cates as $key => &$res) {
                $res['ziji'] = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showArt' and cid = :cid", array(':uniacid' => $uniacid,':cid' => $res['id']));
            }

            $where = "";
            if(!empty($_GPC['sid']) || !empty($_GPC['skey'])){
                if(!empty($_GPC['sid']) && $_GPC['sid'] > 0){
                    $sid = $_GPC['sid'];
                    $where .= " and i.cid = ".$sid;
                }
                if(!empty($_GPC['skey'])){
                    $skey = $_GPC['skey'];
                    $where .= " and i.title like '%".$skey."%'";
                }
            }

            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_products')."as i left join" .tablename('sudu8_page_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." and i.type ='showArt'".$where);
     
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);
            $products = pdo_fetchall("SELECT i.num,i.thumb,i.title,i.id,c.name,i.type FROM ".tablename('sudu8_page_products')."as i left join" .tablename('sudu8_page_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." and i.type ='showArt' ".$where." ORDER BY i.num DESC,i.id DESC LIMIT ".$start.",".$pagesize);

        }
        if($opt == 'getcates'){
            $id = intval($_GPC['id']);

            $sql = "SELECT `top_catas` FROM ".tablename('sudu8_page_multicate')." WHERE `id` = {$id} and `uniacid` = ".$uniacid;
            $top_catas = pdo_fetch($sql);

            $top_catalist = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `id` IN (".$top_catas['top_catas'].")");
            foreach ($top_catalist as $k => $v){
                $sql = "SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `pid` = {$v['id']} and `uniacid` = ".$uniacid;
                $top_catalist[$k]['sons'] = pdo_fetchall($sql);
            }
            $data['sons'] = $top_catalist;
            $data['catelists'] = $catelists;

            echo json_encode($data, JSON_UNESCAPED_UNICODE);


            exit;
        }
        //文章添加、修改
        if ($opt == 'post'){
            $id = intval($_GPC['id']);
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if($item['edittime'] != null){
                $item['edittime'] = date("Y-m-d H:i:s", $item['edittime']);
            }
            if($item['music_art_info'] == ""){
                $item['music_art_info']['musicTitle'] = "";
                $item['music_art_info']['music'] = "";
                $item['music_art_info']['music_price'] = "";
                $item['music_art_info']['autoPlay'] = "";
                $item['music_art_info']['loopPlay'] = "";
                $item['music_art_info']['art_price'] = "";
                $item['music_art_info']['musictype'] = "";
            }else{
                $item['music_art_info'] = unserialize($item['music_art_info']);
                if(!isset($item['music_art_info']['musictype'])){
                    $item['music_art_info']['musictype'] = 1;
                }
            }
            $glnews=array();
            if($item['glnews']!=""){
                $news = unserialize($item['glnews']);
                foreach($news as $k => $v){
                    $glnews[$k] = pdo_fetch("SELECT id,title FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid and flag =1 ", array(':id' => $v ,':uniacid' => $uniacid));
                }
            }

            if(stristr($item['share_score'], 'http') || stristr($item['share_score'], 'sudu8_page')){
                $item['weburl'] = $item['share_score'];
                $item['share_score'] = "";
            }

            $forms = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE uniacid = :uniacid ORDER BY ID DESC", array(':uniacid' => $uniacid));
            $catelist = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_art_nav') ." WHERE uniacid = :uniacid ORDER BY num DESC", array(':uniacid' => $uniacid));
            $listV = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE cid = :cid and uniacid = :uniacid and type='showArt' ORDER BY num DESC,id DESC", array(':cid' => 0 ,':uniacid' => $uniacid));
            $listAll = array();

            foreach($listV as $key=>$val) {

                $cid = intval($val['id']);
                $listP = pdo_fetch("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and id = :id and type='showArt' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
                $listS = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and cid = :id and type='showArt' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
                $listP['data'] = $listS;
                array_push($listAll,$listP);

            }
            //得到所有的多栏目
            $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_multicate') ." WHERE uniacid = :uniacid and statue = 1 and type='showArt' ORDER BY id DESC", array(':uniacid' => $uniacid));
            //得到产品所属的栏目
            /*没有数据库，当前内容也无用*/
            #$multipro = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_multipro') ." WHERE proid = :proid", array(':proid' => $id));

            /*无用可删*/
            /*获取全部子级的主键*/
            if($item['top_catas']){
                $sql = "SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `id` IN (".$item['top_catas'].") and `uniacid` = ".$uniacid;
                $sons_keys = pdo_fetchall($sql);

                foreach ($sons_keys as $k => $v){
                    $sql = "SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `pid` = {$v['id']} and `uniacid` = ".$uniacid;
                    $sons_keys[$k]['sons'] = pdo_fetchall($sql);
                }
            }else{
                $sons_keys = [];
            }

            if (!empty($id)) {
                if (empty($item)) {
                    message('抱歉，文章不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')) {
                if (empty($_GPC['title'])) {
                    message('标题不能为空，请输入标题！');
                }

                $cid = intval($_GPC['cid']);
                $pcid = pdo_fetch("SELECT cid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id =:id ", array(':uniacid' => $uniacid,':id'=>$cid));
                $pcid=implode('',$pcid);
                if($pcid == 0){
                    $pcid = $cid;
                }else{
                    $pcid = intval($pcid);
                }

                /*获得多栏目分类的ID，取父主键，以及子主键保存*/
                #$multicataid = $_GPC['muiltcate'];

                $sql = "SELECT `top_catas` FROM ".tablename('sudu8_page_multicate')." WHERE `id` = {$_GPC['mulitcataid']} and `uniacid` = ".$uniacid;
                $top_catas = pdo_fetch($sql);


                $sons = $_GPC['sons'];
                if(count($sons) > 0){
                    $sons = implode(',',$sons);
                }
                else{
                    $sons = '';
                }
                if(is_null($_GPC['price'])){
                    $price = 0;
                }else{
                    $price = floatval($_GPC['price']);
                }
                if(is_null($_GPC['market_price'])){
                    $market_price = "false";
                }else{
                    $market_price = $_GPC['market_price'];
                }
                // $choose = $_GPC['choose'];
                if(!is_null($_GPC['choose'])){
                    $choose = serialize(array_values(array_unique($_GPC['choose'])));
                }else{
                    $choose="";
                }

                if(stristr($_GPC['weburl'], 'http') || stristr($_GPC['weburl'], 'sudu8_page')){
                    $page_type = $_GPC['weburl'];
                }else{
                    $page_type = $_GPC['share_score'];
                }


                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'cid' => intval($_GPC['cid']),
                    'pcid' => $pcid,
                    'type' => 'showArt',
                    'num' => intval($_GPC['num']),
                    'type_x' => intval($_GPC['type_x']),
                    'type_y' => intval($_GPC['type_y']),
                    'type_i' => intval($_GPC['type_i']),
                    'hits' => intval($_GPC['hits']),
                    'title' => addslashes($_GPC['title']),
                    'text' => htmlspecialchars_decode($_GPC['text'], ENT_QUOTES),
                    'thumb'=>$_GPC['thumb'],
                    'glnews'=> $choose,
                    'shareimg'=>$_GPC['shareimg'],
                    'video'=>$_GPC['video'],
                    'desc'=>$_GPC['desc'],
                    'ctime' => TIMESTAMP,
                    'formset' => $_GPC['formset'],
                    // 'share_type'=>$_GPC['share_type'],
                    'share_score'=>$page_type,
                    // 'share_num'=>$_GPC['share_num'],

                    'get_share_gz'=>$_GPC['get_share_gz'],
                    'get_share_score'=>$_GPC['get_share_score'],
                    'get_share_num'=>$_GPC['get_share_num'],

                    'fx_uni' => $_GPC['fx_uni'],
                    'commission_type' => $_GPC['commission_type'],
                    'commission_one' => $_GPC['commission_one'],
                    'commission_two' => $_GPC['commission_two'],
                    'commission_three' => $_GPC['commission_three'],

                    // 'share_gz'=>$_GPC['share_gz'],
                    'comment'=>$_GPC['comment'], //是否开启评论
                    'top_catas' => $top_catas['top_catas'],//顶级主键关联
                    'sons_catas' => $sons, //子级主键关联,
                    'mulitcataid' => $_GPC['mulitcataid'],//关联文章
                    'price'=> $price,//付费视频
                    'market_price'=>$market_price,//自动播放
                    'labels' => $_GPC['labels'],//视频封面
                    'pro_flag' => intval($_GPC['pro_flag']),
                    'edittime' => $_GPC['edittime'] != "" ? strtotime($_GPC['edittime']) : ""
                );


                $music_art_info = array(
                    "musicTitle" => $_GPC['musicTitle'],
                    "art_price" => $_GPC['art_price'],
                    "music" => $_GPC['music'],
                    "music_price" => $_GPC['music_price'],
                    "autoPlay" => $_GPC['autoPlay'],
                    "loopPlay" => $_GPC['loopPlay'],
                    "musictype" => $_GPC['musictype'],
                    );
                $data['music_art_info'] = serialize($music_art_info);


                //var_dump($data);exit;
                $muiltcate = $_GPC["muiltcate"];
                if($muiltcate!= "0"){
                    $data['multi'] = 1;
                }else{
                   $data['multi'] = 0;
                }
                $multipros = array();
                if (!empty($_GPC['thumb'])) {
                    $data['thumb'] = parse_path($_GPC['thumb']);
                }

                if (empty($id)) {
                    $res = pdo_insert('sudu8_page_products', $data);

                } else {
                    unset($data['ctime']);
                    $data['etime '] = TIMESTAMP;
                    $res = pdo_update('sudu8_page_products', $data, array('id' => $id ,'uniacid' => $uniacid));
                }

                if($muiltcate!="0"){

                    if($id){
                        $multi['proid'] = $id;
                        #$proid = pdo_delete('sudu8_page_multipro', array('proid' => $id));
                    }else{
                        $proid = pdo_fetch("SELECT id FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid order by id desc", array(':uniacid' => $uniacid));
                        $multi['proid'] = $proid['id'];
                    }
                    
                    $multi['multi_id'] = intval($muiltcate);
                }
                message('文章 添加/修改 成功!', $this->createWebUrl('Commentset', array('op'=>'news','opt'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'],'id'=>$id)), 'success');
            }
        }
        //删除文章
        if ($opt == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('文章不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_products', array('id' => $id ,'uniacid' => $uniacid));
             message('删除成功', $this->createWebUrl('Commentset', array('op'=>'news','opt'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }




return include self::template('web/Commentset/news');
