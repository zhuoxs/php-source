<?php

/**

 * 柚子家政小程序模块小程序接口定义

 *

 * @author 厦门梵挚慧

 * @url

 */

defined('IN_IA') or exit('Access Denied');
defined('TD_PATH') or define('TD_PATH',__DIR__);
require_once TD_PATH."/class/func.php";


class wnjz_sunModuleWxapp extends WeModuleWxapp {
    /************************************************首页*****************************************************/
    //获取openid
    public function doPageOpenid(){
        global $_W, $_GPC;
        $res=pdo_get('wnjz_sun_system',array('uniacid'=>$_W['uniacid']));
        $code=$_GPC['code'];
        $appid=$res['appid'];
        $secret=$res['appsecret'];
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$secret."&js_code=".$code."&grant_type=authorization_code";
        function httpRequest($url,$data = null){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            if (!empty($data)){
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            return $output;
        }
        $re=httpRequest($url);
        print_r($re);
    }

    //登录用户信息
    public function doPageLogin(){
        global $_GPC, $_W;
        $openid=$_GPC['openid'];
        $res=pdo_get('wnjz_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
        if($openid and $openid!='undefined'){
            if($res){
                $user_id=$res['id'];
                $data['openid']=$_GPC['openid'];
                $data['img']=$_GPC['img'];
                $data['name']=$_GPC['name'];
                $data['time'] = time();
                $res = pdo_update('wnjz_sun_user', $data, array('id' =>$user_id));
                $user=pdo_get('wnjz_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
                echo json_encode($user);
            }else{
                $data['openid']=$_GPC['openid'];
                $data['img']=$_GPC['img'];
                $data['name']=$_GPC['name'];
                $data['uniacid']=$_W['uniacid'];
                $data['time']=time();
                $res2=pdo_insert('wnjz_sun_user',$data);
                $user=pdo_get('wnjz_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
                echo json_encode($user);
            }
        }
    }

    // 用户数据存入后台
    public function doPageuserData()
    {
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $img = $_GPC['img'];
        $nickname = $_GPC['nickName'];
        $gender = $_GPC['gender'];
        $data = array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$openid,
            'img'=>$img,
            'name'=>$nickname,
            'time'=>time(),
            'gender'=>$gender
        );
        $res = pdo_get('wnjz_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        if($res){
            $result = pdo_update('wnjz_sun_user',$data,array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        }else{
            $result = pdo_insert('wnjz_sun_user',$data);
        }
        $newData = pdo_get('wnjz_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        echo json_encode($newData);
    }

    //首页预约服务
    public function doPageFuwu(){
        global $_GPC, $_W;
        $build_id = $_GPC['build_id']; // 门店id
        $res=pdo_getall('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'status'=>2,'index'=>1));
        $newRes = array();
        foreach ($res as $k=>$v){
            if(in_array($build_id,explode(',',$v['build_id']))){
                $newRes[$k] = $v;
            }
        }
        echo json_encode($newRes);
    }

//获取首页公告
    public function doPageNew(){
        global $_GPC, $_W;
        $res=pdo_getall('wnjz_sun_addnews',array('uniacid'=>$_W['uniacid'],'state'=>1));
        echo json_encode($res);
    }


//获取首页Banner
    public function doPageBanner(){
        global $_GPC, $_W;
        $banner=pdo_get('wnjz_sun_banner',array('uniacid'=>$_W['uniacid']));
        echo  json_encode($banner);
    }

//获取首页热门服务
    public function doPageDemand(){
        global $_GPC, $_W;
        $res=pdo_getall('wnjz_sun_selected',array('uniacid'=>$_W['uniacid'],'detele'=>1,'selected'=>1));
        echo  json_encode($res);
    }

// 首页优惠券领取
    public function doPageCounpIndex(){
        global $_GPC,$_W;
        $userid= $_GPC['userid'];
        $build_id = $_GPC['build_id']; // 门店id
        $new = date('Y-m-d H:i:s',time());
        $where =" WHERE  a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.state=1 and a.antime >"."'$new'";
        $sql = "select a.*,b.limittime,b.createtime,b.isused  from " . tablename("wnjz_sun_coupon")."a ". "left join".tablename("wnjz_sun_user_coupon")."b on b.cid=a.id and b.uid= "."'$userid'".$where;

        $counpIndex = pdo_fetchall($sql);
        if($counpIndex){
            foreach ($counpIndex as  $k=>$v){
                $res[$k]['id']=$v['id'];
                $re=strtotime($v['antime']);
                $res[$k]['antime']=date('Y-m-d',$re);
                $res[$k]['isused']=$v['isused'];
                $res[$k]['createtime']=$v['createtime'];
                $res[$k]['limittime']=$v['limittime'];

                $res[$k]['val']=$v['val'];
                $ret=strtotime($v['astime']);
                $res[$k]['astime']=date('Y-m-d',$ret);
                $res[$k]['vab']=$v['vab'];
            }
        }else{
            $res = array();
        }
        echo json_encode($res);
    }
//获取优惠券
    public function doPageCounpadd(){
        global $_GPC, $_W;
        $res=pdo_get('wnjz_sun_coupon',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        $data['uid']=$_GPC['userid'];
        $data['cid']=$_GPC['id'];
        $data['type']=$res['type'];
        $data['val']=$res['val'];
        $data['vab']=$res['vab'];
        $data['uniacid']=$_W['uniacid'];
        $data['isused']=1;
        $data['createtime']=time();
        $data['limittime']=time();
        $userid=$_GPC['userid'];
        $datas['total'] =$res['total']-1;
        $rul="select * from".tablename('wnjz_sun_user_coupon'). " where cid=".$_GPC['id']." and uid="."'$userid'"." and isUsed=1 and uniacid = ".$_W['uniacid'];
        $retule=pdo_fetch($rul);
        if($retule){
            $hh['status']=2;
            die();
        }else{
            $res2=pdo_insert('wnjz_sun_user_coupon',$data);
            $o = pdo_update('wnjz_sun_coupon',$datas,array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
            $hh['status']=1;
        }

        echo json_encode($hh);
    }


//支付获取优惠圈
    public function doPageCounpPay(){
        global $_GPC,$_W;
        $userid= $_GPC['userid'];
        $build_id = $_GPC['build_id']; // 门店id
        $new = date('Y-m-d H:i:s',time());
        $where =" WHERE  a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.state=1 and b.usetime =0  and a.antime >"."'$new'";
        $sql = "select a.*,b.limittime,b.createtime,b.isused ,b.id  from " . tablename("wnjz_sun_coupon")." a ". "left join".tablename("wnjz_sun_user_coupon")."b on b.cid=a.id and b.uid= "."'$userid'".$where;

        $counpIndex = pdo_fetchall($sql);
        if($counpIndex){
            foreach ($counpIndex as  $k=>$v){
                $res[$k]['cid']=$v['id'];
                $re=strtotime($v['antime']);
                $res[$k]['antime']=date('Y-m-d',$re);
                $res[$k]['isused']=$v['isused'];
                $res[$k]['createtime']=$v['createtime'];
                $res[$k]['limittime']=$v['limittime'];
                $res[$k]['val']=$v['val'];
                $ret=strtotime($v['astime']);
                $res[$k]['astime']=date('Y-m-d',$ret);
                $res[$k]['vab']=$v['vab'];
            }
        }else{
            $res = array();
        }
        echo json_encode($res);
    }

    public function doPageUserCounpPay(){
        global $_GPC,$_W;
        $userid= $_GPC['userid'];
        $build_id = $_GPC['build_id']; // 门店id
        $new = date('Y-m-d H:i:s',time());
        $where =" WHERE  a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and b.uid="."'$userid'"." and a.state=1 and a.antime >"."'$new'";
        $sql = "select a.*,b.limittime,b.createtime,b.isused,b.useTime,b.id  from " . tablename("wnjz_sun_coupon")." a ". "left join".tablename("wnjz_sun_user_coupon")."b on b.cid=a.id".$where;

        $counpIndex = pdo_fetchall($sql);

        foreach ($counpIndex as  $k=>$v){
            $res[$k]['cid']=$v['id'];
            $re=strtotime($v['antime']);
            $res[$k]['antime']=date('Y-m-d',$re);
            $res[$k]['isused']=$v['isused'];
            $res[$k]['createtime']=$v['createtime'];
            $res[$k]['limittime']=$v['limittime'];
            $res[$k]['val']=$v['val'];
            $ret=strtotime($v['astime']);
            $res[$k]['astime']=date('Y-m-d',$ret);
            $res[$k]['vab']=$v['vab'];
            $res[$k]['usetime']=$v['useTime'];
        }
        $Nouser = array();
        $user = array();
        foreach ($res as $k=>$v){
            if($v['usetime']>0){
                $user[] = $v;
            }else{
                $Nouser[] = $v;
            }
        }
        $new = array(
            'user'=>$user,
            'Nouser'=>$Nouser
        );
        echo json_encode($new);
    }


    //查询订单预约详情
    public function doPageOrdercheck(){
        global $_GPC, $_W;
        // 获取商品详情
        $res=pdo_get('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$_GPC['id']));
        $res['lb_imgs'] = explode(',',$res['lb_imgs']);
        // 获取该商品的服务评价
        $data = pdo_getall('wnjz_sun_comment',array('uniacid'=>$_W['uniacid'],'gid'=>$_GPC['id']),'','','eid DESC');
        foreach ($data as $k=>$v){
            $data[$k]['imgs'] = explode(',',$v['imgs']);
            $data[$k]['username'] = pdo_getcolumn('wnjz_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),'name');
            $data[$k]['img'] = pdo_getcolumn('wnjz_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),'img');
            $data[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
        }
        $newData = array(
            'goods'=>$res,
            'comment'=>$data,
        );
        echo json_encode($newData);
    }

//获取文章详情
    public function doPageHotser(){
        global $_GPC, $_W;
        $res=pdo_get('wnjz_sun_selected',array('uniacid'=>$_W['uniacid'],'seid'=>$_GPC['id']));
        echo json_encode($res);
    }

//查询深度预约预约
    public function doPageShenduyuyue(){
        global $_GPC, $_W;
        $res=pdo_getall('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'status'=>2,'cid'=>2));
        echo json_encode($res);
    }
//查询常规预约预约
    public function doPageChangguiyuyue(){
        global $_GPC, $_W;
        $res=pdo_getall('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'status'=>2,'cid'=>1));
        echo json_encode($res);
    }

//获取关于我们
    public function doPageAboutus(){
        global $_GPC, $_W;
        $res=pdo_get('wnjz_sun_system',array('uniacid'=>$_W['uniacid']));
        echo json_encode($res);
    }
    /************************************************分店*****************************************************/
//获取分店地址
    public function doPageAddress(){
        global $_GPC, $_W;
        $openid = $_GPC['openid']; // 用户id
        // 经纬度
        $lat = $_GPC['lat'];
        $lon = $_GPC['lon'];
        $Switch = $_GPC['Switch'];
        if($Switch==1){
            // 用户选取的分店信息
            $data = pdo_get('wnjz_sun_build_switch',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
            if($data){
                $res=pdo_getall('wnjz_sun_branch',array('stutes'=>1,'uniacid'=>$_W['uniacid']));
                foreach ($res as $k=>$v){
                    if($data['build_id']==$v['id']){
                        $res[$k]['switch'] = 1;
                    }
                }
            }
            foreach ($res as $k=>$v){
                $res[$k]['distance'] = round(($this->getdistance($lat,$lon,$v['lat'],$v['lng']))/1000,2);
            }
        }else{
            $res=pdo_getall('wnjz_sun_branch',array('stutes'=>1,'uniacid'=>$_W['uniacid']));
            foreach ($res as $k=>$v){
                $res[$k]['distance'] = round(($this->getdistance($lat,$lon,$v['lat'],$v['lng']))/1000,2);
            }
            foreach ($res as $k=>$v){
                $dis[$k] = $v['distance'];
            }
            array_multisort($dis,SORT_ASC,$res);
            $res[0]['switch'] = 1;
        }

        echo json_encode($res);
    }

//获取分店名称
    public function doPageShopps(){
        global $_GPC, $_W;
        $res=pdo_get('wnjz_sun_system',array('uniacid'=>$_W['uniacid']));
        echo json_encode($res);
    }

    // 切换门店
    public function doPageSwitchBranch()
    {
        global $_W,$_GPC;
        $id = $_GPC['id']; // 切换的门店id
        $openid = $_GPC['openid']; // 用户id
        $build_switch = pdo_get('wnjz_sun_build_switch',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        $data = array(
            'uniacid'=>$_W['uniacid'],
            'build_id'=>$id,
            'openid'=>$openid
        );
        if(!$build_switch){
            $res = pdo_insert('wnjz_sun_build_switch',$data);
        }else{
            $res = pdo_update('wnjz_sun_build_switch',array('build_id'=>$id),array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
            if($id==$build_switch['build_id']){
                $res = 1;
            }
        }
        echo json_encode($res);
    }

    // 获取当前选中的门店
    public function doPageCurrentBranch()
    {
//        global $_W,$_GPC;
//        $openid = $_GPC['openid']; // 用户id
//        // 获取用户选中的分店信息
//        $build = pdo_get('wnjz_sun_build_switch',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
//        if($build){
//            $data = pdo_get('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'stutes'=>1,'id'=>$build['build_id']));
//        }else{
//            $data = pdo_get('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'stutes'=>1,'status'=>1));
//        }
//        echo json_encode($data);
        
        global $_W,$_GPC;
        $openid = $_GPC['openid']; // 用户id
        $Switch = $_GPC['Switch']; // 判断是都主动选择门店
        // 当前位置
        $lat = $_GPC['latitude'];
        $lng = $_GPC['longitude'];
        if ($Switch==1){
            // 获取用户选中的分店信息
            $build = pdo_get('wnjz_sun_build_switch',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
            if($build){
                $data = pdo_get('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'stutes'=>1,'id'=>$build['build_id']));
            }else{
                $data = pdo_get('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'stutes'=>1,'status'=>1));
            }
        }else{
            // 默认中选就近门店
            $branch = pdo_getall('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'stutes'=>1));
            foreach ($branch as $k=>$v){
                $branch[$k]['distance'] = round(($this->getdistance($lat,$lng,$v['lat'],$v['lng']))/1000,2);
            }
            foreach ($branch as $k=>$v){
                $dis[$k] = $v['distance'];
            }
            array_multisort($dis,SORT_ASC,$branch);
            $data = $branch[0];
        }

        $data['lat'] = (float)$data['lat'];
        $data['lng'] = (float)$data['lng'];
        echo json_encode($data);
    }

    /**
     * 求两个已知经纬度之间的距离,单位为米
     *
     * @param lng1 $ ,lng2 经度
     * @param lat1 $ ,lat2 纬度
     * @return float 距离，单位米
     */
    function getdistance($lng1, $lat1, $lng2, $lat2) {
        // 将角度转为弧度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        return $s;
    }

    /************************************************个人中心*****************************************************/
//个人中心获取优惠券的个数
    public function doPageCountcounp(){
        global $_GPC, $_W;
        $userid= $_GPC['userid'];
        $build_id = $_GPC['build_id'];
        $new = date('Y-m-d H:i:s',time());
        $where =" WHERE  a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.state=1 and b.usetime =0  and a.antime >"."'$new'";
        $sql = "select a.*,b.limittime,b.createtime,b.isused ,b.id  from " . tablename("wnjz_sun_coupon")."a ". "left join".tablename("wnjz_sun_user_coupon")."b on b.cid=a.id and b.uid= "."'$userid'".$where;

        $counpIndex =pdo_fetchall($sql);
        echo json_encode($counpIndex);
    }

//个人中心获取优惠券的钱
    public function doPageMoney(){
        global $_GPC, $_W;
        $userid= $_GPC['userid'];
        $res = pdo_get('wnjz_sun_user',  array('openid' =>$userid,'uniacid'=>$_W['uniacid']));
        echo json_encode($res);
    }

// 服务订单
    public function doPageOrrde(){
        global $_GPC, $_W;
        $userid=$_GPC['userid'];
        $build_id = $_GPC['build_id']; // 门店id
        $where = " WHERE  a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.oprnid="."'$userid'" . ' ORDER BY '.' a.addtime DESC';
        $sql = "select * from ".tablename('wnjz_sun_orderlist')."b left join ".tablename('wnjz_sun_order')."a on a.oid=b.order_id".$where;
        $lit=pdo_fetchall($sql);
        foreach ($lit as $k=>$v){
            $lit[$k]['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'gname');
            $lit[$k]['pic'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'pic');

        }
        return $this->result(0,'',$lit);

    }

    //待服务的
    public function doPagedafuwu(){
        global $_GPC, $_W;
        $userid=$_GPC['userid'];
        $build_id = $_GPC['build_id']; // 门店id
        $where = " WHERE a.status = 3 and a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.oprnid="."'$userid'" . ' ORDER BY '.' a.addtime DESC';
        $sql = "select * from ".tablename('wnjz_sun_orderlist')."b left join ".tablename('wnjz_sun_order')."a on a.oid=b.order_id".$where;
        $lit=pdo_fetchall($sql);
        foreach ($lit as $k=>$v){
            $lit[$k]['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'gname');
            $lit[$k]['pic'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'pic');
        }
        echo json_encode($lit);
    }
    //待支付
    public function doPagedazhifu(){
        global $_GPC, $_W;
        $userid=$_GPC['userid'];
        $build_id = $_GPC['build_id']; // 门店id
        $where = " WHERE a.status = 2 and a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.oprnid="."'$userid'" . ' ORDER BY '.' a.addtime DESC';
        $sql = "select * from ".tablename('wnjz_sun_orderlist')."b left join ".tablename('wnjz_sun_order')."a on a.oid=b.order_id".$where;
        $lit=pdo_fetchall($sql);
        foreach ($lit as $k=>$v){
            $lit[$k]['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'gname');
            $lit[$k]['pic'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'pic');
        }
        echo json_encode($lit);

    }
    //待确认
    public function doPagedaqueren(){
        global $_GPC, $_W;
        $userid=$_GPC['userid'];
        $build_id = $_GPC['build_id']; // 门店id
        $where = " WHERE a.status = 3 and a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.oprnid="."'$userid'" . ' ORDER BY '.' a.addtime DESC';
        $sql = "select * from ".tablename('wnjz_sun_orderlist')."b left join ".tablename('wnjz_sun_order')."a on a.oid=b.order_id".$where;
        $lit=pdo_fetchall($sql);
        foreach ($lit as $k=>$v){
            $lit[$k]['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'gname');
            $lit[$k]['pic'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'pic');
        }
        echo json_encode($lit);
    }

    //已服务
    public function doPageServices(){
        global $_GPC,$_W;
        $userid=$_GPC['openid'];
        $build_id = $_GPC['build_id']; // 门店id
        $where = " WHERE a.status = 5 and a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.oprnid="."'$userid'" . ' ORDER BY '.' a.addtime DESC';
        $sql = "select * from ".tablename('wnjz_sun_orderlist')."b left join ".tablename('wnjz_sun_order')."a on a.oid=b.order_id".$where;
        $lit=pdo_fetchall($sql);
        foreach ($lit as $k=>$v){
            $lit[$k]['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'gname');
            $lit[$k]['pic'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'pic');
            if(pdo_get('wnjz_sun_comment',array('uniacid'=>$_W['uniacid'],'openid'=>$userid,'oid'=>$v['oid']))){
                $lit[$k]['is_comment'] = 1;
            }else{
                $lit[$k]['is_comment'] = 0;
            }
        }
        echo json_encode($lit);
    }



    //充值获取金额
    public function doPagejine(){
        global $_W, $_GPC;
        $sql="select * from".tablename('wnjz_sun_money').'where uniacid='.$_W['uniacid'].' and status=1';
        $lisr = pdo_fetchall($sql);
        echo json_encode($lisr);
    }
    //充值充值

    public function doPageAddmoney(){
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        $price=$_GPC['price'];
        $sql="select * from".tablename('wnjz_sun_user')."where uniacid=".$_W['uniacid']." and openid="."'$openid'";
        $orderinfo = pdo_fetch($sql);

        $datas = array(
            'r_name'=>$orderinfo['name'],
            'r_img'=>$orderinfo['img'],
            'uniacid'=>$_W['uniacid'],
            'r_time'=>date('Y-m-d H:i:s',time()),
            'r_money'=>$_GPC['price']
        );
        pdo_insert('wnjz_sun_recharges',$datas);
        $order['money']=$orderinfo['money']+$_GPC['price'];
        $data = pdo_update('wnjz_sun_user',$order,array('uniacid'=>$_W['uniacid'],'id'=>$orderinfo['id']));
        if($data){
            $retu['status']=1;
        }
        echo json_encode($retu);
    }


    // 支付成功模板消息
    public function doPagePaysuccess()
    {
        global $_W, $_GPC;
        function getaccess_token($_W)
        {
            $res = pdo_get('wnjz_sun_system', array('uniacid' => $_W['uniacid']));
            $appid = $res['appid'];
            $secret = $res['appsecret'];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data, true);
            return $data['access_token'];
        }

        //设置与发送模板信息

        function set_msg($_W, $_GPC)
        {
            $access_token = getaccess_token($_W);
            $prepay_id = trim($_GPC['prepay_id'],'prepay_id=');
            $res2 = pdo_get('wnjz_sun_sms', array('uniacid' => $_W['uniacid']));
            // 获取关键词数据
            $sql = ' SELECT  * FROM ' .tablename('wnjz_sun_orderlist') . ' ol ' . ' JOIN ' . tablename('wnjz_sun_order') . ' o ' . ' ON ' . ' o.oid=ol.order_id' . ' WHERE ' . ' o.uniacid='.$_W['uniacid'] . ' AND ' . ' o.oid='.$_GPC['order_id'];
            $order = pdo_fetch($sql);
            $order['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$order['gid']),'gname');
            $order['address'] = $order['provinceName'] . $order['cityName'] . $order['countyName'] . $order['detailInfo'];
            $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
            $formwork = '{
     "touser": "' . $_GET["openid"] . '",
     "template_id": "' . $res2["tid1"] . '",
     "page":"wnjz_sun/pages/index/index",
     "form_id":"' . $prepay_id . '",
     "data": {
       "keyword1": {
         "value": "' . $order['gname'] . '",
         "color": "#173177"
       },
       "keyword2": {
         "value":"' . $order['money'] . '",
         "color": "#173177"
       },
       "keyword3": {
         "value": "' . $order['orderNum'] . '",
         "color": "#173177"
       },
       "keyword4": {
         "value": "' . $order['addtime'] . '",
         "color": "#173177"
       },
       "keyword5": {
         "value":  "' . $order['address'] . '",
         "color": "#173177"
       },
       "keyword6": {
         "value":  "' . $order['time'] . '",
         "color": "#173177"
       }
     }   
   }';
            // $formwork=$data;
            $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formwork);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        echo set_msg($_W, $_GPC);
    }

    // 余额付款 改变订单状态
    public function doPagebalancePay()
    {
        global $_GPC,$_W;
        $openid = $_GPC['openid']; // 用户id
        $order_id = $_GPC['order_id']; // 订单id
        $build_id = $_GPC['build_id']; // 门店id
        // 获取用户余额数据
        $balance = pdo_get('wnjz_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        // 获取订单数据
        $order = pdo_get('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'oid'=>$order_id,'oprnid'=>$openid));
		if($balance['money']>$order['money']){
            if($order['status']==2){
                $price = $balance['money']-$order['money'];
                $ress = pdo_update('wnjz_sun_order',array('status'=>3,"paytype"=>2),array('uniacid'=>$_W['uniacid'],'oid'=>$order_id));
                pdo_update('wnjz_sun_user',array('money'=>$price),array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
				//pdo_update('wnjz_sun_order', array("paytype"=>2), array('oid' => $order_id));

                // 获取平台打印
                $print = pdo_get('wnjz_sun_printing',array('uniacid'=>$_W['uniacid']));
                if($print['is_open']==1){
                    $this->Printing($order_id,$build_id);
                }

                // 调用短信接口
                // 平台数据
                $sms = pdo_get('wnjz_sun_sms',array('uniacid'=>$_W['uniacid']));
                // 个人号码
                $mobile = pdo_getcolumn('wnjz_sun_servies',array('uniacid'=>$_W['uniacid'],'sid'=>$order['sid']),'mobile');
                $phone = array(
                    0=>$sms['mobile'],
                    1=>$mobile
                );
                if($sms['is_open']==1){
                    foreach ($phone as $k=>$v){
                        $this->Shortmessage($v);
                    }
                }

				$res['as'] = 1;
                
            }else{
                $res['as'] = 0;
            }
        }else{
            $res['as'] = 3;
        }
        echo json_encode($res);
    }

    /**************************************************************订单***************************************************/


    // 添加订单
    public  function doPageAddorders(){
        global $_W, $_GPC;
        $build_id = $_GPC['build_id']; // 门店id
        $data['cityName']=$_GPC['cityName'];
        $data['time']=$_GPC['time'];
        $sn = time() . mt_rand(100, 999);
        $data['orderNum'] = $sn;
        //   $data['num']=$_GPC['num'];
        $data['detailInfo']=$_GPC['detailInfo'];
        $data['telNumber']=$_GPC['telNumber'];
        $data['countyName']=$_GPC['countyName'];
        $data['provinceName']=$_GPC['provinceName'];
        $data['name']=$_GPC['name'];
        $data['oprnid']=$_GPC['oprnid'];
        $data['uniacid']=$_W['uniacid'];
        $data['addtime']=time();
        $data['money']=$_GPC['totalprice'];
        $data['text'] = $_GPC['remark'];
        $data['status']=2;
        $data['build_id'] = $build_id;
        $goods = pdo_get('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$_GPC['gid']));
        //判断是否限购
        if(intval($goods["endbuy"])>0){
            if(intval($goods["endbuy"])<intval($_GPC['num'])){
                return $this->result(1, '该商品最多只能购买'.$goods["endbuy"].'份！！！', array());//errno，message，data
            }
            //查找该用户已经购买多少该商品
            $sql = ' SELECT sum(ol.num) as num FROM ' . tablename('wnjz_sun_order') . ' o ' . ' JOIN ' . tablename('wnjz_sun_orderlist') . ' ol ' . ' ON o.oid=ol.order_id' . ' WHERE o.uniacid=' . $_W['uniacid'] . " AND o.oprnid='" .$_GPC['oprnid']."' and ol.gid=".$_GPC['gid'];
            $order_num = pdo_fetch($sql);
            if($order_num){
                if((intval($order_num["num"])+intval($_GPC['num']))>intval($goods["endbuy"])){
                    return $this->result(1, '该商品您最多只能购买'.intval($goods["endbuy"]).'份！！！', array());//errno，message，data
                }
            }
        }
        foreach (explode(',',$goods['build_id']) as $k=>$v){
            if($build_id == $v){
                $data['sid'] = intval(explode(',',$goods['sid'])[$k]);
            }
        }
        /*********修改优惠券的状态**********/
        $datas['usetime']=time();
        $res=pdo_update('wnjz_sun_user_coupon',$datas,array('id'=>$_GPC['cid'],'uniacid'=>$_W['uniacid']));
        $re=pdo_insert('wnjz_sun_order',$data);
		$g_order_id = pdo_insertid();
        if(intval($g_order_id)<=0){
            return $this->result(1,'数据提交失败，请重新提交,0002', array());
        }
        if($re){
            $uniacid=$_W['uniacid'];
            $oprnid=$_GPC['oprnid'];
            $where=" where oprnid ='$oprnid' AND uniacid =$uniacid";
            $sql="SELECT * FROM ".tablename('wnjz_sun_order').$where." ORDER BY oid DESC";
            $retule = pdo_fetch($sql);
            $order['cid']=$_GPC['cid'];
            $order['order_id']=$retule['oid'];
            $order['uniacid']=$_W['uniacid'];
            $order['createTime']=time();
            $order['gid']=$_GPC['gid'];
            $order['num']=$_GPC['num'];
            $orde=pdo_insert('wnjz_sun_orderlist',$order);
        }

		//========计算分销佣金 S===========
        include_once IA_ROOT . '/addons/wnjz_sun/inc/func/distribution.php';
        $distribution = new Distribution();
        $distribution->order_id = $g_order_id;
        $distribution->money = $_GPC['totalprice'];
        $distribution->userid = $_GPC['oprnid'];
        $distribution->ordertype = 1;
        $distribution->computecommission();
        //========计算分销佣金 E===========

        echo $retule['oid'];
    }
    /*
         * 获取微信支付的数据
         *
         */
    public function doPageOrderarr() {
        global $_GPC,$_W;
		$openid = $_GPC['openid'];
		$order_id=intval($_GPC['order_id']);
        $appData = pdo_get('wnjz_sun_system',array('uniacid'=>$_W['uniacid']));
        $appid = $appData['appid'];
        $mch_id = $appData['mchid'];
        $keys = $appData['wxkey'];
        $price = $_GPC['price'];
		$type = $_GPC['type'];
        $order_url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $data = array(
            'appid' => $appid,
            'mch_id' => $mch_id,
            'nonce_str' => '5K8264ILTKCH16CQ2502SI8ZNMTM67VS',//
            //'sign' => '',
            'body' => time(),
            'out_trade_no' => date('Ymd') . substr('' . time(), -4, 4),
            'total_fee' => $price*100,
//            'total_fee' => 1,
            'spbill_create_ip' => '120.79.152.105',
            'notify_url' => '120.79.152.105',
            'trade_type' => 'JSAPI',
            'openid' => $openid
        );
        ksort($data, SORT_ASC);
        $stringA = http_build_query($data);
        $signTempStr = $stringA . '&key='.$keys;
        $signValue = strtoupper(md5($signTempStr));
        $data['sign'] = $signValue;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $order_url);//如果不传这样进行设置
        curl_setopt($ch, CURLOPT_HEADER, 0);//header就是返回header头相关信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置数据是直接输出还是返回
        curl_setopt($ch, CURLOPT_POST, 1);//设置为post模式提交 跟 form表单的提交是一样
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->arrayToXml($data));//设置提交数据
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);//设置ssl不验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//设置ssl不验证
        $result = curl_exec($ch);//执行请求 就等于html表单的 input:submit 如果没有设置 returntransfer 那么 是不会有返回值的 会直接输出
        curl_close($ch);//关闭
        $result = xml2array($result);
//        return $this->result(0,'',$result);
		
		if($type==1){
			pdo_update('wnjz_sun_order', array('out_trade_no' => $data['out_trade_no'],"paytype"=>1), array('oid' => $order_id));
		}else{
			pdo_update('wnjz_sun_kjorder', array('out_trade_no' => $data['out_trade_no'],"paytype"=>1), array('id' => $order_id));
		}
		
        echo json_encode($this->createPaySign($result));

    }
    function createPaySign($result)
    {
        global $_W;
        $appData = pdo_get('wnjz_sun_system',array('uniacid'=>$_W['uniacid']));
        $keys = $appData['wxkey'];
        $data = array(
            'appId' => $result['appid'],
            'timeStamp' => (string)time(),
            'nonceStr' => $result['nonce_str'],
            'package' => 'prepay_id=' . $result['prepay_id'],
            'signType' => 'MD5'
        );
        ksort($data, SORT_ASC);
        $stringA = '';
        foreach ($data as $key => $val) {
            $stringA .= "{$key}={$val}&";
        }
        $signTempStr = $stringA . 'key='.$keys;
        $signValue = strtoupper(md5($signTempStr));
        $data['paySign'] = $signValue;
        return $data;
    }

    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    //付款改变订单状态
    public function doPagePayOrder(){
        global $_W, $_GPC;
        $build_id = $_GPC['build_id']; // 门店id
        //获取订单信息
        $datas['status']=3;
        $datas['paytime'] = time();
        $orderinfo=pdo_update('wnjz_sun_order',$datas,array('oid'=>$_GPC['order_id'],'uniacid'=>$_W['uniacid']));
        $order = pdo_get('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'oid'=>$_GPC['order_id']));
        // 调用短信接口
        
		// 平台数据
        $sms = pdo_get('wnjz_sun_sms',array('uniacid'=>$_W['uniacid']));
		// 个人号码
        $mobile = pdo_getcolumn('wnjz_sun_servies',array('uniacid'=>$_W['uniacid'],'sid'=>$order['sid']),'mobile');
		$phone = array(
            0=>$sms['mobile'],//平台号码
            1=>$mobile //个人号码
        );
        if($sms['is_open']==1){
            foreach ($phone as $k=>$v){
                $this->Shortmessage($v);
            }
        }
        // 获取平台打印
        $print = pdo_get('wnjz_sun_printing',array('uniacid'=>$_W['uniacid']));
        if($print['is_open']==1){
            $this->Printing($_GPC['order_id'],$build_id);
        }
        echo json_encode($order['sid']);
    }

    // 打印
    function Printing($order_id,$build_id)
    {
        global $_W,$_GPC;
        header("Content-type: text/html; charset=utf-8");
        include 'HttpClient.class.php';

        // 获取订单数据
        $sql = ' SELECT * FROM ' . tablename('wnjz_sun_order') . ' o ' . ' JOIN ' . tablename('wnjz_sun_orderlist') . ' ol ' . ' ON o.oid=ol.order_id' . ' WHERE o.uniacid=' . $_W['uniacid'] . ' AND o.oid=' . $order_id;
        $order = pdo_fetch($sql);
        $order['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$order['gid']),'gname');
        $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
        $order['address'] = $order['provinceName'] . $order['cityName'] . $order['countyName'] . $order['detailInfo'];

        $printing = pdo_get('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$build_id));
        $build_name = $printing['name'];

        define('USER', $printing['user']);	//*必填*：飞鹅云后台注册账号
        define('UKEY', $printing['key']);	//*必填*: 飞鹅云注册账号后生成的UKEY
        define('SN', $printing['sn']);	    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API


        //以下参数不需要修改
        define('IP','api.feieyun.cn');			//接口IP或域名
        define('PORT',80);						//接口IP端口
        define('PATH','/Api/Open/');		//接口路径
        define('STIME', time());			    //公共参数，请求时间
        define('SIG', sha1(USER.UKEY.STIME));   //公共参数，请求公钥

        $orderInfo = '<CB>'.$build_name.'</CB><BR>';
        $orderInfo .= '服务名称:　　　　　'.$order['gname'].'<BR>';
        $orderInfo .= '预约时间:　　　　'.$order['time'].'<BR>';
        $orderInfo .= '支付金额:　　　　   　　'.$order['money'].'<BR>';
        $orderInfo .= '数量:　　　　 　　　　　'.$order['num'].'<BR>';
        $orderInfo .= '地址:　　　'.$order['address'].'<BR>';
        $orderInfo .= '联系号码:　　　　　'.$order['telNumber'].'<BR>';
        $orderInfo .= '联系人:　　　　　　　　'.$order['name'].'<BR>';
        $orderInfo .= '备注：　　　　'.$order['text'].'<BR>';
        $orderInfo .= '----------------------------------------------<BR>';
        $orderInfo .= '订单编号：　　'.$order['orderNum'].'<BR>';

        //打开注释可测试
        $this->wp_print(SN,$orderInfo,1);

    }

    /*
 *  方法1
	拼凑订单内容时可参考如下格式
	根据打印纸张的宽度，自行调整内容的格式，可参考下面的样例格式
*/
    function wp_print($printer_sn,$orderInfo,$times){

        $content = array(
            'user'=>USER,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_printMsg',
            'sn'=>$printer_sn,
            'content'=>$orderInfo,
            'times'=>$times//打印次数
        );
        $client = new HttpClient(IP,PORT);
        if(!$client->post(PATH,$content)){
            echo 'error';
        }
        else{
            //服务器返回的JSON字符串，建议要当做日志记录起来
//            return $client->getContent();
//            echo $client->getContent();
        }
    }

    // 短信通知
    function Shortmessage($mobile)
    {
        global $_GPC,$_W;
        header('content-type:text/html;charset=utf-8');

        $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
        // 获取短信模板数据
        $sms = pdo_get('wnjz_sun_sms',array('uniacid'=>$_W['uniacid']));

        $smsConf = array(
            'key'   => $sms['appkey'], //您申请的APPKEY
            'mobile'    => $mobile, //接受短信的用户手机号码
            'tpl_id'    => $sms['tpl_id'], //您申请的短信模板ID，根据实际情况修改
            'tpl_value' =>'#code#=1234&#company#=聚合数据' //您设置的模板变量，根据实际情况修改
        );

        $content = $this->juhecurl($sendUrl,$smsConf,1); //请求发送短信

        /*if($content){
            $result = json_decode($content,true);
            $error_code = $result['error_code'];
            if($error_code == 0){
                //状态为0，说明短信发送成功
                echo "短信发送成功,短信ID：".$result['result']['sid'];
            }else{
                //状态非0，说明失败
                $msg = $result['reason'];
                echo "短信发送失败(".$error_code.")：".$msg;
            }
        }else{
            //返回内容异常，以下可根据业务逻辑自行修改
            echo "请求发送短信失败";
        }*/
    }

    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }


//直接付款
    public function doPageAddorde(){
        global $_W, $_GPC;
        //获取订单信息
        $order['build_id'] = $_GPC['build_id'];
        $order['oprnid']=$_GPC['openid'];
        $order['price']=$_GPC['price'];
        $order['cid']=$_GPC['cid'];
        $order['type']=$_GPC['pays'];
        $order['addtime'] = time();
        $order['uniacid']=$_W['uniacid'];
        $datas['usetime']=time();
        $orderinfo=pdo_insert('wnjz_sun_orde',$order,array('uniacid'=>$_W['uniacid']));
        $res=pdo_update('wnjz_sun_user_coupon',$datas,array('id'=>$_GPC['cid'],'uniacid'=>$_W['uniacid']));

        echo json_encode($order);
    }





//余额付款
    public function doPageLocal(){
        global $_W, $_GPC;
        //获取订单信息
        $openid = $_GPC['openid'];
        $price=$_GPC['price'];
        $build_id = $_GPC['build_id']; // 门店id
        $sql="select * from".tablename('wnjz_sun_user')."where uniacid=".$_W['uniacid']." and openid="."'$openid'";
        $orderinfo = pdo_fetch($sql);
        if($orderinfo['money']-$price >=0 ){
            $order['money']=$orderinfo['money']-$_GPC['price'];
            $data = pdo_update('wnjz_sun_user',$order,array('uniacid'=>$_W['uniacid'],'id'=>$orderinfo['id']));
            if($data){
                $retu['status']=1;
            }
        }else{
            $retu['status']=2;
        }


        echo json_encode($retu);
    }



    //删除订单
    public function doPageOrderDelete(){
        global $_GPC, $_W;
        $res=pdo_delete('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'oid'=>$_GPC['oid']));
        echo json_encode($res);
    }
    //确认
    public function doPageOrderqueren(){
        global $_GPC, $_W;
        //获取订单信息
        $datas['status']=5;
        $orderinfo=pdo_update('wnjz_sun_order',$datas,array('oid'=>$_GPC['oid']));

		/*======分销使用====== */
		include_once IA_ROOT . '/addons/wnjz_sun/inc/func/distribution.php';
		$distribution = new Distribution();
		$distribution->order_id = $_GPC['oid'];
		//0抢购，1拼团，2砍价，3集卡，4普通，10优惠券,6免单
		////1普通，2砍价，3拼团，4抢购，5预约
		$distribution->ordertype = 1;
		$distribution->settlecommission();
            /*======分销使用======*/

        echo json_encode($orderinfo);
    }


    /************************************************砍价*****************************************************/
    //获取砍价的
    public function doPageKanjia(){
        global $_GPC, $_W;
        $new = date('Y-m-d H:i:s',time());
//        echo json_encode($new);die;
        $build_id = $_GPC['build_id']; // 门店id
        $res = pdo_getall('wnjz_sun_new_bargain',array('uniacid'=>$_W['uniacid'],'status'=>2,'endtime >'=>$new,'num >'=>0,'build_id'=>$build_id));
        // 获取砍主数据
        $data = pdo_getall('wnjz_sun_user_bargain',array('uniacid'=>$_W['uniacid'],'mch_id'=>0));
        foreach ($res as $key => $value) {
            $res[$key]['endtime']=strtotime($value['endtime'])*1000;
            $res[$key]['gname']=$value['gname'];
            $res[$key]['id']=$value['id'];
            $res[$key]['marketprice']=$value['marketprice'];
            $res[$key]['pic']=$value['pic'];
            $res[$key]['shopprice']=$value['shopprice'];
            $res[$key]['clock']='';
            $res[$key]['part_num']= count(pdo_getall('wnjz_sun_user_bargain',array('uniacid'=>$_W['uniacid'],'mch_id'=>0,'kid'=>$value['id'])));
            foreach ($data as $k=>$v){
                if($v['kid']==$value['id']){
                    $res[$key]['openid'][$k][] = $v['openid'];
                }
            }
        }

        if($res[$key]['openid']!=''){
			foreach ($res as $k=>$v){
            foreach ($res[$k]['openid'] as $kk=>$vv){
                $res[$k]['mch_img'][$kk][] = pdo_getcolumn('wnjz_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$vv),'img');
            }
        }
		}
		
        echo json_encode($res);
    }

    //点击购买之后
    public function doPageBargainInfo(){
        global $_GPC,$_W;
        $data = pdo_get('wnjz_sun_new_bargain',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        echo json_encode($data);
    }

    //获取砍价的banner
    public function doPageKanBanner(){
        global $_GPC, $_W;
        $banner=pdo_get('wnjz_sun_kanjia_banner',array('uniacid'=>$_W['uniacid']));
        echo  json_encode($banner);
    }


    //查询是否砍主已经有砍了
    public function doPageiskanjia(){
        global $_GPC, $_W;
        //查询是否已经砍价了
        $openid =$_GPC['openid'];
        $sql='select * from'.tablename('wnjz_sun_user_bargain').'where uniacid='.$_W['uniacid'].' and openid='."'$openid'".' and  kid ='.$_GPC['id'].' and mch_id=0';
        $res = pdo_fetch($sql);
        if($res){
            $re['status']=1;
        }else{
            $re['status']=0;
        }
        echo json_encode($re);
    }

    //好友信息
    public function doPageFriendsInfo(){
        global $_GPC, $_W;
        //先查询砍主
        $openid = $_GPC['openid'];
        $kanzhu = pdo_get('wnjz_sun_user_bargain',array('uniacid'=>$_W['uniacid'],'mch_id'=>0,'kid'=>$_GPC['id'],'openid'=>$_GPC['userid']));
        $data = pdo_getall('wnjz_sun_user_bargain',array('uniacid'=>$_W['uniacid'],'kid'=>$_GPC['id'],'mch_id'=>$kanzhu['id']));
        foreach ($data as $k=>$v){
            $data[$k]['img'] = pdo_getcolumn('wnjz_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),'img');
        }
        return $this->result(0,'',$data);
    }
    //将砍价的信息传到后台去
    public function doPageKanjiaorder(){
        global $_GPC, $_W;
        $openid = $_GPC['openid'];
        $id = $_GPC['id'];//商品ID
        $bargainDetails = pdo_get('wnjz_sun_new_bargain', array('uniacid' => $_W['uniacid'], 'id' => $id));//砍价的商品
        //成为砍主
        $data['price'] = $bargainDetails['marketprice'];//商品的价格
        $data['kanjia'] = 0;
        $data['kid'] = $id;
        $data['openid'] = $openid;
        $data['mch_id'] = 0;//为砍主
        $data['status'] = 1;
        $data['uniacid'] = $_W['uniacid'];
        $data['add_time'] = time();
        $res = pdo_insert('wnjz_sun_user_bargain', $data);
        //查询砍主
        $bargain = pdo_get('wnjz_sun_user_bargain', array('uniacid' => $_W['uniacid'], 'mch_id' => 0, 'kid' => $id, 'openid' => $openid));
        //获取砍价的百分比
        $bargainprice = pdo_get('wnjz_sun_system', array('uniacid' => $_W['uniacid']));
        $person = $bargainprice['bargain_price'] * 0.01;
        $price =round(($bargain['price'] - $bargainDetails['shopprice']) * $person,2);

        $datas['price'] = $bargainDetails['marketprice'] - $price;
        $datas['kanjia'] = $price;
        $res = pdo_update('wnjz_sun_user_bargain', $datas, array('uniacid' => $_W['uniacid'], 'kid' => $id, 'openid' => $_GPC['openid'], 'mch_id' => 0));
        echo json_encode($price);
        //查询商品价格
//        $retu = pdo_get('wnjz_sun_bargain',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
//        $data['kid'] =$_GPC['id'];
//        $data['openid'] =$_GPC['openid'];
////        $data['mch_id'] = 0;//为砍主
//        $data['status']=1;
//
//      if($retu['marketprice']-$retu['shopprice']>=1000){
//          $price=rand(100,200);
//      }elseif ($retu['marketprice']-$retu['shopprice']<=1000 &&$retu['marketprice']-$retu['shopprice']>500 ){
//          $price=rand(80,100);
//      }elseif ($retu['marketprice']-$retu['shopprice']<=500 &&$retu['marketprice']-$retu['shopprice']>100 ){
//          $price=rand(50,80);
//      } elseif ($retu['marketprice']-$retu['shopprice']<=100 &&$retu['marketprice']-$retu['shopprice']>50 ){
//          $price=rand(30,50);
//      }elseif ($retu['marketprice']-$retu['shopprice']<=50 &&$retu['marketprice']-$retu['shopprice']>30 ){
//          $price=rand(10,20);
//      }elseif ($retu['marketprice']-$retu['shopprice']<=30 &&$retu['marketprice']-$retu['shopprice']>10 ){
//          $price=rand(3,7);
//      }elseif ($retu['marketprice']-$retu['shopprice']<=10 &&$retu['marketprice']-$retu['shopprice']>5 ){
//          $price=rand(2,4);
//      }elseif ($retu['marketprice']-$retu['shopprice']<=5 &&$retu['marketprice']-$retu['shopprice']>1 ){
//          $price=rand(0.5,1);
//      }else{
//          $price=0.01;
//      }


//        $data['uniacid']=$_W['uniacid'];
//        $data['price']=$retu['marketprice']-$price;
//        $data['kanjia']=$price;
//        $data['add_time']=time();
//        $res = pdo_insert('wnjz_sun_kanjia',$data,array('uniacid'=>$_W['uniacid']));
//        //以上存储砍价的信息
//        //以下查询数据
//        $openid =$_GPC['openid'];
//        $rulute = "select a.*,b.name,b.img  from".tablename('wnjz_sun_kanjia').'a left join'.tablename('wnjz_sun_user').'b on b.openid =a.openid where a.status=1 and a.kid='.$_GPC['id']." and a.mch_id=0 and a.openid="."'$openid'";
//           $list=pdo_fetch($rulute);
//           $list['kanja']=$price;
//          $list['yushu']=($list['kanjia']/($retu['marketprice']-$retu['shopprice']))*100;

//        echo json_encode($list);

    }
    //列出砍住的信息
    public function doPagekanzhu(){
        global $_GPC, $_W;
        $openid=$_GPC['openid'];
        $res ='select a.*,c.marketprice, c.shopprice  from'.tablename('wnjz_sun_user_bargain').'a left join'.tablename('wnjz_sun_new_bargain').'c on c.id=a.kid where a.uniacid='.$_W['uniacid'].' and a.openid='."'$openid'".' and a.kid='.$_GPC['id'];
        $re=pdo_fetch($res);
//        $re['yushu']=($re['kanjia']/($re['marketprice']-$re['shopprice']))*100;
        $re['yushu'] = ($re['kanjia']/$re['marketprice']) * 100;
        echo json_encode($re);
    }

    //砍价详情页
    public function doPagekanjiade(){
        global $_GPC, $_W;
        $data['kid'] =$_GPC['id'];
        $retu = pdo_get('wnjz_sun_new_bargain',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

		$now = time();

		$endtime = strtotime($retu['endtime']);
		$starttime = strtotime($retu['starttime']);

		if($now > $endtime){
			$retu['status'] = 1; //活动结束
		}
		if($now > $starttime && $now <$endtime){
			$retu['status'] = 0; //活动增在进行
		}
		if($now < $endtime){
			$retu['status'] = 2; //活动未开始
		}
        echo json_encode($retu);
    }
    //用户砍价
    public function doPageshuju()
    {
        global $_GPC, $_W;
        $openid = $_GPC['openid'];
        $id = $_GPC['id'];
        //先查询砍主
        $res = 'SELECT a.price,a.kanjia,b.marketprice,b.shopprice ,a.kid   FROM ' . tablename('wnjz_sun_kanjia') . 'a left join '.tablename('wnjz_sun_bargain').'b on b.id=a.kid WHERE a.id=' . $id;
        $re = pdo_fetch($res);
        if($re['price']-$re['shopprice']>1000){
            $price=rand(100,200);
        }elseif ($re['price']-$re['shopprice']<1000 &&$re['price']-$re['shopprice']>500 ){
            $price=rand(80,100);
        }elseif ($re['price']-$re['shopprice']<500 &&$re['price']-$re['shopprice']>100 ){
            $price=rand(50,80);
        } elseif ($re['price']-$re['shopprice']<100 &&$re['price']-$re['shopprice']>50 ){
            $price=rand(30,50);
        }elseif ($re['price']-$re['shopprice']<50 &&$re['price']-$re['shopprice']>30 ){
            $price=rand(10,20);
        }elseif ($re['price']-$re['shopprice']<30 &&$re['price']-$re['shopprice']>10 ){
            $price=rand(3,7);
        }elseif ($re['price']-$re['shopprice']<10 &&$re['price']-$re['shopprice']>5 ){
            $price=rand(2,4);
        }elseif ($re['price']-$re['shopprice']<5 &&$re['price']-$re['shopprice']>1 ){
            $price=rand(0.5,0.8);
        }

        $datas['price']=$re['price']-$price;
        $datas['kanjia']=$re['kanjia']+$price;
        $res = pdo_update('wnjz_sun_kanjia',$datas,array('uniacid'=>$_W['uniacid'],'id'=>$id));
        $data['price']=0;
        $data['kanjia']=$price;
        $data['kid'] =$re['kid'];
        $data['openid'] =$_GPC['openid'];
        $data['mch_id'] = $id;//为砍主
        $data['status']=1;
        $data['uniacid']=$_W['uniacid'];
        $data['kanjia']=$price;
        $data['add_time']=time();
        $res = pdo_insert('wnjz_sun_kanjia',$data,array('uniacid'=>$_W['uniacid']));
        echo json_encode($price);;
    }
    //帮你找出有对多少人已经帮你砍过价了
    public function doPageHelp(){
        global $_GPC, $_W;
        $openid = $_GPC['openid'];//好友ID
        $id = $_GPC['id']; //商品id
        $userid = $_GPC['userid'];//砍主id
        $req_timestamp  = $_GPC['timestamp'];//1525141312581
        $current_timestamp = time();//1525141313
        $t = $_GPC['t'];

        $key = 'alsjdlqkwjlke123654!@#!@81903890';
        $my_t = base64_encode($req_timestamp . '???' . $key);
        if ($current_timestamp - 5 > ($req_timestamp/1000)){
            return $this->result(1, '请勿重复请求！', null);
        }
        if ($my_t !== $t)  return $this->result(1, '非法请求！', null);
        //获取商品
        $bargainDetails = pdo_get('wnjz_sun_new_bargain', array('uniacid' => $_W['uniacid'], 'id' => $id));
        //先查询砍主
        $master = pdo_get('wnjz_sun_user_bargain', array('mch_id' => '0', 'kid' =>$id, 'openid' => $userid));
        //获取砍价的百分比
        $bargainprice = pdo_get('wnjz_sun_system', array('uniacid' => $_W['uniacid']));
        $person = $bargainprice['bargain_price'] * 0.01;
        $price = round(($master['price'] - $bargainDetails['shopprice']) * $person,2);//（70.48-8）* 0.08

        //好友帮忙砍价 存进数据表
        $data['price'] = $master['price'] - $price;
        $data['kanjia'] = $price;
        $data['kid'] = $_GPC['id'];
        $data['openid'] = $_GPC['openid'];
        $data['mch_id'] = $master['id'];//帮谁砍的ID
        $data['status'] = 1;
        $data['uniacid'] = $_W['uniacid'];
        $data['add_time'] = time();
        $res = pdo_insert('wnjz_sun_user_bargain', $data);

        //修改砍主的信息
        $datas['price'] = $master['price'] - $price;
        $datas['kanjia'] = $master['kanjia'] + $price;
        $res = pdo_update('wnjz_sun_user_bargain', $datas, array('id' => $master['id']));

        return $this->result(0, '', $price);



//        $res = 'SELECT a.price,a.kanjia,b.marketprice,b.shopprice ,a.kid   FROM ' . tablename('wnjz_sun_kanjia') . 'a left join '.tablename('wnjz_sun_bargain').'b on b.id=a.kid WHERE a.id=' . $id;
//        $data = pdo_fetch($res);
//        if($data['price']-$data['shopprice']>1000){
//            $price=rand(100,200);
//        }elseif ($data['price']-$data['shopprice']<=1000 &&$data['price']-$data['shopprice']>500 ){
//            $price=rand(80,100);
//        }elseif ($data['price']-$data['shopprice']<=500 &&$data['price']-$data['shopprice']>100 ){
//            $price=rand(30,80);
//        } elseif ($data['price']-$data['shopprice']<=100 &&$data['price']-$data['shopprice']>50 ){
//            $price=rand(15,20);
//        }elseif ($data['price']-$data['shopprice']<=50 &&$data['price']-$data['shopprice']>30 ){
//            $price=rand(5,10);
//        }elseif ($data['price']-$data['shopprice']<=30 &&$data['price']-$data['shopprice']>10 ){
//            $price=rand(2,5);
//        }elseif ($data['price']-$data['shopprice']<=10 &&$data['price']-$data['shopprice']>5 ){
//            $price=rand(1,2);
//        }elseif ($data['price']-$data['shopprice']<=5 &&$data['price']-$data['shopprice']>1 ){
//            $price=rand(0.5,0.8);
//        }else{
//            $price=0.01;
//        }
//        //修改砍主数据
//        $datas['price']=$data['price']-$price;
//        $datas['kanjia']=$data['kanjia']+$price;
//        $list = pdo_update('wnjz_sun_kanjia',$datas,array('uniacid'=>$_W['uniacid'],'id'=>$id));
//        $hkanjia['price']=0;
//        $hkanjia['kid'] =$data['kid'];
//        $hkanjia['openid'] =$_GPC['openid'];
//        $hkanjia['mch_id'] = $id;//为砍主
//        $hkanjia['status']=1;
//        $hkanjia['uniacid']=$_W['uniacid'];
//        $hkanjia['kanjia']=$price;
//        $hkanjia['add_time']=time();
//        $list = pdo_insert('wnjz_sun_kanjia',$hkanjia,array('uniacid'=>$_W['uniacid']));
//        echo $price;
    }
    //付款改变订单状态
    public function doPagePaykjOrder()
    {
        global $_W, $_GPC;
        //获取订单信息
        $datas['status'] = 3;
		$datas['paytime'] = time();
		$paytype = $_GPC['paytype'];
		if($paytype==1){//微信
			$datas['paytype'] = 1;
		}else{//余额
			$datas['paytype'] = 2;
		}
		
		$res = pdo_update('wnjz_sun_kjorder',$datas, array('id' => $_GPC['order_id'],'uniacid' => $_W['uniacid']));

		if($res){
			// 获取平台打印
			$orderinfos = pdo_get('wnjz_sun_kjorder', array('id' => $_GPC['order_id'], 'uniacid' => $_W['uniacid']));
			$print = pdo_get('wnjz_sun_printing',array('uniacid'=>$_W['uniacid']));
			if($print['is_open']==1){
				$this->KjPrinting($orderinfos['id'],$orderinfos['build_id']);
			}

			// 调用短信接口
			// 平台数据
			$sms = pdo_get('wnjz_sun_sms',array('uniacid'=>$_W['uniacid']));
			// 个人号码
			$mobile = pdo_getcolumn('wnjz_sun_servies',array('uniacid'=>$_W['uniacid'],'sid'=>$orderinfos['sid']),'mobile');
			$phone = array(
				0=>$sms['mobile'],//平台号码
				1=>$mobile //个人号码
			);
			if($sms['is_open']==1){
				foreach ($phone as $k=>$v){
					$this->Shortmessage($v);
				}
			}
		}
    }

	// 砍价打印
    function KjPrinting($order_id,$build_id)
    {
        global $_W,$_GPC;
        header("Content-type: text/html; charset=utf-8");
        include 'HttpClient.class.php';

        // 获取订单数据
        $sql = ' SELECT o.*,b.gname,ol.num FROM ' . tablename('wnjz_sun_kjorder') . ' o ' . ' JOIN ' . tablename('wnjz_sun_kjorderlist') . ' ol ' . ' ON o.id=ol.order_id JOIN '. tablename('wnjz_sun_new_bargain') . ' b ON b.id=ol.oid WHERE o.uniacid=' . $_W['uniacid'] . ' AND o.id=' . $order_id;
        $order = pdo_fetch($sql);
        
		//$order['gname'] = pdo_getcolumn('wnjz_sun_new_bargain',array('uniacid'=>$_W['uniacid'],'id'=>$order['gid']),'gname');
        $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
        $order['address'] = $order['provinceName'] . $order['cityName'] . $order['countyName'] . $order['detailInfo'];

        $printing = pdo_get('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$build_id));
        $build_name = $printing['name'];

        define('USER', $printing['user']);	//*必填*：飞鹅云后台注册账号
        define('UKEY', $printing['key']);	//*必填*: 飞鹅云注册账号后生成的UKEY
        define('SN', $printing['sn']);	    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API


        //以下参数不需要修改
        define('IP','api.feieyun.cn');			//接口IP或域名
        define('PORT',80);						//接口IP端口
        define('PATH','/Api/Open/');		//接口路径
        define('STIME', time());			    //公共参数，请求时间
        define('SIG', sha1(USER.UKEY.STIME));   //公共参数，请求公钥

        $orderInfo = '<CB>'.$build_name.'</CB><BR>';
        $orderInfo .= '服务名称:　　　　　'.$order['gname'].'<BR>';
        $orderInfo .= '预约时间:　　　　'.$order['time'].'<BR>';
        $orderInfo .= '支付金额:　　　　   　　'.$order['money'].'<BR>';
        $orderInfo .= '数量:　　　　 　　　　　'.$order['num'].'<BR>';
        $orderInfo .= '地址:　　　'.$order['address'].'<BR>';
        $orderInfo .= '联系号码:　　　　　'.$order['telNumber'].'<BR>';
        $orderInfo .= '联系人:　　　　　　　　'.$order['name'].'<BR>';
        $orderInfo .= '备注：　　　　'.$order['text'].'<BR>';
        $orderInfo .= '----------------------------------------------<BR>';
        $orderInfo .= '订单编号：　　'.$order['orderNum'].'<BR>';

		//打开注释可测试
        $this->wp_print(SN,$orderInfo,1);

    }

    //查询是否已经帮忙砍价过
    public function doPageIsHelp(){
        global $_GPC,$_W;
        $openid = $_GPC['userid'];
        $kanzhu = pdo_get('wnjz_sun_user_bargain', array('openid' => $_GPC['userid'], 'kid' => $_GPC['id'], 'mch_id' => 0));
        $helpInfo = pdo_getall('wnjz_sun_user_bargain', array('openid' => $_GPC['openid'], 'mch_id' => $kanzhu['id']));
        return $this->result(0,'', $helpInfo);
    }


    //查询是否已经最低价
    public function doPageLittleMoney(){
        global $_GPC,$_W;
        $goods = pdo_get('wnjz_sun_new_bargain',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        $data = pdo_get('wnjz_sun_user_bargain',array('uniacid'=>$_W['uniacid'],'mch_id'=>0,'kid'=>$_GPC['id'],'openid'=>$_GPC['userid']));

		//当前时间
		$time = time();
		//活动截止时间
		$endtime = strtotime($goods['endtime']);
		if($time>$endtime){
			echo 3;//活动截止
		}else{
			if($goods['shopprice']>=$data['price']){
				echo 1;//最低价
			}else{
				echo 2;
			}
		}
    }




//订单未完成砍价订单
//
    public function doPagezzkanjia(){
        global $_GPC, $_W;
        $openid=$_GPC['openid'];
        $sql ='select *  from'.tablename('wnjz_sun_user_bargain').'a left join'.tablename('wnjz_sun_new_bargain').'b on b.id=a.kid where a.uniacid='.$_W['uniacid'].' and a.openid='."'$openid'".' and a.status=1 and a.kid<>0 and mch_id=0';
        $res=pdo_fetchall($sql);

		$re = [];
		$time = time();
		foreach($res as $k=>$v){
			$endtime = strtotime($v['endtime']);
			if($time <= $endtime){
				$re[] = $v;
			}
		}
        echo json_encode($re);
    }
    //分享出去的砍价订单
    public function doPagesharkj(){
        global $_GPC, $_W;
//        $openid=$_GPC['openid'];
//        $openid = $_GPC['userid'];
//        $res ='select a.kid,a.id,b.gname,b.pic,b.shopprice,b.num,a.price from'.tablename('wnjz_sun_new_bargain').'a left join'.tablename('wnjz_sun_user_bargain').'b on b.id=a.kid where a.uniacid='.$_W['uniacid'].' and  a.kid='.$_GPC['id'].' and openid='."'$openid'";
        $bargain = pdo_get('wnjz_sun_new_bargain', array('id' => $_GPC['id'], 'uniacid' => $_W['uniacid']));
        return $this->result(0,'',$bargain);
    }
    //查询砍主
    public function doPageBargainMaster()
    {
        global $_GPC, $_W;
        $openid = $_GPC['openid'];
        $userInfo = pdo_get('wnjz_sun_user', array('openid' => $openid, 'uniacid' => $_W['uniacid']));
        return $this->result(0, '', $userInfo);
    }

    //查看是否有已经砍过了东西
    public function doPageisskanjia(){
        global $_GPC, $_W;
        //查询是否已经砍价了
        $openid =$_GPC['openid'];
        $sql='select * from'.tablename('wnjz_sun_kanjia').'where uniacid='.$_W['uniacid'].' and openid='."'$openid'".' and  gid ='.$_GPC['id'].' and mch_id=0';
        $res = pdo_fetch($sql);
        if($res){
            $re['status']=1;
        }else{
            $re['status']=0;
        }
        echo json_encode($res);
    }




//已完成的砍价订单
    public function doPageywckj(){
		global $_GPC, $_W;
        $openid=$_GPC['openid'];
        $sql ='select *  from'.tablename('wnjz_sun_user_bargain').'a left join'.tablename('wnjz_sun_new_bargain').'b on b.id=a.kid where a.uniacid='.$_W['uniacid'].' and a.openid='."'$openid'".' and a.status=1 and a.kid<>0 and mch_id=0';
        $res=pdo_fetchall($sql);

		$re = [];
		$time = time();
		foreach($res as $k=>$v){
			$endtime = strtotime($v['endtime']);
			if($time > $endtime){
				$re[] = $v;
			}
		}
        echo json_encode($re);
    }

    //系统设置
    public function doPageSystem(){
        global $_W, $_GPC;
        $res=pdo_get('wnjz_sun_system',array('uniacid'=>$_W['uniacid']));

        echo json_encode($res);
    }
//公告列表
    public function doPageNews(){
        global $_GPC, $_W;
        $where=" where uniacid=:uniacid and state=1";
        if($_GPC['cityname']){
            $where.=" and cityname LIKE  concat('%', :name,'%')";
            $data[':name']=$_GPC['cityname'];
        }
        $data[':uniacid']=$_W['uniacid'];
        $sql="select * from ".tablename('wnjz_sun_news').$where." order by num asc";
        $res=pdo_fetchall($sql,$data);
        echo json_encode($res);
    }
    //公告详情
    public function doPageNewsInfo(){
        global $_W, $_GPC;
        $res=pdo_get('wnjz_sun_news',array('id'=>$_GPC['id']));
        echo json_encode($res);
    }


    /***************************************************************************************/
//渲染订单的
    public function doPagekjirder(){
        global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $res ='select *  from'.tablename('wnjz_sun_new_bargain').'a left join'.tablename('wnjz_sun_user_bargain').'b on b.id=a.kid where a.uniacid='.$_W['uniacid'].' and a.openid='."'$openid'".' and a.kid='.$_GPC['id'].' and a.mch_id=0';
        $re=pdo_fetch($res);
        echo json_encode($re);
    }

    // 判断该用户是否购买过该砍价商品
    public function doPageisBuyKjgoods()
    {
        global $_GPC,$_W;
        $openid = $_GPC['openid']; // 用户id
        $id = $_GPC['id'];// 砍价id
        $data = pdo_get('wnjz_sun_kjorderlist',array('uniacid'=>$_W['uniacid'],'oid'=>$id,'openid'=>$openid));
        
		$goods = pdo_get('wnjz_sun_new_bargain',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
		//当前时间
		$time = time();
		//活动截止时间
		$endtime = strtotime($goods['endtime']);
		if($time>$endtime){
			$res = 3;//活动截止
		}else{
			if($data){
				$res = 1;
			}else{
				$res = 2;
			}
		}
				
        echo json_encode($res);
    }



//加入购物单订单的
    public function doPageAddkanjiaorder(){
        global $_W, $_GPC;
        $build_id = $_GPC['build_id']; // 门店id
        $data['cityName']=$_GPC['cityName'];
        $data['time']=$_GPC['time'];
        $sn = time() . mt_rand(100, 999);
        $data['orderNum'] = $sn;
        //   $data['num']=$_GPC['num'];
        $data['detailInfo']=$_GPC['detailInfo'];
        $data['telNumber']=$_GPC['telNumber'];
        $data['countyName']=$_GPC['countyName'];
        $data['text']=$_GPC['text'];
        $data['provinceName']=$_GPC['provinceName'];
        $data['name']=$_GPC['name'];
        $data['openid']=$_GPC['openid'];
        $data['uniacid']=$_W['uniacid'];
        $data['addtime']=time();
        $data['money']=$_GPC['price'];
        $data['build_id'] = $build_id;
        $data['status']=2;
        $data['type'] = $_GPC['buy_type'];
		$data['paytype'] = 2;
        $id=$_GPC['id'];//商品ID
        if($_GPC['buy_type']==2){
            $sid = pdo_getcolumn('wnjz_sun_new_bargain',array('uniacid'=>$_W['uniacid'],'id'=>$id),'sid');
        }else{
            $sid = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$id),'sid');
        }
        $data['sid'] = $sid;
//        echo json_encode($data);die;
//        /*********修改优惠券的状态**********/


        $res=pdo_get('wnjz_sun_new_bargain',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        $da['num']=$res['num']-1;
        $s=pdo_update('wnjz_sun_new_bargain',$da,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        $re=pdo_insert('wnjz_sun_kjorder',$data);
		$g_order_id = pdo_insertid();
        if(intval($g_order_id)<=0){
            return $this->result(1,'数据提交失败，请重新提交,0002', array());
        }
        if($re) {
            $uniacid = $_W['uniacid'];
            $openid = $_GPC['openid'];
            $where = " where openid ='$openid' AND uniacid =$uniacid";
            $sql = "SELECT * FROM " . tablename('wnjz_sun_kjorder') . $where . " ORDER BY id DESC";
            $retule = pdo_fetch($sql);
            $order['openid'] = $_GPC['openid'];
            $order['order_id'] = $retule['id'];
            $order['uniacid'] = $_W['uniacid'];
            $order['createTime'] = time();
            $order['oid'] = $_GPC['id'];
            $order['num'] =1;

            $orde = pdo_insert('wnjz_sun_kjorderlist', $order);
        }

		//========计算分销佣金 S===========
        include_once IA_ROOT . '/addons/wnjz_sun/inc/func/distribution.php';
        $distribution = new Distribution();
        $distribution->order_id = $g_order_id;
        $distribution->money = $_GPC['price'];
        $distribution->userid = $_GPC['openid'];
        $distribution->ordertype = 2;
        $distribution->computecommission();
        //========计算分销佣金 E===========

        //echo $retule['id'];
		echo json_encode($g_order_id);
    }

//余额付款
    public function doPagekjLocal(){
        global $_W, $_GPC;
        //获取订单信息
        $openid = $_GPC['openid'];
        $price=$_GPC['price'];
        $sql="select * from".tablename('wnjz_sun_user')."where uniacid=".$_W['uniacid']." and openid="."'$openid'";
        $orderinfo = pdo_fetch($sql);
        if($orderinfo['money']-$price >=0 ){
            $order['money']=$orderinfo['money']-$_GPC['price'];
            $data = pdo_update('wnjz_sun_user',$order,array('uniacid'=>$_W['uniacid'],'id'=>$orderinfo['id']));
            if($data){
                $retu['status']=1;
            }
        }else{
            $retu['status']=2;
        }


        echo json_encode($retu);
    }


    // 服务订单
    public function doPagekjOrrde(){
        global $_GPC, $_W;
        $userid=$_GPC['userid'];
        $build_id = $_GPC['build_id']; // 门店id
        $where = " WHERE  a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.openid="."'$userid'"." and a.type=2 order by a.id desc";
        $sql = "select * from ".tablename('wnjz_sun_kjorder')."a left join ".tablename('wnjz_sun_kjorderlist')."b on b.order_id=a.id".$where;
        $lit=pdo_fetchall($sql);
        $lits=array();
        foreach ($lit as $k =>$v){
            $id = $v['oid'];
            $wher="WHERE id=$id AND uniacid =".$_W['uniacid'];
            $val ="select * from ".tablename("wnjz_sun_new_bargain").$wher;
            $valu= pdo_fetch($val);
            $lits[$k]['money']=$v['money'];
            $lits[$k]['gname']=$valu['gname'];
            $lits[$k]['order_id']=$v['order_id'];
            $lits[$k]['pic']=$valu['pic'];
            $lits[$k]['orderNum']=$v['orderNum'];
            $lits[$k]['telNumber']=$v['telNumber'];
            $lits[$k]['name']=$v['name'];
            $lits[$k]['num']=$v['num'];
            $lits[$k]['time']=$v['time'];
            $lits[$k]['detailInfo']=$v['detailInfo'];
            $lits[$k]['countyName']=$v['countyName'];
            $lits[$k]['provinceName']=$v['provinceName'];
            $lits[$k]['status']=$v['status'];
			$lits[$k]['isrefund']=$v['isrefund'];
        }


        echo json_encode($lits);
    }

    //待服务的
    public function doPagekjdafuwu(){
        global $_GPC, $_W;
        $userid=$_GPC['userid'];
        $build_id = $_GPC['build_id']; // 门店id
        $where = " WHERE a.status = 3 and a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.oprnid="."'$userid'";
        $sql = "select * from ".tablename('wnjz_sun_order')."a left join ".tablename('wnjz_sun_orderlist')."b on b.order_id=a.oid".$where;
        $lit=pdo_fetchall($sql);
        $lits=array();
        foreach ($lit as $k =>$v){
            $gid = $v['gid'];
            $wher="WHERE gid=$gid  AND uniacid =".$_W['uniacid'];
            $val ="select * from ".tablename("wnjz_sun_goods").$wher;
            $valu= pdo_fetch($val);
            $lits[$k]['money']=$v['money'];
            $lits[$k]['gname']=$valu['gname'];
            $lits[$k]['oid']=$v['oid'];
            $lits[$k]['pic']=$valu['pic'];
            $lits[$k]['orderNum']=$v['orderNum'];
            $lits[$k]['telNumber']=$v['telNumber'];
            $lits[$k]['name']=$v['name'];
            $lits[$k]['num']=$v['num'];
            $lits[$k]['time']=$v['time'];
            $lits[$k]['detailInfo']=$v['detailInfo'];
            $lits[$k]['countyName']=$v['countyName'];
            $lits[$k]['provinceName']=$v['provinceName'];
            $lits[$k]['status']=$v['status'];

        }


        echo json_encode($lits);
    }
    //待支付
    public function doPagekjdazhifu(){
        global $_GPC, $_W;
        $userid=$_GPC['userid'];
        $build_id = $_GPC['build_id']; // 门店id
        $where = " WHERE a.status = 2 and a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.openid="."'$userid'"." and a.type=2 order by a.id desc";
        $sql = "select * from ".tablename('wnjz_sun_kjorder')."a left join ".tablename('wnjz_sun_kjorderlist')."b on b.order_id=a.id".$where;
        $lit=pdo_fetchall($sql);
        $lits=array();
        foreach ($lit as $k =>$v){
            $id = $v['oid'];
            $wher="WHERE id=$id AND uniacid =".$_W['uniacid'];
            $val ="select * from ".tablename("wnjz_sun_new_bargain").$wher;
            $valu= pdo_fetch($val);
            $lits[$k]['gname']=$valu['gname'];
            $lits[$k]['money']=$v['money'];
            $lits[$k]['order_id']=$v['order_id'];
            $lits[$k]['pic']=$valu['pic'];
            $lits[$k]['orderNum']=$v['orderNum'];
            $lits[$k]['telNumber']=$v['telNumber'];
            $lits[$k]['name']=$v['name'];
            $lits[$k]['num']=$v['num'];
            $lits[$k]['time']=$v['time'];
            $lits[$k]['detailInfo']=$v['detailInfo'];
            $lits[$k]['countyName']=$v['countyName'];
            $lits[$k]['provinceName']=$v['provinceName'];
            $lits[$k]['status']=$v['status'];

        }


        echo json_encode($lits);
    }
    //待确认
    public function doPagekjdaqueren(){
        global $_GPC, $_W;
        $userid=$_GPC['userid'];
        $build_id = $_GPC['build_id']; // 门店id
        $where = " WHERE a.status =3 and a.uniacid=".$_W['uniacid']." and a.build_id=".$build_id." and a.openid="."'$userid'" ." and a.type=2 order by a.id desc";
        $sql = "select * from ".tablename('wnjz_sun_kjorder')."a left join ".tablename('wnjz_sun_kjorderlist')."b on b.order_id=a.id".$where;
        $lit=pdo_fetchall($sql);
        $lits=array();
        foreach ($lit as $k =>$v){
            $id = $v['oid'];
            $wher="WHERE id=$id AND uniacid =".$_W['uniacid'];
            $val ="select * from ".tablename("wnjz_sun_new_bargain").$wher;
            $valu= pdo_fetch($val);
            $lits[$k]['gname']=$valu['gname'];
            $lits[$k]['money']=$v['money'];
            $lits[$k]['order_id']=$v['order_id'];
            $lits[$k]['pic']=$valu['pic'];
            $lits[$k]['orderNum']=$v['orderNum'];
            $lits[$k]['telNumber']=$v['telNumber'];
            $lits[$k]['name']=$v['name'];
            $lits[$k]['num']=$v['num'];
            $lits[$k]['time']=$v['time'];
            $lits[$k]['detailInfo']=$v['detailInfo'];
            $lits[$k]['countyName']=$v['countyName'];
            $lits[$k]['provinceName']=$v['provinceName'];
            $lits[$k]['status']=$v['status'];
			$lits[$k]['isrefund']=$v['isrefund'];
        }
        echo json_encode($lits);
    }

    //待确认
    public function doPageovercome(){
        global $_GPC, $_W;
        $userid=$_GPC['userid'];
        $where = " WHERE a.status =5 and a.uniacid=".$_W['uniacid']." and a.openid="."'$userid'" ." and a.type=2 order by a.id desc";
        $sql = "select * from ".tablename('wnjz_sun_kjorder')."a left join ".tablename('wnjz_sun_kjorderlist')."b on b.order_id=a.id".$where;
        $lit=pdo_fetchall($sql);
        $lits=array();
        foreach ($lit as $k =>$v){
            $id = $v['oid'];
            $wher="WHERE id=$id AND uniacid =".$_W['uniacid'];
            $val ="select * from ".tablename("wnjz_sun_new_bargain").$wher;
            $valu= pdo_fetch($val);
            $lits[$k]['gname']=$valu['gname'];
            $lits[$k]['money']=$v['money'];
            $lits[$k]['order_id']=$v['order_id'];
            $lits[$k]['pic']=$valu['pic'];
            $lits[$k]['orderNum']=$v['orderNum'];
            $lits[$k]['telNumber']=$v['telNumber'];
            $lits[$k]['name']=$v['name'];
            $lits[$k]['num']=$v['num'];
            $lits[$k]['time']=$v['time'];
            $lits[$k]['detailInfo']=$v['detailInfo'];
            $lits[$k]['countyName']=$v['countyName'];
            $lits[$k]['provinceName']=$v['provinceName'];
            $lits[$k]['status']=$v['status'];
        }
        echo json_encode($lits);
    }

//删除订单
    public function doPagekjOrderDelete(){
        global $_GPC, $_W;
        $res=pdo_delete('wnjz_sun_kjorder',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        echo json_encode($res);
    }
    //确认
    public function doPagekjOrderqueren(){
        global $_GPC, $_W;
        //获取订单信息
        $datas['status'] = 3;
		$datas['paytime'] = time();
		//$datas['id'] = $_GPC['id'];
		//var_dump($datas);die;
        $orderinfo = pdo_update('wnjz_sun_kjorder', $datas, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        echo json_encode($orderinfo);
		//echo json_encode($datas);	
    }

    //确认服务
    public function doPageToService(){
        global $_GPC, $_W;
        //获取订单信息
        $datas['status']=5;
        $orderinfo=pdo_update('wnjz_sun_kjorder',$datas,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

		/*======分销使用====== */
		include_once IA_ROOT . '/addons/wnjz_sun/inc/func/distribution.php';
		$distribution = new Distribution();
		$distribution->order_id = $_GPC['id'];
		$distribution->ordertype = 2;
		$distribution->settlecommission();
        /*======分销使用======*/

        echo json_encode($orderinfo);
    }

    //确认订单
    public function doPageconfiim(){
        global $_GPC, $_W;
        $sql="select * from ".tablename("wnjz_sun_goods")."where uniacid=".$_W['uniacid'].' and gid='.$_GPC['id'];
        $res=pdo_fetch($sql);
        echo json_encode($res);
    }


// 拼接图片路径
    public function doPageUrl(){
        global $_GPC, $_W;
        echo $_W['attachurl'];
    }
//url
    public function doPageUrl2(){
        global $_W, $_GPC;
        echo $_W['siteroot'];
    }

    //文章类别
    public function doPageArc(){
        global $_W, $_GPC;
        $sql="SELECT tname,tid FROM ".tablename('wnjz_sun_selectedtype').'where uniacid='.$_W['uniacid'];
        $result=pdo_fetchall($sql);
//        $lits=array();
//        foreach ($result as $k =>$v){
//            $lits[$k]['']=$valu['gname'];
//        }
        echo json_encode($result);
    }

//文章列表
    public function doPageArticle(){
        global $_W, $_GPC;
        $id=$_GPC['id'];
        if($id==0){
            $sql="SELECT * FROM ".tablename('wnjz_sun_selected').'where uniacid='.$_W['uniacid'].' and detele= 1';
        }else{
            $sql="SELECT * FROM ".tablename('wnjz_sun_selected').'where uniacid='.$_W['uniacid'].' and detele= 1 and ac_id='.$id;
        }
        $result=pdo_fetchall($sql);
        echo json_encode($result);
    }

    //文章默认
    public function doPageDefault(){
        global $_W, $_GPC;
        $sql="SELECT tname,tid FROM ".tablename('wnjz_sun_selectedtype').'where uniacid='.$_W['uniacid'];
        $data = pdo_fetch($sql);
        $id= $data['tid'];
        $sql1="SELECT * FROM ".tablename('wnjz_sun_selected').'where uniacid='.$_W['uniacid'].' and detele= 1';
        $result=pdo_fetchall($sql1);
        echo json_encode($result);
    }

    // 验证登录数据是否正确
    public function doPageisLogin()
    {
        global $_GPC,$_W;
        $account = $_GPC['account'];
        $password = $_GPC['password'];
        $admin = pdo_get('wnjz_sun_business_account',array('uniacid'=>$_W['uniacid'],'account'=>$account,'password'=>$password));
        if($admin){
            $res['r'] = 1;
        }else{
            $data = pdo_get('wnjz_sun_servies',array('uniacid'=>$_W['uniacid'],'login'=>$account,'password'=>$password));
            if($data){
                $res['r'] = 2;
                $res['id'] = $data['sid'];
            }else{
                $branch = pdo_get('wnjz_sun_adminstore',array('uniacid'=>$_W['uniacid'],'account'=>$account,'password'=>$password));
                if($branch){
                    $res['r'] = 3;
                    $res['id'] = $branch['build_id'];
                }else{
                    $res['r'] = 4;
                }
            }
        }
        echo json_encode($res);
    }

    // 获取当前管理用户的数据
    public function doPageNowuser()
    {
        global $_W,$_GPC;
        $sid = $_GPC['sid'];
        $data = pdo_getall('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'sid'=>$sid));
        $count = array();
        foreach ($data as $k=>$v){
            if(date('Y-m-d',time())==date('Y-m-d',$v['addtime'])){
                $count['today'][] = $v;
            }else{
                $count['all'][] = $v;
            }
        }
        $count['today'] = count($count['today']);
        $count['all'] = count($count['all'])+$count['today'];
        echo json_encode($count);
    }

    // 进行订单核销
    public function doPageIsUserorder()
    {
        global $_W,$_GPC;
        $order_num = $_GPC['orderNum'];
        // 已付款
        $data = pdo_get('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'orderNum'=>$order_num,'status'=>3));
        if($data){
            $res = pdo_update('wnjz_sun_order',array('status'=>5),array('uniacid'=>$_W['uniacid'],'orderNum'=>$order_num));
        }else{
            $res = 0;
        }

        echo json_encode($res);
    }

    // 获取待接待订单
    public function doPageReception()
    {
        global $_GPC,$_W;
        $sid = $_GPC['sid'];
        $sql = ' SELECT * FROM ' . tablename('wnjz_sun_orderlist') . ' ol ' . ' JOIN ' . tablename('wnjz_sun_order') . ' o ' .' JOIN ' .tablename('wnjz_sun_goods') . ' g ' . ' ON ' . ' o.oid=ol.order_id' . ' AND ' . ' ol.gid=g.gid' . ' WHERE ' . ' o.sid='. $sid . ' AND ' . ' o.uniacid=' . $_W['uniacid'] . ' AND ' . ' o.status=3';
        $data = pdo_fetchall($sql);
        echo json_encode($data);
    }

    // 获取已完成订单
    public function doPageCompleted()
    {
        global $_GPC,$_W;
        $sid = $_GPC['sid'];
        $sql = ' SELECT * FROM ' . tablename('wnjz_sun_orderlist') . ' ol ' . ' JOIN ' . tablename('wnjz_sun_order') . ' o ' .' JOIN ' .tablename('wnjz_sun_goods') . ' g ' . ' ON ' . ' o.oid=ol.order_id' . ' AND ' . ' ol.gid=g.gid' . ' WHERE ' . ' o.sid='. $sid . ' AND ' . ' o.uniacid=' . $_W['uniacid'] . ' AND ' . ' o.status=5';
        $data = pdo_fetchall($sql);
        echo json_encode($data);
    }

    // 获取分类数据
    public function doPagecategory()
    {
        global $_GPC,$_W;
        $data = pdo_getall('wnjz_sun_category',array('uniacid'=>$_W['uniacid']));
        echo json_encode($data);
    }

    // 获取分类的所有数据
    public function doPagecateData()
    {
        global $_W,$_GPC;
        $build_id = $_GPC['build_id'];
        $sql = ' SELECT * FROM ' . tablename('wnjz_sun_goods') . ' g ' . ' JOIN ' . tablename('wnjz_sun_category') . ' c' . ' ON ' . ' g.cid=c.cid' . ' WHERE ' . ' g.uniacid=' . $_W['uniacid'];
        $data = pdo_fetchall($sql);
        $newRes = array();
        foreach ($data as $k=>$v){
            if(in_array($build_id,explode(',',$v['build_id']))){
                $newRes[$k] = $v;
            }
        }
        echo json_encode($newRes);
    }

    // 获取选中分类对应的数据
    public function doPageXzcate()
    {
        global $_W,$_GPC;
        $cid = $_GPC['cid'];
        $sql = ' SELECT * FROM ' . tablename('wnjz_sun_goods') . ' g ' . ' JOIN ' . tablename('wnjz_sun_category') . ' c' . ' ON ' . ' g.cid=c.cid' . ' WHERE ' . ' g.uniacid=' . $_W['uniacid'] . ' AND ' . ' g.cid='.$cid;

        $data = pdo_fetchall($sql);
        echo json_encode($data);
    }

    // 请求帮砍好友数据
    public function doPageHelpFriends()
    {
        global $_W,$_GPC;
        $id = $_GPC['id'];
        $openid = $_GPC['openid'];
        // 获取砍主的id
        $mch_id = pdo_getcolumn('wnjz_sun_user_bargain',array('uniacid'=>$_W['uniacid'],'kid'=>$id,'openid'=>$openid,'mch_id'=>0),'id');
        // 砍主数据
        $kanzhu = pdo_getall('wnjz_sun_user_bargain',array('uniacid'=>$_W['uniacid'],'id'=>$mch_id));
        // 获取好友数据
        $data = pdo_getall('wnjz_sun_user_bargain',array('uniacid'=>$_W['uniacid'],'kid'=>$id,'mch_id'=>$mch_id),'','','add_time DESC','3');
        $newData = array_merge($kanzhu,$data);
        foreach ($newData as $k=>$v){
            $newData[$k]['user_img'] = pdo_getcolumn('wnjz_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),'img');
        }
        echo json_encode($newData);
    }

    // 获取评价的订单
    public function doPageevaluateOrder()
    {
        global $_GPC,$_W;
        $oid = $_GPC['oid'];
        $openid = $_GPC['openid'];
        $sql = ' SELECT * FROM ' .tablename('wnjz_sun_orderlist') . ' ol ' . ' JOIN ' . tablename('wnjz_sun_order') . ' o ' . ' ON ' . ' o.oid=ol.order_id' . ' WHERE ' . ' o.oid=' . $oid . ' AND ' . ' o.uniacid='.$_W['uniacid'] . ' AND ' . ' o.oprnid=' . "'$openid'";
        $data = pdo_fetch($sql);
        $data['pic'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$data['gid']),'pic');
        $data['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$data['gid']),'gname');
        echo json_encode($data);
    }

    //发布图片保存
    public function doPageToupload(){
        global $_W, $_GPC;
//        $tcid = $_GPC["tcid"];
        //检测是否存在文件
        if (!is_uploaded_file($_FILES["file"]['tmp_name'])) {
            //图片不存在
            echo 2;
            exit;
        }else{
            $file = $_FILES["file"];

            //defined('TD_PATH') or define('TD_PATH',__DIR__);
            require_once TD_PATH."/class/UploadFile.class.php";
            $upload = new UploadFile();
            //设置上传文件大小,目前相当于无限制,微信会自动压缩图片
            $upload->maxSize = 30292200;
            $upload->allowExts = explode(',', 'png,gif,jpeg,pjpeg,bmp,x-png,jpg');
            $upload->savePath = '../attachment/';
            $upload->saveRule = uniqid;
            $uploadList = $upload->uploadOne($file);
            if (!$uploadList) {
                //捕获上传异常
                echo json_encode($upload->getErrorMsg());
                exit;
            }
            $newimg = $uploadList['0']['savename'];

            echo json_encode($newimg);
        }
    }

    // 保存评价数据
    public function doPageSaveComtemt()
    {
        global $_W,$_GPC;
        $oid = $_GPC['oid'];
        $gid = $_GPC['gid'];
        $commemt = $_GPC['comment'];
        $img = rtrim($_GPC['img'],',');
        $scores = $_GPC['scores'];
        $img = explode(',',$img);
        $imgs = array();
        foreach ($img as $k=>$v){
            $imgs[$k] = rtrim($v,'&quot;');
        }
        foreach ($imgs as $k=>$v){
            $imgs[$k] = ltrim($v,'&quot;');
        }

        $data = array(
            'oid'=>$oid,
            'imgs'=>implode(',',$imgs),
            'content'=>$commemt,
            'start'=>$scores,
            'uniacid'=>$_W['uniacid'],
            'openid'=>$_GPC['openid'],
            'gid'=>$gid,
            'addtime'=>time()
        );
        $res = pdo_insert('wnjz_sun_comment',$data);
        echo json_encode($res);
    }


    /**
     * 商家后台
     *
     */
    public function doPagetodayfangke()
    {
        global $_W;
        // 今日访客数
        $data = pdo_getall('wnjz_sun_user',array('uniacid'=>$_W['uniacid']));
        $new = array();
        foreach ($data as $k=>$v){
            if(date('Y-m-d',time())==date('Y-m-d',$v['time'])){
                $new[] = $v;
            }
        }
        $fangke = count($new);

        // 今日订单数
        $order = pdo_getall('wnjz_sun_order',array('uniacid'=>$_W['uniacid']));
        $or = array();
        foreach ($order as $k=>$v){
            if(date('Y-m-d',time())==date('Y-m-d',$v['addtime'])){
                $or[] = $v;
            }
        }
        $orders = count($or);

        // 待付款订单
        $Worder = pdo_getall('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'status'=>2));
        $Worders = count($Worder);

        // 待服务订单
        $Dorder = pdo_getall('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'status'=>3));
        $Dorders = count($Dorder);

        $newData = array(
            'today_fk'=>$fangke,
            'today_num'=>$orders,
            'worder'=>$Worders,
            'dorder'=>$Dorders
        );
        echo json_encode($newData);

    }

    public function doPageFinanceData()
    {
        global $_W;
        // 今日收益
        $Wservice = pdo_getall('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'status'=>3));
        $ws = 0;
        foreach ($Wservice as $k=>$v){
            if(date('Y-m-d',time())==date('Y-m-d',$v['addtime'])){
                $ws += $v['money'];
            }
        }
        $Qorder = pdo_getall('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'status'=>5));
        foreach ($Qorder as $k=>$v){
            if(date('Y-m-d',time())==date('Y-m-d',$v['addtime'])){
                $ws += $v['money'];
            }
        }

        // 昨日收益
        $time = date('Y',time()) . date('m',time()) . date('d',time())-1;
        $zs = 0;
        foreach ($Wservice as $k=>$v){
            if($time==date('Ymd',$v['addtime'])){
                $zs += $v['money'];
            }
        }
        foreach ($Qorder as $k=>$v){
            if($time==date('Ymd',$v['addtime'])){
                $zs += $v['money'];
            }
        }

        // 总收益
        $zong = 0;
        foreach ($Wservice as $k=>$v){
            $zong += $v['money'];
        }

        foreach ($Qorder as $k=>$v){
            $zong += $v['money'];
        }

        $newData = array(
            'zuotian'=>$zs,
            'today'=>$ws,
            'zong'=>$zong
        );
        echo json_encode($newData);

    }

    // 首页弹窗
    public function doPageIndexTan()
    {
        global $_W;
        $data = pdo_get('wnjz_sun_winindex',array('uniacid'=>$_W['uniacid']));
        echo json_encode($data);
    }

    // 一级分类数据
    public function doPageOnecategory()
    {
        global $_W;
        $data = pdo_getall('wnjz_sun_category',array('uniacid'=>$_W['uniacid'],'pid'=>0));
        echo json_encode($data);
    }

    // 判断是否拥有子集
    public function doPageHaveSon()
    {
        global $_W,$_GPC;
        $cid = $_GPC['cid'];
        $build_id = $_GPC['build_id'];
        if($cid==-1){
            $res = array(
                'flag'=>0,
            );
            $data = pdo_getall('wnjz_sun_goods',array('uniacid'=>$_W['uniacid']),'','','selftime DESC');
            foreach ($data as $k=>$v){
                if(in_array($build_id,explode(',',$v['build_id']))){
                    $res['data'][$k] = $v;
                }
            }
        }else{
            $data = pdo_getall('wnjz_sun_category',array('uniacid'=>$_W['uniacid'],'pid'=>$cid));
            if($data){
                $res = array(
                    'flag'=>1,
                    'data'=>$data
                );
            }else{
                $res = array(
                    'flag'=>0,
                );
                $data = pdo_getall('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'cid'=>$cid),'','','selftime DESC');
                foreach ($data as $k=>$v){
                    if(in_array($build_id,explode(',',$v['build_id']))){
                        $res['data'][$k] = $v;
                    }
                }

            }
        }
        echo json_encode($res);

    }

    // 获取一级分类图片
    public function doPagecatepic()
    {
        global $_GPC,$_W;
        $cid = $_GPC['cid'];
        $data = pdo_get('wnjz_sun_category',array('uniacid'=>$_W['uniacid'],'cid'=>$cid));
        echo json_encode($data);
    }

    /**
     * 关键字获取对应服务
     *
     */
    public function doPagekeywordData()
    {
        global $_GPC,$_W;
        $keyword = $_GPC['keyword']; // 关键字
        $build_id = $_GPC['build_id']; // 门店id
        $where = " and (g.gname LIKE  concat('%', :order_no,'%') or g.probably LIKE  concat('%', :order_no,'%'))";
        $data[':order_no']=$keyword;
        $sql = ' SELECT * FROM ' . tablename('wnjz_sun_category') . ' ce ' . ' JOIN ' . tablename('wnjz_sun_goods') . ' g ' . ' ON g.cid=ce.cid ' . ' WHERE g.uniacid='. $_W['uniacid'] . $where . ' ORDER BY g.selftime DESC ';
        $data = pdo_fetchall($sql,$data);
        $newData = array();
        foreach ($data as $k=>$v){
            if(in_array($build_id,explode(',',$v['build_id']))){
                $newData[] = $v;
            }
        }
        echo json_encode($newData);
    }

    // 底部tab
    public function doPageTab()
    {
        global $_W;
        $data = pdo_get('wnjz_sun_tab',array('uniacid'=>$_W['uniacid']));
        // 获取路径
//        $url = $this->doPageUrl2();
//        $data['indeximg'] = $url . $data['indeximg'];
//        $data['indeximgs'] = $url . $data['indeximgs'];
//
//        $data['couponimg'] = $url . $data['couponimg'];
//        $data['couponimgs'] = $url . $data['couponimgs'];
//
//        $data['fansimg'] = $url . $data['fansimg'];
//        $data['fansimgs'] = $url . $data['fansimgs'];
//
//        $data['mineimg'] = $url . $data['mineimg'];
//        $data['mineimgs'] = $url . $data['mineimgs'];
        echo json_encode($data);
    }

    /**
     * 获取普通订单详情
     *
     */
    public function doPageOrderDetails()
    {
        global $_GPC,$_W;
        $id = $_GPC['oid']; // 订单id
        $uniacid = $_W['uniacid'];
        $sql = " select o.*,ol.gid,ol.num from " . tablename('wnjz_sun_order') . " o join " . tablename('wnjz_sun_orderlist') . " ol on o.oid=ol.order_id where o.uniacid=$uniacid and ol.uniacid=$uniacid and o.oid=$id";
        $order = pdo_fetch($sql);
        $order['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$order['gid']),'gname');
        $order['pic'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$order['gid']),'pic');
        $order['b_name'] = pdo_getcolumn('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$order['build_id']),'name');
        $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
		$order['paytime'] = date('Y-m-d H:i:s',$order['paytime']);
        echo json_encode($order);
    }

    // 获取门店
    public function doPagebranch()
    {
        global $_GPC,$_W;
        $bid = $_GPC['bid'];
        $name = pdo_getcolumn('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$bid),'name');
        echo json_encode($name);
    }

    /**
     * 门店后台
     *
     */
    public function doPageBranchtodayfangke()
    {
        global $_W,$_GPC;
        $bid = $_GPC['bid']; // 门店id
        // 今日访客数
        $data = pdo_getall('wnjz_sun_user',array('uniacid'=>$_W['uniacid']));
        $new = array();
        foreach ($data as $k=>$v){
            if(date('Y-m-d',time())==date('Y-m-d',$v['time'])){
                $new[] = $v;
            }
        }
        $fangke = count($new);

        // 今日订单数
        $order = pdo_getall('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'build_id'=>$bid));
        $or = array();
        foreach ($order as $k=>$v){
            if(date('Y-m-d',time())==date('Y-m-d',$v['addtime'])){
                $or[] = $v;
            }
        }
        $orders = count($or);

        // 待付款订单
        $Worder = pdo_getall('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'status'=>2,'build_id'=>$bid));
        $Worders = count($Worder);

        // 待服务订单
        $Dorder = pdo_getall('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'status'=>3,'build_id'=>$bid));
        $Dorders = count($Dorder);

        $newData = array(
            'today_fk'=>$fangke,
            'today_num'=>$orders,
            'worder'=>$Worders,
            'dorder'=>$Dorders
        );
        echo json_encode($newData);

    }

    public function doPageBranchFinanceData()
    {
        global $_W,$_GPC;
        $bid = $_GPC['bid']; // 门店id
        // 今日收益
        $Wservice = pdo_getall('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'status'=>3,'build_id'=>$bid));
        $ws = 0;
        foreach ($Wservice as $k=>$v){
            if(date('Y-m-d',time())==date('Y-m-d',$v['addtime'])){
                $ws += $v['money'];
            }
        }
        $Qorder = pdo_getall('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'status'=>5,'build_id'=>$bid));
        foreach ($Qorder as $k=>$v){
            if(date('Y-m-d',time())==date('Y-m-d',$v['addtime'])){
                $ws += $v['money'];
            }
        }

        // 昨日收益
        $time = date('Y',time()) . date('m',time()) . date('d',time())-1;
        $zs = 0;
        foreach ($Wservice as $k=>$v){
            if($time==date('Ymd',$v['addtime'])){
                $zs += $v['money'];
            }
        }
        foreach ($Qorder as $k=>$v){
            if($time==date('Ymd',$v['addtime'])){
                $zs += $v['money'];
            }
        }

        // 总收益
        $zong = 0;
        foreach ($Wservice as $k=>$v){
            $zong += $v['money'];
        }

        foreach ($Qorder as $k=>$v){
            $zong += $v['money'];
        }

        $newData = array(
            'zuotian'=>$zs,
            'today'=>$ws,
            'zong'=>$zong
        );
        echo json_encode($newData);

    }

    /**
     * 门店订单
     *
     */
    public function doPageBranchOrder()
    {
        global $_W,$_GPC;
        $bid = $_GPC['bid']; // 门店id
        $uniacid = $_W['uniacid'];
        $sql = " select o.*,ol.gid,ol.num from " . tablename('wnjz_sun_order') . " o join " . tablename('wnjz_sun_orderlist') . " ol on o.oid=ol.order_id where o.uniacid=$uniacid and ol.uniacid=$uniacid and o.build_id=$bid and o.status != 2";
        $order = pdo_fetchall($sql);
        foreach ($order as $k=>$v){
            $order[$k]['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'gname');
            $order[$k]['pic'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'pic');
            $order[$k]['b_name'] = pdo_getcolumn('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['build_id']),'name');
            $order[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
        }
        $Waitervice = array();
        $Byservice = array();
        foreach ($order as $k=>$v){
            if($v['status']==3){
                $Waitervice[] = $v;
            }
            if($v['status']==5){
                $Byservice[] = $v;
            }
        }
        $newData = array(
            'order'=>$order,
            'Waitervice'=>$Waitervice,
            'Byservice'=>$Byservice
        );
        echo json_encode($newData);
    }

    /**
     * 门店订单核销
     *
     */
    public function doPageGetOrderInfo()
    {
        global $_GPC,$_W;
        $id = $_GPC['id']; // 订单id
        $bid = $_GPC['bid']; // 门店id
        $uniacid = $_W['uniacid'];
        $sql = " select o.*,ol.gid from " . tablename('wnjz_sun_order') . " o join " . tablename('wnjz_sun_orderlist') . " ol on o.oid=ol.order_id where o.uniacid=$uniacid and o.build_id=$bid and ol.uniacid=$uniacid and o.oid=$id";
        $order = pdo_fetch($sql);
        $order['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$order['gid']),'gname');
        $order['pic'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$order['gid']),'pic');
        $order['b_name'] = pdo_getcolumn('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$order['build_id']),'name');
        $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
        echo json_encode($order);
    }

    /**
     * 门店扫码核销
     *
     */
    public function doPageSaoBrandOrder()
    {
        global $_GPC,$_W;
        $id = $_GPC['id']; // 订单id
        $bid = $_GPC['bid']; // 门店id
        $res = pdo_get('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'oid'=>$id,'build_id'=>$bid,'status'=>3));
        if($res['status']==2){
            $re = 3;
        }else{
            if($res){
                $re = pdo_update('wnjz_sun_order',array('status'=>5),array('uniacid'=>$_W['uniacid'],'oid'=>$id,'build_id'=>$bid));
            }else{
                $re = 2;
            }
        }

        echo json_encode($re);
    }

    /**
     * 门店订单核销
     *
     */
    public function doPageGetSidOrderInfo()
    {
        global $_GPC,$_W;
        $id = $_GPC['id']; // 订单id
        $sid = $_GPC['sid']; // 门店id
        $uniacid = $_W['uniacid'];
        $sql = " select o.*,ol.gid from " . tablename('wnjz_sun_order') . " o join " . tablename('wnjz_sun_orderlist') . " ol on o.oid=ol.order_id where o.uniacid=$uniacid and o.sid=$sid and ol.uniacid=$uniacid and o.oid=$id";
        $order = pdo_fetch($sql);
        $order['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$order['gid']),'gname');
        $order['pic'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$order['gid']),'pic');
        $order['b_name'] = pdo_getcolumn('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$order['build_id']),'name');
        $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
        echo json_encode($order);
    }

    /**
     * 门店扫码核销
     *
     */
    public function doPageSaoSIDOrder()
    {
        global $_GPC,$_W;
        $id = $_GPC['id']; // 订单id
        $sid = $_GPC['sid']; // 门店id
        $res = pdo_get('wnjz_sun_order',array('uniacid'=>$_W['uniacid'],'oid'=>$id,'sid'=>$sid,'status'=>3));
        if($res['status']==2){
            $re = 3;
        }else{
            if($res){
                $re = pdo_update('wnjz_sun_order',array('status'=>5),array('uniacid'=>$_W['uniacid'],'oid'=>$id,'sid'=>$sid));
            }else{
                $re = 2;
            }
        }

        echo json_encode($re);
    }

    /**
     * 生成海报
     *
     */

    public function getaccess_token(){
        global $_W, $_GPC;
        $res=pdo_get('wnjz_sun_system',array('uniacid'=>$_W['uniacid']));
        $appid=$res['appid'];
        $secret=$res['appsecret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data,true);
        return $data['access_token'];
    }

    //小程序码
    /*public function doPageGetwxCode(){
        global $_W, $_GPC;

        $access_token = $this->getaccess_token();
        $scene = $_GPC["scene"];
        $page = $_GPC["page"];
        $width = $_GPC["width"]?$_GPC["width"]:120;
        $auto_color = $_GPC["auto_color"]?$_GPC["auto_color"]:false;
        $line_color = $_GPC["line_color"]?$_GPC["line_color"]:'{"r":"0","g":"0","b":"0"}';
        $is_hyaline = $_GPC["is_hyaline"]?$_GPC["is_hyaline"]:true;

        //$url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token;
        $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$access_token;

        //$data='{"scene":"'.$scene.'","page":"'.$page.'","width":"'.$width.'","is_hyaline":"'.$is_hyaline.'"}';
        //$data["scene"] = $scene;
        $data["path"] = $page;
        $data["width"] = $width;
        $data["is_hyaline"] = $is_hyaline;
        //$data["auto_color"] = $auto_color;
        //$data["line_color"] = $line_color;
        //$data["is_hyaline"] = $is_hyaline;
        //$data["is_hyaline"] = $is_hyaline;
        // $data ='{
        //     "scene": "'.$scene.'",
        //     "page": "'.$page.'",
        //     "width": "'.$width.'",
        //     "is_hyaline": "'.$is_hyaline.'"
        // }';
        $json_data = json_encode($data);
        //echo $json_data;exit;

        $return = $this->request_post($url,$json_data);
        //将生成的小程序码存入相应文件夹下
        $imgname = time().rand(10000,99999).'.jpg';
        //echo json_encode($return);exit;
        file_put_contents("../attachment/".$imgname,$return);

        echo json_encode($imgname);
    }*/

    /*public function doPageDelwxCode(){
        global $_W, $_GPC;
        $imgurl = $_GPC["imgurl"];
        $filename = '../attachment/'.$imgurl;
        if(file_exists($filename)){
            $info ='删除成功';
            unlink($filename);
        }else{
            $info ='没找到:'.$filename;
        }
        echo $info;
    }*/

    /*public function request_post($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $tmpInfo = curl_exec($ch);
        $error = curl_errno($ch);
        curl_close($ch);
        if ($error) {
            return false;
        }else{
            return $tmpInfo;
        }
    }*/

	//B小程序码
    public function doPageGetwxCode(){
        global $_W, $_GPC;

        $access_token = $this->getaccess_token();
        $scene = $_GPC["scene"];
        if (!preg_match('/[0-9a-zA-Z\!\#\$\&\'\(\)\*\+\,\/\:\;\=\?\@\-\.\_\~]{1,32}/', $scene)) {
            return $this->result(1, '场景值不合法', array());
        }
        $page = $_GPC["page"];
        $width = $_GPC["width"]?$_GPC["width"]:430;
        $auto_color = $_GPC["auto_color"]?$_GPC["auto_color"]:false;
        $line_color = $_GPC["line_color"]?$_GPC["line_color"]:array('r' => 0,'g' => 0,'b' => 0);
        $is_hyaline = $_GPC["is_hyaline"]?$_GPC["is_hyaline"]:false;

        $uniacid = $_W["uniacid"];

        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token;//B

		$data = array();
        $data["scene"] = $scene;
        $data["page"] = $page;
        $data["width"] = $width;
        $data["auto_color"] = $auto_color;
        $data["line_color"] = $line_color;
        $data["is_hyaline"] = $is_hyaline;

        $json_data = json_encode($data);
        
		$return = $this->request_post($url,$json_data);

        //将生成的小程序码存入相应文件夹下
        $imgname = time().rand(10000,99999).'.jpg';
        file_put_contents("../attachment/".$imgname,$return);
        
        echo json_encode($imgname);
    }

    public function doPageDelwxCode(){
        global $_W, $_GPC;
        $imgurl = $_GPC["imgurl"];
        $filename = '../attachment/'.$imgurl;
        if(file_exists($filename)){
            $info ='删除成功';
            unlink($filename);
        }else{
            $info ='没找到:'.$filename;
        }
        echo $info;
    }

    public function request_post($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $tmpInfo = curl_exec($ch);
        $error = curl_errno($ch);
        curl_close($ch);
        if ($error) {
            return false;
        }else{
            return $tmpInfo;
        }
    }

    /**
     * 用户交易记录
     *
     */
    public function doPageCurrentMonthBill()
    {
        global $_W,$_GPC;
        $month = $_GPC['month'];
        $year = $_GPC['curYear'];
        $openid = $_GPC['openid']; // 用户id
        $uniacid = $_W['uniacid'];
        $time = $year . '-' . $month;
        $consumption = 0; // 消费
        $rech = 0; // 充值
        // 线上预约
        $sql = " select * from " . tablename('wnjz_sun_order') . " where uniacid=$uniacid and oprnid='$openid'";
        $order = pdo_fetchall($sql);
        $curtimes = array();
        foreach ($order as $k=>$v){
            if($time == date('Y-m',$v['addtime'])){
                $curtimes[] = $v['addtime'];
                $consumption += $v['money'];
            }
            $order[$k]['money'] = '-'.$v['money'];
            $order[$k]['time'] = date('Y-m-d',$v['addtime']);
            $order[$k]['name'] = '预约下单';
        }
        $newData = array();
        foreach ($order as $k=>$v){
            if($time == date('Y-m',$v['addtime'])){
                $newData[] = $v;
            }
        }
        // 线下买单
        $purchase = pdo_getall('wnjz_sun_orde',array('uniacid'=>$uniacid,'oprnid'=>$openid));
        foreach ($purchase as $k=>$v){
            if($time == date('Y-m',$v['addtime'])){
                $curtimes[] = $v['addtime'];
                $consumption += $v['price'];
            }
            $purchase[$k]['money'] = '-'.$v['price'];
            $purchase[$k]['time'] = date('Y-m-d',$v['addtime']);
            $purchase[$k]['name'] = '门店买单';
        }
        foreach ($purchase as $k=>$v){
            if($time == date('Y-m',$v['addtime'])){
                $newData[] = $v;
            }
        }
        // 充值
        $recharge = pdo_getall('wnjz_sun_recharges',array('uniacid'=>$uniacid,'openid'=>$openid));
        foreach ($recharge as $k=>$v){
            if($time == date('Y-m',strtotime($v['r_time']))){
                $curtimes[] = strtotime($v['r_time']);
            }
            $recharge[$k]['money'] = '+'.$v['r_money'];
            $recharge[$k]['time'] = date('Y-m-d',strtotime($v['r_time']));
            $recharge[$k]['name'] = '充值余额';
        }
        foreach ($recharge as $k=>$v){
            if($time == date('Y-m',strtotime($v['r_time']))){
                $newData[] = $v;
                $rech += $v['r_money'];
            }
        }

        foreach ($curtimes as $k=>$v){
            $curtimes[$k] = date("YmdHis",$v);;
        }
        array_multisort($curtimes,SORT_DESC,$newData);
        $data = array(
            'data'=>$newData,
            'consumption'=>$consumption,
            'rech'=>$rech,
        );

        echo json_encode($data);
    }

	//判断门店和商品是否存在
	public function doPageActiveing()
    {
        global $_GPC,$_W;
        $id = $_GPC['id'];
		$bid = $_GPC['build_id'];
        
		$data = pdo_get('wnjz_sun_selected',array('uniacid'=>$_W['uniacid'],'seid'=>$id));
		$bdata = pdo_get('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$bid,'stutes'=>1));

		if($data && $bdata){
			echo 2;
		}else{
			echo 1;
		}
    }

	//判断门店和砍价商品是否存在
	public function doPageKjActiveing()
    {
        global $_GPC,$_W;
        $id = $_GPC['id'];
		$bid = $_GPC['build_id'];
        
		$data = pdo_get('wnjz_sun_new_bargain',array('uniacid'=>$_W['uniacid'],'id'=>$id));
		$bdata = pdo_get('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$bid,'stutes'=>1));

		$now = time();
		$starttime = strtotime($data['starttime']);
		$endtime = strtotime($data['endtime']);
		
		if($data && $bdata && $data['build_id']==$bid){
			if($now>$starttime){
				if($now<$endtime){
					$res = 0; //活动进行中
				}else{
					$res = 1; //活动已结束
				}
			}else{
				$res = 2; //活动未开始
			}
		}else{
			$res = 1; //活动已结束
		}

		echo json_encode($res);
		
    }

    public function doPageCheckGoods(){
        global $_W,$_GPC;
        $openid = $_GPC['openid']; // 用户id
        $uniacid = $_W['uniacid'];
        $gid = intval($_GPC['gid']);

        $goods = pdo_get('wnjz_sun_goods',array('uniacid'=>$uniacid,'gid'=>$gid));

        if($goods["endbuy"]>0){
            //判断是否限购
            $ordersql = "select sum(ol.num) as num from ".tablename('wnjz_sun_orderlist')." as ol left join ".tablename('wnjz_sun_order')." as o on ol.order_id=o.oid where ol.gid=".$gid." and o.status > 2 ";
            $order = pdo_fetchcolumn($ordersql);
            if($order){
                if($goods["endbuy"]<=$order){
                    return $this->result(1, '超过该商品限购数量，无法继续购买！', array());//errno，message，data
                }
            }
        }
    }

	//设置订单状态 — 退款
    public function doPageSetOrderStatus(){
        global $_W, $_GPC;
        $ordertype = intval($_GPC["ordertype"]);//订单类型，1：默认普通，2砍价
        $oid = intval($_GPC["oid"]);
		$status = intval($_GPC["status"]);
        $uniacid = $_W['uniacid'];
        $refund = intval($_GPC["refund"]);
        
		if($refund!=1 && $status==0){
            echo 2;
            exit;
        }
		$datas['status'] = $status;
        
		if($ordertype==2){
            if($refund==1){//进入退款申请
                $order = pdo_get('wnjz_sun_kjorder',array('id'=>$oid,'uniacid'=>$uniacid));
				if($order){
					$orderlist = pdo_get('wnjz_sun_kjorderlist',array('order_id'=>$oid,'uniacid'=>$uniacid));
					$gid = $orderlist['oid'];
				}
                //如果退款，判断是否能退款
                if($refund==1){
                    $goods = pdo_get('wnjz_sun_new_bargain',array('uniacid'=>$uniacid,'id'=>$gid),array("canrefund"));
                    if($goods["canrefund"]==0){//不能退款
                        return $this->result(1, '该商品无法退款！！！', array("status"=>$order["status"]));//errno，message，data
                    }
                }
                if($order["status"]==5){
                    return $this->result(1, '该商品已经核销过，无法退款！！！', array("status"=>$order["status"]));//errno，message，data
                }
                if($order["status"]!=3){
                    return $this->result(1, '该商品无法退款！！！', array("status"=>$order["status"]));//errno，message，data
                }
                $res = pdo_update('wnjz_sun_kjorder', array("isrefund"=>1), array('id' => $oid, 'uniacid' => $uniacid));
                /*if($order["bid"]>0){
                    $this->SendSms($order["bid"],1,$order["ordernum"]);
                }*/
            }elseif($refund==4){//进入取消退款申请
                $res = pdo_update('wnjz_sun_kjorder', array("isrefund"=>0), array('id' => $oid, 'uniacid' => $uniacid));
            }else{
                $res = pdo_update('wnjz_sun_kjorder', $datas, array('id' => $oid, 'uniacid' => $uniacid));
            }
        }else{
            if($refund==1){//进入退款申请
                $order = pdo_get('wnjz_sun_order',array('oid'=>$oid,'uniacid'=>$uniacid));
				if($order){
					$orderlist = pdo_get('wnjz_sun_orderlist',array('order_id'=>$oid,'uniacid'=>$uniacid));
					$gid = $orderlist['gid'];
				}
                //如果退款，判断是否能退款
                if($refund==1){
                    $goods = pdo_get('wnjz_sun_goods',array('uniacid'=>$uniacid,'gid'=>$gid),array("canrefund"));
                    if($goods["canrefund"]==0){//不能退款
                        return $this->result(1, '该商品无法退款！！！', array("status"=>$order["status"]));//errno，message，data
                    }
                }
                if($order["status"]==5){
                    return $this->result(1, '该商品已经核销过，无法退款！！！', array("status"=>$order["status"]));//errno，message，data
                }
                if($order["status"]!=3){
                    return $this->result(1, '该商品无法退款！！！', array("status"=>$order["status"]));//errno，message，data
                }
                $res = pdo_update('wnjz_sun_order', array("isrefund"=>1), array('oid' => $oid, 'uniacid' => $uniacid));
                /*if($order["bid"]>0){
                    $this->SendSms($order["bid"],1,$order["ordernum"]);
                }*/
            }elseif($refund==4){//进入取消退款申请
                $res = pdo_update('wnjz_sun_order', array("isrefund"=>0), array('oid' => $oid, 'uniacid' => $uniacid));
            }else{
                $res = pdo_update('wnjz_sun_order', $datas, array('oid' => $oid, 'uniacid' => $uniacid));
            }
        }

        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }

    //@20190320 自定义导航/广告
    public function doPagegetNavList(){
        global $_W, $_GPC;
        $position = intval($_GPC["p"]);
        $in_position = $_GPC["in_p"];
        $where = array("uniacid"=>$_W['uniacid'],"isshow"=>1);
        if($position>0){
            $where['position'] = $position;
        }
        if($in_position){
            $where['position'] = $in_position;
        }
        $list_data = pdo_getall("wnjz_sun_nav",$where,"","",array("sort asc","id DESC"));
//        echo json_encode($list_data);exit;
        $list = array("nav"=>"","tab"=>"");
        if($list_data){
            $pop_list = array(
                1=>"nav",
                2=>"tab"
            );
            foreach($list_data as $k => $v){
                if($v["pic"]){
                    $v["pic"] = $_W["attachurl"] . $v["pic"];
                }
                if($v["un_pic"]){
                    $v["un_pic"] = $_W["attachurl"].$v["un_pic"];
                }
                $list[$pop_list[$v["position"]]][] = $v;
            }
            echo json_encode($list);
        }else{
            echo json_encode($list);
        }
    }

    //奇推配置信息
    public function doPageGetqtappData(){
        global $_W, $_GPC;
        $item = pdo_get('wnjz_sun_sms',array('uniacid'=>$_W['uniacid']));
        if($item["qitui"]){
            $qitui = unserialize($item["qitui"]);
        }
        if($qitui){
            echo json_encode($qitui);
        }else{
            echo json_encode(array(""));
        }
    }
	
	//判断是否开启相关插件-分销插件
    public function doPagePlugin(){
        global $_W, $_GPC;
        $type = intval($_GPC["type"]);//1分销插件
        $uniacid = $_W["uniacid"];
        if($type==1){
            //判断分销表是否存在
            if(pdo_tableexists("wnjz_sun_distribution_set")){
                $set = pdo_get('wnjz_sun_distribution_set',array('uniacid'=>$uniacid));
                if($set){
                    if($set["status"]>0){
                        echo json_encode($set);
                    }else{
                        echo 2;
                    }
                }else{
                    echo 2;
                }
            }else{
                echo 2;
            }
        }else{
            echo 2;
        }
    }

}/////////////////////////////////////////////