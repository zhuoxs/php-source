<?php

class moguapiModel

{
    public function MakeSign($params,$signkey)
    {
        $string = '';
        //签名步骤一：按字典序排序参数
        ksort($params);
        foreach ($params as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $string .= $k.$v;
            }
        }
        $string = trim($string, "&");
        //签名步骤二：在string后加入KEY
        $string = $signkey.$string.$signkey;
        //签名步骤三：MD5加密或者HMAC-SHA256
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
    /*
     *蘑菇街优惠券商品查询api，传入顺序，接口名，token，appkey，appsecre，api参数
     */
    function moguapi_goodslist($access_token,$app_key,$AppSecret,$promInfoQuery)
    {
        $method = 'xiaodian.cpsdata.promitem.get';
        //$access_token = '8732B4BB3A5B9B47976F2E794898F455';
        //$app_key = '101007';
        //$AppSecret = '90E90367B2E63C43FD05E6273E2B5A51';
        $timestamp = time();
        $format = 'json';
        $sign_method = 'md5';
        //$promInfoQuery = '{"hasCoupon":true,"pageSize":10}';
        $signold = $AppSecret.'access_token'.$access_token.'app_key'.$app_key.'format'.$format.'method'.$method.'promInfoQuery'.$promInfoQuery.'sign_method'.$sign_method.'timestamp'.$timestamp.$AppSecret;
        $sign = md5($signold);
        $sign = strtoupper($sign);
        $data = array (
            'access_token' =>$access_token,
            'app_key' => urlencode($app_key),
            'format' => urlencode($format),
            'method' => urlencode($method),
            'promInfoQuery' => $promInfoQuery,
            'sign_method' => urlencode($sign_method),
            'timestamp' => urlencode($timestamp),
            'sign' =>$sign
        );

        $url = 'https://openapi.mogujie.com/invoke';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        return $result['result']['data']['items'];
     }

     /*
     *蘑菇街商品详情api，传入顺序，接口名，token，appkey，appsecre，api参数
     */
    function moguapi_goodsdetail($access_token,$app_key,$AppSecret,$urlurl)
    {
        $method = 'xiaodian.cpsdata.item.get';
        //$access_token = '65A3908DAE59951ED28D359B62F2DD11';
        //$app_key = '101007';
        //$AppSecret = '90E90367B2E63C43FD05E6273E2B5A51';
        $timestamp = time();
        $format = 'json';
        $sign_method = 'md5';
        //$urlurl = "https://shop.mogujie.com/detail/1k1rot0";
        $signold = $AppSecret.'access_token'.$access_token.'app_key'.$app_key.'format'.$format.'method'.$method.'sign_method'.$sign_method.'timestamp'.$timestamp.'url'.$urlurl.$AppSecret;
        $sign = md5($signold);
        $sign = strtoupper($sign);
        $data = array (
            'access_token' =>$access_token,
            'app_key' => urlencode($app_key),
            'format' => urlencode($format),
            'method' => urlencode($method),
            'url' => $urlurl,
            'sign_method' => urlencode($sign_method),
            'timestamp' => urlencode($timestamp),
            'sign' =>$sign
        );

        $url = 'https://openapi.mogujie.com/invoke';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        return $result['result']['data'];
     }

     /*
     *蘑菇街生成小程序path，传入顺序，接口名，token，appkey，appsecre，api参数
     */
    function moguapi_getpath($access_token,$app_key,$AppSecret,$wxcodeParam)
    {
        $method = 'xiaodian.cpsdata.wxcode.get';
        $timestamp = time();
        $format = 'json';
        $sign_method = 'md5';
        $signold = $AppSecret.'access_token'.$access_token.'app_key'.$app_key.'format'.$format.'method'.$method.'sign_method'.$sign_method.'timestamp'.$timestamp.'wxcodeParam'.$wxcodeParam.$AppSecret;
        $sign = md5($signold);
        $sign = strtoupper($sign);
        $data = array (
            'access_token' =>$access_token,
            'app_key' => urlencode($app_key),
            'format' => urlencode($format),
            'method' => urlencode($method),
            'wxcodeParam' => $wxcodeParam,
            'sign_method' => urlencode($sign_method),
            'timestamp' => urlencode($timestamp),
            'sign' =>$sign
        );

        $url = 'https://openapi.mogujie.com/invoke';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        return $result['result']['data']['path'];
     }

