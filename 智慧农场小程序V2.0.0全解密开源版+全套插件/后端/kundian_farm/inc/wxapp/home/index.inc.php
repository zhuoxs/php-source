<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 2018/12/1
 * Time: 18:18
 */
defined("IN_IA") or exit('Access Denied');
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/public.php';
require_once ROOT_PATH.'model/weather.php';
class IndexController{
    protected $uniacid='';
    protected $uid='';
    static $common='';
    static $weatherModel='';
    /**初始化获取公共数据*/
    public function __construct(){
        global $_GPC;
        $this->uniacid=$_GPC['uniacid'];
        $this->uid=$_GPC['uid'];
        self::$common=new Common_KundianFarmModel();
        self::$weatherModel=new Weather_KundianFarmModel($this->uniacid);
    }

    /** 用户授权登录*/
    public function login(){
        global $_GPC,$_W;
        if(empty($_GPC['uid'])){
            echo json_encode(['code'=>-1,'msg'=>'用户UID获取失败']);die;
        }
        $wxNickName=$_GPC['wxNickName'];
        $wxAvatar=$_GPC['wxAvatar'];
        $userData=pdo_get('cqkundian_farm_user',['openid'=>$_W['openid'],'uniacid'=>$this->uniacid]);
        $data=array(
            'nickname'=>$wxNickName? $wxNickName : $_GPC['nickname'],
            'avatarurl'=>$wxAvatar? $wxAvatar : $_GPC['avatar'],
            'uniacid'=>$this->uniacid,
            'openid'=>$_W['openid'],
        );
        if(empty($userData)){
            $data['uid']=$_GPC['uid'];
            $data['create_time']=time();
            $res=pdo_insert("cqkundian_farm_user",$data);
            echo  $res ? json_encode(['code'=>0,'msg'=>'用户信息更新成功','uid'=>$data['uid']]) : json_encode(['code'=>-1,'msg'=>'用户信息更新失败,或没有修改任何信息','uid'=>$data['uid']]);die;
        }
        $res=pdo_update('cqkundian_farm_user',$data,['openid'=>$_W['openid'],'uniacid'=>$this->uniacid]);
        echo  json_encode(['code'=>0,'msg'=>'用户信息更新成功','uid'=>$userData['uid']]);
    }

    /** 获取小程序首页数据*/
    public function getHomeData(){
        global $_GPC,$_W;
        $pageData=$this->neatenPageData();
        $page=$pageData['page'];
        $request['weather']=$pageData['weather']['weather'];
        $request['weatherSet']=$pageData['weather']['weatherSet'];
        $request['page']=$page;
        $icon=array(
            'voucher'=>$_W['siteroot'].'addons/kundian_farm/resource/image/voucher.png',
            'is_get_quan'=>$_W['siteroot'].'addons/kundian_farm/resource/image/is_get_quan.png',
        );
        $request['icon']=$icon;
        echo json_encode($request);die;
    }

