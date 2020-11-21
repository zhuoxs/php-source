<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/1/21 0021
 * Time: 下午 3:55
 * Desc 微信小程序购物单功能
 */
defined("IN_IA")or exit("Access denied");
require_once ROOT_PATH.'model/common.php';
class Shopping_KundianFarmModel{
    protected $uniacid='';
    public $goods='cqkundian_farm_goods';
    public $goods_spec='cqkundian_farm_goods_spec';
    static $common='';
    public function __construct($uniacid=''){
        global $_W;
        $this->uniacid=$_W['uniacid'];
        if(!empty($uniacid)){
            $this->uniacid=$uniacid;
        }
        self::$common=new Common_KundianFarmModel();
    }


    /**
     * 将加入购物车的商品加入微信购物清单
     * @param $goodsData    商品信息
     * @param $specVal      商品规格信息
     * @return bool|mixed|string
     */
    public function addShoppingList($goodsData,$specVal){
        global $_W;
        $goodsType=pdo_get('cqkundian_farm_goods_type',array('id'=>$goodsData['type_id']));
        if(!empty($specVal)){
            $sku_info=[
                'sku_id'=>$specVal['spec_num'] ? $specVal['spec_num'] : $goodsData['id'],
                'price'=>$specVal['price']*100,
                'status'=>$goodsData['is_put_away']==1 ? 1  : 2,
            ];
        }else{
            $sku_info=[
                'sku_id'=>$goodsData['id'],
                'price'=>$goodsData['price']*100,
                'status'=>$goodsData['is_put_away']==1 ? 1  : 2,
            ];
        }

        $shoppingData=[
            'user_open_id'=>$_W['openid'],
            'sku_product_list'=>[
                [
                    'item_code'=>$goodsData['id'],
                    'title'=>$goodsData['goods_name'],
                    'desc'=>$goodsData['goods_remark'] ?$goodsData['goods_remark']:$goodsData['goods_name'],
                    'category_list'=>$goodsType['type_name'],
                    'image_list'=>unserialize($goodsData['goods_slide']),
                    'src_wxapp_path'=>'kundian_farm/pages/shop/prodeteils/index?goodsid='.$goodsData['id'],
                    'sku_info'=>$sku_info
                ]

            ]
        ];


        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $url='https://api.weixin.qq.com/mall/addshoppinglist?access_token='.$access_token;
        $result=$this->https_curl_json($url,$shoppingData,'json');
        $result=json_decode($result);
        return $result;
    }

    /** 更新购物单中的商品信息*/
    public function updateShippingGoods($goods_id){
        $goodsData=pdo_get('cqkundian_farm_goods',['id'=>$goods_id,'uniacid'=>$this->uniacid]);
        $sku_info=[];
        if($goodsData['is_open_sku']==1){
            $specVal=pdo_getall('cqkundian_farm_goods_spec',['goods_id'=>$goods_id,'uniacid'=>$this->uniacid]);

            foreach ($specVal as $key => $value ){
                $sku_info[$key]=[
                    'sku_id'=>$value['spec_num'] ? $specVal['spec_num'] : $goodsData['id'],
                    'price'=>$specVal['price'] *100,
                    'status'=>$goodsData['is_put_away']==1 ? 1 : 2,
                ];
            }
        }else{
            $sku_info[]=[
                'sku_id'=>$goodsData['id'],
                'price'=>$goodsData['price']*100,
                'status'=>$goodsData['is_put_away']==1 ? 1 : 2,
            ];
        }
        $goodsType=pdo_get('cqkundian_farm_goods_type',array('id'=>$goodsData['type_id']));
        $shoppingData=[
            'product_list'=>[
                [
                    'item_code'=>$goodsData['id'],
                    'title'=>$goodsData['goods_name'],
                    'desc'=>$goodsData['goods_remark'] ?$goodsData['goods_remark']:$goodsData['goods_name'],
                    'category_list'=>$goodsType['type_name'],
                    'image_list'=>unserialize($goodsData['goods_slide']),
                    'src_wxapp_path'=>'kundian_farm/pages/shop/prodeteils/index?goodsid='.$goodsData['id'],
                    'sku_list'=>$sku_info
                ]

            ]
        ];
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $url='https://api.weixin.qq.com/mall/importproduct?access_token='.$access_token;
        $result=$this->https_curl_json($url,$shoppingData,'json');
        $result=json_decode($result);
        return $result;
    }


