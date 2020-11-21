<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/10/12
 * Time: 11:56
 */
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
class Common_KundianFarmModel{
    protected $tableName='cqkundian_farm_set';
    protected $formIdTable='cqkundian_farm_form_id';
    public function __construct($tableName=''){
        if(!empty($tableName)){
            $this->tableName=$tableName;
        }
    }

    /** 获取配置信息 */
    public function getSetData($field,$uniacid){
        $condition=array(
            'ikey'=>$field,
            'uniacid'=>$uniacid,
        );
        $nowList=pdo_getall($this->tableName,$condition);
        $list=array();
        foreach ($nowList as $key => $value) {
            $list[$value['ikey']]=$value['value'];
        }
        return $list;
    }

    /**
     * 生成订单号
     * @return string
     */
    public function getUniqueOrderNumber(){
        $number= date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        return $number;
    }

    /**
     * 插入配置信息
     * @param $data
     * @param $uniacid
     * @return bool|int
     */
    public function insertSetData($data,$uniacid){
        $res=0;
        foreach ($data as $k=>$v){
            $insertData=array(
                'ikey'=>$k,
                'value'=>$v,
                'uniacid'=>$uniacid,
            );
            $cond=array(
                'ikey'=>$k,
                'uniacid'=>$uniacid,
            );
            $farmData=pdo_get($this->tableName,$cond);
            if(empty($farmData)){
                $res+=pdo_insert($this->tableName,$insertData);
            }else{
                $res+=pdo_update($this->tableName,$insertData,$cond);
            }
        }

        return $res;
    }

    /** 后台配置信息插入*/
    public function insertManagerData($data,$uniacid){
        $res=0;
        foreach ($data as $key=>$v){
            $updateData=array(
                'ikey'=>$key,
                'value'=>$v,
                'uniacid'=>$uniacid,
            );
            $cond=array(
                'ikey'=>$key,
                'uniacid'=>$uniacid,
            );
            $farmData=pdo_get('cqkundian_farm_manager_set',$cond);
            if(empty($farmData)){
                $res+=pdo_insert('cqkundian_farm_manager_set',$updateData);
            }else{
                $res+=pdo_update('cqkundian_farm_manager_set',$updateData,$cond);
            }
        }
        return $res;
    }