    /** 获取首页数据*/
    public function neatenPageData(){
        $pageData = pdo_get('cqkundian_farm_page_set', ['page_name' => 'index', 'uniacid' => $this->uniacid]);
        $page = unserialize($pageData['page_value']);
        $setDataList = self::$common->getSetData(['coupon_count'], $this->uniacid);
        for ($i = 0; $i < count($page); $i++) {
            if ($page[$i]->type == 'banner') {
                $page[$i]->imgUrl = $list=pdo_getall('cqkundian_farm_slide',['status'=>1,'uniacid'=>$this->uniacid,'slide_type'=>1],'','','rank asc');;
            } elseif ($page[$i]->type == 'navigation') {
                $typeData = pdo_getall('cqkundian_farm_home_type', array('status' => 1, 'uniacid' => $this->uniacid), '', '', 'rank asc');
                $page[$i]->list = $typeData;
            } elseif ($page[$i]->type == 'coupon') {
                $page[$i]->couponData = $this->getCouponData($setDataList, $this->uniacid, $this->uid);
            } elseif ($page[$i]->type == 'weather') {
                $weather=self::$weatherModel->getTodayWeather();
            } elseif ($page[$i]->type == 'information') {
                $articleData = $list=pdo_getall('cqkundian_farm_article',['uniacid'=>$this->uniacid],'','','rank asc',[0,3]);
                $articleType=pdo_getall('cqkundian_farm_article_type',['uniacid'=>$this->uniacid,'is_default'=>1],'','','rank asc',[0,2]);
                if(empty($articleType)){
                    $articleType=pdo_getall('cqkundian_farm_article_type',['uniacid'=>$this->uniacid],'','','rank asc',[0,2]);
                }
                $page[$i]->articleData = $articleData;
                $page[$i]->articleType=$articleType;
            } elseif ($page[$i]->type == 'btnclounm') {
                $page[$i]->homeBtm = $this->getHomeBtm($this->uniacid);
            } elseif ($page[$i]->type == 'prolist') {
                if ($page[$i]->selectType == 2) {  //选择分类
                    $public=new Public_KundianFarmModel('cqkundian_farm_goods',$this->uniacid);
                    $goods_where = array('uniacid' => $this->uniacid, 'is_put_away' => 1);
                    if ($page[$i]->selectGroup == 1) {         //新品
                        $page[$i]->newList = $public->getTableList($goods_where, 1, $page[$i]->selectNum, 'id desc');
                    } elseif ($page[$i]->selectGroup == 2) {    //热卖
                        $page[$i]->newList = $public->getTableList($goods_where, 1, $page[$i]->selectNum, 'sale_count desc');
                    } elseif ($page[$i]->selectGroup == 3) {   //推荐
                        $goods_where['is_recommend'] = 1;
                        $page[$i]->newList = $public->getTableList($goods_where, 1, $page[$i]->selectNum);
                    }
                }
            }
        }

        return ['page'=>$page,'weather'=>$weather];
    }

