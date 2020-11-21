<?php
/**
 * 餐饮小程序模块微站定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page_plugin_food/');
define("HTTPSHOST",$_W['attachurl']);

class Sudu8_page_plugin_foodModuleSite extends WeModuleSite {

    public function doWebBase() {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'post', 'delete');
        $op = in_array($op, $ops) ? $op : 'post';
        $uniacid = $_W['uniacid'];

        //分类修改新增
        if ($op == 'post'){

            $cate = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_sj')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid)); 

            if (checksubmit('submit')) {
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'names' => $_GPC['names'],         
                    'times' => $_GPC['times'],
                    'phone' => $_GPC['phone'],
                    'address' => $_GPC['address'],
                    'tags' => $_GPC['tags'],
                    'notice' => $_GPC['notice'],
                    'fuwu' => $_GPC['fuwu'],
                    'qita' => $_GPC['qita'],
                    'thumb' => $_GPC['thumb'],
                    'usname' => $_GPC['usname'],
                    'ustel' => $_GPC['ustel'],
                    'usadd' => $_GPC['usadd'],
                    'usdate' => $_GPC['usdate'],
                    'ustime' => $_GPC['ustime'],
                    'score' => $_GPC['score'],
                );

                if (!empty($_GPC['thumb'])) {
                    $data['thumb'] = parse_path($_GPC['thumb']);
                }

                $cate = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_sj')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid)); 
                if($cate){
                    pdo_update('sudu8_page_food_sj', $data, array('uniacid' => $uniacid));
                }else{
                    pdo_insert('sudu8_page_food_sj', $data);
                }
                
                
                message('基本信息 添加/修改 成功!', $this->createWebUrl('base', array('op'=>'post')), 'success');
            }

        }


        include $this->template('base');
    }
        //模板消息
    public function doWebmessage() {
        //copyright
        load()->func('tpl');
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];
        if ($op == 'display'){
            $_W['page']['title'] = '点餐通知';
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_message') ." WHERE uniacid = :uniacid and flag = 4", array(':uniacid' => $uniacid));
            if (checksubmit('submit')) {
                $items = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_message') ." WHERE uniacid = :uniacid and flag = 4", array(':uniacid' => $_W['uniacid']));
                if(!$items){
                    $data = array(
                        'uniacid' => $_W['uniacid'],
                        'mid' =>$_GPC['pay_id'],
                        'url' =>$_GPC['url'],
                        'flag' => 4
                    );
                    $res = pdo_insert('sudu8_page_message', $data);
                }else{
                    $data = array(
                        'mid' =>$_GPC['pay_id'],
                        'url' =>$_GPC['url']
                    );
                     $res = pdo_update('sudu8_page_message', $data ,array('uniacid' => $uniacid,'flag' => 4));
                }

                if($res){
                    message('通知信息更新成功!', $this->createWebUrl('message', array('op'=>'display')), 'success');
                }else{
                    message('通知信息更新失败!', $this->createWebUrl('message', array('op'=>'display')), 'error');
                }
            }
        }
        include $this->template('message');
    }

    public function doWebCate() {

        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'post', 'delete');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];

        //产品列表
        if ($op == 'display'){
            $_W['page']['title'] = '点菜分类';
            $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_food_cate')." WHERE uniacid = :uniacid and flag = 1 order by num desc", array(':uniacid' => $uniacid));

        }


        //分类修改新增
        if ($op == 'post'){
            $id = intval($_GPC['id']);
            $cate = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_cate')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $id));

            

            if (checksubmit('submit')) {
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'num' => $_GPC['num'],         
                    'title' => trim($_GPC['title']),
                    'dateline' => time(),
                    'flag' => 1
                );

                if (!$id) {

                    pdo_insert('sudu8_page_food_cate', $data);

                } else {
                    pdo_update('sudu8_page_food_cate', $data, array('id' => $id ,'uniacid' => $uniacid));

                }

                message('栏目 添加/修改 成功!', $this->createWebUrl('cate', array('op'=>'display')), 'success');
            }

        }

        //删除栏目
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $is = pdo_get('sudu8_page_food', array('uniacid' => $uniacid, 'cid' => $id));
            if(!empty($is)){
                message('当前栏目下存在商品，不可删除！');
            }
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('栏目不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_food_cate', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('cate', array('op'=>'display')), 'success');
        }

        include $this->template('cate');
    }
    public function doWebProducts() {
        
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'post', 'delete');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];

        //菜单列表
        if ($op == 'display'){
            $_W['page']['title'] = '菜单管理';
            $products = pdo_fetchAll("SELECT a.*,b.title as catename FROM ".tablename('sudu8_page_food')." as a LEFT JOIN ".tablename('sudu8_page_food_cate')." as b on a.cid = b.id WHERE a.uniacid = :uniacid", array(':uniacid' => $uniacid));
        }
        
        if ($op == 'post'){

            $id = intval($_GPC['id']);
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            $item['text'] = unserialize($item['text']);
            $labels = unserialize($item['labels']);
            
            $arr = array();
            foreach ($labels as $key => &$res) {
                $kk = explode(":", $res);
                $k1 = $kk[0];
                $k2 = $kk[1];

                $arr[$key]['title'] = $k1;
                $arr[$key]['val'] = $k2;

            }
            $item['labels'] = $arr;

            // echo "<pre>";
            // var_dump($item);
            // echo "</pre>";
            // die();

            $listV = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_food_cate') ." WHERE uniacid = :uniacid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));
            $listAll = $listV;
            
            if (checksubmit('submit')) {

                $labels = $_GPC['labels'];

                // var_dump($labels);
                // die();


                if($labels){
                    $newlab = explode('?',substr($labels, 0, strlen($labels)-1));
                }else{
                    $newlab = "";
                }

                $lab = serialize($newlab);
                
                $cid = intval($_GPC['cid']);
                $pcid = pdo_fetch("SELECT cid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id =:id ", array(':uniacid' => $uniacid,':id'=>$cid));
                $pcid=implode("",$pcid);
                if($pcid == 0){
                    $pcid = $cid;
                }else{
                    $pcid = intval($pcid);
                }

                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'num' => intval($_GPC['num']),
                    'cid' => intval($_GPC['cid']),
                    'pcid' => $pcid,
                    'title' => $_GPC['title'],
                    'labels' => $lab,
                    'counts' => $_GPC['counts'],
                    'price' => $_GPC['price'],
                    'unit' => $_GPC['unit'],
                    'true_price' => $_GPC['true_price'],
                    'thumb' => $_GPC['thumb'],
                    'descimg'=>$_GPC['descimg'],
                    'desccon'=>$_GPC['desccon'],
                );
                
                if (!empty($_GPC['thumb'])) {
                    $data['thumb'] = parse_path($_GPC['thumb']);
                }
                if (empty($id)) {
                    pdo_insert('sudu8_page_food', $data);
                } else {
                    pdo_update('sudu8_page_food', $data, array('id' => $id ,'uniacid' => $uniacid));
                }
                message('菜单 添加/修改 成功!', $this->createWebUrl('products', array('op'=>'display')), 'success');

            }

        }

        //删除产品
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('产品不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_food', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('products', array('op'=>'display')), 'success');

        }

        include $this->template('products');
    }

    public function doWebOrder() {
        
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        

        $op = $_GPC['op'];
        $ops = array('display', 'yh', 'hx','qr','excel');
        $op = in_array($op, $ops) ? $op : 'display';



        $order = $_GPC['order'];

        if($op == "hx"){
            $data['custime'] = time();
            $data['flag'] = 2;
            $res = pdo_update('sudu8_page_order', $data, array('id' => $order));
            message('核销成功!', $this->createWebUrl('orders',array('op'=>'display')), 'success');
        }

        if($op == "qr"){
            $data['flag'] = 1;
            $res = pdo_update('sudu8_page_order', $data, array('id' => $order));
            message('确认成功!', $this->createWebUrl('orders',array('op'=>'display')), 'success');
        }


        if($op == "yh"){
            $openid = $_GPC['openid'];
            $userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid=:openid" , array(':uniacid' => $_W['uniacid'],':openid' => $openid));

            $order_id = $_GPC['order_id'];

            if($order_id){
                $orderinfo = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_order')." WHERE order_id LIKE :order_id and uniacid = :uniacid and openid = :openid  and is_more = 1", array(':order_id' => '%'.$order_id.'%' ,':uniacid' => $uniacid,':openid' => $openid));

                $total = count($orderinfo);
                $pageindex = max(1, intval($_GPC['page']));
                $pagesize = 10;  
                $p = ($pageindex-1) * $pagesize;
                $pager = pagination($total, $pageindex, $pagesize);  

                $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE order_id LIKE :order_id and uniacid = :uniacid and openid = :openid and is_more = 1 LIMIT " . $p . "," . $pagesize, array(':order_id' => '%'.$order_id.'%' ,':uniacid' => $uniacid,':openid' => $openid));

                foreach ($orders as $res) {
                    
                    $arr[] = array(
                        "id"=>$res['id'],
                        "order_id"=>$res['order_id'],
                        "pid"=>$res['pid'],
                        "thumb" => $_W['attachurl'].$res['thumb'],
                        "product"=>$res['product'],
                        "price"=>$res['price'],
                        "num"=>$res['num'],
                        "yhq"=>$res['yhq'],
                        "true_price"=>$res['true_price'],
                        "creattime" => date("Y-m-d H:i:s",$res['creattime']),
                        "custime" => $res['custime']?date("Y-m-d H:i:s",$res['custime']):"未消费",
                        "flag"=>$res['flag'],
                        "pro_user_name"=>$res['pro_user_name'],
                        "pro_user_tel"=>$res['pro_user_tel'],
                        "pro_user_txt"=>$res['pro_user_txt'],
                        "order_duo"=>unserialize($res['order_duo']),
                        "overtime" => date("Y-m-d H:i:s",$res['overtime']),
                        "zh"=>$res['zh'],
                    );
               
                }

            }else{
                $all = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid and openid = :openid and is_more = 1 ORDER BY `creattime` DESC ", array(':uniacid' => $uniacid,':openid' => $openid));
                $total = count($all);
                $pageindex = max(1, intval($_GPC['page']));
                $pagesize = 10;  
                $p = ($pageindex-1) * $pagesize;
                $pager = pagination($total, $pageindex, $pagesize);  


                $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid  and openid = :openid and is_more = 1 ORDER BY `creattime` DESC LIMIT " . $p . "," . $pagesize, array(':uniacid' => $uniacid,':openid' => $openid));
              

                foreach ($orders as $res) {
                    
                    $arr[] = array(
                        "id"=>$res['id'],
                        "order_id"=>$res['order_id'],
                        "pid"=>$res['pid'],
                        "thumb" => $_W['attachurl'].$res['thumb'],
                        "product"=>$res['product'],
                        "price"=>$res['price'],
                        "num"=>$res['num'],
                        "yhq"=>$res['yhq'],
                        "true_price"=>$res['true_price'],
                        "creattime" => date("Y-m-d H:i:s",$res['creattime']),
                        "custime" => $res['custime']?date("Y-m-d H:i:s",$res['custime']):"未消费",
                        "flag"=>$res['flag'],
                        "pro_user_name"=>$res['pro_user_name'],
                        "pro_user_tel"=>$res['pro_user_tel'],
                        "pro_user_txt"=>$res['pro_user_txt'],
                        "order_duo"=>unserialize($res['order_duo']),
                        "overtime" => date("Y-m-d H:i:s",$res['overtime']),
                        "zh"=>$res['zh'],
                    );
               
                }

            }

        }

        if($op == "excel"){
            $order_id = $_GPC['order_id'];
            // var_dump($order_id);die;
            if($order_id){
               


            }else{
                $all = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_food_order')." WHERE uniacid = :uniacid  ORDER BY `creattime` DESC ", array(':uniacid' => $uniacid));
                $total = count($all);
                $pageindex = max(1, intval($_GPC['page']));
                $pagesize = 10;  
                $p = ($pageindex-1) * $pagesize;
                $pager = pagination($total, $pageindex, $pagesize);  

                $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_food_order')." WHERE uniacid = :uniacid  ORDER BY `creattime` DESC ", array(':uniacid' => $uniacid));
                include IA_ROOT.'/addons/sudu8_page/plugin/phpexcel/Classes/PHPExcel.php';
                $objPHPExcel = new \PHPExcel();

                /*以下是一些设置*/
                $objPHPExcel->getProperties()->setCreator("餐饮订单记录")
                    ->setLastModifiedBy("餐饮订单记录")
                    ->setTitle("餐饮订单记录")
                    ->setSubject("餐饮订单记录")
                    ->setDescription("餐饮订单记录")
                    ->setKeywords("餐饮订单记录")
                    ->setCategory("餐饮订单记录");
                $objPHPExcel->getActiveSheet()->setCellValue('A1', '时间');
                $objPHPExcel->getActiveSheet()->setCellValue('B1', '订单编号');
                $objPHPExcel->getActiveSheet()->setCellValue('C1', '商品信息');
                $objPHPExcel->getActiveSheet()->setCellValue('D1', '实付金额');
                $objPHPExcel->getActiveSheet()->setCellValue('E1', '桌号');
                $objPHPExcel->getActiveSheet()->setCellValue('F1', '姓名');
                $objPHPExcel->getActiveSheet()->setCellValue('G1', '联系方式');
                $objPHPExcel->getActiveSheet()->setCellValue('H1', '联系地址');
                $objPHPExcel->getActiveSheet()->setCellValue('I1', '状态');
                foreach ($orders as $k => &$res) {
                    $val = unserialize($res['val']);
                    // $newval = $this->zhuanghuan($val);
                    // $arr[] = array(
                    //     "id"=>$res['id'],
                    //     "order_id"=>$res['order_id'],
                    //     "varl"=>$newval,
                    //     "username"=>$res['username'],
                    //     "usertel"=>$res['usertel'],
                    //     "address"=>$res['address'],
                    //     "userbeiz"=>$res['userbeiz'],
                    //     "usertime"=>$res['usertime'],
                    //     "price"=>$res['price'],
                    //     "creattime"=>date("Y-m-d H:i:s",$res['creattime']),
                    //     "flag"=>$res['flag'],
                    //     "zh"=>$res['zh'],
                    // );
                    
                // }
                    $res['createtime'] = date("Y-m-d H:i:s",$res['creattime']);

                    $goodsinfo = '';
                    foreach ($val as $k1 => $v1) {
                        $goodsinfo = $goodsinfo.$v1['title'].':单价'.$v1['price'].'*'.$v1['num'].',';
                    }
                // var_dump($goodsinfo);die;
                // $goodsinfo = [];
                // foreach ($orders as $k2 => $v2) {
                //     foreach ($v2['varl'] as $k3 => &$v3) {
                //         $goodsinfo = '标题：'.$goodsinfo.$v3['title'].'、数量：'.$v3['num'].',';
                //     }
                // }
               
                // $goodsinfo = [];
                // foreach($arr['varl'] as $k2 => &$v2){
                //     $goodsinfo = '标题：'.$goodsinfo.$v2['title'].'、数量：'.$v2['num'].',';
                // }
                
                // foreach ($arr as $k => $v) {
                    $num  = $k+2;
                    if($res['flag'] == -2){
                        $res['flag1'] = '订单无效';
                    }else if($res['flag'] == -1){
                        $res['flag1'] = '已关闭';
                    }else if($res['flag'] == 0){
                        $res['flag1'] = '未支付';
                    }else if($res['flag'] == 1 ){
                        $res['flag1'] = '已支付';
                    }else if($res['flag'] == 2 ){
                        $res['flag1'] = '已完成';
                    }

                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValueExplicit('A'.$num, $res['creattime'],'s')
                            ->setCellValueExplicit('B'.$num, $res['order_id'],'s')
                            ->setCellValueExplicit('C'.$num, $goodsinfo,'s') 
                            ->setCellValueExplicit('D'.$num, $res['price'],'s')
                            ->setCellValueExplicit('E'.$num, $res['zh'], 's')
                            ->setCellValueExplicit('F'.$num, $res['username'], 's')
                            ->setCellValueExplicit('G'.$num, $res['usertel'], 's')
                            ->setCellValueExplicit('H'.$num, $res['address'], 's')
                            ->setCellValueExplicit('I'.$num, $res['flag1'], 's');
                }

            $objPHPExcel->getActiveSheet()->setTitle('导出餐饮订单');
            $objPHPExcel->setActiveSheetIndex(0);
            $excelname="餐饮订单记录表";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

        if($op == "display"){


            $order_id = $_GPC['order_id'];
            // var_dump($order_id);die;
            if($order_id){
               


            }else{
                $all = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_food_order')." WHERE uniacid = :uniacid  ORDER BY `creattime` DESC ", array(':uniacid' => $uniacid));
                $total = count($all);
                $pageindex = max(1, intval($_GPC['page']));
                $pagesize = 10;  
                $p = ($pageindex-1) * $pagesize;
                $pager = pagination($total, $pageindex, $pagesize);  

                $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_food_order')." WHERE uniacid = :uniacid  ORDER BY `creattime` DESC LIMIT " . $p . "," . $pagesize, array(':uniacid' => $uniacid));
                foreach ($orders as $res) {
                    $val = unserialize($res['val']);
                    $newval = $this->zhuanghuan($val);
                    $arr[] = array(
                        "id"=>$res['id'],
                        "order_id"=>$res['order_id'],
                        "varl"=>$newval,
                        "username"=>$res['username'],
                        "usertel"=>$res['usertel'],
                        "address"=>$res['address'],
                        "userbeiz"=>$res['userbeiz'],
                        "usertime"=>$res['usertime'],
                        "price"=>$res['price'],
                        "creattime"=>date("Y-m-d H:i:s",$res['creattime']),
                        "flag"=>$res['flag'],
                        "zh"=>$res['zh'],
                    );
                }
                // var_dump($arr);exit;
            }
        }

        include $this->template('orders');
    }

    public function doWebPrinter() {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'post', 'delete');
        $op = in_array($op, $ops) ? $op : 'post';
        $uniacid = $_W['uniacid'];

        //分类修改新增
        if ($op == 'post'){

            $cate = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_printer')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid)); 

            if (checksubmit('submit')) {
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'pname' => $_GPC['pname'],         
                    'title' => $_GPC['title'],
                    'models ' => $_GPC['models'],
                    'status' => $_GPC['status'],
                    'nid' => $_GPC['nid'],
                    'nkey' => $_GPC['nkey'],
                    'uid' => $_GPC['uid'],
                    'apikey' => $_GPC['apikey'],
                    'createtime' => time()
                );

                if (!empty($_GPC['thumb'])) {
                    $data['thumb'] = parse_path($_GPC['thumb']);
                }

                $base = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_printer')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid)); 
                if($base){
                    pdo_update('sudu8_page_food_printer', $data, array('uniacid' => $uniacid));
                }else{
                    pdo_insert('sudu8_page_food_printer', $data);
                }
                
                
                message('打印机基本信息 添加/修改 成功!', $this->createWebUrl('printer', array('op'=>'post')), 'success');
            }

        }


        include $this->template('printer');
    }

    public function zhuanghuan($arr){

        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];

        if($arr){

            foreach ($arr as $key => &$res) {
                
                $products = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id'=>$res['id']));
                $res['thumb'] =  HTTPSHOST.$products['thumb'];

            }
            return $arr;
        }
    }



    public function doWebTabs(){

        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'post', 'delete', 'getewm', 'getewmsc');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];

        //产品列表
        if ($op == 'display'){
            $_W['page']['title'] = '桌号管理';
            $tabs = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_food_tables')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
        }

        if ($op == 'post'){

            $id = intval($_GPC['id']);
            $tabs = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_tables')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $id));
            if (checksubmit('submit')) {
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'tnum' => $_GPC['tnum'],         
                    'title' => $_GPC['title']
                );

                if (!$id) {
                    pdo_insert('sudu8_page_food_tables', $data);
                } else {
                    pdo_update('sudu8_page_food_tables', $data, array('id' => $id ,'uniacid' => $uniacid));
                }

                message('桌号 添加/修改 成功!', $this->createWebUrl('tabs', array('op'=>'display')), 'success');
            }

        }

        //删除产品
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_tables')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $_W['uniacid']));
            if (empty($row)) {
                message('桌号不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_food_tables', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('tabs', array('op'=>'display')), 'success');

        }

        // 获取二维码
        if($op == 'getewm'){
            $zuoh = $_GPC['tnum'];
            $id = $_GPC['id'];

            $table = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_tables')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
        }

        // 获取二维码
        if($op == 'getewmsc'){

            $app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
            $appid = $app['key'];
            $appsecret = $app['secret'];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $weixin = file_get_contents($url);
            $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
            $array = get_object_vars($jsondecode);//转换成数组
            $access_token = $array['access_token'];//输出openid
            $tnum = $_GPC['tnum'];

            $id = $_GPC['id'];

            $ewmurl = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
            $sjc = time().rand(1000,9999);
            $data = [
                        'page' => "sudu8_page_plugin_food/food/food",
                        'width' => '500',
                        'scene' => $id
                    ];
            $data=json_encode($data);
            $result = $this->_requestPost($ewmurl,$data); 
            // var_dump($result);
            // die();
            $newpath = ROOT_PATH."ewmimg";
            if(!file_exists($newpath)){
                mkdir($newpath);
            }

            file_put_contents(ROOT_PATH."ewmimg/".$sjc.".jpg", $result); 
            $path = MODULE_URL."ewmimg/".$sjc.".jpg";
            
            $tdata = array(
                "thumb" => $path
            );
            
            pdo_update("sudu8_page_food_tables",$tdata,array("id"=>$id));
            message('二维码生成成功!', $this->createWebUrl('tabs', array('tnum' => $tnum, 'id'=>$id,'op'=>'getewm')), 'success');
        }

        include $this->template('tabs');

    }


    //不带报头的curl
    function _requestPost($url, $data, $ssl=true) {  
            //curl完成  
            $curl = curl_init();  
            //设置curl选项  
            curl_setopt($curl, CURLOPT_URL, $url);//URL  
            $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';  
            curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息  
            curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源  
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间  
            //SSL相关  
            if ($ssl) {  
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证  
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。  
            }  
            // 处理post相关选项  
            curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求  
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据  
            // 处理响应结果  
            curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头  
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果  
  
            // 发出请求  
            $response = curl_exec($curl);
            
            if (false === $response) {  
                echo '<br>', curl_error($curl), '<br>';  
                return false;  
            }  
            curl_close($curl);  
            return $response;  
    }  
}