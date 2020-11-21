<?php
require '../Mao/common.php';
if($islogin == 1){}else exit("<script language='javascript'>window.location.href='/Mao_admin/login.php';</script>");
$mod = isset($_REQUEST['mod']) ? $_REQUEST['mod'] :0;
if($mod){
    if($mod == "index_dd_list"){
        $sql=" M_id='{$mao['id']}'";
        $numrows=$DB->count("SELECT count(*) from mao_dindan WHERE {$sql} ");
        $pagesize=10;
        $pages=intval($numrows/$pagesize);
        if($numrows%$pagesize){
            $pages++;
        }
        if(isset($_REQUEST['page'])){
            $page=intval($_REQUEST['page']);
        }else{
            $page=1;
        }
        $offset=$pagesize*($page - 1);
        $rs=$DB->query("SELECT * FROM mao_dindan WHERE {$sql} order by id desc limit $offset,$pagesize");
        $data = array();
        while($res = $DB->fetch($rs)){
            if($res['zt'] == 0){
                $zt = '<span style="color: #ff0000;">待发货</span>';
            }elseif($res['zt'] == 1){
                $zt = '<span style="color: #ff0000;">未付款</span>';
            }elseif($res['zt'] == 2){
                $zt = '<span style="color: #5FB878;">已处理</span>';
            }elseif($res['zt'] == 3){
                $zt = '<span style="color: #ff0000;">订单异常</span>';
            }else{
                $zt = '<span style="color: #ff0000;">未知状态</span>';
            }
            $data[]=array(
                'id'=>$res['id'],
                'ddh'=>$res['ddh'],
                'name'=>$res['name'],
                'sl'=>$res['sl'],
                'price'=>'<span style="color: #ff6f00;">'.$res['price'].'</span>',
                'time'=>$res['time'],
                'zt'=>$zt
            );
        }
        $first=1;
        $prev=$page-1;
        $next=$page+1;
        $last=$pages;
        if ($page>1){
            $code = $prev.$link;
        } else {
            $code = -1;
        }
        for ($i=1;$i<$page;$i++)
            $i.$link.$i;
        $page;
        for ($i=$page+1;$i<=$pages;$i++)
            $i.$link.$i;
        if ($page<$pages){
            $code_s = $next.$link;
        } else {
            $code_s = -1;
        }
        $result=array("code"=>0,"msg"=>"列表","count"=>$numrows,"data"=>$data);
        exit(json_encode($result));
    }//首页最新订单
    elseif($mod == "set"){
        $title = daddslashes($_POST['title']);
        $qq = daddslashes($_POST['qq']);
        $wx = daddslashes($_POST['wx']);
        $sj = daddslashes($_POST['sj']);
        $gd = daddslashes($_POST['gd']);
        $ym_id = daddslashes($_POST['ym_id']);
        $pass = daddslashes($_POST['pass']);
        if($title == "" || $qq == "" || $wx == "" || $sj == "" || $gd == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif(!preg_match("/^1[34578]{1}\d{9}$/",$sj)){
            $result=array("code"=>-2,"msg"=>"手机号不合法！");
        }else{
            if($pass != "" || $pass != null){
                if(mb_strlen($pass,'UTF8') < 6 || mb_strlen($pass,'UTF8') > 15){
                    $result=array("code"=>-2,"msg"=>"密码只能是6-15位的字母和数字！");
                }elseif(preg_match("/[\x7f-\xff]/", $pass)){
                    $result=array("code"=>-3,"msg"=>"密码不能带有中文！");
                }else{
                    $DB->query("update mao_data set title='{$title}',qq='{$qq}',wx='{$wx}',qq='{$qq}',sj='{$sj}',gd_gg='{$gd}',pass='{$pass}',ym_id='{$ym_id}' where id='{$mao['id']}'");
                    $result=array("code"=>1,"msg"=>"修改成功！");
                }
            }else{
                $DB->query("update mao_data set title='{$title}',qq='{$qq}',wx='{$wx}',qq='{$qq}',sj='{$sj}',gd_gg='{$gd}',ym_id='{$ym_id}' where id='{$mao['id']}'");
                $result=array("code"=>0,"msg"=>"修改成功！");
            }
        }
        exit(json_encode($result));
    }//修改系统信息
    elseif($mod == "dx"){
        $type = daddslashes($_POST['type']);
        if($type == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif($type < 1 || $type > 4){
            $result=array("code"=>-2,"msg"=>"非法操作已记录！");
        }elseif($mao['sj'] == "" || $mao['sj'] == null){
            $result=array("code"=>-3,"msg"=>"请先设置站长手机号！");
        }else{
            if($type == 1){
                if($mao['dx_1'] == 1){//开启
                    $DB->query("update mao_data set dx_1='0' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已开启！");
                }elseif($mao['dx_1'] == 0){//关闭
                    $DB->query("update mao_data set dx_1='1' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已关闭！");
                }else{
                    $result=array("code"=>-2,"msg"=>"非法操作已记录！");
                }
            }elseif($type == 2){
                if($mao['dx_2'] == 1){//开启
                    $DB->query("update mao_data set dx_2='0' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已开启！");
                }elseif($mao['dx_2'] == 0){//关闭
                    $DB->query("update mao_data set dx_2='1' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已关闭！");
                }else{
                    $result=array("code"=>-2,"msg"=>"非法操作已记录！");
                }
            }elseif($type == 3){
                if($mao['dx_3'] == 1){//开启
                    $DB->query("update mao_data set dx_3='0' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已开启！");
                }elseif($mao['dx_3'] == 0){//关闭
                    $DB->query("update mao_data set dx_3='1' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已关闭！");
                }else{
                    $result=array("code"=>-2,"msg"=>"非法操作已记录！");
                }
            }elseif($type == 4){
                if($mao['dx_4'] == 1){//开启
                    $DB->query("update mao_data set dx_4='0' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已开启！");
                }elseif($mao['dx_4'] == 0){//关闭
                    $DB->query("update mao_data set dx_4='1' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已关闭！");
                }else{
                    $result=array("code"=>-2,"msg"=>"非法操作已记录！");
                }
            }else{
                $result=array("code"=>-2,"msg"=>"非法操作已记录！");
            }
        }
        exit(json_encode($result));
    }//短信功能开关
    elseif($mod == "yzf"){
        $type = daddslashes($_POST['type']);

        $yzf_id = daddslashes($_POST['yzf_id']);
        $yzf_key = daddslashes($_POST['yzf_key']);
        $yzf_url = daddslashes($_POST['yzf_url']);

        $mzf_id = daddslashes($_POST['mzf_id']);
        $mzf_key = daddslashes($_POST['mzf_key']);

        $tx_zh = daddslashes($_POST['tx_zh']);
        $tx_sm = daddslashes($_POST['tx_sm']);
        if($type == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif($type < 0 || $type > 2){
            $result=array("code"=>-2,"msg"=>"非法操作已记录！");
        }else{
            if($type == 0){//自定义
                if($yzf_id == "" || $yzf_key == "" || $yzf_url == ""){
                    $result=array("code"=>-1,"msg"=>"参数不完整！");
                }else{
                    $DB->query("update mao_data set yzf_type='{$type}',yzf_id='{$yzf_id}',yzf_key='{$yzf_key}',yzf_url='{$yzf_url}' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"修改成功！");
                }
            }elseif($type == 1){//系统支付
                if($tx_zh == "" || $tx_sm == ""){
                    $result=array("code"=>-1,"msg"=>"参数不完整！");
                }else{
                    $DB->query("update mao_data set yzf_type='{$type}',tx_zh='{$tx_zh}',tx_sm='{$tx_sm}' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"修改成功！");
                }
            }elseif($type == 2){//码支付
                if($mzf_id == "" || $mzf_key == ""){
                    $result=array("code"=>-1,"msg"=>"参数不完整！");
                }else{
                    $DB->query("update mao_data set yzf_type='{$type}',mzf_id='{$mzf_id}',mzf_key='{$mzf_key}' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"修改成功！");
                }
            }else{
                $result=array("code"=>-2,"msg"=>"非法操作已记录！");
            }
        }
        exit(json_encode($result));
    }//支付接口配置
    elseif($mod == "zf_zt"){
        $type = daddslashes($_POST['type']);
        if($type == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }else{
            if($type == 1){//支付宝
                if($mao['zfb_zf'] == 0){
                    $DB->query("update mao_data set zfb_zf='1' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已关闭！");
                }elseif($mao['zfb_zf'] == 1){
                    $DB->query("update mao_data set zfb_zf='0' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已开启！");
                }else{
                    $result=array("code"=>-2,"msg"=>"非法操作已记录！");
                }
            }elseif($type == 2){//QQ
                if($mao['qq_zf'] == 0){
                    $DB->query("update mao_data set qq_zf='1' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已关闭！");
                }elseif($mao['qq_zf'] == 1){
                    $DB->query("update mao_data set qq_zf='0' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已开启！");
                }else{
                    $result=array("code"=>-2,"msg"=>"非法操作已记录！");
                }
            }elseif($type == 3){//微信
                if($mao['wx_zf'] == 0){
                    $DB->query("update mao_data set wx_zf='1' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已关闭！");
                }elseif($mao['wx_zf'] == 1){
                    $DB->query("update mao_data set wx_zf='0' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"已开启！");
                }else{
                    $result=array("code"=>-2,"msg"=>"非法操作已记录！");
                }
            }else{
                $result=array("code"=>-2,"msg"=>"非法操作已记录！");
            }
        }
        exit(json_encode($result));
    }//支付开关
    elseif($mod == "add_commodity"){
        $name = daddslashes($_POST['name']);//名称
        $img_url = daddslashes($_POST['img_url']);//图片
        $type = daddslashes($_POST['type']);//分类
        $tj = daddslashes($_POST['tj']);//推荐
        $slxd = daddslashes($_POST['slxd']);//数量下单
        $rwzl = daddslashes($_POST['rwzl']);//入网资料
        $price = daddslashes($_POST['price']);//价格
        $yf_price = daddslashes($_POST['yf_price']);//运费
        $youhui_zhang = daddslashes($_POST['youhui_zhang']);
        $youhui_price = daddslashes($_POST['youhui_price']);
        $kucun = daddslashes($_POST['kucun']);//库存
        $xiaoliang = daddslashes($_POST['xiaoliang']);//销量
        $dqpb = daddslashes($_POST['dqpb']);//禁止地区下单
        $spsm = daddslashes($_POST['spsm']);//说明
        if($name == "" || $img_url == "" || $type == "" || $tj == "" || $slxd == "" || $rwzl == "" || $price == "" || $yf_price == "" || $youhui_zhang == "" || $youhui_price == "" || $kucun == "" || $xiaoliang == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif($type < 1 || $type > 3){
            $result=array("code"=>-2,"msg"=>"错误的商品分类！");
        }elseif($tj < 0 || $tj > 1 || $slxd < 0 || $slxd > 1 || $rwzl < 0 || $rwzl > 1){
            $result=array("code"=>-3,"msg"=>"非法操作已记录！");
        }elseif($price < 0 || $yf_price < 0 || $youhui_price < 0){
            $result=array("code"=>-4,"msg"=>"价格不能低于0元！");
        }elseif($youhui_zhang < 0){
            $result=array("code"=>-5,"msg"=>"优惠购买不能低于0张！");
        }elseif($kucun < 0 || $xiaoliang < 0){
            $result=array("code"=>-6,"msg"=>"库存或销量不能低于0！");
        }else{
            $DB->query("insert into `mao_shop` (`M_id`,`name`,`img`,`type`,`tj`,`price`,`yf_price`,`youhui_zhang`,`youhui_price`,`kucun`,`xiaoliang`,`xq`,`slxd_zt`,`rwzl_zt`,`dqpb`,`zt`) values ('{$mao['id']}','{$name}','{$img_url}','{$type}','{$tj}','{$price}','{$yf_price}','{$youhui_zhang}','{$youhui_price}','{$kucun}','{$xiaoliang}','{$spsm}','{$slxd}','{$rwzl}','{$dqpb}','0')");
            $result=array("code"=>0,"msg"=>"添加成功！");
        }
        exit(json_encode($result));
    }//添加商品
    elseif($mod == "set_commodity"){
        $id = daddslashes($_POST['id']);
        $name = daddslashes($_POST['name']);
        $img_url = daddslashes($_POST['img_url']);
        $type = daddslashes($_POST['type']);
        $youhui_zhang = daddslashes($_POST['youhui_zhang']);
        $youhui_price = daddslashes($_POST['youhui_price']);
        $dqpb = daddslashes($_POST['dqpb']);
        $spsm = daddslashes($_POST['spsm']);
        $cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$id}' limit 1");
        if($id == "" || $name == "" || $img_url == "" || $type == "" || $youhui_price == "" || $youhui_zhang == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif(!$cha_1){
            $result=array("code"=>-2,"msg"=>"商品不存在！");
        }elseif($type < 1 || $type > 3){
            $result=array("code"=>-3,"msg"=>"错误的商品分类！");
        }elseif($youhui_zhang < 0){
            $result=array("code"=>-4,"msg"=>"不能低于0张！");
        }elseif($youhui_price < 0){
            $result=array("code"=>-4,"msg"=>"不能低于0元！");
        }else{
            $DB->query("update mao_shop set name='{$name}',img='{$img_url}',type='{$type}',youhui_zhang='{$youhui_zhang}',youhui_price='{$youhui_price}',dqpb='{$dqpb}',xq='{$spsm}' where id='{$cha_1['id']}'");
            $result=array("code"=>0,"msg"=>"修改成功！");
        }
        exit(json_encode($result));
    }//修改商品
    elseif($mod == "list_commodity"){
        $sql=" M_id='{$mao['id']}'";
        $numrows=$DB->count("SELECT count(*) from mao_shop WHERE {$sql} ");
        $pagesize=10;
        $pages=intval($numrows/$pagesize);
        if($numrows%$pagesize){
            $pages++;
        }
        if(isset($_REQUEST['page'])){
            $page=intval($_REQUEST['page']);
        }else{
            $page=1;
        }
        $offset=$pagesize*($page - 1);
        $rs=$DB->query("SELECT * FROM mao_shop WHERE {$sql} order by id desc limit $offset,$pagesize");
        $data = array();
        while($res = $DB->fetch($rs)){
            if($res['type'] == 1){
                $type = '<span style="color: #01AAED;">中国电信</span>';
            }elseif($res['type'] == 2){
                $type = '<span style="color: #01AAED;">中国移动</span>';
            }elseif($res['type'] == 3){
                $type = '<span style="color: #01AAED;">中国联通</span>';
            }else{
                $type = '<span style="color: #ff0000;">未知</span>';
            }
            if($res['tj'] == 0){
                $tj = 'checked=""';
            }else{
                $tj = '';
            }
            if($res['slxd_zt'] == 0){
                $slxd_zt = 'checked=""';
            }else{
                $slxd_zt = '';
            }
            if($res['rwzl_zt'] == 0){
                $rwzl_zt = 'checked=""';
            }else{
                $rwzl_zt = '';
            }
            if($res['zt'] == 0){
                $shangjia = 'checked=""';
            }else{
                $shangjia = '';
            }

            $data[]=array(
                'id'=>$res['id'],
                'name'=>$res['name'],
                'img'=>'<img src="'.$res['img'].'">',
                'type'=>$type,
                'tj'=>'<input type="checkbox" '.$tj.' name="open" lay-skin="switch" lay-filter="tj" lay-text="是|否" value="'.$res['id'].'">',
                'price'=>'<span style="color: #FF5722;">'.$res['price'].'</span>',
                'yf_price'=>'<span style="color: #FF5722;">'.$res['yf_price'].'</span>',
                'kucun'=>'<span style="color: #ff0000;">'.$res['kucun'].'</span>',
                'xiaoliang'=>'<span style="color: #ff0000;">'.$res['xiaoliang'].'</span>',
                'slxd'=>'<input type="checkbox" '.$slxd_zt.' name="open" lay-skin="switch" lay-filter="slxd" lay-text="开启|关闭" value="'.$res['id'].'">',
                'rwzl'=>'<input type="checkbox" '.$rwzl_zt.' name="open" lay-skin="switch" lay-filter="rwzl" lay-text="开启|关闭" value="'.$res['id'].'">',
                'shangjia'=>'<input type="checkbox" '.$shangjia.' name="open" lay-skin="switch" lay-filter="shangjia" lay-text="上架|下架" value="'.$res['id'].'">',
                'set'=>'<a lay-href="Mao_commodity/set.php?id='.$res['id'].'" class="layui-btn layui-btn-primary layui-btn-xs">编辑</a><a lay-event="del" class="layui-btn layui-btn-primary layui-btn-xs">删除</a>'
            );
        }
        $first=1;
        $prev=$page-1;
        $next=$page+1;
        $last=$pages;
        if ($page>1){
            $code = $prev.$link;
        } else {
            $code = -1;
        }
        for ($i=1;$i<$page;$i++)
            $i.$link.$i;
        $page;
        for ($i=$page+1;$i<=$pages;$i++)
            $i.$link.$i;
        if ($page<$pages){
            $code_s = $next.$link;
        } else {
            $code_s = -1;
        }
        $result=array("code"=>0,"msg"=>"列表","count"=>$numrows,"data"=>$data);
        exit(json_encode($result));
    }//商品列表
    elseif($mod == "tj_commodity"){
        $id = daddslashes($_POST['id']);
        $cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$id}' limit 1");
        if(!$cha_1){
            $result=array("code"=>-1,"msg"=>"商品不存在！");
        }else{
            if($cha_1['tj'] == 0){
                $DB->query("update mao_shop set tj='1' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"已取消！");
            }elseif($cha_1['tj'] == 1){
                $DB->query("update mao_shop set tj='0' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"已推荐！");
            }else{
                $result=array("code"=>-2,"msg"=>"非法操作已记录！");
            }
        }
        exit(json_encode($result));
    }//商品推荐
    elseif($mod == "slxd_commodity"){
        $id = daddslashes($_POST['id']);
        $cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$id}' limit 1");
        if(!$cha_1){
            $result=array("code"=>-1,"msg"=>"商品不存在！");
        }else{
            if($cha_1['slxd_zt'] == 0){
                $DB->query("update mao_shop set slxd_zt='1' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"已取消！");
            }elseif($cha_1['slxd_zt'] == 1){
                $DB->query("update mao_shop set slxd_zt='0' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"已开启！");
            }else{
                $result=array("code"=>-2,"msg"=>"非法操作已记录！");
            }
        }
        exit(json_encode($result));
    }//数量下单
    elseif($mod == "rwzl_commodity"){
        $id = daddslashes($_POST['id']);
        $cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$id}' limit 1");
        if(!$cha_1){
            $result=array("code"=>-1,"msg"=>"商品不存在！");
        }else{
            if($cha_1['rwzl_zt'] == 0){
                $DB->query("update mao_shop set rwzl_zt='1' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"已取消！");
            }elseif($cha_1['rwzl_zt'] == 1){
                $DB->query("update mao_shop set rwzl_zt='0' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"已开启！");
            }else{
                $result=array("code"=>-2,"msg"=>"非法操作已记录！");
            }
        }
        exit(json_encode($result));
    }//入网资料
    elseif($mod == "shangjia_commodity"){
        $id = daddslashes($_POST['id']);
        $cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$id}' limit 1");
        if(!$cha_1){
            $result=array("code"=>-1,"msg"=>"商品不存在！");
        }else{
            if($cha_1['zt'] == 0){
                $DB->query("update mao_shop set zt='1' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"已下架！");
            }elseif($cha_1['zt'] == 1){
                $DB->query("update mao_shop set zt='0' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"已上架！");
            }else{
                $result=array("code"=>-2,"msg"=>"非法操作已记录！");
            }
        }
        exit(json_encode($result));
    }//上架/下架
    elseif($mod == "del_commodity"){
        $id = daddslashes($_POST['id']);
        $cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$id}' limit 1");
        if(!$cha_1){
            $result=array("code"=>-1,"msg"=>"商品不存在！");
        }else{
            $DB->query("DELETE FROM mao_shop WHERE M_id='{$mao['id']}' and id='{$cha_1['id']}'");
            $result=array("code"=>0,"msg"=>"删除成功！");
        }
        exit(json_encode($result));
    }//删除商品
    elseif($mod == "xiugai_commodity"){
        $id = daddslashes($_POST['id']);
        $type = daddslashes($_POST['type']);
        $value = daddslashes($_POST['value']);
        $cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$id}' limit 1");
        if($id == "" || $type == "" || $value == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif(!$cha_1){
            $result=array("code"=>-2,"msg"=>"商品不存在！");
        }else{
            if($type == "price"){
                if($value < 0){
                    $result=array("code"=>-3,"msg"=>"商品价格不能低于0元！");
                }else{
                    $DB->query("update mao_shop set price='{$value}' where id='{$cha_1['id']}'");
                    $result=array("code"=>0,"msg"=>"商品价格修改为：{$value}元！");
                }
            }elseif($type == "yf_price"){
                if($value < 0){
                    $result=array("code"=>-3,"msg"=>"商品运费不能低于0元！");
                }else{
                    $DB->query("update mao_shop set yf_price='{$value}' where id='{$cha_1['id']}'");
                    $result=array("code"=>0,"msg"=>"商品运费修改为：{$value}元！");
                }
            }elseif($type == "kucun"){
                if($value < 0){
                    $result=array("code"=>-3,"msg"=>"商品库存不能低于0件！");
                }else{
                    $DB->query("update mao_shop set kucun='{$value}' where id='{$cha_1['id']}'");
                    $result=array("code"=>0,"msg"=>"商品库存修改为：{$value}件！");
                }
            }elseif($type == "xiaoliang"){
                if($value < 0){
                    $result=array("code"=>-3,"msg"=>"商品销量不能低于0件！");
                }else{
                    $DB->query("update mao_shop set xiaoliang='{$value}' where id='{$cha_1['id']}'");
                    $result=array("code"=>0,"msg"=>"商品销量修改为：{$value}件！");
                }
            }else{
                $result=array("code"=>-4,"msg"=>"非法操作已记录！");
            }
        }
        exit(json_encode($result));
    }//商品列表修改
    elseif($mod == "list_surbey"){
        $sql=" M_id='{$mao['id']}'";
        $numrows=$DB->count("SELECT count(*) from mao_gd WHERE {$sql} ");
        $pagesize=10;
        $pages=intval($numrows/$pagesize);
        if($numrows%$pagesize){
            $pages++;
        }
        if(isset($_REQUEST['page'])){
            $page=intval($_REQUEST['page']);
        }else{
            $page=1;
        }
        $offset=$pagesize*($page - 1);
        $rs=$DB->query("SELECT * FROM mao_gd WHERE {$sql} order by id desc limit $offset,$pagesize");
        $data = array();
        while($res = $DB->fetch($rs)){
            if($res['type'] == 1){
                $type = '<span style="color: #01AAED;">不能上网</span>';
            }elseif($res['type'] == 2){
                $type = '<span style="color: #01AAED;">其他问题</span>';
            }else{
                $type = '<span style="color: #ff0000;">未知</span>';
            }
            if($res['zt'] == 0){
                $zt = '<span style="color: #5FB878;">已处理</span>';
            }elseif($res['zt'] == 1){
                $zt = '<span style="color: #ff0000;">未处理</span>';
            }else{
                $zt = '<span style="color: #ff0000;">未知</span>';
            }

            $data[]=array(
                'id'=>$res['id'],
                'ddh'=>$res['ddh'],
                'type'=>$type,
                'kh'=>$res['kh'],
                'time'=>$res['time'],
                'zt'=>$zt,
                'set'=>'<a lay-href="Mao_survey/set.php?id='.$res['id'].'" class="layui-btn layui-btn-primary layui-btn-xs">操作</a><a lay-event="del" class="layui-btn layui-btn-primary layui-btn-xs">删除</a>'
            );
        }
        $first=1;
        $prev=$page-1;
        $next=$page+1;
        $last=$pages;
        if ($page>1){
            $code = $prev.$link;
        } else {
            $code = -1;
        }
        for ($i=1;$i<$page;$i++)
            $i.$link.$i;
        $page;
        for ($i=$page+1;$i<=$pages;$i++)
            $i.$link.$i;
        if ($page<$pages){
            $code_s = $next.$link;
        } else {
            $code_s = -1;
        }
        $result=array("code"=>0,"msg"=>"列表","count"=>$numrows,"data"=>$data);
        exit(json_encode($result));
    }//工单列表
    elseif($mod == "del_survey"){
        $id = daddslashes($_POST['id']);
        $cha_1 = $DB->get_row("select * from mao_gd where M_id='{$mao['id']}' and id='{$id}' limit 1");
        if(!$cha_1){
            $result=array("code"=>-1,"msg"=>"工单不存在！");
        }else{
            $DB->query("DELETE FROM mao_gd WHERE M_id='{$mao['id']}' and id='{$cha_1['id']}'");
            $result=array("code"=>0,"msg"=>"删除成功！");
        }
        exit(json_encode($result));
    }//删除工单
    elseif($mod == "set_survey"){
        $id = daddslashes($_POST['id']);
        $value = daddslashes($_POST['value']);
        $cha_1 = $DB->get_row("select * from mao_gd where M_id='{$mao['id']}' and id='{$id}' limit 1");
        if($id == "" || $value == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif(!$cha_1){
            $result=array("code"=>-2,"msg"=>"工单不存在！");
        }else{
            if($mao['dx_4'] == 0){
                $js_1 = ($mao['price'] - 0.01);
                if($mao['price'] >= 0.01 || $mao['sj'] != "" || $mao['sj'] != null){
                    $msg = dx("{$cha_1['users']}","5");
                    if($msg == "0"){
                        $DB->query("update mao_data set price='{$js_1}' where id='{$mao['id']}'");
                    }
                }
            }

            $DB->query("update mao_gd set msg='{$value}',zt='0' where id='{$cha_1['id']}'");
            $result=array("code"=>0,"msg"=>"操作成功！");
        }
        exit(json_encode($result));
    }//操作工单
    elseif($mod == "list_dindan"){
        $ddh = daddslashes($_POST['ddh']);
        if($ddh != "" || $ddh != null){
			if($mao['id'] == 1){
				$sql="ddh='{$ddh}'";
			}else{
				$sql="M_id='{$mao['id']}' and ddh='{$ddh}'";
			}
        }else{
			if($mao['id'] == 1){
				$sql="1";
			}else{
				$sql="M_id='{$mao['id']}'";
			}
        }
        $numrows=$DB->count("SELECT count(*) from mao_dindan WHERE {$sql} ");
        $pagesize=10;
        $pages=intval($numrows/$pagesize);
        if($numrows%$pagesize){
            $pages++;
        }
        if(isset($_REQUEST['page'])){
            $page=intval($_REQUEST['page']);
        }else{
            $page=1;
        }
        $offset=$pagesize*($page - 1);
        $rs=$DB->query("SELECT * FROM mao_dindan WHERE {$sql} order by id desc limit $offset,$pagesize");
        $data = array();
        while($res = $DB->fetch($rs)){
            if($res['zt'] == 0){
                $zt = '<span style="color: #FF5722;">未发货</span>';
                $href = 'lay-href="Mao_Order/set.php?id='.$res['id'].'"';
            }elseif($res['zt'] == 1){
                $zt = '<span style="color: #ff0000;">未付款</span>';
                $href = '';
            }elseif($res['zt'] == 2){
                $zt = '<span style="color: #5FB878;">已发货</span>';
                $href = 'lay-href="Mao_Order/set.php?id='.$res['id'].'"';
            }elseif($res['zt'] == 3){
                $zt = '<span style="color: #ff0000;">异常</span>';
                $href = 'lay-href="Mao_Order/set.php?id='.$res['id'].'"';
            }else{
                $zt = '<span style="color: #ff0000;">未知</span>';
                $href = '';
            }

            $data[]=array(
                'id'=>$res['id'],
				'mid'=>$res['M_id'],
                'ddh'=>$res['ddh'],
                'name'=>$res['name'],
                'sl'=>'<span style="color: #01AAED;">'.$res['sl'].'</span>',
                'dj_price'=>'<span style="color: #FF5722;">'.$res['dj_price'].'</span>',
                'yf_price'=>'<span style="color: #FF5722;">'.$res['yf_price'].'</span>',
                'price'=>'<span style="color: #ff0000;">'.$res['price'].'</span>',
                'time'=>$res['time'],
                'zt'=>$zt,
                'set'=>'<a '.$href.' class="layui-btn layui-btn-primary layui-btn-xs">操作</a><a lay-event="del" class="layui-btn layui-btn-primary layui-btn-xs">删除</a>'
            );
        }
        $first=1;
        $prev=$page-1;
        $next=$page+1;
        $last=$pages;
        if ($page>1){
            $code = $prev.$link;
        } else {
            $code = -1;
        }
        for ($i=1;$i<$page;$i++)
            $i.$link.$i;
        $page;
        for ($i=$page+1;$i<=$pages;$i++)
            $i.$link.$i;
        if ($page<$pages){
            $code_s = $next.$link;
        } else {
            $code_s = -1;
        }
        $result=array("code"=>0,"msg"=>"列表","count"=>$numrows,"data"=>$data);
        exit(json_encode($result));
    }//订单列表
    elseif($mod == "del_dindan"){
        $id = daddslashes($_POST['id']);
        $cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and id='{$id}' limit 1");
        if(!$cha_1){
            $result=array("code"=>-1,"msg"=>"订单不存在！");
        }else{
            $DB->query("DELETE FROM mao_dindan WHERE M_id='{$mao['id']}' and id='{$cha_1['id']}'");
            $result=array("code"=>0,"msg"=>"删除成功！");
        }
        exit(json_encode($result));
    }//删除订单
    elseif($mod == "set_dindan"){
        $id = daddslashes($_POST['id']);
        $type = daddslashes($_POST['type']);
        $kdgs = daddslashes($_POST['kdgs']);
        $ydh = daddslashes($_POST['ydh']);
        $msgs = daddslashes($_POST['msg']);
        $cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and (id='{$id}' && zt!='1') limit 1");
        if(!$cha_1){
            $result=array("code"=>-1,"msg"=>"订单不存在！");
        }else{
            if($type == 2){
                if($kdgs == "" || $ydh == ""){
                    $result=array("code"=>-2,"msg"=>"快递公司或运单号不能为空！");
                }else{
                    $DB->query("update mao_dindan set kdgs='{$kdgs}',ydh='{$ydh}',zt='2' where id='{$cha_1['id']}'");
                    $result=array("code"=>0,"msg"=>"操作成功！");
                    if($mao['dx_2'] == 0){
                        $js_1 = ($mao['price'] - 0.01);
                        if($mao['price'] >= 0.01 || $mao['sj'] != "" || $mao['sj'] != null){
                            $msg = dx("{$cha_1['sjh']}","2","","{$cha_1['xm']}","{$kdgs}","{$ydh}");
                            if($msg == "0"){
                                $DB->query("update mao_data set price='{$js_1}' where id='{$mao['id']}'");
                            }
                        }
                    }
                }
            }elseif($type == 3){
                if($msgs == ""){
                    $result=array("code"=>-2,"msg"=>"返回内容不能为空！");
                }else{
                    $DB->query("update mao_dindan set msg='{$msgs}',zt='3' where id='{$cha_1['id']}'");
                    $result=array("code"=>0,"msg"=>"操作成功！");
                }
            }else{
                $result=array("code"=>-3,"msg"=>"非法操作已记录！");
            }
        }
        exit(json_encode($result));
    }//操作订单
    elseif($mod == "list_sub"){
        if($mao['id'] == 1){
            $sql="1";
        }else{
            $sql="Z_id='{$mao['id']}'";
        }
        $numrows=$DB->count("SELECT count(*) from mao_data WHERE {$sql} ");
        $pagesize=10;
        $pages=intval($numrows/$pagesize);
        if($numrows%$pagesize){
            $pages++;
        }
        if(isset($_REQUEST['page'])){
            $page=intval($_REQUEST['page']);
        }else{
            $page=1;
        }
        $offset=$pagesize*($page - 1);
        $rs=$DB->query("SELECT * FROM mao_data WHERE {$sql} order by id desc limit $offset,$pagesize");
        $data = array();
        while($res = $DB->fetch($rs)){

            $data[]=array(
                'id'=>$res['id'],
                'title'=>$res['title'],
                'user'=>$res['user'],
                'url'=>'<span style="color: #01AAED;">'.$res['url'].'</span>',
                'price'=>'<span style="color: #ff0000;">'.$res['price'].'</span>',
                'time'=>$res['time'],
                'set'=>'<a onclick="jk('.$res['id'].')" class="layui-btn layui-btn-primary layui-btn-xs">加款</a><a onclick="xf('.$res['id'].')" class="layui-btn layui-btn-primary layui-btn-xs">续费</a>'
            );
        }
        $first=1;
        $prev=$page-1;
        $next=$page+1;
        $last=$pages;
        if ($page>1){
            $code = $prev.$link;
        } else {
            $code = -1;
        }
        for ($i=1;$i<$page;$i++)
            $i.$link.$i;
        $page;
        for ($i=$page+1;$i<=$pages;$i++)
            $i.$link.$i;
        if ($page<$pages){
            $code_s = $next.$link;
        } else {
            $code_s = -1;
        }
        $result=array("code"=>0,"msg"=>"列表","count"=>$numrows,"data"=>$data);
        exit(json_encode($result));
    }//分站列表
    elseif($mod == "jiakuan_sub"){
        $id = daddslashes($_POST['id']);
        $price = daddslashes($_POST['price']);
        $cha_1 = $DB->get_row("select * from mao_data where id='{$id}' and Z_id='{$mao['id']}' limit 1");
        if($id == "" || $price == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif(!$cha_1){
            $result=array("code"=>-2,"msg"=>"分站不存在！");
        }elseif($price <= 0){
            $result=array("code"=>-3,"msg"=>"不得低于0元！");
        }else{
            if($mao['id'] == 1){
                $js_1 = ($cha_1['price'] + $price);
                $DB->query("update mao_data set price='{$js_1}' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"加款成功！");
            }else{
                if($mao['price'] < $price){
                    $result=array("code"=>-4,"msg"=>"当前后台余额不足以加款{$price}元！");
                }else{
                    $js_1 = ($mao['price'] - $price);
                    $js_2 = ($cha_1['price'] + $price);
                    $DB->query("update mao_data set price='{$js_2}' where id='{$cha_1['id']}'");
                    $DB->query("update mao_data set price='{$js_1}' where id='{$mao['id']}'");
                    $result=array("code"=>0,"msg"=>"加款成功,当前后台扣除{$price}元！");
                }
            }
        }
        exit(json_encode($result));
    }//分站加款
    elseif($mod == "xufei_sub"){
        $id = daddslashes($_POST['id']);
        $xf = daddslashes($_POST['time']);
        $cha_1 = $DB->get_row("select * from mao_data where id='{$id}' and Z_id='{$mao['id']}' limit 1");
        if($id == "" || $xf == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif(!$cha_1){
            $result=array("code"=>-2,"msg"=>"分站不存在！");
        }elseif($xf < 1){
            $result=array("code"=>-3,"msg"=>"不得低于0元！");
        }else{
            if($mao['id'] == 1){
                if($cha_1['time'] < $time){
                    $js_1 = date("Y-m-d", strtotime("+{$xf} months", strtotime($time)));
                }else{
                    $js_1 = date("Y-m-d", strtotime("+{$xf} months", strtotime($cha_1['time'])));
                }
                $DB->query("update mao_data set time='{$js_1}' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"续费成功！");
            }else{
                $js_1 = ($xf * 10);
                if($mao['price'] < $js_1){
                    $result=array("code"=>-4,"msg"=>"当前后台余额不足续费！");
                }else{
                    $js_2 = ($mao['price'] - $js_1);
                    if($cha_1['time'] < $time){
                        $js_3 = date("Y-m-d", strtotime("+{$xf} months", strtotime($time)));
                    }else{
                        $js_3 = date("Y-m-d", strtotime("+{$xf} months", strtotime($cha_1['time'])));
                    }

                    $DB->query("update mao_data set time='{$js_3}' where id='{$cha_1['id']}'");
                    $DB->query("update mao_data set price='{$js_2}' where id='{$mao['id']}'");

                    $result=array("code"=>0,"msg"=>"续费成功,当前后台扣除{$js_1}元！");
                }
            }
        }
        exit(json_encode($result));
    }//分站续期
    elseif($mod == "add_sub"){
        $title = daddslashes($_POST['title']);
        $user = daddslashes($_POST['user']);
        $pass = daddslashes($_POST['pass']);
        $qz = daddslashes($_POST['qz']);
        $type = daddslashes($_POST['type']);
        if($type == 1){
            $hz = $houzhui;
        }

        $ym = $qz.".".$hz;
        $cha_1 = $DB->get_row("select * from mao_data where user='{$user}' limit 1");
        $cha_2 = $DB->get_row("select * from mao_data where url='{$ym}' limit 1");

        if($title == "" || $user == "" || $pass == "" || $qz == "" || $type == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif(mb_strlen($user,'UTF8') < 6 || mb_strlen($user,'UTF8') > 15){
            $result=array("code"=>-2,"msg"=>"用户名只能是6-15位字符");
        }elseif(mb_strlen($pass,'UTF8') < 6 || mb_strlen($pass,'UTF8') > 15){
            $result=array("code"=>-2,"msg"=>"密码只能是6-15位字符！");
        }elseif(preg_match("/[\x7f-\xff]/", $user) || preg_match("/[\x7f-\xff]/", $pass)){
            $result=array("code"=>-3,"msg"=>"用户名或密码不能带有中文！");
        }elseif(preg_match("/[\x7f-\xff]/", $qz)){
            $result=array("code"=>-3,"msg"=>"域名不能带有中文！");
        }elseif($cha_1){
            $result=array("code"=>-4,"msg"=>"请换一个用户名！");
        }elseif($cha_2){
            $result=array("code"=>-5,"msg"=>"请换一个域名！");
        }elseif($mao['price'] < 10){
            $result=array("code"=>-6,"msg"=>"后台余额不足元,无法开通分站！");
        }else{
            if($mao['id'] == 1){
                $js_1 = date("Y-m-d", strtotime("+1 months", strtotime($time)));
                $DB->query("insert into `mao_data` (`Z_id`,`user`,`pass`,`title`,`price`,`url`,`time`) values ('{$mao['id']}','{$user}','{$pass}','{$title}','0.1','{$ym}','{$js_1}')");
                $result=array("code"=>0,"msg"=>"开通成功！");
            }else{
                $js_2 = ($mao['price'] - 10);
                $js_1 = date("Y-m-d", strtotime("+1 months", strtotime($time)));
                $DB->query("insert into `mao_data` (`Z_id`,`user`,`pass`,`title`,`price`,`url`,`time`) values ('{$mao['id']}','{$user}','{$pass}','{$title}','0.1','{$ym}','{$js_1}')");
                $DB->query("update mao_data set price='{$js_2}' where id='{$mao['id']}'");
                $result=array("code"=>0,"msg"=>"开通成功,后台余额扣除10元！");
            }
        }
        exit(json_encode($result));
    }//添加分站
    elseif($mod == "add_tx"){
        $price = daddslashes($_POST['price']);
        if($price == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif($price < 10){
            $result=array("code"=>-2,"msg"=>"最低提现10元！");
        }elseif($mao['price'] < $price){
            $result=array("code"=>-3,"msg"=>"余额不足！");
        }elseif($mao['tx_zh'] == "" || $mao['tx_sm'] == ""){
            $result=array("code"=>-4,"msg"=>"未设置提现信息！");
        }else{
            $js_1 = ($mao['price'] - $price);
            $DB->query("insert into `mao_tx` (`M_id`,`price`,`time`,`zt`) values ('{$mao['id']}','{$price}','{$times}','1')");
            $result=array("code"=>0,"msg"=>"申请成功！");
            $DB->query("update mao_data set price='{$js_1}' where id='{$mao['id']}'");
        }
        exit(json_encode($result));
    }//申请提现
    elseif($mod == "list_tx"){
        $sql=" M_id='{$mao['id']}'";
        $numrows=$DB->count("SELECT count(*) from mao_tx WHERE {$sql} ");
        $pagesize=10;
        $pages=intval($numrows/$pagesize);
        if($numrows%$pagesize){
            $pages++;
        }
        if(isset($_REQUEST['page'])){
            $page=intval($_REQUEST['page']);
        }else{
            $page=1;
        }
        $offset=$pagesize*($page - 1);
        $rs=$DB->query("SELECT * FROM mao_tx WHERE {$sql} order by id desc limit $offset,$pagesize");
        $data = array();
        while($res = $DB->fetch($rs)){
            if($res['zt'] == 0){
                $zt = '<span style="color: #5FB878;">已处理</span>';
            }elseif($res['zt'] == 1){
                $zt = '<span style="color: #ff0000;">未处理</span>';
            }else{
                $zt = '<span style="color: #ff0000;">未知</span>';
            }

            $data[]=array(
                'id'=>$res['id'],
                'price'=>$res['price'],
                'time'=>$res['time'],
                'zt'=>$zt
            );
        }
        $first=1;
        $prev=$page-1;
        $next=$page+1;
        $last=$pages;
        if ($page>1){
            $code = $prev.$link;
        } else {
            $code = -1;
        }
        for ($i=1;$i<$page;$i++)
            $i.$link.$i;
        $page;
        for ($i=$page+1;$i<=$pages;$i++)
            $i.$link.$i;
        if ($page<$pages){
            $code_s = $next.$link;
        } else {
            $code_s = -1;
        }
        $result=array("code"=>0,"msg"=>"列表","count"=>$numrows,"data"=>$data);
        exit(json_encode($result));
    }//我的提现
    elseif($mod == "list_tx_admin"){
        if($mao['id'] != 1){
            $result=array("code"=>-3000,"msg"=>"非法请求！");
            exit(json_encode($result));
        }

        $sql=" 1";
        $numrows=$DB->count("SELECT count(*) from mao_tx WHERE {$sql} ");
        $pagesize=10;
        $pages=intval($numrows/$pagesize);
        if($numrows%$pagesize){
            $pages++;
        }
        if(isset($_REQUEST['page'])){
            $page=intval($_REQUEST['page']);
        }else{
            $page=1;
        }
        $offset=$pagesize*($page - 1);
        $rs=$DB->query("SELECT * FROM mao_tx WHERE {$sql} order by id desc limit $offset,$pagesize");
        $data = array();
        while($res = $DB->fetch($rs)){
            $cha_1 = $DB->get_row("select * from mao_data where id='{$res['M_id']}' limit 1");

            if($res['zt'] == 0){
                $zt = 'checked=""';
            }else{
                $zt = '';
            }

            $data[]=array(
                'id'=>$res['id'],
                'mid'=>$res['M_id'],
                'zh'=>$cha_1['tx_zh'],
                'sm'=>$cha_1['tx_sm'],
                'price'=>'<span style="color: #FF5722;">'.$res['price'].'</span>',
                'time'=>$res['time'],
                'zt'=>'<input type="checkbox" '.$zt.' name="open" lay-skin="switch" lay-filter="zt" lay-text="是|否" value="'.$res['id'].'">',
            );
        }
        $first=1;
        $prev=$page-1;
        $next=$page+1;
        $last=$pages;
        if ($page>1){
            $code = $prev.$link;
        } else {
            $code = -1;
        }
        for ($i=1;$i<$page;$i++)
            $i.$link.$i;
        $page;
        for ($i=$page+1;$i<=$pages;$i++)
            $i.$link.$i;
        if ($page<$pages){
            $code_s = $next.$link;
        } else {
            $code_s = -1;
        }
        $result=array("code"=>0,"msg"=>"列表","count"=>$numrows,"data"=>$data);
        exit(json_encode($result));

    }
    elseif($mod == "tx_set"){
        $id = daddslashes($_POST['id']);
        $cha_1 = $DB->get_row("select * from mao_tx where id='{$id}' limit 1");
        if($mao['id'] != 1){
            $result=array("code"=>-3000,"msg"=>"非法请求！");
        }elseif(!$cha_1){
            $result=array("code"=>-1,"msg"=>"订单不存在！");
        }else{
            if($cha_1['zt'] == 0){
                $DB->query("update mao_tx set zt='1' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"操作成功！");
            }elseif($cha_1['zt'] == 1){
                $DB->query("update mao_tx set zt='0' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"操作成功！");
            }else{
                $result=array("code"=>-2,"msg"=>"非法操作已记录！");
            }
        }
        exit(json_encode($result));
    }


}else{
    $result=array("code"=>-3000,"msg"=>"非法请求！");
    exit(json_encode($result));
}
?>