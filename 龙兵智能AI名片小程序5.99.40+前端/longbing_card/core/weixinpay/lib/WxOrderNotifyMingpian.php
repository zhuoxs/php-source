<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "WxPay.Api.php";
require_once 'WxPay.Notify.php';


class WxOrderNotifyMingpian extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		file_put_contents('./weixinQuery.txt','in_query',FILE_APPEND);

		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			$arr=unserialize($result['attach']);

			file_put_contents('./weixinQuery.txt','$arr------'.$arr['type'],FILE_APPEND);
			//vip  VIP
			if(is_array($arr) && $arr['type']=='vip'){
				$order_id = intval($arr['order_id']);
				file_put_contents('./weixinQuery.txt','$order_id------'.$order_id,FILE_APPEND);

				$orderModel = new \app\common\model\MingpianOrder();
				if(!$order = $orderModel->where(['id'=>$order_id])->find()){
					echo 'FAIL';die;
				}
				if($order->status==0) {
					//订单状态修改
					$orderModel->update(['status' => 1], ['id' => $order_id]);
					//名片变为vip
					$cardModel=new \app\common\model\MingpianCard();
					//计算结束时间
					$oriCard=$cardModel->where(['id'=>$order['card_id']])->find();
					$vip_end_time=strtotime('+ '.$order['vip_term_month'].' month');

					if($oriCard['vip_level'] && $oriCard['vip_level']==$order['vip_name']){
						//如果是同级的
						$vip_end_time=strtotime('+ '.$order['vip_term_month'].' month',$oriCard['vip_end_time']);
					}
					$cardModel->update(
						[
							'vip_level'=>$order['vip_name'],
							'vip_end_time'=>$vip_end_time,
							'is_vip_success'=>1,
						],
						['id'=>$order['card_id']]
					);
					//分销: 当前消费用户  金额(分) uniacid
					$param=serialize(['uid'=>$order['uid'],'uniacid'=>$order['uniacid'],'money'=>$order['money'],'order_type'=>$order['type']]);
					\think\Hook::exec('app\\common\\behavior\\PartnerMoney','run',$param);
				}
				return  true;
			}elseif(is_array($arr) && $arr['type']=='template'){//名片模板
				//回调逻辑： 更改订单状态  生成名片-模板对应表
				$order_id = intval($arr['order_id']);
				$orderModel = new \app\common\model\MingpianOrder();
				if(!$order = $orderModel->where(['id'=>$order_id])->find()){
					echo 'FAIL';die;
				}
				if($order->status==0) {
					$orderModel->update(['status' => 1], ['id' => $order_id]);
					$payModel=new \app\common\model\MingpianTemplateCard();
					$save_data=[
						'uniacid'=>$order['uniacid'],
						'create_time'=>time(),
						'update_time'=>time(),
						'card_id'=>$order['card_id'],
						'temp_id'=>$order['temp_id'],
						'order_id'=>$order_id,
					];
					$payModel->insert($save_data);
					//分销: 当前消费用户  金额(分) uniacid
					$param=serialize(['uid'=>$order['uid'],'uniacid'=>$order['uniacid'],'money'=>$order['money'],'order_type'=>$order['type']]);
					\think\Hook::exec('app\\common\\behavior\\PartnerMoney','run',$param);
				}
				return  true;
			}elseif(is_array($arr) && $arr['type']=='partner'){//合伙人
				$order_id = intval($arr['order_id']);
				$orderModel = new \app\common\model\MingpianOrder();
				if(!$order = $orderModel->where(['id'=>$order_id])->find()){
					echo 'FAIL';die;
				}
				if($order->status==0) {
					$orderModel->update(['status' => 1], ['id' => $order_id]);
					$userModel=new \app\common\model\MingpianUser();
					$userModel->update(['partner_level'=>$order['temp_id']],['id'=>$order['uid']]);
					//分销: 当前消费用户  金额(分) uniacid
					$param=serialize(['uid'=>$order['uid'],'uniacid'=>$order['uniacid'],'money'=>$order['money'],'order_type'=>$order['type']]);
					\think\Hook::exec('app\\common\\behavior\\PartnerMoney','run',$param);
				}
				return  true;
			}elseif(is_array($arr) && $arr['type']=='info_top'){//帖子置顶
				$order_id = intval($arr['order_id']);
				$orderModel = new \app\common\model\MingpianOrder();
				if(!$order = $orderModel->where(['id'=>$order_id])->find()){
					echo 'FAIL';die;
				}
				if($order->status==0) {
					$orderModel->update(['status' => 1], ['id' => $order_id]);
					//帖子
					$infoModel=new \app\common\model\MingpianInfo();
					$ruleModel=new \app\common\model\MingpianRule();
					$rule=$ruleModel->get(['id'=>$order['temp_id']]);
					$infoModel->where(['id'=>$order['vip_name']])->update([
						'status'=>1,
						'is_top'=>1,
						'top_time'=>time(),
						'top_end_time'=>strtotime('+ '.$rule['days'].'days'),
					]);
					//分销: 当前消费用户  金额(分) uniacid
					$param=serialize(['uid'=>$order['uid'],'uniacid'=>$order['uniacid'],'money'=>$order['money'],'order_type'=>$order['type']]);
					\think\Hook::exec('app\\common\\behavior\\PartnerMoney','run',$param);
				}
				return  true;
			}
		}
		return false;
	}

    //重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			file_put_contents('./weixinQuery.txt','输入参数不正确',FILE_APPEND);
			$msg = "输入参数不正确";
			return false;
		}
		file_put_contents('./weixinQuery.txt','abc',FILE_APPEND);
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}
}