     /*
     *创建蘑菇街渠道id
     */
    function moguapi_getgid($access_token,$app_key,$AppSecret,$CpsChannelGroupParam)
    {
        $method = 'xiaodian.cpsdata.channelgroup.save';
        //$access_token = 'C245D6D399DF176E24C7EF1F125042D3';
        //$app_key = '101007';
        //$AppSecret = '90E90367B2E63C43FD05E6273E2B5A51';
        $timestamp = time();
        $format = 'json';
        $sign_method = 'md5';
        //$CpsChannelGroupParam = json_encode(array('name'=>'1111'));
        $data = array (
            'access_token' =>$access_token,
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'CpsChannelGroupParam' => $CpsChannelGroupParam,//$CpsChannelGroupParam,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://openapi.mogujie.com/invoke';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        return $result['result']['data'];
     }

     /*
     *获取蘑菇街订单
     */
    function moguapi_getorders($access_token,$app_key,$AppSecret,$orderInfoQuery)
    {
        $method = 'xiaodian.cpsdata.order.list.get';
        //$access_token = 'C245D6D399DF176E24C7EF1F125042D3';
        //$app_key = '101007';
        //$AppSecret = '90E90367B2E63C43FD05E6273E2B5A51';
        $timestamp = time();
        $format = 'json';
        $sign_method = 'md5';
        //$orderInfoQuery = json_encode(array('start'=>'20181225','end'=>'20181229','page'=>1,'pagesize'=>3));
        $data = array (
            'access_token' =>$access_token,
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'orderInfoQuery' => $orderInfoQuery,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://openapi.mogujie.com/invoke';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        //var_dump($result['result']['data']['orders']);
        return $result['result']['data']['orders'];
     }

    //查询京东客商品列表 临时测试
    function jdapi_goodslist($param_json)
    {
        $method = 'jd.union.open.goods.query';
        $app_key = 'ae9a8da1b63431ccad996309c75c3964';
        $AppSecret = '2261a6c6174a4a32bc00decf7c71cd70';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'goodsReqDTO'=>
                array('keyword' => '女装',
                      'pageSize' => 20,
                      'pageIndex' => 1
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_goods_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];
        //return $result;
    }
    //查询京东客商品列表 会创科技
    function jdapi_goodslist2($param_json)
    {
        $method = 'jd.union.open.goods.query';
        $app_key = '3e1dab81d6a7fff6bf9ea03a010a0cc9';
        $AppSecret = '853010a758434c15aaa575561cf3fefa';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'goodsReqDTO'=>
                array('keyword' => '女装',
                      'pageSize' => 20,
                      'pageIndex' => 1
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_goods_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];
        //return $result;
    }
    //查询京东客商品列表 会创科技备用
    function jdapi_goodslist3($param_json)
    {
        $method = 'jd.union.open.goods.query';
        $app_key = '44b2aa9980619d76a5d461e873932401';
        $AppSecret = 'e85ea760480b444ca3520f7b238fa8fe';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'goodsReqDTO'=>
                array('keyword' => '女装',
                      'pageSize' => 20,
                      'pageIndex' => 1
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_goods_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];
        //return $result;
    }
    //查询京东客商品列表 会创科技备用
    function jdapi_goodslist5($param_json)
    {
        $method = 'jd.union.open.goods.query';
        $app_key = '55c5f970d6aacd026b5ef307b70e4eda';
        $AppSecret = 'e34e8ae72d0841809fa084c9fbdf964d';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'goodsReqDTO'=>
                array('keyword' => '女装',
                      'pageSize' => 20,
                      'pageIndex' => 1
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_goods_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];
        //return $result;
    }
    //查询京东客商品列表 会创科技备用
    function jdapi_goodslist6($param_json)
    {
        $method = 'jd.union.open.goods.query';
        $app_key = 'b252b7cadab8132837d8a643d4419231';
        $AppSecret = '55c964d711eb4964ba030f9f690ad74f';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'goodsReqDTO'=>
                array('keyword' => '女装',
                      'pageSize' => 20,
                      'pageIndex' => 1
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_goods_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];
        //return $result;
    }
    //查询京东客商品列表 会创科技备用
    function jdapi_goodslist7($param_json)
    {
        $method = 'jd.union.open.goods.query';
        $app_key = '28254a74a9e9d914bc204135c1840a34';
        $AppSecret = 'e0f67de4595b428d9ea34b98d6d9002d';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'goodsReqDTO'=>
                array('keyword' => '女装',
                      'pageSize' => 20,
                      'pageIndex' => 1
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_goods_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];
        //return $result;
    }
    //查询京东客商品列表 会创科技备用
    function jdapi_goodslist8($param_json)
    {
        $method = 'jd.union.open.goods.query';
        $app_key = '5674d2a7b65b6ba5df234e8e658f28b5';
        $AppSecret = '4aa868e304fd41469cf56ca2981b1fd1';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'goodsReqDTO'=>
                array('keyword' => '女装',
                      'pageSize' => 20,
                      'pageIndex' => 1
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_goods_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];
        //return $result;
    }
    //查询京东客商品列表 会创科技备用
    function jdapi_goodslist9($param_json)
    {
        $method = 'jd.union.open.goods.query';
        $app_key = '2009f57cb4604c18e0b755caa7e655d0';
        $AppSecret = 'eb3b2e1a29664010ac9357f0748917af';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'goodsReqDTO'=>
                array('keyword' => '女装',
                      'pageSize' => 20,
                      'pageIndex' => 1
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_goods_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];
        //return $result;
    }
    //查询京东客商品列表 会创科技备用
    function jdapi_goodslist10($param_json)
    {
        $method = 'jd.union.open.goods.query';
        $app_key = '9b2fedcf1e133a6b26b1f8bfe85fd40d';
        $AppSecret = '693bf098f46d4290ac5bdbb11b79f477';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'goodsReqDTO'=>
                array('keyword' => '女装',
                      'pageSize' => 20,
                      'pageIndex' => 1
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_goods_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];
        //return $result;
    }
    //京东优惠券信息
    function jdapi_couponinfo($couponUrls){

        $method = 'jd.union.open.coupon.query';
        $app_key = 'ae9a8da1b63431ccad996309c75c3964';
        $AppSecret = '2261a6c6174a4a32bc00decf7c71cd70';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        $param_json = json_encode(
            array(
                'couponUrls'=> array($couponUrls)
                )
            );
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_coupon_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];

    }
    //京东优惠券信息
    function jdapi_couponinfo2($couponUrls){

        $method = 'jd.union.open.coupon.query';
        $app_key = '3e1dab81d6a7fff6bf9ea03a010a0cc9';
        $AppSecret = '853010a758434c15aaa575561cf3fefa';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        $param_json = json_encode(
            array(
                'couponUrls'=> array($couponUrls)
                )
            );
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_coupon_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];

    }
    //京东优惠券信息
    function jdapi_couponinfo3($couponUrls){

        $method = 'jd.union.open.coupon.query';
        $app_key = '44b2aa9980619d76a5d461e873932401';
        $AppSecret = 'e85ea760480b444ca3520f7b238fa8fe';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        $param_json = json_encode(
            array(
                'couponUrls'=> array($couponUrls)
                )
            );
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_coupon_query_response']['result'],true);
        //var_dump($res['data']);
        return $res['data'];

    }

