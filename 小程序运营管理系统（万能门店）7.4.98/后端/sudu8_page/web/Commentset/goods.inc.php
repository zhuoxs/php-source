<?php
    global $_GPC, $_W;
    $opt = $_GPC['opt'];
    $ops = array('display', 'post','consumption', 'delete','getcates');
    $opt = in_array($opt, $ops) ? $opt : 'display';
    $uniacid = $_W['uniacid'];

    //产品列表
    if ($opt == 'display'){
        $_W['page']['title'] = '产品管理';
        $sid = $_GPC['sid'];
        $skey = $_GPC['skey'];
        $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showPro' and cid = 0", array(':uniacid' => $uniacid));
        foreach ($cates as $key => &$res) {
            $res['ziji'] = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showPro' and cid = :cid", array(':uniacid' => $uniacid,':cid' => $res['id']));
        }
        $where = "";
        if($sid>0){
            $where.=" and i.cid = {$sid}";
        }
        if($skey != null){
            $where.=" and i.title like '%{$skey}%'";
        }

        $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_products')."as i left join" .tablename('sudu8_page_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." and i.type ='showPro' and i.is_more = 0 ".$where);
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;  
        $start = ($pageindex-1) * $pagesize;
        $pager = pagination($total, $pageindex, $pagesize);
        //$products = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_products') ." WHERE uniacid = :uniacid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));
        $products = pdo_fetchall("SELECT i.num,i.thumb,i.title,i.id,c.name,i.type,i.is_more,i.buy_type,i.price,i.sale_num,i.sale_tnum FROM ".tablename('sudu8_page_products')."as i left join" .tablename('sudu8_page_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." and i.type ='showPro' and i.is_more = 0 ".$where." ORDER BY i.num DESC,i.id DESC LIMIT ".$start.",".$pagesize);
        foreach ($products as $key => &$value) {
            $orders_l = pdo_fetchall("SELECT num FROM ".tablename('sudu8_page_order')." WHERE pid = :pid and uniacid = :uniacid and flag > 0" , array(':pid' => $value['id'] ,':uniacid' => $uniacid));
            $sum = 0;
            if($orders_l){
                foreach ($orders_l as $rec) {
                    $sum += intval($rec['num']);
                }
            }
            $value['realnum'] = $sum;
        }
    }
    if ($opt == 'consumption'){
    }
    if($opt == 'getcates'){
        // $id = intval($_GPC['id']);
        // $cates = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_multicate')." WHERE id = :id and uniacid = :uniacid", array(':id' => $id, ':uniacid' => $uniacid ));
        // $catelists= array();
        // foreach (unserialize($cates['cid']) as $key => $value) {
        //     $arr = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE cid = :cid or id=:cid order by id asc", array(':cid' => $value ));
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
    //产品添加、修改
    if ($opt == 'post'){
        $id = intval($_GPC['id']);
        
        $grade_arr = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_vipgrade')." WHERE uniacid = :uniacid order by grade asc", array(':uniacid' => $uniacid));

        $stores = pdo_fetchall("SELECT id,title FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

        $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
        if(!empty($item['vipconfig'])){
            $item['vipconfig'] = unserialize($item['vipconfig']);
        }
        $stores_now = explode(",",$item['stores']);
        $gwcforms = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE uniacid = :uniacid order by id desc", array(':uniacid' => $uniacid));
        $rechargeConf = pdo_get("sudu8_page_rechargeconf", array("uniacid"=>$uniacid));
        
        if($item['mcid']){
            $mcid = explode(',',$item['mcid']);
            if(count($mcid)>=2){
                $item['cid2'] = $mcid[0];
                $item['cid3'] = $mcid[1];
            }else{
                $item['cid2'] = $mcid[0];
            }
        }

        $yunfei_gg_list = pdo_fetchall("SELECT id,name FROM ".tablename('sudu8_page_freight')." WHERE uniacid = :uniacid and is_delete = 0", array(':uniacid' => $uniacid));

        $orders_l = pdo_fetchall("SELECT num FROM ".tablename('sudu8_page_order')." WHERE pid = :pid and uniacid = :uniacid and flag > 0" , array(':pid' => $id ,':uniacid' => $uniacid));
        if($item){

            $item['text'] = unserialize($item['text']);
            if($item['sale_time']!=0){
                $item['sale_time'] = date("Y-m-d H:i:s",$item['sale_time']);
            }
            if($item['sale_end_time']!=0){
                $item['sale_end_time'] = date("Y-m-d H:i:s",$item['sale_end_time']);
            }
        }
        $listV = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE cid = :cid and uniacid = :uniacid and type='showPro' ORDER BY num DESC,id DESC", array(':cid' => 0 ,':uniacid' => $uniacid));
        $listAll = array();
        foreach($listV as $key=>$val) {
            $cid = intval($val['id']);
            $listP = pdo_fetch("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and id = :id and type='showPro' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
            $listS = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and cid = :id and type='showPro' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
            $listP['data'] = $listS;
            array_push($listAll,$listP);

        }

        //得到所有的多栏目
        $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_multicate') ." WHERE uniacid = :uniacid and statue = 1 and type='showPro' ORDER BY id DESC", array(':uniacid' => $uniacid));

        if($item['top_catas']){
            $sql = "SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `id` IN (".$item['top_catas'].") and `uniacid` = ". $uniacid;
            $sons_keys = pdo_fetchall($sql);

            foreach ($sons_keys as $k => $v){
                $sql = "SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `pid` = {$v['id']} and `uniacid` = ". $uniacid;
                $sons_keys[$k]['sons'] = pdo_fetchall($sql);
            }
        }else{
            $sons_keys = [];
        }

        if (!empty($id)) {
            if (empty($item)) {
                message('抱歉，产品不存在或是已经删除！', '', 'error');
            }
        }
        if (checksubmit('submit')) {
            if (empty($_GPC['cid'])){
                message('栏目不能为空，请选择栏目');
            }
            $sale_time = strtotime($_GPC['sale_time']);
            $sale_end_time = strtotime($_GPC['sale_end_time']);
            if($sale_end_time != 0 && $sale_end_time < $sale_time){
                message('秒杀结束时间不能少于秒杀开始时间');
            }
            if (empty($_GPC['price'])) {
                message('门店价不能为空，请输入门店价');
            }
            if (empty($_GPC['thumb'])) {
                message('缩略图不能为空');
            }
            if (empty($_GPC['text'])) {
                message('商品主图不能为空，请上传！');
            }
            if (empty($_GPC['title'])) {
                message('标题不能为空，请输入标题！');
            }
            if (empty($_GPC['buy_type'])) {
                message('自定义购买方式不能为空！');
            }
            $stores_arr = implode(",", $_GPC['stores']);

            $cid = intval($_GPC['cid']);
            $pcid = pdo_fetch("SELECT cid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id =:id ", array(':uniacid' => $uniacid,':id'=>$cid));
            $pcid=implode('',$pcid);
            if($pcid == 0){
                $pcid = $cid;
            }else{
                $pcid = intval($pcid);
            }
            if($_GPC['cid2']&&$_GPC['cid3']==0){
                $mcid = $_GPC['cid2'].',0';
            }elseif($_GPC['cid3']&&$_GPC['cid2']==0){
                $mcid ='0,'.$_GPC['cid3'];
            }
            elseif($_GPC['cid2'] && $_GPC['cid3']){
                $mcid = $_GPC['cid2'].",".$_GPC['cid3'];
            }else{
                $mcid = 0;
            }

            $sql = "SELECT `top_catas` FROM ".tablename('sudu8_page_multicate')." WHERE `id` = {$_GPC['mulitcataid']} and `uniacid` = ". $uniacid;
            $top_catas = pdo_fetch($sql);

            $data = array(
                'uniacid' => $_W['uniacid'],
                'cid' => intval($_GPC['cid']),
                'pcid' => $pcid,
                'num' => intval($_GPC['num']),
                'type' => 'showPro',
                'type_x' => intval($_GPC['type_x']),
                'type_y' => intval($_GPC['type_y']),
                'type_i' => intval($_GPC['type_i']),
                'is_sale' => intval($_GPC['is_sale']),
                'hits' => intval($_GPC['hits']),
                'sale_num' => intval($_GPC['sale_num']),
                'title' => addslashes($_GPC['title']),
                'text' => serialize($_GPC['text']),
                'thumb'=>$_GPC['thumb'],
                'shareimg'=>$_GPC['shareimg'],
                'desc'=>$_GPC['desc'],
                'ctime' => TIMESTAMP,
                'price'=>$_GPC['price'],
                'market_price'=>$_GPC['market_price'],
                'score'=>$_GPC['score'],
                'pro_flag'=>$_GPC['pro_flag'],
                'pro_flag_tel'=>$_GPC['pro_flag_tel'],
                'pro_flag_add'=>$_GPC['pro_flag_add'],
                'pro_flag_data'=>$_GPC['pro_flag_data'],
                'pro_flag_data_name'=>$_GPC['pro_flag_data_name'],
                'pro_flag_time'=>$_GPC['pro_flag_time'],
                'pro_flag_ding'=>0,       //是否确认订单，已弃用
                'pro_kc'=>$_GPC['pro_kc'],
                'pro_xz'=>$_GPC['pro_xz'],
                'product_txt'=>htmlspecialchars_decode($_GPC['product_txt'], ENT_QUOTES),
                'sale_time'=>strtotime($_GPC['sale_time']),
                'sale_end_time'=>strtotime($_GPC['sale_end_time']),
                'labels'=>$_GPC['labels'],
                'buy_type'=>$_GPC['buy_type'],
                'formset'=>$_GPC['formset'],
                'con2'=>$_GPC['con2'],
                'con3'=>$_GPC['con3'],
                // 'share_type'=>$_GPC['share_type'],
                // 'share_score'=>$_GPC['share_score'],
                'share_num'=>$_GPC['share_num'],
                // 'share_gz'=>$_GPC['share_gz'],
                'get_share_gz'=>$_GPC['get_share_gz'],
                'get_share_score'=>$_GPC['get_share_score'],
                'get_share_num'=>$_GPC['get_share_num'],
                // 'comment'=>$_GPC['comment'],
                'mulitcataid' => $_GPC['mulitcataid'],
                'sons_catas' => $_GPC['sons']?implode(',',$_GPC['sons']):'',
                'top_catas' =>$top_catas?$top_catas['top_catas']:'',
                'scoreback' => $_GPC['scoreback'],
                'kuaidi'=>$_GPC['kuaidi'],
                'fx_uni' => $_GPC['fx_uni'],
                'commission_type' => $_GPC['commission_type'],
                'commission_one' => $_GPC['commission_one'],
                'commission_two' => $_GPC['commission_two'],
                'commission_three' => $_GPC['commission_three'],
                'stores' => $stores_arr,
                'yunfei_ggid' => $_GPC['yunfei_ggid']
            );
            $set1 = $_GPC["set1"];
            $set2 = $_GPC["set2"];
            $set3 = $_GPC["set3"];
            $vipconfig = array(
                "set1" => $set1,
                "set2" => $set2,
                "set3" => $set3,
                );
            $data['vipconfig']  = serialize($vipconfig);
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
                    $proid = pdo_delete('sudu8_page_multipro', array('proid' => $id));
                }else{
                    $proid = pdo_fetch("SELECT id FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid order by id desc", array(':uniacid' => $uniacid));
                    $multi['proid'] = $proid['id'];
                }
            }

            message('产品 添加/修改 成功!', $this->createWebUrl('Commentset', array('op'=>'goods','opt'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }
    }
    //删除产品
    if ($opt == 'delete') {
        $id = intval($_GPC['id']);
        $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
        if (empty($row)) {
            message('产品不存在或是已经被删除！');
        }
        pdo_delete('sudu8_page_products', array('id' => $id ,'uniacid' => $uniacid));
        message('删除成功!', $this->createWebUrl('Commentset', array('op'=>'goods','opt'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    }





return include self::template('web/Commentset/goods');
