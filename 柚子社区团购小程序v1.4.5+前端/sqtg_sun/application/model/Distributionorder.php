<?php
namespace app\model;
use think\Loader;
use think\Db;
use app\base\model\Base;

class Distributionorder extends Base
{

    //计算未结算金额
    public function CountOrdermoney($parent,$uid=0){
        global $_W;
        $uniacid = $_W["uniacid"];
        $sql_mid = "";
        $where_p = "";
        $field = "";
        $where = " where d.uniacid=".$uniacid." and d.is_del=0 and o.order_status=10 ";

        if($parent==1){
            $where .= " and d.parents_id_1=".$uid." ";
            $field = " sum(d.first_price) as money ";
        }elseif($parent==2){
            $where .= " and d.parents_id_2=".$uid." ";
            $field = " sum(d.second_price) as money ";
        }elseif($parent==3){
            $where .= " and d.parents_id_3=".$uid." ";
            $field = " sum(d.third_price) as money ";
        }
        $sql_ordinary = " select ".$field." from ims_lhy_sun_distributionorder as d left join ims_lhy_sun_order as o on o.id=d.order_id ".$where;
        $money=Db::query($sql_ordinary);
        //普通订单
        if($money['money']){
            return $money["money"];
        }else{
            return 0;
        }
    }

    //获取我的团队总人数 未结算佣金 分销总订单
    public function getMyTeam($user_id){
        $set=Distributionset::get_curr();
        $allnum=0;
        $nosettlemoney = 0;//未结算佣金
        if($set['level']>0){
            //获取一级团队
            $allnum=(new User())->where(['parents_id'=>$user_id])->count();
            //计算未结算佣金,一级佣金
            $nosettle = $this->CountOrdermoney(1,$user_id);
            $nosettlemoney = $nosettle;
        }
        if($set['level']>1){
            $sql="select count(id) as num from ims_lhy_sun_user where parents_id=any(select id as user1_id from ims_lhy_sun_user where parents_id=$user_id) ";
            $num=Db::query($sql)['num'];
            $allnum+=$num;
            //计算未结算佣金,二级佣金
            $nosettle = $this->CountOrdermoney(2,$user_id);
            $nosettlemoney = $nosettle;
        }
        if($set['level']>2){
            $sql="select count(id) as num from ims_lhy_sun_user where parents_id=any(select id as usr1_id from ims_lhy_sun_user where parents_id=any(select id as user2_id from ims_lhy_sun_user where parents_id=$user_id)) ";
            $num=Db::query($sql)['num'];
            $allnum+=$num;
            //计算未结算佣金,三级佣金
            $nosettle = $this->CountOrdermoney(3,$user_id);
            $nosettlemoney = $nosettle;
        }
        $team['allnum']=$allnum;
        $team['nosettlemoney']=$nosettlemoney;
        $team['allorder']=$this->getDistributionorderNum($user_id);
        return $team;
    }
    //获取总分销订单数量
    public function getDistributionorderNum($user_id){
        $map=array('parents_id_1'=>$user_id,'parents_id_2'=>$user_id,'parents_id_3'=>$user_id);
        $num=$this->where(function($query) use($map){
            $query->whereOr($map);
        })->count();
        return $num;
    }

