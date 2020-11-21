<?php
class ConfirmorderController extends MobileBaseController {
    public function index() {
        if(!$this->uid) {
            message('请您在微信端访问',$this->createMobileUrl('shop'));
        }
        $order_id = intval($_GET['order_id']);
        $data['order_id'] = 0;
        $data['zhekou'] = $this->userInfo['zhekou'];
        $data['levelname'] = $this->userInfo['levelname'];
        $data['wqpay'] = $this->site->configs['config']['wqpay'];
        //todo 从新计算价格
        if($order_id) {
            $order_info = $this->OrderModel->getOne([
                'id'       => $order_id,
                'memberid' => $this->uid,
            ]);
            if($order_info) {
               $order_detail = $this->OrderDetailModel->getList([
                   'order_id' => $order_id
               ],['goods_id','amount','type_id']);
               if($order_detail) {
                   $pay_str = '';
                   foreach($order_detail as $value) {
                       $pay_str.=$value['goods_id'].'_'.$value['amount'].'_'.$value['type_id'].',';
                   }
                   $_GET['pay_info'] = rtrim($pay_str,',');
                   $data['order_id'] = $order_id;
               }
            }
        }
        $goods_types = [];
        $pay_info    = trim($_GET['pay_info']);
        $ids = $goods_info = $goods_ids = [];
        if($pay_info) {
            $pay_info = explode(',', $pay_info);
            if($pay_info) {
                foreach($pay_info as $detail) {
                    list($goods_id, $amount, $type) = explode('_',$detail);
                    $goods_ids[$goods_id.'_'.$type] = [
                        'id'     => $goods_id,
                        'amount' => $amount,
                        'type'   => $type
                    ];
                    $ids[] = $goods_id;
                    if($type) {
                        $goods_types[] = $type;
                    }
                }
            }
        }

        //type info
        if($goods_types) {
            $goods_types = array_unique($goods_types);
            $goods_types = $this->GoodsTypeModel->getList([
                'id'  => $goods_types,
                'del' => 0
            ],'*');
            $goods_types = $this->arrayIndex($goods_types, 'id');
        }

        if($ids) {
            $ids = array_unique($ids);
            $goods_info = $this->GoodsModel->getList([
                'id'     => $ids,
                'status' => 1,
            ],['id', 'goodsname', 'marketprice','thumb', 'quanguoyoufei','goodstype']);

            $goods_info = $this->arrayIndex($goods_info, 'id');
        }

        //抢购商品折扣
        $where = [
            'start <'  => time(),
            'end >'    => time(),
            'goods_id' => $ids,
            'type'     => 1,
        ];
        $zhekou  = $this->GouModel->getList($where,['*']);
        $zhekou  = $this->arrayIndex($zhekou, 'goods_id');


        $money = $postage = $all = 0;
        $this->data['address_need'] = false;
        foreach($goods_ids as &$value) {
            if($goods_info[$value['id']]) {
                $value['goods_info'] = $goods_info[$value['id']];

                //实物需要收货地址
                if($value['goods_info']['goodstype'] == 0) {
                    $this->data['address_need'] = true;
                }
                if($value['goods_info']['quanguoyoufei'] > 0) {
                    $postage = $value['goods_info']['quanguoyoufei'] > $postage ?
                        $value['goods_info']['quanguoyoufei'] : $postage;
                }
                if($value['type'] && $goods_types[$value['type']]) {
                    $value['type_info'] = $goods_types[$value['type']];
                }

                //折扣计算
                if($zhekou[$value['id']]) {
                    $value['zhekou'] = $zhekou[$value['id']]['zhekou'] && $zhekou[$value['id']]['zhekou'] > 0 ? $zhekou[$value['id']]['zhekou'] : 10;
                }else {
                    $value['zhekou'] = $data['zhekou'];
                }



                $money+=$value['amount']*$value['type_info']['marketprice'];

                $all+= $value['amount']*$value['type_info']['marketprice']*$value['zhekou']/10;
            }else {
                $value = null;
            }
        }

        $data['address'] = $this->AddressModel->getList([
            'uniacid' => $this->W['uniacid'],
            'uid'     => $this->uid
        ],'*');
        $data['money']    = number_format($money,2,'.', '');
        $data['postage']  = number_format($postage,2,'.', '');
        $data['need']     = number_format($money+$postage,2,'.', '');
        $data['all']      = number_format( $all+$postage,2,'.', '');
        $data['list']     = $goods_ids;
        $data['pay_info'] = trim($_GET['pay_info']);
        $this->assign($data);
        $this->assign($this->data);
        $this->display();
    }
}