    /**获取小程序公共数据*/
    public function getCommonData(){
        global $_W,$_GPC;
        $tarbar=self::$common->selectTarBar(['uniacid'=>$this->uniacid]);

        if($_GPC['refresh'] || cache_load('kundianFarmTime_'.$this->uniacid)< time()){
            $field =['background_color','nav_top_color','assist_color', 'front_color', 'bar_title', 'vet_title',
                'vet_icon', 'vet_english_title', 'vet_banner', 'sign_title', 'share_home_title', 'share_shop_title', 'share_land_title', 'animal_list_style',
                'center_contact_type', 'center_back_color', 'is_open_webthing', 'animal_list_style', 'animal_name_show', 'user_withdraw_low_price',
                'animal_send_price', 'animal_rule', 'seed_send_price', 'recovery_method', 'self_lifting_address','self_lifting_place','self_lifting_phone', 'is_open_wxpay','shop_delivery_method'];

            $farmSetData = self::$common->getSetData($field, $this->uniacid);
            $farmSetData['live_post'] = $_W['siteroot'] . 'addons/kundian_farm/resource/img/player_loading.gif';
            if ($farmSetData['background_color'] == '') {
                $farmSetData['background_color'] = '#6aa84f';
            }
            if ($farmSetData['front_color'] == '') {
                $farmSetData['front_color'] = '#000000';
            }
            if (empty($farmSetData['nav_top_color']) || $farmSetData['front_color'] == '') {
                $farmSetData['nav_top_color'] = '#ffffff';
            }

            if(empty($farmSetData['self_lifting_place']) || $farmSetData['self_lifting_place']!=''){
                $farmSetData['self_lifting_place']=unserialize($farmSetData['self_lifting_place']);
            }
            cache_write("kundianFarm_" . $this->uniacid, $farmSetData);
            cache_write("kundianFarmTime_" . $this->uniacid, time()+1800);
        } elseif(cache_load('kundianFarmTime_'.$this->uniacid)> time()){
            $farmSetData=cache_load('kundianFarm_'.$this->uniacid);
        }

        if(empty($tarbar)){
            $tarbar=[
                [
                    'color'=>"#999999",
                    'icon'=>$_W['siteroot']."addons/kundian_farm/resource/img/tarbar/icon_1.png",
                    'name'=>"首页",
                    'path'=> "kundian_farm/pages/HomePage/index/index",
                    'rank'=>"1",
                    'select_color'=>"#16ba63",
                    'select_icon'=>$_W['siteroot']."addons/kundian_farm/resource/img/tarbar/icon_1_active.png",
                    'uniacid'=>$this->uniacid,
                ],
                [
                    'color'=>"#999999",
                    'icon'=>$_W['siteroot']."addons/kundian_farm/resource/img/tarbar/icon_2.png",
                    'name'=>"租地",
                    'path'=> "kundian_farm/pages/land/landList/index",
                    'rank'=>"2",
                    'select_color'=>"#16ba63",
                    'select_icon'=>$_W['siteroot']."addons/kundian_farm/resource/img/tarbar/icon_2_active.png",
                    'uniacid'=>$this->uniacid,
                ],
                [
                    'color'=>"#999999",
                    'icon'=>$_W['siteroot']."addons/kundian_farm/resource/img/tarbar/icon_3.png",
                    'name'=>"认养",
                    'path'=> "kundian_farm/pages/shop/Adopt/index",
                    'rank'=>"3",
                    'select_color'=>"#16ba63",
                    'select_icon'=>$_W['siteroot']."addons/kundian_farm/resource/img/tarbar/icon_3_active.png",
                    'uniacid'=>$this->uniacid,
                ],
                [
                    'color'=>"#999999",
                    'icon'=>$_W['siteroot']."addons/kundian_farm/resource/img/tarbar/icon_4.png",
                    'name'=>"商城",
                    'path'=> "kundian_farm/pages/shop/index/index",
                    'rank'=>"4",
                    'select_color'=>"#16ba63",
                    'select_icon'=>$_W['siteroot']."addons/kundian_farm/resource/img/tarbar/icon_4_active.png",
                    'uniacid'=>$this->uniacid,
                ],
                [
                    'color'=>"#999999",
                    'icon'=>$_W['siteroot']."addons/kundian_farm/resource/img/tarbar/icon_5.png",
                    'name'=>"我的",
                    'path'=> "kundian_farm/pages/user/center/index",
                    'rank'=>"5",
                    'select_color'=>"#16ba63",
                    'select_icon'=>$_W['siteroot']."addons/kundian_farm/resource/img/tarbar/icon_5_active.png",
                    'uniacid'=>$this->uniacid,
                ],
            ];

        }
        $request['tarbar']=$tarbar;
        $request['farmSetData']=$farmSetData;
        echo json_encode($request);die;
    }

    /**获取关于我们的信息*/
    public function getAboutData(){
        $about=pdo_get('cqkundian_farm_about',array('uniacid'=>$this->uniacid));
        echo json_encode(array('aboutData'=>$about));die;
    }

    //单独获取天气信息
    public function getNowWeatherData(){
        $weather=self::$weatherModel->getTodayWeather();
        $request['weatherSet']=$weather['weatherSet'];
        $request['weather']=$weather['weather'];
        echo json_encode($weather);die;
    }

    /** 保存formid */
    public function saveFormId(){
        global $_GPC;
        $user=pdo_get('cqkundian_farm_user',['uid'=>$this->uid,'uniacid'=>$this->uniacid]);
        $res=self::$common->insertFormIdData($_GPC['form_id'],$_GPC['uid'],$user['openid'],1,$this->uniacid);
        echo $res ? json_encode(['code'=>200,'msg'=>'formid 保存成功']) : json_encode(['code'=>-1,'msg'=>'formid 保存失败']);
    }