    //获取京东优惠券链接
    function jdapi_getpath($param_json){

        $method = 'jd.union.open.promotion.byunionid.get';
        $app_key = 'ae9a8da1b63431ccad996309c75c3964';
        $AppSecret = '2261a6c6174a4a32bc00decf7c71cd70';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'promotionCodeReq'=>
                array('materialId' => 'item.jd.com/35222761609.html',
                    'unionId' => '1001312562',
                    'couponUrl' => 'http://coupon.jd.com/ilink/couponActiveFront/front_index.action?key=f1c2abbb676f45058bf809bafdb3e85f&roleId=17162390&to=mall.jd.com/index-861986.html'
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_promotion_byunionid_get_response']['result'],true);
        //var_dump($res['data']);
        return $res['data']['shortURL'];

    }
    //获取京东优惠券链接
    function jdapi_getpath2($param_json){

        $method = 'jd.union.open.promotion.byunionid.get';
        $app_key = '44b2aa9980619d76a5d461e873932401';
        $AppSecret = 'e85ea760480b444ca3520f7b238fa8fe';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'promotionCodeReq'=>
                array('materialId' => 'item.jd.com/35222761609.html',
                    'unionId' => '1001312562',
                    'couponUrl' => 'http://coupon.jd.com/ilink/couponActiveFront/front_index.action?key=f1c2abbb676f45058bf809bafdb3e85f&roleId=17162390&to=mall.jd.com/index-861986.html'
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_promotion_byunionid_get_response']['result'],true);
        //var_dump($res['data']);
        return $res['data']['shortURL'];

    }
    //获取京东优惠券链接
    function jdapi_getpath3($param_json){

        $method = 'jd.union.open.promotion.byunionid.get';
        $app_key = '3e1dab81d6a7fff6bf9ea03a010a0cc9';
        $AppSecret = '853010a758434c15aaa575561cf3fefa';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        /*$param_json = json_encode(
            array(
                'promotionCodeReq'=>
                array('materialId' => 'item.jd.com/35222761609.html',
                    'unionId' => '1001312562',
                    'couponUrl' => 'http://coupon.jd.com/ilink/couponActiveFront/front_index.action?key=f1c2abbb676f45058bf809bafdb3e85f&roleId=17162390&to=mall.jd.com/index-861986.html'
                      )
                )
            );*/
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_promotion_byunionid_get_response']['result'],true);
        //var_dump($res['data']);
        return $res['data']['shortURL'];

    }
    //京东推广位
    public function jdapi_getpid($spaceNameList,$param_json){

        $method = 'jd.union.open.position.create';
        $app_key = 'ae9a8da1b63431ccad996309c75c3964';
        $AppSecret = '2261a6c6174a4a32bc00decf7c71cd70';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        //$spaceNameList = '444';
        /*$param_json = json_encode(
            array(
                'positionReq'=>
                array('unionId' => '1001312562',
                      'key' => 'ece3b6ab1c8b87a7875a0e359194bc08e0566b1152670a70bafb64c3a0e11618acc9e8012272d40d',
                      'unionType' => 1,
                      'type' => 3,
                      'spaceNameList' => array($spaceNameList),
                      'siteId' => '38513'
                      )
                )
            );*/
        
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_position_create_response']['result'],true);
        
        //var_dump($res['data']['resultList'][$spaceNameList]);
        return $res['data']['resultList'][$spaceNameList];

    }
    //京东推广位
    public function jdapi_getpid2($spaceNameList,$param_json){

        $method = 'jd.union.open.position.create';
        $app_key = '3e1dab81d6a7fff6bf9ea03a010a0cc9';
        $AppSecret = '853010a758434c15aaa575561cf3fefa';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        //$spaceNameList = '444';
        /*$param_json = json_encode(
            array(
                'positionReq'=>
                array('unionId' => '1001312562',
                      'key' => 'ece3b6ab1c8b87a7875a0e359194bc08e0566b1152670a70bafb64c3a0e11618acc9e8012272d40d',
                      'unionType' => 1,
                      'type' => 3,
                      'spaceNameList' => array($spaceNameList),
                      'siteId' => '38513'
                      )
                )
            );*/
        
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_position_create_response']['result'],true);
        
        //var_dump($res['data']['resultList'][$spaceNameList]);
        return $res['data']['resultList'][$spaceNameList];

    }
    //京东推广位
    public function jdapi_getpid3($spaceNameList,$param_json){

        $method = 'jd.union.open.position.create';
        $app_key = '44b2aa9980619d76a5d461e873932401';
        $AppSecret = 'e85ea760480b444ca3520f7b238fa8fe';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        //$spaceNameList = '444';
        /*$param_json = json_encode(
            array(
                'positionReq'=>
                array('unionId' => '1001312562',
                      'key' => 'ece3b6ab1c8b87a7875a0e359194bc08e0566b1152670a70bafb64c3a0e11618acc9e8012272d40d',
                      'unionType' => 1,
                      'type' => 3,
                      'spaceNameList' => array($spaceNameList),
                      'siteId' => '38513'
                      )
                )
            );*/
        
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);

        $res = json_decode($result['jd_union_open_position_create_response']['result'],true);
        
        //var_dump($res['data']['resultList'][$spaceNameList]);
        return $res['data']['resultList'][$spaceNameList];

    }
    //获取京东订单
    function jdapi_getorders($time,$key){

        $method = 'jd.union.open.order.query';
        $app_key = 'ae9a8da1b63431ccad996309c75c3964';
        $AppSecret = '2261a6c6174a4a32bc00decf7c71cd70';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        $param_json = json_encode(
            array(
                'orderReq'=>
                array('pageNo' => 1,
                      'pageSize' => 20,
                      'type' => 3,
                      'time' => $time,
                      'key' => $key
                      )
                )
            );
        
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);
        $res = json_decode($result['jd_union_open_order_query_response']['result'],true);
        
//        var_dump($res['data']);
        return $res['data'];

    }
    //获取京东订单
    function jdapi_getorders2($time,$key){

        $method = 'jd.union.open.order.query';
        $app_key = '44b2aa9980619d76a5d461e873932401';
        $AppSecret = 'e85ea760480b444ca3520f7b238fa8fe';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        $param_json = json_encode(
            array(
                'orderReq'=>
                array('pageNo' => 1,
                      'pageSize' => 20,
                      'type' => 3,
                      'time' => $time,
                      'key' => $key
                      )
                )
            );
        
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);
        $res = json_decode($result['jd_union_open_order_query_response']['result'],true);
        
