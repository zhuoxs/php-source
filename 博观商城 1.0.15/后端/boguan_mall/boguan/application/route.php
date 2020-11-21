<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\route;
//公众号
Route::put('wechat/oauth','wechat/Oauth/getOauth');
Route::post('api/:version/test','api/:version.Test/test');


//手机管理端
//首页
Route::get('api/:version/mobile/index','api/:version.Mobile/getIndexData');
Route::get('api/:version/mobile/order','api/:version.Mobile/getOrderList');
Route::get('api/:version/mobile/order_search','api/:version.Mobile/searchOrder');
Route::post('api/:version/mobile/delivery','api/:version.Mobile/delivery');
Route::get('api/:version/mobile/refund','api/:version.Mobile/orderRefundList');
Route::post('api/:version/mobile/refund_detail','api/:version.Mobile/orderRefundDetail');
Route::get('api/:version/mobile/refuse_refund','api/:version.Mobile/refuseRefundApply');
Route::get('api/:version/mobile/agree_refund','api/:version.Mobile/agreeRefundApply');
Route::get('api/:version/mobile/pay_refund','api/:version.Mobile/PayRefund');


//会员
Route::get('api/:version/vip/info','api/:version.Vip/getVipInfo');

//积分
Route::get('api/:version/integral/detail','api/:version.Integral/getDetail');


//自提点
//自提地址列表
Route::post('api/:version/pickpoint/list','api/:version.PickPoint/pickPointList');
//自提时间段
Route::post('api/:version/pickpoint/time','api/:version.PickPoint/pickPointTime');
//提货城市搜索
Route::get('api/:version/pickcity/search','api/:version.PickCity/pickCitySearch');
//提货城市列表
Route::get('api/:version/pickcity/list','api/:version.PickCity/pickCityList');


//配送
//送达时间
Route::post('api/:version/delivery/time','api/:version.Delivery/deliveryTime');
//判断用户是否在配送范围内,配送费
Route::post('api/:version/delivery/area','api/:version.Delivery/isInDeliveryArea');


//分销
Route::post('api/:version/share/submit','api/:version.Share/shareSubmit');
//分销团队
Route::get('api/:version/share/team','api/:version.Share/shareTeam');
//分销订单
Route::get('api/:version/share/order','api/:version.Share/shareOrder');
//分销中心数据
Route::get('api/:version/share/data','api/:version.Share/shareData');
//分销提现明细
Route::get('api/:version/share/withdraw','api/:version.Share/shareWithdraw');
//推广海报
Route::get('api/:version/share/poster','api/:version.Share/sharePoster');
//提现
Route::post('api/:version/withdraw/submit','api/:version.Withdraw/withdrawSubmit');
//绑定父级id
Route::get('api/:version/share/bind_parent','api/:version.Share/bindParent');

//通用接口
Route::post('api/:version/upload','api/:version.Base/WxUploadImage');
Route::post('api/:version/upload_images','api/:version.Base/WxUploadImages');
Route::post('api/:version/uploadDel','api/:version.Base/WxDelImage');
Route::post('api/:version/info','api/:version.Base/getPlatformInfo');
//搜索
Route::post('api/:version/common/search','api/:version.Common/search');

//物流信息
Route::post('api/:version/express','api/:version.Base/getExpress');

//diy页面接口
Route::post('api/:version/home/diy','api/:version.Home/getDiyPageData');
//底部菜单
Route::post('api/:version/home/bottom','api/:version.Home/getDiyBottomData');

//优惠券接口
Route::get('api/:version/coupon/get','api/:version.Coupon/getCouponCenter');
//领取优惠券
Route::post('api/:version/coupon/receive','api/:version.Coupon/receiveCoupon');
//获取优惠券详情
Route::get('api/:version/coupon/detail','api/:version.Coupon/getCouponDetail');
//获取用户优惠券详情
Route::get('api/:version/coupon/user_detail','api/:version.Coupon/getUserCouponDetail');
//获取优惠券指定的商品
Route::get('api/:version/coupon/product','api/:version.Coupon/getCouponProduct');

//产品接口
Route::get('api/:version/product/recent','api/:version.Product/getRecent');
Route::get('api/:version/product/by_category','api/:version.Product/getAllInCategory');
Route::get('api/:version/product/one','api/:version.Product/getOne');
//猜你喜欢接口
Route::post('api/:version/product/guess','api/:version.Product/getProductByUserGuess');
//产品收藏
Route::post('api/:version/product/collect','api/:version.Product/collectProduct');
//获取商品指定规格信息接口
Route::post('api/:version/product/attr_info','api/:version.Product/getProductAttrInfo');
//获取商品单价或规格下的单价，以及当前用户等级下的会员价
Route::post('api/:version/product/price','api/:version.Product/getProductPrice');
//获取商品的运费
Route::post('api/:version/product/freight','api/:version.Product/getFreightPrice');
//商品积分兑换
Route::post('api/:version/product/integral','api/:version.Product/getIntegralExchange');
//获取商品的分享图片
Route::get('api/:version/product/share_image','api/:version.Product/getProductShareImage');
//获取多个商品下可用的优惠券
Route::post('api/:version/product/coupon','api/:version.Product/getProductsCoupon');
//用户下单的商品是否支持当前所选的发货方式（1快递，2同城配送，3自提）从而判断是否可购买
Route::post('api/:version/product/check_buy','api/:version.Product/checkProductIsCanBuy');
//获取用户选择优惠券后，计算当前购买的商品中可优惠的价格
Route::post('api/:version/product/coupon_price','api/:version.Product/getCouponPriceInProduct');


