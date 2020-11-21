<?php
class AppError
{
	static public $OK = 0;
	static public $SystemError = -1;
	static public $ParamsError = -2;
	static public $UserNotLogin = -3;
	static public $VerifyFailed = -10;
	static public $PluginNotFound = -9;
	static public $RequestError = -6;
	static public $VerifyCodeError = 90000;
	static public $VerifyCodeTimeOut = 90001;
	static public $SMSTplidNull = 91000;
	static public $SMSRateError = 91001;
	static public $BindSelfBinded = 92000;
	static public $BindWillRelieve = 92001;
	static public $BindWillMerge = 92002;
	static public $BindError = 92003;
	static public $BindNotOpen = 92004;
	static public $BindConfirm = 92005;
	static public $UploadNoFile = 101000;
	static public $UploadFail = 101001;
	static public $UserLoginFail = 10000;
	static public $UserTokenFail = 10001;
	static public $UserMobileExists = 10002;
	static public $UserNotFound = 10003;
	static public $UserIsBlack = 10004;
	static public $UserNotBindMobile = 10010;
	static public $GoodsNotFound = 20000;
	static public $GoodsNotChecked = 20001;
	static public $NotAddCart = 20002;
	static public $NotInCart = 20003;
	static public $AddressNotFound = 30000;
	static public $WithdrawNotOpen = 30101;
	static public $WithdrawError = 30102;
	static public $WithdrawBig = 30103;
	static public $WithdrawNotType = 30104;
	static public $WithdrawRealName = 30105;
	static public $WithdrawAlipay = 30106;
	static public $WithdrawAlipay1 = 30107;
	static public $WithdrawDiffAlipay = 30108;
	static public $WithdrawBank = 30109;
	static public $WithdrawBankCard = 30110;
	static public $WithdrawBankCard1 = 30111;
	static public $WithdrawDiffBankCard = 30112;
	static public $WxPayNotOpen = 40000;
	static public $WxPayParamsError = 40001;
	static public $OrderNotFound = 50000;
	static public $OrderNoExpress = 50001;
	static public $OrderCannotCancel = 50002;
	static public $OrderCannotFinish = 50003;
	static public $OrderCannotRestore = 50004;
	static public $OrderCannotDelete = 50005;
	static public $OrderCreateNoGoods = 50006;
	static public $OrderCreateMinBuyLimit = 50007;
	static public $OrderCreateOneBuyLimit = 50008;
	static public $OrderCreateMaxBuyLimit = 50009;
	static public $OrderCreateTimeNotStart = 50010;
	static public $OrderCreateTimeEnd = 50011;
	static public $OrderCreateMemberLevelLimit = 50012;
	static public $OrderCreateMemberGroupLimit = 50013;
	static public $OrderCreateStockError = 50014;
	static public $OrderCannotPay = 50015;
	static public $OrderPayNoPayType = 50016;
	static public $OrderPayFail = 50017;
	static public $OrderAlreadyPay = 50018;
	static public $OrderCanNotResubmit = 50019;
	static public $OrderCanNotRefund = 51000;
	static public $OrderCanNotComment = 51001;
	static public $OrderCreateTaskGoodsCart = 50202;
	static public $OrderCreateNoDispatch = 50203;
	static public $OrderCreateFalse = 50204;
	static public $OrderCreateNoPackage = 50205;
	static public $OrderCreatePackageTimeNotStart = 50206;
	static public $OrderCreatePackageTimeEnd = 50207;
	static public $MemberRechargeError = 60000;
	static public $CouponNotFound = 61000;
	static public $CouponCanNotBuy = 61001;
	static public $CouponRecordNotFound = 61002;
	static public $CouponBuyError = 61003;
	static public $CommissionReg = 70000;
	static public $CommissionNoUserInfo = 70001;
	static public $CommissionNotShortTimeSubmit = 70002;
	static public $CommissionIsAgent = 70003;
	static public $CommissionQrcodeNoOpen = 70004;
	static public $CommissionPosterNotFound = 70005;
	static public $PosterCreateFail = 70006;
	static public $PageNotFound = 80000;
	static public $MenuNotFound = 80001;
	static public $PermError = 81000;
	static public $ManageNotOpen = 81001;
	static public $RefundFail = 81002;
	static public $PluginNotOpen = 81003;
	static public $OrderNndone = 82001;
	static public $RecordNotFound = 82002;
	static public $logNotFound = 82003;
	static public $NoExchangeAuthority = 82004;
	static public $ExchangeRecordNotFound = 82005;
	static public $RecordUsed = 82006;
	static public $BeyondUsefulLife = 82007;
	static public $NonsupportOfflineConversion = 82008;
	static public $Losing_Lottery = 82009;
	static public $NonPayment = 82010;
	static public $NonPaymentFreight = 82011;
	static public $Expire = 82012;
	static public $GoodsSoldOut = 82013;
	static public $BrowseAuthority = 82014;
	static public $GoodsOptionNotFound = 82015;
	static public $PacketGet = 82016;
	static public $PacketDissatisfyCondition = 82017;
	static public $MoneyInsufficient = 82018;
	static public $PacketError = 82019;
	static public $OrderNotTake = 82020;
	static public $CanBuy = 82021;
	static public $NotFoundAddress = 82022;
	static public $NotOpenWPay = 82023;
	static public $AuthEnticationFail = 82024;
	static public $CommissionIsNotAgent = 82025;
	static public $DividendAgent = 82026;
	static public $CardNotFund = 82030;
	static public $CardisStop = 82031;
	static public $CardisDel = 82032;
	static public $CardisOverTime = 82040;
	static public $NotGetCard = 82041;
	static public $WxAppError = 9900001;
	static public $WxAppLoginError = 9900002;
	static public $errCode = array(0 => '处理成功', -1 => '系统内部错误', -2 => '参数错误', -3 => '未登录', -9 => '插件未找到', -6 => '错误的请求', 90000 => '验证码错误', 90001 => '验证码失效', 10000 => '登录失败', 10001 => '登录失效', 10002 => '手机号已存在', 10003 => '用户不存在', 10004 => '用户是黑名单', 10010 => '用户未绑定手机号', 20000 => '商品不存在', 20001 => '商品不存在(1)', 20002 => '不能加入购物车', 20003 => '无购物车记录', 30000 => '地址未找到', 30101 => '系统未开启提现', 30102 => '提现金额错误', 30103 => '提现金额过大', 30104 => '未选择提现方式', 30105 => '请填写姓名', 30106 => '请填写支付宝帐号', 30107 => '请填写确认帐号', 30108 => '支付宝帐号与确认帐号不一致', 30109 => '请选择银行', 30110 => '请填写银行卡号', 30111 => '请填写确认卡号', 30112 => '银行卡号与确认卡号不一致', 40000 => '微信支付未开启', 40001 => '微信支付参数错误', 80000 => '页面不存在', 80001 => '菜单不存在', 81000 => '无权限操作', 81001 => '未开启管理端', 81002 => '退款失败', 81003 => '插件未开启', 91000 => '短信发送失败(SMSidNull)', 91001 => '60秒内只能发送一次', 92000 => '此手机号已与当前账号绑定', 92001 => '此手机号已与其他帐号绑定, 如果继续将会解绑之前帐号', 92002 => '此手机号已通过其他方式注册, 如果继续将会合并账号信息', 92003 => '绑定失败', 92004 => '未开启绑定', 92005 => '绑定确认', 101000 => '未选择文件', 101001 => '上传失败', 50000 => '订单未找到', 50001 => '无物流信息', 50002 => '订单无法取消', 50003 => '订单无法收货', 50004 => '订单无法恢复', 50005 => '订单无法删除', 50006 => '商品出错', 50007 => '最低购买限制', 50008 => '一次最多购买限制', 50009 => '最多购买限制', 50010 => '限时购时间未开始', 50011 => '限时购时间已结束', 50012 => '会员等级限制', 50013 => '会员组限制', 50014 => '库存不足', 50015 => '订单不能支付', 50016 => '没有合适的支付方式', 50017 => '支付出错', 50018 => '订单已经支付', 50019 => '请不要重复提交', 51000 => '订单不能申请退款', 51001 => '订单不能评论', 50201 => '任务活动优惠最多购买限制', 50202 => '任务活动优惠商品不能放入购物车下单', 50203 => '不配送区域', 50204 => '下单失败', 50205 => '未找到套餐', 50206 => '套餐未开始', 50207 => '套餐已结束', 61000 => '优惠券不存在', 61001 => '无法从领券中心领取', 61002 => '未找到优惠券领取记录', 61003 => '优惠券领取失败', 70000 => '跳转到注册页面', 70001 => '需要您完善资料才能继续操作', 70002 => '不要短时间重复下提交', 70003 => '您已经是分销商了', 70004 => '没有开启推广二维码!', 70005 => '未找到分销海报!', 70006 => '海报生成失败', 82024 => '身份验证失败', 82025 => '您还不是分销商', 82026 => '您已经是团长', 82030 => '会员卡不存在', 82031 => '已经停止发卡', 82032 => '会员卡已经被删除', 82040 => '购买的会员卡已过期', 82041 => '还未开通会员卡');

	static public function getError($errcode = 0)
	{
		return isset(self::$errCode[$errcode]) ? self::$errCode[$errcode] : '';
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