    /**下单下分销订单
     * @param $user_id 下单用户id
     * @param $type    订单类型 1普通商品 2抢购商品 3拼团商品 4会员卡
     * @param $store_id 商户id
     * @param $order_id 订单id
     * @param $order_amount 订单实际支付金额
     * @param $gid 订单各种商品id
     * @param int $share_user_id 分销用户id
     * @param int $pay_type     调用方式 0下单(未支付) 1已支付
     */
    public function setDistributionOrder($user_id,$type,$store_id,$order_id,$order_amount,$gid,$share_user_id=0,$pay_type=0){
        if($pay_type==1){
            $this->setOrdersetDistributionParents($user_id,$share_user_id);
        }
        $this->setOrder($user_id,$type,$store_id,$order_id,$order_amount,$gid);
    }
    /**完成订单进行佣金结算
     * @param $type 订单类型 1普通商品 2抢购商品 3拼团商品 4会员卡
     * @param $order_id 订单id
     * @param $order_no 订单号
     * @param $store_id 门店id
     */
    public function setSettlecommission($type,$order_id,$order_no,$store_id){
        //查找分销订单信息
        $d_order=self::get(['type'=>$type,'order_id'=>$order_id]);
        //不存在订单或者已结算订单退出
        if(!$d_order||$d_order['settle_status']==1){
            return false;
        }
        //获取分销配置信息
        $distributionset=Distributionset::get_curr();
        //佣金结算
        //一级
        $distributionpromoter=new Distributionpromoter();
        if($d_order['parents_id_1']>0&&$d_order['first_price']>0){
            $distributionpromoter->where(['user_id'=>$d_order["parents_id_1"]])->setInc('allcommission',$d_order["first_price"]);
            $distributionpromoter->where(['user_id'=>$d_order["parents_id_1"]])->setInc('canwithdraw',$d_order["first_price"]);
            //增加分销佣金记录
            $this->setDistributionMercapdetails($d_order["parents_id_1"],$type,$d_order["first_price"],$order_id,$order_no,'一级');
            $this->setStoreDeduction($distributionset,$store_id,$d_order["first_price"],$type,$order_id,$order_no,$d_order["parents_id_1"]);
        }
        //二级
        if($d_order['parents_id_2']>0&&$d_order['second_price']>0){
            $distributionpromoter->where(['user_id'=>$d_order["parents_id_2"]])->setInc('allcommission',$d_order["second_price"]);
            $distributionpromoter->where(['user_id'=>$d_order["parents_id_2"]])->setInc('canwithdraw',$d_order["second_price"]);
            //增加分销佣金记录
            $this->setDistributionMercapdetails($d_order["parents_id_2"],$type,$d_order["second_price"],$order_id,$order_no,'二级');
            $this->setStoreDeduction($distributionset,$store_id,$d_order["second_price"],$type,$order_id,$order_no,$d_order["parents_id_2"],'二级');
        }
        //三级
        if($d_order['parents_id_3']>0&&$d_order['third_price']>0){
            $distributionpromoter->where(['user_id'=>$d_order["parents_id_3"]])->setInc('allcommission',$d_order["third_price"]);
            $distributionpromoter->where(['user_id'=>$d_order["parents_id_3"]])->setInc('canwithdraw',$d_order["third_price"]);
            //增加分销佣金记录
            $this->setDistributionMercapdetails($d_order["parents_id_3"],$type,$d_order["third_price"],$order_id,$order_no,'三级');
            $this->setStoreDeduction($distributionset,$store_id,$d_order["third_price"],$type,$order_id,$order_no,$d_order["parents_id_3"],'三级');
        }
        //更新分销订单信息
        $this->allowField(true)->save(['settle_status'=>1,'finish_time'=>time(),'settle_type'=>$distributionset['withhold']],['id'=>$d_order['id']]);
    }
    //分销佣金扣款为商家时调用 商家扣款
    public function setStoreDeduction($distributionset,$store_id,$money,$type,$order_id,$order_no,$user_id,$level='一级'){
        if($store_id==0){
            return false;
        }
        if($distributionset['withhold']==2){
            //减少商家金额
            (new Store())->where(['id' => $store_id])->setDec('balance',$money);
            $store=Store::get($store_id);
            //增加商家金额明细
            $detail = '';
            if($type==1){
                $detail .='普通商品';
            }else if($type==2){
                $detail .='抢购商品';
            }else if($type==3){
                $detail .='拼团商品';
            }else if($type==4){
                $detail .='会员卡';
            }
            $detail.='-分销订单完成-订单id'.$order_id.' 订单号:'.$order_no.' '.$level.'佣金扣款';
            $mercapdetails = [
                'store_id' => $store_id,
                'store_name' => $store['name'],
                'type' => 4,
                'mcd_type'=>6,
                'sign' => 2,
                'user_id'=>$user_id,
                'mcd_memo' => $detail,
                'money' => $money,
                'order_id' => $order_id,
                'add_time' => time(),
                'now_money' => $store['balance'],
            ];
            (new Mercapdetails())->allowField(true)->save($mercapdetails);
        }
    }
    //增加分销佣金记录
    private function setDistributionMercapdetails($user_id,$type,$money,$order_id,$order_no,$level){
        $distributionpromoter=Distributionpromoter::get(['user_id'=>$user_id]);
        if(!$distributionpromoter){
            return false;
        }
        $user=User::get($user_id);
        $detail='';
        if($type==1){
            $detail.='普通商品';
        }else if($type==2){
            $detail.='抢购商品';
        }else if($type==3){
            $detail.='拼团商品';
        }else if($type==4){
            $detail.='会员卡';
        }
        $detail.='分销订单 订单id:'.$order_id.' 订单号: '.$order_no.$level.'分销';
        $data=[
            'user_id'=>$user_id,
            'promoter_id'=>$distributionpromoter['id'],
            'type'=>$type,
            'order_id'=>$order_id,
            'mcd_type'=>1,
            'openid'=>$user['openid'],
            'sign'=>1,
            'mcd_memo'=>$detail,
            'money'=>$money,
            'now_money'=>$distributionpromoter['canwithdraw']-$distributionpromoter['freezemoney'],
        ];
        (new Distributionmercapdetails())->allowField(true)->save($data);
    }


