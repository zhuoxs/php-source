<?php 

load()->func('tpl');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$opt = $_GPC['opt'];
$ops = array('display','delete','post','types');
$opt = in_array($opt, $ops) ? $opt : 'display';
if ($opt == 'display') {
    $sid = $_GPC['sid'];
    $skey = $_GPC['skey'];
    $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showPro' and cid = 0", array(':uniacid' => $uniacid));
    foreach ($cates as $key => &$res) {
        $res['ziji'] = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showPro' and cid = :cid", array(':uniacid' => $uniacid,':cid' => $res['id']));
    }
    $where = "";
    if($sid>0){
        $where.=" and a.cid = {$sid}";
    }
    if($skey != null){
        $where.=" and a.title like '%{$skey}%'";
    }

    $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_products') ." as a LEFT JOIN ".tablename('sudu8_page_cate')." as b on a.cid = b.id WHERE a.uniacid = :uniacid and a.is_more = 3 ".$where." order by a.num desc,a.id desc", array(':uniacid' => $uniacid));
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize = 10;  
    $start = ($pageindex-1) * $pagesize;
    $pager = pagination($total, $pageindex, $pagesize);
    $products = pdo_fetchall("SELECT a.*,b.name as cname FROM ".tablename('sudu8_page_products') ." as a LEFT JOIN ".tablename('sudu8_page_cate')." as b on a.cid = b.id WHERE a.uniacid = :uniacid and a.is_more = 3 ".$where." order by a.num desc,a.id desc LIMIT ".$start.",".$pagesize, array(':uniacid' => $uniacid));
    foreach ($products as $key => &$value) {
        $value['type_values'] = pdo_getall("sudu8_page_duo_products_type_value", array("pid"=>$value['id']));
    }
}
if ($opt == 'delete') {
    $id = intval($_GPC['id']);
    pdo_delete('sudu8_page_products', array('id' => $id ,'uniacid' => $uniacid));
    pdo_delete('sudu8_page_duo_products_type_value', array('pid' => $id));
    message('删除成功!', $this->createWebUrl('Commentset', array('op'=>'duogoods','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
}
$id = $_GPC['id'];
if($opt == "post"){


    $stores = pdo_fetchall("SELECT id,title FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

    $rechargeConf = pdo_get("sudu8_page_rechargeconf", array("uniacid"=>$uniacid));
    $listV = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE cid = :cid and uniacid = :uniacid and type='showPro' ORDER BY num DESC,id DESC", array(':cid' => 0 ,':uniacid' => $uniacid));
    $listAll = array();
    foreach($listV as $key=>$val) {
        $cid = intval($val['id']);
        $listP = pdo_fetch("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and id = :id and type='showPro' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
        $listS = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and cid = :id and type='showPro' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
        $listP['data'] = $listS;
        array_push($listAll,$listP);
    }
    $forms = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE uniacid = :uniacid order by id desc", array(':uniacid' => $uniacid));

    $products = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid, ':id'=>$id));
    if(!empty($products['vipconfig'])){
        $products['vipconfig'] = unserialize($products['vipconfig']);
    }

    $stores_now = explode(",",$products['stores']);
    $products['imgtext'] = unserialize($products['text']); 
    $products['discount'] = unserialize($products['discount']); 

    $grade_arr = pdo_fetchall("SELECT id,grade,name FROM ".tablename('sudu8_page_vipgrade')." WHERE uniacid = :uniacid order by grade asc", array(":uniacid" => $uniacid));
    if(empty($grade_arr)){
        $data_s = [
            'uniacid' => $uniacid,
            'grade' => 1,
            'name' => '大众会员',
            'upgrade' => 0,
            'price' => 0,
            'status' => 1,
            'bgcolor' => '#434550',
            'card_img' => 'static/images/vip_card.png',
            'descs' => '默认会员等级'
        ];
        pdo_insert('sudu8_page_vipgrade',$data_s);
        $grade_arr[0]['name'] = '大众会员';
        $grade_arr[0]['grade'] = 1;
        $grade_arr[0]['id'] = pdo_insertid();
    }

    foreach ($grade_arr as $key => $value) {
        foreach ($products['discount'] as $ks => $vs) {
            if($value['grade'] == $vs['grade']){
                $grade_arr[$key]['discount'] = $vs['discount'];
            }
        }
    }



    // var_dump($products);
    // die();

    if (checksubmit('submit')) { 
        $stores_arr = implode(",", $_GPC['stores']);
        $cid = intval($_GPC['cid']);
        $pcid = pdo_fetch("SELECT cid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id =:id ", array(':uniacid' => $uniacid,':id'=>$cid));
        $pcid=implode('',$pcid);
        if($pcid == 0){
            $pcid = $cid;
        }else{
            $pcid = intval($pcid);
        }
//        var_dump($_GPC['kuaidi']);
//        exit();
        $discount_status = $_GPC['discount_status'];
        $valarr = $_GPC['valarr'];
        $discount = [];
        foreach ($grade_arr as $ki => $vi) {
            foreach ($valarr as $key => $value) {
                if($ki == $key){
                    $discount[$ki]['grade'] = $vi['grade'];
                    $discount[$ki]['discount'] = $value;
                    continue;
                }
            }
        }
        $data = array(
            "uniacid" => $_W['uniacid'],
            "num" => $_GPC['num'],
            "cid" => $_GPC['cid'],
            "pcid" => $pcid,
            "type_x" => $_GPC['type_x'],
            "type_y" => $_GPC['type_y'],
            "type_i" => $_GPC['type_i'],
            "is_sale"=>$_GPC['is_sale'],
            "type" => "showProMore",
            "thumb" => $_GPC['thumb'],

            'shareimg'=>$_GPC['shareimg'],
            
            "title" => $_GPC['title'],
            "price" => $_GPC['priceq'],
            "market_price" => $_GPC['market_price'],
            "desc" => $_GPC['descs'],
            'text' => serialize($_GPC['imgtext']),
            'labels' => $_GPC['explains'],
            'is_more' => 3,

            'fx_uni' => $_GPC['fx_uni'],
            'commission_type' => $_GPC['commission_type'],
            'commission_one' => $_GPC['commission_one'],
            'commission_two' => $_GPC['commission_two'],
            'commission_three' => $_GPC['commission_three'],

            'get_share_gz'=>$_GPC['get_share_gz'],
            'get_share_score'=>$_GPC['get_share_score'],
            'get_share_num'=>$_GPC['get_share_num'],
            
            'formset'=>$_GPC['formset'],
            "product_txt" => htmlspecialchars_decode($_GPC['product_txt'], ENT_QUOTES),
            "score" => $_GPC['score'],
            "scoreback" => $_GPC['scoreback'],
            "kuaidi" => $_GPC['kuaidi'],
            "hits" => $_GPC["hits"],
            'stores' => $stores_arr,
            'discount_status' => $discount_status,
            'discount' => serialize($discount),
            'is_spec' => $_GPC['is_spec'],
            'spec_con' => $_GPC['spec_con'],
            'is_server' => $_GPC['is_server'],
            'server_con' => $_GPC['server_con'],
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
        if($id){
            $res = pdo_update('sudu8_page_products', $data, array('id' => $id));
            message('更新成功!', $this->createWebUrl('Commentset', array('op'=>'duogoods','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'],'id'=>$id)), 'success');
        }else{
            $res = pdo_insert('sudu8_page_products', $data);
            if (!empty($res)) {
                $id = pdo_insertid();
                message('新增成功!', $this->createWebUrl('Commentset', array('op'=>'duogoods','opt'=>"types",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'],'id'=>$id)), 'success');
            }
        }
    }
}  
if($opt == "types"){
    $id = $_GPC['id'];
    $products = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid, ':id'=>$id));
    $products['types'] = $products['pro_flag'];
    if($products['pro_flag']==2){
        $proarr = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_type_value') ." WHERE pid = :pid order by id asc", array(':pid'=>$id));
        $types = $proarr[0]['comment'];    
        //构建规格组
        $typesarr = explode(",", $types);  
        $counttypes = count($typesarr);
        // 构建规格组json
        $typesjson = [];
        foreach ($typesarr as $key => &$rec) {
            $str = "type".($key+1);
            $ziji = pdo_fetchall("SELECT ".$str." FROM ".tablename('sudu8_page_duo_products_type_value') ." WHERE pid = :pid order by id asc ", array(':pid'=>$id)); 
            $xarr = array();
            foreach ($ziji as $key => $res) {
                array_push($xarr, $res[$str]);
            }
            $typesjson[$rec] = array_unique($xarr);
        }
        // 构建对应的数值
        $datajson = [];
        
        foreach ($proarr as $key => &$rec) {
            $strs = $rec['type1'].$rec['type2'].$rec['type3'];
            $strv = $rec['kc'].",".$rec['price'].",".$rec['hnum']."," . $rec['vsalenum'] . "," . $rec['salenum'] . "," . $rec['thumb'];
            $datajson[$strs]=$strv;
        }

    }
    if($products['pro_flag']==1){
        $proarr = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_type_value') ." WHERE pid = :pid order by id asc", array(':pid'=>$id));
        // var_dump($proarr);
        // die();
    }
    if (checksubmit('submit')) {
        //是否启用规则
        $guig = $_GPC['ischeck'];
        $kdatas = array(
            "pro_flag" => $guig
        );
        $rek = pdo_update('sudu8_page_products', $kdatas, array('id' => $id ,'uniacid' => $uniacid));
        // 全部删除已有数据
        pdo_delete('sudu8_page_duo_products_type_value', array('pid' => $id));
        if($guig == 2){
            // 规格组长度
            $typelen = $_GPC['typelen'];
            // 规格数组
            $types = $_GPC['typesarr'];
            $typezz = $types;
            $typesarr = explode(",", $types);

            // 子商品
            $ggarr = stripslashes(html_entity_decode($_GPC['biaogedata']));

            $proarr = json_decode($ggarr,true);
            $count = 0;

            foreach ($proarr as $key => $rec) {
                if($typelen == 1){
                    $type1 = $rec[$typesarr[0]];
                    $type2 = "";
                    $type3 = "";
                }
                if($typelen == 2){
                    $type1 = $rec[$typesarr[0]];
                    $type2 = $rec[$typesarr[1]];
                    $type3 = "";
                }
                if($typelen == 3){
                    $type1 = $rec[$typesarr[0]];
                    $type2 = $rec[$typesarr[1]];
                    $type3 = $rec[$typesarr[2]];
                }

                $data = array(
                    "pid" => $id,
                    "type1" => $type1,
                    "type2" => $type2,
                    "type3" => $type3,
                    "kc" => $rec['库存'],
                    "price" => $rec['价格'],
                    "hnum" => $rec['货号'],
                    "salenum" => $rec['真实销量'],
                    "vsalenum" => $rec['虚拟销量'],
                    "thumb" => $rec['规格图片'],
                    "comment" => $typezz
                );

                $res = pdo_insert("sudu8_page_duo_products_type_value",$data);
                if($res){
                    $count++;
                    if($count == count($proarr)){
                        message('新增/修改成功!', $this->createWebUrl('Commentset', array('op'=>'duogoods','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
                    }
                }
            }
        }else{
            $data = array(
                "pid" => $id,
                "type1" => "默认",
                "type2" => "",
                "type3" => "",
                "kc" => $_GPC['nokc'],
                "price" => $_GPC['noprice'],
                "hnum" => 0,
                "thumb" => $_GPC['nothumb'],
                "comment" => "规格"
            );
            $res = pdo_insert("sudu8_page_duo_products_type_value",$data);
            message('新增/修改成功!', $this->createWebUrl('Commentset', array('op'=>'duogoods','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }
    }
}
return include self::template('web/Commentset/duogoods');