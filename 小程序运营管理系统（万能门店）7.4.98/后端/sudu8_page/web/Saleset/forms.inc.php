<?php 
// global $_W['attachurl'];

//表单管理
global $_GPC, $_W;
$opt = $_GPC['opt'];
$ops = array('formAllL','formAllV','formAllD','formAllCL','formAllCP','formAllCD','formSysL','formSysV','formSysP','formSysD','formNotice','gwcFormset',"excel");
$opt = in_array($opt, $ops) ? $opt : 'formAllL';
$uniacid = $_W['uniacid'];
if($opt=='formAllL'){
    //万能表单信息列表
    $_W['page']['title'] = '万能表单信息列表';
    $total = pdo_fetchall("SELECT a.id FROM ".tablename("sudu8_page_formcon")." as a left join ".tablename("sudu8_page_products")." as b on a.cid = b.id and a.uniacid = b.uniacid WHERE a.uniacid = :uniacid and (a.source is null or a.source <> 'VIP申请') and (b.type = 'showArt' or b.type is null)", array(":uniacid"=>$uniacid));
    $total = count($total);
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize = 15;
    $pager = pagination($total, $pageindex, $pagesize);
    // SELECT a.id, a.cid, a.creattime, a.flag, a.source, a.fid FROM `ims_sudu8_page_formcon` as a 
    // LEFT JOIN `ims_sudu8_page_products` as b ON a.cid = b.id and a.uniacid = b.uniacid 
    // WHERE a.uniacid = 59 and a.source <> 'VIP申请' and (b.type not like 'showPro' or b.type is null) ORDER BY creattime desc
    $formset = pdo_fetchall("SELECT a.id,a.cid,a.creattime,a.flag,a.source,a.fid FROM ".tablename("sudu8_page_formcon")." as a left join ".tablename("sudu8_page_products")." as b on a.cid = b.id and a.uniacid = b.uniacid WHERE a.uniacid = :uniacid and (a.source is null or a.source <> 'VIP申请') and (b.type = 'showArt' or b.type is null) ORDER BY creattime DESC LIMIT ".($pageindex - 1) * $pagesize.",".$pagesize,
        array(":uniacid"=>$uniacid));
    if($formset){
        foreach ($formset as $key => &$res) {
            $pro = pdo_fetch("SELECT title,formset FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $res['cid'] ,':uniacid' => $uniacid));
            if($pro){
                $res['title'] = $pro['title'];
                $res['formtitle'] = pdo_getcolumn("sudu8_page_formlist", array("uniacid"=>$uniacid, "id"=>$pro['formset']), "formname");
            }else{
                $res['formtitle'] = pdo_getcolumn("sudu8_page_formlist", array("uniacid"=>$uniacid, "id"=>$res['fid']), "formname");
            }
            //$res['val'] = unserialize($res['val']);
            $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
        }
    }
}

if($opt == 'excel'){
    $id = $_GPC['id'];
    $jieguo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE id = :id ORDER BY id",array(':id' => $id));

    $jieguos = unserialize($jieguo['tp_text']);
    include MODULE_ROOT.'/plugin/phpexcel/Classes/PHPExcel.php';
    $objPHPExcel = new \PHPExcel();
//    /*以下是一些设置*/
    $objPHPExcel->getProperties()->setCreator($jieguo["formname"])
        ->setLastModifiedBy($jieguo["formname"])
        ->setTitle($jieguo["formname"])
        ->setSubject($jieguo["formname"])
        ->setDescription($jieguo["formname"])
        ->setKeywords($jieguo["formname"])
        ->setCategory($jieguo["formname"]);
    $array2=array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ');
    $objPHPExcel->getActiveSheet()->setCellValue($array2[0]."1","提交人昵称");
    $objPHPExcel->getActiveSheet()->setCellValue($array2[1]."1","提交人头像路径");
    $objPHPExcel->getActiveSheet()->setCellValue($array2[2]."1","查看时间（0未查看）");
    $objPHPExcel->getActiveSheet()->setCellValue($array2[3]."1","表单备注");
    for($i=0;$i<count($jieguos);$i++){
        $objPHPExcel->getActiveSheet()->setCellValue($array2[$i+4]."1",$jieguos[$i]["name"]);
    }



    $excel=pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_formcon')." WHERE fid = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
//   var_dump($excel);
//   exit();
   foreach($excel as $k=>$reb){
       $k=$k+2;
     $userinfo=pdo_fetch("SELECT * FROM ".tablename("sudu8_page_user")." WHERE openid= :openid and uniacid= :uniacid ",array(":uniacid"=>$uniacid,":openid"=>$reb['openid']));

    $reb['val']= unserialize($reb['val']);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($array2[0].$k,$userinfo['nickname'],'s');
       $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($array2[1].$k,$userinfo['avatar'],'s');
       if($reb['vtime']){
           $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($array2[2].$k,date("Y-m-d H:i:s",$reb['vtime']),'s');
       }else{
           $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($array2[2].$k,0,'s');
       }
       $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($array2[3].$k,$reb['beizhu'],'s');
       for($j=0;$j<count($jieguos)+1;$j++) {
           if (isset($reb['val'][$j]['val'])) {
               if (!empty($reb['val'][$j]['val'])) {
                   if (is_array($reb['val'][$j]['val'])) {
                       $a = '';
                       for ($m = 0; $m < count($reb['val'][$j]['val']); $m++) {
                           $a .= $reb['val'][$j]['val'][$m] . '</br>';
                       }
                       $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($array2[$j + 4] . $k, $a, 's');
                   } else {
                       $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($array2[$j + 4] . $k, $reb['val'][$j]['val'], 's');
                   }
               } else {
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($array2[$j + 4] . $k, '', 's');
               }
           }
       }
   }

    $objPHPExcel->getActiveSheet()->setTitle($jieguo["formname"].'信息');
    $objPHPExcel->setActiveSheetIndex(0);
    $excelname=$jieguo["formname"]."提交记录表";
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
//    exit;
    message('设置成功!', $this->createWebUrl('Saleset', array('op'=>'forms','opt'=>'formAllL','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
}



//万能表单信息单个查下
if ($opt == 'formAllV') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT a.*,b.formname as title FROM ".tablename('sudu8_page_formcon')." as a LEFT JOIN ".tablename('sudu8_page_formlist')." as b on a.fid = b.id WHERE a.id = :id and a.uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
    if($item){
        $title = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $item['cid'] ,':uniacid' => $uniacid));
        $item['title'] = "";
        if($title){
            $item['title'] = $title['title'];
            $item['formtitle'] = pdo_getcolumn("sudu8_page_formlist", array("uniacid"=>$uniacid, "id"=>$title['formset']), "formname");
        }else{
            $item['formtitle'] = pdo_getcolumn("sudu8_page_formlist", array("uniacid"=>$uniacid, "id"=>$item['fid']), "formname");
        }

        $itemval = unserialize($item['val']);

        foreach ($itemval as $key => &$res) { 
            if($res['z_val']){
                foreach ($res['z_val'] as $k => &$rek) {
                        if(strstr($rek,"http")){
                            $rek = $rek;
                        }else{
                            $rek = HTTPSHOST.$rek;
                    }
                }
            }
        }
        $item['val'] = $itemval;
        $item['creattime'] = date("Y-m-d H:i:s",$item['creattime']);
        if($item['vtime']){
            $item['vtime'] = date("Y-m-d H:i:s",$item['vtime']);
        }
    }
 
    if (empty($item)) {
        message('记录不存在或是已经被删除！');
    }
    if (checksubmit('submit')) {
        $data = array(
            'flag' => 1,
            'beizhu' => $_GPC['beizhu'],
            'vtime'=>TIMESTAMP
        );
        pdo_update('sudu8_page_formcon', $data, array('id' => $id ,'uniacid' => $uniacid));

        $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formcon')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
        $applet = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
        $appid = $applet['key'];
        $appsecret = $applet['secret'];
        if($applet)
        {
            $mid =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_message')." WHERE uniacid = :uniacid and flag=2" , array(':uniacid' => $_W['uniacid']));
            if($mid && $mid['attach'] == '1')
            {   
                $mid = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_message')." WHERE uniacid = :uniacid and flag=11" , array(':uniacid' => $_W['uniacid']));
                if($mid['mid']!="")
                {
                    $mids = $mid['mid'];
                    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;

                    //curl完成  
                    $curl = curl_init();  
                    //设置curl选项  
                    $header = array(  
                        "authorization: Basic YS1sNjI5dmwtZ3Nocmt1eGI2Njp1TlQhQVFnISlWNlkySkBxWlQ=",
                        "content-type: application/json",
                        "cache-control: no-cache",
                        "postman-token: cd81259b-e5f8-d64b-a408-1270184387ca" 
                    );
                    curl_setopt($curl, CURLOPT_HEADER, 1);
                    curl_setopt($curl, CURLOPT_HTTPHEADER  , $header); 
                    curl_setopt($curl, CURLOPT_URL, $url);//URL  
                    curl_setopt($curl, CURLOPT_HEADER, 0);             // 0：不返回头信息
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   
                    curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间  
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
                    // 发出请求  
                    $response = curl_exec($curl);
                    if (false === $response) {  
                        echo '<br>', curl_error($curl), '<br>';  
                        return false;  
                    }  
                    curl_close($curl);  
                    $a_token = stripslashes(html_entity_decode($response));
                    $a_token = json_decode($a_token,TRUE);

                    if($a_token)
                    {
                        $url_m="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$a_token['access_token'];
                        $furl = $mid['url'];
                        $post_info = '{
                          "touser": "'.$item['openid'].'",  
                          "template_id": "'.$mids.'", 
                          "page": "'.$furl.'",          
                          "form_id": "'.$item['formid'].'",         
                          "data": {
                              "keyword1": {
                                  "value": "审核通过", 
                                  "color": "#173177"
                              }, 
                              "keyword2": {
                                  "value": "'.date("Y-m-d H:i:s", $item['creattime']).'", 
                                  "color": "#173177"
                              },
                              "keyword3":{
                                  "value": "'.date("Y-m-d H:i:s", $item['vtime']).'",
                                  "color": "#173177"
                              }
                          },
                          "emphasis_keyword": "keyword1.DATA" 
                        }';

                        //curl完成  
                        $curl = curl_init();  
                        //设置curl选项  
                        curl_setopt($curl, CURLOPT_URL, $url_m);//URL  
                        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';  
                        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息  
                        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源  
                        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间  
                        //SSL相关  
                        // if ($ssl) {  
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证  
                            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。  
                        // }  
                        // 处理post相关选项  
                        curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求  
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_info);// 处理请求数据  
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
                    }
                }
            }
        }
        message('设置成功!', $this->createWebUrl('Saleset', array('op'=>'forms','opt'=>'formAllL','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    };
}
//万能表单信息删除
if ($opt == 'formAllD') {
    $id = $_GPC['id'];
    pdo_delete('sudu8_page_formcon', array('id' => $id ,'uniacid' => $uniacid));
    message('信息删除成功!', $this->createWebUrl('Saleset', array('op'=>'forms','opt'=>'formAllL','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
}
//万能表单列表
if ($opt == 'formAllCL'){
    $_W['page']['title'] = '万能表单管理';
    $formset =  pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE uniacid = :uniacid ORDER BY id DESC " , array(':uniacid' => $uniacid));
    foreach ($formset as $key => &$res) {
        $res['tp_text'] = unserialize($res['tp_text']);
    }

}
//万能表单添加
if ($opt == 'formAllCP'){
    //$formid = $_GPC['formid'];
    //
    $id = $_GPC['id'];
    $formlet =  pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_formt')." WHERE flag = 1");
    $jieguo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE id = :id ORDER BY id",array(':id' => $id));
    $jieguo['tp_text'] = unserialize($jieguo['tp_text']);
    if (checksubmit('submit')) {
        $data['uniacid'] = $uniacid;
        //$data['formid'] = $_GPC['formid'];
        $data['formname'] = $_GPC['formname'];
        $data['descs'] = $_GPC['descs'];
        $zd_name = array();
        $zd_name = $_GPC['zd_name'];
        $ck_box = array();
        $ck_box = $_GPC['ck_box'];
        $tp_text = array();
        $tp_text = $_GPC['tp_text'];

        $types = array();
        $types = $_GPC['types'];
        $allcount = count($zd_name);
        $formsValueAll = array();
        $formsValue = array();
        foreach ($zd_name as $key => &$res) {
            $formsValue['name'] = $res;
            $formsValue['type'] = $types[$key];
            $formsValue['ismust'] = $ck_box[$key];
            $formsValue['tp_text'] = $tp_text[$key]; 
            $formsValueAll[] = $formsValue;
        }

        $data['tp_text'] = serialize($formsValueAll);
        if($id){
            $res = pdo_update('sudu8_page_formlist', $data, array('id' => $id ,'uniacid' => $uniacid));
        }else{
            $res = pdo_insert('sudu8_page_formlist', $data);
        }

        message('万能表单 添加/修改 成功!', $this->createWebUrl('Saleset', array('op'=>'forms','opt'=>'formAllCL','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    }
}
//删除
if ($opt == 'formAllCD') {
    $id = $_GPC['id'];
    $uniacid = $_W['uniacid'];
    pdo_delete('sudu8_page_formlist', array('id' => $id ,'uniacid' => $uniacid));
    message('表单删除成功!', $this->createWebUrl('Saleset', array('op'=>'forms','opt'=>'formAllCL','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
}
//系统自带表单信息列表
if ($opt == 'formSysL'){
    $_W['page']['title'] = '系统预约信息列表';
    $participators = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_forms') ." WHERE uniacid = :uniacid ORDER BY id DESC", array(':uniacid' => $uniacid)); 
    $total = count($participators);  
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize = 15;  
    $pager = pagination($total, $pageindex, $pagesize);  
    $p = ($pageindex-1) * 15;
    //var_dump($pageindex);
    $list = pdo_fetchall("SELECT * FROM " . tablename('sudu8_page_forms') ." WHERE uniacid = :uniacid ORDER BY `id` DESC LIMIT " . $p . "," . $pagesize, array(':uniacid' => $uniacid));
}
//查询记录
if ($opt == 'formSysV') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
    $v = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forms')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
    $item['t5'] = unserialize($item['t5']);
    $item['t6'] = unserialize($item['t6']);
    $item['s2'] = unserialize($item['s2']);
    $item['c2'] = unserialize($item['c2']);
    $item['con2'] = unserialize($item['con2']);
    if (empty($v)) {
        message('记录不存在或是已经被删除！');
    }
    if (checksubmit('submit')) {
        $data = array(
            'status' => 1,
            'sss_beizhu' => $_GPC['sss_beizhu'],
            'vtime'=>TIMESTAMP
        );
        pdo_update('sudu8_page_forms', $data, array('id' => $id ,'uniacid' => $uniacid));
        message('设置成功!', $this->createWebUrl('Saleset', array('op'=>'forms','opt'=>'formSysL','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    };
}
//删除记录
if ($opt == 'formSysD') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forms')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
    if (empty($row)) {
        message('记录不存在或是已经被删除！');
    }
    pdo_delete('sudu8_page_forms', array('id' => $id ,'uniacid' => $uniacid));

    message('删除成功!', $this->createWebUrl('Saleset', array('op'=>'forms','opt'=>'formSysL','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
}
if ($opt == 'formSysP'){
    $_W['page']['title'] = '系统预约配置';
    $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
    $item['t5arr'] = unserialize($item['t5']);
    $item['t5n'] = $item['t5arr']['t5n'];
    $item['t5u'] = $item['t5arr']['t5u'];
    $item['t5m'] = $item['t5arr']['t5m'];
    $item['t5i'] = $item['t5arr']['t5i'];
    $item['t6arr'] = unserialize($item['t6']);
    $item['t6n'] = $item['t6arr']['t6n'];
    $item['t6u'] = $item['t6arr']['t6u'];
    $item['t6m'] = $item['t6arr']['t6m'];
    $item['t6i'] = $item['t6arr']['t6i'];
    $item['c2arr'] = unserialize($item['c2']);
    $item['c2n'] = $item['c2arr']['c2n'];
    $item['c2num'] = $item['c2arr']['c2num'];
    $item['c2v'] = $item['c2arr']['c2v'];
    $item['c2u'] = $item['c2arr']['c2u'];
    $item['c2m'] = $item['c2arr']['c2m'];
    $item['c2i'] = $item['c2arr']['c2i'];
    $item['s2arr'] = unserialize($item['s2']);
    $item['s2n'] = $item['s2arr']['s2n'];
    $item['s2num'] = $item['s2arr']['s2num'];
    $item['s2v'] = $item['s2arr']['s2v'];
    $item['s2u'] = $item['s2arr']['s2u'];
    $item['s2m'] = $item['s2arr']['s2m'];
    $item['s2i'] = $item['s2arr']['s2i'];
    $item['con2arr'] = unserialize($item['con2']);
    $item['con2n'] = $item['con2arr']['con2n'];
    $item['con2u'] = $item['con2arr']['con2u'];
    $item['con2m'] = $item['con2arr']['con2m'];
    $item['con2i'] = $item['con2arr']['con2i'];
    $item['img1arr'] = unserialize($item['img1']);
    $item['img1n'] = $item['img1arr']['img1n'];
    $item['img1u'] = $item['img1arr']['img1u'];
    $item['img1m'] = $item['img1arr']['img1m'];
    $item['img1i'] = $item['img1arr']['img1i'];
    $item['img1not'] = $item['img1arr']['img1not'];
    if (checksubmit('submit')) {
        if (empty($_GPC['forms_name'])) {
            message('请输入表单名称');
        }
        $t5arr = array(  
            't5n' => $_GPC['t5n'],
            't5u' => $_GPC['t5u'],
            't5m' => $_GPC['t5m'],
            't5i' => $_GPC['t5i'],
        );
        $t5text = serialize($t5arr);
        $t6arr = array(  
            't6n' => $_GPC['t6n'],
            't6u' => $_GPC['t6u'],
            't6m' => $_GPC['t6m'],
            't6i' => $_GPC['t6i'],
        );
        $t6text = serialize($t6arr);
        $c2arr = array(  
            'c2n' => $_GPC['c2n'],
            'c2num' => $_GPC['c2num'],
            'c2v' => $_GPC['c2v'],
            'c2u' => $_GPC['c2u'],
            'c2m' => $_GPC['c2m'],
            'c2i' => $_GPC['c2i'],
        );
        $c2text = serialize($c2arr);
        $s2arr = array(  
            's2n' => $_GPC['s2n'],
            's2num' => $_GPC['s2num'],
            's2v' => $_GPC['s2v'],
            's2u' => $_GPC['s2u'],
            's2m' => $_GPC['s2m'],
            's2i' => $_GPC['s2i'],
        );
        $s2text = serialize($s2arr);
        $con2arr = array(  
            'con2n' => $_GPC['con2n'],
            'con2u' => $_GPC['con2u'],
            'con2m' => $_GPC['con2m'],
            'con2i' => $_GPC['con2i'],
        );
        $con2text = serialize($con2arr);
        $img1arr = array(  
            'img1n' => $_GPC['img1n'],
            'img1u' => $_GPC['img1u'],
            'img1m' => $_GPC['img1m'],
            'img1i' => $_GPC['img1i'],
            'img1not' => $_GPC['img1not'],
        );
        $img1text = serialize($img1arr);
        $data = array(
            'uniacid'=> $uniacid,
            'forms_head' => $_GPC['forms_head'],
            'forms_head_con' => htmlspecialchars_decode($_GPC['forms_head_con'], ENT_QUOTES),
            'forms_title_s' => $_GPC['forms_title_s'],
            'forms_name' => $_GPC['forms_name'],
            'forms_ename' => $_GPC['forms_ename'],
            'success' => $_GPC['success'],
            'name' => $_GPC['name'],
            'name_must' => intval($_GPC['name_must']),
            'tel' => $_GPC['tel'],
            'tel_use' => intval($_GPC['tel_use']),
            'tel_must' => intval($_GPC['tel_must']),
            'wechat' => $_GPC['wechat'],
            'wechat_use' => intval($_GPC['wechat_use']),
            'wechat_must' => intval($_GPC['wechat_must']),
            'address' => $_GPC['address'],
            'address_use' => intval($_GPC['address_use']),
            'address_must' => intval($_GPC['address_must']),
            'date' => $_GPC['date'],
            'date_use' => intval($_GPC['date_use']),
            'date_must' => intval($_GPC['date_must']),
            'time' => $_GPC['time'],
            'time_use' => intval($_GPC['time_use']),
            'time_must' => intval($_GPC['time_must']),
            'single_n' => $_GPC['single_n'],
            'single_num' => intval($_GPC['single_num']),
            'single_v' => $_GPC['single_v'],
            'single_use' => intval($_GPC['single_use']),
            'single_must' => intval($_GPC['single_must']),
            'checkbox_n' => $_GPC['checkbox_n'],
            'checkbox_num' => intval($_GPC['checkbox_num']),
            'checkbox_v' => $_GPC['checkbox_v'],
            'checkbox_use' => intval($_GPC['checkbox_use']),
            'checkbox_must' => intval($_GPC['checkbox_must']),
            'content_n' => $_GPC['content_n'],
            'content_use' => intval($_GPC['content_use']),
            'content_must' => intval($_GPC['content_must']),
            'forms_btn' => $_GPC['forms_btn'],
            'forms_style' => intval($_GPC['forms_style']),
            'forms_inps' => intval($_GPC['forms_inps']),
            'subtime' => intval($_GPC['subtime']),
            'tel_i' => intval($_GPC['tel_i']),
            'wechat_i' => intval($_GPC['wechat_i']),
            'address_i' => intval($_GPC['address_i']),
            'date_i' => intval($_GPC['date_i']),
            'time_i' => intval($_GPC['time_i']),
            'single_i' => intval($_GPC['single_i']),
            'checkbox_i' => intval($_GPC['checkbox_i']),
            'content_i' => intval($_GPC['content_i']),
            't5' => $t5text,
            't6' => $t6text,
            'c2' => $c2text,
            's2' => $s2text,
            'con2' => $con2text,
            'img1' => $img1text,
        );
        //var_dump($item['uniacid']);
        //var_dump($data);
        if (empty($item['uniacid'])) {
            pdo_insert('sudu8_page_forms_config', $data);
        } else {
            pdo_update('sudu8_page_forms_config', $data ,array('uniacid' => $uniacid));
        }
        message('表单配置成功!', $this->createWebUrl('Saleset', array('op'=>'forms','opt'=>'formSysP','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    }
}
if ($opt == 'formNotice'){
    $_W['page']['title'] = '提醒接收人';
    $item = pdo_fetch("SELECT uniacid,mail_sendto FROM ".tablename('sudu8_page_forms_config') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
    if (checksubmit('submit')) {
        $data = array(
            'uniacid'=> $uniacid,
            'mail_sendto' => $_GPC['mail_sendto'],
        );
        if (empty($item['uniacid'])) {
            pdo_insert('sudu8_page_forms_config', $data);
        } else {
            pdo_update('sudu8_page_forms_config', $data ,array('uniacid' => $uniacid));
        }
        message('提醒接收人修改成功!', $this->createWebUrl('Saleset', array('op'=>'forms','opt'=>'formNotice','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    }
}

if ($opt == "gwcFormset"){
    $_W['page']['title'] = '购物车表单设置';
    $gwcforms = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE uniacid = :uniacid order by id desc", array(':uniacid' => $uniacid));
    $yunfeidata = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_yunfei')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));

    if(checksubmit('gwcform')){
        $conf = array(
            "formset" => $_GPC['gwcformset']
        );

        if(empty($yunfeidata)){
            $conf['uniacid'] = $uniacid;
            $conf['byou'] = 0;
            $conf['yfei'] = 0;
            pdo_insert('sudu8_page_duo_products_yunfei', $conf);
        }else{
            pdo_update('sudu8_page_duo_products_yunfei', $conf, array('uniacid' => $uniacid));
        }
        message('购物车表单设置成功!', $this->createWebUrl('Saleset', array('op'=>'forms','opt'=>'gwcFormset','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    }
}

return include self::template('web/Saleset/forms');