    //下单成为下级
    public function setOrdersetDistributionParents($user_id,$parents_id=0){
        if($parents_id==0){
            return false;
        }
        $distributionset=Distributionset::get_curr();
        //首次点击链接条件
        if($distributionset['lower_condition']==2){
            //判断父级是不是分销商
            if(!Distributionpromoter::is_promoter($parents_id)){
                return false;
            }
            //判断用户是不是经销商
            if(Distributionpromoter::is_promoter($user_id)){
                return false;
            }
            $user=User::get($user_id);
            if(!$user){
                return false;
            }
            if($user['parents_id']){
                return false;
            }
            if($user['id']==$parents_id){
                return false;
            }
            $parents=User::get(['id'=>$parents_id]);
            (new User())->allowField(true)->save(['parents_id'=>$parents_id,'parents_name'=>$parents['nickname']],['id'=>$user_id]);
        }else{
            return false;
        }
    }
    /** 生成分销订单
     * @param $user_id 下单用户id
     * @param $type    订单类型 1普通商品 2抢购商品 3拼团商品 4会员卡
     * @param $store_id 商户id
     * @param $order_id 订单id
     * @param $order_amount 订单实际支付金额
     * param $gid 订单各种商品id
     */
    public function setOrder($user_id,$type,$store_id,$order_id,$order_amount,$gid){
        if(empty($user_id)||empty($type)||empty($order_id)||empty($order_amount)||empty($gid)){
            return false;
        }

        //获取分销基础设置
        $distributionset=$this->getDistributionset($store_id);
        if($distributionset){
            //分销三级用户信息
            $leader=$this->getleader($distributionset,$user_id);
            //下单计算佣金
            $this->computleadermoney($distributionset,$leader,$store_id,$type,$user_id,$order_id,$gid,$order_amount);
        }else{
            return false;
        }
    }
    //获取计算三级佣金信息
    private function getCommission($order_amount,$commission){
        $data=array('first_price'=>0,'second_price'=>0,'third_price'=>0);
        if($commission['commissiontype']==1){
            $data['first_price']=sprintf("%.2f",($order_amount * $commission["first_money"] / 100));
            $data['second_price']=sprintf("%.2f",($order_amount * $commission["second_money"] / 100));
            $data['third_price']=sprintf("%.2f",($order_amount * $commission["third_money"] / 100));
        }else if($commission['commissiontype']==2){
            $data['first_price']=sprintf("%.2f",$commission["first_money"]);
            $data['second_price']=sprintf("%.2f",$commission["second_money"]);
            $data['third_price']=sprintf("%.2f",$commission["third_money"]);
        }
        return $data;
    }
    //下单计算佣金
    private function computleadermoney($distributionset,$leader,$store_id,$type,$user_id,$order_id,$gid,$order_amount=0){
        if($order_amount<=0){
            return false;
        }
        if($leader['parent_id_1']==0){
            return false;
        }

        //获取分销佣金设置
        $commission=$this->getDistributionCommission($distributionset,$store_id,$type,$gid);
        if($commission){
            //计算分销金额
            $commission_data=$this->getCommission($order_amount,$commission);
            //存在分销订单结束 下单和支付完后需要调用
            $distributionorder=$this->where(['order_id'=>$order_id,'type'=>$type])->find();
            if($distributionorder){
                return false;
            }
            $data=[
                'type'=>$type,
                'user_id'=>$user_id,
                'order_id'=>$order_id,
                'parents_id_1'=>$leader['parent_id_1'],
                'parents_id_2'=>$leader['parent_id_2'],
                'parents_id_3'=>$leader['parent_id_3'],
                'first_price'=>$commission_data['first_price'],
                'second_price'=>$commission_data['second_price'],
                'third_price'=>$commission_data['third_price'],
                'rebate'=>$leader['rebate'],
            ];
            $this->allowField(true)->save($data);
            //会员卡直接给结算佣金
            if($type==4){
                //完成订单进行佣金结算
                $openvip=openvip::get($order_id);
                (new Distributionorder())->setSettlecommission(4,$order_id,$openvip['out_trade_no'],0);
            }

        }
    }