    /**
     * 发送短信通知
     * @param $messageSet   短信配置西悉尼
     * @param $sms_template 短信模板
     * @param $phone        手机号
     * @param $sms_param    参数配置
     * @return array
     */
    public function sendAliyunSms($messageSet,$sms_template,$phone,$sms_param){
        $params = array ();
        $accessKeyId = $messageSet['sms_access_key'];
        $accessKeySecret = $messageSet['sms_access_key_secret'];
        $params["PhoneNumbers"] = $phone;
        $params["SignName"] = $messageSet['sms_sign'];
        $params["TemplateCode"] =$sms_template;
        $params['TemplateParam'] = $sms_param;
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        include ROOT_PATH.'vendor/aliyun/SignatureHelper.php';
        $helper = new \Aliyun\DySDKLite\SignatureHelper();
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );
        if($content->Message=="OK"){
            return array('err_code'=>0);
        }else{
            return array('err_code'=>1,'msg'=>$content->Message);
        }
    }


    /**
     * 检验插件是否开启使用
     * @param $plugin_name  //插件名称简写
     * @param $uniacid      //小程序唯一id
     * @return bool
     */
    public function checkInstallPlugin($plugin_name,$uniacid){
        error_reporting(0);
        $is_install=false;
        if($plugin_name=='plugin_funding'){
            if (pdo_tableexists('cqkundian_farm_plugin_funding_set')) {
                $fundSet=pdo_get('cqkundian_farm_plugin_funding_set',array('uniacid'=>$uniacid,'ikey'=>'is_open_funding'));
                if($fundSet['value']==1){
                    $is_install=true;
                }
            }
        }elseif ($plugin_name=='plugin_active'){
            if (pdo_tableexists('cqkundian_farm_plugin_active_set')) {
                $fundSet=pdo_get('cqkundian_farm_plugin_active_set',array('uniacid'=>$uniacid,'ikey'=>'is_open_active'));
                if($fundSet['value']==1){
                    $is_install=true;
                }
            }
        }elseif ($plugin_name=='plugin_play'){
            if (pdo_tableexists('cqkundian_farm_plugin_play_set')) {
                $fundSet=pdo_get('cqkundian_farm_plugin_play_set',array('uniacid'=>$uniacid,'ikey'=>'is_open_recovery'));
                if($fundSet['value']==1){
                    $is_install=true;
                }
            }
        }elseif ($plugin_name=='plugin_play_install'){
            if (pdo_tableexists('cqkundian_farm_plugin_play_set')) {
                $is_install=true;
            }
        }elseif ($plugin_name=='plugin_pt'){
            $plugin_pt=WeUtility::createModuleHook('kundian_farm_plugin_pt');
            if($plugin_pt->module){
                $is_install=true;
            }
        }elseif ($plugin_name=='plugin_store'){
            $plugin_pt=WeUtility::createModuleHook('kundian_farm_plugin_store');
            if($plugin_pt->module){
                $is_install=true;
            }
        }
        return $is_install;
    }

    /**
     * 整理众筹信息
     * @param $project
     * @return mixed
     */
    public function getProjectProgress($project){
        $project['fund_money']=$project['fund_money']+$project['fund_fictitious_money'];   //总共众筹金额
        $project['target_money']=$project['target_money']+$project['fund_fictitious_money'];    //总共目标金额
        $project['progress']=round($project['fund_money']/$project['target_money']*100,2);     //计算进度
        $project['fund_person_count']=$project['fund_person_count']+$project['fictitious_person'];

        //判断项目是否结束
        if($project['begin_time'] < time()) {
            if ($project['end_time'] > time()) {
                if ($project['fund_money'] >= $project['target_money']) {
                    $project['project_status'] = 3; //众筹成功
                    $project['project_status_text'] ='众筹成功';
                } else {
                    $project['project_status'] = 2; //进行中
                    $project['project_status_text'] = '进行中';
                }

            } else {
                $project['project_status'] = 1; //已结束
                $project['project_status_text'] = '已结束';
            }
        }else{
            $project['project_status']=0;       //未开始
            $project['project_status_text']='未开始';
        }
        //周期计算
        $time=$project['end_time'] - $project['begin_time'];
        $project['cycle']=floor($time/86400);

        $project['begin_time']=date("Y-m-d",$project['begin_time']);
        $project['end_time']=date("Y-m-d",$project['end_time']);
        $project['profit_send_time']=date("Y-m-d",$project['profit_send_time']);
        return $project;
    }

    /**
     * 获取关于我们的信息
     * @param $uniacid
     * @param $field
     * @return bool
     */
    public function getAboutData($uniacid,$field){
        $list=pdo_get('cqkundian_farm_about',['uniacid'=>$uniacid],$field);
        return $list;
    }

    /**
     * 用户分销佣金分发
     * @param $orderData    订单信息
     * @param $uniacid      小程序唯一id
     * @param $order_type   订单类型
     * @return bool
     */
    public function saleSendPrice($orderData,$uniacid,$order_type){
        require_once ROOT_PATH.'model/user.php';
        $userModel=new User_KundianFarmModel();
        $user=pdo_get('cqkundian_farm_user',array('uniacid'=>$uniacid,'uid'=>$orderData['uid']));
        if($user['one_distributor']!=0) {
            $one_sale = pdo_get('cqkundian_farm_user', array('uniacid' => $uniacid, 'uid' => $user['one_distributor']));
            //一级分销商加佣金
            $update_one_sale=array(
                'total_price +='=>floatval($orderData['one_price']),
                'money +='=>floatval($orderData['one_price']),
            );
            $res=pdo_update('cqkundian_farm_user',$update_one_sale,array('uniacid'=>$uniacid,'uid'=>$user['one_distributor']));
            $userModel->insertRecordMoney($user['one_distributor'],$orderData['one_price'],1,'分销佣金',$uniacid);
//            $this->recordSalePrice($user['one_distributor'],$orderData['uid'],$orderData['one_price'],'一级分销佣金',1,$uniacid,$order_type,$orderData['id']);
            if($res){
                if($one_sale['one_distributor']!=0){
                    $update_two_sale=array(
                        'total_price +='=>floatval($orderData['two_price']),
                        'money +='=>floatval($orderData['two_price']),
                    );
                    //二级分销商加佣金
                    $res_two=pdo_update('cqkundian_farm_user',$update_two_sale,array('uniacid'=>$uniacid,'uid'=>$one_sale['one_distributor']));
                    $userModel->insertRecordMoney($one_sale['one_distributor'],$orderData['two_price'],1,'分销佣金',$uniacid);
//                    $this->recordSalePrice($one_sale['one_distributor'],$orderData['uid'],$orderData['two_price'],'二级分销佣金',1,$uniacid,$order_type,$orderData['id']);
                    return $res_two ? true :false;
                }else{
                    return true;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    /**
     * 记录分销获得的佣金信息记录
     * @param $uid          用户uid
     * @param $one_sale_uid 分销商uid
     * @param $price        佣金
     * @param $remark       备注
     * @param $do_type      佣金 1加 2 减
     * @param $uniacid      小程序唯一id
     * @param $order_type   订单类型
     * @param $order_id     订单编号
     */
    public function recordSalePrice($uid,$one_sale_uid,$price,$remark,$do_type,$uniacid,$order_type,$order_id){
        $data=array(
            'uid'=>$uid,
            'one_sale_uid'=>$one_sale_uid,
            'price'=>$price,
            'remark'=>$remark,
            'do_type'=>$do_type,
            'uniacid'=>$uniacid,
            'create_time'=>time(),
            'order_type'=>$order_type,
            'order_id'=>$order_id
        );
        pdo_insert('cqkundian_farm_sale_price_record',$data);
    }

    /**
     * 获取底部导航信息
     * @param $cond
     * @param $mutilple
     * @return array
     */
    public function selectTarBar($cond,$mutliple=true){
        if($mutliple){
            $list=pdo_getall('cqkundian_farm_tarbar',$cond,'','','rank asc');
        }else{
            $list=pdo_get('cqkundian_farm_tarbar',$cond);
        }
        return $list;
    }

    /**
     * 新增formid信息
     * @param $form_id  小程序生成的formid
     * @param $uid      操作用户UId
     * @param $openid   小程序用户标志openid
     * @param $count    可用次数 form_id 可用一次，支付 $prepay_id 可使用3次
     * @param $uniacid  小程序唯一标志
     * @return bool
     */
    public function insertFormIdData($form_id,$uid,$openid,$count,$uniacid){
        if(empty($uid) || $form_id==undefined || $form_id=='the formId is a mock one' ||$form_id==''){
            return false;
        }

        if(empty($openid)){
            $user=pdo_get('cqkundian_farm_user',['uid'=>$uid,'uniacid'=>$uniacid]);
            $openid=$user['openid'];
        }
        $insertData=array(
            'formid'=>$form_id,
            'openid'=>$openid,
            'count'=>$count,
            'uniacid'=>$uniacid,
            'create_time'=>time(),
            'uid'=>$uid,
        );
        return pdo_insert($this->formIdTable,$insertData);
    }

    /**
     * 获取formid 信息
     * @param $uid
     * @param $uniacid
     * @return bool
     */
    public function getFormId($uid,$uniacid){
        $severn_day=strtotime('-7 day');
        $sql="SELECT * FROM ".tablename($this->formIdTable)." WHERE uid = :uid AND uniacid=:uniacid AND create_time >:time ORDER BY create_time DESC LIMIT 1";
        $formId = pdo_fetch($sql, array(':uid' => $uid,':uniacid'=>$uniacid,':time'=>$severn_day));
        return $formId;
    }

    /**
     * 更新formid信息
     * @param $formId
     */
    public function updateFormId($formId){
        if($formId['count']==1){
            pdo_delete($this->formIdTable,['id'=>$formId['id'],'uniacid'=>$formId['uniacid']]);
        }else{
            pdo_update($this->formIdTable,['count -='=>1],['id'=>$formId['id'],'uniacid'=>$formId['uniacid']]);
        }
    }


    //数组转对象
    public function array_to_object($arr) {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)$this->array_to_object($v);
            }
        }

        return (object)$arr;
    }

    public function objectToArray($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)$this->objectToArray($v);
            }
        }
        return $obj;
    }

    /** 隐藏字符 */
    public function substr_cut($user_name){
        if($user_name){
            $strlen     = mb_strlen($user_name, 'utf-8');
            $firstStr     = mb_substr($user_name, 0, 1, 'utf-8');
            $lastStr     = mb_substr($user_name, -1, 1, 'utf-8');
            return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
        }
        return $user_name;


    }


    public function linkUrl($uniacid,$isChild=false){
        $link=[
            ['link_type'=>'21','is_home'=>'true', 'path'=>'kundian_farm/pages/HomePage/index/index', 'name'=>'首页' ,'e_name'=>'home','is_child'=>0],
            ['link_type'=>'5','is_home'=>'true', 'path'=>'kundian_farm/pages/shop/index/index', 'name'=>'商城','e_name'=>'shop','is_child'=>1,'child_path'=>'kundian_farm/pages/shop/prodeteils/index?goodsid='],
            ['link_type'=>'7','is_home'=>'true', 'path'=>'kundian_farm/pages/shop/integral/exchange/index', 'name'=>'积分商城','e_name'=>'integral','is_child'=>1,'child_path'=>'kundian_farm/pages/shop/integral/exchangedetails/index?goods_id='],
            ['link_type'=>'20','is_home'=>'true', 'path'=>'kundian_farm/pages/user/center/index', 'name'=>'我的','e_name'=>'center','is_child'=>0],
            ['link_type'=>'11','is_home'=>'true', 'path'=>'kundian_farm/pages/shop/buyCar/index', 'name'=>'购物车','e_name'=>'cart','is_child'=>0],
            ['link_type'=>'6','is_home'=>'true', 'path'=>'kundian_farm/pages/shop/Group/index/index', 'name'=>'组团商城','e_name'=>'group','is_child'=>1,'child_path'=>'kundian_farm/pages/shop/Group/proDetails/index?goods_id='],
            ['link_type'=>'4','is_home'=>'true', 'path'=>'kundian_farm/pages/HomePage/live/index', 'name'=>'监控','e_name'=>'live','is_child'=>0],
            ['link_type'=>'2','is_home'=>'true', 'path'=>'kundian_farm/pages/shop/Adopt/index', 'name'=>'认养','e_name'=>'adopt','is_child'=>1,'child_path'=>'kundian_farm/pages/shop/AdoptRules/index?aid='],
            ['link_type'=>'3','is_home'=>'true', 'path'=>'kundian_farm/pages/shop/integral/index/index', 'name'=>'签到','e_name'=>'sign','is_child'=>0],
            ['link_type'=>'1','is_home'=>'true', 'path'=>'kundian_farm/pages/land/landList/index', 'name'=>'租地','e_name'=>'land','is_child'=>1,'child_path'=>'kundian_farm/pages/land/landDetails/index?lid='],

            ['link_type'=>'19','is_home'=>'false', 'path'=>'kundian_farm/pages/common/agreement/index?type=4', 'name'=>'关于我们','e_name'=>'about','is_child'=>0],
            ['link_type'=>'9','is_home'=>'false', 'path'=>'kundian_farm/pages/user/coupon/index/index', 'name'=>'领券中心','e_name'=>'coupon','is_child'=>0],
            ['link_type'=>'12','is_home'=>'false', 'path'=>'kundian_farm/pages/user/addCard/index', 'name'=>'兑换卡','e_name'=>'card','is_child'=>0],
            ['link_type'=>'22','is_home'=>'false', 'path'=>'kundian_farm/pages/shop/VeterinaryIntroduce/index', 'name'=>'团队管理','e_name'=>'team','is_child'=>0],
            ['link_type'=>'8','is_home'=>'false', 'path'=>'kundian_farm/pages/information/index/index', 'name'=>'资讯列表','e_name'=>'information','is_child'=>1,'child_path'=>'kundian_farm/pages/information/article/index?aid='],
            ['link_type'=>'23','is_home'=>'false', 'path'=>'kundian_farm/pages/land/situation/index', 'name'=>'控制台','e_name'=>'control','is_child'=>0],
            ['link_type'=>'17','is_home'=>'false', 'path'=>'kundian_farm/pages/land/order/index', 'name'=>'我的种植','e_name'=>'myLand','is_child'=>0],
            ['link_type'=>'18','is_home'=>'false', 'path'=>'kundian_farm/pages/user/Animal/index', 'name'=>'我的认养','e_name'=>'myAdopt','is_child'=>0],
            ['link_type'=>'10','is_home'=>'false', 'path'=>'kundian_farm/pages/HomePage/issue/index', 'name'=>'常见问题','e_name'=>'question','is_child'=>0],
            ['link_type'=>'27','is_home'=>'false', 'path'=>'kundian_farm/pages/manage/trace/index', 'name'=>'溯源查询','e_name'=>'source_select','is_child'=>0],
            ['link_type'=>'24','is_home'=>'false', 'path'=>'miniprogram', 'name'=>'跳转小程序','e_name'=>'toMiniapp','is_child'=>0],
        ];

        if($this->checkInstallPlugin('plugin_funding',$uniacid)){
            $link[]=['link_type'=>'13','is_home'=>'true', 'path'=>'kundian_funding/pages/index/index', 'name'=>'众筹','e_name'=>'funding','is_child'=>1,'child_path'=>'kundian_funding/pages/prodetail/index?pid='];
        }
        if($this->checkInstallPlugin('plugin_active',$uniacid)){
            $link[]= ['link_type'=>'14','is_home'=>'true', 'path'=>'kundian_active/pages/index/index', 'name'=>'活动','e_name'=>'active','is_child'=>1,'child_path'=>'kundian_active/pages/details/index?activeid='];
        }
        if($this->checkInstallPlugin('plugin_play_install',$uniacid)){
            $link[]= ['link_type'=>'15','is_home'=>'true', 'path'=>'kundian_game/pages/farm/index', 'name'=>'农场乐园','e_name'=>'game','is_child'=>0];
        }
        if($this->checkInstallPlugin('plugin_pt',$uniacid)){
            $link[]= ['link_type'=>'16','is_home'=>'true', 'path'=>'kundian_pt/pages/index/index', 'name'=>'拼团','e_name'=>'pt','is_child'=>1,'child_path'=>'kundian_pt/pages/details/index?goodsid='];
        }

        if($this->checkInstallPlugin('plugin_store',$uniacid)){
            $link[]=['link_type'=>'25','is_home'=>'false', 'path'=>'kundian_store/pages/store/apply/index', 'name'=>'商户申请','e_name'=>'store_apply','is_child'=>0];
            $link[]=['link_type'=>'26','is_home'=>'false', 'path'=>'kundian_store/pages/store/list/index', 'name'=>'商户列表','e_name'=>'store_list','is_child'=>0];
        }
        if($isChild){
            for ($i=0;$i<count($link);$i++){
                if($link[$i]['is_child']==1 ){
                    if($link[$i]['e_name']== 'shop' ){
                        $selectData=pdo_getall('cqkundian_farm_goods',['uniacid'=>$uniacid,'is_put_away'=>1]);
                        foreach ($selectData as $item => $val){
                            $link[$i]['childData'][$item]['id']=$val['id'];
                            $link[$i]['childData'][$item]['title']=$val['goods_name'];
                            $link[$i]['childData'][$item]['cover']=$val['cover'];
                            $link[$i]['childData'][$item]['child_path']=$link[$i]['child_path'].$val['id'];
                        }
                    }
                    if($link[$i]['e_name']== 'integral' ){
                        $selectData=pdo_getall('cqkundian_farm_integral_goods',['uniacid'=>$uniacid,'is_put_away'=>1]);
                        foreach ($selectData as $item => $val){
                            $link[$i]['childData'][$item]['id']=$val['id'];
                            $link[$i]['childData'][$item]['title']=$val['goods_name'];
                            $link[$i]['childData'][$item]['cover']=$val['cover'];
                            $link[$i]['childData'][$item]['child_path']=$link[$i]['child_path'].$val['id'];
                        }
                    }
                    if($link[$i]['e_name']== 'group' ){
                        $selectData=pdo_getall('cqkundian_farm_group_goods',['uniacid'=>$uniacid,'is_put_away'=>1]);
                        foreach ($selectData as $item => $val){
                            $link[$i]['childData'][$item]['id']=$val['id'];
                            $link[$i]['childData'][$item]['title']=$val['goods_name'];
                            $link[$i]['childData'][$item]['cover']=$val['cover'];
                            $link[$i]['childData'][$item]['child_path']=$link[$i]['child_path'].$val['id'];
                        }
                    }
                    if($link[$i]['e_name']== 'adopt' ){
                        $selectData=pdo_getall('cqkundian_farm_animal',['uniacid'=>$uniacid]);
                        foreach ($selectData as $item => $val){
                            $link[$i]['childData'][$item]['id']=$val['id'];
                            $link[$i]['childData'][$item]['title']=$val['animal_name'];
                            $link[$i]['childData'][$item]['cover']=$val['animal_src'];
                            $link[$i]['childData'][$item]['child_path']=$link[$i]['child_path'].$val['id'];
                        }
                    }
                    if($link[$i]['e_name']== 'land' ){
                        $selectData=pdo_getall('cqkundian_farm_land',['uniacid'=>$uniacid]);
                        foreach ($selectData as $item => $val){
                            $link[$i]['childData'][$item]['id']=$val['id'];
                            $link[$i]['childData'][$item]['title']=$val['land_name'];
                            $link[$i]['childData'][$item]['cover']=$val['cover'];
                            $link[$i]['childData'][$item]['child_path']=$link[$i]['child_path'].$val['id'];
                        }
                    }
                    if($link[$i]['e_name']== 'information' ){
                        $selectData=pdo_getall('cqkundian_farm_article',['uniacid'=>$uniacid]);
                        foreach ($selectData as $item => $val){
                            $link[$i]['childData'][$item]['id']=$val['id'];
                            $link[$i]['childData'][$item]['title']=$val['title'];
                            $link[$i]['childData'][$item]['cover']=$val['cover'];
                            $link[$i]['childData'][$item]['child_path']=$link[$i]['child_path'].$val['id'];
                        }
                    }
                    if($link[$i]['e_name']== 'funding' ){
                        $selectData=pdo_getall('cqkundian_farm_plugin_funding_project',['uniacid'=>$uniacid]);
                        foreach ($selectData as $item => $val){
                            $link[$i]['childData'][$item]['id']=$val['id'];
                            $link[$i]['childData'][$item]['title']=$val['project_name'];
                            $link[$i]['childData'][$item]['cover']=$val['cover'];
                            $link[$i]['childData'][$item]['child_path']=$link[$i]['child_path'].$val['id'];
                        }
                    }
                    if($link[$i]['e_name']== 'active' ){
                        $selectData=pdo_getall('cqkundian_farm_plugin_active',['uniacid'=>$uniacid]);
                        foreach ($selectData as $item => $val){
                            $link[$i]['childData'][$item]['id']=$val['id'];
                            $link[$i]['childData'][$item]['title']=$val['title'];
                            $link[$i]['childData'][$item]['cover']=$val['cover'];
                            $link[$i]['childData'][$item]['child_path']=$link[$i]['child_path'].$val['id'];
                        }
                    }
                    if($link[$i]['e_name']== 'pt' ){
                        $selectData=pdo_getall('cqkundian_farm_pt_goods',['uniacid'=>$uniacid]);
                        foreach ($selectData as $item => $val){
                            $link[$i]['childData'][$item]['id']=$val['id'];
                            $link[$i]['childData'][$item]['title']=$val['goods_name'];
                            $link[$i]['childData'][$item]['cover']=$val['cover'];
                            $link[$i]['childData'][$item]['child_path']=$link[$i]['child_path'].$val['id'];
                        }
                    }
                }
            }
        }
        return $link;
    }


    /**
     * 根据起点坐标和终点坐标测距离
     * @param  [array]   $from 	[起点坐标(经纬度),例如:array(118.012951,36.810024)]
     * @param  [array]   $to 	[终点坐标(经纬度)]
     * @param  [bool]    $km        是否以公里为单位 false:米 true:公里(千米)
     * @param  [int]     $decimal   精度 保留小数位数
     * @return [string]  距离数值
     */
    public function get_distance($from,$to,$km=true,$decimal=2){
        sort($from);
        sort($to);
        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $distance = $EARTH_RADIUS * 2 * asin(sqrt(pow(sin(($from[0] * pi() / 180 - $to[0] * pi() / 180) / 2), 2) + cos($from[0] * pi() / 180) * cos($to[0] * pi() / 180) * pow(sin(($from[1] * pi() / 180 - $to[1] * pi() / 180) / 2), 2))) * 1000;
        if ($km) {
            $distance = $distance / 1000;
        }
        return round($distance, $decimal);
    }

    //时间转化
    public function cTime($time){
        return date("Y-m-d H:i:s",$time);
    }

}