    /**
     * 删除购物清单中的商品信息
     * @param $goodsData    商品信息
     * @param $specVal      商品规格信息
     * @return mixed
     */
    public function deleteShopping($goodsData,$specVal){
        global $_W;
        $sku_id=$goodsData['id'];
        if(!empty($specVal)){
            $sku_id=$specVal['spec_num'] ? $specVal['spec_num'] : $goodsData['id'];
        }
        $shoppingData=[
            'user_open_id'=>$_W['openid'],
            'sku_product_list'=>[
                [
                    'item_code'=>$goodsData['id'],
                    'sku_id'=>$sku_id,
                ]
            ]
        ];
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $url='https://api.weixin.qq.com/mall/deleteshoppinglist?access_token='.$access_token;
        $result=$this->https_curl_json($url,$shoppingData,'json');
        return json_decode($result);
    }

    /** 加入订单*/
    public function addOrder($order_id,$trans_id){
        global $_W;
        $aboutData=pdo_get('cqkundian_farm_about',['uniacid'=>$this->uniacid]);
        $orderData=pdo_get('cqkundian_farm_shop_order',['id'=>$order_id,'uniacid'=>$this->uniacid]);
        $user=pdo_get('cqkundian_farm_user',['uid'=>$orderData['uid'],'uniacid'=>$this->uniacid]);
        $goodsDetail=pdo_getall('cqkundian_farm_shop_order_detail',['order_id'=>$orderData['id'],'uniacid'=>$this->uniacid]);
        $item_list=[];
        foreach ($goodsDetail as $key => $value ){
            $goodsData=pdo_get('cqkundian_farm_goods',['id'=>$value['goods_id']]);
            $goodsType=pdo_get('cqkundian_farm_goods_type',['id'=>$goodsData['type_id']]);
            if($value['spec']){
                $specVal=pdo_get('cqkundian_farm_goods_spec',['id'=>$value['spec_id']]);
            }

            $item_list[$key]=[
                'item_code'=>$goodsData['id'],
                'sku_id'=>$specVal['spec_num'] ? $specVal['spec_num'] : $goodsData['id'],
                'amount'=>$value['count'],
                'total_fee'=>$value['price'] *100 * $value['count'],
                'thumb_url'=>$specVal['spec_src'] ? $specVal['spec_src'] :$goodsData['cover'],
                'title'=>$goodsData['goods_name'],
                'unit_price'=>$specVal['price'] ? $specVal['price']*100 : $goodsData['price']*100,
                'original_price'=>$goodsData['old_price']*100,
                'category_list'=>$goodsType['type_name'],
                'item_detail_page'=> [
                        'path'=>'kundian_farm/pages/shop/prodeteils/index?goodsid='.$goodsData['id']
                    ],
            ];

        }

        $orderInfo=[
            'order_list'=>[
                [
                    'order_id'=>$orderData['order_number'],
                    'create_time'=>$orderData['create_time'],
                    'pay_finish_time'=>$orderData['pay_time'],
                    'desc'=>$orderData['body'],
                    'fee'=>$orderData['total_price']*100,
                    'trans_id'=>$trans_id,
                    'status'=>3,
                    'ext_info'=>[
                        'product_info'=>[
                            'item_list'=>$item_list
                        ],
                        'express_info'=>[
                            'name'=>$orderData['name'],
                            'phone'=>$orderData['phone'],
                            'address'=>$orderData['address'],
                            'price'=>$orderData['send_price']*100
                        ],
                        'brand_info'=>[
                            'phone'=>$aboutData['phone'],
                            'contact_detail_page'=>['path'=>'kundian_farm/pages/HomePage/index/index']
                        ],
                        'payment_method'=>1,
                        'user_open_id'=>$user['openid'],
                        'order_detail_page'=>['path'=>'kundian_farm/pages/shop/Group/orderDetails/index?order_id='.$orderData['id']],
                    ],

                ]
            ]
        ];


        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $url='https://api.weixin.qq.com/mall/importorder?action=add-order&access_token='.$access_token;
        $result=$this->https_curl_json($url,$orderInfo,'json');
        load()->func('logging');
        logging_run($orderInfo);
        return json_decode($result);
    }