    //获取各种类型商品单独分销佣金
    private function getAloneDistributionCommission($type,$gid){
        if($type==1){
            $baseModel='app\model\Goods';
        }else if($type==2){
            $baseModel='app\model\Panic';
        }else if($type==3){
            $baseModel='app\model\Pingoods';
        }
        if(!$baseModel)
            return false;
        $goods=$baseModel::get($gid);
        if($goods['distribution_open']==1){
            $data=array('first_money'=>$goods['first_money'],'second_money'=>$goods['second_money'],'third_money'=>$goods['third_money'],'commissiontype'=>$goods['commissiontype']);
        }else{
            return false;
        }
        return $data;
    }
    //格式化三级分销金额数据(分销层级)
    private function formatCommission($level,$data){
        if($level==0){
            $data['first_money']=0;
            $data['second_money']=0;
            $data['third_money']=0;
        }else if($level==1){
            $data['second_money']=0;
            $data['third_money']=0;
        }else if($level==2){
            $data['third_money']=0;
        }
        return $data;
    }
    //获取分销信息
    private function getDistributionCommission($distributionset,$store_id,$type,$gid){
        //判断商品类型是否在参与分销模块中
        if(!in_array($type,explode(',',$distributionset['join_module']))){
            return false;
        }
        $data=array('first_money'=>0,'second_money'=>0,'third_money'=>0);
        //开启商家分销
        if($distributionset['store_setting']==1&&$store_id>0){
            $store=Store::get($store_id);
            if($store['distribution_open']==1){
                //所有类型商品单独分销
               $data=$this->getAloneDistributionCommission($type,$gid);
               if(!$data){
                    $data=array('first_money'=>$store['first_money'],'second_money'=>$store['second_money'],'third_money'=>$store['third_money'],'commissiontype'=>$store['commissiontype']);
               }
               $data=$this->formatCommission($distributionset['level'],$data);
            }else{
                return false;
            }
        }else{
            //关闭商家分销
            $distributionset=$this->formatCommission($distributionset['level'],$distributionset);
            $data['first_money']=$distributionset['first_money'];
            $data['second_money']=$distributionset['second_money'];
            $data['third_money']=$distributionset['third_money'];
            $data['commissiontype']=$distributionset['commissiontype'];
        }
        if($data['first_money']<=0){
            return false;
        }
        if($data['first_money']>0){
            $data['first_money']=sprintf("%.2f",$data['first_money']);
        }
        if($data['second_money']>0){
            $data['second_money']=sprintf("%.2f",$data['second_money']);
        }
        if($data['third_money']>0){
            $data['third_money']=sprintf("%.2f",$data['third_money']);
        }
        return $data;
    }



    //获取三级分销用户信息
    private function getleader($distributionset,$user_id){
        $leader=array('parent_id_1'=>0,'parent_id_2'=>0,'parent_id_3'=>0,'rebate'=>$distributionset['inapp_buy']);
        //开启分销内购
        if($distributionset['inapp_buy']==1){
            $d_promoter = $this->getnextleader($user_id);
            if($d_promoter){//自己为一级
                $leader["parent_id_1"] = $d_promoter["user_id"];
                if($d_promoter["referrer_uid"]>0){
                    //获取二级
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
        //else{
            //没有开启分销内购
            $d_user=User::get($user_id);
            if($d_user){
                if($d_user["parents_id"]>0){
                    //获取一级
                    $leader["parent_id_1"] = intval($d_user["parents_id"]);
                    $d_two_promoter = $this->getnextleader($d_user["parents_id"]);
                    if($d_two_promoter){
                        //获取二级
                        $leader["parent_id_2"] = $d_two_promoter["referrer_uid"];
                        $d_three_promoter = $this->getnextleader($d_two_promoter["referrer_uid"]);//获取第三级
                        if($d_three_promoter){
                            $leader["parent_id_3"] = $d_three_promoter["referrer_uid"];
                        }
                    }
                }
            }
       // }
        return $leader;
    }
    //获取上级
    private function getnextleader($user_id){
        $data=Distributionpromoter::get(['user_id'=>$user_id]);
        return $data;
    }
    //获取分销基础设置
    public function  getDistributionset($store_id){
        $data=Distributionset::get_curr();
        if($data){
            if($data['level']>0){
                if($data['store_setting']==1){
                    if($store_id>0){
                        $store=Store::get($store_id);
                        if($store['distribution_open']==0){
                            return false;
                        }else{
                            return $data;
                        }
                    }else{
                        return $data;
                    }
                }else{
                    return $data;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}
