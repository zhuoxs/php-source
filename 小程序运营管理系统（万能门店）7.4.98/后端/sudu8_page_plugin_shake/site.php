<?php
/**
 * sudu8_page_plugin_shake模块微站定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
define("HTTPSHOST", $_W['attachurl']);

class Sudu8_page_plugin_shakeModuleSite extends WeModuleSite {


        public function doWebactivity() {
        	global $_GPC, $_W;
                $uniacid = $_W['uniacid'];
                $op = $_GPC['op'];
                $ops = array('display', 'post', 'editPrize', 'delete', 'record');
                $op = in_array($op, $ops) ? $op : 'display';
                if ($op == 'display') {
                        $activities = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_lottery_activity')." WHERE uniacid = :uniacid ORDER BY createtime desc", array(':uniacid'=>$uniacid));
                        foreach($activities as $key => &$value){
                            $value['url'] = "/sudu8_page_plugin_shake/index/index?id=" . $value['id'];
                        }
                }
                if($op == 'post'){
                        $id = $_GPC['id'];
                        if(!empty($id)){
                                $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_lottery_activity')." WHERE id = :id and uniacid = :uniacid",array(':uniacid'=>$uniacid, ':id'=>$id));
                                
                                $item['begin'] = date('Y-m-d H:i:s', $item['begin']);
                                $item['end'] = date('Y-m-d H:i:s', $item['end']);
                                $item['base'] = unserialize($item['base']);
                        }
                        if(empty($item['bg'])){
                            $item['bg'] = MODULE_URL . "image/bg.jpg";
                        }
                        if(empty($item['text_img1'])){
                            $item['text_img1'] = MODULE_URL . "image/title_button.png";
                        }
                        if(empty($item['text_img2'])){
                            $item['text_img2'] = MODULE_URL . "image/title_shake.png";
                        }
                        if(checksubmit('addnew')){
                                if(empty($_GPC['title'])){
                                        message('活动标题不能为空！');
                                }
                                if(empty($_GPC['btime']) || empty($_GPC['etime'])){
                                        message('活动时间不能为空！');
                                }
                                if(empty($_GPC['descp'])){
                                        message('活动规则不能为空！');
                                }
                                if(empty($_GPC['thumb'])){
                                        message('活动主图不能为空！');
                                }
                                
                                $data = array(
                                        'title' => $_GPC['title'],
                                        'begin' => strtotime($_GPC['btime']),
                                        'end' => strtotime($_GPC['etime']),
                                        'descp' => $_GPC['descp'],
                                        'thumb' => $_GPC['thumb'],
                                        'bg' => $_GPC['bg'],
                                        'text_img1' => $_GPC['text_img1'],
                                        'text_img2' => $_GPC['text_img2'],
                                        'nav_color' => $_GPC['nav_color'],
                                        'status' => $_GPC['status'] != NULL ? $_GPC['status'] : 1,
                                        'share_url'=>$_GPC['share_url'],
                                        'fxtext'=>$_GPC['fxtext'],
                                        'zjtext'=>$_GPC['zjtext']
                                );
                                $base = array(
                                        'means' => $_GPC['means'] != NULL ? $_GPC['means'] : 1,
                                        'jifen' => $_GPC['jifen'] != NULL ? $_GPC['jifen'] : 10,
                                        'every_join' => $_GPC['every_join'] != NULL ? $_GPC['every_join'] : 3,
                                        'just_one' => $_GPC['just_one'] != NULL ? $_GPC['just_one'] : 0,
                                        'users_type' => $_GPC['users_type'] != NULL ? $_GPC['users_type'] : 0,
                                        'fill_time' => $_GPC['fill_time'] != NULL ? $_GPC['fill_time'] : 0,
                                        'share_type' => 0,
                                        'share_add' => $_GPC['share_add'] != NULL ? $_GPC['share_add'] : 1,
                                        'everyday_share' => $_GPC['everyday_share'] != NULL ? $_GPC['everyday_share'] : 1,
                                        'total_share' => $_GPC['total_share'] != NULL ? $_GPC['total_share'] : 10
                                );
                                $data['base'] = serialize($base);
                                if(!empty($id)){
                                        pdo_update('sudu8_page_lottery_activity', $data, array('uniacid'=>$uniacid, 'id'=>$id));
                                }else{
                                        $data['uniacid'] = $uniacid;
                                        $data['createtime'] = time();
                                        pdo_insert('sudu8_page_lottery_activity', $data);
                                }
                                message('活动添加/修改成功!', $this->createWebUrl('activity', array('op'=>'display')), 'success');
                        }
                }

                if($op == 'editPrize'){
                        $id = $_GPC['id'];

                        if(!empty($id)){
                                $prizes = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid ORDER BY createtime desc",
                                        array(':uniacid'=>$uniacid, ':aid'=>$id));

                                foreach ($prizes as $key => &$value) {
                                    if($value['types'] == '4'){
                                        $value['detail'] = pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_coupon')." WHERE uniacid = :uniacid and id = :id",
                                                            array(":uniacid"=>$uniacid, ":id"=>$value['detail']));
                                    }

                                    if($value['types'] == '1'){
                                        $value['detail'] .= '积分';
                                    }

                                    if($value['types'] == '2'){
                                        $value['detail'] .= '元';
                                    }

                                    $value['chance'] /= 100;
                                }        
                        }

                        $coupons = pdo_fetchall("SELECT id,title FROM ".tablename('sudu8_page_coupon')." WHERE uniacid = :uniacid and flag = 0 ORDER BY creattime desc",
                                        array(':uniacid'=>$uniacid));
                        
                        $selectedPrizes = array();
                        $prizes_set = array();
                        for($i = 1; $i <= 8; $i++){
                            $selectedPrizes[$i] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid and num like '%".$i."%'",
                                        array(':uniacid'=>$uniacid, ':aid'=>$id));
                            $flag = true;
                            if(!empty($selectedPrizes[$i])){
                                if(!empty($prizes_set)){
                                    foreach ($prizes_set as $p) {
                                        if($p['id'] == $selectedPrizes[$i]['id']){
                                            $flag = false;
                                        }
                                    }    
                                }
                                
                                if($flag){
                                    $prizes_set[] = $selectedPrizes[$i];
                                }    
                            }
                            
                        }

                        foreach ($prizes_set as $k => &$v) {
                            $length = count(explode("|", $v['num']));
                            $v['total_num'] = $v['total'] * $length;
                            $v['total_chance'] = $v['chance'] * $length / 100;
                            if($v['types'] == '4'){
                                $v['detail'] = pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_coupon')." WHERE uniacid = :uniacid and id = :id",
                                                    array(":uniacid"=>$uniacid, ":id"=>$v['detail']));
                            }
                            if($v['types'] == '1'){
                                $v['detail'] .= '积分';
                            }
                            if($v['types'] == '2'){
                                $v['detail'] .= '元';
                            }
                            $total_num_sum += $v['total_num'];
                            $total_chance_sum += $v['total_chance'];
                        }

                        $activity = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_lottery_activity')." WHERE uniacid = :uniacid and id = :id",
                                    array(":uniacid"=>$uniacid, ":id"=>$id));
                        $means = unserialize($activity['base']);
                        $means = $means['means'];
                }

                if($op == 'delete'){
                        $id = $_GPC['id'];
                        if(!empty($id)){ 
                                pdo_delete('sudu8_page_lottery_activity', array('uniacid'=>$uniacid, 'id'=>$id));
                                message('活动删除成功!', $this->createWebUrl('activity', array('op'=>'display')), 'success');
                        }
                }

                if($op == 'record'){
                    $id = $_GPC['id'];
                    // var_dump($id);exit();
                    $prizesSet = array();
                    for($i = 1; $i <= 8; $i++){
                        $temp = pdo_fetch("SELECT id,types,detail FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid=:aid and num like '%".$i."%'", 
                                            array(":uniacid"=>$uniacid, ":aid"=>$id));
                        if(!empty($temp) && !in_array($temp,  $prizesSet)){
                            $prizesSet[] = $temp;
                        }
                    }
                    foreach ($prizesSet as $key => &$value) {
                        if($value['types'] == '1'){
                            $value['detail'] = '积分：' . $value['detail'] . '积分';
                        }
                        if($value['types'] == '2'){
                            $value['detail'] = '余额：' . $value['detail'] . '元';
                        }
                        if($value['types'] == '3'){
                            $value['detail'] = '实物：' . $value['detail'];
                        }
                        if($value['types'] == '4'){
                            $value['detail'] = '优惠券：' . pdo_getcolumn("sudu8_page_coupon",array("uniacid"=>$uniacid, "id"=>$value['detail']),"title");
                        }

                    }

                    if(!empty($_GPC['opt']) && $_GPC['opt'] == 'shenhe' && !empty($_GPC['rid'])){
                        $shenhe = array(
                            'status' => 2
                        );
                        pdo_update("sudu8_page_lottery_record", $shenhe, array("uniacid"=>$uniacid, "id"=>$_GPC['rid']));
                        message("审核发货成功！返回上一页并刷新页面");
                    }

                    $where = '';
                    if(!empty($_GPC['select_pid']) || in_array($_GPC['select_status'], ['0','1','2'])){
                        if(!empty($_GPC['select_pid'])){
                            $select_pid = $_GPC['select_pid'];
                            $where .= ' and pid = '.$select_pid;
                        }

                        if(in_array($_GPC['select_status'],['0','1','2'])){
                            $select_status = $_GPC['select_status'];
                            $where .= ' and status = '.$select_status;
                        }
                    }

                    $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("sudu8_page_lottery_record")." WHERE uniacid =:uniacid and aid = :aid ".$where, 
                                                array(":uniacid"=>$uniacid, ":aid"=>$id));
                    $pageindex = max(1, intval($_GPC['page']));
                    $pagesize = 10;
                    $pager = pagination($total, $pageindex, $pagesize);
                    $begin = ($pageindex-1) * $pagesize;

                    $sql = "SELECT * FROM ".tablename("sudu8_page_lottery_record")." WHERE uniacid = :uniacid and aid = :aid ".$where." ORDER BY createtime desc LIMIT ".$begin.",".$pagesize;
                    $records = pdo_fetchall($sql, array(":uniacid"=>$uniacid, ":aid"=>$id));
                    foreach ($records as $k => &$v) {
                        $user = pdo_get("sudu8_page_user", array("uniacid"=>$uniacid, "id"=>$v['uid']));
                        $v['realname'] = $user['realname'] ? $user['realname'] : '暂无';
                        $v['mobile'] = $user['mobile'] ? $user['mobile'] : '暂无';
                        $v['address'] = $user['address'] ? $user['address'] : '暂无';
                        $v['createtime'] = date("Y-m-d H:i:s", $v['createtime']);
                        if($v['status'] != '0'){
                            $prize = pdo_get("sudu8_page_lottery_prize", array("uniacid"=>$uniacid, "id"=>$v['pid']));
                            $v['types'] = $prize['types'];
                            if($prize['types'] == '1'){
                                $v['prize_detail'] = $prize['detail'] . '积分';
                            }else if($prize['types'] == '2'){
                                $v['prize_detail'] = $prize['detail'] . '元';
                            }else if($prize['types'] == '4'){
                                $v['prize_detail'] = pdo_getcolumn("sudu8_page_coupon",array("uniacid"=>$uniacid, "id"=>$prize['detail']),"title");
                            }else{
                                $v['prize_detail'] = $prize['detail'];
                            }
                        }
                    }

                    if(!empty($_GPC['opt']) && $_GPC['opt'] == 'excel'){
                        $excel_records = pdo_fetchall("SELECT * FROM ".tablename("sudu8_page_lottery_record")." WHERE uniacid = :uniacid and aid = :aid ".$where." ORDER BY createtime desc", 
                            array(":uniacid"=>$uniacid, ":aid"=>$id));

                        include MODULE_ROOT.'/../sudu8_page/plugin/phpexcel/Classes/PHPExcel.php';

                        $objPHPExcel = new \PHPExcel();

                        /*以下是一些设置*/
                        $objPHPExcel->getProperties()->setCreator("导出抽奖记录")
                            ->setLastModifiedBy("抽奖记录")
                            ->setTitle("导出抽奖记录")
                            ->setSubject("导出抽奖记录")
                            ->setDescription("导出抽奖记录")
                            ->setKeywords("导出抽奖记录")
                            ->setCategory("导出抽奖记录");
                        $objPHPExcel->getActiveSheet()->setCellValue('A1', '抽奖人姓名');
                        $objPHPExcel->getActiveSheet()->setCellValue('B1', '手机号');
                        $objPHPExcel->getActiveSheet()->setCellValue('C1', '地址');
                        $objPHPExcel->getActiveSheet()->setCellValue('D1', '中奖状态');
                        $objPHPExcel->getActiveSheet()->setCellValue('E1', '中奖奖品');
                        $objPHPExcel->getActiveSheet()->setCellValue('F1', '抽奖时间');

                   
                        foreach($excel_records as $k => &$v){

                            $num=$k+2;

                            $user = pdo_get("sudu8_page_user", array("uniacid"=>$uniacid, "id"=>$v['uid']));

                            switch ($v['status']) {
                                case '0':
                                    $status = '未中奖';
                                    break;
                                
                                case '1':
                                    $status = '待领取';
                                    break;

                                case '2':
                                    $status = '已领取';
                                    break;
                            }

                            $content = "";
                            if($v['status'] != '0'){
                                $prize = pdo_get("sudu8_page_lottery_prize", array("uniacid"=>$uniacid, "id"=>$v['pid']));
                                if($prize['types'] == '1'){
                                    $content = $prize['detail'] . '积分';
                                }else if($prize['types'] == '2'){
                                    $content = $prize['detail'] . '元';
                                }else if($prize['types'] == '4'){
                                    $content = pdo_getcolumn("sudu8_page_coupon",array("uniacid"=>$uniacid, "id"=>$prize['detail']),"title");
                                }else{
                                    $content = $prize['detail'];
                                }
                            }

                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValueExplicit('A'.$num, $user['realname'],'s')
                                ->setCellValueExplicit('B'.$num, $user['mobile'],'s')
                                ->setCellValueExplicit('C'.$num, $user['address'],'s')
                                ->setCellValueExplicit('D'.$num, $status,'s')
                                ->setCellValueExplicit('E'.$num, $content, 's')
                                ->setCellValueExplicit('F'.$num, date("Y-m-d H:i:s",$v['createtime']),'s');
                        }


                        $objPHPExcel->getActiveSheet()->setTitle('导出抽奖信息');
                        $objPHPExcel->setActiveSheetIndex(0);
                        $excelname="抽奖信息导出表";
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
                        header('Cache-Control: max-age=0');
                        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                        $objWriter->save('php://output');
                        exit;
                    }
                }
                include $this->template('activity');
        }

        public function doWebaddPrize(){
                global $_GPC, $_W;
                $uniacid = $_W['uniacid'];

                $pid = $_GPC['pid'];

                $data = array(
                        'title' => $_GPC['title'],
                        'thumb' => $_GPC['thumb'],
                        'types' => $_GPC['types'],
                        'detail' => $_GPC['detail'],
                        'total' => $_GPC['total'],
                        'chance' => $_GPC['chance'],
                );

                if(!empty($pid)){
                        $prize = pdo_get("sudu8_page_lottery_prize", array("uniacid"=>$uniacid, "id"=>$pid));
                        $data['storage'] = intval($_GPC['total']) - intval($prize['total']) + intval($prize['storage']);
                        if($data['storage'] < 0) $data['storage'] = 0; 
                        pdo_update('sudu8_page_lottery_prize', $data, array('uniacid'=>$uniacid, 'id'=>$pid));
                        $data['id'] = $pid;
                        $data['flag'] = 'modify';
                }else{
                        $data['uniacid'] = $uniacid;
                        $data['aid'] = $_GPC['aid'];
                        $data['createtime'] = time();
                        $data['storage'] = $data['total'];
                        $data['num'] = '';
                        pdo_insert('sudu8_page_lottery_prize', $data);
                        $data['id'] = pdo_insertid();
                        $data['flag'] = 'add';
                }
                
                if(strpos($data['thumb'],'http')===false){
                    $data['thumb'] = HTTPSHOST.$data['thumb'];
                }

                if($data['types'] == '4'){
                    $data['detail'] = pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_coupon')." WHERE uniacid = :uniacid and id = :id",
                                                            array(":uniacid"=>$uniacid, ":id"=>$data['detail']));
                }

                if($data['types'] == '1'){
                    $data['detail'] .= '积分';
                }

                if($data['types'] == '2'){
                    $data['detail'] .= '余额';
                }

                $data['chance'] /= 100;

                return json_encode($data, JSON_UNESCAPED_UNICODE); 
        }

        //获取奖品信息
        public function doWebgetPrizeInfo(){
                global $_GPC, $_W;
                $uniacid = $_W['uniacid'];

                $id = $_GPC['id'];

                $prize = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and id = :id",array(":uniacid"=>$uniacid, ":id"=>$id));

                if(strpos($prize['thumb'],'http')===false){
                    $prize['thumb_https'] = HTTPSHOST.$prize['thumb'];
                }else{
                    $prize['thumb_https'] = $prize['thumb'];
                }

                return json_encode($prize, JSON_UNESCAPED_UNICODE); 
        }

        //删除奖品
        public function doWebdelPrize(){
                global $_GPC, $_W;
                $uniacid = $_W['uniacid'];

                $id = $_GPC['id'];

                $result = pdo_delete('sudu8_page_lottery_prize', array('uniacid'=>$uniacid, 'id'=>$id));

                return json_encode($result);
        }

        //给九宫格的8个格子设置奖品
        public function doWebselectPrize(){
                global $_GPC, $_W;
                $uniacid = $_W['uniacid'];

                $id = $_GPC['id'];
                $aid = $_GPC['aid'];

                $res = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid and num like '%".$_GPC['num']."%'",
                            array(":uniacid" => $uniacid, ':aid' => $aid));

                //检测总概率之和有没有超过100%，超过则操作失败
                if(empty($res) || $res['id'] != $id){
                    for($i = 1; $i <= 8; $i++){
                        if($i != $_GPC['num']){
                            $chance_sum += pdo_fetchcolumn("SELECT chance FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid and num like '%".$i."%'",
                                                array(":uniacid" => $uniacid, ':aid' => $aid));
                        }
                    }
                    $chance_num = pdo_fetchcolumn("SELECT chance FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid and id = :id",
                                                array(":uniacid" => $uniacid, ':aid' => $aid, ":id" => $id));
                    if($chance_sum + $chance_num >= 10000){
                        $response = array('flag'=>1, 'warning' => '添加失败，总概率必须小于100%');
                        return json_encode($response, JSON_UNESCAPED_UNICODE);
                    }
                }

                //如果设置了每人只能中一次奖，则至多添加7个奖品
                $base = pdo_fetchcolumn("SELECT base FROM ".tablename("sudu8_page_lottery_activity")." WHERE uniacid = :uniacid and id = :aid", array(':uniacid'=>$uniacid, ':aid'=>$aid));
                $base = unserialize($base);
                if($base['just_one'] == '1' && empty($res)){
                    $flag = false;
                    for($i = 1; $i <= 8; $i++){
                        if($i != $_GPC['num']){
                            $result = pdo_fetchcolumn("SELECT id FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid and num like '%".$i."%'",
                                                array(":uniacid" => $uniacid, ':aid' => $aid));
                            if(empty($result)){
                                $flag = true;
                            }
                        }
                    }
                    if(!$flag){
                        $response = array('flag'=>2, 'warning' => '因每人只能中一次奖，8格不能全设');
                        return json_encode($response, JSON_UNESCAPED_UNICODE);
                    }
                }

                //从之前设置的奖品的num中删除当前选择的格子序号num
                if(!empty($res) && $res['id'] != $id){
                    $temp = explode('|', $res['num']);
                    foreach ($temp as $key => $value) {
                        if($value == $_GPC['num']){
                            unset($temp[$key]);
                        }
                    }
                    $temp = implode('|', $temp);
                    $data1 = array('num' => $temp);
                    pdo_update('sudu8_page_lottery_prize', $data1, array('uniacid'=>$uniacid, 'aid'=>$aid, 'id'=>$res['id']));
                }

                //添加当前选择的格子序号num到当前选择的奖品的num中
                if($res['id'] != $id){
                    $now = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid and id = :id",
                            array(":uniacid"=>$uniacid, ":aid"=>$aid, ":id"=>$id));
                    if(!empty($now['num'])){
                        $now['num'] .= '|' . $_GPC['num'];
                    }else{
                        $now['num'] = $_GPC['num'];
                    }
                    $data2 = array('num' => $now['num']);
                    pdo_update('sudu8_page_lottery_prize', $data2, array('uniacid'=>$uniacid, 'aid'=>$aid, 'id'=>$id));
                }
                                
                $prize = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid and id = :id",
                            array(":uniacid"=>$uniacid, ":aid"=>$aid, ":id"=>$id));

                if(strpos($prize['thumb'],'http')===false){
                    $prize['thumb_https'] = HTTPSHOST.$prize['thumb'];
                }else{
                    $prize['thumb_https'] = $prize['thumb'];
                }

                return json_encode($prize, JSON_UNESCAPED_UNICODE);
        }

        //修改抽奖开始方式（摇一摇、点击按钮开始）
        public function doWebchangeMeans(){
                global $_GPC, $_W;
                $uniacid = $_W['uniacid'];

                $id = $_GPC['id'];

                $activity = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_lottery_activity')." WHERE uniacid = :uniacid and id = :id",
                                    array(":uniacid"=>$uniacid, ":id"=>$id));
                $json = unserialize($activity['base']);
                if($json['means'] == '1'){
                    $json['means'] = '0';
                } else{
                    $json['means'] = '1';
                }

                pdo_update("sudu8_page_lottery_activity", array("base"=>serialize($json)), array("uniacid"=>$uniacid, "id"=>$id));

                return $json['means'];
        }

        //删除已设置的格子的奖品
        public function doWebdelSelectedPrize(){
                global $_GPC, $_W;
                $uniacid = $_W['uniacid'];

                $id = $_GPC['id'];
                $index = $_GPC['index'];

                $res = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid and num like '%".$index."%'",
                            array(":uniacid" => $uniacid, ':aid' => $id));

                if(!empty($res)){
                    $temp = explode('|', $res['num']);
                    foreach ($temp as $key => $value) {
                        if($value == $index){
                            unset($temp[$key]);
                        }
                    }
                    $temp = implode('|', $temp);
                    $data1 = array('num' => $temp);
                    pdo_update('sudu8_page_lottery_prize', $data1, array('uniacid'=>$uniacid, 'aid'=>$id, 'id'=>$res['id']));
                }
        }
}