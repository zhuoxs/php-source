<?php
 global $_W;
        load()->model('mc');
        require_once IA_ROOT.'/addons/tiger_newhu/lib/excel.php';
        $filename = '兑换记录_' . date('YmdHis') . '.csv';
        $exceler = new Tiger_Export();
        $exceler->charset('UTF-8');
        // 生成excel格式 这里根据后缀名不同而生成不同的格式。jason_excel.csv
        $exceler->setFileName($filename);
        // 设置excel标题行
        $excel_title = array('粉丝昵称','粉丝OPENID','真实姓名','手机号码','地址','商品名称','价格','消耗积分','兑换时间');
        $exceler->setTitle($excel_title);
        // 设置excel内容
        $excel_data = array();
        
        //$list = pdo_fetchall('select * from '.tablename($this->modulename."_request")."  where weid='{$_W['uniacid']}'");
        $sql = "SELECT t1.*,t2.title FROM " . tablename($this -> table_request) . "as t1 LEFT JOIN " . tablename($this -> table_goods) . " as t2 " . " ON  t2.goods_id=t1.goods_id AND t2.weid=t1.weid AND t2.weid='{$_W['weid']}' WHERE t1.weid = '{$_W['weid']}' ORDER BY t1.createtime DESC";
            
        $list = pdo_fetchall($sql);
        //echo '<pre>';
        //print_r($list);
       // exit;
        load()->model('mc');
        foreach ($list as $value) {
            $mc = mc_fetch($value['uid']);
            $data = array();
            $data[] = $value['from_user_realname'];
            $data[] = $value['from_user'];
            $data[] = $value['realname'];
            $data[] = $value['mobile'];
            $data[] = $value['residedist'];
            $data[] = $value['title'];
            $data[] = $value['price'];
            $data[] = $value['cost'];
            $data[] = date("Y-m-d H:i:s", $value["createtime"]);
            $excel_data[] = $data;
            $allsum++;
        }
        
        $allsum = 0;
        $excel_data[] = array('总数目:', $allsum);
        $exceler->setContent($excel_data);
        // 生成excel
        $exceler->export();
        exit;
       //include "downloade.php";