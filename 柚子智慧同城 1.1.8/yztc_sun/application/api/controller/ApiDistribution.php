<?php
namespace app\api\controller;
use app\model\Distributionmercapdetails;
use app\model\Distributionorder;
use app\model\Distributionpromoter;
use app\model\Distributionset;
use app\model\Distributionwithdraw;
use app\model\User;
use think\Db;

class ApiDistribution extends Api
{
    //获取佣金明细记录
    public function getMercapdetails(){
        $distributionmercapdetailsModel=new Distributionmercapdetails();
        $distributionmercapdetailsModel->fill_order_limit_length();
        $query = function ($query){
            $user_id=input('request.user_id');
            $query->where('user_id',intval($user_id));
        };
        $data=$distributionmercapdetailsModel->where($query)->order('id desc')->select();
        success_json($data);
    }
    //获取提现明细记录
    public function getWithdrawList(){
        $distributionwithdrawModel =new Distributionwithdraw();
        $distributionwithdrawModel->fill_order_limit_length();//分页，排序
        $query = function ($query){
            $user_id=input('request.user_id');
            $query->where('user_id',intval($user_id));
            $type=input('request.type')?input('request.type'):0;
            if($type==1){
                $query->where('status',0);
                $query->where('is_state',1);
                $query->where('state',0);
            }else if($type==2){
                $query->where('status',1);
            }else if($type==3){
                $query->where('state',2);
            }else if($type==4){
                $query->where('status',2);
            }
        };
        $data=$distributionwithdrawModel->field('id,wd_type,status,is_state,state,money,realmoney,ratesmoney,tx_time,create_time')->where($query)->order('id desc')->select();
        $data=objecttoarray($data);
        success_json($data);
    }
    //获取合伙人信息
    public function getDistributionpromoterDetail(){
        $user_id=input('request.user_id');
        $data=Distributionpromoter::get(['user_id'=>$user_id]);
        $data['withdraw_money']=(new Distributionwithdraw())->getWithdrawMoney($user_id);
        $data['wait_money']=(new Distributionwithdraw())->getWaitMoney($user_id);
        success_json($data);
    }
    //申请提现
    public function setWithDraw(){
        global $_W;
        $user_id=input('request.user_id');
        $money=input('request.money');
        $wd_name=input('request.wd_name');
        $wd_phone=input('request.wd_phone');
        $wd_type=input('request.wd_type')?input('request.wd_type'):1;
        $wd_account=input('request.wd_account')?input('request.wd_account'):'';
        $user=User::get($user_id);
        if(!$user){
            error_json('用户不存在');
        }
        $distributionpromoterModel=new Distributionpromoter();
        $distributionpromoter=$distributionpromoterModel::get(['user_id'=>$user_id]);
        if(!$distributionpromoter){
            error_json('不存在该合伙人');
        }
        if($distributionpromoter['check_status']==1){
            error_json('该合伙人审核中,不能申请提现');
        }
        if($distributionpromoter['check_status']==3){
            error_json('该申请合伙人失败,不能申请提现');
        }
        if($distributionpromoter['canwithdraw']-$distributionpromoter['freezemoney']<$money){
            error_json('可提现余额不足');
        }
        if($money<=0){
            error_json('提现金额必须大于0');
        }
        if($money<1){
            error_json('实际提现金额最少￥1');
        }
        $distributionset=Distributionset::get_curr();
        if(!$distributionset){
            error_json('请先配置提现设置');
        }
        if($money<$distributionset['min_withdraw']){
            error_json('最低提现金额为￥'.$distributionset['min_withdraw']);
        }
        //判断一天申请提现金额
        $starttime = strtotime(date("Y-m-d"));
        $endtime = strtotime(date("Y-m-d")." 23:59:59");
        $oneday_money=Db::name('distributionwithdraw')->where(array('user_id'=>$user_id,'create_time'=>array('between',array($starttime,$endtime))))->sum('money');
        if($oneday_money+$money>$distributionset['daymax_withdraw']){
            error_json('超过当日最大提现额度，无法提现！');
        }
        //微信提现
       // if($with_type==1){
            //冻结分销商金额
            $distributionpromoterModel->where(['id'=>$distributionpromoter['id']])->setInc('freezemoney',$money);
            //手续费
            $ratesmoney=0;
            $ratesmoney1=0;
            if($distributionset['withdraw_fee']>0&&$wd_type==1){
                $ratesmoney=sprintf("%.2f",$distributionset['withdraw_fee']/100*$money);
                $ratesmoney1=sprintf("%.2f",$distributionset['withdraw_fee']/100*$money);
            }
            $lowestmoney=$ratesmoney1+1;
            if($distributionset['min_withdraw']>$lowestmoney){
                $lowestmoney=$distributionset['min_withdraw'];
            }
            if($money<$lowestmoney){
                error_json('最低提现金额￥'.$lowestmoney.'元');
            }

            //实际提现金额
            $realmoney=sprintf("%.2f",$money-$ratesmoney);
            //增加提现记录
            $withdraw=[
                'user_id'=>$user_id,
                'promoter_id'=>$distributionpromoter['id'],
                'openid'=>$user['openid'],
                'wd_type'=>$wd_type,
                'wd_account'=>$wd_account,
                'wd_name'=>$wd_name,
                'wd_phone'=>$wd_phone,
                'money'=>$money,
                'realmoney'=>$realmoney,
                'ratesmoney'=>$ratesmoney,
            ];
            if($money<=$distributionset['pass_money']&&$wd_type==1){
                $withdraw['is_state']=0;
            }else{
                $withdraw['is_state']=1;
            }
            (new Distributionwithdraw())->allowField(true)->save($withdraw);
            $withdraw_id=Db::name('distributionwithdraw')->getLastInsID();
            $distributionpromoter=Distributionpromoter::get($distributionpromoter['id']);
            //增加合伙人分销明细
            $detail='合伙人提现-提现总金额:￥'.$money.';支付手续费:￥'.$ratesmoney.';实际提现金额:￥'.$realmoney;
            if($wd_type==1){
                $mcd_type=2;
            }else  if($wd_type==2){
                $mcd_type=6;
            }else  if($wd_type==3){
                $mcd_type=7;
            }
            $data=[
                'user_id'=>$user_id,
                'promoter_id'=>$distributionpromoter['id'],
                'type'=>5,
                'mcd_type'=>$mcd_type,
                'openid'=>$user['openid'],
                'sign'=>2,
                'mcd_memo'=>$detail,
                'money'=>$money,
                'realmoney'=>$realmoney,
                'ratesmoney'=>$ratesmoney,
                'wd_id'=>$withdraw_id,
                'now_money'=>$distributionpromoter['canwithdraw']-$distributionpromoter['freezemoney'],
            ];
            (new Distributionmercapdetails())->allowField(true)->save($data);
            $withdraw=Db::name('distributionwithdraw')->find($withdraw_id);
            $arr=$this->tixian($withdraw);
            if($withdraw['is_state']==1){
                success_json('提现申请已提交,请等待审核');
            }else if($withdraw['is_state']==0){
                if($arr['return_code']=='SUCCESS'&&$arr['result_code']=='SUCCESS'){
                    success_json('提现成功请在微信钱包查看。');
                }else{
                    //提现失败返还 减少商户冻结资金
                    $distributionpromoterModel->where(['id'=>$distributionpromoter['id']])->setDec('freezemoney',$money);
                    //更新提现状态
                    Db::name('distributionwithdraw')->where(array('uniacid'=>$_W['uniacid'],'id'=>$withdraw_id))->update(array('return_status'=>1,'return_time'=>time()));
                    //增加合伙人分销金额明细
                    $distributionpromoter=Distributionpromoter::get($distributionpromoter['id']);
                    $mcd_memo="合伙人提现失败返还-提现总金额:￥$money;支付手续费:￥$ratesmoney;实际提现金额:￥$realmoney";
                    $data=[
                        'user_id'=>$user_id,
                        'promoter_id'=>$distributionpromoter['id'],
                        'type'=>5,
                        'mcd_type'=>5,
                        'openid'=>$user['openid'],
                        'sign'=>1,
                        'mcd_memo'=>$mcd_memo,
                        'money'=>$money,
                        'realmoney'=>$realmoney,
                        'ratesmoney'=>$ratesmoney,
                        'wd_id'=>$withdraw_id,
                        'now_money'=>$distributionpromoter['canwithdraw']-$distributionpromoter['freezemoney'],
                    ];
                    (new Distributionmercapdetails())->allowField(true)->save($data);
                    error_json('提现失败，原因'.$arr['err_code_des'].'请联系平台管理人员');
                }
            }

        //}

    }
    private function tixian($withdraw)
    {
        global $_W;
        if ($withdraw['is_state'] == 1) {
            return false;
            exit;
        }
        if ($withdraw['status'] == 1) {
            return false;
            exit;
        }
        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $system=Db::name('system')->where(array('uniacid'=>$_W['uniacid']))->find();
        $data['mch_appid']=$system['appid'];
        $data['mchid'] =$system['mchid'];
        $data['nonce_str']=$this->createNoncestr();
        $data['partner_trade_no']=date("YmdHis") .rand(11111, 99999);
        $data['openid']=$withdraw['openid'];
        $data['check_name']='NO_CHECK';
        $data['amount']=$withdraw['realmoney']*100;
        $data['desc']='提现';
        $data['spbill_create_ip']=$_SERVER['REMOTE_ADDR'];
        $data['sign']=$this->getSign($data,$system['wxkey']);
        $xml=$this->postXmlCurl($data,$url);
        //保存报文信息
        Db::name('distributionwithdraw')->where(array('id'=>$withdraw['id']))->update(array('baowen'=>$xml));
        //添加报文记录
        $baowen=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$withdraw['openid'],
            'money'=>$withdraw['realmoney'],
            'baowen'=>$xml,
            'wd_id'=>$withdraw['id'],
            'type'=>1,
            'add_time'=>time(),
            'request_data'=>json_encode($data),
        );
        Db::name('withdrawbaowen')->insert($baowen);
        //更改提现状态 商家明细提现状态
        $arr=xml2array($xml);
        if($arr['return_code']=='SUCCESS'&&$arr['result_code']=='SUCCESS'){
            Db::name('distributionwithdraw')->where(array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']))->update(array('status'=>1,'tx_time'=>time(),'request_time'=>time()));
            Db::name('distributionmercapdetails')->where(array('uniacid'=>$_W['uniacid'],'wd_id'=>$withdraw['id']))->update(array('status'=>1));
            //提现成功减少可提现金额 减少冻结资金
            Db::name('distributionpromoter')->where(array('id'=>$withdraw['promoter_id']))->setDec('canwithdraw',$withdraw['money']);
            Db::name('distributionpromoter')->where(array('id'=>$withdraw['promoter_id']))->setDec('freezemoney',$withdraw['money']);
        }else{
            Db::name('distributionwithdraw')->where(array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']))->update(array('status'=>2,'request_time'=>time(),'err_code'=>$arr['err_code'],'err_code_des'=>$arr['err_code_des']));
            Db::name('distributionmercapdetails')->where(array('uniacid'=>$_W['uniacid'],'wd_id'=>$withdraw['id']))->update(array('status'=>2));
        }
        return $arr;
    }

    //作用：产生随机字符串，不长于32位
    private function createNoncestr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    //作用：生成签名
    private function getSign($Obj,$key) {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    //作用：格式化参数，签名过程需要使用
    private function formatBizQueryParaMap($paraMap, $urlencode) {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    private  function postXmlCurl($xml, $url, $second = 30)
    {
        global $_W;
        if(!$url){
            $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";//微信退款地址，post请求
        }
        $xml = $this->arrayToXmls($xml);
        $refund_xml='';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, IA_ROOT . '/addons/yztc_sun/cert/apiclient_cert_'.$_W['uniacid'].'.pem');
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, IA_ROOT . '/addons/yztc_sun/cert/apiclient_key_'.$_W['uniacid'].'.pem');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $refund_xml = curl_exec($ch);
        // 返回结果0的时候能只能表明程序是正常返回不一定说明退款成功而已
        $errono = curl_errno($ch);
        curl_close($ch);
        return $refund_xml;
    }
    function arrayToXmls($arr)
    {
        $xml = "<root>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</root>";
        return $xml;
    }


    //获取分销订单列表信息
    public function getDistributionorderList(){
        global $_W, $_GPC;
        $uniacid = $_W["uniacid"];
        $user_id=input('request.user_id');
        $type=input('request.type');//1普通商品 2抢购商品 3拼团商品 4会员卡
        $status=input('request.status');//1 全部 2待付款 3已付款 4完成
        $page=input('request.page')?input('request.page'):1;
        $length = input('request.length')?input('request.length'):5;
        $pageindex = ($page-1)*$length;
        $where = " where os.type=$type and os.uniacid='".$uniacid."' AND (os.parents_id_1='".$user_id."' or os.parents_id_2='".$user_id."' or os.parents_id_3='".$user_id."') ";
        if($type!=4){
            if($status==1){
            }else if($status==2){
                $where.=" and o.order_status=10";
            }else if($status==3){
                $where.=" and o.order_status=20 and o.after_sale=0 ";
            }else if($status==4){
                $where.=" and o.order_status>=40 ";
            }
        }
        if($type==1){
            $sql='select o.order_no,o.num,o.order_status,o.after_sale,os.order_id,o.gid,u.avatar,u.nickname,o.order_amount,os.first_price,os.second_price,os.third_price from '.tablename('yztc_sun_distributionorder').' as os left join '.tablename('yztc_sun_order').' as o on os.order_id=o.id left join '.tablename('yztc_sun_user').' as u on os.user_id=u.id ';
        }else if($type==2){
            $sql='select o.order_no,o.num,o.attr_list,o.pid,o.order_status,o.after_sale,os.order_id,o.pid as gid,u.avatar,u.nickname,o.order_amount,os.first_price,os.second_price,os.third_price from '.tablename('yztc_sun_distributionorder').' as os left join '.tablename('yztc_sun_panicorder').' as o on os.order_id=o.id left join '.tablename('yztc_sun_user').' as u on os.user_id=u.id ';
        }else if($type==3){
            $sql='select o.order_no,o.num,o.attr_list,o.goods_id as gid,o.order_status,o.after_sale,os.order_id,u.avatar,u.nickname,o.order_amount,os.first_price,os.second_price,os.third_price from '.tablename('yztc_sun_distributionorder').' as os left join '.tablename('yztc_sun_pinorder').' as o on os.order_id=o.id left join '.tablename('yztc_sun_user').' as u on os.user_id=u.id ';
        }else if($type==4){
            $sql='select o.out_trade_no as order_no,o.name,o.money as order_amount,os.order_id,u.avatar,u.nickname,os.first_price,os.second_price,os.third_price from '.tablename('yztc_sun_distributionorder').' as os left join '.tablename('yztc_sun_openvip').' as o on os.order_id=o.id left join '.tablename('yztc_sun_user').' as u on os.user_id=u.id ';
        }else if($type==5){
            $sql='select o.order_no,o.num,o.order_status,o.after_sale,os.order_id,o.gid,u.avatar,u.nickname,o.order_amount,os.first_price,os.second_price,os.third_price from '.tablename('yztc_sun_distributionorder').' as os left join '.tablename('yztc_sun_order').' as o on os.order_id=o.id left join '.tablename('yztc_sun_user').' as u on os.user_id=u.id ';
        }
        $sql.=$where.' order by os.id desc limit '.$pageindex.",".$length;
        $data=Db::query($sql);
        foreach($data as &$val){
            if($type==1||$type==5){
                $val['goods']=Db::name('orderdetail')->where(array('order_id'=>$val['order_id']))->find();
            }else if($type==2){
                $val['goods']=Db::name('panic')->find($val['pid']);
            }else if($type==3){
                $val['goods']=Db::name('pingoods')->find($val['gid']);
            }
        }
        success_withimg_json($data);
    }
    //获取团队成员信息
    public function getTeamLevel(){
        $user_id = intval(input('request.user_id'));
        $level = intval(input('request.level'));
        $page= input('request.page')? input('request.page'):1;
        $length=input('request.length')? input('request.length'):10;
        $pageindex=($page-1)*$length;
        if($level==1){
            $sql = "select id,avatar,nickname,create_time from ims_yztc_sun_user where  parents_id=$user_id order by id desc ";
        }elseif($level==2){
            $sql = "SELECT id,avatar,nickname,create_time FROM ims_yztc_sun_user WHERE parents_id=ANY(SELECT id as user1 FROM ims_yztc_sun_user WHERE parents_id=$user_id) ";
        }elseif($level==3){
            $sql = "SELECT id,avatar,nickname,create_time FROM ims_yztc_sun_user WHERE parents_id=ANY(SELECT id as user1 FROM ims_yztc_sun_user WHERE parents_id=ANY(SELECT id as user2 FROM ims_yztc_sun_user WHERE parents_id=$user_id)) ";
        }
        $sql = $sql." limit ".$pageindex.",".$length;
        $data=Db::query($sql);
        success_withimg_json($data);
    }

    //获取分销配置信息
    public function getDistributionset(){
        $distributionset=Distributionset::get_curr();
        $distributionpromoter=(new Distributionpromoter())->limit(10)->select();
        $distributionset['distributionpromoter']=$distributionpromoter;
        success_withimg_json($distributionset);
    }
    //申请成为经销商下线
    public function setDistributionParents(){
        $user_id=input('request.user_id');
        $parents_id=input('request.parents_id');
        //判断父级是不是分销商
        if(!Distributionpromoter::is_promoter($parents_id)){
            error_json('不是分销商不能成为下级');
        }
        //判断用户是不是经销商
        if(Distributionpromoter::is_promoter($user_id)){
            error_json('该用户为经销商不能申请成为上级');
        }
        $user=User::get($user_id);
        if(!$user){
            error_json('用户不存在');
        }
        if($user['parents_id']){
            error_json('已有上级不能申请上级');
        }
        if($user['id']==$parents_id){
            error_json('上级不能为自己');
        }
        $distributionset=Distributionset::get_curr();
        //首次点击链接条件
        if($distributionset['lower_condition']==1){
            $parents=User::get(['id'=>$parents_id]);
            (new User())->allowField(true)->save(['parents_id'=>$parents_id,'parents_name'=>$parents['nickname']],['id'=>$user_id]);
            success_json('申请成功');
        }else{
            error_json('暂未开放成为下线条件');
        }
    }
    //判断是否为分销商
    public function isDistributionpromoter(){
        $user_id=input('request.user_id');
        $distributionpromoterModel=new Distributionpromoter();
        $distributionpromoter=$distributionpromoterModel::get(['user_id'=>$user_id]);
        if($distributionpromoter){
            //获取总分销订单、数量获取我的团队、获取未结算佣金
            $team=(new Distributionorder())->getMyTeam($user_id);
            $distributionpromoter['team']=$team;
        }
        success_json($distributionpromoter);
    }
    //申请分销商(合伙人)
    public function setDistributionpromoter(){
        $user_id=input('request.user_id');
        $form_id=input('request.form_id');
        $name=input('request.name');
        $phone=input('request.phone');
        $distributionpromoterModel=new Distributionpromoter();
        $distributionpromoter=$distributionpromoterModel::get(['user_id'=>$user_id]);
        if($distributionpromoter['check_status']==1){
            error_json('您申请合伙人正在审核中');
        }
        if($distributionpromoter['check_status']==2){
            error_json('您已经是合伙人,请不要重复申请');
        }
        $distributionset=Distributionset::get_curr();
        $user=User::get($user_id);
        $data=[
            'condition_type'=>$distributionset['distribution_condition'],
            'user_id'=>$user_id,
            'referrer_name'=>$user['parents_name'],
            'referrer_uid'=>$user['parents_id'],
            'form_id'=>$form_id,
        ];
        if($distributionset['is_check']==1){
            $data['check_status']=1;
        }else{
            $data['check_status']=2;
            $data['check_time']=time();
        }
        switch ($distributionset['distribution_condition']){
            case 1:
                break;
            case 2:
                $data['name']=$name;
                $data['phone']=$phone;
                break;
            case 3:
                if($user['total_consume']<$distributionset['consumption_money']){
                    error_json('不符合消费总条件');
                }
                break;
            case 4:
                error_json('该模式暂未完成');
                break;
            case 5:
                if(User::isVip($user_id)==0){
                    error_json('不符合会员条件');
                }
                break;
            default:
                error_json('缺少申请成为分销商方式');
        }
        if($distributionpromoter['id']){
            $distributionpromoterModel->allowField(true)->save($data,['id'=>$distributionpromoter['id']]);
        }else{
            $distributionpromoterModel->allowField(true)->save($data);
        }
        success_json($distributionpromoterModel::get(['user_id'=>$user_id]));
    }
}
