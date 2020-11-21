<?php
/**
 * 积分兑换商城模块微站定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');

class Sudu8_page_plugin_exchangeModuleSite extends WeModuleSite {

    //积分商城
    public function doWebscoreshop(){
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'post', 'delete');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];
        //产品列表
        if ($op == 'display'){
            $_W['page']['title'] = '产品管理';
            $products = pdo_fetchall("SELECT i.num,i.thumb,i.title,i.id,c.name,i.buy_type FROM ".tablename('sudu8_page_score_shop')."as i left join" .tablename('sudu8_page_score_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." ORDER BY i.num DESC,i.id DESC");
            // 获取文章分类
            $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_score_cate')." WHERE uniacid = :uniacid ", array(':uniacid' => $uniacid));
        }
        //产品添加、修改
        if ($op == 'post'){
            $id = $_GPC['id'];
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_score_shop')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            $item['text'] = unserialize($item['text']);
            // var_dump($item);
            // die();
            $listV = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_score_cate') ." WHERE uniacid = :uniacid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));
            if (!empty($id)) {
                if (empty($item)) {
                    message('抱歉，产品不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')) {
                if (empty($_GPC['title'])) {
                    message('标题不能为空，请输入标题！');
                }
                if (empty($_GPC['buy_type'])) {
                    message('自定义购买方式不能为空！');
                }
                $cid = intval($_GPC['cid']);
                $pcid = pdo_fetch("SELECT cid FROM ".tablename('sudu8_page_score_cate')." WHERE uniacid = :uniacid and id =:id ", array(':uniacid' => $uniacid,':id'=>$cid));
                $pcid=implode('',$pcid);
                if($pcid == 0){
                    $pcid = $cid;
                }else{
                    $pcid = intval($pcid);
                }
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'num' => intval($_GPC['num']),
                    'cid' => intval($_GPC['cid']),
                    'hits'=>$_GPC['hits'],
                    'sale_num'=>$_GPC['sale_num'],
                    'price'=>$_GPC['price'],
                    'market_price'=>$_GPC['market_price'],
                    'pro_kc'=>$_GPC['pro_kc'],
                    'sale_tnum'=>$_GPC['sale_tnum'],
                    'thumb'=>$_GPC['thumb'],
                    'text' => serialize($_GPC['text']),
                    'labels' => $_GPC['labels'],
                    'title' => addslashes($_GPC['title']),
                    'desk'=>$_GPC['desc'],
                    'product_txt'=>htmlspecialchars_decode($_GPC['product_txt'], ENT_QUOTES)
                );
                // echo "<pre>";
                // var_dump($data);
                // echo "</pre>";
                // die();
                if (!empty($_GPC['thumb'])) {
                    $data['thumb'] = parse_path($_GPC['thumb']);
                }
                if (empty($id)) {
                    // var_dump(111);
                    // die();
                    pdo_insert('sudu8_page_score_shop', $data);
                } else {
                    pdo_update('sudu8_page_score_shop', $data, array('id' => $id ,'uniacid' => $uniacid));
                }
                message('产品 添加/修改 成功!', $this->createWebUrl('scoreshop', array('op'=>'display')), 'success');
            }
        }
        //删除产品
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_score_shop')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('产品不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_score_shop', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('scoreshop', array('op'=>'display')), 'success');
        }
        include $this->template('scoreshop');
    }
    //积分商城栏目
    public function doWebscorecate() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display', 'post','delete');
        $op = in_array($op, $ops) ? $op : 'display';
        //栏目列表
        if ($op == 'display'){
            $listV = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_score_cate') ." WHERE uniacid = :uniacid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));
        }
        //添加栏目
        if ($op == 'post'){
            $id = intval($_GPC['id']);
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_score_cate') ." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            $cate_list = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_score_cate') ." WHERE uniacid = :uniacid ", array(':uniacid' => $uniacid));
            if (checksubmit('submit')) {
                if (empty($_GPC['name'])) {
                    message('请输入栏目标题！');
                }
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'num' => intval($_GPC['num']),
                    'name' =>$_GPC['name'], 
                    'catepic'=>$_GPC['catepic']
                );
                if (empty($id)) {
                    pdo_insert('sudu8_page_score_cate', $data);
                } else {
                    pdo_update('sudu8_page_score_cate', $data, array('id' => $id ,'uniacid' => $uniacid));
                }
                message('栏目 添加/修改 成功!', $this->createWebUrl('scorecate', array('op'=>'display')), 'success');
            }
        }
        //删除栏目
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_score_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('栏目不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_score_cate', array('id' => $id ,'uniacid' => $uniacid));
            message('栏目删除成功!', $this->createWebUrl('scorecate', array('op'=>'display')), 'success');
        }
        include $this->template('scorecate');
    }
    //积分商城
    public function doWebscoreorder() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display','hx','excel');
        $op = in_array($op, $ops) ? $op : 'display';
        $order_id = $_GPC['order_id'];


        if($op == "hx"){
            $data['custime'] = time();
            $data['flag'] = 1;
            $res = pdo_update('sudu8_page_score_order', $data, array('order_id' => $order_id));
            message('兑换成功!', $this->createWebUrl('scoreorder'));
        }
        if($op == "display"){

            if($order_id){

                $listV = pdo_fetchall("SELECT a.*,b.nickname,b.mobile FROM ".tablename('sudu8_page_score_order') ." as a LEFT JOIN ".tablename('sudu8_page_user') ." as b on a.openid = b.openid WHERE b.uniacid = :uniacid and a.order_id LIKE :order_id ORDER BY id DESC", array(':uniacid' => $uniacid, ':order_id'=>'%'.$order_id.'%' ));
                foreach($listV as $key => &$res){
                    $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                    $res['thumb'] = $_W['attachurl'].$res['thumb'];
                }
            }else{

                $listV = pdo_fetchall("SELECT a.*,b.nickname,b.mobile FROM ".tablename('sudu8_page_score_order') ." as a LEFT JOIN ".tablename('sudu8_page_user') ." as b on a.openid = b.openid WHERE b.uniacid = :uniacid ORDER BY id DESC", array(':uniacid' => $uniacid));
                foreach($listV as $key => &$res){
                    $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                    $res['thumb'] = $_W['attachurl'].$res['thumb'];
                    $res['nickname'] = rawurldecode($res['nickname']);
                }
            }
        }

        if($op == "excel"){
            if($order_id){

                $listV = pdo_fetchall("SELECT a.*,b.nickname,b.mobile FROM ".tablename('sudu8_page_score_order') ." as a LEFT JOIN ".tablename('sudu8_page_user') ." as b on a.openid = b.openid WHERE b.uniacid = :uniacid and a.order_id LIKE :order_id ORDER BY id DESC", array(':uniacid' => $uniacid, ':order_id'=>'%'.$order_id.'%' ));
                foreach($listV as $key => &$res){
                    $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                    $res['thumb'] = $_W['attachurl'].$res['thumb'];
                }
            }else{

                $listV = pdo_fetchall("SELECT a.*,b.nickname,b.mobile FROM ".tablename('sudu8_page_score_order') ." as a LEFT JOIN ".tablename('sudu8_page_user') ." as b on a.openid = b.openid WHERE b.uniacid = :uniacid ORDER BY id DESC", array(':uniacid' => $uniacid));
                // var_dump($listV);die;
                include IA_ROOT.'/addons/sudu8_page/plugin/phpexcel/Classes/PHPExcel.php';
                $objPHPExcel = new \PHPExcel();

                /*以下是一些设置*/
                $objPHPExcel->getProperties()->setCreator("积分兑换订单记录")
                    ->setLastModifiedBy("积分兑换订单记录")
                    ->setTitle("积分兑换订单记录")
                    ->setSubject("积分兑换订单记录")
                    ->setDescription("积分兑换订单记录")
                    ->setKeywords("积分兑换订单记录")
                    ->setCategory("积分兑换订单记录");
                $objPHPExcel->getActiveSheet()->setCellValue('A1', '时间');
                $objPHPExcel->getActiveSheet()->setCellValue('B1', '订单编号');
                $objPHPExcel->getActiveSheet()->setCellValue('C1', '商品名');
                $objPHPExcel->getActiveSheet()->setCellValue('D1', '单价');
                $objPHPExcel->getActiveSheet()->setCellValue('E1', '数量');
                $objPHPExcel->getActiveSheet()->setCellValue('F1', '姓名');
                $objPHPExcel->getActiveSheet()->setCellValue('G1', '联系方式');
                $objPHPExcel->getActiveSheet()->setCellValue('H1', '总价');
                $objPHPExcel->getActiveSheet()->setCellValue('I1', '兑换时间');
                $objPHPExcel->getActiveSheet()->setCellValue('J1', '状态');

                foreach($listV as $key => &$res){
                    $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                    $res['custime'] = date("Y-m-d H:i:s",$res['custime']);
                    $res['allprice'] = $res['price'] * $res['num'];
                    // $res['thumb'] = $_W['attachurl'].$res['thumb'];
                    $num  = $key+2;
                    if($res['flag'] == 1){
                        $res['flag1'] = '已兑换';
                    }else if($res['flag'] == 0){
                        $res['flag1'] = '未兑换';
                    }

                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValueExplicit('A'.$num, $res['creattime'],'s')
                            ->setCellValueExplicit('B'.$num, $res['order_id'],'s')
                            ->setCellValueExplicit('C'.$num, $res['product'],'s') 
                            ->setCellValueExplicit('D'.$num, $res['price'],'s')
                            ->setCellValueExplicit('E'.$num, $res['num'], 's')
                            ->setCellValueExplicit('F'.$num, $res['nickname'], 's')
                            ->setCellValueExplicit('G'.$num, $res['mobile'], 's')
                            ->setCellValueExplicit('H'.$num, $res['allprice'].'积分', 's')
                            ->setCellValueExplicit('I'.$num, $res['custime'], 's')
                            ->setCellValueExplicit('J'.$num, $res['flag1'], 's');
                }
                // var_dump($listV);die;
                $objPHPExcel->getActiveSheet()->setTitle('导出积分兑换订单');
                $objPHPExcel->setActiveSheetIndex(0);
                $excelname="积分兑换订单记录表";
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
                exit;
            }
        }
        // var_dump($listV);exit;
        include $this->template('scoreorder');
    
}

    //模板消息
    public function doWebscoremsg() {
        //copyright
        load()->func('tpl');
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];
        if ($op == 'display'){
            $_W['page']['title'] = '积分兑换通知';
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_message') ." WHERE uniacid = :uniacid and flag = 5", array(':uniacid' => $uniacid));
            if (checksubmit('submit')) {
                $items = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_message') ." WHERE uniacid = :uniacid and flag = 5", array(':uniacid' => $_W['uniacid']));
                if(!$items){
                    $data = array(
                        'uniacid' => $_W['uniacid'],
                        'mid' =>$_GPC['pay_id'],
                        'url' =>$_GPC['url'],
                        'flag' => 5
                    );
                    $res = pdo_insert('sudu8_page_message', $data);
                }else{
                    $data = array(
                        'mid' =>$_GPC['pay_id'],
                        'url' =>$_GPC['url']
                    );
                     $res = pdo_update('sudu8_page_message', $data ,array('uniacid' => $uniacid,'flag' => 5));
                }

                if($res){
                    message('通知信息更新成功!', $this->createWebUrl('scoremsg', array('op'=>'display')), 'success');
                }else{
                    message('通知信息更新失败!', $this->createWebUrl('scoremsg', array('op'=>'display')), 'error');
                }
            }
        }
        include $this->template('message');
    }
}