<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/9/14
 * Time: 14:04
 */
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH_FARM_PT') && define('ROOT_PATH_FARM_PT', IA_ROOT . '/addons/kundian_farm_plugin_pt/');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
class Kundian_farm_plugin_ptModuleWxapp extends WeModuleWxapp
{
    public function doPagePt(){
        global $_GPC, $_W;
        $action = $_GPC['action'];
        require_once ROOT_PATH_FARM_PT . 'inc/wxapp/' . $action . '.inc.php';
        $class = ucfirst($action . 'Controller');
        $actionModel = new $class();
        $op = $_GPC['op'];
        $actionModel->$op($_GPC);
    }

    public function doPagePay(){
        global $_GPC, $_W;
        $order_id = intval($_GPC['orderid']);
        $uniacid=$_GPC['uniacid'];
        $orderData=pdo_get('cqkundian_farm_pt_order',['id'=>$order_id,'uniacid'=>$uniacid]);
        $relation = pdo_get('cqkundian_farm_pt_relation', ['id' => $orderData['relation_id'], 'uniacid' => $uniacid]);
        if($relation['status']==2){
            return $this->result(0,'当前拼团人员已满，请重新下单拼团');
        }

        if($relation['status']==3){
            return $this->result(0,'当前拼团已失败,请重新下单拼团');
        }

        $order = array(
            'tid' => $orderData['order_number'],
            'user' => $_W['openid'], //用户OPENID
            'fee' => $orderData['total_price'], //金额
            'title' => '拼团',
        );
        $pay_params = $this->pay($order);
        if (is_error($pay_params)) {
            return $this->result(1, $pay_params['message']);
        }
        return $this->result(0, '', $pay_params);
    }

    public function payResult($log){
        load()->func('logging');
        logging_run("拼团支付回调");
        logging_run($log);
        if ($log['result'] == 'success') {
            /**
             * 修改订单状态为已支付
             * 修改用户组团表状态为组团中
             * 更新商品库存、销量信息
             */
            $update_save = array(
                'is_pay' => 1,
                'pra_price' => $log['fee'],
                'pay_time' => time(),
                'pay_method' => '微信支付',
                'uniontid' => $log['uniontid'],
                'trans_id' => $log['tag']['transaction_id'],
            );
            $res = pdo_update('cqkundian_farm_pt_order', $update_save, ['order_number' => $log['tid'], 'uniacid' => $log['uniacid']]);
            if (!$res) {
                echo json_encode(['code' => -1, 'msg' => '回调失败']);
                die;
            }
            $update_rel = ['status' => 1];

            $orderData = pdo_get('cqkundian_farm_pt_order', ['order_number' => $log['tid'], 'uniacid' => $log['uniacid']]);
            if($orderData['is_group']==2){
                $relation = pdo_get('cqkundian_farm_pt_relation', ['id' => $orderData['relation_id'], 'uniacid' => $log['uniacid']]);
                //判断当前拼团组是否人数已满
                $user_total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('cqkundian_farm_pt_order') . " WHERE relation_id=:relation_id AND is_pay=:is_pay AND uniacid=:uniacid",
                    [':relation_id' => $orderData['relation_id'], ':is_pay' => 1, 'uniacid' => $log['uniacid']]);
                if ($user_total == $relation['ptnumber']) {  //成团
                    $update_rel = ['status' => 2];
                    pdo_update('cqkundian_farm_pt_order',['is_success'=>1,'success_time'=>time()],['relation_id'=>$relation['id'],'uniacid'=>$log['uniacid'],'is_pay'=>1]);
                }
                pdo_update('cqkundian_farm_pt_relation', $update_rel, ['id' => $orderData['relation_id'], 'uniacid' => $log['uniacid']]);
            }

            //更新商品库存、销量
            $orderDetail = pdo_get('cqkundian_farm_pt_order_detail', ['order_id' => $orderData['id'], 'uniacid' => $log['uniacid']]);
            $goods = pdo_get('cqkundian_farm_pt_goods', ['id' => $orderDetail['goods_id'], 'uniacid' => $log['uniacid']]);
            $update_goods = ['sale_count +=' => $orderDetail['num']];
            $goodsSku = unserialize($goods['sku']);
            if (!empty($goodsSku)) {
                $sku = unserialize($orderDetail['sku']);
                for ($i = 0; $i < count($goodsSku); $i++) {
                    if ($goodsSku[$i]['spec_num'] == $sku['spec_num'] || $goodsSku[$i]['sku_name'] == $sku['sku_name']) {
                        $goodsSku[$i]['count']= $goodsSku[$i]['count'] - $orderDetail['num'];
                    }
                }
                $update_goods['sku'] = serialize($goodsSku);
            } else {
                $update_goods['count'] =$goods['count']- $orderDetail['num'];
            }
            pdo_update('cqkundian_farm_pt_goods', $update_goods, ['id' => $orderDetail['goods_id'], 'uniacid' => $log['uniacid']]);
        }
    }
}