//足迹
Route::get('api/:version/footprint/list','api/:version.Footprint/getFootprint');
Route::get('api/:version/footprint/del','api/:version.Footprint/delFootprint');

//购物车接口
//获取用户购物车
Route::get('api/:version/cart/get','api/:version.Cart/getCart');
//商品添加到购物车
Route::post('api/:version/cart/add','api/:version.Cart/ProductAddCart');
//修改购物车（加减）
Route::post('api/:version/cart/edit','api/:version.Cart/editCart');
//删除用户购物车商品
Route::post('api/:version/cart/del','api/:version.Cart/delCart');
//购物车选中状态
Route::post('api/:version/cart/check','api/:version.Cart/checkCart');

//分类
Route::get('api/:version/category/all','api/:version.Category/getCategoryAll');
Route::get('api/:version/category/child','api/:version.Category/getCategoryChild');


//token
Route::post('api/:version/token/user','api/:version.Token/getToken');
Route::post('api/:version/token/verify','api/:version.Token/verifyToken');
Route::post('api/:version/token/app','api/:version.Token/getAppToken');

//用户
//更新用户信息
Route::post('api/:version/user/update','api/:version.User/updateUserInfo');
//获取用户信息
Route::post('api/:version/user/info','api/:version.User/getUserInfo');
//用户优惠券
Route::get('api/:version/user/coupon','api/:version.User/getUserCoupon');
//获取用户手机号码
Route::post('api/:version/user/phone','api/:version.Base/decodeUserPhone');
//用户收藏商品和文章列表
Route::post('api/:version/user/collect','api/:version.User/getCollectProductAndContent');
//代理金额查询
Route::get('api/:version/user/agent','api/:version.User/countAgentAmount');

//用户地址
//新增
Route::post('api/:version/address/add','api/:version.Address/addAddress');
//更新
Route::post('api/:version/address/edit','api/:version.Address/editAddress');
//删除
Route::post('api/:version/address/del','api/:version.Address/delAddress');
//获取所有
Route::get('api/:version/address/get','api/:version.Address/getUserAddress');
//设置默认地址
Route::post('api/:version/address/default','api/:version.Address/defaultAddress');
//获取用户默认地址
Route::get('api/:version/address/get_default','api/:version.Address/getDefaultAddress');
//地址详情
Route::get('api/:version/address/detail','api/:version.Address/getAddressDetail');



//内容文章
//获取内容列表接口
Route::get('api/:version/content/by_cate','api/:version.Content/getContentByCate');
//指定下级所有分类
Route::get('api/:version/content/cate','api/:version.Content/getChildCateById');
//详情
Route::get('api/:version/content/detail','api/:version.Content/getContentDetail');
//收藏
Route::post('api/:version/content/collect','api/:version.Content/collectContent');

//帮助中心
Route::get('api/:version/help/list','api/:version.Help/helpList');
Route::get('api/:version/help/detail','api/:version.Help/helpDetail');

//关于
Route::get('api/:version/about/detail','api/:version.About/aboutDetail');



//订单接口
//下订单
Route::post('api/:version/order/place','api/:version.Order/placeOrder');
//获取某一个订单详情
Route::post('api/:version/order/detail','api/:version.Order/getDetail');
//获取用户订单
Route::post('api/:version/order/by_user','api/:version.Order/getByUidAndKind');

Route::put('api/:version/order/delivery','api/:version.Order/delivery');
//搜索用户订单
Route::post('api/:version/order/search','api/:version.Order/searchOrder');
//取消订单
Route::post('api/:version/order/cancel','api/:version.Order/orderCancel');
//确认收货
Route::post('api/:version/order/confirm','api/:version.Order/orderConfirm');
//售后申请提交
Route::post('api/:version/order/refund_submit','api/:version.Order/orderRefundSubmit');
//售后订单详情
Route::post('api/:version/order/refund_detail','api/:version.Order/orderRefundDetail');
//用户发货信息提交
Route::post('api/:version/order/refund_confirm','api/:version.Order/orderRefundConfirm');
//用户自提订单核销详情
Route::post('api/:version/order/clerk_detail','api/:version.Order/clerkOrderDetail');

//核销员核销订单
Route::post('api/:version/order/clerk','api/:version.Order/clerkOrder');


//订单评价
//提交
Route::post('api/:version/comment/submit','api/:version.Comment/commentSubmit');
//列表
Route::post('api/:version/comment/list','api/:version.Comment/commentList');

//预支付接口
Route::post('api/:version/pay/pre_order','api/:version.Pay/getPreOrder');
//余额支付接口
Route::post('api/:version/pay/balance','api/:version.Pay/orderBalance');
//回调接口
Route::post('api/:version/notify','api/:version.Notify/receiveNotify');
//Route::post('api/:version/pay/re_notify','api/:version.Pay/redirectNotify');