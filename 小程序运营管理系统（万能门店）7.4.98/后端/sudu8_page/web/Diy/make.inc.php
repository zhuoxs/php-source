<?php
global $_W,$_GPC;
define("ASSETSS",MODULE_URL."template/diy/");
$opt = $_GPC['opt'] ? $_GPC['opt'] : 'display';
$tplid=$_GPC["tplid"];
$uniacid = $_W['uniacid'];
if($opt == 'display'){
    //查出当前模板关联页面id
    $bg_music = pdo_getcolumn("sudu8_page_base", array("uniacid" => $uniacid), "diy_bg_music");

    $mapforum = 1;
    if(!pdo_tableexists('sudu8_page_mapforum_set')){
        $mapforum = 0;
    }

    $temp = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypagetpl')." WHERE id = :tplid", array(':tplid' => $tplid));
    if($temp['pageid'] == ""){
        $tpldata = array(
            'uniacid' => $uniacid,
            'index' => 1,
            'page' => 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ffffff";s:8:"topcolor";s:1:"1";s:9:"styledata";s:1:"0";s:5:"title";s:21:"小程序页面标题";s:4:"name";s:18:"后台页面名称";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}',
            'items' => '',
            'tpl_name' => '后台页面名称',
        );
        pdo_insert("sudu8_page_diypage", $tpldata);
        $pageid = pdo_insertid();
        pdo_update("sudu8_page_diypagetpl", array("pageid"=>$pageid), array('id' => $tplid));
        $temp = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypagetpl')." WHERE id = :tplid", array(':tplid' => $tplid));
    }

    //改变原来的模板状态为不启用
    $tpls = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_diypagetpl')." WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));

    if($tpls){
        foreach ($tpls as $k => $v) {
            pdo_update("sudu8_page_diypagetpl", array('status' => 2), array('uniacid' => $uniacid));
        }
    }
    pdo_update("sudu8_page_diypagetpl", array('status' => 1), array('id' => $tplid));
    // $pageidArray = explode(',',$temp['pageid']);
    $pageidArray = chop($temp['pageid'],',');


    //查出当前模板所有的页面
    $sql = "SELECT id,tpl_name,`index` FROM ".tablename('sudu8_page_diypage')." WHERE `uniacid` = {$uniacid} and `id` IN (".$pageidArray.")";
    $list = pdo_fetchAll($sql);

    //页面操作
    $diypage = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypage')." WHERE `uniacid` = {$uniacid} and `id` IN (".$pageidArray.") and `index` = 1");
    if(!$diypage){
        $pageidArr = explode(',',$pageidArray);
        $diypageone = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypage')." WHERE `uniacid` = {$uniacid} and `id` IN (".$pageidArray.") ");
        pdo_update("sudu8_page_diypage", array('index' => 1), array('uniacid' => $uniacid, 'id' => $diypageone['id'], 'index' => 0));
        $diypage['id'] = $diypageone['id'];
    }
    $key_id = $_GPC['key_id'] ? $_GPC['key_id'] : $diypage['id'];  //显示页面id
    if($key_id>0){
        $setsave = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypageset')." WHERE `uniacid` = {$uniacid} and `pid` = {$key_id}");
        if(!$setsave){
            $foot_is = 1;
        }

        $data = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypage')." WHERE uniacid = :uniacid and id = :keyid", array(':uniacid' => $uniacid, ':keyid' =>$key_id));
        $data['page'] = unserialize($data['page']);
        $data['items'] = unserialize($data['items']);
        $page = $data['page'];
        $diyform = pdo_fetchAll("SELECT id,formname as title FROM ".tablename('sudu8_page_formlist')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
        $data['diyform'] = $diyform;

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $data = preg_replace("/\'/", "\'", $data);
        $data = preg_replace('/(\\\n)/', "<br>", $data);
    }else{
        $key_id = 0;
        $foot_is = 1;
        $bg_music = "";
    } 
    include self::template('diy/index');
}elseif ($opt == 'add'){
    $data = $_POST;
    if(isset($data['data']['page']['name']) && $data['data']['page']['name'] != ''){
        $sd = [];
        $sd['tpl_name'] = $data['data']['page']['name'];
        $sd['page'] = serialize($data['data']['page']);
        if(strpos($sd['page'], "\\") !== false){
            echo json_encode(['status' => -1,'message' => '保存失败，请去除特殊字符“\”再保存']);
            exit;
        }
        if(isset($data['data']['items'])){
            foreach($data['data']['items'] as $ki => $vi){
                if($vi['id'] == "video" ){
                    if(!empty($vi['params']['videourl'])){
                        if(strpos($vi['params']['videourl'],"</iframe>") !== false || strpos($vi['params']['videourl'],"</embed>") !== false){
                            $data['data']['items'][$ki]['params']['videourl'] = "";
                        }
                    }
                }
                if($vi['id'] == "yuyin" ){
                    if(!empty($vi['params']['linkurl'])){
                        if(strpos($vi['params']['linkurl'],"</iframe>") !== false || strpos($vi['params']['linkurl'],"</embed>") !== false){
                            $data['data']['items'][$ki]['params']['linkurl'] = "";
                        }
                    }
                }
            }
            $sd['items'] = serialize($data['data']['items']);
                if(strpos($sd['items'], "\\") !== false){
                    echo json_encode(['status' => -1,'message' => '保存失败，请去除特殊字符“\”再保存']);
                    exit;
                }
        }else{
            $sd['items'] = "";
        }
        $sd['uniacid'] = $_W['uniacid'];


        if((int)$data['id'] == 0){

            /*新创建*/
            $sql = pdo_fetch("SELECT pageid FROM ".tablename('sudu8_page_diypagetpl')." WHERE uniacid = :uniacid and id = :tplid", array(':uniacid' => $uniacid,':tplid' => $tplid));
            $pageid = $sql['pageid'];
            $pageid = chop($pageid,',');

            $idata = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypage'). " WHERE `tpl_name` = '".$sd['tpl_name']."' and `uniacid` = {$uniacid} and `id` in ({$pageid})");

            if($idata){

                echo json_encode(['status' => 0,'message' => '创建页面名称重复','id' => 0]);exit;

            }
            $is = pdo_fetch("SELECT id FROM ".tablename('sudu8_page_diypage')." WHERE `uniacid` = ".$_W['uniacid']);
            if(!$is){
                $sd['index'] = 1;
            }
            $result = pdo_insert("sudu8_page_diypage",$sd);
            $key = pdo_insertid();
            if($tplid>0){
                
                pdo_update("sudu8_page_diypagetpl", array("pageid"=>$pageid.",".$key), array('uniacid' => $uniacid, 'id' => $tplid));
            } 

        }else{

            $result = pdo_update("sudu8_page_diypage",$sd,['id' => $data['id']]);
            $key = $data['id'];
        }


        if($result){
            echo json_encode(['status' => 0,'message' => '保存成功','id' => $key]);
        }else{
            echo json_encode(['status' => -1,'message' => '保存成功，本次设置未做更改']);
        }
    }
}elseif ($opt == 'delpage'){

    $tpl_id = $_GPC["tplid"];
    $tpl_pages = pdo_getcolumn('sudu8_page_diypagetpl', array('uniacid' => $uniacid, 'id' => $tpl_id), 'pageid');
    $tpl_pages = chop($tpl_pages,',');
    $tpl_pages_count = pdo_fetchAll("SELECT id FROM ".tablename('sudu8_page_diypage')." WHERE `uniacid` = {$uniacid} and `id` in ({$tpl_pages})");

    if(count($tpl_pages_count) == 1){
        message("删除失败，模板必须保留一个页面",'referer','error');
        exit;
    }

    $id = $_GPC['id'] ? (int)$_GPC['id'] : 0;


    if($id == 0){

        message('参数错误');

        exit;

    }


    $is_index = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypage')." WHERE `uniacid` = :uniacid and `id` = :id and `index` = 1", array(":uniacid" => $uniacid, ':id' => $id));
    if($is_index){
        message("当前页面为首页不可删除",'referer','error');
        exit;
    }

    $result = pdo_delete("sudu8_page_diypage",['id' => $id]);



    if($result){

        message("删除成功",'referer','success');

    }else{

        message("删除失败",'referer','error');

    }

}elseif ($opt == 'selecticon'){
    return include self::template("diy/icon");
}elseif ($opt == 'selecturl'){
	$tplid = $_GPC['tplid_only']; //模板id
    if(!$tplid){
        $tplid = pdo_getcolumn("sudu8_page_diypagetpl", array('uniacid' => $uniacid, 'status' => 1), "id");
    }
	$pageid = pdo_getcolumn('sudu8_page_diypagetpl', array('uniacid' => $uniacid, 'id' => $tplid), 'pageid');
    $pageid = chop($pageid,',');
    $diypage = pdo_fetchall("SELECT id,tpl_name FROM ".tablename('sudu8_page_diypage')." WHERE `uniacid` = {$_W['uniacid']} and `id` in (".$pageid.")");

    $article = pdo_fetchall("SELECT id,title FROM ".tablename('sudu8_page_products')." WHERE `uniacid` = {$_W['uniacid']} and type = 'showArt'");

    $pro = pdo_fetchall("SELECT id,title,type,is_more FROM ".tablename('sudu8_page_products')." WHERE `uniacid` = {$_W['uniacid']} and type != 'showArt' and type != 'showPic' and type != 'wxapp'");

    foreach ($pro as $k => $v) {
        if($v['is_more'] == 1){
            $pro[$k]['type'] = "showPro_lv";
        }
    }

    $pic = pdo_fetchall("SELECT id,title FROM ".tablename('sudu8_page_products')." WHERE `uniacid` = {$_W['uniacid']} and type = 'showPic'");

    $cates = pdo_fetchall("SELECT id,name,type FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} and cid = 0 and statue = 1");
    foreach ($cates as $k => $v) {
        if($v['type'] == "showPro"){
            $cates[$k]['type'] = "listPro";
        }
        if($v['type'] == "showPic" || $v['type'] == "showArt"){
            $cates[$k]['type'] = "listPic";
        }
        $subcate = pdo_fetchall("SELECT id,name,type FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} and cid = {$v['id']} and statue = 1");
        foreach ($subcate as $ki=> $vi) {
            if($vi['type'] == "showPro"){
                $subcate[$ki]['type'] = "listPro";
            }
            if($vi['type'] == "showPic" || $vi['type'] == "showArt"){
                $subcate[$ki]['type'] = "listPic";
            }
        }
        $cates[$k]['subcate'] = $subcate;
    }
    return include self::template("diy/selecturl");
}elseif ($opt == 'query'){

    $type = $_GPC['type'];

    $kw = $_GPC['kw'];

    switch ($type){

        case 'news':

            $sql = "SELECT id,title FROM ".tablename("sudu8_page_products")." WHERE `type` = 'showArt' and `uniacid` = {$_W['uniacid']} AND `title` LIKE '%".$kw."%'";



            $list = pdo_fetchall($sql);




            $html = '';


            if($list){

                foreach ($list as $k => $v){

                    $html .= '<div class="line">

                                <div class="icon icon-link1"></div>

                                <nav data-href="/sudu8_page/showArt/showArt?id='.$v['id'].'" data-linktype="page" class="btn btn-default btn-sm" title="选择">选择</nav>

                                <div class="text"><span class="label lable-default">普通</span>'.$v['title'].'</div>

                            </div>';

                }
            }else{
                $html .= '<div class="line">

                               无相关搜索结果

                            </div>';
            }

            break;
        case 'pic':

            $sql = "SELECT id,title FROM ".tablename("sudu8_page_products")." WHERE `type` = 'showPic' and `uniacid` = {$_W['uniacid']} AND `title` LIKE '%".$kw."%'";



            $list = pdo_fetchall($sql);




            $html = '';


            if($list){

                foreach ($list as $k => $v){

                    $html .= '<div class="line">

                                <div class="icon icon-link1"></div>

                                <nav data-href="/sudu8_page/shwoPic/shwoPic?id='.$v['id'].'" data-linktype="page" class="btn btn-default btn-sm" title="选择">选择</nav>

                                <div class="text"><span class="label lable-default">普通</span>'.$v['title'].'</div>

                            </div>';

                }
            }else{
                $html .= '<div class="line">

                               无相关搜索结果

                            </div>';
            }

            break;
        case 'goods':

            $sql = "SELECT id,title,price,pro_kc,pro_flag FROM ".tablename('sudu8_page_products')." WHERE `type` != 'showArt' and `type` != 'showPic' and `type` != 'wxapp' and  `uniacid` = {$_W['uniacid']} AND `title` LIKE '%".$kw."%'";



            $list = pdo_fetchall($sql);



            $html = '';


            if($list){
                foreach ($list as $k => $v){

                    if($v['pro_flag'] == 2){

                        $url = "/sudu8_page/showProMore/showProMore?id=".$v['id'];

                        $g = "多规格";

                    }else{

                        $url = "/sudu8_page/showPro/showPro?id=".$v['id'];

                        $g = "单规格";

                    }

                    $html .= '<div class="line">

                                <div class="icon icon-link1"></div>

                                <nav data-href="'.$url.'" data-linktype="page" class="btn btn-default btn-sm" title="选择">选择</nav>

                                <div class="text"><span class="label lable-default">普通</span>'.$g.' - 商品名称：'.$v['title'].' &nbsp; 价格：'.$v['price'].' &nbsp; 库存：'.$v['pro_kc'].'</div>

                            </div>';

                }
            }else{
                $html .= '<div class="line">

                               无相关搜索结果

                            </div>';
            }


            break;

    }



    echo $html;

}elseif ($opt == 'getsyslist'){



    $action = $_GPC['action'];



    switch ($action){

        case 'get_cate_list':

            $sql = "SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showArt'";

            $list = pdo_fetchall($sql);

            $html = '';

            foreach ($list as $k => $v){

                $html .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';

            }

            echo $html;

            break;

        case 'get_almbs_list':

            $sql = "SELECT * FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showPic'";

            $list = pdo_fetchall($sql);

            $html = '';

            foreach ($list as $k => $v){

                $html .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';

            }

            echo $html;

            break;

        case 'get_goods_cate_list':

            $sql = "SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showPro'";

            $list = pdo_fetchall($sql);

            $html = '';

            foreach ($list as $k => $v){

                $html .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';

            }

            echo $html;

            break;

    }



}elseif ($opt == 'selectsource'){



    $type = $_GPC['type'];



    switch ($type){

        case 'noticcate':

            $sql = "SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showArt' AND `cid` = 0";

            $list = pdo_fetchall($sql);
            foreach ($list as $key => &$value) {
                $subcate = pdo_fetchall("SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showArt' AND cid = {$value['id']}");
                $value['subcate'] = $subcate;
            }
            break;

        case 'goodscate':

            $sql = "SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showPro' AND `cid` = 0";

            $list = pdo_fetchall($sql);
            foreach ($list as $key => &$value) {
                $subcate = pdo_fetchall("SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showPro' and cid = {$value['id']}");
                $value['subcate'] = $subcate;
            }
            break;

        case 'bargainCate':

            $sql = "SELECT id,title as name FROM ".tablename('sudu8_page_bargain_cate')." WHERE `uniacid` = {$_W['uniacid']}";

            $list = pdo_fetchall($sql);

            break;

        case 'piccate':

            $sql = "SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showPic'";

            $list = pdo_fetchall($sql);
            foreach ($list as $key => &$value) {
                $subcate = pdo_fetchall("SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showPic' and cid = {$value['id']}");
                $value['subcate'] = $subcate;
            }
            break;

        case 'picartcate':

            $sql = "SELECT id,name,type FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND (`type` = 'showPic' or `type` = 'showArt')";
            foreach ($list as $key => &$value) {
                $subcate = pdo_fetchall("SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND (`type` = 'showPic' or `type` = 'showArt') and cid = {$value['id']}");
                $value['subcate'] = $subcate;
            }
            $list = pdo_fetchall($sql);

            break;

        case 'articlecate':

            $sql = "SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showArt'";

            $list = pdo_fetchall($sql);
            foreach ($list as $key => &$value) {
                $subcate = pdo_fetchall("SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showArt' and cid = {$value['id']}");
                $value['subcate'] = $subcate;
            }
            break;
        case 'ptcate':

            $sql = "SELECT id,title as name FROM ".tablename('sudu8_page_pt_cate')." WHERE `uniacid` = {$_W['uniacid']}";

            $list = pdo_fetchall($sql);

            break;
        case 'formcate':

            $sql = "SELECT id,formname as name FROM ".tablename('sudu8_page_formlist')." WHERE `uniacid` = {$_W['uniacid']}";

            $list = pdo_fetchall($sql);

            break;

    }

    

    return include self::template("diy/selectsource");

}elseif ($opt == 'setindex'){

    $val = $_GPC['v'];

    $key_id = $_GPC['key_id'];



    if(empty($key_id)){

        return false;

    }

    if($val == 1){

        pdo_update("sudu8_page_diypage",['index' => 0],['uniacid' => $_W['uniacid']]);

        $result = pdo_update("sudu8_page_diypage",['index' => 1],['id' => $key_id]);

    }else{

        $result = pdo_update("sudu8_page_diypage",['index' => 0],['id' => $key_id]);

    }

    if($result){

        echo json_encode(['status' => 1,'result' => ['returndata' => 1]]);

    }else{

        echo json_encode(['status' => 0]);

    }

}elseif ($opt == 'settemplate'){

    $pageid = $_GPC['ids'];
    $pageids = "";
    foreach ($pageid as $key => $value) {
        $info = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypage')." WHERE id = :id", array(':id' => $value));
        $items = unserialize($info['items']);
        if($items){
            //去除栏目信息 
            //notice(公告) msmk(秒杀模块) goods(产品组) feedback(表单) pt(拼团) listdesc(文章) cases(图文)
            if ($v['id'] == 'notice' || $v['id'] == 'msmk' || $v['id'] == 'goods' || $v['id'] == 'feedback' || $v['id'] == 'pt' || $v['id'] == 'listdesc' || $v['id'] == 'cases') {
                $items[$k]['params']['sourceid'] = '';
            } 
        }
        $sys_data = array(
                    'index' => $info['index'],
                    'page' => $info['page'],
                    'items' => serialize($items),
                    'tpl_name' => $info['tpl_name']
                );
        pdo_insert("sudu8_page_diypage_sys", $sys_data);
        $insert_id = pdo_insertid();
        $pageids = $pageids .','. $insert_id;
    }

    $pageids = substr($pageids,1);
    $data = [
            'pageid' => $pageids,
            'template_name' => $_GPC['name'],
            'thumb' => $_GPC['preview'],
            'create_time' => time()
        ];
    
    $key_id = pdo_insert("sudu8_page_diypagetpl_sys", $data);

    echo json_encode(['status' => 1,'id' => $key_id,'message' => '保存成功']);


}elseif ($opt == 'settemp'){
    $templateid = (int)$_GPC['templateid'];
    if($templateid > 0){

        $data = [
            'template_name' => $_GPC['name'],

            'thumb' => $_GPC['preview'],

            'uniacid' => $_W['uniacid']
        ];
        $res = pdo_update("sudu8_page_diypagetpl", $data, array('id' => $templateid));

        echo json_encode(['status' => 1,'message' => '保存成功']);

    }

}elseif ($opt == 'setsave'){

    $uniacid = $_W['uniacid'];
    $pid = $_GPC['key_id'];
    $is = pdo_fetch("SELECT id FROM ".tablename('sudu8_page_diypageset')." WHERE `uniacid` = {$uniacid} and `pid` = {$pid}");

    $go_home = $_GPC['go_home'];
    $kp = $_GPC['kp'];
    $kp_is = $_GPC['kp_is'];
    $kp_m = $_GPC['kp_m'];
    $kp_url = $_GPC['kp_url'];
    $kp_urltype = $_GPC['kp_urltype'];
    $tc_is = $_GPC['tc_is'];
    $tc = $_GPC['tc'];
    $tc_url = $_GPC['tc_url'];
    $tc_urltype = $_GPC['tc_urltype'];
    $foot_is = $_GPC['foot_is'];
    $bg_music = $_GPC['bg_music'];
    pdo_update("sudu8_page_base", array("diy_bg_music" => $bg_music), array('uniacid' => $uniacid));
    $data = array(
        "pid"=>$pid,
        "go_home"=>$go_home,
        "kp"=>$kp,
        "kp_is"=>(int)$kp_is,
        "kp_m"=>(int)$kp_m,
        "kp_url"=>$kp_url,
        "kp_urltype"=>$kp_urltype,
        "tc_is"=>$tc_is,
        "tc"=>$tc,
        "tc_url"=>$tc_url,
        "tc_urltype"=>$tc_urltype,
        "foot_is"=>$foot_is
        );
    if($is){
        $res = pdo_update("sudu8_page_diypageset",$data,['uniacid' => $uniacid,'pid' => $pid]);
    }else{
        $data['uniacid'] = $uniacid;
        $res = pdo_insert("sudu8_page_diypageset",$data);
    }
    
    if($res || $res1){
        echo 1;
    }else{
        echo 2;
    }

}