    /** 更新订单状态信息 */
    public function updateOrder($order_id,$status){
        global $_W;
        $orderData=pdo_get('cqkundian_farm_shop_order',['id'=>$order_id,'uniacid'=>$this->uniacid]);
        $user=pdo_get('cqkundian_farm_user',['uid'=>$orderData['uid'],'uniacid'=>$this->uniacid]);
        $goodsDetail=pdo_getall('cqkundian_farm_shop_order_detail',['order_id'=>$orderData['id'],'uniacid'=>$this->uniacid]);
        $item_list=[];
        foreach ($goodsDetail as $key => $value ){
            $goodsData=pdo_get('cqkundian_farm_goods',['id'=>$value['goods_id']]);
            if($value['spec']){
                $specVal=pdo_get('cqkundian_farm_goods_spec',['id'=>$value['spec_id']]);
            }
            $item_list[$key]=[
                'item_code'=>$goodsData['id'],
                'sku_id'=>$specVal['spec_num'] ? $specVal['spec_num'] : $goodsData['id'],
            ];

        }

        $orderInfo=[
            'order_list'=>[
                [
                    'order_id'=>$orderData['order_number'],
                    'trans_id'=>$orderData['trans_id'],
                    'status'=>$status,

                    'ext_info'=>[
                        'express_info'=>[
                            'name'=>$orderData['name'],
                            'phone'=>$orderData['phone'],
                            'address'=>$orderData['address'],
                            'price'=>$orderData['send_price']*100,
                            'express_package_info_list'=>[
                                [
                                    'express_company_id'=>$this->checkExpressCompany($orderData['express_company']),
                                    'express_company_name'=>$orderData['express_company'],
                                    'express_code'=>$orderData['send_number'],
                                    'ship_time'=>$orderData['send_time'],
                                    'express_page'=>[
                                        'path'=>'kundian_farm/pages/shop/Group/orderDetails/index?order_id='.$orderData['id']
                                    ],
                                    'express_goods_info_list'=>$item_list
                                ],
                            ],
                        ],
                        'user_open_id'=>$user['openid'],
                        'order_detail_page'=>['path'=>'kundian_farm/pages/shop/Group/orderDetails/index?order_id='.$orderData['id']],
                     ]
                ]
            ]
        ];

        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $url='https://api.weixin.qq.com/mall/importorder?action=update-order&access_token='.$access_token;
        $result=$this->https_curl_json($url,$orderInfo,'json');
        return json_decode($result);
    }


    /** 删除订单信息*/
    public function deleteOrder($order_id){
        global $_W;
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $url='https://api.weixin.qq.com/mall/deleteorder?access_token='.$access_token;
        $keyList=[
            'user_open_id'=>$_W['openid'],
            'order_id'=>$order_id
        ];
        $result=$this->https_curl_json($url,$keyList,'json');
        return json_decode($result);
    }

    public function https_curl_json($url,$data,$type){

        if($type=='json'){
            $headers = ["Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache"];
            $data=json_encode($data,JSON_UNESCAPED_UNICODE ); //JSON_UNESCAPED_UNICODE 解决转json时中文变成了unicode
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)){

            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS,$data);

        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
        $output = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }

        curl_close($curl);
        return $output;
    }

    public function checkExpressCompany($express_company_name){
        switch ($express_company_name){
            case 'EMS':return '2000';break;
            case '圆通':return '2001';break;
            case 'DHL':return '2002';break;
            case '中通':return '2004';break;
            case '韵达':return '2005';break;
            case '畅灵':return '2006';break;
            case '百世汇通':return '2008';break;
            case '德邦':return '2009';break;
            case '申通':return '2010';break;
            case '顺丰速运':return '2011';break;
            case '顺兴':return '2012';break;
            case '如风达':return '2014';break;
            case '优速':return '2015';break;
            default:return '9999';break;
        }
    }

}

