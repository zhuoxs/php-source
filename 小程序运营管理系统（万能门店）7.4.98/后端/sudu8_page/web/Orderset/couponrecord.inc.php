<?php
global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $ops = array('display', 'delete','hx','excel');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        if($opt == 'display'){
            $search_flag = $_GPC['search_flag'];
            $start_get = $_GPC['start_get'];
            $end_get = $_GPC['end_get'];
            $start_use = $_GPC['start_use'];
            $end_use = $_GPC['end_use'];
            $search_type = $_GPC['search_type'];
            $search_keys = $_GPC['search_keys'];
            $uid = $_GPC['uid'];

            pdo_query("UPDATE ".tablename("sudu8_page_coupon_user")." SET flag = 2 WHERE flag = 0 and etime > 0 and etime < unix_timestamp()");
            $where = "";
            if(!empty($_GPC['uid'])){
                $where .= ' and a.uid = '.$_GPC['uid'];
            }
            if($_GPC['search_flag'] != null){ //类型 全部3、待使用0、已使用1、已过期2
                if($_GPC['search_flag'] !=3 ){
                    $where .= ' and a.flag = '.$_GPC['search_flag'];
                }
            }

            if(!empty($_GPC['start_get'])){//领取时间开始
                $where .= ' and a.ltime >= '.strtotime($_GPC['start_get']);
            }
            if(!empty($_GPC['end_get'])){//领取时间结束
                $where .= ' and a.ltime <= '.strtotime($_GPC['end_get']);
            }
            if(!empty($_GPC['start_use'])){//领取时间结束
                $where .= ' and a.utime >= '.strtotime($_GPC['start_use']);
            }
            if(!empty($_GPC['end_use'])){
                $where .= ' and a.utime <= '.strtotime($_GPC['end_use']);
            }
            if(!empty($_GPC['search_keys'])){
                if(!empty($_GPC['search_type'])){
                    if($search_type == 1){
                        $where .= ' and b.title like "%'.trim($_GPC['search_keys']).'%"';
                    }else{
                        $where .= ' and c.nickname like "%'.trim($_GPC['search_keys']).'%"';
                    }
                }
            }
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_coupon_user')." as a LEFT JOIN ".tablename('sudu8_page_coupon')." AS b on a.cid = b.id LEFT JOIN ".tablename('sudu8_page_user')." as c on a.uid = c.id WHERE a.uniacid = :uniacid ".$where." ORDER BY a.ltime desc" , array(':uniacid' => $_W['uniacid']));
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);
            if($start > $total){
               $start = 0; 
            }

            $coupon =  pdo_fetchall("SELECT a.*,b.title,c.nickname,c.avatar,c.mobile,a.ltime,a.utime FROM ".tablename('sudu8_page_coupon_user')." as a LEFT JOIN ".tablename('sudu8_page_coupon')." AS b on a.cid = b.id LEFT JOIN ".tablename('sudu8_page_user')." as c on a.uid = c.id WHERE a.uniacid = :uniacid ".$where." ORDER BY a.ltime desc limit ".$start.",".$pagesize, array(':uniacid' => $_W['uniacid']));

            
            foreach ($coupon as $key => &$value) {
                $value['nickname'] = rawurldecode($value['nickname']);
                if($value['ltime'] > 0){
                    $value['ltime'] = date("Y-m-d H:i:s",$value['ltime']);
                }else{
                    $value['ltime'] = "";
                }
                if($value['utime'] > 0){
                    $value['utime'] = date("Y-m-d H:i:s",$value['utime']);
                }else{
                    $value['utime'] = "";
                }
            }
        }
        if($opt == 'delete'){
    	    $id = $_GPC['id'];
            $res = pdo_delete('sudu8_page_coupon_user', array('id' => $id ,'uniacid' => $uniacid));
            if($res){
                message('优惠券领取记录删除成功!', $this->createWebUrl('Orderset', array('opt' => 'display','op' => 'couponrecord', 'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
            }
        }
        if($opt == 'hx'){
            $id = $_GPC['id'];
            $data['utime'] = time();
            $data['flag'] = 1;
            $res = pdo_update('sudu8_page_coupon_user', $data, array('id' => $id));
            message('核销成功!', $this->createWebUrl('Orderset', array('op'=>'couponrecord','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }
        if($opt == 'excel'){
            $excel_coupons = pdo_fetchall("select d.name,a.ltime,a.utime,b.realname,b.nickname,b.mobile,c.title,c.pay_money,c.price from ".tablename('sudu8_page_coupon_user')." as a LEFT JOIN ".tablename('sudu8_page_user')." as b on a.uid = b.id LEFT JOIN ".tablename("sudu8_page_coupon")." as c on a.cid = c.id LEFT JOIN ".tablename('account_wxapp')." as d on a.uniacid = d.acid where a.uniacid = :uniacid and a.flag= 1 order by a.id desc",array(':uniacid' => $uniacid));

            include MODULE_ROOT.'/plugin/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new \PHPExcel();

            /*以下是一些设置*/
            $objPHPExcel->getProperties()->setCreator("优惠券使用记录")
                ->setLastModifiedBy("优惠券使用记录")
                ->setTitle("优惠券使用记录")
                ->setSubject("优惠券使用记录")
                ->setDescription("优惠券使用记录")
                ->setKeywords("优惠券使用记录")
                ->setCategory("优惠券使用记录");
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '优惠券标题');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', '满减');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', '优惠券领取时间');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', '优惠券使用时间');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', '使用者昵称');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', '使用者姓名');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', '使用者电话');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', '所属小程序');

            foreach($excel_coupons as $k => $v){
                $num=$k+2;

                if($v['utime'] > 0){
                    $utime = date("Y-m-d H:i:s", $v['utime']);
                }else{
                    $utime = "";
                }

                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValueExplicit('A'.$num, $v['title'],'s')
                            ->setCellValueExplicit('B'.$num, "满".$v['pay_money']."减".$v['price'],'s')
                            ->setCellValueExplicit('C'.$num, date("Y-m-d H:i:s", $v['ltime']),'s') 
                            ->setCellValueExplicit('D'.$num, $utime,'s')
                            ->setCellValueExplicit('E'.$num, $v['nickname'], 's')
                            ->setCellValueExplicit('F'.$num, $v['realname'], 's')
                            ->setCellValueExplicit('G'.$num, $v['mobile'], 's')
                            ->setCellValueExplicit('H'.$num, $v['name'], 's');
                  
            }
            $objPHPExcel->getActiveSheet()->setTitle('导出优惠券使用记录');
            $objPHPExcel->setActiveSheetIndex(0);
            $excelname="优惠券使用记录表";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
return include self::template('web/Orderset/couponrecord');
