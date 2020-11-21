<?php
defined('IN_IA') or exit ('Access Denied');
//error_reporting(0);
class Distribution{
    public $order_id=0;
    public $ordertype=1;//1普通，2砍价
    public $meno="";
    public $usertype=1;//1为用openid识别用户，2为用uid识别用户
    public $userid="";//用户识别id,openid或者uid
    public $uniacid=0;
    public $leader=array("parent_id_1"=>0,"parent_id_2"=>0,"parent_id_3"=>0);
    public $rebate=0;//判断是否自购，0否，1是

    public function __construct(){
        global $_W;
        $this->uniacid = $_W["uniacid"];
        // echo $this->uniacid;
        // exit;
    }

    //计算分销佣金
    public function computecommission(){
        $uniacid = $this->uniacid;
        if($this->money<=0){
            return false;
        }
        if(empty($this->userid)){
            return false;
        }
        //获取分销设置数据
        $distributionset = $this->getdistributionset();
        if($distributionset){
            //获取所有上级数据
            $this->leader = $this->getleader($distributionset);
            //更新订单中的父级id
            $this->updateorder();
            //计算上级佣金
            $computleadermoney = $this->computleadermoney($distributionset);
            if($computleadermoney){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //获取分销设置，判断分销情况
    private function getdistributionset(){
        $uniacid = $this->uniacid;
        //先判断表是否存在，不存在就断开
        if(!pdo_tableexists('ymmf_sun_distribution_set')) {
            return false;
        }
        $d_set = pdo_get('ymmf_sun_distribution_set', array('uniacid' => $uniacid));
        if($d_set){
            if($d_set["status"]==0){//不开启
                return false;
            }
            return $d_set;
        }else{
            return false;
        }
    }

    //获取上级数据
    private function getleader($distributionset){
        $uniacid = $this->uniacid;
        $leader = $this->leader;
        $haveparentone = false;
        $wdata = array();
        $wdata["uniacid"] = $uniacid;
        if($this->usertype==1){
            $wdata["openid"] = $this->userid;
        }else{
            $wdata["uid"] = $this->userid;
        }
        //如果有开启分销内购，就判断自己是否分销商
        if($distributionset["is_buyself"]==1){
            $d_promoter = pdo_get('ymmf_sun_distribution_promoter', $wdata);
            if($d_promoter){//自己为一级
                $this->rebate = 1;
                $leader["parent_id_1"] = $d_promoter["uid"];
                if($d_promoter["referrer_uid"]>0){
                    $leader["parent_id_2"] = $d_promoter["referrer_uid"];
                    //获取第三级
                    $d_three_promoter = $this->getnextleader($d_promoter["referrer_uid"]);
                    if($d_three_promoter){
                        $leader["parent_id_3"] = $d_three_promoter["referrer_uid"];
                    }
                }
                return $leader;
            }
        }
        if($this->usertype!=1){
            $wdata["id"] = $this->userid;
        }
        $d_user = pdo_get('ymmf_sun_user', $wdata);
        if($d_user){
            $leader["parent_id_1"] = intval($d_user["parents_id"]);
            if($d_user["parents_id"]>0){
                //获取第二级
                $d_two_promoter = $this->getnextleader($d_user["parents_id"]);
                if($d_two_promoter){
                    $leader["parent_id_2"] = $d_two_promoter["referrer_uid"];
                    $d_three_promoter = $this->getnextleader($d_two_promoter["referrer_uid"]);//获取第三级
                    if($d_three_promoter){
                        $leader["parent_id_3"] = $d_three_promoter["referrer_uid"];
                    }
                }
            }
        }
        return $leader;
    }

    //获取上级
    private function getnextleader($uid){
        $uniacid = $this->uniacid;
        $data_promoter = pdo_get('ymmf_sun_distribution_promoter', array("uniacid"=>$uniacid,"uid"=>$uid));
        return $data_promoter;
    }

    //计算上级佣金——全局佣金
    private function computleadermoney($dataset){
        $uniacid = $this->uniacid;
        $leader = $this->leader;
        $money = $this->money;
        $data = array();
        $data["ordertype"] = $this->ordertype;
        $data["order_id"] = $this->order_id;
        $data["rebate"] = $this->rebate;
        $data["uniacid"] = $uniacid;
        if($this->usertype==1){
            $data["openid"] = $this->userid;
        }else{
            $data["user_id"] = $this->userid;
        }
        if($dataset["status"]>0){
            if($leader["parent_id_1"]>0){//开始计算一级佣金
                $data["parent_id_1"] = $leader["parent_id_1"];
                if($dataset["commissiontype"]==1){//百分比
                    $data["first_price"] = sprintf("%.2f",($money * $dataset["firstmoney"] / 100));
                }elseif($dataset["commissiontype"]==2){//固定金额
                    $data["first_price"] = sprintf("%.2f",$dataset["firstmoney"]);
                }
            }
            if($dataset["status"]>=2){//计算二级佣金
                if($leader["parent_id_2"]>0){
                    $data["parent_id_2"] = $leader["parent_id_2"];
                    if($dataset["commissiontype"]==1){//百分比
                        $data["second_price"] = sprintf("%.2f",($money * $dataset["secondmoney"] / 100));
                    }elseif($dataset["commissiontype"]==2){//固定金额
                        $data["second_price"] = sprintf("%.2f",$dataset["secondmoney"]);
                    }
                }
            }
            if($dataset["status"]==3){//计算三级佣金
                if($leader["parent_id_3"]>0){
                    $data["parent_id_3"] = $leader["parent_id_3"];
                    if($dataset["commissiontype"]==1){//百分比
                        $data["third_price"] = sprintf("%.2f",($money * $dataset["thirdmoney"] / 100));
                    }elseif($dataset["commissiontype"]==2){//固定金额
                        $data["third_price"] = sprintf("%.2f",$dataset["thirdmoney"]);
                    }
                }
            }
            $res = pdo_insert('ymmf_sun_distribution_order', $data);
            if($res){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //完成订单进行佣金结算
    public function settlecommission(){
        $uniacid = $this->uniacid;
        $ordertype = $this->ordertype;
        $order_id = $this->order_id;
        if(empty($order_id)){
            return false;
        }
        //先判断表是否存在，不存在就断开
        if(!pdo_tableexists('ymmf_sun_distribution_order')) {
            return false;
        }
        //查找相关订单的数据
        $d_order = pdo_get('ymmf_sun_distribution_order', array('uniacid' => $uniacid,'order_id' => $order_id,'ordertype' => $ordertype,'is_delete' => 0));
        if($d_order){
            //一级
            if($d_order["parent_id_1"]>0 && $d_order["first_price"]>0){
                $res1 = pdo_update('ymmf_sun_distribution_promoter', array("allcommission +="=>$d_order["first_price"],"canwithdraw +="=>$d_order["first_price"]), array('uid' => $d_order["parent_id_1"], 'uniacid' => $uniacid));
            }
            //二级
            if($d_order["parent_id_2"]>0 && $d_order["second_price"]>0){
                $res2 = pdo_update('ymmf_sun_distribution_promoter', array("allcommission +="=>$d_order["second_price"],"canwithdraw +="=>$d_order["second_price"]), array('uid' => $d_order["parent_id_2"], 'uniacid' => $uniacid));
            }
            //三级
            if($d_order["parent_id_3"]>0 && $d_order["third_price"]>0){
                $res3 = pdo_update('ymmf_sun_distribution_promoter', array("allcommission +="=>$d_order["third_price"],"canwithdraw +="=>$d_order["third_price"]), array('uid' => $d_order["parent_id_3"], 'uniacid' => $uniacid));
            }

            //更新分销订单信息
            $res = pdo_update('ymmf_sun_distribution_order', array("is_delete"=>1), array('id' => $d_order["id"], 'uniacid' => $uniacid));
            if($res){
                return true;
            }else{
                return false;
            }
            
        }else{
            return false;
        }
    }

    //更新订单信息---其他小程序要修改部分
    public function updateorder(){
        $uniacid = $this->uniacid;
        $ordertype = $this->ordertype;
        $order_id = $this->order_id;
        $datas = $this->leader;//一到三级id
        switch ($ordertype) {
            case '1'://普通
                $orderinfo = pdo_update('ymmf_sun_order', $datas, array('id' => $order_id, 'uniacid' => $uniacid));
                break;
            case '2'://砍价
                $orderinfo = pdo_update('ymmf_sun_kjorder', $datas, array('id' => $order_id, 'uniacid' => $uniacid));
                break;
            default:
                
                break;
        }
        if ($orderinfo) {
            return true;
        }else{
            return false;
        }
    }

}