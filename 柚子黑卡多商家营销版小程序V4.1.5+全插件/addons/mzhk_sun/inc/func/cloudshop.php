<?php
defined('IN_IA') or exit ('Access Denied');
//error_reporting(0);
class Cloudshop{
    public $order_id=0;
    public $ordertype=1;//1普通，2砍价，3拼团，5抢购，12次卡
    public $money=0;
    public $meno="";
    public $usertype=1;//1为用openid识别用户，2为用uid识别用户
    public $userid="";//用户识别id,openid或者uid
	public $shopid="";//云店id
    public $uniacid=0;
    public $rebate=0;//判断是否自购，0否，1是

    public function __construct(){
        global $_W;
        $this->uniacid = $_W["uniacid"];
    }

    //计算分销佣金
    public function computecloudcommission(){
		$uniacid = $this->uniacid;
        if($this->money<=0){
            return false;
        }
        if(empty($this->userid)){
            return false;
        }
		if(empty($this->shopid)){
            return false;
        }
        //获取分销设置数据
        $cloudshopset = $this->getcloudshopset();
        if($cloudshopset){
            //计算佣金
            $computleadermoney = $this->computleadermoney($cloudshopset);
            if($computleadermoney){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //获取云店设置
    public function getcloudshopset(){
        $uniacid = $this->uniacid;
        //先判断表是否存在，不存在就断开
        if(!pdo_tableexists('mzhk_sun_cloud_set')) {
            return false;
        }
        $d_set = pdo_get('mzhk_sun_cloud_set', array('uniacid' => $uniacid));
        if($d_set){
            if($d_set["cloud_open"]==0){//不开启
                return false;
            }
			//判断是否自购
			if($this->shopid){
				$shopkeeper = pdo_get('mzhk_sun_cloud_shopkeeper', array('uniacid' => $uniacid,'openid'=>$this->shopid));
				if($shopkeeper && $d_set['internal_purchase']==0){
					return false;
				}elseif($shopkeeper && $d_set['internal_purchase']==1){
					$this->rebate = 1;
				}
			}
            return $d_set;
        }else{
            return false;
        }
    }


    //计算佣金
    private function computleadermoney($dataset){
        $uniacid = $this->uniacid;
        $money = $this->money;
        $data = array();
        $data["ordertype"] = $this->ordertype;
        $data["order_id"] = $this->order_id;
        $data["rebate"] = $this->rebate;
        $data["uniacid"] = $uniacid;
		$data["addtime"] = time();
		$data["shopid"] = $this->shopid;

        if($this->usertype==1){
            $data["openid"] = $this->userid;
        }else{
            $data["user_id"] = $this->userid;
        }

		$shopkeeper = pdo_get('mzhk_sun_cloud_shopkeeper', array('uniacid' => $uniacid,'id'=>$this->shopid));
		$data['shopid'] = $shopkeeper['id'];
        if($dataset["cloud_open"]>0){
			$data["cloudprice"] = sprintf("%.2f",$money);
			
			$res = pdo_insert('mzhk_sun_cloud_order', $data);

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
    public function setcloudcommission(){
        $uniacid = $this->uniacid;
        $ordertype = $this->ordertype;
        $order_id = $this->order_id;
        if(empty($order_id)){
            return false;
        }
        //先判断表是否存在，不存在就断开
        if(!pdo_tableexists('mzhk_sun_cloud_order')) {
            return false;
        }

		if($ordertype==1){
			$memos = '普通订单，订单id：'.$order_id." ";
		}elseif($ordertype==2){
			$memos = '砍价订单，订单id：'.$order_id." ";
		}elseif($ordertype==3){
			$memos = '拼团订单，订单id：'.$order_id." ";
		}elseif($ordertype==5){
			$memos = '抢购订单，订单id：'.$order_id." ";
		}elseif($ordertype==12){
			$memos = '次卡订单，订单id：'.$order_id." ";
		}

        //查找相关订单的数据
        $d_order = pdo_get('mzhk_sun_cloud_order', array('uniacid' => $uniacid,'order_id' => $order_id,'ordertype' => $ordertype,'is_delete' => 0));
        if($d_order){
            if($d_order["cloudprice"]>0){
                $res1 = pdo_update('mzhk_sun_cloud_shopkeeper', array("allcommission +="=>$d_order["cloudprice"],"canwithdraw +="=>$d_order["cloudprice"]), array('id' => $d_order["shopid"], 'uniacid' => $uniacid));
				if($res1){
					$shopkeeper = pdo_get('mzhk_sun_cloud_shopkeeper', array('uniacid' => $uniacid,'id' => $d_order["shopid"]));
					//更新云店资金明细
					$data = array();
					$data["shopname"] = $shopkeeper['shopname'];
					$data["shopid"] = $d_order["shopid"];
					$data["mcd_type"] = 1;
					$data["mcd_memo"] = $memos;
					$data["addtime"] = time();
					$data["money"] = $d_order["cloudprice"];
					$data["status"] = 1;
					$data['sign'] = 0;
					$data["order_id"] = $order_id;
					$data["uniacid"] = $uniacid;

					pdo_insert('mzhk_sun_cloud_detailed', $data);
				}
            }
            
            //更新分销订单信息
            $res = pdo_update('mzhk_sun_cloud_order', array("is_delete"=>1,'dtime'=>time()), array('id' => $d_order["id"], 'uniacid' => $uniacid));
            if($res){
                return true;
            }else{
                return false;
            }
            
        }else{
            return false;
        }
    }

}