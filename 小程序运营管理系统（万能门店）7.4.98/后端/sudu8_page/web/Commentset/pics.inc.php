<?php
load()->func('tpl');
global $_GPC, $_W;
        $opt = $_GPC['opt'];
        $ops = array('display', 'post', 'delete','getcates');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        $uniacid = $_W['uniacid'];
        //图片列表
        if ($opt == 'display'){
            $_W['page']['title'] = '图片管理';
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
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_products')."as i left join" .tablename('sudu8_page_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." and i.type ='showPic'".$where);
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);  
            $products = pdo_fetchall("SELECT i.num,i.thumb,i.title,i.id,c.name,i.type FROM ".tablename('sudu8_page_products')."as i left join" .tablename('sudu8_page_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." and i.type ='showPic' ".$where." ORDER BY i.num DESC,i.id DESC LIMIT ".$start.",".$pagesize);
            //var_dump($products);
            // 获取文章分类
            $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showPic' and cid = 0", array(':uniacid' => $uniacid));
            foreach ($cates as $key => &$res) {
                $res['ziji'] = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showPic' and cid = :cid", array(':uniacid' => $uniacid,':cid' => $res['id']));
            }
        }
        //图片添加、修改
        if ($opt == 'post'){
            $id = intval($_GPC['id']);

            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if($item){
                $item['text'] = unserialize($item['text']);
            }
            $listV = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE cid = :cid and uniacid = :uniacid and type='showPic' ORDER BY num DESC,id DESC", array(':cid' => 0 ,':uniacid' => $uniacid));
            $listAll = array();
            foreach($listV as $key=>$val) {
                $cid = intval($val['id']);
                $listP = pdo_fetch("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and id = :id and type='showPic' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
                $listS = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and cid = :id and type='showPic' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
                $listP['data'] = $listS;
                array_push($listAll,$listP);
                //echo("<script>console.log('".json_encode($val)."');</script>");
                //var_dump($listV);
            }
             //得到所有的多栏目
            $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_multicate') ." WHERE uniacid = :uniacid and statue = 1 and type='showPic' ORDER BY id DESC", array(':uniacid' => $uniacid));

            /*获取全部子级的主键*/
            if($item['top_catas']){
                $sql = "SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `id` IN (".$item['top_catas'].")  and `uniacid` = ".$uniacid;
                $sons_keys = pdo_fetchall($sql);

                foreach ($sons_keys as $k => $v){
                    $sql = "SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `pid` = {$v['id']}  and `uniacid` = ".$uniacid;
                    $sons_keys[$k]['sons'] = pdo_fetchall($sql);
                }
            }else{
                $sons_keys = [];
            }

            //var_dump($listAll);
            if (!empty($id)) {
                if (empty($item)) {
                    message('抱歉，图片不存在或是已经删除！', '', 'error');
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

                $sql = "SELECT `top_catas` FROM ".tablename('sudu8_page_multicate')." WHERE `id` = {$_GPC['mulitcataid']}  and `uniacid` = ".$uniacid;
                $top_catas = pdo_fetch($sql);

                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'cid' => intval($_GPC['cid']),
                    'pcid' => $pcid,
                    'num' => intval($_GPC['num']),
                    'type' => 'showPic',
                    'type_x' => intval($_GPC['type_x']),
                    'type_y' => intval($_GPC['type_y']),
                    'type_i' => intval($_GPC['type_i']),
                    'hits' => intval($_GPC['hits']),
                    'title' => addslashes($_GPC['title']),
                    'text' => serialize($_GPC['text']),
                    'thumb'=>$_GPC['thumb'],

                    'shareimg'=>$_GPC['shareimg'],

                    'desc'=>$_GPC['desc'],
                    'ctime' => TIMESTAMP,
                    // 'share_type'=>$_GPC['share_type'],
                    // 'share_score'=>$_GPC['share_score'],
                    // 'share_num'=>$_GPC['share_num'],

                    'get_share_gz'=>$_GPC['get_share_gz'],
                    'get_share_score'=>$_GPC['get_share_score'],
                    'get_share_num'=>$_GPC['get_share_num'],

                    // 'share_gz'=>$_GPC['share_gz'],
                    'mulitcataid' => $_GPC['mulitcataid'],
                    'sons_catas' => $_GPC['sons']?implode(',',$_GPC['sons']):'',
                    'top_catas' => $top_catas?$top_catas['top_catas']:''
                );
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
                    pdo_insert('sudu8_page_products', $data);
                } else {
                    unset($data['ctime']);
                    $data['etime '] = TIMESTAMP;
                    pdo_update('sudu8_page_products', $data, array('id' => $id ,'uniacid' => $uniacid));
                }
                if($muiltcate!="0"){
                    if($id){
                        $multi['proid'] = $id;
                        $proid = pdo_delete('sudu8_page_multipro', array('proid' => $id));
                    }else{
                        $proid = pdo_fetch("SELECT id FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid order by id desc", array(':uniacid' => $uniacid));
                        $multi['proid'] = $proid['id'];
                    }
                }
				message('图片 添加/修改 成功!', $this->createWebUrl('Commentset', array('op'=>'pics','opt'=>$opt,'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'],'id'=>$id)), 'success');

            }
        }
        if($opt == 'getcates'){
            // $id = intval($_GPC['id']);
            // $cates = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_multicate')." WHERE id = :id and uniacid = :uniacid", array(':id' => $id, ':uniacid' => $uniacid));
            // $catelists= array();
            // foreach (unserialize($cates['cid']) as $key => $value) {
            //     $arr = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE cid = :cid or id=:cid  order by id asc", array(':cid' => $value ));
            //     array_push($catelists,$arr);
            // }

            // return json_encode($catelists);
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

        //删除图片
        if ($opt == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('图片不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_products', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('Commentset', array('op'=>'pics','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }






return include self::template('web/Commentset/pics');