        //var_dump($res['data']);
        return $res['data'];

    }
    //获取京东订单
    function jdapi_getorders3($time,$key){

        $method = 'jd.union.open.order.query';
        $app_key = '3e1dab81d6a7fff6bf9ea03a010a0cc9';
        $AppSecret = '853010a758434c15aaa575561cf3fefa';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        $param_json = json_encode(
            array(
                'orderReq'=>
                array('pageNo' => 1,
                      'pageSize' => 20,
                      'type' => 3,
                      'time' => $time,
                      'key' => $key
                      )
                )
            );
        
        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);
        $res = json_decode($result['jd_union_open_order_query_response']['result'],true);
        
        //var_dump($res['data']);
        return $res['data'];

    }
    function jdapi_getcatelist($parentId,$grade){

        $method = 'jd.union.open.category.goods.get';
        $app_key = '3e1dab81d6a7fff6bf9ea03a010a0cc9';
        $AppSecret = '853010a758434c15aaa575561cf3fefa';
        $timestamp = date('Y-m-d H:i:s',time());
        $format = 'json';
        $v = '1.0';
        $sign_method = 'md5';
        $param_json = json_encode(
            array(
                'req'=>
                    array('parentId' => $parentId,
                        'grade' => $grade
                    )
            )
        );

        $data = array(
            'app_key' => $app_key,
            'format' => $format,
            'method' => $method,
            'param_json' => $param_json,
            'sign_method' => $sign_method,
            'timestamp' => $timestamp,
            'v' =>$v
        );
        $data['sign'] = $this->MakeSign($data, $AppSecret);
        $url = 'https://router.jd.com/api';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $result  = json_decode($response['content'],true);
        print_r($result);

        $res = $result['jd_union_open_order_query_response']['result'];
        print_r($res);die;

        return $res['data'];

    }

}