    /**
     * 获取优惠券信息
     * @param $setDataList
     * @param $uniacid
     * @param $uid
     * @return array|bool
     */
    public function getCouponData($setDataList,$uniacid,$uid){
        if($setDataList['coupon_count'] || $setDataList['coupon_count']!=0){
            $pageSize=$setDataList['coupon_count'];
        }else{
            $pageSize=4;
        }
        $couponData=pdo_getall('cqkundian_farm_shop_coupon',array('uniacid'=>$uniacid,'is_delete'=>0),'','','rank asc',array(0,$pageSize));
        if(!empty($couponData)) {
            if ($uid != 0) {
                //判断用户是否已经领取了优惠券
                for ($j = 0; $j < count($couponData); $j++) {
                    $userCoupon = pdo_get('cqkundian_farm_user_coupon', array('uniacid' => $uniacid, 'uid' => $uid,'cid'=>$couponData[$j]['id']));
                    if(!empty($userCoupon)){
                        $couponData[$j]['is_get']=1;
                    }else{
                        $couponData[$j]['is_get']=2;
                    }
                }
                $coupon = $this->array_sort($couponData, 'is_get', SORT_DESC);
            } else {
                $coupon = $couponData;
            }
        }else{
            $coupon=array();
        }

        return $coupon;
    }

    /*$array为要排序的数组,$keys为要用来排序的键名,$type默认为升序排序*/
    public function array_sort($data,$col,$type=SORT_DESC){

        if(is_array($data)){
            $i=0;
            foreach($data as $k=>$v){
                if(key_exists($col,$v)){
                    $arr[$i] = $v[$col];
                    $i++;
                }else{
                    continue;
                }
            }
        }else{
            return false;
        }
        array_multisort($arr,$type,$data);
        return $data;
    }


    /** 获取小程序首页底部三格信息*/
    public function getHomeBtm($uniacid){
        global $_W;
        $btm_con=array(
            'ikey'=>array('plate_one','plate_two','plate_three'),
            'uniacid'=>$uniacid,
        );
        $btmData=pdo_getall('cqkundian_farm_set',$btm_con);
        if($btmData){
            $list=array();
            foreach ($btmData as $key=>$v){
                $list[$v['ikey']]=unserialize($v['value']);
            }
            if($list['plate_one']['icon']==''){
                $list['plate_one']['icon']=$_W['siteroot'].'addons/kundian_farm/resource/image/icon-01.png';
            }
            if($list['plate_two']['icon']==''){
                $list['plate_two']['icon']=$_W['siteroot'].'addons/kundian_farm/resource/image/icon-02.png';
            }
            if($list['plate_three']['icon']==''){
                $list['plate_three']['icon']=$_W['siteroot'].'addons/kundian_farm/resource/image/icon-04.png';
            }
            $homeBtm=$list;
        }else{
            $list['plate_one']['icon']=$_W['siteroot'].'addons/kundian_farm/resource/image/icon-01.png';
            $list['plate_two']['icon']=$_W['siteroot'].'addons/kundian_farm/resource/image/icon-02.png';
            $list['plate_three']['icon']=$_W['siteroot'].'addons/kundian_farm/resource/image/icon-04.png';
            $homeBtm=$list;
        }
        return $homeBtm;
    }

    /** 获取个人中信息用户相关信息*/
    public function getUserInfo(){
        //查询订单信息
        if($this->uid!=0) {
            $userInfo=pdo_get('cqkundian_farm_user',array('uid'=>$this->uid,'uniacid'=>$this->uniacid));
            if($userInfo['is_distributor']==0){  //当前用户不是分销商
                $is_check=pdo_get('cqkundian_farm_distribution_check',array('uid'=>$this->uid,'uniacid'=>$this->uniacid));
                if(!empty($is_check) && $is_check['status']==0){    //是否提交分销商的申请 并且申请还未审核时
                    $userInfo['is_distributor']=2;
                }
            }
            $nopayCon=array(
                'status'=>0,
                'apply_delete'=>0,
                'uniacid'=>$this->uniacid,
                'uid'=>$this->uid,
                'use_is_delete'=>0,
                'order_type'=>0
            );
            $noPayOrder = pdo_getall('cqkundian_farm_shop_order', $nopayCon);
            $request['noPayCount'] = count($noPayOrder);
            $peiCon=array(
                'status'=>1,
                'is_send'=>0,
                'uniacid'=>$this->uniacid,
                'uid'=>$this->uid,
                'use_is_delete'=>0,
                'apply_delete'=>0,
            );
            $peiOrder = pdo_getall('cqkundian_farm_shop_order', $peiCon);
            $request['peiCount'] = count($peiOrder);
            $getCon=array(
                'is_send'=>1,
                'is_confirm'=>0,
                'apply_delete'=>0,
                'uniacid'=>$this->uniacid,
                'uid'=>$this->uid,
            );
            $getOrder = pdo_getall('cqkundian_farm_shop_order', $getCon);
            $request['getCount'] = count($getOrder);
            $request['userInfo']=$userInfo;
        }else{
            $request['noPayCount'] =0;
            $request['peiCount'] =0;
            $request['getCount'] =0;
        }
        //判断用户
        $is_admin=pdo_get('cqkundian_farm_employee',array('uid'=>$this->uid));
        if(!empty($is_admin)){
            $request['is_admin']=1;
        }else{
            $request['is_admin']=2;
        }
        echo json_encode($request);die;
    }

    /** 获取个人中心其他信息*/
    public function getCenterData(){
        global $_W,$_GPC;
        if($this->uid!=0) {
            $nopayCon=array(
                'status'=>0,
                'apply_delete'=>0,
                'uniacid'=>$this->uniacid,
                'uid'=>$this->uid,
                'use_is_delete'=>0,
                'order_type'=>0
            );
            $noPayOrder = pdo_getall('cqkundian_farm_shop_order', $nopayCon);
            $request['noPayCount'] = count($noPayOrder);
            $peiCon=array(
                'status'=>1,
                'is_send'=>0,
                'uniacid'=>$this->uniacid,
                'uid'=>$this->uid,
                'use_is_delete'=>0,
                'apply_delete'=>0,
            );
            $peiOrder = pdo_getall('cqkundian_farm_shop_order', $peiCon);
            $request['peiCount'] = count($peiOrder);
            $getCon=array(
                'is_send'=>1,
                'is_confirm'=>0,
                'apply_delete'=>0,
                'uniacid'=>$this->uniacid,
                'uid'=>$this->uid,
            );
            $getOrder = pdo_getall('cqkundian_farm_shop_order', $getCon);
            $request['getCount'] = count($getOrder);
            $is_admin=pdo_get('cqkundian_farm_employee',array('uid'=>$this->uid));
            if(!empty($is_admin)){
                $request['is_admin']=1;
            }else{
                $request['is_admin']=2;
            }

            $userInfo=pdo_get('cqkundian_farm_user',array('uid'=>$this->uid,'uniacid'=>$this->uniacid));
            if($userInfo['is_distributor']==0){  //当前用户不是分销商
                $is_check=pdo_get('cqkundian_farm_distribution_check',array('uid'=>$this->uid,'uniacid'=>$this->uniacid));
                if(!empty($is_check) && $is_check['status']==0){    //是否提交分销商的申请 并且申请还未审核时
                    $userInfo['is_distributor']=2;
                }
            }
            $request['userInfo']=$userInfo;
        }else{
            $request['noPayCount'] =0;
            $request['peiCount'] =0;
            $request['getCount'] =0;
            $request['is_admin']=2;
        }
        $aboutData=pdo_get('cqkundian_farm_about',array('uniacid'=>$this->uniacid));
        $request['aboutData']=$aboutData;
        $back_img=$_W['siteroot'].'addons/kundian_farm/resource/image/water-1.png';
        $request['back_img']=$back_img;

        $pageData=pdo_get('cqkundian_farm_page_set',array('uniacid'=>$this->uniacid,'page_name'=>'center'));
        if(!empty($pageData)){
            $page=unserialize($pageData['page_value']);
            if(empty($page)){
                $page=neatenCenterPage($this->uniacid);
            }
            $page=self::$common->objectToArray($page);
            if($page['currentType']==2){
                $usedList=[];
                $len=ceil(count($page['usedList'])/2);
                for($i=0;$i<$len;$i++) {
                    $usedList[] = array_slice($page['usedList'], $i * 2 ,2);
                }
                $page['usedList']=$usedList;
            }
        }else{
            $page=neatenCenterPage($this->uniacid);
        }
        $request['page']=$page;
        echo json_encode($request);die;
    }

}